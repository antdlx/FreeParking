<?php
/**
 * Created by PhpStorm.
 * User: Pants
 * Date: 2016/6/30
 * Time: 21:11
 */

function connectDB(){
    return new PDO('mysql:host=127.0.0.1;dbname=db_parking;charset=utf8', 'congjiujiu', '123456');
}

function test_input($input)
{
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

