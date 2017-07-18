<?php
session_start();
require('../../common/dbconnect.php');
require('../../common/functions.php');
$login_user = get_login_user($dbh);



$nickname = $login_user['nickname'];
$email = $login_user['email'];
$nationality = $login_user['nationality'];
$gender = $login_user['gender'];
// $level = $login_user['level'];
$self_intro = $login_user['self_intro'];
$errors = [];

if (!empty($_POST)) {
    $current_password = sha1($_POST['current_password']);
    if ($current_password == $login_user['password']) {
        //現在のパスワードが一致するとき

        $nickname = $_POST['nickname'];
        $email = $_POST['email'];
        $nationality = $_POST['nationality'];
        $gender = $_POST['gender'];
        // $level = $_POST['level'];
        $self_intro = $_POST['self_intro'];

        if ($nickname == '') {
            $errors['nickname'] = 'blank';
        }
        if ($email == '') {
            $errors['email'] = 'blank';
        }
        if ($nationality == '') {
            $errors['nationality'] = 'blank';
        }
        if ($gender == '') {
            $errors['gender'] = 'blank';
        }
        if ($self_intro == '') {
            $errors['self_intro'] = 'blank';
        }

        if (!empty($_POST['new_password'])) {
            //new_passwordが空じゃない場合
            if (strlen($_POST['new_password']) >= 6) {
                $new_password = $_POST['new_password'];
                $confirm_password = $_POST['confirm_password'];
                if ($new_password != $confirm_password) {
                    //new_passwordとconfirm_passwordが一致しなかった場合
                    $errors['confirm_password'] = 'wrong';
                }
            } else {
                $errors['new_password'] = 'length';
            }
        }

        $file_name = $_FILES['pic_path']['nickname'];
        if (!empty($file_name)) {
            //画像が選択されていた場合
            $ext = substr($file_name, -3);
            $ext = strtolower($ext);
            if ($ext != 'jpg' && $ext != 'png' && $ext != 'gif') {
                $errors['pic_path'] = 'type';
            }
        }
    } else {
        $errors['current_password'] = 'failed';
    }

    if (empty($errors)) {
        //もし画像がセットされていれば画像アップデート処理
        if (!empty($file_name)) {
            $date_str = date('YmdHis');
            $submit_file_name = $date_str . $_FILES['pic_path']['nickname'];
            move_uploaded_file($_FILES['pic_path']['tmp_name'], '../../users_pic/' . $submit_file_name);
        }

        //データベース更新処理
        if (empty($new_password)) {
            $password = $current_password;
        } else {
            $password = sha1($new_password);
        }

        //pic_pathのパターン
        //変更なし
        //$login_user['pic_path']
        //変更あり
        //$submit_file_name
        if (empty($file_name)) {
            $submit_file_name = $login_user['pic_path'];
        }

        $sql = 'UPDATE users SET nickname=?,
                                 email=?,
                                 nationality=?,
                                 gender=?,
                                 password=?,
                                 self_intro=?,
                                 pic_path=?,
                                 modified=NOW()   
                           WHERE user_id=?';
        $data = [$nickname,
                 $email,
                 $nationality,
                 $gender,
                 $password,
                 $self_intro,
                 $submit_file_name,
                 $login_user['user_id']];
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);

        header('Location: admin_user.php');
        exit();
    }
}

// 参加予定イベントページ
$sql = 'SELECT * FROM joins WHERE user_id=?';
$data = [$login_user['user_id']];
$stmt = $dbh->prepare($sql);
$stmt->execute($data);

while ($record = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $records[] = $record;
}

// v($records);


for ($i=0; $i < count($records) ; $i++) {
    $sql = 'SELECT events.*,event_pics.e_pic_path FROM events LEFT JOIN event_pics ON events.event_id = event_pics.event_id WHERE events.event_id=? AND events.e_end_date > CURDATE()';
    $event_data =  [$records[$i]['event_id']];
    $event_stmt = $dbh->prepare($sql);
    $event_stmt->execute($event_data);
    while ($event = $event_stmt->fetch(PDO::FETCH_ASSOC)) {
        $events[] = $event;
    }
    $sql = 'SELECT events.*,event_pics.e_pic_path FROM events LEFT JOIN event_pics ON events.event_id = event_pics.event_id WHERE events.event_id=? AND events.e_end_date < CURDATE()';
    $event_end_data =  [$records[$i]['event_id']];
    $event_end_stmt = $dbh->prepare($sql);
    $event_end_stmt->execute($event_end_data);
    while ($event_end = $event_end_stmt->fetch(PDO::FETCH_ASSOC)) {
        $events_end[] = $event_end;
    }



   // echo $record[$i]['event_id'] . "iあり";
    // echo "<br>";
    // echo $record['event_id'] . "iなし";

   // $sql = 'SELECT * FROM event_pics WHERE event_id=?';
   //  $event_data =  [$records[$i]['event_id']];
   //  $pic_stmt = $dbh->prepare($sql);
   //  $pic_stmt->execute($event_data);
   //  while ($pic = $pic_stmt->fetch(PDO::FETCH_ASSOC)) {
   //      $pics[] = $pic;
   //  }

}
// v($events);
// v($pics);

// お気に入りページ

$sql = 'SELECT * FROM likes WHERE user_id=?';
$like_data = [$login_user['user_id']];
$like_stmt = $dbh->prepare($sql);
$like_stmt->execute($like_data);

while ($like = $like_stmt->fetch(PDO::FETCH_ASSOC)) {
    $likes[] = $like;
}

// v($likes);


for ($i=0; $i < count($likes) ; $i++) {
    $sql = 'SELECT events.*,event_pics.e_pic_path FROM events LEFT JOIN event_pics ON events.event_id = event_pics.event_id WHERE events.event_id=? AND events.e_end_date > CURDATE()';
    $event_like_data =  [$likes[$i]['event_id']];
    $event_like_stmt = $dbh->prepare($sql);
    $event_like_stmt->execute($event_like_data);
    while ($event_like = $event_like_stmt->fetch(PDO::FETCH_ASSOC)) {
        $event_likes[] = $event_like;
    }

   // echo $record[$i]['event_id'] . "iあり";
    // echo "<br>";
    // echo $record['event_id'] . "iなし";

    // $sql = 'SELECT * FROM event_pics WHERE event_id=?';
    // $like_data =  [$likes[$i]['event_id']];
    // $pic_like_stmt = $dbh->prepare($sql);
    // $pic_like_stmt->execute($like_data);
    // while ($pic_like = $pic_like_stmt->fetch(PDO::FETCH_ASSOC)) {
    //     $pics_like[] = $pic_like;
    // }

}

// reviewDB登録
$review_rating = '';
$review_comment = '';

if (!empty($_POST)) {
  $review_rating = $_POST['review_rating'];
  $review_comment = $_POST['review_comment'];

  $review_sql = 'INSERT INTO reviews SET event_id = ?, user_id = ?, rating = ?, comment = ?, created = NOW()';
  $review = [$_POST['event_id'],$login_user['user_id'],$_POST['review_rating'],$_POST['review_comment']];
  $review_stmt = $dbh->prepare($review_sql);
  $review_stmt->execute($review);

}

// v($review_comment);
// v($review_rating);
    

$file_review = $_FILES['review_pic_path']['name'];
        //もし画像がセットされていれば画像アップデート処理
        if (!empty($file_review)) {
            $date_str = date('YmdHis');
            $submit_file_name = $date_str . $_FILES['review_pic_path']['name'];
            move_uploaded_file($_FILES['review_pic_path']['tmp_name'], '../../review_photos/' . $submit_file_name);

                $sql = 'SELECT review_id FROM reviews ORDER BY review_id desc limit 1';
                $review_stmt = $dbh->prepare($sql);
                $review_stmt->execute();
                $review_id = $review_stmt->fetch(PDO::FETCH_ASSOC);


            $sql = 'INSERT INTO review_photos SET review_id = ?, review_pic_path = ?';
            $data = [$review_id['review_id'],$submit_file_name];
            $stmt = $dbh->prepare($sql);
            $stmt->execute($data);
        }
// v($_FILES['review_pic_path']);

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
  <title>CITY TOURS - City tours and travel site template by Ansonika</title>

  <!-- Favicons-->
  <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
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

  <!--[if lt IE 9]>
      <script src="js/html5shiv.min.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->

</head>

<body>

  <!--[if lte IE 8]>
    <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a>.</p>
<![endif]-->

<!--   <div id="preloader">
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
<!--     <div id="position">
      <div class="container">
        <ul>
          <li><a href="#">Home</a>
          </li>
          <li><a href="#">Category</a>
          </li>
          <li>Page active</li>
        </ul>
      </div>
    </div> -->
    <!-- End Position -->

    <div class="margin_60 container">      
      <h1 class="welcom">Welcome!</h1><br>
      
      <div id="tabs" class="tabs">
        <nav>
          <ul>
            <li><a href="#section-1" class="icon-calendar"><span>will join</span></a>
            </li>
            <li><a href="#section-2" class="icon-wishlist"><span>like</span></a>
            </li>
            <li><a href="#section-3" class="icon-back-in-time"><span>Reveiw</span></a>
            </li>
            <li><a href="#section-4" class="icon-hourglass"><span>Join the Past</span></a>
            </li>
            <li><a href="#section-5" class="icon-profile"><span>Profile</span></a>
            </li>
          </ul>
        </nav>
        <div class="content">

          <section id="section-1">
            <!-- <div id="tools">
              <div class="row">
                <div class="col-md-3 col-sm-3 col-xs-6">
                  <div class="styled-select-filters">
                    <select name="sort_type" id="sort_type">
                      <option value="" selected>Sort by type</option>
                      <option value="tours">Tours</option>
                      <option value="hotels">Hotels</option>
                      <option value="transfers">Transfers</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-6">
                  <div class="styled-select-filters">
                    <select name="sort_date" id="sort_date">
                      <option value="" selected>Sort by date</option>
                      <option value="oldest">Oldest</option>
                      <option value="recent">Recent</option>
                    </select>
                  </div>
                </div>
              </div>
            </div> -->
            <!--/tools -->
          <?php for ($i=0; $i < count($events) ; $i++) { ?>
            <div class="strip_booking">
              <div class="row">
                <div class="col-md-2 col-sm-2">
                  <div class="date">
                    <!-- <span class="month">Dec</span> -->
                    <span class="day"><img src="../../event_pictures/<?php echo htmlspecialchars($events[$i]['e_pic_path']); ?>" width="50px" height="80px"></span>
                  </div>
                </div>
                <div class="col-md-6 col-sm-5">
                  <h3 class="tours_booking"><?php echo htmlspecialchars($events[$i]['e_name']); ?><span><?php echo htmlspecialchars($events[$i]['e_prefecture']); ?></span></h3>
                </div>
                <div class="col-md-2 col-sm-3">
                  <ul class="info_booking">
                    <li><strong>Event start</strong><?php echo htmlspecialchars($events[$i]['e_start_date']); ?></li>
                    <li><strong>Event end</strong><?php echo htmlspecialchars($events[$i]['e_end_date']); ?></li>
                  </ul>
                </div>
                <div class="col-md-2 col-sm-2">
                  <div class="booking_buttons">
                    <a href="event_detail.php?event_id=<?php echo htmlspecialchars($events[$i]['event_id']); ?>" class="btn_2">Detail</a>
                  </div>
                </div>
              </div>
              <!-- End row -->
            </div>
          <?php } ?>
            <!-- End strip booking -->

            <!-- <div class="strip_booking">
              <div class="row">
                <div class="col-md-2 col-sm-2">
                  <div class="date">
                    <span class="month">Dec</span>
                    <span class="day"><strong>27</strong>Fri</span>
                  </div>
                </div>
                <div class="col-md-6 col-sm-5">
                  <h3 class="tours_booking">Louvre Museum<span>2 Adults / 2 Childs</span></h3>
                </div>
                <div class="col-md-2 col-sm-3">
                  <ul class="info_booking">
                    <li><strong>Booking id</strong> 23442</li>
                    <li><strong>Booked on</strong> Sat. 20 Dec. 2015</li>
                  </ul>
                </div>
                <div class="col-md-2 col-sm-2">
                  <div class="booking_buttons">
                    <a href="#0" class="btn_2">Edit</a>
                    <a href="#0" class="btn_3">Cancel</a>
                  </div>
                </div>
              </div>
              <!-- End row -->
            <!-- </div> -->
             <!-- End strip booking -->

            <!-- <div class="strip_booking">
              <div class="row">
                <div class="col-md-2 col-sm-2">
                  <div class="date">
                    <span class="month">Dec</span>
                    <span class="day"><strong>28</strong>Fri</span>
                  </div>
                </div>
                <div class="col-md-6 col-sm-5">
                  <h3 class="tours_booking">Tour Eiffel<span>2 Adults</span></h3>
                </div>
                <div class="col-md-2 col-sm-3">
                  <ul class="info_booking">
                    <li><strong>Booking id</strong> 23442</li>
                    <li><strong>Booked on</strong> Sat. 20 Dec. 2015</li>
                  </ul>
                </div>
                <div class="col-md-2 col-sm-2">
                  <div class="booking_buttons">
                    <a href="#0" class="btn_2">Edit</a>
                    <a href="#0" class="btn_3">Cancel</a>
                  </div>
                </div>
              </div>
 -->              <!-- End row -->
            <!-- </div> -->
            <!-- End strip booking -->

            <!-- <div class="strip_booking">
              <div class="row">
                <div class="col-md-2 col-sm-2">
                  <div class="date">
                    <span class="month">Dec</span>
                    <span class="day"><strong>30</strong>Fri</span>
                  </div>
                </div>
                <div class="col-md-6 col-sm-5">
                  <h3 class="transfers_booking">Orly Airport<span>2 Adults / 2Childs</span></h3>
                </div>
                <div class="col-md-2 col-sm-3">
                  <ul class="info_booking">
                    <li><strong>Booking id</strong> 23442</li>
                    <li><strong>Booked on</strong> Sat. 20 Dec. 2015</li>
                  </ul>
                </div>
                <div class="col-md-2 col-sm-2">
                  <div class="booking_buttons">
                    <a href="#0" class="btn_2">Edit</a>
                    <a href="#0" class="btn_3">Cancel</a>
                  </div>
                </div>
              </div> -->
              <!-- End row -->
            <!-- </div> -->
            <!-- End strip booking -->

          </section> 
                   <!-- End section 1 -->
          <section id="section-2">
          <div class="row">
            <?php for ($i=0; $i < count($event_likes) ; $i++) { ?>

            
              <div class="col-md-4 col-sm-6">
                <div class="hotel_container">
                  <div class="img_container">
                    <a href="event_detail.php?event_id=<?php echo htmlspecialchars($event_likes[$i]['event_id']); ?>">
                      <img src="../../event_pictures/<?php echo htmlspecialchars($event_likes[$i]['e_pic_path']); ?>" width="200" height="200" class="img-responsive" alt="Image">
                      <div class="">
                      </div>
                      <div class="score">
                        <!-- <span>7.5</span>Good -->
                      </div>
                      <div class="short_info hotel">
                        <!-- From/Per night<span class="price"><sup>$</sup>59</span> -->
                      </div>
                    </a>
                  </div>
                  <div class="hotel_title">
                    <h3><strong><?php echo htmlspecialchars($event_likes[$i]['e_name']); ?></strong></h3>
                    <div class="rating">
                      <i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star-empty"></i>
                    </div>
                    <!-- end rating -->
                    <div class="wishlist_close_admin">
                      -
                    </div>
                  </div>
                </div>
                <!-- End box tour -->
              </div>
              
              <!-- End col-md-6 -->

              <!-- <div class="col-md-4 col-sm-6 ">
                <div class="hotel_container">
                  <div class="img_container">
                    <a href="single_hotel.html">
                      <img src="img/hotel_2.jpg" width="800" height="533" class="img-responsive" alt="Image">
                      <div class="ribbon top_rated">
                      </div>
                      <div class="score">
                        <span>9.0</span>Superb
                      </div>
                      <div class="short_info hotel">
                        From/Per night<span class="price"><sup>$</sup>45</span>
                      </div>
                    </a>
                  </div>
                  <div class="hotel_title">
                    <h3><strong>Mariott</strong> Hotel</h3>
                    <div class="rating">
                      <i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star-empty"></i>
                    </div>
               -->      <!-- end rating -->
                    <!-- <div class="wishlist_close_admin"> -->
                      
                    <!-- </div>
                  </div>
                </div> -->
                <!-- End box -->
              <!-- </div> -->
              <!-- End col-md-6 -->

              <!-- <div class="col-md-4 col-sm-6">
                <div class="tour_container">
                  <div class="img_container">
                    <a href="single_tour.html">
                      <img src="img/tour_box_1.jpg" width="800" height="533" class="img-responsive" alt="Image">
                      <div class="ribbon top_rated">
                      </div>
                      <div class="short_info">
                        <i class="icon_set_1_icon-44"></i>Historic Buildings<span class="price"><sup>$</sup>45</span>
                      </div>
                    </a>
                  </div>
                  <div class="tour_title">
                    <h3><strong>Arc Triomphe</strong> tour</h3>
                    <div class="rating">
                      <i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile"></i><small>(75)</small>
                    </div> -->
                    <!-- end rating -->
                    <!-- <div class="wishlist_close_admin"> -->
                    
                    <!-- </div>
                  </div>
                </div> -->
                <!-- End box tour -->
              <!-- </div> -->
              <!-- End col-md-6 -->

              <!-- <div class="col-md-4 col-sm-6">
                <div class="tour_container">
                  <div class="img_container">
                    <a href="single_tour.html">
                      <img src="img/tour_box_3.jpg" width="800" height="533" class="img-responsive" alt="Image">
                      <div class="ribbon popular">
                      </div>
                      <div class="short_info">
                        <i class="icon_set_1_icon-44"></i>Historic Buildings<span class="price"><sup>$</sup>45</span>
                      </div>
                    </a>
                  </div>
                  <div class="tour_title">
                    <h3><strong>Versailles</strong> tour</h3>
                    <div class="rating">
                      <i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile"></i><small>(75)</small>
                    </div>
               -->      <!-- end rating -->
                    <!-- <div class="wishlist_close_admin"> -->
                      <!-- -
                    </div>
                  </div>
                </div> -->
                <!-- End box tour -->
              <!-- </div> -->
              <!-- End col-md-6 -->

              <!-- <div class="col-md-4 col-sm-6">
                <div class="tour_container">
                  <div class="img_container">
                    <a href="single_tour.html">
                      <img src="img/tour_box_4.jpg" width="800" height="533" class="img-responsive" alt="Image">
                      <div class="ribbon popular">
                      </div>
                      <div class="short_info">
                        <i class="icon_set_1_icon-30"></i>Walking tour<span class="price"><sup>$</sup>45</span>
                      </div>
                    </a>
                  </div>
                  <div class="tour_title">
                    <h3><strong>Pompidue</strong> tour</h3>
                    <div class="rating">
                      <i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile"></i><small>(75)</small>
                    </div>
               -->      <!-- end rating -->
                    <!-- <div class="wishlist_close_admin">
                      -
                    </div>
                  </div>
                </div> -->
                <!-- End box tour -->
              <!-- </div> -->
              <!-- End col-md-6 -->

              <!-- <div class="col-md-4 col-sm-6">
                <div class="transfer_container">
                  <div class="img_container">
                    <a href="single_transfer.html">
                      <img src="img/transfer_1.jpg" width="800" height="533" class="img-responsive" alt="Image">
                      <div class="ribbon top_rated">
                      </div>
                      <div class="short_info">
                        From/Per person<span class="price"><sup>$</sup>45</span>
                      </div>
                    </a>
                  </div>
                  <div class="transfer_title">
                    <h3><strong>Orly Airport</strong> private</h3>
                    <div class="rating">
                      <i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile"></i><small>(75)</small>
                    </div>
               -->      <!-- end rating -->
                    <!-- <div class="wishlist_close_admin">
                      -
                    </div>
                  </div>
                </div> -->
                <!-- End box tour -->
              <!-- </div> -->
              <!-- End col-md-6 -->

           
            <!-- End row -->
            <!-- <button type="submit" class="btn_1 green">Update wishlist</button> -->
          <?php } ?>
           </div>
          </section>

          <!-- End section 2 -->

          <section id="section-3">
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
            <!-- End row -->
          </section>
          <!-- End section 3 -->

          <section id="section-4">
            <?php for ($i=0; $i < count($events_end) ; $i++) { ?>
              <div class="strip_booking">
                <div class="row">
                  <div class="col-md-2 col-sm-2">
                    <div class="date">
                      <!-- <span class="month">Dec</span> -->
                      <span class="day"><img src="../../event_pictures/<?php echo htmlspecialchars($events_end[$i]['e_pic_path']); ?>" width="50px" height="80px"></span>
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-5">
                    <h3 class="tours_booking"><?php echo htmlspecialchars($events_end[$i]['e_name']); ?><span><?php echo htmlspecialchars($events_end[$i]['e_prefecture']); ?></span></h3>
                  </div>
                  <div class="col-md-2 col-sm-3">
                    <ul class="info_booking">
                      <li><strong>Event start</strong><?php echo htmlspecialchars($events_end[$i]['e_start_date']); ?></li>
                      <li><strong>Event end</strong><?php echo htmlspecialchars($events_end[$i]['e_end_date']); ?></li>
                    </ul>
                  </div>
                  <div class="col-md-2 col-sm-2">
                    <div class="booking_buttons">
                      <a href="#" class="btn_1 add_bottom_30" data-toggle="modal" data-target="#myReview" id="<?php echo htmlspecialchars($events_end[$i]['event_id']); ?>">Review</a>
                    </div>
                  </div>
                </div>
                <!-- End row -->
              </div>
            <?php } ?>
            <!-- <div class="row">
              <div class="col-md-4 col-sm-6">
                <div class="hotel_container">
                  <div class="img_container">
                    <a href="single_hotel.html">
                      <img src="img/hotel_1.jpg" width="800" height="533" class="img-responsive" alt="Image">
                      <div class="ribbon top_rated">
                      </div>
                      <div class="score">
                        <span>7.5</span>Good
                      </div>
                      <div class="short_info hotel">
                        From/Per night<span class="price"><sup>$</sup>59</span>
                      </div>
                    </a>
                  </div>
                  <div class="hotel_title">
                    <h3><strong>Park Hyatt</strong> Hotel</h3>
                    <div class="rating">
                      <i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star-empty"></i>
                    </div> -->
                    <!-- end rating -->
                    <!-- <div class="wishlist_close_admin">
                
                    </div>
                  </div>
                </div> -->
                <!-- End box tour -->
              <!-- </div> -->
              <!-- End col-md-6 -->

            <!-- </div> -->
            <!-- End row -->
            <!-- <div class="col-md-12 col-sm-12">
              <textarea class="form-control"></textarea><br> 
              <button type="submit" class="btn_1 green">Review</button>  
            </div> -->
            
          </section>
          <!-- End section 4 -->

          <section id="section-5">
            <div class="row">
              <div class="col-md-7 col-sm-7" name="a1">
                <h4>Your profile</h4>
                <ul id="profile_summary">
                  <li>Username <span><?php echo htmlspecialchars($nickname); ?></span>
                  </li>
                  <li>Email <span><?php echo htmlspecialchars($email);?></span>
                  </li>
                  <li>Country <span><?php echo htmlspecialchars($nationality);?></span>
                  </li>
                  <li>Gender <span><?php echo htmlspecialchars($gender);?></span>
                  <!-- </li>
                  <li>Level of Japanese<span><?php echo htmlspecialchars($level);?></span>
                  </li> -->
                  <li>Comment<span><?php echo htmlspecialchars($self_intro);?></span>
                  </li>
                </ul>
                <!-- Editボタンが押されたらパスワード確認が開く -->
                <!-- <div onclick="obj=document.getElementById('open').style;　obj.display=(obj.display=='none')?'block':'none';">
                  <a href="#a1" style="cursor:pointer;" ><button type="submit" class="btn_1 green" id="js-upload-submit">Edit</button></a>                  
                </div> -->

                <!-- 展開の中身 -->
               <!--  <div id="open" style="display:none;clear:both;">
                  現在のパスワードを入力してください<br>
                  <form method="POST" action="admin_user.php#a1">
                    <input type="password" class="form-control" name="current_password" id="password">
                      <?php if(isset($errors['current_password']) && $errors['current_password'] == 'failed') { ?>
                      <p class="alert-danger">本人確認に失敗しました。再度パスワードを入力してください</p>
                      <?php } ?>
                        <div onclick="obj=document.getElementById('open').style; obj.display=(obj.display=='none')?'block':'none';">
                        <a href="#a1" style="cursor:pointer;"><input type="submit" class="btn_1 green" value="確認する"></a>
                          <div id="open" style="display:none;clear:both;">
                            hoge
                          </div>
                        </div>
                  </form>          
                </div> -->
                <!-- End 展開の中身 -->
              </div>
              <div class="col-md-5 col-sm-5">
                <img src="img/tourist_guide_pic.jpg" alt="Image" class="img-responsive styled profile_pic">
              </div>
            </div>
            <!-- End row -->

            <div class="divider"></div>
            <div class="row">
              <div class="col-md-12">
                <h4 id="edit_profile">Edit profile</h4>
              </div>
              <div class="col-md-12 col-sm-12">
                <table class="table table-bordered">
                  <thead>
                    <tbody>
                      <form method="POST" action="" enctype="multipart/form-data">
                        <tr>
                          <th>Username</th>
                          <td>
                            <input class="form-control" name="nickname" id="nickname" type="text" value="<?php echo htmlspecialchars($nickname);?>">
                            <?php if(isset($errors['nickname']) && $errors['nickname'] == 'blank') { ?>
                              <p class="alert-danger">ユーザー名を入力してください</p>
                            <?php } ?>
                          </td>
                        </tr>
                        <tr>
                          <th>Email</th>
                          <td>
                            <input class="form-control" name="email" id="email" type="text" value="<?php echo htmlspecialchars($email); ?>">
                            <?php if(isset($errors['email']) && $errors['email'] == 'blank') { ?>
                              <p class="alert-danger">メールアドレスを入力してください</p>
                            <?php } ?>
                            <?php if(isset($errors['email']) && $errors['email'] == 'duplicate') { ?>
                              <p class="error">そのメールアドレスは既に登録されています</p>
                            <?php } ?>
                          </td>
                        </tr>
                        <tr>
                          <th>Now Password</th>
                            <td>
                              <input type="password" class="form-control" name="current_password" id="current_password" >
                              <?php if(isset($errors['current_password']) && $errors['current_password'] == 'failed') { ?>
                                <p class="alert-danger">本人確認に失敗しました。再度パスワードを入力してください</p>
                              <?php } ?>
                            </td>
                        </tr>
                        <tr>
                          <th>New Password</th>
                            <td>
                              <input class="form-control" name="new_password" id="new_password" type="password">
                              <?php if(isset($errors['new_password']) && $errors['new_password'] == 'length') { ?>
                                <p class="alert-danger">パスワードは6文字以上で入力してください</p>
                              <?php } ?>
                            </td>
                        </tr>
                        <tr>
                          <th>Confirm password</th>
                            <td>
                              <input class="form-control" name="confirm_password" id="confirm_password" type="password">
                              <?php if(isset($errors['confirm_password']) && $errors['confirm_password'] == 'wrong') { ?>
                                <p class="alert-danger">パスワードが一致しません</p>
                              <?php } ?>
                            </td>
                        </tr>
                        <tr>
                          <th>Country</th>
                            <td>
                              <select class="form-control" name="nationality" id="nationality" selected="<?php echo htmlspecialchars($nationality); ?>">
                                <option value="nationality">Nationality</option>
                                <option value="Afganistan">Afghanistan</option>
                                <option value="Albania">Albania</option>
                                <option value="Algeria">Algeria</option>
                                <option value="American Samoa">American Samoa</option>
                                <option value="Andorra">Andorra</option>
                                <option value="Angola">Angola</option>
                                <option value="Anguilla">Anguilla</option>
                                <option value="Antigua &amp; Barbuda">Antigua &amp; Barbuda</option>  
                                <option value="Argentina">Argentina</option>
                                <option value="Armenia">Armenia</option>
                                <option value="Aruba">Aruba</option>
                                <option value="Australia">Australia</option>
                                <option value="Austria">Austria</option>
                                <option value="Azerbaijan">Azerbaijan</option>
                                <option value="Bahamas">Bahamas</option>
                                <option value="Bahrain">Bahrain</option>
                                <option value="Bangladesh">Bangladesh</option>
                                <option value="Barbados">Barbados</option>
                                <option value="Belarus">Belarus</option>
                                <option value="Belgium">Belgium</option>
                                <option value="Belize">Belize</option>
                                <option value="Benin">Benin</option>
                                <option value="Bermuda">Bermuda</option>
                                <option value="Bhutan">Bhutan</option>
                                <option value="Bolivia">Bolivia</option>
                                <option value="Bonaire">Bonaire</option>
                                <option value="Bosnia &amp; Herzegovina">Bosnia &amp; Herzegovina</option>
                                <option value="Botswana">Botswana</option>
                                <option value="Brazil">Brazil</option>
                                <option value="British Indian Ocean Ter">British Indian Ocean Ter</option>
                                <option value="Brunei">Brunei</option>
                                <option value="Bulgaria">Bulgaria</option>
                                <option value="Burkina Faso">Burkina Faso</option>
                                <option value="Burundi">Burundi</option>
                                <option value="Cambodia">Cambodia</option>
                                <option value="Cameroon">Cameroon</option>
                                <option value="Canada">Canada</option>
                                <option value="Canary Islands">Canary Islands</option>
                                <option value="Cape Verde">Cape Verde</option>
                                <option value="Cayman Islands">Cayman Islands</option>
                                <option value="Central African Republic">Central African Republic</option>
                                <option value="Chad">Chad</option>
                                <option value="Channel Islands">Channel Islands</option>
                                <option value="Chile">Chile</option>
                                <option value="China">China</option>
                                <option value="Christmas Island">Christmas Island</option>
                                <option value="Cocos Island">Cocos Island</option>
                                <option value="Colombia">Colombia</option>
                                <option value="Comoros">Comoros</option>
                                <option value="Congo">Congo</option>
                                <option value="Cook Islands">Cook Islands</option>
                                <option value="Costa Rica">Costa Rica</option>
                                <option value="Cote DIvoire">Cote D'Ivoire</option>
                                <option value="Croatia">Croatia</option>
                                <option value="Cuba">Cuba</option>
                                <option value="Curaco">Curacao</option>
                                <option value="Cyprus">Cyprus</option>
                                <option value="Czech Republic">Czech Republic</option>
                                <option value="Denmark">Denmark</option>
                                <option value="Djibouti">Djibouti</option>
                                <option value="Dominica">Dominica</option>
                                <option value="Dominican Republic">Dominican Republic</option>
                                <option value="East Timor">East Timor</option>
                                <option value="Ecuador">Ecuador</option>
                                <option value="Egypt">Egypt</option>
                                <option value="El Salvador">El Salvador</option>
                                <option value="Equatorial Guinea">Equatorial Guinea</option>
                                <option value="Eritrea">Eritrea</option>
                                <option value="Estonia">Estonia</option>
                                <option value="Ethiopia">Ethiopia</option>
                                <option value="Falkland Islands">Falkland Islands</option>
                                <option value="Faroe Islands">Faroe Islands</option>
                                <option value="Fiji">Fiji</option>
                                <option value="Finland">Finland</option>
                                <option value="France">France</option>
                                <option value="French Guiana">French Guiana</option>
                                <option value="French Polynesia">French Polynesia</option>
                                <option value="French Southern Ter">French Southern Ter</option>
                                <option value="Gabon">Gabon</option>
                                <option value="Gambia">Gambia</option>
                                <option value="Georgia">Georgia</option>
                                <option value="Germany">Germany</option>
                                <option value="Ghana">Ghana</option>
                                <option value="Gibraltar">Gibraltar</option>
                                <option value="Great Britain">Great Britain</option>
                                <option value="Greece">Greece</option>
                                <option value="Greenland">Greenland</option>
                                <option value="Grenada">Grenada</option>
                                <option value="Guadeloupe">Guadeloupe</option>
                                <option value="Guam">Guam</option>
                                <option value="Guatemala">Guatemala</option>
                                <option value="Guinea">Guinea</option>
                                <option value="Guyana">Guyana</option>
                                <option value="Haiti">Haiti</option>
                                <option value="Hawaii">Hawaii</option>
                                <option value="Honduras">Honduras</option>
                                <option value="Hong Kong">Hong Kong</option>
                                <option value="Hungary">Hungary</option>
                                <option value="Iceland">Iceland</option>
                                <option value="India">India</option>
                                <option value="Indonesia">Indonesia</option>
                                <option value="Iran">Iran</option>
                                <option value="Iraq">Iraq</option>
                                <option value="Ireland">Ireland</option>
                                <option value="Isle of Man">Isle of Man</option>
                                <option value="Israel">Israel</option>
                                <option value="Italy">Italy</option>
                                <option value="Jamaica">Jamaica</option>
                                <option value="Japan">Japan</option>
                                <option value="Jordan">Jordan</option>
                                <option value="Kazakhstan">Kazakhstan</option>
                                <option value="Kenya">Kenya</option>
                                <option value="Kiribati">Kiribati</option>
                                <option value="Korea North">Korea North</option>
                                <option value="Korea Sout">Korea South</option>
                                <option value="Kuwait">Kuwait</option>
                                <option value="Kyrgyzstan">Kyrgyzstan</option>
                                <option value="Laos">Laos</option>
                                <option value="Latvia">Latvia</option>
                                <option value="Lebanon">Lebanon</option>
                                <option value="Lesotho">Lesotho</option>
                                <option value="Liberia">Liberia</option>
                                <option value="Libya">Libya</option>
                                <option value="Liechtenstein">Liechtenstein</option>
                                <option value="Lithuania">Lithuania</option>
                                <option value="Luxembourg">Luxembourg</option>
                                <option value="Macau">Macau</option>
                                <option value="Macedonia">Macedonia</option>
                                <option value="Madagascar">Madagascar</option>
                                <option value="Malaysia">Malaysia</option>
                                <option value="Malawi">Malawi</option>
                                <option value="Maldives">Maldives</option>
                                <option value="Mali">Mali</option>
                                <option value="Malta">Malta</option>
                                <option value="Marshall Islands">Marshall Islands</option>
                                <option value="Martinique">Martinique</option>
                                <option value="Mauritania">Mauritania</option>
                                <option value="Mauritius">Mauritius</option>
                                <option value="Mayotte">Mayotte</option>
                                <option value="Mexico">Mexico</option>
                                <option value="Midway Islands">Midway Islands</option>
                                <option value="Moldova">Moldova</option>
                                <option value="Monaco">Monaco</option>
                                <option value="Mongolia">Mongolia</option>
                                <option value="Montserrat">Montserrat</option>
                                <option value="Morocco">Morocco</option>
                                <option value="Mozambique">Mozambique</option>
                                <option value="Myanmar">Myanmar</option>
                                <option value="Nambia">Nambia</option>
                                <option value="Nauru">Nauru</option>
                                <option value="Nepal">Nepal</option>
                                <option value="Netherland Antilles">Netherland Antilles</option>
                                <option value="Netherlands">Netherlands (Holland, Europe)</option>
                                <option value="Nevis">Nevis</option>
                                <option value="New Caledonia">New Caledonia</option>
                                <option value="New Zealand">New Zealand</option>
                                <option value="Nicaragua">Nicaragua</option>
                                <option value="Niger">Niger</option>
                                <option value="Nigeria">Nigeria</option>
                                <option value="Niue">Niue</option>
                                <option value="Norfolk Island">Norfolk Island</option>
                                <option value="Norway">Norway</option>
                                <option value="Oman">Oman</option>
                                <option value="Pakistan">Pakistan</option>
                                <option value="Palau Island">Palau Island</option>
                                <option value="Palestine">Palestine</option>
                                <option value="Panama">Panama</option>
                                <option value="Papua New Guinea">Papua New Guinea</option>
                                <option value="Paraguay">Paraguay</option>
                                <option value="Peru">Peru</option>
                                <option value="Phillipines">Philippines</option>
                                <option value="Pitcairn Island">Pitcairn Island</option>
                                <option value="Poland">Poland</option>
                                <option value="Portugal">Portugal</option>
                                <option value="Puerto Rico">Puerto Rico</option>
                                <option value="Qatar">Qatar</option>
                                <option value="Republic of Montenegro">Republic of Montenegro</option>
                                <option value="Republic of Serbia">Republic of Serbia</option>
                                <option value="Reunion">Reunion</option>
                                <option value="Romania">Romania</option>
                                <option value="Russia">Russia</option>
                                <option value="Rwanda">Rwanda</option>
                                <option value="St Barthelemy">St Barthelemy</option>
                                <option value="St Eustatius">St Eustatius</option>
                                <option value="St Helena">St Helena</option>
                                <option value="St Kitts-Nevis">St Kitts-Nevis</option>
                                <option value="St Lucia">St Lucia</option>
                                <option value="St Maarten">St Maarten</option>
                                <option value="St Pierre &amp; Miquelon">St Pierre &amp; Miquelon</option>
                                <option value="St Vincent &amp; Grenadines">St Vincent &amp; Grenadines</option>
                                <option value="Saipan">Saipan</option>
                                <option value="Samoa">Samoa</option>
                                <option value="Samoa American">Samoa American</option>
                                <option value="San Marino">San Marino</option>
                                <option value="Sao Tome &amp; Principe">Sao Tome &amp; Principe</option>
                                <option value="Saudi Arabia">Saudi Arabia</option>
                                <option value="Senegal">Senegal</option>
                                <option value="Serbia">Serbia</option>
                                <option value="Seychelles">Seychelles</option>
                                <option value="Sierra Leone">Sierra Leone</option>
                                <option value="Singapore">Singapore</option>
                                <option value="Slovakia">Slovakia</option>
                                <option value="Slovenia">Slovenia</option>
                                <option value="Solomon Islands">Solomon Islands</option>
                                <option value="Somalia">Somalia</option>
                                <option value="South Africa">South Africa</option>
                                <option value="Spain">Spain</option>
                                <option value="Sri Lanka">Sri Lanka</option>
                                <option value="Sudan">Sudan</option>
                                <option value="Suriname">Suriname</option>
                                <option value="Swaziland">Swaziland</option>
                                <option value="Sweden">Sweden</option>
                                <option value="Switzerland">Switzerland</option>
                                <option value="Syria">Syria</option>
                                <option value="Tahiti">Tahiti</option>
                                <option value="Taiwan">Taiwan</option>
                                <option value="Tajikistan">Tajikistan</option>
                                <option value="Tanzania">Tanzania</option>
                                <option value="Thailand">Thailand</option>
                                <option value="Togo">Togo</option>
                                <option value="Tokelau">Tokelau</option>
                                <option value="Tonga">Tonga</option>
                                <option value="Trinidad &amp; Tobago">Trinidad &amp; Tobago</option>
                                <option value="Tunisia">Tunisia</option>
                                <option value="Turkey">Turkey</option>
                                <option value="Turkmenistan">Turkmenistan</option>
                                <option value="Turks &amp; Caicos Is">Turks &amp; Caicos Is</option>
                                <option value="Tuvalu">Tuvalu</option>
                                <option value="Uganda">Uganda</option>
                                <option value="Ukraine">Ukraine</option>
                                <option value="United Arab Erimates">United Arab Emirates</option>
                                <option value="United Kingdom">United Kingdom</option>
                                <option value="United States of America">United States of America</option>
                                <option value="Uraguay">Uruguay</option>
                                <option value="Uzbekistan">Uzbekistan</option>
                                <option value="Vanuatu">Vanuatu</option>
                                <option value="Vatican City State">Vatican City State</option>
                                <option value="Venezuela">Venezuela</option>
                                <option value="Vietnam">Vietnam</option>
                                <option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
                                <option value="Virgin Islands (USA)">Virgin Islands (USA)</option>
                                <option value="Wake Island">Wake Island</option>
                                <option value="Wallis &amp; Futana Is">Wallis &amp; Futana Is</option>
                                <option value="Yemen">Yemen</option>
                                <option value="Zaire">Zaire</option>
                                <option value="Zambia">Zambia</option>
                                <option value="Zimbabwe">Zimbabwe</option>
                              </select>
                            </td>
                        </tr>
                        <tr>
                          <th>Gender</th>
                          <td>
                            <select class="form-control" name="gender" id="gender" selected="<?php echo htmlspecialchars($gender);?>">
                              <option value="male" selected>male</option>
                              <option value="female" selected>female</option>
                              <option value="other" selected>other</option>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <th>Level of JApanese</th>
                          <td>
                            <select class="form-control" name="level" id="level" selected="<?php echo htmlspecialchars($level);?>">
                              <option value="male" selected>male</option>
                              <option value="female" selected>female</option>
                              <option value="other" selected>other</option>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <th>Comment</th>
                            <td>
                              <textarea class="form-control" value="<?php echo htmlspecialchars($self_intro);?>"></textarea>
                              <?php if(isset($errors['o_intro']) && $errors['o_intro'] == 'wrong') { ?>
                                <p class="alert-danger"></p>
                              <?php } ?>
                            </td>
                        </tr>
                      </form>
                    </tbody>
                  </thead>
                </table>
              </div> 
            </div>
            <!-- End row -->      
       
            <h4>Upload profile photo</h4>
            <div class="form-inline upload_1">
              <div class="form-group">
                <input type="file" name="pic_path" id="js-upload-files" enctype="multiple/form-data">
                <?php if(isset($errors['pic_path']) && $errors['pic_path'] == 'type') { ?>
                  <p class="alert-danger">画像は「jpg」「png」「gif」の画像を選択してください</p>
                <?php } ?>
              </div>
            </div> 
            
            <hr>
            <a href="#a1"><button type="submit" class="btn_1 green">Update Profile</button></a>
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

  <footer>
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
    <form role="search" id="searchform" method="POST">
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

  <!-- 郵便番号 -->
  <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>

  <!-- Modal Review -->
  <form method="POST" action="admin_user.php" enctype="multipart/form-data">
   <div class="modal fade" id="myReview" tabindex="-1" role="dialog" aria-labelledby="myReviewLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                  </button>
                  <h4 class="modal-title" id="myReviewLabel">Write your review</h4>
              </div>
              <div class="modal-body">
                  <div id="message-review"></div>
                  <form method="post" action="assets/review_tour.php" name="review_tour" id="review_tour">

                      <!-- End row -->

                      <!-- End row -->
                      <div class="row">
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label>Position</label>
                                  <select class="form-control" name="review_rating" id="position_review">
                                      <option value="">Please review</option>
                                      <option value="1">1</option>
                                      <option value="2">2</option>
                                      <option value="3">3</option>
                                      <option value="4">4</option>
                                      <option value="5">5</option>
                                  </select>
                              </div>
                          </div>
                      </div>
                      <!-- End row -->

                      <!-- End row -->
                      <div class="form-group">
                          <textarea name="review_comment" id="review_text" class="form-control" style="height:100px" placeholder="Write your review"></textarea>
                      </div>
                      <div class="form-group">
                          <span class="btn btn-primary">
                          <input type="file" name="review_pic_path" multiple>
                          </span>
                      </div>
                      <div>
                        <input type="hidden" name="event_id" value="" id="modal_event_id">
                      </div>
                      <div>
                        <input class="btn btn-primary" type="submit">
                      </div>
                  </div>
          </div>
      </div>
    </div>
  </form>

  <!-- <footer class="revealed">
  <div class="container">
  <div class="row">
  ※requireで呼び出し
  </div>
  </div> -->
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
      <!-- jsのプログラムの実行 -->
      <script>
        $(document).ready(function(){
          $('a').click(function(){
            var event_id = $(this).attr('id');
            console.log(event_id);
            $('#modal_event_id').val(event_id);
          });
        });

      </script>


</body>

</html>