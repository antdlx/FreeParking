<?php
/**
 * Created by PhpStorm.
 * User: Ran
 * Date: 2016/7/1 0001
 * Time: 14:10
 */

/*
 * state => 0 成功
 * state => 1 失败
 */

function test_input($data){
    $data = trim($data);
    $data = stripcslashes($data);//去除反斜杠
    $data = htmlspecialchars($data);//去除特殊html字符
    return $data;
}

try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=freeparking;charset=utf8', 'root', '123321');

    $user_id = test_input($_POST['user_id']);
    $user_oldpassword = test_input($_POST['user_oldpassword']);
    $user_newpassword = test_input($_POST['user_newpassword']);

    $stmt = $pdo->prepare("select * from user where user_id = '$user_id' and user_password = '$user_oldpassword'");
    $stmt->execute();
    $count = $stmt->rowCount();

    if($count > 0){
        $sql = "update user set user_password = '$user_newpassword' where user_id = '$user_id'";
        $result = $pdo->exec($sql);
        if($result){
            success();
        }else{
            fail();
        }
    }else{
        fail();
    }
}catch(PDOException $e){
    die("Error".$e->getMessage()."<br/>");
}

function success(){
    $tmp = array(
        "state" => 0
    );
    echo json_encode($tmp);
    exit();
}

function fail(){
    $tmp = array(
        "state" => 1
    );
    echo json_encode($tmp);
    exit();
}

?>