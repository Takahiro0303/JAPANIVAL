// alert("modal_register_user_ajax.js"); 
$(document).ready(function(){
  // alert("modal_register_user_ajax.js"); 
  $('#register_user_button_c').click(function(){
      console.log('click');
  //ajax処理

    var nick_name = $('#r_u_nick_name').val();
    var email = $('#r_u_email').val();
    var password = $('#r_u_password').val();
    var confirm_password = $('#r_u_confirm_password').val();
    var nationality = $('#r_u_nationality').val();
    var gender = $('#r_u_gender').val();
    var japanese_level = $('#r_u_japanese_level').val();
    var comment = $('#r_u_comment').val();
    var pic_path = $('#r_u_pic_path').val();

    console.log(nick_name);
    console.log(email);
    console.log(password);
    console.log(confirm_password);
    console.log(nationality);
    console.log(gender);
    console.log(japanese_level);
    console.log(comment);
    console.log(pic_path);

    //POST送信するデータをJS側で取得
    var r_u_data = {  
                      nick_name: nick_name, 
                      email: email, 
                      password: password, 
                      confirm_password: confirm_password,
                      nationality: nationality, 
                      gender: gender,
                      japanese_level: japanese_level, 
                      comment: comment, 
                      pic_path: pic_path
                    };
    // var tweet_id_data = {tweet_id : tweet_id, like_data: like_data};

    //ajax通信処理
    //done →処理が成功した時に呼ばれる
    //fail →処理が失敗した時に呼ばれる

    $.ajax({
      type: "POST",
      url: "modal_register_user_ajax.php",
      data: r_u_data

    }).done(function(result){
      console.log('ajax成功');
      console.log(result); //画像表示されない
      var errors = JSON.parse(result);
      console.log(errors);

      }).fail(function(XMLHttpRequest, textStatus, errorThrown){
    console.log(XMLHttpRequest.status);
    console.log(textStatus);
    console.log(errorThrown);




      if (errors['nick_name'] == 'blank') {
        $('.error_nick_name').text('ユーザー名を入力してください。');
      }else if(errors['nick_name'] == ''){
        $('.error_nick_name').text('');
      }

      if (errors['email'] == 'blank') {
        $('.error_email').text('メールアドレスを入力してください。');
      }else if (errors['email'] == 'duplicate') {
        $('.error_email').text('そのメールアドレスは既に登録されています。');
      }else if (errors['email'] == '') {
        $('.error_email').text('');
      }

      if (errors['password'] == 'blank') {
        $('.error_password').text('パスワードを入力してください。');
      }else if (errors['password'] == 'length') {
        $('.error_password').text('パスワードは6文字以上で入力してください。');
      }else if (errors['password'] == '') {
        $('.error_password').text('');
      }

      if (errors['confirm_password'] == 'blank') {
        $('.error_confirm_password').text('確認用パスワードを入力してください。');
      }else if (errors['confirm_password'] == 'wrong') {
        $('.error_confirm_password').text('パスワードが一致しません。');
      }else if (errors['confirm_password'] == '') {
        $('.error_confirm_password').text('');
      }


      // for(key in customers){
      //   alert(key + "さんの番号は、" + customers[key] + "です。") ;
      // }
      var b = 0;
      for(key in errors){
        if (errors[key] != ''){ 
          b += 1;
        }
      }

      if (b == 0) {
          var password_show = ''; 
          for (var i = 0; i < password.length; i++) {
            password_show += "*";
          }
        
          // $('body').removeClass('modal-open'); // 1
          // $('.modal-backdrop').remove();       // 2
          $('#modal_register_user').modal('hide');        // 3
          $('#modal_register_user_confirm').modal();

          // 確認用モーダルの内容
          $('#r_u_nick_name_s').text(nick_name);
          $('#r_u_email_s').text(email);
          $('#r_u_password_s_a').text(password_show);
          $('#r_u_password_s').val(password);
          $('#r_u_nationality_s').text(nationality);
          $('#r_u_gender_s').text(gender);
          $('#r_u_japanese_level_s').text(japanese_level);
          $('#r_u_comment_s').text(comment);
        
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