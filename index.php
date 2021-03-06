<?
	require_once 'config.php';
	require_once 'config_terms.php';
	require_once './includes/logic.php';
	require_once './includes/cache.php';
	require_once './includes/sessionhandler.php';

	if (defined("FORCE_SECURE_CONNECTION") && FORCE_SECURE_CONNECTION)
	{
		if (empty($_SERVER['HTTPS']))
		{
			header("location: https://{$_SERVER['SERVER_NAME']}");
			die();
		}
	}
	
	
	$plugins = array();
	$title = '--NOT SET--';
	
	function set_title($t)
	{
		global $title;
		$title = $t;
	}
	
	function get_title()
	{
		global $title;
		return $title;
	}


	function plugin_register($keyword, $callback)
	{
		global $plugins;
		$plugins[$keyword] = $callback;
	}

  
	function sanitize_output($buffer)
	{
	    $search = array(
	        '/\>[^\S ]+/s', //strip whitespaces after tags, except space
	        '/[^\S ]+\</s', //strip whitespaces before tags, except space
	        '/(\s)+/s'  // shorten multiple whitespace sequences
	        );
	    $replace = array(
	        '>',
	        '<',
	        '\\1'
	        );
	    $buffer = preg_replace($search, $replace, $buffer);
	
	    return $buffer;
	}
	
	require_once './config_plugins.php';
	
	if (!session_start())
	{
		die("Error starting PHP session!");
	}


	setlocale(LC_ALL,RT_LOCALE);
  
	
  
  if (isset($_REQUEST['print']))
  {
    $template_html = file_get_contents(RT_TEMPLATE_PRINT);
  }
  else
  {
	$template_html = file_get_contents(RT_TEMPLATE);
  }
	
	foreach ($plugins as $keyword => $callback)
	{
		$value = $callback();
		$template_html = str_replace("%%$keyword%%", $value, $template_html);
	}
	
	logic_update_tracker();
	if (logic_is_member()) logic_update_last_page_view();
	
	$template_html = str_replace("%%TITLE%%", $title, $template_html);
	
	echo $template_html;
	
	// echo "<!---- ".print_r($_SESSION,true)."--->";

?>