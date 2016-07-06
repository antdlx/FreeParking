<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 16/7/1
 * Time: 下午2:45
 *
*/
$pdo = new PDO('mysql:host=127.0.0.1;dbname=db_parking;charset=utf8', 'congjiujiu', '123456');

function test_input($data){
    $data = trim($data);
    $data = stripcslashes($data);//去除反斜杠
    $data = htmlspecialchars($data);//去除< > ? 之类的html所含的特殊字符
    return $data;
}

$user_id = $_POST['user_id'];
$user_name = $_POST['user_name'];
$user_img = $_POST['user_img'];

$stmt = $pdo->prepare("update user set user_name = ?, user_img = ? where user_id = ? ");
$stmt->bindParam(1,$user_name);
$stmt->bindParam(2,$user_img);
$stmt->bindParam(3,$user_id);

$result = $stmt->execute();
$count = $stmt->rowCount();

if($result){
    $a = array(
        'state'=>0
    );

}else{
    $a = array(
        'state'=>1
    );
}

echo json_encode($a);


?>