
import Swiper from 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.mjs'

import { gsap } from './gsap/esm/index.js'
import { SplitText } from './gsap/esm/SplitText.js'
import { ScrollTrigger } from './gsap/esm/ScrollTrigger.js'
export default function caseJS() {

    var window_width = window.screen.width;
    var window_height = window.innerHeight;
    let vh = window.innerHeight * 0.01;

    document.documentElement.style.setProperty("--vh", `${vh}px`);
    gsap.registerPlugin(SplitText);
    gsap.registerPlugin(ScrollTrigger)

    //-- 返回滑到列表畫面 --
    if(location.hash=='#case_list'){
        setTimeout(() => {
            gsap.to(window, { duration: 1, scrollTo: "#case_list" });
        }, 1500);
    }
  

    // function footerInsert() {
    //     var footer_div =
    //         `<div class="page-footer-info-moblie">
    //     <div class="copy-right">Copyright © 2023橄欖樹廣告行銷有限公司 版權所有</div>
    //     <div class="address">地址 ｜ 244新北市林口區忠孝路7號</div>
    //     <div class="phone">TEL | (02) 2606 8068</div>
    //     <div class="footer-icon-box">
    //         <div class="footer-icon footer-fb-box">
    //             <img src="../assets/images/header/footer_fb.png" alt="footer_fb" srcset="">
    //         </div>
    //         <div class="footer-icon footer-yt-box">
    //             <img src="../assets/images/header/footer_yt.png" alt="footer_yt" srcset="">
    //         </div>
    //         <div class="footer-icon footer-line-box">
    //             <img src="../assets/images/header/footer_line.png" alt="footer_line" srcset="">
    //         </div>
    //         <div class="footer-icon footer-email-box">
    //             <img src="../assets/images/header/footer_email.png" alt="footer_email" srcset="">
    //         </div>
    //     </div>
    // </div>`

    //     $('body').append(footer_div);
    // }
    // footerInsert();

    const swiper = new Swiper(".swiper", {
        slidesPerView: 2.5,
        // spaceBetween: 50,
        speed: 800,
        centeredSlides: true,
        // autoplay: {
        //     delay: 3000
        // },

        loop: true,
        effect: "creative",
        navigation: {
            prevEl: ".prev",
            nextEl: ".next"
        },
        creativeEffect: {

            prev: {
                translate: ["-92.45%", "50%", 0],
                opacity: "0",
                scale: 0.65,
            },
            next: {
                translate: ["92.45%", "-50%", 0],
                opacity: "0",
                scale: 0.65,
            },
            limitProgress: 1,
        },
        on: {

            slideChange: function () {
                const index_currentSlide = this.realIndex;
                const banner_text = document.querySelectorAll('.swiper .case-title-box');
                const banner_year = document.querySelectorAll('.swiper .case-sign-box .year-text-box .year');
                banner_text.forEach((text, index) => {

                    let tl = gsap.timeline({});
                    tl.to(text, { duration: 0.8, opacity: index === index_currentSlide ? 1 : 0, ease: "power1.inOut" });

                });

                banner_year.forEach((year, index) => {

                    let tl = gsap.timeline({});
                    tl.to(year, { duration: 0.8, opacity: index === index_currentSlide ? 1 : 0, ease: "power1.inOut" });

                });

            },

        },

    });


    function caseNameAni() {
        if (window_width <= 1024) {

            const boxes = gsap.utils.toArray('.case-box');

            boxes.forEach(box => {
                const img = box.querySelectorAll('.case-img')
                // const text = box.querySelectorAll('.case-title-box div')
                const name = box.querySelectorAll('.case-title-box .case-name')
                const title = box.querySelectorAll('.case-title-box .case-title')
                const more = box.querySelectorAll('.case-title-box .more-box')
                const sign = box.querySelectorAll('.case-sign-box')
                let tl = gsap.timeline({
                    scrollTrigger: {
                        trigger: box,
                        start: "top 90%",
                    },
                });
                tl.fromTo(img, { y: 50, opacity: 0 }, { duration: 1, y: 0, ease: "power1.inOut", opacity: 1 })
                    // .fromTo(text, { y: 50, opacity: 0 }, { duration: 1, y: 0, ease: "power1.inOut", stagger: 0.2, opacity: 1 }, '<0.3')
                    .fromTo(name, { y: 50, opacity: 0 }, { duration: 1, y: 0, ease: "power1.inOut", opacity: 1 }, '<0.3')
                    .fromTo(title, { y: 50, opacity: 0 }, { duration: 1, y: 0, ease: "power1.inOut", opacity: 1 }, '<0.3')
                    .fromTo(more, { y: 50, opacity: 0 }, { duration: 1, y: 0, ease: "power1.inOut", opacity: 1 }, '<0.3')
                    .fromTo(sign, { y: 50, opacity: 0 }, { duration: 1, y: 0, ease: "power1.inOut", stagger: 0.2, opacity: 1 }, '<')

            });

        } else {

            let tl = gsap.timeline({
                delay: 0.5,
                scrollTrigger: {
                    trigger: '.case-body .case-main .page-contaniner',
                    start: "top 70%",
                }
            });
            tl.from('.swiper', { duration: 1, y: 150, ease: "power1.inOut", })
        }
    }
    caseNameAni();

    function caseTitleAni() {
        let text = document.querySelectorAll('.case-title-svg');
        let zhTitle = gsap.utils.toArray(".page-title");
        let splitZhTitle = zhTitle.map(heading => new SplitText(heading, {
            type: "chars,words,lines", linesClass: "clip-text"
        }));
        console.log(splitZhTitle)
        let tl = gsap.timeline({
            scrollTrigger: {
                trigger: text,
                start: "top 80%",
            }
        });
        // tl.from(text, { y: -200, stagger: 0.1, duration: 0.8, })
        // tl.from(text, { y: gsap.utils.wrap([100, 100, 200, 300, 400, 500]), stagger: 0.1 })
        tl.from(text, {
            x: gsap.utils.wrap([-100, 100]),
            filter: 'blur(5px)',
            opacity: 0,
            duration: 1,
            // rotation: gsap.utils.wrap([-100, 100]),
            stagger: { each: 0.05, from: "start", },

        })
            .from(splitZhTitle[0].chars,
                {
                    y: -100,
                    stagger: { each: 0.05, from: 'start', },
                    opacity: 0,
                    duration: 1,

                }, '<0.3')

        // tl.from(text, {
        //     z: gsap.utils.wrap([-100, 100]),
        //     filter: 'blur(5px)',
        //     opacity: 0,
        // duration: 1,
        //     stagger: { each: 0.1, from: "start",  } // try center ;)
        // })



    }
    caseTitleAni()

}