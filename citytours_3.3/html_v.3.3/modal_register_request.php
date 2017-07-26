

<!-- Modal Review -->
  <form method="POST" action="" enctype="multipart/form-data">
   <div class="modal fade" id="myRequest" tabindex="-1" role="dialog" aria-labelledby="myRequestLabel" aria-hidden="true">
      <div class="modal-dialog" style="width: 400px;">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                  </button>
                  <h4 class="modal-title" id="myReviewLabel">Request to Friends</h4>
              </div>
              <div class="modal-body">
                  <div id="message-review"></div>
                      <div class="row">
                          <div class="col-md-12" style="width:100%;">
                              <div class="form-group" style="width:100%;">
                                  <label>Request Category</label>
                                  <select class="form-control form-inline" name="request_category_id" style="width:100%;">
                                      <option value="">Please Select</option>
                                      <option value="1">Want to Know</option>
                                      <option value="2">Want to you to Navigate</option>
                                      <option value="3">Let's hang out</option>
                                  </select>
                              </div>
                          </div>
                      </div>
                      <div>
                        <input type="hidden" name="request_id" id="modal_request_id">
                      </div>
                      <div>
                        <button class="btn btn-primary" type="submit" style="width:100%; height:40px;">Submit</button>
                      </div>
                  </div>
          </div>
      </div>
    </div>
  </form>