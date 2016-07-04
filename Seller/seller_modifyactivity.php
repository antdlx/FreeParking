<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/1
 * Time: 10:32
 */
include_once("common.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $obj;
    $activity_id = $_POST["activity_id"];
    $activity_name = $_POST["activity_name"];
    $activity_starttime = $_POST["activity_starttime"];
    $activity_endtime = $_POST["activity_endtime"];
    $activity_detail = $_POST["activity_detail"];
    $activity_img = $_POST["activity_img"];
    $pdo = connectDB();
    $stmt = $pdo->prepare("select * from activity where activity_id = ?");
    $stmt->bindParam(1, $activity_id);
    $stmt->execute();
    $rowcount = $stmt->rowCount();
    if ($rowcount == 0)
        $obj["state"] = 1;
    else {
        $stmt = $pdo->prepare("update activity set activity_name =?, activity_starttime=?, activity_endtime=?, activity_detail=?, activity_img=?  where activity_id = ?");
        $stmt->bindParam(1, $activity_name);
        $stmt->bindParam(2, $activity_starttime);
        $stmt->bindParam(3, $activity_endtime);
        $stmt->bindParam(4, $activity_detail);
        $stmt->bindParam(5, $activity_img);
        $stmt->bindParam(6, $activity_id);
        $stmt->execute();
        $obj["state"] = 0;
    }
    echo json_encode($obj);
    return;
}