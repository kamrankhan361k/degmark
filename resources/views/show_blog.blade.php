@extends($active_theme)
@section('title')
    <title>{{ $blog->title }}</title>
    <meta name="title" content="{{ $blog->seo_title }}">
    <meta name="description" content="{{ $blog->seo_description }}">
@endsection
@section('meta')
@endsection

@section('frontend-content')



    <!--=============================
        BREADCRUMB START
    ==============================-->
    <section class="wsus__breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <h1>{{__('user.Blog details')}}</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{__('user.Home')}}</a></li>
                            <li class="breadcrumb-item">{{__('user.Blog details')}}</li>
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
        BLOG DETAILS START
    ==============================-->
    <section class="wsus__blog_details pt_100">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 col-lg-8 wow fadeInLeft" data-wow-duration="1s">
                    <div class="wsus__blog_details_img">
                        <img src="{{ asset($blog->image) }}" alt="blog details" class="img-fluid w-100">
                    </div>
                    <ul class="wsus__blog_details_header d-flex flex-wrap">
                        <li><i class="far fa-user"></i> {{__('user.By')}} {{ $blog->admin->name }}</li>
                        <li><i class="far fa-comment-alt-dots"></i> {{ $blog_comments->count() }} {{__('user.Comments')}}</li>
                    </ul>
                    <div class="wsus__blog_details_text">
                        <h3>
                            {{ $blog->title }}
                        </h3>
                        <p>
                            {!! clean($blog->description) !!}
                        </p>
                    </div>

                    <div class="wsus__blog_tags_and_share d-flex flex-wrap justify-content-between">
                        <ul class="tags d-flex flex-wrap align-items-center">
                            <li><span>{{__('user.tags')}}:</span></li>
                            @php
                                $tag_arr=[];
                                $tags=explode(', ', $blog->tag);
                                foreach($tags as $tag){
                                    $tag_arr[]=$tag;
                                }
                                array_pop($tag_arr);
                            @endphp
                            @foreach ($tag_arr as $tag)
                            <li><a href="{{ route('blogs', strtolower($tag)) }}">#{{ $tag }}</a></li>
                            @endforeach

                        </ul>
                        <ul class="share d-flex flex-wrap align-items-center">
                            <li><span>share:</span></li>
                            <li><a href="https://www.facebook.com/sharer/sharer.php?u={{ route('blog', $blog->slug) }}&t={{ $blog->title }}"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="https://www.linkedin.com/shareArticle?mini=true&url={{ route('blog', $blog->slug) }}&title={{ $blog->title }}"><i class="fab fa-linkedin-in"></i></a></li>
                            <li><a href="https://twitter.com/share?text={{ $blog->title }}&url={{ route('blog', $blog->slug) }}"><i class="fab fa-twitter"></i></a></li>
                        </ul>
                    </div>

                    <div class="wsus__comment_input_area mt_50">
                        <h3>{{__('user.Leave a Comment')}}</h3>
                        <form id="blogCommentForm">
                            @csrf
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="wsus__comment_single_input">
                                        <label>{{__('user.Name')}}*</label>
                                        <input type="text" name="name" id="name" placeholder="{{__('user.Name')}}">
                                        <input type="hidden" name="blog_id" id="blog_id" value="{{ $blog->id }}">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="wsus__comment_single_input">
                                        <label>{{__('user.email')}}*</label>
                                        <input type="text" name="email" id="email" placeholder="{{__('user.Email')}}">
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="wsus__comment_single_input">
                                        <label>{{__('user.comment')}}*</label>
                                        <textarea rows="5" name="comment" id="comment" placeholder="{{__('user.Type your comment here')}}"></textarea>
                                    </div>
                                </div>
                                @if($recaptchaSetting->status==1)
                                    <div class="col-xl-12">
                                        <div class="wsus__single_com mt_20 blog_comment_recaptcha">
                                            <div class="g-recaptcha" data-sitekey="{{ $recaptchaSetting->site_key }}"></div>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-xl-12">
                                    <div class="wsus__comment_single_input">
                                        <button class="common_btn2" id="submitBtn" type="submit">{{__('user.Submit Comment')}}</button>
                                        <button class="common_btn2 d-none" id="showspin" type="submit"><i class="fas fa-spinner fa-spin"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    @if ($blog_comments->count()>0)
                    <div class="wsus__comment_list mt_45">
                        <h3>{{__('user.Comments')}} ({{ $blog_comments->count() }})</h3>
                        @foreach ($blog_comments as $comment)
                        <div class="wsus__single_comment">
                            <p class="comment_date">{{ Carbon\Carbon::parse($comment->created_at)->format('F d,Y') }} {{__('user.At')}} {{ Carbon\Carbon::parse($comment->created_at)->format('h:i A') }}</p>
                            <p class="comment_des">
                                {{ html_decode($comment->comment) }}
                            </p>
                            <div class="comment_footer d-flex flex-wrap">
                                <div class="img">
                                    <img src="{{ asset($setting->default_avatar) }}" alt="useer" class="img-fluid w-100">
                                </div>
                                <div class="text">
                                    <h3>{{ html_decode($comment->name) }}</h3>
                                    <p>{{ '@'.html_decode(strtolower(str_replace(' ', '_', $comment->name))) }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
                <div class="col-xl-4 col-lg-4">
                    <div class="wsus__sidebar" id="sticky_sidebar">
                        <div class="wsus__sidebar_item wsus__sidebar_search mt-0">
                            <h3>{{__('user.Search')}}</h3>
                            <form action="{{ route('blogs') }}" method="GET">
                                <input type="text" name="search" placeholder="Search">
                                <button type="submit"><i class="fas fa-search"></i></button>
                            </form>
                        </div>
                        <div class="wsus__sidebar_item wsus__sidebar_blog">
                            <h3>{{__('user.Popular Post')}}</h3>
                            <ul>
                                @foreach ($popular_blogs as $blog)
                                <li>
                                    <div class="img">
                                        <img src="{{ asset($blog->image) }}" alt="blog" class="img-fluid w-100">
                                    </div>
                                    <div class="text">
                                        <a href="{{ route('blog', $blog->slug) }}">{{ $blog->title }}</a>
                                        <p><i class="fas fa-calendar-alt"></i> {{ Carbon\Carbon::parse($blog->created_at)->format('d-m-Y') }}</p>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="wsus__sidebar_item wsus__sidebar_categories">
                            <h3>{{__('user.Categories')}}</h3>
                            <ul>
                                @foreach ($categories as $category)
                                @php
                                    $total_blog = App\Models\Blog::where(['blog_category_id' => $category->id, 'status' => 1])->count();
                                @endphp
                                <li><a href="{{ route('blogs', $category->slug ) }}">{{ $category->name }} <span>({{ $total_blog }})</span></a></li>
                                @endforeach
                            </ul>
                        </div>
                        @if ($pupular_tags->count()>0)
                        <div class="wsus__sidebar_item wsus__sidebar_tags">
                            <h3>{{__('user.Popular Tags')}}</h3>
                            <ul class="d-flex flex-wrap">
                                @foreach ($pupular_tags as $popular_tag)
                                <li><a href="{{ route('blogs', strtolower($popular_tag->tag_name)) }}">{{ $popular_tag->tag_name }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <div class="wsus__sidebar_item wsus__sidebar_subscribe"
                        style="background: url({{ asset($subscriber->image) }});">
                            <div class="wsus__sidebar_subscribe_overlay">
                                <h3>{{ $subscriber->title }}</h3>
                                <p>{!! clean($subscriber->description) !!}</p>

                                <form id="subscriberForm">
                                    @csrf
                                    <input type="text" name="email" placeholder="{{__('user.Enter Your Email Address')}}">
                                    <button class="common_btn mt-1" id="subSubmitBtn" type="submit">{{__('user.Subscribe')}}</button>
                                    <button class="common_btn d-none mt-1" id="subShowSpain" type="submit"><i class="fas fa-spinner fa-spin"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
        BLOG DETAILS END
    ==============================-->


    <!--=============================
        RELATED BLOG START
    ==============================-->
    @if ($related_blogs->count() > 0)
    <section class="wsus__related_blog wsus__related_product mt_100 pt_95 pb_245">
        <div class="container">
            <div class="row">
                <div class="col-xl-7 m-auto wow fadeInUp" data-wow-duration="1s">
                    <div class="wsus__section_heading mb_25">
                        <h5>{{__('user.Save time with pre-installed software.')}}</h5>
                        <h2>{{__('user.Related Blog Posts')}}</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($related_blogs as $blog)
                <div class="col-xl-4 col-md-6 wow fadeInUp" data-wow-duration="1s">
                    <div class="wsus__single_blog">
                        <div class="wsus__single_blog_img">
                            <img src="{{ asset($blog->image) }}" alt="blog" class="img-fluid w-100">
                            <p><span>{{ \Carbon\Carbon::parse($blog->created_at)->format('d') }}</span> {{ \Carbon\Carbon::parse($blog->created_at)->format('F') }}</p>
                        </div>
                        <div class="wsus__single_blog_text">
                            <p>{{__('user.By')}} <a href="#">{{ $blog->admin->name }}</a></p>
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
        RELATED BLOG END
    ==============================-->
@endsection
@section('frontend_js')
<script>
    (function($) {
        "use strict";
        $(document).ready(function () {
            $("#blogCommentForm").on('submit', function(e){
                e.preventDefault();
                $('#showspin').removeClass('d-none');
                $('#submitBtn').addClass('d-none');
                submitBtn
                var isDemo = "{{ env('APP_MODE') }}"
                if(isDemo == 'DEMO'){
                    toastr.error('This Is Demo Version. You Can Not Change Anything');
                    return;
                }
                $.ajax({
                    type: 'POST',
                    data: $('#blogCommentForm').serialize(),
                    url: "{{ route('blog-comment') }}",
                    success: function (response) {
                        if(response.status == 1){
                            toastr.success(response.message)
                            $("#blogCommentForm").trigger("reset");
                            $('#showspin').addClass('d-none');
                            $('#submitBtn').removeClass('d-none');
                        }
                    },
                    error: function(response) {
                        $('#showspin').addClass('d-none');
                        $('#submitBtn').removeClass('d-none');
                        if(response.responseJSON.errors.name)toastr.error(response.responseJSON.errors.name[0])
                        if(response.responseJSON.errors.email)toastr.error(response.responseJSON.errors.email[0])
                        if(response.responseJSON.errors.comment)toastr.error(response.responseJSON.errors.comment[0])

                        if(!response.responseJSON.errors.name && !response.responseJSON.errors.email && !response.responseJSON.errors.comment){
                            toastr.error("{{__('user.Please complete the recaptcha to submit the form')}}")
                        }
                    }
                });
            });


            $("#subscriberForm").on('submit', function(e){
                e.preventDefault();
                $('#subShowSpain').removeClass('d-none');
                $('#subSubmitBtn').addClass('d-none');
                var isDemo = "{{ env('APP_MODE') }}"
                if(isDemo == 'DEMO'){
                    toastr.error('This Is Demo Version. You Can Not Change Anything');
                    return;
                }

                let loading = "{{__('user.Processing...')}}"

                $("#subscribe_btn").html(loading);
                $("#subscribe_btn").attr('disabled',true);

                $.ajax({
                    type: 'POST',
                    data: $('#subscriberForm').serialize(),
                    url: "{{ route('subscribe-request') }}",
                    success: function (response) {
                        if(response.status == 1){
                            toastr.success(response.message);
                            let subscribe = "{{__('user.Subscribe')}}"
                            $("#subscribe_btn").html(subscribe);
                            $("#subscribe_btn").attr('disabled',false);
                            $("#subscriberForm").trigger("reset");
                            $('#subShowSpain').addClass('d-none');
                            $('#subSubmitBtn').removeClass('d-none');
                        }

                        if(response.status == 0){
                            toastr.error(response.message);
                            let subscribe = "{{__('user.Subscribe')}}"
                            $("#subscribe_btn").html(subscribe);
                            $("#subscribe_btn").attr('disabled',false);
                            $("#subscriberForm").trigger("reset");
                            $('#subShowSpain').addClass('d-none');
                            $('#subSubmitBtn').removeClass('d-none');
                        }
                    },
                    error: function(err) {
                        $('#subShowSpain').addClass('d-none');
                        $('#subSubmitBtn').removeClass('d-none');
                        toastr.error('Something went wrong');
                        let subscribe = "{{__('user.Subscribe')}}"
                            $("#subscribe_btn").html(subscribe);
                            $("#subscribe_btn").attr('disabled',false);
                            $("#subscriberForm").trigger("reset");
                    }
                });
            })


        });
    })(jQuery);

</script>
@endsection
