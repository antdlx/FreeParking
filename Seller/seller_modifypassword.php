<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/1
 * Time: 9:09
 */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $obj;
    $seller_id = test_input($_POST["seller_id"]);
    $seller_oldpassword = test_input($_POST["seller_oldpassword"]);
    $seller_newpassword = test_input($_POST["seller_newpassword"]);

    $pdo = connectDB();
    $stmt = $pdo->prepare("select seller_password as password from seller where seller_id = ?");
    $stmt->bindParam(1, $seller_id);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $rowCount = $stmt->rowCount();
    $password = $row["password"];

    if ($rowCount == 1 && $seller_oldpassword == $password) {
        $obj["state"] = 0;

        $stmt = $pdo->prepare("update seller set seller_password where seller_id = ?");
        $stmt->bindParam(1, $seller_id);
        $stmt->execute();
    } else {
        $obj["state"] = 1;
    }
    echo json_encode($obj);
    return;
}