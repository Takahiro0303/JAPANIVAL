// alert("modal_register_user_ajax.js"); 
$(document).ready(function(){
  // alert("modal_register_user_ajax.js"); 
  $('#register_news_button_c').click(function(){
      console.log('click');
  //ajax処理

    var news_input_title = $('#news_input_title').val();
    var news_input_comment = $('#news_input_comment').val();
    var event_id = $('#modal_news_event_id').val();

    console.log(news_input_title);
    console.log(news_input_comment);
    console.log(event_id);

    //POST送信するデータをJS側で取得
    var news_data = {  
                      news_input_title  : news_input_title,
                      news_input_comment: news_input_comment,
                      event_id: event_id
                    };

    $.ajax({
      type: "POST",
      url: "modal_register_news_ajax.php",
      data: news_data

    }).done(function(result){
      console.log('ajax成功');
      console.log(result); //画像表示されない
      var errors = JSON.parse(result);
      console.log(errors);

      if (errors['news_title'] == 'blank') {
        $('.error_news_title').text('タイトルを入力してください。');
      }

      if (errors['news_comment'] == 'blank') {
        $('.error_news_comment').text('コメントを入力してください。');
      }

      if (errors['news_title'] == '' && errors['news_comment'] == '' ) {
        $('#myNews').modal('hide');        // 3
        $('#myNews_confirm').modal();

        $('#confirm_news_title').text(news_input_title);
        $('#confirm_news_comment').text(news_input_comment);

      }

    }).fail(function(result){
      console.log('ajax失敗');

    });
  });

  // 確認モーダルでの登録ボタン押下
  $('#register_news_button_r').click(function(){
    console.log('click');

    var news_input_title = $('#news_input_title').val();
    var news_input_comment = $('#news_input_comment').val();
    var event_id = $('#modal_news_event_id').val();

    var r_u_data_c = {  
                      news_input_title  : news_input_title,
                      news_input_comment: news_input_comment,
                      event_id: event_id,
                      db_register: 'on'
                    };

    $.ajax({
      type: "POST",
      url: "modal_register_news_ajax.php",
      data: r_u_data_c

    }).done(function(result){
      console.log('ajax成功');
      // console.log(result);
      // var errors = JSON.parse(result);
      // console.log(errors);
      location.reload();


    }).fail(function(result){
      console.log('ajax失敗');

    });
  });



  // 確認モーダルでの戻るボタン押下
  $('#register_news_button_b').click(function(){
    console.log('click');
    $('#myNews_confirm').modal('hide');
    $('#myNews').modal();

  });

});