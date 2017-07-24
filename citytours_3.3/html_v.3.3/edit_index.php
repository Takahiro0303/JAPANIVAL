<?php 
session_start();
require('../../common/dbconnect.php');
require('../../common/functions.php');
// require('../../common/auth.php');

$login_user = get_login_user($dbh);

$sql = 'SELECT * FROM events WHERE 1 ORDER BY e_start_date DESC;';
$stmt = $dbh->prepare($sql);
$stmt->execute();
while ($record = $stmt->fetch(PDO::FETCH_ASSOC)) {
   $records[] = $record;
}

//全イベント数のカウント
$sql = 'SELECT COUNT(*) AS total FROM events WHERE 1';
$stmt = $dbh->prepare($sql);
$stmt->execute();
$all_event_count = $stmt->fetch(PDO::FETCH_ASSOC);

//event_categoriesのカラム数をカウント
$sql = 'SELECT COUNT(*) AS total FROM event_categories WHERE 1';
$stmt = $dbh->prepare($sql);
$stmt->execute();
$event_category_count = $stmt->fetch(PDO::FETCH_ASSOC);

for ($i=1; $i <= $event_category_count['total']; $i++) { 
    $sql = 'SELECT COUNT(*) AS total FROM event_connects WHERE e_category_id=?';
    $data = [$i];
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    $category_count_total[$i] = $stmt->fetch(PDO::FETCH_ASSOC);
}


// $sql = 'SELECT * FROM events, event_connects, event_categories 
//         WHERE   events.event_id = event_connects.event_id
//         AND     event_connects.e_category_id = event_categories.e_category_id';
// $stmt = $dbh->prepare($sql);
// $stmt->execute();
// while ($record = $stmt->fetch(PDO::FETCH_ASSOC)) {
//    $records[] = $record;
// }


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
            font-weight: 700;
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

    <!-- header.phpのrequire -->
    <?php require('header.php');  ?>

	<section id="hero">
        <!-- Slider -->
        <div id="rev_slider_13_1_wrapper" class="rev_slider_wrapper fullwidthbanner-container" data-alias="highlight-carousel1" data-source="gallery" style="margin:0px auto;background:#000000;padding:0px;margin-top:0px;margin-bottom:0px;">
            <!-- START REVOLUTION SLIDER 5.4.1 fullwidth mode -->
            <div id="rev_slider_13_1" class="rev_slider fullwidthabanner" style="display:none;" data-version="5.4.1">
                <ul>
                    <!-- SLIDE  -->
                    <li data-index="rs-30" data-transition="slideoverhorizontal" data-slotamount="7" data-hideafterloop="0" data-hideslideonmobile="off" data-easein="default" data-easeout="default" data-masterspeed="1500" data-thumb="rev-slider-files/assets/100x50_newspaper_bg1.jpg" data-rotate="0" data-fstransition="fade" data-fsmasterspeed="1000" data-fsslotamount="7" data-saveperformance="off" data-title="Discover" data-param1="" data-param2="" data-param3="" data-param4="" data-param5="" data-param6="" data-param7="" data-param8="" data-param9="" data-param10="" data-description="">
                        <!-- MAIN IMAGE -->
                        <img src="rev-slider-files/assets/nebuta.jpg" alt="" data-bgposition="center bottom" data-bgfit="cover" data-bgrepeat="no-repeat" data-bgparallax="10" class="rev-slidebg" data-no-retina>
                        <!-- <img src="rev-slider-files/assets/newspaper_bg1.jpg" alt="" data-bgposition="center bottom" data-bgfit="cover" data-bgrepeat="no-repeat" data-bgparallax="10" class="rev-slidebg" data-no-retina> -->
                        <!-- LAYERS -->

                        <!-- LAYER NR. 1 -->
                        <div class="tp-caption News-Title   tp-resizeme" id="slide-30-layer-1" data-x="['left','left','left','left']" data-hoffset="['80','80','40','40']" data-y="['top','top','top','top']" data-voffset="['450','450','274','274']" data-fontsize="['65','65','50','50']" data-lineheight="['60','60','50','50']" data-width="364" data-height="133" data-whitespace="normal" data-type="text" data-responsive_offset="on" data-frames='[{"delay":500,"speed":1500,"frame":"0","from":"y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":1000,"frame":"999","to":"y:[100%];","mask":"x:inherit;y:inherit;s:inherit;e:inherit;","ease":"nothing"}]' data-textAlign="['left','left','left','left']" data-paddingtop="[0,0,0,0]" data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]" style="z-index: 5; min-width: 364px; max-width: 364px; max-width: 133px; max-width: 133px; white-space: normal; font-size: 65px;font-family:Montserrat;">Nebuta Matsuri </div>

                        <!-- LAYER NR. 2 -->
                        <div class="tp-caption   tp-resizeme" id="slide-30-layer-2" data-x="['left','left','left','left']" data-hoffset="['80','80','40','40']" data-y="['top','top','top','top']" data-voffset="['587','587','382','382']" data-width="none" data-height="none" data-whitespace="nowrap" data-type="image" data-responsive_offset="on" data-frames='[{"delay":500,"speed":1500,"frame":"0","from":"x:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":1000,"frame":"999","to":"x:[100%];","mask":"x:inherit;y:inherit;s:inherit;e:inherit;","ease":"Power3.easeInOut"}]' data-textAlign="['left','left','left','left']" data-paddingtop="[0,0,0,0]" data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]" style="z-index: 6;"><img src="rev-slider-files/assets/bluebar.png" alt="" data-ww="['350px','350px','350px','350px']" data-hh="['4px','4px','4px','4px']" data-no-retina> </div>

                        <!-- LAYER NR. 3 -->
                        <div class="tp-caption News-Subtitle   tp-resizeme" id="slide-30-layer-3" data-x="['left','left','left','left']" data-hoffset="['81','81','41','41']" data-y="['top','top','top','top']" data-voffset="['605','605','401','401']" data-width="none" data-height="none" data-whitespace="nowrap" data-type="text" data-responsive_offset="on" data-frames='[{"delay":500,"speed":1500,"frame":"0","from":"y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":1000,"frame":"999","to":"y:[100%];","mask":"x:inherit;y:inherit;s:inherit;e:inherit;","ease":"nothing"},{"frame":"hover","speed":"300","ease":"Power3.easeInOut","to":"o:1;rX:0;rY:0;rZ:0;z:0;","style":"c:rgba(255, 255, 255, 0.65);br:0 0 0px 0;"}]' data-textAlign="['left','left','left','left']" data-paddingtop="[0,0,0,0]" data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]" style="z-index: 7; white-space: nowrap;cursor:pointer;">@Aomori</div>

                        <!-- LAYER NR. 4 -->
                        <div class="tp-caption -   tp-resizeme" id="slide-30-layer-4" data-x="['left','left','left','left']" data-hoffset="['423','423','383','383']" data-y="['top','top','top','top']" data-voffset="['607','607','403','403']" data-width="none" data-height="none" data-whitespace="nowrap" data-type="text" data-responsive_offset="on" data-frames='[{"delay":500,"speed":1500,"frame":"0","from":"x:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":1000,"frame":"999","to":"x:[100%];","mask":"x:inherit;y:inherit;s:inherit;e:inherit;","ease":"Power3.easeInOut"}]' data-textAlign="['left','left','left','left']" data-paddingtop="[0,0,0,0]" data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]" style="z-index: 8; white-space: nowrap; font-size: 20px; line-height: 22px; font-weight: 400; color: rgba(0,210,255,1);"><!-- <i class="fa-icon-caret-right"></i> --> </div>
                    </li>
                    <!-- SLIDE  -->
                    <li data-index="rs-31" data-transition="slideoverhorizontal" data-slotamount="7" data-hideafterloop="0" data-hideslideonmobile="off" data-easein="default" data-easeout="default" data-masterspeed="1500" data-thumb="assets/100x50_newspaper_bg3.jpg" data-rotate="0" data-saveperformance="off" data-title="Beach" data-param1="" data-param2="" data-param3="" data-param4="" data-param5="" data-param6="" data-param7="" data-param8="" data-param9="" data-param10="" data-description="">
                        <!-- MAIN IMAGE -->
                        <img src="rev-slider-files/assets/awaodori.jpg" alt="" data-bgposition="center bottom" data-bgfit="cover" data-bgrepeat="no-repeat" data-bgparallax="10" class="rev-slidebg" data-no-retina>
                        <!-- <img src="rev-slider-files/assets/newspaper_bg3.jpg" alt="" data-bgposition="center bottom" data-bgfit="cover" data-bgrepeat="no-repeat" data-bgparallax="10" class="rev-slidebg" data-no-retina> -->
                        <!-- LAYERS -->

                        <!-- LAYER NR. 5 -->
                        <div class="tp-caption News-Title   tp-resizeme" id="slide-31-layer-1" data-x="['left','left','left','left']" data-hoffset="['80','80','40','40']" data-y="['top','top','top','top']" data-voffset="['450','450','270','270']" data-fontsize="['70','70','50','50']" data-lineheight="['60','60','50','50']" data-width="['397','397','297','297']" data-height="none" data-whitespace="normal" data-type="text" data-responsive_offset="on" data-frames='[{"delay":500,"speed":1500,"frame":"0","from":"y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":1000,"frame":"999","to":"y:[100%];","mask":"x:inherit;y:inherit;s:inherit;e:inherit;","ease":"nothing"}]' data-textAlign="['left','left','left','left']" data-paddingtop="[0,0,0,0]" data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]" style="z-index: 5; min-width: 397px; max-width: 397px; white-space: normal; color: #FF6666;font-family:Montserrat;">Awa
                            <br>Odori</div>

                        <!-- LAYER NR. 6 -->
                        <div class="tp-caption   tp-resizeme" id="slide-31-layer-2" data-x="['left','left','left','left']" data-hoffset="['80','80','40','40']" data-y="['top','top','top','top']" data-voffset="['587','587','382','382']" data-width="none" data-height="none" data-whitespace="nowrap" data-type="image" data-responsive_offset="on" data-frames='[{"delay":500,"speed":1500,"frame":"0","from":"x:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":1000,"frame":"999","to":"x:[100%];","mask":"x:inherit;y:inherit;s:inherit;e:inherit;","ease":"Power3.easeInOut"}]' data-textAlign="['left','left','left','left']" data-paddingtop="[0,0,0,0]" data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]" style="z-index: 6;"><img src="rev-slider-files/assets/bluebar.png" alt="" data-ww="" data-hh="" data-no-retina> </div>

                        <!-- LAYER NR. 7 -->
                        <div class="tp-caption News-Subtitle   tp-resizeme" id="slide-31-layer-3" data-x="['left','left','left','left']" data-hoffset="['81','81','41','41']" data-y="['top','top','top','top']" data-voffset="['605','605','401','401']" data-width="none" data-height="none" data-whitespace="nowrap" data-type="text" data-responsive_offset="on" data-frames='[{"delay":500,"speed":1500,"frame":"0","from":"y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":1000,"frame":"999","to":"y:[100%];","mask":"x:inherit;y:inherit;s:inherit;e:inherit;","ease":"nothing"},{"frame":"hover","speed":"300","ease":"Power3.easeInOut","to":"o:1;rX:0;rY:0;rZ:0;z:0;","style":"c:rgba(0, 0, 0, 0.65);br:0 0 0px 0;"}]' data-textAlign="['left','left','left','left']" data-paddingtop="[0,0,0,0]" data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]" style="z-index: 7; white-space: nowrap; color: #FF6666;cursor:pointer;">@Tokushima</div>

                        <!-- LAYER NR. 8 -->
                        <div class="tp-caption -   tp-resizeme" id="slide-31-layer-4" data-x="['left','left','left','left']" data-hoffset="['423','423','383','383']" data-y="['top','top','top','top']" data-voffset="['607','607','403','403']" data-width="none" data-height="none" data-whitespace="nowrap" data-type="text" data-responsive_offset="on" data-frames='[{"delay":500,"speed":1500,"frame":"0","from":"x:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":1000,"frame":"999","to":"x:[100%];","mask":"x:inherit;y:inherit;s:inherit;e:inherit;","ease":"Power3.easeInOut"}]' data-textAlign="['left','left','left','left']" data-paddingtop="[0,0,0,0]" data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]" style="z-index: 8; white-space: nowrap; font-size: 20px; line-height: 22px; font-weight: 400; color: rgba(0,210,255,1);"><!-- <i class="fa-icon-caret-right"></i> --> </div>
                    </li>
                    <!-- SLIDE  -->
                    <li data-index="rs-32" data-transition="slideoverhorizontal" data-slotamount="7" data-hideafterloop="0" data-hideslideonmobile="off" data-easein="default" data-easeout="default" data-masterspeed="1500" data-thumb="assets/100x50_newspaper_bg2.jpg" data-rotate="0" data-saveperformance="off" data-title="Trip" data-param1="" data-param2="" data-param3="" data-param4="" data-param5="" data-param6="" data-param7="" data-param8="" data-param9="" data-param10="" data-description="">
                        <!-- MAIN IMAGE -->
                        <img src="rev-slider-files/assets/kokuragion.jpeg" alt="" data-bgposition="center bottom" data-bgfit="cover" data-bgrepeat="no-repeat" data-bgparallax="10" class="rev-slidebg" data-no-retina>
                        <!-- LAYERS -->

                        <!-- LAYER NR. 9 -->
                        <div class="tp-caption News-Title   tp-resizeme" id="slide-32-layer-1" data-x="['left','left','left','left']" data-hoffset="['80','80','40','40']" data-y="['top','top','top','top']" data-voffset="['450','450','269','269']" data-fontsize="['70','70','50','50']" data-lineheight="['60','60','50','50']" data-width="364" data-height="133" data-whitespace="normal" data-type="text" data-responsive_offset="on" data-frames='[{"delay":500,"speed":1500,"frame":"0","from":"y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":1000,"frame":"999","to":"y:[100%];","mask":"x:inherit;y:inherit;s:inherit;e:inherit;","ease":"nothing"}]' data-textAlign="['left','left','left','left']" data-paddingtop="[0,0,0,0]" data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]" style="z-index: 5; min-width: 364px; max-width: 364px; max-width: 133px; max-width: 133px; white-space: normal;font-family:Montserrat;">Kokura Gion</div>

                        <!-- LAYER NR. 10 -->
                        <div class="tp-caption   tp-resizeme" id="slide-32-layer-2" data-x="['left','left','left','left']" data-hoffset="['80','80','40','40']" data-y="['top','top','top','top']" data-voffset="['587','587','382','382']" data-width="none" data-height="none" data-whitespace="nowrap" data-type="image" data-responsive_offset="on" data-frames='[{"delay":500,"speed":1500,"frame":"0","from":"x:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":1000,"frame":"999","to":"x:[100%];","mask":"x:inherit;y:inherit;s:inherit;e:inherit;","ease":"Power3.easeInOut"}]' data-textAlign="['left','left','left','left']" data-paddingtop="[0,0,0,0]" data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]" style="z-index: 6;"><img src="rev-slider-files/assets/bluebar.png" alt="" data-ww="" data-hh="" data-no-retina> </div>

                        <!-- LAYER NR. 11 -->
                        <div class="tp-caption News-Subtitle   tp-resizeme" id="slide-32-layer-3" data-x="['left','left','left','left']" data-hoffset="['81','81','41','41']" data-y="['top','top','top','top']" data-voffset="['605','605','401','401']" data-width="none" data-height="none" data-whitespace="nowrap" data-type="text" data-responsive_offset="on" data-frames='[{"delay":500,"speed":1500,"frame":"0","from":"y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":1000,"frame":"999","to":"y:[100%];","mask":"x:inherit;y:inherit;s:inherit;e:inherit;","ease":"nothing"},{"frame":"hover","speed":"300","ease":"Power3.easeInOut","to":"o:1;rX:0;rY:0;rZ:0;z:0;","style":"c:rgba(255, 255, 255, 0.65);br:0 0 0px 0;"}]' data-textAlign="['left','left','left','left']" data-paddingtop="[0,0,0,0]" data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]" style="z-index: 7; white-space: nowrap;cursor:pointer;">@Fukuoka</div>

                        <!-- LAYER NR. 12 -->
                        <div class="tp-caption -   tp-resizeme" id="slide-32-layer-4" data-x="['left','left','left','left']" data-hoffset="['423','423','383','383']" data-y="['top','top','top','top']" data-voffset="['607','607','403','403']" data-width="none" data-height="none" data-whitespace="nowrap" data-type="text" data-responsive_offset="on" data-frames='[{"delay":500,"speed":1500,"frame":"0","from":"x:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":1000,"frame":"999","to":"x:[100%];","mask":"x:inherit;y:inherit;s:inherit;e:inherit;","ease":"Power3.easeInOut"}]' data-textAlign="['left','left','left','left']" data-paddingtop="[0,0,0,0]" data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]" style="z-index: 8; white-space: nowrap; font-size: 20px; line-height: 22px; font-weight: 400; color: rgba(0,210,255,1);"><!-- <i class="fa-icon-caret-right"></i> --> </div>
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
                                <li><a href="#section-1" ><i class="icon_set_1_icon-39"></i><span>Pick Up!!</span></a></li>
                                <li><a href="#section-2" ><i class="icon_set_1_icon-42"></i><span>Refine Search</span></a></li>
                                <li><a href="#section-3" ><i class="icon_set_1_icon-37"></i><span>Map Search</span></a></li>
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
<!--             <div class="main_title">
                <h2><span>Pick UP!!!</span></h2>
            </div> -->

            <div class="row">

                <?php for($i=0;$i < count($records); $i++) { ?>
                    <?php


                        $sql = 'SELECT * FROM event_pics WHERE event_id=? limit 1';

                        $data = [$records[$i]['event_id']];
                        $stmt = $dbh->prepare($sql);
                        $stmt->execute($data);
                        $event_pic = $stmt->fetch(PDO::FETCH_ASSOC);

                        $starts = explode('-', $records[$i]['e_start_date']);
                        $ends = explode('-', $records[$i]['e_end_date']);

                        if ($starts[0] != $ends[0]) {
                            $duration = date('F d, Y', strtotime(implode('-', $starts))) .' - ' . date('F d, Y', strtotime(implode('-', $ends)));
                        } elseif($starts[1] != $ends[1]){
                            $duration = date('F d', strtotime(implode('-', $starts))) .' - ' . date('F d, Y', strtotime(implode('-', $ends)));
                        } elseif($starts[2] != $ends[2]){
                            $duration = date('F d', strtotime(implode('-', $starts))) .' - ' . date('d, Y', strtotime(implode('-', $ends)));
                        } else{
                            $duration = date('F d, Y', strtotime(implode('-', $starts)));
                        }


                        //join数カウント
                        $sql = 'SELECT COUNT(*) AS total FROM joins WHERE event_id=?';
                        $data = [$records[$i]['event_id']];
                        $stmt = $dbh->prepare($sql);
                        $stmt->execute($data);
                        $join_count_total = $stmt->fetch(PDO::FETCH_ASSOC);

                        //like数カウント
                        $sql = 'SELECT COUNT(*) AS total FROM likes WHERE event_id=?';
                        $data = [$records[$i]['event_id']];
                        $stmt = $dbh->prepare($sql);
                        $stmt->execute($data);
                        $like_count_total = $stmt->fetch(PDO::FETCH_ASSOC);
                    
                        //join済み判定の為のSQL
                        if (isset($login_user['user_id'])) {
                            $sql = 'SELECT COUNT(*) AS total FROM joins WHERE event_id=? AND user_id=?';
                            $data = [$records[$i]['event_id'], $login_user['user_id']];
                            $stmt = $dbh->prepare($sql);
                            $stmt->execute($data);
                            $join_count = $stmt->fetch(PDO::FETCH_ASSOC);

                            //like済み判定の為のSQL
                            $sql = 'SELECT COUNT(*) AS total FROM likes WHERE event_id=? AND user_id=?';
                            $data = [$records[$i]['event_id'], $login_user['user_id']];
                            $stmt = $dbh->prepare($sql);
                            $stmt->execute($data);
                            $like_count = $stmt->fetch(PDO::FETCH_ASSOC);
                        }
                    ?>

                    <div class="col-md-4 col-sm-6 wow zoomIn" data-wow-delay="0.1s">
                        <div class="tour_container">
                            <?php if (strtotime(date('Y-m-d')) > strtotime($records[$i]['e_end_date'])){ ?>
                                <div class="ribbon_3"><span>Past</span></div>
                            <?php } else if(strtotime(date('Y-m-d', strtotime('-2 day') )) < strtotime($records[$i]['created'])){ ?>
                                <div class="ribbon_3 popular"><span>New</span></div>
                            <?php }  ?>
                            <div class="img_container">
                                <a href="event_detail.php?event_id=<?php echo htmlspecialchars($records[$i]['event_id']); ?>">
                                    <img src="<?php echo htmlspecialchars($event_pic['e_pic_path']); ?>" class="img-responsive" alt="Image" style="width: 800px; height: 270px;">
                                    <div class="short_info">
                                        <span class="like_count">Like:<span class="like_count_change_<?php echo htmlspecialchars($records[$i]['event_id']); ?>"><?php echo $like_count_total['total']; ?></span></span> 
                                                                        
                                        <span class="join_count">Join:<span class="join_count_change_<?php echo htmlspecialchars($records[$i]['event_id']); ?>"><?php echo $join_count_total['total']; ?></span></span> 
                                     

                                    </div>
                                </a>
                            </div>
                            <div class="tour_title" style="padding-top: 8px; padding-bottom: 7px;">
                                <div class="row">
                                    <div class="col-md-8 col-sm-8 col-xs-8" style="margin-top: 5px;">
                                        <h3><strong><?php echo htmlspecialchars($records[$i]['e_name']); ?></strong></h3>
                                        <div><?php echo $duration; ?></div>
                                    </div>
                                    <!-- end rating -->
                                    <div  class="col-md-2 col-sm-2 col-xs-2" style="height: 40px; padding: 0px; margin-top: 2px; margin-left: -2px;">
                                        <?php if (isset($login_user['user_id'])): ?>
                                            <?php if ($join_count['total'] == '1'): ?>
                                            <div class="join_button_color error" >           
                                                <i class="icon_set_1_icon-30 join_button" style="font-size: 40px; cursor: pointer;"></i>
                                                <input type="hidden" class="event_id_join" name="event_id" value="<?php echo htmlspecialchars($records[$i]['event_id']); ?>">
                                                <input type="hidden" class="user_id_join" name="user_id" value="<?php echo htmlspecialchars($login_user['user_id']); ?>">
                                                <input type="hidden" class="join_or_not_<?php echo htmlspecialchars($records[$i]['event_id']); ?>" name="user_id" value="join">
                                            <?php else: ?>
                                            <div class="join_button_color" >  
                                                <i class="icon_set_1_icon-30 join_button" style="font-size: 40px; cursor: pointer;"></i>
                                                <input type="hidden" class="event_id_join" name="event_id" value="<?php echo htmlspecialchars($records[$i]['event_id']); ?>">
                                                <input type="hidden" class="user_id_join" name="user_id" value="<?php echo htmlspecialchars($login_user['user_id']); ?>">
                                                <input type="hidden" class="join_or_not_<?php echo htmlspecialchars($records[$i]['event_id']); ?>" name="user_id" value="unjoin">
                                            <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div  class="col-md-2 col-sm-2 col-xs-2" style="height: 40px; padding: 0px; margin-top: 5px; margin-left: -1px;">
                                        <?php if (isset($login_user['user_id'])): ?>
                                            <?php if ($like_count['total'] == '1'): ?>
                                            <div class="like_button_color error" >           
                                                <i class="icon_set_1_icon-82 like_button" style="font-size: 40px; cursor: pointer;"></i>
                                                <input type="hidden" class="event_id_like" name="event_id" value="<?php echo htmlspecialchars($records[$i]['event_id']); ?>">
                                                <input type="hidden" class="user_id_like" name="user_id" value="<?php echo htmlspecialchars($login_user['user_id']); ?>">
                                                <input type="hidden" class="like_or_not_<?php echo htmlspecialchars($records[$i]['event_id']); ?>" name="user_id" value="like">
                                            <?php else: ?>
                                            <div class="like_button_color" >  
                                                <i class="icon_set_1_icon-82 like_button" style="font-size: 40px; cursor: pointer;"></i>
                                                <input type="hidden" class="event_id_like" name="event_id" value="<?php echo htmlspecialchars($records[$i]['event_id']); ?>">
                                                <input type="hidden" class="user_id_like" name="user_id" value="<?php echo htmlspecialchars($login_user['user_id']); ?>">
                                                <input type="hidden" class="like_or_not_<?php echo htmlspecialchars($records[$i]['event_id']); ?>" name="user_id" value="unlike">
                                            <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <!-- End wish list-->
                                </div>
                            </div>
                        </div>
                        <!-- End box tour -->
                    </div>
                <?php } ?>
            </div>
            <!-- End row -->
            <img src="data:image/png;base64,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%E2%80%A6%E2%80%A6">
<!-- 
            <p class="text-center nopadding"> <a href="#" class="btn_1 medium">View all tours (144) </a>
            </p> -->
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
                                        <div class="cta filter">
                                            <ul id="cat_nav">
                                                <li><a class="all active" data-filter="all" href="#" role="button"><i class="icon_set_1_icon-51"></i>All festivals <span>(<?php echo $all_event_count['total']; ?>)</span></a>
                                                </li>
                                                <li><a data-filter="spring" href="#" role="button"><i class="icon_set_1_icon-3"></i>Spring<span>(<?php echo $category_count_total[1]['total']; ?>)</span></a>                                                                                                                    
                                                </li>
                                                <li><a data-filter="summer" href="#" role="button"><i class="icon_set_2_icon-110"></i>Summer<span>(<?php echo htmlspecialchars($category_count_total[2]['total']); ?>)</span></a>
                                                </li>
                                                <li><a data-filter="fall" href="#" role="button"><i class="icon-feather-1"></i>Fall<span>(<?php echo htmlspecialchars($category_count_total[3]['total']); ?>)</span></a>
                                                </li>
                                                <li><a data-filter="winter" href="#" role="button"><i class="icon-asterisk"></i>Winter<span>(<?php echo htmlspecialchars($category_count_total[4]['total']); ?>)</span></a>
                                                </li>
                                                <li><a data-filter="flower" href="#" role="button"><i class="icon-garden"></i>Flower<span>(<?php echo htmlspecialchars($category_count_total[5]['total']); ?>)</span></a>
                                                </li>
                                                <li><a data-filter="sakura" href="#" role="button"><i class="icon-leaf-1"></i>Sakura<span>(<?php echo htmlspecialchars($category_count_total[6]['total']); ?>)</span></a>
                                                </li>
                                                <li><a data-filter="food_drink" href="#" role="button"><i class="icon_set_3_restaurant-10"></i>Food/Drink<span>(<?php echo htmlspecialchars($category_count_total[7]['total']); ?>)</span></a>
                                                </li>
                                                <li><a data-filter="alcohol" href="#" role="button"><i class="icon_set_1_icon-15"></i>Alcohol<span>(<?php echo htmlspecialchars($category_count_total[8]['total']); ?>)</span></a>
                                                </li>
                                                <li><a data-filter="strange_festival" href="#" role="button"><i class="icon-question"></i>Strange Festival<span>(<?php echo htmlspecialchars($category_count_total[9]['total']); ?>)</span></a>
                                                </li>
                                                <li><a data-filter="50years_lasting" href="#" role="button"><i class="icon-angle-right"></i>50years Lasting<span>(<?php echo htmlspecialchars($category_count_total[10]['total']); ?>)</span></a>
                                                </li>
                                                <li><a data-filter="100years_lasting" href="#" role="button"><i class="icon-angle-double-right"></i>100years lasting<span>(<?php echo htmlspecialchars($category_count_total[11]['total']); ?>)</span></a>
                                                </li>
                                            </ul>
                                        </div>
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
                                    </aside>
                                    <!--End aside -->



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

                                    <div class="col-lg-9 col-md-9 boxes">
                                        <?php for($i=0;$i < count($records); $i++) { ?>
                                            <?php

                                                $sql = 'SELECT * FROM event_pics WHERE event_id=? limit 1';
                                                $data = [$records[$i]['event_id']];
                                                $stmt = $dbh->prepare($sql);
                                                $stmt->execute($data);
                                                $event_pic = $stmt->fetch(PDO::FETCH_ASSOC);

                                                $starts = explode('-', $records[$i]['e_start_date']);
                                                $ends = explode('-', $records[$i]['e_end_date']);

                                                if ($starts[0] != $ends[0]) {
                                                    $duration = date('F d, Y', strtotime(implode('-', $starts))) .' - ' . date('F d, Y', strtotime(implode('-', $ends)));
                                                } elseif($starts[1] != $ends[1]){
                                                    $duration = date('F d', strtotime(implode('-', $starts))) .' - ' . date('F d, Y', strtotime(implode('-', $ends)));
                                                } elseif($starts[2] != $ends[2]){
                                                    $duration = date('F d', strtotime(implode('-', $starts))) .' - ' . date('d, Y', strtotime(implode('-', $ends)));
                                                } else{
                                                    $duration = date('F d, Y', strtotime(implode('-', $starts)));
                                                }


                                                //join数カウント
                                                $sql = 'SELECT COUNT(*) AS total FROM joins WHERE event_id=?';
                                                $data = [$records[$i]['event_id']];
                                                $stmt = $dbh->prepare($sql);
                                                $stmt->execute($data);
                                                $join_count_total = $stmt->fetch(PDO::FETCH_ASSOC);

                                                //like数カウント
                                                $sql = 'SELECT COUNT(*) AS total FROM likes WHERE event_id=?';
                                                $data = [$records[$i]['event_id']];
                                                $stmt = $dbh->prepare($sql);
                                                $stmt->execute($data);
                                                $like_count_total = $stmt->fetch(PDO::FETCH_ASSOC);
                                                
                                                if (isset($login_user['user_id'])) {
                                                    //join済み判定の為のSQL
                                                    $sql = 'SELECT COUNT(*) AS total FROM joins WHERE event_id=? AND user_id=?';
                                                    $data = [$records[$i]['event_id'], $login_user['user_id']];
                                                    $stmt = $dbh->prepare($sql);
                                                    $stmt->execute($data);
                                                    $join_count = $stmt->fetch(PDO::FETCH_ASSOC);

                                                    //like済み判定の為のSQL
                                                    $sql = 'SELECT COUNT(*) AS total FROM likes WHERE event_id=? AND user_id=?';
                                                    $data = [$records[$i]['event_id'], $login_user['user_id']];
                                                    $stmt = $dbh->prepare($sql);
                                                    $stmt->execute($data);
                                                    $like_count = $stmt->fetch(PDO::FETCH_ASSOC);
                                                }

                                                //explanationの文字数制限
                                                $explanation_p = mb_strimwidth( $records[$i]['explanation'], 0, 200, "...", "UTF-8" );

                                                //イベントカテゴリー取得
                                                $sql = 'SELECT * FROM event_connects, event_categories
                                                        WHERE  event_connects.e_category_id = event_categories.e_category_id
                                                        AND event_connects.event_id=?';
                                                $data = [$records[$i]['event_id']];
                                                $stmt = $dbh->prepare($sql);
                                                $stmt->execute($data);
                                                $event_categories = '';
                                                while($event_category = $stmt->fetch(PDO::FETCH_ASSOC)){
                                                    $event_categories[] = $event_category; 
                                                }
                                            ?>

                                            <div class="strip_all_tour_list wow fadeIn" data-wow-delay="0.1s" data-category="<?php echo htmlspecialchars($event_categories[0]['e_category']); ?>" href="#">
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                                        <div class="ribbon_3 popular"><span>Popular</span>
                                                        </div>
                                                        <div class="wishlist">
                                                            <a class="tooltip_flip tooltip-effect-1" href="javascript:void(0);">+<span class="tooltip-content-flip"><span class="tooltip-back">Add to wishlist</span></span></a>
                                                        </div>
                                                        <div class="img_list">
                                                            <a href="event_detail.php?event_id=<?php echo htmlspecialchars($records[$i]['event_id']); ?>"><img src="<?php echo htmlspecialchars($event_pic['e_pic_path']); ?>" alt="Image">                                    
                                                                <div class="short_info"><i class="icon_set_1_icon-4"></i>Museums </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="clearfix visible-xs-block"></div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <?php  ?>
                                                        <div class="tour_list_desc" style="display: table-cell; vertical-align: middle;width: 100%;">
                                           <!--                  <div class="rating"><i class="icon-smile voted"></i><i class="icon-smile  voted"></i><i class="icon-smile  voted"></i><i class="icon-smile  voted"></i><i class="icon-smile"></i><small>(75)</small>
                                                            </div> -->
                                                            <h3 style="margin-bottom: 5px;"><strong><?php echo htmlspecialchars($records[$i]['e_name']); ?></strong></h3>
                                                            <p style="margin-bottom: 5px;"><?php echo htmlspecialchars($duration); ?></p>
                                                            <p style="margin-bottom: 8px;"><?php echo htmlspecialchars($explanation_p); ?></p>
                                                            <ul class="add_info">
<!--                                                                 <li>
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
                                                                </li> -->
                                                                <li>
                                                                    <div class="tooltip_styled tooltip-effect-4">
                                                                        <span class="tooltip-item"><i class="icon_set_1_icon-41"></i></span>
                                                                        <div class="tooltip-content">
                                                                            <h4>Address</h4>
                                                                            <strong>Address: </strong><?php echo htmlspecialchars($records[$i]['e_postal']); ?><?php echo htmlspecialchars($records[$i]['e_prefecture']); ?><?php echo htmlspecialchars($records[$i]['e_address']); ?>
                                                                            <br>
                                                                            <strong>Venue: </strong><?php echo htmlspecialchars($records[$i]['e_venue']); ?>
                                                                            <br>
                                                                        </div>
                                                                    </div>
                                                                </li>
<!--                                                                 <li>
                                                                    <div class="tooltip_styled tooltip-effect-4">
                                                                        <span class="tooltip-item"><i class="icon_set_1_icon-97"></i></span>
                                                                        <div class="tooltip-content">
                                                                            <h4>Languages</h4> English - French - Chinese - Russian - Italian
                                                                        </div>
                                                                    </div>
                                                                </li> -->
<!--                                                                 <li>
                                                                    <div class="tooltip_styled tooltip-effect-4">
                                                                        <span class="tooltip-item"><i class="icon_set_1_icon-27"></i></span>
                                                                        <div class="tooltip-content">
                                                                            <h4>Parking</h4> 1-3 Rue Elisée Reclus
                                                                            <br> 76 Rue du Général Leclerc
                                                                            <br> 8 Rue Caillaux 94923
                                                                            <br>
                                                                        </div>
                                                                    </div>
                                                                </li> -->
                                                                <li>
                                                                    <div class="tooltip_styled tooltip-effect-4">
                                                                        <span class="tooltip-item"><i class="icon_set_1_icon-25"></i></span>
                                                                        <div class="tooltip-content">
                                                                            <h4>Transport/Access</h4>
                                                                            <?php echo htmlspecialchars($records[$i]['e_access']); ?>
                                                                            
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 col-md-2 col-sm-2">
                                                        <div class="price_list">
                                                            <div><!-- sup>$</sup>39*<span class="normal_price_list">$99</span><small>*Per person</small> -->
                                                                <p><a href="event_detail.php?event_id=<?php echo htmlspecialchars($records[$i]['event_id']); ?>" class="btn_1">Details</a>
                                                                </p>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--End strip -->
                                        <?php } ?>





                                        <!--End strip -->

<!--                                         <hr>

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
                                        </div> -->
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

    <!-- フッター呼び出し -->
    <?php require('footer.php'); ?>

    <!-- モーダル・ログイン -->
    <?php require('modal_login.php'); ?>

    <!-- モーダル・ユーザー登録 -->
    <?php require('modal_register_user.php'); ?>

    <!-- モーダル・主催者登録 -->
    <?php require('modal_register_organizer.php'); ?>

	<div id="toTop"></div><!-- Back to top button -->
	



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
    <script src="js/modal_login_ajax.js"></script>
    <script src="js/modal_register_user_ajax.js"></script>
    <script src="js/modal_register_organizer_ajax.js"></script>
    <script src="js/join_ajax.js"></script>
    <script src="js/like_ajax.js"></script>
    <script src="js/refine_search.js"></script>
    <!-- 自作のJS -->
    <script src="js/custom.js"></script>
<!--     <script src="js/bootstrap.js"></script> -->





  </body>
</html>