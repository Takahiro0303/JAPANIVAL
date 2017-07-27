<?php
session_start();
require('../../common/dbconnect.php'); //データベースへ接続
require('../../common/functions.php');
require('request.php'); // パラメータがなければ、edit_index.phpに遷移

$login_user = get_login_user($dbh);


$event_id = $_REQUEST['event_id'];

// ○イベントデータ取得 * ログイン不要
$sql = 'SELECT * FROM events WHERE event_id=?';
$data = [$event_id];
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
$event_data = $stmt->fetch(PDO::FETCH_ASSOC);

$starts = explode('-', $event_data['e_start_date']);
$ends = explode('-', $event_data['e_end_date']);

if ($starts[0] != $ends[0]) {
    $duration = date('F d, Y', strtotime(implode('-', $starts))) .' - ' . date('F d, Y', strtotime(implode('-', $ends)));
} elseif($starts[1] != $ends[1]){
    $duration = date('F d', strtotime(implode('-', $starts))) .' - ' . date('F d, Y', strtotime(implode('-', $ends)));
} elseif($starts[2] != $ends[2]){
    $duration = date('F d', strtotime(implode('-', $starts))) .' - ' . date('d, Y', strtotime(implode('-', $ends)));
} else{
    $duration = date('F d, Y', strtotime(implode('-', $starts)));
}


$sql = 'SELECT * FROM event_pics WHERE event_id=?';
$data = [$event_id];
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
while ($event_pic = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $event_pics[] = $event_pic;
}

// ○reviews&usersテーブルから全データ取得
$sql ='SELECT r.rating, r.comment, r.created, u.nickname
        FROM reviews r, users u
        WHERE r.user_id=u.user_id AND r.event_id=?';
        // -- ORDER BY r.created
        // -- DESC LIMIT %d, 3
 $data = [$event_id];   
 $stmt = $dbh->prepare($sql);
 $stmt->execute($data);
$reviews = [];
while ($review = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $reviews[] = $review;
}

$count = count($reviews);
// v($count);

// reviewDB登録
$review_rating = '';
$review_comment = '';

if (!empty($_POST['review_rating']) && !empty($_POST['review_text'])) {
  $review_rating = $_POST['review_rating'];
  $review_comment = $_POST['review_comment'];

  $review_sql = 'INSERT INTO reviews SET event_id = ?, user_id = ?, rating = ?, comment = ?, created = NOW()';
  $review = [$_POST['event_id'],$login_user['user_id'],$_POST['review_rating'],$_POST['review_comment']];
  $review_stmt = $dbh->prepare($review_sql);
  $review_stmt->execute($review);

}
    


//　マッチング希望者数カウント・表示　⇦ リクエスト欄に記載させるか要相談
// $sql = 'SELECT COUNT(*) AS total FROM requests WHERE event_id=?';
// $data = [$_REQUEST['event_id']];
// $stmt = $dbh->prepare($sql);
// $stmt->execute($data);
// $request_count = $stmt->fetch(PDO::FETCH_ASSOC);

$sql = 'SELECT e_Lat,e_Lng FROM events WHERE event_id=?';
$data = [$event_id];
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
$record = $stmt->fetch(PDO::FETCH_ASSOC);

$e_lat = $record['e_Lat'];
$e_lng = $record['e_Lng'];


?>

<!DOCTYPE html>
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
    <link href="modal_profile.css"  rel="stylesheet">

    <style type="text/css">
      html { height: 100% }
      body { height: 100%; margin: 0; padding: 0 }
      #map_canvas { height: 100% }
    </style>

    <script src="js/jquery-2.2.4.min.js"></script>

    <!-- Google Maps APIを読み込む -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCzo1nDw_k6yNjo48_6UCYjLOwqF_QxEWE"></script>

    <!-- initialize()関数を定義 -->
    <script type="text/javascript">
      function initialize() {
        var lat = $('#keido').text();
        var lng = $('#ido').text();
        console.log(lat);
        console.log(lng);

        // 地図を表示する際のオプションを設定
        var map = new google.maps.Map( document.getElementById( 'map_canvas' ), {
          zoom: 15 ,  // ズーム値
          center: new google.maps.LatLng(lat , lng) , // 中心の位置座標
        } ) ;

        var marker = new google.maps.Marker( {
          map: map ,  // 地図
          position: new google.maps.LatLng(lat , lng) , // 位置座標
        } ) ;
      }
    </script>


<!--[if lt IE 9]>
<script src="js/html5shiv.min.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->

</head>

<body onload="initialize()">




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
                        <span style="display:block; font-size: 17px;margin-bottom:6px; margin-top: 2px;"><?php echo $event_data['e_prefecture']; ?></span> <!-- 開催地名表示 -->

                    </div>
                    <div class="col-md-5 col-sm-5" style="text-align: center;">

                        <span><h1 style="font-size: 32px; padding-top: 15px; "><?php echo $duration; ?></h1></span>
                      <!--             date('F d, Y', strtotime($event_data['e_start_date'])) -->

                         <!-- 曜日・開催日時を表示 -->
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

                        <div class="sp-slides" style="margin-top:2px;">

                            <?php  for ($j = 0; $j< count($event_pics); $j++) { ?>
                                <div class="sp-slide">
                                    <img alt="Image" class="sp-image" src="<?php echo $event_pics[$j]['e_pic_path'];?>" >
                                    <data-src="<?php echo $event_pics[$j]['e_pic_path'];?>">
                                    <data-small="<?php echo $event_pics[$j]['e_pic_path'];?>">
                                    <data-medium="<?php echo $event_pics[$j]['e_pic_path'];?>">
                                    <data-large="<?php echo $event_pics[$j]['e_pic_path'];?>">
                                    <data-retina="<?php echo $event_pics[$j]['e_pic_path'];?>">
                                </div>
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
                            <div style="word-wrap: break-word; width:99%; height:300px; overflow: auto;">
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
                                                    <?php echo date('F d, Y', strtotime(implode('-', $starts))); ?>
                                                </div>
                                                <div>
                                                    イベント日程（終了日）（必須）<br>
                                                    <?php echo date('F d, Y', strtotime(implode('-', $ends))); ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="vertical-align: middle;">
                                                prefecture
                                            </td>
                                            <td>
                                                <div>
                                                    <?php echo $event_data['e_prefecture']; ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="vertical-align: middle;">
                                                address
                                            </td>
                                            <td>
                                                <div>
                                                    <?php echo $event_data['e_address']; ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="vertical-align: middle;">
                                                the place
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
                                                <?php echo $event_data['e_venue']; ?>
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
                        <div id="keido" style="display: none;">
                            <?php echo htmlspecialchars($e_lat);?>
                        </div>

                        <div id="ido" style="display: none;">
                            <?php echo htmlspecialchars($e_lng);?>
                        </div>

                        <div id="address" style="display: none;">
                            <?php echo htmlspecialchars($e_address);?>
                        </div>

                        <div class="col-md-9">

                            <div id="map_canvas" style="width:100%; height:400px"></div>

                        </div>
                    </div>

                    <hr>

                    <div class="row"><!-- レビュー表示 -->
                        <div class="col-md-3">
                            <h3>Reviews </h3> 
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div id="general_rating" class="rating">
                                    <div class="col-md-7">
                                        <span><?php echo($count); ?></span> Reviews <!-- レビュー件数表示 -->            
<!--                                         <i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star"></i><i class="icon-star"></i>  -->
                                    </div>
<!--                                     <div class="col-md-5">
                                        <a href="#" class="btn_1 add_bottom_30" data-toggle="modal" data-target="#myReview">Leave a review</a>
                                    </div> -->
                                </div> <!-- general_rating -->     
                            </div> 

                            <hr>

                            <?php foreach ($reviews as $review){ ?>
                                <div class="review_strip_single">
                                    <img src="<?php echo($review['pic_path']); ?>" alt="Image" class="img-circle" width="70px" height="70px" style="height:70px;" >

                                    <!--　レビュー作成日表示 -->
                                    <small><?php echo($review['created']);?></small>

                                    <!-- ユーザー名表示 -->
                                    <h4 style="margin-bottom: 10px;margin-top: -20px;"><?php echo($review['nickname']); ?></h4>

                                    <!-- レビュー評価表示機能 -->
                                    <div style="margin-bottom: 10px;">
                                        <?php if ($review['rating'] == 1){ ?>
                                            <div class="rating" style="margin-top:30px;">
                                                <i class="icon-star voted" style="font-weight: 400;"></i>
                                                <i class="icon-star"></i>
                                                <i class="icon-star"></i>
                                                <i class="icon-star"></i>
                                                <i class="icon-star"></i>
                                            </div>
                                            <?php }elseif ($review['rating'] == 2){ ?>
                                            <div class="rating" style="margin-top:30px;">
                                                <i class="icon-star voted"></i>
                                                <i class="icon-star voted"></i>
                                                <i class="icon-star "></i>
                                                <i class="icon-star "></i>
                                                <i class="icon-star "></i>
                                            </div>
                                            <?php }elseif ($review['rating'] == 3){ ?>
                                            <div class="rating" style="margin-top:30px;">
                                                <i class="icon-star voted"></i>
                                                <i class="icon-star voted"></i>
                                                <i class="icon-star voted"></i>
                                                <i class="icon-star "></i>
                                                <i class="icon-star "></i>
                                            </div>
                                            <?php }elseif ($review['rating'] == 4){ ?>
                                            <div class="rating" style="margin-top:30px;">
                                                <i class="icon-star voted"></i>
                                                <i class="icon-star voted"></i>
                                                <i class="icon-star voted"></i>
                                                <i class="icon-star voted"></i>
                                                <i class="icon-star "></i>
                                            </div>
                                            <?php }elseif ($review['rating'] == 5){ ?>
                                            <div class="rating" style="margin-top:30px;">
                                                <i class="icon-star voted"></i>
                                                <i class="icon-star voted"></i>
                                                <i class="icon-star voted"></i>
                                                <i class="icon-star voted"></i>
                                                <i class="icon-star voted"></i>
                                            </div>
                                        <?php }; ?>
                                    </div>
                                    <!-- レビュー本文表示 -->
                                    <p><?php echo($review['comment']) ; ?></p>


                                </div> <!-- End review strip -->

                            <?php }; ?>
<!--                         
                            <div align="center">
                                <a href="" class="btn_1 add_bottom_30">See all review</a>
                            </div> -->


                        </div> <!-- col-md-9 -->
                    </div> <!-- row -->
                    
                </div>
                <!--End  single_tour_desc-->

                <!-- event_aside挿入 --> 
                <?php require('event_aside.php');  ?>



            </div>
        </div>
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

    <!-- モーダル・レビュー登録 -->
    <?php require('modal_leave_review.php'); ?>

    <!-- モーダル・リクエスト登録 -->
    <?php require('modal_register_request.php'); ?>

    <!-- モーダル・プロフィール -->
    <?php require('modal_profile.php') ?>

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
<!-- <script src="http://maps.googleapis.com/maps/api/js"></script> -->
<script src="js/map.js"></script>
<script src="js/infobox.js"></script>

<script src="js/modal_login_ajax.js"></script>
<script src="js/modal_register_user_ajax.js"></script>
<script src="js/modal_register_organizer_ajax.js"></script>
<script src="js/modal_register_request_ajax.js"></script>

<!-- 自作のJS -->
<script src="js/custom.js"></script>


</body>

<footer>
    <!-- require('../../common/footer.php'); -->
</footer>
</html>