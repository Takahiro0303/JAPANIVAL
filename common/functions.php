<?php 
/* =====================================================
    検証用関数
====================================================- */
    function v($var) {
        echo '<pre>';
        var_dump($var);
        echo '</pre>';
    }

    function e($var) {
        echo $var;
        echo '<br>';
    }

/* =====================================================
    実機能関数
====================================================- */
    function get_login_user($dbh) {
        // ユーザーフラグに値が有る場合は、ユーザーあるいは管理者として認識。usersテーブルからユーザー情報を取得

        if ($_SESSION == null) {
            $_SESSION['id'] = '';
            $_SESSION['flag'] = '';
        }


        if ($_SESSION['flag'] == '1' || $_SESSION['flag'] == '0') {
            $sql = 'SELECT * FROM users WHERE user_id=?';

        // ユーザーフラグに値が無い場合は、主催者として認識。organizersテーブルから主催者情報を取得
        }else{
            $sql = 'SELECT * FROM organizers WHERE o_id=?';
        }
        $data = [$_SESSION['id']];
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);
        $login_user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($login_user == null) {
            $_SESSION['id'] = '';
            $_SESSION['flag'] = '';
        }

        return $login_user;
    }

    function hs($var) {
        return htmlspecialchars($var);
    }

    // function eh($var){
    //     return echo htmlspecialchars($var);
    // }

    function uri() {
        $uri = $_SERVER['REQUEST_URI'];
        $uri_arr = explode('/', $uri);
        $file_name = end($uri_arr);
        return $file_name;
    }

    function h($var) {
        header('Location:' . $var);
        exit();
    }

?>