<?php
session_start();
require('../../common/dbconnect.php');
require('../../common/functions.php');
$login_user = get_login_user($dbh);

if ($_SESSION['flag'] == '') {
    header('Location: edit_index.php');
    exit();//ここでこのファイルの読み込みを強制終了
}

$nickname     = $login_user['nickname'];
$email        = $login_user['email'];
$nationality  = $login_user['nationality'];
$gender       = $login_user['gender'];
// $level     = $login_user['level'];
$self_intro   = $login_user['self_intro'];
$errors       = [];

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

//参加予定（未来日）イベントデータ
$sql = 'SELECT * FROM joins, events WHERE joins.event_id = events.event_id
                                    AND   events.e_end_date > CURDATE()
                                    AND   joins.user_id=?';
$data = [$login_user['user_id']];
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
while ($f_event = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $f_events[] = $f_event;
}

//参加済み（過去日）イベントデータ
$sql = 'SELECT * FROM joins, events WHERE joins.event_id = events.event_id
                                    AND   events.e_end_date < CURDATE()
                                    AND   joins.user_id=?';
$data = [$login_user['user_id']];
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
while ($p_event = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $p_events[] = $p_event;
}



  // echo '<pre>';
  // var_dump($events);
  // echo '</pre>';

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

// v($events);
// v($pics);

// お気に入りページ

$sql = 'SELECT * FROM likes, events WHERE likes.event_id = events.event_id AND likes.user_id=?';
$like_data = [$login_user['user_id']];
$like_stmt = $dbh->prepare($sql);
$like_stmt->execute($like_data);

while ($like = $like_stmt->fetch(PDO::FETCH_ASSOC)) {
    $likes[] = $like;
}

// v($likes);


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
    
if (isset($_FILES['review_pic_path']['name'])) {

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
  # code...
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
  <div class="layer"></div>
  <!-- Mobile menu overlay mask -->

  <!-- Header================================================== -->
  <!-- header.phpのrequire -->
  <?php require('header.php');  ?>

<?php  
  $sql = 'SELECT COUNT(*) AS total FROM event_pics INNER JOIN events ON event_pics.event_id = events.event_id AND events.e_end_date > CURDATE()';
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
  $pic_count = $stmt->fetch(PDO::FETCH_ASSOC);

  $event_number = mt_rand(0, $pic_count['total']-1);

  $sql = 'SELECT * FROM event_pics INNER JOIN events ON event_pics.event_id = events.event_id AND events.e_end_date > CURDATE()';
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
  while ($e_info = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $e_infos[] = $e_info;
  }

?>


  <section class="parallax-window" data-parallax="scroll" data-image-src="<?php echo $e_infos[$event_number]['e_pic_path'] ?>" data-natural-width="1400" data-natural-height="470">
    <div class="parallax-content-1">
      <div class="animated fadeInDown">
        <h1><?php echo $e_infos[$event_number]['e_name'] ?></h1>

        <?php 
              $starts = explode('-', $e_infos[$event_number]['e_start_date']);
              $ends = explode('-', $e_infos[$event_number]['e_end_date']);

              if ($starts[0] != $ends[0]) {
                  $duration = date('F d, Y', strtotime(implode('-', $starts))) .' - ' . date('F d, Y', strtotime(implode('-', $ends)));
              } elseif($starts[1] != $ends[1]){
                  $duration = date('F d', strtotime(implode('-', $starts))) .' - ' . date('F d, Y', strtotime(implode('-', $ends)));
              } elseif($starts[2] != $ends[2]){
                  $duration = date('F d', strtotime(implode('-', $starts))) .' - ' . date('d, Y', strtotime(implode('-', $ends)));
              } else{
                  $duration = date('F d, Y', strtotime(implode('-', $starts)));
              } 
        ?>
        <p><?php echo $duration ?></p>
      </div>
    </div>
  </section>
  <!-- End section -->

  <main>
    <div class="margin_60 container">      
      <div id="tabs" class="tabs">
        <br>
        <nav>
          <ul>
            <li><a href="#section-1" class="icon-calendar"><span>will join</span></a>
            </li>
            <li><a href="#section-2" class="icon-wishlist"><span>liked</span></a>
            </li>
<!--             <li><a href="#section-3" class="icon-back-in-time"><span>Reveiw</span></a>
            </li> -->
            <li><a href="#section-4" class="icon-hourglass"><span>Joined</span></a>
            </li>
            <li><a href="#section-5" class="icon-profile"><span>Profile</span></a>
            </li>
          </ul>
        </nav>
        <div class="content">

<!-- 
  ####  ###### #### ###### ###### ####  ##  ##         ##    
 ##  ## ##    ##  ##  ##     ##  ##  ## ##  ##        ###    
 ##     ##    ##      ##     ##  ##  ## ### ##         ##    
  ####  ##### ##      ##     ##  ##  ## ######  ###### ##    
     ## ##    ##      ##     ##  ##  ## ## ###         ##    
 ##  ## ##    ##  ##  ##     ##  ##  ## ##  ##         ##    
   ###  ###### ####   ##   ###### ####  ##  ##       ######  

 ##   ## ###### ##     ##        ##### #### ###### ##  ##  
 ##   ##   ##   ##     ##          ## ##  ##  ##   ##  ##  
 ## # ##   ##   ##     ##          ## ##  ##  ##   ### ##  
 ## # ##   ##   ##     ##          ## ##  ##  ##   ######  
 #######   ##   ##     ##          ## ##  ##  ##   ## ###  
 ### ###   ##   ##     ##       ## ## ##  ##  ##   ##  ##  
 ##   ## ###### ###### ######    ###   #### ###### ##  ##  

 -->
          <section id="section-1">
          <?php if (isset($f_events)): ?>
            <?php for ($i=0; $i < count($f_events) ; $i++) { ?>
              <?php
                $sql = 'SELECT * FROM event_pics WHERE event_id=? limit 1';

                $data = [$f_events[$i]['event_id']];
                $stmt = $dbh->prepare($sql);
                $stmt->execute($data);
                $f_event_pic = $stmt->fetch(PDO::FETCH_ASSOC);


               ?>
              <div class="strip_booking">
                <div class="row">
                  <div class="col-md-2 col-sm-2">
                    <div class="date" style="background-color:#FF6666; border-radius: 5px;">
                      <img class="day" src="<?php echo htmlspecialchars($f_event_pic['e_pic_path']); ?>" style=" height: 100px; padding:5px;width:100%; border-radius: 10px;">

                    </div>
                  </div>
                  <div class="col-md-6 col-sm-5">
                    <h3 class="tours_booking"><?php echo htmlspecialchars($f_events[$i]['e_name']); ?><span><?php echo htmlspecialchars($f_events[$i]['e_prefecture']); ?></span></h3>
                  </div>

                  <div class="col-md-2 col-sm-3" ">
                    <ul class="info_booking" style="padding-top:23px; padding-bottom:20px; padding-right:0px; text-align: left; font-size: 15px;">

                      <li><strong>Event start</strong><?php echo htmlspecialchars(date('F d, Y', strtotime($f_events[$i]['e_start_date']))); ?></li>
                      <li><strong>Event end</strong><?php echo htmlspecialchars(date('F d, Y', strtotime($f_events[$i]['e_end_date']))); ?></li>
                    </ul>
                  </div>
                  <div class="col-md-2 col-sm-2">
                    <div class="booking_buttons" style="padding-top: 14px">
                      <a href="event_detail.php?event_id=<?php echo htmlspecialchars($p_events[$i]['event_id']); ?>" class="btn_2" style="font-size: 14px; font-weight: 400; line-height: 1.42857143">Detail</a>

                    </div>
                  </div>
                </div>
                <!-- End row -->
              </div>
            <?php } ?>
          <?php else: ?>
            <p>参加予定のイベントはありません。</p>
          <?php endif; ?>

          </section> 
          <!-- End section 1 -->

<!-- 
  ####  ###### #### ###### ###### ####  ##  ##       ####   
 ##  ## ##    ##  ##  ##     ##  ##  ## ##  ##      ##  ##  
 ##     ##    ##      ##     ##  ##  ## ### ##          ##  
  ####  ##### ##      ##     ##  ##  ## ######  ###### ##   
     ## ##    ##      ##     ##  ##  ## ## ###        ##    
 ##  ## ##    ##  ##  ##     ##  ##  ## ##  ##       ##     
   ###  ###### ####   ##   ###### ####  ##  ##      ######  

 ##     ###### ##  ## ######  
 ##       ##   ## ##  ##      
 ##       ##   ####   ##      
 ##       ##   ###    #####   
 ##       ##   ####   ##      
 ##       ##   ## ##  ##      
 ###### ###### ##  ## ######  
 -->

          <section id="section-2">
          <div class="row">


            <?php for ($i=0; $i < count($likes) ; $i++) { ?>
            <?php


              // $sql = 'SELECT * FROM event_pics WHERE event_id=? limit 1';

              // $data = [$records[$i]['event_id']];
              // $stmt = $dbh->prepare($sql);
              // $stmt->execute($data);
              // $event_pic = $stmt->fetch(PDO::FETCH_ASSOC);

              $starts = explode('-', $likes[$i]['e_start_date']);
              $ends = explode('-', $likes[$i]['e_end_date']);

              if ($starts[0] != $ends[0]) {
                  $duration = date('F d, Y', strtotime(implode('-', $starts))) .' - ' . date('F d, Y', strtotime(implode('-', $ends)));
              } elseif($starts[1] != $ends[1]){
                  $duration = date('F d', strtotime(implode('-', $starts))) .' - ' . date('F d, Y', strtotime(implode('-', $ends)));
              } elseif($starts[2] != $ends[2]){
                  $duration = date('F d', strtotime(implode('-', $starts))) .' - ' . date('d, Y', strtotime(implode('-', $ends)));
              } else{
                  $duration = date('F d, Y', strtotime(implode('-', $starts)));
              }

              $sql = 'SELECT * FROM event_pics WHERE event_id=? limit 1';

              $data = [$likes[$i]['event_id']];
              $stmt = $dbh->prepare($sql);
              $stmt->execute($data);
              $l_event_pic = $stmt->fetch(PDO::FETCH_ASSOC);

                // echo '<pre>';
                // var_dump($likes[$i]);
                // echo '</pre>';

              //join数カウント
              $sql = 'SELECT COUNT(*) AS total FROM joins WHERE event_id=?';
              $data = [$likes[$i]['event_id']];
              $stmt = $dbh->prepare($sql);
              $stmt->execute($data);
              $join_count_total = $stmt->fetch(PDO::FETCH_ASSOC);

              //like数カウント
              $sql = 'SELECT COUNT(*) AS total FROM likes WHERE event_id=?';
              $data = [$likes[$i]['event_id']];
              $stmt = $dbh->prepare($sql);
              $stmt->execute($data);
              $like_count_total = $stmt->fetch(PDO::FETCH_ASSOC);


            ?>


              <div class="col-md-4 col-sm-6">
                <div class="tour_container">
                  <div class="img_container">
                    <a href="event_detail.php?event_id=<?php echo htmlspecialchars($likes[$i]['event_id']); ?>">
                      <img src="<?php echo htmlspecialchars($l_event_pic['e_pic_path']); ?>" width="800" height="533" class="img-responsive" alt="Image" style="height: 220px;">
<!--                       <div class="ribbon top_rated">
                      </div> -->
                      <div class="short_info hotel">
                          <span class="like_count">Like:<span class="like_count_change_<?php echo htmlspecialchars($records[$i]['event_id']); ?>"><?php echo $like_count_total['total']; ?></span></span> 
                                                          
                          <span class="join_count">Join:<span class="join_count_change_<?php echo htmlspecialchars($records[$i]['event_id']); ?>"><?php echo $join_count_total['total']; ?></span></span> 
                       

                      </div>
                    </a>
                  </div>
                  <div class="tour_title">
                    <h3><strong><?php echo htmlspecialchars($likes[$i]['e_name']); ?></strong></h3>
                    <div><?php echo $duration; ?></div>

                    <!-- end rating -->

                  </div>
                </div>
                <!-- End box tour -->
              </div>
              <!-- End col-md-6 -->

          <?php } ?>
           </div>
          </section>

          <!-- End section 2 -->

<!-- 
  ####  ###### #### ###### ###### ####  ##  ##        ####   
 ##  ## ##    ##  ##  ##     ##  ##  ## ##  ##       ##  ##  
 ##     ##    ##      ##     ##  ##  ## ### ##           ##  
  ####  ##### ##      ##     ##  ##  ## ######  ###### ###   
     ## ##    ##      ##     ##  ##  ## ## ###           ##  
 ##  ## ##    ##  ##  ##     ##  ##  ## ##  ##       ##  ##  
   ###  ###### ####   ##   ###### ####  ##  ##        ####   

 #####  ###### ##  ## ###### ###### ##   ## 
 ##  ## ##     ##  ##   ##   ##     ##   ## 
 ##  ## ##     ##  ##   ##   ##     ## # ## 
 #####  #####  ##  ##   ##   #####  ## # ## 
 ## ##  ##     ##  ##   ##   ##     ####### 
 ##  ## ##      ####    ##   ##     ### ### 
 ##  ## ######   ##   ###### ###### ##   ## 
 -->

<!-- 

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
            </div> -->
            <!-- End row -->

<!--             <hr>
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
            </div> -->
            <!-- End row -->
<!--           </section> -->
          <!-- End section 3 -->

<!-- 
  ####  ###### #### ###### ###### ####  ##  ##            ##   
 ##  ## ##    ##  ##  ##     ##  ##  ## ##  ##           ###   
 ##     ##    ##      ##     ##  ##  ## ### ##          ####   
  ####  ##### ##      ##     ##  ##  ## ######  ###### ## ##   
     ## ##    ##      ##     ##  ##  ## ## ###         ######  
 ##  ## ##    ##  ##  ##     ##  ##  ## ##  ##            ##   
   ###  ###### ####   ##   ###### ####  ##  ##            ##   

  ##### #### ###### ##  ## ###### ####    
    ## ##  ##  ##   ##  ## ##     ## ##   
    ## ##  ##  ##   ### ## ##     ##  ##  
    ## ##  ##  ##   ###### #####  ##  ##  
    ## ##  ##  ##   ## ### ##     ##  ##  
 ## ## ##  ##  ##   ##  ## ##     ## ##   
  ###   #### ###### ##  ## ###### ####   
 -->

          <section id="section-4">
          <?php if (isset($p_events)): ?>
            <?php for ($i=0; $i < count($p_events) ; $i++) { ?>
              <?php
                //イベント写真取得
                $sql = 'SELECT * FROM event_pics WHERE event_id=? limit 1';
                $data = [$p_events[$i]['event_id']];
                $stmt = $dbh->prepare($sql);
                $stmt->execute($data);
                $p_event_pic = $stmt->fetch(PDO::FETCH_ASSOC);

                //レビュー済み判定

                $sql = 'SELECT COUNT(*) AS total FROM reviews WHERE event_id = ? AND user_id = ?';
                $data = [$p_events[$i]['event_id'], $login_user['user_id']];
                $stmt = $dbh->prepare($sql);
                $stmt->execute($data);
                $review_count = $stmt->fetch(PDO::FETCH_ASSOC);


               ?>
              <div class="strip_booking">
                <div class="row">
                  <div class="col-md-2 col-sm-2">
                    <div class="date" style="background-color:#008000; border-radius: 5px;">
                      <img class="day" src="<?php echo htmlspecialchars($p_event_pic['e_pic_path']); ?>" style="height: 100px; padding:5px;width:100%; border-radius: 10px;">
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-5">
                    <h3 class="tours_booking"><?php echo htmlspecialchars($p_events[$i]['e_name']); ?><span><?php echo htmlspecialchars($p_events[$i]['e_prefecture']); ?></span></h3>
                  </div>
                  <div class="col-md-2 col-sm-3" ">
                    <ul class="info_booking" style="padding-top:23px; padding-bottom:20px; padding-right:0px; text-align: left; font-size: 15px;">
                      <li><strong>Event start</strong><?php echo htmlspecialchars(date('F d, Y', strtotime($p_events[$i]['e_start_date']))); ?></li>
                      <li><strong>Event end</strong><?php echo htmlspecialchars(date('F d, Y', strtotime($p_events[$i]['e_end_date']))); ?></li>
                    </ul>
                  </div>
                  <div class="col-md-2 col-sm-2">
                      <?php if ($review_count['total'] == 0) { ?>

                        <div class="" style="margin-top: 17px;">
                        <a href="#" class="btn_1 add_bottom_30" data-toggle="modal" data-target="#myReview" id="<?php echo htmlspecialchars($p_events[$i]['event_id']); ?>" style="margin-bottom: 0px; width: 100%;" >Review</a>
                        
                      <?php } else if($review_count['total'] > 0){ ?>

                        <div class="" style="margin-top: 5px;">
                        <button type="button" class="btn btn-outline-secondary" style="margin-bottom: 0px; width: 100%;" disabled>Reviewed</button>

                      <?php } ?>

                    </div>
                    <div class="booking_buttons" style="padding-top: 0px">
                      <a href="event_detail.php?event_id=<?php echo htmlspecialchars($p_events[$i]['event_id']); ?>" class="btn_2" style="font-size: 14px; font-weight: 400; line-height: 1.42857143">Detail</a>
                    </div>
                  </div>
                </div>
                <!-- End row -->
              </div>
            <?php } ?>
          <?php else: ?>
            <p>参加済みのイベントはありません。</p>
          <?php endif; ?>

          </section> 

          <!-- End section 4 -->
<!-- 
  ####  ###### #### ###### ###### ####  ##  ##     ######  
 ##  ## ##    ##  ##  ##     ##  ##  ## ##  ##     ##      
 ##     ##    ##      ##     ##  ##  ## ### ##     #####   
  ####  ##### ##      ##     ##  ##  ## ######  ###### ##  
     ## ##    ##      ##     ##  ##  ## ## ###         ##  
 ##  ## ##    ##  ##  ##     ##  ##  ## ##  ##     ##  ##  
   ###  ###### ####   ##   ###### ####  ##  ##      ####   

 #####  #####   ####  ###### ###### ##     ######  
 ##  ## ##  ## ##  ## ##       ##   ##     ##      
 ##  ## ##  ## ##  ## ##       ##   ##     ##      
 #####  #####  ##  ## #####    ##   ##     #####   
 ##     ## ##  ##  ## ##       ##   ##     ##      
 ##     ##  ## ##  ## ##       ##   ##     ##      
 ##     ##  ##  ####  ##     ###### ###### ######  
 -->
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

    <!-- フッター呼び出し -->
    <?php require('footer.php'); ?>

    <!-- モーダル・ログイン -->
    <?php require('modal_login.php'); ?>

    <!-- モーダル・ユーザー登録 -->
    <?php require('modal_register_user.php'); ?>

    <!-- モーダル・主催者登録 -->
    <?php require('modal_register_organizer.php'); ?>

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

<!--       <script src="js/common_scripts_min.js"></script> -->
<!--       <script src="js/common_scripts_min.js"></script> -->
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
    <script src="js/notify_func.js"></script>
    <script src="js/modal_login_ajax.js"></script>
    <script src="js/modal_register_user_ajax.js"></script>
    <script src="js/modal_register_organizer_ajax.js"></script>
    <script src="js/join_ajax.js"></script>
    <script src="js/like_ajax.js"></script>

    <!-- 自作のJS -->
    <script src="js/custom.js"></script>
<!--     <script src="js/bootstrap.js"></script> -->

</body>

</html>