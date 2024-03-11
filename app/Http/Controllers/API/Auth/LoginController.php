<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

use App\Models\GoogleRecaptcha;
use App\Models\User;
use App\Rules\Captcha;
use App\Mail\UserForgetPassword;
use App\Mail\UserForgetPasswordForOTP;
use App\Helpers\MailHelper;
use App\Models\EmailTemplate;
use App\Models\SocialLoginInformation;
use App\Models\Setting;
use Mail;
use Str;
use Validator,Redirect,Response,File;
use Socialite;
use Auth;
use Hash;
use Session;
class LoginController extends Controller
{

    use AuthenticatesUsers;
    protected $redirectTo = '/dashboard';

    public function __construct()
    {
        $this->middleware('guest:api')->except('userLogout');
    }

    public function storeLogin(Request $request){
        $rules = [
            'email'=>'required',
            'password'=>'required',
            'g-recaptcha-response'=>new Captcha()
        ];
        $customMessages = [
            'email.required' => trans('user_validation.Email is required'),
            'password.required' => trans('user_validation.Password is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        $credential=[
            'email'=> $request->email,
            'password'=> $request->password
        ];

        $user = User::where('email',$request->email)->select('id','name','email','phone','user_name','status','password','image','address','designation','about_me','my_skill','facebook','twitter','linkedin','dribbble','pinterest')->first();
        if($user){
            if($user->status==1){
                if(Hash::check($request->password,$user->password)){
                    if($token = Auth::guard('api')->attempt($credential)){
                        return $this->respondWithToken($token,$user);
                    }else{
                        return response()->json(['message' => 'Unauthorized'], 401);
                    }
                }else{
                    $notification = trans('user_validation.Credentials does not exist');
                    return response()->json(['message' => $notification], 403);
                }

            }else{
                $notification = trans('user_validation.Disabled Account');
                return response()->json(['message' => $notification], 403);
            }
        }else{
            $notification = trans('user_validation.Email does not exist');
            return response()->json(['message' => $notification], 403);
        }
    }

    protected function respondWithToken($token,$user)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => $user
        ]);
    }

    public function sendForgetPassword(Request $request){
        $rules = [
            'email'=>'required',
            'g-recaptcha-response'=>new Captcha()
        ];
        $customMessages = [
            'email.required' => trans('user_validation.Email is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        $user = User::where('email', $request->email)->first();

        if($user){
            $user->forget_password_otp = random_int(100000, 999999);
            $user->save();

            try{
                MailHelper::setMailConfig();
                $template = EmailTemplate::where('id',1)->first();
                $subject = $template->subject;
                $message = $template->description;
                $message = str_replace('{{name}}',$user->name,$message);
                Mail::to($user->email)->send(new UserForgetPasswordForOTP($message,$subject,$user));
            }catch(Exception $ex){}

            $notification = trans('user_validation.Reset password link send to your email.');
            return response()->json(['message' => $notification]);

        }else{
            $notification = trans('user_validation.Email does not exist');
            return response()->json(['message' => $notification],403);
        }
    }

    public function storeResetPasswordPage(Request $request){

        $rules = [
            'email'=>'required',
            'token'=>'required',
            'password'=>'required|min:4|confirmed',
            'g-recaptcha-response'=>new Captcha()
        ];
        $customMessages = [
            'email.required' => trans('user_validation.Email is required'),
            'password.required' => trans('user_validation.Password is required'),
            'password.min' => trans('user_validation.Password must be 4 characters'),
            'password.confirmed' => trans('user_validation.Confirm password does not match'),
            'token.required' => trans('user_validation.Token is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        $user = User::where(['email' => $request->email, 'forget_password_otp' => $request->token])->first();
        if($user){
            $user->password=Hash::make($request->password);
            $user->forget_password_token=null;
            $user->forget_password_otp=null;
            $user->save();

            $notification = trans('user_validation.Password Reset successfully');
            return response()->json(['message' => $notification]);
        }else{
            $notification = trans('user_validation.Invalid token');
            return response()->json(['message' => $notification],403);
        }
    }

    public function userLogout(){
        Auth::guard('api')->logout();
        $notification= trans('user_validation.Logout Successfully');
        return response()->json(['message' => $notification]);
    }

}
