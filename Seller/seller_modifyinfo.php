<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/1
 * Time: 9:30
 */
include_once("common.php");
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $obj;
    $seller_id = $_POST["seller_id"];
    $seller_img = $_POST["seller_img"];
    $seller_name = $_POST["seller_name"];
    $seller_address = $_POST["seller_address"];
    $seller_contact = $_POST["seller_contact"];
    $pdo = connectDB();
    $stmt = $pdo->prepare("select * from seller where seller_id = ?");
    $stmt->bindParam(1,$seller_id );
    $stmt->execute();
    $rowcount = $stmt->rowCount();
    if($rowcount == 0)
        $obj["state"] = 1;
    else{
        $stmt = $pdo->prepare("update seller set seller_img =? ,seller_name = ?, seller_address = ? ,seller_contact = ? where seller_id = ?");
        $stmt->bindParam(1,$seller_img);
        $stmt->bindParam(2,$seller_name );
        $stmt->bindParam(3,$seller_address );
        $stmt->bindParam(4,$seller_contact);
        $stmt->bindParam(5,$seller_id );
        $stmt->execute();
        $obj["state"] = 0;
    }
    echo json_encode($obj);
    return;
}