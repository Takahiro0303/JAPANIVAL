<?php
session_start();
require('../../common/dbconnect.php'); //データベースへ接続
require('../../common/functions.php');
require('request.php'); // パラメータがなければ、edit_index.phpに遷移

$login_user = get_login_user($dbh);

v($_SESSION['id']);

// sessionを持たない状態で直接、このページに来た時には、event_input.phpに自動遷移 ⇦ request.phpで処理済み、またなぜREQUESTではなくSESSIONなのか/大澤
// if(!isset($_SESSION['event'])){
//     header('Location: edit_index.php');
//     exit();
// }

$event_id = $_REQUEST['event_id'];

// ○イベントデータ取得 * ログイン不要
$sql = 'SELECT * FROM events WHERE event_id=?';
$data = [$event_id];
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
$event_data = $stmt->fetch(PDO::FETCH_ASSOC);

// ○イベント写真データ取得 * ログイン不要
$sql = 'SELECT * FROM event_pics WHERE event_id=?';

$data = [$event_id];
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
while ($event_pic = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $event_pics[] = $event_pic;
}

// ○reviews&usersテーブルから全データ取得
$sql ='SELECT r.*, u.*
        FROM reviews r, users u
        WHERE r.user_id=u.user_id AND r.event_id=?';
        // -- ORDER BY r.created
        // -- DESC LIMIT %d, 3
 $data = [$event_id];   
 $stmt = $dbh->prepare($sql);
 $stmt->execute($data);
$reviews = [];
while ($review = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $reviews[] = $review;
}
$count = count($reviews);
// v($count);

// ○newsテーブルから全データ取得 *ログイン不要
$sql = 'SELECT * FROM news WHERE event_id=?';
$data = [$_REQUEST['event_id']];
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
    while ($new = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $news[] = $new;
    }

// ○requestsテーブルから全データ取得　※ログイン必須
if (isset($_SESSION['id'])){
    $sql ='SELECT r.*,u.* FROM requests r,users u WHERE r.user_id=u.user_id AND r.event_id=?';
    $data = [$_REQUEST['event_id']];
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    $requests = [];
    while ($request = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $requests[] = $request;
    }
}
v(count($requests));

// reviewDB登録
$review_rating = '';
$review_comment = '';

if (!empty($_POST['review_rating']) && !empty($_POST['review_text'])) {
  $review_rating = $_POST['review_rating'];
  $review_comment = $_POST['review_comment'];

  $review_sql = 'INSERT INTO reviews SET event_id = ?, user_id = ?, rating = ?, comment = ?, created = NOW()';
  $review = [$_POST['event_id'],$login_user['user_id'],$_POST['review_rating'],$_POST['review_comment']];
  $review_stmt = $dbh->prepare($review_sql);
  $review_stmt->execute($review);

}
    
// $file_review = $_FILES['review_pic_path']['name'];
//         //もし画像がセットされていれば画像アップデート処理
//         if (!empty($file_review)) {
//             $date_str = date('YmdHis');
//             $submit_file_name = $date_str . $_FILES['review_pic_path']['name'];
//             move_uploaded_file($_FILES['review_pic_path']['tmp_name'], '../../review_photos/' . $submit_file_name);

//                 $sql = 'SELECT review_id FROM reviews ORDER BY review_id desc limit 1';
//                 $review_stmt = $dbh->prepare($sql);
//                 $review_stmt->execute();
//                 $review_id = $review_stmt->fetch(PDO::FETCH_ASSOC);


//             $sql = 'INSERT INTO review_photos SET review_id = ?, review_pic_path = ?';
//             $data = [$review_id['review_id'],$submit_file_name];
//             $stmt = $dbh->prepare($sql);
//             $stmt->execute($data);
//         }
// v($_FILES['review_pic_path']);

// ○リクエストボタンを押した際の登録処理
// v($request['user_id']);
// if ($requests['user_id'] != $login_user){
    if (isset($_POST['request_category_id'])) { // リクエストカテゴリ指定されていればリクエスト処理
        $sql = 'INSERT INTO requests
                        SET request_id=?,
                            user_id=?,
                            event_id=?,
                            request_category_id=?,
                            created=NOW()';
        $data = [$_POST['request_id'],$login_user,$_REQUEST['event_id'],$_POST['request_category_id']];
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);

        // 更新後、イベント詳細ページに戻す
        header('Location: event_detail.php?event_id=' . $_REQUEST['event_id']);
        exit();
        }
// }

//　マッチング希望者数カウント・表示　⇦ リクエスト欄に記載させるか要相談
// $sql = 'SELECT COUNT(*) AS total FROM requests WHERE event_id=?';
// $data = [$_REQUEST['event_id']];
// $stmt = $dbh->prepare($sql);
// $stmt->execute($data);
// $request_count = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="Citytours - Premium site template for city tours agencies, transfers and tickets.">
    <meta name="author" content="Ansonika">
    <title>JAPANIVAL-EventDetail</title>

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

<!--[if lt IE 9]>
<script src="js/html5shiv.min.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->

</head>

<body>




    <div class="layer"></div>
    <!-- Mobile menu overlay mask -->

    <!-- Header================================================== -->

    <!-- header.phpのrequire -->
    <?php require('header.php');  ?>

    <!-- End Header -->

    <section class="parallax-window" data-parallax="scroll" data-image-src="<?php echo $event_pic['e_pic_path'];?>" data-natural-width="1400" data-natural-height="470">
        <div class="parallax-content-2">
            <div class="container">
                <div class="row">

                    <div class="col-md-7 col-sm-7">
                        <h1><?php echo $event_data['e_name']; ?></h1> <!-- イベント名表示 -->
                        <span><?php echo $event_data['e_prefecture']; ?></span> <!-- 開催地名表示 -->

                    </div>
                    <div class="col-md-5 col-sm-5" style="font-size: 60px;">
                        <span><h1><?php echo $event_data['e_start_date'] . '〜'. $event_data['e_end_date']; ?></h1></span> <!-- 曜日・開催日時を表示 -->
                        <!-- <span class="favorites"><i class="icon-heart" style="color: red;"></i><b>125<b></span> <!-- お気に入り数の表示 -->
                        <!--                         <a class="btn-danger" href="" aria-expanded="false" width="40px" height="20">♡</a> -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End section -->


    <main>

        <div class="collapse" id="collapseMap">
            <div id="map" class="map"></div>
        </div>
        <!-- End Map -->


        <div class="container margin_60">
            <div class="row">

                <div class="col-md-8">
                    <!-- Map button for tablets/mobiles -->

                    <div id="Img_carousel" class="slider-pro" style="margin-bottom: 10px;">

                        <div class="sp-slides">

                            <?php  for ($j = 0; $j< count($event_pics); $j++) { ?>
                                <?php echo '<div class="sp-slide">' ?>
                                    <?php echo '<img' ?>    
                                    <?php echo 'alt="Image"'  ?> 
                                    <?php echo 'class="sp-image"'  ?> 
                                    <?php echo 'src="' . $event_pics[$j]['e_pic_path'] . '"'  ?> 
                                    <?php echo 'data-src="' . $event_pics[$j]['e_pic_path'] . '"'  ?> 
                                    <?php echo 'data-small="' . $event_pics[$j]['e_pic_path'] . '"'  ?> 
                                    <?php echo 'data-medium="' . $event_pics[$j]['e_pic_path'] . '"'  ?> 
                                    <?php echo 'data-large="' . $event_pics[$j]['e_pic_path'] . '"'  ?> 
                                    <?php echo 'data-retina="' . $event_pics[$j]['e_pic_path'] . '">'  ?> 
                                <?php echo '</div>'  ?>
                            <?php } ?>

                        </div>
                        <div class="sp-thumbnails">
                            <?php  for ($j = 0; $j< count($event_pics); $j++) { ?>
                            <?php echo '<img alt="Image" class="sp-thumbnail" src="' . $event_pics[$j]['e_pic_path'] . '">'  ?> 
                            <?php } ?>
                        </div>

                    </div>

                    <hr>

                    <!-- 以下、イベント説明 -->
                    <div class="row">
                        <div class="col-md-3">
                            <h3>Event Description</h3>
                        </div>
                        <div class="col-md-9">
                            <div style="word-wrap: break-word; width:99%; height:300px;">
                                <?php echo $event_data['explanation'] ?>
                            </div>
                        </div>
                    </div>

                    <!-- End row  -->

                    <hr>

                    <!-- 以下、イベント詳細 -->
                    <div class="row">
                        <div class="col-md-3">
                            <h3>Event Detail</h3>
                        </div>
                        <div class="col-md-9">
                            <div class=" table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th colspan="2">
                                                イベント開催詳細
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td width= "200" style="vertical-align: middle;">
                                                Event Name
                                            </td>
                                            <td>
                                                <div>
                                                    <?php echo $event_data['e_name']; ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="vertical-align: middle;">
                                                Date and time
                                            </td>
                                            <td>
                                                <div style="margin-bottom: 10px;">
                                                    イベント日程（開始日）（必須）<br>
                                                    <?php echo $event_data['e_start_date']; ?>
                                                </div>
                                                <div>
                                                    イベント日程（終了日）（必須）<br>
                                                    <?php echo $event_data['e_start_date']; ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="vertical-align: middle;">
                                                city
                                            </td>
                                            <td>
                                                <div>
                                                    <?php echo $event_data['e_prefecture']; ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="vertical-align: middle;">
                                                the place (follow on map)
                                            </td>
                                            <td>
                                                <div>
                                                    <?php echo $event_data['e_venue']; ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="vertical-align: middle;">
                                                Web page
                                            </td>
                                            <td>
                                                <div>
                                                    <?php echo $event_data['official_url']; ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="vertical-align: middle;">
                                                Acces
                                            </td>
                                            <td>
                                                <?php echo $event_data['e_venue']; ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class=" table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th colspan="2">
                                                The latest participants (The number of visitors)
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td width= "200" style="vertical-align: middle;">
                                                2014
                                            </td>
                                            <td>
                                                <div>
                                                    <?php echo $event_data['year_ppp']; ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="vertical-align: middle;">
                                                2015
                                            </td>
                                            <td>
                                                <div>
                                                    <?php echo $event_data['year_pp']; ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="vertical-align: middle;">
                                                2016
                                            </td>
                                            <td>
                                                <div>
                                                    <?php echo $event_data['year_p']; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-3">
                            <h3>Map</h3>
                        </div>
                        <div class="col-md-9">
                            <img src="img/SuperScreenshot 2017-7-3 12-49-11.png" width="450px" height="400px">
                        </div>
                    </div>

                    <hr>

                    <div class="row"><!-- レビュー表示 -->
                        <div class="col-md-3">
                            <h3>Reviews </h3> 
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div id="general_rating" class="rating">
                                    <div class="col-md-7">
                                        <span><?php echo($count); ?></span> Reviews <!-- レビュー件数表示 -->            
                                        <i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star"></i><i class="icon-star"></i> 
                                    </div>
                                    <div class="col-md-5">
                                        <a href="#" class="btn_1 add_bottom_30" data-toggle="modal" data-target="#myReview">Leave a review</a>
                                    </div>
                                </div> <!-- general_rating -->     
                            </div> 

                            <hr>

                            <?php foreach ($reviews as $review){ ?>
                                <div class="review_strip_single">
                                    <img src="../../users_pic/<?php echo($review['pic_path']); ?>" alt="Image" class="img-circle" width="70px" height="70px">

                                    <!--　レビュー作成日表示 -->
                                    <small><?php echo($review['created']);?></small>

                                    <!-- ユーザー名表示 -->
                                    <h4><?php echo($review['nickname']); ?></h4>

                                    <!-- レビュー評価表示機能 -->
                                    <?php if ($review['rating'] == 1){ ?>
                                        <?php v($review); ?>
                                        <div class="rating">
                                            <i class="icon-star voted"></i>
                                            <i class="icon-star"></i>
                                            <i class="icon-star"></i>
                                            <i class="icon-star"></i>
                                            <i class="icon-star"></i>
                                        </div>
                                        <?php }elseif ($review['rating'] == 2){ ?>
                                        <div class="rating">
                                            <i class="icon-star voted"></i>
                                            <i class="icon-star voted"></i>
                                            <i class="icon-star "></i>
                                            <i class="icon-star "></i>
                                            <i class="icon-star "></i>
                                        </div>
                                        <?php }elseif ($review['rating'] == 3){ ?>
                                        <div class="rating">
                                            <i class="icon-star voted"></i>
                                            <i class="icon-star voted"></i>
                                            <i class="icon-star voted"></i>
                                            <i class="icon-star "></i>
                                            <i class="icon-star "></i>
                                        </div>
                                        <?php }elseif ($review['rating'] == 4){ ?>
                                        <div class="rating">
                                            <i class="icon-star voted"></i>
                                            <i class="icon-star voted"></i>
                                            <i class="icon-star voted"></i>
                                            <i class="icon-star voted"></i>
                                            <i class="icon-star "></i>
                                        </div>
                                        <?php }elseif ($review['rating'] == 5){ ?>
                                        <div class="rating">
                                            <i class="icon-star voted"></i>
                                            <i class="icon-star voted"></i>
                                            <i class="icon-star voted"></i>
                                            <i class="icon-star voted"></i>
                                            <i class="icon-star voted"></i>
                                        </div>
                                    <?php }; ?>

                                    <!-- レビュー本文表示 -->
                                    <p><?php echo($review['comment']) ; ?></p>


                                </div> <!-- End review strip -->

                            <?php }; ?>
                        
                            <div align="center">
                                <a href="" class="btn_1 add_bottom_30">See all review</a>
                            </div>


                        </div> <!-- col-md-9 -->
                    </div> <!-- row -->
                    
                </div>
                <!--End  single_tour_desc-->

                <!-- event_aside挿入 --> 
                <?php //require('event_aside.php');  ?>

                <aside class="col-md-4">
                    <div class="box_style_1 expose">
                        <h3 class="inner">EVENT NEWS</h3>
                        <!-- ニュース表示 -->
                        <div id="scroll" class="news">

                            <?php if (isset($news)): ?>
                            <!-- ニュースデータがある場合はfor文で表示 -->
                                <?php foreach ($news as $new) { ?> 
                                    <p style="margin-bottom: 0px; color: black; font-weight: 600; text-decoration: underline;"><?php echo $new['news_title'];?></p>
                                    <p style="margin-bottom: 0px; color: black;"><?php echo $new['news_comment'];?></p>      
                                    <p style="margin-bottom: 0px; font-style:oblique;">登録日<?php echo $new['created'];?></p>
                                    <?php if ($new['created'] != $new['modified']): ?>
                                        <p style="margin-bottom: 0px; font-style:oblique;">変更日<?php echo $new['modified'];?></p>
                                    <?php endif; ?>
                                    <hr style="margin-top: 10px; margin-bottom: 10px;">
                                <?php } ?>
                            <?php else: ?>
                            <!-- ニュースデータがない場合 -->
                            お知らせはありません。
                            <?php endif; ?>
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
                            <div style="overflow: scroll; height: 1400px">
                            <?php v(count($requests)) ?>
                                <?php if ($_SESSION['id'] != '' && $_SESSION['flag'] == '1'): ?>
                                    <?php foreach ($requests as $request){ ?>
                                     <div class="row" style=" border-radius: 3px; padding: 10px; padding-bottom: 5px; margin-top: 10px; box-shadow:0 0 5px #fff, 0 0 5px #ccc, 0 0 1px #aaa; ">
                                        <div class="col-md-6 col-sm-6" style="padding-left: 0; padding-top: 5px;">
                                            <div style="text-align: center">
                                                <img src="../../users_pic/<?php echo($request['pic_path']); ?>" alt="Image" class="img-circle" width="95px" height="95px" >
                                            </div>
                                            <h4 style="margin-top: 0px; text-align: center; margin-bottom: 5px;"><?php echo($request['nickname']); ?></h4>
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
                                    <?php } ?>
                                <?php elseif ($_SESSION['id'] != '' && $_SESSION['flag'] == ''): ?>
                                    <?php foreach ($requests as $request){ ?>
                                     <div class="row" style=" border-radius: 3px; padding: 10px; padding-bottom: 5px; margin-top: 10px; box-shadow:0 0 5px #fff, 0 0 5px #ccc, 0 0 1px #aaa; ">
                                        <div class="col-md-6 col-sm-6" style="padding-left: 0; padding-top: 5px;">
                                            <div style="text-align: center">
                                                <img src="../../users_pic/<?php echo($request['pic_path']); ?>" alt="Image" class="img-circle" width="95px" height="95px" >
                                            </div>
                                            <h4 style="margin-top: 0px; text-align: center; margin-bottom: 5px;"><?php echo($request['nickname']); ?></h4>
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
                                    <?php } ?>
                                </div>
                            <?php elseif ($_SESSION['id'] == '' && $_SESSION['flag'] == ''): ?>


                            <?php elseif ($_SESSION['id'] == '1' && $_SESSION['flag'] == '0'): ?>

                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- <div>
                        <input type="button"  value="REQUEST" style="width:360px; height: 50px;" class="btn btn-danger" >
                    </div> -->
                   <!--  -->
                
                        <p>
                            <a class="btn_map" name="request" data-toggle="modal" href="" data-text-original="Request to eve tomo" data-target="#myRequest">Request to eve tomo</a>
                        </p>
                    

                </aside> <!-- class="col-md-4" -->

            </div>
        </div>
        <!--End container -->
        <div id="overlay"></div>
        <!-- Mask on input focus -->
    </div>
</main>
<!-- End main -->

    <!-- フッター呼び出し -->
    <?php require('footer.php'); ?>

    <!-- モーダル・ログイン -->
    <?php require('modal_login.php'); ?>

    <!-- モーダル・ユーザー登録 -->
    <?php require('modal_register_user.php'); ?>

    <!-- モーダル・主催者登録 -->
    <?php require('modal_register_organizer.php'); ?>

    <!-- モーダル・レビュー登録 -->
    <?php require('modal_leave_review.php'); ?>

    <!-- モーダル・リクエスト登録 -->
    <?php require('modal_register_request.php'); ?>

<div id="toTop"></div>
<!-- Back to top button -->


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

<script src="js/modal_login_ajax.js"></script>
<script src="js/modal_register_user_ajax.js"></script>
<script src="js/modal_register_organizer_ajax.js"></script>
<!-- 自作のJS -->
<script src="js/custom.js"></script>


</body>

<footer>
    <!-- require('../../common/footer.php'); -->
</footer>
</html>