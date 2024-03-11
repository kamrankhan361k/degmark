@extends($active_theme)

@section('title')
    <title>{{__('user.Become author')}}</title>
@endsection
@section('frontend-content')


    <!--=============================
        BECOME AUTHOR START
    ==============================-->
    <section class="wsus__become_author pt_150">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="wsus__author_header">
                        <h1 class="wow fadeInLeft" data-wow-duration="1s">{{ $become_author->title }}</h1>
                        <a class="common_btn wow fadeInRight" data-wow-duration="1s" href="{{ route('register') }}">{{__('user.Become an Author')}}</a>

                        <div class="background_animi_area author_bg_animi">
                            <ul class="bg_animation">
                                <li class="wow bounceIn" data-wow-duration=" 1000ms"></li>
                                <li class="wow bounceIn" data-wow-duration=" 1100ms"></li>
                                <li class="wow bounceIn" data-wow-duration=" 1200ms"></li>
                                <li class="wow bounceIn" data-wow-duration=" 1300ms"></li>
                                <li class="wow bounceIn" data-wow-duration=" 1400ms"></li>
                                <li class="wow bounceIn" data-wow-duration=" 1500ms"></li>
                                <li class="wow bounceIn" data-wow-duration=" 1600ms"></li>
                                <li class="wow bounceIn" data-wow-duration=" 1700ms"></li>
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
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="wsus__author_benefits_area pt_230 pb_70">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-duration="1s">
                        <div class="wsus__author_benefits">
                            <div class="img">
                                <img src="{{ asset($become_author->icon1) }}" alt="icon" class="img-fluid w-100">
                            </div>
                            <h3>{{ $become_author->item1 }}</h3>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-duration="1s">
                        <div class="wsus__author_benefits">
                            <div class="img">
                                <img src="{{ asset($become_author->icon2) }}" alt="icon" class="img-fluid w-100">
                            </div>
                            <h3>{{ $become_author->item2 }}</h3>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-duration="1s">
                        <div class="wsus__author_benefits">
                            <div class="img">
                                <img src="{{ asset($become_author->icon3) }}" alt="icon" class="img-fluid w-100">
                            </div>
                            <h3>{{ $become_author->item3 }}</h3>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-duration="1s">
                        <div class="wsus__author_benefits">
                            <div class="img">
                                <img src="{{ asset($become_author->icon4) }}" alt="icon" class="img-fluid w-100">
                            </div>
                            <h3>{{ $become_author->item4 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="wsus__author_about pt_100 pb_100">
            <div class="container">
                <div class="row justify-content-between">
                    <div class="col-xl-5 col-lg-6 wow fadeInLeft" data-wow-duration="1s">
                        <div class="wsus__about_img">
                            <img src="{{ asset($become_author->image) }}" alt="about us" class="img-fluid w-100">
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 wow fadeInRight" data-wow-duration="1s">
                        <div class="wsus__about_text">
                            <h2>{!! strip_tags(clean($become_author->header1),'<span>') !!}</h2>

                            {!! clean($become_author->description) !!}

                            <a class="common_btn2" href="{{ route('contact-us') }}">{{__('user.Contact us')}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if ($our_teams->count()>0)
        <div class="wsus__team pb_95" style="background: url(images/team_bg.jpg);">
            <div class="container">
                <div class="row">
                    <div class="col-xl-7 m-auto wow fadeInUp" data-wow-duration="1s">
                        <div class="wsus__section_heading mb_25">
                            <h5>{{__('user.Save time with pre-installed software')}}.</h5>
                            <h2>{{__('user.Meet Our Expertise Team')}}</h2>
                        </div>
                    </div>
                </div>
                <div class="row team_slider">
                    @foreach ($our_teams as $our_team)
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
        <div class="wsus__categories author_categories pt_95 pb_245">
            <div class="container">
                <div class="row">
                    <div class="col-xl-7 m-auto wow fadeInUp" data-wow-duration="1s">
                        <div class="wsus__section_heading mb_25">
                            <h5>{{ $category_header->title }}</h5>
                            <h2>{{ $category_header->description }}</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach ($categories as $key=>$category)
                    <div class="col wow fadeInUp" data-wow-duration="1s">
                        <div class="wsus__categories_item">
                            <div class="icon">
                                <img src="{{ asset($category->icon) }}" alt="category" class="img-fluid w-100">
                            </div>
                            <h3>{{ $category->name }}</h3>
                            <a class="view_all" href="{{ route('products', ['category'=>$category->slug]) }}">{{__('user.View All')}} <i class="far fa-long-arrow-right"></i></a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

    </section>
    <!--=============================
        BECOME AUTHOR END
    ==============================-->
@endsection
