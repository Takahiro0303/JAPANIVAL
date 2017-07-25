<?php
session_start();
require('../../common/dbconnect.php');
require('../../common/functions.php');

$nick_name          = $_POST['nick_name'];
$email              = $_POST['email'];
$password           = $_POST['password'];
$confirm_password   = $_POST['confirm_password'];
$nationality        = $_POST['nationality'];
$gender             = $_POST['gender'];
$japanese_level     = $_POST['japanese_level'];
$comment            = $_POST['comment'];

if (isset($_POST['db_register'])) {

    $date_str = date('YmdHis');
    $submit_file_name = $date_str . $_FILES['pic_path']['name'];
    move_uploaded_file($_FILES['pic_path']['tmp_name'],'../../users_pic/' . $submit_file_name);


    $sql = 'INSERT INTO `users` SET `user_flag`=?,
                                    `nickname` =?,
                                    `email` =?, 
                                    `password` =?, 
                                    `nationality` =?, 
                                    `gender` =?, 
                                    `japanese_level` =?,
                                    `self_intro` =?,
                                    `pic_path` =?, 
                                    `created` =NOW()';
    $data = [
                                    '1',//ユーザーフラグ
                                    $nick_name,
                                    $email,
                                    sha1($password),
                                    $nationality,
                                    $gender,
                                    $japanese_level,
                                    $comment,
                                    $submit_file_name];
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

}

if (!isset($_POST['db_register'])) {

    $errors = array();

    $errors['nick_name'] = '';
    $errors['email'] = '';
    $errors['password'] = '';
    $errors['confirm_password'] = '';

    if ($nick_name == '') {
        $errors['nick_name'] = 'blank';
    }

    if ($email == '') {
        $errors['email'] = 'blank';
    }

    //パスワードの文字数チェック
    $count = strlen($password);
    if ($password == '') {
        $errors['password'] = 'blank';
    }elseif ($count < 6) {
        $errors['password'] = 'length';
    }

    if ($confirm_password == '') {
        $errors['confirm_password'] = 'blank';
    } elseif ($password !== $confirm_password) {
        $errors['confirm_password'] = 'wrong';
    }
    // console.log($errors);
      // echo '<pre>';
      // var_dump($errors);
      // echo '</pre>';


    $a = 0;

    foreach ($errors as $key => $value) {
        if ($value != '') {
            $a += 1;
            // echo $errors[$key];
            // echo $a;
        }
    }

    // if (empty($errors)) { ←値がなくてもkeyがあれば配列ありと見なされる。

    if ($a == 0) {
        // echo 'a';
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

    // if (!empty($file_name)) {
    //     $ext = substr($file_name, -3);
    //     $ext = strtolower($ext);
    //     if ($ext != 'jpg' && $ext != 'png' && $ext != 'gif') {
    //         $errors['pic_path'] = 'type';
    //     }
    // }

    $data = [   
                'nick_name' => $errors['nick_name'],
                'email' => $errors['email'],
                'password' => $errors['password'],
                'confirm_password' => $errors['confirm_password']
            ];
    echo json_encode($data);
}

?>