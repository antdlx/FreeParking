<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 16/6/30
 * Time: 下午4:58
 */

$pdo = new PDO('mysql:host=127.0.0.1;dbname=freeparking;charset=utf8', 'root', '123321');

function test_input($data){
    $data = trim($data);
    $data = stripcslashes($data);//去除反斜杠
    $data = htmlspecialchars($data);//去除< > ? 之类的html所含的特殊字符
    return $data;
}

$seller_id = test_input($_POST['seller_id']);

$stmt = $pdo->prepare("select * from activity where seller_id = '$seller_id';");

$stmt->execute();

$count = $stmt->rowCount();

$i = 0;
$activities;

if($count > 0 ){
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $activity['activity_id'] = urlencode($row['activity_id']);
        $activity['activity_name'] = urlencode($row['activity_name']);
        $activity['activity_starttime'] = urlencode($row['activity_starttime']);
        $activity['activity_endtime'] = urlencode($row['activity_endtime']);
        $activity['activity_detail'] = urlencode($row['activity_detail']);
        $activities[$i] = $activity;
        $i++;
    }
    echo urldecode(json_encode($activities));
}
else{
    $a = array(
      "state" => 0
    );

    echo json_encode($a);//没有数据
}





?>