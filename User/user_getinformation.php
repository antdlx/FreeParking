<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 16/6/30
 * Time: 下午3:04
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


$con->query("set names utf8");

$check = $con->query("SELECT * FROM user where user_id = '$user_id'");
$row = $check->fetch_array();

$user_name = $row['user_name'];
$user_img = $row['user_img'];

$a = array(
  'user_name' =>$user_name,
  'user_img' =>$user_img
);

echo json_encode($a);

$con->close();

?>