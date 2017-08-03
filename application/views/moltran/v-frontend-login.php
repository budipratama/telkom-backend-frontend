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
                    <h3 class="text-center m-t-10 text-white"><strong><?php echo FUSION_PLATFORM_NAME; ?></strong> - Simple Dashboard</h3>
                </div>

                <div class="panel-body">

					<?php $this->load->view($params['base_widget'] . 'v-widget-alert'); ?>

	                <form method="post" class="form-horizontal m-t-20" action="<?php echo @ site_url('authentication/user/sign-in'); ?>">

	                    <div class="form-group">
	                        <div class="col-xs-12">
	                            <input autocomplete="off" readonly="readonly" onfocus="this.removeAttribute('readonly');" maxlength="100" name="userid" class="form-control input-lg" type="text" required="required" placeholder="Masukkan User ID anda" />
	                        </div>
	                    </div>

	                    <div class="form-group">
	                        <div class="col-xs-12">
	                            <input autocomplete="off" readonly="readonly" onfocus="this.removeAttribute('readonly');" maxlength="100" name="password" class="form-control input-lg" type="password" required="required" placeholder="Masukkan Password anda" />
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
										<input autocomplete="off" readonly="readonly" onfocus="this.removeAttribute('readonly');" name="danraCaptcha" id="danraCaptcha" type="text" maxlength="4" value="" required="required" placeholder="Masukkan Kode Keamanan" class="form-control input-lg" style="width: 100%; padding-left: 10px;" />
									</div>
								</div>
							</div>
						</div>

	                    <div class="form-group text-center m-t-30">
	                        <div class="col-xs-12">
	                            <button class="btn btn-danger btn-lg w-lg waves-effect waves-light" type="submit">Log In</button>
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