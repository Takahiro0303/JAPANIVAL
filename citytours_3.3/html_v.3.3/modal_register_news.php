<!-- Modal Review -->

<div class="modal fade" id="myNews" tabindex="-1" role="dialog" aria-labelledby="myNewsLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 600px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myReviewLabel">News Register</h4>
            </div>
            <div class="modal-body">
                <div id="message-review"></div>
                <div class="row">
                    <div>
                        <div class="col-md-12 form-group" style="width:100%;">
                            <label>タイトル</label>
                            <input type="text" id="news_input_title" class="form-control" style="width:100%;">
                        </div>
                    </div>
                    <div>

                        <div class="col-md-12 form-group" style="width:100%;">
                            <label>本文</label>
                            <textarea id="news_input_comment" class="form-control" style="width:100%; margin-bottom: 10px; height:200px;"></textarea>
                        </div>
                    </div>
                </div>
                <div>
                    <input type="hidden" id="modal_news_event_id" value="<?php echo htmlspecialchars($event_id); ?>">
                </div>
                <div>
                    <input type="button" class="btn btn-primary" id="register_news_button_c" style="width:100%; height:40px;" value="News Register">
                </div>
            </div>
        </div>
    </div>
</div>



<!-- 確認画面 -->
<div class="modal fade" id="myNews_confirm" tabindex="-1" role="dialog" aria-labelledby="myNewsLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 600px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myNewsLabel">News to Friends</h4>
            </div>
            <div class="modal-body">
                <div id="message-review"></div>
                <div class="row">
                    <div>
                        <div class="col-md-12 form-group" style="width:100%;">
                            <label>タイトル</label>
                            <div id="confirm_news_title" style="width:100%;"></div>
                        </div>
                    </div>
                    <div>

                        <div class="col-md-12 form-group" style="width:100%;">
                            <label>本文</label>
                            <div id="confirm_news_comment" style="width:100%; margin-bottom: 10px; height:200px;"></div>
                        </div>
                    </div>
                </div>
                <div>
                    <input type="hidden" id="modal_news_event_id" value="<?php echo htmlspecialchars($event_id) ?>">
                </div>
                <div>

                        <input type="button" id="register_news_button_r" class="btn_full" value="Register">
                        <input type="button" id="register_news_button_b" class="btn_full" value="Back">
                </div>
            </div>
        </div>
    </div>
</div>
