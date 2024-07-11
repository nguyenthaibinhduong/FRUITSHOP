<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class PaymentController extends Controller
{
    protected $cart;
    protected $product;
    protected $cartProduct;
    protected $subtotal;
    public function __construct(Product $product, Cart $cart, CartProduct $cartProduct)
    {
        $this->product = $product;
        $this->cart = $cart;
        $this->cartProduct = $cartProduct;
        View::share('types', Type::all());
        View::share('categories', Category::all());
    }
    public function index($code)
    {
        $order = Order::where('order_code', $code)->first();
        return view('client.cart.payment', compact('order'));
    }
    // =================VNPAY payment========================

    public function vnpay_payment(Request $request)
    {
        $order = Order::find($request->order_id);

        $vnp_Url = env('VNP_URL'); // URL của VNPAY từ file .env
        $vnp_Returnurl = route('vnpay_return'); // URL trả về sau khi thanh toán
        $vnp_TmnCode = env('VNP_TMN_CODE'); // Mã website tại VNPAY từ file .env
        $vnp_HashSecret = env('VNP_HASH_SECRET'); // Chuỗi bí mật từ file .env


        $vnp_TxnRef = $order->order_code; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = 'Thanh toán đơn hàng ' . $order->order_code;
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $order->total_price * 100;
        $vnp_Locale = 'vn';
        $vnp_BankCode = 'NCB';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        //Add Params of 2.0.1 Version
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        //var_dump($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        $returnData = array(
            'code' => '00'
            ,
            'message' => 'success'
            ,
            'data' => $vnp_Url
        );
        if (isset($_POST['redirect'])) {
            header('Location: ' . $vnp_Url);
            die();
        } else {
            echo json_encode($returnData);
        }
    }
    public function vnpay_return(Request $request)
    {
        $vnp_HashSecret = env('VNP_HASH_SECRET'); // Chuỗi bí mật

        $vnp_SecureHash = $request->vnp_SecureHash;
        $inputData = $request->all();
        unset($inputData['vnp_SecureHash']);

        ksort($inputData);
        $hashData = "";
        foreach ($inputData as $key => $value) {
            $hashData .= urlencode($key) . "=" . urlencode($value) . '&';
        }
        $hashData = rtrim($hashData, '&');

        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        if ($secureHash == $vnp_SecureHash) {
            if ($request->vnp_ResponseCode == '00') {
                $order = Order::where('order_code', $request->vnp_TxnRef)->first();
                if ($order) {
                    $order->status = 3; // Đặt trạng thái đơn hàng thành công
                    $order->save();
                }
                return redirect()->route('orders.detail', ['id' => $order->id]);// Return success response or redirect
            } else {
                return 'Handle unsuccessful payment';
            }
        } else {
            return 'Handle invalid hash';
        }
    }

    // =================MOMO payment========================
    public function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            )
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        return $result;
    }
    public function momo_payment(Request $request)
    {
        $order = Order::find($request->order_id);
        // dd($order->total_price)
        $order_id = $order->id;
        $endpoint = env('MM_URL');

        $partnerCode = env('MM_PARTNERCODE');
        $accessKey = env('MM_ACCESSKEY');
        $secretKey = env('MM_SECRETKEY');
        $orderInfo = "Thanh toán qua MoMo";
        $amount = (int) $order->total_price;
        $orderId = time() . "";
        $redirectUrl = route('momo_return');
        $ipnUrl = "https://webhook.site/b3088a6a-2d17-4f8d-a383-71389a6c600b";
        $extraData = $order_id;

        $requestId = time() . "";
        $requestType = "payWithATM";
        // $extraData = ($_POST["extraData"] ? $_POST["extraData"] : "");
        //before sign HMAC SHA256 signature
        $rawHash =
            "accessKey=" . $accessKey
            . "&amount=" . $amount
            . "&extraData=" . $extraData
            . "&ipnUrl=" . $ipnUrl
            . "&orderId=" . $orderId
            . "&orderInfo=" . $orderInfo
            . "&partnerCode=" . $partnerCode
            . "&redirectUrl=" . $redirectUrl
            . "&requestId=" . $requestId
            . "&requestType=" . $requestType;


        $signature = hash_hmac("sha256", $rawHash, $secretKey);
        $data = array(
            'partnerCode' => $partnerCode,
            'partnerName' => "FRUITSHOP",
            "storeId" => "FRUITSHOP",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature,
            'raw' => $rawHash
        );
        $result = $this->execPostRequest($endpoint, json_encode($data));
        $jsonResult = json_decode($result, true);  // decode json

        //Just a example, please check more in there

        return redirect()->to($jsonResult['payUrl']);
        //return '<h1>Chưa thanh toán MOMO được </h1>';
    }
    public function momo_return(Request $request)
    {
        // Lấy extraData để tìm đơn hàng
        $extraData = $request->input('extraData');
        $order = Order::find($extraData);

        if (!$order) {
            // Xử lý nếu đơn hàng không tồn tại
            return redirect()->route('orders.detail', ['id' => $extraData])->with('error', 'Order not found.');
        }

        // Lấy các thông tin cần thiết từ request
        $partnerCode = $request->partnerCode;

        if ($partnerCode === env('MM_PARTNERCODE') && $request->resultCode == '0') {
            // Nếu chữ ký khớp, cập nhật trạng thái đơn hàng
            $order->status = 3;
            $order->save();

            return redirect()->route('orders.detail', ['id' => $extraData])->with('success', 'Payment successful and order status updated.');
        } else {
            // Nếu chữ ký không khớp
            return redirect()->route('orders.detail', ['id' => $extraData])->with('error', 'Invalid signature.');
        }
    }
}