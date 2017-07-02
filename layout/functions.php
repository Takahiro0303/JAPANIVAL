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
    // function $login_get_user($hoge) {
    //     $sql = 'SELECT * FROM hogehoge WHERE fugafuga=?';
    //     $data = [$_SESSION['id']];
    //     $stmt = $hoge->prepare($sql);
    //     $stmt->execute($data);
    //     $login_user = $stmt->fetch(PDO::FETCH_ASSOC);
    //     return $login_user;
    // }

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