
<section class="content-header">
    <h1>
      Customer Level
      <small>Detail</small>
    </h1>
</section>
<section class="content">
    <div class="row">
    <?php //print_r($customerData);?>
        <div class="col-md-12">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Customer Level</h3>
            </div>
            <?php if(isset($custLevel)){ ?>
                <form class="form-horizontal" id="formUserLevel" method="post" action="<?php echo base_url()?>management/customer_level_save" enctype="multipart/form-data">
                  <div class="box-body">
                    <div class="errorMessage hide alert alert-danger alert-dismissable">
                        <span class="messageText"></span>
                    </div>
                    <div class="successMessage hide alert alert-success alert-dismissable">
                        <span class="messageText"></span>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Level Name</label>
                      <div class="col-sm-8">
                        <input type="text" id="levelName" name="levelName" class="form-control" value="<?php echo $custLevel[0]['LEVEL_NAME']?>">
                        <input type="hidden" id="levelId" name="levelId" class="form-control" value="<?php echo $custLevel[0]['ID']?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Level Description</label>
                      <div class="col-sm-8">
                        <textarea class="form-control" rows="5" placeholder="Enter reason..." name="levelDesc" id="remarks"><?php echo $custLevel[0]['LEVEL_DESC']?></textarea>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Min Balance</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control numeric" placeholder="" id="custMinBal" name="custMinBal" value="<?php echo $custLevel[0]['LEVEL_MINBALANCE']?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Max Balance</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control numeric" placeholder="" id="custMaxBal" name="custMaxBal" value="<?php echo $custLevel[0]['LEVEL_MAXBALANCE']?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Max Outgoing</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control numeric" placeholder="" id="custMaxOutGoing" name="custMaxOutGoing" value="<?php echo $custLevel[0]['LEVEL_MAXOUTGOING']?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Group Fee</label>
                      <div class="col-sm-8">
                        <select class="form-control" id="custGroupFee" name="custGroupFee">
                          <?php foreach($group_fee as $value): ?>
                            <option value="<?php echo $value['FH_ID'] ?>"><?php echo $value['FH_NAME'] ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                      <script>
                        $('#custGroupFee').val("<?php echo $custLevel[0]['GROUP_FEE']?>");
                      </script>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Customer Type ID</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" placeholder="" id="custTypeID" name="custTypeID" value="<?php echo $custLevel[0]['CUST_TYPE_ID']?>" disabled="disabled">
                      </div>
                    </div>
                    <div class="form-group" style="display:none">
                      <label for="inputEmail3" class="col-sm-2 control-label">Access</label>
                      <div class="col-sm-8">
                      <?php
                        // set access
                        $access = isset($custLevelAcl[0]['ACCESS']) ? $custLevelAcl[0]['ACCESS'] : array();

                          $accessOld = explode(',', $access);
                          foreach ($moduleLevelData as $key => $value) {
                            if($value['CHILDID'] == 0){
                              $checked = '';
                              if (in_array($value['ID'], $accessOld)){
                                  $checked = 'checked';
                              }
                              echo '';
                              echo '<input style="display:none;" class="parent-box" type="checkbox" '.$checked.'  name="levelAccess[]" value="'.$value['CODE'].'"/>';
                               echo $value['NAME'].'<br/>';
                              foreach ($moduleLevelData as $keyChild => $valueChild) {
                                if($valueChild['CHILDID'] != 0){
                                  if($value['CODE'] == $valueChild['CHILDID']){
                                    $checkedChild = '';
                                    if (in_array($valueChild['ID'], $accessOld)){
                                        $checkedChild = 'checked';
                                    }
                                    echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class="child-box" data-parent="' . $value['CODE'] .'" type="checkbox" '.$checkedChild.' name="levelAccess[]" value="'.$valueChild['CODE'].'"/>  '.$valueChild['NAME'].'<br/>';
                                  }
                                }
                              }
                            }
                          }
                      ?>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-sm-offset-2 col-sm-10">
                        <div class="checkbox">
                          <?php
                                $checked = '';
                                if($custLevel[0]['LEVEL_STATUS'] == 1){
                                    $checked = "checked=''";
                                }
                          ?>
                          <label>
                              <input type="checkbox" <?php echo $checked?> value="1" name="active" id="active"> Active
                          </label>
                        </div>
                      </div>
                    </div>
                    </div>
                    <div class="box-footer">
                      <a href="<?php echo base_url()?>management/customer_level" class="btn btn-default">Cancel</a>
                      <button type="button" class="btn btn-info pull-right" onclick="submitForm()">Proses</button>
                    </div>
                </form>
            <?php }else{ ?>

              <form class="form-horizontal" id="formUserLevelAdd" method="post" action="<?php echo base_url()?>management/customer_level_save" enctype="multipart/form-data">
                      <div class="box-body">
                        <div class="errorMessage hide alert alert-danger alert-dismissable">
                            <span class="messageText"></span>
                        </div>
                        <div class="successMessage hide alert alert-success alert-dismissable">
                            <span class="messageText"></span>
                        </div>
                        <div class="form-group">
                          <label for="inputEmail3" class="col-sm-2 control-label">User Level Name</label>
                          <div class="col-sm-8">
                            <input type="text" class="form-control" name="levelName" id="levelName" value="">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="inputEmail3" class="col-sm-2 control-label">Description</label>
                          <div class="col-sm-8">
                            <input type="text" class="form-control" id="levelDesc" name="levelDesc" value="">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-2 control-label">Min Balance</label>
                          <div class="col-sm-8">
                            <input type="text" class="form-control numeric" placeholder="" id="custMinBal" name="custMinBal">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-2 control-label">Max Balance</label>
                          <div class="col-sm-8">
                            <input type="text" class="form-control numeric" placeholder="" id="custMaxBal" name="custMaxBal">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-2 control-label">Max Outgoing</label>
                          <div class="col-sm-8">
                            <input type="text" class="form-control numeric" placeholder="" id="custMaxOutGoing" name="custMaxOutGoing">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-2 control-label">Group Fee</label>
                          <div class="col-sm-8">
                            <select class="form-control" id="custGroupFee" name="custGroupFee">
                              <?php foreach($group_fee as $value): ?>
                                <option value="<?php echo $value['FH_ID'] ?>"><?php echo $value['FH_NAME'] ?></option>
                              <?php endforeach; ?>
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-2 control-label">Customer Type ID</label>
                          <div class="col-sm-8">
                            <input type="text" class="form-control" value="<?php echo $next_cust_type_id; ?>" id="custTypeID" name="custTypeID" disabled="disabled">
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="col-sm-12">
                              <hr>
                          </div>
                        </div>
                        <div class="form-group" style="display:none">
                          <label for="inputEmail3" class="col-sm-2 control-label">Access</label>
                          <div class="col-sm-8">
                          <?php
                              foreach ($moduleLevelData as $key => $value) {
                                if($value['CHILDID'] == 0){
                                  $checked = '';
                                  echo '';
                                  echo '<input style="display:none" type="checkbox" '.$checked.'  name="levelAccess[]" value="'.$value['CODE'].'"/>';
                                  echo $value['NAME'].'<br/>';
                                  foreach ($moduleLevelData as $keyChild => $valueChild) {
                                    if($valueChild['CHILDID'] != 0){
                                      if($value['CODE'] == $valueChild['CHILDID']){
                                        $checkedChild = '';
                                        echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class="child-box"  data-parent="' . $value['CODE'] .'"  type="checkbox" '.$checkedChild.' name="levelAccess[]" value="'.$valueChild['CODE'].'"/>  '.$valueChild['NAME'].'<br/>';
                                      }
                                    }
                                  }
                                }
                              }
                          ?>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="col-sm-offset-2 col-sm-10">
                            <div class="checkbox">
                                  <input type="checkbox" value="1" name="active" id="active" checked> Active
                              </label>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="box-footer">
                        <a href="<?php echo base_url()?>management/customer_level" class="btn btn-default">Cancel</a>
                        <button type="button" class="btn btn-info pull-right" onclick="submitFormAdd()">Save</button>
                      </div>
                </form>
              <?php } ?>
          </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    var baseurl = "<?php echo base_url()?>";
    $(document).ready(function(){
      $('.child-box').on('change',function(){
        //reset semua parent ke un check
        $('.parent-box').each(function(){
          $(this).prop('checked', false);
        })
        //check smua child yg di check trus check juga parentnya
        $('.child-box:checked').each(function(){
          $('input[value='+ $(this).data('parent')+']').prop('checked',true);
        })
      })
    })
    function submitFormEdit(){
        $('.errorMessage').addClass('hide');
        $('.successMessage').addClass('hide');
        var provName = $('#provName').val();
        var provId = $('#provId').val();
        var provId = $('#provId').val();
        var active = 0;
        if ($('#active').prop('checked')) {
            active = 1;
        }
        if(provName != ''){
            $.ajax({
                type: "POST",
                url: baseurl+"management/province_save",
                data: {'provId': provId, 'provName' : provName, 'active' : active},
                cache: false,
                dataType: "json",
                success: function (res) {
                    if(res.result){
                      $('.successMessage').removeClass('hide');
                      $('.messageText').text(res.message);
                    }else{
                      $('.errorMessage').removeClass('hide');
                      $('.messageText').text(res.message);
                    }
                }
            });
        }else{
            $('.errorMessage').removeClass('hide');
            $('.messageText').text('Please fill all Field');
        }
    }
    function submitForm(){
        $('.errorMessage').addClass('hide');
        $('.successMessage').addClass('hide');
        var levelName = $('#levelName').val();
        var levelDesc = $('#levelDesc').val();
        var custMinBal = $('#custMinBal').val();
        var custMaxBal = $('#custMaxBal').val();
        if(levelName == ''){
            $('.errorMessage').removeClass('hide');
            $('.messageText').text('Please input level name.');
            return false;
        }else if(levelDesc == ''){
            $('.errorMessage').removeClass('hide');
            $('.messageText').text("Please input level Description.");
            return false;
        }else if(custMinBal == ''){
            $('.errorMessage').removeClass('hide');
            $('.messageText').text("Please input min balance.");
            return false;
        }else if(custMaxBal == ''){
            $('.errorMessage').removeClass('hide');
            $('.messageText').text("Please input max balance.");
            return false;
        }else{
            $('#formUserLevel').submit();
        }
    }
    function submitFormAdd(){
        $('.errorMessage').addClass('hide');
        $('.successMessage').addClass('hide');
        var levelName = $('#levelName').val();
        var levelDesc = $('#levelDesc').val();
        var custMinBal = $('#custMinBal').val();
        var custMaxBal = $('#custMaxBal').val();
        var custMaxOutGoing = $('#custMaxOutGoing').val();
        if(levelName == ''){
            $('.errorMessage').removeClass('hide');
            $('.messageText').text('Please input level name.');
            return false;
        }else if(levelDesc == ''){
            $('.errorMessage').removeClass('hide');
            $('.messageText').text("Please input level Description.");
            return false;
        }else if(custMinBal == ''){
            $('.errorMessage').removeClass('hide');
            $('.messageText').text("Please input min balance.");
            return false;
        }else if(custMaxBal == ''){
            $('.errorMessage').removeClass('hide');
            $('.messageText').text("Please input max balance.");
            return false;
        }else if(custMaxOutGoing == ''){
            $('.errorMessage').removeClass('hide');
            $('.messageText').text("Please input max out going.");
            return false;
        }else{
            $('#formUserLevelAdd').submit();
        }
    }
</script>
