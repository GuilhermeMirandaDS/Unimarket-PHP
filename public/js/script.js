jQuery(document).ready(function(){
    if (jQuery('.banner-home .swiper-slide'.length > 1)){
        new Swiper('.banner-home .swiper', {
            preloadImages: false,
            loop: true,
            effect: 'slide',
            autoplay: {
                delay: 5000,
                pauseOnMouseEnter: true
            },
            slidesPerView: 1,
            centeredSlides: true,
            spaceBetween: 10
        })
    };

    if (jQuery('.showcase .swiper-slide'.length > 1)){
        new Swiper('.showcase .swiper', {
            preloadImages: false,
            loop: true,
            effect: 'slide',
            slidesPerView: 5,
            spaceBetween: 10
        })
    };
    
})