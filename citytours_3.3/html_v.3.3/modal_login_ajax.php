<?php
session_start();
require('../../common/dbconnect.php');

$errors = array();
$errors['login'] = 'no';

$email = $_POST['email'];
$password = $_POST['password'];

if ($email != '' && $password != '') {

    //emailとpasswordがorganizersテーブルに入っているかの確認
    $o_sql = 'SELECT * FROM organizers WHERE o_email=? AND o_password=?';
    $o_data = [$email, sha1($password)];
    $stmt = $dbh->prepare($o_sql);
    $stmt->execute($o_data);

    $o_record = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($o_record != false) {
        $_SESSION['id'] = $o_record['o_id'];
        $_SESSION['flag'] = '';//オーガナイザーの場合にはユーザーフラグは空
    } else {
        //emailとpasswordがusersテーブルに入っているかの確認
        $sql = 'SELECT * FROM users WHERE email=? AND password=?';
        $data_1 = [$email, sha1($password)];
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data_1);

        $record = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($record != false) {
            $_SESSION['id'] = $record['user_id'];
            $_SESSION['flag'] = $record['user_flag'];//
        }else{
            $errors['login'] = 'failed';
        }
    }

}else{
    $errors['login'] = 'blank';
}

//データを返す
$data = ['error' => $errors['login']];
echo json_encode($data);



?>

