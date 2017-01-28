<meta http-equiv="refresh" content="1">
<?

	chdir($_SERVER['DOCUMENT_ROOT']);

	require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/config_terms.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/logic.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/sessionhandler.php';

		
		echo get_html_table("select ts,logtext,section from log  order by lid desc limit 25");
//	echo get_html_table("select ts,logtext from log where section='soap_remote_debug' order by lid desc limit 25");
	
?>