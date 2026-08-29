(function($){

    "use strict";

    function stickyHeader() {
        if ($('header').length) {
            var strickyScrollPos = $('header').next().offset().top;
            if($(window).scrollTop() > strickyScrollPos) {
                $('header').addClass('sticky');
                $('body').addClass('sticky');
            }
            else if($(window).scrollTop() <= strickyScrollPos) {
                $('header').removeClass('sticky');
                $('body').removeClass('sticky');
            }
        };
    }

    $(window).load(function() {

        // Preloader
        $('#status').fadeOut();
        $('#preloader').delay(350).fadeOut('slow');
        $('body').delay(350).css({
            'overflow': 'visible'
        });

        // Animation in animate.css
        new WOW().init();

        // Mix It Up
        $("#mix-container").mixItUp();

        // Carousel - Payment Promotions
        $('.payment-promo-carousel').owlCarousel({
            loop: true,
            autoplay: true,
            autoplayTimeout: 6500,
            autoplayHoverPause: true,
            smartSpeed: 650,
            margin: 24,
            dots: true,
            nav: true,
            responsiveClass: true,
            navText: [
                '<i class="fa fa-angle-left"></i>',
                '<i class="fa fa-angle-right"></i>'
            ],
            responsive: {
                0: {
                    items: 1,
                    margin: 16
                },
                600: {
                    items: 2,
                    margin: 20
                },
                992: {
                    items: 3,
                    margin: 24
                }
            }
        });

        $('#promo-event-carousel').on('slide.bs.carousel', function(event) {
            var nextIndex = $(event.relatedTarget).index() + 1;
            $(this).find('.promo-event-current').text(('0' + nextIndex).slice(-2));
        });

        $('#promo-event-carousel').on('slide.bs.carousel', function(event) {
    var nextIndex = $(event.relatedTarget).index() + 1;
    $(this).find('.promo-event-current').text(('0' + nextIndex).slice(-2));
});

(function () {
    var $carousel = $('#promo-event-carousel');
    if (!$carousel.length) return;

    var startX = 0, isDragging = false, threshold = 50;

    function dragStart(e) {
	if (e.type === 'mousedown') {
		e.preventDefault(); // <-- INI YANG BARU, mencegah native image-drag browser
	}
	isDragging = true;
	startX = (e.type === 'touchstart') ? e.originalEvent.touches[0].clientX : e.clientX;
	$carousel.carousel('pause');
}

    function dragEnd(e) {
        if (!isDragging) return;
        isDragging = false;
        var endX = (e.type === 'touchend') ? e.originalEvent.changedTouches[0].clientX : e.clientX;
        var diff = endX - startX;

        if (Math.abs(diff) > threshold) {
            diff < 0 ? $carousel.carousel('next') : $carousel.carousel('prev');
        }
        $carousel.carousel('cycle');
    }

    $carousel.on('touchstart mousedown', '.promo-event-visual', dragStart);
    $carousel.on('touchend mouseup mouseleave', '.promo-event-visual', dragEnd);

    $carousel.on('click', '.promo-event-visual', function (e) {
        if (Math.abs(e.clientX - startX) > threshold) {
            e.preventDefault();
        }
    });
})();


        // Carousel - Atorney
        $('.team-member-carousel').owlCarousel({
            loop: true,
            autoplay: true,
            margin: 30,
            dots: false,
            animateIn: true,
            responsiveClass: true,
            navText: [
            '<i class="fa fa-angle-left"></i>',
            '<i class="fa fa-angle-right"></i>'
            ],
            responsive:{
                0:{
                    items:1,
                    nav:true
                },
                600:{
                    items:3,
                    nav:true
                },
                1000:{
                    items:4,
                    nav:true,
                    loop:true
                }
            }
        });

        // Carousel - News
        $('.news-carousel').owlCarousel({
            loop: true,
            autoplay: true,
            margin: 30,
            dots: false,
            animateIn: true,
            responsiveClass: true,
            navText: [
            '<i class="fa fa-angle-left"></i>',
            '<i class="fa fa-angle-right"></i>'
            ],
            responsive:{
                0:{
                    items:1,
                    nav:true
                },
                600:{
                    items:3,
                    nav:true
                },
                1000:{
                    items:4,
                    nav:true,
                    loop:true
                }
            }
        });

        // Carousel - Testimonial (Version 1)
        $('.testimonial-carousel').owlCarousel({
            loop: true,
            autoplay: true,
            margin: 15,
            dots: false,
            animateIn: true,
            responsiveClass: true,
            navText: [
            '<i class="fa fa-angle-left"></i>',
            '<i class="fa fa-angle-right"></i>'
            ],
            responsive:{
                0:{
                    items:1,
                    nav:true
                },
                600:{
                    items:1,
                    nav:true
                },
                1000:{
                    items:1,
                    nav:true,
                    loop:true
                }
            }
        });

        // Carousel - Testimonial (Version 2)
        $('.testimonial-carousel-2').owlCarousel({
            loop: true,
            autoplay: true,
            margin: 15,
            dots: true,
            animateIn: true,
            responsiveClass: true,
            navText: [
            '<i class="fa fa-angle-left"></i>',
            '<i class="fa fa-angle-right"></i>'
            ],
            responsive:{
                0:{
                    items:1,
                    nav:false
                },
                600:{
                    items:2,
                    nav:false
                },
                1000:{
                    items:2,
                    nav:false,
                    loop:true
                }
            }
        });

        // Carousel - Partner
        $('.partner-carousel').owlCarousel({
            loop: true,
            autoplay: true,
            margin: 25,
            dots: false,
            animateIn: true,
            responsiveClass: true,
            navText: [
            '<i class="fa fa-angle-left"></i>',
            '<i class="fa fa-angle-right"></i>'
            ],
            responsive:{
                0:{
                    items:1,
                    nav:false
                },
                600:{
                    items:3,
                    nav:false
                },
                1000:{
                    items:5,
                    nav:false,
                    loop:true
                }
            }
        });

        // Carousel - Gallery
        $('.gallery-carousel').owlCarousel({
            loop: true,
            autoplay: true,
            margin: 15,
            dots: false,
            animateIn: true,
            responsiveClass: true,
            navText: [
            '<i class="fa fa-angle-left"></i>',
            '<i class="fa fa-angle-right"></i>'
            ],
            responsive:{
                0:{
                    items:1,
                    nav:true
                },
                600:{
                    items:1,
                    nav:true
                },
                1000:{
                    items:1,
                    nav:true,
                    loop:true
                }
            }
        });

        // Responsive Menu
        $(".sf-menu").slicknav({
            delay:       1000,
            animation:   {opacity:'show',height:'show'},
            speed:       'fast',
            autoArrows:  false
        });

        // Superfish Menu
        $("#sf-example").superfish({
            pathLevels: 1,
            delay: 800,
            animation: {opacity: 'show'},
            animationOut: {opacity: 'hide'},
            speed: 'fast',
            speedOut: 'fast',
            cssArrows: true,
            disableHI: false,
        });

        // Magnific Popup
        $('.gallery-photo').magnificPopup({
            type: 'image'
        });

        $('.payment-promo-image-popup').magnificPopup({
            type: 'image',
            closeOnContentClick: true,
            mainClass: 'mfp-fade',
            removalDelay: 180,
            image: {
                verticalFit: true,
                titleSrc: 'title'
            }
        }); // <-- DI SINI PERBAIKANNYA (Kurung tertutup yang tadi hilang)

        // Click event to scroll to top
        $('.scrollup').on("click",function(){
            $('html, body').animate({scrollTop : 0},800);
            return false;
        });

        $('.counter').counterUp({
            delay: 10,
            time: 1000
        });

    });

})(jQuery);