<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 16/6/30
 * Time: 下午5:27
 */

$pdo = new PDO('mysql:host=127.0.0.1;dbname=db_parking;charset=utf8', 'congjiujiu', '123456');

function test_input($data){
    $data = trim($data);
    $data = stipcslashes($data);//去除反斜杠
    $data = htmlspecialchars($data);//去除< > ? 之类的html所含的特殊字符
    return $data;
}

$ticket_id = test_input($_POST['ticket_id']);
$user_id = test_input($_POST['user_id']);

$stmt = $pdo->prepare("select ticket_state from ticket where ticket_id = '$ticket_id'");
$stmt->execute();

$row = $stmt->fetch(PDO::FETCH_ASSOC);
$state = $row['ticket_state'];

if($state == 1){
    $a = array(
        'state'=>0
    );

    $stmt = $pdo->prepare("update ticket set ticket_state = 2,user_id = ?");
    $stmt->bindParam(1,$user_id);
    $stmt->execute();

    echo json_encode($a);
}
else if($state == 2){
    $a = array(
        'state'=>1
    );
    echo json_encode($a);
}



?>