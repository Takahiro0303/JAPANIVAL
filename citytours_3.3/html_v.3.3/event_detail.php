<?php
session_start();
require('../../common/dbconnect.php'); //データベースへ接続
require('../../common/functions.php');

$login_user = get_login_user($dbh);

// sessionを持たない状態で直接、このページに来た時には、event_input.phpに自動遷移
if(!isset($_SESSION['event'])){
    header('Location: edit_index.php');
    exit();
}

// require('header.php');
// require('../../common/event_data.php'); //イベント詳細情報データの読み込み (function化したデータベースの読み込み) ⇦他でも使うようなら復活させる
// $_REQUEST['event_id'] = 1;

$event_id = $_REQUEST['event_id'];

// 【○】イベントデータ取得 * ログイン不要
$sql = 'SELECT * FROM events WHERE event_id=?';
$data = [$event_id];
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
$event_data = $stmt->fetch(PDO::FETCH_ASSOC);
// v($event_data);

// 【○】イベント写真データ取得 * ログイン不要
$sql = 'SELECT * FROM event_pics WHERE event_id=?';

$data = [$event_id];
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
while ($event_pic = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $event_pics[] = $event_pic;
}


  // echo '<pre>';
  // var_dump($event_pics);
  // echo '</pre>';
  // echo $event_id;

// v($event_pics);



// reviews&usersテーブルから全データ取得
// $sql ='SELECT r.*, u.*
//         FROM reviews r, users u
//         WHERE r.user_id=u.user_id AND r.event_id=?';
//         // -- ORDER BY r.created
//         // -- DESC LIMIT %d, 3
//  $data = [$event_id];   
//  $stmt = $dbh->prepare($sql);
//  $stmt->execute($data);
// $reviews = [];

// while ($review = $stmt->fetch(PDO::FETCH_ASSOC)) {
//     $reviews[] = $review;
// }
// v($reviews);


// $count = count($reviews);

// v($count);

// v($event_pics[0]['e_pic_path']);

// マッチング情報＆リクエストボタンの表示 ※ログイン必須

// ○requestsテーブルから全データ取得
// if (isset($_SESSION[''])){
// user_flag != 0 // 管理者ではない場合、
    $sql ='SELECT r.*,u.* FROM requests r,users u WHERE r.user_id=u.user_id AND r.event_id=?';
    $data = [$_REQUEST['event_id']];
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    $requests = [];
    while ($request = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $requests[] = $request;
    }
// }
v($requests[1]['nickname']);

// リクエストボタンを押した際の登録処理
if (!empty($_POST['request_category_id'])) { // リクエストカテゴリ指定されていればリクエスト処理
        if ($request = $_POST['request_category_id']) {
        $sql = 'INSERT INTO requests
                    SET request_id=?,
                        user_id=?,
                        event_id=?,
                        request_category_id=?,
                        created=NOW()';
        $data = array($requst_id, $login_user['user_id'],$_REQUST['event_id']);
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);

        // 更新後、イベント詳細ページに戻す
        header('Location: event_detail.php?event_id=' . $_REQUEST['event_id']);
        exit();
        }
}

// ③いいねロジック実装
if (!empty($_POST['like_data'])) {
    // $_POST['like_data']の値がlikeかunlikeかで条件分岐
    if ($_POST['like_data'] == 'like') {
        // いいね！ボタンが押されたとき（likesテーブルにデータ追加）
        $sql = 'INSERT INTO likes SET member_id=?, tweet_id=?';
        $data = [$login_user['member_id'] , $record['tweet_id']];
    } else {
        // いいね！取り消しボタンが押されたとき（likesテーブルからデータ削除）
        $sql = 'DELETE FROM likes WHERE member_id=? AND tweet_id=?';
        $data = [$login_user['member_id'] , $record['tweet_id']];
    }
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    header('Location: view.php?tweet_id=' . $record['tweet_id']);
    exit();
}

//　マッチング希望者数カウント・表示
$sql = 'SELECT COUNT(*) AS total FROM requests WHERE event_id=?';
$data = [$_REQUEST['event_id']];
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
$request_count = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<!--[if IE 8]><html class="ie ie8"> <![endif]-->
<!--[if IE 9]><html class="ie ie9"> <![endif]-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="Citytours - Premium site template for city tours agencies, transfers and tickets.">
    <meta name="author" content="Ansonika">
    <title>JAPANIVAL-EventDetail</title>

    <!-- Favicons-->
    <link rel="shortcut icon" href="img/japanival_icon.jpg" type="image/x-icon">
    <link rel="apple-touch-icon" type="image/x-icon" href="img/apple-touch-icon-57x57-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="img/apple-touch-icon-72x72-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="img/apple-touch-icon-114x114-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="img/apple-touch-icon-144x144-precomposed.png">

    <!-- Google web fonts -->
    <link href="https://fonts.googleapis.com/css?family=Gochi+Hand|Lato:300,400|Montserrat:400,400i,700,700i" rel="stylesheet">

    <!-- CSS -->
    <link href="css/base.css" rel="stylesheet">

    <!-- CSS -->
    <link href="css/slider-pro.min.css" rel="stylesheet">
    <link href="css/date_time_picker.css" rel="stylesheet">

<!--[if lt IE 9]>
<script src="js/html5shiv.min.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->

</head>

<body>




    <div class="layer"></div>
    <!-- Mobile menu overlay mask -->

    <!-- Header================================================== -->

    <!-- header.phpのrequire -->
    <?php require('header.php');  ?>

    <!-- End Header -->

    <section class="parallax-window" data-parallax="scroll" data-image-src="<?php echo $event_pics[0]['e_pic_path'];?>" data-natural-width="1400" data-natural-height="470">
        <div class="parallax-content-2">
            <div class="container">
                <div class="row">

                    <div class="col-md-7 col-sm-7">
                        <h1><?php echo $event_data['e_name']; ?></h1> <!-- イベント名表示 -->
                        <span><?php echo $event_data['e_prefecture']; ?></span> <!-- 開催地名表示 -->

                    </div>
                    <div class="col-md-5 col-sm-5" style="font-size: 60px;">
                        <span><h1><?php echo $event_data['e_start_date'] . '〜'. $event_data['e_end_date']; ?></h1></span> <!-- 曜日・開催日時を表示 -->
                        <!-- <span class="favorites"><i class="icon-heart" style="color: red;"></i><b>125<b></span> <!-- お気に入り数の表示 -->
                        <!--                         <a class="btn-danger" href="" aria-expanded="false" width="40px" height="20">♡</a> -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End section -->


    <main>

        <div class="collapse" id="collapseMap">
            <div id="map" class="map"></div>
        </div>
        <!-- End Map -->


        <div class="container margin_60">
            <div class="row">

                <div class="col-md-8">
                    <!-- Map button for tablets/mobiles -->

                    <div id="Img_carousel" class="slider-pro" style="margin-bottom: 10px;">

                        <div class="sp-slides">

                            <?php  for ($j = 0; $j< count($event_pics); $j++) { ?>
                                <?php echo '<div class="sp-slide">' ?>
                                    <?php echo '<img' ?>    
                                    <?php echo 'alt="Image"'  ?> 
                                    <?php echo 'class="sp-image"'  ?> 
                                    <?php echo 'src="' . $event_pics[$j]['e_pic_path'] . '"'  ?> 
                                    <?php echo 'data-src="' . $event_pics[$j]['e_pic_path'] . '"'  ?> 
                                    <?php echo 'data-small="' . $event_pics[$j]['e_pic_path'] . '"'  ?> 
                                    <?php echo 'data-medium="' . $event_pics[$j]['e_pic_path'] . '"'  ?> 
                                    <?php echo 'data-large="' . $event_pics[$j]['e_pic_path'] . '"'  ?> 
                                    <?php echo 'data-retina="' . $event_pics[$j]['e_pic_path'] . '">'  ?> 
                                <?php echo '</div>'  ?>
                            <?php } ?>

                        </div>
                        <div class="sp-thumbnails">
                            <?php  for ($j = 0; $j< count($event_pics); $j++) { ?>
                            <?php echo '<img alt="Image" class="sp-thumbnail" src="' . $event_pics[$j]['e_pic_path'] . '">'  ?> 
                            <?php } ?>
                        </div>

                    </div>

                    <hr>

                    <!-- 以下、イベント説明 -->
                    <div class="row">
                        <div class="col-md-3">
                            <h3>Event Description</h3>
                        </div>
                        <div class="col-md-9">
                            <div style="word-wrap: break-word; width:99%; height:300px;">
                                <?php echo $event_data['explanation'] ?>
                            </div>
                        </div>
                    </div> 

                    <!-- End row  -->

                    <hr>

                    <!-- 以下、イベント詳細 -->
                    <div class="row">
                        <div class="col-md-3">
                            <h3>Event Detail</h3>
                        </div>
                        <div class="col-md-9">
                            <div class=" table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th colspan="2">
                                                イベント開催詳細
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td width= "200" style="vertical-align: middle;">
                                                Event Name
                                            </td>
                                            <td>
                                                <div>
                                                    <?php echo $event_data['e_name']; ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="vertical-align: middle;">
                                                Date and time
                                            </td>
                                            <td>
                                                <div style="margin-bottom: 10px;">
                                                    イベント日程（開始日）（必須）<br>
                                                    <?php echo $event_data['e_start_date']; ?>
                                                </div>
                                                <div>
                                                    イベント日程（終了日）（必須）<br>
                                                    <?php echo $event_data['e_start_date']; ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="vertical-align: middle;">
                                                city
                                            </td>
                                            <td>
                                                <div>
                                                    <?php echo $event_data['e_prefecture']; ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="vertical-align: middle;">
                                                the place (follow on map)
                                            </td>
                                            <td>
                                                <div>
                                                    <?php echo $event_data['e_venue']; ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="vertical-align: middle;">
                                                Web page
                                            </td>
                                            <td>
                                                <div>
                                                    <?php echo $event_data['official_url']; ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="vertical-align: middle;">
                                                Acces
                                            </td>
                                            <td>
                                                <?php echo $event_data['e_access']; ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class=" table-responsive">
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
                                            <td width= "200" style="vertical-align: middle;">
                                                2014
                                            </td>
                                            <td>
                                                <div>
                                                    <?php echo $event_data['year_ppp']; ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="vertical-align: middle;">
                                                2015
                                            </td>
                                            <td>
                                                <div>
                                                    <?php echo $event_data['year_pp']; ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="vertical-align: middle;">
                                                2016
                                            </td>
                                            <td>
                                                <div>
                                                    <?php echo $event_data['year_p']; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-3">
                            <h3>Map</h3>
                        </div>
                        <div class="col-md-9">
                            <img src="img/SuperScreenshot 2017-7-3 12-49-11.png" width="550px" height="400px">
                        </div>
                    </div>

                    <hr>

                    
                </div>
                <!--End  single_tour_desc-->

                <!-- event_aside挿入 -->
                <?php require('event_aside.php');  ?>

            </div>
        </div>
        <!--End container -->
        <div id="overlay"></div>
        <!-- Mask on input focus -->
    </div>
</main>
<!-- End main -->

    <!-- フッター呼び出し -->
    <?php require('footer.php'); ?>

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
<script src="js/common_scripts_min.js"></script>
<script src="js/functions.js"></script>

<!-- Specific scripts -->
<script src="js/icheck.js"></script>
<script>
    $('input').iCheck({
        checkboxClass: 'icheckbox_square-grey',
        radioClass: 'iradio_square-grey'
    });
</script>
<!-- Date and time pickers -->
<script src="js/jquery.sliderPro.min.js"></script>
<script type="text/javascript">
    $(document).ready(function ($) {
        $('#Img_carousel').sliderPro({
            width: 960,
            height: 500,
            fade: true,
            arrows: true,
            buttons: false,
            fullScreen: false,
            smallSize: 500,
            startSlide: 0,
            mediumSize: 1000,
            largeSize: 3000,
            thumbnailArrows: true,
            autoplay: false
        });
    });
</script>

<!-- Date and time pickers -->
<script src="js/bootstrap-datepicker.js"></script>
<script src="js/bootstrap-timepicker.js"></script>
<script>
    $('input.date-pick').datepicker('setDate', 'today');
    $('input.time-pick').timepicker({
        minuteStep: 15,
        showInpunts: false
    })
</script>

<!--Review modal validation -->
<script src="assets/validate.js"></script>

<!-- Map -->
<script src="http://maps.googleapis.com/maps/api/js"></script>
<script src="js/map.js"></script>
<script src="js/infobox.js"></script>

<script src="js/modal_login_ajax.js"></script>
<script src="js/modal_register_user_ajax.js"></script>
<script src="js/modal_register_organizer_ajax.js"></script>
<!-- 自作のJS -->
<script src="js/custom.js"></script>


</body>

<footer>
    <!-- require('../../common/footer.php'); -->
</footer>
</html>