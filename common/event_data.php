<?php 

// idを使って各イベントの情報を取得

function get_event_data($dbh){
$sql = 'SELECT * FROM events WHERE event_id=0';
$data = array($_SESSION['id']);
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
$event_data = $stmt->fetch(PDO::FETCH_ASSOC);
}
 ?>