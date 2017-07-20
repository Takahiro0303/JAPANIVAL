<?php 
session_start();
require('../../common/dbconnect.php'); // データベースへ接続
require('../../common/functions.php'); // 関数ファイル読み込み
require('../../common/auth.php'); // ログイン判定

$login_user = get_login_user($dbh);

if (empty($_REQUEST['user_id'])) {
    header('Location: top.php');
    exit();
}

// ○クリックされたユーザーのIDを一件取得
$chat_room_id = $_REQUEST['user_id'];



if($login_user_id == $request_id || $login_user_id == $accept_id){

    // チャットルームのデータを呼び出し
    $sql ='SELECT chat_rooms
           FROM *
           WHERE chat_room_id=?';
    $data = [$chat_room_id];
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

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
        $cnt = count($messages);
    }

    if(!empty($_POST['message'])){
    $massage = $_POST['massage'];
        if ($massage != '') {
            // DBへの登録処理
            $sql = 'INSERT INTO messages SET message = ?,
                                            chat_room_id=?,
                                            user_id = ?,
                                            created = NOW()';

            $data = array($_POST['message'],$chat_room_id, $_SESSION['login_user_id']);
            $stmt = $dbh->prepare($sql);
            $stmt->execute($data);

            header('Location: user_chat.php=?'. $_REQUEST['chat_room_id']);
            exit();
        }
    // イベントデータ取得
    $sql = 'SELECT * FROM events WHERE event_id=? ';
    $data = $;
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    $event_data = $stmt->fetch(PDO::FETCH_ASSOC);

    // クリックされたチャット情報をchatrooms&messagesから
    $sql ='SELECT m.*, c.chat_room_id ,c.event_id 
           FROM messages m ,chat_rooms c
           WHERE m.chat_room_id=c.chat_room_id 
           AND m.chat_room_id=?';
    $data = ;
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    $chat_rooms = [];
    while ($chat_room = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $chat_rooms[] = $chat_room;
}
}

// chat_room_idをもとにチャットルームの情報を取得
// $sql ='SELECT c.*,m.*
//        FROM chat_rooms c,messages m
//        WHERE c.chat_room_id=m.chat_room_id
//        AND c.chat_room_id=?';
// $data = [$_REQUEST['chat_room_id']];
// $stmt = $dbh->prepare($sql);
// $stmt->execute($data);
// $chat_rooms = [];
// while ($chat_room = $stmt->fetch(PDO::FETCH_ASSOC)) {
//     $chat_rooms[] = $chat_room;
// }

// if($_SESSION['id'] == );

// if (!empty($_POST['message'])) {
//     // データベースへ登録 tweetsテーブルに
//     $message = $_POST['message'];
//     if ($message != '') {
//         $sql = 'INSERT INTO messages
//                        SET message=?,
//                            user_id=?,
//                            chat_room_id=?,
//                            created=NOW()';
//         $data = array($message, $login_user['user_id'],$chat_room_id);
//         $stmt = $dbh->prepare($sql);
//         $stmt->execute($data);

//         // 'UPDATE chat_rooms SET chat_room_id=?, updated=NOW()';

//         // POST送信をGET送信で上書き
//         header('Location: user_chat.php');
//         exit();
//     }
// }


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
</head>
<body>
<div class="main_section">
    <div class='container'>
        <div class="row">
            <!-- チャット全件表示 -->
            <aside class="col-md-3">
                <div class="row">
                    <h2>チャット一覧</h2>
                </div>
            </aside>

            <!-- 個人間チャット表示 -->
            <div class="col-md-6">
                <div class="row">
                  <h2 class="page-header">チャット</h2>
                  <div id="messages" style="overflow-y: auto; width: 100%; height: 500px;">
                  <?php for ($i=0; $i < $cnt ; $i++): ?>
                    <section class="comment-list">
                      <!-- チャット相手からのメッセージ -->
                      <?php if ($messages[$i]['user_id'] != $_SESSION['user_id']) { ; ?>
                        <article class="row">
                          <div class="col-md-2 col-sm-2 hidden-xs">
                            <figure class="thumbnail">
                              <img class="img-responsive" src="../../users_pic/<?php echo $messages[$i]['picture_path']; ?>" />
                            </figure>
                          </div>
                          <div class="col-md-10 col-sm-10">
                            <div class="panel panel-default arrow left">
                              <div class="panel-body">
                                <header class="text-left" style="background-color: white;font-stretch: ">
                                  <div class="comment-user"><i class="fa fa-user"></i>
                                    <?php echo $messages[$i]['nickname'];?>
                                  </div>
                                  <time class="comment-date" datetime="<?php echo $messages[$i]['created']; ?>"><i class="fa fa-clock-o"></i>
                                    <?php echo $messages[$i]['created']; ?>
                                  </time>
                                </header>
                                <div class="comment-post">
                                  <p>
                                    <?php echo $messages[$i]['message']; ?>
                                  </p>
                                </div>
                              </div>
                            </div>
                          </div>
                        </article>
                      <?php }elseif($messages[$i]['user_id'] == $_SESSION['login_user_id']){; ?>
                      <!-- 自分が送ったメッセージ -->
                      <article class="row">
                        <div class="col-md-10 col-sm-10">
                          <div class="panel panel-default arrow right">
                            <div class="panel-body">
                              <header class="text-right" style="background-color: white;">
                                <time class="comment-date" datetime="<?php echo $messages[$i]['created']; ?>"><i class="fa fa-clock-o"></i>
                                  <?php echo $messages[$i]['created']; ?>
                                </time>
                              </header>
                              <div class="comment-post">
                                <p>
                                  <?php echo $messages[$i]['message']; ?>
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
                  <?php endfor; ?>
                  </div>
                    <form method="POST" action="">
                      <div class="panel-footer">
                        <div class="input-group">
                          <input id="btn-input" type="text" name='message' class="form-control input-sm chat_input" placeholder="type a message">
                          <input type="hidden" name="user_id" value="<?php echo $_SESSION['login_user_id']; ?>" class="btn btn-primary btn-sm" id="btn-chat">
                          <input type="submit" value="Send" class="btn btn-danger" id="btn-chat">
                        </div>
                      </div>
                    </form>
                </div>
            </div>

            <!-- チャット全件表示 -->
            <aside class="col-md-3">
                <div class="row">
                    <h2>イベント詳細</h2>
                    <h2>ユーザー詳細</h2>
                </div>
            </aside>
        </div><!-- row -->
    </div> <!-- container -->
</div><!-- main_section -->

</body>
</html>