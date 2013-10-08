<?
function fetch_active_roles($uid)
{
	if ($uid == 1)
	{
		return array (
			array("rid"=>HONORARY_RID)
		);
	}
	else
	{
		return array();
	}
}

function get_other_meetings($cid)
{
	return array(
		array("mid"=>1)
	);
}
?>