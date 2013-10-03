<?
// header('Content-Type: application/javascript');
	require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/config_terms.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/logic.php';
  require_once $_SERVER['DOCUMENT_ROOT'].'/includes/cache.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/sessionhandler.php';
	
	session_start();
	
	
	
	if (logic_is_member())
	{
		$m = false;//cache_get("birthday_members");
		if (!$m)
		{
		  $m = logic_get_club_birthdays(false,true);
		  cache_put("birthday_members", $m);
		}
		
		echo term_unwrap("birthday_js", $m, true);
	}
	else
	{
		echo "";
	}
	

?>