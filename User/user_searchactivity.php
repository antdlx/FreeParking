<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 16/6/30
 * Time: 下午4:19
 */


$pdo = new PDO('mysql:host=127.0.0.1;dbname=db_parking;charset=utf8', 'congjiujiu', '123456');

function test_input($data){
    $data = trim($data);
    $data = stripcslashes($data);//去除反斜杠
    $data = htmlspecialchars($data);//去除< > ? 之类的html所含的特殊字符
    return $data;
}

$search_word = $_POST['search_word'];
$number_limit = $_POST['number_limit'];



$sql = "select count(*) as number from seller where seller_name like '%".$search_word."%' order by seller_id";

$stmt = $pdo->prepare($sql);

$stmt->execute();

$row = $stmt->fetch(PDO::FETCH_ASSOC);
$count = $row['number'];

print($count);


if($number_limit > $count){
    echo -1;//没有数据
}
else{
    $stmt = $pdo->prepare("select * from seller where seller_name like '%$search_word%' order by seller_id limit $number_limit,10");
}

$stmt->execute();
$count = $stmt->rowCount();

print($count);


$i = 0;
$as;
$b;

if($count > 0 ){
    if($count > 10)
        $b = 10;
    else
        $b = $count;
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $a['seller_id'] = urlencode($row['seller_id']);
        $a['seller_name'] = urlencode($row['seller_name']);
        $a['seller_address'] = urlencode($row['seller_address']);
        $a['seller_contact'] = urlencode($row['seller_contact']);
        $a['seller_img'] = urlencode($row['seller_img']);
        $as[$i] = $a;
        $i++;
    }
    echo urldecode(json_encode($b));
    echo urldecode(json_encode($as));
}
else{
    echo 0;//没有数据
}

?>