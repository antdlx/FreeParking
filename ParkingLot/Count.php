<?php
/**
 * Created by PhpStorm.
 * 获取今天停车的数量的类
 * 需要传入一个pdo对象
 * return -> 停车的数量
 * User: antdlx
 * Date: 2016/6/30
 * Time: 16:45
 */

require_once "Functions.php";

class Count{

    function GetCount($_pdo){

        $pdo =$_pdo;

        date_default_timezone_set('Asia/Shanghai');

        $current_date = date('Y-m-d',time());

        $sql = "SELECT count(ticket_id) FROM ticket WHERE ticket_state=4 AND day(ticket_usetime) = day('$current_date')";
        $stmt = $pdo -> query($sql);
        $list = $stmt ->fetchAll(PDO::FETCH_ASSOC);

        return $list[0]['count(ticket_id)'];
    }
}
