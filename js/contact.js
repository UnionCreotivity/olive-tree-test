import {check_input, check_email, sw_success, sw_error} from './config.js'

export default function contactJS() {


    setTimeout(() => {
        $('body').css('height', 'auto');
        $('body').css('overflow', 'auto');
    }, 500);
    

    var window_width = window.screen.width;
    var window_height = window.innerHeight;
    let vh = window.innerHeight * 0.01;

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


    $('#contact-send').click(function (e) { 
        e.preventDefault();
        let err_txt='';
        err_txt+=check_input('[name="UserName"]', "姓名、");
        err_txt+=check_input('[name="UserPhone"]', "電話");
        
        if(err_txt!=''){
            Swal.fire({...sw_error, text: `以下欄位為必填：${err_txt}`});
        }
        else if($('[name="UserMail"]').val()!='' && !check_email('[name="UserMail"]')){
            Swal.fire({...sw_error, text: `信箱格式錯誤`});
        }
        else if(!$('#contact-checkbox').is(":checked")){
            Swal.fire({...sw_error, text: `請勾選同意橄欖樹廣告行銷個資運用聲明`});
        }
        else{
            let url=new URL(location.href);
            $.ajax({
                type: "POST",
                url: "share_area/ajax/send_mail.php",
                data:{
                  type:'contact_us',
                  UserName: $('[name="UserName"]').val(),
                  UserMail: $('[name="UserMail"]').val(),
                  UserPhone: $('[name="UserPhone"]').val(),
                  UserMsg: $('[name="UserMsg"]').val(),
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