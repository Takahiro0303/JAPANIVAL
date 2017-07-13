

<aside class="col-md-4">
                    <div>

                        <div class="box_style_ume"><!-- //TODO!:変更前 class="box_style_1 expose" -->
                            
                            <h3 class="inner">Information</h3>
                            <div>
                                ニュース登録日
                                <input type="date" class="form-control" name="news_date" value= "<?php echo htmlspecialchars($e_start_date); ?>" style="margin-right: 5px; margin-bottom: 5px;">
                                ニュース記載欄
                                <textarea name="news_comment" class="form-control"  placeholder = "こちらにイベント情報（ニュース）を入力してください">
                                    <?php echo htmlspecialchars($news_comment); ?>
                                </textarea>
                            </div>

                        </div>

                        <div class="box_style_1">
                            <h3 class="inner">Requests!!</h3> <!-- style="margin-bottom: 5px;" -->
                            <div class="requests" style="margin-bottom: 0px;">
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label>
                                                <i class="icon-globe"></i>Nationality
                                            </label>
                                            <div class="styled-select">
                                                <select class="form-control" name="nationarity" id="nationarity">
                                                    <option value="not specified" selected>not specified</option>
                                                    <option value="Japan">Japan</option>
                                                    <option value="Philippine">Philippine</option>
                                                    <option value="Afghanistan">Afghanistan</option>
                                                    <option value="Albanie">Albanie</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label>
                                                <i class="icon-language"></i>Language
                                            </label>
                                            <div class="styled-select">
                                                <select class="form-control" name="language" id="language">
                                                    <option value="not specified" selected>not specified</option>
                                                    <option value="Japanese">Japanese</option>
                                                    <option value="Tagalog">Tagalog</option>
                                                    <option value="English">English</option>
                                                    <option value="Tagalog">Tagalog</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr style="margin-bottom: 0px; margin-top: 0px;">

                                <div class="row" style=" border-radius: 3px; padding: 10px; padding-bottom: 5px; margin-top: 10px; box-shadow:0 0 5px #fff, 0 0 5px #ccc, 0 0 1px #aaa; ">
                                    <div >
                                                
                                        <div class="col-md-6 col-sm-6" style="padding-left: 0; padding-top: 5px;">
                                            <div style="text-align: center">
                                                <img src="img/spongebob.jpg" alt="Image" class="img-circle" width="95px" height="95px" >
                                            </div>
                                            <h4 style="margin-top: 0px; text-align: center; margin-bottom: 5px;">Sponge Bob</h4>
                                            <div style="text-align: center">
                                                <img src="img/japan.png" width="32px" height="20px"> <!-- 国籍(国旗)表示 -->
                                                <div>Language : JP/EN</div> <!-- 対応可能言語表示 -->
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6" align="center" style="padding : 0px;">
                                            <div class="button">
                                                <!-- 個人詳細ページに遷移 -->
                                                <div class="col-md-12 col-sm-12" style="padding : 0px; ">
                                                    <a class="btn_full" href="profile.html" style="padding : 0px; height: 40px;line-height: 40px;"><i class=" icon-user" ></i>Profile</a>
                                                </div>
                                                <!-- チャットページに遷移 -->
                                                <div class="col-md-12 col-sm-12" style="padding : 0px; ">
                                                    <div class="panel panel-danger" style="margin-bottom: 5px;">
                                                        <div class="panel-heading" style="padding : 10px; ">
                                                            <div style="margin-bottom: 5px;">
                                                                Request Category
                                                            </div>
                                                            <div style="font-weight: 900; font-size: 24px; margin-bottom: 5px;">
                                                                <a href="" class="text-danger" style="text-decoration:underline; ">GUIDE</a>
                                                            </div>
                                                        </div>
                                                        <div class="panel-body" style="padding : 5px">
                                                            <a class="btn_full_outline" href="chat" style="padding : 0px; height: 40px;line-height: 40px;"><i class=" icon-chat"></i>Chat</a>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </aside>