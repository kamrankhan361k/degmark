<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, target-densityDpi=device-dpi" />
    <meta name="_token" content="{{ csrf_token() }}">
    <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">
    @yield('title')
    @php
        $setting = App\Models\Setting::first();
    @endphp
    <link rel="icon" type="image/png" href="{{ asset($setting->favicon) }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/summernote.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/price_range_ui.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/price_range_style.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/percircle.css') }}">

    <link rel="stylesheet" href="{{ asset('frontend/css/spacing.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/tagify.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap-tagsinput.css') }}">

    @if ($setting->text_direction=='rtl')
    <link rel="stylesheet" href="{{ asset('frontend/css/rtl.css') }}">
    @endif

    <style>
        .tox .tox-promotion,
        .tox-statusbar__branding{
            display: none !important;
        }
    </style>
</head>


<body class="home_3">

    <!--=============================
        HEADER START
    ==============================-->
    <header>
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="wsus__header_content d-flex flex-wrap justify-content-between">
                        <ul class="wsus__header_left d-flex flex-wrap">
                            @php
                                $social_links=App\Models\FooterSocialLink::latest()->get();
                            @endphp
                            <li><a href="{{ route('dashboard') }}">{{__('user.Dashboard')}}</a></li>
                            <li><a href="{{ route('contact-us') }}">{{__('user.Contact')}}</a></li>

                            @if ($setting->vendor_type == 'multi')
                            <li><a href="{{ route('select-product-type') }}">{{__('user.Upload product')}}</a></li>
                            @endif


                        </ul>
                        <ul class="wsus__header_right d-flex flex-wrap">
                            @foreach ($social_links as $link)
                            <li><a href="{{ $link->link }}">{{ $link->text }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!--=============================
        HEADER END
    ==============================-->


    <!--=============================
        MENU 3 START
    ==============================-->
    <nav class="navbar navbar-expand-lg main_menu main_menu_3">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset($setting->logo_three) }}" alt="Degmark" class="img-fluid w-100">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="far fa-bars menu_icon"></i>
                <i class="far fa-times close_icon"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav m-auto">
                    <li class="nav-item">
                        @php
                            if($setting->selected_theme==1){
                               $route = route('home',['theme' => 1]);
                            }else if($setting->selected_theme==2){
                                $route = route('home',['theme' => 2]);
                            }else if($setting->selected_theme==3){
                                $route = route('home',['theme' => 3]);
                            }else if($setting->selected_theme==0){
                                $route = route('home',['theme' => 1]);
                            }
                        @endphp
                        <a class="nav-link {{ Route::is('home') ? 'active':'' }}" href="{{ route('home') }}">
                            {{__('user.Home')}}
                            @if ($setting->selected_theme==0)
                                <i class="fas fa-angle-down"></i>
                            @endif
                        </a>
                        @if ($setting->selected_theme==0)
                        <ul class="wsus__droap_menu">
                            <li><a class="{{ Session::get('selected_theme') == 'theme_one' ? 'active' : '' }}" href="{{ route('home',['theme' => 1]) }}">{{__('user.home one')}}</a></li>
                            <li><a class="{{ Session::get('selected_theme') == 'theme_two' ? 'active' : '' }}" href="{{ route('home',['theme' => 2]) }}">{{__('user.home two')}}</a></li>
                            <li><a class="{{ Session::get('selected_theme') == 'theme_three' ? 'active' : '' }}" href="{{ route('home',['theme' => 3]) }}">{{__('user.home three')}}</a></li>
                        </ul>
                        @endif
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('products') || Route::is('product-detail') ? 'active':'' }}" href="{{ route('products') }}">{{__('user.Products')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('about-us') || Route::is('become-author-page') || Route::is('faq') || Route::is('privacy-policy') || Route::is('terms-and-conditions') ? 'active':'' }}" href="#">{{__('user.Pages')}} <i class="fas fa-angle-down"></i></a>
                        <ul class="wsus__droap_menu">
                            <li><a class="{{ Route::is('about-us') ? 'active':'' }}" href="{{ route('about-us') }}">{{__('user.about us')}}</a></li>
                            @if ($setting->vendor_type == 'multi')
                            <li><a class="{{ Route::is('become-author-page') ? 'active':'' }}" href="{{ route('become-author-page') }}">{{__('user.become an author')}}</a></li>
                            @endif
                            <li><a class="{{ Route::is('faq') ? 'active':'' }}" href="{{ route('faq') }}">{{__('user.FAQ')}}</a></li>
                            <li><a class="{{ Route::is('privacy-policy') ? 'active':'' }}" href="{{ route('privacy-policy') }}">{{__('user.privacy policy')}}</a></li>
                            <li><a class="{{ Route::is('terms-and-conditions') ? 'active':'' }}" href="{{ route('terms-and-conditions') }}">{{__('user.terms and condition')}}</a></li>

                            @php
                                $pages = App\Models\CustomPage::where('status', 1)->get();
                            @endphp
                            @foreach ($pages as $page)
                            <li><a href="{{ route('custom-page', $page->slug) }}">{{ $page->page_name }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('blogs') ? 'active':'' }}" href="{{ route('blogs') }}">{{__('user.Blog')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('contact-us') ? 'active':'' }}" href="{{ route('contact-us') }}">{{__('user.Contact')}}</a>
                    </li>
                </ul>

                <ul class="right_menu right_menu_2 d-flex flex-wrap">
                    <li>
                        <a href="{{ route('cart-view') }}">
                            <img src="{{ asset('frontend') }}/images/menu_cart_icom.png" alt="user" class="img-fluid w-100">
                            <span id="cartQty">0</span>
                        </a>
                    </li>
                    <li>
                        <a class="my_account common_btn" href="{{ route('dashboard') }}"><i class="fas fa-user"></i> {{__('user.my account')}}</a>
                        <ul class="wsus__droap_menu">
                            <li><a href="{{ route('dashboard') }}">{{__('user.My Profile')}}</a></li>
                            <li><a href="{{ route('download') }}">{{__('user.Download')}}</a></li>
                            @if ($setting->vendor_type == 'multi')
                                <li><a href="{{ route('portfolio') }}">{{__('user.Portfolio')}}</a></li>
                            @endif
                            <li><a href="{{ route('collection') }}">{{__('user.Collection')}}</a></li>

                            @if ($setting->vendor_type == 'multi')
                            <li><a href="{{ route('select-product-type') }}">{{__('user.Upload product')}}</a></li>
                            @endif


                            @if (Route::is('dashboard') || Route::is('download') || Route::is('portfolio') || Route::is('collection') || Route::is('withdraw'))
                               <li><a href="#" data-bs-toggle="modal"
                                data-bs-target="#changePassword">{{__('user.Change password')}}</a></li>
                            @endif

                            @if (Auth::guard('web')->check())
                            <li><a href="{{ route('user.logout') }}">{{__('user.Logout')}}</a></li>
                            @else
                            <li><a href="{{ route('login') }}">{{__('user.Login')}}</a></li>
                            @endif
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!--=============================
        MENU 3 END
    ==============================-->

    @yield('frontend-content')

    <!--=============================
        FOOTER START
    ==============================-->
    <footer class="mt_245" style="background: url( {{asset('frontend')}}/images/footer_bg.png);">
        <div class="container">
            <div class="row">
                <div class="col-12 wow fadeInUp" data-wow-duration="1s">
                    @php
                        $footer = App\Models\Footer::first();

                        $item_sold = App\Models\OrderItem::get()->count();

                        $total_earning = App\Models\OrderItem::get()->sum('price');

                        $setting = App\Models\Setting::first();
                    @endphp
                    <div class="wsus__subscribe" style="background: url( {{asset('frontend')}}/images/subscribe_bg3.jpg);">
                        <div class="row">
                            <div class="col-xxl-6 col-xl-8 col-md-8 col-lg-6">
                                <h2>{{ $setting->subscriber_title }}</h2>
                                <p>{{ $setting->subscriber_description }}</p>
                                <form id="fsubscriberForm">
                                    @csrf
                                    <input type="text" name="email" placeholder="Enter your email address">
                                    <button class="common_btn2" id="fsubSubmitBtn" type="submit">{{__('user.Subscribe')}}</button>
                                    <button class="common_btn2 d-none" id="fsubShowSpain"><i class="fas fa-spinner fa-spin"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-between mt_80">
                <div class="col-xl-2 col-md-4">
                    <div class="wsus__footer_content">
                        <a class="footer_logo" href="index.html">
                            <img src="{{ asset($setting->footer_logo_three) }}" alt="degmark" class="img-fluid w-100">
                        </a>
                        <ul>
                            @if ($setting->vendor_type == 'multi')
                                <li><a href="{{ route('register') }}">{{__('user.Become an author')}}</a></li>
                            @endif
                            <li><a href="{{ route('terms-and-conditions') }}">{{__('user.Terms & Conditions')}}</a></li>
                            <li><a href="{{ route('products') }}">{{__('user.Our product')}}</a></li>
                            <li><a href="{{ route('cart-view') }}">{{__('user.Cart page')}}</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4">
                    <div class="wsus__footer_content">
                        <h4>{{ $footer->first_column }}</h4>
                        <ul>
                            <li><a href="{{ route('contact-us') }}">{{__('user.Contact Us')}}</a></li>
                            <li><a href="{{ route('blogs') }}">{{__('user.Our Blog')}}</a></li>
                            <li><a href="{{ route('faq') }}">{{__('user.FAQ')}}</a></li>
                            <li><a href="{{ route('privacy-policy') }}">{{__('user.Privacy Policy')}}</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4">
                    <div class="wsus__footer_content">
                        <h4>{{ $footer->second_column }}</h4>
                        <ul>
                            <li><a href="{{ route('dashboard') }}">{{__('user.My Profile')}}</a></li>
                            <li><a href="{{ route('about-us') }}">{{__('user.About Us')}}</a></li>
                            <li><a href="{{ route('login') }}">{{__('user.Login')}}</a></li>
                            <li><a href="{{ route('register') }}">{{__('user.Registration')}}</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-4 col-md-10">
                    <div class="wsus__footer_counter">
                        <h4>{{__('user.Market Analysis')}}</h4>
                        <p>{{__('user.Save time with preconfigured find to a environments that alreadyintod')}}.</p>
                        <ul class="d-flex flex-wrap">
                            <li>
                                <h5 class="counter">{{ $item_sold }}</h5>
                                <p>{{__('user.Item Sold')}}</p>
                            </li>
                            <li>
                                <h5 class="counter">{{ $total_earning }}</h5>
                                <p>{{__('user.Total Earnings')}}</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="wsus__footer_bottom mt_50">
            <div class="container max-width">
                <div class="row">
                    <div class="col-xl-6 col-lg-6">
                        <div class="wsus__footer_copyright d-flex flex-wrap">
                            <ul class="d-flex flex-wrap">
                                @foreach ($social_links as $link)
                                <li><a href="{{ $link->link }}"><i class="{{ $link->icon }}"></i></a></li>
                                @endforeach
                            </ul>
                            <p>{{ $footer->copyright }}</p>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6">
                        <div class="wsus__footer_payment d-flex flex-wrap">
                            <p><a href="{{ $footer->community_link }}" class="text-light">{{ $footer->community }}</a> <i class="far fa-angle-right"></i></p>
                            <div class="img">
                                <img src="{{ asset($footer->payment_image) }}" alt="payment gateway" class="img-fluid w-100">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!--=============================
        FOOTER END
    ==============================-->


    <!--============================
        SCROLL BUTTON START
    =============================-->
    <div class="wsus__scroll_btn">
        <span><i class="fas fa-arrow-alt-up"></i></span>
    </div>
    <!--============================
        SCROLL BUTTON END
    =============================-->


    <!--jquery library js-->
    <script src="{{ asset('frontend/js/jquery-3.7.0.min.js') }}"></script>
    <!--bootstrap js-->
    <script src="{{ asset('frontend/js/bootstrap.bundle.min.js') }}"></script>
    <!--font-awesome js-->
    <script src="{{ asset('frontend/js/Font-Awesome.js') }}"></script>
    <!--counter up js-->
    <script src="{{ asset('frontend/js/jquery.countup.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.waypoints.min.js') }}"></script>
    <!--nice select js-->
    <script src="{{ asset('frontend/js/jquery.nice-select.min.js') }}"></script>
    <!--slick slider js-->
    <script src="{{ asset('frontend/js/slick.min.js') }}"></script>
    <!--sticky sidebar js-->
    <script src="{{ asset('frontend/js/sticky_sidebar.js') }}"></script>
    <!--summer note js-->
    <script src="{{ asset('frontend/js/summernote.min.js') }}"></script>
    <!--wow js-->
    <script src="{{ asset('frontend/js/wow.min.js') }}"></script>
    <!--price renger js-->
    <script src="{{ asset('frontend/js/price_range_ui.min.js') }}"></script>
    <script src="{{ asset('frontend/js/price_range_script.js') }}"></script>
    <!--precircle js-->
    <script src="{{ asset('frontend/js/percircle.js') }}"></script>

    <!--main/custom js-->
    <script src="{{ asset('frontend/js/main.js') }}"></script>
    <script src="{{ asset('frontend/js/cart.js') }}"></script>
    <script src="{{ asset('toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('backend/js/select2.min.js') }}"></script>
    <script src="{{ asset('frontend/js/tagify.js') }}"></script>
    <script src="{{ asset('frontend/js/bootstrap-tagsinput.min.js') }}"></script>
    <script src="{{ asset('backend/tinymce/js/tinymce/tinymce.min.js') }}"></script>
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <script>
        @if(Session::has('messege'))
        var type="{{Session::get('alert-type','info')}}"
        switch(type){
            case 'info':
                toastr.info("{{ Session::get('messege') }}");
                break;
            case 'success':
                toastr.success("{{ Session::get('messege') }}");
                break;
            case 'warning':
                toastr.warning("{{ Session::get('messege') }}");
                break;
            case 'error':
                toastr.error("{{ Session::get('messege') }}");
                break;
        }
        @endif
    </script>
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <script>
                toastr.error('{{ $error }}');
            </script>
        @endforeach
    @endif

    @yield('frontend_js')

    <script>
        (function($) {
            "use strict";
            $(document).ready(function () {

                $("#country_id").on("change",function(){
                    var countryId = $("#country_id").val();
                    if(countryId){
                        $.ajax({
                            type:"get",
                            url:"{{url('/state-by-country/')}}"+"/"+countryId,
                            success:function(response){
                                $("#state_id").html(response.states);
                            },
                            error:function(err){

                            }
                        })
                    }else{
                        var response= "<option value=''>{{__('user.Select a State')}}</option>";
                        $("#state_id").html(response);
                    }

                })

                $("#fsubscriberForm").on('submit', function(e){
                    e.preventDefault();
                    $('#fsubShowSpain').removeClass('d-none');
                    $('#fsubSubmitBtn').addClass('d-none');
                    var isDemo = "{{ env('APP_MODE') }}"
                    if(isDemo == 'DEMO'){
                        toastr.error('This Is Demo Version. You Can Not Change Anything');
                        return;
                    }

                    let loading = "{{__('user.Processing...')}}"

                    $("#fsubscribe_btn").html(loading);
                    $("#fsubscribe_btn").attr('disabled',true);

                    $.ajax({
                        type: 'POST',
                        data: $('#fsubscriberForm').serialize(),
                        url: "{{ route('subscribe-request') }}",
                        success: function (response) {
                            if(response.status == 1){
                                toastr.success(response.message);
                                let subscribe = "{{__('user.Subscribe')}}"
                                $("#fsubscribe_btn").html(subscribe);
                                $("#fsubscribe_btn").attr('disabled',false);
                                $("#fsubscriberForm").trigger("reset");
                                $('#fsubShowSpain').addClass('d-none');
                                $('#fsubSubmitBtn').removeClass('d-none');
                            }

                            if(response.status == 0){
                                toastr.error(response.message);
                                let subscribe = "{{__('user.Subscribe')}}"
                                $("#fsubscribe_btn").html(subscribe);
                                $("#fsubscribe_btn").attr('disabled',false);
                                $("#fsubscriberForm").trigger("reset");
                                $('#fsubShowSpain').addClass('d-none');
                                $('#fsubSubmitBtn').removeClass('d-none');
                            }
                        },
                        error: function(err) {
                            $('#fsubShowSpain').addClass('d-none');
                            $('#fsubSubmitBtn').removeClass('d-none');
                            toastr.error('Something went wrong');
                            let subscribe = "{{__('user.Subscribe')}}"
                            $("#fsubscribe_btn").html(subscribe);
                            $("#fsubscribe_btn").attr('disabled',false);
                            $("#fsubscriberForm").trigger("reset");
                        }
                    });
                });

                $('.select2').select2();

                tinymce.init({
                    selector: '#editor',
                    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed linkchecker a11ychecker tinymcespellchecker permanentpen powerpaste advtable advcode editimage tinycomments tableofcontents footnotes mergetags autocorrect typography inlinecss',
                    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
                    tinycomments_mode: 'embedded',
                    tinycomments_author: 'Author name',
                    mergetags_list: [
                        { value: 'First.Name', title: 'First Name' },
                        { value: 'Email', title: 'Email' },
                    ]
                });

            });
        })(jQuery);
    </script>
    <script>
        "use strict";
            function addWishlist(product_id){
                $.ajax({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type:"POST",
                    url:"{{ url('/add/wishlist/') }}/"+product_id,
                    dataType:'json',
                    success:function(response){
                        if(response.success){
                            toastr.success(response.success);
                        }else{
                            toastr.error(response.error);
                        }
                    }
                })
            };

        //add to cart function start
        function addToCard(product_id){
            let product_type=$('#product_type').val();
            let regular_price = $('#regular_price').text();
            let extend_price = $('#extend_price').text();
            let price = $('#price').text();
            let variant_id = $('#variant_id option:selected').val();
            let variant_name = $('#variant_id option:selected').text();
            let price_type = $('#price_type option:selected').val();
            let product_name = $('#product_name').val();
            let category_name = $('#category_name').val();
            let slug = $('#slug').val();
            let category_id = $('#category_id').val();
            let product_image = $('#product_image').val();
            let author_name = $('#author_name').val();
            let author_id = $('#author_id').val();
            $.ajax({
                headers: {
                'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                },
                type:"POST",
                dataType:"json",
                data:{
                    product_type:product_type,
                    regular_price:regular_price,
                    extend_price:extend_price,
                    price:price,
                    variant_id:variant_id,
                    variant_name:variant_name,
                    price_type:price_type,
                    product_name:product_name,
                    slug:slug,
                    category_name:category_name,
                    category_id:category_id,
                    product_image:product_image,
                    author_name:author_name,
                    author_id:author_id,
                },
                url: "{{ url('/add-to-cart') }}" + "/" + product_id,
                success:function(response){
                    miniCart();
                    if(response.status == 1){
                        toastr.success(response.message);
                    }
                    if(response.status == 0){
                        toastr.error(response.message);
                    }
                }
            });
        };
    //add to cart function end
    //mini cart function start
        function miniCart(){
            $.ajax({
                type:"GET",
                dataType:"json",
                url: "{{ url('/mini-cart') }}",
                success:function(response){
                    $('#cartQty').text(response.cartQty);
                }
            });
        }
        miniCart();
        //mini cart function end

        //cart item  function start
        function cartItem(){
            $.ajax({
                type:"GET",
                dataType:"json",
                url: "{{ url('/cart-item') }}",
                success:function(response){
                    let cartItem="";
                    $('#cartTotal').text(response.cartTotal);
                    $.each(response.carts, function(key, value){
                        cartItem+=`<tr>
                                    <td class="img">
                                        <a href="{{ url('/product/${value.options.slug}') }}">
                                            <img src="${ value.options.image }" alt="cart item"
                                                class="img-fluid w-100">
                                        </a>
                                    </td>
                                    <td class="description">
                                        <h3><a href="{{ url('/product/${value.options.slug}') }}">${value.name}</a></h3>
                                        <p>
                                        <span>{{__('Item by')}}</span> ${value.options.author}
                                        <b class="${value.options.variant_name!=null?'':'d-none'}">${value.options.variant_name!=null?value.options.variant_name:''}</b>
                                        <b class="${value.options.price_type!=null?'':'d-none'}">${value.options.price_type!=null?value.options.price_type:''}</b>
                                    </p>
                                    </td>
                                    <td class="price">
                                        <p>${response.setting.currency_icon+value.price}</p>
                                    </td>
                                    <td class="discount">
                                        <p style="text-transform:capitalize">${value.options.category}</p>
                                    </td>
                                    <td class="action">
                                        <a href="javascript:;" id="${value.rowId}" onclick="cartRemove(this.id)"><i class="far fa-times"></i></a>
                                    </td>
                            </tr>`;
                    });
                    $('#cartItem').html(cartItem);
                }
            });
        }
        cartItem();

        function cartRemove(rowId){
            $.ajax({
                type:"GET",
                dataType:"json",
                url: "{{ url('/cart-remove') }}"+ "/" + rowId,
                success:function(response){
                    miniCart();
                    cartItem();
                    couponCalculation();
                    if(response.status == 1){
                        toastr.success(response.message);
                    }
                }
            });
        };
        //cart item function end
       //coupon section start
        function couponApply(){
            let coupon_name=$('#coupon_name').val();
            if(coupon_name){
                $.ajax({
                    headers: {
                    'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                    },
                    type:"POST",
                    dataType:"json",
                    data:{
                        coupon_name:coupon_name,
                    },
                    url: "{{ url('/coupon-apply') }}",
                    success:function(response){
                        if(response.status == 1){
                            $('#coupon_name').val('');
                            couponCalculation();
                            toastr.success(response.message);
                        }
                        if(response.status == 0){
                            $('#coupon_name').val('');
                            toastr.error(response.message);
                        }
                    }
                });
            }else{
            toastr.error('Coupon is required');
            }
        };

        function couponCalculation(){
            $.ajax({
               type:"GET",
               url: "{{ url('/coupon-calculation') }}",
               dataType:'json',
               success:function(data){
                if(data.total){
                    $('#calprice').html(`
                        <p class="subtotal">{{__('user.subtotal')}} <span>${data.setting.currency_icon}<span id="cartTotal">${data.total}</span></span></p>
                        <p class="discount">{{__('user.Discount')}} <span>(-)${data.setting.currency_icon} 0</span></p>
                        <p class="total">{{__('user.Total')}} <span><span>${data.setting.currency_icon}<span>${data.total}</span></span></p>
                        <a class="common_btn" href="{{ route('checkout') }}">{{__('user.Proceed to Checkout')}}</a>
                    `);
                }else{
                    $('#calprice').html(`
                        <p class="subtotal">{{__('user.subtotal')}} <span>${data.setting.currency_icon}<span id="cartTotal">${data.sub_total}</span></span></p>
                        <p class="subtotal">{{__('user.coupon')}} <span>${data.coupon_name} <button type="submit" class="btn btn-danger btn-sm" onclick="couponRemove()"><i class="fa fa-times"></i></button></span></p>
                        <p class="discount">{{__('user.Discount')}} <span>(-)${data.setting.currency_icon} ${data.discount_amount}</span></p>
                        <p class="total">{{__('user.Total')}} <span>${data.setting.currency_icon}${data.total_amount}</span></p>
                        <a class="common_btn" href="{{ route('checkout') }}">{{__('user.Proceed to Checkout')}}</a>
                    `);
                }
            }
         });
        };
        couponCalculation();
        function couponRemove(){
            $.ajax({
               type:"GET",
               url: "{{ url('/coupon-remove') }}",
               dataType:'json',
               success:function(response){
                 $('#coupon_name').val('');
                couponCalculation();
                if(response.status == 1){
                    toastr.success(response.message);
                }
            }
         });
        }
        //coupon section end
    </script>
</body>

</html>
