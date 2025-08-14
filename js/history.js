import Swiper from 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.mjs'

import { gsap } from './gsap/esm/index.js'
import { SplitText } from './gsap/esm/SplitText.js'
import { ScrollTrigger } from './gsap/esm/ScrollTrigger.js'
import { ScrollToPlugin } from './gsap/esm/ScrollToPlugin.js'


export default function historyJS() {
    var window_width = window.screen.width;
    var window_height = window.innerHeight;
    let vh = window.innerHeight * 0.01;
    document.documentElement.style.setProperty("--vh", `${vh}px`);
    gsap.registerPlugin(ScrollTrigger);
    gsap.registerPlugin(SplitText);
    gsap.registerPlugin(ScrollToPlugin);


    //-- 返回滑到列表畫面 --
    if(location.hash=='#history_list'){
        setTimeout(() => {
            gsap.to(window, { duration: 1, scrollTo: "#history_list" });
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

    function hoverCard() {
        const history_cards = document.querySelectorAll('.history-card');

            history_cards.forEach((history_card) => {

                const history_card_font = history_card.querySelector('.history-card-font');
                const history_card_back = history_card.querySelector('.history-card-back');
                const history_card_a=history_card.querySelector('.link_a');

                let tl = gsap.timeline({});

                if($(window).width()>900){
                    history_card.addEventListener('mouseenter', () => {
                        enterHistoryCardAni(tl, history_card_font, history_card_back);
                    });
    
                    history_card.addEventListener('mouseleave', () => {
                        leaveHistoryCardAni(tl);
                    });
                }
                

                if($(window).width()>900){
                    history_card_a.addEventListener('click', (e) => {
                        let url= history_card_a.getAttribute('data-href')
                        barba.go(url);
                    });
                }
                else{
                    history_card_a.addEventListener('click', (e) => {
                        let url= history_card_a.getAttribute('data-href')
    
                        
                        if($(history_card_a).hasClass('back_a')){
                            $(history_card_a).removeClass('back_a');
                            barba.go(url);
                        }
                        else{
                            gsap.to('.back_a .history-card-back', { duration: 0.5, rotationY: '180', ease: "power1.inOut",})
                            gsap.to('.back_a .history-card-font', { duration: 0.5, rotationY: '0', ease: "power1.inOut", })
                            gsap.to(history_card_back, { duration: 0.5, rotationY: '0', ease: "power1.inOut",})
                            gsap.to(history_card_font, { duration: 0.5, rotationY: '-180', ease: "power1.inOut", })
                            $('.history-card .link_a').removeClass('back_a');
                            $(history_card_a).addClass('back_a');
                        }
                    });
                }
                
            })
        
    }
    hoverCard();

    function enterHistoryCardAni(tl, history_card_font, history_card_back) {

        if (tl.reversed()) {
            tl.play();
        }
        tl.to(history_card_back, { duration: 0.5, rotationY: '0', ease: "power1.inOut", }, "<")
          .to(history_card_font, { duration: 0.5, rotationY: '-180', ease: "power1.inOut", }, "<")

    }

    function leaveHistoryCardAni(tl) {
        tl.reverse();
    }
    if (window_width <= 500) {
        const swiper = new Swiper('.swiper', {
            speed: 800, loop: true,
            slidesPerView: 2,
            autoplay: {
                delay: 3000
            },
            centeredSlides: true,
            spaceBetween: 80,
            navigation: {
                prevEl: ".prev",
                nextEl: ".next"
            },
        })
    } else if (window_width <= 1024) {
        const swiper = new Swiper('.swiper', {
            speed: 800,
            loop: true,
            autoplay: {
                delay: 3000
            },
            slidesPerView: 2,
            centeredSlides: true,
            navigation: {
                prevEl: ".prev",
                nextEl: ".next"
            },
        })
    } else if (window_width <= 1920) {
        const swiper = new Swiper('.swiper', {
            slidesPerView: 4,
            spaceBetween: 0,
            speed: 800,
            spaceBetween: 0,
            autoplay: {
                delay: 3000
            },
            effect: "creative",
            creativeEffect: {

                prev: {
                    translate: ["-109.97%", "10%", 0],
                },
                next: {
                    translate: ["109.97%", "-10%", 0],
                },
                limitProgress: 4,
            },
            navigation: {
                prevEl: ".prev",
                nextEl: ".next"
            },
        })
    } else {
        const swiper = new Swiper('.swiper', {
            slidesPerView: 4,
            speed: 1000,
            spaceBetween: 0,
            autoplay: {
                delay: 3000
            },
            effect: "creative",
            creativeEffect: {

                prev: {
                    translate: ["-112.69%", "10%", 0],
                },
                next: {
                    translate: ["112.69%", "-10%", 0],
                },
                limitProgress: 4,
            },
            navigation: {
                prevEl: ".prev",
                nextEl: ".next"
            },
        })
    };


    function cardAni() {

        let tl = gsap.timeline({
            scrollTrigger: {
                trigger: '.main-container',
                start: "top 70%",
            },
        });

        // tl.from('.card-box .swiper-wrapper', { duration: 1, y: 150, ease: "power1.inOut", })
    }
    //cardAni();

    function historyTitleAni() {
        let text = document.querySelectorAll('.history-title-svg');
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
            filter: 'blur(5px)',
            opacity: 0,
            duration: 1,
            stagger: { each: 0.05, from: "start", }
        })
            .from(splitZhTitle[0].chars,
                {
                    y: -100,
                    stagger: { each: 0.05, from: 'start', },
                    opacity: 0,
                    duration: 1,

                }, '<0.3')



    }
    historyTitleAni();
}