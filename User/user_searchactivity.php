<?php
/**
 *
 */

/*
 *  select SQRT(POW((location_j - 117.1234) * 10,2) + POW((location_w - 36.1234) * 10,2)) as distance from seller;
 *  select SQRT(POW((location_j - 117.1234) * 10,2) + POW((location_w - 36.1234) * 10,2)) as distance from seller order by distance asc;
 */

$pdo = new PDO('mysql:host=127.0.0.1;dbname=db_parking;charset=utf8', 'congjiujiu', '123456');

function test_input($data){
    $data = trim($data);
    $data = stripcslashes($data);//去除反斜杠
    $data = htmlspecialchars($data);//去除< > ? 之类的html所含的特殊字符
    return $data;
}

$search_word = test_input($_POST['search_word']);
$number_limit = test_input($_POST['number_limit']);
$location_j = test_input($_POST['location_j']);
$location_w = test_input($_POST['location_w']);

$RADIUS = 8;//单位km 显示的商家距离范围

$sql = "select seller_id,seller_name,seller_address,seller_contact,seller_img,SQRT(POW((location_j - $location_j) * 111,2) + POW((location_w - $location_w) * 111,2)) as distance
from seller where seller_name like '%$search_word%' order by distance limit $number_limit,10";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$count = $stmt->rowCount();


$i = 0;
$as;
$b;

if($count > 0 ){
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        if($row['distance'] < $RADIUS){
            $a['seller_id'] = urlencode($row['seller_id']);
            $a['seller_name'] = urlencode($row['seller_name']);
            $a['seller_address'] = urlencode($row['seller_address']);
            $a['seller_contact'] = urlencode($row['seller_contact']);
            $a['seller_img'] = urlencode($row['seller_img']);
            $a['distance'] = urlencode($row['distance']);
            $as[$i] = $a;
            $i++;
        }
    }
    echo urldecode(json_encode($as));
}
else{
    echo 0;//没有数据
}

?>