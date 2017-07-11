<?php 
// idを使って各イベントの情報を取得
$sql = 'SELECT * FROM events  WHERE event_id=?';
$data = array($_SESSION['id']);
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
$login_user = $stmt->fetch(PDO::FETCH_ASSOC);
 ?>