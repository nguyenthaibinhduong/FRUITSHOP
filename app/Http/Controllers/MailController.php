<?php

namespace App\Http\Controllers;

use App\Mail\SendMail;
use App\Models\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail as FacadesMail;
use Illuminate\Support\Facades\View;

class MailController extends Controller
{
    protected $view_path='admin.mail.';
    public function index($status){
        if($status=='recive'){
            $mails = Mail::where('type',1)->get();
        }
        if($status=='send'){
            $mails = Mail::where('type',0)->get();
        }
        if($status=='all'){
            $mails = Mail::all();
        }

        return view($this->view_path.'index', compact('mails'));
    }
    public function detail($id){
        $mail = Mail::find($id);

        return view($this->view_path.'detail', compact('mail'));
    }
    public function recycle(){
        $mails = Mail::onlyTrashed()->get();
        return view($this->view_path.'recycle', compact('mails'));
    }
    public function create(){
        return view($this->view_path.'create');
    }
    public function send(Request $request){
     try{
            //dd($request->all());
      $recipient_email=$request->recipient_email;
      $subject=$request->subject;
      $body=$request->body;
      $view_mail= View::make('admin.mail.template', compact('body'))->render();
      if(FacadesMail::mailer('smtp')
      ->to($recipient_email)
      ->send(new SendMail($subject,$body))){
         Mail::create([
         'type'=>0,
         'subject'=>$subject,
         'body'=>$view_mail,
         'sender_email'=>'natteam1998@gmail.com',
         'recipient_email'=>$recipient_email,
         ]);
         return redirect()->back()->with('success','Mail được gửi thành công');
      }else{
        return back()->with('danger','Mail gửi không thành công');
      }
        
        } catch (\Exception $e) {
            // Handle other exceptions
            return back()->with('danger','Đã xảy ra lỗi. Vui lòng thử lại.');
        }
    }
    public function restore($id){
        try{

            $mail= Mail::withTrashed()->find($id);
            $mail->restore();
    
            return redirect()->back()->with('success','Khôi phục thành công');
            } catch (\Exception $e) {
                // Handle other exceptions
                return back()->with('danger','Đã xảy ra lỗi. Vui lòng thử lại.');
            }
    }
    public function delete($id){
        try{

        Mail::find($id)->delete();

        return redirect()->back()->with('success','Xóa thành công');
        } catch (\Exception $e) {
            // Handle other exceptions
            return back()->with('danger','Đã xảy ra lỗi. Vui lòng thử lại.');
        }
    }
    public function destroy($id){
        try{

        $mail = Mail::onlyTrashed()->find($id);
        $mail->forceDelete();
        return redirect()->back()->with('success','Bản ghi đã được xóa vĩnh viễn');
        } catch (\Exception $e) {
            // Handle other exceptions
            return back()->with('danger','Đã xảy ra lỗi. Vui lòng thử lại.');
        }
    }
}