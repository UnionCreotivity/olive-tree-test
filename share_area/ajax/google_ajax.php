<?php
require '../sys/config.php';
require '../sys/pdo_fun_calss.php';
require '../sys/function.php';
require '../sys/jwt_class.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $pdo=new PDO_fun;
    $JWT=new JWT_verify;

    switch ($_POST['type']) {

        //-- GOOGLE快速註冊 --
        case 'google_signup':
            $member1=$pdo->select("SELECT m.Tb_index 
                                   FROM appMember as m
                                   INNER JOIN appMember_login as ml ON m.Tb_index=ml.mem_id
                                   WHERE ml.lgn_id=:lgn_id", ['lgn_id'=>$_POST['mem_google_id']], 'one');

            if(!empty($member1['Tb_index'])){
                echo json_encode(['success'=>false, 'msg'=>'此GOOGLE已註冊過!']);
            }
            else{
                $Tb_index='mem'.date('YmdHis').rand(10,99);
                $parem=[
                    'Tb_index'=>$Tb_index,
                    'mem_name'=>$_POST['mem_name'],
                    // 'mem_email'=>$_POST['mem_email'],
                    'StartDate'=>date('Y-m-d H:i:s'),
                    // 'update_num'=>date('His')
                ];
                $pdo->insert('appMember', $parem);

                $parem=[
                    'mem_id'=>$Tb_index,
                    'lgn_type'=>2,
                    'lgn_id'=>$_POST['mem_google_id'],
                ];
                $pdo->insert('appMember_login', $parem);

                //-- 獲取token --
                $jwt_token= $JWT->get_token([
                    'Tb_index' => $Tb_index,
                    'mem_name' => $_POST['mem_name'],
                ]);
                $jwt_token['msg']='您已註冊成功!';
        
                echo json_encode($jwt_token);
            }
            break;

            
        //-- 登入 --
        case 'google_singin':

            $member= $pdo->select("SELECT m.Tb_index, m.mem_name 
                                    FROM appMember as m
                                    INNER JOIN appMember_login as ml ON ml.mem_id=m.Tb_index
                                    WHERE ml.lgn_id=:lgn_id AND m.OnLineOrNot=1", 
                                    ["lgn_id"=>$_POST['mem_google_id']], 'one');

            if(!empty($member['Tb_index'])){

                //-- 獲取token --
                $jwt_token= $JWT->get_token([
                    'Tb_index' => $member['Tb_index'],
                    'mem_name' => $member['mem_name'],
                ]);
                $jwt_token['msg']='歡迎'.$member['mem_name'].'登入!';

                echo json_encode($jwt_token);
            }
            else{
                echo json_encode(['success'=>false, 'msg'=>'此GOOGLE帳戶尚未註冊!']);
            }
            break;


        

        default:
            echo json_encode(['success'=>false, 'msg'=>'type error']);
            break;
    }
    


    $pdo->close();
}
?>