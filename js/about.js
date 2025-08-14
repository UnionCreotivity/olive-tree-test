import { gsap } from './gsap/esm/index.js'
import { SplitText } from './gsap/esm/SplitText.js'
import { ScrollTrigger } from "./gsap/esm/ScrollTrigger.js";
import {ScrollToPlugin} from './gsap/esm/ScrollToPlugin.js'
import Swiper from 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.mjs'

export default function aboutJS() {

    var window_width = window.screen.width;
    var window_height = window.innerHeight;
    let vh = window.innerHeight * 0.01;

    document.documentElement.style.setProperty("--vh", `${vh}px`);
    gsap.registerPlugin(ScrollTrigger, SplitText, ScrollToPlugin)


    
    


    // function footerInsert() {
    //     var footer_div =
    //         `<div class="page-footer-info-moblie">
    //         <div class="copy-right">Copyright © 2023橄欖樹廣告行銷有限公司 版權所有</div>
    //         <div class="address">地址 ｜ 244新北市林口區忠孝路7號</div>
    //         <div class="phone">TEL | (02) 2606 8068</div>
    //         <div class="footer-icon-box">
    //             <div class="footer-icon footer-fb-box">
    //                 <img src="../assets/images/header/footer_fb.png" alt="footer_fb" srcset="">
    //             </div>
    //             <div class="footer-icon footer-yt-box">
    //                 <img src="../assets/images/header/footer_yt.png" alt="footer_yt" srcset="">
    //             </div>
    //             <div class="footer-icon footer-line-box">
    //                 <img src="../assets/images/header/footer_line.png" alt="footer_line" srcset="">
    //             </div>
    //             <div class="footer-icon footer-email-box">
    //                 <img src="../assets/images/header/footer_email.png" alt="footer_email" srcset="">
    //             </div>
    //         </div>
    //     </div>`

    //     $('body').append(footer_div);
    // }
    // footerInsert();

    function newsTitleAni() {
        let text = document.querySelectorAll('.news-title-svg');
        let zhTitle = gsap.utils.toArray(".page-title");
        let splitZhTitle = zhTitle.map(heading => new SplitText(heading, {
            type: "chars,words,lines", linesClass: "clip-text"
        }));
        let tl = gsap.timeline({
            scrollTrigger: {
                trigger: text,
                start: "top 80%",
            }
        });
        tl.from(text, {
            x: gsap.utils.wrap([-100, 100]),

            opacity: 0,
            duration: 1,
            // rotation: gsap.utils.wrap([-100, 100]),
            stagger: { each: 0.05, from: "start", } // try center ;)
        })
            .from(splitZhTitle[0].chars,
                {
                    y: -100,
                    stagger: { each: 0.05, from: 'start', },
                    opacity: 0,
                    duration: 1,

                }, '<0.3')
            .from('.about-tab',
                {
                    ease: "power1.inOut",
                    opacity: 0,
                    duration: 1.2,

                }, '<0.3')
            .from('.video-tab',
                {
                    ease: "power1.inOut",
                    opacity: 0,
                    duration: 1.2,
                }, '<')
            .from('.tab-line',
                {
                    ease: "power1.inOut",
                    opacity: 0,
                    duration: 1,
                }, '<')
    }
    newsTitleAni();

    $('.about-tab').click(function () {
        // $(".about-tab-container").fadeIn(1000);
        // $(".video-tab-container").fadeOut(1000);
        $('.tab-box div').removeClass('active');
        $('.tab-box .about-tab').addClass('active');
        let tl = gsap.timeline({})
        tl.to(".video-tab-container", { duration: 1, opacity: 0, ease: "power1.out", })
            .to(".video-tab-container", { duration: 1, display: 'none', ease: "power1.out", }, '<0.3')
            .to(".about-tab-container", { duration: 0.5, display: 'flex', ease: "power1.out", }, '<')
            .to(".about-tab-container", { duration: 0.5, opacity: 0, ease: "power1.out", }, '<')
            .to(".about-tab-container", { duration: 1, opacity: 1, ease: "power1.out", }, '<0.3')
        peaveVictoryTextAni();
        spiritAni();
        olivetreeAni();
        sectorAni();
        sectorTextAni();
        bottomImgAni();
        bottomOlivetreeAni();
    });

    function videoPageAni() {

        let tl = gsap.timeline({
            delay: 1
        });

        if (window_width <= 1024) {
            tl.from('.video-tab-container .title-box .title', {
                opacity: 1,
                duration: 1, ease: "power1.out",
            })
                .from('.video-tab-container .title-box .right-box', {
                    opacity: 1,
                    duration: 1, ease: "power1.out",
                }, '<0.9')
        } else {
            tl.from('.video-tab-container .title-box', {

                opacity: 1,
                duration: 1, ease: "power1.out",
            });

        }

    }

    function videoFiretTitleAni() {
        let zhTitle = gsap.utils.toArray(".video-tab-container .video-box .video-title .title");
        let zhIntroduce = gsap.utils.toArray(".video-tab-container .video-box .video-title .introduce");
        let splitZhTitle = zhTitle.map(heading => new SplitText(heading, {
            type: "chars,words,lines", linesClass: "clip-text"
        }));
        let splitZhIntroduce = zhIntroduce.map(heading => new SplitText(heading, {
            type: "chars,words,lines", linesClass: "clip-text"
        }));

        if (window_width <= 1024) {
            var videoFirstText_tl = gsap.timeline({
                scrollTrigger: {
                    trigger: '.video-tab-container .video-box .video-title',
                    start: "+=1",
                }
            });
        } else {
            var videoFirstText_tl = gsap.timeline({
                delay: 0.7
            });

        }

        videoFirstText_tl.from(splitZhTitle[0].chars, {
            y: 150,
            stagger: { each: 0.05, from: 'start' },
            opacity: 0,
            duration: 1,
        }).from(splitZhIntroduce[0].chars, {
            y: 150,
            stagger: { each: 0.05, from: 'start' },
            opacity: 0,
            duration: 1,
        }, '<0.3')

    }

    function videoAni() {
        let video = document.querySelectorAll('.video-tab-container .video-box');

        if (video.length > 1) {
            let zhTitle = gsap.utils.toArray(".video-tab-container .video-box .video-title .title");
            let splitZhTitle = zhTitle.map(heading => new SplitText(heading, {
                type: "chars,words,lines", linesClass: "clip-text"
            }));

            let zhIntroduce = gsap.utils.toArray(".video-tab-container .video-box .video-title .introduce");
            let splitZhIntroduce = zhIntroduce.map(heading => new SplitText(heading, {
                type: "chars,words,lines", linesClass: "clip-text"
            }));

            if (window_width <= 1024) {
                var videoText_tl = gsap.timeline({
                    scrollTrigger: {
                        trigger: '.video-tab-container .video-box .video-title',
                        start: "top center",
                        // markers:true
                    }
                });
            } else {
                var videoText_tl = gsap.timeline({
                    scrollTrigger: {
                        trigger: '.video-tab-container .video-box .video-title',
                        start: "top center",
                        // markers:true
                    }
                });
            }

            for (let i = 1; i < video.length; i++) {
                videoText_tl.from(splitZhTitle[i].chars, {
                    y: 150,
                    stagger: { each: 0.05, from: 'start' },
                    opacity: 0,
                    duration: 1,
                })
                    .from(splitZhIntroduce[i].chars, {
                        y: 150,
                        stagger: { each: 0.05, from: 'start' },
                        opacity: 0,
                        duration: 1,
                    }, '<0.3')
            }
        }
    }

    $('.video-tab').click(function () {
        // $(".video-tab-container").fadeIn(1000);
        // $(".about-tab-container").fadeOut(1000);
        $('.tab-box div').removeClass('active');
        $('.tab-box .video-tab').addClass('active');
        let tl = gsap.timeline({})
        tl.to(".about-tab-container", { duration: 1, opacity: 0, ease: "power1.out", })
            .to(".about-tab-container", { duration: 0.5, display: 'none', ease: "power1.out", }, '<0.3')
            .to(".video-tab-container", { duration: 0.5, display: 'flex', ease: "power1.out", }, '<')
            .to(".video-tab-container", { duration: 0.5, opacity: 0, ease: "power1.out", }, '<')
            .to(".video-tab-container", { duration: 1, opacity: 1, ease: "power1.out", })
        videoPageAni();
        videoFiretTitleAni();
        videoAni();
    });

    if($(window).width()>1024){
        let tab_box_tl=gsap.timeline({
            scrollTrigger: {
                toggleActions: 'play none reverse none',
                trigger: '.page-content',
                start: "top center",
                end: 'top center',
                // markers: true
            }
        })
        tab_box_tl.to('.tab-box', { x:'8vw', duration: 0.3, ease:'power.out3'})
    }
    
    const swiper = new Swiper(".service-swiper", {
        loop: true,

        navigation: {
            prevEl: ".slider-prev",
            nextEl: ".slider-next"
        },
        effect: "fade",
        fadeEffect: { crossFade: true },
        virtualTranslate: true,
        autoplay: {
            delay: 2500,
            disableOnInteraction: true,
        },
        speed: 1300,
        slidersPerView: 1,

    });

    const swiper2 = new Swiper(".bottom-swiper", {
        loop: true,
        slideToClickedSlide: true,
        effect: "fade",
        fadeEffect: { crossFade: true },
        virtualTranslate: true,
        autoplay: {
            delay: 2500,
            disableOnInteraction: true,
        },
        speed: 1000,
        slidersPerView: 1,

    });

    function clickLightBox() {
        let light_box_btn = document.querySelectorAll('.open-light-box');
        let light_box = document.querySelectorAll('.light-box');
        let light_bg = document.querySelector('.light-box-bg');
        let light_close = document.querySelectorAll('.light-box-close');

        light_box_btn.forEach((item, index) => {
            let lightbox_tl = gsap.timeline({}); // 定義區域變數 lightbox_tl

            item.addEventListener('click', (e) => {
                e.stopPropagation();
                if (lightbox_tl.reversed()) {
                    lightbox_tl.play();
                }
                lightbox_tl
                    .to(light_box[index], { duration: 1, display: 'flex', ease: "power1.inOut", })
                    .to(light_box[index], { duration: 1, opacity: 1, ease: "power1.inOut", }, '<')
                    .to(light_bg, { duration: 1, display: 'flex', opacity: 0.9, ease: "power1.inOut", }, '<');
            });
        });

        light_close.forEach((item, index) => {
            let lightbox_tl = gsap.timeline({}); // 定義區域變數 lightbox_tl
            item.addEventListener('click', (e) => {
                e.stopPropagation();
                lightbox_tl.to(light_box[index], { duration: 1, display: 'none', ease: "power1.inOut", })
                    .to(light_box[index], { duration: 1, opacity: 0, ease: "power1.inOut", }, '<')
                    .to(light_bg, { duration: 1, display: 'none', opacity: 0, ease: "power1.inOut", }, '<');
            });
        });
    }
    clickLightBox();

    function peaveVictoryTextAni() {
        let text = document.querySelectorAll('.peace-victory-svg');
        let peaceTextMoblie = document.querySelectorAll('.peace-cls-1');
        let victoryTextMoblie = document.querySelectorAll('.victory-cls-1');

        if (window_width <= 1024) {
            let tl = gsap.timeline({
                scrollTrigger: {
                    trigger: '.peace-victory-box',
                    start: "top 30%",
                }
            });

            tl.from(peaceTextMoblie, {
                y: gsap.utils.wrap([150, 150]),
                opacity: 0,
                duration: 0.7,
                // rotation: gsap.utils.wrap([-100, 100]),
                stagger: { each: 0.08, from: "start", }
            }).from(victoryTextMoblie, {
                y: gsap.utils.wrap([150, 150]),
                opacity: 0,
                duration: 0.7,
                stagger: { each: 0.08, from: "start", }
            }, '<0.2')

        } else {

            let tl = gsap.timeline({
                scrollTrigger: {
                    trigger: text,
                    start: "top 90%",
                }
            });

            tl.from(text, {
                y: gsap.utils.wrap([150, 150]),
                opacity: 0,
                duration: 0.7,
                // rotation: gsap.utils.wrap([-100, 100]),
                stagger: { each: 0.08, from: "start", }
            })
        }

        if (window_width <= 1024) {
            var content_tl = gsap.timeline({
                scrollTrigger: {
                    trigger: '.peace-victory-box',
                    start: "top 60%",
                }
            })
        } else {
            var content_tl = gsap.timeline({
                scrollTrigger: {
                    trigger: '.peace-victory-box',
                    start: "top 80%",
                }
            })
        }

        content_tl
            .from('.peace-victory-box .left-box .img-box1 ', {
                duration: 1.2,
                ease: "power1.in",
                opacity: 0
            })
            .from('.peace-victory-box .left-box .img-box2 ', {
                duration: 1.2,
                ease: "power1.in",
                opacity: 0
            }, '<')
            .from('.peace-victory-box .leaf-icon,.peace-victory-box .right-content .title-text', {
                y: 50,
                duration: 1,
                ease: "power1.inOut",
                opacity: 0
            }, '<')
            .from('.peace-victory-box .right-content .about_line', {
                y: 50,
                duration: 1,
                ease: "power1.inOut",
                opacity: 0
            }, '<0.3')
            .from('.peace-victory-box .right-content .content1', {
                y: 50,
                duration: 1,
                ease: "power1.inOut",
                opacity: 0
            }, '<0.3')
            .from('.peace-victory-box .right-content .content2', {
                y: 50,
                duration: 1,
                ease: "power1.inOut",
                opacity: 0
            }, '<0.3')


    }
    peaveVictoryTextAni();

    function spiritAni() {
        let openBoxes = document.querySelectorAll('.open-spirit-box');

        if (window_width <= 1024) {
            let tl = gsap.timeline({
                scrollTrigger: {
                    trigger: '.spirit-box',
                    start: "top 80%",
                }
            });
            tl.from('.spirit-box .title-box', {
                duration: 1,
                ease: "power1.inOut",
                opacity: 0,
                y: 40
            })
                .from('.spirit-tree-img', { duration: 1, opacity: 0, ease: "power1.inOut", }, '<0.3')
                .from('.open-light-box', { duration: 1, opacity: 0, ease: "power1.inOut", }, '<0.3')
                .from('.arrow1', { duration: 1, opacity: 0, x: -70, ease: "power1.inOut", }, '<0.15')
                .from('.arrow2', { duration: 1, opacity: 0, x: -70, ease: "power1.inOut", }, '<0.3')
                .from('.arrow3', { duration: 1, opacity: 0, x: -70, ease: "power1.inOut", }, '<0.3')
        } else {
            let tl = gsap.timeline({
                scrollTrigger: {
                    trigger: '.spirit-box',
                    start: "top 75%",
                }
            });
            tl.from('.spirit-box .title-box', {
                duration: 1, y: 70,
                ease: "power1.inOut",
                opacity: 0
            })
                .from('.spirit-tree-img', { duration: 1, opacity: 0, ease: "power1.inOut", }, '<0.3')
                .from('.open-spirit-box', { duration: 1, opacity: 0, ease: "power1.inOut", }, '<0.3')
        }

        openBoxes.forEach((box) => {
            box.addEventListener('mouseenter', () => {
                let openBox_tl = gsap.timeline({});
                openBox_tl.to(box.querySelector('.left-box'), { duration: 1, opacity: 1 })
                    .to(box.querySelector('.right-box .content'), { duration: 1, opacity: 1 }, '<')
            });

            box.addEventListener('mouseleave', () => {
                let openBox_tl = gsap.timeline({});
                openBox_tl.to(box.querySelector('.left-box'), { duration: 1, opacity: 0 })
                    .to(box.querySelector('.right-box .content'), { duration: 1, opacity: 0, }, '<')
            });
        });
        // let arrow_tl = gsap.timeline({
        //     scrollTrigger: {
        //         trigger: '.spirit-box',
        //         start: "top 85%",
        //     }
        // });



    }
    spiritAni();

    function olivetreeAni() {
        let text = document.querySelectorAll('.olivetree-svg-fill');

        if (window_width <= 1024) {
            var olivetree_tl = gsap.timeline({
                scrollTrigger: {
                    trigger: '.olivetree-box',
                    start: "top 80%",
                }
            });
        } else {
            var olivetree_tl = gsap.timeline({
                scrollTrigger: {
                    trigger: '.olivetree-box',
                    start: "top 70%",
                }
            });
        }

        olivetree_tl.from(text, {
            y: gsap.utils.wrap([150, 150]),
            opacity: 0,
            duration: 1,
            stagger: { each: 0.08, from: "start", }
        })
            .from('.olivetree-box .right-box .content', {
                duration: 1,
                ease: "power1.inOut",
                opacity: 0,
                y: 50,
            }, '<0.3')
            .from('.olivetree-box .left-box .img1-moblie', {
                duration: 1,
                ease: "power1.inOut",
                opacity: 0,
            }, '<0.3')


    }
    olivetreeAni();

    function sectorAni() {
        let sector = document.querySelectorAll('.sector-item-box');
        let sectorImg = document.querySelectorAll('.sector-item-img');
        let sectorTextImg = document.querySelectorAll('.sector-text-svg');
        let sectorTextWhiteImg = document.querySelectorAll('.sector-text-white-svg');
        let whiteCircleImg = document.querySelectorAll('.white-circle');
        let circleImg = document.querySelectorAll('.line-circle');

        sector.forEach((item, index) => {
            item.addEventListener('mouseenter', () => {
                animateImage(sectorImg[index], whiteCircleImg[index], circleImg[index], sectorTextImg[index], sectorTextWhiteImg[index], 1);
            });
            item.addEventListener('mouseleave', () => {
                animateImage(sectorImg[index], whiteCircleImg[index], circleImg[index], sectorTextImg[index], sectorTextWhiteImg[index], 0);
            });
        });

        function animateImage(img, whiteCircle, greenCircle, sectorTextImg, sectorTextWhiteImg, opacity) {
            let tl = gsap.timeline({});
            tl.to(img, { duration: 1, opacity: opacity, zIndex: opacity ? 10 : 0, ease: "power1.inOut" })
                .to(whiteCircle, { duration: 1, opacity: opacity, zIndex: opacity ? 10 : 0, ease: "power1.inOut" }, '<')
                .to(greenCircle, { duration: 1, opacity: opacity ? 0 : 1, ease: "power1.inOut" }, '<')
                .to(sectorTextImg, { duration: 1, opacity: opacity ? 0 : 1, ease: "power1.inOut" }, '<')
                .to(sectorTextWhiteImg, { duration: 1, opacity: opacity ? 1 : 0, ease: "power1.inOut" }, '<');
        }
    }
    sectorAni();

    function sectorTextAni() {
        let targetsSvg = [
            document.querySelectorAll('.research-cls-1'),
            document.querySelectorAll('.position-cls-1'),
            document.querySelectorAll('.plan-cls-1'),
            document.querySelectorAll('.marketing-cls-1')
        ];
        let targetsTitle = [
            document.querySelectorAll('.research-title .title'),
            document.querySelectorAll('.position-title .title'),
            document.querySelectorAll('.plan-title .title'),
            document.querySelectorAll('.marketing-title .title')
        ];

        let tl = gsap.timeline({
            scrollTrigger: {
                trigger: '.about-tab-container .sector-box',
                start: "top 60%",
            }
        });
        let animationOptions = {
            y: gsap.utils.wrap([150, 150]),
            opacity: 0,
            duration: 1,
            stagger: { each: 0.08, from: "start" },
            ease: "power1.inOut",
        };

        targetsSvg.forEach(elements => {
            tl.from(elements, animationOptions, "<");
        });

        targetsTitle.forEach(elements => {
            tl.from(elements, { opacity: 0, y: 50, duration: 1, ease: "power1.inOut" }, "<0.3");
        });

        let title_tl = gsap.timeline({
            scrollTrigger: {
                trigger: '.about-tab-container .sector-box',
                start: "top 70%",
            }
        });

        if (window_width <= 1024) {
            title_tl.from('.sector-box .title-box .title-img', { y: 50, duration: 1, opacity: 0, ease: "power1.inOut" })
                .from('.sector-box .title-box .title-moblie', { y: 50, duration: 1, opacity: 0, ease: "power1.inOut" }, '<0.2')
        } else {
            title_tl.from('.sector-box .title-box .title-img', { y: 100, duration: 1, opacity: 0, ease: "power1.inOut" })
                .from('.sector-box .title-box .title', { y: 100, duration: 1, opacity: 0, ease: "power1.inOut" }, '<0.2')
        }


    }
    sectorTextAni();

    function bottomImgAni() {
        let left = document.querySelector('.bottom-img-box .left-box')
        // let middle = document.querySelector('.bottom-img-box .middle-box')
        let right = document.querySelector('.bottom-img-box .right-box')

        left.addEventListener('mouseenter', () => {
            let tl = gsap.timeline({});
            tl.to(left, { duration: 1.5, width: '76%', ease: "power1.inOut", })
        });

        left.addEventListener('mouseleave', () => {
            let tl = gsap.timeline({});
            tl.to(left, { duration: 1.5, width: '25%', ease: "power1.inOut", })
        });

        // middle.addEventListener('mouseenter', () => {
        //     let tl = gsap.timeline({});
        //     tl.to(middle, { duration: 1, width: '100%', ease: "power1.inOut", })
        // });

        // middle.addEventListener('mouseleave', () => {
        //     let tl = gsap.timeline({});
        //     tl.to(middle, { duration: 1, width: '60%', ease: "power1.inOut", })
        // });


        right.addEventListener('mouseenter', () => {
            let tl = gsap.timeline({});
            tl.to(right, { duration: 1.5, width: '100%', ease: "power1.inOut", })
        });

        right.addEventListener('mouseleave', () => {
            let tl = gsap.timeline({});
            tl.to(right, { duration: 1.5, width: '25%', ease: "power1.inOut", })
        });

    }
    bottomImgAni();

    function bottomOlivetreeAni() {

        let tl = gsap.timeline({
            scrollTrigger: {
                trigger: '.bottom-img-box',
                start: "top 65%",
            }
        });
        if (window_width <= 1024) {
            tl.from('.bottom-img-box .bottom-swiper .title-box .title', {
                y: 100,
                opacity: 0,
                duration: 1,
            })
                .from('.bottom-img-box .bottom-swiper .content-box .content', {
                    y: 100,
                    opacity: 0,
                    duration: 1,
                }, '<0.3')
        } else {
            tl.from('.middle-box .title-box .title', {
                y: 150,
                opacity: 0,
                duration: 1,
            })
                .from('.middle-box .content-box .content', {
                    y: 150,
                    opacity: 0,
                    duration: 1,
                }, '<0.3')
        }


    }
    bottomOlivetreeAni();

}