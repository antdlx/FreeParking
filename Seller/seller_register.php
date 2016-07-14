<?php
/**
 * Created by PhpStorm.
 * User: Pants
 * Date: 2016/6/30
 * Time: 21:11
 */
require_once("common.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $seller_id = test_input($_POST["seller_id"]);
    $seller_password = test_input($_POST["seller_password"]);
    $seller_name = test_input($_POST["seller_name"]);
    $seller_address = test_input($_POST["seller_address"]);
    $seller_contact = test_input($_POST["seller_contact"]);
    $seller_img = test_input($_POST["seller_img"]);
    $seller_location_j = test_input($_POST["seller_location_j"]);
    $seller_location_w = test_input($_POST["seller_location_w"]);

    $pdo = connectDB();
    $stmt = $pdo->prepare("select * from seller where seller_id=?");
    $stmt->bindParam(1, $seller_id);
    $stmt->execute();
    $count = $stmt->rowCount();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $obj;
    if ($count >= 1) {
        //同名账号已存在
        $obj['state'] = 1;
    } else {
        //未有同名账号
        $obj['state'] = 0;

        $stmt->closeCursor();
        $stmt = $pdo->prepare("insert into seller VALUES(?,?,?,?,?,?,?,?)");
        $stmt->bindParam(1, $seller_id);
        $stmt->bindParam(2, $seller_password);
        $stmt->bindParam(3, $seller_name);
        $stmt->bindParam(4, $seller_address);
        $stmt->bindParam(5, $seller_contact);
        $stmt->bindParam(6, $seller_img);
        $stmt->bindParam(7, $seller_location_j);
        $stmt->bindParam(8, $seller_location_w);
        $stmt->execute();
    }
    echo json_encode($obj);
    return;
}