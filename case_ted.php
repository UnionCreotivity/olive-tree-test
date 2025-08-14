<?php 
//-- 共用連結 --
require 'share_area/conn.php';

$db_name='appCase';
//-- 判斷暫存 --
if(!empty($_GET['temporary_storage']) && $_GET['temporary_storage']=='1'){
  $db_name='appCase_ts';
}
$case=$pdo->select("SELECT * FROM $db_name WHERE Tb_index =:Tb_index", ['Tb_index'=>$_GET['Tb_index']], 'one');
$ca_t_img1=IMG_URL.$case['ca_t_img1'].'?'.$case['update_num'];
?>

<!DOCTYPE html>
<html lang="zh-tw">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">

    <title><?php echo $case['ca_name'].'｜'.$company['name'];?></title>
    <!-- FACEBOOK 分享資訊 -->
    <meta property="og:title" content="<?php echo $case['ca_name'].'｜'.$company['name'];?>" />
    <meta property="og:description" content="<?php echo substr(strip_tags($case['ca_txt']), 0, 80);?>..." />
    <meta property="og:url" content="<?php echo NOW_URL;?>" />
    <meta itemprop="image" property="og:image" content="<?php echo $ca_t_img1;?>" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="<?php echo $case['ca_name'].'｜'.$company['name'];?>" />
    <meta itemprop="name" content="<?php echo $case['ca_name'].'｜'.$company['name'];?>" />
    <meta itemprop="description" content="<?php echo substr(strip_tags($case['ca_txt']), 0, 80);?>..." />
    <meta name="description" content="<?php echo substr(strip_tags($case['ca_txt']), 0, 80);?>..." />
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
        <div data-barba="container" data-barba-namespace="case_ted">
            
            <?php 
             //-- 共用MENU --
             if($case['is_dark']=='1'){
                require 'share_area/nav_dark.php';
             }
             else{
                require 'share_area/nav.php';
             }
            ?>

            <div class="case-ted-body <?php echo $case['is_dark']=='1' ? 'dark-case-ted-body':'';?>">

                <?php
                  if(!empty($case['ca_pop_type'])){

                    if($case['ca_pop_type']=='1'){
                        $ca_pop_img=IMG_URL.$case['ca_pop_img'].'?'.$case['update_num'];
                        $Html='<img src="'.$ca_pop_img.'" alt="">';
                    }
                    else{
                        $ca_pop_video=explode('youtu.be/', $case['ca_pop_video']);
                        $Html='<iframe id="youtube_player" class="yt_player_iframe" width="640" height="360"
                                src="https://www.youtube.com/embed/'.$ca_pop_video[1].'"
                                allowfullscreen="true" allowscriptaccess="always" frameborder="0"></iframe>';
                    }
                    
                    echo '<div class="fixed-video-box">
                            <div class="video-banner-box">
                                <div class="video-banner">
                                    <div class="swiper video-swiper">
                                        <div class="swiper-wrapper">
                                            <div class="swiper-slide">
                                                '.$Html.'
                                            </div>
                                        </div>
                                        <div class="swiper-pagination-video"></div>
                                    </div>
                                </div>
                                <div class="swiper-close">
                                    <img src="assets/images/page_case_ted/video_banner_close.svg" alt="" srcset="">
                                </div>
                                <div class="slider-controller">
                                    <div class="slider-arrow video-banner-box-prev">
                                        <img src="assets/images/page_case/prev.png" alt="prev" srcset="">
                                    </div>
                                    <div class="slider-arrow video-banner-box-next">
                                        <img src="assets/images/page_case/next.png" alt="next" srcset="">
                                    </div>
                                </div>
                            </div>
                        </div>';
                  }

                ?>


                
                <div class="case-ted-contanier">

                    <div class="card1">
                        <div class="moblie-title">
                            <div class="title-box">
                                <div class="case-name dark-case-name">
                                    <?php echo $case['ca_name'];?>
                                </div>
                                <div class="case-title dark-case-title">
                                    <?php echo $case['ca_s_text'];?>
                                </div>

                            </div>
                        </div>
                        <div class="main-banner-box">
                            <div class="swiper-container gallery-top">
                                <div class="swiper-wrapper">
                                    <?php
                                      $ca_slide=explode(',', $case['ca_slide']);
                                      foreach ($ca_slide as $slide) {
                                        $slideImg=IMG_URL.$slide.'?'.$case['update_num'];
                                        echo '<div class="swiper-slide" >
                                                <img src="'.$slideImg.'" alt="'.$case['ca_name'].'banner" srcset="">
                                            </div>';
                                      }
                                    
                                    ?>
                                    <!-- <div class="swiper-slide">
                                        <img src="assets/images/page_case_ted/banner1.webp" alt="banner1" srcset="">
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="assets/images/page_case_ted/banner2.webp" alt="banner2" srcset="">
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="assets/images/page_case_ted/banner3.webp" alt="banner2" srcset="">
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="assets/images/page_case_ted/banner4.webp" alt="banner2" srcset="">
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="assets/images/page_case_ted/banner5.webp" alt="banner2" srcset="">
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="assets/images/page_case_ted/banner1.webp" alt="banner2" srcset="">
                                    </div> -->
                                </div>
                                <div class="slider-controller">
                                    <div class="slider-arrow main-banner-box-prev">
                                        <img src="assets/images/page_case/prev.png" alt="prev" srcset="">
                                    </div>
                                    <div class="slider-arrow main-banner-box-next">
                                        <img src="assets/images/page_case/next.png" alt="next" srcset="">
                                    </div>
                                </div>

                            </div>
                            <div class="swiper-container gallery-thumbs">
                                <div class="swiper-wrapper">
                                    <?php
                                        $ca_slide=explode(',', $case['ca_slide']);
                                        foreach ($ca_slide as $slide) {
                                            $slideImg=IMG_URL.$slide.'?'.$case['update_num'];
                                            echo '<div class="swiper-slide" >
                                                    <img src="'.$slideImg.'" alt="'.$case['ca_name'].'小banner" srcset="">
                                                </div>';
                                        }
                                    ?>
                                    <!-- <div class="swiper-slide">
                                        <img src="assets/images/page_case_ted/banner1.webp" alt="banner1" srcset="">
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="assets/images/page_case_ted/banner2.webp" alt="banner2" srcset="">
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="assets/images/page_case_ted/banner3.webp" alt="banner2" srcset="">
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="assets/images/page_case_ted/banner4.webp" alt="banner2" srcset="">
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="assets/images/page_case_ted/banner5.webp" alt="banner2" srcset="">
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="assets/images/page_case_ted/banner1.webp" alt="banner2" srcset="">
                                    </div> -->

                                </div>
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>

                        <div class="moblie-case-content-box">
                            <div class="moblie-case-content">
                                <?php echo $case['ca_txt'];?>
                            </div>

                            <div class="line-box">
                                <img src="assets/images/page_case_ted/horizonta_line_moblie.png"
                                    alt="horizonta_line_moblie" srcset="">
                            </div>

                            <div class="bottom-box">
                                <div class="text-box">
                                    <div class="title">建案類型</div>
                                    <div class="content"><?php echo $case['ca_type'];?></div>
                                </div>
                                <div class="text-box">
                                    <div class="title">座落地點</div>
                                    <div class="content"><?php echo $case['ca_area'];?></div>
                                </div>
                                <div class="text-box">
                                    <div class="title">投資建設</div>
                                    <div class="content"><?php echo $case['ca_invest'];?></div>
                                </div>
                                <div class="text-box">
                                    <div class="title">坪數規劃</div>
                                    <div class="content"><?php echo $case['ca_square'];?></div>
                                </div>
                                <?php
                                  if($case['mt_id']=='site2023080912315936'){
                                    echo '<div class="text-box">
                                            <div class="title">諮詢專線</div>
                                            <div class="content">'.$case['ca_phone'].'</div>
                                        </div>
                                        <div class="text-box">
                                            <div class="title">接待會館</div>
                                            <div class="content">'.$case['ca_adds'].'</div>
                                        </div>';
                                  }
                                ?>
                                
                            </div>
                        </div>
                        <div class="right-box">
                            <div class="case-name-box">
                                <div class="topBottomBox">
                                    <div class="top-box">
                                        <div class="title-box">
                                            <div class="case-name">
                                                <?php echo $case['ca_name'];?>
                                            </div>
                                            <div class="case-title">
                                                <?php echo $case['ca_s_text'];?>
                                            </div>
                                        </div>
                                        <div class="line-box">
                                            <img src="assets/images/page_case_ted/horizonta_line.png"
                                                alt="horizontal_line" srcset="">
                                        </div>
                                        <div class="case-content">
                                            <?php echo nl2br($case['ca_txt'], false);?>
                                            <!-- 時間研磨、建築烘焙，<br>
                                            每個人都要好好愛自己為出發點，<br>
                                            創造不受限的理想生活。 -->
                                        </div>
                                    </div>
                                    <div class="bottom-box">
                                        <div class="text-box">
                                            <div class="title">建案類型</div>
                                            <div class="content"><?php echo $case['ca_type'];?></div>
                                        </div>
                                        <div class="text-box">
                                            <div class="title">座落地點</div>
                                            <div class="content"><?php echo $case['ca_area'];?></div>
                                        </div>
                                        <div class="text-box">
                                            <div class="title">投資建設</div>
                                            <div class="content"><?php echo $case['ca_invest'];?></div>
                                        </div>
                                        <div class="text-box">
                                            <div class="title">坪數規劃</div>
                                            <div class="content"><?php echo $case['ca_square'];?></div>
                                        </div>

                                        <?php
                                        if($case['mt_id']=='site2023080912315936'){
                                            echo '<div class="text-box">
                                                    <div class="title">諮詢專線</div>
                                                    <div class="content">'.$case['ca_phone'].'</div>
                                                </div>
                                                <div class="text-box">
                                                    <div class="title">接待會館</div>
                                                    <div class="content">'.$case['ca_adds'].'</div>
                                                </div>';
                                        }
                                        ?>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tree-shadow">
                        <img src="assets/images/page_case_ted/tree-shadow.png" alt="tree-shadow" srcset="">
                    </div>

                    <?php
                      $txt_db_name='appCase_txt';
                      //-- 判斷暫存 --
                      if(!empty($_GET['temporary_storage']) && $_GET['temporary_storage']=='1'){
                        $txt_db_name='appCase_txt_ts';
                      }
                      $appCase_txt=$pdo->select("SELECT * FROM $txt_db_name WHERE case_id=:case_id ORDER BY OrderBy", ['case_id'=>$case['Tb_index']]);
                      foreach ($appCase_txt as $txt) {

                        $slide_html='';

                        if($txt['media_type']=='0'){
                            $aPic=explode(',', $txt['aPic']);
                            foreach ($aPic as $pOne) {
                                $imgUrl=IMG_URL.$pOne.'?'.$case['update_num'];
                                $slide_html.='<div class="swiper-slide">
                                                <img src="'.$imgUrl.'" alt="banner" srcset="">
                                            </div>';
                            }
                        }
                        else{
                            $aVideo=explode('youtu.be/', $txt['aVideo']);
                            $slide_html.='<div class="swiper-slide">
                                                <div class="video">
                                                    <iframe class="yt-player-iframe"
                                                        src="https://www.youtube.com/embed/'.$aVideo[1].'"
                                                        allowfullscreen="true" allowscriptaccess="always"
                                                        frameborder="0"></iframe>
                                                </div>
                                          </div>';
                        }
                        

                        echo '<div class="banner-box ">
                                    <div class="banner">
                                        <div class="swiper ">
                                            <div class="swiper-wrapper">
                                                '.$slide_html.'
                                            </div>
                                            <div class="slider-controller">
                                                <div class="slider-arrow main-banner-box-prev">
                                                    <img src="assets/images/page_case/prev.png" alt="prev" srcset="">
                                                </div>
                                                <div class="slider-arrow main-banner-box-next">
                                                    <img src="assets/images/page_case/next.png" alt="next" srcset="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="banner-content">
                                        <div class="title">'.$txt['aTitle'].'</div>
                                        <div class="content">
                                          '.nl2br($txt['aTxt'], false).'
                                        </div>
                                    </div>
                                </div>';
                      }
                    ?>
                  <div class="bottom-box">
                            <div class="return-box">
                                <a class="return-a" href="<?php echo $case['mt_id']=='site2023080912315936' ? 'case.php#case_list': 'history.php#history_list' ;?> ">
                                    <img src="../assets/images/page_news_content/return.png" alt="return" srcset="">
                                    返回前頁
                                </a>
                            </div>
                        </div>

                    <div class="reserve-box">
                        <?php
                          if(!empty($case['ca_map'])){
                            echo $case['ca_map'];
                          }


                        ?>
   
                        <div class="form-box" style="display:<?php echo $case['is_msg']=='1' ? 'blcok':'none';?>;">
                            <div class="form-content">
                                <div class="form-title">預約賞屋</div>
                                <div class="line-box">
                                    <img src="assets/images/page_case_ted/reserve_line.png" alt="reserve_line"
                                        srcset="">
                                </div>
                                <form action="">
                                    <div class="name-box input-box">
                                        <div class="name-title input-title">姓名</div>
                                        <input id="aName" name="aName" type="text">
                                    </div>
                                    <div class="phone-box input-box">
                                        <div class="phone-title input-title">電話</div>
                                        <input id="aPhone" name="aPhone" type="text">
                                    </div>
                                    <div class="email-box input-box">
                                        <div class="email-title input-title">信箱</div>
                                        <input id="aEmail" name="aEmail" type="email">
                                    </div>
                                    <div class="message-box input-box">
                                        <div class="message-title input-title">留言</div>
                                        <textarea name='aMsg' id="aMsg" spellcheck="true" id="wider" rows="5"></textarea>
                                    </div>
                                </form>
                                <div class="button-box">
                                    <button id="send-btn">確認</button>
                                </div>
                            </div>

                        </div>

                        <div class="tree-shadow-moblie">
                            <img src="assets/images/page_case_ted/tree-shadow.png" alt="tree-shadow" srcset="">
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