import Swiper from "https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.mjs";

import { gsap } from "./gsap/esm/index.js";
import { ScrollTrigger } from "./gsap/esm/ScrollTrigger.js";
import { SplitText } from "./gsap/esm/SplitText.js";

export default function renewalJS() {
  let vh = window.innerHeight * 0.01;
  document.documentElement.style.setProperty("--vh", `${vh}px`);
  gsap.registerPlugin(ScrollTrigger);
  gsap.registerPlugin(SplitText);

  const is_Pc = window.innerWidth > 1024;

  function newsTitleAni() {
    let text = document.querySelectorAll(".news-title-svg");
    let zhTitle = gsap.utils.toArray(".page-title");
    let splitZhTitle = zhTitle.map(
      (heading) =>
        new SplitText(heading, {
          type: "chars,words,lines",
          linesClass: "clip-text",
        })
    );
    let tl = gsap.timeline({
      scrollTrigger: {
        trigger: text,
        start: "top 80%",
      },
    });
    tl.from(text, {
      x: gsap.utils.wrap([-100, 100]),
      filter: "blur(5px)",
      opacity: 0,
      duration: 1,
      // rotation: gsap.utils.wrap([-100, 100]),
      stagger: { each: 0.05, from: "start" }, // try center ;)
    }).from(
      splitZhTitle[0].chars,
      {
        y: -100,
        stagger: { each: 0.05, from: "start" },
        opacity: 0,
        duration: 1,
      },
      "<0.3"
    );
  }
  newsTitleAni();

  function itemAniPc() {
    const item = $(".content-list .content-item");

    item.each(function (i, item) {
      const tl = gsap.timeline({
        scrollTrigger: {
          trigger: item,
          start: is_Pc ? "top bottom" : "5% bottom",
        },
      });
      tl.fromTo(
        item,
        { y: is_Pc ? 400 : 200 },
        { y: 0, duration: 1.5, ease: "power4.out" }
      ).from(
        $(item).find("img")[0],
        {
          scale: 1.5,
          duration: 1.25,
          ease: "power1.out",
        },
        "<+0.1"
      );
    });
  }

  itemAniPc();
}
