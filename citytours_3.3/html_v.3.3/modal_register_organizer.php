<div class="modal fade" id="modal_register_organizer" tabindex="-1" role="dialog" aria-labelledby="myReviewLabel" aria-hidden="true" style="overflow-y: auto;">
    <div class="modal-dialog" > <!-- ここにstyle="width: 400px;"を入れれば、広い画面ではちょうど良いが、画面を狭くすると微妙にずれる。 -->
        <div class="modal-content">

                <div id="modal_register_organizer" >
                    <div class="text-center"><img src="img/japanival_logo.png" width="240" height="70" alt="JAPANIVAL" data-retina="true" style="max-width: 100%;height: auto;" ></div>
                    <hr>
                    <form method="POST" action="" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>団体名</label>
                            <input type="text" id="r_o_name"  class="form-control"  placeholder="団体名">
                            <p class="error error_o_name"></p>
                        </div>
                        <div class="form-group">
                            <label>代表者名</label>
                            <input type="text" id="r_o_f_name"  class="form-control"  placeholder="代表者名">
                            <p class="error error_o_f_name"></p>
                        </div>
                        <div class="form-group">
                            <label>郵便番号</label>
                            <input type="text" id="r_o_postal"  class="form-control"  placeholder="郵便番号">
                            <p class="error error_o_postal"></p>
                        </div>
                        <div class="form-group">
                            <label>都道府県</label>
                            <input type="text" id="r_o_pref"  class="form-control"  placeholder="都道府県">
                            <p class="error error_o_pref"></p>
                        </div>
                        <div class="form-group">
                            <label>市区町村・番地・建物名・号室</label>
                            <input type="text" id="r_o_address"  class="form-control"  placeholder="市区町村・番地・建物名・号室">
                            <p class="error error_o_address"></p>
                        </div>
                        <div class="form-group">
                            <label>電話番号</label>
                            <input type="text" id="r_o_tel"  class="form-control"  placeholder="電話番号">
                            <p class="error error_o_tel"></p>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" id="r_o_email" class="form-control" placeholder="Email">
                            <p class="error error_o_email"></p>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" id="r_o_password" class="form-control" id="password1" placeholder="Password">
                            <p class="error error_o_password"></p>
                        </div>
                        <div class="form-group">
                            <label>Confirm password</label>
                            <input type="password" id="r_o_confirm_password" class="form-control" id="password2" placeholder="Confirm password">
                            <p class="error error_o_confirm_password"></p>
                        </div>
                        <div class="form-group">
                            <label>Comment</label><br>
                            <textarea name="comment" id="r_o_comment" class="form-control" placeholder="Describe who you are"></textarea>
                            <p class="error error_o_comment"></p>
                        </div>
                        <div class="form-group">
                            <label>Photo</label>
                            <div class="form-group">
                                <input type="file" name="pic_path" id="r_o_pic_path">
                                <p class="error error_o_pic_path"></p>
                            </div> 
                        </div>
                        <div>
<!--                             <button id="register_user_button" class="btn_full">Create an account</button> なぜページが更新されるのか質問 -->
                            <input type="button" id="register_organizer_button_c" class="btn_full" value="Create an account">

                        </div>
                    </form>
                </div>
        </div>
    </div>
</div>



<!-- 確認用 -->
<div class="modal fade" id="modal_register_organizer_confirm" tabindex="-1" role="dialog" aria-labelledby="myReviewLabel" aria-hidden="true" style="overflow-y: auto;max-height: 100%;">
    <div class="modal-dialog" > <!-- ここにstyle="width: 400px;"を入れれば、広い画面ではちょうど良いが、画面を狭くすると微妙にずれる。 -->
        <div class="modal-content">

                <div id="modal_register_organizer" >
                    <div class="text-center"><img src="img/japanival_logo.png" width="240" height="70" alt="JAPANIVAL" data-retina="true" style="max-width: 100%;height: auto;" ></div>
                    <hr>
                    <p>下記の内容で登録して宜しいですか？</p>
                    <form method="POST" action="" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>団体名:</label>
                            <p id="r_o_name_s" style="font-size: 15px; text-decoration: underline;"></p>
                        </div>
                        <div class="form-group">
                            <label>代表者名:</label>
                            <p id="r_o_f_name_s" style="font-size: 15px; text-decoration: underline;"></p>
                        </div>
                        <div class="form-group">
                            <label>郵便番号:</label>
                            <p id="r_o_postal_s" style="font-size: 15px; text-decoration: underline;"></p>
                        </div>
                        <div class="form-group">
                            <label>都道府県:</label>
                            <p id="r_o_pref_s" style="font-size: 15px; text-decoration: underline;"></p>
                        </div>
                        <div class="form-group">
                            <label>市区町村・番地・建物名・号室:</label>
                            <p id="r_o_address_s" style="font-size: 15px; text-decoration: underline;"></p>
                        </div>
                        <div class="form-group">
                            <label>電話番号:</label>
                            <p id="r_o_tel_s" style="font-size: 15px; text-decoration: underline;"></p>
                        </div>
                        <div class="form-group">
                            <label>Email:</label>
                            <p id="r_o_email_s" style="font-size: 15px; text-decoration: underline;"></p>
                        </div>
                        <div class="form-group">
                            <label>Password:</label>
                            <p type="password" id="r_o_password_s_a" style="font-size: 15px; text-decoration: underline;"></p>
                            <input type="hidden" id="r_o_password_s" value="">
                        </div>
                        <div class="form-group">
                            <label>Comment:</label><br>
                            <p id="r_o_comment_s" style="font-size: 15px; text-decoration: underline;"></p>
                        </div>
                        <div class="form-group">
                            <label>Photo:</label>
                            <div class="form-group">
                            <img src="">
                            </div> 
                        </div>
                        <div>
<!--                             <button id="register_organizer_button" class="btn_full">Create an account</button> なぜページが更新されるのか質問 -->
                            <input type="button" id="register_organizer_button_r" class="btn_full" value="Register">
                            <input type="button" id="register_organizer_button_b" class="btn_full" value="Back">
                        </div>
                    </form>
                </div>
        </div>
    </div>
</div>


<!-- 登録完了通知モーダル -->

<div class="modal fade" id="modal_register_organizer_result" tabindex="-1" role="dialog" aria-labelledby="myReviewLabel" aria-hidden="true" style="overflow-y: auto;max-height: 100%;">
    <div class="modal-dialog" > <!-- ここにstyle="width: 400px;"を入れれば、広い画面ではちょうど良いが、画面を狭くすると微妙にずれる。 -->
        <div class="modal-content">

                <div id="modal_register_organizer" >
                    <div class="text-center"><img src="img/japanival_logo.png" width="240" height="70" alt="JAPANIVAL" data-retina="true" style="max-width: 100%;height: auto;" ></div>
                    <hr>
                    <p>登録が完了しました。</p>
                    <br>
                    <input type="button" id="org_signin_modal_button" class="btn_full" value="Sign in">
                </div>
        </div>
    </div>
</div>


