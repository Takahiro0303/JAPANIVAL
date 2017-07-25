<?php

// require('../../common/dbconnect.php');
// require('../../common/functions.php');


?>

<!-- ユーザーとしてヘッダーを呼び出し -->
<?php if ($_SESSION['id'] != '' && $_SESSION['flag'] == '1'): ?>

    <!-- Header================================================== -->
    <header style="height: 80px; z-index: 1040;">

        <!-- ヘッダーの上段部分をrequire -->
        <?php require('header_top.php') ?>

        <!-- End top line-->
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-3 col-xs-3">
                    <div id="logo_home">
                      <h1 style="line-height: 2;"><a href="edit_index.php" title="JAPANIVAL">City Tours travel template</a></h1>
                    </div>
                </div>
                <nav class="col-md-9 col-sm-9 col-xs-9">
                    <a class="cmn-toggle-switch cmn-toggle-switch__htx open_close" href="javascript:void(0);" ><span>Menu mobile</span></a>
                    <div class="main-menu">
                        <div id="header_menu">
                            <img src="" width="160" height="34" alt="City tours" data-retina="true">
                        </div>
                        <a href="#" class="open_close" id="close_in"><i class="icon_set_1_icon-77"></i></a>
                        <ul class="umetani">
                            <li class="submenu">
                                <a href="#" class="show-submenu" data-toggle="modal" data-target="#modal_about_us">About us<i class="icon-down-open-mini"></i></a>
                            </li>
                             <li class="submenu">
                                <a href="#" class="show-submenu" data-toggle="modal" data-target="#modal_register_organizer">Make An Event<i class="icon-down-open-mini"></i></a>
                            </li>
                            <li class="submenu">
                                <a href="#" class="show-submenu" data-toggle="modal" data-target="#modal_login">Sing in<i class="icon-down-open-mini"></i></a>
                            </li>
                        </ul>
                    </div><!-- End main-menu -->
                </nav>
            </div>
        </div><!-- container -->
    </header><!-- End Header -->

<!-- 主催者としてヘッダーを呼び出し -->
<?php elseif ($_SESSION['id'] != '' && $_SESSION['flag'] == ''): ?>

    <!-- Header================================================== -->
    <header style="height: 80px; z-index: 1040;">

        <!-- ヘッダーの上段部分をrequire -->
        <?php require('header_top.php') ?>

        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-3 col-xs-3">
                    <div id="logo_home">
                      <h1 style="line-height: 2;"><a href="edit_index.php" title="JAPANIVAL">City Tours travel template</a></h1>
                    </div>
                </div>
                <nav class="col-md-9 col-sm-9 col-xs-9">
                    <a class="cmn-toggle-switch cmn-toggle-switch__htx open_close" href="javascript:void(0);"><span>Menu mobile</span></a>
                    <div class="main-menu">
                        <div id="header_menu">
                            <img src="" width="160" height="34" alt="City tours" data-retina="true">
                        </div>
                        <a href="#" class="open_close" id="close_in"><i class="icon_set_1_icon-77"></i></a>
                        <ul class="umetani">
                            <li class="submenu">
                                <a href="#" class="show-submenu" data-toggle="modal" data-target="#modal_about_us">About us<i class="icon-down-open-mini"></i></a>
                            </li>
                             <li class="submenu">
                                <a href="event_input.php">Make An Event<i class="icon-down-open-mini"></i></a>
                            </li>
                            <li class="submenu">
                                <a href="#" class="show-submenu" data-toggle="modal" data-target="#modal_login">Sing in<i class="icon-down-open-mini"></i></a>
                            </li>
                        </ul>
                    </div><!-- End main-menu -->
                </nav>
            </div>
        </div><!-- container -->
    </header><!-- End Header -->


<!-- ゲストとしてヘッダーを呼び出し -->
<?php elseif ($_SESSION['id'] == '' && $_SESSION['flag'] == ''): ?>

    <!-- Header================================================== -->
    <header style="height: 80px; z-index: 1040;">

        <!-- ヘッダーの上段部分をrequire -->
        <?php require('header_top.php') ?>

        <div class="container" style="height: 65px;">
            <div class="row" style="height: 65px;">
                <div class="col-md-3 col-sm-3 col-xs-3">
                    <div id="logo_home">
                      <h1 style="line-height: 2;"><a href="edit_index.php" title="JAPANIVAL">City Tours travel template</a></h1>
                    </div>
                </div>
                <nav class="col-md-9 col-sm-9 col-xs-9">
                    <a class="cmn-toggle-switch cmn-toggle-switch__htx open_close" href="javascript:void(0);"><span>Menu mobile</span></a>
                    <div class="main-menu">
                        <div id="header_menu">
                            <img src="" width="160" height="34" alt="City tours" data-retina="true">
                        </div>
                        <a href="#" class="open_close" id="close_in"><i class="icon_set_1_icon-77"></i></a>
                        <ul class="umetani">
                            <li class="submenu">
                                <a href="#" class="show-submenu" data-toggle="modal" data-target="#modal_about_us">About us<i class="icon-down-open-mini"></i></a>
                            </li>
                            <li class="submenu">
                                <a href="#" class="show-submenu" data-toggle="modal" data-target="#modal_register_user">Sign Up<i class="icon-down-open-mini"></i></a>
                            </li>
                             <li class="submenu">
                                <a href="#" class="show-submenu" data-toggle="modal" data-target="#modal_register_organizer">Make An Event<i class="icon-down-open-mini"></i></a>
                            </li>
                            <li class="submenu">
                                <a href="#" class="show-submenu" data-toggle="modal" data-target="#modal_login">Sing in<i class="icon-down-open-mini"></i></a>
                            </li>
                        </ul>
                    </div><!-- End main-menu -->
                </nav>
            </div>
        </div><!-- container -->
    </header><!-- End Header -->


<!-- 管理者としてヘッダーを呼び出し -->
<?php elseif ($_SESSION['id'] == '1' && $_SESSION['flag'] == '0'): ?>

    <!-- Header================================================== -->
    <header style="height: 80px; z-index: 1040;">

        <!-- ヘッダーの上段部分をrequire -->
        <?php require('header_top.php') ?>

        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-3 col-xs-3">
                    <div id="logo_home">
                      <h1 style="line-height: 2;"><a href="edit_index.php" title="JAPANIVAL">City Tours travel template</a></h1>
                    </div>
                </div>
                <nav class="col-md-9 col-sm-9 col-xs-9">
                    <a class="cmn-toggle-switch cmn-toggle-switch__htx open_close" href="javascript:void(0);"><span>Menu mobile</span></a>
                    <div class="main-menu">
                        <div id="header_menu">
                            <img src="" width="160" height="34" alt="City tours" data-retina="true">
                        </div>
                        <a href="#" class="open_close" id="close_in"><i class="icon_set_1_icon-77"></i></a>
                        <ul class="umetani">
                            <li class="submenu">
                                <a href="#" class="show-submenu" data-toggle="modal" data-target="#modal_about_us">About us<i class="icon-down-open-mini"></i></a>
                            </li>
                            <li class="submenu">
                                <a href="#" class="show-submenu" data-toggle="modal" data-target="#modal_register_user">Sign Up<i class="icon-down-open-mini"></i></a>
                            </li>
                             <li class="submenu">
                                <a href="#" class="show-submenu" data-toggle="modal" data-target="#modal_register_organizer">Make An Event<i class="icon-down-open-mini"></i></a>
                            </li>
                            <li class="submenu">
                                <a href="#" class="show-submenu" data-toggle="modal" data-target="#modal_login">Sing in<i class="icon-down-open-mini"></i></a>
                            </li>
                        </ul>
                    </div><!-- End main-menu -->
                </nav>
            </div>
        </div><!-- container -->
    </header><!-- End Header -->

<?php endif; ?>

<?php require('modal_about_us.php'); ?>