<?php 

//イベントID初期化

if (isset($event_id)) {　// event_idがセットされているか...この処理はいらないのでは？ イベント詳細ページ以外でも使うなら別ですが、他のページでも使うようであればその都度requireでrequest.phpを呼び出せば不要かと/大澤
    $sql = 'SELECT * FROM news WHERE event_id=?';
    $data = [$event_id];
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    $c = 0;
    while ($new = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $news[] = $new;
        $c =+ 1;
    }
}


?>

<aside class="col-md-4">
    <div>

        <div class="box_style_ume" style="overflow: auto;"><!-- //TODO!:変更前 class="box_style_1 expose" -->

            <h3 class="inner">Information</h3>
            <div>
            <?php if ($_SESSION['id'] != '' && $_SESSION['flag'] == ''): ?>
            <!--主催者 -->
                <?php if (isset($_REQUEST['event_id'])):?><!-- //イベントデータがあれば、紐づくニュースを表示 --> 
                    <!-- オーガナイザーイベント修正 -->
                    <input type="button" id="news_register_button" class="btn_full" value="News Register">

                    <?php if (isset($news)): ?>
                    <!-- ニュースデータがある場合はfor文で表示 -->
                        <?php for ($i=0; $i < count($news) ; $i++) { ?> 
                            <p style="margin-bottom: 0px; color: black; font-weight: 600; text-decoration: underline;"><?php echo $news[$i]['news_title'];?></p>
                            <p style="margin-bottom: 0px; color: black;"><?php echo $news[$i]['news_comment'];?></p>      
                            <p style="margin-bottom: 0px; font-style:oblique;">登録日<?php echo $news[$i]['created'];?></p>
                            <?php if ($news[$i]['created'] != $news[$i]['modified']): ?>
                                <p style="margin-bottom: 0px; font-style:oblique;">変更日<?php echo $news[$i]['modified'];?></p>
                            <?php endif; ?>
                            <hr style="margin-top: 10px; margin-bottom: 10px;">
                        <?php } ?>
                    <?php else: ?>
                    <!-- ニュースデータがない場合 -->
                    同イベントに関連するニュース（中止連絡、その他情報）のアップデートが可能です。
                    <?php endif; ?>
                <?php else: ?>
                    <!-- オーガナイザー新規イベント作成 -->
                    イベント登録後、同イベントに関連するニュース（中止連絡、その他情報）のアップデートが可能です。
                <?php endif; ?>
            <?php else: ?>
            <!-- 主催者以外 -->
                <?php if ($c > 0):?><!-- //イベントデータがあれば、紐づくニュースを表示 -->
                    <?php for ($i=0; $i < count($news) ; $i++) { ?> 
                        <p style="margin-bottom: 0px; color: black; font-weight: 600; text-decoration: underline;"><?php echo $news[$i]['news_title'];?></p>
                        <p style="margin-bottom: 0px; color: black;"><?php echo $news[$i]['news_comment'];?></p>      
                        <p style="margin-bottom: 0px; font-style:oblique;">登録日<?php echo $news[$i]['created'];?></p>
                        <?php if ($news[$i]['created'] != $news[$i]['modified']): ?>
                            <p style="margin-bottom: 0px; font-style:oblique;">変更日<?php echo $news[$i]['modified'];?></p>
                        <?php endif; ?>
                        <hr style="margin-top: 10px; margin-bottom: 10px;">

                    <?php } ?>

                <?php else: ?>
                    本イベントに関連するニュース（中止連絡、その他情報）を随時、主催者よりのアップデート致します。
                    <?php echo '<br>'; ?>
                    <?php echo "id"; ?>
                    <?php  echo $_SESSION['id']; ?>
                    <?php echo '<br>'; ?>
                    <?php echo "flag"; ?>
                    <?php  echo $_SESSION['flag']; ?>
                <?php endif; ?>                
            <?php endif; ?>

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

                <?php if (isset($_REQUEST['event_id'])): ?> <!-- //イベントデータがあれば、紐づくニュースを表示 -->
             <!--    # code... -->
                <?php else: ?>
                <?php echo '<br>'; ?>
                イベント登録後、同イベントに関心を持つ外国人ユーザーが下記の例のように、リクエストをポストします。
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
                <?php endif; ?>
            </div>
        </div>


    </div>
</aside>