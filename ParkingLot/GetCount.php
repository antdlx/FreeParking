<?php
/**
 * Created by PhpStorm.
 * 返回当天停车数量的接口
 * return -> 停车的数量
 * User: antdlx
 * Date: 2016/6/30
 * Time: 17:16
 */

require_once "Count.php";

$method = $_SERVER['REQUEST_METHOD'];
$manager_id=$_POST['manager_id'];

if($method == "POST"){

    $pdo = connectDb();
    $func = new Count();
    $num = $func ->GetCount($pdo,$manager_id);
    $list = array("car_count" => $num);
    echo json1($list);

}

