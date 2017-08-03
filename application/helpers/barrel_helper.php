<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	$CI 							= get_instance();
	$GLOBALS['dir_barrel']			= @ $CI->config->item('base_url') . 'barrel/';


	/**
	 * base_barrel()
	 *
	 * Set the BARREL as the web asset directory
	 * Don't change this value if no important enough - Be careful on this method
	 *
	 * @param		string $directory
	 *
	 * @return		string $value
	 */
	if(! function_exists('base_barrel'))
	{

		function base_barrel($directory = 'frontend')
		{

			global $dir_barrel;

			$value				= array
						(
							'base_barrel'			=> $dir_barrel,
							'base_comp'				=> @ base_comp((string) FUSION_DEFAULT_THEME, $directory),
							'base_font'				=> @ base_font(),
							'base_image'			=> @ base_image(),
							'base_page'				=> @ base_page((string) FUSION_DEFAULT_THEME, $directory),
							'base_plugin'			=> @ base_plugin(),
							'base_script'			=> @ base_script(),
							'base_style'			=> @ base_style(),
							'base_theme'			=> @ base_theme((string) FUSION_DEFAULT_THEME),
							'base_theme_horizontal'	=> @ base_theme((string) FUSION_DEFAULT_THEME_BACKEND),
							'base_widget'			=> @ base_widget((string) FUSION_DEFAULT_THEME, $directory)
						);

			return ($value);

		}

	}


	/**
	 * base_comp()
	 *
	 * Set the default directory for storing component files loaded on the web view pages
	 * Located in the default BARREL directory
	 *
	 * @param		string $template
	 * @param		string $directory
	 *
	 * @return		string $value
	 */
	if(! function_exists('base_comp'))
	{

		function base_comp($template = '', $directory = 'frontend')
		{

			global $dir_barrel;

			$template			= ($template == '') ? (string) FUSION_DEFAULT_THEME : @ sanitizer_vars($template);
			return ($template . (($directory == 'backend') ? '/backend' : '') . '/components/');

		}

	}


	/**
	 * base_font()
	 *
	 * Set the default directory for storing font files
	 * Located in the default BARREL directory
	 *
	 * @param		NULL
	 * @return		string $value
	 */
	if(! function_exists('base_font'))
	{

		function base_font()
		{

			global $dir_barrel;
			return ($dir_barrel . 'fonts/');

		}

	}


	/**
	 * base_image()
	 *
	 * Set the default directory for storing image files
	 * Located in the default BARREL directory
	 *
	 * @param		NULL
	 * @return		string $value
	 */
	if(! function_exists('base_image'))
	{

		function base_image()
		{

			global $dir_barrel;
			return ($dir_barrel . 'images/');

		}

	}


	/**
	 * base_page()
	 *
	 * Set the default directory for storing web view pages
	 * Located in the default VIEW directory
	 *
	 * @param		string $template
	 * @param		string $directory
	 *
	 * @return		string $value
	 */
	if(! function_exists('base_page'))
	{

		function base_page($template = '', $directory = 'frontend')
		{

			global $dir_barrel;

			$template			= ($template == '') ? (string) FUSION_DEFAULT_THEME : @ sanitizer_vars($template);
			return ($template . (($directory == 'backend') ? '/backend' : '') . '/pages/');

		}

	}


	/**
	 * base_plugin()
	 *
	 * Set the default directory for storing additional plugin files
	 * Located in the default BARREL directory
	 *
	 * @param		NULL
	 * @return		string $value
	 */
	if(! function_exists('base_plugin'))
	{

		function base_plugin()
		{

			global $dir_barrel;
			return ($dir_barrel . 'plugins/');

		}

	}


	/**
	 * base_script()
	 *
	 * Set the default directory for storing JS and many scripting files
	 * Located in the default BARREL directory
	 *
	 * @param		NULL
	 * @return		string $value
	 */
	if(! function_exists('base_script'))
	{

		function base_script()
		{

			global $dir_barrel;
			return ($dir_barrel . 'scripts/');

		}

	}


	/**
	 * base_style()
	 *
	 * Set the default directory for storing CSS (Styles) files
	 * Located in the default BARREL directory
	 *
	 * @param		NULL
	 * @return		string $value
	 */
	if(! function_exists('base_style'))
	{

		function base_style()
		{

			global $dir_barrel;
			return ($dir_barrel . 'styles/');

		}

	}


	/**
	 * base_theme()
	 *
	 * Set the default loaded THEME (added as you want & setup by yourself)
	 * Located in the default BARREL directory
	 *
	 * @param		string $template
	 * @return		string $value
	 */
	if(! function_exists('base_theme'))
	{

		function base_theme($template = '')
		{
			// echo $template."<br>";
			// die();
			global $dir_barrel;

			// $template			= ($template == '') ? (string) "FUSION_DEFAULT_THEME" : @ sanitizer_vars($template);
			// echo "sss ".$template."<br>";
			return ($dir_barrel . 'themes/' . $template . '/');

		}

	}


	/**
	 * base_widget()
	 *
	 * Set the WIDGET shown on the frontend site
	 * Located in the default VIEW directory
	 *
	 * @param		string $template
	 * @param		string $directory
	 *
	 * @return		string $value
	 */
	if(! function_exists('base_widget'))
	{

		function base_widget($template = '', $directory = 'frontend')
		{

			global $dir_barrel;

			$template			= ($template == '') ? (string) FUSION_DEFAULT_THEME : @ sanitizer_vars($template);
			return ($template . (($directory == 'backend') ? '/backend' : '') . '/widgets/');

		}

	}