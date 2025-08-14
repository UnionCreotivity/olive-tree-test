<?php 
//-- 共用連結 --
require 'share_area/conn.php';

$article=$pdo->select("SELECT * FROM appArticle_sp3 WHERE mt_id='site2024031910443948' LIMIT 0,1", 'no', 'one');
?>

<!DOCTYPE html>
<html lang="zh-tw">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">

    <title><?php echo '建築規劃、設計｜'.$company['name'];?></title>
    <!-- FACEBOOK 分享資訊 -->
    <meta property="og:title" content="<?php echo '建築規劃、設計｜'.$company['name'];?>" />
    <meta property="og:description" content="<?php echo $company['description'];?>" />
    <meta property="og:url" content="<?php echo NOW_URL;?>" />
    <meta itemprop="image" property="og:image" content="<?php echo NOW_HOST.'img/share.jpg';?>" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="<?php echo '建築規劃、設計｜'.$company['name'];?>" />
    <meta itemprop="name" content="<?php echo '建築規劃、設計｜'.$company['name'];?>" />
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
        <div data-barba="container" data-barba-namespace="about_plan">
            
            <?php 
             //-- 共用MENU --
             require 'share_area/nav.php';
            ?>

            <div class="about-insidepage-body">
                <div class="about-insidepage-container">
                    <img class="tree-bg" src="../assets/images/page_about/olivetree_bg.png" alt="olivetree_bg"
                        srcset="">

                    <div class="content-box">
                        <div class="title-box">
                            <div class="title-img">
                                <img src="../assets/images/page_about/plan.svg" alt="plan" srcset="">
                            </div>
                            <div class="title">建築規劃、設計</div>
                            <div class="title-line">
                                <img class="title-line-pc" src="../assets/images/page_about/title_line.png"
                                    alt="title_line" srcset="">
                                <img class="title-line-moblie" src="../assets/images/page_about/title_line_moblie.svg"
                                    alt="title_line_moblie" srcset="">
                            </div>
                        </div>

                        <div class="content">

                            <?php echo $article['aTxt'];?>

                            <!-- <div class="text">我們對每塊土地充滿期待、我們熱衷與業主共同規劃、創意激盪，以身在一線面對客戶的敏鋭度，塑造出市場無可取代的稀有建築、
                                創造建案的最大價值，並吸引客戶認同。</div>
                            <img src="../assets/images/page_about/plan_photo.webp" alt="plan_photo" srcset="">
                            <div class="content-img-title">
                                <b>2020 林口區 森JIA</b>為每位住戶訂製門牌，以各戶不同的乾燥花妝點回家的風景
                            </div>
                            <img src="../assets/images/page_about/plan_photo2.webp" alt="plan_photo2" srcset="">
                            <div class="content-img-title">
                                <b>2023 林口區 森鉅旭</b>點亮建案屋頂，也是點亮了，我們在林口的家
                            </div> -->
                        </div>


                        <div class="bottom-box">
                            <div class="return-box">
                                <a class="return-a" href="./about.php#sectorbox">
                                    <img src="../assets/images/page_news_content/return.png" alt="return" srcset="">
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