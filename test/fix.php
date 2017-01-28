<?
	session_start();
	chdir($_SERVER['DOCUMENT_ROOT']);
	require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/config_terms.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/logic.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/sessionhandler.php';



//honorary	$users = get_data("select uid,(select cid from user where user.uid=role.uid) as cid from role where role.rid=26 and role.start_date<now() and role.end_date>now()");
	$users = get_data("select uid,(select cid from user where user.uid=role.uid) as cid from role where role.rid=33 and role.start_date<now() and role.end_date>now()");
	for ($i=0; $i<sizeof($users); $i++)
	{
		$u = $users[$i];
		$uid = $u['uid'];
		$cid = $u['cid'];
		echo "<li>{$uid}. ";
		logic_decline_future_meetings($uid,$cid);
		
		
		
		/*
    $meetings = logic_fetch_future_meetings_for_club($cid,"asc",100,false);
    foreach ($meetings as $m)
    {
		$mid = $m['mid'];
		save_meeting_attendance($mid,$uid,1,"");
	}		*/
	}
	
	
	
?>