<?
	chdir($_SERVER['DOCUMENT_ROOT']);
	require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/config_terms.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/logic.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/sessionhandler.php';
	
	session_start();

	if (logic_is_member())
	{
		$aid = $_REQUEST['aid'];
		$f= logic_get_article_files($aid,false);
		echo term_unwrap('js_article_files', $f, true);
	}
	else
	{
		echo term('article_must_be_logged_in');
	}
?>