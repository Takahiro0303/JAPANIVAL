<?php
session_start();
require('../../common/dbconnect.php');
require('../../common/functions.php');

$event_id      = $_POST['event_id'];
$user_id       = $_POST['user_id'];
$join_or_not   = $_POST['join_or_not'];

if ($join_or_not == 'unjoin') {
  $sql = 'INSERT INTO joins SET event_id=?, user_id=?';
  $data = [$event_id, $user_id];
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data); 
} else{
  $sql = 'DELETE FROM joins WHERE event_id=? AND user_id=?';
  $data = [$event_id, $user_id];
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data); 
}

// select
$sql = 'SELECT COUNT(*) AS cnt FROM joins WHERE event_id=?';
$data = [$event_id];
$stmt = $dbh->prepare($sql);
$stmt->execute($data); 
$join_count = $stmt->fetch(PDO::FETCH_ASSOC);


//データを返す
if ($_POST['join_or_not'] == 'unjoin') {
  $data = ['join_or_not' => 'unjoin', 'join_count' => $join_count['cnt'], 'event_id' => $event_id];
  echo json_encode($data);
} else{
  $data = ['join_or_not' => 'join', 'join_count' => $join_count['cnt'], 'event_id' => $event_id];
  echo json_encode($data);
}

?>