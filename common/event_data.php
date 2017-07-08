<?php 

// idを使って各イベントの情報を取得

function get_event_data($dbh){
$sql = 'SELECT * FROM events WHERE event_id=0';
$data = array($'event_id');
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
$event_data = $stmt->fetch(PDO::FETCH_ASSOC);

unction get_event_data($dbh){
$sql = 'SELECT * FROM events WHERE e_postal=1700002';
$stmt = $dbh->prepare($sql);
$stmt->execute();
$event_data = $stmt->fetch(PDO::FETCH_ASSOC);
return $event_data;
}

}
 ?>