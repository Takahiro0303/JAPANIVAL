<?php
session_start();
require('../../common/dbconnect.php');
require('../../common/functions.php');

$event_id      = $_POST['event_id'];
$user_id       = $_POST['user_id'];
$like_or_not   = $_POST['like_or_not'];

if ($like_or_not == 'unlike') {
  $sql = 'INSERT INTO likes SET event_id=?, user_id=?';
  $data = [$event_id, $user_id];
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data); 
} else{
  $sql = 'DELETE FROM likes WHERE event_id=? AND user_id=?';
  $data = [$event_id, $user_id];
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data); 
}

// select
$sql = 'SELECT COUNT(*) AS cnt FROM likes WHERE event_id=?';
$data = [$event_id];
$stmt = $dbh->prepare($sql);
$stmt->execute($data); 
$like_count = $stmt->fetch(PDO::FETCH_ASSOC);


//データを返す
if ($_POST['like_or_not'] == 'unlike') {
  $data = ['like_or_not' => 'unlike', 'like_count' => $like_count['cnt'], 'event_id' => $event_id];
  echo json_encode($data);
} else{
  $data = ['like_or_not' => 'like', 'like_count' => $like_count['cnt'], 'event_id' => $event_id];
  echo json_encode($data);
}

?>