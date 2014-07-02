<?
	require_once '../../config.php';
	require_once '../../config_terms.php';
	require_once '../../includes/logic.php';
	require_once '../../includes/sessionhandler.php';
	
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