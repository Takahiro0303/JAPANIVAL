<?php 
	session_start();
	require('dbconnect.php');
	require('layout/functions.php');


// 登録時バリデーション

	$nick_name = '';
	$email ='';

	$errors = array();

if (!empty($_POST)) {
	$nick_name = $_POST['nick_name'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$confirm_password = $_POST['confirm_password'];
	$nationality = $_POST['nationality'];
	$gender = $_POST['gender'];
	$comment = $_POST['comment'];



	if ($nick_name == '') {
		$errors['nick_name'] = 'blank';
		}
	if ($email == '') {
		$errors['email'] = 'blank';
		}

//パスワードの暗号化
	$count = strlen($password);
	if ($password == '') {
		$errors['password'] = 'blank';
		}elseif ($count < 6) {
		$errors['password'] = 'length';
		}

	if (!isset($_REQUEST['action'])) {
			$file_name = $_FILES['pic_path']['name'];

		}

	if ($password !== $confirm_password) {
		$errors['password'] = 'wrong';
	}

	if (!empty($file_name)) {
		$ext = substr($file_name, -3);
		$ext = strtolower($ext);
		if ($ext != 'jpg' && $ext != 'png' && $ext != 'gif') {
			$errors['pic_path'] = 'type';
			}
		}else{
		$errors['pic_path'] = 'blank';
		}


	if (empty($errors)) {
		$sql = 'SELECT COUNT(*) FROM `users` WHERE `email` = ?';
		$data = array($email);
		$stmt = $dbh->prepare($sql);
		$stmt->execute($data);

		$record = $stmt->fetch(PDO::FETCH_ASSOC);
		$count = $record['COUNT(*)'];
	if ($count > 0) {
		$errors['email'] = 'duplicate';
		}
	}

	if (empty($errors)) {
		$date_str = date('YmdHis');
		$submit_file_name = $date_str . $_FILES['pic_path']['name'];
		move_uploaded_file($_FILES['pic_path']['tmp_name'], 'users_pic' . $submit_file_name);
		$_SESSION['join'] = $_POST;
		$_SESSION['join']['pic_path'] = $submit_file_name;


	if (!empty($_POST)) {
		$sql = 'INSERT INTO `users` SET `nickname` =?,`email` =?, `password` =?, `nationality` =?, `gender` =?, `self_intro` =?, `pic_path` =?, `created` =NOW()';
		$data = array($nick_name,$email,sha1($password),$nationality,$gender,$comment,$_SESSION['join']['pic_path']);
		$stmt = $dbh->prepare($sql);
		$stmt->execute($data);


		header('Location:index.php');
		exit();
	}

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
	 <form method="POST" action="user_login.php" enctype="multipart/form-data">
	 <div>
	 	User Name<br>
	 	<input type="text" name="nick_name" value="<?php echo htmlspecialchars($nick_name); ?>">
	 	<?php if (isset($errors['nick_name']) && $errors['nick_name'] == 'blank') { ?>
	 	 <p class="error">ユーザー名を記入してください</p>
	 	 <?php } ?>
	 </div>
	 <div>
	 	Emil<br>
	 	<input type="text" name="email" value="<?php echo htmlspecialchars($email); ?>">
	 	<?php if (isset($errors['email']) && $errors['email'] == 'blank') { ?>
	 	 <p class="error">メールアドレスを記入してください</p>
	 	 <?php } ?>
	 	 <?php if (isset($errors['email']) && $errors['email'] == 'duplicate') { ?>
	 	  <p class="error">そのメールアドレスは既に登録されています</p>
	 	  <?php } ?>
	 </div>
	 <div>
	 	password<br>
	 	<input type="password" name="password">
	 	<?php if (isset($errors['password']) && $errors['password'] == 'blank') { ?>
	 	 <p class="error">パスワードを記入してください</p>
	 	 <?php } ?>
	 	 <?php if (isset($errors['password']) && $errors['password'] == 'length') { ?>
	 	  <p class="error">パスワードは4文字以上で入力してください</p>
	 	  <?php } ?>
	 </div>
	 <div>
	 	confirm password<br>
	 	<input type="password" name="confirm_password">
	 	<?php if (isset($errors['password']) && $errors['password'] == 'wrong') { ?>
	 	 <p class="alert-danger">パスワードが一致しません</p>
	 	 <?php } ?>
	 </div>
	 <div>
	 	Nationality<br>
	 	<input type="text" name="nationality">
	 </div>
	 <div>
	 	Gender<br>
	 	<input type="text" name="gender">
	 </div>
	 <div>
	 	Comment<br>
	 	<input type="text" name="comment">
	 </div>
	 <div>
	 	プロフィール画像<br>
	 	<input type="file" name="pic_path">
	 	<?php if (isset($errors['pic_path']) && $errors['pic_path'] == 'type') { ?>
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