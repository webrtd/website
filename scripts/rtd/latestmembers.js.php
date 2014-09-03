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
    $m = cache_get("latest_members");
//    if (!$m)
    {
      $m = logic_get_latest_members();
      cache_put("latest_members", $m);
    }
		
		echo term_unwrap("latestmembers_js", $m, true);
	}
	else
	{
		echo "";
	}
	

?>