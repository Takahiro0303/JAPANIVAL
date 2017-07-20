<?php  
session_start();
require('../../common/dbconnect.php'); //データベースへ接続
require('../../common/functions.php'); //関数ファイル読み込み
require('request.php');

// $login_user = get_login_user($dbh);

// 【○】クリックされたイベントデータを一件を取得 * ログイン不要
$event_id = $_REQUEST['event_id'];

// 【○】イベントデータ取得 * ログイン不要
$sql = 'SELECT * FROM events WHERE event_id=?';
$data = [$_REQUEST['event_id']];
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
$event_data = $stmt->fetch(PDO::FETCH_ASSOC);
// v($event_data);

// 【○】イベント写真データ取得 * ログイン不要
$sql = 'SELECT * FROM event_pics WHERE event_id=?';
$data = [$_REQUEST['event_id']];
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
while ($event_pic = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $event_pics[] = $event_pic;
}
// v($event_pics);

// 【○】お気に入り数の取得 * ログイン不要
$sql = 'SELECT COUNT(*) AS total FROM likes WHERE event_id=?';
$data = [$_REQUEST['event_id']];
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
$like_count = $stmt->fetch(PDO::FETCH_ASSOC);
// v($like_count);

// 【○】newsテーブルから全データ取得 *ログイン不要
$sql = 'SELECT * FROM news WHERE event_id=?';
$data = [$_REQUEST['event_id']];
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
while ($notification = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $notifications[] = $notification;
}
// v($notifications);

// 【○】reviews&usersテーブルから全データ取得 * ログイン不要
$sql ='SELECT r.*, u.* FROM reviews r, users u WHERE r.user_id=u.user_id AND r.event_id=?';
$data = [$_REQUEST['event_id']];
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
$reviews = [];
while ($review = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $reviews[] = $review;
}
$count = count($reviews);
// v($reviews);
// v($count);

// v($event_pics[0]['e_pic_path']);

// マッチング情報＆リクエストボタンの表示 ※ログイン必須

// ○requestsテーブルから全データ取得
// if (isset($_SESSION[''])){
// user_flag != 0 // 管理者ではない場合、
    $sql ='SELECT r.*,u.* FROM requests r,users u WHERE r.user_id=u.user_id AND r.event_id=?';
    $data = [$_REQUEST['event_id']];
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    $requests = [];
    while ($request = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $requests[] = $request;
    }
// }
v($requests[1]['nickname']);

// リクエストボタンを押した際の登録処理
if (!empty($_POST['request_category_id'])) { // リクエストカテゴリ指定されていればリクエスト処理
        if ($request = $_POST['request_category_id']) {
        $sql = 'INSERT INTO requests
                    SET request_id=?,
                        user_id=?,
                        event_id=?,
                        request_category_id=?,
                        created=NOW()';
        $data = array($requst_id, $login_user['user_id'],$_REQUST['event_id'],$_POST['request_category_id']);
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);

        // 更新後、イベント詳細ページに戻す
        header('Location: event_detail.php?event_id=' . $_REQUEST['event_id']);
        exit();
        }
}

// ③いいねロジック実装
if (!empty($_POST['like_data'])) {
    // $_POST['like_data']の値がlikeかunlikeかで条件分岐
    if ($_POST['like_data'] == 'like') {
        // いいね！ボタンが押されたとき（likesテーブルにデータ追加）
        $sql = 'INSERT INTO likes SET member_id=?, tweet_id=?';
        $data = [$login_user['member_id'] , $record['tweet_id']];
    } else {
        // いいね！取り消しボタンが押されたとき（likesテーブルからデータ削除）
        $sql = 'DELETE FROM likes WHERE member_id=? AND tweet_id=?';
        $data = [$login_user['member_id'] , $record['tweet_id']];
    }
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    header('Location: view.php?tweet_id=' . $record['tweet_id']);
    exit();
}

//　マッチング希望者数カウント・表示
$sql = 'SELECT COUNT(*) AS total FROM requests WHERE event_id=?';
$data = [$_REQUEST['event_id']];
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
$request_count = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="Citytours - Premium site template for city tours agencies, transfers and tickets.">
    <meta name="author" content="Ansonika">
    <!-- 【タイトル表示】(イベントタイトル)の詳細-->
    <title><?php echo ($event_data['e_name']) ?>の詳細</title>

    <!-- Favicons-->
    <link rel="shortcut icon" href="img/japanival_icon.jpg" type="image/x-icon">
    <link rel="apple-touch-icon" type="image/x-icon" href="img/apple-touch-icon-57x57-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="img/apple-touch-icon-72x72-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="img/apple-touch-icon-114x114-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="img/apple-touch-icon-144x144-precomposed.png">

    <!-- Google web fonts -->
    <link href="https://fonts.googleapis.com/css?family=Gochi+Hand|Lato:300,400|Montserrat:400,400i,700,700i" rel="stylesheet">

    <!-- CSS -->
    <link href="css/base.css" rel="stylesheet">

    <!-- CSS -->
    <link href="css/slider-pro.min.css" rel="stylesheet">
    <link href="css/date_time_picker.css" rel="stylesheet">
</head>

<body>

    <header>
    <!-- require('../../common/header.php'); -->
    </header>

    <!-- 【○トップ】画像表示-->
    <section class="parallax-window" data-parallax="scroll" data-image-src="../../event_pictures/<?php echo(($event_pics[0]['e_pic_path'])); ?>" data-natural-width="1400" data-natural-height="470">
        <div class="parallax-content-2">
            <div class="container">
                <div class="row">
                    <div class="col-md-5 col-sm-5 col-xs-5" style="font-size: 40px">
                        <span><?php echo($event_data['e_name']); ?><?php echo $like_count['total']; ?></span>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-2">
                        <!-- お気に入り数表示 -->
                        <!-- <a class="btn-danger" href="" aria-expanded="false" width="40px" height="20px">♡</a> -->
                    </div>
                    <div class="col-md-5 col-sm-5 col-xs-5" style="font-size: 30px;">
                        <div class="event_date"><?php echo($event_data['e_start_date']) ?> ~ <?php echo($event_data['e_end_date']); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- End section -->

    <!-- 【メイン】イベント内容表示・マッチング機能表示-->

    <main>

        <div id="position">
            <div class="container">
                <ul>
                    <li><a href="#"><span><?php e($event_data['e_prefecture']); ?></span></a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="container margin_60">
            <div class="row">
                <div class="col-md-8" id="single_tour_desc">
                    <!-- イベント写真データ表示 -->
                    <div id="Img_carousel" class="slider-pro" align="center">
                        <div class="sp-slides">
                            <?php  foreach($event_pics as $event_pic){ ?>
                                <div class="sp-slides">
                                    <img alt="Image" 
                                    class="sp-image" 
                                    src="css/images/blank.gif" 
                                    data-src=../../event_pictures/"<?php echo($event_pic['e_pic_path']); ?>" 
                                    data-small="../../event_pictures/"<?php echo($event_pic['e_pic_path']); ?>"
                                    data-medium="../../event_pictures/"<?php echo($event_pic['e_pic_path']); ?>" 
                                    data-large="../../event_pictures/"<?php echo($event_pic['e_pic_path']); ?>"
                                    data-retina="../../event_pictures/"<?php echo($event_pic['e_pic_path']); ?>">
                                </div> <!-- sp-slides -->
                            <?php } ?>
                        </div> <!-- sp-slides -->
                       
                        <div class="sp-thumbnails">
                            <?php  foreach($event_pics as $event_pic){ ?>
                                    <img class="sp-thumbnail" src="../../event_pictures/<?php echo($event_pic['e_pic_path']); ?>"> 
                            <?php } ?>            
                        </div><!-- sp-slides -->
                    </div><!-- Img_carousel -->

                    <hr>

                    <!-- 以下、イベント説明 -->
                    <div class="row">
                        <div class="col-md-3">
                            <h3>Description</h3>
                        </div> <!-- col-md-3 -->
                        <div class="col-md-9">
                            <p><?php e($event_data['explanation']) ?></p>
                        </div> <!-- col-md-9 -->
                    </div> <!-- End row  -->

                    <hr>

                    <!-- 以下、イベント詳細 -->
                    <div class="row">
                        <div class="col-md-3">
                            <h3>Event Detail</h3>
                        </div> <!-- col-md-3 -->
                        <div class="col-md-9">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th rowspan="6">イベント詳細</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">Event Name</th>
                                            <td><?php e($event_data['e_name']) ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Category</th>
                                            <td>※カテゴリ表示</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Date</th>
                                            <td><?php echo($event_data['e_start_date']) ?> ~ <?php echo($event_data['e_end_date']) ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">city</th>
                                            <td><?php e($event_data['e_prefecture']) ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">the place (follow on map)</th>
                                            <td><?php e($event_data['e_venue']) ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Web page</th>
                                            <td><?php e($event_data['official_url']) ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Acces</th>
                                            <td>*アクセス方法表示</td>
                                        </tr>
                                    </tbody>
                                </table> <!-- table class="table table-striped" -->
                            </div> <!-- table-responsive -->

                            <div class=" table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th rowspan="3">The number of visitors</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row"><?php e($event_data['year_p']) ?></td>
                                            <td><?php e($event_data['attendance_p']) ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row"><?php e($event_data['year_pp']) ?></td>
                                            <td><?php e($event_data['attendance_p']) ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row"><?php e($event_data['year_ppp']) ?></td>
                                            <td><?php e($event_data['attendance_p']) ?></td>
                                        </tr>                                   
                                    </tbody>
                                </table>
                            </div>
                        </div> <!-- col-md-9 -->
                    </div><!-- row -->

                    <hr>

                    <div class="row">
                        <div class="col-md-3">
                            <h3>Map</h3>
                        </div>
                        <div class="col-md-9">
                        <!--　地図表示 -->
                        <!-- Google map apiでドカン -->
                        </div>
                    </div>

                    <hr>

                    <div class="row"><!-- レビュー表示 -->
                        <div class="col-md-3">
                            <h3>Reviews </h3> 
                        </div>
                        <div class="col-md-9">
                            <div id="general_rating" class="rating">
                                <span><?php echo($count); ?></span> Reviews <!-- レビュー件数表示 -->                   
                                <i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star"></i><i class="icon-star"></i>             
                                <a href="#" class="btn_1 add_bottom_30" data-toggle="modal" data-target="#myReview">Leave a review</a>
                            </div> <!-- general_rating -->

                            <hr>

                            <?php foreach ($reviews as $review){ ?>
                                <div class="review_strip_single">
                                    <img src="../../users_pic/<?php echo($review['pic_path']); ?>" alt="Image" class="img-circle" width="70px" height="70px">

                                    <!-- ユーザー名表示 -->
                                    <h4><?php echo($review['nickname']); ?></h4>

                                    <!-- レビュー評価表示機能 -->
                                    <?php if ($review['rating'] == '1'){ ?>
                                        <?php v($review); ?>
                                        <div class="rating">
                                            <i class="icon-star voted"></i>
                                            <i class="icon-star"></i>
                                            <i class="icon-star"></i>
                                            <i class="icon-star"></i>
                                            <i class="icon-star"></i>
                                        </div>
                                        <?php }elseif ($review['rating'] == '2'){ ?>
                                        <div class="rating">
                                            <i class="icon-star voted"></i>
                                            <i class="icon-star voted"></i>
                                            <i class="icon-star "></i>
                                            <i class="icon-star "></i>
                                            <i class="icon-star "></i>
                                        </div>
                                        <?php }elseif ($review['rating'] == '3'){ ?>
                                        <div class="rating">
                                            <i class="icon-star voted"></i>
                                            <i class="icon-star voted"></i>
                                            <i class="icon-star voted"></i>
                                            <i class="icon-star "></i>
                                            <i class="icon-star "></i>
                                        </div>
                                        <?php }elseif ($review['rating'] == '4'){ ?>
                                        <div class="rating">
                                            <i class="icon-star voted"></i>
                                            <i class="icon-star voted"></i>
                                            <i class="icon-star voted"></i>
                                            <i class="icon-star voted"></i>
                                            <i class="icon-star "></i>
                                        </div>
                                        <?php }elseif ($review['rating'] == '5'){ ?>
                                        <div class="rating">
                                            <i class="icon-star voted"></i>
                                            <i class="icon-star voted"></i>
                                            <i class="icon-star voted"></i>
                                            <i class="icon-star voted"></i>
                                            <i class="icon-star voted"></i>
                                        </div>
                                    <?php }; ?>

                                    <!--　レビュー作成日表示 -->
                                    <small><?php echo($review['created']);?></small>

                                    <!-- レビュー本文表示 -->
                                    <p><?php echo($review['comment']) ; ?></p>

                                </div> <!-- End review strip -->

                            <?php }; ?>


                        </div> <!-- col-md-9 -->
                    </div> <!-- row -->
                </div> <!-- col-md-8 -->

                <!--End  single_tour_desc-->

                <aside class="col-md-4">
                    <div class="box_style_1 expose">
                        <h3 class="inner">EVENT NEWS</h3>
                        <!-- ニュース表示 -->
                        <div id="scroll" class="news">
                            <?php foreach($notifications as $notification){ ?>
                                <?php e($notification['news_comment']); ?>
                            <?php } ?> 
                        </div>
                    </div> <!-- box_style_1 expose -->

                    <div class="box_style_1 expose">
                        <h3 class="inner">Eve tomo</h3>
                        <div class="eve_tomo">
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label><i class="icon-globe"></i>Nationality</label>
                                        <div class="styled-select">
                                            <select class="form-control" name="currency" id="currency">
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
                                        <label><i class=" icon-language"></i>Language</label>
                                        <div class="styled-select">
                                            <select class="form-control" name="currency" id="currency">
                                                <option value="not specified" selected>not specified</option>
                                                <option value="Japanese">Japanese</option>
                                                <option value="Tagalog">Tagalog</option>
                                                <option value="English">English</option>
                                                <option value="Tagalog">Tagalog</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- row -->

                            <hr>

                             <div class="row" style=" border-radius: 3px; padding: 10px; padding-bottom: 5px; margin-top: 10px; box-shadow:0 0 5px #fff, 0 0 5px #ccc, 0 0 1px #aaa; ">
                                <div class="col-md-6 col-sm-6" style="padding-left: 0; padding-top: 5px;">
                                    <div style="text-align: center">
                                        <img src="../../users_pic/<?php echo($requests[0]['pic_path']); ?>" alt="Image" class="img-circle" width="95px" height="95px" >
                                    </div>
                                    <h4 style="margin-top: 0px; text-align: center; margin-bottom: 5px;"><?php echo($requests[0]['nickname']); ?></h4>
                                    <div style="text-align: center">
                                        <img src="img/japan.png" width="32px" height="20px"> <!-- 国籍(国旗)表示 -->
                                        <div>Language : JP/EN</div> <!-- 対応可能言語表示 -->
                                    </div>
                                </div><!-- col-md-6 col-sm-6 -->
                                <div class="col-md-6 col-sm-6" align="center" style="padding : 0px;">
                                    <div class="button">
                                        <!-- 個人詳細ページに遷移 -->
                                        <div class="col-md-12 col-sm-12" style="padding : 0px; ">
                                            <a class="btn_full" href="" style="padding : 0px; height: 40px;line-height: 40px;"><i class=" icon-user" ></i>Profile</a>
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
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-sm-12" style="padding : 0px; ">
                                            <a class="btn_full_outline" href="user_chat.php?<?php  ?>" style="padding: 0px; height: 40px;line-height: 40px;"><i class=" icon-chat"></i>Chat</a>
                                        </div>
                                    </div> <!-- button -->
                                </div> <!-- col-md-6 col-sm-6 -->
                            </div>
                        </div>
                    </div>

                    <!-- <div>
                        <input type="button"  value="REQUEST" style="width:360px; height: 50px;" class="btn btn-danger" >
                    </div> -->
                    <a href="#" class="btn_1 add_bottom_30" data-toggle="modal" data-target="#myReview">Leave a review</a>
                    <p>
                        <a class="btn_map" name="request" data-toggle="collapse" href="" data-text-swap="Cancel" data-text-original="Confirm to eve tomo">Confirm to eve tomo</a>
                    </p>

                </aside> <!-- class="col-md-4" -->
            </div> <!-- row -->
        </div><!--End container -->
    </main><!-- End main -->

    <footer class="revealed">
        <div class="container">
            <div class="row">
            ※requireで呼び出し
            </div>
        </div>
    </footer>

<!-- Modal Review -->
    <div class="modal fade" id="myReview" tabindex="-1" role="dialog" aria-labelledby="myReviewLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myReviewLabel">Write your review</h4>
                </div>
                <div class="modal-body">
                    <div id="message-review">
                    </div>
                    <form method="post" action="assets/review_restaurant.php" name="review_restaurant" id="review_restaurant">
                        <input name="restaurant_name" id="restaurant_name" type="hidden" value="Mexican Taco Mex">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input name="name_review" id="name_review" type="text" placeholder="Your name" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input name="lastname_review" id="lastname_review" type="text" placeholder="Your last name" class="form-control">
                                </div>
                            </div>
                        </div>
                        <!-- End row -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input name="email_review" id="email_review" type="email" placeholder="Your email" class="form-control">
                                </div>
                            </div>
                        </div>
                        <!-- End row -->
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Position</label>
                                    <select class="form-control" name="position_review" id="position_review">
                                        <option value="">Please review</option>
                                        <option value="Low">Low</option>
                                        <option value="Sufficient">Sufficient</option>
                                        <option value="Good">Good</option>
                                        <option value="Excellent">Excellent</option>
                                        <option value="Superb">Super</option>
                                        <option value="Not rated">I don't know</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Service</label>
                                    <select class="form-control" name="service_review" id="service_review">
                                        <option value="">Please review</option>
                                        <option value="Low">Low</option>
                                        <option value="Sufficient">Sufficient</option>
                                        <option value="Good">Good</option>
                                        <option value="Excellent">Excellent</option>
                                        <option value="Superb">Super</option>
                                        <option value="Not rated">I don't know</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End row -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Price</label>
                                    <select class="form-control" name="price_review" id="price_review">
                                        <option value="">Please review</option>
                                        <option value="Low">Low</option>
                                        <option value="Sufficient">Sufficient</option>
                                        <option value="Good">Good</option>
                                        <option value="Excellent">Excellent</option>
                                        <option value="Superb">Super</option>
                                        <option value="Not rated">I don't know</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Quality</label>
                                    <select class="form-control" name="quality_review" id="quality_review">
                                        <option value="">Please review</option>
                                        <option value="Low">Low</option>
                                        <option value="Sufficient">Sufficient</option>
                                        <option value="Good">Good</option>
                                        <option value="Excellent">Excellent</option>
                                        <option value="Superb">Super</option>
                                        <option value="Not rated">I don't know</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End row -->
                        <div class="form-group">
                            <textarea name="review_text" id="review_text" class="form-control" style="height:100px" placeholder="Write your review"></textarea>
                        </div>
                        <div class="form-group">
                            <input type="text" id="verify_review" class=" form-control" placeholder="Are you human? 3 + 1 =">
                        </div>
                        <input type="submit" value="Submit" class="btn_1" id="submit-review">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End modal review -->

    <!-- Modal Request form -->
    <div class="modal fade" id="myReview" tabindex="-1" role="dialog" aria-labelledby="myReviewLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myReviewLabel">Write your review</h4>
                </div>
                <div class="modal-body">
                    <div id="message-review">
                    </div>
                    <form method="post" action="assets/review_restaurant.php" name="review_restaurant" id="review_restaurant">
                        <input name="restaurant_name" id="restaurant_name" type="hidden" value="Mexican Taco Mex">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input name="name_review" id="name_review" type="text" placeholder="Your name" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input name="lastname_review" id="lastname_review" type="text" placeholder="Your last name" class="form-control">
                                </div>
                            </div>
                        </div>
                        <!-- End row -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input name="email_review" id="email_review" type="email" placeholder="Your email" class="form-control">
                                </div>
                            </div>
                        </div>
                        <!-- End row -->
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Position</label>
                                    <select class="form-control" name="position_review" id="position_review">
                                        <option value="">Please review</option>
                                        <option value="Low">Low</option>
                                        <option value="Sufficient">Sufficient</option>
                                        <option value="Good">Good</option>
                                        <option value="Excellent">Excellent</option>
                                        <option value="Superb">Super</option>
                                        <option value="Not rated">I don't know</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Service</label>
                                    <select class="form-control" name="service_review" id="service_review">
                                        <option value="">Please review</option>
                                        <option value="Low">Low</option>
                                        <option value="Sufficient">Sufficient</option>
                                        <option value="Good">Good</option>
                                        <option value="Excellent">Excellent</option>
                                        <option value="Superb">Super</option>
                                        <option value="Not rated">I don't know</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End row -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Price</label>
                                    <select class="form-control" name="price_review" id="price_review">
                                        <option value="">Please review</option>
                                        <option value="Low">Low</option>
                                        <option value="Sufficient">Sufficient</option>
                                        <option value="Good">Good</option>
                                        <option value="Excellent">Excellent</option>
                                        <option value="Superb">Super</option>
                                        <option value="Not rated">I don't know</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Quality</label>
                                    <select class="form-control" name="quality_review" id="quality_review">
                                        <option value="">Please review</option>
                                        <option value="Low">Low</option>
                                        <option value="Sufficient">Sufficient</option>
                                        <option value="Good">Good</option>
                                        <option value="Excellent">Excellent</option>
                                        <option value="Superb">Super</option>
                                        <option value="Not rated">I don't know</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End row -->
                        <div class="form-group">
                            <textarea name="review_text" id="review_text" class="form-control" style="height:100px" placeholder="Write your review"></textarea>
                        </div>
                        <div class="form-group">
                            <input type="text" id="verify_review" class=" form-control" placeholder="Are you human? 3 + 1 =">
                        </div>
                        <input type="submit" value="Submit" class="btn_1" id="submit-review">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End modal review -->

    <!-- Common scripts -->
    <script src="js/jquery-2.2.4.min.js"></script>
    <script src="js/common_scripts_min.js"></script>
    <script src="js/functions.js"></script>

    <!-- Specific scripts -->
    <script src="js/icheck.js"></script>
    <script>
    $('input').iCheck({
    checkboxClass: 'icheckbox_square-grey',
    radioClass: 'iradio_square-grey'
    });
    </script>
    <!-- Date and time pickers -->
    <script src="js/jquery.sliderPro.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function ($) {
    $('#Img_carousel').sliderPro({
    width: 960,
    height: 500,
    fade: true,
    arrows: true,
    buttons: false,
    fullScreen: false,
    smallSize: 500,
    startSlide: 0,
    mediumSize: 1000,
    largeSize: 3000,
    thumbnailArrows: true,
    autoplay: false
    });
    });
    </script>

    <!-- Date and time pickers -->
    <script src="js/bootstrap-datepicker.js"></script>
    <script src="js/bootstrap-timepicker.js"></script>
    <script>
    $('input.date-pick').datepicker('setDate', 'today');
    $('input.time-pick').timepicker({
    minuteStep: 15,
    showInpunts: false
    })
    </script>

    <!--Review modal validation -->
    <script src="assets/validate.js"></script>

    <!-- Map -->
    <script src="http://maps.googleapis.com/maps/api/js"></script>
    <script src="js/map.js"></script>
    <script src="js/infobox.js"></script>
</body>
</html>