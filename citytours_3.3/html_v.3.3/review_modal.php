<?php
session_start();
require('../../common/dbconnect.php');
require('../../common/functions.php');
// require('../../common/auth.php');

$login_user = get_login_user($dbh);

  $rating = '';
  $comment = '';
  $review_pic_path = '';

if (!isset($_POST)) {
  $rating = $_POST['rating'];
  $comment = $_POST['commnet'];
  $review_pic_path = $_POST['review_pic_path'];
}

$r_sql = 'SELECT * FROM reviews r LEFT JOIN users u ON r.user_id=u.user_id WHERE r.event_id=?';
$data = [$_GET['event_id']];
$r_stmt = $dbh->prepare($r_sql);
$r_stmt->execute($data);

$reviews = array();

while ($r_record = $r_stmt->fetch(PDO::FETCH_ASSOC)) {
  $reviews[] = $r_record;
}

$r_count = count($reviews);

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
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="access_link">Sign in</a>
                  <div class="dropdown-menu">
                    <div class="row">
                      <div class="col-md-6 col-sm-6 col-xs-6">
                        <a href="#" class="bt_facebook">
                          <i class="icon-facebook"></i>Facebook </a>
                      </div>
                      <div class="col-md-6 col-sm-6 col-xs-6">
                        <a href="#" class="bt_paypal">
                          <i class="icon-paypal"></i>Paypal </a>
                      </div>
                    </div>
                    <div class="login-or">
                      <hr class="hr-or">
                      <span class="span-or">or</span>
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control" id="inputUsernameEmail" placeholder="Email">
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control" id="inputPassword" placeholder="Password">
                    </div>
                    <a id="forgot_pw" href="#">Forgot password?</a>
                    <input type="submit" name="Sign_in" value="Sign in" id="Sign_in" class="button_drop">
                    <input type="submit" name="Sign_up" value="Sign up" id="Sign_up" class="button_drop outline">
                  </div>
                </div>
                <!-- End Dropdown access -->
              </li>
              <li><a href="wishlist.html" id="wishlist_link">Wishlist</a>
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

  <section class="parallax-window" data-parallax="scroll" data-image-src="img/single_tour_bg_1.jpg" data-natural-width="1400" data-natural-height="470">
    <div class="parallax-content-2">
      <div class="container">
        <div class="row">
          <div class="col-md-8 col-sm-8">
            <h1>Arc de Triomphe</h1>
            <span>Champ de Mars, 5 Avenue Anatole, 75007 Paris.</span>
            <span class="rating"><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile"></i><small>(75)</small></span>
          </div>
          <div class="col-md-4 col-sm-4">
            <div id="price_single_main">
              from/per person <span><sup>$</sup>52</span>
            </div>
          </div>
        </div>
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


    <div class="collapse" id="collapseMap">
      <div id="map" class="map"></div>
    </div>
    <!-- End Map -->

    <div class="container margin_60">
      <div class="row">
        <div class="col-md-8" id="single_tour_desc">
          <!-- <div id="single_tour_feat">
            <ul>
              <li><i class="icon_set_1_icon-4"></i>Museum</li>
              <li><i class="icon_set_1_icon-83"></i>3 Hours</li>
              <li><i class="icon_set_1_icon-13"></i>Accessibiliy</li>
              <li><i class="icon_set_1_icon-82"></i>144 Likes</li>
              <li><i class="icon_set_1_icon-22"></i>Pet allowed</li>
              <li><i class="icon_set_1_icon-97"></i>Audio guide</li>
              <li><i class="icon_set_1_icon-29"></i>Tour guide</li>
            </ul>
          </div> -->

          <!-- <p class="visible-sm visible-xs"><a class="btn_map" data-toggle="collapse" href="#collapseMap" aria-expanded="false" aria-controls="collapseMap" data-text-swap="Hide map" data-text-original="View on map">View on map</a>
          </p> -->
          <!-- Map button for tablets/mobiles -->

          <div id="Img_carousel" class="slider-pro">
            <div class="sp-slides">

              <div class="sp-slide">
                <img alt="Image" class="sp-image" src="css/images/blank.gif" data-src="img/slider_single_tour/1_medium.jpg" data-small="img/slider_single_tour/1_small.jpg" data-medium="img/slider_single_tour/1_medium.jpg" data-large="img/slider_single_tour/1_large.jpg" data-retina="img/slider_single_tour/1_large.jpg">
              </div>
              <div class="sp-slide">
                <img alt="Image" class="sp-image" src="css/images/blank.gif" data-src="img/slider_single_tour/2_medium.jpg" data-small="img/slider_single_tour/2_small.jpg" data-medium="img/slider_single_tour/2_medium.jpg" data-large="img/slider_single_tour/2_large.jpg" data-retina="img/slider_single_tour/2_large.jpg">
                <h3 class="sp-layer sp-black sp-padding" data-horizontal="40" data-vertical="40" data-show-transition="left">
                        Lorem ipsum dolor sit amet </h3>
                <p class="sp-layer sp-white sp-padding" data-horizontal="40" data-vertical="100" data-show-transition="left" data-show-delay="200">
                  consectetur adipisicing elit
                </p>
                <p class="sp-layer sp-black sp-padding" data-horizontal="40" data-vertical="160" data-width="350" data-show-transition="left" data-show-delay="400">
                  sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                </p>
              </div>

              <div class="sp-slide">
                <img alt="Image" class="sp-image" src="css/images/blank.gif" data-src="img/slider_single_tour/3_medium.jpg" data-small="img/slider_single_tour/3_small.jpg" data-medium="img/slider_single_tour/3_medium.jpg" data-large="img/slider_single_tour/3_large.jpg" data-retina="img/slider_single_tour/3_large.jpg">
                <p class="sp-layer sp-white sp-padding" data-position="centerCenter" data-vertical="-50" data-show-transition="right" data-show-delay="500">
                  Lorem ipsum dolor sit amet
                </p>
                <p class="sp-layer sp-black sp-padding" data-position="centerCenter" data-vertical="50" data-show-transition="left" data-show-delay="700">
                  consectetur adipisicing elit
                </p>
              </div>

              <div class="sp-slide">
                <img alt="Image" class="sp-image" src="css/images/blank.gif" data-src="img/slider_single_tour/4_medium.jpg" data-small="img/slider_single_tour/4_small.jpg" data-medium="img/slider_single_tour/4_medium.jpg" data-large="img/slider_single_tour/4_large.jpg" data-retina="img/slider_single_tour/4_large.jpg">
                <p class="sp-layer sp-black sp-padding" data-position="bottomLeft" data-vertical="0" data-width="100%" data-show-transition="up">
                  Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                </p>
              </div>

              <div class="sp-slide">
                <img alt="Image" class="sp-image" src="css/images/blank.gif" data-src="img/slider_single_tour/5_medium.jpg" data-small="img/slider_single_tour/5_small.jpg" data-medium="img/slider_single_tour/5_medium.jpg" data-large="img/slider_single_tour/5_large.jpg" data-retina="img/slider_single_tour/5_large.jpg">
                <p class="sp-layer sp-white sp-padding" data-vertical="5%" data-horizontal="5%" data-width="90%" data-show-transition="down" data-show-delay="400">
                  Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                </p>
              </div>

              <div class="sp-slide">
                <img alt="Image" class="sp-image" src="css/images/blank.gif" data-src="img/slider_single_tour/6_medium.jpg" data-small="img/slider_single_tour/6_small.jpg" data-medium="img/slider_single_tour/6_medium.jpg" data-large="img/slider_single_tour/6_large.jpg" data-retina="img/slider_single_tour/6_large.jpg">
                <p class="sp-layer sp-white sp-padding" data-horizontal="10" data-vertical="10" data-width="300">
                  Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                </p>
              </div>

              <div class="sp-slide">
                <img alt="Image" class="sp-image" src="css/images/blank.gif" data-src="img/slider_single_tour/7_medium.jpg" data-small="img/slider_single_tour/7_small.jpg" data-medium="img/slider_single_tour/7_medium.jpg" data-large="img/slider_single_tour/7_large.jpg" data-retina="img/slider_single_tour/7_large.jpg">
                <p class="sp-layer sp-black sp-padding" data-position="bottomLeft" data-horizontal="5%" data-vertical="5%" data-width="90%" data-show-transition="up" data-show-delay="400">
                  Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                </p>
              </div>

              <div class="sp-slide">
                <img alt="Image" class="sp-image" src="css/images/blank.gif" data-src="img/slider_single_tour/8_medium.jpg" data-small="img/slider_single_tour/8_small.jpg" data-medium="img/slider_single_tour/8_medium.jpg" data-large="img/slider_single_tour/8_large.jpg" data-retina="img/slider_single_tour/8_large.jpg">
                <p class="sp-layer sp-black sp-padding" data-horizontal="50" data-vertical="50" data-show-transition="down" data-show-delay="500">
                  Lorem ipsum dolor sit amet
                </p>
                <p class="sp-layer sp-white sp-padding" data-horizontal="50" data-vertical="100" data-show-transition="up" data-show-delay="500">
                  consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                </p>
              </div>

              <div class="sp-slide">
                <img alt="Image" class="sp-image" src="css/images/blank.gif" data-src="img/slider_single_tour/9_medium.jpg" data-small="img/slider_single_tour/9_small.jpg" data-medium="img/slider_single_tour/9_medium.jpg" data-large="img/slider_single_tour/9_large.jpg" data-retina="img/slider_single_tour/9_large.jpg">
              </div>
            </div>
            <div class="sp-thumbnails">
              <img alt="Image" class="sp-thumbnail" src="img/slider_single_tour/1_medium.jpg">
              <img alt="Image" class="sp-thumbnail" src="img/slider_single_tour/2_medium.jpg">
              <img alt="Image" class="sp-thumbnail" src="img/slider_single_tour/3_medium.jpg">
              <img alt="Image" class="sp-thumbnail" src="img/slider_single_tour/4_medium.jpg">
              <img alt="Image" class="sp-thumbnail" src="img/slider_single_tour/5_medium.jpg">
              <img alt="Image" class="sp-thumbnail" src="img/slider_single_tour/6_medium.jpg">
              <img alt="Image" class="sp-thumbnail" src="img/slider_single_tour/7_medium.jpg">
              <img alt="Image" class="sp-thumbnail" src="img/slider_single_tour/8_medium.jpg">
              <img alt="Image" class="sp-thumbnail" src="img/slider_single_tour/9_medium.jpg">
            </div>
          </div>

          <hr>

          <div class="row">
            <div class="col-md-3">
              <h3>Description</h3>
            </div>
            <div class="col-md-9">
              <h4>Paris in love</h4>
              <p>
                Lorem ipsum dolor sit amet, at omnes deseruisse pri. Quo aeterno legimus insolens ad. Sit cu detraxit constituam, an mel iudico constituto efficiendi. Eu ponderum mediocrem has, vitae adolescens in pro. Mea liber ridens inermis ei, mei legendos vulputate an, labitur tibique te qui.
              </p>
              <h4>What's include</h4>
              <p>
                Lorem ipsum dolor sit amet, at omnes deseruisse pri. Quo aeterno legimus insolens ad. Sit cu detraxit constituam, an mel iudico constituto efficiendi.
              </p>
              <div class="row">
                <div class="col-md-6 col-sm-6">
                  <ul class="list_ok">
                    <li>Lorem ipsum dolor sit amet</li>
                    <li>No scripta electram necessitatibus sit</li>
                    <li>Quidam percipitur instructior an eum</li>
                    <li>Ut est saepe munere ceteros</li>
                    <li>No scripta electram necessitatibus sit</li>
                    <li>Quidam percipitur instructior an eum</li>
                  </ul>
                </div>
                <div class="col-md-6 col-sm-6">
                  <ul class="list_ok">
                    <li>Lorem ipsum dolor sit amet</li>
                    <li>No scripta electram necessitatibus sit</li>
                    <li>Quidam percipitur instructior an eum</li>
                    <li>No scripta electram necessitatibus sit</li>
                  </ul>
                </div>
              </div>
              <!-- End row  -->
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-md-3">
              <h3>Schedule</h3>
            </div>
            <div class="col-md-9">

              <div class=" table-responsive">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th colspan="2">
                        1st March to 31st October
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>
                        Monday
                      </td>
                      <td>
                        10.00 - 17.30
                      </td>
                    </tr>
                    <tr>
                      <td>
                        Tuesday
                      </td>
                      <td>
                        09.00 - 17.30
                      </td>
                    </tr>
                    <tr>
                      <td>
                        Wednesday
                      </td>
                      <td>
                        09.00 - 17.30
                      </td>
                    </tr>
                    <tr>
                      <td>
                        Thursday
                      </td>
                      <td>
                        <span class="label label-danger">Closed</span>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        Friday
                      </td>
                      <td>
                        09.00 - 17.30
                      </td>
                    </tr>
                    <tr>
                      <td>
                        Saturday
                      </td>
                      <td>
                        09.00 - 17.30
                      </td>
                    </tr>
                    <tr>
                      <td>
                        Sunday
                      </td>
                      <td>
                        10.00 - 17.30
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <strong><em>Last Admission</em></strong>
                      </td>
                      <td>
                        <strong>17.00</strong>
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
                        1st November to 28th February
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>
                        Monday
                      </td>
                      <td>
                        10.00 - 17.30
                      </td>
                    </tr>
                    <tr>
                      <td>
                        Tuesday
                      </td>
                      <td>
                        09.00 - 17.30
                      </td>
                    </tr>
                    <tr>
                      <td>
                        Wednesday
                      </td>
                      <td>
                        09.00 - 17.30
                      </td>
                    </tr>
                    <tr>
                      <td>
                        Thursday
                      </td>
                      <td>
                        <span class="label label-danger">Closed</span>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        Friday
                      </td>
                      <td>
                        09.00 - 17.30
                      </td>
                    </tr>
                    <tr>
                      <td>
                        Saturday
                      </td>
                      <td>
                        09.00 - 17.30
                      </td>
                    </tr>
                    <tr>
                      <td>
                        Sunday
                      </td>
                      <td>
                        10.00 - 17.30
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <strong><em>Last Admission</em></strong>
                      </td>
                      <td>
                        <strong>17.00</strong>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <hr>
          <!-- 0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000 -->
          <div class="row">
            <div class="col-md-3">
              <h3>Reviews </h3>
              <!-- <a href="#" class="btn_1 add_bottom_30" data-toggle="modal" data-target="#myReview">Leave a review</a> -->
            </div>
            <div class="col-md-9">
              <div id="general_rating"><?php echo htmlspecialchars($r_count); ?> Reviews</div>
              <!-- End general_rating -->
              <!--<div class="row" id="rating_summary">
                 <div class="col-md-6">
                  <ul>
                    <li>Position
                      <div class="rating">
                        <i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile"></i><i class="icon-smile"></i>
                      </div>
                    </li>
                    <li>Tourist guide
                      <div class="rating">
                        <i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile"></i>
                      </div>
                    </li>
                  </ul>
                </div>
                <div class="col-md-6">
                  <ul>
                    <li>Price
                      <div class="rating">
                        <i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile"></i><i class="icon-smile"></i>
                      </div>
                    </li>
                    <li>Quality
                      <div class="rating">
                        <i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i>
                      </div>
                    </li>
                  </ul>
                </div> 
              </div> -->
              <!-- End row -->
              <hr>
              <?php for ($i=0; $i <$r_count ; $i++) { ?>
                <div class="review_strip_single">
                  <!-- <img src="img/avatar1.jpg" alt="Image" class="img-circle"> -->
                  <img src="../../o_pic/<?php echo htmlspecialchars($reviews[$i]['pic_path']); ?>" alt="Image" class="img-circle">
                  <small><?php echo htmlspecialchars($reviews[$i]['modified']) ?></small>
                  <h4><?php echo htmlspecialchars($reviews[$i]['nickname']) ?></h4>
                  <p><?php echo htmlspecialchars($reviews[$i]['comment']) ?></p>
                </div>
              <?php } ?>
            </div>
          </div>
          <!-- 0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000 -->
        </div>
        <!--End  single_tour_desc-->

        <!-- <aside class="col-md-4">
          <p class="hidden-sm hidden-xs">
            <a class="btn_map" data-toggle="collapse" href="#collapseMap" aria-expanded="false" aria-controls="collapseMap" data-text-swap="Hide map" data-text-original="View on map">View on map</a>
          </p>
          <div class="box_style_1 expose">
            <h3 class="inner">- Booking -</h3>
            <div class="row">
              <div class="col-md-6 col-sm-6">
                <div class="form-group">
                  <label><i class="icon-calendar-7"></i> Select a date</label>
                  <input class="date-pick form-control" data-date-format="M d, D" type="text">
                </div>
              </div>
              <div class="col-md-6 col-sm-6">
                <div class="form-group">
                  <label><i class=" icon-clock"></i> Time</label>
                  <input class="time-pick form-control" value="12:00 AM" type="text">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 col-sm-6">
                <div class="form-group">
                  <label>Adults</label>
                  <div class="numbers-row">
                    <input type="text" value="1" id="adults" class="qty2 form-control" name="quantity">
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-sm-6">
                <div class="form-group">
                  <label>Children</label>
                  <div class="numbers-row">
                    <input type="text" value="0" id="children" class="qty2 form-control" name="quantity">
                  </div>
                </div>
              </div>
            </div>
            <br>
            <table class="table table_summary">
              <tbody>
                <tr>
                  <td>
                    Adults
                  </td>
                  <td class="text-right">
                    2
                  </td>
                </tr>
                <tr>
                  <td>
                    Children
                  </td>
                  <td class="text-right">
                    0
                  </td>
                </tr>
                <tr>
                  <td>
                    Total amount
                  </td>
                  <td class="text-right">
                    3x $52
                  </td>
                </tr>
                <tr class="total">
                  <td>
                    Total cost
                  </td>
                  <td class="text-right">
                    $154
                  </td>
                </tr>
              </tbody>
            </table>
            <a class="btn_full" href="cart.html">Book now</a>
            <a class="btn_full_outline" href="#"><i class=" icon-heart"></i> Add to whislist</a>
          </div>
          <!--/box_style_1 -->

          <!--<div class="box_style_4">
            <i class="icon_set_1_icon-90"></i>
            <h4><span>Book</span> by phone</h4>
            <a href="tel://004542344599" class="phone">+45 423 445 99</a>
            <small>Monday to Friday 9.00am - 7.30pm</small>
          </div>

        </aside> -->
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
    <form role="search" id="searchform" method="get">
      <input value="" name="q" type="search" placeholder="Search..." />
      <button type="submit"><i class="icon_set_1_icon-78"></i>
      </button>
    </form>
  </div><!-- End Search Menu -->













  <!-- Modal Review -->
  <!-- <div class="modal fade" id="myReview" tabindex="-1" role="dialog" aria-labelledby="myReviewLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title" id="myReviewLabel">Write your review</h4>
        </div>


        <div class="modal-body"> -->
<!--           <div id="message-review">
          </div> -->
          <!-- <form method="post" name="review_event" id="review_event"> -->


            <!-- End row -->
            <!-- <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Rating</label> -->
                  
                  <!-- 入力時 -->
                  <!-- <select class="form-control" name="rating" id="position_review">
                    <option value="1">★</option>
                    <option value="2">★ ★</option>
                    <option value="3">★ ★ ★</option>
                    <option value="4">★ ★ ★ ★</option>
                    <option value="5">★ ★ ★ ★ ★</option>
                  </select> -->

                  <!-- 入力時 -->

                <!-- </div>
              </div>
            </div> -->


            <!-- End row -->
            <!-- <label>Write Your Review</label>
            <div class="form-group">
              <textarea name="review_text" id="review_text" name="comment" class="form-control" style="height:100px" placeholder="Write your review"></textarea>
            </div>


            <label>Upload Photo</label>
            <div class="imagePreview"></div>
              <div class="input-group">
                  <label class="input-group-btn">
                      <span class="btn btn-primary">
                          Choose File<input type="file" style="display:none" class="uploadFile" name="review_pic_path">
                      </span>
                  </label>
                  <input type="text" class="form-control" readonly="">
              </div>
            <hr>
          </form>
          <button id="review-modal-c" class="form-control btn-primary" onclick="confirm()">CONFIRM</button>
          <br>
          <button id="review-modal-b" class="form-control btn-default">BACK</button>
        </div>
      </div>
    </div>
  </div> -->
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
  <script src="js/custom.js"></script>
</body>

</html>