<?php
session_start();
require('../../../../common/dbconnect.php');
require('../../../../common/functions.php');

$jason = file_get_contents('geocode.js');
// 外部からデータの中身を取得したい時
echo '<pre>';
var_dump($jason);
echo '<pre>';

// jasonデータを配列にデコードする
$decode_date = json_decode($jason, true);
// true指定で配列として取得
echo '<pre>';
var_dump($decode_date);
echo '<pre>';

// キー指定して値を出力
// echo $decode_date['name'];
// echo '<br>';
// echo $decode_date['skills'][1];
// echo '<br>';
// echo $decode_date['skills'][3]['PHP'][1];


// $sql = 'INSERT INTO  events SET e_Lat = ?,e_Lng = ?'
// $data = [$decode_date['e_Lat'],$decode_date['e_Lng']];
// $stmt = $dbh->prepare($sql);
// $stmt->execute($data);
// $record = $stmt->fetch(PDO::FETCH_ASSOC);

?>