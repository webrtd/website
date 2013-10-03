<?
	/*
		content plugin (c) 3kings.dk
		
		31-10-2012	rasmus@3kings.dk	draft
		02-11-2012	rasmus@3kings.dk	rewritten as plugin based
	*/
	
	if ($_SERVER['REQUEST_URI'] == $_SERVER['PHP_SELF']) header("location: /");
	
	plugin_register('CONTENT', 'content');

	$content_plugins = array();
	$content_title = array();

	function content_plugin_register($keyword, $callback, $title='')
	{
		global $content_plugins;
		global $content_title;
		$content_plugins[$keyword] = $callback;
		$content_title[$keyword] = $title;
	}
	
	require_once $_SERVER['DOCUMENT_ROOT'].'/config_content_plugins.php';

	// handle content pane	
	function content()
	{		
		global $content_plugins;
		global $content_plugin_default;
		global $content_title;
		
		foreach ($content_plugins as $key => $callback)
		{
			if (isset($_REQUEST[$key])) 
			{
				set_title($content_title[$key]);
				return $callback();
			}
		}
		
		return $content_plugins[$content_plugin_default]();
	}


?>