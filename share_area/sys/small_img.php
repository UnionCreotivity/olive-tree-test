<?php

if (!empty($_GET['aes'])) {
    
    $url_aes=urldecode($_GET['aes']);
    $url_aes=str_replace(' ','+',$url_aes);
	  $aes=aes_decrypt(date('Ymd'), $url_aes);

    $data=explode('||', $aes);

	if (count($data)>1) {

		$type=explode('.', $data[0]);
		$type=$type[count($type)-1];

		if ($type=='jpg' || $type=='jpeg') {
			ecstart_convert_jpeg_NEW($data[0],null,$data[1],$data[2]);
		}
		elseif($type=='png'){
       ecstart_convert_png_NEW($data[0],null,$data[1],$data[2]);
		}
		
	}
	else{
	echo'aes error';
	exit();
}
	
}
else{
	echo'NO GET';
	exit();
}




//-------------------------------- 資料AES解密 --------------------------------------
function aes_decrypt($key, $unlock_data)
{ 
  $hash = hash('SHA384', $key, true);
  $app_cc_aes_key = substr($hash, 0, 32);
  $app_cc_aes_iv = substr($hash, 32, 16);

  $encrypt=base64_decode($unlock_data);
  $data = openssl_decrypt($encrypt, 'aes-128-cbc', $app_cc_aes_key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $app_cc_aes_iv);
  //-- PHP 7-1棄用 --
  //$data = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $app_cc_aes_key, $encrypt, MCRYPT_MODE_CBC, $app_cc_aes_iv);
  $padding = ord($data[strlen($data) - 1]);
  $decrypt_text = substr($data, 0, -$padding);
  return $decrypt_text;
}

//--------------------------- 縮圖程式 JPG -------------------------
function ecstart_convert_jpeg_NEW($src_file,$dst_file,$pic_width,$quality){

//$src_file 來源圖片路徑
//$dst_file 存檔圖片路徑
//$Orientation 圖片轉向代碼
//$pic_width 存檔圖片寬度 
//$pic_height 存檔圖片高度
$image = imagecreatefromjpeg($src_file) ;

$s_width = imagesx($image);
$s_height = imagesy($image);
// 縮圖高
$pic_height=round($pic_width/($s_width/$s_height));
// 縮圖大小

if ($s_width>$pic_width) {
  $thumb = imagecreatetruecolor($pic_width, $pic_height);
  // 自動縮圖
  imagecopyresized($thumb, $image, 0, 0, 0, 0, $pic_width, $pic_height, $s_width, $s_height);
}
else{
  $thumb = imagecreatetruecolor($s_width, $s_height);
  // 自動縮圖
  imagecopyresized($thumb, $image, 0, 0, 0, 0, $s_width, $s_height, $s_width, $s_height);
}


//imagejpeg($thumb,"/tmp/tmpfile.jpg","100");
//$thumbimage = imagecreatefromjpeg("/tmp/tmpfile.jpg") ;

//======== 圖片轉向 ==============
$exif = exif_read_data($src_file);

if (!empty($exif['Orientation'])) {
switch ($exif['Orientation']) {
case 3:
$thumb = imagerotate($thumb, 180, 0);
break;
case 6:
$thumb = imagerotate($thumb, -90, 0);
break;
case 8:
$thumb = imagerotate($thumb, 90, 0);
break;
}
}
//============ 圖片轉向 END ========

imagejpeg($thumb,$dst_file,$quality);

imagedestroy($thumb);
imagedestroy($image);
}




//--------------------------- 縮圖程式 PNG -------------------------
function ecstart_convert_png_NEW($src_file,$dst_file,$pic_width,$quality){

//$src_file 來源圖片路徑
//$dst_file 存檔圖片路徑
//$Orientation 圖片轉向代碼
//$pic_width 存檔圖片寬度 
//$pic_height 存檔圖片高度
$image = imagecreatefrompng($src_file) ;

$s_width = imagesx($image);
$s_height = imagesy($image);
// 縮圖高
$pic_height=round($pic_width/($s_width/$s_height));
// 縮圖大小

if ($s_width>$pic_width) {
  $thumb = imagecreatetruecolor($pic_width, $pic_height);
  $color = imagecolorallocatealpha($thumb, 0, 0, 0, 127);
  imagefill($thumb, 0, 0, $color);
  // 自動縮圖
  imagecopyresized($thumb, $image, 0, 0, 0, 0, $pic_width, $pic_height, $s_width, $s_height);
}
else{
  $thumb = imagecreatetruecolor($s_width, $s_height);
  $color = imagecolorallocatealpha($thumb, 0, 0, 0, 127);
  imagefill($thumb, 0, 0, $color);
  // 自動縮圖
  imagecopyresized($thumb, $image, 0, 0, 0, 0, $s_width, $s_height, $s_width, $s_height);
}

//imagejpeg($thumb,"/tmp/tmpfile.jpg","100");
//$thumbimage = imagecreatefromjpeg("/tmp/tmpfile.jpg") ;

//========= 圖片轉向 ============
$exif = exif_read_data($src_file);

if (!empty($exif['Orientation'])) {
switch ($exif['Orientation']) {
case 3:
$thumb = imagerotate($thumb, 180, 0);
break;
case 6:
$thumb = imagerotate($thumb, -90, 0);
break;
case 8:
$thumb = imagerotate($thumb, 90, 0);
break;
}
}
//=========== 圖片轉向 END ==========

imagesavealpha($thumb, true);//保存透明資訊
$quality=(int)$quality/10;
imagepng($thumb,$dst_file,$quality);
// imagejpeg($thumb,$dst_file,$quality);
imagedestroy($thumb);
imagedestroy($image);
}
?>