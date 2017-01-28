<?
/*
	mapping definition for role definitions from CSV to CLUB table
	
	format:
	$mapping[<field name in csv>]=<field name in ROLE table>
	
	28-10-2012	rasmus@3kings.dk draft
*/

$destination_table = "role_definition";
$mapping = array();
$mapping[rid] = "rid";
$mapping[name] = "shortname";
?>
