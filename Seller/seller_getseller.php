<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/1
 * Time: 8:44
 */
require_once("common.php");

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $seller_id = test_input($_POST["seller_id"]);
    $pdo = connectDB();
    $stmt = $pdo->prepare("select * from seller where seller_id = ?");
    $stmt->bindParam(1,$seller_id );
    $stmt->execute();
    $rowcount = $stmt->rowCount();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $obj;
    if($rowcount==0)
        $obj["state"] = 1;
    else{
        $obj["state"] = 0;
        $obj["seller_name"] = $row["seller_name"];
        $obj["seller_img"] = $row["seller_img"];
        $obj["seller_contact"] = $row["seller_contact"];
        $obj["seller_address"] = $row["seller_address"];
        $obj["seller_location_j"] = $row["seller_location_j"];
        $obj["seller_location_w"] = $row["seller_location_w"];
        echo json_encode($obj);
    }
    return;
}