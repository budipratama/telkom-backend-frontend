
<section class="content-header">
    <h1>
      Change Password
      <small>CMS</small>
    </h1>
</section>
<section class="content">
    <div class="row">
    <?php //print_r($customerData);?>
        <div class="col-md-12">  
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Change Password</h3>
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
                  <label for="inputEmail3" class="col-sm-2 control-label">Current Password</label>
                  <div class="col-sm-8">
                    <input type="password" id="curnPass" class="form-control" value="">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">New Password</label>
                  <div class="col-sm-8">
                    <input type="password" id="newPass" class="form-control" value="">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Confirm New Password</label>
                  <div class="col-sm-8">
                    <input type="password"  id="confNewPass" class="form-control" value="">
                  </div>
                </div>
              <div class="box-footer">
                <button type="button" class="btn btn-info pull-right" onclick="submitFormChangePass()">Proses</button>
              </div>
            </form>
          </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    var baseurl = "<?=base_url()?>";
    function submitFormChangePass(){
        $('.errorMessage').addClass('hide');
        $('.successMessage').addClass('hide');
        var curnPass = $('#curnPass').val();
        var newPass = $('#newPass').val();
        var confNewPass = $('#confNewPass').val();
        if(curnPass != '' && newPass != '' && confNewPass != ''){          
            if(newPass.length < 8){            
                $('.errorMessage').removeClass('hide');
                $('.messageText').text('Password too short, password minimal 8 characters.');
                return false;
            }
            if(newPass == confNewPass){
                $.ajax({
                    type: "POST",
                    url: baseurl+"security/updatePassword",
                    data: {'curnPass': curnPass, 'newPass' : newPass},
                    cache: false,
                    dataType: "json",
                    success: function (res) {
                        if(res.result){                          
                          clearAllText();
                          $('.successMessage').removeClass('hide');
                          $('.messageText').text(res.message);
                        }else{           
                          $('#curnPass').focus();
                          $('#curnPass').select();
                          $('.errorMessage').removeClass('hide');
                          $('.messageText').text(res.message);
                        }
                    }
                });
            }else{
                clearAllText();
                $('.errorMessage').removeClass('hide');
                $('.messageText').text("New password and confirm new password doesn't match");
            }
        }else{
            $('#curnPass').focus();
            $('.errorMessage').removeClass('hide');
            $('.messageText').text('Please fill all Field');
        }
    }
    function clearAllText(){
        $('#curnPass').focus();
        $('#curnPass').val(''); 
        $('#newPass').val('');
        $('#confNewPass').val('');
    }
</script>