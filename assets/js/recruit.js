// assets/js/recruit.js
document.addEventListener('DOMContentLoaded', () => {
    new Swiper('.recruit-gallery-swiper', {
        loop: true,
        speed: 800,
        autoplay: { delay: 5000 },
        slidesPerView: 1,
        spaceBetween: 0,
        breakpoints: {
            768: { slidesPerView: 3 }
        },
        pagination: {
            el: '.recruit-gallery-pagination',
            clickable: true,
        },
    });
});
