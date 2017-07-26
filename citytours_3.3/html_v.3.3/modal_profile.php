<div class="modal fade" id="myprofile_<?php echo htmlspecialchars($request['user_id']); ?>" tabindex="-1" role="dialog" aria-labelledby="myRequestLabel" aria-hidden="true">
  <div class="modal-dialog" >
    <div class="modal-content" style="z-index: 214748; position: relative; -webkit-transform: translate3d(0px, 0px, 12px);">
      <div class="panel panel-default" style="z-index: 214749; position: relative;">
        <div class="panel-heading" style="z-index: 214750; position: relative;">  <h4 >User Profile</h4></div>
        <div class="panel-body">
          <div class="box box-info">
            <div class="box-body">
              <div class="col-sm-6">
                <div  align="center"> <img alt="User Pic" src="<?php echo htmlspecialchars($request['pic_path']); ?>" id="profile-image1" class="img-circle img-responsive"> 
                  <div style="color:#999;" ></div>
                </div>
                <br>
                <!-- /input-group -->
              </div>
              <div class="col-sm-6">
                <h4 style="color:#00b1b1;">COMMENT</h4><?php echo htmlspecialchars($request['self_intro']); ?></span>
                <span><p><?php  ?></p></span>            
              </div>
              <div class="clearfix"></div>
              <hr style="margin:5px 0 5px 0;">

              <div class="col-sm-5 col-xs-6 tital" style="line-height: 25px;" >USERNAME:</div><div class="col-sm-7 col-xs-6" style="padding-left:30px; line-height: 20px;font-size: 15px;line-height: 25px;"><?php echo htmlspecialchars($request['nickname']); ?></div>
              <div class="clearfix"></div>
              <div class="bot-border"></div>

              <div class="col-sm-5 col-xs-6 tital" style="line-height: 25px;"  >COUNTRY:</div><div class="col-sm-7" style="padding-left:30px; line-height: 20px;font-size: 15px;line-height: 25px;"><?php echo htmlspecialchars($request['nationality']); ?></div>
              <div class="clearfix"></div>
              <div class="bot-border"></div>

              <div class="col-sm-5 col-xs-6 tital" style="line-height: 25px;"  >GENDER:</div><div class="col-sm-7" style="padding-left:30px; line-height: 20px;font-size: 15px;line-height: 25px;"><?php echo htmlspecialchars($request['gender']); ?></div>
              <div class="clearfix"></div>
              <div class="bot-border"></div>

              <div class="col-sm-5 col-xs-6 tital" style="line-height: 25px;"  >LEVEL OF JAPANEASE:</div><div class="col-sm-7" style="padding-left:30px; line-height: 20px;font-size: 15px;line-height: 25px;">japanese_level</div>

              <!-- /.box-body -->
            </div>
            <!-- /.box -->
          </div>
        </div> 
      </div>
      <!-- </div>   -->
    </div>
  </div>
</div>

