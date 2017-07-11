<?php  

session_start();

// echo '<pre>';
//  var_dump($_SESSION['event']['e_pic_path']);
//  echo '</pre>';

require('../../common/dbconnect.php');
require('../../common/functions.php');

$login_user = get_login_user($dbh);

// echo '<pre>';
// var_dump($_SESSION['event']);
// echo '</pre>';


// sessionを持たない状態で直接、このページに来た時には、event_input.phpに自動遷移
if(!isset($_SESSION['event'])){
    header('Location: event_input.php');
    exit();

//emptyは箱があって、値が入っているかどうか？
//issetはそもそも箱があるかどうか。
}


//会員登録ボタンが押された際の処理
if(!empty($_POST)){

    $sql = 'INSERT INTO events
    SET e_name = ?,
    e_start_date = ?,
    e_end_date = ?,
    e_prefecture = ?,
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
    $event_id = $events_stmt->fetch(PDO::FETCH_ASSOC);


// newsテーブルへの登録
    $sql = 'INSERT INTO news
    SET event_id= ?,
    news_comment = ?,
    created = NOW()';

    $data = [ $event_id,$_SESSION['event']['news_comment']];
    $news_comment_stmt = $dbh->prepare($sql);
    $news_comment_stmt->execute($data);


// event_picsテーブルへの登録
    $sql = 'INSERT INTO event_pics
    SET event_id= ?,
    e_pic_path = ?,
    created = NOW()';

    $data = [ $event_id,$_SESSION['event']['e_pic_path']];
    $event_pics_stmt = $dbh->prepare($sql);
    $event_pics_stmt->execute($data);

// echo '<pre>';
// var_dump($_SESSION['event']['e_pic_path']);
// echo '</pre>';

// unset($_SESSION['event']);
//TODO!:なんでunsetなんだっけ？

    header('Location: event_thanks.php');
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

    <section class="parallax-window" data-parallax="scroll" data-image-src="<?php echo $_SESSION['event']['e_pic_path'][0];?>" data-natural-width="1400" data-natural-height="470">
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
                            <div style="word-wrap: break-word; width:99%; height:300px;">
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
                                                the place (follow on map)
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
                                    <form method="POST" action="event_input.php" enctype="multipart/form-data">
                                        <input class="btn btn-primary" type="submit" value="確認">
                                    </form>
                                </div>
                                <div style="display: inline-block;">
                                    <a href="event_input.php?action=rewrite" class="btn btn-primary">書き直す</a>
                                </div>
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

                <aside class="col-md-4">
                    <div>

                        <div class="box_style_ume"><!-- //TODO!:変更前 class="box_style_1 expose" -->
                            
                            <h3 class="inner">Information</h3>
                            <div>
                                ニュース登録日
                                <input type="date" class="form-control" name="news_date" value= "<?php echo htmlspecialchars($e_start_date); ?>" style="margin-right: 5px; margin-bottom: 5px;">
                                ニュース記載欄
                                <textarea name="news_comment" class="form-control"  placeholder = "こちらにイベント情報（ニュース）を入力してください">
                                    <?php echo htmlspecialchars($news_comment); ?>
                                </textarea>
                            </div>

                        </div>

                        <div id="eve_tomo" class="box_style_1">
                            <h3 class="inner" style="margin-bottom: 5px;">Requests!!</h3>
                            <div class="requests" style="margin-bottom: 0px;">
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label>
                                                <i class="icon-globe"></i>Nationality
                                            </label>
                                            <div class="styled-select">
                                                <select class="form-control" name="nationarity" id="nationarity">
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
                                            <label>
                                                <i class="icon-language"></i>Language
                                            </label>
                                            <div class="styled-select">
                                                <select class="form-control" name="language" id="language">
                                                    <option value="not specified" selected>not specified</option>
                                                    <option value="Japanese">Japanese</option>
                                                    <option value="Tagalog">Tagalog</option>
                                                    <option value="English">English</option>
                                                    <option value="Tagalog">Tagalog</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr style="margin-bottom: 0px; margin-top: 0px;">

                                <div class="row" style=" border-radius: 3px; padding: 10px; padding-bottom: 5px; margin-top: 10px; box-shadow:0 0 5px #fff, 0 0 5px #ccc, 0 0 1px #aaa; ">
                                    <div >
                                                
                                        <div class="col-md-6 col-sm-6" style="padding-left: 0; padding-top: 5px;">
                                            <div style="text-align: center">
                                                <img src="img/spongebob.jpg" alt="Image" class="img-circle" width="95px" height="95px" >
                                            </div>
                                            <h4 style="margin-top: 0px; text-align: center; margin-bottom: 5px;">Sponge Bob</h4>
                                            <div style="text-align: center">
                                                <img src="img/japan.png" width="32px" height="20px"> <!-- 国籍(国旗)表示 -->
                                                <div>Language : JP/EN</div> <!-- 対応可能言語表示 -->
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6" align="center" style="padding : 0px;">
                                            <div class="button">
                                                <!-- 個人詳細ページに遷移 -->
                                                <div class="col-md-12 col-sm-12" style="padding : 0px; ">
                                                    <a class="btn_full" href="profile.html" style="padding : 0px; height: 40px;line-height: 40px;"><i class=" icon-user" ></i>Profile</a>
                                                </div>
                                                <!-- チャットページに遷移 -->
                                                <div class="col-md-12 col-sm-12" style="padding : 0px; ">
                                                    <div class="panel panel-danger" style="margin-bottom: 5px;">
                                                        <div class="panel-heading" style="padding : 10px; ">
                                                            <div style="margin-bottom: 5px;">
                                                                Request Category
                                                            </div>
                                                            <div style="font-weight: 900; font-size: 24px; margin-bottom: 5px;">
                                                                <a href="" class="text-danger" style="text-decoration:underline; ">GUIDE</a>
                                                            </div>
                                                        </div>
                                                        <div class="panel-body" style="padding : 5px">
                                                            <a class="btn_full_outline" href="chat" style="padding : 0px; height: 40px;line-height: 40px;"><i class=" icon-chat"></i>Chat</a>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </aside>
            </div>
        </div>
        <!--End container -->
        <div id="overlay"></div>
        <!-- Mask on input focus -->
    </div>
</main>
<!-- End main -->

<footer><!-- //TODO!:元はclass名revealed -->
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


<script src="js/custom.js"></script>


</body>
</html>