// alert("modal_register_user_ajax.js"); 
$(document).ready(function(){
  // alert("modal_register_user_ajax.js"); 
  $('#register_request_button_c').click(function(){
      console.log('click');
  //ajax処理

    var request_category_id = $('#request_category_id').val();
    var event_id = $('#modal_request_event_id').val();

    console.log(request_category_id);
    console.log(event_id);

    //POST送信するデータをJS側で取得
    var request_data = {  
                      request_category_id: request_category_id,
                      event_id: event_id
                    };
    // var tweet_id_data = {tweet_id : tweet_id, like_data: like_data};

    //ajax通信処理
    //done →処理が成功した時に呼ばれる
    //fail →処理が失敗した時に呼ばれる

    $.ajax({
      type: "POST",
      url: "modal_register_request_ajax.php",
      data: request_data

    }).done(function(result){
      console.log('ajax成功');
      console.log(result); //画像表示されない
      var errors = JSON.parse(result);
      console.log(errors);

      if (errors['request_category_id'] == 'blank') {
        $('.error_request_category_id').text('リクエストカテゴリーを選んで下さい。');
      }else if (errors['request_category_id'] == 'existed') {
        $('.error_request_category_id').text('そのリクエストは既に登録されています。');
      }else if (errors['request_category_id'] == '') {
        $('.error_request_category_id').text('');

        $('#myRequest').modal('hide');        // 3
        $('#myRequest_confirm').modal();


        $('#confirm_request').text(comment);
      }

    }).fail(function(result){
      console.log('ajax失敗');

    });
  });

  // 確認モーダルでの登録ボタン押下
  $('#register_user_button_r').click(function(){
    console.log('click');

    var r_u_data_c = {  
                      nick_name: $('#r_u_nick_name_s').text(), 
                      email: $('#r_u_email_s').text(), 
                      password: $('#r_u_password_s').val(), 
                      // confirm_password: $('#r_u_confirm_password_s').text(),
                      nationality: $('#r_u_nationality_s').text(),
                      gender: $('#r_u_gender_s').text(),
                      japanese_level: $('#r_u_japanese_level_s').text(), 
                      comment: $('#r_u_comment_s').text(), 
                      pic_path: 'a',
                      db_register: 'on'
                    };

    $.ajax({
      type: "POST",
      url: "modal_register_user_ajax.php",
      data: r_u_data_c

    }).done(function(result){
      console.log('ajax成功');
      // console.log(result);
      // var errors = JSON.parse(result);
      // console.log(errors);
      $('#modal_register_user_confirm').modal('hide');        // 3
      $('#modal_register_user_result').modal();


    }).fail(function(result){
      console.log('ajax失敗');

    });
  });



  // 確認モーダルでの戻るボタン押下
  $('#register_user_button_b').click(function(){
    console.log('click');
    $('#modal_register_user_confirm').modal('hide');
    $('#modal_register_user').modal();

  });

  // 登録完了通知モーダルでのサインインボタン押下
  $('#signin_modal_button').click(function(){
    console.log('click');
    $('#modal_register_user_result').modal('hide');
    $('#modal_login').modal();

  });

});