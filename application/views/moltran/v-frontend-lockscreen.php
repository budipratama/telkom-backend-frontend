<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">

		<title><?php echo $headers['title']; ?></title>

		<meta name="keywords" content="<?php echo $headers['meta_key']; ?>" />
		<meta name="description" content="<?php echo $headers['meta_desc']; ?>" />
		<meta name="author" content="<?php echo $headers['author']; ?>" />
		<meta name="codename" content="<?php echo $headers['codename']; ?>" />

		<link rel="shortcut icon" href="<?php echo $params['base_image'] . 'favicon.png'; ?>" />

        <link href="<?php echo $params['base_theme']; ?>dark/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo $params['base_theme']; ?>dark/assets/css/core.css" rel="stylesheet" type="text/css">
        <link href="<?php echo $params['base_theme']; ?>dark/assets/css/icons.css" rel="stylesheet" type="text/css">
        <link href="<?php echo $params['base_theme']; ?>dark/assets/css/components.css" rel="stylesheet" type="text/css">
        <link href="<?php echo $params['base_theme']; ?>dark/assets/css/pages.css" rel="stylesheet" type="text/css">
        <link href="<?php echo $params['base_theme']; ?>dark/assets/css/menu.css" rel="stylesheet" type="text/css">
        <link href="<?php echo $params['base_theme']; ?>dark/assets/css/responsive.css" rel="stylesheet" type="text/css">

        <style type="text/css">
			::-webkit-input-placeholder { text-transform: none; }
			:-moz-placeholder { text-transform: none; }
			::-moz-placeholder { text-transform: none; }
			:-ms-input-placeholder { text-transform: none; }
			#refresh-captcha { cursor: pointer; }
			input[type=number]::-webkit-inner-spin-button, input[type=number]::-webkit-outer-spin-button {
			  	-webkit-appearance: none;
			  	margin: 0;
			}
			input[type=number] {
			  	-moz-appearance: textfield;
			}
			/* input[type="number"]:hover, input[type="number"]:focus {
			  	-moz-appearance: number-input;
			} */
		</style>

        <script src="<?php echo $params['base_theme']; ?>dark/assets/js/jquery.min.js"></script>
        <script src="<?php echo $params['base_theme']; ?>dark/assets/js/modernizr.min.js"></script>

		<script type="text/javascript">
			function captcha()
			{
				jQuery.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>" + "frontend/generate-captcha.danra",
					success: function(res) {
						if (res)
						{
							jQuery("div#captcha-wrapper").html(res);
						}
					}
				});
			}

			jQuery(document).ready(function() {
				captcha();

				jQuery("div#refresh-captcha").on("click", function() {
					captcha();
				});
			});
		</script>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
	</head>
    <body>
        <div class="wrapper-page">
            <div class="panel panel-color panel-primary panel-pages">

                <div class="panel-heading bg-img">
                    <div class="bg-overlay"></div>
                    <h3 class="text-center m-t-10 text-white">&nbsp;</h3>
                </div>

                <div class="panel-body" style="padding-top:0px">
                 	<form method="post" action="<?php echo @ site_url('authentication/user/unlock-screen'); ?>" role="form" class="text-center form-horizontal m-t-20">
	                    <div class="user-thumb">
	                        <img src="<?php echo $params['base_image']; ?>profile.png" class="img-responsive img-circle img-thumbnail" alt="thumbnail">
	                    </div>
	                    <div class="form-group">
	                        <h3><?php echo trim(ucwords(strtolower($this->session->tempdata('full_name')))); ?></h3>
	                        <p class="text-muted">Masukkan password anda untuk mengakses aplikasi <?php echo substr(FUSION_APP_NAME, 0, 6); ?></p>
	                    </div>

	                    <div class="form-group">
	                        <div class="col-xs-12">
								<?php $this->load->view($params['base_widget'] . 'v-widget-alert'); ?>

	                            <input required="required" readonly="readonly" onfocus="this.removeAttribute('readonly');" name="userid" id="userid" type="hidden" class="form-control input-lg" placeholder="Masukkan User ID anda" value="<?php echo trim($this->session->tempdata('user_id')); ?>" />
	                            <input required="required" readonly="readonly" onfocus="this.removeAttribute('readonly');" name="username" id="username" type="hidden" class="form-control input-lg" placeholder="Masukkan User Name anda" value="<?php echo trim($this->session->tempdata('user_name')); ?>" />
	                            <input required="required" readonly="readonly" onfocus="this.removeAttribute('readonly');" maxlength="100" name="password" id="password" type="password" class="form-control input-lg" placeholder="Masukkan password anda" />
	                      	</div>
	                    </div>

						<div class="form-group">
							<div class="col-xs-12">
								<div style="width: 100%;">
									<div style="float: left; width: 35%;">
										<div id="refresh-captcha">
											<div id="captcha-wrapper">
												<?php echo ($captcha['image'] != NULL ? $captcha['image'] : '-'); ?>
											</div>
										</div>
									</div>
									<div style="float: right; width: 64%; margin-left: 1%;">
										<input readonly="readonly" onfocus="this.removeAttribute('readonly');" name="danraCaptcha" id="danraCaptcha" autocomplete="off" type="text" maxlength="4" value="" required="required" placeholder="Masukkan Kode Keamanan" class="form-control input-lg" style="width: 100%; padding-left: 10px;" />
									</div>
								</div>
							</div>
						</div>

						<div class="form-group">
		                    <div class="text-right col-xs-12">
		                        <a href="<?php echo @ site_url('frontend/sign-in'); ?>">Bukan <?php echo trim(ucwords(strtolower($this->session->tempdata('full_name')))); ?> ?</a>
		                    </div>
	                    	<div class="text-center col-xs-12 m-t-10">
								<span class="input-group-btn"> <button type="submit" class="btn btn-danger btn-lg waves-effect waves-light">Log In</button> </span>
							</div>
						</div>
                	</form>

                </div>

            </div>
        </div>


    	<script>
            var resizefunc = [];
        </script>

        <!-- Main  -->
        <script src="<?php echo $params['base_theme']; ?>dark/assets/js/bootstrap.min.js"></script>
        <script src="<?php echo $params['base_theme']; ?>dark/assets/js/detect.js"></script>
        <script src="<?php echo $params['base_theme']; ?>dark/assets/js/fastclick.js"></script>
        <script src="<?php echo $params['base_theme']; ?>dark/assets/js/jquery.slimscroll.js"></script>
        <script src="<?php echo $params['base_theme']; ?>dark/assets/js/jquery.blockUI.js"></script>
        <script src="<?php echo $params['base_theme']; ?>dark/assets/js/waves.js"></script>
        <script src="<?php echo $params['base_theme']; ?>dark/assets/js/wow.min.js"></script>
        <script src="<?php echo $params['base_theme']; ?>dark/assets/js/jquery.nicescroll.js"></script>
        <script src="<?php echo $params['base_theme']; ?>dark/assets/js/jquery.scrollTo.min.js"></script>

        <script src="<?php echo $params['base_theme']; ?>dark/assets/js/jquery.app.js"></script>

	</body>
</html>