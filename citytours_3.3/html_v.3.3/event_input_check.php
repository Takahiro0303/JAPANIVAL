<?php  
  
session_start();
require('../../common/dbconnect.php');

  //sha1()関数 暗号化（ハッシュ化）
  //逆置換できません。
  // $password = sha1('hogehoge');
  // echo $password;




  // sessionを持たない状態で直接、このページに来た時には、event_input_index.phpに自動遷移
  if(!isset($_SESSION['event'])){
    header('Location: event_input_index.php');
  exit();

  //emptyは箱があって、値が入っているかどうか？
  //issetはそもそも箱があるかどうか。
  }

  //会員登録ボタンが押された際の処理
  if(!empty($_POST)){

    // eventsテーブルへの登録
    $sql = 'INSERT INTO events
                    SET e_name = ?,
                        e_start_date = ?,
                        e_end_date = ?,
                        e_prefecture = ?,
                        e_postal = ?,
                        e_address = ?,
                        e_venue = ?,
                        e_o_name = ?,
                        e_o_tel = ?,
                        e_o_email = ?,
                        explanation = ?,
                        priority = ?,
                        start_year = ?,
                        year_p = ?,
                        year_pp = ?,
                        year_ppp = ?,
                        attendance_p = ?,
                        attendance_pp = ?,
                        attendance_ppp = ?,
                        official_url = ?,
                        related_url = ?,
                        created = NOW()';

  $data = [ $_SESSION['event']['e_name'],
            $_SESSION['event']['e_start_date'],
            $_SESSION['event']['e_end_date'],
            $_SESSION['event']['e_prefecture'],
            $_SESSION['event']['e_postal'],
            $_SESSION['event']['e_address'],
            $_SESSION['event']['e_venue'],
            $_SESSION['event']['e_o_name'],
            $_SESSION['event']['e_o_tel'],
            $_SESSION['event']['e_o_email'],
            $_SESSION['event']['explanation'],
            $_SESSION['event']['priority'],
            $_SESSION['event']['start_year'],
            $_SESSION['event']['year_p'],
            $_SESSION['event']['year_pp'],
            $_SESSION['event']['year_ppp'],
            $_SESSION['event']['attendance_p'],
            $_SESSION['event']['attendance_pp'],
            $_SESSION['event']['attendance_ppp'],
            $_SESSION['event']['official_url'],
            $_SESSION['event']['related_url']];
    $events_stmt = $dbh->prepare($sql);
    $events_stmt->execute($data);

    $sql = 'SELECT event_id FROM events ORDER BY event_id desc limit 1';
    //TODO!:条件に主催者IDを加えないと、他人も含めた最新の一件を取得しちゃうかも。
    $events_stmt = $dbh->prepare($sql);
    $events_stmt->execute();
    $event_id = $events_stmt->fetch(PDO::FETCH_ASSOC);


    // event_picsテーブルへの登録
    $sql = 'INSERT INTO event_pics
                    SET event_id= ?,
                        e_pic_path = ?,
                        created = NOW()';

  $data = [ $event_id,
            $_SESSION['event']['e_pic_path']];
    $event_pics_stmt = $dbh->prepare($sql);
    $event_pics_stmt->execute($data);



    unset($_SESSION['event']);
    //TODO!:なんでunsetなんだっけ？

    header('Location: event_input_thanks.php');
    exit();

  }

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title></title>
  <link rel="stylesheet" href="css/main.css">
</head>
<body>
  <h1>登録内容確認</h1>

  <h3>イベント概要</h3>
  イベント名（必須）:<br>
  <?php echo htmlspecialchars($_SESSION['event']['e_name']) . '<br>'; ?>
  イベント日程（開始日）（必須）※MM-DD-YYYYで入力してください。:<br>
  <?php echo htmlspecialchars($_SESSION['event']['e_start_date']) . '<br>'; ?>
  イベント日程（終了日）（必須）※MM-DD-YYYYで入力してください。:<br>
  <?php echo htmlspecialchars($_SESSION['event']['e_end_date']) . '<br>'; ?>
  
  <h3>開催場所</h3><br>
  都道府県（必須）: <br>
  <?php echo htmlspecialchars($_SESSION['event']['e_prefecture']) . '<br>'; ?>
  郵便番号（必須）:<br>
  <?php echo htmlspecialchars($_SESSION['event']['e_postal']) . '<br>'; ?>
  住所（必須）:<br>
  <?php echo htmlspecialchars($_SESSION['event']['e_address']) . '<br>'; ?>
  会場（必須）: <br>
  <?php echo htmlspecialchars($_SESSION['event']['e_venue']) . '<br>'; ?>
  
  <h3>主催者情報</h3><br>
  主催者名（必須）:<br>
  <?php echo htmlspecialchars($_SESSION['event']['e_o_name']) . '<br>'; ?>
  電話番号（必須）:<br>
  <?php echo htmlspecialchars($_SESSION['event']['e_o_tel']) . '<br>'; ?>
  e-mail（必須）: <br>
  <?php echo htmlspecialchars($_SESSION['event']['e_o_email']) . '<br>'; ?>

  <h3>イベント説明/関連情報</h3>
  説明文（必須）:<br>
  <?php echo htmlspecialchars($_SESSION['event']['explanation']) . '<br>'; ?>
  開始年（必須）:<br>
  <?php echo htmlspecialchars($_SESSION['event']['start_year']) . '<br>'; ?>
  前回開催年:<br>
  <?php echo htmlspecialchars($_SESSION['event']['year_p']) . '<br>'; ?>
  前々回開催年:<br>
  <?php echo htmlspecialchars($_SESSION['event']['year_pp']) . '<br>'; ?>
  前前前回開催年: <br>
  <?php echo htmlspecialchars($_SESSION['event']['year_ppp']) . '<br>'; ?>
  前回参加者数:<br>
  <?php echo htmlspecialchars($_SESSION['event']['attendance_p']) . '<br>'; ?>
  前々回参加者数:<br>
  <?php echo htmlspecialchars($_SESSION['event']['attendance_pp']) . '<br>'; ?>
  前前前回参加者数:<br>
  <?php echo htmlspecialchars($_SESSION['event']['attendance_ppp']) . '<br>'; ?>
  公式URL:<br>
  <?php echo htmlspecialchars($_SESSION['event']['official_url']) . '<br>'; ?>
  関連URL: <br>
  <?php echo htmlspecialchars($_SESSION['event']['related_url']) . '<br>'; ?>
  イベント画像:<br>
  <img src="../../event_pictures/<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>" width="200" >

  <form method="POST" action="event_input_check.php">
    <a href="event_input_index.php?action=rewrite">&laquo;&nbsp;書き直す</a>
    <input type="hidden" name="action" value="aaaaaa">
    <input type="submit" value="会員登録">
  </form>
  <?php  
    // require('test.php');//指定するファイルを呼び出す
  ?>
</body>
</html>