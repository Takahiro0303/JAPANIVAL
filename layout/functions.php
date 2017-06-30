<?php 

// サイトタイトル用関数
function siteTitle(){
	return 'JAPANIVAL';
}


function uri(){
	$uri = $_SERVER['REQUEST_URI'];

    $uri_arr = explode('/', $uri);
    $file_name = end($uri_arr);
    return $file_name;
}

 ?>