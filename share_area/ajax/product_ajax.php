<?php
require '../sys/config.php';
require '../sys/pdo_fun_calss.php';
require '../sys/function.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $pdo=new PDO_fun;

    switch ($_POST['type']) {
        //-- 商品類別 --
        case 'pro_type':
            $type=$pdo->select("SELECT * FROM appProduct_type WHERE OnLineOrNot=1 ORDER BY OrderBy");
            echo json_encode(['success'=>true, 'data'=>$type]);
            break;

        //-- 撈商品 --
        case 'product':
            
            switch ($_POST['sort']) {
                case 'sell_from-desc':
                    $order_sql="ORDER BY p.StartDate DESC";
                    break;
                case 'sell_from-asc':
                    $order_sql="ORDER BY p.StartDate ASC";
                    break;
                case 'price-desc':
                    $order_sql="ORDER BY price DESC";
                    break;
                case 'price-asc':
                    $order_sql="ORDER BY price ASC";
                    break;
                default:
                    $order_sql="ORDER BY p.StartDate DESC";
                    break;
            }

            $products=$pdo->select("SELECT p.Tb_index, p.aTitle, p.aPic, p.is_spec, p.update_num,
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
                                   WHERE p.OnLineOrNot=1 AND p.aType=:aType
                                   GROUP BY p.Tb_index
                                   $order_sql",
                                   ['aType'=>$_POST['aType']]);
            $products_num=count($products);
            for ($i=0; $i <$products_num ; $i++) {
                $pic_arr=explode(',',$products[$i]['aPic']);
                $products[$i]['aPic']=IMG_URL.$pic_arr[0].'?'.$products[$i]['update_num'];
            }
            echo json_encode(['success'=>true, 'data'=>$products]);
            break;


        //-- 撈相關商品 --
        case 'more_product':
            $products=$pdo->select("SELECT p.Tb_index, p.aTitle, p.aPic, p.is_spec, p.update_num,
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
                                   WHERE p.OnLineOrNot=1 AND p.aType=:aType AND p.Tb_index!=:Tb_index
                                   GROUP BY p.Tb_index
                                   ORDER BY p.StartDate DESC
                                   LIMIT 0,4",
                                   ['aType'=>$_POST['aType'], 'Tb_index'=>$_POST['Tb_index']]);
            $products_num=count($products);
            for ($i=0; $i <$products_num ; $i++) {
                $pic_arr=explode(',',$products[$i]['aPic']);
                $products[$i]['aPic']=IMG_URL.$pic_arr[0].'?'.$products[$i]['update_num'];
            }
            echo json_encode(['success'=>true, 'data'=>$products]);
            break;

        //-- 撈產品規格資料 --
        case 'get_spec':
            $product=$pdo->select("SELECT aTitle, is_spec, m_sku, price, price_sp, quantity, aPic, update_num FROM appProduct WHERE Tb_index=:Tb_index", ['Tb_index'=>$_POST['Tb_index']], 'one');
            $aPic_arr=explode(',', $product['aPic']);
            $product['aPic_num']=count($aPic_arr);
            $product['aPic']=IMG_URL.$aPic_arr[0].'?'.$product['update_num'];
            if($product['is_spec']==1){
                $row_spec=$pdo->select("SELECT DISTINCT ps.spec_name, psv.spec_value_name
                                       FROM appProduct_spec_value as psv 
                                       INNER JOIN appProduct_spec as ps ON psv.spec_id=ps.Tb_index
                                       INNER JOIN appProduct_spec_product as psp ON psv.Tb_index=psp.spec_value_id
                                       WHERE psp.pro_id=:pro_id
                                       ORDER BY psv.OrderBy",
                                       ['pro_id'=>$_POST['Tb_index']]);
  
                $row_spec2=$pdo->select("SELECT DISTINCT ps.spec_name, psv.spec_value_name
                                       FROM appProduct_spec_value as psv 
                                       INNER JOIN appProduct_spec as ps ON psv.spec_id=ps.Tb_index
                                       INNER JOIN appProduct_spec_product as psp ON psv.Tb_index=psp.spec_value_id2
                                       WHERE psp.pro_id=:pro_id
                                       ORDER BY psv.OrderBy",
                                       ['pro_id'=>$_POST['Tb_index']]);
  
               $row_spec_value=$pdo->select("SELECT rowid, price, price_sp, quantity, sku, 
                                                  (SELECT spec_value_name FROM appProduct_spec_value WHERE Tb_index=psp.spec_value_id) as sv_name1,
                                                  (SELECT spec_value_name FROM appProduct_spec_value WHERE Tb_index=psp.spec_value_id2) as sv_name2,
                                                  (SELECT spec_value_img FROM appProduct_spec_value WHERE Tb_index=psp.spec_value_id) as sv_img
                                             FROM appProduct_spec_product as psp
                                             WHERE psp.pro_id=:pro_id",
                                             ['pro_id'=>$_POST['Tb_index']]);

                $spec_value_num=count($row_spec_value);
                for ($i=0; $i <$spec_value_num ; $i++) {
                    $row_spec_value[$i]['sv_img']=empty($row_spec_value[$i]['sv_img']) ? '' : IMG_URL.$row_spec_value[$i]['sv_img'].'?'.$product['update_num'];
                }

                $product['spec_obj']=[
                  's_name'=>$row_spec,
                  's_name2'=>$row_spec2,
                  'data'=>$row_spec_value
                ];
              }
            echo json_encode(['success'=>true, 'data'=>$product]);
            break;
        
        default:
            echo json_encode(['success'=>false, 'msg'=>'錯誤的請求']);
            break;
    }
    
    $pdo->close();
}
?>