<?php 

//ニュース情報取得
if (isset($event_id)) {
    $sql = 'SELECT * FROM news WHERE event_id=? ORDER BY modified DESC';
    $data = [$event_id];
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    $c = 0;
    while ($new = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $news[] = $new;
        $c =+ 1;
    }
}

// ○requestsテーブルから全データ取得　※ログイン必須
if (isset($_REQUEST['event_id'])){
    $sql ='SELECT r.request_id, r.request_category_id, r.created, u.nickname, u.user_id, u.pic_path, u.nationality, u.gender, u.self_intro FROM requests r,users u WHERE r.user_id=u.user_id AND r.event_id=? ORDER BY r.created DESC ';
    $data = [$_REQUEST['event_id']];
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    $requests = [];
    while ($request = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $requests[] = $request;
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
                    <?php endif; ?>                
                <?php endif; ?>

            </div>

        </div>

        <div class="box_style_1" style="max-height: 1500px; overflow: auto;">
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
                    <?php if ($_SESSION['id'] != '' && $_SESSION['flag'] != ''): ?>
                        <p>
                            <a class="btn_map" name="request" data-toggle="modal" href="" data-text-original="Request to eve tomo" data-target="#myRequest" style="margin-top: 5px; margin-bottom: 0px;">Request to Friends</a>
                        </p>
                    <?php endif ?>
                        <?php foreach ($requests as $request) { ?>
                            <?php  

                                $sql = 'SELECT chat_room_id FROM chat_rooms WHERE request_id = ?';
                                $data = [$request['request_id']];
                                $stmt = $dbh->prepare($sql);
                                $stmt->execute($data);
                                $chat_room_id = $stmt->fetch(PDO::FETCH_ASSOC);
                                // echo $chat_room_id['chat_room_id'];
                            ?>

                            <div class="row" style=" border-radius: 3px; padding: 10px; padding-bottom: 5px; margin-top: 10px; box-shadow:0 0 5px #fff, 0 0 5px #ccc, 0 0 1px #aaa; ">
                                <div >

                                    <div class="col-md-6 col-sm-6" style="padding-left: 0;">
                                        <div style="text-align: center">
                                            <img src="<?php echo htmlspecialchars($request['pic_path']); ?>" alt="Image" class="img-circle" style="width: 95px; height:95px; margin-top: 5px;">
                                     
                                        <h4 style="margin-top: 5px; text-align: center; margin-bottom: 5px; text-decoration: underline;"><?php echo htmlspecialchars($request['nickname']); ?></h4>
                                        <!-- <div style="text-align: center"> -->
                                        <?php $duration = date('Y/m/d H:i', strtotime($request['created'])) ?>
                                        <p style="margin-top: 5px; text-align: center; margin-bottom: 5px; text-decoration: underline;">登録:<?php echo htmlspecialchars($duration); ?></p>
                                        <!-- <div style="text-align: center"> -->

                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6" align="center" style="padding : 0px;">
                                        <!-- 個人詳細ページに遷移 -->
                                        <div class="col-md-12 col-sm-12" style="padding : 0px; ">
                                            <a href="#" class="btn_full" data-toggle="modal" data-target="#myprofile_<?php echo htmlspecialchars($request['user_id']); ?>" style="padding : 0px; height: 30px;line-height: 30px;"><i class=" icon-user" ></i>Profile</a>
                                        </div>
                                        <!-- チャットページに遷移 -->

                                        <!-- もしユーザーなら -->
                                        <?php if (isset($login_user['user_id'])): ?>
                                            
                                        <!-- もし自分のリクエストならば -->
                                            <?php if ($request['user_id'] == $login_user['user_id']): ?>

                                                <div class="col-md-12 col-sm-12" style="padding : 0px; ">
                                                    <div class="panel panel-info" style="margin-bottom: 5px;">
                                                        <div class="panel-heading" style="padding : 5px; ">
                                                            <div style="margin-bottom: 5px;">
                                                                YOUR Request
                                                            </div>
                                                            <?php if($request['request_category_id'] == '1'): ?>
                                                                <div style="font-weight: 900; font-size: 24px; margin-bottom: 5px;">
                                                                    <a href="" class="text-info" style="text-decoration:underline; ">INQUIRY</a>
                                                                </div>
                                                            <?php elseif($request['request_category_id'] == '2'): ?>
                                                                <div style="font-weight: 900; font-size: 24px; margin-bottom: 5px;">
                                                                    <a href="" class="text-info" style="text-decoration:underline; font-size: 20px;">NAVIGATION</a>
                                                                </div>
                                                            <?php elseif($request['request_category_id'] == '3'): ?>    
                                                                <div style="font-weight: 900; font-size: 24px; margin-bottom: 5px;">
                                                                    <a href="" class="text-info" style="text-decoration:underline; ">HANG OUT</a>
                                                                </div>
                                                            <?php else: ?>
                                                                <div style="font-weight: 900; font-size: 24px; margin-bottom: 5px;">
                                                                    <a href="" class="text-info" style="text-decoration:underline; ">選んでない</a>
                                                                </div>
                                                            <?php endif; ?>

                                                        </div>
                                                        <div class="panel-body" style="padding : 5px">

                                                            <?php echo $chat_room_id['chat_room_id']; ?>
                                                            <?php echo $request['request_id']; ?>

                                                            <?php if (isset($chat_room_id['chat_room_id'])): ?>
                                                                <a class="btn btn-success" href="user_chat.php?chat_room_id=<?php echo htmlspecialchars($chat_room_id['chat_room_id']); ?>&request_id=<?php echo htmlspecialchars($request['request_id']); ?>" style="padding : 0px; height: 40px;width:100%; line-height: 40px;"><i class=" icon-chat"></i>Keep on Chat</a>
                                                            <?php else:?>
                                                                <button type="button" class="btn btn-danger disabled" style="width: 100%; font-weight: 500;">waiting</button>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>

                                            <!-- もし自分のリクエストでないならば -->
                                            <?php else: ?>

                                                <div class="col-md-12 col-sm-12" style="padding : 0px; ">
                                                    <div class="panel panel-danger" style="margin-bottom: 5px;">
                                                        <div class="panel-heading" style="padding : 5px; ">
                                                            <div style="margin-bottom: 5px;">
                                                                Request Category
                                                            </div>
                                                            <?php if($request['request_category_id'] == '1'): ?>
                                                                <div style="font-weight: 900; font-size: 24px; margin-bottom: 5px;">
                                                                    <a href="" class="text-danger" style="text-decoration:underline; ">INQUIRY</a>
                                                                </div>
                                                            <?php elseif($request['request_category_id'] == '2'): ?>
                                                                <div style="font-weight: 900; font-size: 24px; margin-bottom: 5px;">
                                                                    <a href="" class="text-danger" style="text-decoration:underline; font-size: 20px;">NAVIGATION</a>
                                                                </div>
                                                            <?php elseif($request['request_category_id'] == '3'): ?>    
                                                                <div style="font-weight: 900; font-size: 24px; margin-bottom: 5px;">
                                                                    <a href="" class="text-danger" style="text-decoration:underline; ">HANG OUT</a>
                                                                </div>
                                                            <?php else: ?>
                                                                <div style="font-weight: 900; font-size: 24px; margin-bottom: 5px;">
                                                                    <a href="" class="text-danger" style="text-decoration:underline; ">選んでない</a>
                                                                </div>
                                                            <?php endif; ?>

                                                        </div>
                                                        <div class="panel-body" style="padding : 5px">

                                                            <?php echo $chat_room_id['chat_room_id']; ?>
                                                            <?php echo $request['request_id']; ?>
                                                        
                                                            <?php if (isset($chat_room_id['chat_room_id'])): ?>
                                                                <a class="btn btn-success" href="user_chat.php?chat_room_id=<?php echo htmlspecialchars($chat_room_id['chat_room_id']); ?>&request_id=<?php echo htmlspecialchars($request['request_id']); ?>" style="padding : 0px; height: 40px;width:100%; line-height: 40px;"><i class=" icon-chat"></i>Keep on Chat</a>
                                                            <?php else:?>
                                                                <a class="btn_full_outline" href="user_chat.php?chat_room_id=no&request_id=<?php echo htmlspecialchars($request['request_id']); ?>" style="padding : 0px; height: 40px;line-height: 40px;"><i class=" icon-chat"></i>Start Chat</a>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>

                                        <?php else: ?>
                                                <div class="col-md-12 col-sm-12" style="padding : 0px; ">
                                                    <div class="panel panel-danger" style="margin-bottom: 5px;">
                                                        <div class="panel-heading" style="padding : 5px; ">
                                                            <div style="margin-bottom: 5px;">
                                                                Request Category
                                                            </div>
                                                            <?php if($request['request_category_id'] == '1'): ?>
                                                                <div style="font-weight: 900; font-size: 24px; margin-bottom: 5px;">
                                                                    <a href="" class="text-danger" style="text-decoration:underline; ">INQUIRY</a>
                                                                </div>
                                                            <?php elseif($request['request_category_id'] == '2'): ?>
                                                                <div style="font-weight: 900; font-size: 24px; margin-bottom: 5px;">
                                                                    <a href="" class="text-danger" style="text-decoration:underline; font-size: 20px;">NAVIGATION</a>
                                                                </div>
                                                            <?php elseif($request['request_category_id'] == '3'): ?>    
                                                                <div style="font-weight: 900; font-size: 24px; margin-bottom: 5px;">
                                                                    <a href="" class="text-danger" style="text-decoration:underline; ">HANG OUT</a>
                                                                </div>
                                                            <?php else: ?>
                                                                <div style="font-weight: 900; font-size: 24px; margin-bottom: 5px;">
                                                                    <a href="" class="text-danger" style="text-decoration:underline; ">選んでない</a>
                                                                </div>
                                                            <?php endif; ?>

                                                        </div>
                                                        <div class="panel-body" style="padding : 5px">

                                                            <?php echo $chat_room_id['chat_room_id']; ?>
                                                            <?php echo $request['request_id']; ?>
                                                        
                                                            <?php if (isset($chat_room_id['chat_room_id'])): ?>
                                                                <button type="button" class="btn btn-danger disabled" style="width: 100%; font-weight: 500;">chatting now</button>
                                                            <?php else:?>
                                                                <button type="button" class="btn btn-danger disabled" style="width: 100%; font-weight: 500;">waiting</button>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>








                                        <?php endif; ?>



                                    </div>

                                </div>
                            </div>


                        <?php } ?>

                <?php else: ?>
                    <?php echo '<br>'; ?>
                    イベント登録後、同イベントに関心を持つ外国人ユーザーが下記の例のように、リクエストをポストします。
                            <div class="row" style=" border-radius: 3px; padding: 10px; padding-bottom: 5px; margin-top: 10px; box-shadow:0 0 5px #fff, 0 0 5px #ccc, 0 0 1px #aaa; ">
                                <div >

                                    <div class="col-md-6 col-sm-6" style="padding-left: 0;">
                                        <div style="text-align: center">
                                            <img src="../../users_pic/baikin.jpg" alt="Image" class="img-circle" style="width: 95px; height:95px; margin-top: 5px;">
                                     
                                        <h4 style="margin-top: 5px; text-align: center; margin-bottom: 5px; text-decoration: underline;">バイキンマン</h4>
                                        <!-- <div style="text-align: center"> -->
                                        登録:2017/07/27 10:50
                                        <!-- <div style="text-align: center"> -->

                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6" align="center" style="padding : 0px;">
                                        <!-- 個人詳細ページに遷移 -->
                                        <div class="col-md-12 col-sm-12" style="padding : 0px; ">
                                            <a href="#" class="btn_full" data-toggle="modal" data-target="" style="padding : 0px; height: 30px;line-height: 30px;"><i class=" icon-user" ></i>Profile</a>
                                        </div>
                                        <!-- チャットページに遷移 -->

                                        <!-- ハリボテ -->
                                                <div class="col-md-12 col-sm-12" style="padding : 0px; ">
                                                    <div class="panel panel-danger" style="margin-bottom: 5px;">
                                                        <div class="panel-heading" style="padding : 5px; ">
                                                            <div style="margin-bottom: 5px;">
                                                                Request Category
                                                            </div>

                                                                <div style="font-weight: 900; font-size: 24px; margin-bottom: 5px;">
                                                                    <a href="" class="text-danger" style="text-decoration:underline; ">INQUIRY</a>
                                                                </div>


                                                        </div>
                                                        <div class="panel-body" style="padding : 5px">

                                                                <button type="button" class="btn btn-danger disabled" style="width: 100%; font-weight: 500;">chatting now</button>

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

