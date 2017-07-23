<?php 
session_start();
require('../../common/dbconnect.php'); // データベースへ接続
require('../../common/functions.php'); // 関数ファイル読み込み
// require('../../common/auth.php'); // ログイン判定

$login_user = get_login_user($dbh);

// chat_room_idが指定されてなければ、user_chat画面に遷移
// if (empty($_REQUEST['chat_room_id'])) {
//     header('Location: user_chat.php');
//     exit();
// }

// ○クリックされたユーザーのIDを一件取得
if(isset($_REQUEST['chat_room_id'])){
$chat_room_id = $_REQUEST['chat_room_id'];
}

// ○バリデーションのためにrequest_idとaccept_user_idを取得
$sql ='SELECT *
           FROM caht_rooms
           WHERE chat_room_id=?';
$data = [$chat_room_id];
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
$chat_check=$stmt->fetch(PDO::FETCH_ASSOC);
  
$request_id = $chat_check['request_id'];
$accept_user_id = $chat_check['accept_user_id'];

// チャット情報全件取得
$sql ='SELECT c.*,u.*
      FROM caht_rooms c,users u
      WHERE c.accept_user_id=u.user_id OR c.request_user_id=u.user_id
      AND u.user_id=?';
$data = [$_SESSION['id']];
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
$chat_rooms = [];
while ($chat_room = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $chat_rooms[] = $chat_room;
}
// v($chat_rooms);

// ○もし、ログインユーザーのidがchat_roomsテーブルのaccept_idかaccept_user_idと合えばメッセージ読み込み。そうでなければ、user_chat.php(チャットトップ)へ繊維
if($_SESSION['id'] == $request_id || $_SESSION['id'] == $accept_user_id){
    // ○チャットルームのデータを呼び出し
    $sql ='SELECT m.*,u.*
           FROM messages m,users u
           WHERE m.user_id=u.user_id
           AND m.chat_room_id=?';
    $data = [$chat_room_id];
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    $messages = [];
    while ($message = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $messages[] = $message;
    }

    if (isset($chat_room_id)) {
      // ○イベントデータ取得
      $sql = 'SELECT * FROM caht_rooms WHERE chat_room_id=?';
      $data = [$chat_room_id];
      $stmt = $dbh->prepare($sql);
      $stmt->execute($data);
      $chat_room_data = $stmt->fetch(PDO::FETCH_ASSOC);

      $sql = 'SELECT * FROM events WHERE event_id=?';
      $data = [$chat_room_data['event_id']];
      $stmt = $dbh->prepare($sql);
      $stmt->execute($data);
      $event_data = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}else{
  // ログインユーザーidがrequest_user_idまたは、accept_user_idにも当てはまらない場合はuser_chat.php(チャットトップ)に遷移
  // header('Location: user_chat.php');
  //   exit();
}

// ○メッセージをデータベースへ登録処理
if (!empty($_POST['message'])) {
    $message = $_POST['message'];
    if ($message != '') {
        // DBへの登録処理
        $sql = 'INSERT INTO messages SET chat_room_id=?,
                                        message = ?,     
                                        user_id = ?,
                                        created = NOW()';
        $data = array($_REQUEST['chat_room_id'],$_POST['message'],$login_user['user_id']);
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);

        header('Location: user_chat.php?chat_room_id='. $_REQUEST['chat_room_id']);
        exit();
    }
  }




// $sql = 'SELECT t.*, m.nick_name, m.picture_path FROM tweets t, members m WHERE t.member_id=m.member_id ORDER BY t.created';
// // $data = [$start];
// $data = array();
// $stmt = $dbh->prepare($sql);
// $stmt->execute($data);
// v($messages);

// while ($message = $stmt->fetch(PDO::FETCH_ASSOC)) {
//     $messages[] = $message;
// }




// // イベント写真データ取得
// // $sql = 'SELECT * FROM event_pics WHERE  ';
// // $data = [$_REQUEST['chat_room_id']];
// // $stmt = $dbh->prepare($sql);
// // $stmt->execute($data);
// // while ($event_pic = $stmt->fetch(PDO::FETCH_ASSOC)) {
// //     $event_pics[] = $event_pic;
// // }

// // usersテーブルデータ取得
// // $sql = 'SELECT * FROM users WHERE chat_room_id=?';
// // $data = [$_REQUEST['chat_room_id']];
// // $stmt = $dbh->prepare($sql);
// // $stmt->execute($data);
// // $event_data = $stmt->fetch(PDO::FETCH_ASSOC);

// // if (!empty($_POST['messege'])) {
// //     // データベースへ登録 tweetsテーブルに
// // // データベースへ登録 tweetsテーブルに
// //     $messege = $_POST['messege'];
// //     if ($messege != '') {
// //         $sql = 'INSERT INTO messages
// //                         SET message=?,
// //                             message_id=?,
// //                             chat_room_id=?,
// //                             user_id=?,
// //                             created=NOW()';
// //         $data = array($tweet, $login_user['member_id'], $_POST['rep']);
// //         $stmt = $dbh->prepare($sql);
// //         $stmt->execute($data);

// //         // POST送信をGET送信で上書き
// //         header('Location: user_chat.php');
// //         exit();
// //     }
// }


?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/animate.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>

  <header>
    <!-- チャット全件表示 -->
    <aside class="col-md-3">
      <h3 class="page-header" align="center">チャット一覧</h3>
    </aside>
    <!-- 個人間チャット表示 -->
    <div class="col-md-6">
      <h3 class="page-header" align="center">チャット相手の名前を表示</h3>
    </div>
    <!-- チャット全件表示 -->
    <aside class="col-md-3" align="center">
      <h3 class="page-header">イベント詳細</h3>
    </aside>
  </header>

  <main style="padding-top: 100px; ">
    <!-- チャット全件表示 -->
    <aside class="col-md-3">
      <?php foreach($chat_rooms as $chat_room){ ?>
        <a type="button" href="user_chat.php?chat_room_id=<?php echo $chat_rooms['chat_room_id']; ?>">
          <div class="row">
            <div class="col-md-3">
                 <img src="../../users_pic/<?php echo $chat_room['pic_path']; ?>" alt="User Picture" class="img-circle" style="width: 40px; height: 50px;""> 
            </div>
            <div class="col-md-9">
                  <div><?php echo $chat_room['nickname']; ?></div>
                  <strong class="pull-right">09:45AM</strong>
                  (123) 123-456
            </div>
          </div>
        </a>
        <hr>
      <?php } ?>
    </aside>
    
    <!-- 個人間チャット表示 -->
    <div class="col-md-6">
        <div class="row">
          <div id="messages" style="overflow-y: auto; width: 100%; height: 500px;">

          <?php foreach($messages as $message){ ?>
            <section class="comment-list">
              <!-- チャット相手からのメッセージ -->
              <?php if ($message['user_id'] != $_SESSION['id']) { ?>
                <article class="row">
                  <div class="col-md-2 col-sm-2 hidden-xs">
                    <figure class="thumbnail">
                      <img class="img-responsive" src="../../users_pic/<?php echo $message['pic_path']; ?>" />
                    </figure>
                  </div>
                  <div class="col-md-10 col-sm-10">
                    <div class="panel panel-default arrow left">
                      <div class="panel-body">
                        <div class="comment-post">
                          <p>
                            <?php echo $message['message']; ?>
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                </article>
              <?php }elseif($message['user_id'] == $_SESSION['id']){ ?>
              <!-- 自分が送ったメッセージ -->
              <article class="row">
                <div class="col-md-10 col-sm-10">
                  <div class="panel panel-default arrow right">
                    <div class="panel-body">
                      <div class="comment-post">
                        <p>
                          <?php echo $message['message']; ?>
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-2 col-sm-2 hidden-xs">
                  <figure class="thumbnail">
                    <img class="img-responsive" src="../../users_pic/<?php echo $login_user['pic_path']; ?>" />
                  </figure>
                </div>
              </article>
              <?php }; ?>
            </section>
          <?php } ?>
          </div>
            <form method="POST" action="">
              <div class="panel-footer">
                <input id="btn-input" type="text" name='message' class="form-control input-sm chat_input" placeholder="type a message">
                <input type="hidden" name="user_id" value="<?php echo $_SESSION['login_user_id']; ?>">
                <p  align="right">
                    <input type="submit" value="Send" class="btn btn-danger" id="btn-chat">
                </p>
              </div>
            </form>
        </div>
    </div>

    <!--　イベント詳細&ユーザー詳細　表示 -->
    <!-- イベントデータ　＝　$event_data　に取得済み -->
    <aside class="col-md-3">
      <div class=" table-responsive">
          <table　class="table table-striped">
            <thead>
              <tr>
                <th　colspan="2"><?php echo $event_data['e_name']?></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Date&Time:</td><td>あ</td>
                <td>City:</td><td>あ</td>
                <td>place:</td><td>あ</td>
                <td>Web Page:</td><td>あ</td>

              </tr>
              

            </tbody>
          </table>
          <table>
            <thead>
              <tr>
                <th>例年参加者</th><th><?php echo $event_data['e_name']?></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Date&Time:</td><td></td>
                <td>City:</td><td></td>
                <td>place:</td><td></td>
                <td>Web Page:</td><td></td>
              </tr>
            </tbody>
          </table>
        </div>
    </aside>

  </main><!-- main_section -->

</body>
</html>