<?php

// require('../../common/dbconnect.php');
// require('../../common/functions.php');


?>

<!-- ユーザーとしてヘッダーを呼び出し -->
<?php if ($_SESSION['id'] != '' && $_SESSION['flag'] == '1'): ?>
    
    <?php  ?>


    <?php  ?>

        <div id="top_line">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-6">
                    </div>

                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <ul id="top_links">
                            <li>
                                <div class="dropdown dropdown-access">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="access_link"><?php echo htmlspecialchars($login_user['nickname']); ?></a>
                                    <div class="dropdown-menu" id="log_out">
                                        <img src="img/avatar1.jpg" alt="" class="img-circle">
                                        <h4><?php echo htmlspecialchars($login_user['nickname']); ?></h4>
                                        <p>Last access 15th November 2016 08.45pm</p>
                                        <input type="submit" name="Profile" value="Profile" id="Profile" class="button_drop outline" onclick="location.href='admin_user.php?user_id=<?php echo htmlspecialchars($login_user['user_id']); ?>'">
                                        <input type="submit" name="Sign_up" value="Log out" id="Sign_up" class="button_drop outline" onclick="logout()">
                                    </div>
                                </div>
                                <!-- End Dropdown access -->
                            </li>
                            <li id="lang_top"><i class="icon-globe-1"></i> <a href="#0">EN</a> - <a href="#0">JA</a> - <a href="#0">CH</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- End row -->
            </div>
            <!-- End container-->
        </div>
    

<!-- 主催者としてヘッダーを呼び出し -->
<?php elseif ($_SESSION['id'] != '' && $_SESSION['flag'] == ''): ?>

        <div id="top_line">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-6">
                    </div>

                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <ul id="top_links">
                            <li>
                                <div class="dropdown dropdown-access">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="access_link"><?php echo htmlspecialchars($login_user['o_name']); ?></a>
                                    <div class="dropdown-menu" id="log_out">
                                        <img src="img/avatar1.jpg" alt="" class="img-circle">   
                                        <h4><?php echo htmlspecialchars($login_user['o_name']); ?></h4>
                                        <p>Last access 15th November 2016 08.45pm</p>
                                        <input type="submit" name="Profile"  value="Profile" id="Profile" class="button_drop outline" onclick="location.href='admin_organizer.php?o_id=<?php echo htmlspecialchars($login_user['o_id']); ?>'">
                                        <input type="submit" name="Sign_up" value="Log out" id="Sign_up" class="button_drop outline" onclick="logout()">
                                    </div>
                                </div>
                                <!-- End Dropdown access -->
                            </li>
                            <li id="lang_top"><i class="icon-globe-1"></i> <a href="#0">EN</a> - <a href="#0">JA</a> - <a href="#0">CH</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- End row -->
            </div>
            <!-- End container-->
        </div>


<!-- ゲストとしてヘッダーを呼び出し -->
<?php elseif ($_SESSION['id'] == '' && $_SESSION['flag'] == ''): ?>

        <div id="top_line">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-6">
                    </div>

                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <ul id="top_links">
                            <li>
                                <div class="dropdown dropdown-access">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="access_link">Guest</a>
                                    <div class="dropdown-menu" id="log_out">
                                        <img src="img/avatar1.jpg" alt="" class="img-circle">
                                        <h4>Guest</h4>

                                    </div>
                                </div>
                                <!-- End Dropdown access -->
                            </li>
                            <li id="lang_top"><i class="icon-globe-1"></i> <a href="#0">EN</a> - <a href="#0">JA</a> - <a href="#0">CH</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- End row -->
            </div>
            <!-- End container-->
        </div>


<!-- 管理者としてヘッダーを呼び出し -->
<?php elseif ($_SESSION['id'] == '1' && $_SESSION['flag'] == '0'): ?>

        <div id="top_line">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-6">
                    </div>

                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <ul id="top_links">
                            <li>
                                <div class="dropdown dropdown-access">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="access_link"><?php echo htmlspecialchars($login_user['nickname']); ?></a>
                                    <div class="dropdown-menu" id="log_out">
                                        <img src="img/avatar1.jpg" alt="" class="img-circle">
                                        <h4><?php echo htmlspecialchars($login_user['nickname']); ?></h4>
                                        <p>Last access 15th November 2016 08.45pm</p>
                                        <input type="submit" name="Profile" value="Profile" id="Profile" class="button_drop outline">
                                        <input type="submit" name="Sign_up" value="Log out" id="Sign_up" class="button_drop outline" onclick="logout()">
                                    </div>
                                </div>
                                <!-- End Dropdown access -->
                            </li>

                            <li id="lang_top"><i class="icon-globe-1"></i> <a href="#0">EN</a> - <a href="#0">JA</a> - <a href="#0">CH</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- End row -->
            </div>
            <!-- End container-->
        </div>

<?php endif; ?>