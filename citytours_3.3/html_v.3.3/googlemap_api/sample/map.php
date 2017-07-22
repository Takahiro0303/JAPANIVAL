<?php 

session_start();
require('../../../../common/dbconnect.php');
require('../../../../common/functions.php');

$sql = 'SELECT e_Lat,e_Lng FROM events WHERE event_id=1';
// $data = [$event_id];
$stmt = $dbh->prepare($sql);
$stmt->execute();
$record = $stmt->fetch(PDO::FETCH_ASSOC);

$e_lat = $record['e_Lat'];
$e_lng = $record['e_Lng'];


$sql = 'SELECT e_address FROM events WHERE event_id=1';
// $data = [$event_id];
$stmt = $dbh->prepare($sql);
$stmt->execute();
$record = $stmt->fetch(PDO::FETCH_ASSOC);

$e_address = $record['e_address'];
// v($e_address);



 ?>


<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta charset="utf-8">
    <style type="text/css">
      html { height: 100% }
      body { height: 100%; margin: 0; padding: 0 }
      #map_canvas { height: 100% }
    </style>

    <!-- Google Maps APIを読み込む -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCzo1nDw_k6yNjo48_6UCYjLOwqF_QxEWE"></script>

    <!-- initialize()関数を定義 -->
    <script type="text/javascript">
      function initialize() {
        var lat = $('#keido').text();
        var lng = $('#ido').text();
        console.log(lat);
        console.log(lng);

        // 地図を表示する際のオプションを設定
        var map = new google.maps.Map( document.getElementById( 'map_canvas' ), {
          zoom: 15 ,  // ズーム値
          center: new google.maps.LatLng(lat , lng) , // 中心の位置座標
        } ) ;


        // var mapOptions = {
        //   center: new google.maps.LatLng(lat , lng),
        //   zoom: 15,
        //   mapTypeId: google.maps.MapTypeId.ROADMAP
        // };

        var marker = new google.maps.Marker( {
          map: map ,  // 地図
          position: new google.maps.LatLng(lat , lng) , // 位置座標
        } ) ;


        // Mapオブジェクトに地図表示要素情報とオプション情報を渡し、インスタンス生成
        // var map = new google.maps.Map(document.getElementById("map_canvas"),
        //     mapOptions);
      }
    </script>
  </head>

  <!-- ページが読み込まれたらinitialize()関数を実行 -->
  <body onload="initialize()">
    <!-- <form>
      <input type="text" value="東京スカイツリー" id="address">
      <input type="button" value="地図検索" id="button">
    </form>
 -->
    <div id="keido" style="display: none;">
    <?php echo htmlspecialchars($e_lat);?>
     </div>

     <div id="ido" style="display: none;">
     <?php echo htmlspecialchars($e_lng);?>
     </div>

     <div id="address" style="display: none;">
     <?php echo htmlspecialchars($e_address);?>
     </div>

    <!-- 地図を表示させる要素。widthとheightを必ず指定する。 -->
    <div id="map_canvas" style="width:600px; height:500px"></div>

    
    <!-- JavaScriptの読み込み -->
    <script src="../js/jquery-3.1.1.js"></script>
    <script src="../js/jquery-migrate-1.4.1.js"></script>

    <script src="geocode.js"></script>
    <script>

      // // ボタンに指定したid要素を取得
      // var button = document.getElementById("button");

      // // ボタンが押された時の処理
      // button.onclick = function() {
        var jyuusho = $('#address').text();
        console.log(jyuusho);
        
      //   // フォームに入力された住所情報を取得
        var address = jyuusho;
        // 取得した住所を引数に指定してcodeAddress()関数を実行
        codeAddress(address);

      // }
    </script>

  </body>

</html>