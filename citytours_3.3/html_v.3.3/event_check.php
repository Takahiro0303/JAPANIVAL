<?php  

session_start();
// echo '<pre>';
// var_dump($_SESSION['event']);    
// echo '</pre>';

require('../../common/dbconnect.php');
require('../../common/functions.php');

$login_user = get_login_user($dbh);

if ($_SESSION['id'] == '' && $_SESSION['flag'] == '') {
    header('Location: edit_index.php');
    exit();//ここでこのファイルの読み込みを強制終了
} elseif ($_SESSION['flag'] == '1') {
    header('Location: edit_index.php');
    exit();//ここでこのファイルの読み込みを強制終了
}

// sessionを持たない状態で直接、このページに来た時には、event_input.phpに自動遷移
if(!isset($_SESSION['event'])){
    header('Location: event_input.php');
    exit();
}

  // echo '<pre>';
  // var_dump($_POST);
  // echo '</pre>';

//会員登録ボタンが押された際の処理
if(!empty($_POST)){

  // echo '<pre>';
  // var_dump($_SESSION['event']);
  // echo '</pre>';
    $sql = 'INSERT INTO events
    SET     e_name = ?,
            e_start_date = ?,
            e_end_date = ?,
            e_prefecture = ?,
            e_address = ?,
            e_lat = ?,
            e_lng = ?,
            e_venue = ?,
            explanation = ?,
            e_access = ?,
            year_p = ?,
            year_pp = ?,
            year_ppp = ?,
            official_url = ?,
            created = NOW()';

    $data = [ $_SESSION['event']['e_name'],
    $_SESSION['event']['e_start_date'],
    $_SESSION['event']['e_end_date'],
    $_SESSION['event']['e_prefecture'],
    $_SESSION['event']['e_address'],
    $_POST['lat_name'],
    $_POST['lng_name'],
    $_SESSION['event']['e_venue'],
    $_SESSION['event']['explanation'],
    $_SESSION['event']['e_access'],
    $_SESSION['event']['year_p'],
    $_SESSION['event']['year_pp'],
    $_SESSION['event']['year_ppp'],
    $_SESSION['event']['official_url']];


    $events_stmt = $dbh->prepare($sql);
    $events_stmt->execute($data);

    $sql = 'SELECT event_id FROM events ORDER BY event_id desc limit 1';
    //TODO!:条件に主催者IDを加えないと、他人も含めた最新の一件を取得しちゃうかも。
    $events_stmt = $dbh->prepare($sql);
    $events_stmt->execute();
    $event_id_register = $events_stmt->fetch(PDO::FETCH_ASSOC);


    /*if ($_POST['top_pic']) {
        $sql = 'INSERT INTO event_pics
        SET event_id= ?,
        e_pic_path = ?,
        top_pic_flag=1,
        created = NOW()';

        $data = [$event_id_register['event_id'],$_POST['top_pic']];
        $event_pics_stmt = $dbh->prepare($sql);
        $event_pics_stmt->execute($data);
    }*/



    for ($j = 0; $j< count($_SESSION['event']['e_pic_path']); $j++) {
    // event_picsテーブルへの登録
        $sql = 'INSERT INTO event_pics
                        SET event_id= ?,
                            e_pic_path = ?,        
                            created = NOW()';

        $data = [$event_id_register['event_id'],
                 $_SESSION['event']['e_pic_path'][$j]];
        $event_pics_stmt = $dbh->prepare($sql);
        $event_pics_stmt->execute($data);
    }

    //TOP画像
    // $sql = 'INSERT INTO event_pics
    //                 SET event_id=?,
    //                     top_pic_flag=1,
    //                     cropp_file_name=?,
    //                     created=NOW()';
    // $data = [$event_id_register['event_id'],
    //          $_SESSION['event']['cropp_file_name']];
    // $event_top_pics_stmt = $dbh->prepare($sql);
    // $event_top_pics_stmt->execute($data);


// echo '<pre>';
// var_dump($_SESSION['event']['e_pic_path']);
// echo '</pre>';

// unset($_SESSION['event']);
//TODO!:なんでunsetなんだっけ？

    header("Location: event_detail.php?event_id=" . $event_id_register['event_id']);
    exit();

}

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

    <style type="text/css">
      html { height: 100% }
      body { height: 100%; margin: 0; padding: 0 }
      #map_canvas { height: 100% }
    </style>

<!--[if lt IE 9]>
<script src="js/html5shiv.min.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->


</head>

<body  onload="initialize()">



    <div class="layer"></div>
    <!-- Mobile menu overlay mask -->

    <!-- Header================================================== -->

    <!-- header.phpのrequire -->
    <?php require('header.php');  ?>

    <!-- End Header -->

    <section class="parallax-window" data-parallax="scroll" data-image-src="

    <?php echo htmlspecialchars($_SESSION['event']['e_pic_path'][0]);?>" data-natural-width="1400" data-natural-height="470">
        <div class="parallax-content-2">
            <div class="container">
                <div class="row">
                    <div class="col-md-7 col-sm-7">
                        <h1><?php echo $_SESSION['event']['e_name']; ?></h1> <!-- イベント名表示 -->
                        <span><?php echo $_SESSION['event']['e_prefecture']; ?></span> <!-- 開催地名表示 -->
                    </div>
                    <div class="col-md-5 col-sm-5" style="font-size: 60px;">
                        <span><h1><?php echo $_SESSION['event']['e_start_date'] . '〜'. $_SESSION['event']['e_end_date']; ?></h1></span> <!-- 曜日・開催日時を表示 -->
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

                            <?php  for ($j = 0; $j< count($_SESSION['event']['e_pic_path']); $j++) { ?>
                            <?php echo '<div class="sp-slide">' ?>
                            <?php echo '<img' ?>    
                            <?php echo 'alt="Image"'  ?> 
                            <?php echo 'class="sp-image"'  ?> 
                            <?php echo 'src="' . $_SESSION['event']['e_pic_path'][$j] . '"'  ?> 
                            <?php echo 'data-src="' . $_SESSION['event']['e_pic_path'][$j] . '"'  ?> 
                            <?php echo 'data-small="' . $_SESSION['event']['e_pic_path'][$j] . '"'  ?> 
                            <?php echo 'data-medium="' . $_SESSION['event']['e_pic_path'][$j] . '"'  ?> 
                            <?php echo 'data-large="' . $_SESSION['event']['e_pic_path'][$j] . '"'  ?> 
                            <?php echo 'data-retina="' . $_SESSION['event']['e_pic_path'][$j] . '">'  ?> 
                            <?php echo '</div>'  ?>
                            <?php } ?>

                        </div>
                        <div class="sp-thumbnails">
                            <?php  for ($j = 0; $j< count($_SESSION['event']['e_pic_path']); $j++) { ?>
                            <?php echo '<img alt="Image" class="sp-thumbnail" src="' . $_SESSION['event']['e_pic_path'][$j] . '">'  ?> 
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
                                <?php echo $_SESSION['event']['explanation'] ?>
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
                            <form method="POST" action="event_check.php" enctype="multipart/form-data">
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
                                                        <?php echo $_SESSION['event']['e_name']; ?>
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
                                                        <?php echo $_SESSION['event']['e_start_date']; ?>
                                                    </div>
                                                    <div>
                                                        イベント日程（終了日）（必須）<br>
                                                        <?php echo $_SESSION['event']['e_start_date']; ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="vertical-align: middle;">
                                                    city
                                                </td>
                                                <td>
                                                    <div>
                                                        <?php echo $_SESSION['event']['e_prefecture']; ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="vertical-align: middle;">
                                                    address
                                                </td>
                                                <td>
                                                    <div id="address">
                                                        <?php echo $_SESSION['event']['e_address']; ?>
                                                    </div>
                                                    <input type="hidden" id="lat_id" name="lat_name" value="">
                                                    <input type="hidden" id="lng_id" name="lng_name" value="">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="vertical-align: middle;">
                                                    the place
                                                </td>
                                                <td>
                                                    <div>
                                                        <?php echo $_SESSION['event']['e_venue']; ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="vertical-align: middle;">
                                                    Web page
                                                </td>
                                                <td>
                                                    <div>
                                                        <?php echo $_SESSION['event']['official_url']; ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="vertical-align: middle;">
                                                    Acces
                                                </td>
                                                <td>
                                                    <?php echo $_SESSION['event']['e_access']; ?>
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
                                                        <?php echo $_SESSION['event']['year_ppp']; ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="vertical-align: middle;">
                                                    2015
                                                </td>
                                                <td>
                                                    <div>
                                                        <?php echo $_SESSION['event']['year_pp']; ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="vertical-align: middle;">
                                                    2016
                                                </td>
                                                <td>
                                                    <div>
                                                        <?php echo $_SESSION['event']['year_p']; ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div style="display: inline-block;">

                                            <input class="btn btn-primary" type="submit" value="確認">
                                            <input type="hidden" name="action" value="確認ボタン">
                                        
                                    </div>
                                    <div style="display: inline-block;">
                                        <a href="event_input.php?action=rewrite" class="btn btn-primary">書き直す</a>
                                    </div>
                                </div>
                            </form>
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
                            <div id="map_canvas" style="width:600px; height:500px"></div>
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
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCzo1nDw_k6yNjo48_6UCYjLOwqF_QxEWE"></script>
<script src="js/map.js"></script>
<script src="js/infobox.js"></script>

<script src="js/modal_login_ajax.js"></script>
<script src="js/modal_register_user_ajax.js"></script>
<script src="js/modal_register_organizer_ajax.js"></script>
<!-- 自作のJS -->
<script src="js/custom.js"></script>

<script type="text/javascript">
function initialize() {
      // google.maps.Geocoder()コンストラクタのインスタンスを生成
  var geocoder = new google.maps.Geocoder();



  // // 地図を表示させるインスタンスを生成
  // var map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);

  var address = document.getElementById("address").textContent;
  // geocoder.geocode()メソッドを実行 
  geocoder.geocode( { 'address':address}, function(results, status) {

    // ジオコーディングが成功した場合
    if (status == google.maps.GeocoderStatus.OK) {
        // alert( results[ 0 ].geometry.location );編集
        var lat = results[ 0 ].geometry.location.lat();
        var lng = results[ 0 ].geometry.location.lng();

        console.log(lat);
        console.log(lng);
        $('#lat_id').val(lat);
        $('#lng_id').val(lng);

        // 地図を表示する際のオプションを設定
        var map = new google.maps.Map( document.getElementById( 'map_canvas' ), {
          zoom: 15 ,  // ズーム値
          center: new google.maps.LatLng(lat , lng) , // 中心の位置座標
        } ) ;

        var marker = new google.maps.Marker( {
          map: map ,  // 地図
          position: new google.maps.LatLng(lat , lng) , // 位置座標
        } ) ;


      
      // google.maps.Map()コンストラクタに定義されているsetCenter()メソッドで
      // 変換した緯度・経度情報を地図の中心に表示
      // map.setCenter(results[0].geometry.location);

      // // 地図上に目印となるマーカーを設定います。
      // // google.maps.Marker()コンストラクタにマーカーを設置するMapオブジェクトと
      // // 変換した緯度・経度情報を渡してインスタンスを生成
      // // →マーカー詳細
      // var marker = new google.maps.Marker({
      //   map: map,
      //   position: results[0].geometry.location
      // });


    // ジオコーディングが成功しなかった場合
    } else {
      console.log('Geocode was not successful for the following reason: ' + status);
    }
    
  });
}
</script>


</body>
</html>