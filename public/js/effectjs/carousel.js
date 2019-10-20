$(document).ready(function() {
    $('.center').slick({
        dots: false,
        infinite: true,
        speed: 300,
        slidesToShow: 4,
        variableWidth: false,
        slidesToScroll: 1,
    });
    $('.center-3-slider').slick({
        dots: false,
        infinite: true,
        speed: 300,
        slidesToShow: 3,
        variableWidth: false,
        slidesToScroll: 1,
    });
    $('slick-active').css('opacity','1');

    $('.res-slick').slick({
        dots: false,
        infinite: false,
        speed: 300,
        slidesToShow: 4,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    infinite: true,
                    dots: true
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
        ]
    });

});
