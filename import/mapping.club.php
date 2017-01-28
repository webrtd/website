<?
/*
	mapping definition for importing data from CSV to CLUB table
	
	format:
	$mapping[<field name in csv>]=<field name in CLUB table>
	
	26-10-2012	rasmus@3kings.dk draft
*/

$destination_table = "club";
$mapping = array();
$mapping[tid] = "cid";
$mapping[title] = "name";
$mapping[body] = "description";
$mapping[field_klub_moedested_value] = "meeting_place";
$mapping[field_klub_moedetid_value] = "meeting_time";
$mapping[field_klub_hjemmeside_value] = "webpage";
$mapping[field_klub_stiftet_value] = "charter_date";
$mapping[field_klub_stiftetaf_nid] = "charter_club_cid";
$mapping[tid2] = "district_did";
?>
