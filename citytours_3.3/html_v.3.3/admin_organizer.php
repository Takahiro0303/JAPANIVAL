<?php 
session_start();
require('../../common/dbconnect.php');
require('../../common/functions.php');
$login_user = get_login_user($dbh);

$o_name = $login_user['o_name'];
$o_f_name = $login_user['o_f_name'];
$o_postal = $login_user['o_postal'];
$o_pref = $login_user['o_pref'];
$o_address = $login_user['o_address'];
$o_tel = $login_user['o_tel'];
$o_email = $login_user['o_email'];
$o_intro = $login_user['o_intro'];
$errors = [];

if (!empty($_POST)) {
    $o_current_password = sha1($_POST['o_current_password']);
    if ($o_current_password == $login_user['o_password']) {
        //現在のパスワードが一致する場合
        
        $o_name = $_POST['o_name'];
        $o_f_name = $_POST['o_f_name'];
        $o_postal = $_POST['o_postal'];
        $o_pref = $_POST['o_pref'];
        $o_address = $_POST['o_address'];
        $o_tel = $_POST['o_tel'];
        $o_email = $_POST['o_email'];
        $o_intro = $_POST['o_intro'];        

        if ($o_f_name == '') {
            $errors['o_f_name'] = 'blank';
        }
        if ($o_email == '') {
            $errors['o_email'] = 'blank';
        }
        if ($o_postal == 'o_postal') {
            $errors['o_postal'] = 'blank';
        }
        if ($o_pref == 'o_pref') {
            $errors['o_pref'] = 'blank';
        }
        if ($o_address == 'o_address') {
            $errors['o_address'] = 'blank';
        }
        if ($o_tel == 'o_tel') {
            $errors['o_tel'] = 'blank';
        }
        if ($o_email == 'o_email') {
            $errors['o_email'] = 'blank';
        }
        if ($o_intro == 'o_intro') {
            $errors['o_intro'] = 'blank';
        }

        if (!empty($_POST['o_new_password'])) {
            //o_new_passwordが空じゃない時
            if (strlen($_POST['o_new_password']) >= 6) {
                $o_new_password = $_POST['o_new_password'];
                $o_confirm_password = $_POST['o_confirm_password'];
                if ($o_new_password != $o_confirm_password) {
                    //new_passwordとconfirm_passwordが一致しなかった場合
                    $errors['o_confirm_password'] = 'wrong';
                }
            } else {
                $errors['o_new_password'] = 'length';
            }  
        }

        $file_name = $_FILES['o_pic']['o_name'];
        if (!empty($file_name)) {
            //画像が選択されていた場合
            $ext = substr($file_name, -3);
            $ext = strtolower($ext);
            if ($ext != 'jpg' && $ext != 'png' && $ext != 'gif') {
                $errors['o_pic'] = 'type';
            }
        }
    } else {
        $errors['o_current_password'] = 'failed';
    }

    if (empty($errors)) {
        //もし画像がセットされていればUP処理
        if (!empty($file_name)) {
            $data_str = date('YmdHis');
            $submit_file_name = $date_str . $_FILES['o_pic']['o_name'];
            move_uploaded_file($_FILES['o_pic']['tmp_name'], '../../o_pic/' . $submit_file_name);
        }

        //データベース更新
        if (empty($o_new_password)) {
            $o_password = $o_current_password;
        } else {
            $o_password = sha1($o_new_password);
        }

        if (empty($file_name)) {
            $submit_file_name = $login_user['o_pic'];
        }

        $sql = 'UPDATE organizers SET o_name=?,
                                      o_f_name=?,
                                      o_postal=?,
                                      o_pref=?,
                                      o_address=?,
                                      o_tel=?,
                                      o_email=?,
                                      o_password=?,
                                      o_intro=?,
                                      o_pic=?,
                                      modified=NOW()
                                WHERE o_id=?';
        $data = [$o_name,
                 $o_f_name,
                 $o_postal,
                 $o_pref,
                 $o_address,
                 $o_tel,
                 $o_email,
                 $o_password,
                 $o_intro,
                 $submit_file_name,
                 $login_user['o_id']];
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);

        header('Location:admin_organizer.php');
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
          <div class="col-md-6 col-sm-6 col-xs-6">
            <i class="icon-phone"></i><strong>0045 043204434</strong>
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
            <a href="index.html"><img src="img/logo.png" width="160" height="34" alt="City tours" data-retina="true" class="logo_normal"></a>
            <a href="index.html"><img src="img/logo_sticky.png" width="160" height="34" alt="City tours" data-retina="true" class="logo_sticky"></a>
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
                    <a href="javascript:void(0);" class="show-submenu">Hotels <i class="icon-down-open-mini"></i></a>
                    <ul>
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
                      <strong><a href="#">Louvre museum</a>1x $36.00 </strong>
                      <a href="#" class="action"><i class="icon-trash"></i></a>
                    </li>
                    <li>
                      <div class="image"><img src="img/thumb_cart_2.jpg" alt="image"></div>
                      <strong><a href="#">Versailles tour</a>2x $36.00 </strong>
                      <a href="#" class="action"><i class="icon-trash"></i></a>
                    </li>
                    <li>
                      <div class="image"><img src="img/thumb_cart_3.jpg" alt="image"></div>
                      <strong><a href="#">Versailles tour</a>1x $36.00 </strong>
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
          <li><a href="#">Home</a></li>
          <li><a href="#">Category</a></li>
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
          </section>
          <!-- End section 4 -->

          <section id="section-5">
            <div class="row">
              <div class="col-md-7 col-sm-7" name="a1">
                <h4>Your profile</h4>
                <ul id="profile_summary">
                  <li>団体名 <span><?php echo htmlspecialchars($o_name);?></span>
                  </li>
                  <li>代表者 <span><?php echo htmlspecialchars($o_f_name);?></span>
                  </li>
                  <li>メールアドレス<span><?php echo htmlspecialchars($o_email);?></span>
                  </li>
                  <li>郵便番号 <span><?php echo htmlspecialchars($o_postal);?></span>
                  </li>
                  <li>住所 <span><?php echo htmlspecialchars($o_pref);?> <?php echo htmlspecialchars($o_address);?></span>
                  </li>
                  <li>電話番号<span><?php echo htmlspecialchars($o_tel);?></span>
                  </li>                  
                  <li>自己紹介<span><?php echo htmlspecialchars($o_intro);?></span>
                  </li>
                </ul>
              </div>
              <div class="col-md-5 col-sm-5">
                <img src="../../o_pic/<?php echo htmlspecialchars($login_user['o_pic']); ?>" width="300" alt="Image" class="img-responsive styled profile_pic"><!-- フォルダ名/データ名 -->
              </div>
            </div>
            <!-- End row -->
<form method="POST" action="" enctype="multipart/form-data">
            <div class="divider"></div>
            <div class="row">
              <div class="col-md-12">
                <h4 id="edit_profile">Edit profile</h4>
              </div>
              <div class="col-md-12 col-sm-12">
                <table class="table table-bordered">
                  <thead>
                    <tbody>
                      
                        <tr>
                          <th class="col-md-3 col-sm-3">団体名</th>
                          <td>
                            <input class="form-control" name="o_name" id="nickname" type="text" value="<?php echo htmlspecialchars($o_name);?>">
                            <?php if (isset($errors['o_name']) && $errors['o_name'] == 'blank') { ?>
                              <p class="alert-danger">団体名を入力してください</p>
                            <?php } ?>
                          </td>
                        </tr>
                        <tr>
                          <th>代表者名</th>
                          <td>
                            <input class="form-control" name="o_f_name" id="o_f_name" type="text" value="<?php echo htmlspecialchars($o_f_name); ?>">
                            <?php if (isset($errors['o_f_name']) && $errors['o_f_name'] == 'blank') { ?>
                              <p class="alert-danger">代表者名を入力してください</p>
                            <?php } ?>
                          </td>
                        </tr>
                        <tr>
                          <th>メールアドレス</th>
                          <td>
                            <input class="form-control" name="o_email" id="o_email" type="text" value="<?php echo htmlspecialchars($o_email); ?>">
                            <?php if(isset($errors['o_email']) && $errors['o_email'] == 'blank') { ?>
                              <p class="alert-danger">メールアドレスを入力してください</p>
                            <?php } ?>
                            <?php if(isset($errors['o_email']) && $errors['o_email'] == 'duplicate') { ?>
                              <p class="error">そのメールアドレスは既に登録されています</p>
                            <?php } ?>
                          </td>
                        </tr>
                        <tr>
                          <th>現在のパスワード</th>
                            <td>
                              <input type="password" class="form-control" name="o_current_password" id="o_current_password" type="password">
                            </td>
                            <?php if(isset($errors['o_current_password']) && $errors['o_current_password'] == 'failed') { ?>
                              <p class="alert-danger">本人確認に失敗しました。再度現在のパスワードを入力してください</p>
                            <?php } ?>
                        </tr>
                        <tr>
                          <th>新しいパスワード</th>
                            <td>
                              <input class="form-control" name="o_new_password" id="o_new_password" type="password">
                              <?php if(isset($errors['o_new_password']) && $errors['o_new_password'] == 'length') { ?>
                                <p class="alert-danger">パスワードは6文字以上で入力してください</p>
                              <?php } ?>
                            </td>
                        </tr>
                        <tr>
                          <th>確認パスワード</th>
                            <td>
                              <input class="form-control" name="o_confirm_password" id="o_confirm_password" type="password">
                              <?php if(isset($errors['o_confirm_password']) && $errors['o_confirm_password'] == 'wrong') { ?>
                                <p class="alert-danger">パスワードが一致しません</p>
                              <?php } ?>
                            </td>
                        </tr>
                        <tr>
                          <th>郵便番号</th>
                            <td>
                              <input type="text" name="o_postal" class="form-control" maxlength="8" onKeyUp="AjaxZip3.zip2addr(this,'','o_pref','o_address');" value="<?php echo htmlspecialchars($o_postal); ?>">
                              <?php if (isset($errors['o_postal']) && $errors['o_postal'] == 'blank') { ?>
                                <p class="alert-danger">郵便番号を入力してください</p>
                              <?php } ?>
                            </td>
                        </tr>
                        <tr>
                          <th>都道府県</th>
                            <td>
                              <input class="form-control" name="o_pref" id="o_pref" type="text" value="<?php echo htmlspecialchars($o_pref); ?>">
                            </td>
                        </tr>
                        <tr>
                          <th>市区町村・番地・建物名・号室</th>
                          <td>
                            <input class="form-control" name="o_address" id="o_address" type="text" value="<?php echo htmlspecialchars($o_address); ?>">
                          </td>
                        </tr>
                        <tr>
                          <th>電話番号</th>
                            <td>
                              <input class="form-control" name="o_tel" id="o_tel" type="text" value="<?php echo htmlspecialchars($o_tel); ?>">
                            </td>
                        </tr>                        
                        <tr>
                          <th>自己紹介コメント</th>
                            <td>
                              <textarea class="form-control" name="o_intro" value="<?php echo htmlspecialchars($o_intro); ?>"></textarea>
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
                <input type="file" name="o_pic" id="js-upload-files" enctype="multiple/form-data">
                <?php if(isset($errors['o_pic']) && $errors['o_pic'] == 'type') { ?>
                  <p class="alert-danger">画像は「jpg」「png」「gif」の画像を選択してください</p>
                <?php } ?>
              </div>
            </div>

            <hr>
            <a href="#a1"><button type="submit" class="btn_1 green">Update Profile</button></a>
<!-- ★</form>   -->          
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
    <form role="search" id="searchform" method="get">
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