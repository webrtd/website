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
	/*
    $m = cache_get("latest_members");
    if (!$m)
    {
      $m = logic_get_latest_members();
      cache_put("latest_members", $m);
    }
		*/
		$data = logic_get_random_user();
		echo term_unwrap("randomuser_js", $data);
	}
	else
	{
		echo "";
	}
	

?>