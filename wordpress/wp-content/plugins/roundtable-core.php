<?php
/**
 * @package RoundTable-Core
 * @version 1.0
 */
/*
Plugin Name: RoundTable Core
Plugin URI: http://rtd.dk
Description: Round Table Wordpress Core Integration
Author: Rasmus Kaae
Version: 1.0
Author URI: http://3kings.dk
*/


function rt_replace($content, $handler)
{
	foreach($handler as $key=>$value)
	{
		if (!is_array($value))
		{
			$content = str_replace("%%rt_{$key}%%", $value, $content);
		}
	}
	return $content;
}

function rt_user_content($content)
{
	if (strpos($content, "!!rt_user")!==false && !isset($_SESSION['user']))
	{
		return "Not logged in";
	}
	else
	{
		$content = str_replace("!!rt_user", "", $content);
	}


	$plugs = array(
		"latestmembers" => "<div id='latestmembers'></div><script src='/scripts/rtd/latestmembers.js.php'></script>",
		"news" => "<div id='news'></div><script src='/scripts/rtd/news.js.php'></script>"		
	);


	if (strpos($content,"%%")!==false)
	{
		$content = rt_replace($content, $plugs);
	
		if (isset($_SESSION['user']))
		{	
			$content = rt_replace($content, $_SESSION['user']);
		}
	}

	return $content;
}

function rt_plugin_menu()
{
	add_menu_page('RoundTable Core Options', 'RoundTable Core', 'manage_options', 'rt-core-options', 'rt_plugin_options');
}

function rt_plugin_options()
{
	if ( !current_user_can( 'manage_options' ) )  
	{
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	echo '<div class="wrap">';
	echo '<p>Short instructions:<ul><ul><li>Use "!!rt_user" on any page to restrict content to logged in users<li>Use "%%latestmembers%%" to show latest members chunk<li>Use "%%news%%" to show latest news<li>Or use "%%??%%" where ?? is a session variable to display</ul></ul></p>';
	echo '</div>';
}




add_action('admin_menu', 'rt_plugin_menu');
add_filter( 'the_content', 'rt_user_content' );


?>