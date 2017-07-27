<?php
session_start();
require('../../common/dbconnect.php');
require('../../common/functions.php');
$login_user = get_login_user($dbh);

  $request_category_id = $_POST['request_category_id'];
  $event_id = $_POST['event_id'];

if (!isset($_POST['db_register'])) {

  $errors = array();

  $errors['request_category_id'] = '';

  if ($request_category_id == '') {
      $errors['request_category_id'] = 'blank';
  }


  if ($errors['request_category_id'] != 'blank') {

    //同じリクエストがすでに存在する場合はreject
    $sql = 'SELECT COUNT(*) AS total FROM requests WHERE user_id =  ?
                                                     AND event_id = ? 
                                                     AND request_category_id = ?';
    $data = [$login_user['user_id'], $event_id, $request_category_id];
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    $requested = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($requested['total'] > 0) {
        $errors['request_category_id'] = 'existed';
    }

  }

    $data = [   
                'request_category_id' => $errors['request_category_id']
            ];
    echo json_encode($data);

}

if (isset($_POST['db_register'])) {
      $sql = 'INSERT INTO requests
                      SET user_id=?,
                          event_id=?,
                          request_category_id=?,
                          created=NOW()';
      $data = [$login_user['user_id'], $event_id, $request_category_id];
      $stmt = $dbh->prepare($sql);
      $stmt->execute($data);

    $data = [   
                'event_id' => $event_id
            ];
    echo json_encode($data);

}


?>