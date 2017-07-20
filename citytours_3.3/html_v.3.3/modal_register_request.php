<!-- Modal Review -->
  <form method="POST" action="" enctype="multipart/form-data">
   <div class="modal fade" id="myRequest" tabindex="-1" role="dialog" aria-labelledby="myRequestLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                  </button>
                  <h4 class="modal-title" id="myReviewLabel">Request to Eve Tomo</h4>
              </div>
              <div class="modal-body">
                  <div id="message-review"></div>
                      <div class="row">
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label>Category</label>
                                  <select class="form-control" name="request_category_id">
                                      <option value="">未選択</option>
                                      <option value="1">ガイドをお願いしたい</option>
                                      <option value="2">一人じゃ寂しい</option>
                                      <option value="3">ほげほげ</option>
                                  </select>
                              </div>
                          </div>
                      </div>
                      <div>
                        <input type="hidden" name="request_id" id="modal_request_id">
                      </div>
                      <div>
                        <input class="btn btn-primary" type="submit">
                      </div>
                  </div>
          </div>
      </div>
    </div>
  </form>