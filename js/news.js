import { gsap } from './gsap/esm/index.js'
import { SplitText } from './gsap/esm/SplitText.js'
import { ScrollTrigger } from './gsap/esm/ScrollTrigger.js'
export default function newsJS() {

    var window_width = window.screen.width;
    var window_height = window.innerHeight;
    let vh = window.innerHeight * 0.01;

    document.documentElement.style.setProperty("--vh", `${vh}px`);
    gsap.registerPlugin(SplitText);
    gsap.registerPlugin(ScrollTrigger)


    //-- 自動下滑到列表畫面 --
    // if(window.scrollY==0){
    //     setTimeout(() => {
    //         gsap.to(window, { duration: 1, scrollTo: "#news_list" });
    //     }, 1500);
    // }

    $('.page-top').click(function () {
        $('html,body').animate({ scrollTop: 0 }, 800);
    });
   

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

    function itemAni() {
        let circle_item = document.querySelectorAll('.news-main .page-contaniner .page-content .item')

        if (window_width > 1024) {
            let gl = gsap.timeline({});
            gl.fromTo(circle_item, { y: 200 }, { y: 0, duration: 1, stagger: 0.2, ease: "power1.inOut" })

            circle_item.forEach((item, i) => {
                const item_font = item.querySelector('.item-font');
                const item_back = item.querySelector('.item-back-img');
                const item_content = item.querySelector('.back-content');
                const circle_svg = item.querySelector('.circle-svg text textPath');

                let tl = gsap.timeline({});
                tl
                    // .fromTo(circle_svg, { attr: { startOffset: "-30%", } }, { attr: { startOffset: "53%", }, duration: 1.2, ease: "power1.inOut" })
                    .fromTo(circle_svg, { attr: { textLength: "2500" } }, { attr: { textLength: "200" }, duration: 1.5, ease: "power1.inOut" })

            })
        }
    }
    // itemAni();

    function moblieItemAni() {


        let circle_item = document.querySelectorAll('.news-main .page-contaniner .page-content .item')
        let content = document.querySelector('.news-main .page-contaniner .page-content')
        let item_height = content.getBoundingClientRect().height;
        circle_item.forEach((item, i) => {
            const item_font = item.querySelector('.item-font');
            const item_back = item.querySelector('.item-back-img');
            const item_content = item.querySelector('.back-content');
            const circle_svg = item.querySelector('.circle-svg text textPath');

            // let tl = gsap.timeline({});
            // tl
            //     // .fromTo(circle_svg, { attr: { startOffset: "-30%", } }, { attr: { startOffset: "53%", }, duration: 1.2, ease: "power1.inOut" })
            //     .fromTo(circle_svg, { attr: { textLength: "2500" } }, { attr: { textLength: "200" }, duration: 1.5, ease: "power1.inOut" })


            let gl = gsap.timeline({
                scrollTrigger: {
                    trigger: item,
                    start: "top 100%",

                }
            });

            if (window_width <= 1024) {
                gl.fromTo(item, { y: 100 }, { y: 0, duration: 1, ease: "power1.inOut" })
                  .fromTo(circle_svg, { attr: { startOffset: "-80%", textLength: "5000" } }, { attr: { startOffset: "48%", textLength: circle_svg.getAttribute("data-length") }, duration: 1.4, ease: "power1.inOut" }, '<')
            } else if (window_width <= 1440) {

                gl.fromTo(item, { y: 300 }, { y: 0, duration: 1.2, ease: "power1.inOut" })
                  .fromTo(circle_svg,
                        { attr: { textLength: "2500" } },
                        { attr: { textLength: circle_svg.getAttribute("data-length") }, duration: 1.5, ease: "power1.inOut" }, '<')
            }
            else {
                gl.fromTo(item, { y: 300 }, { y: 0, duration: 1.2, ease: "power1.inOut" })
                  .fromTo(circle_svg, { attr: { textLength: "2500" } }, { attr: { textLength: circle_svg.getAttribute("data-length") }, duration: 1.5, ease: "power1.inOut" }, '<')
            }

        })

    }
    moblieItemAni();

    function itemHover() {
        let circle_item = document.querySelectorAll('.news-main .page-contaniner .page-content .item')

        if (window_width > 1100) {
            circle_item.forEach((item) => {
                const item_box = item.querySelector('.item-img');
                const item_font = item.querySelector('.item-font');
                const item_back = item.querySelector('.item-back-img');
                const item_content = item.querySelector('.back-content');
                const circle_svg = item.querySelector('.circle-svg text textPath');

                let tl = gsap.timeline({});
                item_box.addEventListener('mouseenter', () => {
                    itemMouseEnter(tl, item_font, item_back, item_content, circle_svg);

                });

                item_box.addEventListener('mouseleave', () => {
                    itemMouseLeave(tl, item_font, item_back, item_content);
                });
            })
        }
    }
    itemHover();

    function itemMouseEnter(tl, item_font, item_back, item_content, circle_svg) {
        if (tl.reversed()) {
            tl.play();
        }
        tl.to(item_font, { duration: 0.7, opacity: 0, ease: "power1.inOut", })
            .to(item_back, { duration: 0.7, opacity: 1, ease: "power1.inOut", }, '<0.3')
            .to(circle_svg, { duration: 1, attr: { startOffset: "140%", }, ease: "power1.inOut", }, '<')
            .to(item_content, { duration: 0.7, opacity: 1, ease: "power1.inOut", }, '<')

    }

    function itemMouseLeave(tl, item_font, item_back, item_content) {
        tl.reverse();
    }

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
            filter: 'blur(5px)',
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
    }
    newsTitleAni();
}