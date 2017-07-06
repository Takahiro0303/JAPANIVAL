<?php

// require('../../common/dbconnect.php');
// require('../../common/functions.php');


?>

<!-- ユーザーとしてヘッダーを呼び出し -->
<?php if ($_SESSION['id'] != '' && $_SESSION['flag'] == '1'): ?>

    <!-- Header================================================== -->
    <header>

        <!-- ヘッダーの上段部分をrequire -->
        <?php require('header_top.php') ?>

        <!-- End top line-->
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-3 col-xs-3">
                    <div id="logo_home">
                      <h1><a href="index.html" title="City tours travel template">City Tours travel template</a></h1>
                    </div>
                </div>
                <nav class="col-md-9 col-sm-9 col-xs-9">
                    <a class="cmn-toggle-switch cmn-toggle-switch__htx open_close" href="javascript:void(0);"><span>Menu mobile</span></a>
                    <div class="main-menu">
                        <div id="header_menu">
                            <img src="img/logo_sticky.png" width="160" height="34" alt="City tours" data-retina="true">
                        </div>
                        <a href="#" class="open_close" id="close_in"><i class="icon_set_1_icon-77"></i></a>
                        <ul class="umetani">
                            <li class="submenu">
                                <a href="javascript:void(0);" class="show-submenu">About us USER<i class="icon-down-open-mini"></i></a>
                            </li>
                             <li class="submenu">
                                <a href="javascript:void(0);" class="show-submenu">Make An Event<i class="icon-down-open-mini"></i></a>
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
    <header>

        <!-- ヘッダーの上段部分をrequire -->
        <?php require('header_top.php') ?>

        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-3 col-xs-3">
                    <div id="logo_home">
                      <h1><a href="index.html" title="City tours travel template">City Tours travel template</a></h1>
                    </div>
                </div>
                <nav class="col-md-9 col-sm-9 col-xs-9">
                    <a class="cmn-toggle-switch cmn-toggle-switch__htx open_close" href="javascript:void(0);"><span>Menu mobile</span></a>
                    <div class="main-menu">
                        <div id="header_menu">
                            <img src="img/logo_sticky.png" width="160" height="34" alt="City tours" data-retina="true">
                        </div>
                        <a href="#" class="open_close" id="close_in"><i class="icon_set_1_icon-77"></i></a>
                        <ul class="umetani">
                            <li class="submenu">
                                <a href="javascript:void(0);" class="show-submenu">About us ORGANIZER<i class="icon-down-open-mini"></i></a>
                            </li>
                             <li class="submenu">
                                <a href="javascript:void(0);" class="show-submenu">Make An Event<i class="icon-down-open-mini"></i></a>
                            </li>
                            <li class="submenu">
                                <a href="javascript:void(0);" class="show-submenu">Sign in<i class="icon-down-open-mini"></i></a>
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
    <header>

        <!-- ヘッダーの上段部分をrequire -->
        <?php require('header_top.php') ?>

        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-3 col-xs-3">
                    <div id="logo_home">
                      <h1><a href="index.html" title="City tours travel template">City Tours travel template</a></h1>
                    </div>
                </div>
                <nav class="col-md-9 col-sm-9 col-xs-9">
                    <a class="cmn-toggle-switch cmn-toggle-switch__htx open_close" href="javascript:void(0);"><span>Menu mobile</span></a>
                    <div class="main-menu">
                        <div id="header_menu">
                            <img src="img/logo_sticky.png" width="160" height="34" alt="City tours" data-retina="true">
                        </div>
                        <a href="#" class="open_close" id="close_in"><i class="icon_set_1_icon-77"></i></a>
                        <ul class="umetani">
                            <li class="submenu">
                                <a href="javascript:void(0);" class="show-submenu">About us GUEST<i class="icon-down-open-mini"></i></a>
                            </li>
                            <li class="submenu">
                                <a href="javascript:void(0);" class="show-submenu">Sign Up<i class="icon-down-open-mini"></i></a>
                            </li>
                             <li class="submenu">
                                <a href="javascript:void(0);" class="show-submenu">Make An Event<i class="icon-down-open-mini"></i></a>
                            </li>
                            <li class="submenu">
                                <a href="javascript:void(0);" class="show-submenu">Sing in<i class="icon-down-open-mini"></i></a>
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
    <header>

        <!-- ヘッダーの上段部分をrequire -->
        <?php require('header_top.php') ?>

        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-3 col-xs-3">
                    <div id="logo_home">
                      <h1><a href="index.html" title="City tours travel template">City Tours travel template</a></h1>
                    </div>
                </div>
                <nav class="col-md-9 col-sm-9 col-xs-9">
                    <a class="cmn-toggle-switch cmn-toggle-switch__htx open_close" href="javascript:void(0);"><span>Menu mobile</span></a>
                    <div class="main-menu">
                        <div id="header_menu">
                            <img src="img/logo_sticky.png" width="160" height="34" alt="City tours" data-retina="true">
                        </div>
                        <a href="#" class="open_close" id="close_in"><i class="icon_set_1_icon-77"></i></a>
                        <ul class="umetani">
                            <li class="submenu">
                                <a href="javascript:void(0);" class="show-submenu">About us MANAGER<i class="icon-down-open-mini"></i></a>
                            </li>
                            <li class="submenu">
                                <a href="javascript:void(0);" class="show-submenu">Sign Up<i class="icon-down-open-mini"></i></a>
                            </li>
                             <li class="submenu">
                                <a href="javascript:void(0);" class="show-submenu">Make An Event<i class="icon-down-open-mini"></i></a>
                            </li>
                            <li class="submenu">
                                <a href="javascript:void(0);" class="show-submenu">Sing in<i class="icon-down-open-mini"></i></a>
                            </li>
                        </ul>
                    </div><!-- End main-menu -->
                </nav>
            </div>
        </div><!-- container -->
    </header><!-- End Header -->

<?php endif; ?>