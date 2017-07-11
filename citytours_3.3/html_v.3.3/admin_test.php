<?php 
session_start();
// $_SESSSION['id'] = '1';
require('../../dbconnect.php');
require('../../common/functions.php');

// $sql = 'SELECT * FROM joins WHERE user_id= %d ORDER BY created BESC,'

$login_user = get_login_user($dbh);



// v($login_user);


$sql = 'SELECT * FROM joins WHERE user_id=?';
$data = [$login_user['user_id']];
$stmt = $dbh->prepare($sql);
$stmt->execute($data);

while ($record = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $records[] = $record;
}

// v($records);


for ($i=0; $i < count($records) ; $i++) {
    $sql = 'SELECT * FROM events WHERE event_id=?';
    $event_data =  [$records[$i]['event_id']];
    $event_stmt = $dbh->prepare($sql);
    $event_stmt->execute($event_data);
    while ($event = $event_stmt->fetch(PDO::FETCH_ASSOC)) {
        $events[] = $event;
    }

   // echo $record[$i]['event_id'] . "iあり";
    // echo "<br>";
    // echo $record['event_id'] . "iなし";

   $sql = 'SELECT * FROM event_pics WHERE event_id=?';
    $event_data =  [$records[$i]['event_id']];
    $pic_stmt = $dbh->prepare($sql);
    $pic_stmt->execute($event_data);
    while ($pic = $pic_stmt->fetch(PDO::FETCH_ASSOC)) {
        $pics[] = $pic;
    }

}

// v($events);
v($pics);

?>




<!DOCTYPE html>
 <html>
 <head>
     <title></title>
 </head>
 <body>

<?php for ($i=0; $i < count($events) ; $i++) { ?>
  <div><?php echo htmlspecialchars($events[$i]['e_name']); ?></div>
  <img src="../../event_pictures/<?php echo htmlspecialchars($pics[$i]['e_pic_path']); ?>"width=“550px" height=“400px”>
  <div><?php echo htmlspecialchars($events[$i]['e_start_date']); ?></div>
  <div><?php echo htmlspecialchars($events[$i]['e_end_date']); ?></div>
  <div><?php echo htmlspecialchars($events[$i]['e_prefecture']); ?></div>
  <div><?php echo htmlspecialchars($events[$i]['e_address']) ?></div>
  <div><?php echo htmlspecialchars($events[$i]['e_venue']) ?></div>
<?php } ?>

</body>
</html>