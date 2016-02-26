<?php
	session_start();
	
	require_once('include/nusoap.php');
	chdir($_SERVER['DOCUMENT_ROOT']);

	require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/config_terms.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/logic.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/sessionhandler.php';


	
	$URL       = 'http://'.$_SERVER['SERVER_NAME'].'/soap/';
	$namespace = $URL . '?wsdl';


	$server    = new soap_server;

	$server->configureWSDL(str_replace('.','',$_SERVER['SERVER_NAME']), $namespace);
	
	
	function build_token($user)
	{
		$token_salt = "1-2-3-I-LOVE-RTD";
		$uid = $user['uid'];
		$str = $token_salt.$user['password'];
		$sql = "select md5(concat('{$token_salt}',password,uid)) as token from user where uid={$uid}";
		
		logic_log(__FUNCTION__, $sql);
		
		$data = get_one_data_row($sql);
		return $data['token'];
	}
	
	function get_title()
	{
		return "RTDapp";
	}
		
	function verify_token($token)
	{
		$token_salt = "1-2-3-I-LOVE-RTD";
		$sql = "select uid,username,password from user where STRCMP(md5(concat('{$token_salt}',password,uid)),'{$token}')=0";
		$data = get_one_data_row($sql);
		if (isset($data['uid'])) 
		{
			$_SESSION['user'] = logic_login($data['username'], $data['password'], true);
			logic_update_last_page_view();
			return true;
		}
		else
		{
			logic_log(__FUNCTION__, 'Bad token');
			session_destroy();
			session_start();
			return false;
		}		
	}
	
	function soap_put_image($mid, $base64image, $token)
	{
		logic_log(__FUNCTION__, "mid: {$mid} img: {$base64image}");
		if (!verify_token($token))
		{
			logic_log(__FUNCTION__, "bad token {$token}");
			return false;
		}
		else
		{
			logic_log(__FUNCTION__, "mid: {$mid} img: {$base64image}");

			$imgdata = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64image));
			$ts = time();

			$outputname = "{$_SESSION['user']['uid']}-{$ts}.jpg";

			$folder =MEETING_IMAGES_UPLOAD_PATH.$mid;
			if (!is_dir(MEETING_IMAGES_UPLOAD_PATH.$mid))
			{
				assert(mkdir($folder,0777));
			}
			$fn = $folder."/".$outputname;
			
			save_meeting_image($fn, $outputname, $mid);


			
			file_put_contents($fn, $imgdata);
			
			return true;
		}
	}
	$server->register('soap_put_image', 
		array(
			'mid' => 'xsd:string',
			'base64image' => 'xsd:string',
			'token' => 'xsd:string',
		),
		array('data' => 'xsd:string')
		,false, false, false, false, ''

	);
	
	function soap_get_duties($uid, $token)
	{
		if (!verify_token($token))
		{
			return false;
		}
		else
		{
			$data = json_encode(logic_get_duties($uid));
			logic_log(__FUNCTION__, $data);
			return $data;
		}
	}
	$server->register('soap_get_duties', 
		array(
			'token' => 'xsd:string',
			'uid' => 'xsd:string'
		),
		array('data' => 'xsd:string')
		,false, false, false, false, 'uid = user id.'

	);
	
	function soap_remote_debug($msg, $token)
	{
		if (!verify_token($token)) 
		{
			return false;
		}
		else
		{
			logic_log(__FUNCTION__, $msg);
		}
	}
	$server->register('soap_remote_debug', 
		array(
			'token' => 'xsd:string',
			'msg' => 'xsd:string'
		),
		array('data' => 'xsd:string')
		,false, false, false, false, 'msg = log msg.'

	);
	
	function soap_update_geolocation($lat, $lng, $token)
	{
		if (!verify_token($token)) 
		{
			return false;
		}
		logic_log(__FUNCTION__, "({$lat}, {$lng})");
		logic_update_geolocation($lat, $lng);
		return true;
	}
	
	$server->register('soap_update_geolocation', 
		array(
			'token' => 'xsd:string',
			'lat' => 'xsd:string',
			'lng' => 'xsd:string'
		),
		array('data' => 'xsd:string')
		,false, false, false, false, 'cid = club id of club to fetch.'

	);

	function soap_get_geolocation_latest($token)
	{
		if (!verify_token($token)) 
		{
			logic_log("soap_get_geolocation_latest", "bad token");
			return false;
		}
		logic_log(__FUNCTION__, "");
		$data = logic_get_geolocation_latest();
		return json_encode($data);
	}
	
	$server->register('soap_get_geolocation_latest', 
		array(
			'token' => 'xsd:string'
		),
		array('data' => 'xsd:string')
		,false, false, false, false, ''

	);
	
	
	function soap_get_roles($uid,$token)
	{
		if (!verify_token($token)) return false;
		logic_log(__FUNCTION__, $uid);
		return json_encode(logic_get_roles($uid));
	}
	$server->register('soap_get_roles', 
		array(
			'token' => 'xsd:string',
			'uid' => 'xsd:int'
		),
		array('data' => 'xsd:string')
		,false, false, false, false, 'uid = user id of user to fetch.'

	);
	
	function soap_get_active_club_members($cid, $token)
	{
		if (!verify_token($token)) return false;
		put_user_path_tracker($_SESSION['user']['uid'],'RTDApp - klub');
		logic_log(__FUNCTION__, $cid);
		return json_encode(logic_get_active_club_members($cid));
	}
	
	$server->register('soap_get_active_club_members', 
		array(
			'token' => 'xsd:string',
			'cid' => 'xsd:int'
		),
		array('data' => 'xsd:string')
		,false, false, false, false, 'cid = club id of club to fetch.'

	);
	
	
	function soap_get_user_year_details_stats($token,$uid)
	{
		if (!verify_token($token)) return false;
		logic_log(__FUNCTION__, $uid);
		$stats = logic_get_user_year_details_stats($uid);
		return json_encode($stats);
	}
	$server->register('soap_get_user_year_details_stats',
		array(
			'token' => 'xsd:string',
			'uid' => 'xsd:int'
		),
		array('data' => 'xsd:string'),
		false, false, false, false, 'uid = uid to query the database for.'
	);
	
	function soap_search($q, $token)
	{
		if (!verify_token($token)) return false;
		put_user_path_tracker($_SESSION['user']['uid'],'RTDApp - søg');
		logic_log(__FUNCTION__, $q);

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
	
	function soap_get_geodata($token, $lat,$lng)
	{
		if (!verify_token($token)) return false;
		put_user_path_tracker($_SESSION['user']['uid'],'RTDApp - geodata');
		logic_log(__FUNCTION__, "({$lat},{$lng})");
		$data = logic_get_geodata($lat, $lng);
		for ($i=0; $i<sizeof($data); $i++)
		{
			$d = $data[$i];
			$u = logic_get_user_by_id($d['refid']);
			
			$data[$i]['profile_firstname'] = $u['profile_firstname'];
			$data[$i]['profile_lastname'] = $u['profile_lastname'];
		}
		
		return json_encode($data);
	}
	
	$server->register('soap_get_geodata',
		array(
			'token' => 'xsd:string',
			'lat' => 'xsd:string',
			'lng' => 'xsd:string'
		),
		array('data' => 'xsd:string'),
		false, false, false, false, 'lat/lng = current location.'
	);
	
	function soap_new_updates($token)
	{
		if (!verify_token($token)) return false;
		$data = logic_new_updates(date("Y-m-d", time() - 60 * 60 * 24));
		return json_encode($data);
	}
	$server->register('soap_new_updates', 
		array(
			'token' => 'xsd:string'
		),
		array('data' => 'xsd:string')
		,false, false, false, false, ''

	);
	
	
	function soap_get_jubilees($token)
	{
		if (!verify_token($token)) return false;
		logic_log(__FUNCTION__, "");
		$data = array("member" => logic_get_member_jubilees(), "club" => logic_get_club_jubilees());
		return json_encode($data);
	}
	$server->register('soap_get_jubilees', 
		array(
			'token' => 'xsd:string'
		),
		array('data' => 'xsd:string')
		,false, false, false, false, ''

	);
	
	
	function soap_get_club_stats($token, $cid)
	{
		if (!verify_token($token)) return false;
		logic_log(__FUNCTION__, "");
		return json_encode(logic_get_club_stats($cid));
	}
	
	$server->register('soap_get_club_stats', 
		array(
			'token' => 'xsd:string', 'cid' => 'xsd:string'
		),
		array('data' => 'xsd:string')
		,false, false, false, false, ''

	);
 
	function soap_get_clubs($token,$did)
	{
		if (!verify_token($token)) return false;
		logic_log(__FUNCTION__, "");
		put_user_path_tracker($_SESSION['user']['uid'],'RTDApp - opdater data');
		$data = logic_get_clubs($did);
		for ($i=0;$i<sizeof($data);$i++)
		{
			unset($data[$i]['webmail_password']);
			unset($data[$i]['mummy_password']);
		}
		
		return json_encode($data);
	}
	$server->register('soap_get_clubs', 
		array(
			'token' => 'xsd:string', 'did' => 'xsd:string'
		),
		array('data' => 'xsd:string')
		,false, false, false, false, ''

	);
	
	
	function soap_get_users($token, $offset)
	{ 
		if (!verify_token($token)) return false;
		if (!is_numeric($offset)) return false;
		logic_log(__FUNCTION__, "");

		$data = get_data("select cid, company_address, company_business, company_city, company_country, company_email, company_name, company_phone, company_position, company_profile, company_web, company_zipno, company_business, private_address, private_city, private_country, private_email, private_housefloor, private_houseletter, private_houseno, private_houseplacement, private_mobile, private_msn, private_phone, private_profile, private_skype, private_zipno, profile_birthdate, profile_ended, profile_firstname, profile_image, profile_lastname, profile_started, uid, username  from user order by uid asc limit 2000 offset {$offset}");
		
		put_user_path_tracker($_SESSION['user']['uid'],'RTDApp - opdater data');


		return json_encode($data);
	}
	
	$server->register('soap_get_users',
		array(
			'token' => 'xsd:string',
			'offset' => 'xsd:string'
		),
		array('data' => 'xsd:string')
		,false, false, false, false, ''

	);
	
	
	
	function soap_get_user_by_id($token, $uid)
	{
		if (!verify_token($token)) return false;
		logic_log(__FUNCTION__, $uid);
		put_user_path_tracker($_SESSION['user']['uid'],'RTDApp - vis medlem');
		logic_update_user_view_tracker($uid);
		$data = logic_get_user_by_id($uid);
		if (isset($data['password'])) unset($data['password']);
		return json_encode($data);
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
			logic_log(__FUNCTION__, "OK: ".$username.print_r($data,true));
		}
		else
		{
			logic_log(__FUNCTION__, "Fail: ".$username);
		}
		
		logic_log(__FUNCTION__, json_encode($data));
		
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
	
	function soap_get_club($cid,$token)
	{
		if (!verify_token($token)) 
		{
			return false;
		}
		logic_log(__FUNCTION__, $cid);
		put_user_path_tracker($_SESSION['user']['uid'],'RTDApp - klub');
		return json_encode(logic_get_club($cid));
	}
	
	$server->register('soap_get_club',
		array('cid' => 'xsd:int','token'=>'xsd:string'),
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
	
	
	function soap_get_country($did, $token)
	{
		if (!verify_token($token)) return false;
		if ($did == 0) $did = "";
		logic_log(__FUNCTION__, $did);		 
		put_user_path_tracker($_SESSION['user']['uid'],'RTDApp - kalender');
		return json_encode(logic_get_country($did,25));
	}
	$server->register('soap_get_country',
			array('token'=>'xsd:string','did' => 'xsd:int'),
			array('data' => 'xsd:string')
		,false, false, false, false, 'did = district to fetch meetings (blank for whole country).'
	);
	
	
	function soap_fetch_future_meetings_for_club($cid,$token)
	{
		if (!verify_token($token)) return false;
		logic_log(__FUNCTION__, $cid);		
		put_user_path_tracker($_SESSION['user']['uid'],'RTDApp - klub');
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
		logic_log(__FUNCTION__, $mid);
		put_user_path_tracker($_SESSION['user']['uid'],'RTDApp - møde');
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
		logic_log(__FUNCTION__, "");
		put_user_path_tracker($_SESSION['user']['uid'],'RTDApp - nyheder');
		return json_encode(logic_get_news(0,5));
	}

	$server->register('soap_get_news',
			array('token'=>'xsd:string'),
			array('data' => 'xsd:string')
	);
	

	function soap_get_last_mail_index($token)
	{
		if (!verify_token($token)) return false;

		$m1 = $_SESSION['user']['private_email'];
		$m2 = $_SESSION['user']['company_email'];
		
		if (trim($m1) == "") $m1 = "foo@bar.bash";
		if (trim($m2) == "") $m2 = "foo@bar.bash";
		
		$sql = "select id from mass_mail WHERE mail_receiver LIKE '%{$m1}%' OR mail_receiver LIKE '%{$m2}%' order by id desc limit 1";
		$data = get_one_data_row($sql);
		return json_encode($data['id']);
	}
	$server->register('soap_get_last_mail_index',
			array('token'=>'xsd:string'),
			array('data' => 'xsd:string')
	);
	
	function soap_get_mail($token)
	{
		if (!verify_token($token)) return false;
		
		logic_log(__FUNCTION__, print_r($_SESSION,true));
		
		put_user_path_tracker($_SESSION['user']['uid'],'RTDApp - besked');
		$data = json_encode(logic_get_mail(0,5));
		logic_log(__FUNCTION__, $data);
		return $data;
	}

	$server->register('soap_get_mail',
			array('token'=>'xsd:string'),
			array('data' => 'xsd:string')
	);

	

	function soap_get_meeting_attendance($token, $mid)
	{
		if (!verify_token($token)) return false;
		logic_log(__FUNCTION__, $mid);
		put_user_path_tracker($_SESSION['user']['uid'],'RTDApp - møde');
		return json_encode(fetch_meeting_attendance($mid));
	}

	$server->register('soap_get_meeting_attendance',
			array('token'=>'xsd:string','mid' => 'xsd:int'),
			array('data' => 'xsd:string')
			,false, false, false, false, 'mid = meeting id of meeting to fetch.'

	);
	
	function soap_send_mail($token, $uid, $title, $content)
	{
		if (!verify_token($token)) return false;
		
		$data = json_decode($uid);
		if (is_array($data))
		{
			$uid = $data;
			$email = "";
			for ($i=0;$i<sizeof($uid);++$i)
			{
				$user = logic_get_user_by_id($uid[$i]);
				$email .=  $user['private_email']."; ";
			}
		}
		else
		{
			$user = logic_get_user_by_id($uid);		
			$email = $user['private_email'];
		}
		logic_log(__FUNCTION__, $email);
		
		logic_save_mail($email, $title, $content, 0, $_SESSION['user']['uid']);
		put_user_path_tracker($_SESSION['user']['uid'],'RTDApp - besked');
		return true;
	}

	$server->register('soap_send_mail',
			array('token'=>'xsd:string','uid' => 'xsd:string', 'title'=>'xsd:string', 'content'=>'xsd:string'),
			array('data' => 'xsd:string')
			,false, false, false, false, 'uid= user, title=msg title, content=msg content.'

	);
	
	function soap_get_meeting($token,$mid)
	{
		if (!verify_token($token)) return false;
		logic_log(__FUNCTION__, $mid);
		put_user_path_tracker($_SESSION['user']['uid'],'RTDApp - møde');
		return json_encode(logic_get_meeting($mid));
	}
	
	$server->register('soap_get_meeting',
			array('token'=>'xsd:string','mid' => 'xsd:int'),
			array('data' => 'xsd:string')
			,false, false, false, false, 'mid = meeting id of meeting to fetch.'

	);

	function soap_get_minutes($cid,$token) 
	{
		if (!verify_token($token)) return false;
		logic_log(__FUNCTION__, $cid);
		
		$data = get_data("select mid, start_time, title from meeting where cid={$cid} order by start_time desc");

		return json_encode($data);
	}
	$server->register('soap_get_minutes', 
		array(
			'token' => 'xsd:string',
			'cid' => 'xsd:int' 
		),
		array('data' => 'xsd:string')
		,false, false, false, false, 'cid = club id of club to fetch.'

	);
	

	$server->service(file_get_contents('php://input'));

	session_destroy();

	exit();
?>