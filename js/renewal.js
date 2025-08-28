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
    const item3n1 = $(".content-item:nth-child(3n+1)");
    const item3n = $(".content-item:nth-child(3n)");
    const item3n2 = $(".content-item:nth-child(3n+2)");

    // document.querySelectorAll(".content-item");
    item3n1.each(function (i, item) {
      const tl = gsap.timeline({
        scrollTrigger: {
          trigger: item,
          start: "top bottom",
          end: "75% bottom",
          scrub: 1,
        },
      });

      tl.from($(item).children(".content-item-container"), {
        rotate: "-15",
        opacity: 0,
        x: "-50%",
      });
    });

    item3n.each(function (i, item) {
      const tl = gsap.timeline({
        scrollTrigger: {
          trigger: item,
          start: "top bottom",
          end: "75% bottom",
          scrub: 1,
        },
      });

      tl.from($(item).children(".content-item-container"), {
        rotate: "15",
        opacity: 0,
        x: "50%",
      });
    });

    item3n2.each(function (i, item) {
      const tl = gsap.timeline({
        scrollTrigger: {
          trigger: item,
          start: "top bottom",
          end: "75% bottom",
          scrub: 1,
        },
      });

      tl.from($(item).children(".content-item-container"), {
        rotate: "15",
        opacity: 0,
        x: "50%",
      });
    });
  }

  const itemAniMb = () => {
    const item2n = $(".content-item:nth-child(2n)");
    const item2n1 = $(".content-item:nth-child(2n+1)");
    item2n.each(function (i, item) {
      const tl = gsap.timeline({
        scrollTrigger: {
          trigger: item,
          start: "25% 100%",
          end: "bottom 100%",
          scrub: 1,
        },
      });

      tl.from($(item).children(".content-item-container"), {
        rotate: "15",
        opacity: 0,
        x: "50%",
      });
    });
    item2n1.each(function (i, item) {
      const tl = gsap.timeline({
        scrollTrigger: {
          trigger: item,
          start: "25% 100%",
          end: "bottom 100%",
          scrub: 1,
        },
      });

      tl.from($(item).children(".content-item-container"), {
        rotate: "-15",
        opacity: 0,
        x: "-50%",
      });
    });
  };

  if (is_Pc) {
    itemAniPc();
  } else {
    itemAniMb();
  }
}
