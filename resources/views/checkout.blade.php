@extends($active_theme)

@section('title')
    <title>{{__('user.Checkout')}}</title>
@endsection

@section('meta')
    <meta name="description" content="{{__('user.Checkout')}}">
@endsection

@section('frontend-content')

    <!--=============================
        BREADCRUMB START
    ==============================-->
    <section class="wsus__breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <h1>{{__('user.checkout')}}</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{__('user.Home')}}</a></li>
                            <li class="breadcrumb-item">{{__('user.Checkout')}}</li>
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
        CHECKOUT START
    ==============================-->
    <section class="wsus__checkout pt_100">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 col-lg-7">
                    <div class="wsus__checkout_text mt_40 wow fadeInUp" data-wow-duration="1s">
                        <h3>{{__('user.Select your payment method')}}</h3>
                        <ul class="nav nav-pills" id="pills-tab" role="tablist">
                            @if ($stripe->status == 1)
                            <li class="nav-item">
                                <button class="nav-link"  data-bs-toggle="modal" data-bs-target="#exampleModal">
                                  <img src="{{ asset($stripe->image) }}" alt="visa" class="img-fluis w-100">
                                </button>
                            </li>
                            @endif
                            @if ($paypal->status == 1)
                            <li class="nav-item">
                                <form action="{{ route('pay-with-paypal') }}" method="GET" id="paypalForm">
                                    @csrf
                                    <input type="hidden" name="total_amount" value="{{ $cartTotal }}">
                                    <input type="hidden" name="cart_qty" value="{{ $cartQty }}">
                                </form>
                                <button class="nav-link" id="paypal" data-bs-toggle="pill">
                                    <img src="{{ asset($paypal->image) }}" alt="skrill" class="img-fluis w-100">
                                </button>
                            </li>
                            @endif
                            @if ($mollie->mollie_status == 1)
                            <li class="nav-item">
                                <button class="nav-link" id="mollie" data-bs-toggle="pill">
                                    <img src="{{ asset($mollie->mollie_image) }}" alt="paypal" class="img-fluis w-100">
                                </button>
                                <form action="{{ route('pay-with-mollie') }}" method="GET" id="mollieForm">
                                    @csrf
                                    <input type="hidden" name="total_amount" value="{{ $cartTotal }}">
                                    <input type="hidden" name="cart_qty" value="{{ $cartQty }}">
                                </form>
                            </li>
                            @endif
                            @if ($instamojo->status == 1)
                            <li class="nav-item">
                                <button class="nav-link" id="instamojo" data-bs-toggle="pill">
                                    <img src="{{ asset($instamojo->image) }}" alt="Degmark" class="img-fluis w-100">
                                </button>
                                <form action="{{ route('pay-with-instamojo') }}" method="GET" id="instamojoForm">
                                    @csrf
                                    <input type="hidden" name="total_amount" value="{{ $cartTotal }}">
                                    <input type="hidden" name="cart_qty" value="{{ $cartQty }}">
                                </form>
                            </li>
                            @endif
                            @if ($paystack->paystack_status == 1)
                            <li class="nav-item">
                                <button class="nav-link" onclick="payWithPaystack()" data-bs-toggle="pill">
                                    <img src="{{ asset($paystack->paystack_image) }}" alt="Degmark" class="img-fluis w-100">
                                </button>
                                <input type="hidden" name="total_amount" id="total_amount" value="{{ $cartTotal }}">
                                <input type="hidden" name="cart_qty" id="cart_qty" value="{{ $cartQty }}">
                            </li>
                            @endif
                            @if ($razorpay->status == 1)
                            <li class="nav-item">
                                <button class="nav-link" id="rajorpay" data-bs-toggle="pill">
                                    <img src="{{ asset($razorpay->image) }}" alt="Degmark" class="img-fluis w-100">
                                </button>
                                <form action="{{ route('pay-with-razorpay') }}" class="d-none" method="POST" id="rajorpayForm">
                                @csrf
                                @php
                                    $payable_amount = intval($cartTotal) * $razorpay->currency_rate;
                                    $payable_amount = round($payable_amount, 2);
                                @endphp
                                <script src="https://checkout.razorpay.com/v1/checkout.js"
                                        data-key="{{ $razorpay->key }}"
                                        data-currency="{{ $razorpay->currency_code }}"
                                        data-amount= "{{ $payable_amount * 100 }}"
                                        data-buttontext="{{__('user.Pay')}} {{ $payable_amount }} {{ $razorpay->currency_code }}"
                                        data-name="{{ $razorpay->name }}"
                                        data-description="{{ $razorpay->description }}"
                                        data-image="{{ asset($razorpay->image) }}"
                                        data-prefill.name=""
                                        data-prefill.email=""
                                        data-theme.color="{{ $razorpay->color }}">
                                </script>
                                    <input type="hidden" name="total_amount" value="{{ $cartTotal }}">
                                    <input type="hidden" name="cart_qty" value="{{ $cartQty }}">
                                </form>
                            </li>
                            @endif
                            @if ($flutterwave->status == 1)
                            <li class="nav-item">
                                <button class="nav-link" onclick="flutterwavePayment()" data-bs-toggle="pill">
                                    <img src="{{ asset('frontend') }}/images/pay_method_7.png" alt="Degmark" class="img-fluis w-100">
                                </button>
                            </li>
                            @endif
                            @if ($bankPayment->status == 1)
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="modal" data-bs-target="#bankPayment">
                                    <img src="{{ asset($bankPayment->image) }}" alt="Degmark" class="img-fluis w-100">
                                </button>
                            </li>
                            @endif
                            @if ($sslcommerz->status == 1)
                            <li class="nav-item">
                                <form action="{{ url('/pay') }}" method="POST" class="needs-validation" id="sslForm">
                                    @csrf
                                    <input type="hidden" name="total_amount" value="{{ $cartTotal }}">
                                    <input type="hidden" name="cart_qty" value="{{ $cartQty }}">
                                </form>
                                <button class="nav-link" id="sslBtn" data-bs-toggle="pill">
                                    <img src="{{ asset($sslcommerz->image) }}" alt="Degmark" class="img-fluis w-100">
                                </button>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-5">
                    <div class="wsus__checkout_sidebar" id="sticky_sidebar">
                        <h3>{{__('user.Order Summary')}}</h3>
                        <ul>
                            @foreach ($carts as $cart)
                            <li>
                                <div class="img">
                                    <a href="{{ route('product-detail', $cart->options->slug) }}">
                                        <img src="{{ asset($cart->options->image) }}" alt="checkout" class="img-fluid w-100">
                                    </a>
                                </div>
                                <div class="text">
                                    <a href="{{ route('product-detail', $cart->options->slug) }}">{{ html_decode($cart->name) }}</a>
                                    <p>{{__('user.Item by')}} {{ html_decode($cart->options->author) }}</p>
                                    <p>{{ $cart->options->size ? html_decode($cart->options->size):'' }}</p>
                                    <p> {{ $cart->options->price_type ? ucfirst(html_decode($cart->options->price_type)):''}}</p>
                                    <h3>{{ $setting->currency_icon }}{{ html_decode($cart->price) }}</h3>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                        @if (Session::has('coupon'))
                        <div class="wsus__checkout_sidebar_price">
                            <p>{{__('user.Subtotal')}} <span>{{ $setting->currency_icon }}{{ $cartTotal }}</span> </p>
                            <p>{{__('user.Discount')}} <span class="dis_amount">(-){{ $setting->currency_icon }} {{ session()->get('coupon')['discount_amount'] }}</span> </p>
                            <p class="total">{{__('user.Total')}} <span>{{ $setting->currency_icon }}{{ session()->get('coupon')['total_amount'] }}</span> </p>
                        </div>
                        @else
                        <div class="wsus__checkout_sidebar_price">
                            <p>{{__('user.Subtotal')}} <span>{{ $setting->currency_icon }}{{ $cartTotal }}</span> </p>
                            <p>{{__('user.Discount')}} <span class="dis_amount">(-){{ $setting->currency_icon }} 0</span> </p>
                            <p class="total">{{__('user.Total')}} <span>{{ $setting->currency_icon }}{{ $cartTotal }}</span> </p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
        CHECKOUT END
    ==============================-->


    <!--=============================
        RELATED PRODICT START
    ==============================-->
    <section class="wsus__related_product mt_100 pt_95 pb_245">
        <div class="container">
            <div class="row">
                <div class="col-xl-7 m-auto wow fadeInUp" data-wow-duration="1s">
                    <div class="wsus__section_heading mb_15">
                        <h5>{{__('user.Save time withd software')}}.</h5>
                        <h2>{{__('user.Related Products')}}.</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @forelse ($products as $product)
                    <div class="col-xl-4 col-md-6 wow fadeInUp" data-wow-duration="1s">
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
                                <p>{{__('user.By')}}<span>{{ html_decode($product->author->name) }}</span> {{__('user.In')}} <a class="category" href="{{ route('products', ['category' => $product->category->slug]) }}">{{ $product->category->name }}</a></p>
                                <a class="title" href="{{ route('product-detail', $product->slug) }}">{{ html_decode($product->name) }}</a>
                                <ul class="d-flex flex-wrap justify-content-between">
                                    @php
                                        $review=App\Models\Review::where(['product_id' => $product->id, 'status' => 1])->get()->average('rating');
                                        $sale=App\Models\OrderItem::where(['product_id' => $product->id])->get()->count();
                                        $variant=App\Models\ProductVariant::where('product_id', $product->id)->first();
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
                                            @for($i = 0; $i < $review; $i++)
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
        </div>
    </section>
    <!--=============================
        RELATED PRODICT END
    ==============================-->
    {{-- stripe modal --}}
    <!-- Button trigger modal -->
  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{__('user.Pay via Stripe')}}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            @php
                $stripe = App\Models\StripePayment::first();
            @endphp
          <form  role="form" action="{{route('pay-with-stripe')}}" method="post"
          class="require-validation"
          data-cc-on-file="false"
          data-stripe-publishable-key="{{ $stripe->stripe_key }}"
          id="payment-form">
          @csrf
            <div class="row">
                <div class="col-md-12 mt-2">
                    <div class="form-group">
                        <label for="card_number">{{__('user.Card Number')}}*</label>
                        <input autocomplete='off' class='form-control card-number' size='20'
                        type='text' name="card_number" autocomplete="off">
                        <input type="hidden" name="total_amount" value="{{ $cartTotal }}">
                        <input type="hidden" name="cart_qty" value="{{ $cartQty }}">
                    </div>
                </div>
                <div class="col-md-12 mt-4">
                    <div class="form-group">
                        <label for="month">{{__('user.Month')}}*</label>
                        <input input
                        class='form-control card-expiry-month' size='2'
                        type='text' name="month" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-12 mt-4">
                    <div class="form-group">
                        <label for="year">{{__('user.Year')}}*</label>
                        <input class='form-control card-expiry-year' size='4'
                        type='text' name="year" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-12 my-4">
                    <div class="form-group">
                        <label for="cvc">{{__('user.CVC')}}*</label>
                        <input autocomplete='off'
                        class='form-control card-cvc' size='4'
                        type='text' name="cvc" autocomplete="off">
                    </div>
                </div>
              </div>
              <div class='row'>
                <div class='col-md-12 error d-none'>
                    <div class='alert-danger alert'>{{__('user.Please correct the errors and try
                        again')}}.</div>
                </div>
            </div>

           <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">{{__('user.Cancel')}}</button>
            <button class="btn btn-primary btn-block" type="submit">{{__('user.Payment')}}</button>
          </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  {{-- start bank payment modal --}}
  <div class="wsus__payment_modal modal fade" id="bankPayment" data-bs-backdrop="static" data-bs-keyboard="false"
  tabindex="-1" aria-labelledby="bankPaymentLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="bankPaymentLabel">{{__('user.Bank Payment')}}</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <form method="POST" action="{{ route('bank-payment') }}">
                  @csrf
                  <div class="row">
                      <div class="col-xl-12 mb-4">
                          <p>{!! clean(nl2br($bankPayment->account_info)) !!}</p>
                      </div>

                      <div class="col-xl-12">
                          <textarea required cols="3" rows="3" name="tnx_info"  placeholder="{{__('user.Type your transaction information')}}"></textarea>
                        <input type="hidden" name="total_amount" value="{{ $cartTotal }}">
                        <input type="hidden" name="cart_qty" value="{{ $cartQty }}">
                      </div>

                  </div>

          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('user.Close')}}</button>
              <button type="submit" class="btn btn-danger">{{__('user.Submit')}}</button>
          </div>
          </form>
      </div>
  </div>
</div>
{{-- end bank payment --}}
@endsection
@section('frontend_js')
<script>
    "use strict";
    $(document).ready(function(){
        $('#paypal').on('click',function(){
            $('#paypalForm').submit();
        });
        $('#rajorpay').on('click',function(){
            $('#rajorpayForm').submit();
        });

        $('#mollie').on('click',function(){
            $('#mollieForm').submit();
        });

        $('#instamojo').on('click',function(){
            $('#instamojoForm').submit();
        });
        $('#paystack').on('click',function(){
            $('#paystackForm').submit();
        });
        $('#sslBtn').on('click',function(){
            $('#sslForm').submit();
        });
    })
</script>




<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">

$(function() {
    "use strict";
    /*------------------------------------------
    --------------------------------------------
    Stripe Payment Code
    --------------------------------------------
    --------------------------------------------*/

    var $form = $(".require-validation");

    $('form.require-validation').bind('submit', function(e) {
        var $form = $(".require-validation"),
        inputSelector = ['input[type=email]', 'input[type=password]',
                         'input[type=text]', 'input[type=file]',
                         'textarea'].join(', '),
        $inputs = $form.find('.required').find(inputSelector),
        $errorMessage = $form.find('div.error'),
        valid = true;
        $errorMessage.addClass('d-none');

        $('.has-error').removeClass('has-error');
        $inputs.each(function(i, el) {
          var $input = $(el);
          if ($input.val() === '') {
            $input.parent().addClass('has-error');
            $errorMessage.removeClass('d-none');
            e.preventDefault();
          }
        });

        if (!$form.data('cc-on-file')) {
          e.preventDefault();
          Stripe.setPublishableKey($form.data('stripe-publishable-key'));
          Stripe.createToken({
            number: $('.card-number').val(),
            cvc: $('.card-cvc').val(),
            exp_month: $('.card-expiry-month').val(),
            exp_year: $('.card-expiry-year').val()
          }, stripeResponseHandler);
        }

    });

    /*------------------------------------------
    --------------------------------------------
    Stripe Response Handler
    --------------------------------------------
    --------------------------------------------*/
    function stripeResponseHandler(status, response) {
        if (response.error) {
            $('.error')
                .removeClass('d-none')
                .find('.alert')
                .text(response.error.message);
        } else {
            /* token contains id, last4, and card type */
            var token = response['id'];

            $form.find('input[type=text]').empty();
            $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
            $form.get(0).submit();
        }
    }

});
</script>
{{-- paystack start --}}


<script src="https://js.paystack.co/v1/inline.js"></script>
@php

    $public_key = $paystack->paystack_public_key;
    $currency = $paystack->paystack_currency_code;
    $currency = strtoupper($currency);
    $ngn_amount = $cartTotal  * $paystack->paystack_currency_rate;
    $ngn_amount = $ngn_amount * 100;
    $ngn_amount = round($ngn_amount);
    $user=Auth::guard('web')->user();
@endphp
<script>
"use strict";
function payWithPaystack(){
    var isDemo = "{{ env('APP_MODE') }}"
    if(isDemo == 'DEMO'){
        toastr.error('This Is Demo Version. You Can Not Change Anything');
        return;
    }
    var handler = PaystackPop.setup({
        key: '{{ $public_key }}',
        email: '{{ $user->email }}',
        amount: '{{ $ngn_amount }}',
        currency: "{{ $currency }}",
        callback: function(response){
        let reference = response.reference;
        let tnx_id = response.transaction;
        let _token = "{{ csrf_token() }}";
        $.ajax({
            type: "post",
            data: {reference, tnx_id, _token},
            url: "{{ url('pay-with-paystack') }}",
            success: function(response) {
                if(response.status == 'success'){
                    toastr.success(response.message);
                    window.location.href = "{{ route('payment-success') }}";
                }else{
                    toastr.error(response.message);
                    window.location.reload();
                }
            },
            error: function(response){
                    toastr.error('Server Error');
                    window.location.reload();
            }
        });
        },
        onClose: function(){
            alert('window closed');
        }
    });
    handler.openIframe();
}
</script>
<script src="https://checkout.flutterwave.com/v3.js"></script>
@php
    $payable_amount = $cartTotal * $flutterwave->currency_rate;
    $payable_amount = round($payable_amount, 2);
@endphp
<script>
    "use strict";
    function flutterwavePayment() {

        var isDemo = "{{ env('APP_MODE') }}"
        if(isDemo == 'DEMO'){
            toastr.error('This Is Demo Version. You Can Not Change Anything');
            return;
        }


        FlutterwaveCheckout({
            public_key: "{{ $flutterwave->public_key }}",
            tx_ref: "RX1",
            amount: {{ $payable_amount }},
            currency: "{{ $flutterwave->currency_code }}",
            country: "{{ $flutterwave->country_code }}",
            payment_options: " ",
            customer: {
            email: "{{ $user->email }}",
            phone_number: "{{ $user->phone }}",
            name: "{{ $user->name }}",
            },
            callback: function (data) {

                var tnx_id = data.transaction_id;
                var _token = "{{ csrf_token() }}";
                $.ajax({
                    type: 'post',
                    data : {tnx_id,_token},
                    url: "{{ url('pay-with-flutterwave') }}",
                    success: function (response) {
                        if(response.status == 'success'){
                            toastr.success(response.message);
                            window.location.href = "{{ route('payment-success') }}";
                        }else{
                            toastr.error(response.message);
                            window.location.reload();
                        }
                    },
                    error: function(err) {

                    }
                });
            },
            customizations: {
            title: "{{ $flutterwave->title }}",
            logo: "{{ asset($flutterwave->logo) }}",
            },
        });



    }
</script>
{{-- end flutterwave payment --}}
@endsection
