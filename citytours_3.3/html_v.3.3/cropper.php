<?php 
session_start();
require('../../common/dbconnect.php');
require('../../common/functions.php');

$login_user = get_login_user($dbh);

var_dump($_POST);

//バリデーションエラーの内容を保持する配列
$errors = array();

if (!empty($_POST['cropp_file_name'])) { // 送信ボタンが押されたとき
  $top_pic = $_POST['cropp_file_name'];

  // エラーがなかったとき
  if (empty($errors)) {
      $date_str = date('YmdHis');
      /*echo'aaaaa';*/
      $submit_file_name = $date_str . '_top_picture.png';

      $img = $top_pic;
      $img = str_replace('data:image/png;base64,', '', $img);
      $img = str_replace(' ', '+', $img);
      $fileData = base64_decode($img);

      file_put_contents('../../event_pictures/event_top_pictures/'.$submit_file_name,$fileData);

      //送信データを$_SESSIONに登録
      $_SESSION['event']['cropp_file_name'] = $submit_file_name;    
  }
}

//送信ボタンが押された際の処理
/*if (!empty($_POST)) {
  //データベースへの登録
  $sql = 'INSERT INTO event_pics SET top_pic_flag=?,
                                     event_id=?,
                                     cropp_file_name=?
                                     created=NOW()';
  $data = ['1',
           ];
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data);
}*/



echo '<br>';
var_dump($errors);
echo '<br>';
var_dump($_SESSION['event']['cropp_file_name']);
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
  <title>JAPANIVAL-画像トリミング</title>

  <!-- Google web fonts -->
  <link href="https://fonts.googleapis.com/css?family=Gochi+Hand|Lato:300,400|Montserrat:400,400i,700,700i" rel="stylesheet">

  <!-- CSS -->
  <link href="css/base.css" rel="stylesheet">

  <!-- cropper -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/cropper/2.3.1/cropper.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="cropper.css">

<!--[if lt IE 9]>
<script src="js/html5shiv.min.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->
</head>
<body>
  <div class="layer"></div>
  
  <!-- Header================================================== -->
  <!-- header.phpのrequire -->
  <!-- <?php /*require('header.php');*/  ?> -->　<!-- ←反映し直すこと？！ -->
  <!-- End Header -->

  <main>
  <img src="img/japanival_logo.png" style="width: 200px;">
  <h1><strong>トップ画像をトリミングしてください</strong></h1>
    <div class="container margin_60">
      <div class="row">
        <div class="col-md-12">
          <form method="POST" action="cropper.php" enctype="multipart/form-data">
            <div>
              <button type="button" id="imgUpload" class="btn_1">画像を選択する</button>
              <input type="file" accept="image/*" name="top_picture_path">

              <h2>選択された画像</h2>
              <div class="my-gallery" style="border:solid 1px; width:100%; height:500px;"></div>

              <h2>プレビュー</h2>
              <div id="cropped" style="border:solid 1px;width:560px;height:188px;overflow:hidden;"></div>
              <input id="cropp_file_name" type="hidden" name="cropp_file_name">
              <button type="button" id="cropBtn">表示</button>              
              
              <input type="submit" class="btn_1" >
              <button type="button" id="resetBtn" class="btn_1">リセット</button>


            </div>
          </form> 
        </div>
      </div>
      <!--End row -->
    </div>
    <!--End container -->
  </main>
  <!-- End main -->

<!-- cropper scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropper/2.3.1/cropper.min.js"></script>
<script src="cropper.js"></script>

</body>
</html>