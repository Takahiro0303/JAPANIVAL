<?php 
session_start();
require('../../common/dbconnect.php'); //データベースへ接続
require('../../common/functions.php'); //関数ファイル読み込み

$login_user = get_login_user($dbh);

// リクエストされたチャットルームデータを一見表示
$chat_room_id = $_REQUEST['chat_room_id'];

// もしログインユーザー
if ($login_user) {
    // データベースへ登録 tweetsテーブルに
    $tweet = $_POST['tweet'];
    if ($tweet != '') {
        $sql = 'INSERT INTO `tweets`
                       SET `tweet`=?,
                           `member_id`=?,
                           `reply_tweet_id`=?,
                           `created`=NOW()';
        $data = array($tweet, $login_user['member_id'], $_POST['rep']);
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);

        // member_idなどのテーブル同士を紐付けるidのことを
        // 外部キー(FK)

        // POST送信をGET送信で上書き
        header('Location:');
        exit();
    }
}

// chatroomから全データ取得
$sql = 'SELECT * FROM chat_rooms WHERE chat_room_id=?';
$data = [$_REQUEST['chat_room_id']];
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
while ($chat_rooms = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $chat_rooms[] = $event_pic;
}

// messagesテーブルからチャット情報取得
$sql = 'SELECT * FROM messeges WHERE chat_room_id=?';
$data = [$_REQUEST['chat_room_id']];
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
while ($notification = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $notifications[] = $notification;
}

// イベントデータ取得
$sql = 'SELECT * FROM events WHERE chat_room_id=?';
$data = [$_REQUEST['chat_room_id']];
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
$event_data = $stmt->fetch(PDO::FETCH_ASSOC);

イベント写真データ取得
$sql = 'SELECT * FROM event_pics WHERE ';
$data = [$_REQUEST['chat_room_id']];
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
while ($event_pic = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $event_pics[] = $event_pic;
}

// usersテーブルデータ取得
$sql = 'SELECT * FROM users WHERE chat_room_id=?';
$data = [$_REQUEST['chat_room_id']];
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
$event_data = $stmt->fetch(PDO::FETCH_ASSOC);





?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>チャット</title>

  <!-- デザインCSS -->
  <link rel="stylesheet" type="text/css" href="user_chat.css">
  
  <!-- 【タイトルアイコン表示】 -->
  <link rel="shortcut icon" href="img/japanival_icon.jpg" type="image/x-icon">
</head>

<body>
  <div class="main_section">
    <div class="container">
      <div class="chat_container">
        <div class="col-md-3 chat_sidebar">
          <div class="row">
            <div id="custom-search-input">
              <div class="input-group col-md-12">
                <input type="text" class="  search-query form-control" placeholder="Conversation" />
                <button class="btn btn-danger" type="button">
                  <span class=" glyphicon glyphicon-search"></span>
                </button>
              </div>
            </div>
              <div class="dropdown all_conversation">
                <button class="dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fa fa-weixin" aria-hidden="true"></i>
                  All Conversations
                  <span class="caret pull-right"></span>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                  <li>
                    <a href="#"> All Conversation </a>
                    <ul class="sub_menu_ list-unstyled">
                      <li><a href="#"> All Conversation </a> </li>
                      <li><a href="#">Another action</a></li>
                      <li><a href="#">Something else here</a></li>
                      <li><a href="#">Separated link</a></li>
                    </ul>
                  </li>
                  <li><a href="#">Another action</a></li>
                  <li><a href="#">Something else here</a></li>
                  <li><a href="#">Separated link</a></li>
                </ul>
              </div>
              <div class="member_list">
              <ul class="list-unstyled">
              <li class="left clearfix">
              <span class="chat-img pull-left">
              <img src="https://lh6.googleusercontent.com/-y-MY2satK-E/AAAAAAAAAAI/AAAAAAAAAJU/ER_hFddBheQ/photo.jpg" alt="User Avatar" class="img-circle">
              </span>
              <div class="chat-body clearfix">
              <div class="header_sec">
              <strong class="primary-font">Jack Sparrow</strong> <strong class="pull-right">
              09:45AM</strong>
              </div>
              <div class="contact_sec">
              <strong class="primary-font">(123) 123-456</strong> <span class="badge pull-right">3</span>
              </div>
              </div>
              </li>
              <li class="left clearfix">
              <span class="chat-img pull-left">
              <img src="https://lh6.googleusercontent.com/-y-MY2satK-E/AAAAAAAAAAI/AAAAAAAAAJU/ER_hFddBheQ/photo.jpg" alt="User Avatar" class="img-circle">
              </span>
              <div class="chat-body clearfix">
              <div class="header_sec">
              <strong class="primary-font">Jack Sparrow</strong> <strong class="pull-right ">
              09:45AM</strong>
              </div>
              <div class="contact_sec">
              <strong class="primary-font">(123) 123-456</strong> <span class="badge pull-right">3</span>
              </div>
              </div>
              </li>
              <li class="left clearfix">
              <span class="chat-img pull-left">
              <img src="https://lh6.googleusercontent.com/-y-MY2satK-E/AAAAAAAAAAI/AAAAAAAAAJU/ER_hFddBheQ/photo.jpg" alt="User Avatar" class="img-circle">
              </span>
              <div class="chat-body clearfix">
              <div class="header_sec">
              <strong class="primary-font">Jack Sparrow</strong> <strong class="pull-right">
              09:45AM</strong>
              </div>
              <div class="contact_sec">
              <strong class="primary-font">(123) 123-456</strong> <span class="badge pull-right">3</span>
              </div>
              </div>
              </li>
              <li class="left clearfix">
              <span class="chat-img pull-left">
              <img src="https://lh6.googleusercontent.com/-y-MY2satK-E/AAAAAAAAAAI/AAAAAAAAAJU/ER_hFddBheQ/photo.jpg" alt="User Avatar" class="img-circle">
              </span>
              <div class="chat-body clearfix">
              <div class="header_sec">
              <strong class="primary-font">Jack Sparrow</strong> <strong class="pull-right">
              09:45AM</strong>
              </div>
              <div class="contact_sec">
              <strong class="primary-font">(123) 123-456</strong> <span class="badge pull-right">3</span>
              </div>
              </div>
              </li>
              <li class="left clearfix">
              <span class="chat-img pull-left">
              <img src="https://lh6.googleusercontent.com/-y-MY2satK-E/AAAAAAAAAAI/AAAAAAAAAJU/ER_hFddBheQ/photo.jpg" alt="User Avatar" class="img-circle">
              </span>
              <div class="chat-body clearfix">
              <div class="header_sec">
              <strong class="primary-font">Jack Sparrow</strong> <strong class="pull-right">
              09:45AM</strong>
              </div>
              <div class="contact_sec">
              <strong class="primary-font">(123) 123-456</strong> <span class="badge pull-right">3</span>
              </div>
              </div>
              </li>
              <li class="left clearfix">
              <span class="chat-img pull-left">
              <img src="https://lh6.googleusercontent.com/-y-MY2satK-E/AAAAAAAAAAI/AAAAAAAAAJU/ER_hFddBheQ/photo.jpg" alt="User Avatar" class="img-circle">
              </span>
              <div class="chat-body clearfix">
              <div class="header_sec">
              <strong class="primary-font">Jack Sparrow</strong> <strong class="pull-right">
              09:45AM</strong>
              </div>
              <div class="contact_sec">
              <strong class="primary-font">(123) 123-456</strong> <span class="badge pull-right">3</span>
              </div>
              </div>
              </li>
              <li class="left clearfix">
              <span class="chat-img pull-left">
              <img src="https://lh6.googleusercontent.com/-y-MY2satK-E/AAAAAAAAAAI/AAAAAAAAAJU/ER_hFddBheQ/photo.jpg" alt="User Avatar" class="img-circle">
              </span>
              <div class="chat-body clearfix">
              <div class="header_sec">
              <strong class="primary-font">Jack Sparrow</strong> <strong class="pull-right">
              09:45AM</strong>
              </div>
              <div class="contact_sec">
              <strong class="primary-font">(123) 123-456</strong> <span class="badge pull-right">3</span>
              </div>
              </div>
              </li>
              </ul>
            </div>
          </div> <!-- row -->
        </div> <!-- col-md-3 chat_sidebar -->
      <!--chat_sidebar-->

        <div class="col-md-9 message_section">
          <div class="row">
          <div class="new_message_head">
          <div class="pull-left"><button><i class="fa fa-plus-square-o" aria-hidden="true"></i> New Message</button></div><div class="pull-right"><div class="dropdown">
          <button class="dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-cogs" aria-hidden="true"></i>  Setting
          <span class="caret"></span>
          </button>
          <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu1">
          <li><a href="#">Action</a></li>
          <li><a href="#">Profile</a></li>
          <li><a href="#">Logout</a></li>
          </ul>
          </div></div>
          </div><!--new_message_head-->

          <div class="chat_area">
          <ul class="list-unstyled">
          <li class="left clearfix">
          <span class="chat-img1 pull-left">
          <img src="https://lh6.googleusercontent.com/-y-MY2satK-E/AAAAAAAAAAI/AAAAAAAAAJU/ER_hFddBheQ/photo.jpg" alt="User Avatar" class="img-circle">
          </span>
          <div class="chat-body1 clearfix">
          <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia.</p>
          <div class="chat_time pull-right">09:40PM</div>
          </div>
          </li>
          <li class="left clearfix">
          <span class="chat-img1 pull-left">
          <img src="https://lh6.googleusercontent.com/-y-MY2satK-E/AAAAAAAAAAI/AAAAAAAAAJU/ER_hFddBheQ/photo.jpg" alt="User Avatar" class="img-circle">
          </span>
          <div class="chat-body1 clearfix">
          <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia.</p>
          <div class="chat_time pull-right">09:40PM</div>
          </div>
          </li>
          <li class="left clearfix">
          <span class="chat-img1 pull-left">
          <img src="https://lh6.googleusercontent.com/-y-MY2satK-E/AAAAAAAAAAI/AAAAAAAAAJU/ER_hFddBheQ/photo.jpg" alt="User Avatar" class="img-circle">
          </span>
          <div class="chat-body1 clearfix">
          <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia.</p>
          <div class="chat_time pull-right">09:40PM</div>
          </div>
          </li>
          <li class="left clearfix admin_chat">
          <span class="chat-img1 pull-right">
          <img src="https://lh6.googleusercontent.com/-y-MY2satK-E/AAAAAAAAAAI/AAAAAAAAAJU/ER_hFddBheQ/photo.jpg" alt="User Avatar" class="img-circle">
          </span>
          <div class="chat-body1 clearfix">
          <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia.</p>
          <div class="chat_time pull-left">09:40PM</div>
          </div>
          </li>
          <li class="left clearfix admin_chat">
          <span class="chat-img1 pull-right">
          <img src="https://lh6.googleusercontent.com/-y-MY2satK-E/AAAAAAAAAAI/AAAAAAAAAJU/ER_hFddBheQ/photo.jpg" alt="User Avatar" class="img-circle">
          </span>
          <div class="chat-body1 clearfix">
          <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia.</p>
          <div class="chat_time pull-left">09:40PM</div>
          </div>
          </li>




          </ul>
          </div><!--chat_area-->
          <div class="message_write">
          <textarea class="form-control" placeholder="type a message"></textarea>
          <div class="clearfix"></div>
          <div class="chat_bottom"><a href="#" class="pull-left upload_btn"><i class="fa fa-cloud-upload" aria-hidden="true"></i>
          Add Files</a>
          <a href="#" class="pull-right btn btn-success">
          Send</a></div>
          </div>
          </div>
        </div> <!--message_section-->
      </div><!--chat_container-->
    </div><!--container-->
  </div><!--main_section-->
    
    <script src="https://use.fontawesome.com/45e03a14ce.js"></script>
</body>
</html>