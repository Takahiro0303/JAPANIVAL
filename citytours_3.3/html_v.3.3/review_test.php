<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>

<!-- <a href="#" class="btn_1 add_bottom_30" data-toggle="modal" data-target="#myReview">
 -->
 <div class="modal fade" id="myReview" tabindex="-1" role="dialog" aria-labelledby="myReviewLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myReviewLabel">Write your review</h4>
            </div>
            <div class="modal-body">
                <div id="message-review">
                </div>
                <form method="post" action="assets/review_tour.php" name="review_tour" id="review_tour">

                    <!-- End row -->

                    <!-- End row -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Position</label>
                                <select class="form-control" name="position_review" id="position_review">
                                    <option value="">Please review</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- End row -->

                    <!-- End row -->
                    <div class="form-group">
                        <textarea name="review_text" id="review_text" class="form-control" style="height:100px" placeholder="Write your review"><?php echo 'hogehoge'; ?></textarea>
                    </div>
                    <div class="form-group">
                        <input type="button" name="picture" value=写真の選択>
                    </div>
        </div>
      </div>
    </div>
  </div>


<!-- <footer class="revealed">
<div class="container">
<div class="row">
※requireで呼び出し
</div>
</div> -->
</div>
<!-- End modal review -->

    <!-- Common scripts -->
    <script src="js/jquery-2.2.4.min.js"></script>
    <script src="js/common_scripts_min.js"></script>
    <script src="js/functions.js"></script>

    <!-- Specific scripts -->
    <script src="js/icheck.js"></script>
    <script>
    $('input').iCheck({
    checkboxClass: 'icheckbox_square-grey',
    radioClass: 'iradio_square-grey'
    });
    </script>
    <!-- Date and time pickers -->
    <script src="js/jquery.sliderPro.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function ($) {
    $('#Img_carousel').sliderPro({
    width: 960,
    height: 500,
    fade: true,
    arrows: true,
    buttons: false,
    fullScreen: false,
    smallSize: 500,
    startSlide: 0,
    mediumSize: 1000,
    largeSize: 3000,
    thumbnailArrows: true,
    autoplay: false
    });
    });
    </script>

    <!-- Date and time pickers -->
    <script src="js/bootstrap-datepicker.js"></script>
    <script src="js/bootstrap-timepicker.js"></script>
    <script>
    $('input.date-pick').datepicker('setDate', 'today');
    $('input.time-pick').timepicker({
    minuteStep: 15,
    showInpunts: false
    })
    </script>

    <!--Review modal validation -->
    <script src="assets/validate.js"></script>

    <!-- Map -->
    <!-- <script src="http://maps.googleapis.com/maps/api/js"></script>
    <script src="js/map.js"></script>
    <script src="js/infobox.js"></script>
 -->
    </body>
    </html>
