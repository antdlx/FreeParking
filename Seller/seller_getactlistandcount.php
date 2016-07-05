<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/1
 * Time: 12:23
 */
require_once("common.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $seller_id = test_input($_POST["seller_id"]);
    $num = test_input($_POST["num"]);
    $pdo = connectDB();
    $stmt = $pdo->prepare("select seller_address from seller where seller_id = ?");
    $stmt->bindParam(1, $seller_id);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $address = $row["seller_address"];
    $num += 0;
    $stmt = $pdo->prepare("select * from activity where seller_id = ? order by activity_id limit $num,10");
    $stmt->bindParam(1, $seller_id);
    $stmt->execute();
    $rowcnt = $stmt->rowCount();
    $array;
    $i = 0;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $obj["activity_id"] = $row["activity_id"];
        $obj["activity_name"] = $row["activity_name"];
        $obj["activity_starttime"] = $row["activity_starttime"];
        $obj["activity_endtime"] = $row["activity_endtime"];
        $obj["activity_img"] = $row["activity_img"];
        $stmt2 = $pdo->prepare("select * from ticket where activity_id = ?");
        $stmt2->bindParam(1, $row["activity_id"]);
        $stmt2->execute();
        $ticketcnt = $stmt2->rowCount();
        $obj["Tcount"] = $ticketcnt;
        $array[$i] = $obj;
        $i++;
    }
    $res["count"] = $rowcnt;
    $res["seller_address"] = $address;
    $res["array"] = $array;
    echo json_encode($res);
    return;
}