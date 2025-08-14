<?php
require '../sys/config.php';
require '../sys/pdo_fun_calss.php';
require '../sys/function.php';
require '../sys/jwt_class.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $pdo=new PDO_fun;
    $JWT=new JWT_verify;

    switch ($_POST['type']) {
        //-- 檢查優惠碼 --
        case 'ch_coupon':
            $token= $JWT->token_verify();

            if($token['success']){

                $data=(array) $token['info']['data'];

                $coupon=$pdo->select("SELECT * 
                                  FROM appCoupon 
                                  WHERE cp_code=:cp_code AND OnLineOrNot=1 AND CURDATE() BETWEEN StartDate AND EndDate",
                                  ['cp_code'=>$_POST['cp_code']], 'one');

                
                if(!empty($coupon['cp_code'])){

                    //-- 確認是否已使用過 --
                    $ck_mem_coupon=$pdo->select("SELECT COUNT(*) as total
                                                 FROM appOrder_coupon as odc
                                                 INNER JOIN appMember_order as md ON odc.order_id=md.order_id
                                                 WHERE md.mem_id=:mem_id AND odc.coupon_id=:coupon_id",
                                                 ['mem_id'=>$data['Tb_index'], 'coupon_id'=>$coupon['Tb_index']], 'one');
                    if($ck_mem_coupon['total']=='1'){
                        echo json_encode(['success'=>false, 'msg'=>'此優惠碼已使用過!']);
                    }
                    else{
                        echo json_encode(['success'=>true, 'data'=>$coupon]);
                    }
                }
                else{
                    echo json_encode(['success'=>false, 'msg'=>'此優惠碼已無效!']);
                }

            }
            else{
                echo json_encode($token);
            }
            
            break;

        //-- 抓運費 --
        case 'get_freight':
            $freight=$pdo->select("SELECT * FROM appFreight LIMIT 0,1", 'no', 'one');
            echo json_encode(['success'=>true, 'data'=>$freight]);
            break;

        //-- 檢查產品數量 --
        case 'ck_product':
            $pro_arr=json_decode($_POST['producr_arr'], true);
            $pro_new_arr=[];
            foreach ($pro_arr as $pro) {
               $new_pro=[
                'Tb_index'=> $pro['Tb_index'],
                'rowid'=>$pro['rowid'],
               ];
               if(empty($pro['rowid'])){
                $pro=$pdo->select("SELECT quantity FROM appProduct WHERE Tb_index=:Tb_index", ['Tb_index'=>$pro['Tb_index']], 'one');
               }
               else{
                $pro=$pdo->select("SELECT quantity FROM appProduct_spec_product WHERE rowid=:rowid", ['rowid'=>$pro['rowid']], 'one');
               }
               $new_pro['quantity']=$pro['quantity'];
               array_push($pro_new_arr, $new_pro);
            }
            echo json_encode(['success'=>true, 'data'=>$pro_new_arr]);
            break;
        
        default:
            echo json_encode(['success'=>false, 'msg'=>'錯誤的請求']);
            break;
    }
    
    $pdo->close();
}
?>