<?php 
session_start();
require('../../../common/dbconnect.php');
require('../../../common/functions.php');

$sql = 'SELECT e_Lat,e_Lng FROM events WHERE event_id=1';
// $data = [$event_id];
$stmt = $dbh->prepare($sql);
$stmt->execute();
$record = $stmt->fetch(PDO::FETCH_ASSOC);

$e_lat = $record['e_Lat'];
$e_lng = $record['e_Lng'];



 ?>


<!DOCTYPE html>
<html>
  <head>
    <title>Google Maps: 地図の表示</title>
    <!-- スタイルシートの読み込み -->
    <link href="./map.css" rel="stylesheet">
    <!-- Google Mapsライブラリの読み込み -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCzo1nDw_k6yNjo48_6UCYjLOwqF_QxEWE"></script>
  </head>
<body>
<div id="keido" style="display: none;">
<?php echo htmlspecialchars($e_lat);?>
 </div>

 <div id="ido" style="display: none;">
 <?php echo htmlspecialchars($e_lng);?>
 </div>
<!-- 地図が描画されるキャンパス -->
<div id="map-canvas">ここに地図が表示されます</div>

<!-- JavaScriptの読み込み -->
<script src="js/jquery-3.1.1.js"></script>
<script src="js/jquery-migrate-1.4.1.js"></script>
<script src="./map.js"></script>



</body>
</html>