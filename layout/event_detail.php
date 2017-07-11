<?php  
session_start();
require('../dbconnect.php');
require('functions.php');

$login_user = get_login_user($dbh);

$sql = 'SELECT * FROM events WHERE event_id=?';
$data = [$_SESSION['event_id']];
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
while ($record = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $records[] = $record;
}



 for ($i=0; $i < count($records) ; $i++) {
 	$sql = 'SELECT * FROM reviews WHERE event_id=?';
 	// echo $sql;
	$data = [$record['review_id']];
	// v($data);
	$review_stmt = $dbh->prepare($sql);
	$review_stmt->execute($data);
	while ($review = $review_stmt->fetch(PDO::FETCH_ASSOC)) {
	    $reviews[] = $review;
	}


}


?>


<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>



</body>
</html>