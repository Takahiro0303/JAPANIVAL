<?php 

session_start();
require('../../common/dbconnect.php');

  if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'rewrite') {
    //$_REQUEST, $_GET, $_POST, $_FILEの情報全てを持つスーパーグローバル変数
    //$_REQUESTと$_GETの使い分け
    //formのGET送信に対してのみ$_GETを使用

    $_POST = $_SESSION['event'];
    $errors['rewrite'] = true;
    echo 'aaaaaaaaaaaaa';
      echo '<pre>';
      var_dump($_POST);
      echo '</pre>';

  }

//変数の初期化
$nick_name = '';
$email = '';
$password = '';
$e_name = '';
$e_start_date = '';
$e_end_date = '';
$e_prefecture = '';
$e_postal = '';
$e_address = '';
$e_venue = '';
$e_o_name = '';
$e_o_tel = '';
$e_o_email = '';
$explanation = '';
$priority = '';
$start_year = '';
$year_p = '';
$year_pp = '';
$year_ppp = '';
$attendance_p = '';
$attendance_pp = '';
$attendance_ppp = '';
$official_url = '';
$related_url = '';

//バリデーションエラーの内容を保持する配列
$errors = array();

if (!empty($_POST)) {
  //$_POSTが空じゃなければ処理
  $e_name           = $_POST['e_name'];
  $e_start_date     = $_POST['e_start_date'];
  $e_end_date       = $_POST['e_end_date'];
  $e_prefecture     = $_POST['e_prefecture'];
  $e_postal         = $_POST['e_postal'];
  $e_address        = $_POST['e_address'];
  $e_venue          = $_POST['e_venue'];
  $e_o_name         = $_POST['e_o_name'];
  $e_o_tel          = $_POST['e_o_tel'];
  $e_o_email        = $_POST['e_o_email'];
  $explanation      = $_POST['explanation'];
  $start_year       = $_POST['start_year'];
  $year_p           = $_POST['year_p'];
  $year_pp          = $_POST['year_pp'];
  $year_ppp         = $_POST['year_ppp'];
  $attendance_p     = $_POST['attendance_p'];
  $attendance_pp    = $_POST['attendance_pp'];
  $attendance_ppp   = $_POST['attendance_ppp'];
  $official_url     = $_POST['official_url'];
  $related_url      = $_POST['related_url'];

  //イベント名の空チェック
  if ($e_name == '') {
      $errors['e_name'] = 'blank'; //blankの部分は自由
  }

  //イベント日程（開始日）の空チェック
  if ($e_start_date == '') {
      $errors['e_start_date'] = 'blank'; //blankの部分は自由
  }

//TODO!:日付エラーチェック
// $date = '2016-02-29';
 
// list($Y, $m, $d) = explode('-', $date);
 
// if (checkdate($m, $d, $Y) === true) {
//   echo $date;
// } else {
//   echo '存在しない日付です。';
// }

  //イベント日程（終了日）の空チェック
  if ($e_end_date == '') {
      $errors['e_end_date'] = 'blank'; //blankの部分は自由
  }

  //都道府県の空チェック
  if ($e_prefecture == '') {
      $errors['e_prefecture'] = 'blank'; //blankの部分は自由
  }

  //郵便番号の空チェック
  if ($e_postal == '') {
      $errors['e_postal'] = 'blank'; //blankの部分は自由
  }

  //その他の住所の空チェック
  if ($e_address == '') {
      $errors['e_address'] = 'blank'; //blankの部分は自由
  }

  //会場の空チェック
  if ($e_venue == '') {
      $errors['e_venue'] = 'blank'; //blankの部分は自由
  }

  //法人名（表示用）の空チェック
  if ($e_o_name == '') {
      $errors['e_o_name'] = 'blank'; //blankの部分は自由
  }

  //電話番号（表示用）の空チェック
  if ($e_o_tel == '') {
      $errors['e_o_tel'] = 'blank'; //blankの部分は自由
  }

  //email（表示用）の空チェック
  if ($e_o_email == '') {
      $errors['e_o_email'] = 'blank'; //blankの部分は自由
  }

  //説明文の空チェック
  if ($explanation == '') {
      $errors['explanation'] = 'blank'; //blankの部分は自由
  }

  //表示順の空チェック
  // if ($priority == '') {
  //     $errors['priority'] = 'blank'; //blankの部分は自由
  // }

  //開始年の空チェック
  if ($start_year == '') {
      $errors['start_year'] = 'blank'; //blankの部分は自由
  }

  // //前回開催年の空チェック
  // if ($year_p == '') {
  //     $errors['year_p'] = 'blank';
  // }

  // //前々回開催年の空チェック
  // if ($year_pp == '') {
  //     $errors['year_pp'] = 'blank';
  // }

  // //前前々回開催年の空チェック
  // if ($year_ppp == '') {
  //     $errors['year_ppp'] = 'blank';
  // }

  // //前回開催時の入場者数の空チェック
  // if ($attendance_p == '') {
  //     $errors['$attendance_p'] = 'blank';
  // }

  // //前々回開催時の入場者数の空チェック
  // if ($attendance_pp == '') {
  //     $errors['$attendance_pp'] = 'blank'; 
  // }

  // //前前々回開催時の入場者数の空チェック
  // if ($attendance_ppp == '') {
  //     $errors['$attendance_ppp'] = 'blank'; 
  // }

  // //公式URLの空チェック
  // if ($official_url == '') {
  //     $errors['official_url'] = 'blank'; 
  // }

  // //関連URLの空チェック
  // if ($related_url == '') {
  //     $errors['$related_url'] = 'blank';
  // }


  //書き直しなら$file_nameにfile_pathを入れない。つまり、書き直しの場合はあえて
  if (!isset($_REQUEST['action'])) {
    $file_name = $_FILES['e_pic_path']['name'];
  }




  //画像データの拡張子チェック
  //$_POST['name属性値']
  //$_FILES['name属性値']['各データへのキー']
  if (!empty($file_name)) { //画像が選択されていれば
    $ext = substr($file_name, -3);
    $ext = strtolower($ext);
    if ($ext != 'jpg' && $ext != 'png' && $ext != 'gif') {
      $errors['e_pic_path'] = 'type';
    }
  } else{
    //画像データ未選択の場合
    $errors['e_pic_path'] = 'blank';
  }

  //エラーがなかったときの処理
  if (empty($errors)) {
    
    //画像をサーバー上のmember_picturesへアップロード
    $date_str = date('YmdHis');
    $submit_file_name = $date_str . $_FILES['e_pic_path']['name'];

    move_uploaded_file($_FILES['e_pic_path']['tmp_name'], '../../event_pictures/' . $submit_file_name);

    //送信データを$_SESSIONに登録
    $_SESSION['event'] = $_POST;
    $_SESSION['event']['e_pic_path'] = $submit_file_name;

    echo '<pre>';
    var_dump($_POST);
    echo '</pre>';
    echo '<pre>';
    var_dump($errors);
    echo '</pre>';
    echo $submit_file_name;  ;

    //次のページへ遷移
    header('Location: event_input_check.php');
    exit();//ここでこのファイルの読み込みを強制終了
  }

      echo '<pre>';
      var_dump($_POST);
      echo '</pre>';
    echo '<pre>';
    var_dump($errors);
    echo '</pre>';
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title></title>
  <link rel="stylesheet" type="text/css" href="css/custom.css">
</head>
<body>
  <h1>イベント登録</h1>
  <form method="POST" action="event_input_index.php" enctype="multipart/form-data">
    
    <h3>イベント概要</h3>
    <div>
      イベント名（必須）<br>
      <input type="text" name="e_name" value="<?php echo htmlspecialchars($e_name); ?>">
      <?php if(isset($errors['e_name']) && $errors['e_name'] == 'blank') { ?>
        <p class="error">イベント名を入力してください</p>
      <?php } ?>
    </div>

    <div>
      イベント日程（開始日）（必須）※MM-DD-YYYYで入力してください。<br>
      <input type="text" name="e_start_date" value= "<?php echo htmlspecialchars($e_start_date); ?>">
      <?php if(isset($errors['e_start_date']) && $errors['e_start_date'] == 'blank') { ?>
        <p class="error">メールアドレス名を入力してください</p>
      <?php } ?>
    </div>

    <div>
      イベント日程（終了日）（必須）※MM-DD-YYYYで入力してください。<br>
      <input type="text" name="e_end_date" value= "<?php echo htmlspecialchars($e_end_date); ?>">
      <?php if(isset($errors['e_end_date']) && $errors['e_end_date'] == 'blank') { ?>
        <p class="error">メールアドレス名を入力してください</p>
      <?php } ?>
    </div>

    <h3>開催場所</h3>
    <div>
      都道府県（必須）<br>
      <input type="text" name= "e_prefecture" value="<?php echo htmlspecialchars($e_prefecture); ?>">
      <?php if(isset($errors['e_prefecture']) && $errors['e_prefecture'] == 'blank') { ?>
        <p class="error">都道府県を入力してください</p>
      <?php } ?>
    </div>

    <div>
      郵便番号（必須）<br>
      <input type="text" name="e_postal" value="<?php echo htmlspecialchars($e_postal); ?>">
      <?php if(isset($errors['e_postal']) && $errors['e_postal'] == 'blank') { ?>
        <p class="error">郵便番号を入力してください</p>
      <?php } ?>
    </div>

    <div>
      住所（必須）<br>
      <input type="text" name="e_address" value= "<?php echo htmlspecialchars($e_address); ?>">
      <?php if(isset($errors['e_address']) && $errors['e_address'] == 'blank') { ?>
        <p class="error">住所を入力してください</p>
      <?php } ?>
    </div>

    <div>
      会場（必須）<br>
      <input type="text" name="e_venue" value= "<?php echo htmlspecialchars($e_venue); ?>">
      <?php if(isset($errors['e_venue']) && $errors['e_venue'] == 'blank') { ?>
        <p class="error">会場を入力してください</p>
      <?php } ?>
    </div>

    <h3>主催者情報</h3>

    <div>
      主催者名（必須）<br>
      <input type="text" name="e_o_name" value= "<?php echo htmlspecialchars($e_o_name); ?>">
      <?php if(isset($errors['e_o_name']) && $errors['e_o_name'] == 'blank') { ?>
        <p class="error">主催者を入力してください</p>
      <?php } ?>
    </div>
    <!-- //TODO!:主催者情報から主催者名、電話番号、emailを取得 -->

    <div>
      電話番号（必須）<br>
      <input type="text" name="e_o_tel" value= "<?php echo htmlspecialchars($e_o_tel); ?>">
      <?php if(isset($errors['e_o_tel']) && $errors['e_o_tel'] == 'blank') { ?>
        <p class="error">電話番号を入力してください</p>
      <?php } ?>
    </div>

    <div>
      e-mail（必須）<br>
      <input type="text" name="e_o_email" value= "<?php echo htmlspecialchars($e_o_email); ?>">
      <?php if(isset($errors['e_o_email']) && $errors['e_o_email'] == 'blank') { ?>
        <p class="error">e-mailアドレスを入力してください</p>
      <?php } ?>
    </div>

    <h3>イベント説明/関連情報</h3>

    <div>
      説明文（必須）<br>
      <textarea name="explanation" col = "30" row = "5"><?php echo htmlspecialchars($explanation); ?></textarea>
      <?php if(isset($errors['explanation']) && $errors['explanation'] == 'blank') { ?>
        <p class="error">説明文を入力してください</p>
      <?php } ?>
    </div>

    <div>
      開始年（必須）<br>
      <input type="text" name="start_year" value= "<?php echo htmlspecialchars($start_year); ?>">
      <?php if(isset($errors['start_year']) && $errors['start_year'] == 'blank') { ?>
        <p class="error">開始年を入力してください</p>
      <?php } ?>
    </div>

    <div>
      前回開催年<br>
      <input type="text" name="year_p" value= "<?php echo htmlspecialchars($year_p); ?>">
      <?php if(isset($errors['year_p']) && $errors['year_p'] == 'blank') { ?>
        <p class="error">住所を入力してください</p>
      <?php } ?>
    </div>

    <div>
      前々回開催年<br>
      <input type="text" name="year_pp" value= "<?php echo htmlspecialchars($year_pp); ?>">
      <?php if(isset($errors['year_pp']) && $errors['year_pp'] == 'blank') { ?>
        <p class="error">住所を入力してください</p>
      <?php } ?>
    </div>

    <div>
      前前前回開催年<br>
      <input type="text" name="year_ppp" value= "<?php echo htmlspecialchars($year_ppp); ?>">
      <?php if(isset($errors['year_ppp']) && $errors['year_ppp'] == 'blank') { ?>
        <p class="error">住所を入力してください</p>
      <?php } ?>
    </div>

    <div>
      前回参加者数<br>
      <input type="text" name="attendance_p" value= "<?php echo htmlspecialchars($attendance_p); ?>">
      <?php if(isset($errors['attendance_p']) && $errors['attendance_p'] == 'blank') { ?>
        <p class="error">住所を入力してください</p>
      <?php } ?>
    </div>

    <div>
      前々回参加者数<br>
      <input type="text" name="attendance_pp" value= "<?php echo htmlspecialchars($attendance_pp); ?>">
      <?php if(isset($errors['attendance_pp']) && $errors['attendance_pp'] == 'blank') { ?>
        <p class="error">住所を入力してください</p>
      <?php } ?>
    </div>

    <div>
      前前前回参加者数<br>
      <input type="text" name="attendance_ppp" value= "<?php echo htmlspecialchars($attendance_ppp); ?>">
      <?php if(isset($errors['attendance_ppp']) && $errors['attendance_ppp'] == 'blank') { ?>
        <p class="error">住所を入力してください</p>
      <?php } ?>
    </div>

    <div>
      公式URL<br>
      <input type="text" name="official_url" value= "<?php echo htmlspecialchars($official_url); ?>">
      <?php if(isset($errors['official_url']) && $errors['official_url'] == 'blank') { ?>
        <p class="error">住所を入力してください</p>
      <?php } ?>
    </div>

    <div>
      関連URL<br>
      <input type="text" name="related_url" value= "<?php echo htmlspecialchars($related_url); ?>">
      <?php if(isset($errors['related_url']) && $errors['related_url'] == 'blank') { ?>
        <p class="error">住所を入力してください</p>
      <?php } ?>
    </div>

    <div>
      イベント画像<br>
      <input type="file" name="e_pic_path">
      <?php if(isset($errors['e_pic_path']) && $errors['e_pic_path'] == 'type') { ?>
        <p class="error">画像は「jpg」「png」「gif」の画像を選択してください。</p>
      <?php } ?>
      <!-- <?php //if(!empty($errors)) { ?> -->
      <?php if(isset($errors['e_pic_path']) && $errors['e_pic_path'] == 'blank') { ?>
        <p class="error">画像を指定してください</p>
      <?php } ?>
    </div>


    <input type="submit" value="確認"> 
  </form>
</body>
</html>

<!-- 画像アップロード手順
①input type="file"を用意
②formタグにenctype追加
③アップロード先フォルダの作成
④アップロード先フォルダのpermissionを変更

スーパーグローバル変数$_FILES
input fileで選択されたファイルを扱う変数
使用条件はinput fileとenctypeがformにあること
 -->