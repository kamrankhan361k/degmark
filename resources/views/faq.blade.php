@extends($active_theme)
@section('title')
    <title>{{__('user.FAQ')}}</title>
@endsection
@section('meta')
    <meta name="description" content="{{__('user.FAQ')}}">
@endsection

@section('frontend-content')

    <!--=============================
        BREADCRUMB START
    ==============================-->
    <section class="wsus__breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <h1>{{__('user.Frequently Asked Questions')}}</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{__('user.Home')}}</a></li>
                            <li class="breadcrumb-item">{{__('user.FAQs')}}</li>
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
        FAQ START
    ==============================-->
    <section class="wsus__faq pt_100">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 wow fadeInLeft" data-wow-duration="1s">
                    <div class="wsus__faq_text">
                        <h3>{{__('user.Frequently asked questions')}}</h3>
                        <div class="accordion accordion-flush" id="accordionFlushExample">
                            @foreach ($faqs as $index=>$faq)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-heading{{ $faq->id }}">
                                    <button class="accordion-button {{ ++$index!=1? 'collapsed':'' }}" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapse{{ $faq->id }}" aria-expanded="false"
                                        aria-controls="flush-collapse{{ $faq->id }}">
                                        {{ $index }}. {{ $faq->question }}
                                    </button>
                                </h2>
                                <div id="flush-collapse{{ $faq->id }}" class="accordion-collapse collapse {{ $index==1 ? 'show':'' }}"
                                    aria-labelledby="flush-heading{{ $faq->id }}" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        <p>
                                            {!! clean($faq->answer) !!}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-xl-5 col-lg-5 wow fadeInRight" data-wow-duration="1s">
                    <div class="wsus__contact_form">
                        <h3>{{__('user.Have Any Question')}}</h3>
                        <form action="{{ route('send-contact-message') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="wsus__contact_form_single">
                                        <label>{{__('user.Name')}}*</label>
                                        <input type="text" name="name" placeholder="{{__('user.Your name here')}}...">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="wsus__contact_form_single">
                                        <label>{{__('user.Email')}}*</label>
                                        <input type="text" name="email" placeholder="{{__('user.Email')}}...">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="wsus__contact_form_single">
                                        <label>{{__('user.Phone')}}*</label>
                                        <input type="text" name="phone" placeholder="{{__('user.Phone')}}">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="wsus__contact_form_single">
                                        <label>{{__('user.Subject')}}*</label>
                                        <input type="text" name="subject" placeholder="{{__('user.Subject')}}...">
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
                                        <button class="common_btn" type="submit">{{__('user.Sand Messages')}}</button>
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
        FAQ END
    ==============================-->
@endsection
