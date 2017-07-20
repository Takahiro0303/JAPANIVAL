<div class="modal fade" id="modal_login" tabindex="-1" role="dialog" aria-labelledby="myReviewLabel" aria-hidden="true">
    <div class="modal-dialog" > <!-- ここにstyle="width: 400px;"を入れれば、広い画面ではちょうど良いが、画面を狭くすると微妙にずれる。 -->
        <div class="modal-content">
            <section class="login">
                <div id="modal_login" >
                    <div class="text-center"><img src="img/japanival_logo.png" width="240" height="70" alt="JAPANIVAL" data-retina="true" style="max-width: 100%;height: auto;" ></div>
                    <hr>
                    <form method="POST" action="">
                        <div class="login_social">
                            <a href="#" class="btn btn-primary btn-block"><i class="icon-facebook"></i>Facebook</a>
                        </div>
                        <div class="login-or"><hr class="hr-or"><span class="span-or">or</span></div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" id="email_modal" name="email" class="form-control" placeholder="Email">

                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" id="password_modal"  name="password" class="form-control" placeholder="Password">
                        </div>
                        <p class="error"></p>
<!--                         <p class="small">
                            <a href="#">Forgot Password?</a>
                        </p> -->
                        <input type="button" id="modal_login_button" class="form-control btn-default" value="SIGN IN" style="border: 2px solid #0080FF; font-weight: bold; color: #0080FF;">
                        <br>
                        <a href="register_user.html " class="btn_full_outline">Register</a>
                    </form>
                </div>
            </section>
        </div>
    </div>
</div>