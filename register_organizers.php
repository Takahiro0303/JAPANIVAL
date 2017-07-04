<?php 
	session_start();
	require('dbconnect.php');
	require('layout/functions.php');


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
	 <html lang="ja">
	 <head>
	 <meta charset="utf-8">
	 	<title></title>
	 </head>
	 <body>
	 <h1>会員登録</h1>
	 <form method="POST" action="register_organizers.php" enctype="multipart/form-data">
	 <div>
	 	団体名<br>
	 	<input type="text" name="o_name" value="<?php echo htmlspecialchars($o_name); ?>">
	 	<?php if (isset($errors['o_name']) && $errors['o_name'] == 'blank') { ?>
	 	 <p class="error">団体名を記入してください</p>
	 	 <?php } ?>
	 </div>
	 <div>
	 	代表者名<br>
	 	<input type="text" name="o_f_name" value="<?php echo htmlspecialchars($o_f_name); ?>">
	 	<?php if (isset($errors['o_f_name']) && $errors['o_f_name'] == 'blank') { ?>
	 	 <p class="error">代表者名を記入してください</p>
	 	 <?php } ?>
	 </div>
	 <div>
	 	郵便番号<br>
	 	<input type="text" name="o_postal">
	 	<?php if (isset($errors['o_postal']) && $errors['o_postal'] == 'blank') { ?>
	 	 <p class="error">郵便番号を記入してください</p>
	 	 <?php } ?>
	 </div>
	 <div>
	 	都道府県<br>
	 	<input type="text" name="o_pref">
	 	<?php if (isset($errors['o_pref']) && $errors['o_pref'] == 'blank') { ?>
	 	 <p class="error">都道府県をを記入してください</p>
	 	 <?php } ?>
	 </div>
	 <div>
	 	市町村番地<br>
	 	<input type="text" name="o_address">
	 	<?php if (isset($errors['o_address']) && $errors['o_address'] == 'blank') { ?>
	 	 <p class="error">市町村を記入してください</p>
	 	 <?php } ?>
	 </div>
	 <div>
	 	電話番号<br>
	 	<input type="text" name="o_tel">
	 	<?php if (isset($errors['o_tel']) && $errors['o_tel'] == 'blank') { ?>
	 	 <p class="error">電話番号を記入してください</p>
	 	 <?php } ?>
	 </div>
	 <div>
	 	Emil<br>
	 	<input type="text" name="o_email" value="<?php echo htmlspecialchars($o_email); ?>">
	 	<?php if (isset($errors['o_email']) && $errors['o_email'] == 'blank') { ?>
	 	<p class="error">メールアドレスを記入してください</p>
	 	<?php } ?>
	 	<?php if (isset($errors['o_email']) && $errors['o_email'] == 'duplicate') { ?>
	 	<p class="error">そのメールアドレスは既に登録されています</p>
	 	<?php } ?>
	 </div>
	 <div>
	 	パスワード<br>
	 	<input type="password" name="o_password">
	 	<?php if (isset($errors['o_password']) && $errors['o_password'] == 'blank') { ?>
	 	 <p class="error">パスワードを記入してください</p>
	 	 <?php } ?>
	 	 <?php if (isset($errors['o_password']) && $errors['o_password'] == 'length') { ?>
	 	  <p class="error">パスワードは6文字以上で入力してください</p>
	 	  <?php } ?>
	 </div>
	 <div>
	 	もう一度パスワードを入力してください<br>
	 	<input type="password" name="o_confirm_password">
	 	<?php if (isset($errors['o_password']) && $errors['o_password'] == 'wrong') { ?>
	 	 <p class="alert-danger">パスワードが一致しません</p>
	 	 <?php } ?>
	 </div>
	 <div>
	 	自己紹介コメント<br>
	 	<input type="text" name="o_intro">
	 </div>
	 <div>
	 	photo<br>
	 	<input type="file" name="o_pic">
	 	<?php if (isset($errors['o_pic']) && $errors['o_pic'] == 'type') { ?>
	 	<p class="error">画像はjpg,png,gifの画像を選択してください</p>
	 	<?php } ?>
	 	<?php if (!empty($errors)) { ?>
	 	<p class="error">画像を選択してください</p>
	 	<?php } ?>

	 </div>







	 <input type="submit" value="登録">




	 </form>



	 </body>
	 </html>