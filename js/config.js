import { gsap } from './gsap/esm/index.js'

export default function configJS() {

    //-- 回首頁 --
    $('.home_link').click(function (e) { 
        e.preventDefault();
        sessionStorage['page']=true;
        const _this=$(this)
        setTimeout(() => {
            location.href=_this.attr('href')
        }, 300);
    });

    //-- 手機下拉MENU --
    function menuClick() {
        let menu_btn = document.querySelector('.menu-btn');
        let menu_box = document.querySelector('.menu-box');
        let menu_close = document.querySelector('.close');
        var menu_tl = gsap.timeline({
            paused: true
        });
        var menu_close_tl = gsap.timeline({
    
        });
    
        menu_tl.
            to(menu_box,
                {
                    duration: 0.5,
                    opacity: 1,
                    zIndex: 9999,
                    height: '100vh',
                    ease: "power1.inOut"
                }
            )
            .to('.menu .item',
                { duration: 1, opacity: 0.7, stagger: 0.2, ease: "power1.inOut", }, '<0.3')
    
            .fromTo(".menu-tree-shadow", {
                y: -10,
                x: -5,
                rotate: '-6deg',
            }, {
                y: 1,
                x: -10,
                rotate: '0deg',
                yoyo: true,
                repeat: -1,
                ease: "power1.inOut",
                duration: 2,
            }, '<')
    
    
        menu_btn.addEventListener('click', () => {
            menu_tl.play(0);
            $('body').css('overflow', 'hidden');
        });
    
        menu_close.addEventListener('click', () => {
            $('body').css('overflow', 'unset');
            menu_close_tl
                .to('.menu .item',
                    { duration: 0.7, opacity: 0, stagger: 0.2, ease: "power1.inOut", })
    
                .to(menu_box,
                    {
                        duration: 0.5,
                        opacity: 0,
                        zIndex: 0,
                        height: '0vh',
                        ease: "power1.inOut"
                    }
                    , '<0.3')
        });
    };
    menuClick();

}

// =============================== 檢查input ====================================
export function check_input(id,txt) {
    if ($(id).attr('type')=='radio' || $(id).attr('type')=='checkbox') {

    if($(id+':checked').val()==undefined){
    $(id).css('borderColor', 'red');
        return txt;
    }else{
        $(id).css('borderColor', 'rgba(0,0,0,0.1)');
        return "";
    }
    }else{
    if ($(id).val()=='') {
        $(id).css('borderColor', 'red');
        return txt;
    }else{
        $(id).css('borderColor', 'rgba(0,0,0,0.1)');
        return "";
    }
    }
}

//-- 判斷Email --
export function check_email(id) {
    if($(id).val().search(/^\w+(?:(?:-\w+)|(?:\.\w+))*\@\w+(?:(?:\.|-)\w+)*\.[A-Za-z]+$/)>-1){
        
        return true;
    }
    else{
        $(id).css('borderColor', 'red');
        return false;
    }
}

//-- sweetAlert 樣式 --
let confirmButtonColor='#4f563f';
export let sw_error={
    title: '錯誤!',
    icon: 'error',
    confirmButtonText: '關閉',
    confirmButtonColor: confirmButtonColor
    }
export let sw_success={
    title: '完成!',
    icon: 'success',
    confirmButtonText: '關閉',
    confirmButtonColor: confirmButtonColor
    }
