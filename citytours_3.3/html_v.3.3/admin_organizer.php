<?php 
session_start();
require('../../common/dbconnect.php');
require('../../common/functions.php');
$login_user = get_login_user($dbh);



// echo 'flag' . $_SESSION['flag'];
// echo '<br>';
// echo 'id' . $_SESSION['id'];



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
/*session-5 End*/

/*session-1*/
$word = '';
if (isset($_GET['search_word']) && !empty($_GET['search_word'])) {
  
  $word = $_GET['search_word'];
  
  $e_sql = sprintf('SELECT * FROM events WHERE o_id=%s AND e_name LIKE "%%%s%%" ORDER BY e_start_date ASC', $login_user['o_id'], $word);
  
  $e_stmt = $dbh->prepare($e_sql);
  $e_stmt->execute();
} else {
  $e_sql = 'SELECT * FROM events WHERE o_id=? ORDER BY e_start_date ASC';
  $e_data = [$login_user['o_id']];
  $e_stmt = $dbh->prepare($e_sql);
  $e_stmt->execute($e_data);
} 

$events = array();

while ($e_record = $e_stmt->fetch(PDO::FETCH_ASSOC)) {
  $events[] = $e_record;
}
$count = count($events);
/*session-1 End*/

/*session-3*/
$past_sql = 'SELECT events.*,event_pics.e_pic_path FROM events LEFT JOIN event_pics ON events.event_id = event_pics.event_id WHERE events.o_id=? AND events.e_end_date < CURDATE()';
$past_date = [$login_user['o_id']];
$past_stmt = $dbh->prepare($past_sql);
$past_stmt->execute($past_date);

$past_events = array();

while ($past_record = $past_stmt->fetch(PDO::FETCH_ASSOC)) {
  $past_events[] = $past_record; 
}
$past_count = count($past_events);

// var_dump($login_user['o_id']);
/*session-3 End*/

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
  </section>
  <!-- End section -->

  <main>
      <!-- <div id="position">
        <div class="container">
          <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">Category</a></li>
            <li>Page active</li>
          </ul>
        </div>
      </div> -->
    <!-- End Position -->

    <div class="margin_60 container">      
      <h1 class="welcom" style="text-align:center;">Welcome!&nbsp&nbsp<?php echo htmlspecialchars($login_user['o_name']); ?>様</h1><br>      
      <div id="tabs" class="tabs">
        <nav>
          <ul>
            <li><a href="#section-1" class="icon-calendar"><span>登録済みイベント一覧</span></a>
            </li>
            <li><a href="#section-2" class="icon-wishlist"><span>イベント登録</span></a>
            </li>
            <li><a href="#section-3" class="icon-back-in-time"><span>実施済みイベント </span></a>
            </li>
            <!-- <li><a href="#section-3-2" class="icon-back-in-time"><span>実施済みイベント② </span></a>
            </li> -->
            <li><a href="#section-5" class="icon-profile"><span>Profile</span></a>
            </li>
          </ul>
        </nav>

        <div class="content">
          <section id="section-1">
            <div id="tools" class="col-md-12">
              <form method="GET" action="">
                <div class="row">
                  <div class="col-md-3 col-sm-3 col-xs-6">
                    <div> 
                      <span class="input-group">
                      <input type="text" name="search_word" placeholder="イベント名"　value="<?php echo htmlspecialchars($word); ?>">
                      <button class="btn btn-default" type="submit" style="margin-left:0;"><i class="icon-search"></i></button>
                      </span>
                    </div>                                   
                  </div>                
                </div>
              </form>
            </div>
          <!--/tools -->

            <div class="strip_booking col-md-12">
              <?php for ($i=0; $i <$count ; $i++) { ?>
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
                          <div class="rating"></div>
                            <h3><strong><?php echo htmlspecialchars($events[$i]['e_name']); ?></strong></h3>
                            <p><?php echo htmlspecialchars($events[$i]['explanation']); ?></p>
                            <p><?php echo htmlspecialchars($events[$i]['e_start_date']); ?></p>
                        </div>
                      </div>
                      <div class="col-lg-2 col-md-2 col-sm-2">
                        <div class="price_list">
                          <div>
                            <p><a href="#0" class="btn_1">詳細</a></p><br>
                            <p><a href="event_input.php" class="btn_1">編集</a></p> 
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <?php } ?>
              <!-- End row -->              
            </div>
            <!-- End strip booking -->
          </section>
          <!-- End section 1 -->


          <section id="section-2">
          </section>
          <!-- End section 2 -->

          <!-- 過去のFMT(不要) -->
          
          
          <section id="section-3">
          <div id="tools" class="col-md-12">
            <form method="GET" action="">
              <div class="row">
                <div class="col-md-3 col-sm-3 col-xs-6">
                  <div> 
                    <span class="input-group">
                    <input type="text" name="search_word" placeholder="イベント名"　value="<?php echo htmlspecialchars($word); ?>">
                    <button class="btn btn-default" type="submit" style="margin-left:0;"><i class="icon-search"></i></button>
                    </span>
                  </div>                                   
                </div>                
              </div>
            </form>
          </div>


          <?php for ($i=0; $i <$past_count ; $i++) { ?>              
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
                    <a href="review_modal.php?event_id=<?php echo htmlspecialchars($past_events[$i]['event_id']); ?>"><img src="../../o_pic/<?php echo htmlspecialchars($past_events[$i]['e_pic_path']) ?>" alt="Image">
                    <!-- <div class="short_info"><i class="icon_set_1_icon-4"></i>Museums </div> -->
                    </a>
                  </div>
                </div>
                <div class="clearfix visible-xs-block"></div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                  <div class="tour_list_desc">
                    <div class="rating"></div>
                      <h3><strong><?php echo htmlspecialchars($past_events[$i]['e_name']); ?></strong></h3>
                      <p><?php echo htmlspecialchars($past_events[$i]['explanation']); ?></p>
                      <p><?php echo htmlspecialchars($past_events[$i]['e_start_date']); ?></p>
                  </div>  
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2">
                  <div class="price_list">
                    <div>
                      <p><a href="review_modal.php?event_id=<?php echo htmlspecialchars($past_events[$i]['event_id']); ?>" class="btn_1">レビューを見る</a></p><br>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php } ?>               
          <!-- End row --> 
          </section>
          <!-- End section 3 -->

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
                <div>
                  <button class="btn_1 green" onclick="obj=document.getElementById('open').style; obj.display=(obj.display=='none')?'block':'none';">編集</button>
                </div>
              </div>
              <div class="col-md-5 col-sm-5">
                <img src="../../o_pic/<?php echo htmlspecialchars($login_user['o_pic']); ?>" width="300" alt="Image" class="img-responsive styled profile_pic"><!-- フォルダ名/データ名 -->
              </div>
            </div>
            <!-- End row -->
            <form method="POST" action="" enctype="multipart/form-data">
              <div class="divider"></div> <!-- 線 -->
              <div id="open" style="display:none;clear:both;" >
                <div class="row">
              <div class="col-md-12">
                <h4 id="edit_profile">現在のパスワードを入力してください</h4>
              </div>
              <div class="col-md-12 col-sm-12">
                <table class="table table-bordered">
                  <thead>
                    <tbody>
                      <tr>
                        <th class="col-md-3 col-sm-3">現在のパスワード </th>
                        <td>
                          <input type="password" class="form-control" name="o_current_password" id="o_current_password" type="password">
                        </td>
                        <?php if(isset($errors['o_current_password']) && $errors['o_current_password'] == 'failed') { ?>
                          <p class="alert-danger">本人確認に失敗しました。再度現在のパスワードを入力してください</p>
                        <?php } ?>
                      </tr> 
                    </tbody>
                  </thead>
                </table>
                <div>
                  <a class="btn_1 green" onclick="obj=document.getElementById('open1').style; obj.display=(obj.display=='none')?'block':'none';">確認</a>
                </div>
                <div class="divider"></div> <!-- 線 -->

                <div id="open1" style="display:none;clear:both;" >



            <div class="row">
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
                        <!-- <tr>
                          <th>現在のパスワード</th>
                            <td>
                              <input type="password" class="form-control" name="o_current_password" id="o_current_password" type="password">
                            </td>
                            <?php if(isset($errors['o_current_password']) && $errors['o_current_password'] == 'failed') { ?>
                              <p class="alert-danger">本人確認に失敗しました。再度現在のパスワードを入力してください</p>
                            <?php } ?>
                        </tr> -->
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

 


            <a href="#a1"><button type="submit" class="btn_1 green">更新</button></a>
            <div id="open2" style="display:none;clear:both;">
  
    </div>
    </div> 
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

  <!-- フッター呼び出し -->
  <?php require('footer.php'); ?>

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


  <script>
    function dropsort() {
    var browser = document.sort_form.sort.value;
    location.href = browser
}
  </script>

</body>

</html>