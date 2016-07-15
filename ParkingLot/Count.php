<?php
/**
 * Created by PhpStorm
 * 获取今天停车的数量的类
 * 需要传入一个pdo对象
 * return -> 停车的数量
 * User: antdlx
 * Date: 2016/6/30
 * Time: 16:45
 */

require_once "Functions.php";

class Count{

    function GetCount($_pdo,$_manager_id){

        $pdo =$_pdo;
        $pdo->query('set names utf8');
        $manager_id= $_manager_id;

        date_default_timezone_set('Asia/Shanghai');

        $current_date = date('Y-m-d',time());

//        $sql = "SELECT count(ticket_id) FROM ticket NATURAL JOIN activity NATURAL JOIN seller_parklot WHERE parklot_id =(SELECT parklot_id FROM manager WHERE manager_id = '$manager_id')AND ticket_state=4 AND day(ticket_usetime) = day('$current_date')";
        $sql = "SELECT count(ticket_id) FROM ticket NATURAL JOIN activity NATURAL JOIN seller_parklot WHERE parklot_id =(SELECT parklot_id FROM manager WHERE manager_id = '$manager_id')AND ticket_state=4";
        $stmt = $pdo->prepare($sql);
        $stmt ->execute();
        $list = $stmt ->fetchAll(PDO::FETCH_ASSOC);

        return $list[0]['count(ticket_id)'];
    }
}
