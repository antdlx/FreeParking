<?php
/**
 * 用于返回manager信息的接口
 * 成功  manager_name,manager_img or 失败   1
 * Created by PhpStorm.
 * User: antdlx
 * Date: 2016/7/7
 * Time: 9:33
 */

require_once "Functions.php";

$method  =  $_SERVER['REQUEST_METHOD'];
$manager_id = $_POST['manager_id'];
$pdo = connectDb();

$pdo->query('set names utf8');

if(($method=='POST') && (!empty($manager_id))){

    $sql = "SELECT manager_name,manager_img FROM manager WHERE manager_id = '$manager_id'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $list = $stmt ->fetchAll(PDO::FETCH_ASSOC);
    $count = $stmt->rowCount();

    if($count == 1){

        echo json1($list[0]);

    }else{
        echo 1;
    }

}else{
    echo 1;
}
