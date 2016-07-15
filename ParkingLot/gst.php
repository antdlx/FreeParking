<?php
/**
 * Created by PhpStorm.
 * User: antdlx
 * Date: 2016/7/14
 * Time: 16:06
 */
require_once "Functions.php";
$pdo = connectDb();
//获取请求的方式
$method = $_SERVER["REQUEST_METHOD"];
$gstmid= $_POST['gstmid'];

if($method=="POST" && (!empty($gstmid))){
    $pdo->query('set names utf8');
    $sql = "SELECT seller_id,seller_name,count('ticket_id') as ticket_num FROM manager NATURAL JOIN seller_parklot NATURAL JOIN seller NATURAL JOIN
 activity NATURAL JOIN ticket WHERE  manager_id = '$gstmid' AND ticket_state= 4 GROUP BY ticket_id";
    $stmt = $pdo->prepare($sql);
    $stmt ->execute();
    $list = $stmt ->fetchAll(PDO::FETCH_ASSOC);

    $num = $stmt -> rowCount();
    if($num==0){
        echo 1;
    }else{
        echo json1($list);
    }
}else{
    echo 1;
}