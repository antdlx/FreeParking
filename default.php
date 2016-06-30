<?php
/**
 * Created by PhpStorm.
 * User: dell-pc
 * Date: 2015/11/14
 * Time: 12:45
 */


$pdo = new PDO('mysql:host=127.0.0.1;dbname=db_parking;charset=utf8', 'congjiujiu', '123456');
$stmt = $pdo->prepare("select * from ticket_state");
$stmt->execute();
$count = $stmt->rowCount();

$states;
$i = 0;
if ($count > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $state["a"] = urlencode($row["state"]);
        $state["b"] = urlencode($row["description"]);
        $states[$i] = $state;
        $i++;
    }
    echo urldecode(json_encode($states));
} else {
    echo 1;
}