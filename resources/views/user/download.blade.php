@extends($active_theme)

@section('title')
    <title>{{__('user.Buying product')}}</title>
@endsection

@section('meta')
    <meta name="description" content="{{__('user.Buying product')}}">
@endsection

@section('frontend-content')


    <section class="wsus__profile pt_150">
        <div class="container">
            {{-- start header section --}}
            @include('user.inc.profile_header')
            {{-- end header section --}}

            <div class="row">
                <div class="col-xl-8 col-lg-8">
                    @if ($order_items->count() > 0)
                    <div class="wsus__profile_download mt_40">
                        <h2>{{__('user.Buying Items')}}</h2>
                        @foreach ($order_items as $item)
                        @if ($item->order->order_status == 1)
                        <div class="wsus__download_item wow fadeInUp" data-wow-duration="1s">
                            <div class="wsus__download_item_left">
                                <div class="img">
                                    <img src="{{ asset($item->product->thumbnail_image) }}" alt="download" class="img-fluid w-100">
                                </div>
                                <div class="text">
                                    <a href="{{ route('product-detail', $item->product->slug) }}">{{ html_decode($item->product->name) }}</a>
                                    <p>{{__('user.Item by')}}
                                        @if ($item->author_id != 0)
                                            {{ html_decode($item->author->name) }}
                                        @else
                                            {{ html_decode($item->admin_author->name) }}
                                        @endif


                                    </p>
                                    @if ($item->variant_id!=null)
                                    <p>{{ html_decode($item->variant->variant_name) }}</p>
                                    @endif
                                    @if ($item->price_type!=null)
                                    <p>{{ $item->price_type }}</p>
                                    @endif
                                    <h4>{{ $setting->currency_icon }}{{ html_decode($item->price) }}</h4>
                                </div>
                            </div>
                            <div class="wsus__download_item_right">
                                @if ($item->product_type=='script')
                                        <a class="common_btn" href="{{ route('download-script', $item->product->id) }}">{{__('user.Download File')}}</a>
                                @else
                                    @if ($item->variant)
                                        <a class="common_btn" href="{{ route('download-variant', $item->variant->id) }}">{{__('user.Download File')}}</a>
                                    @endif
                                @endif
                                @php
                                    $review=App\Models\Review::where(['product_id' => $item->product->id, 'status' => 1])->get()->average('rating');
                                @endphp
                                <p data-bs-toggle="modal" data-bs-target="#exampleModal2{{ $item->product->id }}">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </p>
                                <p class="rating" data-bs-toggle="modal" data-bs-target="#exampleModal2{{ $item->product->id }}">
                                    @for ($i = 0; $i < $review; $i++)
                                    <i class="fas fa-star collection-review"></i>
                                    @endfor
                                </p>
                            </div>
                        </div>
                        @endif
                        @endforeach

                        <div class="row">
                            {{ $order_items->links('custom_pagination') }}
                        </div>

                        <!-- rating modal end -->
                        <div class="wsus__rating_moadl_area">
                            @foreach ($order_items as $item)
                            <div class="modal fade" id="exampleModal2{{ $item->product->id }}" tabindex="-1"
                            aria-labelledby="exampleModalLabel2" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel2">{{__('user.Review this Item')}}</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>{{__('user.Your Rating')}}</p>
                                        <p class="rating1">
                                            <i class="far fa-star text-dark s1"></i>
                                            <i class="far fa-star text-dark s2"></i>
                                            <i class="far fa-star text-dark s3"></i>
                                            <i class="far fa-star text-dark s4"></i>
                                            <i class="far fa-star text-dark s5"></i>
                                        </p>
                                        <form id="reviewForm" action="{{ route('product-review') }}" method="POST">
                                            @csrf
                                            <label>{{__('user.Comment')}}*</label>
                                            <input type="hidden" class="star" name="rating" value="">
                                            <input type="hidden" id="product_id" name="product_id" value="{{ $item->product->id }}">
                                            <input type="hidden" id="order_id" name="order_id" value="{{ $item->order->id }}">
                                            @if ($item->product->product_type!='script' && $item->variant)
                                              <input type="hidden" id="variant_id" name="variant_id" value="{{ $item->variant->id }}">
                                            @endif

                                            @if ($item->author_id != 0)
                                                <input type="hidden" id="author_id" name="author_id" value="{{ $item->author->id }}">
                                            @else
                                                <input type="hidden" id="author_id" name="author_id" value="{{ $item->admin_id }}">
                                            @endif


                                            <textarea rows="7" name="review" placeholder="Type your message here"></textarea>
                                            <button type="submit" id="submitBtn" class="common_btn" type="submit">{{__('user.Save Review')}}</button>
                                            <button class="common_btn d-none" id="showSpain"><i class="fas fa-spinner fa-spin"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                            @endforeach
                        </div>
                        <!-- rating modal end -->

                    </div>
                    @else
                    <div class="wsus__profile_download_empty mt_40">
                        <h2>{{__('user.Buying Items')}}</h2>
                        <div class="img">
                            <img src="{{ asset('frontend/images/empty_download.png') }}" alt="empty download" class="img-fluid w-100">
                        </div>
                        <h3>{{__('user.Your download is empty')}}</h3>
                        <a class="common_btn2" href="{{ route('products') }}">{{__('user.Continue to Shopping')}}</a>
                    </div>
                    @endif
                </div>
                {{-- information --}}
                @php
                    $order_item=App\Models\OrderItem::where('author_id', $user->id)->get()->count();
                    $total_product=App\Models\Product::where(['author_id' => $user->id, 'status' => 1])->get()->count();
                    $total_review=App\Models\Review::where(['author_id' => $user->id, 'status' => 1])->get()->count();
                @endphp
                <div class="col-xl-4 col-lg-4 wow fadeInRight" data-wow-duration="1s">
                    <div class="wsus__profile_sidebar">
                        @if ($setting->vendor_type == 'multi')
                        <div class="wsus__profile_sedebar_item wsus__sidebar_buy_info mt_30">
                            <h3>{{__('user.Selling Info')}}</h3>
                            <ul class="info">
                                <li>
                                    <p><i class="fal fa-cart-plus"></i> {{__('user.Total Sale')}}</p>
                                    <span>{{ $order_item }}</span>
                                </li>
                                <li>
                                    <p><i class="far fa-box"></i> {{__('user.Item')}}</p>
                                    <span>{{ $total_product }}</span>
                                </li>
                                <li>
                                    <p><i class="fas fa-star"></i> {{__('user.Item Rating')}}</p>
                                    <span><i class="fas fa-star"></i> ({{ $total_review }})</span>
                                </li>
                            </ul>
                        </div>
                        @endif
                        <div class="wsus__profile_sedebar_item wsus__sidebar_pro_info mt_30">
                            <h3>{{__('user.Personal Info')}}</h3>
                            <ul>
                                <li><span>{{__('user.Country')}}</span> {{ $user->country ? $user->country->name : '' }}</li>
                                <li><span>{{__('user.City')}}</span> {{ $user->country ? $user->city->name : ''}}</li>
                                <li><span>{{__('user.Member Since')}}</span>  {{ Carbon\Carbon::parse($user->created_at)->format('F Y') }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
        PROFILE DOWNLOAD END
    ==============================-->
@endsection
@section('frontend_js')



<script>

    (function($) {
        "use strict";
        $(document).ready(function () {
            $("#contactWithAuthor").on("submit", function(e){
                e.preventDefault();

                var isDemo = "{{ env('APP_MODE') }}"
                if(isDemo == 'DEMO'){
                    toastr.error('This Is Demo Version. You Can Not Change Anything');
                    return;
                }
                 $('#submitBtn').addClass('d-none');
                 $('#showSpain').removeClass('d-none');
                $.ajax({
                    url: "{{ route('contact-with-author') }}",
                    type:"post",
                    data:$('#contactWithAuthor').serialize(),
                    success:function(response){
                        if(response.status == 1){
                            toastr.success(response.message)
                            $("#contactWithAuthor").trigger("reset");
                            $('#submitBtn').removeClass('d-none');
                            $('#showSpain').addClass('d-none');
                        }
                    },
                    error:function(response){
                        if(response.status == 403){
                            toastr.error(response.responseJSON.message);
                            $('#submitBtn').removeClass('d-none');
                            $('#showSpain').addClass('d-none');
                        }else{
                            if(response.responseJSON.errors.email)toastr.error(response.responseJSON.errors.email[0])
                            if(response.responseJSON.errors.message)toastr.error(response.responseJSON.errors.message[0])
                            $('#submitBtn').removeClass('d-none');
                            $('#showSpain').addClass('d-none');
                        }
                    }
                });
            });

            $('.s1').on('click', function(){
                $('.s2, .s3, .s4, .s5').removeClass('fas fa-star text-warning');
                $('.s2, .s3, .s4, .s5').addClass('far fa-star text-dark');
                $('.s1').removeClass('far fa-star text-dark');
                $('.s1').addClass('fas fa-star text-warning');
                $('.star').val('');
                $('.star').val(1);
            });
            $('.s2').on('click', function(){
                $('.s3, .s4, .s5').removeClass('fas fa-star text-warning');
                $('.s3, .s4, .s5').addClass('far fa-star text-dark');
                $('.s1, .s2').removeClass('far fa-star text-dark');
                $('.s1, .s2').addClass('fas fa-star text-warning');
                $('.star').val('');
                $('.star').val(2);
            });
            $('.s3').on('click', function(){
                $('.s4, .s5').removeClass('fas fa-star text-warning');
                $('.s4, .s5').addClass('far fa-star text-dark');
                $('.s1, .s2, .s3').removeClass('far fa-star text-dark');
                $('.s1, .s2, .s3').addClass('fas fa-star text-warning');
                $('.star').val('');
                $('.star').val(3);
            });
            $('.s4').on('click', function(){
                $('.s5').removeClass('fas fa-star text-warning');
                $('.s5').addClass('far fa-star text-dark');
                $('.s1, .s2, .s3, .s4').removeClass('far fa-star text-dark');
                $('.s1, .s2, .s3, .s4').addClass('fas fa-star text-warning');
                $('.star').val('');
                $('.star').val(4);
            });
            $('.s5').on('click', function(){
                $('.s1, .s2, .s3, .s4, .s5').removeClass('far fa-star text-dark');
                $('.s1, .s2, .s3, .s4, .s5').addClass('fas fa-star text-warning');
                $('.star').val('');
                $('.star').val(5);
            });

        });
    })(jQuery);



</script>
@endsection
