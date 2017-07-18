<?php
session_start();
require('../../common/dbconnect.php');
require('../../common/functions.php');

$o_name                 = $_POST['o_name'];
$o_f_name               = $_POST['o_f_name'];
$o_postal               = $_POST['o_postal'];
$o_pref                 = $_POST['o_pref'];
$o_address              = $_POST['o_address'];
$o_tel                  = $_POST['o_tel'];
$o_email                = $_POST['o_email'];
$o_password             = $_POST['o_password'];
$o_confirm_password     = $_POST['o_confirm_password'];
$o_comment              = $_POST['o_comment'];
$o_pic_path             = $_POST['o_pic_path'];

if (isset($_POST['o_db_register'])) {

//     $date_str = date('YmdHis');
//     $submit_file_name = $date_str . $_FILES['pic_path']['name'];

//     move_uploaded_file($_FILES['pic_path']['tmp_name'], '../../users_pic/' . $submit_file_name);

    $sql = 'INSERT INTO `organizers` SET `o_name` =?,
                                         `o_f_name` =?, 
                                         `o_postal` =?, 
                                         `o_pref` =?, 
                                         `o_address` =?, 
                                         `o_tel` =?,
                                         `o_email` =?,
                                         `o_password` =?, 
                                         `o_intro` =?,
                                         `o_pic` =?, 
                                         `created` =NOW()';
    $data = [
                                    $o_name,
                                    $o_f_name,
                                    $o_postal,
                                    $o_pref,
                                    $o_address,
                                    $o_tel,
                                    $o_email,
                                    sha1($o_password),
                                    $o_comment,
                                    $o_pic_path];
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

}

if (!isset($_POST['o_db_register'])) {

    $errors = array();

    $errors['o_name'] = '';
    $errors['o_f_name'] = '';
    $errors['o_postal'] = '';
    $errors['o_pref'] = '';
    $errors['o_address'] = '';
    $errors['o_tel'] = '';
    $errors['o_email'] = '';
    $errors['o_password'] = '';
    $errors['o_confirm_password'] = '';

    if ($o_name == '') {
        $errors['o_name'] = 'blank';
    }

    if ($o_f_name == '') {
        $errors['o_f_name'] = 'blank';
    }

    if ($o_postal == '') {
        $errors['o_postal'] = 'blank';
    }

    if ($o_pref == '') {
        $errors['o_pref'] = 'blank';
    }

    if ($o_address == '') {
        $errors['o_address'] = 'blank';
    }

    if ($o_tel == '') {
        $errors['o_tel'] = 'blank';
    }

    if ($o_email == '') {
        $errors['o_email'] = 'blank';
    }

    //パスワードの文字数チェック
    $count = strlen($o_password);
    if ($o_password == '') {
        $errors['o_password'] = 'blank';
    }elseif ($count < 6) {
        $errors['o_password'] = 'length';
    }

    if ($o_confirm_password == '') {
        $errors['o_confirm_password'] = 'blank';
    } elseif ($o_password !== $o_confirm_password) {
        $o_errors['o_confirm_password'] = 'wrong';
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
        $sql = 'SELECT COUNT(*) FROM `organizers` WHERE `o_email` = ?';
        $data = array($o_email);
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);

        $record = $stmt->fetch(PDO::FETCH_ASSOC);
        $count = $record['COUNT(*)'];
        if ($count > 0) {
            $errors['o_email'] = 'duplicate';
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
                'o_name' => $errors['o_name'],
                'o_f_name' => $errors['o_f_name'],
                'o_postal' => $errors['o_postal'],
                'o_pref' => $errors['o_pref'],
                'o_address' => $errors['o_address'],
                'o_tel' => $errors['o_tel'],
                'o_email' => $errors['o_email'],
                'o_password' => $errors['o_password'],
                'o_confirm_password' => $errors['o_confirm_password']
            ];
    echo json_encode($data);
}

?>