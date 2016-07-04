<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/1
 * Time: 12:23
 */
require_once("common.php");

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $seller_id = test_input($_POST["seller_id"]);
    $num = test_input($_POST["num"]);
    $pdo = connectDB();
    $num+=0;
    $stmt = $pdo->prepare("select * from activity where seller_id = ? order by activity_id limit $num,10");
    $stmt -> bindParam(1,$seller_id );
    $stmt->execute();
    $rowcnt = $stmt->rowCount();
    $array;
    $i = 0;
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $obj["activity_id"] = $row["activity_id"];
        $obj["activity_name"] = $row["activity_name"];
        $obj["activity_starttime"] = $row["activity_starttime"];
        $obj["activity_endtime"] = $row["activity_endtime"];
        $obj["activity_img"] = $row["activity_img"];
        $array[$i] = $obj;
        $i++;
    }
    $res["count"] = $rowcnt;
    $res["array"] = $array;
    echo json_encode($res);
    return;
}