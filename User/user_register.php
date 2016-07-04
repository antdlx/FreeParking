<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 16/6/30
 * Time: 下午5:47
 */
$pdo = new PDO('mysql:host=127.0.0.1;dbname=freeparking;charset=utf8', 'root', '123321');

function test_input($data){
    $data = trim($data);
    $data = stripcslashes($data);//去除反斜杠
    $data = htmlspecialchars($data);//去除< > ? 之类的html所含的特殊字符
    return $data;
}


$user_id = test_input($_POST['user_id']);
$user_password = test_input($_POST['user_password']);
$user_name = $_POST['user_name'];
$user_img = $_POST['user_img'];

print($user_id);
print($user_password);
print($user_name);
print($user_img);


if(!$user_id || !$user_password || !$user_name || !$user_img){
    $a = array(
        'state'=>2
    );
    echo json_encode($a);
    exit();
}


$stmt = $pdo->prepare("select user_id from user where user_id = '$user_id'");
$stmt->execute();

$count = $stmt->rowCount();


if($count == 0){
    $stm = $pdo->prepare("insert into user values('$user_id','$user_password','$user_name','$user_img')");
    $stm->execute();

    $a = array(
        'state'=>0
    );
}else if($count > 0){

    $a = array(
        'state'=>1
    );
}

echo json_encode($a);



?>