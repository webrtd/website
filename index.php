<?
	/*
	if (!isset($_REQUEST['down']))
	{
		die("<title>Jamen, jamen...</title><h1>Kom tilbage...</h1><p>Vi opdaterer pt. serveren - kom tilbage senere</p><p>MVH Rasmus, WEB</p>");
	}*/
	require_once 'config.php';
	require_once 'config_terms.php';
	require_once './includes/logic.php';
	require_once './includes/cache.php';
	require_once './includes/sessionhandler.php';

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
	if (isset($_SESSION['theme']) || isset($_REQUEST['theme']))
	{
		if (isset($_REQUEST['theme'])) $_SESSION['theme'] = $_REQUEST['theme'];
		$template_html = file_get_contents($_SESSION['theme']);
	}
	else
	{
		$template_html = file_get_contents(RT_TEMPLATE);
	}
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