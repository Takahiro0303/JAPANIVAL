<?php
session_start();
require('../../common/dbconnect.php');
require('../../common/functions.php');
$login_user = get_login_user($dbh);

  $news_title     = $_POST['news_input_title'];
  $news_comment   = $_POST['news_input_comment'];
  $event_id = $_POST['event_id'];

if (!isset($_POST['db_register'])) {

  $errors = array();

  $errors['news_input_title'] = '';
  $errors['news_input_comment'] = '';

  if ($news_title == '') {
      $errors['news_input_title'] = 'blank';
  }

  if ($news_comment == '') {
      $errors['news_input_comment'] = 'blank';
  }

    $data = [   
                'news_title'        => $errors['news_input_title'],
                'news_comment'      => $errors['news_input_comment']
            ];
    echo json_encode($data);

}

if (isset($_POST['db_register'])) {
      $sql = 'INSERT INTO news
                      SET event_id=?,
                          news_title=?,
                          news_comment=?,
                          created=NOW()';
      $data = [$event_id, $news_title, $news_comment];
      $stmt = $dbh->prepare($sql);
      $stmt->execute($data);

    $data = [   
                'event_id' => $event_id
            ];
    echo json_encode($data);

}


?>