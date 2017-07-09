<?php  
session_start();
require('../dbconnect.php');
// require('header.php');
// require('.php');


// if (!isset($_GET['event_id'])) {
	// h('main_portal.php');
// }else {

$event_id = 1;
$sql = 'SELECT * FROM events WHERE event_id = ?';
$data = [$event_id];
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
$event = $stmt->fetch(PDO::FETCH_ASSOC);
// }


$reviews=array();
$sql = 'SELECT r.*,m.pic_path,m.f_name FROM `reviews` r,`members` m WHERE r.user_id=m.user_id AND event_id = ?';
$data = [$event_id];
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
$reviews[] = $stmt->fetch(PDO::FETCH_ASSOC);


?>


<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>



</body>
</html>