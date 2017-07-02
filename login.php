<?php
session_start();
require('dbconnect.php');
var_dump($_COOKIE);


if (isset($_COOKIE['email']) && $_COOKIE['email'] != '') {
 	$_POST['email'] = $_COOKIE['email'];
 	$_POST['password'] = $_COOKIE['password'];
 	$_POST['save'] = 'on';

 }

 $errors = array();
 $email ='';

 if (!empty($_POST)) {
 	$email = $_POST['email'];
 	$password = $_POST['password'];
 	if ($email != '' && $password != '') {
 		$sql = 'SELECT * FROM `members` WHERE `email`=? AND `password` =?';
 		$data = array($email, sha1($password));
 		$stmt = $dbh->prepare($sql);
 		$stmt->execute($data);

 		$record = $stmt->fetch(PDO::FETCH_ASSOC);
 		if ($record != false) {
 			$_SESSION['id'] =$record['member_id'];
 			$_SESSION['time'] = time();

 			if ($_POST['save'] == 'on') {
 			setcookie('email' , $email , time() + 60*60*24*14);
 			setcookie('password' , $password , time() + 60*60*24*14);
 			}
 			
 			// var_dump($_SESSION['id']);
 			header('Location: timeline.php');
 				exit();
 		}else{
 			$errors['login'] = 'failed';
 		}



 	} else {
 		$errors['login'] = 'blank';
  	}
 }


 ?>




 <!DOCTYPE html>
 <html>
 <head>
 	<link rel="stylesheet" type="text/css" href="custom.css">
 	<title></title>
 </head>
 <body>
  <h1>ログイン</h1>
  <form method="POST" action="">
  	<div>メールアドレス<br>
	<input type="text" name="email" value= "<?php echo htmlspecialchars($email); ?>">
	<?php if (isset($errors['login'])  && isset($errors['login'])== 'blank') { ?>
		<p class="error">メールアドレスとパスワードを入力してください</p>
	<?php } ?>
	<?php if (isset($errors['login'])  && isset($errors['login'])== 'failed') { ?>
		<p class="error">ログインに失敗しました</p>
	<?php } ?>
	</div>
	<div>パスワード<br>
	<input type="password" name="password">
	</div>

	<div>
		<label for="save">
		次回以降ログイン状態を保持しますか？
		</label>
		
		<input id="save" type="checkbox" name="save" value="on">
	</div>

  	<input type="submit" value="ログイン">


  </form>
 </body>
 </html>