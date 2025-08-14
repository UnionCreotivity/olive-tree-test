<?php
 /**
  * 圖片上傳
  */

  class file_class
  {

    private $_img_path = '../../img/'; //圖檔位置
    private $_file_path = '../../other_file/'; //檔案位置

    public $Tb_index='';

    //-- 圖檔路徑 --
    function img_url($img_name, $UpdateDate)
    {
      $date_num=date('His', strtotime($UpdateDate));
      return $this->_img_path.$this->Tb_index.'/'.$img_name.'?'.$date_num;
    }

    //-- 檔案路徑 --
    function file_url( $file_name, $UpdateDate)
    {
      $date_num=date('His', strtotime($UpdateDate));
      return $this->_file_path.$this->Tb_index.'/'.$file_name.'?'.$date_num;
    }

    //-- 上傳圖檔 --
    function upload_img($files)
    {
        if (!empty($files['name'])){
            $type=pathinfo($files['name'], PATHINFO_EXTENSION);
            $img_name=$this->Tb_index.'.'.$type;

            if(!is_dir(dirname(__FILE__).$this->_img_path.$this->Tb_index)){
                mkdir($this->_img_path.$this->Tb_index, 0777);
            }
            move_uploaded_file($files['tmp_name'], $this->_img_path.$this->Tb_index.'/'.$img_name);
         }
         else{
            $img_name='';
         }
         return $img_name;
    }

    //-- 上傳檔案 --
    function upload_file($files)
    {
        if (!empty($files['name'])){
            $type=pathinfo($files['name'], PATHINFO_EXTENSION);
            $img_name=$this->Tb_index.'.'.$type;

            if(!is_dir(dirname(__FILE__).$this->_file_path.$this->Tb_index)){
                mkdir($this->_file_path.$this->Tb_index, 0777);
            }
            move_uploaded_file($files['tmp_name'], $this->_file_path.$this->Tb_index.'/'.$img_name);
         }
         else{
            $img_name='';
         }
         return $img_name;
    }

    //-- 多圖檔上傳 --
    function more_upload_img($files)
    {
        $img_txt='';
        if (!empty($files['name'][0])){

          if(!is_dir(dirname(__FILE__).$this->_img_path.$this->Tb_index)){
            mkdir($this->_img_path.$this->Tb_index, 0777);
          }

            for ($i=0; $i <count($files['name']) ; $i++) { 

                $type=pathinfo($files['name'][$i], PATHINFO_EXTENSION);
                $img_name=$this->Tb_index.'_other_'.$i.'.'.$type;
                $img_txt.=$img_name.',';
                move_uploaded_file($files['tmp_name'][$i], $this->_img_path.$this->Tb_index.'/'.$img_name);
           }
        }
        return $img_txt;
    }

    //-- 多檔案上傳 --
    function more_upload_file($files)
    {
        $img_txt='';
        if (!empty($files['name'][0])){

          if(!is_dir(dirname(__FILE__).$this->_file_path.$this->Tb_index)){
            mkdir($this->_file_path.$this->Tb_index, 0777);
          }

            for ($i=0; $i <count($files['name']) ; $i++) { 

                $type=pathinfo($files['name'][$i], PATHINFO_EXTENSION);
                $img_name=$this->Tb_index.'_other_'.$i.'.'.$type;
                $img_txt.=$img_name.',';
                move_uploaded_file($files['tmp_name'][$i], $this->_file_path.$this->Tb_index.'/'.$img_name);
           }
        }
        return $img_txt;
    }
  }
?>