
// alert("modal_login_ajax.js"); 
$(document).ready(function(){
// alert("modal_login_ajax.js"); 
  $('#modal_login_button').click(function(){
        console.log('click');
              console.log('click');
              console.log('click');

  //ajax処理

    // var tweet_id = $('#tweet_id1').val();
    // var like_data = $('#like_data1').val();
    var email = $('#email_modal').val();
    var password = $('#password_modal').val();
    var error = '';

    console.log(email);
    console.log(password);

    //POST送信するデータをJS側で取得
    var login_data = {email : email, password: password};
    // var tweet_id_data = {tweet_id : tweet_id, like_data: like_data};

    //ajax通信処理
    //done →処理が成功した時に呼ばれる
    //fail →処理が失敗した時に呼ばれる

    $.ajax({
      type: "POST",
      url: "modal_login_ajax.php",
      data: login_data

    }).done(function(result){
      console.log('ajax成功');
      console.log(result);
      var error = JSON.parse(result);
      console.log(error);

      if (error['error'] == 'failed') {
        $('.error').text('ログインに失敗しました');
        // $('#like_data1').val('unlike');
      } else if (error['error'] == 'blank'){
        $('.error').text('メールアドレスとパスワードを入力してください');
        // $('#like_data1').val('like');
      } else if (error['error'] == 'no'){
        location.href = "edit_index.php";
      }


    }).fail(function(result){
      console.log('ajax失敗');

    });
  });
});