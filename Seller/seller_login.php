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

    $pdo = connectDB();
    $stmt = $pdo->prepare("select * from seller where seller_id=?");
    $stmt->bindParam(1, $seller_id);
    $stmt->execute();
    $count = $stmt->rowCount();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $obj;
    if ($count == 0) {
        //账号不存在
        $obj['state'] = 1;
    } else if ($seller_password == $row["seller_password"]) {
        //密码验证成功
        $obj['state'] = 0;

        $stmt = $pdo->prepare("select * from seller where seller_id = ?");
        $stmt->bindParam(1, $seller_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $obj["state"] = 0;
        $obj["seller_name"] = $row["seller_name"];
        $obj["seller_img"] = $row["seller_img"];
        $obj["seller_contact"] = $row["seller_contact"];
        $obj["seller_address"] = $row["seller_address"];
    } else {
        //密码错误
        $obj['state'] = 1;
    }
    echo json_encode($obj);
    return;
}