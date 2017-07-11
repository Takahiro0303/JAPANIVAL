<?php 
session_start();
require('../../common/dbconnect.php');
require('../../common/functions.php');
$login_user = get_login_user($dbh);

$o_name = $login_user['o_name'];
$o_f_name = $login_user['o_f_name'];
$o_postal = $login_user['o_postal'];
$o_pref = $login_user['o_pref'];
$o_address = $login_user['o_address'];
$o_tel = $login_user['o_tel'];
$o_email = $login_user['o_email'];
$o_intro = $login_user['o_intro'];
$errors = [];

if (!empty($_POST)) {
    $o_current_password = sha1($_POST['o_current_password']);
    if ($o_current_password == $login_user['o_password']) {
        //現在のパスワードが一致する場合
        
        $o_name = $_POST['o_name'];
        $o_f_name = $_POST['o_f_name'];
        $o_postal = $_POST['o_postal'];
        $o_pref = $_POST['o_pref'];
        $o_address = $_POST['o_address'];
        $o_tel = $_POST['o_tel'];
        $o_email = $_POST['o_email'];
        $o_intro = $_POST['o_intro'];        

        if ($o_f_name == '') {
            $errors['o_f_name'] = 'blank';
        }
        if ($o_email == '') {
            $errors['o_email'] = 'blank';
        }
        if ($o_postal == 'o_postal') {
            $errors['o_postal'] = 'blank';
        }
        if ($o_pref == 'o_pref') {
            $errors['o_pref'] = 'blank';
        }
        if ($o_address == 'o_address') {
            $errors['o_address'] = 'blank';
        }
        if ($o_tel == 'o_tel') {
            $errors['o_tel'] = 'blank';
        }
        if ($o_email == 'o_email') {
            $errors['o_email'] = 'blank';
        }
        if ($o_intro == 'o_intro') {
            $errors['o_intro'] = 'blank';
        }

        if (!empty($_POST['o_new_password'])) {
            //o_new_passwordが空じゃない時
            if (strlen($_POST['o_new_password']) >= 6) {
                $o_new_password = $_POST['o_new_password'];
                $o_confirm_password = $_POST['o_confirm_password'];
                if ($o_new_password != $o_confirm_password) {
                    //new_passwordとconfirm_passwordが一致しなかった場合
                    $errors['o_confirm_password'] = 'wrong';
                }
            } else {
                $errors['o_new_password'] = 'length';
            }  
        }

        $file_name = $_FILES['o_pic']['o_name'];
        if (!empty($file_name)) {
            //画像が選択されていた場合
            $ext = substr($file_name, -3);
            $ext = strtolower($ext);
            if ($ext != 'jpg' && $ext != 'png' && $ext != 'gif') {
                $errors['o_pic'] = 'type';
            }
        }
    } else {
        $errors['o_current_password'] = 'failed';
    }

    if (empty($errors)) {
        //もし画像がセットされていればUP処理
        if (!empty($file_name)) {
            $data_str = date('YmdHis');
            $submit_file_name = $date_str . $_FILES['o_pic']['o_name'];
            move_uploaded_file($_FILES['o_pic']['tmp_name'], '../../o_pic/' . $submit_file_name);
        }

        //データベース更新
        if (empty($o_new_password)) {
            $o_password = $o_current_password;
        } else {
            $o_password = sha1($o_new_password);
        }

        if (empty($file_name)) {
            $submit_file_name = $login_user['o_pic'];
        }

        $sql = 'UPDATE organizers SET o_name=?,
                                      o_f_name=?,
                                      o_postal=?,
                                      o_pref=?,
                                      o_address=?,
                                      o_tel=?,
                                      o_email=?,
                                      o_password=?,
                                      o_intro=?,
                                      o_pic=?,
                                      modified=NOW()
                                WHERE o_id=?';
        $data = [$o_name,
                 $o_f_name,
                 $o_postal,
                 $o_pref,
                 $o_address,
                 $o_tel,
                 $o_email,
                 $o_password,
                 $o_intro,
                 $submit_file_name,
                 $login_user['o_id']];
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);

        header('Location:admin_organizer.php');
        exit();
    }    
}

$e_sql = 'SELECT e.*, e.e_name,e.e_start_date FROM events e,organizers o WHERE e.o_id=o.o_id ORDER BY e.created DESC';
$e_stmt = $dbh->prepare($e_sql);
$e_stmt->execute();

$events = array();

while ($e_record = $e_stmt->fetch(PDO::FETCH_ASSOC)) {
  $events[] = $e_record;
  
}
    
var_dump($events);

$count = count($events);
   
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

  <!-- SPECIFIC CSS -->
  <link href="css/admin.css" rel="stylesheet">
  <link href="css/jquery.switch.css" rel="stylesheet">
  <link href="css/slider-pro.min.css" rel="stylesheet">
  <link href="css/date_time_picker.css" rel="stylesheet">

  <!--[if lt IE 9]>
      <script src="js/html5shiv.min.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->

</head>
<body>

  <!--[if lte IE 8]>
    <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a>.</p>
<![endif]-->

  <div id="preloader">
    <div class="sk-spinner sk-spinner-wave">
      <div class="sk-rect1"></div>
      <div class="sk-rect2"></div>
      <div class="sk-rect3"></div>
      <div class="sk-rect4"></div>
      <div class="sk-rect5"></div>
    </div>
  </div>
  <!-- End Preload -->

  <div class="layer"></div>
  <!-- Mobile menu overlay mask -->

  <!-- Header================================================== -->
  <!-- header.phpのrequire -->
  <?php require('header.php');  ?>  
  <!-- End Header -->

  <section class="parallax-window" data-parallax="scroll" data-image-src="img/admin_top.jpg" data-natural-width="1400" data-natural-height="470">
    <div class="parallax-content-1">
      <div class="animated fadeInDown">
        <h1>Hello Clara!</h1>
        <p>Ridiculus sociosqu cursus neque cursus curae ante scelerisque vehicula.</p>
      </div>
    </div>
  </section>
  <!-- End section -->

  <main>
    <div id="position">
      <div class="container">
        <ul>
          <li><a href="#">Home</a></li>
          <li><a href="#">Category</a></li>
          <li>Page active</li>
        </ul>
      </div>
    </div>
    <!-- End Position -->

    <div class="margin_60 container">      
      <h1 class="welcom">Welcome!</h1><br>
      
      <div id="tabs" class="tabs">
        <nav>
          <ul>
            <li><a href="#section-1" class="icon-calendar"><span>登録済みイベント一覧</span></a>
            </li>
            <li><a href="#section-2" class="icon-wishlist"><span>イベント登録</span></a>
            </li>
            <li><a href="#section-3" class="icon-back-in-time"><span>実施済みイベント </span></a>
            </li>
            <li><a href="#section-4" class="icon-hourglass"><span>Join the Past</span></a>
            </li>
            <li><a href="#section-5" class="icon-profile"><span>Profile</span></a>
            </li>
          </ul>
        </nav>
        <div class="content">

          <section id="section-1">
            <div id="tools">
              <div class="row">
                <div class="col-md-3 col-sm-3 col-xs-6">
                  <div class="styled-select-filters">
                    <select name="sort_type" id="sort_type">
                      <option value="" selected>イベント実施日 </option>
                      <option value="hotels">イベント登録</option>
                    </select>
                  </div>
                </div>                
              </div>
            </div>
            <!--/tools -->

            <div class="strip_booking">
              <div class="row">
                <div class="strip_all_tour_list wow fadeIn" data-wow-delay="0.1s">
                  <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-4">
                      <div class="ribbon_3 popular">
                        <span>Popular</span>
                      </div>
                      <div class="wishlist">
                        <a class="tooltip_flip tooltip-effect-1" href="javascript:void(0);">+<span class="tooltip-content-flip"><span class="tooltip-back">Add to wishlist</span></span></a>
                      </div>
                      <div class="img_list" >
                        <a href="single_tour.html"><img src="img/tour_box_1.jpg" alt="Image">
                        <div class="short_info"><i class="icon_set_1_icon-4"></i>Museums </div>
                        </a>
                      </div>
                    </div>
                    <div class="clearfix visible-xs-block"></div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                      <div class="tour_list_desc">
                        <div class="rating">
                        </div>
                          <h3><strong>イベント名</strong></h3>
                            <p>イベント詳細</p>
                      </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2">
                      <div class="price_list">
                        <div>
                          <p><a href="#0" class="btn_1">詳細</a></p><br> <!-- Takuya待ち -->
                          <p><a href="event_input.php" class="btn_1">編集</a> <!-- Ume待ち -->
                          </p>
                          
                        </div>

                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- End row -->

              <div class="row">
                <div class="strip_all_tour_list wow fadeIn" data-wow-delay="0.1s">
                  <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-4">
                      <div class="ribbon_3 popular">
                        <span>Popular</span>
                      </div>
                      <div class="wishlist">
                        <a class="tooltip_flip tooltip-effect-1" href="javascript:void(0);">+<span class="tooltip-content-flip"><span class="tooltip-back">Add to wishlist</span></span></a>
                      </div>
                      <div class="img_list" >
                        <a href="single_tour.html"><img src="img/tour_box_1.jpg" alt="Image">
                        <div class="short_info"><i class="icon_set_1_icon-4"></i>Museums </div>
                        </a>
                      </div>
                    </div>
                    <div class="clearfix visible-xs-block"></div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                      <div class="tour_list_desc">
                        <div class="rating"><i class="icon-smile voted"></i><i class="icon-smile  voted"></i><i class="icon-smile  voted"></i><i class="icon-smile  voted"></i><i class="icon-smile"></i><small>(75)</small>
                        </div>
                          <h3><strong>Arch Triomphe</strong> tour</h3>
                            <p>Lorem ipsum dolor sit amet, quem convenire interesset ut vix, ad dicat sanctus detracto vis. Eos modus dolorum ex, qui adipisci maiestatis inciderint no, eos in elit dicat.....</p>
                            <ul class="add_info">
                              <li>
                                <div class="tooltip_styled tooltip-effect-4">
                                  <span class="tooltip-item"><i class="icon_set_1_icon-83"></i></span>
                                    <div class="tooltip-content">
                                        <h4>Schedule</h4>
                                        <strong>Monday to Friday</strong> 09.00 AM - 5.30 PM
                                        <br>
                                        <strong>Saturday</strong> 09.00 AM - 5.30 PM
                                        <br>
                                        <strong>Sunday</strong> <span class="label label-danger">Closed</span>
                                    </div>
                                </div>
                              </li>
                              <li>
                                <div class="tooltip_styled tooltip-effect-4">
                                  <span class="tooltip-item"><i class="icon_set_1_icon-41"></i></span>
                                  <div class="tooltip-content">
                                    <h4>Address</h4> Musée du Louvre, 75058 Paris - France
                                    <br>
                                  </div>
                                </div>
                              </li>
                              <li>
                                <div class="tooltip_styled tooltip-effect-4">
                                  <span class="tooltip-item"><i class="icon_set_1_icon-97"></i></span>
                                  <div class="tooltip-content">
                                    <h4>Languages</h4> English - French - Chinese - Russian - Italian
                                  </div>
                                </div>
                              </li>
                              <li>
                                <div class="tooltip_styled tooltip-effect-4">
                                  <span class="tooltip-item"><i class="icon_set_1_icon-27"></i></span>
                                  <div class="tooltip-content">
                                    <h4>Parking</h4> 1-3 Rue Elisée Reclus
                                    <br> 76 Rue du Général Leclerc
                                    <br> 8 Rue Caillaux 94923
                                    <br>
                                  </div>
                                </div>
                              </li>
                              <li>
                                <div class="tooltip_styled tooltip-effect-4">
                                  <span class="tooltip-item"><i class="icon_set_1_icon-25"></i></span>
                                  <div class="tooltip-content">
                                    <h4>Transport</h4>
                                    <strong>Metro: </strong>Musée du Louvre station (line 1)
                                    <br>
                                    <strong>Bus:</strong> 21, 24, 27, 39, 48, 68, 69, 72, 81, 95
                                    <br>
                                  </div>
                                </div>
                              </li>
                            </ul>
                      </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2">
                      <div class="price_list">
                        <div><sup>$</sup>39*<span class="normal_price_list">$99</span><small>*Per person</small>
                          <p><a href="single_tour.html" class="btn_1">Details</a>
                          </p>
                        </div>

                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- End row -->            
            </div>
            <!-- End strip booking -->
          </section>
          <!-- End section 1 -->

          <section id="section-2">
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

            <div class="input-group">
                <label class="input-group-btn">
                    <span class="btn btn-primary">
                        Browse&hellip; <input type="file" style="display: none;" name="e_pic_path[]" multiple>
                    </span>
                </label>
                <input type="text" class="form-control" readonly>
            </div>
<!--                   <input type="file" class="btn btn-primary" name="e_pic_path[]" multiple> -->
                  <!-- <input type="submit" value="submit"> -->

                  <!-- <?php if(isset($errors['e_pic_path']) && $errors['e_pic_path'] == 'type') { ?>
                    <p class="error">画像は「jpg」「png」「gif」の画像を選択してください。</p>
                  <?php } ?>
                  <!-- <?php //if(!empty($errors)) { ?> -->
                  <!-- <?php if(isset($errors['e_pic_path']) && $errors['e_pic_path'] == 'blank') { ?>
                    <p class="error">画像を指定してください</p>
                  <?php } ?> -->
                  <!-- <input type="submit" value="アップロードを実行する" /> -->
          <hr>
          <!-- 以下、イベント説明 -->
          <div class="row">
            <div class="col-md-3">
              <h3>Event Description</h3>
            </div>
            <div class="col-md-9">
              <div>
                <textarea name="explanation" class="form-control" style="width:99%; height:300px;" placeholder = "説明文を入力してください"><?php echo htmlspecialchars($explanation); ?></textarea>
                <?php if(isset($errors['explanation']) && $errors['explanation'] == 'blank') { ?>
                  <p class="error">説明文を入力してください</p>
                <?php } ?>
                </div>
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
                      <td width= "200" style="vertical-align: middle;">
                          Event Name
                      </td>
                      <td>
                        <div>
                          <input type="text" class="form-control" name="e_name" placeholder = "イベント名の入力" value="<?php echo htmlspecialchars($e_name); ?>">
                          <?php if(isset($errors['e_name']) && $errors['e_name'] == 'blank') { ?>
                            <p class="error">イベント名を入力してください</p>
                          <?php } ?>
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
                          <input type="date" class="form-control" name="e_start_date" value= "<?php echo htmlspecialchars($e_start_date); ?>">
                          <?php if(isset($errors['e_start_date']) && $errors['e_start_date'] == 'blank') { ?>
                            <p class="error">開始日を入力してください</p>
                          <?php } ?>
                        </div>
                        <div>
                          イベント日程（終了日）（必須）<br>
                          <input type="date" class="form-control" name="e_end_date" value= "<?php echo htmlspecialchars($e_end_date); ?>">
                          <?php if(isset($errors['e_end_date']) && $errors['e_end_date'] == 'blank') { ?>
                            <p class="error">終了日を入力してください</p>
                          <?php } ?>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td style="vertical-align: middle;">
                        city
                      </td>
                      <td>
                        <div>
                          <input type="text" class="form-control" name= "e_prefecture" placeholder = "都道府県の入力" value="<?php echo htmlspecialchars($e_prefecture); ?>">
                          <?php if(isset($errors['e_prefecture']) && $errors['e_prefecture'] == 'blank') { ?>
                            <p class="error">都道府県を入力してください</p>
                          <?php } ?>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td style="vertical-align: middle;">
                        the place (follow on map)
                      </td>
                      <td>
                        <div>
                          <input type="text" class="form-control" name="e_venue" placeholder = "会場を入力してください" value= "<?php echo htmlspecialchars($e_venue); ?>">
                          <?php if(isset($errors['e_venue']) && $errors['e_venue'] == 'blank') { ?>
                            <p class="error">会場を入力してください</p>
                          <?php } ?>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td style="vertical-align: middle;">
                        Web page
                      </td>
                      <td>
                        <div>
                          <input type="text" class="form-control" name="official_url" placeholder = "URLを入力してください" value= "<?php echo htmlspecialchars($official_url); ?>">
                          <?php if(isset($errors['official_url']) && $errors['official_url'] == 'blank') { ?>
                            <p class="error">URLを入力してください</p>
                          <?php } ?>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td style="vertical-align: middle;">
                        Acces
                        </td>
                      <td>
                        <input type="text" class="form-control" name="e_access" placeholder = "アクセスの入力" value= "<?php echo htmlspecialchars($e_access); ?>">
                        <?php if(isset($errors['e_access']) && $errors['e_access'] == 'blank') { ?>
                          <p class="error">アクセスを入力してください</p> -->
                        <?php } ?>
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
                          <input type="text" class="form-control" name="year_ppp" placeholder = "数字を入力してください" value= "<?php echo htmlspecialchars($year_ppp); ?>">
                          <?php if(isset($errors['year_ppp']) && $errors['year_ppp'] == 'blank') { ?>
                            <p class="error">数字を入力してください</p>
                          <?php } ?>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td style="vertical-align: middle;">
                        2015
                      </td>
                      <td>
                        <div>
                          <input type="text" class="form-control" name="year_pp" placeholder = "数字を入力してください" value= "<?php echo htmlspecialchars($year_pp); ?>">
                          <?php if(isset($errors['year_pp']) && $errors['year_pp'] == 'blank') { ?>
                            <p class="error">数字を入力してください</p>
                          <?php } ?>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td style="vertical-align: middle;">
                        2016
                      </td>
                      <td>
                        <div>
                          <input type="text" class="form-control" name="year_p" placeholder = "数字を入力してください"value= "<?php echo htmlspecialchars($year_p); ?>">
                          <?php if(isset($errors['year_p']) && $errors['year_p'] == 'blank') { ?>
                            <p class="error">数字を入力してください</p>
                          <?php } ?>
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
            <div class="col-md-9">

              <hr>
              <div align="center">
                <a href="#" class="btn_1 add_bottom_30" data-toggle="modal" data-target="#myReview">See all review</a>
              </div>
            </div>
          </div>
        </div>
        
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
</form>
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
                    </div>.
        </aside>
      </div>            
            <!-- End row -->
            <button type="submit" class="btn_1 green">Update wishlist</button>
          </section>
          <!-- End section 2 -->

          <section id="section-3">
            <div id="tools">
              <div class="row">
                <div class="col-md-3 col-sm-3 col-xs-6">
                  <div class="styled-select-filters">
                    <select name="sort_type" id="sort_type">
                      <option value="" selected>イベント実施日 </option>
                      <option value="hotels">イベント登録</option>
                    </select>
                  </div>
                </div>                
              </div>
            </div>
            <!--/tools -->

            <div class="strip_booking">
              <div class="row">
                <div class="strip_all_tour_list wow fadeIn" data-wow-delay="0.1s">
                  <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-4">
                      <div class="ribbon_3 popular">
                        <span>Popular</span>
                      </div>
                      <div class="wishlist">
                        <a class="tooltip_flip tooltip-effect-1" href="javascript:void(0);">+<span class="tooltip-content-flip"><span class="tooltip-back">Add to wishlist</span></span></a>
                      </div>
                      <div class="img_list" >
                        <a href="single_tour.html"><img src="img/tour_box_1.jpg" alt="Image">
                        <div class="short_info"><i class="icon_set_1_icon-4"></i>Museums </div>
                        </a>
                      </div>
                    </div>
                    <div class="clearfix visible-xs-block"></div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                      <div class="tour_list_desc">
                        <div class="rating">
                        </div>
                          <h3><strong>イベント名</strong></h3>
                            <p>イベント詳細</p>
                      </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2">
                      <div class="price_list">
                        <div>
                          <p><a href="#0" class="btn_1">詳細</a></p><br> <!-- Takuya待ち -->
                          </p>
                          
                        </div>

                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
              
              <!-- End row -->            
            </div>
            <!-- End row -->
          </section>
          <!-- End section 3 -->

          <section id="section-4">
            <div class="row">
              <div class="col-md-6 col-sm-6 add_bottom_30">
                <h4>Change your password</h4>
                <div class="form-group">
                  <label>Old password</label>
                  <input class="form-control" name="old_password" id="old_password" type="password">
                </div>
                <div class="form-group">
                  <label>New password</label>
                  <input class="form-control" name="new_password" id="new_password" type="password">
                </div>
                <div class="form-group">
                  <label>Confirm new password</label>
                  <input class="form-control" name="confirm_new_password" id="confirm_new_password" type="password">
                </div>
                <button type="submit" class="btn_1 green">Update Password</button>
              </div>
              <div class="col-md-6 col-sm-6 add_bottom_30">
                <h4>Change your email</h4>
                <div class="form-group">
                  <label>Old email</label>
                  <input class="form-control" name="old_password" id="old_password" type="password">
                </div>
                <div class="form-group">
                  <label>New email</label>
                  <input class="form-control" name="new_password" id="new_password" type="password">
                </div>
                <div class="form-group">
                  <label>Confirm new email</label>
                  <input class="form-control" name="confirm_new_password" id="confirm_new_password" type="password">
                </div>
                <button type="submit" class="btn_1 green">Update Email</button>
              </div>
            </div>
            <!-- End row -->

            <hr>
            <br>
            <div class="row">
              <div class="col-md-6 col-sm-6">
                <h4>Notification settings</h4>
                <table class="table table-striped options_cart">
                  <tbody>
                    <tr>
                      <td style="width:10%">
                        <i class="icon_set_1_icon-33"></i>
                      </td>
                      <td style="width:60%">
                        New Citytours Tours
                      </td>
                      <td style="width:35%">
                        <label class="switch-light switch-ios pull-right">
                          <input type="checkbox" name="option_1" id="option_1" checked value="">
                          <span>
              <span>No</span>
                          <span>Yes</span>
                          </span>
                          <a></a>
                        </label>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <i class="icon_set_1_icon-6"></i>
                      </td>
                      <td>
                        New Citytours Hotels
                      </td>
                      <td>
                        <label class="switch-light switch-ios pull-right">
                          <input type="checkbox" name="option_2" id="option_2" value="">
                          <span>
              <span>No</span>
                          <span>Yes</span>
                          </span>
                          <a></a>
                        </label>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <i class="icon_set_1_icon-26"></i>
                      </td>
                      <td>
                        New Citytours Transfers
                      </td>
                      <td>
                        <label class="switch-light switch-ios pull-right">
                          <input type="checkbox" name="option_3" id="option_3" value="" checked>
                          <span>
              <span>No</span>
                          <span>Yes</span>
                          </span>
                          <a></a>
                        </label>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <i class="icon_set_1_icon-81"></i>
                      </td>
                      <td>
                        New Citytours special offers
                      </td>
                      <td>
                        <label class="switch-light switch-ios pull-right">
                          <input type="checkbox" name="option_4" id="option_4" value="">
                          <span>
              <span>No</span>
                          <span>Yes</span>
                          </span>
                          <a></a>
                        </label>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <button type="submit" class="btn_1 green">Update notifications settings</button>
              </div>
            </div>
          </section>
          <!-- End section 4 -->

          <section id="section-5">
            <div class="row">
              <div class="col-md-7 col-sm-7" name="a1">
                <h4>Your profile</h4>
                <ul id="profile_summary">
                  <li>団体名 <span><?php echo htmlspecialchars($o_name);?></span>
                  </li>
                  <li>代表者 <span><?php echo htmlspecialchars($o_f_name);?></span>
                  </li>
                  <li>メールアドレス<span><?php echo htmlspecialchars($o_email);?></span>
                  </li>
                  <li>郵便番号 <span><?php echo htmlspecialchars($o_postal);?></span>
                  </li>
                  <li>住所 <span><?php echo htmlspecialchars($o_pref);?> <?php echo htmlspecialchars($o_address);?></span>
                  </li>
                  <li>電話番号<span><?php echo htmlspecialchars($o_tel);?></span>
                  </li>                  
                  <li>自己紹介<span><?php echo htmlspecialchars($o_intro);?></span>
                  </li>
                </ul>
              </div>
              <div class="col-md-5 col-sm-5">
                <img src="../../o_pic/<?php echo htmlspecialchars($login_user['o_pic']); ?>" width="300" alt="Image" class="img-responsive styled profile_pic"><!-- フォルダ名/データ名 -->
              </div>
            </div>
            <!-- End row -->
<form method="POST" action="" enctype="multipart/form-data">
            <div class="divider"></div>
            <div class="row">section
              <div class="col-md-12">
                <h4 id="edit_profile">Edit profile</h4>
              </div>
              <div class="col-md-12 col-sm-12">
                <table class="table table-bordered">
                  <thead>
                    <tbody>
                      
                        <tr>
                          <th class="col-md-3 col-sm-3">団体名</th>
                          <td>
                            <input class="form-control" name="o_name" id="nickname" type="text" value="<?php echo htmlspecialchars($o_name);?>">
                            <?php if (isset($errors['o_name']) && $errors['o_name'] == 'blank') { ?>
                              <p class="alert-danger">団体名を入力してください</p>
                            <?php } ?>
                          </td>
                        </tr>
                        <tr>
                          <th>代表者名</th>
                          <td>
                            <input class="form-control" name="o_f_name" id="o_f_name" type="text" value="<?php echo htmlspecialchars($o_f_name); ?>">
                            <?php if (isset($errors['o_f_name']) && $errors['o_f_name'] == 'blank') { ?>
                              <p class="alert-danger">代表者名を入力してください</p>
                            <?php } ?>
                          </td>
                        </tr>
                        <tr>
                          <th>メールアドレス</th>
                          <td>
                            <input class="form-control" name="o_email" id="o_email" type="text" value="<?php echo htmlspecialchars($o_email); ?>">
                            <?php if(isset($errors['o_email']) && $errors['o_email'] == 'blank') { ?>
                              <p class="alert-danger">メールアドレスを入力してください</p>
                            <?php } ?>
                            <?php if(isset($errors['o_email']) && $errors['o_email'] == 'duplicate') { ?>
                              <p class="error">そのメールアドレスは既に登録されています</p>
                            <?php } ?>
                          </td>
                        </tr>
                        <tr>
                          <th>現在のパスワード</th>
                            <td>
                              <input type="password" class="form-control" name="o_current_password" id="o_current_password" type="password">
                            </td>
                            <?php if(isset($errors['o_current_password']) && $errors['o_current_password'] == 'failed') { ?>
                              <p class="alert-danger">本人確認に失敗しました。再度現在のパスワードを入力してください</p>
                            <?php } ?>
                        </tr>
                        <tr>
                          <th>新しいパスワード</th>
                            <td>
                              <input class="form-control" name="o_new_password" id="o_new_password" type="password">
                              <?php if(isset($errors['o_new_password']) && $errors['o_new_password'] == 'length') { ?>
                                <p class="alert-danger">パスワードは6文字以上で入力してください</p>
                              <?php } ?>
                            </td>
                        </tr>
                        <tr>
                          <th>確認パスワード</th>
                            <td>
                              <input class="form-control" name="o_confirm_password" id="o_confirm_password" type="password">
                              <?php if(isset($errors['o_confirm_password']) && $errors['o_confirm_password'] == 'wrong') { ?>
                                <p class="alert-danger">パスワードが一致しません</p>
                              <?php } ?>
                            </td>
                        </tr>
                        <tr>
                          <th>郵便番号</th>
                            <td>
                              <input type="text" name="o_postal" class="form-control" maxlength="8" onKeyUp="AjaxZip3.zip2addr(this,'','o_pref','o_address');" value="<?php echo htmlspecialchars($o_postal); ?>">
                              <?php if (isset($errors['o_postal']) && $errors['o_postal'] == 'blank') { ?>
                                <p class="alert-danger">郵便番号を入力してください</p>
                              <?php } ?>
                            </td>
                        </tr>
                        <tr>
                          <th>都道府県</th>
                            <td>
                              <input class="form-control" name="o_pref" id="o_pref" type="text" value="<?php echo htmlspecialchars($o_pref); ?>">
                            </td>
                        </tr>
                        <tr>
                          <th>市区町村・番地・建物名・号室</th>
                          <td>
                            <input class="form-control" name="o_address" id="o_address" type="text" value="<?php echo htmlspecialchars($o_address); ?>">
                          </td>
                        </tr>
                        <tr>
                          <th>電話番号</th>
                            <td>
                              <input class="form-control" name="o_tel" id="o_tel" type="text" value="<?php echo htmlspecialchars($o_tel); ?>">
                            </td>
                        </tr>                        
                        <tr>
                          <th>自己紹介コメント</th>
                            <td>
                              <textarea class="form-control" name="o_intro" value="<?php echo htmlspecialchars($o_intro); ?>"></textarea>
                              <?php if(isset($errors['o_intro']) && $errors['o_intro'] == 'wrong') { ?>
                                <p class="alert-danger"></p>
                              <?php } ?>
                            </td>
                        </tr>
                      <!-- </form> --> 
                    </tbody>
                  </thead>
                </table>
              </div> 
            </div>
            <!-- End row -->      
       
            <h4>Upload profile photo</h4>
            <div class="form-inline upload_1">
              <div class="form-group">
                <input type="file" name="o_pic" id="js-upload-files" enctype="multiple/form-data">
                <?php if(isset($errors['o_pic']) && $errors['o_pic'] == 'type') { ?>
                  <p class="alert-danger">画像は「jpg」「png」「gif」の画像を選択してください</p>
                <?php } ?>
              </div>
            </div>

            <hr>
            <a href="#a1"><button type="submit" class="btn_1 green">Update Profile</button></a>
<!-- ★</form>   -->          
          </section>
          <!-- End section 5 -->

          </div>
          <!-- End content -->
        </div>
        <!-- End tabs -->
      </div> 
      <!-- end container -->
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
                            <option value="French">French</option>
                            <option value="Spanish">Spanish</option>
                            <option value="Russian">Russian</option>
                        </select>
                    </div>
                    <div class="styled-select">
                        <select class="form-control" name="currency" id="currency">
                            <option value="USD" selected>USD</option>
                            <option value="EUR">EUR</option>
                            <option value="GBP">GBP</option>
                            <option value="RUB">RUB</option>
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
                        <p>© Citytours 2015</p>
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

  <!-- Common scripts -->
  <script src="js/jquery-2.2.4.min.js"></script>
  <script src="js/common_scripts_min.js"></script>
  <script src="js/functions.js"></script>

  <!-- Specific scripts -->  
  <script src="js/tabs.js"></script>
  <script>
    new CBPFWTabs(document.getElementById('tabs'));
  </script>
  <script>
    $('.wishlist_close_admin').on('click', function (c) {
      $(this).parent().parent().parent().fadeOut('slow', function (c) {});
    });
  </script>

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

  <!-- 郵便番号 -->
  <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>

</body>

</html>