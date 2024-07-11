<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\UserController;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

$controller = UserController::class;
Route::get('/login', [$controller, 'login'])->name('login');
Route::post('/login', [$controller, 'post_login']);
Route::get('/loginadmin', [$controller, 'loginadmin'])->name('loginadmin');
Route::post('/loginadmin', [$controller, 'post_loginadmin']);
Route::get('/register', [$controller, 'register'])->name('register');
Route::post('/register', [$controller, 'post_register']);
Route::get('/logout', [$controller, 'logout'])->name('logout');
Route::get('/forgot-password', [$controller, 'forgotPassword'])->name('forgot-password');
Route::post('/confirm-information', [$controller, 'confirmInformation'])->name('confirm-information');
Route::get('/reset-password/{token}', [$controller, 'resetPassword'])->name('reset-password');
Route::post('/create-password', [$controller, 'createPassword'])->name('create-password');

$controller = ShopController::class;
Route::prefix('')->group(function () use ($controller) {
    Route::get('/', [$controller, 'index'])->name('home');
    Route::get('/shop', [$controller, 'product'])->name('shop');
    Route::get('/contact', [$controller, 'contact'])->name('contact');
    Route::post('/post-contact', [$controller, 'postcontact'])->name('contact.post');
    Route::get('/category/{id}', [$controller, 'getProductByCategory'])->name('getbycategory');
    Route::get('/brand/{id}', [$controller, 'getProductByBrand'])->name('getbybrand');
    Route::get('/product/{id}', [$controller, 'getProductDetail'])->name('getdetail');
    Route::get('/search', [$controller, 'getProductByName'])->name('search');
    Route::get('/blog', [$controller, 'post'])->name('blog');
    Route::get('/blog/{id}', [$controller, 'getPostById'])->name('getbypostid');
    Route::get('/type/{id}', [$controller, 'getPostByType'])->name('getbytype');
    Route::get('/searchblog', [$controller, 'getPostByTitle'])->name('searchblog');
    $prefix = 'cart';
    $controller = CartController::class;
    Route::prefix('cart')->middleware('checklogin')->group(function () use ($prefix, $controller) {
        Route::get('/', [$controller, 'index'])->name($prefix);
        Route::post('/store', [$controller, 'store'])->name($prefix . '.store');
        Route::post('/update', [$controller, 'update'])->name($prefix . '.update');
        Route::get('/delete/{id}', [$controller, 'delete'])->name($prefix . '.delete');
        Route::post('/apply-coupon', [$controller, 'applyCoupon'])->name($prefix . '.coupon');
        Route::get('/delete-coupon', [$controller, 'removeCoupon'])->name($prefix . '.coupon.delete');
        Route::prefix('/checkout')->group(function () use ($prefix, $controller) {
            Route::get('/', [$controller, 'checkout'])->name($prefix . '.checkout');
            Route::post('/create-order', [$controller, 'createOrder'])->name($prefix . '.order.create');
        });
    });
    $controller = InformationController::class;
    Route::prefix('information')->middleware('checklogin')->group(function () use ($controller) {
        Route::get('/', [$controller, 'index'])->name('information');
        Route::get('/edit', [$controller, 'edit'])->name('information.edit');
        Route::post('/update/{id}', [$controller, 'update'])->name('information.update');
        Route::get('/orders', [$controller, 'orders'])->name('orders');
        Route::get('/orders-detail/{id}', [$controller, 'orderDetail'])->name('orders.detail');
        Route::get('/new-password', [$controller, 'newPassword'])->name('new-password');
        Route::post('/post-password', [$controller, 'postPassword'])->name('post-password');
    });
});
$admin_prefix = config('app_define.admin_prefix');
Route::prefix($admin_prefix)->middleware('authAdmin')->group(function () use ($admin_prefix) {
    Route::get('/', [DashboardController::class, 'index'])->name($admin_prefix);
    //===========================BANNER=====================
    $prefix = 'banner';
    $controller = BannerController::class;
    Route::prefix($prefix)->group(function () use ($controller, $prefix) {
        Route::get('/', [$controller, 'index'])->middleware('checkpermission:show-' . $prefix)->name($prefix);
        Route::get('/create', [$controller, 'create'])->middleware('checkpermission:create-' . $prefix)->name($prefix . '.create');
        Route::post('/store', [$controller, 'store'])->name($prefix . '.store');
        Route::get('/edit/{id}', [$controller, 'edit'])->middleware('checkpermission:update-' . $prefix)->name($prefix . '.edit');
        Route::post('/update/{id}', [$controller, 'update'])->name($prefix . '.update');
        Route::get('/delete/{id}', [$controller, 'delete'])->middleware('checkpermission:delete-' . $prefix)->name($prefix . '.delete');

    });
    //===========================CATEGORY=====================
    $prefix = 'category';
    $controller = CategoryController::class;
    Route::prefix($prefix)->group(function () use ($controller, $prefix) {
        Route::get('/', [$controller, 'index'])->middleware('checkpermission:show-' . $prefix)->name($prefix);
        Route::get('/create', [$controller, 'create'])->middleware('checkpermission:create-' . $prefix)->name($prefix . '.create');
        Route::post('/store', [$controller, 'store'])->name($prefix . '.store');
        Route::get('/edit/{id}', [$controller, 'edit'])->middleware('checkpermission:update-' . $prefix)->name($prefix . '.edit');
        Route::post('/update/{id}', [$controller, 'update'])->name($prefix . '.update');
        Route::get('/delete/{id}', [$controller, 'delete'])->middleware('checkpermission:delete-' . $prefix)->name($prefix . '.delete');
    });
    //===========================BRAND==========================
    $prefix = 'brand';
    $controller = BrandController::class;
    Route::prefix($prefix)->group(function () use ($controller, $prefix) {
        Route::get('/', [$controller, 'index'])->middleware('checkpermission:show-' . $prefix)->name($prefix);
        Route::get('/create', [$controller, 'create'])->middleware('checkpermission:create-' . $prefix)->name($prefix . '.create');
        Route::post('/store', [$controller, 'store'])->name($prefix . '.store');
        Route::get('/edit/{id}', [$controller, 'edit'])->middleware('checkpermission:update-' . $prefix)->name($prefix . '.edit');
        Route::post('/update/{id}', [$controller, 'update'])->name($prefix . '.update');
        Route::get('/delete/{id}', [$controller, 'delete'])->middleware('checkpermission:delete-' . $prefix)->name($prefix . '.delete');
    });
    //===========================PRODUCT=====================
    $prefix = 'product';
    $controller = ProductController::class;
    Route::prefix($prefix)->group(function () use ($controller, $prefix) {
        Route::get('/', [$controller, 'index'])->middleware('checkpermission:show-' . $prefix)->name($prefix);
        Route::get('/create', [$controller, 'create'])->middleware('checkpermission:create-' . $prefix)->name($prefix . '.create');
        Route::post('/store', [$controller, 'store'])->name($prefix . '.store');
        Route::get('/edit/{id}', [$controller, 'edit'])->middleware('checkpermission:update-' . $prefix)->name($prefix . '.edit');
        Route::post('/update/{id}', [$controller, 'update'])->name($prefix . '.update');
        Route::get('/delete/{id}', [$controller, 'delete'])->middleware('checkpermission:delete-' . $prefix)->name($prefix . '.delete');
        Route::get('/comment/{id}', [$controller, 'showComment'])->middleware('checkpermission:show-' . $prefix)->name($prefix . '.comment');
        Route::get('/delete-comment/{id}', [$controller, 'deleteComment'])->middleware('checkpermission:show-' . $prefix)->name($prefix . '.comment.delete');
    });
    //===========================TYPE POST=====================
    $prefix = 'type';
    $controller = TypeController::class;
    Route::prefix($prefix)->group(function () use ($controller, $prefix) {
        Route::get('/', [$controller, 'index'])->middleware('checkpermission:show-' . $prefix)->name($prefix);
        Route::get('/create', [$controller, 'create'])->middleware('checkpermission:create-' . $prefix)->name($prefix . '.create');
        Route::post('/store', [$controller, 'store'])->name($prefix . '.store');
        Route::get('/edit/{id}', [$controller, 'edit'])->middleware('checkpermission:update-' . $prefix)->name($prefix . '.edit');
        Route::post('/update/{id}', [$controller, 'update'])->name($prefix . '.update');
        Route::get('/delete/{id}', [$controller, 'delete'])->middleware('checkpermission:delete-' . $prefix)->name($prefix . '.delete');
    });
    //===========================TYPE POST=====================
    $prefix = 'post';
    $controller = PostController::class;
    Route::prefix($prefix)->group(function () use ($controller, $prefix) {
        Route::get('/', [$controller, 'index'])->middleware('checkpermission:show-' . $prefix)->name($prefix);
        Route::get('/create', [$controller, 'create'])->middleware('checkpermission:create-' . $prefix)->name($prefix . '.create');
        Route::post('/store', [$controller, 'store'])->name($prefix . '.store');
        Route::get('/edit/{id}', [$controller, 'edit'])->middleware('checkpermission:update-' . $prefix)->name($prefix . '.edit');
        Route::post('/update/{id}', [$controller, 'update'])->name($prefix . '.update');
        Route::get('/delete/{id}', [$controller, 'delete'])->middleware('checkpermission:delete-' . $prefix)->name($prefix . '.delete');
        Route::get('/comment/{id}', [$controller, 'showComment'])->middleware('checkpermission:show-' . $prefix)->name($prefix . '.comment');
        Route::get('/delete-comment/{id}', [$controller, 'deleteComment'])->middleware('checkpermission:show-' . $prefix)->name($prefix . '.comment.delete');
    });
    //===========================ROLE=====================
    $prefix = 'role';
    $controller = RoleController::class;
    Route::prefix($prefix)->group(function () use ($controller, $prefix) {
        Route::get('/', [$controller, 'index'])->middleware('checkpermission:show-' . $prefix)->name($prefix);
        Route::get('/create', [$controller, 'create'])->middleware('checkpermission:create-' . $prefix)->name($prefix . '.create');
        Route::post('/store', [$controller, 'store'])->name($prefix . '.store');
        Route::get('/edit/{id}', [$controller, 'edit'])->middleware('checkpermission:update-' . $prefix)->name($prefix . '.edit');
        Route::post('/update/{id}', [$controller, 'update'])->name($prefix . '.update');
        Route::get('/delete/{id}', [$controller, 'delete'])->middleware('checkpermission:delete-' . $prefix)->name($prefix . '.delete');
    });
    //===========================USER=====================
    $prefix = 'user';
    $controller = UserController::class;
    Route::prefix($prefix)->group(function () use ($controller, $prefix) {
        Route::get('/', [$controller, 'index'])->middleware('checkpermission:show-' . $prefix)->name($prefix);
        Route::get('/create', [$controller, 'create'])->middleware('checkpermission:create-' . $prefix)->name($prefix . '.create');
        Route::post('/store', [$controller, 'store'])->name($prefix . '.store');
        Route::get('/edit/{id}', [$controller, 'edit'])->middleware('checkpermission:update-' . $prefix)->name($prefix . '.edit');
        Route::post('/update/{id}', [$controller, 'update'])->name($prefix . '.update');
        Route::get('/delete/{id}', [$controller, 'delete'])->middleware('checkpermission:delete-' . $prefix)->name($prefix . '.delete');
    });
    //===========================COUPON=====================
    $prefix = 'coupon';
    $controller = CouponController::class;
    Route::prefix($prefix)->group(function () use ($controller, $prefix) {
        Route::get('/', [$controller, 'index'])->middleware('checkpermission:show-' . $prefix)->name($prefix);
        Route::get('/create', [$controller, 'create'])->middleware('checkpermission:create-' . $prefix)->name($prefix . '.create');
        Route::post('/store', [$controller, 'store'])->name($prefix . '.store');
        Route::get('/edit/{id}', [$controller, 'edit'])->middleware('checkpermission:update-' . $prefix)->name($prefix . '.edit');
        Route::post('/update/{id}', [$controller, 'update'])->name($prefix . '.update');
        Route::get('/delete/{id}', [$controller, 'delete'])->middleware('checkpermission:delete-' . $prefix)->name($prefix . '.delete');
    });
    //===========================CUTSTOMER=====================
    $prefix = 'customer';
    $controller = CustomerController::class;
    Route::prefix($prefix)->group(function () use ($controller, $prefix) {
        Route::get('/', [$controller, 'index'])->middleware('checkpermission:list-' . $prefix)->name($prefix);
        Route::get('/edit/{id}', [$controller, 'edit'])->middleware('checkpermission:list-' . $prefix)->name($prefix . '.edit');
        Route::post('/update/{id}', [$controller, 'update'])->middleware('checkpermission:list-' . $prefix)->name($prefix . '.update');
        Route::get('/delete/{id}', [$controller, 'delete'])->middleware('checkpermission:list-' . $prefix)->name($prefix . '.delete');
        Route::get('/detail/{id}', [$controller, 'detail'])->middleware('checkpermission:list-' . $prefix)->name($prefix . '.detail');
    });
    //===========================ORDER=====================
    $prefix = 'order';
    $controller = OrderController::class;
    Route::prefix($prefix)->group(function () use ($controller, $prefix) {
        Route::get('/', [$controller, 'index'])->name($prefix);
        Route::get('/detail/{id}', [$controller, 'detail'])->name($prefix . '.detail');
        Route::post('/update/{id}', [$controller, 'updateStatus'])->name($prefix . '.update');
    });
    //===========================MAIL=====================
    $prefix = 'mail';
    $controller = MailController::class;
    Route::prefix($prefix)->group(function () use ($controller, $prefix) {
        Route::get('/{status}', [$controller, 'index'])->middleware('checkpermission:list-' . $prefix)->name($prefix);
        Route::get('/m/create', [$controller, 'create'])->middleware('checkpermission:send-' . $prefix)->name($prefix . '.create');
        Route::get('/m/recycle', [$controller, 'recycle'])->middleware('checkpermission:list-' . $prefix)->name($prefix . '.recycle');
        Route::post('/m/send', [$controller, 'send'])->middleware('checkpermission:send-' . $prefix)->name($prefix . '.send');
        Route::get('/detail/{id}', [$controller, 'detail'])->middleware('checkpermission:list-' . $prefix)->name($prefix . '.detail');
        Route::get('/delete/{id}', [$controller, 'delete'])->middleware('checkpermission:delete-' . $prefix)->name($prefix . '.delete');
        Route::get('/restore/{id}', [$controller, 'restore'])->middleware('checkpermission:delete-' . $prefix)->name($prefix . '.restore');
        Route::get('/destroy/{id}', [$controller, 'destroy'])->middleware('checkpermission:delete-' . $prefix)->name($prefix . '.destroy');
    });
});

Route::group(['prefix' => 'laravel-filemanager'], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
Route::prefix('/error')->group(function () {
    $prefix = '404';
    Route::get($prefix, function () use ($prefix) {
        return view('error.error' . $prefix);
    })->name($prefix);
    $prefix = '403';
    Route::get($prefix, function () use ($prefix) {
        return view('error.error' . $prefix);
    })->name($prefix);
});
//===========API============//
Route::prefix('api')->group(function () {
    Route::get('/search-product/{key}', [ApiController::class, 'ajaxSearch'])->name('ajaxSearch');
    Route::get('/get-cart/{id}', [ApiController::class, 'getCartAjax']);
    Route::post('/add-cart', [ApiController::class, 'addCartAjax']);
    Route::get('/cart-quantity', [ApiController::class, 'cartQuantity'])->name('cart-quantity');
    Route::get('/get-min-max-price', [ApiController::class, 'MinMaxPriceAjax']);
    Route::get('/get-product-price', [ApiController::class, 'getProductByPrice']);
    Route::get('/store-comment', [CommentController::class, 'store'])->name('comments.store');
    Route::get('/update-comment/{id}', [CommentController::class, 'update'])->name('comments.update');
    Route::get('/delete-comment/{id}', [CommentController::class, 'delete'])->name('comments.delete');

});
//===========Payment============//
Route::prefix('payment')->group(function () {
    Route::get('/{code}', [PaymentController::class, 'index'])->name('payment');
    Route::post('/vn-pay', [PaymentController::class, 'vnpay_payment'])->name('vn-pay');
    Route::get('vn/vnpay_return', [PaymentController::class, 'vnpay_return'])->name('vnpay_return');
    Route::post('/mm-pay', [PaymentController::class, 'momo_payment'])->name('mm-pay');
    Route::get('mm/mmpay_return', [PaymentController::class, 'momo_return'])->name('momo_return');
});