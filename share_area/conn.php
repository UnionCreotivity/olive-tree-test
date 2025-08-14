<?php
 require $_SERVER['DOCUMENT_ROOT'].'/share_area/sys/config.php';
 require $_SERVER['DOCUMENT_ROOT'].'/share_area/sys/pdo_fun_calss.php';
 require $_SERVER['DOCUMENT_ROOT'].'/share_area/sys/function.php';
 require $_SERVER['DOCUMENT_ROOT'].'/share_area/sys/view_class.php';

 $pdo=new PDO_fun;
 $company=$pdo->select("SELECT * FROM company_base LIMIT 0,1", 'no', 'one');

 OneDayChart();

?>