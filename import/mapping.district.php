<?
/*
	mapping definition for importing data from CSV to DISTRICT table
	
	format:
	$mapping[<field name in csv>]=<field name in DISTRICT table>
	
	26-10-2012	rasmus@3kings.dk draft
*/

$destination_table = "district";
$mapping = array();
$mapping[tid] = "did";
$mapping[name] = "name";
$mapping[description] = "description";
?>