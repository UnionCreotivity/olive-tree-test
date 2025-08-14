<?php 
//-- 共用連結 --
require 'share_area/conn.php';
?>

<!DOCTYPE html>
<html lang="zh-tw">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">


    <title><?php echo '聯絡我們｜'.$company['name'];?></title>
    <!-- FACEBOOK 分享資訊 -->
    <meta property="og:title" content="<?php echo '聯絡我們｜'.$company['name'];?>" />
    <meta property="og:description" content="<?php echo $company['description'];?>" />
    <meta property="og:url" content="<?php echo NOW_URL;?>" />
    <meta itemprop="image" property="og:image" content="<?php echo NOW_HOST.'img/share.jpg';?>" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="<?php echo '聯絡我們｜'.$company['name'];?>" />
    <meta itemprop="name" content="<?php echo '聯絡我們｜'.$company['name'];?>" />
    <meta itemprop="description" content="<?php echo $company['description'];?>" />
    <meta name="description" content="<?php echo $company['description'];?>" />
    <meta name="keywords" content="<?php echo $company['keywords'];?>" />
    <!-- 標準網址 -->
    <link rel="canonical" href="<?php echo NOW_URL;?>" />


    <?php 
        //-- 共用CSS --
        require 'share_area/css.php';
    ?>
</head>

<body>
    <div data-barba="wrapper">
        <div data-barba="container" data-barba-namespace="contact">
            
            <?php 
             //-- 共用MENU --
             require 'share_area/nav_dark.php';
            ?>

            <div class="contact-body">
                <div class="contact-video">
                    <video src="assets/images/page_contact/contact_video.mp4" autoplay loop muted
                        playsinline></video>
                </div>
                <div class="contact-contanier">
                    <div class="left-box">
                        <div class="title-box">
                            <div class="title-img">
                                <img src="assets/images/page_contact/contact-title.svg" alt="contact-title"
                                    srcset="">
                            </div>
                            <div class="title-text">聯 絡 我 們</div>
                        </div>

                        <div class="map-img">
                            <img src="assets/images/page_contact/contact-map.png" alt="contact-map" srcset="">
                        </div>
                    </div>
                    <div class="right-box">
                        <div class="top-text">
                            親愛的客戶您好，若有任何問題，歡迎透過留言表單或來電與橄欖樹廣告行銷聯絡，
                            我們將盡快與您聯繫，謝謝。
                        </div>
                        <div class="contact-form-box">
                            <form action="">
                                <div class="name-box input-box">
                                    <div class="name-title input-title">姓名</div>
                                    <input id="UserName" name="UserName" type="text">
                                </div>
                                <div class="phone-box input-box">
                                    <div class="phone-title input-title">電話</div>
                                    <input id="UserPhone" name="UserPhone" type="text">
                                </div>
                                <div class="email-box input-box">
                                    <div class="email-title input-title">信箱</div>
                                    <input id="UserMail" name="UserMail" type="email">
                                </div>
                                <div class="message-box input-box">
                                    <div class="message-title input-title">留言</div>
                                    <textarea name='UserMsg' id="UserMsg" spellcheck="true" id="wider" rows="5"></textarea>
                                </div>
                            </form>
                        </div>
                        <div class="contact-send-box">
                            <div class="check-box">
                                <input type="checkbox" name="" id="contact-checkbox">
                                <label for="contact-checkbox">送出並同意橄欖樹廣告行銷個資運用聲明</label>
                            </div>

                            <button id="contact-send">送出</button>
                        </div>
                        <div class="map-img-moblie">
                            <img src="assets/images/page_contact/contact-map.png" alt="contact-map" srcset="">
                        </div>
                    </div>
                </div>
            </div>
            
            <?php
              //-- 共用footer --
              require 'share_area/footer.php';
            ?>

        </div>
    </div>

    <?php 
        //-- 共用JS --
        require 'share_area/js.php';
    ?>

</body>
</html>