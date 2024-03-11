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
                    <h1>{{__('user.Our Blogs')}}</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{__('user.Home')}}</a></li>
                            <li class="breadcrumb-item">{{__('user.Blogs')}}</li>
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
        BLOG PAGE START
    ==============================-->
    <section class="wsus__blog_page pt_75">
        <div class="container">
            <div class="row">
                @forelse ($blogs as $blog)
                <div class="col-xl-4 col-md-6 wow fadeInUp" data-wow-duration="1s">
                    <div class="wsus__single_blog">
                        <div class="wsus__single_blog_img">
                            <img src="{{ asset($blog->image) }}" alt="blog" class="img-fluid w-100">
                            <p><span>{{ \Carbon\Carbon::parse($blog->created_at)->format('d') }}</span> {{ \Carbon\Carbon::parse($blog->created_at)->format('F') }}</p>
                        </div>
                        <div class="wsus__single_blog_text">
                            <p>{{__('user.By')}} <a href="javascript:;">{{ $blog->admin->name }}</a></p>
                            <a class="title" href="{{ route('blog', $blog->slug) }}">{{ $blog->title }}</a>
                            <a class="view_all" href="{{ route('blog', $blog->slug) }}">{{__('user.See more')}} <i class="far fa-long-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center text-danger">
                     <h2>{{__('user.Blog Not Found')}}</h2>
                </div>
                @endforelse
            </div>
            <div class="row">
                {{ $blogs->links('custom_pagination') }}
            </div>
        </div>
    </section>
    <!--=============================
        BLOG PAGE END
    ==============================-->
@endsection
