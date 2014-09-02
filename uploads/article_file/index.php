<?
/*
	article file fetcher
	
	23-12-2012	rasmus@3kings.dk 	draft
*/
			
  chdir($_SERVER['DOCUMENT_ROOT']);
  
	require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/config_terms.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/logic.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/sessionhandler.php';
	
	session_start();

	if (!isset($_REQUEST['afid']) || !is_numeric($_REQUEST['afid']))
	{
		header("location: /");
		die();
	}

	$f = get_article_file($_REQUEST['afid']);
	$fn = ARTICLE_FILE_UPLOAD_PATH.$f['aid']."/".$f['filename'];
	$mime = $f['mimetype'];
	
	$article = logic_get_article($f['aid']);
//	if ($article['public'] || logic_is_member())
	{
		header("Content-type: $mime"); 
    header("Content-Disposition: attachment; filename=\"{$f['filename']}\"");		
		header('Content-Transfer-Encoding: binary'); 	
		readfile($fn);
	}
//	else
	{
	//	die(term('article_must_be_logged_in'));
	}
?>