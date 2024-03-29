<?php

namespace App\Http\Controllers\API;

use Auth;
use App\Rules\Captcha;
use App\Helpers\MailHelper;
use Illuminate\Http\Request;
use App\Models\EmailTemplate;
use App\Mail\ContactWithAuthor;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class ContactWithAuthorController extends Controller
{

    public function contactWithAuthor(Request $request){
        if(Auth::guard('api')->check()){
            $rules = [
                'message'=>'required',
                'g-recaptcha-response'=>new Captcha()
            ];
            $customMessages = [
                'message.required' => trans('user_validation.Message is required'),
            ];
            $this->validate($request, $rules,$customMessages);

            $user=Auth::guard('api')->user();
            $user_email=$user->email;
            $user_message=$request->message;
            $template=EmailTemplate::where('id',12)->first();
            $subject=$template->subject;
            $message=$template->description;
            $message = str_replace('{{message}}',$user_message,$message);

            MailHelper::setMailConfig();
            Mail::to($request->email)->send(new ContactWithAuthor($subject,$message,$user_email));

            $notification = trans('user_validation.Message submit successfully');
            return response()->json(['message' => $notification]);
       }else{
            $notification = trans('user_validation.Please login your account');
            return response()->json(['message' => $notification],401);
       }
    }
}
