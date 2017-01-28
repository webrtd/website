<?

	chdir($_SERVER['DOCUMENT_ROOT']);
	require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/config_terms.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/logic.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/sessionhandler.php';

	
	$clubs = fetch_search_clubs("RT{$_REQUEST['klub']} -");
	
	if (sizeof($clubs)!=1)
	{
		die("Kan ikke finde {$_REQUEST['klub']}");
	}
	
	$club = $clubs[0];
	
	$meeting = array();
	$meeting['title'] = $_REQUEST['dato'];
	$meeting['cid'] = $club['cid'];
	$meeting['start_time'] = $meeting['end_time'] = $_REQUEST['dato'];
	
	$desc = "<!--- ".utf8_encode(utf8_decode($_REQUEST['ocr']))." --->";

	$meeting['description'] = $desc;
	
	$mid = save_meeting($meeting, -1);
	
	logic_upload_meeting_file($_FILES['pdf'], $mid);
	
	logic_finish_meeting_minutes($mid, false);
	
	
	echo "<script>document.location.href='/?mid={$mid}';</script>";
?>