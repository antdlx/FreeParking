<?php
/**
 * Created by PhpStorm.
 * User: Pants
 * Date: 2016/6/30
 * Time: 22:06
 */
require_once("common.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $activity_name = test_input($_POST["activity_name"]);
    $activity_starttime = test_input($_POST["activity_starttime"]);
    $activity_endtime = test_input($_POST["activity_endtime"]);
    $activity_detail = test_input($_POST["activity_detail"]);
    $activity_img = test_input($_POST["activity_img"]);
    $seller_id = test_input($_POST["seller_id"]);

    $pdo = connectDB();
    $stmt = $pdo->prepare("insert into activity VALUES(null,?,?,?,?,?,?)");
    $stmt->bindParam(1, $activity_name);
    $stmt->bindParam(2, $activity_starttime);
    $stmt->bindParam(3, $activity_endtime);
    $stmt->bindParam(4, $activity_detail);
    $stmt->bindParam(5, $activity_img);
    $stmt->bindParam(6, $seller_id);
    $stmt->execute();

    $stmt = $pdo->prepare("select @@identity as id;");
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $obj;
    $obj['state'] = 0;
    $obj['activity_id'] = $row['id'];
    echo json_encode($obj);
    return;
}

