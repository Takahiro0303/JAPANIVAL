<?php
session_start();
 
header("Content-type: text/html; charset=utf-8");
 
//設定ファイル
require_once("config.php");
 
//タイムゾーンの設定
date_default_timezone_set('asia/tokyo');
 
$helper = $fb->getRedirectLoginHelper();
 
try {
	if (isset($_SESSION['facebook_access_token'])) {
		$accessToken = $_SESSION['facebook_access_token'];
	} else {
		//アクセストークンを取得する
		$accessToken = $helper->getAccessToken();
		// urlの記入
	}
} catch(Facebook\Exceptions\FacebookResponseException $e) {
	// When Graph returns an error
	echo 'Graph returned an error: ' . $e->getMessage();
	exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
	// When validation fails or other local issues
	echo 'Facebook SDK returned an error: ' . $e->getMessage();
	exit;
}
 
if (isset($accessToken)) {
	//アクセストークンをセッションに保存
	$_SESSION['facebook_access_token'] = (string) $accessToken;
	
	header('Location: member.php');
	exit();
}else{
	echo "<a href='index.php'>はじめのページへ</a>";
}