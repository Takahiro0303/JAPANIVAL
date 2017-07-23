<?php
session_start();
require('../../common/dbconnect.php');
require('../../common/functions.php');

$event_id = $_POST['event_id'];
$lat_id   = $_POST['lat'];
$lnd_id   = $_POST['lng'];

  $sql = 'INSERT INTO events SET event_id=?, e_Lat=?, e_Lng=?';
  $data = [$event_id, $lat_id, $lng_id];
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data); 

//データを返す
if ($_POST['like_or_not'] == 'unlike') {
  $data = ['like_or_not' => 'unlike', 'like_count' => $like_count['cnt'], 'event_id' => $event_id];
  echo json_encode($data);
} else{
  $data = ['like_or_not' => 'like', 'like_count' => $like_count['cnt'], 'event_id' => $event_id];
  echo json_encode($data);
}

?>