<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/1
 * Time: 10:43
 */
include_once("common.php");
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $obj;
    $activity_id = $_POST["activity_id"];
    $pdo = connectDB();
    $stmt = $pdo->prepare("select * from activity where activity_id = ?");
    $stmt->bindParam(1,$activity_id );
    $stmt->execute();
    $rowcount = $stmt->rowCount();
    if($rowcount == 0)
        $obj["state"] = 1;
    else{
        $stmt = $pdo->prepare("delete from activity where activity_id = ?");
        $stmt->bindParam(1,$activity_id );
        $stmt->execute();
        $obj["state"] = 0;
    }
    echo json_encode($obj);
    return;
}