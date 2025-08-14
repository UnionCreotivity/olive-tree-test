import Swiper from 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.mjs'

import { gsap } from './gsap/esm/index.js'
import { ScrollTrigger } from './gsap/esm/ScrollTrigger.js'

export default function news_contentJS() {
    var window_width = window.screen.width;
    var window_height = window.innerHeight;
    let vh = window.innerHeight * 0.01;

    gsap.registerPlugin(ScrollTrigger);
    document.documentElement.style.setProperty("--vh", `${vh}px`);

   

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


    const swiper1 = new Swiper(".swiper1", {
        // autoplay: true,
        loop: true,
        effect: "fade",

        navigation: {
            prevEl: ".prev",
            nextEl: ".next"
        },
    });

    //-- 輪播圖背景 --
    $.each($('.swiper1 .swiper-wrapper .swiper-slide'), function (index, valueOfElement) { 
        //  console.log($(this))
         $(this).css('background-image', `url('${$(this).find('img').attr('src')}')`);  
    });

    $('.page-top').click(function () {
        $('html,body').animate({ scrollTop: 0 }, 800);
    });
    // $(window).scroll(function () {
    //     if ($(this).scrollTop() > 300) {
    //         $('.page-top').fadeIn(1222);
    //     } else {
    //         $('.page-top').stop();
    //     }
    // }).scroll();
}