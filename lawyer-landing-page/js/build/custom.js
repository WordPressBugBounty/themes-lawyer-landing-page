jQuery(document).ready(function ($) {
    var rtl, mrtl;

    if (llp_data.rtl == '1') {
        rtl = true;
        mrtl = false;
    } else {
        rtl = false;
        mrtl = true;
    }

    /* Masonry for faq */
    if ($('.page-template-template-home').length > 0) {

        $('.rara-masonry').imagesLoaded(function () {
            $('.rara-masonry').masonry({
                itemSelector: '.col',
                isOriginLeft: mrtl
            });
        });

        // The slider being synced must be initialized first
        $(".testimonial-slider").owlCarousel({
            margin: 30,
            nav: true,
            dots: false,
            mouseDrag: false,
            rtl: rtl,
            responsive: {
                0: {
                    items: 1
                },
                768: {
                    items: 3
                },
                992: {
                    items: 4
                }
            }
        });

    }

    // custom scrollbar
    $(".team .col .img-holder .text-holder").niceScroll({
        cursorcolor: "#000000",
        cursorborder: "0",
        cursorwidth: "3px"
    });

    $(".practice-area .box .text-holder").niceScroll();

    $(".why-us .box .text-holder").niceScroll();

    $('.team .col .img-holder .text-holder').removeAttr("tabindex");
    $('.practice-area .box .text-holder').removeAttr("tabindex");
    $('.why-us .box .text-holder').removeAttr("tabindex");

    /** Ajax cal for testimonial slider in home page */
    $('.testimonial-slider .testimonial-slide').on('click', function () {
        var id = $(this).attr('id').split('-').pop();

        $('.testimonial-slider .testimonial-slide').removeClass('testimonial-active');
        $(this).addClass('testimonial-active');

        if (typeof llp_data !== 'undefined') {
            //Ajax Call
            $.ajax({
                url: llp_data.url,
                data: { 'action': 'lawyer_landing_page_testimonial', 'post_id': id },
                beforeSend: function () {
                    $('.testimonial-content').addClass('loading');
                },
                success: function (data) {
                    $('.testimonial-content').html(data);
                }
            }).done(function () {
                $('.testimonial-content').removeClass('loading');
            });
        }
    });


    //mobile-menu

    $('<button class="angle-down"></button>').insertAfter($('.mobile-menu-wrapper .main-navigation ul .menu-item-has-children > a'));
    $('.mobile-menu-wrapper .main-navigation ul li .angle-down').on('click', function () {
        $(this).next().slideToggle();
        $(this).toggleClass('active');
    });

    var winWidth = $(window).width();
    $('.menu-opener').on('click', function () {
        $('body').addClass('menu-open');
        $('.mobile-menu-wrapper').animate({
            width: 'toggle',
        });
    });

    $('.mobile-menu-wrapper .close').on('click', function () {
        $('body').removeClass('menu-open');
        $('.mobile-menu-wrapper').animate({
            width: 'toggle',
        });
    });

    $('.overlay').on('click', function () {
        $('body').removeClass('menu-open');
        $('.mobile-menu-wrapper').animate({
            width: 'toggle',
        });
    });
    
    var windowWidth = window.innerWidth;
    window.addEventListener('resize', function () {
        if (windowWidth >= 1024) {
            document.body.classList.remove('menu-open');
        }
    });

    //for accessible menu
    if (winWidth > 1024) {
        $("#site-navigation ul li a").on('focus', function () {
            $(this).parents("li").addClass("focus");
        }).on('blur', function () {
            $(this).parents("li").removeClass("focus");
        });
    }
});
