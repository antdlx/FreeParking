<?php
/**
 * Created by PhpStorm.
 *获取提高车场所有商家的信息
 * User: antdlx
 * Date: 2016/7/14
 * Time: 16:06
 */
require_once "Functions.php";
$pdo = connectDb();

//获取请求的方式
$method = $_SERVER["REQUEST_METHOD"];
$manager_id = $_POST['manager_id'];

if($method=="POST" && (!empty($manager_id))){

    $sql = "SELECT seller_id,seller_name,count(ticket_id) FROM manager NATURAL JOIN seller_parklot NATURAL JOIN seller NATURAL JOIN
 activity NATURAL JOIN ticket WHERE  manager_id = '$manager_id' AND ticket_state= 4";
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