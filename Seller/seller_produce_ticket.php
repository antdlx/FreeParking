<?php
/**
 * Created by PhpStorm.
 * User: Pants
 * Date: 2016/6/30
 * Time: 21:11
 */
require_once("common.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ticket_id = test_input($_POST["ticket_id"]);
    $ticket_deadline = test_input($_POST["ticket_deadline"]);
    $activity_id = test_input($_POST["activity_id"]);

    $obj;
    $pdo = connectDB();
    $stmt = $pdo->prepare("select * from activity where activity_id=?");
    $stmt->bindParam(1, $activity_id);
    $stmt->execute();
    $rowCount = $stmt->rowCount();
    if ($rowCount == 0) {
        $obj['state'] = 1;
    }else{
        $obj['state'] = 0;

        $stmt = $pdo->prepare("insert into ticket VALUES(?,?,1,null,?,null)");
        $stmt->bindParam(1, $ticket_id);
        $stmt->bindParam(2, $ticket_deadline);
        $stmt->bindParam(3, $activity_id);
        $stmt->execute();
    }
    echo json_encode($obj);
    return;
}