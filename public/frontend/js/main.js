$(function () {
    "use strict";

    //======MENU FIX========
    if ($('.main_menu').offset() != undefined) {
        $(window).bind('scroll', function () {
            if ($(window).scrollTop() > 40) {
                $('.main_menu').addClass('menu_fix');
            } else {
                $('.main_menu').removeClass('menu_fix');
            }
        });
    }


    //======NICE SELECT========
    $('.select_js').niceSelect();


    //=======COUNTER JS=======
    $('.counter').countUp();


    //=======TESTI SLIDER======
    $('.team_slider').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 4000,
        dots: true,
        arrows: false,

        responsive: [
            {
                breakpoint: 1400,
                settings: {
                    slidesToShow: 3,
                }
            },
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 2,
                }
            },
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 2,
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1,
                }
            },
            {
                breakpoint: 576,
                settings: {
                    slidesToShow: 1,
                }
            }
        ]
    });


    //=======TESTI SLIDER======
    $('.testi_slider').slick({
        slidesToShow: 2,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 4000,
        dots: true,
        arrows: false,

        responsive: [
            {
                breakpoint: 1400,
                settings: {
                    slidesToShow: 2,
                }
            },
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 2,
                }
            },
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 2,
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1,
                }
            },
            {
                breakpoint: 576,
                settings: {
                    slidesToShow: 1,
                }
            }
        ]
    });


    //=======TESTI SLIDER======
    $('.pro_det_slider').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 4000,
        dots: false,
        arrows: true,
        nextArrow: '<i class="far fa-angle-right nextArrow"></i>',
        prevArrow: '<i class="far fa-angle-left prevArrow"></i>',
    });


    //=====STICKY SIDEBAR====== 
    $("#sticky_sidebar").stickit({
        top: 90,
    })


    //=====SUMMER NOTE JS=======
    $(document).ready(function () {
        $('.summer_note').summernote();
    });


    //=====WOW JS=======
    new WOW().init();


    //=====percircle js=====
    $("[id$='circle']").percircle();


    // =====testimonial 3 slider=====
    $('.wsus__testi_slider_top').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 4000,
        dots: false,
        arrows: false,
        fade: false,
        centerMode: true,
        asNavFor: '.wsus__testi_slider_bottom'
    });

    $('.wsus__testi_slider_bottom').slick({
        slidesToShow: 5,
        slidesToScroll: 1,
        asNavFor: '.wsus__testi_slider_top',
        autoplay: true,
        autoplaySpeed: 4000,
        dots: false,
        arrows: false,
        centerMode: true,
        focusOnSelect: true,

        responsive: [
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 5,
                }
            },
            {
                breakpoint: 576,
                settings: {
                    slidesToShow: 3,
                }
            }
        ]
    });


    //*=======SCROLL BUTTON=======  
    $('.wsus__scroll_btn').on('click', function () {
        $('html, body').animate({
            scrollTop: 0,
        }, 400);
    });

    $(window).on('scroll', function () {
        var scrolling = $(this).scrollTop();

        if (scrolling > 300) {
            $('.wsus__scroll_btn').fadeIn();
        } else {
            $('.wsus__scroll_btn').fadeOut();
        }
    });


    //=======MOBILE MENU ICON======
    $(".navbar-toggler").on("click", function () {
        $(".navbar-toggler").toggleClass("show_close_icon");
    });


    //=======MOBILE MENU ICON======
    $(".wsus__product_sidebar_filter").on("click", function () {
        $(".wsus__product_sidebar_area").toggleClass("show_filter");
    });

    $(".wsus__product_sidebar_filter").on("click", function () {
        $(".wsus__product_sidebar_filter").toggleClass("show_minus");
    });


}); 