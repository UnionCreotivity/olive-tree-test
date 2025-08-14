<?php 
//-- 共用連結 --
require 'share_area/conn.php';

$active=$pdo->select("SELECT * FROM appActive LIMIT 0,1", 'no', 'one');
// $aImg=IMG_URL.$news['aImg'].'?'.$news['update_num'];
?>

<!DOCTYPE html>
<html lang="zh-tw">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <title>最新活動</title>
    <title><?php echo $news['aTitle_one'].'｜'.$company['name'];?></title>
    <!-- FACEBOOK 分享資訊 -->
    <meta property="og:title" content="<?php echo $news['aTitle_one'].'｜'.$company['name'];?>" />
    <meta property="og:description" content="<?php echo substr(strip_tags($news['aTXT']), 0, 80);?>..." />
    <meta property="og:url" content="<?php echo NOW_URL;?>" />
    <meta itemprop="image" property="og:image" content="<?php echo $aImg;?>" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="<?php echo $news['aTitle_one'].'｜'.$company['name'];?>" />
    <meta itemprop="name" content="<?php echo $news['aTitle_one'].'｜'.$company['name'];?>" />
    <meta itemprop="description" content="<?php echo substr(strip_tags($news['aTXT']), 0, 80);?>..." />
    <meta name="description" content="<?php echo substr(strip_tags($news['aTXT']), 0, 80);?>..." />
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
        <div data-barba="container" data-barba-namespace="activity">
            
            <?php 
             //-- 共用MENU --
             require 'share_area/nav.php';
            ?>

            <div class="news-content-body">

                <div class="news-content-container">
                    <div class="banner">
                        <div class="swiper swiper1">
                            <div class="swiper-wrapper">
                                <?php
                                  $aSlide=explode(',', $active['aSlide']);
                                  foreach ($aSlide as $sOne) {
                                     $aImg=IMG_URL.$sOne.'?'.$active['update_num'];
                                     echo '<div class="swiper-slide">
                                                <img src="'.$aImg.'" alt="news_content1" srcset="">
                                            </div>';
                                  }
                                ?>

                                <!-- <div class="swiper-slide">
                                    <img src="assets/images/page_news_content/news_content1.webp" alt="news_content1" srcset="">
                                </div>
                                <div class="swiper-slide">
                                    <img src="assets/images/page_news_content/news_content2.webp" alt="news_content2"
                                        srcset="">
                                </div>
                                <div class="swiper-slide">
                                    <img src="assets/images/page_news_content/news_content3.webp" alt="news_content3"
                                        srcset="">
                                </div>
                                <div class="swiper-slide">
                                    <img src="assets/images/page_news_content/news_content4.webp" alt="news_content4"
                                        srcset="">
                                </div>
                                <div class="swiper-slide">
                                    <img src="assets/images/page_news_content/news_content5.webp" alt="news_content5"
                                        srcset="">
                                </div>
                                <div class="swiper-slide">
                                    <img src="assets/images/page_news_content/news_content6.webp" alt="news_content6"
                                        srcset="">
                                </div> -->
                            </div>

                            <div class="slider-arrow prev">
                                <img src="assets/images/page_news_content/prev.png" alt="prev" srcset="">
                            </div>
                            <div class="slider-arrow next">
                                <img src="assets/images/page_news_content/next.png" alt="next" srcset="">
                            </div>
                        </div>
                    </div>
                    <div class="content-box">

                        <div class="article-type">最新活動</div>
                        <div class="article-title"><?php echo $active['aTitle_one'];?></div>
                        <img class="article-line" src="assets/images/page_news_content/content_line.png"
                            alt="content_line" srcset="">
                        
                        <div class="txt">
                          <?php echo $active['aTXT'];?>
                        </div>
                        

                        <div class="bottom-box">
                            <div class="date-box">
                                撰文日期:<div class="date"><?php echo date('Y.m.d', strtotime($active['StartDate']));?></div>
                            </div>

                            <div class="return-box">

                                <a class="return-a" href="<?php echo NOW_HOST;?>">
                                    <img src="assets/images/page_news_content/return.png" alt="return" srcset="">
                                    返回前頁
                                </a>

                            </div>
                        </div>

                    </div>
                </div>
                <img class="bottom-tree-shadow" src="assets/images/page_news_content/tree_shadow.png"
                    alt="tree_shadow" srcset="">
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