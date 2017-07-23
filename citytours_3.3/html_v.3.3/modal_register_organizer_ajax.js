
$(document).ready(function(){

  $('#register_organizer_button_c').click(function(){
      console.log('click');
  //ajax処理

    var o_name = $('#r_o_name').val();
    var o_f_name = $('#r_o_f_name').val();
    var o_postal = $('#r_o_postal').val();
    var o_pref = $('#r_o_pref').val();
    var o_address = $('#r_o_address').val();
    var o_tel = $('#r_o_tel').val();
    var o_email = $('#r_o_email').val();
    var o_password = $('#r_o_password').val();
    var o_confirm_password = $('#r_o_confirm_password').val();
    var o_comment = $('#r_o_comment').val();
    var o_pic_path = $('#r_o_pic_path').val();

    console.log(o_name);
    console.log(o_f_name);
    console.log(o_postal);
    console.log(o_pref);
    console.log(o_address);
    console.log(o_tel);
    console.log(o_email);
    console.log(o_password);
    console.log(o_confirm_password);
    console.log(o_comment);
    console.log(o_pic_path);

    //POST送信するデータをJS側で取得
    var r_o_data = {  
                      o_name: o_name, 
                      o_f_name: o_f_name, 
                      o_postal: o_postal, 
                      o_pref: o_pref, 
                      o_address: o_address, 
                      o_tel: o_tel, 
                      o_email: o_email,
                      o_password: o_password, 
                      o_confirm_password: o_confirm_password,
                      o_comment: o_comment, 
                      o_pic_path: o_pic_path
                    };
    // var tweet_id_data = {tweet_id : tweet_id, like_data: like_data};

    //ajax通信処理
    //done →処理が成功した時に呼ばれる
    //fail →処理が失敗した時に呼ばれる

    $.ajax({
      type: "POST",
      url: "modal_register_organizer_ajax.php",
      data: r_o_data

    }).done(function(result){
      console.log('ajax成功');
      console.log(result);
      var errors = JSON.parse(result);
      console.log(errors);

      if (errors['o_name'] == 'blank') {
        $('.error_o_name').text('団体名を入力してください。');
      }else if(errors['o_name'] == ''){
        $('.error_o_name').text('');
      }

      if (errors['o_f_name'] == 'blank') {
        $('.error_o_f_name').text('代表者名を入力してください。');
      }else if(errors['o_f_name'] == ''){
        $('.error_o_f_name').text('');
      }

      if (errors['o_postal'] == 'blank') {
        $('.error_o_postal').text('郵便番号を入力してください。');
      }else if(errors['o_postal'] == ''){
        $('.error_o_postal').text('');
      }

      if (errors['o_pref'] == 'blank') {
        $('.error_o_pref').text('都道府県を入力してください。');
      }else if(errors['o_pref'] == ''){
        $('.error_o_pref').text('');
      }

      if (errors['o_address'] == 'blank') {
        $('.error_o_address').text('市区町村・番地・建物名・号室を入力してください。');
      }else if(errors['o_address'] == ''){
        $('.error_o_address').text('');
      }

      if (errors['o_tel'] == 'blank') {
        $('.error_o_tel').text('電話番号を入力してください。');
      }else if(errors['o_tel'] == ''){
        $('.error_o_tel').text('');
      }

      if (errors['o_email'] == 'blank') {
        $('.error_o_email').text('メールアドレスを入力してください。');
      }else if (errors['o_email'] == 'duplicate') {
        $('.error_o_email').text('そのメールアドレスは既に登録されています。');
      }else if (errors['o_email'] == '') {
        $('.error_o_email').text('');
      }

      if (errors['o_password'] == 'blank') {
        $('.error_o_password').text('パスワードを入力してください。');
      }else if (errors['o_password'] == 'length') {
        $('.error_o_password').text('パスワードは6文字以上で入力してください。');
      }else if (errors['o_password'] == '') {
        $('.error_o_password').text('');
      }

      if (errors['o_confirm_password'] == 'blank') {
        $('.error_o_confirm_password').text('確認用パスワードを入力してください。');
      }else if (errors['o_confirm_password'] == 'wrong') {
        $('.error_o_confirm_password').text('パスワードが一致しません。');
      }else if (errors['o_confirm_password'] == '') {
        $('.error_o_confirm_password').text('');
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
          var o_password_show = ''; 
          for (var i = 0; i < o_password.length; i++) {
            o_password_show += "*";
          }
        
          // $('body').removeClass('modal-open'); // 1
          // $('.modal-backdrop').remove();       // 2
          $('#modal_register_organizer').modal('hide');        // 3
          $('#modal_register_organizer_confirm').modal();

          // 確認用モーダルの内容
          $('#r_o_name_s').text(o_name);
          $('#r_o_f_name_s').text(o_f_name);
          $('#r_o_postal_s').text(o_postal);
          $('#r_o_pref_s').text(o_pref);
          $('#r_o_address_s').text(o_address);
          $('#r_o_tel_s').text(o_tel);
          $('#r_o_email_s').text(o_email);
          $('#r_o_password_s_a').text(o_password_show);
          $('#r_o_password_s').val(o_password);
          $('#r_o_comment_s').text(o_comment);
        
      }



    }).fail(function(result){
      console.log('ajax失敗');

    });
  });

  // 確認モーダルでの登録ボタン押下
  $('#register_organizer_button_r').click(function(){
    console.log('click');

    var r_o_data_c = {  
                      o_name: $('#r_o_name_s').text(), 
                      o_f_name: $('#r_o_f_name_s').text(), 
                      o_postal: $('#r_o_postal_s').text(), 
                      o_pref: $('#r_o_pref_s').text(),
                      o_address: $('#r_o_address_s').text(), 
                      o_tel: $('#r_o_tel_s').text(),
                      o_email: $('#r_o_email_s').text(), 
                      o_password: $('#r_o_password_s').val(), 
                      o_comment: $('#r_o_comment_s').text(), 
                      o_pic_path: 'a',
                      o_db_register: 'on'
                    };
    // console.log(r_o_data_c[''])
    $.ajax({
      type: "POST",
      url: "modal_register_organizer_ajax.php",
      data: r_o_data_c

    }).done(function(result){
      console.log('ajax成功');
      // console.log(result);
      // var errors = JSON.parse(result);
      // console.log(errors);
      $('#modal_register_organizer_confirm').modal('hide');        // 3
      $('#modal_register_organizer_result').modal();


    }).fail(function(result){
      console.log('ajax失敗');

    });
  });



  // 確認モーダルでの戻るボタン押下
  $('#register_organizer_button_b').click(function(){
    console.log('click');
    $('#modal_register_organizer_confirm').modal('hide');
    $('#modal_register_organizer').modal();

  });

  // 登録完了通知モーダルでのサインインボタン押下
  $('#org_signin_modal_button').click(function(){
    console.log('click');
    $('#modal_register_organizer_result').modal('hide');
    $('#modal_login').modal();

  });

});