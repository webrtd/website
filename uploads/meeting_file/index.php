<?
/*
	file fetcher
	
	02-01-2013	rasmus@3kings.dk 	draft
*/
			
  chdir($_SERVER['DOCUMENT_ROOT']);
	require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/config_terms.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/logic.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/sessionhandler.php';
	
	session_start();
	

	if (logic_is_member() || logic_is_mummy())
	{
		$filepath = logic_get_meeting_file($_REQUEST['mfid']);
    $fi = new finfo(FILEINFO_MIME);
    $data = file_get_contents($filepath);
    $mime = $fi->buffer($data);
    $mime = explode(";",$mime);
    $mime = $mime[0];
    $fn = basename($filepath);
    $size = strlen($data);
    //echo $mime;
    header("Content-Type: $mime");
    header("Content-Disposition: attachment; filename=\"$fn\"");
    header("Content-length: $size");
    die($data);
     //header("location: $filepath");

	}
	else
	{
		
		echo term('article_must_be_logged_in');
	}

?>