<?
  header('Content-Type: application/javascript');
	chdir($_SERVER['DOCUMENT_ROOT']);
  require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/config_terms.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/logic.php';
  require_once $_SERVER['DOCUMENT_ROOT'].'/includes/cache.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/sessionhandler.php';
	
	session_start();
	
	
	
	if (logic_is_member())
	{
		$data = fetch_news(0,false,7);
		$did = logic_get_district_for_user($_SESSION['user']['uid']);
		if (isset($_REQUEST['beta'])) print_r($data);
		echo term_unwrap("latestnews_js", $data, true);
	
	}
	else
	{
		echo "";
	}
	

?>