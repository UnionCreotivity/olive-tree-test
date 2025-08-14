<?php 
//-- 共用連結 --
require 'share_area/conn.php';

$article=$pdo->select("SELECT * FROM appArticle_sp3 WHERE mt_id='site2024031910445746' LIMIT 0,1", 'no', 'one');
?>

<!DOCTYPE html>
<html lang="zh-tw">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">


    <title><?php echo '房地產行銷策劃｜'.$company['name'];?></title>
    <!-- FACEBOOK 分享資訊 -->
    <meta property="og:title" content="<?php echo '房地產行銷策劃｜'.$company['name'];?>" />
    <meta property="og:description" content="<?php echo $company['description'];?>" />
    <meta property="og:url" content="<?php echo NOW_URL;?>" />
    <meta itemprop="image" property="og:image" content="<?php echo NOW_HOST.'img/share.jpg';?>" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="<?php echo '房地產行銷策劃｜'.$company['name'];?>" />
    <meta itemprop="name" content="<?php echo '房地產行銷策劃｜'.$company['name'];?>" />
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
        <div data-barba="container" data-barba-namespace="about_marketing">

            <?php 
             //-- 共用MENU --
             require 'share_area/nav.php';
            ?>

            <div class="about-insidepage-body">
                <div class="about-insidepage-container">
                    <img class="tree-bg" src="assets/images/page_about/olivetree_bg.png" alt="olivetree_bg"
                        srcset="">

                    <div class="content-box">
                        <div class="title-box">
                            <div class="title-img">
                                <img src="assets/images/page_about/marketing.svg" alt="marketing" srcset="">
                            </div>
                            <div class="title">房地產行銷策劃</div>
                            <div class="title-line">
                                <img class="title-line-pc" src="assets/images/page_about/title_line.png"
                                    alt="title_line" srcset="">
                                <img class="title-line-moblie" src="assets/images/page_about/title_line_moblie.svg"
                                    alt="title_line_moblie" srcset="">
                            </div>
                        </div>

                        <div class="content">
                            <?php echo $article['aTxt'];?>
                            <!-- <div class="text">
                                我們特別重視客戶端感受，醉心於營造「接待會館」及「樣品屋」氛圍，進而呈現建案核心精神，體現不同於一般傳統代銷的創意思維。對我們來說，每一個建案都是一個全新的作品，力求獨樹一格且從不重複。
                            </div>
                            <img src="assets/images/page_about/marketing_photo.webp" alt="marketing_photo" srcset="">
                            <div class="content-img-title">
                                <b>2023 林口區 CLASSY HOME</b>精品簡約時尚風格 朗闊透明光亮 寫下「112年下半年雙北前三大案」紀錄
                            </div>
                            <img src="assets/images/page_about/marketing_photo2.webp" alt="marketing_photo2"
                                srcset="">
                            <div class="content-img-title">
                                <b>2023 林口區 森鉅旭</b>綠意環繞、陽光浸透 的靜謐之處 就是我們未來的家
                            </div>
                            <img src="assets/images/page_about/marketing_photo3.webp" alt="marketing_photo3"
                                srcset="">
                            <img src="assets/images/page_about/marketing_photo4.webp" alt="marketing_photo4"
                                srcset="">
                            <div class="content-img-title">
                                <b>2015 林口區 森達美術館</b>把未來規劃的公設完美鑲嵌進接待會館，現在未來，我們，都在美術館
                            </div>
                            <img src="assets/images/page_about/marketing_photo5.webp" alt="marketing_photo5"
                                srcset="">
                            <div class="content-img-title">
                                <b>2023 林口區 CLASSY HOME</b>頂客族最愛房型，樣品屋打破傳統格局及家具配置，吸睛難忘
                            </div> -->

                        </div>

                        <div class="bottom-box">
                            <div class="return-box">
                                <a class="return-a" href="./about.php#sectorbox">
                                    <img src="assets/images/page_news_content/return.png" alt="return" srcset="">
                                    返回前頁
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="page-top">
                        Top
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