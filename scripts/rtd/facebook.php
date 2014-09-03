<?
  chdir($_SERVER['DOCUMENT_ROOT']);
	require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/config_terms.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/logic.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/sessionhandler.php';
	session_start();

	$user = logic_login($_REQUEST['email'],'',true);
	if ($user)
	{
		$_SESSION['user'] = $user;
		echo json_encode(true);
	}
	else
	{
		echo json_encode(false);
	}

?>