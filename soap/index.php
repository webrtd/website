<?php
	require_once('include/nusoap.php');
	chdir($_SERVER['DOCUMENT_ROOT']);

	require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/config_terms.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/logic.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/sessionhandler.php';
	session_start();


	
	$URL       = 'http://'.$_SERVER['SERVER_NAME'].'/soap/';
	$namespace = $URL . '?wsdl';


	$server    = new soap_server;

	$server->configureWSDL(str_replace('.','',$_SERVER['SERVER_NAME']), $namespace);
	
	function build_token($user)
	{
		$remote = $_SERVER['REMOTE_ADDR'];
		$server = $_SERVER['SERVER_NAME'];
		$sql = "select md5('{$remote}{$server}{$user['password']}') as token";
		$data = get_one_data_row($sql);
		return $data['token'];
	}
		
	function verify_token($token)
	{
		$remote = $_SERVER['REMOTE_ADDR'];
		$server = $_SERVER['SERVER_NAME'];
		$sql = "select uid from user where md5(concat('{$remote}{$server}',password))='{$token}'";
		$data = get_one_data_row($sql);
		if (isset($data['uid']))
		{
			return true;
		}
		else
		{
			return false;
		}		
	}
	
	function soap_search($token, $q)
	{
		if (!verify_token($token)) return false;
		return json_encode(logic_search($q));
	}

	$server->register('soap_search',
		array(
			'token' => 'xsd:string',
			'q' => 'xsd:string'
		),
		array('data' => 'xsd:string'),
		false, false, false, false, 'q = search term to query the database for.'
	);

	function soap_get_user_by_id($token, $uid)
	{
		if (!verify_token($token)) return false;
		return json_encode(logic_get_user_by_id($uid));
	}
	
	$server->register('soap_get_user_by_id',
		array(
			'token' => 'xsd:string',
			'uid' => 'xsd:int'
		),
		array('data' => 'xsd:string')
		,false, false, false, false, 'uid = user id of user to fetch.'

	);


	function soap_login($username, $password)
	{
		$data = logic_login($username, $password);
		if (is_array($data))
		{
			$data['token'] = build_token($data);
			if (isset($data['password'])) unset($data['password']);	
		}
		
		return json_encode($data);
	}
	
	$server->register('soap_login',
		array(
			'username' => 'xsd:string',
			'password' => 'xsd:string'
		),
		array('data' => 'xsd:string')
		,false, false, false, false, 'username = username or email of user to logon. password = password of user to logon.'
	);
	
	function soap_get_club($token,$cid)
	{
		if (!verify_token($token)) return false;
		return json_encode(logic_get_club($cid));
	}
	
	$server->register('soap_get_club',
		array('token'=>'xsd:string','cid' => 'xsd:int'),
		array('data' => 'xsd:string')
		,false, false, false, false, 'cid = id of specific club to get from database.'
	);
	
	function soap_get_organization_ics($token)
	{
		if (!verify_token($token)) return false;
		return logic_get_calendar_meetings_ics();
	}

	$server->register('soap_get_organization_ics',
		array('token'=>'xsd:string'),
		array('data' => 'xsd:string')
	);
	
	function soap_fetch_future_meetings_for_club($token,$cid)
	{
		if (!verify_token($token)) return false;
		return json_encode(logic_fetch_future_meetings_for_club($cid));
	}
	
	$server->register('soap_fetch_future_meetings_for_club',
			array('token'=>'xsd:string','cid' => 'xsd:int'),
			array('data' => 'xsd:string')
		,false, false, false, false, 'cid = club id to fetch meetings for.'
	);

	// cid ==> meeting cid, accept ==> 1=yes, 0=no
	function soap_save_meeting_attendance($token, $cid, $mid, $uid, $accept, $comment)
	{
		if (!verify_token($token)) return false;
		return json_encode(logic_save_meeting_attendance($cid, $mid,$uid,$accept,$comment));
	}
	
	$server->register('soap_save_meeting_attendance',
			array(	'token'=>'xsd:string',
						'cid' => 'xsd:int',
						'mid' => 'xsd:int',
						'uid' => 'xsd:int',
						'accept' => 'xsd:int',
						'comment' => 'xsd:string'),
			array('data' => 'xsd:string')
			,false, false, false, false, 'cid = club id of arranging club. mid = meeting id. uid = user id. accept = 1 means accept, 0 means decline. comment = reason for declining/accepting.'

	);
	
	
	function soap_get_news($token)
	{
		if (!verify_token($token)) return false;
		return json_encode(logic_get_news(0,5));
	}

	$server->register('soap_get_news',
			array('token'=>'xsd:string'),
			array('data' => 'xsd:string')
	);
	
	

	function soap_get_meeting_attendance($token, $mid)
	{
		if (!verify_token($token)) return false;
		return json_encode(fetch_meeting_attendance($mid));
	}

	$server->register('soap_get_meeting_attendance',
			array('token'=>'xsd:string','mid' => 'xsd:int'),
			array('data' => 'xsd:string')
			,false, false, false, false, 'mid = meeting id of meeting to fetch.'

	);
	
	function soap_get_meeting($token,$mid)
	{
		if (!verify_token($token)) return false;
		return json_encode(logic_get_meeting($mid));
	}
	
	$server->register('soap_get_meeting',
			array('token'=>'xsd:string','mid' => 'xsd:int'),
			array('data' => 'xsd:string')
			,false, false, false, false, 'mid = meeting id of meeting to fetch.'

	);
	

	$server->service(file_get_contents('php://input'));
	exit();
?>