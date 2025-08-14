<?php
require 'vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

/**
 * JWT 驗證 class (PHP 版本 7.0 以上)
 */
class JWT_verify 
{
    const KEY = '1gHuiop975cdashyex9Ud23ldsvm2Xq'; //金鑰
    private $res=[
                'success'=>false,
                'jwt'=>'',
                'msg'=>''
                ];
    
    /**
     * 登入驗證
     */
    // function login($mem_id, $mem_pwd)
    // {
    //    $pdo=new PDO_fun;
    //    if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    //         $member_id = htmlentities($mem_id);
    //         $member_pwd = htmlentities($mem_pwd);

    //         $user=$pdo->select("SELECT tb_index, jobid, per_id, membername, caseid, refresh_token, pw 
    //                             FROM member 
    //                             WHERE id=:id AND OnLineOrNot=1",
    //                             ['id'=>$member_id], 'one');

    //         if(!empty(count($user)) && password_verify($member_pwd, $user['pw'])){


    //             //-- 歷史紀錄 --
    //             // $pdo->hs_tb_name='member';
    //             // $pdo->hs_h_location='管理者登入';
    //             // $pdo->hs_h_action_type='login';
    //             // $pdo->hs_h_title='管理者登入-'.$user['membername'];


    //             // $pdo->add_history();


    //             //------------------------- 記住帳號 -------------------------------
    //             if(!empty($_POST['remember'])){
    //                 setcookie('tb_index', $user['tb_index'], time()+36000000);
    //             }else{
    //                 setcookie('tb_index', '', time()-36000000);
    //             }

    //             $_SESSION['member_id'] = $user['tb_index'];
    //             $_SESSION['jobid'] = $user['jobid'];
    //             $_SESSION['per_id']=$user['per_id'];
    //             $_SESSION['membername']= $user['membername'];
    //             $_SESSION['caseid']= $user['caseid'];


    //             //-- 權限抓第一個功能網址 --
    //             $row_top_p=$pdo->select("SELECT Permissions FROM sysAdminGroup WHERE Tb_index=:Tb_index", ['Tb_index'=>$user['per_id']], 'one');
    //             $per_arr=explode(',',$row_top_p['Permissions']);
    //             $per_sql=implode("','",$per_arr);
    //             $per_sql="'".$per_sql."'";
                
    //             $row_mt=$pdo->select("SELECT * FROM maintable WHERE use_web!='' AND Tb_index IN ($per_sql) ORDER BY parent_id ASC, OrderBy ASC LIMIT 0,1", 'no', 'one');
    //             if(!empty($_COOKIE['link_url'])){
    //               $this->res['use_web']=$_COOKIE['link_url'];
    //             }
    //             elseif(!empty($row_mt['use_web'])){
    //               $this->res['use_web']=$row_mt['use_web'];
    //             }else{
    //               $this->res['use_web']='index.php';
    //             }


    //             //-- 獲取token --
    //             $this->get_token([
    //                 'member_id' => $user['tb_index'],
    //                 'jobid' => $user['jobid'],
    //                 'per_id' => $user['per_id'],
    //                 'caseid' => $user['caseid'], 
    //             ]);
              

    //             //-- 返回給User --
    //             $this->res['success'] = true;
    //             $this->res['jwt'] = $jwt;
    //             $this->res['refresh_jwt'] = $refresh_jwt;
    //             $this->res['membername']=$user['membername'];
    //         }
    //         else{
    //             $this->res['msg'] = '使用者名稱或密碼錯誤!';
    //         }
    //    }
    //    return json_encode($this->res);
    //    $pdo->close();
    // }


    /**
     * 獲取token
     * @param object $data 裝入token的資料
     * @return json jwt 資訊
     */
    function get_token($data)
    {
        $nowtime = time();
        $token = [
            'iss' => NOW_HOST, //簽發者
            'aud' => NOW_HOST, //jwt所面向的使用者
            'iat' => $nowtime, //簽發時間
            'nbf' => $nowtime+1, //在什麼時間之後該jwt才可用
            'exp' => $nowtime+1800, //過期時間- 30m
            'scopes'=>'role_access',
            'data' => $data
        ];

        //-- 產生 請求接口的token --
        $jwt = JWT::encode($token, self::KEY, 'HS256');

        //-- 產生 刷新access_token --
        $token['scopes']='role_refresh';
        $token['exp']=$nowtime+(43200); //過期時間- 12小
        $refresh_jwt = JWT::encode($token, self::KEY, 'HS256');

        $this->res['success'] = true;
        $this->res['jwt'] = $jwt;
        $this->res['refresh_jwt'] = $refresh_jwt;

        return $this->res;
    }


    /**
     * token驗證
     */
    function token_verify()
    {
        $jwt =isset($_SERVER['HTTP_AUTHORIZATION']) ? str_replace('Bearer ', '', $_SERVER['HTTP_AUTHORIZATION']) : '';
        //$jwt =isset($_SERVER['HTTP_REFRESH_TOKEN']) ? $_SERVER['HTTP_REFRESH_TOKEN'] : '';
        if (empty($jwt)) {
            $this->res['msg'] = '請您登入會員!';
            return $this->res;
            exit;
        }

        
        try {
            
            JWT::$leeway = 60;
            $decoded = JWT::decode($jwt, new Key(self::KEY, 'HS256'));
            $arr = (array)$decoded;
            
            //-- 簽名錯誤 --
            if($arr['iss']!=NOW_HOST && $arr['aud']!=NOW_HOST){
                $this->res['msg'] = '請您登入會員!';
            }
            //-- token過期 --
            elseif( time()<$arr['nbf'] && time()>$arr['exp']){

                $refresh_jwt =isset($_SERVER['HTTP_REFRESH_TOKEN']) ? $_SERVER['HTTP_REFRESH_TOKEN'] : '';

                JWT::$leeway = 60;
                $decoded = JWT::decode($refresh_jwt, new Key(self::KEY, 'HS256'));
                $refresh_arr = (array)$decoded;

                //-- 延長到期時間 --
                if(time()<$refresh_arr['nbf'] && time()>$refresh_arr['exp']){
                    
                }
            }
            else{
                $this->res['success'] = true;
                $this->res['info'] = $arr;
            }
        }
        catch(\Firebase\JWT\SignatureInvalidException $e) { //簽名不正確
            $this->res['msg'] = '請您登入會員!';
        }
        catch(\Firebase\JWT\BeforeValidException $e) { // 簽名在某個時間點之後才能用
            $this->res['msg'] = '請您登入會員!';
        }
        catch(\Firebase\JWT\ExpiredException $e){ // token過期

            $refresh_jwt =isset($_SERVER['HTTP_REFRESH_TOKEN']) ? $_SERVER['HTTP_REFRESH_TOKEN'] : '';

            try{
                JWT::$leeway = 60;
                $decoded = JWT::decode($refresh_jwt, new Key(self::KEY, 'HS256'));
                $refresh_arr = (array)$decoded;
                $this->res['success'] = true;
                $this->res['info'] = $refresh_arr;
                    $token = [
                        'iss' => NOW_HOST, //簽發者
                        'aud' => NOW_HOST, //jwt所面向的使用者
                        'iat' => time(), //簽發時間
                        'nbf' => time()+1, //在什麼時間之後該jwt才可用
                        'exp' => time()+1800, //過期時間- 30m
                        'scopes'=>'role_access',
                        'data' =>$refresh_arr['data']
                    ];

                    //-- 請求接口的token --
                    $jwt = JWT::encode($token, self::KEY, 'HS256');

                    //-- 產生 刷新access_token --
                    $token['scopes']='role_refresh';
                    $token['exp']=time()+(7200); //過期時間- 2小
                    $refresh_jwt = JWT::encode($token, self::KEY, 'HS256');

                    $this->res['jwt'] = $jwt;
                    $this->res['refresh_jwt']= $refresh_jwt;
            }
            catch(\Firebase\JWT\ExpiredException $e){
                $this->res['msg'] = '請重新登入會員!!';
            }
        }
        catch(Exception $e) { // 其他錯誤
            //$this->res['msg'] = $e->getMessage();
            $this->res['msg'] = '請您登入會員!';
        }
        return $this->res;
    }
}
?>