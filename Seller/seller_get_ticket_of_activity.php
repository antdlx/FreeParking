<?php
/**
 * Created by PhpStorm.
 * User: Pants
 * Date: 2016/6/30
 * Time: 21:11
 */
require_once("common.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $activity_id = test_input($_POST["activity_id"]);
    $num = test_input($_POST["num"]);

    $obj;
    $pdo = connectDB();
    $stmt = $pdo->prepare("select * from activity where activity_id=?");
    $stmt->bindParam(1, $activity_id);
    $stmt->execute();
    $rowCount = $stmt->rowCount();
    if ($rowCount == 0) {
        $obj['state'] = 1;
    } else {
        $obj['state'] = 0;

        $stmt = $pdo->prepare("select * from ticket as a LEFT OUTER JOIN `user` as b On a.user_id=b.user_id where activity_id=? LIMIT $num,10");
        $stmt->bindParam(1, $activity_id);
        $stmt->execute();
        $rowCount = $stmt->rowCount();

        $array;
        $i = 0;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $ticket;
            $ticket['ticket_id'] = $row['ticket_id'];
            $ticket['user_name'] = $row['user_name'];
            $ticket['ticket_usetime'] = $row['ticket_usetime'];
            $ticket['ticket_deadLine'] = $row['ticket_deadLine'];
            $ticket['ticket_state'] = $row['ticket_state'];
            $array[$i] = $ticket;
            $i++;
        }
        $obj['count'] = $rowCount;
        $obj['array'] = $array;
    }
    echo json_encode($obj);
    return;
}