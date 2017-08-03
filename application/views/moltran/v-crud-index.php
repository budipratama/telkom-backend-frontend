<html>
	<head>
		<meta charset="utf-8" />
    	<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<?php
			if(is_object($output)) :
				foreach($output->css_files as $file): ?>
					<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
		<?php
				endforeach;
			endif;
		?>
		<?php
			if(is_object($output)) :
				foreach($output->js_files as $file): ?>
					<script src="<?php echo $file; ?>"></script>
		<?php
				endforeach;
			endif;
		?>
	</head>
	<body>
		<?php
			echo $output->output;
		?>
	</body>
</html>