@extends($active_theme)
@section('title')
    <title>{{__('user.Login')}}</title>
@endsection
@section('meta')
    <meta name="description" content="{{__('user.Login')}}">
@endsection

@section('frontend-content')
 <!--=============================
        LOGIN PAGE START
    ==============================-->
    <section class="wsus__login pt_180 pb_205">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-md-10 col-lg-7 m-auto wow fadeInUp" data-wow-duration="1s">
                    <div class="wsus__login_area">
                        <h2>{{__('user.Log In')}}</h2>
                        <form action="{{ route('store-login') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="wsus__login_inpu_area">
                                        <label>{{__('user.Email Address')}}*</label>
                                        <input type="text" name="email" placeholder="{{__('user.Email Address')}}">
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="wsus__login_inpu_area">
                                        <label>{{__('user.Password')}}*</label>
                                        <input type="password" name="password" id="passowrd_input" placeholder="{{__('user.Password')}}">
                                        <span class="eye" id="show_password"><i class="fas fa-eye-slash"></i></span>
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="wsus__login_inpu_area">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="flexCheckDefault" name="remember">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                {{__('user.Remeber Me')}}
                                            </label>
                                            <a href="{{ route('forget-password') }}">{{__('user.Forget Password')}}</a>
                                        </div>
                                    </div>
                                </div>
                                @if($recaptchaSetting->status==1)
                                    <div class="col-xl-12">
                                        <div class="wsus__single_com mt_20">
                                            <div class="g-recaptcha" data-sitekey="{{ $recaptchaSetting->site_key }}"></div>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-xl-12 mt-2">
                                    <button class="common_btn" type="submit">{{__('user.Log In')}}</button>
                                </div>
                                <div class="col-xl-12">
                                    @if ($socialLogin->is_gmail == 1)
                                    <div class="wsus__login_inpu_area mb_15">
                                        <ul>
                                            <li>
                                                <a href="{{ route('login-google') }}">
                                                    <span>
                                                        <img src="{{ asset('frontend/images/google_icon.png') }}" alt="icon"
                                                            class="img-fluid w-100">
                                                    </span>
                                                    {{__('user.Sign In with Google')}}</
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    @endif
                                    <p class="go_login">{{__("user.Do not have an Account")}}?  <a href="{{ route('register') }}">   {{__('user.create account')}}</a></p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="login_animi_area">
            <ul class="bg_animation">
                <li class="wow bounceIn" data-wow-duration=" 1000ms"></li>
                <li class="wow bounceIn" data-wow-duration=" 1100ms"></li>
                <li class="wow bounceIn" data-wow-duration=" 1200ms"></li>
                <li class="wow bounceIn" data-wow-duration=" 1300ms"></li>
                <li class="wow bounceIn" data-wow-duration=" 1400ms"></li>
                <li class="wow bounceIn" data-wow-duration=" 1500ms"></li>
                <li class="wow bounceIn" data-wow-duration=" 1600ms"></li>
                <li class="wow bounceIn" data-wow-duration=" 1700ms"></li>
                <li class="wow bounceIn" data-wow-duration=" 1800ms"></li>
                <li class="wow bounceIn" data-wow-duration=" 1900ms"></li>
                <li class="wow bounceIn" data-wow-duration=" 2000ms"></li>
            </ul>
            <ul class="bg_animation bg_animation_r">
                <li class="wow bounceIn" data-wow-duration=" 1000ms"></li>
                <li class="wow bounceIn" data-wow-duration=" 1100ms"></li>
                <li class="wow bounceIn" data-wow-duration=" 1200ms"></li>
                <li class="wow bounceIn" data-wow-duration=" 1300ms"></li>
                <li class="wow bounceIn" data-wow-duration=" 1400ms"></li>
                <li class="wow bounceIn" data-wow-duration=" 1500ms"></li>
                <li class="wow bounceIn" data-wow-duration=" 1600ms"></li>
                <li class="wow bounceIn" data-wow-duration=" 1700ms"></li>
                <li class="wow bounceIn" data-wow-duration=" 1800ms"></li>
                <li class="wow bounceIn" data-wow-duration=" 1900ms"></li>
                <li class="wow bounceIn" data-wow-duration=" 2000ms"></li>
            </ul>
        </div>
    </section>
    <!--=============================
        LOGIN PAGE END
    ==============================-->




@endsection

@section('frontend_js')
<script>
    let password_show = false;
    (function($) {
        "use strict";
        $(document).ready(function () {
            $("#show_password").on("click", function(){
                password_show = !password_show;
                if(password_show){
                    $(this).html('<i class="fas fa-eye"></i>')

                    $('#passowrd_input').prop('type', 'text');

                }else{
                    $(this).html('<i class="fas fa-eye-slash"></i>')
                    $('#passowrd_input').prop('type', 'password');
                }
            })
        });
    })(jQuery);
</script>
@endsection
