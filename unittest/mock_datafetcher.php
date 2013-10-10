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
function update_club($cid,$data)
{
	DBCallCountIncrease();
}

function mock_build_user()
{
	return array(
		'uid' => 1,
		'username' => 'test',
		'cid' => 1,
		'password' => md5('test')
	);
}

function fetch_user_by_username($un)
{
	DBCallCountIncrease();
	if ($un=="test") return mock_build_user();
	return false;
}

function fetch_user_by_private_email($email)
{
	DBCallCountIncrease();
	if ($email="private@test.com") return mock_build_user();
	return false;
}
function fetch_user_by_company_email($email)
{
	DBCallCountIncrease();
	if ($email="company@test.com") return mock_build_user();
	return false;
}

function store_log($ip,$sec,$t)
{
	DBCallCountIncrease();
//	echo "<i>{$ip}/{$sec}: $t</i>";
}

function save_mail($to,$subj,$body,$a=0,$b=0,$c=0)
{
	DBCallCountIncrease();
}

?>