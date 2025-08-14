<?php
require '../sys/config.php';
require '../sys/pdo_fun_calss.php';
require '../sys/function.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $pdo=new PDO_fun;

    switch ($_POST['type']) {

        //-- 熱銷建案 --
        case 'hot_project':
            $project=$pdo->select("SELECT * FROM appCase WHERE OnLineOrNot=1 AND mt_id='site2023080912315936' ORDER BY ca_date DESC, StartDate DESC, Tb_index DESC");
            $pArr=[];
            $x=1;
            foreach ($project as $pOne) {
                array_push($pArr, [
                  'id'=>$x,
                  'title'=>'HOME FROM HEART',
                  'sTitle'=>$pOne['ca_name'],
                  'para'=>$pOne['ca_Abstract'],
                  'place'=>$pOne['ca_mapArea'],
                  'connect'=>$pOne['ca_url'],
                  'fb'=>$pOne['ca_FB'],
                  'mail'=>'project_content.php?Tb_index='.$pOne['Tb_index'].'#form-main',
                  'ca_isMsg'=>$pOne['ca_isMsg'],
                  'more'=>'project_content.php?Tb_index='.$pOne['Tb_index'],
                ]);
                $x++;
            }

            echo json_encode(['success'=>true, 'data'=>$pArr]);
            break;

        case 'project_imgWall':
            $project=$pdo->select("SELECT Tb_index, ca_imgWall 
                                   FROM appCase 
                                   WHERE OnLineOrNot=1 AND mt_id='site2023080912315936' 
                                   ORDER BY ca_date DESC, StartDate DESC, Tb_index DESC
                                   LIMIT 0, 3");
                $x=0;
                foreach ($project as $pOne) {

                    $img_arr=explode(',', $pOne['ca_imgWall']);
                    $project[$x]['ca_imgWall']=$img_arr;
                    $x++;
                }

                echo json_encode(['success'=>true, 'data'=>$project]);
            break;


        
        default:
            echo json_encode(['success'=>false, 'msg'=>'錯誤的請求']);
            break;
    }
    
    $pdo->close();
}
?>