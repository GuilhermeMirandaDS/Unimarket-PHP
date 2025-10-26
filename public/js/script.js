jQuery(document).ready(function(){
    if (jQuery('.banner-home .swiper-slide'.length > 1)){
        new Swiper('.banner-home .swiper', {
            preloadImages: false,
            loop: true,
            effect: 'slide',
            slidesPerView: 1,
            centeredSlides: true,
            spaceBetween: 10
        })
    }
})