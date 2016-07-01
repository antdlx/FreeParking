<?php
/**
 * Created by PhpStorm.
 * User: antdlx
 * Date: 2016/6/30
 * Time: 15:00
 */
function connectDb(){
    try{
        $conn = "mysql:host=localhost;dbname=db_parking";
        $pdo = new PDO($conn,"root","");
        //异常处理：显示exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }catch (PDOException $e){
        die('can not connect to the db :'.$e->getMessage());
    }
    return $pdo;
}

/**
 *防止utf8乱码
 * @param $array
 * @param $function
 * @param bool|false $apply_to_keys_also
 */
function arrayRecursive(&$array, $function, $apply_to_keys_also = false)
{
    static $recursive_counter = 0;
    if (++$recursive_counter > 1000)
    {
        die('possible deep recursion attack');
    }
    foreach ($array as $key => $value)
    {
        if (is_array($value))
        {
            arrayRecursive($array[$key], $function, $apply_to_keys_also);
        }
        else
        {
            $array[$key] = $function($value);
        }
        if ($apply_to_keys_also && is_string($key))
        {
            $new_key = $function($key);
            if ($new_key != $key)
            {
                $array[$new_key] = $array[$key];
                unset($array[$key]);
            }
        }
    }
    $recursive_counter--;
}

/**
 * 防止乱码
 * @param $array 输入的utf8数组
 * @return string  返回解码后的不会乱码的数组
 */
function json1($array)
{
    arrayRecursive($array, 'urlencode', true);
    $json = json_encode($array);
    return urldecode($json);
}