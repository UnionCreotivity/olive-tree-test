<?php
  
/** 
 * 图片压缩类：通过缩放来压缩。 
* 如果要保持源图比例，把参数$quality保持为1即可 0.1~1。 
* 即使原比例压缩，也可大幅度缩小。数码相机4M图片。也可以缩为700KB左右。如果缩小比例，则体积会更小。 
 *   
 * 结果：可保存、可直接显示。 
 */  
class imgcompress{  
  
       private $src;  
       private $image;  
       private $imageinfo;  
       //private $quality = 100;  
       private $pic_width = 1920;  
  
       /** 
        * 图片压缩 
        * @param $src 源图 
        * @param float $quality  品質 
        */  
       public function __construct($src,  $pic_width)  
       {  
              $this->src = $src;  
              //$this->quality = $quality;  
              $this->pic_width = $pic_width; 
       }  
  
  
       /** 高清压缩图片 
        * @param string $saveName  提供图片名（可不带扩展名，用源图扩展名）用于保存。或不提供文件名直接显示 
        */  
       public function compressImg($saveName='')  
       {  
              $this->_openImage();  
              if(!empty($saveName)) $this->_saveImage($saveName);  //保存  
              else $this->_showImage();  
       }  
  
       /** 
        * 内部：打开图片 
        */  
       private function _openImage()  
       {  
              list($width, $height, $type, $attr) = getimagesize($this->src);  
              $this->imageinfo = array(  
                     'width'=>$width,  
                     'height'=>$height,  
                     'type'=>image_type_to_extension($type,false),  
                     'attr'=>$attr  
              );  
              $fun = "imagecreatefrom".$this->imageinfo['type'];  
              $this->image = $fun($this->src);  
              $this->_thumpImage();  
       }  
       /** 
        * 内部：操作图片 
        */  
       private function _thumpImage()  
       {  
           $s_width=$this->imageinfo['width'];
           $s_height=$this->imageinfo['height'];
           $pic_width=$this->pic_width;
            //   $new_width = $this->imageinfo['width'] * $this->percent;  
            //   $new_height = $this->imageinfo['height'] * $this->percent;  
              
              // 縮圖高
              $pic_height=round($pic_width/($s_width/$s_height));

              if ($s_width>$pic_width) {
                $image_thump = imagecreatetruecolor($pic_width,$pic_height);  
                //将原图复制带图片载体上面，并且按照一定比例压缩,极大的保持了清晰度  
                imagecopyresampled($image_thump, $this->image, 0, 0, 0, 0, $pic_width, $pic_height, $s_width, $s_height);
              }
             else{
                $image_thump = imagecreatetruecolor($s_width,$s_height);  
                //将原图复制带图片载体上面，并且按照一定比例压缩,极大的保持了清晰度  
                imagecopyresampled($image_thump, $this->image, 0, 0, 0, 0, $pic_width, $pic_height, $s_width, $s_height);
             }  
              imagedestroy($this->image);  
              $this->image = $image_thump;  
       }  
       /** 
        * 输出图片:保存图片则用saveImage() 
        */  
       private function _showImage()  
       {  
              header('Content-Type: image/'.$this->imageinfo['type']);  
              $funcs = "image".$this->imageinfo['type'];  
              $funcs($this->image);  
       }  
       /** 
        * 保存图片到硬盘： 
        * @param  string $dstImgName  1、可指定字符串不带后缀的名称，使用源图扩展名 。2、直接指定目标图片名带扩展名。 
        */  
       private function _saveImage($dstImgName)  
       {  
              if(empty($dstImgName)) return false;  
              $allowImgs = ['.jpg', '.jpeg', '.png', '.bmp', '.wbmp','.gif'];   //如果目标图片名有后缀就用目标图片扩展名 后缀，如果没有，则用源图的扩展名  
              $dstExt =  strrchr($dstImgName ,".");  
              $sourseExt = strrchr($this->src ,".");  
              if(!empty($dstExt)) $dstExt =strtolower($dstExt);  
              if(!empty($sourseExt)) $sourseExt =strtolower($sourseExt);  
  
              //有指定目标名扩展名  
              if(!empty($dstExt) && in_array($dstExt,$allowImgs)){  
                     $dstName = $dstImgName;  
              }elseif(!empty($sourseExt) && in_array($sourseExt,$allowImgs)){  
                     $dstName = $dstImgName.$sourseExt;  
              }else{  
                     $dstName = $dstImgName.$this->imageinfo['type'];  
              }  
              $funcs = "image".$this->imageinfo['type'];  
              $funcs($this->image, $dstName);  
       }  
  
       /** 
        * 销毁图片 
        */  
       public function __destruct(){  
              imagedestroy($this->image);  
       }  
  
}  

?>