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
                    <h1>{{__('user.product page')}}</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{__('user.Home')}}</a></li>
                            <li class="breadcrumb-item">{{__('user.Products')}}</li>
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
        PRODUCT PAGE START
    ==============================-->
    <section class="wsus__product_page pt_100" style="background: url(images/product_page_bg.jpg);">
        <div class="container">
            <div class="row">
                <div class="col-12 wow fadeInUp" data-wow-duration="1s">
                    <div class="wsus__product_page_header d-flex flex-wrap">
                        <form id="search_form">
                            <input type="text" name="search" id="search" value="{{ request()->get('keyword') }}" placeholder="{{__('user.Search your products')}}...">
                            <button class="common_btn2" type="submit"><i class="far fa-search"></i> {{__('user.Search')}}</button>
                        </form>
                        <select class="select_js" id="sorting">
                            <option value="default" {{ request()->get('sorting')=='default'? 'selected':'' }}>{{__('user.Default sorting')}}</option>
                            <option value="script" {{ request()->get('sorting')=='script'? 'selected':'' }}>{{__('user.Script product')}}</option>
                            <option value="image" {{ request()->get('sorting')=='image'? 'selected':'' }}>{{__('user.Image product')}}</option>
                            <option value="video" {{ request()->get('sorting')=='video'? 'selected':'' }}>{{__('user.Video product')}}</option>
                            <option value="audio" {{ request()->get('sorting')=='audio'? 'selected':'' }}>{{__('user.Audio product')}}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-xl-3 wow fadeInLeft" data-wow-duration="1s">
                    <div class="wsus__product_sidebar_filter">
                        <h5>{{__('user.filter')}}</h5>
                        <span>
                            <i class="fas fa-plus plus"></i>
                            <i class="fas fa-minus minus"></i>
                        </span>
                    </div>

                    <div class="wsus__product_sidebar_area">
                        <div class="wsus__product_sidebar categories mt_25">
                            <h3>{{__('user.Categories')}}</h3>
                            <ul>
                                @foreach ($categories as $category)
                                @php
                                    $total_product = App\Models\Product::where(['status' => 1, 'category_id'=>$category->id])->count();
                                @endphp
                                <li><a href="javascript:;" onclick="getCatSlug('{{ $category->slug }}')">{{ $category->name }}<span>({{ $total_product }})</span> </a></li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="wsus__product_sidebar mt_25">
                            <h3>{{__('user.Filter Price')}}</h3>

                            <div id="slider-range" class="price-filter-range"></div>
                            <div class="range_price_area d-flex">
                                <p>{{__('user.Price')}}: <span>{{ $setting->currency_icon }}</span></p>
                                <div class="range_main_price d-flex">
                                    <input type="text" oninput="validity.valid||(value='0');" id="min_price"
                                        class="price-range-field" readonly />
                                    <input type="text" oninput="validity.valid||(value='1000');" id="max_price"
                                        class="price-range-field" readonly />
                                </div>
                            </div>

                            <input type="hidden" id="filter_min_price" name="min_price" value="0">
                            <input type="hidden" id="filter_max_price" name="max_price" value="1000">
                            <input type="hidden" id="get_min_price" value="{{ $min_price }}">
                            <input type="hidden" id="get_max_price" value="{{ $max_price }}">
                            <input type="hidden" id="product_max_price" value="{{ $product_max_price }}">
                            <button class="common_btn2 w-100 mt-3" onclick="priceFilter()" type="submit">{{__('user.Filter')}}</button>

                        </div>
                        @if ($ad->status==1)
                        <div class="wsus__product_sidebar_offer mt_25">
                            <a href="{{ $ad->link }}">
                                <img src="{{ asset($ad->image) }}" alt="offer" class="img-fluid w-100">
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-8 col-xl-9">
                    <div class="row">
                        @forelse ($products as $product)
                        <div class="col-xl-4 col-sm-6 wow fadeInUp" data-wow-duration="1s">
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
                                    </span> {{__('user.In')}} <a class="category" href="javascript:;" onclick="getCatSlug('{{ $product->category->slug }}')">{{ $product->category->name }}</a></p>
                                    <a class="title" href="{{ route('product-detail', $product->slug) }}">{{ html_decode($product->name) }}</a>
                                    <ul class="d-flex flex-wrap justify-content-between">
                                        @php
                                            $review=App\Models\Review::where(['product_id' => $product->id, 'status' => 1])->get()->average('rating');
                                            $sale=App\Models\OrderItem::where(['product_id' => $product->id])->get()->count();
                                        @endphp
                                        <li><span><i class="fas fa-download"></i> {{ $sale }} {{__('user.Sale')}}</span></li>
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
                        @empty
                        <div class="col-12 text-center text-danger mt-5">
                            <h2 class="mt-5">{{__('user.Product Not Found')}}</h2>
                       </div>
                        @endforelse
                    </div>
                    <div class="row">
                        {{ $products->links('custom_pagination') }}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
        PRODUCT PAGE END
    ==============================-->

    <form action="{{ route('products') }}" id="productSearchForm">

        @if (request()->has('sorting'))
        <input type="hidden" name="sorting" value="{{ request()->get('sorting') }}" id="search_sorting">
        @else
        <input type="hidden" name="sorting" value="" id="search_sorting">
        @endif

        @if (request()->has('category'))
            <input type="hidden" name="category" value="{{ request()->get('category') }}" id="search_category_slug">
        @else
            <input type="hidden" name="category" value="" id="search_category_slug">
        @endif


        @if (request()->has('min_price'))
        <input type="hidden" name="min_price" value="{{ request()->get('min_price') }}" id="search_min_price">
        @else
            <input type="hidden" name="min_price" value="" id="search_min_price">
        @endif

        @if (request()->has('max_price'))
            <input type="hidden" name="max_price" value="{{ request()->get('max_price') }}" id="search_max_price">
        @else
            <input type="hidden" name="max_price" value="" id="search_max_price">
        @endif

        @if (request()->has('keyword'))
            <input type="hidden" name="keyword" value="{{ request()->get('keyword') }}" id="keyword">
        @else
            <input type="hidden" name="keyword" value="" id="keyword">
        @endif

    </form>
@endsection
@section('frontend_js')
<script>
    (function($) {
        "use strict";
         $(document).ready(function () {

            $("#sorting").on("change", function(){
                $("#search_sorting").val($(this).val());
                $("#productSearchForm").submit();

            });

            $("#search_form").on("submit", function(e){
                e.preventDefault();

                $("#keyword").val($("#search").val());
                $("#productSearchForm").submit();
            });
        });
    })(jQuery);
    function getCatSlug(slug){
        $("#search_category_slug").val(slug);
        $("#productSearchForm").submit();
    }

    function priceFilter(){
        let filter_min_price = $('#filter_min_price').val();
        let filter_max_price = $('#filter_max_price').val();
        $('#search_min_price').val(filter_min_price);
        $('#search_max_price').val(filter_max_price);
        $("#productSearchForm").submit();
    }
</script>
@endsection
