<?php 
session_start();
require('../../common/dbconnect.php');
// require('functions.php');
// require('auth.php');

$sql = 'SELECT * FROM events WHERE 1';
// $data = [$login_user['member_id'], $record['tweet_id']];
$stmt = $dbh->prepare($sql);
$stmt->execute();
// $is_like = $stmt->fetch(PDO::FETCH_ASSOC);

while ($record = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $events[] = $record;
}

//   echo '<pre>';
//   var_dump($events);
//   echo '</pre>';
// echo ($_POST['field-keywords']);

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


    <!-- 元々with search bar付きのページで必要なCSS-->
    <link href="css/base.css" rel="stylesheet">

    <!-- 元々with search tabs付きのページで必要なCSS-->
    <link href="rs-plugin/css/settings.css" rel="stylesheet">
    <link href="css/extralayers.css" rel="stylesheet">
    
    <link href="css/tabs_home.css" rel="stylesheet">

    <!-- 元々 tour listページで必要な Range sliderCSS -->
    <!-- Radio and check inputs -->
    <link href="css/skins/square/grey.css" rel="stylesheet">

    <!-- Range slider -->
    <link href="css/ion.rangeSlider.css" rel="stylesheet">
    <link href="css/ion.rangeSlider.skinFlat.css" rel="stylesheet">
        
    <!-- REVOLUTION SLIDER CSS -->
    <link rel="stylesheet" type="text/css" href="rev-slider-files/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css">
    <link rel="stylesheet" type="text/css" href="rev-slider-files/fonts/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="rev-slider-files/css/settings.css">
    
    <!-- REVOLUTION LAYERS STYLES -->
    <style>
        .tp-caption.News-Title,
        .News-Title {
            color: rgba(255, 255, 255, 1.00);
            font-size: 70px;
            line-height: 60px;
            font-weight: 700;
            font-style: normal;
            text-decoration: none;
            background-color: transparent;
            border-color: transparent;
            border-style: none;
            border-width: 0px;
            border-radius: 0 0 0 0px
        }

        .tp-caption.News-Subtitle,
        .News-Subtitle {
            color: rgba(255, 255, 255, 1.00);
            font-size: 15px;
            line-height: 24px;
            font-weight: 300;
            font-style: normal;
            font-family: Roboto Slab;
            text-decoration: none;
            background-color: rgba(255, 255, 255, 0);
            border-color: transparent;
            border-style: none;
            border-width: 0px;
            border-radius: 0 0 0 0px
        }

        .tp-caption.News-Subtitle:hover,
        .News-Subtitle:hover {
            color: rgba(255, 255, 255, 0.65);
            text-decoration: none;
            background-color: rgba(255, 255, 255, 0);
            border-color: transparent;
            border-style: solid;
            border-width: 0px;
            border-radius: 0 0 0px 0
        }
    </style>
    <style type="text/css">
        @import url(http://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700);
    </style>
    <style type="text/css">
        .hermes.tp-bullets {}

        .hermes .tp-bullet {
            overflow: hidden;
            border-radius: 50%;
            width: 16px;
            height: 16px;
            background-color: rgba(0, 0, 0, 0);
            box-shadow: inset 0 0 0 2px rgb(255, 255, 255);
            -webkit-transition: background 0.3s ease;
            transition: background 0.3s ease;
            position: absolute
        }

        .hermes .tp-bullet:hover {
            background-color: rgba(0, 0, 0, 0.21)
        }

        .hermes .tp-bullet:after {
            content: ' ';
            position: absolute;
            bottom: 0;
            height: 0;
            left: 0;
            width: 100%;
            background-color: rgb(255, 255, 255);
            box-shadow: 0 0 1px rgb(255, 255, 255);
            -webkit-transition: height 0.3s ease;
            transition: height 0.3s ease
        }

        .hermes .tp-bullet.selected:after {
            height: 100%
        }
    </style>


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
<!--                     <div class="col-md-6 col-sm-6 col-xs-6"><i class="icon-phone"></i><strong>0045 043204434</strong></div> -->
                    
                    <div class="col-md-offset-6 col-md-6 col-sm-offset-6 col-sm-6 col-xs-offset-6 col-xs-6">
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
                                </div><!-- End Dropdown access -->
                            </li>
                            <li><a href="wishlist.html" id="wishlist_link">Wishlist</a></li>
                        </ul>
                    </div>
                </div><!-- End row -->
            </div><!-- End container-->
        </div><!-- End top line-->
        
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-3 col-xs-3">
                    <div id="logo_home">
                    	<h1><a href="index.html" title="City tours travel template">City Tours travel template</a></h1>
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
                </nav>
            </div>
        </div><!-- container -->
    </header><!-- End Header -->

	<section id="hero">
        <!-- Slider -->
        <div id="rev_slider_13_1_wrapper" class="rev_slider_wrapper fullwidthbanner-container" data-alias="highlight-carousel1" data-source="gallery" style="margin:0px auto;background:#000000;padding:0px;margin-top:0px;margin-bottom:0px;">
            <!-- START REVOLUTION SLIDER 5.4.1 fullwidth mode -->
            <div id="rev_slider_13_1" class="rev_slider fullwidthabanner" style="display:none;" data-version="5.4.1">
                <ul>
                    <!-- SLIDE  -->
                    <li data-index="rs-30" data-transition="slideoverhorizontal" data-slotamount="7" data-hideafterloop="0" data-hideslideonmobile="off" data-easein="default" data-easeout="default" data-masterspeed="1500" data-thumb="rev-slider-files/assets/100x50_newspaper_bg1.jpg" data-rotate="0" data-fstransition="fade" data-fsmasterspeed="1000" data-fsslotamount="7" data-saveperformance="off" data-title="Discover" data-param1="" data-param2="" data-param3="" data-param4="" data-param5="" data-param6="" data-param7="" data-param8="" data-param9="" data-param10="" data-description="">
                        <!-- MAIN IMAGE -->
                        <img src="rev-slider-files/assets/newspaper_bg1.jpg" alt="" data-bgposition="center bottom" data-bgfit="cover" data-bgrepeat="no-repeat" data-bgparallax="10" class="rev-slidebg" data-no-retina>
                        <!-- LAYERS -->

                        <!-- LAYER NR. 1 -->
                        <div class="tp-caption News-Title   tp-resizeme" id="slide-30-layer-1" data-x="['left','left','left','left']" data-hoffset="['80','80','40','40']" data-y="['top','top','top','top']" data-voffset="['450','450','274','274']" data-fontsize="['65','65','50','50']" data-lineheight="['60','60','50','50']" data-width="364" data-height="133" data-whitespace="normal" data-type="text" data-responsive_offset="on" data-frames='[{"delay":500,"speed":1500,"frame":"0","from":"y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":1000,"frame":"999","to":"y:[100%];","mask":"x:inherit;y:inherit;s:inherit;e:inherit;","ease":"nothing"}]' data-textAlign="['left','left','left','left']" data-paddingtop="[0,0,0,0]" data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]" style="z-index: 5; min-width: 364px; max-width: 364px; max-width: 133px; max-width: 133px; white-space: normal; font-size: 65px;font-family:Montserrat;">DISCOVER THE WILD </div>

                        <!-- LAYER NR. 2 -->
                        <div class="tp-caption   tp-resizeme" id="slide-30-layer-2" data-x="['left','left','left','left']" data-hoffset="['80','80','40','40']" data-y="['top','top','top','top']" data-voffset="['587','587','382','382']" data-width="none" data-height="none" data-whitespace="nowrap" data-type="image" data-responsive_offset="on" data-frames='[{"delay":500,"speed":1500,"frame":"0","from":"x:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":1000,"frame":"999","to":"x:[100%];","mask":"x:inherit;y:inherit;s:inherit;e:inherit;","ease":"Power3.easeInOut"}]' data-textAlign="['left','left','left','left']" data-paddingtop="[0,0,0,0]" data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]" style="z-index: 6;"><img src="rev-slider-files/assets/bluebar.png" alt="" data-ww="['350px','350px','350px','350px']" data-hh="['4px','4px','4px','4px']" data-no-retina> </div>

                        <!-- LAYER NR. 3 -->
                        <div class="tp-caption News-Subtitle   tp-resizeme" id="slide-30-layer-3" data-x="['left','left','left','left']" data-hoffset="['81','81','41','41']" data-y="['top','top','top','top']" data-voffset="['605','605','401','401']" data-width="none" data-height="none" data-whitespace="nowrap" data-type="text" data-responsive_offset="on" data-frames='[{"delay":500,"speed":1500,"frame":"0","from":"y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":1000,"frame":"999","to":"y:[100%];","mask":"x:inherit;y:inherit;s:inherit;e:inherit;","ease":"nothing"},{"frame":"hover","speed":"300","ease":"Power3.easeInOut","to":"o:1;rX:0;rY:0;rZ:0;z:0;","style":"c:rgba(255, 255, 255, 0.65);br:0 0 0px 0;"}]' data-textAlign="['left','left','left','left']" data-paddingtop="[0,0,0,0]" data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]" style="z-index: 7; white-space: nowrap;cursor:pointer;">Learn how to balance your city job with nature </div>

                        <!-- LAYER NR. 4 -->
                        <div class="tp-caption -   tp-resizeme" id="slide-30-layer-4" data-x="['left','left','left','left']" data-hoffset="['423','423','383','383']" data-y="['top','top','top','top']" data-voffset="['607','607','403','403']" data-width="none" data-height="none" data-whitespace="nowrap" data-type="text" data-responsive_offset="on" data-frames='[{"delay":500,"speed":1500,"frame":"0","from":"x:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":1000,"frame":"999","to":"x:[100%];","mask":"x:inherit;y:inherit;s:inherit;e:inherit;","ease":"Power3.easeInOut"}]' data-textAlign="['left','left','left','left']" data-paddingtop="[0,0,0,0]" data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]" style="z-index: 8; white-space: nowrap; font-size: 20px; line-height: 22px; font-weight: 400; color: rgba(0,210,255,1);"><i class="fa-icon-caret-right"></i> </div>
                    </li>
                    <!-- SLIDE  -->
                    <li data-index="rs-31" data-transition="slideoverhorizontal" data-slotamount="7" data-hideafterloop="0" data-hideslideonmobile="off" data-easein="default" data-easeout="default" data-masterspeed="1500" data-thumb="assets/100x50_newspaper_bg3.jpg" data-rotate="0" data-saveperformance="off" data-title="Beach" data-param1="" data-param2="" data-param3="" data-param4="" data-param5="" data-param6="" data-param7="" data-param8="" data-param9="" data-param10="" data-description="">
                        <!-- MAIN IMAGE -->
                        <img src="rev-slider-files/assets/newspaper_bg3.jpg" alt="" data-bgposition="center bottom" data-bgfit="cover" data-bgrepeat="no-repeat" data-bgparallax="10" class="rev-slidebg" data-no-retina>
                        <!-- LAYERS -->

                        <!-- LAYER NR. 5 -->
                        <div class="tp-caption News-Title   tp-resizeme" id="slide-31-layer-1" data-x="['left','left','left','left']" data-hoffset="['80','80','40','40']" data-y="['top','top','top','top']" data-voffset="['450','450','270','270']" data-fontsize="['70','70','50','50']" data-lineheight="['60','60','50','50']" data-width="['397','397','297','297']" data-height="none" data-whitespace="normal" data-type="text" data-responsive_offset="on" data-frames='[{"delay":500,"speed":1500,"frame":"0","from":"y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":1000,"frame":"999","to":"y:[100%];","mask":"x:inherit;y:inherit;s:inherit;e:inherit;","ease":"nothing"}]' data-textAlign="['left','left','left','left']" data-paddingtop="[0,0,0,0]" data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]" style="z-index: 5; min-width: 397px; max-width: 397px; white-space: normal; color: rgba(0,0,0,1);font-family:Montserrat;">BEACH
                            <br>LIFE </div>

                        <!-- LAYER NR. 6 -->
                        <div class="tp-caption   tp-resizeme" id="slide-31-layer-2" data-x="['left','left','left','left']" data-hoffset="['80','80','40','40']" data-y="['top','top','top','top']" data-voffset="['587','587','382','382']" data-width="none" data-height="none" data-whitespace="nowrap" data-type="image" data-responsive_offset="on" data-frames='[{"delay":500,"speed":1500,"frame":"0","from":"x:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":1000,"frame":"999","to":"x:[100%];","mask":"x:inherit;y:inherit;s:inherit;e:inherit;","ease":"Power3.easeInOut"}]' data-textAlign="['left','left','left','left']" data-paddingtop="[0,0,0,0]" data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]" style="z-index: 6;"><img src="rev-slider-files/assets/bluebar.png" alt="" data-ww="" data-hh="" data-no-retina> </div>

                        <!-- LAYER NR. 7 -->
                        <div class="tp-caption News-Subtitle   tp-resizeme" id="slide-31-layer-3" data-x="['left','left','left','left']" data-hoffset="['81','81','41','41']" data-y="['top','top','top','top']" data-voffset="['605','605','401','401']" data-width="none" data-height="none" data-whitespace="nowrap" data-type="text" data-responsive_offset="on" data-frames='[{"delay":500,"speed":1500,"frame":"0","from":"y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":1000,"frame":"999","to":"y:[100%];","mask":"x:inherit;y:inherit;s:inherit;e:inherit;","ease":"nothing"},{"frame":"hover","speed":"300","ease":"Power3.easeInOut","to":"o:1;rX:0;rY:0;rZ:0;z:0;","style":"c:rgba(0, 0, 0, 0.65);br:0 0 0px 0;"}]' data-textAlign="['left','left','left','left']" data-paddingtop="[0,0,0,0]" data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]" style="z-index: 7; white-space: nowrap; color: rgba(0,0,0,1);cursor:pointer;">Summer, sun and endless fun at the beach </div>

                        <!-- LAYER NR. 8 -->
                        <div class="tp-caption -   tp-resizeme" id="slide-31-layer-4" data-x="['left','left','left','left']" data-hoffset="['423','423','383','383']" data-y="['top','top','top','top']" data-voffset="['607','607','403','403']" data-width="none" data-height="none" data-whitespace="nowrap" data-type="text" data-responsive_offset="on" data-frames='[{"delay":500,"speed":1500,"frame":"0","from":"x:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":1000,"frame":"999","to":"x:[100%];","mask":"x:inherit;y:inherit;s:inherit;e:inherit;","ease":"Power3.easeInOut"}]' data-textAlign="['left','left','left','left']" data-paddingtop="[0,0,0,0]" data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]" style="z-index: 8; white-space: nowrap; font-size: 20px; line-height: 22px; font-weight: 400; color: rgba(0,210,255,1);"><i class="fa-icon-caret-right"></i> </div>
                    </li>
                    <!-- SLIDE  -->
                    <li data-index="rs-32" data-transition="slideoverhorizontal" data-slotamount="7" data-hideafterloop="0" data-hideslideonmobile="off" data-easein="default" data-easeout="default" data-masterspeed="1500" data-thumb="assets/100x50_newspaper_bg2.jpg" data-rotate="0" data-saveperformance="off" data-title="Trip" data-param1="" data-param2="" data-param3="" data-param4="" data-param5="" data-param6="" data-param7="" data-param8="" data-param9="" data-param10="" data-description="">
                        <!-- MAIN IMAGE -->
                        <img src="rev-slider-files/assets/newspaper_bg2.jpg" alt="" data-bgposition="center bottom" data-bgfit="cover" data-bgrepeat="no-repeat" data-bgparallax="10" class="rev-slidebg" data-no-retina>
                        <!-- LAYERS -->

                        <!-- LAYER NR. 9 -->
                        <div class="tp-caption News-Title   tp-resizeme" id="slide-32-layer-1" data-x="['left','left','left','left']" data-hoffset="['80','80','40','40']" data-y="['top','top','top','top']" data-voffset="['450','450','269','269']" data-fontsize="['70','70','50','50']" data-lineheight="['60','60','50','50']" data-width="364" data-height="133" data-whitespace="normal" data-type="text" data-responsive_offset="on" data-frames='[{"delay":500,"speed":1500,"frame":"0","from":"y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":1000,"frame":"999","to":"y:[100%];","mask":"x:inherit;y:inherit;s:inherit;e:inherit;","ease":"nothing"}]' data-textAlign="['left','left','left','left']" data-paddingtop="[0,0,0,0]" data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]" style="z-index: 5; min-width: 364px; max-width: 364px; max-width: 133px; max-width: 133px; white-space: normal;font-family:Montserrat;">JUST GO HIKING </div>

                        <!-- LAYER NR. 10 -->
                        <div class="tp-caption   tp-resizeme" id="slide-32-layer-2" data-x="['left','left','left','left']" data-hoffset="['80','80','40','40']" data-y="['top','top','top','top']" data-voffset="['587','587','382','382']" data-width="none" data-height="none" data-whitespace="nowrap" data-type="image" data-responsive_offset="on" data-frames='[{"delay":500,"speed":1500,"frame":"0","from":"x:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":1000,"frame":"999","to":"x:[100%];","mask":"x:inherit;y:inherit;s:inherit;e:inherit;","ease":"Power3.easeInOut"}]' data-textAlign="['left','left','left','left']" data-paddingtop="[0,0,0,0]" data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]" style="z-index: 6;"><img src="rev-slider-files/assets/bluebar.png" alt="" data-ww="" data-hh="" data-no-retina> </div>

                        <!-- LAYER NR. 11 -->
                        <div class="tp-caption News-Subtitle   tp-resizeme" id="slide-32-layer-3" data-x="['left','left','left','left']" data-hoffset="['81','81','41','41']" data-y="['top','top','top','top']" data-voffset="['605','605','401','401']" data-width="none" data-height="none" data-whitespace="nowrap" data-type="text" data-responsive_offset="on" data-frames='[{"delay":500,"speed":1500,"frame":"0","from":"y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":1000,"frame":"999","to":"y:[100%];","mask":"x:inherit;y:inherit;s:inherit;e:inherit;","ease":"nothing"},{"frame":"hover","speed":"300","ease":"Power3.easeInOut","to":"o:1;rX:0;rY:0;rZ:0;z:0;","style":"c:rgba(255, 255, 255, 0.65);br:0 0 0px 0;"}]' data-textAlign="['left','left','left','left']" data-paddingtop="[0,0,0,0]" data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]" style="z-index: 7; white-space: nowrap;cursor:pointer;">Go and discover unknown, mysterious places </div>

                        <!-- LAYER NR. 12 -->
                        <div class="tp-caption -   tp-resizeme" id="slide-32-layer-4" data-x="['left','left','left','left']" data-hoffset="['423','423','383','383']" data-y="['top','top','top','top']" data-voffset="['607','607','403','403']" data-width="none" data-height="none" data-whitespace="nowrap" data-type="text" data-responsive_offset="on" data-frames='[{"delay":500,"speed":1500,"frame":"0","from":"x:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":1000,"frame":"999","to":"x:[100%];","mask":"x:inherit;y:inherit;s:inherit;e:inherit;","ease":"Power3.easeInOut"}]' data-textAlign="['left','left','left','left']" data-paddingtop="[0,0,0,0]" data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]" style="z-index: 8; white-space: nowrap; font-size: 20px; line-height: 22px; font-weight: 400; color: rgba(0,210,255,1);"><i class="fa-icon-caret-right"></i> </div>
                    </li>
                </ul>
                <div class="tp-bannertimer tp-bottom" style="visibility: hidden !important;"></div>
            </div>
        </div>





		<div id="search_bar_container">
			<div class="container">
                <!-- Start Search Bar -->
                <form method="POST" action="">
    				<div class="search_bar">
    					<span class="nav-facade-active" id="nav-search-in">
    								<span id="nav-search-in-content" style="">Search</span>
    					<span class="nav-down-arrow nav-sprite"></span>
    					</span>
    					<div class="nav-searchfield-outer">
    						<input type="text" autocomplete="off" name="field-keywords" placeholder="Type your search terms ...." id="twotabsearchtextbox">
    					</div>
    					<div class="nav-submit-button">
    						<input type="submit" title="Cerca" class="nav-submit-input" value="Search">
    					</div>
    				</div>
                </form>
				<!-- End search bar-->
			</div>
		</div>
		<!-- /search_bar-->
	</section>
	<!-- End hero -->


                    <div id="tabs" class="tabs">
                        <nav>
                            <ul>
                                <li><a href="#section-1" class="icon-tours"><span>Pick Up!!</span></a></li>
                                <li><a href="#section-2" class="icon-hotels"><span>Refine Search</span></a></li>
                                <li><a href="#section-3" class="icon-restaurants"><span>Map Search</span></a></li>
                            </ul>
                        </nav>
                    <div class="content">
                        

<!-- 1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111
1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111
1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111
1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111
1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111
1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111
1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111
1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111
1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111
1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111
1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111
1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111
1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111
1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111
1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111
1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111 -->






        <!-- セクション1 -->
        <section id="section-1">
            <div class="main_title">
                <h2>Paris <span>Top</span> Tours</h2>
                <p>Quisque at tortor a libero posuere laoreet vitae sed arcu. Curabitur consequat.</p>
            </div>

            <div class="row">

                <div class="col-md-4 col-sm-6 wow zoomIn" data-wow-delay="0.1s">
                    <div class="tour_container">
                        <div class="ribbon_3 popular"><span>Popular</span></div>
                        <div class="img_container">
                            <a href="single_tour.html">
                                <img src="img/tour_box_1.jpg" class="img-responsive" alt="Image">
                                <div class="short_info">
                                    <i class="icon_set_1_icon-44"></i>Historic Buildings<span class="price"><sup>$</sup>39</span>
                                </div>
                            </a>
                        </div>
                        <div class="tour_title">
                            <h3><strong>Arc Triomphe</strong> tour</h3>
                            <div class="rating">
                                <i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile"></i><small>(75)</small>
                            </div>
                            <!-- end rating -->
                            <div class="wishlist">
                                <a class="tooltip_flip tooltip-effect-1" href="javascript:void(0);">+<span class="tooltip-content-flip"><span class="tooltip-back">Add to wishlist</span></span></a>
                            </div>
                            <!-- End wish list-->
                        </div>
                    </div>
                    <!-- End box tour -->
                </div>
                <!-- End col-md-4 -->

                <div class="col-md-4 col-sm-6 wow zoomIn" data-wow-delay="0.2s">
                    <div class="tour_container">
                        <div class="ribbon_3 popular"><span>Popular</span></div>
                        <div class="img_container">
                            <a href="single_tour.html">
                                <img src="img/tour_box_2.jpg" width="800" height="533" class="img-responsive" alt="Image">
                                <div class="short_info">
                                    <i class="icon_set_1_icon-43"></i>Churches<span class="price"><sup>$</sup>45</span>
                                </div>
                            </a>
                        </div>
                        <div class="tour_title">
                            <h3><strong>Notredame</strong> tour</h3>
                            <div class="rating">
                                <i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile"></i><small>(75)</small>
                            </div>
                            <!-- end rating -->
                            <div class="wishlist">
                                <a class="tooltip_flip tooltip-effect-1" href="javascript:void(0);">+<span class="tooltip-content-flip"><span class="tooltip-back">Add to wishlist</span></span></a>
                            </div>
                            <!-- End wish list-->
                        </div>
                    </div>
                    <!-- End box tour -->
                </div>
                <!-- End col-md-4 -->

                <div class="col-md-4 col-sm-6 wow zoomIn" data-wow-delay="0.3s">
                    <div class="tour_container">
                        <div class="ribbon_3 popular"><span>Popular</span></div>
                        <div class="img_container">
                            <a href="single_tour.html">
                                <img src="img/tour_box_3.jpg" width="800" height="533" class="img-responsive" alt="Image">
                                <div class="badge_save">Save<strong>30%</strong></div>
                                <div class="short_info">
                                    <i class="icon_set_1_icon-44"></i>Historic Buildings<span class="price"><sup>$</sup>48</span>
                                </div>
                            </a>
                        </div>
                        <div class="tour_title">
                            <h3><strong>Versailles</strong> tour</h3>
                            <div class="rating">
                                <i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile"></i><small>(75)</small>
                            </div>
                            <!-- end rating -->
                            <div class="wishlist">
                                <a class="tooltip_flip tooltip-effect-1" href="javascript:void(0);">+<span class="tooltip-content-flip"><span class="tooltip-back">Add to wishlist</span></span></a>
                            </div>
                            <!-- End wish list-->
                        </div>
                    </div>
                    <!-- End box tour -->
                </div>
                <!-- End col-md-4 -->

                <div class="col-md-4 col-sm-6 wow zoomIn" data-wow-delay="0.4s">
                    <div class="tour_container">
                        <div class="ribbon_3 popular"><span>Popular</span></div>
                        <div class="img_container">
                            <a href="single_tour.html">
                                <img src="img/tour_box_4.jpg" width="800" height="533" class="img-responsive" alt="Image">
                                <div class="short_info">
                                    <i class="icon_set_1_icon-30"></i>Walking tour<span class="price"><sup>$</sup>36</span>
                                </div>
                            </a>
                        </div>
                        <div class="tour_title">
                            <h3><strong>Pompidue</strong> tour</h3>
                            <div class="rating">
                                <i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile"></i><small>(75)</small>
                            </div>
                            <!-- end rating -->
                            <div class="wishlist">
                                <a class="tooltip_flip tooltip-effect-1" href="javascript:void(0);">+<span class="tooltip-content-flip"><span class="tooltip-back">Add to wishlist</span></span></a>
                            </div>
                            <!-- End wish list-->
                        </div>
                    </div>
                    <!-- End box tour -->
                </div>
                <!-- End col-md-4 -->

                <div class="col-md-4 col-sm-6 wow zoomIn" data-wow-delay="0.5s">
                    <div class="tour_container">
                        <div class="ribbon_3"><span>Top rated</span></div>
                        <div class="img_container">
                            <a href="single_tour.html">
                                <img src="img/tour_box_14.jpg" width="800" height="533" class="img-responsive" alt="Image">
                                <div class="badge_save">Save<strong>30%</strong></div>
                                <div class="short_info">
                                    <i class="icon_set_1_icon-28"></i>Skyline tours<span class="price"><sup>$</sup>42</span>
                                </div>
                            </a>
                        </div>
                        <div class="tour_title">
                            <h3><strong>Tour Eiffel</strong> tour</h3>
                            <div class="rating">
                                <i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile"></i><small>(75)</small>
                            </div>
                            <!-- end rating -->
                            <div class="wishlist">
                                <a class="tooltip_flip tooltip-effect-1" href="javascript:void(0);">+<span class="tooltip-content-flip"><span class="tooltip-back">Add to wishlist</span></span></a>
                            </div>
                            <!-- End wish list-->
                        </div>
                    </div>
                    <!-- End box tour -->
                </div>
                <!-- End col-md-4 -->

                <div class="col-md-4 col-sm-6 wow zoomIn" data-wow-delay="0.6s">
                    <div class="tour_container">
                        <div class="ribbon_3"><span>Top rated</span></div>
                        <div class="img_container">
                            <a href="single_tour.html">
                                <img src="img/tour_box_5.jpg" width="800" height="533" class="img-responsive" alt="Image">
                                <div class="short_info">
                                    <i class="icon_set_1_icon-44"></i>Historic Buildings<span class="price"><sup>$</sup>40</span>
                                </div>
                            </a>
                        </div>
                        <div class="tour_title">
                            <h3><strong>Pantheon</strong> tour</h3>
                            <div class="rating">
                                <i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile"></i><small>(75)</small>
                            </div>
                            <!-- end rating -->
                            <div class="wishlist">
                                <a class="tooltip_flip tooltip-effect-1" href="javascript:void(0);">+<span class="tooltip-content-flip"><span class="tooltip-back">Add to wishlist</span></span></a>
                            </div>
                            <!-- End wish list-->
                        </div>
                    </div>
                    <!-- End box tour -->
                </div>
                <!-- End col-md-4 -->

                <div class="col-md-4 col-sm-6 wow zoomIn" data-wow-delay="0.7s">
                    <div class="tour_container">
                        <div class="ribbon_3"><span>Top rated</span></div>
                        <div class="img_container">
                            <a href="single_tour.html">
                                <img src="img/tour_box_8.jpg" width="800" height="533" class="img-responsive" alt="Image">
                                <div class="short_info">
                                    <i class="icon_set_1_icon-3"></i>City sightseeing<span class="price"><sup>$</sup>35</span>
                                </div>
                            </a>
                        </div>
                        <div class="tour_title">
                            <h3><strong>Open Bus</strong> tour</h3>
                            <div class="rating">
                                <i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile"></i><small>(75)</small>
                            </div>
                            <!-- end rating -->
                            <div class="wishlist">
                                <a class="tooltip_flip tooltip-effect-1" href="javascript:void(0);">+<span class="tooltip-content-flip"><span class="tooltip-back">Add to wishlist</span></span></a>
                            </div>
                            <!-- End wish list-->
                        </div>
                    </div>
                    <!-- End box tour -->
                </div>
                <!-- End col-md-4 -->

                <div class="col-md-4 col-sm-6 wow zoomIn" data-wow-delay="0.8s">
                    <div class="tour_container">
                        <div class="ribbon_3"><span>Top rated</span></div>
                        <div class="img_container">
                            <a href="single_tour.html">
                                <img src="img/tour_box_9.jpg" width="800" height="533" class="img-responsive" alt="Image">
                                <div class="short_info">
                                    <i class="icon_set_1_icon-4"></i>Museums<span class="price"><sup>$</sup>38</span>
                                </div>
                            </a>
                        </div>
                        <div class="tour_title">
                            <h3><strong>Louvre museum</strong> tour</h3>
                            <div class="rating">
                                <i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile"></i><small>(75)</small>
                            </div>
                            <!-- end rating -->
                            <div class="wishlist">
                                <a class="tooltip_flip tooltip-effect-1" href="javascript:void(0);">+<span class="tooltip-content-flip"><span class="tooltip-back">Add to wishlist</span></span></a>
                            </div>
                            <!-- End wish list-->
                        </div>
                    </div>
                    <!-- End box tour -->
                </div>
                <!-- End col-md-4 -->

                <div class="col-md-4 col-sm-6 wow zoomIn" data-wow-delay="0.9s">
                    <div class="tour_container">
                        <div class="ribbon_3"><span>Top rated</span></div>
                        <div class="img_container">
                            <a href="single_tour.html">
                                <img src="img/tour_box_12.jpg" width="800" height="533" class="img-responsive" alt="Image">
                                <div class="short_info">
                                    <i class="icon_set_1_icon-14"></i>Eat &amp; drink<span class="price"><sup>$</sup>25</span>
                                </div>
                            </a>
                        </div>
                        <div class="tour_title">
                            <h3><strong>Boulangerie</strong> tour</h3>
                            <div class="rating">
                                <i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile"></i><small>(75)</small>
                            </div>
                            <!-- end rating -->
                            <div class="wishlist">
                                <a class="tooltip_flip tooltip-effect-1" href="javascript:void(0);">+<span class="tooltip-content-flip"><span class="tooltip-back">Add to wishlist</span></span></a>
                            </div>
                            <!-- End wish list-->
                        </div>
                    </div>
                    <!-- End box tour -->
                </div>
                <!-- End col-md-4 -->

            </div>
            <!-- End row -->

            <p class="text-center nopadding"> <a href="#" class="btn_1 medium"><i class="icon-eye-7"></i>View all tours (144) </a>
            </p>
        </section>
        <!-- End section -->


<!-- 1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111
1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111
1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111
1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111
1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111
1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111
1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111
1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111
1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111
1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111
1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111
1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111
1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111
1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111
1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111
1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111 -->
                        <section id="section-2">
                            <!-- map -->
                            <div class="collapse" id="collapseMap">
                                <div id="map" class="map"></div>
                            </div>
                            <!-- End Map -->

                            <div class="container margin_60">

                                <div class="row">
                                    <aside class="col-lg-3 col-md-3">
                                        <p>
                                            <a class="btn_map" data-toggle="collapse" href="#collapseMap" aria-expanded="false" aria-controls="collapseMap" data-text-swap="Hide map" data-text-original="View on map">View on map</a>
                                        </p>

                                        <div class="box_style_cat">
                                            <ul id="cat_nav">
                                                <li><a href="#" id="active"><i class="icon_set_1_icon-51"></i>All tours <span>(141)</span></a>
                                                </li>
                                                <li><a href="#"><i class="icon_set_1_icon-3"></i>City sightseeing <span>(20)</span></a>
                                                </li>
                                                <li><a href="#"><i class="icon_set_1_icon-4"></i>Museum tours <span>(16)</span></a>
                                                </li>
                                                <li><a href="#"><i class="icon_set_1_icon-44"></i>Historic Buildings <span>(12)</span></a>
                                                </li>
                                                <li><a href="#"><i class="icon_set_1_icon-37"></i>Walking tours <span>(11)</span></a>
                                                </li>
                                                <li><a href="#"><i class="icon_set_1_icon-14"></i>Eat & Drink <span>(20)</span></a>
                                                </li>
                                                <li><a href="#"><i class="icon_set_1_icon-43"></i>Churces <span>(08)</span></a>
                                                </li>
                                                <li><a href="#"><i class="icon_set_1_icon-28"></i>Skyline tours <span>(11)</span></a>
                                                </li>
                                            </ul>
                                        </div>

                                        <div id="filters_col">
                                            <a data-toggle="collapse" href="#collapseFilters" aria-expanded="false" aria-controls="collapseFilters" id="filters_col_bt"><i class="icon_set_1_icon-65"></i>Filters <i class="icon-plus-1 pull-right"></i></a>
                                            <div class="collapse" id="collapseFilters">
                                                <div class="filter_type">
                                                    <h6>Price</h6>
                                                    <input type="text" id="range" name="range" value="">
                                                </div>
                                                <div class="filter_type">
                                                    <h6>Rating</h6>
                                                    <ul>
                                                        <li>
                                                            <label>
                                                                <input type="checkbox"><span class="rating">
                                            <i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i>
                                            </span>
                                                            </label>
                                                        </li>
                                                        <li>
                                                            <label>
                                                                <input type="checkbox"><span class="rating">
                                            <i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile"></i>
                                            </span>
                                                            </label>
                                                        </li>
                                                        <li>
                                                            <label>
                                                                <input type="checkbox"><span class="rating">
                                            <i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile"></i><i class="icon-smile"></i>
                                            </span>
                                                            </label>
                                                        </li>
                                                        <li>
                                                            <label>
                                                                <input type="checkbox"><span class="rating">
                                            <i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile"></i><i class="icon-smile"></i><i class="icon-smile"></i>
                                            </span>
                                                            </label>
                                                        </li>
                                                        <li>
                                                            <label>
                                                                <input type="checkbox"><span class="rating">
                                            <i class="icon-smile voted"></i><i class="icon-smile"></i><i class="icon-smile"></i><i class="icon-smile"></i><i class="icon-smile"></i>
                                            </span>
                                                            </label>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="filter_type">
                                                    <h6>Facility</h6>
                                                    <ul>
                                                        <li>
                                                            <label>
                                                                <input type="checkbox">Pet allowed</label>
                                                        </li>
                                                        <li>
                                                            <label>
                                                                <input type="checkbox">Groups allowed</label>
                                                        </li>
                                                        <li>
                                                            <label>
                                                                <input type="checkbox">Tour guides</label>
                                                        </li>
                                                        <li>
                                                            <label>
                                                                <input type="checkbox">Access for disabled</label>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <!--End collapse -->
                                        </div>
                                        <!--End filters col-->
                                        <div class="box_style_2">
                                            <i class="icon_set_1_icon-57"></i>
                                            <h4>Need <span>Help?</span></h4>
                                            <a href="tel://004542344599" class="phone">+45 423 445 99</a>
                                            <small>Monday to Friday 9.00am - 7.30pm</small>
                                        </div>
                                    </aside>
                                    <!--End aside -->
                                    <div class="col-lg-9 col-md-9">

                                        <div id="tools">

                                            <div class="row">
                                                <div class="col-md-3 col-sm-3 col-xs-6">
                                                    <div class="styled-select-filters">
                                                        <select name="sort_price" id="sort_price">
                                                            <option value="" selected>Sort by price</option>
                                                            <option value="lower">Lowest price</option>
                                                            <option value="higher">Highest price</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-sm-3 col-xs-6">
                                                    <div class="styled-select-filters">
                                                        <select name="sort_rating" id="sort_rating">
                                                            <option value="" selected>Sort by ranking</option>
                                                            <option value="lower">Lowest ranking</option>
                                                            <option value="higher">Highest ranking</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-sm-6 hidden-xs text-right">
                                                    <a href="all_tours_grid.html" class="bt_filters"><i class="icon-th"></i></a> <a href="#" class="bt_filters"><i class=" icon-list"></i></a>
                                                </div>

                                            </div>
                                        </div>
                                        <!--/tools -->

                                        <div class="strip_all_tour_list wow fadeIn" data-wow-delay="0.1s">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-4 col-sm-4">
                                                    <div class="ribbon_3 popular"><span>Popular</span>
                                                    </div>
                                                    <div class="wishlist">
                                                        <a class="tooltip_flip tooltip-effect-1" href="javascript:void(0);">+<span class="tooltip-content-flip"><span class="tooltip-back">Add to wishlist</span></span></a>
                                                    </div>
                                                    <div class="img_list">
                                                        <a href="single_tour.html"><img src="img/tour_box_1.jpg" alt="Image">
                                                            <div class="short_info"><i class="icon_set_1_icon-4"></i>Museums </div>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="clearfix visible-xs-block"></div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="tour_list_desc">
                                                        <div class="rating"><i class="icon-smile voted"></i><i class="icon-smile  voted"></i><i class="icon-smile  voted"></i><i class="icon-smile  voted"></i><i class="icon-smile"></i><small>(75)</small>
                                                        </div>
                                                        <h3><strong>Arch Triomphe</strong> tour</h3>
                                                        <p>Lorem ipsum dolor sit amet, quem convenire interesset ut vix, ad dicat sanctus detracto vis. Eos modus dolorum ex, qui adipisci maiestatis inciderint no, eos in elit dicat.....</p>
                                                        <ul class="add_info">
                                                            <li>
                                                                <div class="tooltip_styled tooltip-effect-4">
                                                                    <span class="tooltip-item"><i class="icon_set_1_icon-83"></i></span>
                                                                    <div class="tooltip-content">
                                                                        <h4>Schedule</h4>
                                                                        <strong>Monday to Friday</strong> 09.00 AM - 5.30 PM
                                                                        <br>
                                                                        <strong>Saturday</strong> 09.00 AM - 5.30 PM
                                                                        <br>
                                                                        <strong>Sunday</strong> <span class="label label-danger">Closed</span>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="tooltip_styled tooltip-effect-4">
                                                                    <span class="tooltip-item"><i class="icon_set_1_icon-41"></i></span>
                                                                    <div class="tooltip-content">
                                                                        <h4>Address</h4> Musée du Louvre, 75058 Paris - France
                                                                        <br>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="tooltip_styled tooltip-effect-4">
                                                                    <span class="tooltip-item"><i class="icon_set_1_icon-97"></i></span>
                                                                    <div class="tooltip-content">
                                                                        <h4>Languages</h4> English - French - Chinese - Russian - Italian
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="tooltip_styled tooltip-effect-4">
                                                                    <span class="tooltip-item"><i class="icon_set_1_icon-27"></i></span>
                                                                    <div class="tooltip-content">
                                                                        <h4>Parking</h4> 1-3 Rue Elisée Reclus
                                                                        <br> 76 Rue du Général Leclerc
                                                                        <br> 8 Rue Caillaux 94923
                                                                        <br>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="tooltip_styled tooltip-effect-4">
                                                                    <span class="tooltip-item"><i class="icon_set_1_icon-25"></i></span>
                                                                    <div class="tooltip-content">
                                                                        <h4>Transport</h4>
                                                                        <strong>Metro: </strong>Musée du Louvre station (line 1)
                                                                        <br>
                                                                        <strong>Bus:</strong> 21, 24, 27, 39, 48, 68, 69, 72, 81, 95
                                                                        <br>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-md-2 col-sm-2">
                                                    <div class="price_list">
                                                        <div><sup>$</sup>39*<span class="normal_price_list">$99</span><small>*Per person</small>
                                                            <p><a href="single_tour.html" class="btn_1">Details</a>
                                                            </p>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--End strip -->

                                        <div class="strip_all_tour_list wow fadeIn" data-wow-delay="0.2s">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-4 col-sm-4">
                                                    <div class="ribbon_3 popular"><span>Popular</span>
                                                    </div>
                                                    <div class="wishlist">
                                                        <a class="tooltip_flip tooltip-effect-1" href="javascript:void(0);">+<span class="tooltip-content-flip"><span class="tooltip-back">Add to wishlist</span></span></a>
                                                    </div>
                                                    <div class="img_list">
                                                        <a href="single_tour.html"><img src="img/tour_box_2.jpg" alt="Image">
                                                            <div class="short_info"><i class="icon_set_1_icon-44"></i>Churches</div>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="clearfix visible-xs-block"></div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="tour_list_desc">
                                                        <div class="rating"><i class="icon-smile voted"></i><i class="icon-smile  voted"></i><i class="icon-smile  voted"></i><i class="icon-smile  voted"></i><i class="icon-smile"></i><small>(75)</small>
                                                        </div>
                                                        <h3><strong>Notredame</strong> tour</h3>
                                                        <p>Lorem ipsum dolor sit amet, quem convenire interesset ut vix, ad dicat sanctus detracto vis. Eos modus dolorum ex, qui adipisci maiestatis inciderint no, eos in elit dicat.....</p>
                                                        <ul class="add_info">
                                                            <li>
                                                                <div class="tooltip_styled tooltip-effect-4">
                                                                    <span class="tooltip-item"><i class="icon_set_1_icon-83"></i></span>
                                                                    <div class="tooltip-content">
                                                                        <h4>Schedule</h4>
                                                                        <strong>Monday to Friday</strong> 09.00 AM - 5.30 PM
                                                                        <br>
                                                                        <strong>Saturday</strong> 09.00 AM - 5.30 PM
                                                                        <br>
                                                                        <strong>Sunday</strong> <span class="label label-danger">Closed</span>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="tooltip_styled tooltip-effect-4">
                                                                    <span class="tooltip-item"><i class="icon_set_1_icon-41"></i></span>
                                                                    <div class="tooltip-content">
                                                                        <h4>Address</h4> Musée du Louvre, 75058 Paris - France
                                                                        <br>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="tooltip_styled tooltip-effect-4">
                                                                    <span class="tooltip-item"><i class="icon_set_1_icon-97"></i></span>
                                                                    <div class="tooltip-content">
                                                                        <h4>Languages</h4> English - French - Chinese - Russian - Italian
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="tooltip_styled tooltip-effect-4">
                                                                    <span class="tooltip-item"><i class="icon_set_1_icon-27"></i></span>
                                                                    <div class="tooltip-content">
                                                                        <h4>Parking</h4> 1-3 Rue Elisée Reclus
                                                                        <br> 76 Rue du Général Leclerc
                                                                        <br> 8 Rue Caillaux 94923
                                                                        <br>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="tooltip_styled tooltip-effect-4">
                                                                    <span class="tooltip-item"><i class="icon_set_1_icon-25"></i></span>
                                                                    <div class="tooltip-content">
                                                                        <h4>Transport</h4>
                                                                        <strong>Metro: </strong>Musée du Louvre station (line 1)
                                                                        <br>
                                                                        <strong>Bus:</strong> 21, 24, 27, 39, 48, 68, 69, 72, 81, 95
                                                                        <br>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-md-2 col-sm-2">
                                                    <div class="price_list">
                                                        <div><sup>$</sup>42*<span class="normal_price_list">$99</span><small>*Per person</small>
                                                            <p><a href="single_tour.html" class="btn_1">Details</a>
                                                            </p>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--End strip -->

                                        <div class="strip_all_tour_list wow fadeIn" data-wow-delay="0.3s">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-4 col-sm-4">
                                                    <div class="ribbon_3"><span>Top rated</span>
                                                    </div>
                                                    <div class="wishlist">
                                                        <a class="tooltip_flip tooltip-effect-1" href="javascript:void(0);">+<span class="tooltip-content-flip"><span class="tooltip-back">Add to wishlist</span></span></a>
                                                    </div>
                                                    <div class="img_list">
                                                        <a href="single_tour.html"><img src="img/tour_box_3.jpg" alt="Image">
                                                            <div class="short_info"><i class="icon_set_1_icon-44"></i>Historic Buildings</div>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="clearfix visible-xs-block"></div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="tour_list_desc">
                                                        <div class="rating"><i class="icon-smile voted"></i><i class="icon-smile  voted"></i><i class="icon-smile  voted"></i><i class="icon-smile  voted"></i><i class="icon-smile"></i><small>(75)</small>
                                                        </div>
                                                        <h3><strong>Versailles</strong> tour</h3>
                                                        <p>Lorem ipsum dolor sit amet, quem convenire interesset ut vix, ad dicat sanctus detracto vis. Eos modus dolorum ex, qui adipisci maiestatis inciderint no, eos in elit dicat.....</p>
                                                        <ul class="add_info">
                                                            <li>
                                                                <div class="tooltip_styled tooltip-effect-4">
                                                                    <span class="tooltip-item"><i class="icon_set_1_icon-83"></i></span>
                                                                    <div class="tooltip-content">
                                                                        <h4>Schedule</h4>
                                                                        <strong>Monday to Friday</strong> 09.00 AM - 5.30 PM
                                                                        <br>
                                                                        <strong>Saturday</strong> 09.00 AM - 5.30 PM
                                                                        <br>
                                                                        <strong>Sunday</strong> <span class="label label-danger">Closed</span>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="tooltip_styled tooltip-effect-4">
                                                                    <span class="tooltip-item"><i class="icon_set_1_icon-41"></i></span>
                                                                    <div class="tooltip-content">
                                                                        <h4>Address</h4> Musée du Louvre, 75058 Paris - France
                                                                        <br>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="tooltip_styled tooltip-effect-4">
                                                                    <span class="tooltip-item"><i class="icon_set_1_icon-97"></i></span>
                                                                    <div class="tooltip-content">
                                                                        <h4>Languages</h4> English - French - Chinese - Russian - Italian
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="tooltip_styled tooltip-effect-4">
                                                                    <span class="tooltip-item"><i class="icon_set_1_icon-27"></i></span>
                                                                    <div class="tooltip-content">
                                                                        <h4>Parking</h4> 1-3 Rue Elisée Reclus
                                                                        <br> 76 Rue du Général Leclerc
                                                                        <br> 8 Rue Caillaux 94923
                                                                        <br>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="tooltip_styled tooltip-effect-4">
                                                                    <span class="tooltip-item"><i class="icon_set_1_icon-25"></i></span>
                                                                    <div class="tooltip-content">
                                                                        <h4>Transport</h4>
                                                                        <strong>Metro: </strong>Musée du Louvre station (line 1)
                                                                        <br>
                                                                        <strong>Bus:</strong> 21, 24, 27, 39, 48, 68, 69, 72, 81, 95
                                                                        <br>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-md-2 col-sm-2">
                                                    <div class="price_list">
                                                        <div><sup>$</sup>39*<span class="normal_price_list">$99</span><small>*Per person</small>
                                                            <p><a href="single_tour.html" class="btn_1">Details</a>
                                                            </p>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--End strip -->

                                        <div class="strip_all_tour_list wow fadeIn" data-wow-delay="0.4s">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-4 col-sm-4">
                                                    <div class="ribbon_3"><span>Top rated</span>
                                                    </div>
                                                    <div class="wishlist">
                                                        <a class="tooltip_flip tooltip-effect-1" href="javascript:void(0);">+<span class="tooltip-content-flip"><span class="tooltip-back">Add to wishlist</span></span></a>
                                                    </div>
                                                    <div class="img_list">
                                                        <a href="single_tour.html"><img src="img/tour_box_4.jpg" alt="Image">
                                                            <div class="short_info"><i class="icon_set_1_icon-37"></i>Walking tour</div>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="clearfix visible-xs-block"></div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="tour_list_desc">
                                                        <div class="rating"><i class="icon-smile voted"></i><i class="icon-smile  voted"></i><i class="icon-smile  voted"></i><i class="icon-smile  voted"></i><i class="icon-smile"></i><small>(75)</small>
                                                        </div>
                                                        <h3><strong>Pompidue</strong> tour</h3>
                                                        <p>Lorem ipsum dolor sit amet, quem convenire interesset ut vix, ad dicat sanctus detracto vis. Eos modus dolorum ex, qui adipisci maiestatis inciderint no, eos in elit dicat.....</p>
                                                        <ul class="add_info">
                                                            <li>
                                                                <div class="tooltip_styled tooltip-effect-4">
                                                                    <span class="tooltip-item"><i class="icon_set_1_icon-83"></i></span>
                                                                    <div class="tooltip-content">
                                                                        <h4>Schedule</h4>
                                                                        <strong>Monday to Friday</strong> 09.00 AM - 5.30 PM
                                                                        <br>
                                                                        <strong>Saturday</strong> 09.00 AM - 5.30 PM
                                                                        <br>
                                                                        <strong>Sunday</strong> <span class="label label-danger">Closed</span>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="tooltip_styled tooltip-effect-4">
                                                                    <span class="tooltip-item"><i class="icon_set_1_icon-41"></i></span>
                                                                    <div class="tooltip-content">
                                                                        <h4>Address</h4> Musée du Louvre, 75058 Paris - France
                                                                        <br>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="tooltip_styled tooltip-effect-4">
                                                                    <span class="tooltip-item"><i class="icon_set_1_icon-97"></i></span>
                                                                    <div class="tooltip-content">
                                                                        <h4>Languages</h4> English - French - Chinese - Russian - Italian
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="tooltip_styled tooltip-effect-4">
                                                                    <span class="tooltip-item"><i class="icon_set_1_icon-27"></i></span>
                                                                    <div class="tooltip-content">
                                                                        <h4>Parking</h4> 1-3 Rue Elisée Reclus
                                                                        <br> 76 Rue du Général Leclerc
                                                                        <br> 8 Rue Caillaux 94923
                                                                        <br>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="tooltip_styled tooltip-effect-4">
                                                                    <span class="tooltip-item"><i class="icon_set_1_icon-25"></i></span>
                                                                    <div class="tooltip-content">
                                                                        <h4>Transport</h4>
                                                                        <strong>Metro: </strong>Musée du Louvre station (line 1)
                                                                        <br>
                                                                        <strong>Bus:</strong> 21, 24, 27, 39, 48, 68, 69, 72, 81, 95
                                                                        <br>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-md-2 col-sm-2">
                                                    <div class="price_list">
                                                        <div><sup>$</sup>69*<span class="normal_price_list">$59</span><small>*Per person</small>
                                                            <p><a href="single_tour.html" class="btn_1">Details</a>
                                                            </p>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--End strip -->

                                        <div class="strip_all_tour_list wow fadeIn" data-wow-delay="0.5s">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-4 col-sm-4">
                                                    <div class="ribbon_3"><span>Top rated</span>
                                                    </div>
                                                    <div class="wishlist">
                                                        <a class="tooltip_flip tooltip-effect-1" href="javascript:void(0);">+<span class="tooltip-content-flip"><span class="tooltip-back">Add to wishlist</span></span></a>
                                                    </div>
                                                    <div class="img_list">
                                                        <a href="single_tour.html"><img src="img/tour_box_14.jpg" alt="Image">
                                                            <div class="short_info"><i class="icon_set_1_icon-28"></i>Skyline tour</div>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="clearfix visible-xs-block"></div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="tour_list_desc">
                                                        <div class="rating"><i class="icon-smile voted"></i><i class="icon-smile  voted"></i><i class="icon-smile  voted"></i><i class="icon-smile  voted"></i><i class="icon-smile"></i><small>(75)</small>
                                                        </div>
                                                        <h3><strong>Tour Eiffel</strong> tour</h3>
                                                        <p>Lorem ipsum dolor sit amet, quem convenire interesset ut vix, ad dicat sanctus detracto vis. Eos modus dolorum ex, qui adipisci maiestatis inciderint no, eos in elit dicat.....</p>
                                                        <ul class="add_info">
                                                            <li>
                                                                <div class="tooltip_styled tooltip-effect-4">
                                                                    <span class="tooltip-item"><i class="icon_set_1_icon-83"></i></span>
                                                                    <div class="tooltip-content">
                                                                        <h4>Schedule</h4>
                                                                        <strong>Monday to Friday</strong> 09.00 AM - 5.30 PM
                                                                        <br>
                                                                        <strong>Saturday</strong> 09.00 AM - 5.30 PM
                                                                        <br>
                                                                        <strong>Sunday</strong> <span class="label label-danger">Closed</span>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="tooltip_styled tooltip-effect-4">
                                                                    <span class="tooltip-item"><i class="icon_set_1_icon-41"></i></span>
                                                                    <div class="tooltip-content">
                                                                        <h4>Address</h4> Musée du Louvre, 75058 Paris - France
                                                                        <br>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="tooltip_styled tooltip-effect-4">
                                                                    <span class="tooltip-item"><i class="icon_set_1_icon-97"></i></span>
                                                                    <div class="tooltip-content">
                                                                        <h4>Languages</h4> English - French - Chinese - Russian - Italian
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="tooltip_styled tooltip-effect-4">
                                                                    <span class="tooltip-item"><i class="icon_set_1_icon-27"></i></span>
                                                                    <div class="tooltip-content">
                                                                        <h4>Parking</h4> 1-3 Rue Elisée Reclus
                                                                        <br> 76 Rue du Général Leclerc
                                                                        <br> 8 Rue Caillaux 94923
                                                                        <br>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="tooltip_styled tooltip-effect-4">
                                                                    <span class="tooltip-item"><i class="icon_set_1_icon-25"></i></span>
                                                                    <div class="tooltip-content">
                                                                        <h4>Transport</h4>
                                                                        <strong>Metro: </strong>Musée du Louvre station (line 1)
                                                                        <br>
                                                                        <strong>Bus:</strong> 21, 24, 27, 39, 48, 68, 69, 72, 81, 95
                                                                        <br>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-md-2 col-sm-2">
                                                    <div class="price_list">
                                                        <div><sup>$</sup>49*<span class="normal_price_list">$59</span><small>*Per person</small>
                                                            <p><a href="single_tour.html" class="btn_1">Details</a>
                                                            </p>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--End strip -->

                                        <div class="strip_all_tour_list wow fadeIn" data-wow-delay="0.7s">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-4 col-sm-4">
                                                    <div class="ribbon_3"><span>Top rated</span>
                                                    </div>
                                                    <div class="wishlist">
                                                        <a class="tooltip_flip tooltip-effect-1" href="javascript:void(0);">+<span class="tooltip-content-flip"><span class="tooltip-back">Add to wishlist</span></span></a>
                                                    </div>
                                                    <div class="img_list">
                                                        <a href="single_tour.html"><img src="img/tour_box_5.jpg" alt="Image">
                                                            <div class="short_info"><i class="icon_set_1_icon-44"></i>Historic Building</div>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="clearfix visible-xs-block"></div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="tour_list_desc">
                                                        <div class="rating"><i class="icon-smile voted"></i><i class="icon-smile  voted"></i><i class="icon-smile  voted"></i><i class="icon-smile  voted"></i><i class="icon-smile"></i><small>(75)</small>
                                                        </div>
                                                        <h3><strong>Pantheon</strong> tour</h3>
                                                        <p>Lorem ipsum dolor sit amet, quem convenire interesset ut vix, ad dicat sanctus detracto vis. Eos modus dolorum ex, qui adipisci maiestatis inciderint no, eos in elit dicat.....</p>
                                                        <ul class="add_info">
                                                            <li>
                                                                <div class="tooltip_styled tooltip-effect-4">
                                                                    <span class="tooltip-item"><i class="icon_set_1_icon-83"></i></span>
                                                                    <div class="tooltip-content">
                                                                        <h4>Schedule</h4>
                                                                        <strong>Monday to Friday</strong> 09.00 AM - 5.30 PM
                                                                        <br>
                                                                        <strong>Saturday</strong> 09.00 AM - 5.30 PM
                                                                        <br>
                                                                        <strong>Sunday</strong> <span class="label label-danger">Closed</span>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="tooltip_styled tooltip-effect-4">
                                                                    <span class="tooltip-item"><i class="icon_set_1_icon-41"></i></span>
                                                                    <div class="tooltip-content">
                                                                        <h4>Address</h4> Musée du Louvre, 75058 Paris - France
                                                                        <br>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="tooltip_styled tooltip-effect-4">
                                                                    <span class="tooltip-item"><i class="icon_set_1_icon-97"></i></span>
                                                                    <div class="tooltip-content">
                                                                        <h4>Languages</h4> English - French - Chinese - Russian - Italian
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="tooltip_styled tooltip-effect-4">
                                                                    <span class="tooltip-item"><i class="icon_set_1_icon-27"></i></span>
                                                                    <div class="tooltip-content">
                                                                        <h4>Parking</h4> 1-3 Rue Elisée Reclus
                                                                        <br> 76 Rue du Général Leclerc
                                                                        <br> 8 Rue Caillaux 94923
                                                                        <br>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="tooltip_styled tooltip-effect-4">
                                                                    <span class="tooltip-item"><i class="icon_set_1_icon-25"></i></span>
                                                                    <div class="tooltip-content">
                                                                        <h4>Transport</h4>
                                                                        <strong>Metro: </strong>Musée du Louvre station (line 1)
                                                                        <br>
                                                                        <strong>Bus:</strong> 21, 24, 27, 39, 48, 68, 69, 72, 81, 95
                                                                        <br>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-md-2 col-sm-2">
                                                    <div class="price_list">
                                                        <div><sup>$</sup>49*<span class="normal_price_list">$59</span><small>*Per person</small>
                                                            <p><a href="single_tour.html" class="btn_1">Details</a>
                                                            </p>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--End strip -->

                                        <hr>

                                        <div class="text-center">
                                            <ul class="pagination">
                                                <li><a href="#">Prev</a>
                                                </li>
                                                <li class="active"><a href="#">1</a>
                                                </li>
                                                <li><a href="#">2</a>
                                                </li>
                                                <li><a href="#">3</a>
                                                </li>
                                                <li><a href="#">4</a>
                                                </li>
                                                <li><a href="#">5</a>
                                                </li>
                                                <li><a href="#">Next</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <!-- end pagination-->

                                    </div>
                                    <!-- End col lg-9 -->
                                </div>
                                <!-- End row -->
                            </div>
                        </section>

<!-- 1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111
1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111
1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111
1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111
1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111
1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111
1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111
1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111
1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111
1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111
1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111
1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111
1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111
1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111
1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111
1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111 -->
                        <section id="section-3">
                            <div class="container-fluid full-height">
                                <div class="row row-height">
                                    <div class="col-md-7 content-left">
                                    
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <div class="hotel_container">
                                                <div class="ribbon_3 popular"><span>Popular</span></div>
                                                <div class="img_container">
                                                    <a href="single_hotel.html">
                                                    <img src="img/hotel_1.jpg" width="800" height="533" class="img-responsive" alt="Image">
                                                    <div class="score"><span>7.5</span>Good</div>
                                                    <div class="short_info hotel">
                                                        From/Per night<span class="price"><sup>$</sup>59</span>
                                                    </div>
                                                    </a>
                                                </div>
                                                <div class="hotel_title">
                                                    <h3><strong>Park Hyatt</strong> Hotel</h3>
                                                    <div class="rating">
                                                        <i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star-empty"></i>
                                                    </div><!-- end rating -->
                                                    <div class="wishlist">
                                                        <a class="tooltip_flip tooltip-effect-1" href="#">+<span class="tooltip-content-flip"><span class="tooltip-back">Add to wishlist</span></span></a>
                                                    </div><!-- End wish list-->
                                                    <div onclick="onHtmlClick('Hotels', 0)" class="view_on_map">View on map</div>
                                                </div>
                                            </div><!-- End box tour -->
                                        </div><!-- End col-md-6 -->
                                        
                                        <div class="col-md-6 col-sm-6">
                                            <div class="hotel_container">
                                                <div class="ribbon_3 popular"><span>Popular</span></div>
                                                <div class="img_container">
                                                    <a href="single_hotel.html">
                                                    <img src="img/hotel_2.jpg"  width="800" height="533" class="img-responsive" alt="Image">
                                                    <div class="score"><span>9.0</span>Superb</div>
                                                    <div class="short_info hotel">
                                                        From/Per night<span class="price"><sup>$</sup>45</span>
                                                    </div>
                                                    </a>
                                                </div>
                                                <div class="hotel_title">
                                                    <h3><strong>Mariott</strong> Hotel</h3>
                                                    <div class="rating">
                                                        <i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star-empty"></i>
                                                    </div><!-- end rating -->
                                                    <div class="wishlist">
                                                        <a class="tooltip_flip tooltip-effect-1" href="#">+<span class="tooltip-content-flip"><span class="tooltip-back">Add to wishlist</span></span></a>
                                                    </div><!-- End wish list-->
                                                    <div onclick="onHtmlClick('Hotels', 1)" class="view_on_map">View on map</div>
                                                </div>
                                            </div><!-- End box -->
                                        </div><!-- End col-md-6 -->
                                        </div><!-- End row -->
                                        
                                        <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <div class="hotel_container">
                                                <div class="ribbon_3 popular"><span>Popular</span></div>
                                                <div class="img_container">
                                                    <a href="single_hotel.html">
                                                    <img src="img/hotel_3.jpg"  width="800" height="533" class="img-responsive" alt="Image">
                                                    <div class="score"><span>9.5</span>Superb</div>
                                                    <div class="short_info hotel">
                                                        From/Per night<span class="price"><sup>$</sup>39</span>
                                                    </div>
                                                    </a>
                                                </div>
                                                <div class="hotel_title">
                                                    <h3><strong>Lumiere</strong> Hotel</h3>
                                                    <div class="rating">
                                                        <i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star-empty"></i>
                                                    </div><!-- end rating -->
                                                    <div class="wishlist">
                                                        <a class="tooltip_flip tooltip-effect-1" href="#">+<span class="tooltip-content-flip"><span class="tooltip-back">Add to wishlist</span></span></a>
                                                    </div><!-- End wish list-->
                                                    <div onclick="onHtmlClick('Hotels', 2)" class="view_on_map">View on map</div>
                                                </div>
                                            </div><!-- End box -->
                                        </div><!-- End col-md-6 -->
                                        
                                        <div class="col-md-6 col-sm-6">
                                            <div class="hotel_container">
                                                <div class="ribbon_3 popular"><span>Popular</span></div>
                                                <div class="img_container">
                                                    <a href="single_hotel.html">
                                                    <img src="img/hotel_4.jpg" width="800" height="533" class="img-responsive" alt="Image">
                                                    <div class="score"><span>7.5</span>Good</div>
                                                    <div class="short_info hotel">
                                                            From/Per night<span class="price"><sup>$</sup>45</span>
                                                    </div>
                                                    </a>
                                                </div>
                                                <div class="hotel_title">
                                                    <h3><strong>Concorde</strong> Hotel</h3>
                                                    <div class="rating">
                                                        <i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star-empty"></i>
                                                    </div><!-- end rating -->
                                                    <div class="wishlist">
                                                        <a class="tooltip_flip tooltip-effect-1" href="javascript:void(0);">+<span class="tooltip-content-flip"><span class="tooltip-back">Add to wishlist</span></span></a>
                                                    </div><!-- End wish list-->
                                                    <div onclick="onHtmlClick('Hotels', 3)" class="view_on_map">View on map</div>
                                                </div>
                                            </div><!-- End box -->
                                        </div><!-- End col-md-6 -->
                                        </div><!-- End row -->
                                        
                                        <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <div class="hotel_container">
                                                <div class="ribbon_3"><span>Top rated</span></div>
                                                <div class="img_container">
                                                    <a href="single_hotel.html">
                                                    <img src="img/hotel_5.jpg"  width="800" height="533" class="img-responsive" alt="Image">
                                                    <div class="score"><span>8.0</span>Good</div>
                                                    <div class="short_info hotel">
                                                        From/Per night<span class="price"><sup>$</sup>39</span>
                                                    </div>
                                                    </a>
                                                </div>
                                                <div class="hotel_title">
                                                    <h3><strong>Louvre</strong> Hotel</h3>
                                                    <div class="rating">
                                                        <i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star-empty"></i>
                                                    </div><!-- end rating -->
                                                    <div class="wishlist">
                                                        <a class="tooltip_flip tooltip-effect-1" href="#">+<span class="tooltip-content-flip"><span class="tooltip-back">Add to wishlist</span></span></a>
                                                    </div><!-- End wish list-->
                                                    <div onclick="onHtmlClick('Hotels', 4)" class="view_on_map">View on map</div>
                                                </div>
                                            </div><!-- End box -->
                                        </div><!-- End col-md-6 -->
                                        
                                        <div class="col-md-6 col-sm-6">
                                            <div class="hotel_container">
                                                <div class="ribbon_3"><span>Top rated</span></div>
                                                <div class="img_container">
                                                    <a href="single_hotel.html">
                                                    <img src="img/hotel_6.jpg" width="800" height="533" class="img-responsive" alt="Image">
                                                    <div class="score"><span>8.5</span>Superb</div>
                                                    <div class="short_info hotel">
                                                            From/Per night<span class="price"><sup>$</sup>45</span>
                                                    </div>
                                                    </a>
                                                </div>
                                                <div class="hotel_title">
                                                    <h3><strong>Concorde</strong> Hotel</h3>
                                                    <div class="rating">
                                                        <i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star-empty"></i>
                                                    </div><!-- end rating -->
                                                    <div class="wishlist">
                                                        <a class="tooltip_flip tooltip-effect-1" href="javascript:void(0);">+<span class="tooltip-content-flip"><span class="tooltip-back">Add to wishlist</span></span></a>
                                                    </div><!-- End wish list-->
                                                    <div onclick="onHtmlClick('Hotels', 5)" class="view_on_map">View on map</div>
                                                </div>
                                            </div><!-- End box -->
                                        </div><!-- End col-md-6 -->
                                        </div><!-- End row -->
                                    
                                    <hr>
                                        
                                        <div class="text-center">
                                            <ul class="pagination">
                                                <li><a href="#">Prev</a></li>
                                                <li class="active"><a href="#">1</a></li>
                                                <li><a href="#">2</a></li>
                                                <li><a href="#">3</a></li>
                                                <li><a href="#">4</a></li>
                                                <li><a href="#">5</a></li>
                                                <li><a href="#">Next</a></li>
                                            </ul>
                                        </div><!-- end pagination-->
                                    </div>
                                    
                                    <div class="col-md-5 map-right hidden-sm hidden-xs">
                                        <div class="map" id="map"></div>
                                    </div>
                                    
                                </div><!-- End row-->
                            </div><!-- End container-fluid -->
                        </section>

                    </div>
                    <!-- /content -->
                </div>






	
	<footer >
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

<!-- searchbar側のJS -->
 <!-- Common scripts -->
<script src="js/jquery-2.2.4.min.js"></script>
<script src="js/common_scripts_min.js"></script>
<script src="js/functions.js"></script>

<script>
//Search bar
$(function () {
"use strict";
$("#searchDropdownBox").change(function(){
    var Search_Str = $(this).val();
    //replace search str in span value
    $("#nav-search-in-content").text(Search_Str);
  });
});
</script>

    <!-- tabs側のJS -->
    <!-- SLIDER REVOLUTION 4.x SCRIPTS  -->
    <script src="rs-plugin/js/jquery.themepunch.tools.min.js"></script>
    <script src="rs-plugin/js/jquery.themepunch.revolution.min.js"></script>
    <script src="js/revolution_func.js"></script>
    
    <script src="js/tabs.js"></script>
    <script>new CBPFWTabs( document.getElementById( 'tabs' ) );</script>

    <!-- all tour list側のjs -->
    <!-- Specific scripts -->
    <!-- Cat nav mobile -->
    <script src="js/cat_nav_mobile.js"></script>
    <script>
        $('#cat_nav').mobileMenu();
    </script>
    <!-- Check and radio inputs -->
    <script src="js/icheck.js"></script>
    <script>
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-grey',
            radioClass: 'iradio_square-grey'
        });
    </script>
    <!-- Map -->
    <script src="http://maps.googleapis.com/maps/api/js"></script>
    <script src="js/map.js"></script>
    <script src="js/infobox.js"></script>


    <!-- all-hotels-map-listingからの引用 -->
    <!-- Map -->
    <script src="http://maps.googleapis.com/maps/api/js"></script>
    <script src="js/map_listing_hotels.js"></script>
    <script src="js/infobox.js"></script>


    <!-- SLIDER REVOLUTION SCRIPTS  -->
    <script type="text/javascript" src="rev-slider-files/js/jquery.themepunch.tools.min.js"></script>
    <script type="text/javascript" src="rev-slider-files/js/jquery.themepunch.revolution.min.js"></script>
    <script type="text/javascript" src="rev-slider-files/js/extensions/revolution.extension.actions.min.js"></script>
    <script type="text/javascript" src="rev-slider-files/js/extensions/revolution.extension.carousel.min.js"></script>
    <script type="text/javascript" src="rev-slider-files/js/extensions/revolution.extension.kenburn.min.js"></script>
    <script type="text/javascript" src="rev-slider-files/js/extensions/revolution.extension.layeranimation.min.js"></script>
    <script type="text/javascript" src="rev-slider-files/js/extensions/revolution.extension.migration.min.js"></script>
    <script type="text/javascript" src="rev-slider-files/js/extensions/revolution.extension.navigation.min.js"></script>
    <script type="text/javascript" src="rev-slider-files/js/extensions/revolution.extension.parallax.min.js"></script>
    <script type="text/javascript" src="rev-slider-files/js/extensions/revolution.extension.slideanims.min.js"></script>
    <script type="text/javascript" src="rev-slider-files/js/extensions/revolution.extension.video.min.js"></script>
    <script type="text/javascript">
        var tpj=jQuery;
            var revapi13;
            tpj(document).ready(function() {
                if(tpj("#rev_slider_13_1").revolution == undefined){
                    revslider_showDoubleJqueryError("#rev_slider_13_1");
                }else{
                    revapi13 = tpj("#rev_slider_13_1").show().revolution({
                        sliderType:"carousel",
                        jsFileLocation: "rev-slider-files/js/",
                        sliderLayout:"fullwidth",
                        dottedOverlay:"none",
                        delay:9000,
                        navigation: {
                            keyboardNavigation:"off",
                            keyboard_direction: "horizontal",
                            mouseScrollNavigation:"off",
                             mouseScrollReverse:"default",
                            onHoverStop:"off",
                            touch:{
                                touchenabled:"on",
                                touchOnDesktop:"off",
                                swipe_threshold: 75,
                                swipe_min_touches: 1,
                                swipe_direction: "horizontal",
                                drag_block_vertical: false
                            }
                            ,
                            bullets: {
                                enable:true,
                                hide_onmobile:false,
                                style:"hermes",
                                hide_onleave:false,
                                direction:"horizontal",
                                h_align:"center",
                                v_align:"bottom",
                                h_offset:0,
                                v_offset:20,
                                space:5,
                                tmp:''
                            }
                        },
                        carousel: {
                            horizontal_align: "center",
                            vertical_align: "center",
                            fadeout: "on",
                            vary_fade: "on",
                            maxVisibleItems: 3,
                            infinity: "on",
                            space: 0,
                            stretch: "off",
                             showLayersAllTime: "off",
                             easing: "Power3.easeInOut",
                             speed: "800"
                        },
                        responsiveLevels:[1240,1024,778,778],
                        visibilityLevels:[1240,1024,778,778],
                        gridwidth:[800,640,480,480],
                        gridheight:[720,720,480,360],
                        lazyType:"none",
                        parallax: {
                            type:"scroll",
                            origo:"enterpoint",
                            speed:400,
                            levels:[5,10,15,20,25,30,35,40,45,50,47,48,49,50,51,55],
                        },
                        shadow:0,
                        spinner:"off",
                        stopLoop:"on",
                        stopAfterLoops:0,
                        stopAtSlide:1,
                        shuffle:"off",
                        autoHeight:"off",
                        disableProgressBar:"on",
                        hideThumbsOnMobile:"off",
                        hideSliderAtLimit:0,
                        hideCaptionAtLimit:0,
                        hideAllCaptionAtLilmit:0,
                        debugMode:false,
                        fallbacks: {
                            simplifyAll:"off",
                            nextSlideOnWindowFocus:"off",
                            disableFocusListener:false,
                        }
                    });
                }
            }); /*ready*/
        </script>
    
    <script src="js/notify_func.js"></script>




  </body>
</html>