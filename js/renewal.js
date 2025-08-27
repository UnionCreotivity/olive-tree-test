import Swiper from "https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.mjs";

import { gsap } from "./gsap/esm/index.js";
import { ScrollTrigger } from "./gsap/esm/ScrollTrigger.js";

export default function renewalJS() {
  let vh = window.innerHeight * 0.01;
  document.documentElement.style.setProperty("--vh", `${vh}px`);
  gsap.registerPlugin(ScrollTrigger);

  const is_Pc = window.innerWidth > 1024;

  function itemAni() {
    const item = document.querySelectorAll(".content-item");
    item.forEach((item) => {
      const tl = gsap.timeline({
        scrollTrigger: {
          trigger: item,
          start: "top 100%",
        },
      });
      tl.from(item, {
        y: is_Pc ? 200 : 100,
        duration: 1,
        ease: "power1.inOut",
      });
    });
  }
  itemAni();
}
