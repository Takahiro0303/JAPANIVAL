<!-- Modal Review -->

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
                            <select class="form-control form-inline" id="request_category_id" style="width:100%;">
                                <option value="">Please Select</option>
                                <option value="1">Want to Know</option>
                                <option value="2">Want you to Navigate</option>
                                <option value="3">Let's hang out</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div>
                    <input type="hidden" id="modal_request_event_id" value="<?php echo htmlspecialchars($event_id) ?>">
                </div>
                <div>
                    <input type="button" class="btn btn-primary" id="register_request_button_c" style="width:100%; height:40px;" value="REQUEST">
                </div>
            </div>
        </div>
    </div>
</div>



<!-- 確認画面 -->
<div class="modal fade" id="myRequest_confirm" tabindex="-1" role="dialog" aria-labelledby="myRequestLabel" aria-hidden="true">
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
                            <label>こちらのカテゴリーIDで登録して宜しいでしょうか？</label>
                                <div id="confirm_request" style="font-size: 15px; text-decoration: underline;"></div>
                            </select>
                        </div>
                    </div>
                </div>
                <div>
                    <input type="hidden" id="modal_request_event_id" value="<?php echo htmlspecialchars($event_id) ?>">
                </div>
                <div>
                    <input type="button" class="btn btn-primary" id="register_request_button_c" style="width:100%; height:40px;" value="REQUEST">
                            <input type="button" id="register_user_button_r" class="btn_full" value="Register">
                            <input type="button" id="register_user_button_b" class="btn_full" value="Back">
                </div>
            </div>
        </div>
    </div>
</div>