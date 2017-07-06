<?php
// 閲覧条件 (ログイン処理をしていること)
// $_SESSION['id']が存在すること

// 1時間以上何のアクションもしなければ強制ログアウト
// echo '<br>';
// var_dump($_SESSION['time']);
// echo '<br>';
// var_dump(time());
// echo '<br>';

// if ($_SESSION['time'] + 5 < time()) {
//     echo '5秒以上経過';
//     echo '<br>';
// }

if ( !isset($_SESSION['id']) || $_SESSION['time'] + 10000 < time() ) { // ログイン判定

    // $_COOKIE['email']があれば、14日間は保持するので、無視
    // if (isset($_COOKIE['email']) && $_COOKIE['email'] != '') {

    // } else {
        // そうでなければ強制的にlogin.phpに遷移
        header('Location: logout.php');
        exit();
    // }
}

$_SESSION['time'] = time();

?>