<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 16/6/30
 * Time: 下午2:22
 */

header("Content-type:text/html; charset = utf-8");

require_once'conn.php';

session_start();

function test_input($data){
    $data = trim($data);
    $data = stripcslashes($data);//去除反斜杠
    $data = htmlspecialchars($data);//去除< > ? 之类的html所含的特殊字符
    return $data;
}


$user_id = $_POST['user_id'];
$user_password = $_POST['user_password'];

$con->query("set names utf8");//设置这些数据返回的编码是utf-8
//$log = fopen()


$check = $con->query("SELECT user_password FROM user where user_id = '$user_id'" );

$row = $check->fetch_array();
$password = $row['user_password'];
if($password == $user_password){
    $a = array(
        'state'=>0
    );
    echo json_encode($a);
}else{
    $a = array(
        'state'=>1
    );
    echo json_encode($a);
}

if(!empty($check)){
    $check ->free();
}

$con->close();



?>