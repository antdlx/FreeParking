<?php
/**
 * Created by PhpStorm.
 * 用来修改密码的接口
 * 成功返回0，失败返回1
 * User: antdlx
 * Date: 2016/6/30
 * Time: 23:42
 */

require_once "Functions.php";

$pdo  = connectDb();
$pdo->query('set names utf8');
$method = $_SERVER['REQUEST_METHOD'];
$manager_id  = $_POST['manager_id'];
$manager_oldpassword   = $_POST['manager_oldpassword'];
$manager_newpassword  = $_POST['manager_newpassword'];

if($method=='POST' && (!empty($manager_id)) && (!empty($manager_oldpassword)) && (!empty($manager_newpassword))){

    try{
        $pdo -> beginTransaction();

        $sql = "SELECT manager_id FROM manager WHERE manager_id = '$manager_id' AND manager_password = '$manager_oldpassword'";
        $stmt = $pdo -> prepare($sql);
        $stmt ->execute();
        $num = $stmt -> rowCount();

        if($num == 1){
            $sql = "UPDATE manager SET manager_password = '$manager_newpassword' WHERE manager_id = '$manager_id'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();

            echo 0;
            $pdo -> commit();
        }else{
            echo 1;
            $pdo->rollBack();
        }

    }catch (PDOException $e){
        echo 1;
        $pdo->rollBack();
    }

}else{
    echo 1;
}
