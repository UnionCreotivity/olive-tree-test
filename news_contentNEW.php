<?php 
//-- 共用連結 --
require 'share_area/conn.php';

$db_name='appNews';
//-- 判斷暫存 --
if(!empty($_GET['temporary_storage']) && $_GET['temporary_storage']=='1'){
  $db_name='appNews_ts';
}
$news=$pdo->select("SELECT * FROM $db_name WHERE Tb_index =:Tb_index", ['Tb_index'=>$_GET['Tb_index']], 'one');
$aImg=IMG_URL.$news['aImg'].'?'.$news['update_num'];
?>

<!DOCTYPE html>
<html lang="zh-tw">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">

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
        <div data-barba="container" data-barba-namespace="news_content">
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
                                  $aSlide=explode(',', $news['aSlide']);
                                  foreach ($aSlide as $sOne) {
                                     $imgUrl=IMG_URL.$sOne.'?'.$news['update_num'];
                                     echo '<div class="swiper-slide">
                                                <img src="'.$imgUrl.'" alt="'.$news['aTitle_one'].'" srcset="">
                                            </div>';
                                  }
                                ?>
                                <!-- <div class="swiper-slide">
                                    <img src="assets/images/page_news_content/news_content1.webp" alt="news_content1"
                                        srcset="">
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

                        <div class="article-type">最新消息</div>
                        <div class="article-title"><?php echo $news['aTitle_one'];?></div>
                        <img class="article-line" src="assets/images/page_news_content/content_line.png"
                            alt="content_line" srcset="">
                        <div class="txt">
                          <?php echo $news['aTXT'];?>
                        </div>
                        
                        <!-- <div class="content">
                            
                            疫情重創傳統在地商圈，新北工務局規畫「府中雙城」連結新舊城區，注入更多藝文元素，也盼振興商圈；今並與新北市建築師公會攜手，於府中商圈舉辦新北建築設計展，除展覽出新北各建築手繪圖及建案內容外，也說明府中雙城改造成果。

                            今活動由新北工務局長祝惠美、新北建築師公會理事長崔懋森及常務監事李魁相共同主持開幕，工務局、都更處、新北建築師公會及參與板橋府中區公辦都更的建築師事務所-上圓聯合建築師事務所、奧宇國際聯合建築師事務所，以「府中雙城為例的城市發展探討」為主題，和現場民眾都市更新建築沙龍對談，希望透過不同聲音的交流，了解城市更新的重要性。
                        </div>

                        <img src="assets/images/page_news_content/news_content2.webp" alt="" srcset="">

                        <div class="content">
                            疫情重創傳統在地商圈，新北工務局規畫「府中雙城」連結新舊城區，注入更多藝文元素，也盼振興商圈；今並與新北市建築師公會攜手，於府中商圈舉辦新北建築設計展，除展覽出新北各建築手繪圖及建案內容外，也說明府中雙城改造成果。

                            今活動由新北工務局長祝惠美、新北建築師公會理事長崔懋森及常務監事李魁相共同主持開幕，工務局、都更處、新北建築師公會及參與板橋府中區公辦都更的建築師事務所-上圓聯合建築師事務所、奧宇國際聯合建築師事務所，以「府中雙城為例的城市發展探討」為主題，和現場民眾都市更新建築沙龍對談，希望透過不同聲音的交流，了解城市更新的重要性。
                        </div>

                        <img src="assets/images/page_news_content/news_content3.webp" alt="" srcset="">

                        <div class="content">
                            疫情重創傳統在地商圈，新北工務局規畫「府中雙城」連結新舊城區，注入更多藝文元素，也盼振興商圈；今並與新北市建築師公會攜手，於府中商圈舉辦新北建築設計展，除展覽出新北各建築手繪圖及建案內容外，也說明府中雙城改造成果。

                            今活動由新北工務局長祝惠美、新北建築師公會理事長崔懋森及常務監事李魁相共同主持開幕，工務局、都更處、新北建築師公會及參與板橋府中區公辦都更的建築師事務所-上圓聯合建築師事務所、奧宇國際聯合建築師事務所，以「府中雙城為例的城市發展探討」為主題，和現場民眾都市更新建築沙龍對談，希望透過不同聲音的交流，了解城市更新的重要性。
                        </div> -->

                        <div class="bottom-box">
                            <div class="date-box">
                                撰文日期:<div class="date"><?php echo date('Y.m.d', strtotime($news['StartDate']));?></div>
                            </div>

                            <div class="return-box">

                                <a class="return-a" href="news.php#news_list">
                                    <img src="assets/images/page_news_content/return.png" alt="return" srcset="">返回前頁
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