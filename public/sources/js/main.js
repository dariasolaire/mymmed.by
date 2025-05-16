$(document).ready(function(){
//CUSTOM JS LUTOVICH//
////////////validation close
$('._js-b-close-validation-alert').on('click', function () {
    $('._js-validation-alert').addClass('hide');
    return false;
});
////////////cookie close
    $('._js-b-cookie-alert').on('click', function () {
        $('._js-cookie-alert').addClass('hide');
        Cookies.set('cookie', 'true', { expires: 60*60*24*30*12 })
    });

    if(Cookies.get('cookie') != 'true') {
        $('._js-cookie-alert').removeClass('hide');
    }

    $('._js-b-cookie-alert-fall').on('click', function () {
        $('._js-cookie-alert').addClass('hide');

        return false;
    });
////////////b-wrapper min-height
$(window).on('resize scroll load', function () {
    var footer_H = $('.s-footer').height();
    var b_wrapper_H = $(window).height() - footer_H;
    $('.b-wrapper').css("min-height" , ""+b_wrapper_H +"px");
});
////////////device type
$(window).on('scroll resize load', function () {
    var touchscreen = jQuery.browser.mobile;
    if (touchscreen) {
        $('body').removeClass('_desk').addClass('_touch');
    }
    else {
        $('body').removeClass('_touch').addClass('_desk');
    }
})
////////////article scroll tables mobile
    $(document).each(function(e){
        $('._js-article-table-mobile-scroll table').wrap('<div class="w-scrollable-table-shades"><div class="w-scrollable-table"></div></div>');
    });
////////////article float images mobile
    $('article img').each(function(e){
        if($(this).css('float') === 'left'){$(this).addClass('img-article-left');}
        if($(this).css('float') === 'right'){$(this).addClass('img-article-right');}
    });
////////////article fancy images
    $(function(){
        $('._js-article-fancy-images img').each(function () {
            var $this = $(this);
            var $thisparentdatafancy = $(this).parents('._js-article-fancy-images').attr('data-images-fancy')
            $this.wrap('<a class="block__link grouped_elements" data-fancybox="' + $thisparentdatafancy + '" rel="" href="' + $this.attr('src') + '" title="' + $this.attr('alt') + '"></a>');
        });
    });
////////////pop open
    $('body').on('click', '._js-b-pop', function () {
        var pop_id = $(this).attr('data-pop-id');
        $('.s-popup').show();
        $('.s-popup__background').show();
        $('._js-popup.' + pop_id ).addClass('animate');
        $('._js-popup.' + pop_id ).css("display" , "inline-block");
        return false;
    });
////////////popup CLOSE
    $('._js-pop-close').on('click', function () {
        $('.s-popup').hide();
        $('.w-popup').hide();
        $('.s-popup__background').hide();
        $('.w-popup').removeClass('animate');
        return false;
    });
////////////toggler-button-inset-default
$('._js-b-toggler-button').on('click', function () {
    insetCurrent = $(this).closest('._js-toggler-button-parrent').find('._js-inset');
    if (insetCurrent.is(":visible")){
        insetCurrent.slideUp();
        $(this).removeClass('_toggled');
        /*$(this).closest('._js-toggler-button-parrent').removeClass('_toggled');*/
        setTimeout(function() {
            $(this).parents('._js-toggler-button-parrent').removeClass('');
        }.bind(this), 200);
    }
    else {
        insetCurrent.slideDown();
        $(this).addClass('_toggled');
        /*$(this).closest('._js-toggler-button-parrent').addClass('_toggled');*/
        setTimeout(function() {
            $(this).parents('._js-toggler-button-parrent').addClass('');
        }.bind(this), 100);
    }
    $(this).closest('._js-toggler-button-parrent').toggleClass('_toggled');
    return false;
});
////////////double-changed-button
    $('._js-b-double-changed').on('click', function () {
        $(this).find('.info').toggleClass('_active');
        return false;
    });
////////////mobile-menu-new
    $('._js-b-toggle-mobile-menu').on('click', function () {
        $('._js-s-toggle-mobile-menu').toggleClass('_toggled');
        $('body').toggleClass('_blocked-mobile');
        return false;
    });
////////////mobile-menu-new-toggle-inset
    $('._js-s-toggle-mobile-menu .ul-mobile-menu.default ._js-b-dropper').on('click', function () {
        let insetMenuCurrent = $(this).closest('._js-li-dropper').children('._js-inset');
        if (insetMenuCurrent.is(":visible")){
            insetMenuCurrent.slideUp();
            $(this).removeClass('_toggled');
            $(this).siblings('.b-dropper').removeClass('_toggled');
            $(this).closest('._js-li-dropper').removeClass('_toggled');
        }
        else {
            insetMenuCurrent.slideDown();
            $(this).siblings('.b-dropper').addClass('_toggled');
            $(this).addClass('_toggled');
            $(this).closest('._js-li-dropper').addClass('_toggled');
        }
        return false;
    });
////////////js cloud-dropper
    $('._js-b-click-dropper').on('click', function () {
        /*$('._js-click-dropper').removeClass('_toggled');*/
        if ($(this).parents('._js-click-dropper').hasClass('_toggled')) {
            $(this).parents('._js-click-dropper').removeClass('_toggled')
        }
        else {
            $(this).parents('._js-click-dropper').addClass('_toggled');
        }
        return false;
    });
    $(document).on('click', function (e) {
        if ($('._js-click-dropper ._js-inset').has(e.target).length === 0){
            $('._js-click-dropper').removeClass('_toggled');
        }
    });
////////////pager up
    $(function () {
        $(window).scroll(function () {
        if ($(this).scrollTop() != 0) {
            $('._js-w-pager-up').fadeIn();
        } else {
            $('._js-w-pager-up').fadeOut();
        }
        });
        $('._js-b-pager-up').click(function () {
            $('body,html').animate({scrollTop: 0}, 300);
            return false;
        });
    });
////////////mobile-search
    $('._js-b-mobile-search').on('click', function () {
        $('._js-click-dropper').removeClass('_toggled');
        $('body').toggleClass('_js-mobile-search-toggled');
        $('#site-search-input').focus();
        return false;
    });
////////////hide mobile header on scroll
    $(document).ready(() => {
        const onScrollHeader = () => {
        const header = $('.s-header-mobile')
        let prevScroll = $(window).scrollTop()
        let currentScroll
        $(window).scroll(() => {
        currentScroll = $(window).scrollTop()
        const headerHidden = () => header.hasClass('header_hidden')
        if (currentScroll > prevScroll && !headerHidden()) {
            var scrollTop = $(window).scrollTop();
            if (scrollTop >= 1000) {
                 header.addClass('header_hidden')
             }
        }
        if (currentScroll < prevScroll && headerHidden()) {
        header.removeClass('header_hidden')
        }
        prevScroll = currentScroll
        })
        }
        onScrollHeader()
    })
////////////fixed header responsive
    $(window).on('resize scroll load', function () {
        var windowSize = $(window).width();
        var header_H = $('.s-header').height();
        var header_top_H = $('.header-top').height();
        var header_middle_H = $('.header-middle').height();
        var header_bottom_H = $('.header-bottom').height();
        var offsetTop = $('.s-header').offset().top;
        var scrollTop = $(window).scrollTop();
        if (windowSize >= 310) {
            if (scrollTop >= header_H - header_middle_H - header_bottom_H) {
                $('.s-header').addClass('fixed');
            }
            if (scrollTop < header_H - header_middle_H - header_bottom_H) {
                $('.s-header').removeClass('fixed');
            }
        }
        $('.header-empty').css("height" , +header_middle_H +"px");
    });
//fixed top menu
/*
    $(window).scroll(function() {
        if ($(window).scrollTop() > 241) {$('header').addClass('fixed');}
        else {$('header').removeClass('fixed');}
    });
*/
//toggle-navigation-menu CUSTOM
    $('._js-b-toggle-navigation-menu').on('click', function () {
        var nav_id = $(this).attr('data-nav-id');
        $('._js-navigation-menu.' + nav_id ).toggleClass('_toggled');
        $('._js-navigation-menu.' + nav_id ).children('.menu-layout').toggleClass('_toggled');
        $(this).parents('._js-mobile-menu.' + nav_id ).toggleClass('_toggled');
        $('body').toggleClass('_blocked-mobile');
        $('body').toggleClass('_nav-menu-shown');
        return false;
    });

//OWL persons slider
    $('.owl-persons-item-slider').owlCarousel({
        items: 1,
        margin: 0,
        stagePadding: 0,
        nav: true,
        navText:false,
        navSpeed: 800,
        dots: true,
        dotsSpeed: 200,
        navRewind: false,
        autoplay: false,
        autoplayTimeout: 4000,
        autoplayHoverPause: true,
        autoplaySpeed: 600,
        mouseDrag: true,
        touchDrag: true
    });


//OWL partners slider
    $('.owl-partners-slider').owlCarousel({
        items: 1,
        margin: 0,
        stagePadding: 0,
        nav: true,
        navText:false,
        navSpeed: 800,
        dots: true,
        dotsSpeed: 200,
        navRewind: false,
        autoplay: false,
        autoplayTimeout: 4000,
        autoplayHoverPause: true,
        autoplaySpeed: 600,
        mouseDrag: true,
        touchDrag: true,
        responsive:{
        0:{
          items:1,
          margin: 10
        },
        360:{
          items:2,
          margin: 10
        },
        576:{
          items:2,
          margin: 10
        },
        768:{
          items:3,
          margin: 10
        },
        992:{
          items:4,
          margin: 10
        },
        1200:{
          items:4,
          margin: 30
        },
        1300:{
          items:5,
          margin: 30
        }
      }
  });

//OWL partners slider
    $('.owl-event-number-benefits-list').owlCarousel({
        items: 1,
        margin: 0,
        stagePadding: 0,
        nav: true,
        navText:false,
        navSpeed: 800,
        dots: true,
        dotsSpeed: 200,
        navRewind: false,
        autoplay: false,
        autoplayTimeout: 4000,
        autoplayHoverPause: true,
        autoplaySpeed: 600,
        mouseDrag: true,
        touchDrag: true,
        responsive:{
        0:{
          items:1,
          margin: 10
        },
        768:{
          items:2,
          margin: 10
        },
        1200:{
          items:3,
          margin: 30
        }
      }
  });
//fancybox
    if ($('._js-w-fancy').length > 0) {
        $("a.grouped_elements").fancybox();
    }
    if ($('.select__default').length > 0) {


        $(".select__default").select2({
            maximumSelectionLength: 10,
            placeholder: "Выбрать",
            /*minimumResultsForSearch: Infinity,*/
            minimumResultsForSearch: 5,
            tags: true,
            allowClear: false
        });
    };
//change-tabs
    if ($('._js-switchible-tabs').length) {
        $('._js-w-tabs ._js-change-tab').on('click', function () {
            var tabs_id = $(this).attr('data-tabs-id');
            $(this).parents('._js-switchible-tabs.' + tabs_id).find('._js-w-tabs-content ._js-tab-content.' + tabs_id).removeClass('_active').eq($(this).parents('._js-parent-element.' + tabs_id).index()).addClass('_active');
            $(this).parents('._js-w-tabs.' + tabs_id).find('._js-parent-element.' + tabs_id).removeClass('_active').eq($(this).parents('._js-parent-element.' + tabs_id).index()).addClass('_active');
            $(this).parents('._js-w-tabs.' + tabs_id).find('._js-change-tab').removeClass('_active').eq($(this).parents('._js-parent-element.' + tabs_id).index()).addClass('_active');

            $('._js-mobile-select-overlay').removeClass('_toggled-mobile');
            return false;
        });
    }
//show password btn
    $('.input-password .btn').click(function(){
        var type = $(this).parents('.input-password').find('.input__default').attr('type') == "text" ? "password" : 'text';
        $(this).parents('.input-password').find('.input__default').prop('type', type);
        $(this).toggleClass('_active');
        return false;
    });

});
