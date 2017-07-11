<?php  
session_start();

require('../../common/dbconnect.php'); //データベースへ接続
require('../../common/functions.php'); //関数ファイル読み込み
// require('../../common/event_data.php'); //イベント詳細情報データの読み込み (function化したデータベースの読み込み) ⇦　他でも使うようなら復活させる

// イベントデータ取得
$sql = 'SELECT * FROM events WHERE event_id=1';
$data = ['event_id'];
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
$event_data = $stmt->fetch(PDO::FETCH_ASSOC);

v($event_data);

// cnotificationsテーブルからぜ全データ取得
$sql = 'SELECT * FROM notifications WHERE notification_id=1';
// $data = ['notisfuction_id'];
$stmt = $dbh->prepare($sql);
$stmt->execute();
$notification = $stmt->fetch(PDO::FETCH_ASSOC);

v($notification);

// reviews&usersテーブルから全データ取得
$sql ='SELECT r.*, u.*
        FROM reviews r, users u
        WHERE r.event_id=1';
        // -- ORDER BY r.created
        // -- DESC LIMIT %d, 3
 $data = ['reviews'];   
 $stmt = $dbh->prepare($sql);
 $stmt->execute($data);
 $reviews = $stmt->fetch(PDO::FETCH_ASSOC);

v($reviews);

?>


<!DOCTYPE html>
<!--[if IE 8]><html class="ie ie8"> <![endif]-->
<!--[if IE 9]><html class="ie ie9"> <![endif]-->
<html lang="en">

<header>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="Citytours - Premium site template for city tours agencies, transfers and tickets.">
    <meta name="author" content="Ansonika">
    <title>Matshumoto Bonbon</title><!-- イベントタイトル挿入 -->


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

  </header>

  <body>
    <!-- 【トップ】画像表示-->
    <section class="parallax-window" data-parallax="scroll" data-image-src="e_pic_path/松ぼん6.jpg" data-natural-width="1000" data-natural-height="470">
        <!-- ＊画像データINSERT -->
        <div class="parallax-content-2">
            <div class="container">
                <div class="row">
                    <div class="col-md-7 col-sm-7">
                        <h1><?php e($event_data['e_name']) ?></h1>
                        <span><?php e($event_data['e_prefecture']) ?></span>
                    </div>
                    <div class="col-md-4 col-sm-4" style="font-size: 60px;">
                        <span><sup style="font-size: 20px;">Sat</sup><?php e($event_data['e_start_date']) ?> ~ <?php e($event_data['e_end_date']) ?></span> <!-- ＊曜日・開催日時INSERT -->
                        <span class="favorites"><i class="icon-heart" style="color: red;" value="125"></i></span> <!-- ＊お気に入り数 INSERT -->
                    </div>
                    <div class="col-md-1 col-sm-1">
                        <a class="btn-danger" href="" aria-expanded="false" width="40px" height="20px">♡</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End section -->

    <main style="margin-bottom: 1000px;"> <!--  -->

        <div class="container margin_60">
            <div class="row">
                <div class="col-md-8">
                    <p class="visible-sm visible-xs"><a class="btn_map" data-toggle="collapse" href="#collapseMap" aria-expanded="false" aria-controls="collapseMap" data-text-swap="Hide map" data-text-original="Confirm to eve tomo">Confirm to eve tomo</a>
                    </p>
                    <!-- Map button for tablets/mobiles -->



                    <div id="Img_carousel" class="slider-pro">
                        <div class="sp-slides">

                            <div class="sp-slide">
                                <img class="sp-image" src="../../event_pictures/<?php e($event_data['e_pic_path']) ?>"
                                >
                            </div>



                        </div>

                        <div class="sp-thumbnails">
                            <img class="sp-thumbnail" src="e_pic_path/松ぼん1.jpg">
                            <img class="sp-thumbnail" src="e_pic_path/松ぼん2.jpg">
                            <img class="sp-thumbnail" src="e_pic_path/松ぼん3.jpg">
                            <img class="sp-thumbnail" src="e_pic_path/松ぼん4.jpg">
                            <img class="sp-thumbnail" src="e_pic_path/松ぼん5.jpg">
                            <img class="sp-thumbnail" src="e_pic_path/松ぼん6.jpg">
                            <img class="sp-thumbnail" src="e_pic_path/松ぼん7.jpg">
                            <img class="sp-thumbnail" src="e_pic_path/松ぼん8.jpg">
                            <img class="sp-thumbnail" src="e_pic_path/松ぼん9.jpg">
                            <img class="sp-thumbnail" src="e_pic_path/松ぼん10.jpg">
                        </div>
                    </div>

                    <hr>

                    <!-- 以下、イベント説明 -->
                    <div class="row">
                        <div class="col-md-3">
                            <h3>Event Description</h3>
                        </div>
                        <div class="col-md-9">
                            <p>
                             <?php e($event_data['explanation']) ?>
                         </p>
                     </div>
                 </div> <!-- End row  -->

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
                                        <td>
                                            Event Name 
                                        </td>
                                        <td>
                                            <?php e($event_data['e_name']) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>                                        
                                            Category
                                        </td>
                                        <td>
                                            <!-- カテゴリ表示 -->
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Date
                                        </td>
                                        <td>
                                            <?php e($event_data['e_start_date']) ?> ~ <?php e($event_data['e_end_date']) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            city
                                        </td>
                                        <td>
                                            <?php e($event_data['e_prefecture']) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            the place (follow on map)
                                        </td>
                                        <td>
                                            <?php e($event_data['e_venue']) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Web page
                                        </td>
                                        <td>
                                            <?php e($event_data['official_url']) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Acces
                                        </td>
                                        <td>
                                            <!-- アクセス方法表示 -->
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
                                        <td>
                                            <?php e($event_data['year_p']) ?>
                                        </td>
                                        <td>
                                            <?php e($event_data['attendance_p']) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <?php e($event_data['year_pp']) ?>
                                        </td>
                                        <td>
                                            <?php e($event_data['attendance_p']) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <?php e($event_data['year_ppp']) ?>
                                        </td>
                                        <td>
                                            <?php e($event_data['attendance_p']) ?>
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
                        <!--　地図表示 -->
                    </div>
                </div>

                <hr>
                <div class="row">
                    <div class="col-md-3">
                        <h3>Reviews </h3>
                    </div>
                    <div class="col-md-9">
                        <div id="general_rating" class="rating">3 Reviews                   
                            <i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star"></i><i class="icon-star"></i>
                            <a href="#" class="btn_1 add_bottom_30" data-toggle="modal" data-target="#myReview">Leave a review</a>
                        </div>
                        <!-- End general_rating -->
                        <hr>
                        <div class="review_strip_single">
                            <img src="img/spongebob.jpg" alt="Image" class="img-circle" width="70px" height="70px">
                            <h4>Sponge Bob</h4>
                            <div class="rating">
                                <i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i>
                            </div>
                            <small> - 10 August 2016 -</small>

                            <p>
                                "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed a lorem quis neque interdum consequat ut sed sem. Duis quis tempor nunc. Interdum et malesuada fames ac ante ipsum primis in faucibus."
                            </p>

                        </div>
                        <!-- End review strip -->

                        <div class="review_strip_single">
                            <img src="img/patrick.png" alt="Image" class="img-circle" width="70px" height="70px">
                            <small> - 10 August 2016 -</small>
                            <h4>Patrick</h4>
                            <p>
                                "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed a lorem quis neque interdum consequat ut sed sem. Duis quis tempor nunc. Interdum et malesuada fames ac ante ipsum primis in faucibus."
                            </p>
                            <div class="rating">
                                <i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i>
                            </div>
                        </div>
                        <!-- End review strip -->

                        <div class="review_strip_single last">
                            <img src="img/squidward.jpg" alt="Image" class="img-circle" width="70px" height="70px"> 
                            <small> - 10 August 2016 -</small>
                            <h4>Squidward</h4>
                            <p>
                                "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed a lorem quis neque interdum consequat ut sed sem. Duis quis tempor nunc. Interdum et malesuada fames ac ante ipsum primis in faucibus."
                            </p>
                            <div class="rating">
                                <i class="icon-star voted"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i>
                            </div>
                        </div>
                        <div align="center">
                            <a href="#" class="btn_1 add_bottom_30" data-toggle="modal" data-target="#myReview">See all review</a>
                        </div>

                        <!-- End review strip -->
                    </div>
                </div>
            </div>
            <!--End  single_tour_desc-->

            <aside class="col-md-4">
                <div class="row">
                    <div id="eve_info" class="box_style_1 expose">
                        <h3 class="inner">Information</h3>
                        <div id="scroll" class="info">
                            <?php e($notification['comment']) ?>
                        </div>
                    </div>

                    <div id="eve_tomo" class="box_style_1 expose">
                        <h3 class="inner">Eve tomo</h3>
                        <div class="eve_tomo">
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label><i class="icon-globe"></i>Nationality</label>
                                    <div class="styled-select">
                                        <select class="form-control" name="currency" id="currency">
                                            <option value="not specified" selected>not specified</option>
                                            <option value="Japan">Japan</option>
                                            <option value="Philippine">Philippine</option>
                                            <option value="Afghanistan">Afghanistan</option>
                                            <option value="Albanie">Albanie</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label><i class=" icon-language"></i>Language</label>
                                    <div class="styled-select">
                                        <select class="form-control" name="currency" id="currency">
                                            <option value="not specified" selected>not specified</option>
                                            <option value="Japanese">Japanese</option>
                                            <option value="Tagalog">Tagalog</option>
                                            <option value="English">English</option>
                                            <option value="Tagalog">Tagalog</option>
                                        </select>
                                    </div>

                                </div>
                            </div>
                        </div><hr>

                        <div class="eve_tomo" class="scr">
                            <div id="profile">

                                <div class="profile 1">
                                    <div class="col-md-5 col-sm-5">
                                        <img src="img/spongebob.jpg" alt="Image" class="img-circle" width="80px" height="80px">
                                    </div>
                                    <div class="col-md-7 col-sm-7" align="center">
                                        <h3>Sponge Bob</h3> 
                                        <img src="img/japan.png" width="32px" height="20px"> <!-- 国籍(国旗)表示 -->
                                        <p>JP/EN</p> <!-- 対応可能言語表示 -->
                                    </div>
                                </div>
                                <div class="purpose">
                                    <div class="purpose title">Purpose:</div>
                                    <div class="purpose content">この祭りのガイドをしてもらいたいです！</div>
                                </div>
                                <div class="button">
                                   <!-- 個人詳細ページに戦遷移 -->
                                   <div class="col-md-6 col-sm-6">
                                    <a class="btn_full" href="profile.html"><i class=" icon-user"></i>Profile</a>
                                </div>
                                <!-- チャットページに遷移 -->
                                <div class="col-md-6 col-sm-6">
                                    <a class="btn_full_outline" href="chat"><i class=" icon-chat"></i>Chat</a>
                                </div>
                            </div>
                        </div>

                        <hr>

                    </div>
                    <!--/box_style_1 -->

                    <!-- マッチング希望ボタン -->
                    <p>
                        <a class="btn_map" data-toggle="collapse" href="" aria-expanded="false" aria-controls="collapseMap" data-text-swap="Cancel" data-text-original="Confirm to eve tomo">Confirm to eve tomo</a>
                    </p>
                    <!-- 終了タグ　マッチング希望ボタン -->
                </div>
            </aside>
        </div>
        <!--End row -->
    </div>
    <!--End container -->

    <div id="overlay"></div>
    <!-- Mask on input focus -->

</main>
<!-- End main -->

<footer class="revealed">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-sm-3">
                <h3>Need help?</h3>
                <a href="tel://004542344599" id="phone">+45 423 445 99</a>
                <a href="mailto:help@citytours.com" id="email_footer">help@citytours.com</a>
            </div>
            <div class="col-md-3 col-sm-3">
                <h3>About</h3>
                <ul>
                    <li><a href="#">About us</a></li>
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Login</a></li>
                    <li><a href="#">Register</a></li>
                    <li><a href="#">Terms and condition</a></li>
                </ul>
            </div>
            <div class="col-md-3 col-sm-3">
                <h3>Discover</h3>
                <ul>
                    <li><a href="#">Community blog</a></li>
                    <li><a href="#">Tour guide</a></li>
                    <li><a href="#">Wishlist</a></li>
                    <li><a href="#">Gallery</a></li>
                </ul>
            </div>
            <div class="col-md-2 col-sm-3">
                <h3>Settings</h3>
                <div class="styled-select">
                    <select class="form-control" name="lang" id="lang">
                        <option value="English" selected>English</option>
                        <option value="French">Japanese</option>
                    </select>
                </div>
            </div>
        </div><!-- End row -->
        <div class="row">
            <div class="col-md-12">
                <div id="social_footer">
                    <ul>
                        <li><a href="#"><i class="icon-facebook"></i></a></li>
                        <li><a href="#"><i class="icon-twitter"></i></a></li>
                        <li><a href="#"><i class="icon-google"></i></a></li>
                        <li><a href="#"><i class="icon-instagram"></i></a></li>
                        <li><a href="#"><i class="icon-pinterest"></i></a></li>
                        <li><a href="#"><i class="icon-vimeo"></i></a></li>
                        <li><a href="#"><i class="icon-youtube-play"></i></a></li>
                        <li><a href="#"><i class="icon-linkedin"></i></a></li>
                    </ul>
                    <p>© Japanival 2017</p>
                </div>
            </div>
        </div><!-- End row -->
    </div><!-- End container -->
</footer><!-- End footer -->

<div id="toTop"></div><!-- Back to top button -->

<!-- Search Menu -->
<div class="search-overlay-menu">
    <span class="search-overlay-close"><i class="icon_set_1_icon-77"></i></span>
    <form role="search" id="searchform" method="get">
        <input value="" name="q" type="search" placeholder="Search..." />
        <button type="submit"><i class="icon_set_1_icon-78"></i>
        </button>
    </form>
</div><!-- End Search Menu -->

<!-- Modal Review -->
<div class="modal fade" id="myReview" tabindex="-1" role="dialog" aria-labelledby="myReviewLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myReviewLabel">Write your review</h4>
            </div>
            <div class="modal-body">
                <div id="message-review">
                </div>
                <form method="post" action="assets/review_tour.php" name="review_tour" id="review_tour">

                    <!-- End row -->
                    
                    <!-- End row -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Position</label>
                                <select class="form-control" name="position_review" id="position_review">
                                    <option value="">Please review</option>
                                    <option value="Low">Low</option>
                                    <option value="Sufficient">Sufficient</option>
                                    <option value="Good">Good</option>
                                    <option value="Excellent">Excellent</option>
                                    <option value="Superb">Super</option>
                                    <option value="Not rated">I don't know</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- End row -->

                    <!-- End row -->
                    <div class="form-group">
                        <textarea name="review_text" id="review_text" class="form-control" style="height:100px" placeholder="Write your review"></textarea>
                    </div>
                    <div class="form-group">
                        <input type="button" name="picture" value=写真の選択>
                    </div>

                    <input type="submit" value="Submit" class="btn_1" id="submit-review">
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End modal review -->

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
</body>
</html>