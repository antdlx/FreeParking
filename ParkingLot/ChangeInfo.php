<?php
/**
 * Created by PhpStorm.
 * 修改账户信息的接口
 * 成功返回0，失败返回1
 * User: antdlx
 * Date: 2016/7/1
 * Time: 9:42
 */

require_once "Functions.php";

$pdo  = connectDb();
$pdo->query('set names utf8');
$manager_id = $_POST['manager_id'];
$manager_img = $_POST['manager_img'];
$manager_name = $_POST['manager_name'];

$method = $_SERVER['REQUEST_METHOD'];

if($method=='POST' &&   (!empty($manager_id)) && (!empty($manager_img)) && (!empty($manager_name))){

    try{
        $pdo->beginTransaction();

        $sql = "UPDATE manager SET manager_img = '$manager_img', manager_name = '$manager_name' WHERE manager_id = '$manager_id'";
        $stmt = $pdo->prepare($sql);
        $stmt ->execute();

        if($stmt==1){
            echo 0;
            $pdo->commit();
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