<!-- footer -->
<div class="page-footer-info-moblie">
                <div class="copy-right">Copyright © 2023<?php echo $company['name']?> 版權所有</div>
                <div class="address">地址 ｜ <?php echo str_replace(',' ,'', $company['adds'])?></div>
                <div class="phone">TEL | <?php echo $company['phone']?></div>
                <div class="footer-icon-box">
                    <div class="footer-icon footer-fb-box">
                        <a href="<?php echo $company['fb_url']?>" target="_blank">
                            <img src="assets/images/header/footer_fb.png" alt="footer_fb" srcset="">
                        </a>
                    </div>
                    <div class="footer-icon footer-yt-box">
                        <a href="<?php echo $company['yt_url']?>" target="_blank">
                           <img src="assets/images/header/footer_yt.png" alt="footer_yt" srcset="">
                        </a>
                    </div>
                    <div class="footer-icon footer-line-box">
                        <a href="<?php echo $company['line_url']?>" target="_blank">
                            <img src="assets/images/header/footer_line.png" alt="footer_line" srcset="">
                        </a>
                        
                    </div>
                    <div class="footer-icon footer-email-box">
                      <a href="contact.php" >
                         <img src="assets/images/header/footer_email.png" alt="footer_email" srcset="">
                      </a>
                    </div>
                </div>
            </div>