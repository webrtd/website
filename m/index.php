<?
	require_once '../config.php';
	require_once '../config_terms.php';
	require_once '../includes/logic.php';
	require_once '../includes/sessionhandler.php';

	if (!session_start())
	{
		die("Error starting PHP session!");
	}

	setlocale(LC_ALL,RT_LOCALE);
  
  $mobile_plugins = array();
	function mobile_plugin_register($keyword, $callback)
	{
		global $mobile_plugins;
		$mobile_plugins[$keyword] = $callback;
	}
  require_once '../config_mobile_plugins.php';
    
  $template_html = file_get_contents(RT_TEMPLATE_MOBILE);
	
  foreach ($mobile_plugins as $keyword => $callback)
	{
		$value = $callback();
		$template_html = str_replace("%%$keyword%%", $value, $template_html);
	}
	
	function get_title()
	{
		return "RTD Mobil";
	}

  echo $template_html;
  if (logic_is_member()) logic_update_last_page_view();
?>