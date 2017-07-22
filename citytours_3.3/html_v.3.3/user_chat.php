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
$chat_room_id = $_REQUEST['chat_room_id'];

// ○バリデーションのためにrequest_idとaccept_user_idを取得
$sql ='SELECT request_id,accept_user_id
           FROM caht_rooms
           WHERE chat_room_id=?';
$data = [$chat_room_id];
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
$chat_check=$stmt->fetch(PDO::FETCH_ASSOC);
  
$request_id = $chat_check['request_id'];
$accept_user_id = $chat_check['accept_user_id'];

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
      <h2 class="page-header">チャット一覧</h2>
    </aside>
    <!-- 個人間チャット表示 -->
    <div class="col-md-6">
      <h2 class="page-header">チャット</h2>
    </div>
    <!-- チャット全件表示 -->
    <aside class="col-md-3">
      <h2 class="page-header">イベント詳細</h2>
    </aside>
  </header>

  <div class="main_section" style="padding-top: 100px; ">
      <div class='container'>
          <div class="row">
              <!-- チャット全件表示 -->
              <aside class="col-md-3">
                  <div class="row">
                  
                  </div>
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
              <aside class="col-md-3">
                  <div class="row">

                      
                  </div>
              </aside>
          </div><!-- row -->
      </div> <!-- container -->
  </div><!-- main_section -->

</body>
</html>