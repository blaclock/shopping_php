const swiper = new Swiper('.mv', {
  // Optional parameters
  direction: 'horizontal',
  loop: true,
  speed: 1000,

  autoplay: {
    delay: 5000,
    disableOnInteraction: false,
  },

  effect: 'fade',
  fadeEffect: {
    crossFade: true
  },

  // If we need pagination
  pagination: {
    el: '.swiper-pagination',
  }

  ,

  // Navigation arrows
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  }
}
);

const hotItemsSlide = new Swiper('.hot-items', {
  // Optional parameters
  direction: 'horizontal',
  loop: true,
  loopedSlides: 2,
  speed: 1000,
  slidesPerView: 2.5,
  spaceBetween: 20,
  initialSlide: 0,

  breakpoints: {
    // スライドの表示枚数：500px以上の場合
    500: {
      slidesPerView: 2.5,
    }
  }
}
);
