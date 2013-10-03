<?
	require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/config_terms.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/logic.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/sessionhandler.php';
	
	session_start();
	print_r($_REQUEST);
	
	if (isset($_REQUEST['club']))
	{
		$l = logic_mummy_login($_REQUEST['club'], $_REQUEST['password']);
		if ($l)
		{
			$_SESSION['mummy'] = $l;
		}
	}
	if (isset($_REQUEST['logout']))
	{
		unset($_SESSION['mummy']);
	}

	if (isset($_SESSION['mummy']))
	{
		$html = "";
		$meetings = logic_fetch_future_meetings_for_club($_SESSION['mummy']['cid']);
		$minutes = logic_fetch_minutes($_SESSION['mummy']['cid']);
		$html .= term_unwrap('club_future_meetings', $meetings, true);
		$html .= term_unwrap('club_minutes', $minutes, true);
		echo $html;		
	}
	else
	{
		echo term('mummy_login');
	}

?>