<?php 
session_start();

require('../../common/dbconnect.php'); //データベースへ接続
require('../../common/functions.php'); //関数ファイル読み込み


// reviews&usersテーブルからデータ取得
$sql ='SELECT r.*, u.*
		FROM reviews r, users u
		WHERE r.event_id=1';
		// -- ORDER BY r.created
		// -- DESC LIMIT %d, 3
 $data = ['reviews'];	
 $stmt = $dbh->prepare($sql);
 $stmt->execute($data);
 $reviews = $stmt->fetch(PDO::FETCH_ASSOC);

v($reviews);

?>