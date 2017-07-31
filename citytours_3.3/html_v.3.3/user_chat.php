<?php 
session_start();
require('../../common/dbconnect.php'); // データベースへ接続
require('../../common/functions.php'); // 関数ファイル読み込み
// require('../../common/auth.php'); // ログイン判定

$login_user = get_login_user($dbh);

// $_REQUESTを持っていない場合、即ち、不正に同URLに入って来ようとした場合にはedit_indexに飛ばす。
if(isset($_REQUEST['chat_room_id'])){

// $_REQUEST['chat_room_id']== 'no' には以下の3パターンあり。
// ①新たにチャットルームを作った場合
// ②チャットルームを新規作成後、メッセージと投稿した場合。
// ③チャットルームを新規作成後、メッセージを投稿せずにページをreloadした場合。
    if ($_REQUEST['chat_room_id'] == 'no' && !isset($chat_room_id)) {

// ① or ②、③を判別するべく、すでにchat_room_idが存在しているかどうかのチェックを行うための存在有無確認sql
        $sql = 'SELECT COUNT(*) AS total FROM chat_rooms WHERE request_id = ?
        AND accept_user_id = ?';
        $data = [$_REQUEST['request_id'], $login_user['user_id']];
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);
        $chat_room_count = $stmt->fetch(PDO::FETCH_ASSOC);

// chat_roomが存在しない場合（つまり①の場合）はchat_roomを作成し、かつ、該当のchat_room_idを$chat_room_idに格納
        if ($chat_room_count['total'] == 0) {
            $sql = 'INSERT INTO chat_rooms SET request_id = ?,     
            accept_user_id = ?,
            created = NOW()';
            $data = [$_REQUEST['request_id'], $login_user['user_id']];
            $stmt = $dbh->prepare($sql);
            $stmt->execute($data);

// たった今登録したchat_room_idを$chat_room_idに渡す。
            $sql = 'SELECT * FROM chat_rooms ORDER BY created desc limit 1';
            $events_stmt = $dbh->prepare($sql);
            $events_stmt->execute();
            $chat_room_new = $events_stmt->fetch(PDO::FETCH_ASSOC);

            $chat_room_id = $chat_room_new['chat_room_id'];

// chat_roomが存在する場合（②、③の場合）は、すでに存在するchat_room_idを$chat_room_idに渡す
        } else{
            $sql = 'SELECT * FROM chat_rooms WHERE request_id = ? AND accept_user_id = ?';
            $data = [$_REQUEST['request_id'], $login_user['user_id']];
            $stmt = $dbh->prepare($sql);
            $stmt->execute($data);
            $room=$stmt->fetch(PDO::FETCH_ASSOC);

            $chat_room_id = $room['chat_room_id'];
        }

//$_REQUEST['chat_room_id']はあるんだが、$_REQUEST['chat_room_id'] == 'no'ではない即ち、chat_room_idを元から持っている場合。
    }else{
        $chat_room_id = $_REQUEST['chat_room_id'];
    }
} else {
    header('Location: edit_index.php');
    exit();
}


//チャットルーム情報を取得
$sql ='SELECT * FROM chat_rooms WHERE chat_room_id=?';
$data = [$chat_room_id];
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
$chat_check=$stmt->fetch(PDO::FETCH_ASSOC);

$request_id     = $chat_check['request_id'];
$accept_user_id = $chat_check['accept_user_id'];

// ログインユーザーに関連する全てのチャットルームデータ及びイベントデータを取得
$sql ='SELECT * FROM chat_rooms, requests, events, request_categories WHERE chat_rooms.request_id = requests.request_id
AND requests.event_id = events.event_id
AND requests.request_category_id = request_categories.request_category_id
AND (chat_rooms.accept_user_id = ? OR  requests.user_id = ?)';
$data = [$login_user['user_id'], $login_user['user_id']];
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
$event_chat_rooms = [];
while ($event_chat_room = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $event_chat_rooms[] = $event_chat_room;
}
// echo '<pre>';
// var_dump($event_chat_rooms);
// echo '</pre>';



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

// ○メッセージをデータベースへ登録処理
if (!empty($_POST['message'])) {
    $message = $_POST['message'];
    if ($message != '') {
// DBへの登録処理
        $sql = 'INSERT INTO messages SET chat_room_id=?,
        message = ?,     
        user_id = ?,
        created = NOW()';
        $data = array($chat_room_id, $_POST['message'], $login_user['user_id']);
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);

        header('Location: user_chat.php?chat_room_id='. $chat_room_id);
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="Citytours - Premium site template for city tours agencies, transfers and tickets.">
    <meta name="author" content="Ansonika">
    <title>CITY TOURS - City tours and travel site template by Ansonika</title>

    <!-- Favicons-->
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" type="image/x-icon" href="img/apple-touch-icon-57x57-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="img/apple-touch-icon-72x72-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="img/apple-touch-icon-114x114-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="img/apple-touch-icon-144x144-precomposed.png">

    <!-- Google web fonts -->
    <link href="https://fonts.googleapis.com/css?family=Gochi+Hand|Lato:300,400|Montserrat:400,400i,700,700i" rel="stylesheet">


    <!-- 元々with search bar付きのページで必要なCSS-->
    <link href="css/base.css" rel="stylesheet">

    <!-- 元々with search tabs付きのページで必要なCSS-->
    <link href="rs-plugin/css/settings.css" rel="stylesheet">
    <link href="css/extralayers.css" rel="stylesheet">

    <link href="css/tabs_home.css" rel="stylesheet">

    <!-- 元々 tour listページで必要な Range sliderCSS -->
    <!-- Radio and check inputs -->
    <link href="css/skins/square/grey.css" rel="stylesheet">

    <!-- Range slider -->
    <link href="css/ion.rangeSlider.css" rel="stylesheet">
    <link href="css/ion.rangeSlider.skinFlat.css" rel="stylesheet">

    <!-- REVOLUTION SLIDER CSS -->
    <link rel="stylesheet" type="text/css" href="rev-slider-files/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css">
    <link rel="stylesheet" type="text/css" href="rev-slider-files/fonts/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="rev-slider-files/css/settings.css">

    <!-- REVOLUTION LAYERS STYLES -->
    <style>
        .tp-caption.News-Title,
        .News-Title {
            color: rgba(255, 255, 255, 1.00);
            font-size: 70px;
            line-height: 60px;
            font-weight: 700;
            font-style: normal;
            text-decoration: none;
            background-color: transparent;
            border-color: transparent;
            border-style: none;
            border-width: 0px;
            border-radius: 0 0 0 0px
        }

        .tp-caption.News-Subtitle,
        .News-Subtitle {
            color: rgba(255, 255, 255, 1.00);
            font-size: 15px;
            line-height: 24px;
            font-weight: 700;
            font-style: normal;
            font-family: Roboto Slab;
            text-decoration: none;
            background-color: rgba(255, 255, 255, 0);
            border-color: transparent;
            border-style: none;
            border-width: 0px;
            border-radius: 0 0 0 0px
        }

        .tp-caption.News-Subtitle:hover,
        .News-Subtitle:hover {
            color: rgba(255, 255, 255, 0.65);
            text-decoration: none;
            background-color: rgba(255, 255, 255, 0);
            border-color: transparent;
            border-style: solid;
            border-width: 0px;
            border-radius: 0 0 0px 0
        }
    </style>
    <style type="text/css">
        @import url(http://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700);
    </style>
    <style type="text/css">
        .hermes.tp-bullets {}

        .hermes .tp-bullet {
            overflow: hidden;
            border-radius: 50%;
            width: 16px;
            height: 16px;
            background-color: rgba(0, 0, 0, 0);
            box-shadow: inset 0 0 0 2px rgb(255, 255, 255);
            -webkit-transition: background 0.3s ease;
            transition: background 0.3s ease;
            position: absolute
        }

        .hermes .tp-bullet:hover {
            background-color: rgba(0, 0, 0, 0.21)
        }

        .hermes .tp-bullet:after {
            content: ' ';
            position: absolute;
            bottom: 0;
            height: 0;
            left: 0;
            width: 100%;
            background-color: rgb(255, 255, 255);
            box-shadow: 0 0 1px rgb(255, 255, 255);
            -webkit-transition: height 0.3s ease;
            transition: height 0.3s ease
        }

        .hermes .tp-bullet.selected:after {
            height: 100%
        }
    </style>


</head>
<body>

    <!-- ヘッダー読み込み -->
    <?php require('header_chat.php');  ?>

    <div class="row" style="margin-top: 90px; position: fixed; width: 100%; top: 0; left: 0; right: 0; bottom: 0; z-index: 200000;height: 50px; ">
        <!-- チャット全件表示 -->
        <div class="col-md-3">
            <h4 class="" align="center">Chat List</h4>
        </div>
        <!-- 個人間チャット表示 -->
        <div class="col-md-6">
            <h4 class="" align="center"></h4>
        </div>
        <!-- チャット全件表示 -->
        <div class="col-md-3" align="center">
            <h4 class="">Event Detail</h4>
        </div>
    </div>

    <main style="padding-top: 140px; ">
        <!-- チャット全件表示 -->
        <aside class="col-md-3">
            <?php foreach($event_chat_rooms as $event_chat_room){ ?>
            <?php 

            $sql ='SELECT * FROM users WHERE user_id = ?';
if ($event_chat_room['accept_user_id'] == $login_user['user_id']) {//ログインユーザがアクセプトユーザの場合
    $data = [$event_chat_room['user_id']];
} else if($event_chat_room['user_id'] == $login_user['user_id']){//ログインユーザがリクエストユーザの場合
    $data = [$event_chat_room['accept_user_id']];
}
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
$opponent_info = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!-- 現在のチャットルームについてはbackground-colorをすこし変える -->
<?php if ($event_chat_room['chat_room_id'] == $chat_room_id): ?>
    <div style="border: double 1px black; padding:8px; margin-bottom: 3px; border-radius: 5px; background-color: #FF6666">
    <?php else: ?>
        <div style="border: double 1px black; padding:8px; margin-bottom: 3px; border-radius: 5px; background-color: #1088FF">
        <?php endif; ?>

        <div class="row">
            <div class="col-md-3 col-sm-3" style="text-align: right; padding-right: 3px;">
                <img src="<?php echo $opponent_info['pic_path']; ?>" alt="User Picture" class="img-circle" style="width: 80px; height: 60px;"> 
            </div>
            <div class="col-md-9 col-sm-9">
                <a style="color: black;" href="user_chat.php?chat_room_id=<?php echo htmlspecialchars($event_chat_room['chat_room_id']); ?>&request_id=<?php echo htmlspecialchars($event_chat_room['request_id']); ?>">
                    <div>Event : <?php echo $event_chat_room['e_name']; ?></div>
                    <?php if ($event_chat_room['accept_user_id'] == $login_user['user_id']): ?>
                        <div>Request User : <?php echo $opponent_info['nickname']; ?></div>
                    <?php elseif($event_chat_room['user_id'] == $login_user['user_id']): ?>
                        <div>Accept User : <?php echo $opponent_info['nickname']; ?></div>
                    <?php endif; ?>
                    <div>Reqest Category : <?php echo $event_chat_room['request_category']; ?></div>
                </a>
            </div>
        </div>

    </div>


    <?php } ?>
</aside>




<!-- 個人間チャット表示 -->
<div class="col-md-6">
    <div class="row">
        <div id="messages" style="overflow-y: auto; width: 100%; height: 500px;" class="chat-frame">

            <?php foreach($messages as $message){ ?>
            <!--             <section class="comment-list "> -->
            <!-- チャット相手からのメッセージ -->
            <?php if ($message['user_id'] != $_SESSION['id']) { ?>
            <article class=" chat-talk">
                <span class="talk-icon">
                    <img class="img-responsive" src="<?php echo $opponent_info['pic_path']; ?>" style="width:50px; height: 50px;" >
                </span>
                <span class="talk-content">
                    <?php echo $message['message']; ?>
                </span>
            </article>
            <?php }elseif($message['user_id'] == $_SESSION['id']){ ?>
            <!-- 自分が送ったメッセージ -->
            <article class=" chat-talk mytalk">

                <span class="talk-icon">
                    <img class="img-responsive" src="<?php echo $login_user['pic_path']; ?>" style="width:50px; height: 50px;">
                </span>

                <span class="talk-content">
                    <?php echo $message['message']; ?>
                </span>





            </article>


            <?php }; ?>
        </section>
        <?php } ?>
    </div>
    <form method="POST" action="">
        <div class="panel-footer">
            <input id="btn-input" type="text" name='message' class="form-control input-sm chat_input" placeholder="type a message">
            <input type="hidden" name="user_id" value="<?php echo $_SESSION['login_user_id']; ?>">
            <p align="right" style="margin-top: 10px;">
                <input type="submit" value="Send" class="btn btn-danger" id="btn-chat">
            </p>
        </div>
    </form>
</div>
</div>

<!-- イベント詳細&ユーザー詳細 表示 -->
<!-- イベントデータ = $event_data に取得済み -->

<?php  

// 対象のchat_room_idに紐づくイベントデータを取得
$sql ='SELECT e.* FROM chat_rooms c, events e, requests r WHERE r.request_id = c.request_id AND r.event_id = e.event_id AND c.chat_room_id=?';
$data = [$chat_room_id];
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
$chat_event=$stmt->fetch(PDO::FETCH_ASSOC);

  // echo '<pre>';
  // var_dump($chat_event);
  // echo '</pre>';

?>


<aside class="col-md-3">
    <div class="">

        <div class="">
            <table class="table table-striped">

                <tbody>
                    <tr>
                        <td width= "120" style="vertical-align: middle;">
                            Event Name
                        </td>
                        <td>
                            <div>
                                <?php echo $chat_event['e_name']; ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: middle;">
                            Date and time
                        </td>
                        <td>
                            <div style="margin-bottom: 10px;">
                                Start Date<br>
                                <?php echo date('F d, Y', strtotime($chat_event['e_start_date'])); ?>
                            </div>
                            <div>
                                End Date<br>
                                <?php echo date('F d, Y', strtotime($chat_event['e_end_date'])); ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: middle;">
                            prefecture
                        </td>
                        <td>
                            <div>
                                <?php echo $chat_event['e_prefecture']; ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: middle;">
                            address
                        </td>
                        <td>
                            <div>
                                <?php echo $chat_event['e_address']; ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: middle;">
                            the place
                        </td>
                        <td>
                            <div>
                                <?php echo $chat_event['e_venue']; ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: middle;">
                            Web page
                        </td>
                        <td>
                            <div>
                                <?php echo $chat_event['official_url']; ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: middle;">
                            Acces
                        </td>
                        <td>
                            <?php echo $chat_event['e_venue']; ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th colspan="2">
                            The latest participants (The number of visitors)
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td width= "120" style="vertical-align: middle;">
                            2014
                        </td>
                        <td>
                            <div>
                                <?php echo $chat_event['year_ppp']; ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: middle;">
                            2015
                        </td>
                        <td>
                            <div>
                                <?php echo $chat_event['year_pp']; ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: middle;">
                            2016
                        </td>
                        <td>
                            <div>
                                <?php echo $chat_event['year_p']; ?>
                            </div>
                        </td>
                    </tr>
                    <td colspan ="2" style="font-weight: 700; font-size: 20px;">
                        <a href="event_detail.php?event_id=<?php echo htmlspecialchars($chat_event['event_id']);?>">Back to Event Detail</a>
                    </td>
                </tbody>
            </table>
        </div>



    </div>
</aside>

</main><!-- main_section -->


<!-- モーダル・ログイン -->
<?php require('modal_login.php'); ?>

<!-- モーダル・ユーザー登録 -->
<?php require('modal_register_user.php'); ?>

<!-- モーダル・主催者登録 -->
<?php require('modal_register_organizer.php'); ?>


<div id="toTop"></div>
<!-- Back to top button -->


<!-- Common scripts -->
<script src="js/jquery-2.2.4.min.js"></script>
<!-- <script src="js/common_scripts_min.js"></script>
    <script src="js/functions.js"></script> -->

    <!-- Specific scripts -->
    <script src="js/icheck.js"></script>
    <script>
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-grey',
            radioClass: 'iradio_square-grey'
        });
    </script>
    <!-- Date and time pickers -->


    <script src="js/modal_login_ajax.js"></script>
    <script src="js/modal_register_user_ajax.js"></script>
    <script src="js/modal_register_organizer_ajax.js"></script>
    <script src="js/modal_register_request_ajax.js"></script>

    <!-- 自作のJS -->
    <script src="js/custom.js"></script>

</body>
</html>