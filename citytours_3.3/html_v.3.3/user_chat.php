<?php 
session_start();
require('../../common/dbconnect.php'); // データベースへ接続
require('../../common/functions.php'); // 関数ファイル読み込み
// require('../../common/auth.php'); // ログイン判定
// require('footer.php'); // フッター表示

// $login_user = get_login_user($dbh);

// ○パラメータがなければ、チャット画面に遷移
if (!isset($_REQUEST['chat_room_id']) || empty($_REQUEST['chat_room_id'])) {
    header('Location: user_chat.php');
    exit();
}

// ○クリックされたチャットデータを一件取得
$chat_room_id = $_REQUEST['chat_room_id'];

// chat_room_idをもとにチャットルームの情報を取得
$sql ='SELECT m.*,u.* 
       FROM caht_rooms u,users u
       WHERE m.=m.chat_room_id
       AND m.chat_room_id=?
       ORDER BY c.created DESC';
$data = [$_REQUEST['chat_room_id']];
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
$chat_rooms = [];
while ($chat_room = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $chat_rooms[] = $chat_room;
}

v($chat_rooms);

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



// // クリックされたチャット情報をchatrooms&messagesから
// $sql ='SELECT m.*, c.chat_room_id ,c.event_id 
//        FROM messages m ,chat_rooms c
//        WHERE m.chat_room_id=c.chat_room_id 
//        AND m.chat_room_id=?';
// $data = ;
// $stmt = $dbh->prepare($sql);
// $stmt->execute($data);
// $chat_rooms = [];
// while ($chat_room = $stmt->fetch(PDO::FETCH_ASSOC)) {
//     $chat_rooms[] = $chat_room;
// }

// // イベントデータ取得
// // $sql = 'SELECT * FROM events WHERE ';
// // $data = [$_REQUEST['chat_room_id']];
// // $stmt = $dbh->prepare($sql);
// // $stmt->execute($data);
// // $event_data = $stmt->fetch(PDO::FETCH_ASSOC);

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
    <div class='container'>
        <div class="row">

            <!-- チャット全件表示s -->
            <div class="col-md-3">    
            </div>

            <!-- チャット個別チャット表示 -->
            <div class="col-md-6">

                <form method="POST" action="chat_user.php?">
                    <textarea name="message" cols="30" rows="5"></textarea>
                    <input type="submit" value="送信">
                </form> 
            </div>

            <!-- イベント詳細・ユーザー詳細表示 -->
            <div class="col-md-3">    
            </div>

        </div><!-- row -->
    </div> <!-- container -->

</body>
</html>