 	<!-- CSSの読み込み -->
 	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
 	<link rel="stylesheet" type="text/css" href="assets/font-awsome/css/font-awsome.css">
 	<!-- 独自CSSの読み込みエリア -->
 	<link rel="stylesheet" type="text/css" href="assets/css/navbar.css">
 	<!-- URLにより分岐させる
 		例）読み込みファイル名がtimeline.phpの時 -->



<?php 

$uri = $_SERVER['REQUEST_URI'];
// /20170508_Basic/layout_sample/index.php
// var_dump($uri);
// スラッシュ区切りで配列化
// 配列の一番最後の値を取得
// ファイル名により分岐

$uri_arr = explode('/', $uri);
var_dump($uri_arr);
$file_name = end($uri_arr);

 ?>

 <?php if ($file_name == 'timeline.php') : ?>
 	<!-- timelineページのCSSの読み込み -->
 <?php endif ; ?>