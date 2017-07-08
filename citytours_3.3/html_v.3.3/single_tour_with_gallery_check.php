<?php  
  
session_start();
require('../../common/dbconnect.php');

  //sha1()関数 暗号化（ハッシュ化）
  //逆置換できません。
  // $password = sha1('hogehoge');
  // echo $password;




  // sessionを持たない状態で直接、このページに来た時には、event_input_index.phpに自動遷移
  if(!isset($_SESSION['event'])){
    header('Location: single_tour_with_gallery.php');
  exit();

  //emptyは箱があって、値が入っているかどうか？
  //issetはそもそも箱があるかどうか。
  }

  //会員登録ボタンが押された際の処理
  if(!empty($_POST)){

  // echo '<pre>';
  // var_dump($_POST);
  // echo '</pre>';
    // eventsテーブルへの登録
  $sql = 'INSERT INTO events
                  SET e_name = ?,
                      e_start_date = ?,
                      e_end_date = ?,
                      e_prefecture = ?,
                      e_venue = ?,
                      explanation = ?,
                      e_access = ?,
                      year_p = ?,
                      year_pp = ?,
                      year_ppp = ?,
                      official_url = ?,
                      created = NOW()';

  $data = [ $_SESSION['event']['e_name'],
            $_SESSION['event']['e_start_date'],
            $_SESSION['event']['e_end_date'],
            $_SESSION['event']['e_prefecture'],
            // $_SESSION['event']['e_postal'],
            // $_SESSION['event']['e_address'],
            $_SESSION['event']['e_venue'],
            // $_SESSION['event']['e_o_name'],
            // $_SESSION['event']['e_o_tel'],
            // $_SESSION['event']['e_o_email'],
            $_SESSION['event']['explanation'],
            $_SESSION['event']['e_access'],
            // $_SESSION['event']['priority'],
            // $_SESSION['event']['start_year'],
            $_SESSION['event']['year_p'],
            $_SESSION['event']['year_pp'],
            $_SESSION['event']['year_ppp'],
            // $_SESSION['event']['attendance_p'],
            // $_SESSION['event']['attendance_pp'],
            // $_SESSION['event']['attendance_ppp'],
            $_SESSION['event']['official_url']];
            // $_SESSION['event']['related_url']];
    $events_stmt = $dbh->prepare($sql);
    $events_stmt->execute($data);

    $sql = 'SELECT event_id FROM events ORDER BY event_id desc limit 1';
    //TODO!:条件に主催者IDを加えないと、他人も含めた最新の一件を取得しちゃうかも。
    $events_stmt = $dbh->prepare($sql);
    $events_stmt->execute();
    $event_id = $events_stmt->fetch(PDO::FETCH_ASSOC);

    // newsテーブルへの登録
    $sql = 'INSERT INTO news
                    SET event_id= ?,
                        news_comment = ?,
                        created = NOW()';

    $data = [ $event_id,$_SESSION['event']['news_comment']];
    $news_comment_stmt = $dbh->prepare($sql);
    $news_comment_stmt->execute($data);


    // event_picsテーブルへの登録
    $sql = 'INSERT INTO event_pics
                    SET event_id= ?,
                        e_pic_path = ?,
                        created = NOW()';

    $data = [ $event_id,$_SESSION['event']['e_pic_path']];
    $event_pics_stmt = $dbh->prepare($sql);
    $event_pics_stmt->execute($data);



    unset($_SESSION['event']);
    //TODO!:なんでunsetなんだっけ？

    header('Location: ../layout/event_detail.php');
    exit();

  }

?>


<!DOCTYPE html>
<!--[if IE 8]><html class="ie ie8"> <![endif]-->
<!--[if IE 9]><html class="ie ie9"> <![endif]-->
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

    <!-- 大澤：なんの機能かよくわからないが消しても問題なし。消すのは怖いので、コメントアウト -->
	<!-- <div id="preloader">
		<div class="sk-spinner sk-spinner-wave">
			<div class="sk-rect1"></div>
			<div class="sk-rect2"></div>
			<div class="sk-rect3"></div>
			<div class="sk-rect4"></div>
			<div class="sk-rect5"></div>
		</div>
	</div> -->
    <!-- End Preload -->

	<div class="layer"></div>
	<!-- Mobile menu overlay mask -->

	<!-- Header================================================== -->
	<header>
		<div class="container">
			<div class="row">
				<div class="col-md-3 col-sm-3 col-xs-3">
					<div id="logo">
						<a href="index.html"><img src="japanival_logo.png" width="160" height="50" alt="City tours" data-retina="true" class="logo_normal">
						</a>
						<a href="index.html"><img src="japanival_logo.png" width="160" height="50" alt="City tours" data-retina="true" class="logo_sticky">
						</a>
					</div>
				</div>
				<nav class="col-md-6 col-sm-6 col-xs-6">
                    <div class="main-menu">
                        <!-- <div id="header_menu">
                            <img src="img/logo_sticky.png" width="160" height="34" alt="City tours" data-retina="true">
                        </div>
                        <a href="#" class="open_close" id="close_in"><i class="icon_set_1_icon-77"></i></a> -->
                        <ul>
                            <li class="submenu">
                                <a href="javascript:void(0);" class="show-submenu"  style="font-size: 20px">Home <i class="icon-down-open-mini"></i></a>
                                <ul>
                                    <li><a href="javascript:void(0);">Revolution slider</a>
                                        <ul>
                                            <li><a href="index.html">Default slider</a></li>
                                            <li><a href="index_20.html">Advanced slider</a></li>
                                            <li><a href="index_14.html">Youtube Hero</a></li>
                                            <li><a href="index_15.html">Vimeo Hero</a></li>
                                            <li><a href="index_17.html">Youtube 4K</a></li>
                                            <li><a href="index_16.html">Carousel</a></li>
                                            <li><a href="index_19.html">Mailchimp Newsletter</a></li>
                                            <li><a href="index_18.html">Fixed Caption</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="index_12.html">Layer slider</a></li>
                                    <li><a href="index_2.html">With Only tours</a></li>
                                    <li><a href="index_3.html">Single image</a></li>
                                    <li><a href="index_4.html">Header video</a></li>
                                    <li><a href="index_7.html">With search panel</a></li>
                                    <li><a href="index_13.html">With tabs</a></li>
                                    <li><a href="index_5.html">With map</a></li>
                                    <li><a href="index_6.html">With search bar</a></li>
                                    <li><a href="index_8.html">Search bar + Video</a></li>
                                    <li><a href="index_9.html">With Text Rotator</a></li>
                                    <li><a href="index_10.html">With Cookie Bar (EU law)</a></li>
                                    <li><a href="index_11.html">Popup Advertising</a></li>
                                </ul>
                            </li>
                            <li class="submenu">
                                <a href="javascript:void(0);" class="show-submenu" style="font-size: 20px">PickUp <i class="icon-down-open-mini"></i></a>
                                <ul>
                                    <li><a href="all_tours_list.html">All tours list</a></li>
                                    <li><a href="all_tours_grid.html">All tours grid</a></li>
                                    <li><a href="all_tours_map_listing.html">All tours map listing</a></li>
                                    <li><a href="single_tour.html">Single tour page</a></li>
                                    <li><a href="single_tour_with_gallery.html">Single tour with gallery</a></li>
                                    <li><a href="javascript:void(0);">Single tour fixed sidebar</a>
                                        <ul>
                                            <li><a href="single_tour_fixed_sidebar.html">Single tour fixed sidebar</a></li>
                                            <li><a href="single_tour_with_gallery_fixed_sidebar.html">Single tour 2 Fixed Sidebar</a></li>
                                            <li><a href="cart_fixed_sidebar.html">Cart Fixed Sidebar</a></li>
                                            <li><a href="payment_fixed_sidebar.html">Payment Fixed Sidebar</a></li>
                                            <li><a href="confirmation_fixed_sidebar.html">Confirmation Fixed Sidebar</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="single_tour_working_booking.php">Single tour working booking</a></li>
                                    <li><a href="cart.html">Single tour cart</a></li>
                                    <li><a href="payment.html">Single tour booking</a></li>
                                </ul>
                            </li>
                            <li class="submenu">
                                <a href="javascript:void(0);" class="show-submenu" style="font-size: 20px">Serch <i class="icon-down-open-mini"></i></a>
                                <ul>
                                    <li><a href="all_restaurants_list.html">All restaurants list</a></li>
                                    <li><a href="all_restaurants_grid.html">All restaurants grid</a></li>
                                    <li><a href="all_restaurants_map_listing.html">All restaurants map listing</a></li>
                                    <li><a href="single_restaurant.html">Single restaurant page</a></li>
                                    <li><a href="payment_restaurant.html">Booking restaurant</a></li>
                                    <li><a href="confirmation_restaurant.html">Confirmation transfers</a></li>
                                </ul>
                            </li>
                            <li class="megamenu submenu">
                                <a href="javascript:void(0);" class="show-submenu-mega" style="font-size: 20px">Others<i class="icon-down-open-mini"></i></a>
                                <div class="menu-wrapper">
                                    <div class="col-md-4">
                                        <h3>Pages</h3>
                                        <ul>
                                            <li><a href="about.html">About us</a></li>
                                           <li><a href="general_page.html">General page</a></li>
                                            <li><a href="tourist_guide.html">Tourist guide</a></li>
                                             <li><a href="wishlist.html">Wishlist page</a></li>
                                             <li><a href="faq.html">Faq</a></li>
                                             <li><a href="faq_2.html">Faq smooth scroll</a></li>
                                             <li><a href="pricing_tables.html">Pricing tables</a></li>
                                             <li><a href="gallery_3_columns.html">Gallery 3 columns</a></li>
                                            <li><a href="gallery_4_columns.html">Gallery 4 columns</a></li>
                                            <li><a href="grid_gallery_1.html">Grid gallery</a></li>
                                            <li><a href="grid_gallery_2.html">Grid gallery with filters</a></li>
                                        </ul>
                                    </div>
                                    <div class="col-md-4">
                                        <h3>Pages</h3>
                                        <ul>
                                            <li><a href="contact_us_1.html">Contact us 1</a></li>
                                            <li><a href="contact_us_2.html">Contact us 2</a></li>
                                             <li><a href="blog_right_sidebar.html">Blog</a></li>
                                            <li><a href="blog.html">Blog left sidebar</a></li>
                                            <li><a href="login.html">Login</a></li>
                                            <li><a href="register.html">Register</a></li>
                                            <li><a href="invoice.html" target="_blank">Invoice</a></li>
                                            <li><a href="404.html">404 Error page</a></li>
                                            <li><a href="site_launch/index.html">Site launch / Coming soon</a></li>
                                            <li><a href="timeline.html">Tour timeline</a></li>
                                            <li><a href="page_with_map.html"><i class="icon-map"></i>  Full screen map</a></li>
                                        </ul>
                                    </div>
                                    <div class="col-md-4">
                                        <h3>Elements</h3>
                                         <ul>
                                            <li><a href="footer_2.html"><i class="icon-columns"></i> Footer with working newsletter</a></li>
                                            <li><a href="footer_5.html"><i class="icon-columns"></i> Footer with Twitter feed</a></li>
                                            <li><a href="icon_pack_1.html"><i class="icon-inbox-alt"></i> Icon pack 1 (1900)</a></li>
                                            <li><a href="icon_pack_2.html"><i class="icon-inbox-alt"></i> Icon pack 2 (100)</a></li>
                                            <li><a href="icon_pack_3.html"><i class="icon-inbox-alt"></i> Icon pack 3 (30)</a></li>
                                            <li><a href="icon_pack_4.html"><i class="icon-inbox-alt"></i> Icon pack 4 (200)</a></li>
                                            <li><a href="icon_pack_5.html"><i class="icon-inbox-alt"></i> Icon pack 5 (360)</a></li>
                                            <li><a href="shortcodes.html"><i class="icon-tools"></i> Shortcodes</a></li>
                                            <li><a href="newsletter_template/newsletter.html" target="blank"><i class=" icon-mail"></i> Responsive email template</a></li>
                                            <li><a href="admin.html"><i class="icon-cog-1"></i>  Admin area</a></li>
                                            <li><a href="general_page.html"><i class="icon-light-up"></i>  Weather Forecast</a></li>                                             
                                        </ul>
                                    </div>
                                </div><!-- End menu-wrapper -->
                            </li>
                        </ul>
                    </div><!-- End main-menu -->
                </nav>

                <!-- <nav class="col-md-3 col-sm-3 col-xs-3">

                    <ul id="personalarea">
                        <li class="right personal">
                            <a href="favorites.html" id="favorites_link">Favorites</a>
                        <li>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class=" icon-chat"></i>Chat (2)</a>
                        </li>
                        <li>
                            <img src="e_pic_path/profile1.jpg" width="40px" height="40px">
                        </li>
                    </ul>
                </nav><!col-md-3 col-sm-3 col-xs-3 -->

                <nav class="col-md-3 col-sm-3 col-xs-3">
                    <div class="main-menu">
                        <ul>
                            <li class="submenu">
                                <a href="javascript:void(0);" class="show-submenu"><i class="icon-heart"></i>Favorites</a>
                            </li>
                            <li class="submenu">
                                <a href="javascript:void(0);" class="show-submenu"><i class="icon-chat"></i>Chat (2)</a>
                                <ul>
                                    <li><a href="all_transfer_list.html">All transfers list</a></li>
                                    <li><a href="all_transfer_grid.html">All transfers grid</a></li>
                                    <li><a href="single_transfer.html">Single transfer page</a></li>
                                    <li><a href="cart_transfer.html">Cart transfers</a></li>
                                    <li><a href="payment_transfer.html">Booking transfers</a></li>
                                    <li><a href="confirmation_transfer.html">Confirmation transfers</a></li>
                                </ul>
                            </li>
                            <li class="submenu" style="margin-left: 20px;">
                                <a href="">
                                    <img class="img-circle" src="e_pic_path/profile1.jpg" style="width: 40px; height: 40px;">
                                </a>
                                <!-- <ul>
                                    <li><a href="all_restaurants_list.html">All restaurants list</a></li>
                                    <li><a href="all_restaurants_grid.html">All restaurants grid</a></li>
                                    <li><a href="all_restaurants_map_listing.html">All restaurants map listing</a></li>
                                    <li><a href="single_restaurant.html">Single restaurant page</a></li>
                                    <li><a href="payment_restaurant.html">Booking restaurant</a></li>
                                    <li><a href="confirmation_restaurant.html">Confirmation transfers</a></li>
                                </ul> -->
                            </li>
                        </ul>
                    </div><!-- End main-menu -->
                </nav>

			</div><!-- row -->
		</div><!-- container -->
	</header>
	<!-- End Header -->

	<section class="parallax-window" data-parallax="scroll" data-image-src=<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?> data-natural-width="1000" data-natural-height="470">
		<div class="parallax-content-2">
			<div class="container">
				<div class="row">
					<div class="col-md-7 col-sm-7">
						<h1><?php echo htmlspecialchars($_SESSION['event']['e_name']); ?></h1> <!-- イベント名表示 -->
						<span><?php echo htmlspecialchars($_SESSION['event']['e_venue']); ?></span> <!-- 開催地名表示 -->
					</div>
					<div class="col-md-5 col-sm-5" style="font-size: 60px;">
  			    <span><b><?php echo htmlspecialchars($_SESSION['event']['e_start_date']); ?></b></span> <!-- 曜日・開催日時を表示 -->
            <span class="favorites"><i class="icon-heart" style="color: red;"></i><b>125<b></span> <!-- お気に入り数の表示 -->
            <a class="btn-danger" href="" aria-expanded="false" width="40px" height="20">♡</a>
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
					<p class="visible-sm visible-xs"><a class="btn_map" data-toggle="collapse" href="#collapseMap" aria-expanded="false" aria-controls="collapseMap" data-text-swap="Hide map" data-text-original="Confirm to eve tomo">Confirm to eve tomo</a>
					</p>
					<!-- Map button for tablets/mobiles -->

					<div id="Img_carousel" class="slider-pro">
						<div class="sp-slides">

							<div class="sp-slide">
                <img src="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>">
							</div>

              <div class="sp-slide">
                  <img alt="Image" class="sp-image" src="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>" data-src="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>" data-small="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>" data-medium="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>" data-large="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>" data-retina="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>">
              </div>

              <div class="sp-slide">
                  <img alt="Image" class="sp-image" src="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>" data-src="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>" data-small="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>" data-medium="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>" data-large="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>" data-retina="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>">
              </div>

              <div class="sp-slide">
                  <img alt="Image" class="sp-image" src="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>" data-src="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>" data-small="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>" data-medium="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>" data-large="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>" data-retina="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>">
              </div>

              <div class="sp-slide">
                  <img alt="Image" class="sp-image" src="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>" data-src="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>" data-small="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>" data-medium="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>" data-large="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>" data-retina="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>">
              </div>

              <div class="sp-slide">
                  <img alt="Image" class="sp-image" src="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>" data-src="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>" data-small="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>" data-medium="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>" data-large="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>" data-retina="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>">
              </div>

              <div class="sp-slide">
                  <img alt="Image" class="sp-image" src="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>" data-src="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>" data-small="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>" data-medium="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>" data-large="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>" data-retina="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>">
              </div>

              <div class="sp-slide">
                  <img alt="Image" class="sp-image" src="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>" data-src="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>" data-small="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>" data-medium="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>" data-large="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>" data-retina="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>">
              </div>

              <div class="sp-slide">
                  <img alt="Image" class="sp-image" src="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>" data-src="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>" data-small="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>" data-medium="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>" data-large="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>" data-retina="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>">
              </div>

              <div class="sp-slide">
                  <img alt="Image" class="sp-image" src="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>" data-src="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>" data-small="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>" data-medium="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>" data-large="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>" data-retina="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>">
              </div>

              <div class="sp-slide">
                  <img alt="Image" class="sp-image" src="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>" data-src="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>" data-small="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>" data-medium="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>" data-large="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>" data-retina="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>">
              </div>
						</div>

						<div class="sp-thumbnails">
							<img alt="Image" class="sp-thumbnail" src="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>">
							<img alt="Image" class="sp-thumbnail" src="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>">
							<img alt="Image" class="sp-thumbnail" src="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>">
							<img alt="Image" class="sp-thumbnail" src="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>">
							<img alt="Image" class="sp-thumbnail" src="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>">
							<img alt="Image" class="sp-thumbnail" src="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>">
							<img alt="Image" class="sp-thumbnail" src="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>">
							<img alt="Image" class="sp-thumbnail" src="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>">
							<img alt="Image" class="sp-thumbnail" src="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>">
              <img alt="Image" class="sp-thumbnail" src="<?php echo htmlspecialchars($_SESSION['event']['e_pic_path']); ?>">
						</div>
					</div>

					<hr>

                    <!-- 以下、イベント説明 -->
					<div class="row">
						<div class="col-md-3">
							<h3>Event Description</h3>
						</div>
						<div class="col-md-9">
                            <div>
                                <?php echo htmlspecialchars($_SESSION['event']['explanation']); ?>
                            </div>
						</div>
					</div> <!-- End row  -->

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
											<td>
											    Event Name
											</td>
											<td>
												<div>
                          <?php echo htmlspecialchars($_SESSION['event']['e_name']); ?>
                        </div>
											</td>
										</tr>
                                        <tr>
                                            <td>                                        
                                                Category
                                            </td>
                                            <td>
                                                
                                            </td>
                                        </tr>
										<tr>
											<td>
												Date and time
											</td>
											<td>
												<div>
                          <?php echo htmlspecialchars($_SESSION['event']['e_start_date']); ?>
                        </div>
                      </td>
                      <td>
                        <div>
                            <?php echo htmlspecialchars($_SESSION['event']['e_end_date']); ?>
                        </div>
											</td>
										</tr>
                                        <tr>
                                            <td>
                                                city
                                            </td>
                                            <td>
                                              <div>
                                                <?php echo htmlspecialchars($_SESSION['event']['e_prefecture']); ?>
                                              </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                the place (follow on map)
                                            </td>
                                            <td>
                                              <div>
                                                <?php echo htmlspecialchars($_SESSION['event']['e_venue']); ?>
                                              </div>
                                            </td>
                                        </tr>
										<tr>
											<td>
												Web page
											</td>
											<td>
                                                <div>
                                                  <?php echo htmlspecialchars($_SESSION['event']['official_url']); ?>
                                                </div>
											</td>
										</tr>
										<tr>
											<td>
												Acces
   											</td>
											<td>
												<?php echo htmlspecialchars($_SESSION['event']['e_access']); ?>
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
											<td>
												2014
											</td>
											<td>
												<div>
                          <?php echo htmlspecialchars($_SESSION['event']['year_ppp']); ?>
                        </div>
											</td>
										</tr>
										<tr>
											<td>
												2015
											</td>
											<td>
												<div>
                          <?php echo htmlspecialchars($_SESSION['event']['year_pp']); ?>
                        </div>
											</td>
										</tr>
										<tr>
											<td>
												2016
											</td>
											<td>
												<div>
                          <?php echo htmlspecialchars($_SESSION['event']['year_p']); ?>
                        </div>
											</td>
										</tr>
									</tbody>
								</table>
                  <form method="POST" action="single_tour_with_gallery_check.php">
                    <a href="single_tour_with_gallery.php?action=rewrite">&laquo;&nbsp;書き直す</a>
                    <input type="hidden" name="action" value="aaaaaa">
                    <input type="submit" value="会員登録">
                  </form>
							</div>
						</div>
					</div>

                    <hr>

                    <div class="row">
                        <div class="col-md-3">
                            <h3>Map</h3>
                        </div>
                        <div class="col-md-9">
                            <img src="img/SuperScreenshot 2017-7-3 12-49-11.png" width="550px" height="400px">
                        </div>
                    </div>

					<hr>
					<div class="row">
						<div class="col-md-3">
							<h3>Reviews </h3>
						</div>
						<div class="col-md-9">
							<div id="general_rating" class="rating">3 review_strip_single
									<i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star"></i><i class="icon-star"></i>
                                    <a href="#" class="btn_1 add_bottom_30" data-toggle="modal" data-target="#myReview">Leave a review</a>
							</div>
							<!-- End general_rating -->
							<hr>
							<div class="review_strip_single">
								<img src="img/spongebob.jpg" alt="Image" class="img-circle" width="70px" height="70px">
								<h4>Sponge Bob</h4>
                                <div class="rating">
                                    <i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i>
                                </div>
                                <small> - 10 August 2016 -</small>
								
								<p>
									"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed a lorem quis neque interdum consequat ut sed sem. Duis quis tempor nunc. Interdum et malesuada fames ac ante ipsum primis in faucibus."
								</p>
								
							</div>
							<!-- End review strip -->

							<div class="review_strip_single">
								<img src="img/patrick.png" alt="Image" class="img-circle" width="70px" height="70px">
								<small> - 10 August 2016 -</small>
								<h4>Patrick</h4>
								<p>
									"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed a lorem quis neque interdum consequat ut sed sem. Duis quis tempor nunc. Interdum et malesuada fames ac ante ipsum primis in faucibus."
								</p>
								<div class="rating">
									<i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i>
								</div>
							</div>
							<!-- End review strip -->

							<div class="review_strip_single last">
								<img src="img/squidward.jpg" alt="Image" class="img-circle" width="70px" height="70px"> 
								<small> - 10 August 2016 -</small>
								<h4>Squidward</h4>
								<p>
									"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed a lorem quis neque interdum consequat ut sed sem. Duis quis tempor nunc. Interdum et malesuada fames ac ante ipsum primis in faucibus."
								</p>
								<div class="rating">
									<i class="icon-star voted"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i>
								</div>
							</div>
                            <div align="center">
                                <a href="#" class="btn_1 add_bottom_30" data-toggle="modal" data-target="#myReview">See all review</a>
                            </div>
                            
							<!-- End review strip -->
						</div>
					</div>
				</div>
				<!--End  single_tour_desc-->

				<aside class="col-md-4">
                    <div class="row">
                        <div id="eve_info" class="box_style_1 expose">
                            <h3 class="inner">Information</h3>
                            <div id="scroll" class="info">
                              <div>
                                <?php echo htmlspecialchars($_SESSION['event']['news_comment']); ?>
                              </div>
                            </div>
                        </div>
    					<div id="eve_tomo" class="box_style_1 expose">
    						<h3 class="inner">Eve tomo</h3>
        						<div class="eve_tomo">
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
        						</div><hr>

                                <div class="eve_tomo" class="scr">
                                    <div id="profile">
                                        
                                        <div class="profile 1">
                                            <div class="col-md-5 col-sm-5">
                                                <img src="img/spongebob.jpg" alt="Image" class="img-circle" width="80px" height="80px">
                                            </div>
                                            <div class="col-md-7 col-sm-7" align="center">
                                                <h3>Sponge Bob</h3> 
                                                <img src="img/japan.png" width="32px" height="20px"> <!-- 国籍(国旗)表示 -->
                                                <p>JP/EN</p> <!-- 対応可能言語表示 -->
                                            </div>
                                        </div>
                                        <div class="purpose">
                                            <div class="purpose title">Purpose:</div>
                                            <div class="purpose content">この祭りのガイドをしてもらいたいです！</div>
                                        </div>
                                        <div class="button">
                                             <!-- 個人詳細ページに戦遷移 -->
                                            <div class="col-md-6 col-sm-6">
                                                <a class="btn_full" href="profile.html"><i class=" icon-user"></i>Profile</a>
                                             </div>
                                              <!-- チャットページに遷移 -->
                                            <div class="col-md-6 col-sm-6">
                                                <a class="btn_full_outline" href="chat"><i class=" icon-chat"></i>Chat</a>
                                             </div>
                                        </div>
                                    </div>

                                <hr>

    					</div>
    					<!--/box_style_1 -->

                        <!-- マッチング希望ボタン -->
                         <p>
                            <a class="btn_map" data-toggle="collapse" href="" aria-expanded="false" aria-controls="collapseMap" data-text-swap="Cancel" data-text-original="Confirm to eve tomo">Confirm to eve tomo</a>
                        </p>
                        <!-- 終了タグ　マッチング希望ボタン -->
                    </div>
				</aside>
			</div>
			<!--End row -->
		</div>
		<!--End container -->
        
        <div id="overlay"></div>
		<!-- Mask on input focus -->
        
	</main>
	<!-- End main -->

	<footer class="revealed">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-3">
                    <h3>Need help?</h3>
                    <a href="tel://004542344599" id="phone">+45 423 445 99</a>
                    <a href="mailto:help@citytours.com" id="email_footer">help@citytours.com</a>
                </div>
                <div class="col-md-3 col-sm-3">
                    <h3>About</h3>
                    <ul>
                        <li><a href="#">About us</a></li>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Login</a></li>
                        <li><a href="#">Register</a></li>
                         <li><a href="#">Terms and condition</a></li>
                    </ul>
                </div>
                <div class="col-md-3 col-sm-3">
                    <h3>Discover</h3>
                    <ul>
                        <li><a href="#">Community blog</a></li>
                        <li><a href="#">Tour guide</a></li>
                        <li><a href="#">Wishlist</a></li>
                         <li><a href="#">Gallery</a></li>
                    </ul>
                </div>
                <div class="col-md-2 col-sm-3">
                    <h3>Settings</h3>
                    <div class="styled-select">
                        <select class="form-control" name="lang" id="lang">
                            <option value="English" selected>English</option>
                            <option value="French">Japanese</option>
                        </select>
                    </div>
                </div>
            </div><!-- End row -->
            <div class="row">
                <div class="col-md-12">
                    <div id="social_footer">
                        <ul>
                            <li><a href="#"><i class="icon-facebook"></i></a></li>
                            <li><a href="#"><i class="icon-twitter"></i></a></li>
                            <li><a href="#"><i class="icon-google"></i></a></li>
                            <li><a href="#"><i class="icon-instagram"></i></a></li>
                            <li><a href="#"><i class="icon-pinterest"></i></a></li>
                            <li><a href="#"><i class="icon-vimeo"></i></a></li>
                            <li><a href="#"><i class="icon-youtube-play"></i></a></li>
                            <li><a href="#"><i class="icon-linkedin"></i></a></li>
                        </ul>
                        <p>© Japanival 2017</p>
                    </div>
                </div>
            </div><!-- End row -->
        </div><!-- End container -->
    </footer><!-- End footer -->

	<div id="toTop"></div><!-- Back to top button -->
	
	<!-- Search Menu -->
	<div class="search-overlay-menu">
		<span class="search-overlay-close"><i class="icon_set_1_icon-77"></i></span>
		<form role="search" id="searchform" method="get">
			<input value="" name="q" type="search" placeholder="Search..." />
			<button type="submit"><i class="icon_set_1_icon-78"></i>
			</button>
		</form>
	</div><!-- End Search Menu -->

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
					<form method="post" action="assets/review_tour.php" name="review_tour" id="review_tour">
						<input name="tour_name" id="tour_name" type="hidden" value="Paris Arch de Triomphe Tour">
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
									<label>Tourist guide</label>
									<select class="form-control" name="guide_review" id="guide_review">
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