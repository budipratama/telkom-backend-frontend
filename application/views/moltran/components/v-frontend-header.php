			<meta charset="utf-8">
			<meta name="viewport" content="width=device-width,initial-scale=1">

			<title><?php echo $headers['title']; ?></title>

			<meta name="keywords" content="<?php echo $headers['meta_key']; ?>" />
			<meta name="description" content="<?php echo $headers['meta_desc']; ?>" />
			<meta name="author" content="<?php echo $headers['author']; ?>" />
			<meta name="codename" content="<?php echo $headers['codename']; ?>" />

			<link rel="shortcut icon" href="<?php echo $params['base_image'] . 'favicon.png'; ?>" />

			<?php
				if(! empty($output)) :
					foreach($output->css_files as $file): ?>
						<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
			<?php
					endforeach;
				endif;
			?>

	        <!--Form Wizard-->
			<link href="<?php echo $params['base_style']; ?>jquery.steps.css" rel="stylesheet" type="text/css" />

			<link href="<?php echo $params['base_theme']; ?>dark/assets/plugins/sweetalert/dist/sweetalert.css" rel="stylesheet" type="text/css" />

	        <!--venobox lightbox-->
	        <link href="<?php echo $params['base_theme']; ?>dark/assets/plugins/magnific-popup/dist/magnific-popup.css" rel="stylesheet" />

	        <!-- Plugins css-->
	        <link href="<?php echo $params['base_theme']; ?>dark/assets/plugins/tagsinput/jquery.tagsinput.css" rel="stylesheet" />
	        <link href="<?php echo $params['base_theme']; ?>dark/assets/plugins/toggles/toggles.css" rel="stylesheet" />
	        <link href="<?php echo $params['base_theme']; ?>dark/assets/plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet" />
	        <link href="<?php echo $params['base_theme']; ?>dark/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet" />
	        <link href="<?php echo $params['base_theme']; ?>dark/assets/plugins/colorpicker/colorpicker.css" rel="stylesheet" type="text/css" />
	        <link href="<?php echo $params['base_theme']; ?>dark/assets/plugins/jquery-multi-select/multi-select.css" rel="stylesheet" type="text/css" />
	        <link href="<?php echo $params['base_theme']; ?>dark/assets/plugins/select2/dist/css/select2.css" rel="stylesheet" type="text/css" />
	        <link href="<?php echo $params['base_theme']; ?>dark/assets/plugins/select2/dist/css/select2-bootstrap.css" rel="stylesheet" type="text/css" />
	        <link href="<?php echo $params['base_theme']; ?>dark/assets/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />

	        <!-- DataTables -->
	        <link href="<?php echo $params['base_theme']; ?>dark/assets/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
	        <link href="<?php echo $params['base_theme']; ?>dark/assets/plugins/datatables/buttons.bootstrap.min.css" rel="stylesheet" type="text/css" />
	        <link href="<?php echo $params['base_theme']; ?>dark/assets/plugins/datatables/fixedHeader.bootstrap.min.css" rel="stylesheet" type="text/css" />
	        <link href="<?php echo $params['base_theme']; ?>dark/assets/plugins/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css" />
	        <link href="<?php echo $params['base_theme']; ?>dark/assets/plugins/datatables/scroller.bootstrap.min.css" rel="stylesheet" type="text/css" />

			<link href="<?php echo $params['base_theme']; ?>dark/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
			<link href="<?php echo $params['base_theme']; ?>dark/assets/css/core.css" rel="stylesheet" type="text/css" />
			<link href="<?php echo $params['base_theme']; ?>dark/assets/css/icons.css" rel="stylesheet" type="text/css" />
			<link href="<?php echo $params['base_theme']; ?>dark/assets/css/components-red.css" rel="stylesheet" type="text/css" />
			<link href="<?php echo $params['base_theme']; ?>dark/assets/css/pages.css" rel="stylesheet" type="text/css" />
			<link href="<?php echo $params['base_theme']; ?>dark/assets/css/menu.css" rel="stylesheet" type="text/css" />
			<link href="<?php echo $params['base_theme']; ?>dark/assets/css/responsive.css" rel="stylesheet" type="text/css" />

	         <!-- Plugins css -->
	        <link href="<?php echo $params['base_theme']; ?>dark/assets/plugins/modal-effect/css/component.css" rel="stylesheet">

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

			<?php
				if(! empty($output)) :
					foreach($output->js_files as $file): ?>
						<script src="<?php echo $file; ?>"></script>
			<?php
					endforeach;
				endif;
			?>

			<script src="<?php echo $params['base_theme']; ?>dark/assets/js/modernizr.min.js"></script>

			<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
			<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
			<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
			<![endif]-->

			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("div#refresh-captcha").on("click", function() {
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
					});

			        var $body = $('body'),
			        $modalTriggers = $('a.modalTrigger'),

			        openModal = function(evt) {
			              var $trigger = $(this),
			              modalPath = $trigger.attr('href'),
			              $newModal,

			              removeModal = function(evt) {
			                    $newModal.off('hidden.bs.modal');
			                    $newModal.remove();
			              },

			              showModal = function(data) {
			                    $body.append(data);
			                    $newModal = $('.md-modal').last();
			                    $newModal.modal('show');
			                    $newModal.on('hidden.bs.modal', removeModal);
			              };

			              $.get(modalPath,showModal);

			              evt.preventDefault();
			        };

			        $modalTriggers.on('click',openModal);
				});
			</script>