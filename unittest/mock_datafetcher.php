<?
$call_count_mock = 0;

function DBCallCountIncrease()
{
	global $call_count_mock;
	$call_count_mock++;
}

function DBCallCountGet()
{
	global $call_count_mock;
	return $call_count_mock;
}

function DBCallCountReset()
{
	global $call_count_mock;
	$call_count_mock = 0;
}

function fetch_active_roles($uid)
{
	DBCallCountIncrease();
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
	DBCallCountIncrease();
	return array(
		array("mid"=>1)
	);
}

function delete_other_meeting($omid)
{
	DBCallCountIncrease();
}

function put_other_meeting($cid,$t,$d,$l,$s,$e)
{
	DBCallCountIncrease();
}


?>