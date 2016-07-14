<?php
/**
 * Created by PhpStorm.
 * User: antdlx
 * Date: 2016/7/14
 * Time: 10:03
 */
require_once "Auth.php";
require_once "../ParkingLot/Functions.php";

use Qiniu\Auth;
$method = $_SERVER['REQUEST_METHOD'];
$key = $_POST['key'];

if($method == 'POST' && (!empty($key))){
    $bucket = "freeparking";
    $accessKey = "BH5izUYX7Ozzjm5_Y7MQfz_BDa9H4C36Uv1h2a4N";
    $secretKey = "p0-jtBog5sOW0oaM4GF_1nEkQwRK13kPzIcxsEdp";

    $auth = new Auth($accessKey, $secretKey);

    date_default_timezone_set('Asia/Shanghai');

    $current_date = time();

    //制定上传策略
    $policy = array(
        'savekey' => 'antdlx'.$current_date
    );

    $upToken = $auth->uploadToken($bucket,$key,3600,$policy);

    $res = array('uptoken' => $upToken);

    echo json1($res);
}
