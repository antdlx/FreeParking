<?php
/**
 * Created by PhpStorm.
 * 获取所有停车场的停车数量
 * User: antdlx
 * Date: 2016/7/14
 * Time: 16:00
 */

require_once "Functions.php";
$pdo = connectDb();
$pdo->query('set names utf8');
//获取请求的方式
$method = $_SERVER["REQUEST_METHOD"];

if($method=="POST"){

    $sql = "SELECT parklot_id,parklot_address FROM parklot";
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
