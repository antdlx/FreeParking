<?php
/**
 * Created by PhpStorm.
 * User: Ran
 * Date: 2016/7/1 0001
 * Time: 9:28
 */
/*
 * state => 0 无数据
 * state => 2 参数为空
 * 正常数据返回
 */

function test_input($data){
    $data = trim($data);
    $data = stripcslashes($data);//去除反斜杠
    $data = htmlspecialchars($data);//去除特殊html字符
    return $data;
}

$dbms = 'mysql';
$host = '127.0.0.1';
$dbName = 'freeparking';
$user = 'root';
$passwd = '123321';
$dsn = $dbms.':host='.$host.';dbName='.$dbName.';charset=UTF8';
try{
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=db_parking;charset=utf8', 'congjiujiu', '123456');


    $user_id = $_POST['user_id'];
    if(!$user_id){
        $tmp = array('state'=>2);
        echo json_encode($tmp);
        exit();
    }

    $stmt = $pdo->prepare("select * from ticket natural join activity natural join seller where user_id = '".$user_id."'
     where ticket_state <> 3 and ticket_state <> 4 order by ticket_deadLine asc;");
    $stmt->execute();

    $count = $stmt->rowCount();

    $i = 0;
    if($count > 0){
        $activitys = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $activity = array();

            $activity['ticket_id'] = urlencode($row['ticket_id']);
            $activity['seller_name'] = urlencode($row['seller_name']);
            $activity['activity_name'] = urlencode($row['activity_name']);
            $activity['ticket_deadline'] = urlencode($row['ticket_deadline']);

            $activitys[$i] = $activity;
            $i++;
        }
        echo urldecode(json_encode($activitys));

    }else{
        $tmp = array(
            "state"=>0
        );
        echo json_encode($tmp);
        exit();
    }

}catch(PDOException $e){
    die("Error:".$e->getMessage()."<br/>");
}

?>