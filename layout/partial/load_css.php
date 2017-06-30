<!-- cssの読み込み -->
<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="assets/font-awesome/css/font-awesome.css">
<!-- 独自cssの読み込みエリア -->
<link rel="stylesheet" type="text/css" href="assets/css/navbar.css">

<?php 
    $uri = $_SERVER['REQUEST_URI'];
    // スラッシュで配列化
    // 配列の一番最後の値を取得
    // ファイル名により分岐

    $uri_arr = explode('/', $uri);
    $file_name = end($uri_arr);
 ?>

 <?php if($file_name == 'timeline.php'): ?>
    <!-- timelineページのcss読み込み -->
    <link rel="stylesheet" type="text/css" href="assets/css/timeline.css">
 <?php endif; ?>