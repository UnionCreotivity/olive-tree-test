<?php
require '../sys/config.php';
require '../sys/pdo_fun_calss.php';
require '../sys/function.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $pdo=new PDO_fun;

    switch ($_POST['type']) {

        //-- 動態公設圖 --
        case 'home_canvas':
            $canvas=$pdo->select("SELECT pf_img, pf_ph_img 
                                   FROM appArticle_sp1 
                                   LIMIT 0, 1", 'no', 'one');
                
                $pf_img_arr=explode(',', $canvas['pf_img']);
                $canvas['pf_img']=$pf_img_arr;

                $pf_ph_img_arr=explode(',', $canvas['pf_ph_img']);
                $canvas['pf_ph_img']=$pf_ph_img_arr;

                echo json_encode(['success'=>true, 'data'=>$canvas]);
            break;

        default:
            echo json_encode(['success'=>false, 'msg'=>'錯誤的請求']);
            break;
    }
    
    $pdo->close();
}
?>