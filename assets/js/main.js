const scrollSwiper = new Swiper(".scroll-img", {
    loop: true,
    speed: 15000, // スクロールにかかる時間（数値を大きくするとゆっくり）
    allowTouchMove: false,
    slidesPerView: "auto",
    spaceBetween: 0,
    centeredSlides: false,
    autoplay: {
      delay: 0,
      disableOnInteraction: false,
    }
  });
  


const newsSwiper = new Swiper(".news-swiper", {
    loop: true,
    slidesPerView: 4,
    spaceBetween: 20,

});


document.addEventListener("DOMContentLoaded", function () {
    const items = document.querySelectorAll(".qa-item");

    items.forEach(item => {
        const dt = item.querySelector("dt");
        dt.addEventListener("click", function () {
            item.classList.toggle("open");
            dt.classList.toggle("active");
        });
    });
});


document.addEventListener("DOMContentLoaded", function () {
    const thumbs = document.querySelectorAll(".salon__mv--thumbs .thumb");
    const mainImage = document.querySelector(".salon__mv--right .main-image");

    thumbs.forEach(thumb => {
        thumb.addEventListener("click", function () {
            const bgImage = this.style.backgroundImage;
            mainImage.style.backgroundImage = bgImage;

            thumbs.forEach(t => t.classList.remove("active"));
            this.classList.add("active");
        });
    });
});



if (document.querySelector('.swiper-thumbs')) {
    new Swiper('.swiper-thumbs', {
        slidesPerView: 6,
        spaceBetween: 10,
        loop: true
    });
}


