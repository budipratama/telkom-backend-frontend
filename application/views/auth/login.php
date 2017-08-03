<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>CMS | Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.4 -->
    <link href="<?php echo $css_admin?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="<?php echo $css_admin?>dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <script src='https://www.google.com/recaptcha/api.js'></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
    .g-recaptcha {
        transform:scale(1.07);
        transform-origin:0 0;
    }
    </style>
  </head>
  <body class="login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="#"><b>tMoney</b>CMS</a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">&nbsp;
          <div class="errorMessage hide alert alert-danger alert-dismissable">
              <span class="messageText"></span>
          </div>
          <div class="successMessage hide alert alert-success alert-dismissable">
              <span class="messageText"></span>
          </div>
        </p>
        <form action="#" method="post" id="formLogin">
          <div class="form-group has-feedback">
            <input type="text" class="form-control" id="username" placeholder="Username" />
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" id="userpass" placeholder="Password" />
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-12">
              <!-- <div class="checkbox icheck">
                <label>
                  <input type="checkbox"> Remember Me
                </label>
              </div> -->
              <!-- <div class="form-group">
                  <div class="g-recaptcha" data-sitekey="6Ld9fCITAAAAAEKC5gduXOqYxpBgG1Q4WlSveG5a" id="reCaptcha"></div>
              </div> -->
            </div>
            <div class="col-xs-12">
              <button type="button" class="btn btn-primary btn-block btn-flat" onclick="login()">Sign In</button>
            </div>
          </div>
        </form>
<!--         <a href="#">I forgot my password</a><br>
        <a href="#" class="text-center">Register a new membership</a> -->
      </div>
    </div>

    <!-- jQuery 2.1.4 -->
    <script src="<?php echo $css_admin?>plugins/jQuery/jQuery-2.1.4.min.js" type="text/javascript"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="<?php echo $css_admin?>bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?php echo $js_admin?>auth.js" type="text/javascript"></script>
  </body>
</html>
<script type="text/javascript">
    var baseurl = '<?php echo base_url()?>';
    function login(){
        $('.errorMessage').addClass('hide');
        $('.successMessage').addClass('hide');
        var username = $('#username').val();
        var userpass = $('#userpass').val();
        // var reCaptcha = $('#g-recaptcha-response').val();
        // if(username != '' && userpass != '' && reCaptcha != ''){
        if(username != '' && userpass != ''){
            $.ajax({
                type: "POST",
                url: baseurl+"auth/checkLogin",
                data: {'username': username, 'userpass':userpass},
                // data: {'username': username, 'userpass':userpass, 'reCaptcha':reCaptcha},
                cache: false,
                dataType: "json",
                success: function (res) {
                    if(res.result){
                      $('.successMessage').removeClass('hide');
                      $('.messageText').text("Login success");
                      window.location.href = baseurl+"dashboard";
                    }else{
                        // grecaptcha.reset();
                        $('.errorMessage').removeClass('hide');
                        $('.messageText').text(res.message);
                    }
                }
            });
        }else{
            $('.errorMessage').removeClass('hide');
            $('.messageText').text('Please fill all field');
        }
    }
    $('#formLogin input').keypress(function (e) {
        if (e.which == 13) {
            login();
        }
    });

</script>
