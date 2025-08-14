<?php
require '../sys/config.php';
require '../sys/pdo_fun_calss.php';
require '../sys/function.php';
require '../sys/jwt_class.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $pdo=new PDO_fun;
    $JWT=new JWT_verify;

    switch ($_POST['type']) {

        //-- 註冊 --
        case 'singup':
            $member1=$pdo->select("SELECT mem_email FROM appMember WHERE mem_email=:mem_email", ['mem_email'=>$_POST['mem_email']], 'one');
            $member2=$pdo->select("SELECT mem_phone FROM appMember WHERE mem_phone=:mem_phone", ['mem_phone'=>$_POST['mem_phone']], 'one');

            if(!empty($member1['mem_email'])){
                echo json_encode(['success'=>false, 'msg'=>'此信箱已使用過!']);
            }
            elseif(!empty($member2['mem_phone'])){
                echo json_encode(['success'=>false, 'msg'=>'此手機號碼已使用過!']);
            }
            else{
                $parem=[
                    'Tb_index'=>'mem'.date('YmdHis').rand(10,99),
                    'mem_name'=>$_POST['mem_name'],
                    'mem_phone'=>$_POST['mem_phone'],
                    'mem_email'=>$_POST['mem_email'],
                    'mem_birthday'=>$_POST['mem_birthday'],
                    'mem_pwd'=>aes_encrypt( AES_KEY, $_POST['mem_pwd']),
                    'StartDate'=>date('Y-m-d H:i:s'),
                    // 'update_num'=>date('His')
                ];
                $pdo->insert('appMember', $parem);

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
        case 'singin':
            $mem_email = htmlentities($_POST['mem_email']);
            $mem_pwd = htmlentities($_POST['mem_pwd']);

            $member= $pdo->select("SELECT Tb_index, mem_name 
                                    FROM appMember 
                                    WHERE mem_email=:mem_email AND mem_pwd=:mem_pwd AND OnLineOrNot=1", 
                                ["mem_email"=>$mem_email, "mem_pwd" => aes_encrypt(AES_KEY, $mem_pwd)], 'one');

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
                echo json_encode(['success'=>false, 'msg'=>'帳號或密碼錯誤!']);
            }
            break;


        //-- 會員資料更新 --
        case 'update':
            $parem=[
                'mem_type'=>$_POST['mem_type'],
                'company_name'=>$_POST['company_name'],
                'mem_mail'=>$_POST['mem_mail'],
            ];
            if(!empty($_POST['mem_pwd'])){
                $parem['mem_pwd'] = aes_encrypt( AES_KEY, $_POST['mem_pwd']);
            }
            $pdo->update('appMember', $parem, ['Tb_index'=>$_POST['Tb_index']]);

            echo json_encode(['success'=>true, 'msg'=>'更新成功!']);
            break;

        

        //-- 登出 --
        case 'logout':
            unset($_SESSION['Tb_index']);
            echo json_encode(['success'=>true, 'msg'=>'已登出會員!']);
            break;
        

        //-- 檢查驗證碼 --
        case 'test_rand_num':
            if(empty($_SESSION['rand_num'])){
                echo json_encode(['success'=>false, 'msg'=>'驗證碼已失效!']);
            }
            elseif($_SESSION['rand_num']!=$_POST['mail_ch_num']){
                echo json_encode(['success'=>false, 'msg'=>'驗證碼錯誤!']);
            }
            else{
                echo json_encode(['success'=>true, 'msg'=>'驗證碼正確!']);
            }
            break;
        

        //-- 更新密碼 --
        case 'new_pwd':
            if(empty($_SESSION['rand_num'])){
                echo json_encode(['success'=>false, 'msg'=>'驗證碼已失效!']);
            }
            elseif($_SESSION['rand_num']!=$_POST['mail_ch_num']){
                echo json_encode(['success'=>false, 'msg'=>'驗證碼錯誤!']);
            }
            else{
                $parem=[
                    'mem_pwd'=>aes_encrypt( AES_KEY, $_POST['mem_pwd']),
                ];
                $pdo->update('appMember', $parem, ['mem_mail'=>$_POST['mem_mail']]);
                unset($_SESSION['rand_num']);
                echo json_encode(['success'=>true, 'msg'=>'已更新密碼!']);
            }
            break;

        default:
            echo json_encode(['success'=>false, 'msg'=>'type error']);
            break;
    }
    


    $pdo->close();
}
?>