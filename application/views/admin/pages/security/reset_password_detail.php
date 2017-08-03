
<section class="content-header">
    <h1>
      User CMS
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
                        <input type="text" disabled class="form-control" name="userName" id="userName" value="<?=$userData[0]['USERNAME']?>">
                        <input type="hidden" class="form-control" name="userId" id="userId" value="<?=$userData[0]['ID']?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Password</label>
                      <div class="col-sm-8">
                        <input type="password" class="form-control" name="userPass" id="userPass">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Confirm Password</label>
                      <div class="col-sm-8">
                        <input type="password" class="form-control" name="userPassConf" id="userPassConf">
                      </div>
                    </div>
                                        
                  </div>
                  <div class="box-footer">
                    <a href="<?=base_url()?>security/reset_password" class="btn btn-default">Cancel</a>
                    <button type="button" class="btn btn-info pull-right" onclick="submitForm()">Reset</button>
                  </div>
                </form>
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
        var userPass = $('#userPass').val();
        var userPassConf = $('#userPassConf').val();
        if(userName == '' && userPass == '' && userPassConf == ''){
            $('.errorMessage').removeClass('hide');
            $('.messageText').text('Please input all field.');
            return false;
        }else if(userPass.length < 8){            
            $('.errorMessage').removeClass('hide');
            $('.messageText').text('Password too short, password minimal 8 characters.');
            return false;
        }else{
            if(userPass == userPassConf){
                var conf = confirm("Are you sure?");
                if(conf){
                    $.ajax({
                        type: "POST",
                        url: baseurl+"security/reset_password_save",
                        data: {'userId': userId, 'userPass' : userPass},
                        cache: false,
                        dataType: "json",
                        success: function (res) {
                            if(res.result){
                                $('.successMessage').removeClass('hide');
                                $('.messageText').text(res.message);
                                $('#userPass').val('');
                                $('#userPassConf').val('');
                            }else{
                                $('.errorMessage').removeClass('hide');
                                $('.messageText').text(res.message);
                                $('#userPass').val('');
                                $('#userPassConf').val('');
                            }
                        }
                    });
                }
            }else{
                $('.errorMessage').removeClass('hide');
                $('.messageText').text("Password and Confirm Password doesn't match");
            }
        }
    }
</script>