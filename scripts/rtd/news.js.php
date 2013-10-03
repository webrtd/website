<?
header('Content-Type: application/javascript');
	require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/config_terms.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/logic.php';
  require_once $_SERVER['DOCUMENT_ROOT'].'/includes/cache.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/sessionhandler.php';
	
	session_start();
	
	
	
	if (logic_is_member())
	{
		$data = fetch_news(0);
		$data['content'] = substr(strip_tags($data['content']),0,400)."...";
		echo term_unwrap("latestnews_js", $data, true);
	}
	else
	{
		echo "";
	}
	

?>