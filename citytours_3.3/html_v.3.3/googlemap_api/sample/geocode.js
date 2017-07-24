function codeAddress(address) {

  // google.maps.Geocoder()コンストラクタのインスタンスを生成
  var geocoder = new google.maps.Geocoder();

  // // 地図表示に関するオプション
  // var mapOptions = {
  //   zoom: 18,
  //   mapTypeId: google.maps.MapTypeId.ROADMAP,
  //   // マウスホイールによるズーム操作を無効
  //   scrollwheel: false
  // };

  // // 地図を表示させるインスタンスを生成
  // var map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);

  // geocoder.geocode()メソッドを実行 
  geocoder.geocode( { 'address': address}, function(results, status) {

    // ジオコーディングが成功した場合
    if (status == google.maps.GeocoderStatus.OK) {
      alert( results[ 0 ].geometry.location );
      // lat longの変数を作る





      
      // google.maps.Map()コンストラクタに定義されているsetCenter()メソッドで
      // 変換した緯度・経度情報を地図の中心に表示
      // map.setCenter(results[0].geometry.location);

      // // 地図上に目印となるマーカーを設定います。
      // // google.maps.Marker()コンストラクタにマーカーを設置するMapオブジェクトと
      // // 変換した緯度・経度情報を渡してインスタンスを生成
      // // →マーカー詳細
      // var marker = new google.maps.Marker({
      //   map: map,
      //   position: results[0].geometry.location
      // });


    // ジオコーディングが成功しなかった場合
    } else {
      console.log('Geocode was not successful for the following reason: ' + status);
    }
    
  });

}