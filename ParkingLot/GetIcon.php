<?php
/**
 * Created by PhpStorm.
 * 实时获得头像的接口
 * 1->用户不存在  or manager_url 用户的头像url
 * User: antdlx
 * Date: 2016/6/30
 * Time: 16:20
 */

require_once "Functions.php";
$pdo = connectDb();

//获取请求的方式
$method = $_SERVER["REQUEST_METHOD"];
$manager_id = $_POST['manager_id'];

if($method=="POST" && (!empty($manager_id))){

    $sql = "SELECT manager_img FROM manager WHERE manager_id = '$manager_id'";
    $stmt = $pdo->query($sql);
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