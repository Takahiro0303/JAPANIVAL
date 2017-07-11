<?php
session_start();
require('../../common/dbconnect.php');
require('../../common/functions.php');
$login_user = get_login_user($dbh);

$nickname = $login_user['nickname'];
$email = $login_user['email'];
$nationality = $login_user['nationality'];
$gender = $login_user['gender'];
$level = $login_user['level'];
$self_intro = $login_user['self_intro'];
$errors = [];

if (!empty($_POST)) {
  $current_password = sha1($_POST['current_password']);
  if ($current_password == $login_user['password']) {
//現在のパスワードが一致するとき

    $nickname = $_POST['nickname'];
    $email = $_POST['email'];
    $nationality = $_POST['nationality'];
    $gender = $_POST['gender'];
    $level = $_POST['level'];
    $self_intro = $_POST['self_intro'];

    if ($nickname == '') {
      $errors['nickname'] = 'blank';
    }
    if ($email == '') {
      $errors['email'] = 'blank';
    }
    if ($nationality == '') {
      $errors['nationality'] = 'blank';
    }
    if ($gender == '') {
      $errors['gender'] = 'blank';
    }
    if ($self_intro == '') {
      $errors['self_intro'] = 'blank';
    }

    if (!empty($_POST['new_password'])) {
//new_passwordが空じゃない場合
      if (strlen($_POST['new_password']) >= 6) {
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];
        if ($new_password != $confirm_password) {
//new_passwordとconfirm_passwordが一致しなかった場合
          $errors['confirm_password'] = 'wrong';
        }
      } else {
        $errors['new_password'] = 'length';
      }
    }

    $file_name = $_FILES['pic_path']['nickname'];
    if (!empty($file_name)) {
//画像が選択されていた場合
      $ext = substr($file_name, -3);
      $ext = strtolower($ext);
      if ($ext != 'jpg' && $ext != 'png' && $ext != 'gif') {
        $errors['pic_path'] = 'type';
      }
    }
  } else {
    $errors['current_password'] = 'failed';
  }

  if (empty($errors)) {
//もし画像がセットされていれば画像アップデート処理
    if (!empty($file_name)) {
      $date_str = date('YmdHis');
      $submit_file_name = $date_str . $_FILES['pic_path']['nickname'];
      move_uploaded_file($_FILES['pic_path']['tmp_name'], '../../users_pic/' . $submit_file_name);
    }

//データベース更新処理
    if (empty($new_password)) {
      $password = $current_password;
    } else {
      $password = sha1($new_password);
    }

//pic_pathのパターン
//変更なし
//$login_user['pic_path']
//変更あり
//$submit_file_name
    if (empty($file_name)) {
      $submit_file_name = $login_user['pic_path'];
    }

    $sql = 'UPDATE users SET nickname=?,
    email=?,
    nationality=?,
    gender=?,
    password=?,
    self_intro=?,
    pic_path=?,
    modified=NOW()   
    WHERE user_id=?';
    $data = [$nickname,
    $email,
    $nationality,
    $gender,
    $password,
    $self_intro,
    $submit_file_name,
    $login_user['user_id']];
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    header('Location: admin_user.php');
    exit();
  }
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
  <title>CITY TOURS - City tours and travel site template by Ansonika</title>

  <!-- Favicons-->
  <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
  <link rel="apple-touch-icon" type="image/x-icon" href="img/apple-touch-icon-57x57-precomposed.png">
  <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="img/apple-touch-icon-72x72-precomposed.png">
  <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="img/apple-touch-icon-114x114-precomposed.png">
  <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="img/apple-touch-icon-144x144-precomposed.png">

  <!-- Google web fonts -->
  <link href="https://fonts.googleapis.com/css?family=Gochi+Hand|Lato:300,400|Montserrat:400,400i,700,700i" rel="stylesheet">

  <!-- CSS -->
  <link href="css/base.css" rel="stylesheet">

  <!-- SPECIFIC CSS -->
  <link href="css/admin.css" rel="stylesheet">
  <link href="css/jquery.switch.css" rel="stylesheet">

<!--[if lt IE 9]>
<script src="js/html5shiv.min.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->

</head>

<body>

<!--[if lte IE 8]>
<p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a>.</p>
<![endif]-->

<div id="preloader">
  <div class="sk-spinner sk-spinner-wave">
    <div class="sk-rect1"></div>
    <div class="sk-rect2"></div>
    <div class="sk-rect3"></div>
    <div class="sk-rect4"></div>
    <div class="sk-rect5"></div>
  </div>
</div>
<!-- End Preload -->

<div class="layer"></div>
<!-- Mobile menu overlay mask -->

<!-- Header================================================== -->


<header>
  <div id="top_line">
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-6"><i class="icon-phone"></i><strong>0045 043204434</strong>
        </div>

        <div class="col-md-6 col-sm-6 col-xs-6">
          <ul id="top_links">
            <li>
              <div class="dropdown dropdown-access">
                <a href="#" id="access_link">Sign Out</a>
              </div>
            </li>
          </ul>
        </div>
      </div>
      <!-- End row -->
    </div>
    <!-- End container-->
  </div>
  <!-- End top line-->

  <div class="container">
    <div class="row">
      <div class="col-md-3 col-sm-3 col-xs-3">
        <div id="logo">
          <a href="index.html"><img src="img/logo.png" width="160" height="34" alt="City tours" data-retina="true" class="logo_normal">
          </a>
          <a href="index.html"><img src="img/logo_sticky.png" width="160" height="34" alt="City tours" data-retina="true" class="logo_sticky">
          </a>
        </div>
      </div>
      <nav class="col-md-9 col-sm-9 col-xs-9">
        <a class="cmn-toggle-switch cmn-toggle-switch__htx open_close" href="javascript:void(0);"><span>Menu mobile</span></a>
        <div class="main-menu">
          <div id="header_menu">
            <img src="img/logo_sticky.png" width="160" height="34" alt="City tours" data-retina="true">
          </div>
          <a href="#" class="open_close" id="close_in"><i class="icon_set_1_icon-77"></i></a>
          <ul>
            <li class="submenu">
              <a href="javascript:void(0);" class="show-submenu">Home <i class="icon-down-open-mini"></i></a>
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
              <a href="javascript:void(0);" class="show-submenu">Tours <i class="icon-down-open-mini"></i></a>
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
              <a href="javascript:void(0);" class="show-submenu">Hotels <i class="icon-down-open-mini"></i></a><ul>
              <li><a href="all_hotels_list.html">All hotels list</a></li>
              <li><a href="all_hotels_grid.html">All hotels grid</a></li>
              <li><a href="all_hotels_map_listing.html">All hotels map listing</a></li>
              <li><a href="single_hotel.html">Single hotel page</a></li>
              <li><a href="single_hotel_datepicker_adv.html">Single hotel datepicker adv</a></li>
              <li><a href="single_hotel_working_booking.php">Single hotel working booking</a></li>
              <li><a href="single_hotel_contact.php">Single hotel contact working</a></li>
              <li><a href="cart_hotel.html">Cart hotel</a></li>
              <li><a href="payment_hotel.html">Booking hotel</a></li>
              <li><a href="confirmation_hotel.html">Confirmation hotel</a></li>
            </ul>
          </li>
          <li class="submenu">
            <a href="javascript:void(0);" class="show-submenu">Transfers <i class="icon-down-open-mini"></i></a>
            <ul>
              <li><a href="all_transfer_list.html">All transfers list</a></li>
              <li><a href="all_transfer_grid.html">All transfers grid</a></li>
              <li><a href="single_transfer.html">Single transfer page</a></li>
              <li><a href="cart_transfer.html">Cart transfers</a></li>
              <li><a href="payment_transfer.html">Booking transfers</a></li>
              <li><a href="confirmation_transfer.html">Confirmation transfers</a></li>
            </ul>
          </li>
          <li class="submenu">
            <a href="javascript:void(0);" class="show-submenu">Restaurants <i class="icon-down-open-mini"></i></a>
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
            <a href="javascript:void(0);" class="show-submenu-mega">Bonus<i class="icon-down-open-mini"></i></a>
            <div class="menu-wrapper">
              <div class="col-md-4">
                <h3>Header styles</h3>
                <ul>
                  <li><a href="index.html">Default transparent</a></li>
                  <li><a href="header_2.html">Plain color</a></li>
                  <li><a href="header_3.html">Plain color on scroll</a></li>
                  <li><a href="header_4.html">With socials on top</a></li>
                  <li><a href="header_5.html">With language selection</a></li>
                  <li><a href="header_6.html">With lang and conversion</a></li>
                  <li><a href="header_7.html">With full horizontal menu</a></li>
                </ul>
              </div>
              <div class="col-md-4">
                <h3>Footer styles</h3>
                <ul>
                  <li><a href="index.html">Footer default</a></li>
                  <li><a href="footer_2.html">Footer style 2</a></li>
                  <li><a href="footer_3.html">Footer style 3</a></li>
                  <li><a href="footer_4.html">Footer style 4</a></li>
                  <li><a href="footer_5.html">Footer style 5</a></li>
                  <li><a href="footer_6.html">Footer style 6</a></li>
                  <li><a href="footer_7.html">Footer style 7</a></li>
                </ul>
              </div>
              <div class="col-md-4">
                <h3>Shop</h3>
                <ul>
                  <li><a href="shop.html">Shop</a></li>
                  <li><a href="shop-single.html">Shop single</a></li>
                  <li><a href="shopping-cart.html">Shop cart</a></li>
                  <li><a href="checkout.html">Shop Checkout</a></li>
                </ul>
              </div>
            </div><!-- End menu-wrapper -->
          </li>
          <li class="megamenu submenu">
            <a href="javascript:void(0);" class="show-submenu-mega">Pages<i class="icon-down-open-mini"></i></a>
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
      <ul id="top_tools">
        <li>
          <div class="dropdown dropdown-search">
            <a href="#" class="search-overlay-menu-btn" data-toggle="dropdown"><i class="icon-search"></i></a>
          </div>
        </li>
        <li>
          <div class="dropdown dropdown-cart">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class=" icon-basket-1"></i>Cart (0) </a>
            <ul class="dropdown-menu" id="cart_items">
              <li>
                <div class="image"><img src="img/thumb_cart_1.jpg" alt="image"></div>
                <strong>
                  <a href="#">Louvre museum</a>1x $36.00 </strong>
                  <a href="#" class="action"><i class="icon-trash"></i></a>
                </li>
                <li>
                  <div class="image"><img src="img/thumb_cart_2.jpg" alt="image"></div>
                  <strong>
                    <a href="#">Versailles tour</a>2x $36.00 </strong>
                    <a href="#" class="action"><i class="icon-trash"></i></a>
                  </li>
                  <li>
                    <div class="image"><img src="img/thumb_cart_3.jpg" alt="image"></div>
                    <strong>
                      <a href="#">Versailles tour</a>1x $36.00 </strong>
                      <a href="#" class="action"><i class="icon-trash"></i></a>
                    </li>
                    <li>
                      <div>Total: <span>$120.00</span></div>
                      <a href="cart.html" class="button_drop">Go to cart</a>
                      <a href="payment.html" class="button_drop outline">Check out</a>
                    </li>
                  </ul>
                </div><!-- End dropdown-cart-->
              </li>
            </ul>
          </nav>
        </div>
      </div>
      <!-- container -->
    </header>
    <!-- End Header -->


    <section class="parallax-window" data-parallax="scroll" data-image-src="img/admin_top.jpg" data-natural-width="1400" data-natural-height="470">
      <div class="parallax-content-1">
        <div class="animated fadeInDown">
          <h1>Hello Clara!</h1>
          <p>Ridiculus sociosqu cursus neque cursus curae ante scelerisque vehicula.</p>
        </div>
      </div>
    </section>
    <!-- End section -->

    <main>
      <div id="position">
        <div class="container">
          <ul>
            <li><a href="#">Home</a>
            </li>
            <li><a href="#">Category</a>
            </li>
            <li>Page active</li>
          </ul>
        </div>
      </div>
      <!-- End Position -->

      <div class="margin_60 container">      
        <h1 class="welcom">Welcome!</h1><br>

        <div id="tabs" class="tabs">
          <nav>
            <ul>
              <li><a href="#section-1" class="icon-calendar"><span>Reservations</span></a>
              </li>
              <li><a href="#section-2" class="icon-wishlist"><span>Favorite</span></a>
              </li>
              <li><a href="#section-3" class="icon-back-in-time"><span>Browsing history</span></a>
              </li>
              <li><a href="#section-4" class="icon-hourglass"><span>Join the Past</span></a>
              </li>
              <li><a href="#section-5" class="icon-profile"><span>Profile</span></a>
              </li>
            </ul>
          </nav>
          <div class="content">

            <section id="section-1">
              <div id="tools">
                <div class="row">
                  <div class="col-md-3 col-sm-3 col-xs-6">
                    <div class="styled-select-filters">
                      <select name="sort_type" id="sort_type">
                        <option value="" selected>Sort by type</option>
                        <option value="tours">Tours</option>
                        <option value="hotels">Hotels</option>
                        <option value="transfers">Transfers</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3 col-sm-3 col-xs-6">
                    <div class="styled-select-filters">
                      <select name="sort_date" id="sort_date">
                        <option value="" selected>Sort by date</option>
                        <option value="oldest">Oldest</option>
                        <option value="recent">Recent</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <!--/tools -->

              <div class="strip_booking">
                <div class="row">
                  <div class="col-md-2 col-sm-2">
                    <div class="date">
                      <span class="month">Dec</span>
                      <span class="day"><strong>23</strong>Sat</span>
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-5">
                    <h3 class="hotel_booking">Hotel Mariott Paris<span>2 Adults / 2 Nights</span></h3>
                  </div>
                  <div class="col-md-2 col-sm-3">
                    <ul class="info_booking">
                      <li><strong>Booking id</strong> 23442</li>
                      <li><strong>Booked on</strong> Sat. 23 Dec. 2015</li>
                    </ul>
                  </div>
                  <div class="col-md-2 col-sm-2">
                    <div class="booking_buttons">
                      <a href="#0" class="btn_2">Edit</a>
                      <a href="#0" class="btn_3">Cancel</a>
                    </div>
                  </div>
                </div>
                <!-- End row -->
              </div>
              <!-- End strip booking -->

              <div class="strip_booking">
                <div class="row">
                  <div class="col-md-2 col-sm-2">
                    <div class="date">
                      <span class="month">Dec</span>
                      <span class="day"><strong>27</strong>Fri</span>
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-5">
                    <h3 class="tours_booking">Louvre Museum<span>2 Adults / 2 Childs</span></h3>
                  </div>
                  <div class="col-md-2 col-sm-3">
                    <ul class="info_booking">
                      <li><strong>Booking id</strong> 23442</li>
                      <li><strong>Booked on</strong> Sat. 20 Dec. 2015</li>
                    </ul>
                  </div>
                  <div class="col-md-2 col-sm-2">
                    <div class="booking_buttons">
                      <a href="#0" class="btn_2">Edit</a>
                      <a href="#0" class="btn_3">Cancel</a>
                    </div>
                  </div>
                </div>
                <!-- End row -->
              </div>
              <!-- End strip booking -->

              <div class="strip_booking">
                <div class="row">
                  <div class="col-md-2 col-sm-2">
                    <div class="date">
                      <span class="month">Dec</span>
                      <span class="day"><strong>28</strong>Fri</span>
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-5">
                    <h3 class="tours_booking">Tour Eiffel<span>2 Adults</span></h3>
                  </div>
                  <div class="col-md-2 col-sm-3">
                    <ul class="info_booking">
                      <li><strong>Booking id</strong> 23442</li>
                      <li><strong>Booked on</strong> Sat. 20 Dec. 2015</li>
                    </ul>
                  </div>
                  <div class="col-md-2 col-sm-2">
                    <div class="booking_buttons">
                      <a href="#0" class="btn_2">Edit</a>
                      <a href="#0" class="btn_3">Cancel</a>
                    </div>
                  </div>
                </div>
                <!-- End row -->
              </div>
              <!-- End strip booking -->

              <div class="strip_booking">
                <div class="row">
                  <div class="col-md-2 col-sm-2">
                    <div class="date">
                      <span class="month">Dec</span>
                      <span class="day"><strong>30</strong>Fri</span>
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-5">
                    <h3 class="transfers_booking">Orly Airport<span>2 Adults / 2Childs</span></h3>
                  </div>
                  <div class="col-md-2 col-sm-3">
                    <ul class="info_booking">
                      <li><strong>Booking id</strong> 23442</li>
                      <li><strong>Booked on</strong> Sat. 20 Dec. 2015</li>
                    </ul>
                  </div>
                  <div class="col-md-2 col-sm-2">
                    <div class="booking_buttons">
                      <a href="#0" class="btn_2">Edit</a>
                      <a href="#0" class="btn_3">Cancel</a>
                    </div>
                  </div>
                </div>
                <!-- End row -->
              </div>
              <!-- End strip booking -->

            </section>
            <!-- End section 1 -->

            <section id="section-2">
              <div class="row">
                <div class="col-md-4 col-sm-6">
                  <div class="hotel_container">
                    <div class="img_container">
                      <a href="single_hotel.html">
                        <img src="img/hotel_1.jpg" width="800" height="533" class="img-responsive" alt="Image">
                        <div class="ribbon top_rated">
                        </div>
                        <div class="score">
                          <span>7.5</span>Good
                        </div>
                        <div class="short_info hotel">
                          From/Per night<span class="price"><sup>$</sup>59</span>
                        </div>
                      </a>
                    </div>
                    <div class="hotel_title">
                      <h3><strong>Park Hyatt</strong> Hotel</h3>
                      <div class="rating">
                        <i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star-empty"></i>
                      </div>
                      <!-- end rating -->
                      <div class="wishlist_close_admin">
                        -
                      </div>
                    </div>
                  </div>
                  <!-- End box tour -->
                </div>
                <!-- End col-md-6 -->

                <div class="col-md-4 col-sm-6 ">
                  <div class="hotel_container">
                    <div class="img_container">
                      <a href="single_hotel.html">
                        <img src="img/hotel_2.jpg" width="800" height="533" class="img-responsive" alt="Image">
                        <div class="ribbon top_rated">
                        </div>
                        <div class="score">
                          <span>9.0</span>Superb
                        </div>
                        <div class="short_info hotel">
                          From/Per night<span class="price"><sup>$</sup>45</span>
                        </div>
                      </a>
                    </div>
                    <div class="hotel_title">
                      <h3><strong>Mariott</strong> Hotel</h3>
                      <div class="rating">
                        <i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star-empty"></i>
                      </div>
                      <!-- end rating -->
                      <div class="wishlist_close_admin">
                        -
                      </div>
                    </div>
                  </div>
                  <!-- End box -->
                </div>
                <!-- End col-md-6 -->

                <div class="col-md-4 col-sm-6">
                  <div class="tour_container">
                    <div class="img_container">
                      <a href="single_tour.html">
                        <img src="img/tour_box_1.jpg" width="800" height="533" class="img-responsive" alt="Image">
                        <div class="ribbon top_rated">
                        </div>
                        <div class="short_info">
                          <i class="icon_set_1_icon-44"></i>Historic Buildings<span class="price"><sup>$</sup>45</span>
                        </div>
                      </a>
                    </div>
                    <div class="tour_title">
                      <h3><strong>Arc Triomphe</strong> tour</h3>
                      <div class="rating">
                        <i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile"></i><small>(75)</small>
                      </div>
                      <!-- end rating -->
                      <div class="wishlist_close_admin">
                        -
                      </div>
                    </div>
                  </div>
                  <!-- End box tour -->
                </div>
                <!-- End col-md-6 -->

                <div class="col-md-4 col-sm-6">
                  <div class="tour_container">
                    <div class="img_container">
                      <a href="single_tour.html">
                        <img src="img/tour_box_3.jpg" width="800" height="533" class="img-responsive" alt="Image">
                        <div class="ribbon popular">
                        </div>
                        <div class="short_info">
                          <i class="icon_set_1_icon-44"></i>Historic Buildings<span class="price"><sup>$</sup>45</span>
                        </div>
                      </a>
                    </div>
                    <div class="tour_title">
                      <h3><strong>Versailles</strong> tour</h3>
                      <div class="rating">
                        <i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile"></i><small>(75)</small>
                      </div>
                      <!-- end rating -->
                      <div class="wishlist_close_admin">
                        -
                      </div>
                    </div>
                  </div>
                  <!-- End box tour -->
                </div>
                <!-- End col-md-6 -->

                <div class="col-md-4 col-sm-6">
                  <div class="tour_container">
                    <div class="img_container">
                      <a href="single_tour.html">
                        <img src="img/tour_box_4.jpg" width="800" height="533" class="img-responsive" alt="Image">
                        <div class="ribbon popular">
                        </div>
                        <div class="short_info">
                          <i class="icon_set_1_icon-30"></i>Walking tour<span class="price"><sup>$</sup>45</span>
                        </div>
                      </a>
                    </div>
                    <div class="tour_title">
                      <h3><strong>Pompidue</strong> tour</h3>
                      <div class="rating">
                        <i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile"></i><small>(75)</small>
                      </div>
                      <!-- end rating -->
                      <div class="wishlist_close_admin">
                        -
                      </div>
                    </div>
                  </div>
                  <!-- End box tour -->
                </div>
                <!-- End col-md-6 -->

                <div class="col-md-4 col-sm-6">
                  <div class="transfer_container">
                    <div class="img_container">
                      <a href="single_transfer.html">
                        <img src="img/transfer_1.jpg" width="800" height="533" class="img-responsive" alt="Image">
                        <div class="ribbon top_rated">
                        </div>
                        <div class="short_info">
                          From/Per person<span class="price"><sup>$</sup>45</span>
                        </div>
                      </a>
                    </div>
                    <div class="transfer_title">
                      <h3><strong>Orly Airport</strong> private</h3>
                      <div class="rating">
                        <i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile"></i><small>(75)</small>
                      </div>
                      <!-- end rating -->
                      <div class="wishlist_close_admin">
                        -
                      </div>
                    </div>
                  </div>
                  <!-- End box tour -->
                </div>
                <!-- End col-md-6 -->

              </div>
              <!-- End row -->
              <button type="submit" class="btn_1 green">Update wishlist</button>
            </section>
            <!-- End section 2 -->

            <section id="section-3">
              <div class="row">
                <div class="col-md-6 col-sm-6 add_bottom_30">
                  <h4>Change your password</h4>
                  <div class="form-group">
                    <label>Old password</label>
                    <input class="form-control" name="old_password" id="old_password" type="password">
                  </div>
                  <div class="form-group">
                    <label>New password</label>
                    <input class="form-control" name="new_password" id="new_password" type="password">
                  </div>
                  <div class="form-group">
                    <label>Confirm new password</label>
                    <input class="form-control" name="confirm_new_password" id="confirm_new_password" type="password">
                  </div>
                  <button type="submit" class="btn_1 green">Update Password</button>
                </div>
                <div class="col-md-6 col-sm-6 add_bottom_30">
                  <h4>Change your email</h4>
                  <div class="form-group">
                    <label>Old email</label>
                    <input class="form-control" name="old_password" id="old_password" type="password">
                  </div>
                  <div class="form-group">
                    <label>New email</label>
                    <input class="form-control" name="new_password" id="new_password" type="password">
                  </div>
                  <div class="form-group">
                    <label>Confirm new email</label>
                    <input class="form-control" name="confirm_new_password" id="confirm_new_password" type="password">
                  </div>
                  <button type="submit" class="btn_1 green">Update Email</button>
                </div>
              </div>
              <!-- End row -->

              <hr>
              <br>
              <div class="row">
                <div class="col-md-6 col-sm-6">
                  <h4>Notification settings</h4>
                  <table class="table table-striped options_cart">
                    <tbody>
                      <tr>
                        <td style="width:10%">
                          <i class="icon_set_1_icon-33"></i>
                        </td>
                        <td style="width:60%">
                          New Citytours Tours
                        </td>
                        <td style="width:35%">
                          <label class="switch-light switch-ios pull-right">
                            <input type="checkbox" name="option_1" id="option_1" checked value="">
                            <span>
                              <span>No</span>
                              <span>Yes</span>
                            </span>
                            <a></a>
                          </label>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <i class="icon_set_1_icon-6"></i>
                        </td>
                        <td>
                          New Citytours Hotels
                        </td>
                        <td>
                          <label class="switch-light switch-ios pull-right">
                            <input type="checkbox" name="option_2" id="option_2" value="">
                            <span>
                              <span>No</span>
                              <span>Yes</span>
                            </span>
                            <a></a>
                          </label>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <i class="icon_set_1_icon-26"></i>
                        </td>
                        <td>
                          New Citytours Transfers
                        </td>
                        <td>
                          <label class="switch-light switch-ios pull-right">
                            <input type="checkbox" name="option_3" id="option_3" value="" checked>
                            <span>
                              <span>No</span>
                              <span>Yes</span>
                            </span>
                            <a></a>
                          </label>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <i class="icon_set_1_icon-81"></i>
                        </td>
                        <td>
                          New Citytours special offers
                        </td>
                        <td>
                          <label class="switch-light switch-ios pull-right">
                            <input type="checkbox" name="option_4" id="option_4" value="">
                            <span>
                              <span>No</span>
                              <span>Yes</span>
                            </span>
                            <a></a>
                          </label>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <button type="submit" class="btn_1 green">Update notifications settings</button>
                </div>
              </div>
              <!-- End row -->
            </section>
            <!-- End section 3 -->

            <section id="section-4">
              <div class="row">
                <div class="col-md-4 col-sm-6">
                  <div class="hotel_container">
                    <div class="img_container">
                      <a href="single_hotel.html">
                        <img src="img/hotel_1.jpg" width="800" height="533" class="img-responsive" alt="Image">
                        <div class="ribbon top_rated">
                        </div>
                        <div class="score">
                          <span>7.5</span>Good
                        </div>
                        <div class="short_info hotel">
                          From/Per night<span class="price"><sup>$</sup>59</span>
                        </div>
                      </a>
                    </div>
                    <div class="hotel_title">
                      <h3><strong>Park Hyatt</strong> Hotel</h3>
                      <div class="rating">
                        <i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star-empty"></i>
                      </div>
                      <!-- end rating -->
                      <div class="wishlist_close_admin">
                        -
                      </div>
                    </div>
                  </div>
                  <!-- End box tour -->
                </div>
                <!-- End col-md-6 -->

              </div>
              <!-- End row -->
              <div class="col-md-12 col-sm-12">
                <textarea class="form-control"></textarea><br> 
                <button type="submit" class="btn_1 green">Review</button>  
              </div>

            </section>
            <!-- End section 4 -->

            <section id="section-5">
              <div class="row">
                <div class="col-md-7 col-sm-7" name="a1">
                  <h4>Your profile</h4>
                  <ul id="profile_summary">
                    <li>Username <span><?php echo htmlspecialchars($nickname); ?></span>
                    </li>
                    <li>Email <span><?php echo htmlspecialchars($email);?></span>
                    </li>
                    <li>Country <span><?php echo htmlspecialchars($nationality);?></span>
                    </li>
                    <li>Gender <span><?php echo htmlspecialchars($gender);?></span>
                    </li>
                    <li>Level of Japanese<span><?php echo htmlspecialchars($level);?></span>
                    </li>
                    <li>Comment<span><?php echo htmlspecialchars($self_intro);?></span>
                    </li>
                  </ul>
                  <!-- Editボタンが押されたらパスワード確認が開く -->
<!-- <div onclick="obj=document.getElementById('open').style;　obj.display=(obj.display=='none')?'block':'none';">
<a href="#a1" style="cursor:pointer;" ><button type="submit" class="btn_1 green" id="js-upload-submit">Edit</button></a>                  
</div> -->

<!-- 展開の中身 -->
<!--  <div id="open" style="display:none;clear:both;">
現在のパスワードを入力してください<br>
<form method="POST" action="admin_user.php#a1">
<input type="password" class="form-control" name="current_password" id="password">
<?php if(isset($errors['current_password']) && $errors['current_password'] == 'failed') { ?>
<p class="alert-danger">本人確認に失敗しました。再度パスワードを入力してください</p>
<?php } ?>
<div onclick="obj=document.getElementById('open').style; obj.display=(obj.display=='none')?'block':'none';">
<a href="#a1" style="cursor:pointer;"><input type="submit" class="btn_1 green" value="確認する"></a>
<div id="open" style="display:none;clear:both;">
hoge
</div>
</div>
</form>          
</div> -->
<!-- End 展開の中身 -->
</div>
<div class="col-md-5 col-sm-5">
  <img src="img/tourist_guide_pic.jpg" alt="Image" class="img-responsive styled profile_pic">
</div>
</div>
<!-- End row -->

<div class="divider"></div>
<div class="row">
  <div class="col-md-12">
    <h4 id="edit_profile">Edit profile</h4>
  </div>
  <div class="col-md-12 col-sm-12">
    <table class="table table-bordered">
      <thead>
        <tbody>
          <form method="POST" action="" enctype="multipart/form-data">
            <tr>
              <th>Username</th>
              <td>
                <input class="form-control" name="nickname" id="nickname" type="text" value="<?php echo htmlspecialchars($nickname);?>">
                <?php if(isset($errors['nickname']) && $errors['nickname'] == 'blank') { ?>
                <p class="alert-danger">ユーザー名を入力してください</p>
                <?php } ?>
              </td>
            </tr>
            <tr>
              <th>Email</th>
              <td>
                <input class="form-control" name="email" id="email" type="text" value="<?php echo htmlspecialchars($email); ?>">
                <?php if(isset($errors['email']) && $errors['email'] == 'blank') { ?>
                <p class="alert-danger">メールアドレスを入力してください</p>
                <?php } ?>
                <?php if(isset($errors['email']) && $errors['email'] == 'duplicate') { ?>
                <p class="error">そのメールアドレスは既に登録されています</p>
                <?php } ?>
              </td>
            </tr>
            <tr>
              <th>Now Password</th>
              <td>
                <input type="password" class="form-control" name="current_password" id="current_password" >
                <?php if(isset($errors['current_password']) && $errors['current_password'] == 'failed') { ?>
                <p class="alert-danger">本人確認に失敗しました。再度パスワードを入力してください</p>
                <?php } ?>
              </td>
            </tr>
            <tr>
              <th>New Password</th>
              <td>
                <input class="form-control" name="new_password" id="new_password" type="password">
                <?php if(isset($errors['new_password']) && $errors['new_password'] == 'length') { ?>
                <p class="alert-danger">パスワードは6文字以上で入力してください</p>
                <?php } ?>
              </td>
            </tr>
            <tr>
              <th>Confirm password</th>
              <td>
                <input class="form-control" name="confirm_password" id="confirm_password" type="password">
                <?php if(isset($errors['confirm_password']) && $errors['confirm_password'] == 'wrong') { ?>
                <p class="alert-danger">パスワードが一致しません</p>
                <?php } ?>
              </td>
            </tr>
            <tr>
              <th>Country</th>
              <td>
                <select class="form-control" name="nationality" id="nationality" selected="<?php echo htmlspecialchars($nationality); ?>">
                  <option value="nationality">Nationality</option>
                  <option value="Afganistan">Afghanistan</option>
                  <option value="Albania">Albania</option>
                  <option value="Algeria">Algeria</option>
                  <option value="American Samoa">American Samoa</option>
                  <option value="Andorra">Andorra</option>
                  <option value="Angola">Angola</option>
                  <option value="Anguilla">Anguilla</option>
                  <option value="Antigua &amp; Barbuda">Antigua &amp; Barbuda</option>  
                  <option value="Argentina">Argentina</option>
                  <option value="Armenia">Armenia</option>
                  <option value="Aruba">Aruba</option>
                  <option value="Australia">Australia</option>
                  <option value="Austria">Austria</option>
                  <option value="Azerbaijan">Azerbaijan</option>
                  <option value="Bahamas">Bahamas</option>
                  <option value="Bahrain">Bahrain</option>
                  <option value="Bangladesh">Bangladesh</option>
                  <option value="Barbados">Barbados</option>
                  <option value="Belarus">Belarus</option>
                  <option value="Belgium">Belgium</option>
                  <option value="Belize">Belize</option>
                  <option value="Benin">Benin</option>
                  <option value="Bermuda">Bermuda</option>
                  <option value="Bhutan">Bhutan</option>
                  <option value="Bolivia">Bolivia</option>
                  <option value="Bonaire">Bonaire</option>
                  <option value="Bosnia &amp; Herzegovina">Bosnia &amp; Herzegovina</option>
                  <option value="Botswana">Botswana</option>
                  <option value="Brazil">Brazil</option>
                  <option value="British Indian Ocean Ter">British Indian Ocean Ter</option>
                  <option value="Brunei">Brunei</option>
                  <option value="Bulgaria">Bulgaria</option>
                  <option value="Burkina Faso">Burkina Faso</option>
                  <option value="Burundi">Burundi</option>
                  <option value="Cambodia">Cambodia</option>
                  <option value="Cameroon">Cameroon</option>
                  <option value="Canada">Canada</option>
                  <option value="Canary Islands">Canary Islands</option>
                  <option value="Cape Verde">Cape Verde</option>
                  <option value="Cayman Islands">Cayman Islands</option>
                  <option value="Central African Republic">Central African Republic</option>
                  <option value="Chad">Chad</option>
                  <option value="Channel Islands">Channel Islands</option>
                  <option value="Chile">Chile</option>
                  <option value="China">China</option>
                  <option value="Christmas Island">Christmas Island</option>
                  <option value="Cocos Island">Cocos Island</option>
                  <option value="Colombia">Colombia</option>
                  <option value="Comoros">Comoros</option>
                  <option value="Congo">Congo</option>
                  <option value="Cook Islands">Cook Islands</option>
                  <option value="Costa Rica">Costa Rica</option>
                  <option value="Cote DIvoire">Cote D'Ivoire</option>
                  <option value="Croatia">Croatia</option>
                  <option value="Cuba">Cuba</option>
                  <option value="Curaco">Curacao</option>
                  <option value="Cyprus">Cyprus</option>
                  <option value="Czech Republic">Czech Republic</option>
                  <option value="Denmark">Denmark</option>
                  <option value="Djibouti">Djibouti</option>
                  <option value="Dominica">Dominica</option>
                  <option value="Dominican Republic">Dominican Republic</option>
                  <option value="East Timor">East Timor</option>
                  <option value="Ecuador">Ecuador</option>
                  <option value="Egypt">Egypt</option>
                  <option value="El Salvador">El Salvador</option>
                  <option value="Equatorial Guinea">Equatorial Guinea</option>
                  <option value="Eritrea">Eritrea</option>
                  <option value="Estonia">Estonia</option>
                  <option value="Ethiopia">Ethiopia</option>
                  <option value="Falkland Islands">Falkland Islands</option>
                  <option value="Faroe Islands">Faroe Islands</option>
                  <option value="Fiji">Fiji</option>
                  <option value="Finland">Finland</option>
                  <option value="France">France</option>
                  <option value="French Guiana">French Guiana</option>
                  <option value="French Polynesia">French Polynesia</option>
                  <option value="French Southern Ter">French Southern Ter</option>
                  <option value="Gabon">Gabon</option>
                  <option value="Gambia">Gambia</option>
                  <option value="Georgia">Georgia</option>
                  <option value="Germany">Germany</option>
                  <option value="Ghana">Ghana</option>
                  <option value="Gibraltar">Gibraltar</option>
                  <option value="Great Britain">Great Britain</option>
                  <option value="Greece">Greece</option>
                  <option value="Greenland">Greenland</option>
                  <option value="Grenada">Grenada</option>
                  <option value="Guadeloupe">Guadeloupe</option>
                  <option value="Guam">Guam</option>
                  <option value="Guatemala">Guatemala</option>
                  <option value="Guinea">Guinea</option>
                  <option value="Guyana">Guyana</option>
                  <option value="Haiti">Haiti</option>
                  <option value="Hawaii">Hawaii</option>
                  <option value="Honduras">Honduras</option>
                  <option value="Hong Kong">Hong Kong</option>
                  <option value="Hungary">Hungary</option>
                  <option value="Iceland">Iceland</option>
                  <option value="India">India</option>
                  <option value="Indonesia">Indonesia</option>
                  <option value="Iran">Iran</option>
                  <option value="Iraq">Iraq</option>
                  <option value="Ireland">Ireland</option>
                  <option value="Isle of Man">Isle of Man</option>
                  <option value="Israel">Israel</option>
                  <option value="Italy">Italy</option>
                  <option value="Jamaica">Jamaica</option>
                  <option value="Japan">Japan</option>
                  <option value="Jordan">Jordan</option>
                  <option value="Kazakhstan">Kazakhstan</option>
                  <option value="Kenya">Kenya</option>
                  <option value="Kiribati">Kiribati</option>
                  <option value="Korea North">Korea North</option>
                  <option value="Korea Sout">Korea South</option>
                  <option value="Kuwait">Kuwait</option>
                  <option value="Kyrgyzstan">Kyrgyzstan</option>
                  <option value="Laos">Laos</option>
                  <option value="Latvia">Latvia</option>
                  <option value="Lebanon">Lebanon</option>
                  <option value="Lesotho">Lesotho</option>
                  <option value="Liberia">Liberia</option>
                  <option value="Libya">Libya</option>
                  <option value="Liechtenstein">Liechtenstein</option>
                  <option value="Lithuania">Lithuania</option>
                  <option value="Luxembourg">Luxembourg</option>
                  <option value="Macau">Macau</option>
                  <option value="Macedonia">Macedonia</option>
                  <option value="Madagascar">Madagascar</option>
                  <option value="Malaysia">Malaysia</option>
                  <option value="Malawi">Malawi</option>
                  <option value="Maldives">Maldives</option>
                  <option value="Mali">Mali</option>
                  <option value="Malta">Malta</option>
                  <option value="Marshall Islands">Marshall Islands</option>
                  <option value="Martinique">Martinique</option>
                  <option value="Mauritania">Mauritania</option>
                  <option value="Mauritius">Mauritius</option>
                  <option value="Mayotte">Mayotte</option>
                  <option value="Mexico">Mexico</option>
                  <option value="Midway Islands">Midway Islands</option>
                  <option value="Moldova">Moldova</option>
                  <option value="Monaco">Monaco</option>
                  <option value="Mongolia">Mongolia</option>
                  <option value="Montserrat">Montserrat</option>
                  <option value="Morocco">Morocco</option>
                  <option value="Mozambique">Mozambique</option>
                  <option value="Myanmar">Myanmar</option>
                  <option value="Nambia">Nambia</option>
                  <option value="Nauru">Nauru</option>
                  <option value="Nepal">Nepal</option>
                  <option value="Netherland Antilles">Netherland Antilles</option>
                  <option value="Netherlands">Netherlands (Holland, Europe)</option>
                  <option value="Nevis">Nevis</option>
                  <option value="New Caledonia">New Caledonia</option>
                  <option value="New Zealand">New Zealand</option>
                  <option value="Nicaragua">Nicaragua</option>
                  <option value="Niger">Niger</option>
                  <option value="Nigeria">Nigeria</option>
                  <option value="Niue">Niue</option>
                  <option value="Norfolk Island">Norfolk Island</option>
                  <option value="Norway">Norway</option>
                  <option value="Oman">Oman</option>
                  <option value="Pakistan">Pakistan</option>
                  <option value="Palau Island">Palau Island</option>
                  <option value="Palestine">Palestine</option>
                  <option value="Panama">Panama</option>
                  <option value="Papua New Guinea">Papua New Guinea</option>
                  <option value="Paraguay">Paraguay</option>
                  <option value="Peru">Peru</option>
                  <option value="Phillipines">Philippines</option>
                  <option value="Pitcairn Island">Pitcairn Island</option>
                  <option value="Poland">Poland</option>
                  <option value="Portugal">Portugal</option>
                  <option value="Puerto Rico">Puerto Rico</option>
                  <option value="Qatar">Qatar</option>
                  <option value="Republic of Montenegro">Republic of Montenegro</option>
                  <option value="Republic of Serbia">Republic of Serbia</option>
                  <option value="Reunion">Reunion</option>
                  <option value="Romania">Romania</option>
                  <option value="Russia">Russia</option>
                  <option value="Rwanda">Rwanda</option>
                  <option value="St Barthelemy">St Barthelemy</option>
                  <option value="St Eustatius">St Eustatius</option>
                  <option value="St Helena">St Helena</option>
                  <option value="St Kitts-Nevis">St Kitts-Nevis</option>
                  <option value="St Lucia">St Lucia</option>
                  <option value="St Maarten">St Maarten</option>
                  <option value="St Pierre &amp; Miquelon">St Pierre &amp; Miquelon</option>
                  <option value="St Vincent &amp; Grenadines">St Vincent &amp; Grenadines</option>
                  <option value="Saipan">Saipan</option>
                  <option value="Samoa">Samoa</option>
                  <option value="Samoa American">Samoa American</option>
                  <option value="San Marino">San Marino</option>
                  <option value="Sao Tome &amp; Principe">Sao Tome &amp; Principe</option>
                  <option value="Saudi Arabia">Saudi Arabia</option>
                  <option value="Senegal">Senegal</option>
                  <option value="Serbia">Serbia</option>
                  <option value="Seychelles">Seychelles</option>
                  <option value="Sierra Leone">Sierra Leone</option>
                  <option value="Singapore">Singapore</option>
                  <option value="Slovakia">Slovakia</option>
                  <option value="Slovenia">Slovenia</option>
                  <option value="Solomon Islands">Solomon Islands</option>
                  <option value="Somalia">Somalia</option>
                  <option value="South Africa">South Africa</option>
                  <option value="Spain">Spain</option>
                  <option value="Sri Lanka">Sri Lanka</option>
                  <option value="Sudan">Sudan</option>
                  <option value="Suriname">Suriname</option>
                  <option value="Swaziland">Swaziland</option>
                  <option value="Sweden">Sweden</option>
                  <option value="Switzerland">Switzerland</option>
                  <option value="Syria">Syria</option>
                  <option value="Tahiti">Tahiti</option>
                  <option value="Taiwan">Taiwan</option>
                  <option value="Tajikistan">Tajikistan</option>
                  <option value="Tanzania">Tanzania</option>
                  <option value="Thailand">Thailand</option>
                  <option value="Togo">Togo</option>
                  <option value="Tokelau">Tokelau</option>
                  <option value="Tonga">Tonga</option>
                  <option value="Trinidad &amp; Tobago">Trinidad &amp; Tobago</option>
                  <option value="Tunisia">Tunisia</option>
                  <option value="Turkey">Turkey</option>
                  <option value="Turkmenistan">Turkmenistan</option>
                  <option value="Turks &amp; Caicos Is">Turks &amp; Caicos Is</option>
                  <option value="Tuvalu">Tuvalu</option>
                  <option value="Uganda">Uganda</option>
                  <option value="Ukraine">Ukraine</option>
                  <option value="United Arab Erimates">United Arab Emirates</option>
                  <option value="United Kingdom">United Kingdom</option>
                  <option value="United States of America">United States of America</option>
                  <option value="Uraguay">Uruguay</option>
                  <option value="Uzbekistan">Uzbekistan</option>
                  <option value="Vanuatu">Vanuatu</option>
                  <option value="Vatican City State">Vatican City State</option>
                  <option value="Venezuela">Venezuela</option>
                  <option value="Vietnam">Vietnam</option>
                  <option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
                  <option value="Virgin Islands (USA)">Virgin Islands (USA)</option>
                  <option value="Wake Island">Wake Island</option>
                  <option value="Wallis &amp; Futana Is">Wallis &amp; Futana Is</option>
                  <option value="Yemen">Yemen</option>
                  <option value="Zaire">Zaire</option>
                  <option value="Zambia">Zambia</option>
                  <option value="Zimbabwe">Zimbabwe</option>
                </select>
              </td>
            </tr>
            <tr>
              <th>Gender</th>
              <td>
                <select class="form-control" name="gender" id="gender" selected="<?php echo htmlspecialchars($gender);?>">
                  <option value="male" selected>male</option>
                  <option value="female" selected>female</option>
                  <option value="other" selected>other</option>
                </select>
              </td>
            </tr>
            <tr>
              <th>Level of JApanese</th>
              <td>
                <select class="form-control" name="level" id="level" selected="<?php echo htmlspecialchars($level);?>">
                  <option value="male" selected>male</option>
                  <option value="female" selected>female</option>
                  <option value="other" selected>other</option>
                </select>
              </td>
            </tr>
            <tr>
              <th>Comment</th>
              <td>
                <textarea class="form-control" value="<?php echo htmlspecialchars($self_intro);?>"></textarea>
                <?php if(isset($errors['o_intro']) && $errors['o_intro'] == 'wrong') { ?>
                <p class="alert-danger"></p>
                <?php } ?>
              </td>
            </tr>
            <!-- </form> -->
          </tbody>
        </thead>
      </table>
    </div> 
  </div>
  <!-- End row -->      

  <h4>Upload profile photo</h4>
  <div class="form-inline upload_1">
    <div class="form-group">
      <input type="file" name="pic_path" id="js-upload-files" enctype="multiple/form-data">
      <?php if(isset($errors['pic_path']) && $errors['pic_path'] == 'type') { ?>
      <p class="alert-danger">画像は「jpg」「png」「gif」の画像を選択してください</p>
      <?php } ?>
    </div>
  </div> 

  <hr>
  <a href="#a1"><button type="submit" class="btn_1 green">Update Profile</button></a>
</section>
<!-- End section 5 -->

</div>
<!-- End content -->
</div>
<!-- End tabs -->
</div>
<!-- end container -->
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
            <option value="French">French</option>
            <option value="Spanish">Spanish</option>
            <option value="Russian">Russian</option>
          </select>
        </div>
        <div class="styled-select">
          <select class="form-control" name="currency" id="currency">
            <option value="USD" selected>USD</option>
            <option value="EUR">EUR</option>
            <option value="GBP">GBP</option>
            <option value="RUB">RUB</option>
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
          <p>© Citytours 2015</p>
        </div>
      </div>
    </div><!-- End row -->
  </div><!-- End container -->
</footer><!-- End footer -->

<div id="toTop"></div><!-- Back to top button -->

<!-- Search Menu -->
<div class="search-overlay-menu">
  <span class="search-overlay-close"><i class="icon_set_1_icon-77"></i></span>
  <form role="search" id="searchform" method="POST">
    <input value="" name="q" type="search" placeholder="Search..." />
    <button type="submit"><i class="icon_set_1_icon-78"></i>
    </button>
  </form>
</div><!-- End Search Menu -->

<!-- Common scripts -->
<script src="js/jquery-2.2.4.min.js"></script>
<script src="js/common_scripts_min.js"></script>
<script src="js/functions.js"></script>

<!-- Specific scripts -->
<script src="js/tabs.js"></script>
<script>
  new CBPFWTabs(document.getElementById('tabs'));
</script>
<script>
  $('.wishlist_close_admin').on('click', function (c) {
    $(this).parent().parent().parent().fadeOut('slow', function (c) {});
  });
</script>

<!-- 郵便番号 -->
<script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>

</body>

</html>