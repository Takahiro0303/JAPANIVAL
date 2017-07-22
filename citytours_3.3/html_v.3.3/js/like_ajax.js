
$(document).ready(function(){

  $('.like_button').click(function(){
      console.log('click');
  //ajax処理

    var event_id = $(this).siblings('.event_id_like').val();
    var user_id = $(this).siblings('.user_id_like').val();
    var like_or_not =  $(this).siblings('.like_or_not_' + event_id).val();

    console.log(event_id);
    console.log(user_id);
    console.log(like_or_not);


    // POST送信するデータをJS側で取得
    var like_data = {  
                      event_id: event_id, 
                      user_id: user_id,
                      like_or_not: like_or_not
                    };
    // var tweet_id_data = {tweet_id : tweet_id, like_data: like_data};

    //ajax通信処理
    //done →処理が成功した時に呼ばれる
    //fail →処理が失敗した時に呼ばれる

    $.ajax({
      type: "POST",
      url: "like_ajax.php",
      data: like_data

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


});