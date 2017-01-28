<?
/*
	mapping definition for role from CSV to ROLE table
	
	format:
	$mapping[<field name in csv>]=<field name in ROLE table>
	
	28-10-2012	rasmus@3kings.dk draft
*/

$destination_table = "role";
$mapping = array();
$mapping[rid] = "rid";
$mapping[uid] = "uid";
?>
