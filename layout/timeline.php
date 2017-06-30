<?php 
require('functions.php');

 ?>

 <!DOCTYPE html>
 <html lang="ja">
 <head>
 <meta charset="utf-8">
 	<title>ジャパニバル</title>
 	<?php require('partial/load_css.php'); ?>
 </head>
 <body style="margin-top: 60px;">
 	
 	<?php require('partial/header.php'); ?>

 	<div class='container'>
 		<div class="row">
 		<!-- left sideber area -->
 		<?php require('partial/sidebar.php') ?>
 		<!-- main contant area -->
 			<div class="col-xs-9">
 				各ページごとのコンテンツ、デザイン
 			</div>
 		</div>


 	</div>
	
 	
 	<!-- footer area -->
 	<?php require('partial/footer.php'); ?>

 	<?php require('partial/load_js.php'); ?>
 </body>
 </html>