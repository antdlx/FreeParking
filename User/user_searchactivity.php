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



$sql = "select count(*) as number from activity join seller using (seller_id) where seller_name like '%".$search_word."%'";

$stmt = $pdo->prepare($sql);

$stmt->execute();

$row = $stmt->fetch(PDO::FETCH_ASSOC);
$count = $row['number'];

print($count);


if($number_limit > $count){
    echo -1;//没有数据
}
else if($number_limit + 10 > $count){
    $stmt = $pdo->prepare("select * from activity join seller using(seller_id) where seller_name like '%$search_word%' and activity_id between '$number_limit' and '$count'");

}
else{
    $stmt = $pdo->prepare("select * from activity join seller using (seller_id) where seller_name like '%$search_word%'
    and activity_id between '$number_limit' and ('$number_limit'+10)");
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
        $a['activity_name'] = urlencode($row['activity_name']);
        $a['activity_address'] = urlencode($row['activity_address']);
        $a['activity_contact'] = urlencode($row['activity_contact']);
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