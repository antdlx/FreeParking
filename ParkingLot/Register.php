<?php
/**
 * Created by PhpStorm.
 * 账号注册接口
 * 成功返回0，账号重复返回1，创建失败2
 * User: antdlx
 * Date: 2016/6/30
 * Time: 23:24
 */

require_once "Functions.php";

$pdo = connectDb();
$pdo->query('set names utf8');
$method = $_SERVER['REQUEST_METHOD'];

$manager_id = $_POST['manager_id'];
$manager_img = $_POST['manager_img'];
$manager_name = $_POST['manager_name'];
$manager_password = $_POST['manager_password'];
$parklot_id= $_POST['parklot_id'];

if($method=='POST' && (!empty($parklot_id)) && (!empty($manager_id)) && (!empty($manager_img)) && (!empty($manager_name)) && (!empty($manager_password))){

    try{

        $sql = "SELECT manager_id FROM manager WHERE manager_id = '$manager_id'";
        $stmt = $pdo -> prepare($sql);
        $stmt->execute();
        $num = $stmt->rowCount();

        if($num == 0){

            $pdo -> beginTransaction();

            $sql = "INSERT INTO manager VALUES (?,?,?,?,?)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(1,$manager_id);
            $stmt -> bindValue(2,$manager_img);
            $stmt -> bindValue(3,$manager_name);
            $stmt -> bindValue(4,$manager_password);
            $stmt -> bindValue(5,$parklot_id);
            $stmt ->execute();

            $num = $stmt->rowCount();

            if($num == 1){
                echo 0;
                $pdo->commit();
            }else{
                //创建失败
                echo 2;
                $pdo->rollBack();
            }

        }else{
            echo 1;
        }

    }catch (PDOException $e){
        echo 3;
    }

}else{
    echo 2;
}