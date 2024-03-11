
@extends($active_theme)

@section('title')
<title>{{ $seo_setting->seo_title }}</title>
<meta name="title" content="{{ $seo_setting->seo_title }}">
<meta name="description" content="{{ $seo_setting->seo_description }}">
@endsection


@section('frontend-content')
<!--=============================
        BREADCRUMB START
    ==============================-->
    <section class="wsus__breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <h1>{{__('user.contact us')}}</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{__('user.Home')}}</a></li>
                            <li class="breadcrumb-item">{{__('user.Contact us')}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="breadcrumb_animi_area">
            <ul class="bg_animation breadcrumb_animi">
                <li class="wow bounceIn" data-wow-duration=" 1000ms"></li>
                <li class="wow bounceIn" data-wow-duration=" 1100ms"></li>
                <li class="wow bounceIn" data-wow-duration=" 1200ms"></li>
                <li class="wow bounceIn" data-wow-duration=" 1300ms"></li>
                <li class="wow bounceIn" data-wow-duration=" 1400ms"></li>
                <li class="wow bounceIn" data-wow-duration=" 1500ms"></li>
            </ul>
            <ul class="bg_animation bg_animation_r breadcrumb_animi breadcrumb_animi_r">
                <li class="wow bounceIn" data-wow-duration=" 1000ms"></li>
                <li class="wow bounceIn" data-wow-duration=" 1100ms"></li>
                <li class="wow bounceIn" data-wow-duration=" 1200ms"></li>
                <li class="wow bounceIn" data-wow-duration=" 1300ms"></li>
                <li class="wow bounceIn" data-wow-duration=" 1400ms"></li>
                <li class="wow bounceIn" data-wow-duration=" 1500ms"></li>
            </ul>
        </div>
    </section>
    <!--=============================
        BREADCRUMB END
    ==============================-->


    <!--=============================
        CONTACT US START
    ==============================-->
    <section class="wsus__contact_us pt_100">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-7 wow fadeInLeft" data-wow-duration="1s">
                    <div class="wsus__contact_info">
                        <h3>{{ $contact->title }}</h3>
                        <p>
                            {{ $contact->description }}
                        </p>
                        <div class="row">
                            <div class="col-xl-6 col-md-6">
                                <div class="wsus__contact_single_info">
                                    <span><i class="fas fa-phone-alt"></i></span>
                                    <h4>{{__('user.Phone')}}</h4>
                                    <a>{!!  nl2br($contact->phone) !!}</a>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6">
                                <div class="wsus__contact_single_info">
                                    <span><i class="fas fa-envelope"></i></span>
                                    <h4>{{__('user.Email')}}</h4>
                                    <a>{!! nl2br($contact->email) !!}</a>
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="wsus__contact_map">
                                    <div class="text">
                                        <span><i class="fas fa-map-marker-alt"></i></span>
                                        <h4>{{__('user.Address')}}</h4>
                                        <p>
                                            {{ $contact->address }}
                                        </p>
                                    </div>
                                    <div class="map">
                                        {!! $contact->map !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-5 wow fadeInRight" data-wow-duration="1s">
                    <div class="wsus__contact_form">
                        <h3>{{__('user.Have Any Question')}}</h3>
                        <form action="{{ route('send-contact-message') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="wsus__contact_form_single">
                                        <label>{{__('user.Name')}}*</label>
                                        <input type="text" name="name" placeholder="{{__('user.Name')}}">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="wsus__contact_form_single">
                                        <label>{{__('user.Email')}}*</label>
                                        <input type="text" name="email" placeholder="{{__('user.Email')}}">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="wsus__contact_form_single">
                                        <label>{{__('user.Phone')}}</label>
                                        <input type="text" name="phone" placeholder="{{__('user.Phone')}}">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="wsus__contact_form_single">
                                        <label>{{__('user.Subject')}}*</label>
                                        <input type="text" name="subject" placeholder="{{__('user.Subject')}}">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="wsus__contact_form_single">
                                        <label>{{__('user.Message')}}*</label>
                                        <textarea rows="8" name="message" placeholder="{{__('user.Type your message here')}}"></textarea>
                                    </div>
                                </div>
                                @if($recaptchaSetting->status==1)
                                    <div class="col-xl-12">
                                        <div class="wsus__single_com mb_10">
                                            <div class="g-recaptcha" data-sitekey="{{ $recaptchaSetting->site_key }}"></div>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-12">
                                    <div class="wsus__contact_form_single">
                                        <button class="common_btn" type="submit">{{__('user.Send Messages')}}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
        CONTACT US END
    ==============================-->
@endsection
