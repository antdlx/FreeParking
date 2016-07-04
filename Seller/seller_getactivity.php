<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/1
 * Time: 10:49
 */
require_once("common.php");

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $activity_id = test_input($_POST["activity_id"]);
    $pdo = connectDB();
    $stmt = $pdo->prepare("select * from activity where activity_id = ?");
    $stmt->bindParam(1,$activity_id );
    $stmt->execute();
    $rowcount = $stmt->rowCount();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $obj;
    if($rowcount==0)
        $obj["state"] = 1;
    else{
        $obj["state"] = 0;
        $obj["activity_img"] = $row["activity_img"];
        $obj["activity_starttime"] = $row["activity_starttime"];
        $obj["activity_endtime"] = $row["activity_endtime"];
        $obj["activity_detail"] = $row["activity_detail"];
        $stmt = $pdo->prepare("select * from seller where seller_id = ?");
        $stmt ->bindParam(1,$row["seller_id"] );
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $obj["seller_address"] = $row["seller_address"];
        echo json_encode($obj);
    }
    return;
}