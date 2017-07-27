<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-sm-10">
                <a href="#" class="show-submenu" data-toggle="modal" data-target="#modal_about_us"><h3>About us</h3></a>
                <a href="#" class="show-submenu" data-toggle="modal" data-target="#modal_user_policy"><h3>User policy</h3></a>
                <a href="#" class="show-submenu" data-toggle="modal" data-target="#modal_inquiry.php"><h3>Inquiry</h3></a>
                <a href="#" class="show-submenu" data-toggle="modal" data-target="#modal_Privacy Policy"><h3>Privacy Policy</h3></a>
            </div>
            <div class="col-md-2 col-sm-2">
                <h3>Settings</h3>
                <div class="styled-select">
                    <select class="form-control" name="lang" id="lang">
                        <option value="English" selected>English</option>
                        <option value="Japanese">Japanese</option>
                    </select>
                </div>
            </div>
        </div><!-- End row -->
        <div class="row">
            <div class="col-md-12">
                <div id="social_footer">

                    <p>© Japanival 2017</p>
                </div>
            </div>
        </div><!-- End row -->
    </div><!-- End container -->
</footer><!-- End footer -->


    <!-- モーダル・about us -->
    <?php require('modal_about_us.php'); ?>

    <!-- モーダル・ユーザー規約 -->
    <?php require('modal_user_policy.php'); ?>

    <!-- モーダル・問い合わせ -->
    <?php //('modal_inquiry.php'); ?>

    <!-- モーダル・個人情報規約 -->
    <?php require('modal_privacy_policy.php'); ?>