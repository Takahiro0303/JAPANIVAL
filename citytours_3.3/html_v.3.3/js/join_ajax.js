
$(document).ready(function(){

  $('.join_button').click(function(){
      console.log('click');
  //ajax処理

    var event_id = $(this).siblings('.event_id_join').val();
    var user_id = $(this).siblings('.user_id_join').val();
    var join_or_not =  $(this).siblings('.join_or_not_' + event_id).val();

    console.log(event_id);
    console.log(user_id);
    console.log(join_or_not);


    // POST送信するデータをJS側で取得
    var join_data = {  
                      event_id: event_id, 
                      user_id: user_id,
                      join_or_not: join_or_not
                    };
    // var tweet_id_data = {tweet_id : tweet_id, like_data: like_data};

    //ajax通信処理
    //done →処理が成功した時に呼ばれる
    //fail →処理が失敗した時に呼ばれる

    $.ajax({
      type: "POST",
      url: "join_ajax.php",
      data: join_data

    }).done(function(result){
      console.log('ajax成功');
      var joins = JSON.parse(result);
      console.log(joins);

        var event_id = joins['event_id'];

      if (joins['join_or_not'] == 'unjoin') {
        $('.join_or_not_' + event_id).val('join');
        $('.join_or_not_' + event_id).parent('.join_button_color').addClass('error');
      } else{
        $('.join_or_not_' + event_id).val('unjoin');
        $('.join_or_not_' + event_id).parent('.join_button_color').removeClass('error');
      }

      // 画面の書き換え
      // $('#like1').val('いいね！を取り消す');
      $('.join_count_change_' + event_id).text(joins['join_count']);


    }).fail(function(result){
      console.log('ajax失敗');

    });
  });

});