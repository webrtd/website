<?
	chdir($_SERVER['DOCUMENT_ROOT']);
	require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/config_terms.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/logic.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/sessionhandler.php';
	
	session_start();

	function pull_data_from_rtidatahub($data)
	{
		$url = "http://rtidatahub.org/api/widget/";
		$apikey = RTIDATAHUB_APIKEY;
		return file_get_contents("{$url}?apikey={$apikey}&data={$data}");
	}

	if (logic_is_member())
	{
		$nb = pull_data_from_rtidatahub("NATIONALBOARD");
		$m = pull_data_from_rtidatahub("MEETING");
		$table = pull_data_from_rtidatahub("TABLE");

		$data = array(
			"NATIONALBOARD" => addslashes($nb),
			"MEETING" => addslashes($m),
			"TABLE" => addslashes($table)
		); 
		
		echo term_unwrap("rtidatahub_js", $data);
		
	
	}
	else
	{
		echo term('article_must_be_logged_in');
	}
?>