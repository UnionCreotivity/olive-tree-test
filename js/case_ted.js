import Swiper from 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.mjs'

import { gsap } from './gsap/esm/index.js'
import { ScrollTrigger } from './gsap/esm/ScrollTrigger.js'

import {check_input, check_email, sw_success, sw_error} from './config.js'

export default function caseTedJS() {

    var window_width = window.screen.width;
    var window_height = window.innerHeight;
    let vh = window.innerHeight * 0.01;

    gsap.registerPlugin(ScrollTrigger);
    document.documentElement.style.setProperty("--vh", `${vh}px`);

    
    //-- 輪播圖背景 --
    $.each($('.gallery-top .swiper-wrapper .swiper-slide, .banner-box .banner .swiper-wrapper .swiper-slide'), function (index, valueOfElement) { 
         //console.log($(this))
         $(this).css('background-image', `url('${$(this).find('img').attr('src')}')`);  
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

    if (window_width <= 1024) {
        var galleryThumbs = new Swiper('.gallery-thumbs', {
            spaceBetween: 5,
            slidesPerView: 4,
            // loop: true,
        });
    } else {
        var galleryThumbs = new Swiper('.gallery-thumbs', {
            spaceBetween: 30,
            slidesPerView: 6,
            // loop: true,
        });
    }

    var galleryTop = new Swiper('.gallery-top', {
        spaceBetween: 30,
        loop: true,
        effect: "fade",
        speed: 500,
        // loopedSlides: 6, 
        navigation: {
            prevEl: '.main-banner-box-prev',
            nextEl: '.main-banner-box-next',
        },
        thumbs: {
            swiper: galleryThumbs,
        },
        pagination: {
            el: '.swiper-pagination',
        },
    });


    var video_swiper = new Swiper(".video-swiper", {
        navigation: {
            prevEl: '.video-banner-box-prev',
            nextEl: '.video-banner-box-next',
        },

        pagination: {
            el: '.swiper-pagination-video',
        },
        effect: "fade",
        on: {
            slideChangeTransitionStart: function () {

                $('.yt_player_iframe').each(function () {
                    var video_el_src = $(this).attr("src");
                    $(this).attr("src", video_el_src);
                });

            }
        },
    });


    $.each($('.banner-box .banner .swiper'), function (index, valueOfElement) { 
         
         const swiper = new Swiper(valueOfElement, {
            autoplay: {
                delay: 4000,
                disableOnInteraction: true,
            },
            loop: true,
            effect: "fade",
            speed:1200,
        });

        if(swiper.slides.length==1){
            $(this).find('.slider-controller').css('display','none');
        }

        $(this).find('.main-banner-box-prev').click(function (e) { 
            e.preventDefault();
            swiper.slidePrev();
        });
        $(this).find('.main-banner-box-next').click(function (e) { 
            e.preventDefault();
            swiper.slideNext();
        });
    });
    // const swiper1 = new Swiper(".swiper1", {
    //     autoplay: {
    //         delay: 4000,
    //         disableOnInteraction: true,
    //     },
    //     loop: true,
    //     effect: "fade",
    //     speed:1200,
    //     navigation: {
    //         prevEl: '.banner .main-banner-box-prev',
    //         nextEl: '.banner .main-banner-box-next',
    //     },
    // });
    // const swiper2 = new Swiper(".swiper2", {
    //     // autoplay: true,
    //     loop: true,
    //     effect: "fade",
    // });
    // const swiper3 = new Swiper(".swiper3", {
    //     // autoplay: true,
    //     loop: true,
    //     effect: "fade",
    // });
    // const swiper4 = new Swiper(".swiper4", {
    //     // autoplay: true,
    //     loop: true,
    //     effect: "fade",
    // });
    // const swiper5 = new Swiper(".swiper5", {
    //     // autoplay: true,
    //     loop: true,
    //     effect: "fade",
    // });

    function fixedVideoClose() {
        let swiper_close = document.querySelector('.swiper-close');

        if(swiper_close){
            var close_tl = gsap.timeline();

            swiper_close.addEventListener('click', () => {
                close_tl.to('.fixed-video-box',
                    {
                        opacity: 0,
                        duration: 1,
                        ease: "power1.inOut"
                    })
                    .to('.video-banner',
                        {
                            opacity: 0,
                            duration: 0.5,
                        }, '<').to('.fixed-video-box',
                            {
                                display: 'none',
                                duration: 1,
                                // height: '0vh',
                                ease: "power1.inOut"
                            }
                            , '<')
                    .to('.case-ted-contanier .banner-box',
                        {
                            opacity: 1,
                            duration: 1,
                            ease: "power1.inOut"
                        }
                        , '<')
                //-- 他的問題 --
                topBannerAni();

            });
        }
        else{
            topBannerAni();
        }
        
    }
    fixedVideoClose();

    function topBannerAni() {
        let tl = gsap.timeline({});
        if (window_width <= 1024) {
            tl
                // .to('.gallery-top', { duration: 1, opacity: 1, ease: "power1.inOut", }, '<')
                // .to('.swiper-thumbs', { duration: 1, opacity: 1, ease: "power1.inOut", }, '<')
                .fromTo('.card1 .moblie-title .title-box div', {
                    opacity: 0,
                    y: 40
                }, {
                    opacity: 1,
                    ease: "power1.inOut",
                    y: 0,
                    stagger: 0.2,
                    duration: 1,
                })
                .fromTo('.gallery-top,.swiper-thumbs', {
                    opacity: 0,
                    y: 50
                }, {
                    opacity: 1,
                    ease: "power1.inOut",
                    y: 0,
                    stagger: 0.15,
                    duration: 1,
                }, "<0.3")
                .fromTo('.card1 .moblie-case-content', {
                    opacity: 0,
                    y: 50
                }, {
                    opacity: 1,
                    ease: "power1.inOut",
                    y: 0,
                    duration: 1,
                }, '<0.2')
                .fromTo('.card1 .moblie-case-content-box .line-box', {
                    opacity: 0,
                    y: 50
                }, {
                    opacity: 1,
                    ease: "power1.inOut",
                    y: 0,
                    stagger: 0.15,
                    duration: 1,
                }, "<0.3")
                .fromTo('.card1 .moblie-case-content-box .bottom-box .text-box', {
                    opacity: 0,
                    y: 50
                }, {
                    opacity: 1,
                    ease: "power1.inOut",
                    y: 0,
                    stagger: 0.2,
                    duration: 1,
                }, '<0.3')
        }
        else {
            tl.fromTo('.gallery-top,.swiper-thumbs', {
                opacity: 0,
                y: 50
            }, {
                opacity: 1,
                ease: "power1.inOut",
                y: 0,
                stagger: 0.15,
                duration: 1,
            }).to('.case-name-box', { duration: 1, opacity: 1, ease: "power1.inOut", }, '<')
                .fromTo('.card1 .top-box .title-box div', {
                    opacity: 0,
                    y: 40
                }, {
                    opacity: 1,
                    ease: "power1.inOut",
                    y: 0,
                    stagger: 0.2,
                    duration: 1,
                }, '<')
                .fromTo('.card1 .top-box .line-box', {
                    opacity: 0,
                    y: 40
                }, {
                    opacity: 1,
                    ease: "power1.inOut",
                    y: 0,
                    duration: 1,
                }, '<0.3')
                .fromTo('.card1 .top-box .case-content', {
                    opacity: 0,
                    y: 40
                }, {
                    opacity: 1,
                    ease: "power1.inOut",
                    y: 0,
                    duration: 1,
                }, '<0.2')
                .fromTo('.card1 .case-name-box .bottom-box .text-box', {
                    opacity: 0,
                    y: 50,

                }, {
                    opacity: 1,
                    ease: "power1.inOut",
                    y: 0,
                    stagger: 0.15,
                    duration: 1,
                }, '<0.3')

        }

    }
    // topBannerAni();

    function bannerAni() {

        const boxes = gsap.utils.toArray('.banner-box');

        boxes.forEach(box => {
            const img = box.querySelectorAll('.swiper .swiper-slide img')

            let tl = gsap.timeline({
                scrollTrigger: {
                    trigger: box,
                    start: "top 90%",
                },
            });
            tl.fromTo(img, { scale: 1.2 }, { duration: 1, scale: 1, ease: "power1.inOut" })

        });


        boxes.forEach(box => {
            const boxes_title = box.querySelectorAll('.banner-content .title')
            const boxes_content = box.querySelectorAll('.banner-content .content')
            let tl = gsap.timeline({
                scrollTrigger: {
                    trigger: box,
                    start: "top 75%",
                },
            });
            if (window_width <= 1024) {
                tl.fromTo(boxes_title, { y: 50, opacity: 0 }, { duration: 1, y: 0, opacity: 1, ease: "power1.inOut" },)
                    .fromTo(boxes_content, { y: 50, opacity: 0 }, { duration: 1, y: 0, opacity: 1, ease: "power1.inOut" }, '<0.3')
            } else {
                tl.fromTo(boxes_title, { y: 70, opacity: 0 }, { duration: 1, y: 0, opacity: 1, ease: "power1.inOut" },)
                    .fromTo(boxes_content, { y: 70, opacity: 0 }, { duration: 1, y: 0, opacity: 1, ease: "power1.inOut" }, '<0.2')
            }


        });

    }
    bannerAni();


    function formAni() {

        let tl = gsap.timeline({
            scrollTrigger: {
                trigger: '.reserve-box',
                start: "top 80%",
            },
        });
        if (window_width <= 1024) {
            tl.fromTo('.reserve-box iframe', { y: 100, opacity: 0 }, { duration: 1, y: 0, opacity: 1, ease: "power1.inOut" },)
                .fromTo('.reserve-box .form-content', { y: 100, opacity: 0 }, { duration: 1, y: 0, opacity: 1, ease: "power1.inOut" }, '<0.3')
        } else {
            tl.fromTo('.reserve-box iframe', { y: 100, opacity: 0 }, { duration: 1, y: 0, opacity: 1, ease: "power1.inOut" },)
                .fromTo('.reserve-box .form-content', { y: 100, opacity: 0 }, { duration: 1, y: 0, opacity: 1, ease: "power1.inOut" }, '<')
        }
    }
    formAni();



    function contact_form () {
        

        $('#send-btn').click(function (e) { 
            e.preventDefault();
            let err_txt='';
            err_txt+=check_input('[name="aName"]', "姓名、");
            err_txt+=check_input('[name="aPhone"]', "電話");
            
            if(err_txt!=''){
                Swal.fire({...sw_error, text: `以下欄位為必填：${err_txt}`});
            }
            else if($('[name="aEmail"]').val()!='' && !check_email('[name="aEmail"]')){
                Swal.fire({...sw_error, text: `信箱格式錯誤`});
            }
            else{
                let url=new URL(location.href);
                $.ajax({
                    type: "POST",
                    url: "share_area/ajax/send_mail.php",
                    data:{
                      type:'reserve',
                      Tb_index: url.searchParams.get('Tb_index'),
                      aName: $('[name="aName"]').val(),
                      aEmail: $('[name="aEmail"]').val(),
                      aPhone: $('[name="aPhone"]').val(),
                      aMsg: $('[name="aMsg"]').val(),
                    },
                    dataType: "json",
                    success: function (data) {
                        if(data.success){
                            Swal.fire({...sw_success, text: data.msg});
                            $('input, textarea').val('');
                        }
                        else{
                            Swal.fire({...sw_error, text: data.msg});
                        }
                    }
                });
            }
            
        });
    }
    contact_form();


   
}