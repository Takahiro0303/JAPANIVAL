function codeAddress(address) {

  // google.maps.Geocoder()コンストラクタのインスタンスを生成
  var geocoder = new google.maps.Geocoder();


  // geocoder.geocode()メソッドを実行 
  geocoder.geocode( { 'address': address}, function(results, status) {

    // ジオコーディングが成功した場合
    if (status == google.maps.GeocoderStatus.OK) {
      alert( results[ 0 ].geometry.location );
      // lat longの変数を作る
      var map_data = results[ 0 ].geometry.location;


    // ジオコーディングが成功しなかった場合
    } else {
      console.log('Geocode was not successful for the following reason: ' + status);
    }

// POST送信するデータをJS側で取得
    var map_data = {
                      event_id: event_id,
                      lat: map_data.lat(),
                      lng: map_data.lng(),
                    };
    // var tweet_id_data = {tweet_id : tweet_id, like_data: like_data};

    //ajax通信処理
    //done →処理が成功した時に呼ばれる
    //fail →処理が失敗した時に呼ばれる

    $.ajax({
      type: "POST",
      url: "map_ajax.php",
      data: map_data

    }).done(function(result){
      console.log('ajax成功');
      var likes = JSON.parse(result);
      console.log(likes);

        var event_id = likes['event_id'];

      if (likes['like_or_not'] == 'unlike') {
        $('.like_or_not_' + event_id).val('like');
        $('.like_or_not_' + event_id).parent('.like_button_color').addClass('error');
      } else{
        $('.like_or_not_' + event_id).val('unlike');
        $('.like_or_not_' + event_id).parent('.like_button_color').removeClass('error');
      }

      // 画面の書き換え
      // $('#like1').val('いいね！を取り消す');
      $('.like_count_change_' + event_id).text(likes['like_count']);


    }).fail(function(result){
      console.log('ajax失敗');

    });
  });

}

