<?
/*
	mapping definition for meeting files
	
	format:
	$mapping[<field name in csv>]=<field name in ... table>
	
	02-01-2013	rasmus@3kings.dk draft
*/

$destination_table = "meeting_file";
$mapping = array();
$mapping[nid] = "mid";
$mapping[fid] = "mfid";
$mapping[filename] = "filename";
$mapping[filepath] = "filepath";
?>
