<?php  
  
session_start();
require('../../common/dbconnect.php');
require('../../common/functions.php');

$login_user = get_login_user($dbh);




  // sessionを持たない状態で直接、このページに来た時には、event_input_index.phpに自動遷移
  if(!isset($_SESSION['event'])){
    header('Location: event_input.php');
  exit();

  //emptyは箱があって、値が入っているかどうか？
  //issetはそもそも箱があるかどうか。
  }

  //会員登録ボタンが押された際の処理
  if(!empty($_POST)){

  // echo '<pre>';
  // var_dump($_POST);
  // echo '</pre>';
    // eventsテーブルへの登録
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
            // $_SESSION['event']['e_postal'],
            // $_SESSION['event']['e_address'],
            $_SESSION['event']['e_venue'],
            // $_SESSION['event']['e_o_name'],
            // $_SESSION['event']['e_o_tel'],
            // $_SESSION['event']['e_o_email'],
            $_SESSION['event']['explanation'],
            $_SESSION['event']['e_access'],
            // $_SESSION['event']['priority'],
            // $_SESSION['event']['start_year'],
            $_SESSION['event']['year_p'],
            $_SESSION['event']['year_pp'],
            $_SESSION['event']['year_ppp'],
            // $_SESSION['event']['attendance_p'],
            // $_SESSION['event']['attendance_pp'],
            // $_SESSION['event']['attendance_ppp'],
            $_SESSION['event']['official_url']];
            // $_SESSION['event']['related_url']];
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

      echo '<pre>';
      var_dump($_SESSION['event']['e_pic_path']);
      echo '</pre>';


    unset($_SESSION['event']);
    //TODO!:なんでunsetなんだっけ？


    header('Location: ../layout/event_detail.php');
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

    <!-- 大澤：なんの機能かよくわからないが消しても問題なし。消すのは怖いので、コメントアウト -->
	<!-- <div id="preloader">
		<div class="sk-spinner sk-spinner-wave">
			<div class="sk-rect1"></div>
			<div class="sk-rect2"></div>
			<div class="sk-rect3"></div>
			<div class="sk-rect4"></div>
			<div class="sk-rect5"></div>
		</div>
	</div> -->
    <!-- End Preload -->

	<div class="layer"></div>
	<!-- Mobile menu overlay mask -->

    <!-- Header================================================== -->

    <!-- header.phpのrequire -->
    <?php require('header.php');  ?>

    <!-- End Header -->

    <section class="parallax-window" data-parallax="scroll" data-image-src="<?php echo '../../event_pictures/' . $_SESSION['event']['e_pic_path'][0]; ?>" data-natural-width="1400" data-natural-height="470">
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


<form method="POST" action="event_input.php" enctype="multipart/form-data">
        <div class="collapse" id="collapseMap">
            <div id="map" class="map"></div>
        </div>
        <!-- End Map -->

        <div class="container margin_60">
            <div class="row">
                <div class="col-md-8">
                    <p class="visible-sm visible-xs"><a class="btn_map" data-toggle="collapse" href="#collapseMap" aria-expanded="false" aria-controls="collapseMap" data-text-swap="Hide map" data-text-original="Confirm to eve tomo">Confirm to eve tomo</a>
                    </p>
                    <!-- Map button for tablets/mobiles -->



          <div id="Img_carousel" class="slider-pro" style="margin-bottom: 10px;">
            <div class="sp-slides">

              <div class="sp-slide">
                <img alt="Image" class="sp-image" src="css/images/blank.gif" data-src="img/slider_single_tour/1_medium.jpg" data-small="img/slider_single_tour/1_small.jpg" data-medium="img/slider_single_tour/1_medium.jpg" data-large="img/slider_single_tour/1_large.jpg" data-retina="img/slider_single_tour/1_large.jpg">
              </div>
              <div class="sp-slide">
                <img alt="Image" class="sp-image" src="css/images/blank.gif" data-src="img/slider_single_tour/2_medium.jpg" data-small="img/slider_single_tour/2_small.jpg" data-medium="img/slider_single_tour/2_medium.jpg" data-large="img/slider_single_tour/2_large.jpg" data-retina="img/slider_single_tour/2_large.jpg">
                <h3 class="sp-layer sp-black sp-padding" data-horizontal="40" data-vertical="40" data-show-transition="left">
                        Lorem ipsum dolor sit amet </h3>
                <p class="sp-layer sp-white sp-padding" data-horizontal="40" data-vertical="100" data-show-transition="left" data-show-delay="200">
                  consectetur adipisicing elit
                </p>
                <p class="sp-layer sp-black sp-padding" data-horizontal="40" data-vertical="160" data-width="350" data-show-transition="left" data-show-delay="400">
                  sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                </p>
              </div>

              <div class="sp-slide">
                <img alt="Image" class="sp-image" src="css/images/blank.gif" data-src="img/slider_single_tour/3_medium.jpg" data-small="img/slider_single_tour/3_small.jpg" data-medium="img/slider_single_tour/3_medium.jpg" data-large="img/slider_single_tour/3_large.jpg" data-retina="img/slider_single_tour/3_large.jpg">
                <p class="sp-layer sp-white sp-padding" data-position="centerCenter" data-vertical="-50" data-show-transition="right" data-show-delay="500">
                  Lorem ipsum dolor sit amet
                </p>
                <p class="sp-layer sp-black sp-padding" data-position="centerCenter" data-vertical="50" data-show-transition="left" data-show-delay="700">
                  consectetur adipisicing elit
                </p>
              </div>

              <div class="sp-slide">
                <img alt="Image" class="sp-image" src="css/images/blank.gif" data-src="img/slider_single_tour/4_medium.jpg" data-small="img/slider_single_tour/4_small.jpg" data-medium="img/slider_single_tour/4_medium.jpg" data-large="img/slider_single_tour/4_large.jpg" data-retina="img/slider_single_tour/4_large.jpg">
                <p class="sp-layer sp-black sp-padding" data-position="bottomLeft" data-vertical="0" data-width="100%" data-show-transition="up">
                  Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                </p>
              </div>

              <div class="sp-slide">
                <img alt="Image" class="sp-image" src="css/images/blank.gif" data-src="img/slider_single_tour/5_medium.jpg" data-small="img/slider_single_tour/5_small.jpg" data-medium="img/slider_single_tour/5_medium.jpg" data-large="img/slider_single_tour/5_large.jpg" data-retina="img/slider_single_tour/5_large.jpg">
                <p class="sp-layer sp-white sp-padding" data-vertical="5%" data-horizontal="5%" data-width="90%" data-show-transition="down" data-show-delay="400">
                  Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                </p>
              </div>

              <div class="sp-slide">
                <img alt="Image" class="sp-image" src="css/images/blank.gif" data-src="img/slider_single_tour/6_medium.jpg" data-small="img/slider_single_tour/6_small.jpg" data-medium="img/slider_single_tour/6_medium.jpg" data-large="img/slider_single_tour/6_large.jpg" data-retina="img/slider_single_tour/6_large.jpg">
                <p class="sp-layer sp-white sp-padding" data-horizontal="10" data-vertical="10" data-width="300">
                  Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                </p>
              </div>

              <div class="sp-slide">
                <img alt="Image" class="sp-image" src="css/images/blank.gif" data-src="img/slider_single_tour/7_medium.jpg" data-small="img/slider_single_tour/7_small.jpg" data-medium="img/slider_single_tour/7_medium.jpg" data-large="img/slider_single_tour/7_large.jpg" data-retina="img/slider_single_tour/7_large.jpg">
                <p class="sp-layer sp-black sp-padding" data-position="bottomLeft" data-horizontal="5%" data-vertical="5%" data-width="90%" data-show-transition="up" data-show-delay="400">
                  Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                </p>
              </div>

              <div class="sp-slide">
                <img alt="Image" class="sp-image" src="css/images/blank.gif" data-src="img/slider_single_tour/8_medium.jpg" data-small="img/slider_single_tour/8_small.jpg" data-medium="img/slider_single_tour/8_medium.jpg" data-large="img/slider_single_tour/8_large.jpg" data-retina="img/slider_single_tour/8_large.jpg">
                <p class="sp-layer sp-black sp-padding" data-horizontal="50" data-vertical="50" data-show-transition="down" data-show-delay="500">
                  Lorem ipsum dolor sit amet
                </p>
                <p class="sp-layer sp-white sp-padding" data-horizontal="50" data-vertical="100" data-show-transition="up" data-show-delay="500">
                  consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                </p>
              </div>

              <div class="sp-slide">
                <img alt="Image" class="sp-image" src="css/images/blank.gif" data-src="img/slider_single_tour/9_medium.jpg" data-small="img/slider_single_tour/9_small.jpg" data-medium="img/slider_single_tour/9_medium.jpg" data-large="img/slider_single_tour/9_large.jpg" data-retina="img/slider_single_tour/9_large.jpg">
              </div>
            </div>
            <div class="sp-thumbnails">
              <img alt="Image" class="sp-thumbnail" src="img/slider_single_tour/1_medium.jpg">
              <img alt="Image" class="sp-thumbnail" src="img/slider_single_tour/2_medium.jpg">
              <img alt="Image" class="sp-thumbnail" src="img/slider_single_tour/3_medium.jpg">
              <img alt="Image" class="sp-thumbnail" src="img/slider_single_tour/4_medium.jpg">
              <img alt="Image" class="sp-thumbnail" src="img/slider_single_tour/5_medium.jpg">
              <img alt="Image" class="sp-thumbnail" src="img/slider_single_tour/6_medium.jpg">
              <img alt="Image" class="sp-thumbnail" src="img/slider_single_tour/7_medium.jpg">
              <img alt="Image" class="sp-thumbnail" src="img/slider_single_tour/8_medium.jpg">
              <img alt="Image" class="sp-thumbnail" src="img/slider_single_tour/9_medium.jpg">
            </div>
          </div>


					<hr>

                    <!-- 以下、イベント説明 -->
                    <div class="row">
                      <div class="col-md-3">
                        <h3>Event Description</h3>
                      </div>
                        <div class="col-md-9">
                          <div style="width:99%; height:300px;">
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
                <input class="btn btn-primary" type="submit" value="確認">
                            </div>
                        </div>
                    </div>

          <hr>
</form>

          <div class="row">
              <div class="col-md-3">
                  <h3>Map</h3>
              </div>
              <div class="col-md-9">
                  <img src="img/SuperScreenshot 2017-7-3 12-49-11.png" width="550px" height="400px">
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
                        <div id="eve_info" class="box_style_1"><!-- //TODO!:変更前 class="box_style_1 expose" -->
                            <h3 class="inner">Information</h3>
                            <div id="scroll" class="info">
                              <div>
                                ニュース登録日
                                <input type="date" class="form-control" name="news_date" value= "<?php echo htmlspecialchars($e_start_date); ?>">
                                ニュース記載欄
                                <textarea name="news_comment" class="form-control"  placeholder = "こちらにイベント情報（ニュース）を入力してください"><?php echo htmlspecialchars($news_comment); ?></textarea>
                              </div>
                            </div>
                        </div>

                        <div id="eve_tomo" class="box_style_1">
                            <h3 class="inner">Eve tomo</h3>
                                <div class="eve_tomo">
                      <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label><i class="icon-globe"></i>Nationality</label>
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
                                            <label><i class="icon-language"></i>Language</label>
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
                      <div class="row">
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
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="purpose">
                            <div class="purpose title">Purpose:</div>
                            <div class="purpose content">この祭りのガイドをしてもらいたいです！</div>
                        </div>
                      </div>
                      <div class="row">
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
                          </div>
                        <!--/box_style_1 -->

                        <!-- マッチング希望ボタン -->
                    <div>
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

    <div id="toTop"></div><!-- Back to top button -->
    


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
                        <input name="tour_name" id="tour_name" type="hidden" value="Paris Arch de Triomphe Tour">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input name="name_review" id="name_review" type="text" placeholder="Your name" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input name="lastname_review" id="lastname_review" type="text" placeholder="Your last name" class="form-control">
                                </div>
                            </div>
                        </div>
                        <!-- End row -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input name="email_review" id="email_review" type="email" placeholder="Your email" class="form-control">
                                </div>
                            </div>
                        </div>
                        <!-- End row -->
                        <hr>
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tourist guide</label>
                                    <select class="form-control" name="guide_review" id="guide_review">
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
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Price</label>
                                    <select class="form-control" name="price_review" id="price_review">
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Quality</label>
                                    <select class="form-control" name="quality_review" id="quality_review">
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
                        <div class="form-group">
                            <textarea name="review_text" id="review_text" class="form-control" style="height:100px" placeholder="Write your review"></textarea>
                        </div>
                        <div class="form-group">
                            <input type="text" id="verify_review" class=" form-control" placeholder="Are you human? 3 + 1 =">
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


  <script src="js/custom.js"></script>

  <?php var_dump($_SESSION['event']['e_name']); ?>


</body>
</html>