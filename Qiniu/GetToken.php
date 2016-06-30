<?php
/**
 * Created by PhpStorm.
 * User: antdlx
 * Date: 2016/6/30
 * Time: 15:57
 */
require_once "Auth.php";
require_once "../ParkingLot/Functions.php";

use Qiniu\Auth;

$bucket = "freeparking";
$accessKey = "BH5izUYX7Ozzjm5_Y7MQfz_BDa9H4C36Uv1h2a4N";
$secretKey = "p0-jtBog5sOW0oaM4GF_1nEkQwRK13kPzIcxsEdp";

$auth = new Auth($accessKey, $secretKey);
$upToken = $auth->uploadToken($bucket);

$res = array('uptoken' => $upToken);

echo json1($res);

?>