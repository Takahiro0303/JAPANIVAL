<?php 

session_start();
require('../../../common/dbconnect.php');
require('../../../common/functions.php');


// $sql = 'INSERT INTO  events SET e_Lat = ?,e_Lng = ?'
// // $data = [$event_id];
// $stmt = $dbh->prepare($sql);
// $stmt->execute();
// $record = $stmt->fetch(PDO::FETCH_ASSOC);





 ?>


 <!DOCTYPE html>
 <html>
 <head>
 	<title></title>
 	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCzo1nDw_k6yNjo48_6UCYjLOwqF_QxEWE"></script>
 </head>
 <body>
 


 <!-- JavaScriptの読み込み -->
 <script src="js/jquery-3.1.1.js"></script>
 <script src="js/jquery-migrate-1.4.1.js"></script>
 <script src="./geocode.js"></script>

 </body>
 </html>