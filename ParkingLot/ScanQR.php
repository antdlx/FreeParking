<?php
/**
 * Created by PhpStorm.
 * 验证二维码的接口
 * 验证成功>>0 or 未绑定用户>>1 or 已使用>>2 or 已过期>>3 or 失败 4
 * User: antdlx
 * Date: 2016/7/1
 * Time: 0:00
 */

require_once "Functions.php";

$pdo = connectDb();
$pdo->query('set names utf8');
$method = $_SERVER['REQUEST_METHOD'];
$ticket_id = $_POST['ticket_id'];
$manager_id = $_POST['manager_id'];

date_default_timezone_set('Asia/Shanghai');

if($method == "POST"  && (!empty($ticket_id)) && (!empty($manager_id))){

    try{
        $sql = "SELECT ticket_state FROM ticket WHERE ticket_id = '$ticket_id'";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $list = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $num = $stmt->rowCount();

        if($num == 0){
            echo 4;
        }else{

            //检查有没有过期
            $time = date('Y-m-d H:i:s',time());
            $sql = "SELECT ticket_id FROM ticket WHERE ticket_deadLine >= '$time' AND ticket_id = '$ticket_id'";
            $stmt = $pdo -> prepare($sql);
            $stmt->execute();
            $num = $stmt -> rowCount();

            $state = $list[0]['ticket_state'];

            $pdo -> beginTransaction();

            if($num == 1){
                switch($state){
                    case 1:
                        //未绑定
                        echo 1;
                        break;
                    case 2:
                        //检查是否属于这个停车场
                        $sql = "SELECT count(ticket_id) FROM ticket NATURAL JOIN activity NATURAL JOIN seller_parklot NATURAL JOIN manager WHERE ticket_id = '$ticket_id' AND manager_id = '$manager_id'";
                        $stmt = $pdo->prepare($sql);
                        $stmt ->execute();
                        $list = $stmt ->fetchAll(PDO::FETCH_ASSOC);
                        if($list[0]['count(ticket_id)']==0){
                            echo 5;
                            return;
                        }

                        $sql = "UPDATE ticket SET ticket_usetime = '$time',ticket_state=4 WHERE ticket_id = '$ticket_id'";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute();
                        if($stmt->rowCount()==1){
                            //验证成功
                            echo 0;
                            $pdo->commit();
                        }else{
                            echo 4;
                            $pdo->rollBack();
                        }
                        break;
                    case 4:
                        //已使用
                        echo 2;
                        break;
                    default:
                        //验证失败
                        echo 44;
                        $pdo -> rollBack();
                }
            }else{
                //已过期
                echo 3;
                $sql = "UPDATE ticket SET ticket_state = 3 WHERE ticket_id = '$ticket_id'";
                $stmt = $pdo -> prepare($sql);
                $bool=$stmt ->execute();
                if(!$bool){
                    echo 444;
                    $pdo -> rollBack();
                }
            }
        }

    }catch (PDOException $e){
        echo $e;
        $pdo -> rollBack();
    }

}else{
    echo 44444;
}