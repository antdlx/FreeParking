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
    $stmt->bindParam(1, $seller_id);
    $stmt->bindParam(2, $seller_password);
    $stmt->bindParam(3, $seller_name);
    $stmt->bindParam(4, $seller_address);
    $stmt->bindParam(5, $seller_contact);
    $stmt->bindParam(6, $seller_img);
    $stmt->execute();

    $obj;
    $obj['state'] = 0;
    echo json_encode($obj);
    return;
}

