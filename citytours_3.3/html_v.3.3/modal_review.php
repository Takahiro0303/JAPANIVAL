  <!-- Modal Review -->
  <form method="POST" action="admin_user.php" enctype="multipart/form-data">
   <div class="modal fade" id="myReview" tabindex="-1" role="dialog" aria-labelledby="myReviewLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                  </button>
                  <h4 class="modal-title" id="myReviewLabel">Write your review</h4>
              </div>
              <div class="modal-body">
                  <div id="message-review"></div>
                  <form method="post" action="assets/review_tour.php" name="review_tour" id="review_tour">

                      <!-- End row -->

                      <!-- End row -->
                      <div class="row">
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label>Position</label>
                                  <select class="form-control" name="review_rating" id="position_review">
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
                          <textarea name="review_comment" id="review_text" class="form-control" style="height:100px" placeholder="Write your review"></textarea>
                      </div>
                      <div class="form-group">
                          <input type="file" name="review_pic_path" multiple>
                      </div>
                      <div>
                        <input type="hidden" name="event_id" value="" id="modal_event_id">
                      </div>
                      <div>
                        <input class="btn btn-primary" type="submit">
                      </div>
                  </div>
          </div>
      </div>
    </div>
  </form>
  <!-- End modal review -->