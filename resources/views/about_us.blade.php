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
                    <h1>{{__('user.About us')}}</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{__('user.Home')}}</a></li>
                            <li class="breadcrumb-item">{{__('user.About us')}}</li>
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
        ABOUT PAGE START
    ==============================-->
    <section class="wsus__about_page">

        <div class="wsus__about_us pt_100 pb_100">
            <div class="container">
                <div class="row justify-content-between">
                    <div class="col-xl-5 col-lg-6 wow fadeInLeft" data-wow-duration="1s">
                        <div class="wsus__about_img">
                            <img src="{{ $about_us->image }}" alt="about us" class="img-fluid w-100">
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 wow fadeInRight" data-wow-duration="1s">
                        <div class="wsus__about_text">

                            <h2>{!! strip_tags(clean($about_us->header1),'<span>') !!}</h2>

                            {!! clean($about_us->about_us) !!}

                            <a class="common_btn2" href="{{ route('contact-us') }}">{{__('user.Contact us')}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if ($our_teem_section->visibility)
        <div class="wsus__team pt_95 pb_95" style="background: url({{ asset('frontend') }}/images/team_bg.jpg);">
            <div class="container">
                <div class="row">
                    <div class="col-xl-7 m-auto wow fadeInUp" data-wow-duration="1s">
                        <div class="wsus__section_heading mb_25">
                            <h5>{{__('user.Save time with pre-installed software.')}}</h5>
                            <h2>{{__('user.Meet Our Expertise Team')}}</h2>
                        </div>
                    </div>
                </div>
                <div class="row team_slider">
                @foreach ($our_teem_section->our_teems as $our_team)
                    <div class="col-xl-4 wow fadeInUp" data-wow-duration="1s">
                        <div class="wsus__single_team">
                            <div class="wsus__single_team_img">
                                <img src="{{ asset( $our_team->image ) }}" alt="{{ $our_team->name }}" class="img-fluid w-100">
                                <ul>
                                    <li><a href="{{ $our_team->facebook }}"><i class="fab fa-facebook-f"></i></a></li>
                                    <li><a href="{{ $our_team->linkedin }}"><i class="fab fa-linkedin-in"></i></a></li>
                                    <li><a href="{{ $our_team->twitter }}"><i class="fab fa-twitter"></i></a></li>
                                    <li><a href="{{ $our_team->instagram }}"><i class="fab fa-instagram"></i></a></li>
                                </ul>
                            </div>
                            <div class="wsus__single_team_text">
                                <h4>{{ $our_team->name }}</h4>
                                <p>{{ $our_team->designation }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>
        </div>
        @endif
        @if ($why_choose_us->visibility)
        <div class="wsus__why_choose pt_95 pb_100" style="background: url({{ asset($why_choose_us->home1_background) }});">
            <div class="container">
                <div class="row">
                    <div class="col-xl-7 m-auto wow fadeInUp" data-wow-duration="1s">
                        <div class="wsus__section_heading mb_25">
                            <h5>{{ $why_choose_us->title1 }}</h5>
                            <h2>{{ $why_choose_us->title2 }}</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-4 col-md-4 wow fadeInLeft" data-wow-duration="1s">
                        <div class="wsus__why_choose_item">
                            <div class="img">
                                <img src="{{ asset($why_choose_us->icon1) }}" alt="why choose" class="img-fluid w-100">
                            </div>
                            <h4>{{ $why_choose_us->item_title1 }}</h4>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-4 wow fadeInLeft" data-wow-duration="1s">
                        <div class="wsus__why_choose_item">
                            <div class="img">
                                <img src="{{ asset($why_choose_us->icon2) }}" alt="why choose" class="img-fluid w-100">
                            </div>
                            <h4>{{ $why_choose_us->item_title2 }}</h4>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-4 wow fadeInLeft" data-wow-duration="1s">
                        <div class="wsus__why_choose_item last">
                            <div class="img">
                                <img src="{{ asset($why_choose_us->icon3) }}" alt="why choose" class="img-fluid w-100">
                            </div>
                            <h4>{{ $why_choose_us->item_title3 }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    <!--=============================
        TESTIMOMNIAL START
    ==============================-->
    @if ($testimonial_section->visibility)
    <section class="wsus__testimonial pt_95 pb_100">
        <div class="container">
            <div class="row">
                <div class="col-xl-7 m-auto wow fadeInUp" data-wow-duration="1s">
                    <div class="wsus__section_heading mb_40">
                        <h5>{{ $testimonial_section->title }}</h5>
                        <h2>{{ $testimonial_section->description }}</h2>
                    </div>
                </div>
            </div>
            <div class="row testi_slider">
                @foreach ($testimonial_section->testimonials as $testimonial)
                <div class="col-xl-6 wow fadeInUp" data-wow-duration="1s">
                    <div class="wsus__testimonial_item">
                        <p class="description">
                            {!! clean($testimonial->comment) !!}
                        </p>
                        <p class="rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                        </p>
                        <div class="wsus__testimonial_footer d-flex flex-wrap">
                            <div class="img">
                                <img src="{{ asset($testimonial->image) }}" alt="testimonial" class="img-fluid w-100">
                            </div>
                            <div class="text">
                                <h4>{{ $testimonial->name }}</h4>
                                <p>{{ $testimonial->designation }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
    <!--=============================
        TESTIMOMNIAL END
    ==============================-->
    <!--=============================
        BRAND SECTION START
    ==============================-->
    @if ($partner_visbility)
    <div class="wsus__brand">
        <div class="container">
            <div class="row">
                <div class="col-12 mb_30 wow fadeInUp" data-wow-duration="1s">
                    <ul class="wsus__brand_item d-flex flex-wrap justify-content-center">
                        @foreach ($partners as $partner)
                        <li>
                            <a href="{{ $partner->link }}">
                                <img src="{{ asset($partner->logo) }}" alt="brand" class="img-fluid w-100">
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @endif
    <!--=============================
        BRAND SECTION END
    ==============================-->


    <!--=============================
        DOWNLOAD START
    ==============================-->
    @if ($mobile_app->visibility)
    <section class="wsus__download pt_130 pb_125 xs_pt_95 xs_pb_100" style="background: url( {{asset($mobile_app->home1_background)}});">
        <div class="container">
            <div class="row">
                <div class="col-xxl-6 col-xl-7 col-lg-8 ms-auto wow fadeInRight" data-wow-duration="1s">
                    <div class="wsus__download_text">
                        <h2>{!! $mobile_app->title1 !!}</h2>
                        <h2> {{ $mobile_app->title3 }}</h2>
                        <p>
                            {!! $mobile_app->description !!}
                        </p>
                        <ul class="d-flex flex-wrap">
                            <li>
                                <a target="_blank" href="{{ $mobile_app->apple_store_link }}">
                                    <img src="{{ asset('frontend/images/download_icon_1.png') }}" alt="Apple store">
                                </a>
                            </li>
                            <li>
                                <a target="_blank" href="{{ $mobile_app->play_store_link }}">
                                    <img src="{{ asset('frontend/images/download_icon_2.png') }}" alt="Play store">
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
    <!--=============================
        DOWNLOAD END
    ==============================-->


    <!--=============================
        BLOG START
    ==============================-->
    @if ($blog_section->visibility)
    <section class="wsus__blog pt_95">
        <div class="container">
            <div class="row">
                <div class="col-xl-7 m-auto wow fadeInUp" data-wow-duration="1s">
                    <div class="wsus__section_heading mb_25">
                        <h5>{{ $blog_section->title }}</h5>
                        <h2>{{ $blog_section->description }}</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($blog_section->blogs as $blog)
                <div class="col-xl-4 col-md-6 wow fadeInUp" data-wow-duration="1s">
                    <div class="wsus__single_blog">
                        <div class="wsus__single_blog_img">
                            <img src="{{ asset($blog->image) }}" alt="blog" class="img-fluid w-100">
                            <p><span>{{ \Carbon\Carbon::parse($blog->created_at)->format('d') }}</span> {{ \Carbon\Carbon::parse($blog->created_at)->format('F') }}</p>
                        </div>
                        <div class="wsus__single_blog_text">
                            <p> {{__('user.By')}} <a href="#">{{ $blog->admin->name }}</a></p>
                            <a class="title" href="{{ route('blog', $blog->slug) }}">{{ $blog->title }}</a>
                            <a class="view_all" href="{{ route('blog', $blog->slug) }}">{{__('user.See more')}} <i class="far fa-long-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
    <!--=============================
        BLOG END
    ==============================-->
    <!--=============================
        ABOUT PAGE END
    ==============================-->
@endsection
