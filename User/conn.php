<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 16/6/30
 * Time: 下午2:30
 */
header("Content-type:text/html; charset=utf-8");

$dbHost ="127.0.0.1";
$dbUser ="congjiujiu";
$dbPassword = "123456";
$database = "db_parking";

$con = new mysqli($dbHost, $dbUser, $dbPassword, $database);

if($con -> connect_error){
    $a = array(
        'status'=>2
    );
    echo json_encode($a);
}





?>