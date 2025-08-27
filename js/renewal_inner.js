import Swiper from "https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.mjs";

import { ScrollTrigger } from "./gsap/esm/ScrollTrigger.js";

export default function renewal_innerJS() {
  let vh = window.innerHeight * 0.01;
  document.documentElement.style.setProperty("--vh", `${vh}px`);
  $(window).on("load", function () {
    const swiperDataSet = () => {
      const topSlides = $(".renewal-inner-top-swiper .swiper-slide");
      let index = 0;

      topSlides.each((i, el) => {
        el.dataset.id = i;
      });

      const bottomSlides = $(".renewal-inner-bottom-swiper .swiper-slide");
      bottomSlides.each((i, el) => {
        el.dataset.id = i;
      });
    };
    swiperDataSet();

    const swiperRender = () => {
      const swiperTop = new Swiper(".renewal-inner-top-swiper", {
        spaceBetween: 10,
        speed: 1500,
        navigation: {
          nextEl: ".cut-top-next",
          prevEl: ".cut-top-prev",
        },
      });

      const swiperBottom = new Swiper(".renewal-inner-bottom-swiper", {
        spaceBetween: 20,
        slidesPerView: 4,
        slidesPerGroup: 3,
        navigation: {
          nextEl: ".cut-bottom-next",
          prevEl: ".cut-bottom-prev",
        },
        breakpoints: {
          1024: {
            slidesPerView: 6,
            slidesPerGroup: 3,
          },
        },
        on: {
          init: function () {
            //初始第一個swiper透明度
            const bottomSlides = $(
              ".renewal-inner-bottom-swiper .swiper-slide"
            );
            bottomSlides.each((i, el) => {
              const elId = $(el).data("id");
              if (elId == 0) {
                $(el).css("opacity", "1");
              }
            });
          },
          click: function (swiper) {
            //連動大swiper圖片
            const activeId = swiper.clickedSlide.dataset.id;
            const topSlides = $(".renewal-inner-top-swiper .swiper-slide");
            topSlides.each((i, el) => {
              const elId = $(el).data("id");
              if (elId == activeId) {
                swiperTop.slideTo(elId, 1000);
              }
            });

            //重置透明度
            const bottomSlides = $(
              ".renewal-inner-bottom-swiper .swiper-slide"
            );
            bottomSlides.each((i, el) => {
              $(el).css("opacity", "0.5");
            });

            $(swiper.clickedSlide).css("opacity", "1");
          },
        },
      });
    };
    swiperRender();
  });
}
