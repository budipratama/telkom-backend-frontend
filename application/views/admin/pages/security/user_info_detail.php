
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
            <?php if(isset($userData)){ ?>
                <form class="form-horizontal">
                  <div class="box-body">
                    <div class="errorMessage hide alert alert-danger alert-dismissable">
                        <span class="messageText"></span>
                    </div>
                    <div class="successMessage hide alert alert-success alert-dismissable">
                        <span class="messageText"></span>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">User Name</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="userName" id="userName" value="<?=$userData[0]['USERNAME']?>">
                        <input type="hidden" class="form-control" name="userId" id="userId" value="<?=$userData[0]['ID']?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">User Real Name</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="userRealName" id="userRealName" value="<?=$userData[0]['REALNAME']?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">User Level</label>
                      <div class="col-sm-8">
                          <select class="form-control" id="userLevel" name="userLevel">
                          <?php
                              foreach ($levelList as $key => $value) {
                                  $selected = '';
                                  if($userData[0]['LEVEL'] == $value['ID']){
                                      $selected = "selected";
                                  }
                                  echo "<option ".$selected." value='".$value['ID']."'>".$value['LEVELNAME']."</option>";
                              }
                          ?>
                          </select>
                      </div>
                    </div>
                  </div>
                  <div class="box-footer">
                    <a href="<?=base_url()?>security/user_info" class="btn btn-default">Cancel</a>
                    <button type="button" class="btn btn-info pull-right" onclick="submitForm()">Save</button>
                  </div>
                </form>
            <?php }else{ ?>
                <form class="form-horizontal" id="formAddUserInfo" method="post" action="<?=base_url()?>security/user_info_save">
                  <div class="box-body">
                    <div class="errorMessage hide alert alert-danger alert-dismissable">
                        <span class="messageText"></span>
                    </div>
                    <div class="successMessage hide alert alert-success alert-dismissable">
                        <span class="messageText"></span>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">User Name</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="userName" id="userName" value="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">User Real Name</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="userRealName" id="userRealName" value="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Password</label>
                      <div class="col-sm-8">
                        <input type="password" class="form-control" name="userPass" id="userPass" value="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Confirm Password</label>
                      <div class="col-sm-8">
                        <input type="password" class="form-control" name="userConfPass" id="userConfPass" value="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">User Level</label>
                      <div class="col-sm-8">
                          <select class="form-control" id="userLevel" name="userLevel">
                          <?php
                              foreach ($levelList as $key => $value) {
                                  echo "<option value='".$value['ID']."'>".$value['LEVELNAME']."</option>";
                              }
                          ?>
                          </select>
                      </div>
                    </div>
                  </div>
                  <div class="box-footer">
                    <a href="<?=base_url()?>security/user_info" class="btn btn-default">Cancel</a>
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
    function submitForm(){
        $('.errorMessage').addClass('hide');
        $('.successMessage').addClass('hide');
        var userId = $('#userId').val();
        var userName = $('#userName').val();
        var userRealName = $('#userRealName').val();
        var userLevel = $("#userLevel").val();
        if(userName == '' && userRealName == '' && userLevel == ''){
            alert('Please input level name.');
            return false;
        }else{
            $.ajax({
                type: "POST",
                url: baseurl+"security/user_info_save",
                data: {'userId': userId, 'userName' : userName, 'userRealName' : userRealName, 'userLevel' : userLevel},
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
        }
    }
    function submitFormAdd(){
        $('.errorMessage').addClass('hide');
        $('.successMessage').addClass('hide');
        var userName = $('#userName').val();
        var userRealName = $('#userRealName').val();
        var userLevel = $("#userLevel").val();
        var userPass = $("#userPass").val();
        var userConfPass = $("#userConfPass").val();
        if(userName != '' && userRealName != '' && userPass != '' && userConfPass != ''){
            if(userPass.length < 8){                
                $('.errorMessage').removeClass('hide');
                $('.messageText').text("Error. Password minimal 8 characters.");
                return false;
            }
            if(userPass == userConfPass){
                $('#formAddUserInfo').submit();
            }else{
                $('.errorMessage').removeClass('hide');
                $('.messageText').text("Error. Password and Confirm Password Doesn't match.");
            }
        }else{
            $('.errorMessage').removeClass('hide');
            $('.messageText').text("Error. Please fill all field");
        }
    }
</script>