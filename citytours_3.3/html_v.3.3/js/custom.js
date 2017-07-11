
function logout(){

    location.href = "../../common/logout.php";
}

<<<<<<< HEAD
$(function() {

  // We can attach the `fileselect` event to all file inputs on the page
  $(document).on('change', ':file', function() {
    var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [numFiles, label]);
  });

  // We can watch for our custom `fileselect` event like this
  $(document).ready( function() {
      $(':file').on('fileselect', function(event, numFiles, label) {

          var input = $(this).parents('.input-group').find(':text'),
              log = numFiles > 1 ? numFiles + ' files selected' : label;

          if( input.length ) {
              input.val(log);
          } else {
              if( log ) alert(log);
          }

      });
  });
  
});
=======
$(document).on('change', ':file', function() {
    var input = $(this),
    numFiles = input.get(0).files ? input.get(0).files.length : 1,
    label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.parent().parent().next(':text').val(label);

    var files = !!this.files ? this.files : [];
    if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
    if (/^image/.test( files[0].type)){ // only image file
        var reader = new FileReader(); // instance of the FileReader
        reader.readAsDataURL(files[0]); // read the local file
        reader.onloadend = function(){ // set image data as background of div
            input.parent().parent().parent().prev('.imagePreview').css("background-image", "url("+this.result+")");
        }
    }
});


function confirm(){
    $(function(){
        $(".modal-title").text("Confirmation");
        var rating = document.review_event.rating.value;
        var comment = document.review_event.review_text.value;
        alert(rating + comment);


    });
}

// $("#review-modal-c").on("click", function(event){
//     $(".modal-title").text("Confirmation");
//     $("#review-event").submit();  
//     $("#position_review").hide();
//     $(".c-rating").show();  
//     return false;   
//        var str1=document.review_event.review_text.value;
//        $(this).text(str);
// });

// $(document).ready(function(){
//     $("#form1").submit(function(){
//         $.post( "postsample.php", $(this).serialize(), function(response){
//             alert(response);
//         } );
//         return false;
//     });
// });
>>>>>>> umetani_review_modal
