<?php
session_start();
 
header("Content-type: text/html; charset=utf-8");
 
//設定ファイル
require_once("config.php");
 
$helper = $fb->getRedirectLoginHelper();
 
//オプションによって認証画面の文言が変わる
//$permissions = ['email', 'user_likes','user_posts']; //あなたの公開プロフィール、メールアドレス、タイムライン投稿、いいね！。
//$permissions = ['email', 'user_likes']; //あなたの公開プロフィール、メールアドレス、いいね！。
//$permissions = ['email', 'user_posts'];//あなたのタイムライン投稿。
//$permissions = ['email','user_friends'];//あなたの公開プロフィール、友達リスト、メールアドレス。
//$permissions = ['email'];//あなたの公開プロフィール、メールアドレス。
$permissions = [];//あなたの公開プロフィール。
$loginUrl = $helper->getLoginUrl('http://noumenon-th.net/programming/sample/php/facebook/callback.php', $permissions);
 
echo '<a href="' . $loginUrl . '">ログインする</a>';