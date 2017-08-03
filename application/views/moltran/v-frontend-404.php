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

        <script src="<?php echo $params['base_theme']; ?>dark/assets/js/modernizr.min.js"></script>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->


    </head>
    <body>


        <div class="wrapper-page">
            <div class="ex-page-content text-center">
                <h1>404</h1>
                <h2>Maaf, halaman tersebut tidak ditemukan</h2><br />
                <a class="btn btn-purple waves-effect waves-light" href="<?php echo @ site_url('frontend/dashboard'); ?>"><i class="fa fa-angle-left"></i> Kembali ke Dashboard</a>
            </div>
        </div>


    	<script>
            var resizefunc = [];
        </script>

        <!-- Main  -->
        <script src="<?php echo $params['base_theme']; ?>dark/assets/js/jquery.min.js"></script>
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