<?php
/**
 * Created by PhpStorm.
 * 管理员登录的接口
 * 成功->0 or 失败->1
 * User: antdlx
 * Date: 2016/6/30
 * Time: 16:31
 */

require_once "Count.php";

$pdo = connectDb();

$method = $_SERVER['REQUEST_METHOD'];
$manager_id = $_POST['manager_id'];
$manager_pwd = $_POST['manager_password'];

if($method=='POST' && (!empty($manager_id)) && (!empty($manager_pwd))){

    $sql = "SELECT  manager_id FROM manager WHERE manager_id = '$manager_id' AND manager_password = '$manager_pwd'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $num = $stmt -> rowCount();

    if($num == 0 ){
        echo 1;
    }else{
        $func = new Count();
        $count = $func -> GetCount($pdo);
        $list = array("car_count" => $count);
        echo json1($list);
    }

}else{
    echo 1;
}