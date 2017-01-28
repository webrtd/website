<?
/*
	mapping definition for importing data from CSV to MEETING table
	
	format:
	$mapping[<field name in csv>]=<field name in USER table>
	
	29-10-2012	rasmus@3kings.dk draft
	02-11-2012	rasmus@3kings.dk added diverse labels

create table if not exists meeting (
cid int unsigned,



description blob,

duty_meeting_responsible_uid int default null,

duty_ext2_text varchar(32) default '',
duty_ext2_uid int default null,
duty_ext3_text varchar(32) default '',
duty_ext3_uid int default null,
duty_ext4_text varchar(32) default '',
duty_ext4_uid int default null,
duty_ext5_text varchar(32) default '',
duty_ext5_uid int default null,

minutes_3min	blob,
minutes_letters	blob,

minutes_number_of_participants int,
minutes_number_of_rejections int
)


*/

$destination_table = "meeting";
$mapping = array();
$mapping[nid] = "mid";
$mapping[tid] = "cid";

$mapping[field_date_value] = "start_time";
$mapping[field_date_value2] = "end_time";

$mapping[title] = "title";
$mapping[field_event_referat_value] = "minutes";
$mapping[field_event_sted_value] = "location";
$mapping[field_event_refdato_value] = "minutes_date";


$mapping[field_event_brev1uid_value] = "duty_letters1_uid";
$mapping[field_event_brev2uid_value] = "duty_letters2_uid";
$mapping[field_event_3minuid_value] = "duty_3min_uid";
$mapping[field_event_diverse1uid_value] = "duty_ext1_uid";
$mapping[field_event_diverse2uid_value] = "duty_ext2_uid";
$mapping[field_event_beskrivelse1_value] = "duty_ext1_text";
$mapping[field_event_beskrivelse2_value] = "duty_ext2_text";


?>