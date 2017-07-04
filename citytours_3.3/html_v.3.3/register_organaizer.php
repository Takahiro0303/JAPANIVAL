<?php 
session_start();
require('../../dbconnect.php');
require('../../layout/functions.php');


// 登録時バリデーション

    $o_name = '';
    $o_f_name ='';
    $o_email ='';

    $errors = array();

if (!empty($_POST)) {
    $o_name = $_POST['o_name'];
    $o_f_name = $_POST['o_f_name'];
    $o_postal = $_POST['o_postal'];
    $o_pref = $_POST['o_pref'];
    $o_address = $_POST['o_address'];
    $o_password = $_POST['o_password'];
    $o_confirm_password = $_POST['o_confirm_password'];
    $o_tel = $_POST['o_tel'];
    $o_email = $_POST['o_email'];
    $o_intro = $_POST['o_intro'];



    if ($o_name == '') {
        $errors['o_name'] = 'blank';
        }
    if ($o_f_name == '') {
        $errors['o_f_name'] = 'blank';
        }
    if ($o_f_name == '') {
        $errors['o_postal'] = 'blank';
        }
    if ($o_f_name == '') {
        $errors['o_pref'] = 'blank';
        }
    if ($o_f_name == '') {
        $errors['o_address'] = 'blank';
        }
    if ($o_tel == '') {
        $errors['o_tel'] = 'blank';
    }
    if ($o_email == '') {
        $errors['o_email'] = 'blank';
    }
    
//パスワードの暗号化
    $count = strlen($o_password);
    if ($o_password == '') {
        $errors['o_password'] = 'blank';
        }elseif ($count < 6) {
        $errors['o_password'] = 'length';
        }

    if (!isset($_REQUEST['action'])) {
            $file_name = $_FILES['o_pic']['name'];

        }

    if ($o_password !== $o_confirm_password) {
        $errors['o_password'] = 'wrong';
    }

    if (!empty($file_name)) {
        $ext = substr($file_name, -3);
        $ext = strtolower($ext);
        if ($ext != 'jpg' && $ext != 'png' && $ext != 'gif') {
            $errors['o_pic'] = 'type';
            }
        }else{
        $errors['o_pic'] = 'blank';
        }

        var_dump($errors['o_pic']);

    if (empty($errors)) {
        $sql = 'SELECT COUNT(*) FROM `organizers` WHERE `o_email` = ?';
        $data = array($o_email);
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);

        $o_record = $stmt->fetch(PDO::FETCH_ASSOC);
        $count = $o_record['COUNT(*)'];
    if ($count > 0) {
        $errors['o_email'] = 'duplicate';
        }
    }

    if (empty($errors)) {
        $date_str = date('YmdHis');
        $submit_file_name = $date_str . $_FILES['o_pic']['name'];
        move_uploaded_file($_FILES['o_pic']['tmp_name'], 'o_pic/' . $submit_file_name);
        $_SESSION['join'] = $_POST;
        $_SESSION['join']['o_pic'] = $submit_file_name;

        $sql = 'INSERT INTO `organizers` SET `o_name` =?, `o_f_name` =?, `o_postal` =?, `o_pref` =?, `o_address` =?, `o_tel` =?, `o_email` =?, `o_password` =?, `o_intro` =?, `o_pic` =?, `created` =NOW()';
        $data = array($o_name,$o_f_name,$o_postal,$o_pref,$o_address,$o_tel,$o_email,sha1($o_password),$o_intro,$_SESSION['join']['o_pic']);
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);


        header('Location:index.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<!--[if IE 8]><html class="ie ie8"> <![endif]-->
<!--[if IE 9]><html class="ie ie9"> <![endif]-->
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <meta name="description" content="Citytours - Premium site template for city tours agencies, transfers and tickets.">
    <meta name="author" content="Ansonika">
    <title>JAPANIVAL</title>
    
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
    
    <!-- CSS -->
    <link href="css/flickity.css" rel="stylesheet">
    
    <!--[if lt IE 9]>
      <script src="js/html5shiv.min.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
    <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
        
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

     <!-- main================================================== -->
    <form method="POST" action="register_organizers.php" enctype="multipart/form-data">   
	<main>
    <section id="hero" class="login">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
                    <div id="login">
                        <div class="text-center"><img src="img/japanival.png" alt="Image" data-retina="true" >
                        </div>
                        <hr>
                        <form>
                            <div class="form-group">
                                    <label>団体名</label>
                                    <input type="text" name="o_name" class=" form-control"  placeholder="">
                                    <?php if (isset($errors['o_name']) && $errors['o_name'] == 'blank') { ?>
                                    <p class="error">団体名を記入してください</p>
                                    <?php } ?>
                                </div>
                                <div class="form-group">
                                    <label>フリガナ</label>
                                    <input type="text" name="" class=" form-control"  placeholder="">
                                </div>
                                <div class="form-group">
                                    <label>代表者名</label>
                                    <input type="text" name="o_f_name" class=" form-control" placeholder="">
                                    <?php if (isset($errors['o_f_name']) && $errors['o_f_name'] == 'blank') { ?>
                                    <p class="error">代表者名を記入してください</p>
                                    <?php } ?>
                                </div>
                                <div class="form-group">
                                    <label>フリガナ</label>
                                    <input type="text" name="" class=" form-control"  placeholder="">
                                </div>
                                <div class="form-group">
                                    <label>郵便番号</label>
                                    <input type="text" name="o_postal" class="form-control"  maxlength="8" onKeyUp="AjaxZip3.zip2addr(this,'','o_pref','o_address');">
                                    <?php if (isset($errors['o_postal']) && $errors['o_postal'] == 'blank') { ?>
                                    <p class="error">郵便番号を記入してください</p>
                                    <?php } ?>
                                </div>
                                <div class="form-group">
                                    <label>都道府県</label>
                                    <input type="text" name="o_pref" class="form-control">
                                    <?php if (isset($errors['o_pref']) && $errors['o_pref'] == 'blank') { ?>
                                    <p class="error">都道府県をを記入してください</p>
                                    <?php } ?>
                                </div>
                                <div class="form-group">
                                    <label>市区町村・番地・建物名・号室</label>
                                    <input type="text" name="o_address" class="form-control" size="60">
                                    <?php if (isset($errors['o_address']) && $errors['o_address'] == 'blank') { ?>
                                    <p class="error">市町村を記入してください</p>
                                    <?php } ?>
                                </div>
                                <div class="form-group">
                                    <label>電話番号</label>
                                    <input type="text" name="o_tel" class="form-control">
                                    <?php if (isset($errors['o_tel']) && $errors['o_tel'] == 'blank') { ?>
                                    <p class="error">電話番号を記入してください</p>
                                    <?php } ?>
                                </div>
                                <div class="form-group">
                                    <label>メールアドレス</label>
                                    <input type="email" name="o_email" class=" form-control" placeholder="">
                                    <?php if (isset($errors['o_email']) && $errors['o_email'] == 'blank') { ?>
                                    <p class="error">メールアドレスを記入してください</p>
                                    <?php } ?>
                                    <?php if (isset($errors['o_email']) && $errors['o_email'] == 'duplicate') { ?>
                                    <p class="error">そのメールアドレスは既に登録されています</p>
                                    <?php } ?>
                                </div>
                                <div class="form-group">
                                    <label>パスワード</label>
                                    <input type="password" name="o_password" class=" form-control" id="password1">
                                    <?php if (isset($errors['o_password']) && $errors['o_password'] == 'blank') { ?>
                                    <p class="error">パスワードを記入してください</p>
                                    <?php } ?>
                                    <?php if (isset($errors['o_password']) && $errors['o_password'] == 'length') { ?>
                                    <p class="error">パスワードは6文字以上で入力してください</p>
                                    <?php } ?>
                                </div>
                                <div class="form-group">
                                    <label>もう一度パスワードを入力してください</label>
                                    <input type="password" name="o_confirm_password" class=" form-control" id="password2">
                                    <?php if (isset($errors['o_password']) && $errors['o_password'] == 'wrong') { ?>
                                    <p class="alert-danger">パスワードが一致しません</p>
                                    <?php } ?>
                                </div>
                                <div class="form-group">
                                    <label>自己紹介コメント</label><br>
                                    <textarea name="o_intro" class="form-control"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Photo</label>
                                    <div class="form-group">
                                        <input type="file" name="o_pic" id="js-upload-files">
                                        <?php if (isset($errors['o_pic']) && $errors['o_pic'] == 'type') { ?>
                                        <p class="error">画像はjpg,png,gifの画像を選択してください</p>
                                        <?php } ?>
                                        <?php if (!empty($errors)) { ?>
                                        <p class="error">画像を選択してください</p>
                                        <?php } ?>
                                    </div> 
                                </div>
                                <div>
                                    <button class="btn_full">Create an account</button>
                                </div> 
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

                           
                                                                   
                     
                
            
        
    
	</main><!-- End main -->
</form>
	   
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
<script src="//code.jquery.com/jquery-2.1.0.min.js" type="text/javascript"></script>
<script src="//jpostal-1006.appspot.com/jquery.jpostal.js" type="text/javascript"></script>


 <!-- Specific scripts -->
<script src="js/pw_strenght.js"></script>

  </body>
</html>