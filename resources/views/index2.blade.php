
@extends('layout2')
@section('title')
    <title>{{ $seo_setting->seo_title }}</title>
    <meta name="title" content="{{ $seo_setting->seo_title }}">
    <meta name="description" content="{{ $seo_setting->seo_description }}">
@endsection

@section('frontend-content')

    <!--=============================
        BANNER 2 START
    ==============================-->
    @if ($intro_visibility)
    <section class="wsus__banner wsus__banner_2" style="background: url({{ asset('frontend/images/banner_bg_2.jpg') }});">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 wow fadeInLeft" data-wow-duration="1s">
                    <div class="wsus__banner_text">
                        <h1>{{ $intro_section->content->home2_title  }}</h1>
                        <p>{{ $intro_section->content->home2_description  }}</p>
                        <form action="{{ route('products') }}" method="GET">
                            <select class="select_js" name="category">
                                <option value="">{{__('user.All Categories')}}</option>
                                @foreach ($intro_section->categories as $category)
                                    <option value="{{ $category->slug }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <input type="text" name="keyword" placeholder="{{__('user.Search your products')}}...">
                            <button class="common_btn2" type="submit"><i class="far fa-search"></i> {{__('user.Search')}}</button>
                        </form>
                        <ul class="wsus__banner_counter d-flex flex-wrap mt_20">
                            <li>
                                <span class="counter">{{ $intro_section->content->total_product }}</span>
                                <span>{{__('user.k')}}+</span>
                                {{__('user.Prodcuts')}}
                            </li>
                            <li>
                                <span class="counter">{{ $intro_section->content->total_user }}</span>
                                <span>{{__('user.k')}}+</span>
                                {{__('user.Users')}}
                            </li>
                            <li>
                                <span class="counter">{{ $intro_section->content->total_sold }}</span>
                                <span>+</span>
                                {{__('user.Million Sells')}}
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-6 wow fadeInRight" data-wow-duration="1s">
                    <div class="wsus__banner_img">
                        <div class="img">
                            <img src="{{ asset($intro_section->content->home2_image) }}" alt="banner" class="img-fluid w-100">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
    <!--=============================
        BANNER 2 END
    ==============================-->


    <!--=============================
        CATEGORIES START
    ==============================-->
    @if ($category_visibility)
    <section class="wsus__categories wsus__categories_2 pt_95 pb_100">
        <div class="container">
            <div class="row">
                <div class="col-xl-7 m-auto wow fadeInUp" data-wow-duration="1s">
                    <div class="wsus__section_heading mb_25">
                        <h5>{{ $category_section->title }}</h5>
                        <h2>{{ $category_section->description }}</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($category_section->categories as $key=>$category)
                <div class="col-xl-2 col-sm-6 col-md-4 col-lg-3 wow fadeInUp" data-wow-duration="1s">
                    <div class="wsus__categories_item">
                        <div class="icon">
                            <img src="{{ asset($category->icon) }}" alt="category" class="img-fluid w-100">
                        </div>
                        <h3>{{ $category->name }}</h3>
                        <a class="view_all" href="{{ route('products', ['category' => $category->slug]) }}">{{__('user.View All')}} <i class="far fa-long-arrow-right"></i></a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
    <!--=============================
        CATEGORIES END
    ==============================-->


    <!--=============================
        GALLERY START
    ==============================-->
    @if ($product_section->visibility)
    <section class="wsus__galley pt_95 pb_100" style="background: url( {{asset('frontend/images/gallery_bg.png')}});">
        <div class="container">
            <div class="row">
                <div class="col-xl-7 m-auto wow fadeInUp" data-wow-duration="1s">
                    <div class="wsus__section_heading mb_25">
                        <h5>{{ $product_section->title }}</h5>
                        <h2>{{ $product_section->description }}</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($product_section->products as $product)
                <div class="col-xl-3 col-sm-6 col-lg-4 wow fadeInUp" data-wow-duration="1s">
                    <div class="wsus__gallery_item">
                        <div class="wsus__gallery_item_img">
                            <img src="{{ asset($product->thumbnail_image) }}" alt="gallery" class="img-fluid w-100">
                            <p><span>{{ $setting->currency_icon }}</span>{{ html_decode($product->regular_price) }}</p>
                            <ul class="wsus__gallery_item_overlay">
                                <li><a target="__blank" href="{{ $product->preview_link }}">{{__('user.Preview')}}</a></li>
                                <li><a href="{{ route('product-detail', $product->slug) }}">{{__('user.Buy Now')}}</a></li>
                            </ul>
                        </div>
                        <div class="wsus__gallery_item_text">
                            <p>{{__('user.By')}} <span>
                                @if ($product->author_id != 0)
                                    {{ html_decode($product->author->name) }}
                                @else
                                    {{ html_decode($product->admin_author->name) }}
                                @endif
                            </span> {{__('user.In')}} <a class="category" href="{{ route('products', ['category' => $product->category->slug]) }}">{{ $product->category->name }}</a></p>
                            <a class="title" href="{{ route('product-detail', $product->slug) }}">{{ html_decode($product->name) }}</a>
                            <ul class="d-flex flex-wrap justify-content-between">
                                @php
                                    $review=App\Models\Review::where(['product_id' => $product->id, 'status' => 1])->get()->average('rating');
                                    $sale=App\Models\OrderItem::where(['product_id' => $product->id])->get()->count();
                                @endphp
                                <li><span><i class="fas fa-download"></i> {{ $sale }} {{__('user.Sale')}}</s></li>
                                <li>
                                    <p>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                    </p>
                                    <p class="product-review">
                                        @for ($i = 0; $i < $review; $i++)
                                        <i class="fas fa-star"></i>
                                        @endfor
                                    </p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                @endforeach
                <div class="col-12 mt_40 text-center">
                    <a class="common_btn" href="{{ route('products') }}">{{__('user.view all')}}</a>
                </div>
            </div>
        </div>
    </section>
    @endif
    <!--=============================
        GALLERY END
    ==============================-->


    <!--=============================
        COUNTER 2 START
    ==============================-->
    @if ($counter_section->visibitliy)
    <section class="wsus__counter_2">
        <div class="wsus__single_counter2_area pt_100 pb_250" style="background: url( {{asset($counter_section->home1_background)}});">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-md-6 col-lg-4 wow fadeInLeft" data-wow-duration="1s">
                        <div class="wsus__single_counter2">
                            <div id="bluecircle" data-percent="{{ $counter_section->value1 }}" class="red big"></div>
                            <h4>{{ $counter_section->title1 }}</h4>
                            <p>{{ $counter_section->description1 }}</p>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 col-lg-4 wow fadeInUp" data-wow-duration="1s">
                        <div class="wsus__single_counter2">
                            <div id="bluecircle" data-percent="{{ $counter_section->value2 }}" class="pink big"></div>
                            <h4>{{ $counter_section->title2 }}</h4>
                            <p>{{ $counter_section->description2 }}</p>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 col-lg-4 wow fadeInRight" data-wow-duration="1s">
                        <div class="wsus__single_counter2">
                            <div id="bluecircle" data-percent="{{ $counter_section->value3 }}" class="orange big"></div>
                            <h4>{{ $counter_section->title3 }}</h4>
                            <p>{{ $counter_section->description3 }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="wsus__single_counter2_text_area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 wow fadeInUp" data-wow-duration="1s">
                        <div class="wsus__single_counter2_text">
                            <h3>{{ $counter_section->counter_item1_title }}</h3>
                            <p>{{ $counter_section->counter_item1_description }}</p>
                            <a class="common_btn color_yellow" href="{{ $counter_section->counter_item1_link }}">{{__('user.Buy Goods')}}</a>
                            <span class="icon">
                                <img src="{{ asset( $counter_section->counter_item1_icon ) }}" alt="buy Goods" class="img-fluid w-100">
                            </span>
                        </div>
                    </div>
                    <div class="col-lg-6 wow fadeInUp" data-wow-duration="1s">
                        <div class="wsus__single_counter2_text">
                            <h3>{{ $counter_section->counter_item2_title }}</h3>
                            <p>{{ $counter_section->counter_item2_description }}</p>
                            <a class="common_btn" href="{{ $counter_section->counter_item2_link }}">{{__('user.Buy Goods')}}</a>
                            <span class="icon">
                                <img src="{{ asset( $counter_section->counter_item2_icon ) }}" alt="buy Goods" class="img-fluid w-100">
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
    <!--=============================
        COUNTER 2 END
    ==============================-->


    <!--=============================
        RECENT PRODUCT 2 START
    ==============================-->
    @if ($popular_trending->visibility)
    <section class="wsus__recent_product wsus__recent_product_2 pt_95 pb_100">
        <div class="container">
            <div class="row">
                <div class="col-xl-7 col-lg-6 wow fadeInLeft" data-wow-duration="1s">
                    <div class="wsus__section_heading heading_left mb_5">
                        <h5>{{ $popular_trending->title }}</h5>
                        <h2>{{ $popular_trending->description }}</h2>
                    </div>
                </div>
                <div class="col-xl-5 col-lg-6 wow fadeInRight" data-wow-duration="1s">
                    <div class="wsus__recent_product_filter d-flex flex-wrap">
                        <ul class="nav nav-pills" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                                    aria-selected="true"><i class="fas fa-magic"></i> {{__('user.Popular')}}</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-profile" type="button" role="tab"
                                    aria-controls="pills-profile" aria-selected="false"><i class="fas fa-bolt"></i>
                                    {{__('user.Tranding')}}</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-contact" type="button" role="tab"
                                    aria-controls="pills-contact" aria-selected="false"><i class="far fa-bars"></i>
                                    {{__('user.New Items')}}</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row mt_20 wow fadeInUp" data-wow-duration="1s">
                <div class="col-12">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                            aria-labelledby="pills-home-tab" tabindex="0">
                            <div class="row">
                                @foreach ($popular_trending->popular_products as $popular_product)
                                <div class="col-xl-4 col-lg-6">
                                    <div class="wsus__recent_product_2_item">
                                        <div class="img">
                                            <img src="{{ asset($popular_product->product_icon) }}" alt="product" class="img-fluid w-100">
                                        </div>
                                        <div class="text">
                                            <a href="{{ route('product-detail', $popular_product->slug) }}">{{ $popular_product->name }}</a>
                                            <p>{{ $setting->currency_icon }}{{ $popular_product->regular_price }}</p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                            aria-labelledby="pills-profile-tab" tabindex="0">
                            <div class="row">
                                @foreach ($popular_trending->trending_products as $trending_product)
                                <div class="col-xl-4 col-lg-6">
                                    <div class="wsus__recent_product_2_item">
                                        <div class="img">
                                            <img src="{{ asset($trending_product->product_icon) }}" alt="product" class="img-fluid w-100">
                                        </div>
                                        <div class="text">
                                            <a href="{{ route('product-detail', $trending_product->slug) }}">{{ $trending_product->name }}</a>
                                            <p>{{ $setting->currency_icon }}{{ $trending_product->regular_price }}</p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                            aria-labelledby="pills-contact-tab" tabindex="0">
                            <div class="row">
                                @foreach ($popular_trending->new_products as $new_product)
                                <div class="col-xl-4 col-lg-6">
                                    <div class="wsus__recent_product_2_item">
                                        <div class="img">
                                            <img src="{{ asset($new_product->product_icon) }}" alt="product" class="img-fluid w-100">
                                        </div>
                                        <div class="text">
                                            <a href="{{ route('product-detail', $new_product->slug) }}">{{ $new_product->name }}</a>
                                            <p>{{ $setting->currency_icon }}{{ $new_product->regular_price }}</p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
    <!--=============================
        RECENT PRODUCT 2 END
    ==============================-->


    <!--=============================
        DOWNLOAD START
    ==============================-->
    @if ($mobile_app->visibility)
    <section class="wsus__download pt_50 pb_50" style="background: url( {{asset($mobile_app->home2_background)}});">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 wow fadeInLeft" data-wow-duration="1s">
                    <div class="wsus__download_text">
                        <h2>{!! $mobile_app->title1 !!}</h2>
                        <h2> {{ $mobile_app->title3 }}</h2>
                        <p>
                            {!! $mobile_app->description !!}
                        </p>
                        <ul class="d-flex flex-wrap">
                            <li>
                                <a href="{{ $mobile_app->apple_store_link }}">
                                    <img src="{{ asset('frontend/images/download_icon_1.png') }}" alt="Apple store">
                                </a>
                            </li>
                            <li>
                                <a href="{{ $mobile_app->play_store_link }}">
                                    <img src="{{ asset('frontend/images/download_icon_2.png') }}" alt="Play store">
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-5 wow bounceIn" data-wow-duration="1s">
                    <div class="wsus__download_img_2">
                        <img src="{{ asset('frontend/images/download_img_2.png') }}" alt="Download">
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
        WHU CHOOSE 2 START
    ==============================-->
    @if ($why_choose_us->visibility)
    <section class="wsus__why_choose wsus__why_choose_2 pt_95 pb_100"
        style="background: url( {{asset('frontend')}}/images/why_choose_bg2.png);">
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
                <div class="col-md-4 wow fadeInLeft" data-wow-duration="1s">
                    <div class="wsus__why_choose_item">
                        <div class="img">
                            <img src="{{ asset($why_choose_us->icon1) }}" alt="why choose" class="img-fluid w-100">
                        </div>
                        <h4>{{ $why_choose_us->item_title1 }}</h4>
                    </div>
                </div>
                <div class="col-md-4 wow fadeInLeft" data-wow-duration="1s">
                    <div class="wsus__why_choose_item">
                        <div class="img">
                            <img src="{{ asset($why_choose_us->icon2) }}" alt="why choose" class="img-fluid w-100">
                        </div>
                        <h4>{{ $why_choose_us->item_title2 }}</h4>
                    </div>
                </div>
                <div class="col-md-4 wow fadeInLeft" data-wow-duration="1s">
                    <div class="wsus__why_choose_item last">
                        <div class="img">
                            <img src="{{ asset($why_choose_us->icon3) }}" alt="why choose" class="img-fluid w-100">
                        </div>
                        <h4>{{ $why_choose_us->item_title3 }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
    <!--=============================
       WHU CHOOSE 2 END
    ==============================-->


    <!--=============================
        OFFER 2 START
    ==============================-->
    @if ($special_offer->visibility)
    <section class="wsus__offer wsus__offer_2 pt_90 pb_90" style="background: url( {{asset($special_offer->home2_background)}});">
        <div class="container">
            <div class="row">
                <div class="col-xl-7 m-auto wow fadeInUp" data-wow-duration="1s">
                    <div class="wsus__offer_text text-center">
                        <h2><span>{{ $special_offer->title1 }}</span> {{ $special_offer->title2 }}</h2>
                        <a class="common_btn" href="{{ $special_offer->link }}">{{__('user.Go to Offer page')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
    <!--=============================
        OFFER 2 END
    ==============================-->


    <!--=============================
        BLOG 2 START
    ==============================-->
    @if ($blog_section->visibility)
    <section class="wsus__blog wsus__blog_2 pt_95">
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
                            <a class="view_all" href="{{ route('blog', $blog->slug) }}">{{__('user.See More')}} <i class="far fa-long-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
    <!--=============================
        BLOG 2 END
    ==============================-->
@endsection
