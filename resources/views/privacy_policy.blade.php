@extends($active_theme)
@section('title')
    <title>{{__('user.Privacy Policy')}}</title>
@endsection
@section('meta')
    <meta name="description" content="{{__('user.Privacy Policy')}}">
@endsection

@section('frontend-content')
 <!--=============================
        BREADCRUMB START
    ==============================-->
    <section class="wsus__breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <h1>{{__('user.Privacy Policy')}}</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{__('user.Home')}}</a></li>
                            <li class="breadcrumb-item">{{__('user.Privacy Policy')}}</li>
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
        PRIVACY POLICY START
    ==============================-->
    <section class="wsus__privacy_policy pt_45">
        <div class="container">
            <div class="row">
                <div class="col-12 col-xl-12 wow fadeInUp" data-wow-duration="1s">
                    <div class="wsus__terms_condition_text">
                        {!! clean($privacyPolicy) !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
        PRIVACY POLICY END
    ==============================-->

@endsection
