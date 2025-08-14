<?php
 
 /**
  * PDO 查詢、新增、修改、刪除
  */
 class PDO_fun
 {
 	
 	private $_dbname = DB_NAME; //資料庫名稱
	private $_user_id = DB_USER; //使用者ID
	private $_user_pwd = DB_PWD; //使用者密碼
	private $keywords=[]; //關鍵字欄位
	private $pdo_obj; //PDO物件
	private $sql;
	public $keyword=''; //關鍵字
	
    

    
    //-- 建構子 --
	function __construct()
	{
		$this->_pdo_conn();
	}

	/* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ PDO連線 @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */
 	 function _pdo_conn() {
		$this->pdo_obj = new PDO("mysql:host=".DB_HOST.";dbname=".$this->_dbname, $this->_user_id, $this->_user_pwd);
		$this->pdo_obj->exec("SET NAMES utf8mb4");
	}


	/* ----------------------- PDO 查詢 --------------------------- */
	function select($sql_query, $where='no' ,$fetch_num='all')
	{
	  try{
		//-- 關鍵字搜尋 (目前需要WHERE 才能使用)  --
		if(!empty($this->keywords[0])){
			$_keywords=$this->keywords;
			$keyword_col_num=count($_keywords);

			//-- 多關鍵字 --
			$keyword_one=str_replace('\'',' ',$this->keyword);
			if (strpos($keyword_one, ',')!=FALSE){
				$keyword_point=',';
			}
			elseif(strpos($keyword_one, ' ')!=FALSE){
				$keyword_point=' ';
			}
			elseif(strpos($keyword_one, '、')!=FALSE){
				$keyword_point='、';
			}
			else{
				$keyword_point='';
			}
			$keyWord= empty($keyword_point) ? [$keyword_one] : explode($keyword_point, $keyword_one);
			$keyword_num=count($keyWord);

			$keyWord_txt_all='';
			for ($k=0; $k < $keyword_num; $k++) { 

				//-- 關鍵字欄位 --
				$keyWord_txt='';
				for ($i=0; $i < $keyword_col_num; $i++) { 
					$keyWord_txt.=" ".$_keywords[$i]['col']." LIKE :keyword_sql".$k.$i." OR ";
				}
				$keyWord_txt=mb_substr($keyWord_txt, 0, -3, 'utf-8');
				$keyWord_txt_all.=" (".$keyWord_txt.") AND ";
			}
			

			//$keyWord_txt_all=mb_substr($keyWord_txt_all, 0, -4, 'utf-8');
			//-- strtolower 轉小寫 --
			$where_index=mb_strpos(strtolower($sql_query), 'where', 0, 'utf-8');
			//-- 插入 keywords_sql --
			$sql_query=substr_replace($sql_query, $keyWord_txt_all, ($where_index+5), 0);
		}
		
		$this->sql=$sql_query;
		$sql=$this->pdo_obj->prepare($sql_query);


		if ($where!='no') {
			$where_key=array_keys($where);//陣列鍵名
			for ($i=0; $i <count($where) ; $i++) { 
				$sql->bindparam($where_key[$i], $where[$where_key[$i]]);
			}
		}

		//-- 關鍵字搜尋 --
		if(!empty($this->keywords[0])){
			for ($k=0; $k < $keyword_num; $k++){
				for ($i=0; $i < $keyword_col_num; $i++) {
					//-- bindparam 只能放變數 --
					$kw_sql='%'.$keyWord[$k].'%';
					$sql->bindparam('keyword_sql'.$k.$i, $kw_sql);
				}
			}
		}

		$sql->execute();
		
		if ($fetch_num=='one') {
			$row=$sql->fetch(PDO::FETCH_ASSOC);
			return $row;
		}
		else{
			$row=$sql->fetchAll(PDO::FETCH_ASSOC);
			return $row;
		}
	  }
	  catch (PDOException $e){
		
		$err_msg="錯誤文件:".$e->getFile()."\n".
				 "錯誤行數:".$e->getLine()."\n".
				 "錯誤描述:".$e->getMessage();
		echo json_encode(['success'=>false, 'msg'=>$err_msg]);
		exit();
	  }
	}


	/* ---------------- PDO新增 ----------------- */
	function insert($tb_name, $array_data )
	{
	  try{
		$key=array_keys($array_data); //陣列鍵名
		$data_name='';
		$data='';

		for ($i=0; $i < count($array_data) ; $i++) { 
			if ($i==count($array_data)-1) {
			$data_name.=$key[$i];
			$data.=':'.$key[$i];
			}else{
			$data_name.=$key[$i].',';
			$data.=':'.$key[$i].',';
			}
		}

		$sql_query="INSERT INTO ".$tb_name." (".$data_name.") VALUES (".$data.")";

			$sql=$this->pdo_obj->prepare($sql_query);
		for ($i=0; $i < count($array_data) ; $i++) { 
				$sql->bindparam(':'.$key[$i], $array_data[$key[$i]]);
			}	
			$sql->execute();
	  }
	  catch (PDOException $e){
		
		$err_msg="錯誤文件:".$e->getFile()."\n".
				 "錯誤行數:".$e->getLine()."\n".
				 "錯誤描述:".$e->getMessage();
		echo json_encode(['success'=>false, 'msg'=>$err_msg]);
		exit();
	  }
	}


	/* ---------------- PDO修改 ----------------- */
	function update($tb_name, $array_data, $where)
	{
		try{
			$key=array_keys($array_data);//陣列鍵名
			$where_key=array_keys($where);
			$data='';
			$where_sql='';

			for ($i=0; $i < count($array_data) ; $i++) { 
				if ($i==count($array_data)-1) {
				$data.=$key[$i].'=:'.$key[$i];
				}else{
				$data.=$key[$i].'=:'.$key[$i].',';
				}
			}

			for ($i=0; $i < count($where) ; $i++) { 
				if ($i==count($where)-1) {
				$where_sql.=$where_key[$i].'=:'.$where_key[$i];
				}else{
				$where_sql.=$where_key[$i].'=:'.$where_key[$i].' AND ';
				}
			}

			$sql_query="UPDATE ".$tb_name." SET ".$data." WHERE ".$where_sql;

				$sql=$this->pdo_obj->prepare($sql_query);
			for ($i=0; $i < count($array_data) ; $i++) { 
					$sql->bindparam(':'.$key[$i], $array_data[$key[$i]]);
				}	
			for ($i=0; $i < count($where) ; $i++) { 
					$sql->bindparam(':'.$where_key[$i], $where[$where_key[$i]]);
				}

			$sql->execute();
		}
		catch (PDOException $e){
			$err_msg="錯誤文件:".$e->getFile()."\n".
					 "錯誤行數:".$e->getLine()."\n".
					 "錯誤描述:".$e->getMessage();
			echo json_encode(['success'=>false, 'msg'=>$err_msg]);
			exit();
		}
	}


	/* ---------------- PDO刪除 ----------------- */
	function delete($tb_name, $where)
	{
		try{
			$where_key=array_keys($where);//陣列鍵名
			$where_sql='';

			for ($i=0; $i < count($where) ; $i++) { 
				if ($i==count($where)-1) {
				$where_sql.=$where_key[$i].'=:'.$where_key[$i];
				}else{
				$where_sql.=$where_key[$i].'=:'.$where_key[$i].' AND ';
				}
			}
	   
			$sql_query="DELETE FROM ".$tb_name." WHERE ".$where_sql;
			$sql=$this->pdo_obj->prepare($sql_query);	
			for ($i=0; $i < count($where) ; $i++) { 
				$sql->bindparam(':'.$where_key[$i], $where[$where_key[$i]]);
			}
			// $sql->bindparam(':'.$where_key[0], $where[$where_key[0]]);
			$sql->execute();
		}
		catch (PDOException $e){
			$err_msg="錯誤文件:".$e->getFile()."\n".
					 "錯誤行數:".$e->getLine()."\n".
					 "錯誤描述:".$e->getMessage();
			echo json_encode(['success'=>false, 'msg'=>$err_msg]);
			exit();
		}
	}
	

	/*--------------------- 關鍵字欄位加入 ------------------------ */
	function add_keyword($col)
	{
	   $keyword_obj=['col'=>$col];
	   array_push($this->keywords, $keyword_obj);
	}

	/*-- 關閉PDO --*/
	function close()
	{
		$this->pdo_obj=NULL;
	}
 }
?>