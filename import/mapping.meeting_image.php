<?
/*
	mapping definition for role definitions from CSV to meeting images table
	
	format:
	$mapping[<field name in csv>]=<field name in ... table>
	
	30-10-2012	rasmus@3kings.dk draft
*/

$destination_table = "meeting_image";
$mapping = array();
$mapping[nid] = "mid";
$mapping[filename] = "filename";
$mapping[filepath] = "filepath";
?>
