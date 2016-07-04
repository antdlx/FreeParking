<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/1
 * Time: 9:09
 */
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $obj;
    $seller_id = test_input($_POST["seller_id"]);
    $seller_oldpassword = test_input($_POST["seller_oldpassword"]);
    $seller_newpassword = test_input($_POST["seller_newpassword"]);
    if($seller_oldpassword!=$seller_newpassword){
        $obj["state"] = 0;
    }else{
        $pdo = connectDB();
        $stmt = $pdo->prepare("update seller set seller_password where seller_id = ?");
        $stmt->bindParam(1,$seller_id);
        $stmt->execute();
        $obj["state"] = 1;
    }
    echo json_encode($obj);
    return;
}