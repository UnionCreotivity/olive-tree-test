<?php
require '../sys/config.php';
require '../sys/pdo_fun_calss.php';
require '../sys/function.php';
require '../sys/jwt_class.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $pdo=new PDO_fun;
    $JWT=new JWT_verify;

    $token= $JWT->token_verify();


    if($token['success']){

        $data=(array) $token['info']['data'];

        switch ($_POST['type']) {

            //-- 驗證token-撈會員資料 --
            case 'token_verify':
                    $success_data=['success'=>true, 'data'=>$data];
                    //-- 延長過期時間 --
                    if(!empty($token['jwt']) && !empty($token['refresh_jwt'])){
                        $success_data['jwt']=$token['jwt'];
                        $success_data['refresh_jwt']=$token['refresh_jwt'];
                    }
    
                    echo json_encode($success_data);
                break;
                
            //-- 撈會員基本資料 --
            case 'mem_data':

                $mem=$pdo->select("SELECT mem_name, mem_phone, mem_email, mem_sex, mem_birthday, mem_county, mem_district, mem_zipcode, mem_adds 
                                   FROM appMember WHERE Tb_index=:Tb_index", ['Tb_index'=>$_POST['Tb_index']], 'one');
                echo json_encode(['success'=>true, 'data'=>$mem]);
                break;
        

            //-- 更新會員基本資料 --
            case 'update_mem':
                $member1=$pdo->select("SELECT mem_email FROM appMember WHERE mem_email=:mem_email AND Tb_index!=:Tb_index", 
                                      ['Tb_index'=>$data['Tb_index'], 'mem_email'=>$_POST['mem_email']], 'one');
                $member2=$pdo->select("SELECT mem_phone FROM appMember WHERE mem_phone=:mem_phone AND Tb_index!=:Tb_index", 
                                      ['Tb_index'=>$data['Tb_index'], 'mem_phone'=>$_POST['mem_phone']], 'one');

                if(!empty($member1['mem_email'])){
                    echo json_encode(['success'=>false, 'msg'=>'此信箱已使用過!']);
                }
                elseif(!empty($member2['mem_phone'])){
                    echo json_encode(['success'=>false, 'msg'=>'此手機號碼已使用過!']);
                }
                else{
                    $param=[
                        'mem_name'=>$_POST['mem_name'],
                        'mem_phone'=>$_POST['mem_phone'],
                        'mem_email'=>$_POST['mem_email'],
                        'mem_birthday'=>$_POST['mem_birthday'],
                        'mem_sex'=>$_POST['mem_sex'],
                        'mem_county'=>$_POST['mem_county'],
                        'mem_district'=>$_POST['mem_district'],
                        'mem_zipcode'=>$_POST['mem_zipcode'],
                        'mem_adds'=>$_POST['mem_adds'],
                    ];
                    $pdo->update('appMember', $param, ['Tb_index'=>$data['Tb_index']]);

                    //-- 獲取token --
                    $jwt_token= $JWT->get_token([
                        'Tb_index' => $data['Tb_index'],
                        'mem_name' => $_POST['mem_name'],
                    ]);
                    $jwt_token['msg']='已更新會員資料!';
                    echo json_encode($jwt_token);
                }
                break;


            //-- 撈收件地址資料 --
            case 'mem_adds':

                $mem=$pdo->select("SELECT md.*
                                   FROM appMember as m
                                   INNER JOIN appMember_adds as md ON md.mem_id=m.Tb_index
                                   WHERE m.Tb_index=:Tb_index", ['Tb_index'=>$_POST['Tb_index']], 'one');
                echo json_encode(['success'=>true, 'data'=>$mem]);
                break;

            
            //-- 更新收件地址資料 --
            case 'update_adds':
                $mem_adds=$pdo->select("SELECT md.*
                                        FROM appMember as m
                                        INNER JOIN appMember_adds as md ON md.mem_id=m.Tb_index
                                        WHERE m.Tb_index=:Tb_index", 
                                      ['Tb_index'=>$data['Tb_index']], 'one');

                if(!empty($mem_adds['mem_id'])){
                    $param=[
                        'a_name'=>$_POST['a_name'],
                        'a_phone'=>$_POST['a_phone'],
                        'a_county'=>$_POST['a_county'],
                        'a_district'=>$_POST['a_district'],
                        'a_zipcode'=>$_POST['a_zipcode'],
                        'a_adds'=>$_POST['a_adds'],
                    ];
                    $pdo->update('appMember_adds', $param, ['mem_id'=>$data['Tb_index']]);
                    echo json_encode(['success'=>true, 'msg'=>'已更新收件地址資料!']);
                }
                else{
                    $param=[
                        'mem_id'=>$data['Tb_index'],
                        'a_name'=>$_POST['a_name'],
                        'a_phone'=>$_POST['a_phone'],
                        'a_county'=>$_POST['a_county'],
                        'a_district'=>$_POST['a_district'],
                        'a_zipcode'=>$_POST['a_zipcode'],
                        'a_adds'=>$_POST['a_adds'],
                    ];
                    $pdo->insert('appMember_adds', $param);
                    echo json_encode(['success'=>true, 'msg'=>'已儲存收件地址資料!999']);
                }
                break;


                //-- 更新密碼 --
                case 'update_pwd':
                    $param=[
                        'mem_pwd'=>aes_encrypt( AES_KEY, $_POST['new_pwd']),
                    ];
                    $pdo->update('appMember', $param, ['Tb_index'=>$data['Tb_index']]);
                    echo json_encode(['success'=>true, 'msg'=>'已更新密碼!']);
                    break;

                
                //-- 加入最愛 --
                case 'favorite':
                    $favorite=$pdo->select("SELECT COUNT(*) as total 
                                       FROM appMember_favorite 
                                       WHERE mem_id=:mem_id AND pro_id=:pro_id", 
                                       ['mem_id'=>$_POST['mem_id'], 'pro_id'=>$_POST['product_id']], 'one');
                    
                    if(!empty($favorite['total'])){
                       $pdo->delete('appMember_favorite', ['mem_id'=>$_POST['mem_id'], 'pro_id'=>$_POST['product_id']]);
                       echo json_encode(['success'=>true, 'checked'=>false, 'msg'=>'已刪除收藏']);
                    }
                    else{
                       $param=[
                         'mem_id'=> $_POST['mem_id'],
                         'pro_id'=> $_POST['product_id']
                       ];
                       $pdo->insert('appMember_favorite', $param);
                       echo json_encode(['success'=>true, 'checked'=>true, 'msg'=>'已加入收藏']);
                    }
                    break;

                
                //-- 判斷是否加入收藏 --
                case 'ck_favorite':
                    $favorite=$pdo->select("SELECT COUNT(*) as total 
                                       FROM appMember_favorite 
                                       WHERE mem_id=:mem_id AND pro_id=:pro_id", 
                                       ['mem_id'=>$_POST['mem_id'], 'pro_id'=>$_POST['product_id']], 'one');
                    
                    if(!empty($favorite['total'])){
                       echo json_encode(['success'=>true, 'msg'=>'有收藏']);
                    }
                    else{
                       echo json_encode(['success'=>false, 'msg'=>'無收藏']);
                    }
                    break;


                //-- 撈收藏 --
                case 'sel_favorite':
                    $favorite=$pdo->select("SELECT p.Tb_index, p.aTitle, p.aPic, p.is_spec, p.update_num,
                                                CASE
                                                    WHEN p.is_spec = 1 
                                                    THEN psp.price
                                                    ELSE p.price
                                                END AS price,
                                                CASE
                                                    WHEN p.is_spec = 1 
                                                    THEN psp.price_sp
                                                    ELSE p.price_sp
                                                END AS price_sp
                                            FROM appProduct as p
                                            LEFT JOIN appProduct_spec_product as psp ON psp.pro_id=p.Tb_index
                                            INNER JOIN appMember_favorite as mf ON p.Tb_index=mf.pro_id
                                            WHERE p.OnLineOrNot=1 AND mf.mem_id=:mem_id
                                            GROUP BY p.Tb_index
                                            ORDER BY p.StartDate DESC", 
                                             ['mem_id'=>$_POST['mem_id']]);
                    
                    if(!empty($favorite[0]['Tb_index'])){

                        $favorite_num=count($favorite);
                        for ($i=0; $i <$favorite_num ; $i++) {
                            $pic_arr=explode(',',$favorite[$i]['aPic']);
                            $favorite[$i]['aPic']=IMG_URL.$pic_arr[0].'?'.$favorite[$i]['update_num'];
                        }
                        
                       echo json_encode(['success'=>true, 'data'=>$favorite]);
                    }
                    else{
                       echo json_encode(['success'=>false, 'msg'=>'無收藏']);
                    }
                    break;


                //-- 會員訂單 --
               case 'mem_order':
                $order=$pdo->select("SELECT od.Tb_index, od.total, od.statusMsg, odp.RtnMsg as p_RtnMsg, odl.RtnMsg as l_RtnMsg
                                     FROM appOrder as od
                                     INNER JOIN appMember_order as md ON md.order_id=od.Tb_index
                                     INNER JOIN appOrder_payment as odp ON odp.MerchantTradeNo=od.Tb_index
                                     INNER JOIN appOrder_logistics as odl ON odl.MerchantTradeNo=od.Tb_index
                                     WHERE md.mem_id=:mem_id AND StartDate BETWEEN date_format(date_sub(CURDATE(), interval 1 month),'%Y-%m-%d') AND date_format(date_sub(CURDATE(), interval -1 day),'%Y-%m-%d')
                                     ORDER BY StartDate DESC", ['mem_id'=>$_POST['mem_id']]);
                echo json_encode(['success'=>true, 'data'=>$order]);
                break;


                //-- 會員訂單(完整) --
                case 'mem_dt_order':
                    $order=$pdo->select("SELECT od.Tb_index, od.StartDate, od.total, od.statusMsg, od.status, odp.RtnMsg as p_RtnMsg, odl.RtnMsg as l_RtnMsg
                                         FROM appOrder as od
                                         INNER JOIN appMember_order as md ON md.order_id=od.Tb_index
                                         INNER JOIN appOrder_payment as odp ON odp.MerchantTradeNo=od.Tb_index
                                         INNER JOIN appOrder_logistics as odl ON odl.MerchantTradeNo=od.Tb_index
                                         WHERE md.mem_id=:mem_id
                                         ORDER BY od.StartDate DESC", ['mem_id'=>$_POST['mem_id']]);

                    $order_num=count($order);
                    for ($i=0; $i <$order_num ; $i++) { 

                        $order[$i]['StartDate']=date('Y-m-d', strtotime($order[$i]['StartDate']));

                        //-- 訂單狀態紀錄 --
                        $od_history=$pdo->select("SELECT status, StartDate FROM appOrder_history WHERE order_id=:order_id ORDER BY StartDate DESC",
                                                 ['order_id'=>$order[$i]['Tb_index']]);
                        $order[$i]['history']=$od_history;

                        //-- 訂單產品 --
                        $od_product=$pdo->select("SELECT op.* ,p.aPic, p.update_num
                                                  FROM appOrder_product as op
                                                  INNER JOIN appProduct as p ON p.Tb_index=op.product_id
                                                  WHERE op.order_id=:order_id",
                                                ['order_id'=>$order[$i]['Tb_index']]);
                        $order_p_num=count($od_product);
                        for ($j=0; $j <$order_p_num ; $j++) { 
                            $aPic_arr=explode(',', $od_product[$j]['aPic']);
                            $od_product[$j]['aPic']=IMG_URL.$aPic_arr[0].'?'.$od_product[$j]['update_num'];
                        }
                        $order[$i]['product']=$od_product;
                    }
                    
                    echo json_encode(['success'=>true, 'data'=>$order]);
                    break;
                

                //-- 會員訂單(單) --
                case 'mem_one_order':
                    $order=$pdo->select("SELECT od.Tb_index, od.StartDate, od.total, od.statusMsg, od.status, odp.RtnMsg as p_RtnMsg, odl.RtnMsg as l_RtnMsg, odp.RtnCode,
                                                odpt.pay_name, od.od_name, od.od_phone, od.od_adds, olt.logistics_name, odl.UpdateStatusDate
                                         FROM appOrder as od
                                         INNER JOIN appMember_order as md ON md.order_id=od.Tb_index
                                         INNER JOIN appOrder_payment as odp ON odp.MerchantTradeNo=od.Tb_index
                                         LEFT JOIN appOrder_pay_type as odpt ON odp.PaymentType LIKE CONCAT('%',odpt.pay_code,'%')
                                         INNER JOIN appOrder_logistics as odl ON odl.MerchantTradeNo=od.Tb_index
                                         INNER JOIN appOrder_logistics_type as olt ON odl.LogisticsType = olt.logistics_code
                                         WHERE md.mem_id=:mem_id AND od.Tb_index=:Tb_index
                                         ORDER BY od.StartDate DESC", ['mem_id'=>$_POST['mem_id'], 'Tb_index'=>$_POST['order_id']], 'one');

                    $order['StartDate']=date('Y-m-d', strtotime($order['StartDate']));

                    //-- 訂單狀態紀錄 --
                    $od_history=$pdo->select("SELECT status, StartDate FROM appOrder_history WHERE order_id=:order_id ORDER BY StartDate DESC",
                                            ['order_id'=>$order['Tb_index']]);
                    $order['history']=$od_history;

                    //-- 訂單產品 --
                    $od_product=$pdo->select("SELECT op.* ,p.aPic, p.update_num
                                            FROM appOrder_product as op
                                            INNER JOIN appProduct as p ON p.Tb_index=op.product_id
                                            WHERE op.order_id=:order_id",
                                            ['order_id'=>$order['Tb_index']]);
                    $order_p_num=count($od_product);
                    for ($j=0; $j <$order_p_num ; $j++) { 
                        $aPic_arr=explode(',', $od_product[$j]['aPic']);
                        $od_product[$j]['aPic']=IMG_URL.$aPic_arr[0].'?'.$od_product[$j]['update_num'];
                    }
                    $order['product']=$od_product;
                    
                    echo json_encode(['success'=>true, 'data'=>$order]);
                    break;
                

               
    
    
            default:
                echo json_encode(['success'=>false, 'msg'=>'type error']);
                break;
        }

    }
    else{
        echo json_encode($token);
    }

    
    
    $pdo->close();
}
?>