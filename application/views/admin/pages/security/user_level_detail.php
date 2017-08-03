
<section class="content-header">
    <h1>
      User Level
      <small>Detail</small>
    </h1>
</section>
<section class="content">
    <div class="row">
    <?php //print_r($levelData);?>
        <div class="col-md-12">  
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Data User Level</h3>
            </div>
            <!-- Edit Form User Level -->
            <?php if(isset($levelData)){ ?>
                <form class="form-horizontal" id="formUserLevel" method="post" action="<?=base_url()?>security/user_level_save" enctype="multipart/form-data">
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
                        <input type="text" class="form-control" name="levelName" id="levelName" value="<?=$levelData[0]['LEVELNAME']?>">
                        <input type="hidden" class="form-control" name="levelId" id="levelId" value="<?=$levelData[0]['ID']?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Description</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" id="levelDesc" name="levelDesc" value="<?=$levelData[0]['DESCRIPTION']?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-sm-12">
                      		<hr>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Access</label>
                      <div class="col-sm-8">
                      <?php  
                          $accessOld = explode(',', $levelData[0]['ACCESS']);
                          foreach ($moduleData as $key => $value) {
                            if($value['CHILDID'] == 0){
                              $checked = '';
                              if (in_array($value['ID'], $accessOld)){
                                  $checked = 'checked';
                              }
                              echo '';
                              echo '<input style="display:none;" class="parent-box" type="checkbox" '.$checked.'  name="levelAccess[]" value="'.$value['CODE'].'"/>';
                               echo $value['NAME'].'<br/>';
                              foreach ($moduleData as $keyChild => $valueChild) {
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
                  </div>
                  <div class="box-footer">
                    <a href="<?=base_url()?>security/user_level" class="btn btn-default">Cancel</a>
                    <button type="button" class="btn btn-info pull-right" onclick="submitForm()">Save</button>
                  </div>
                </form>
            <?php }else{ ?> <!-- Add Form User Level -->
                <form class="form-horizontal" id="formUserLevelAdd" method="post" action="<?=base_url()?>security/user_level_save" enctype="multipart/form-data">
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
                          <div class="col-sm-12">
                              <hr>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="inputEmail3" class="col-sm-2 control-label">Access</label>
                          <div class="col-sm-8">
                          <?php  
                              foreach ($moduleData as $key => $value) {
                                if($value['CHILDID'] == 0){
                                  $checked = '';
                                  echo '';
                                  echo '<input style="display:none" type="checkbox" '.$checked.'  name="levelAccess[]" value="'.$value['CODE'].'"/>';
                                  echo $value['NAME'].'<br/>';
                                  foreach ($moduleData as $keyChild => $valueChild) {
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
                      </div>
                      <div class="box-footer">
                        <a href="<?=base_url()?>security/user_level" class="btn btn-default">Cancel</a>
                        <button type="button" class="btn btn-info pull-right" onclick="submitFormAdd()">Save</button>
                      </div>
                </form>
              <?php } ?>
          </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    var baseurl = "<?=base_url()?>";

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

    function submitForm(){
        $('.errorMessage').addClass('hide');
        $('.successMessage').addClass('hide');
        var levelName = $('#levelName').val();
        var levelDesc = $('#levelDesc').val();
        if(levelName == ''){
            $('.errorMessage').removeClass('hide');
            $('.messageText').text('Please input level name.');
            return false;
        }else if(levelDesc == ''){
            $('.errorMessage').removeClass('hide');
            $('.messageText').text("Please input level Description.");
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
        if(levelName == ''){
            $('.errorMessage').removeClass('hide');
            $('.messageText').text('Please input level name.');
            return false;
        }else if(levelDesc == ''){
            $('.errorMessage').removeClass('hide');
            $('.messageText').text("Please input level Description.");
            return false;
        }else{
            $('#formUserLevelAdd').submit();
        }
    }
</script>