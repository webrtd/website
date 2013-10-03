<?
	header('Content-type: '.$_REQUEST['m']);
	die(file_get_contents($_REQUEST['i'].".data"));

?>