<?
  $path = $_SERVER['DOCUMENT_ROOT'];
	chdir($path);
  require_once $path.'/config.php';
	require_once $path.'/config_terms.php';
	require_once $path.'/includes/mysqlconnect.php';
	require_once $path.'/includes/logic.php';
	
	
	function pull_data_from_rtidatahub($data)
	{
		$url = "http://rtidatahub.org/api/pull/";
		$apikey = RTIDATAHUB_APIKEY;
		return file_get_contents("{$url}?apikey={$apikey}&data={$data}");
	}
	
	
	function push_data_to_rtidatahub($data, $values)
	{
		$url = "http://rtidatahub.org/api/push/";
		$apikey = RTIDATAHUB_APIKEY;

		$fields = array(
			'apikey' => $apikey,
			'data' => $data,
			'values'=>json_encode($values)
		);
		
		

		$postvars='';
		$sep='';
		foreach($fields as $key=>$value)
		{
				$postvars.= $sep.urlencode($key).'='.urlencode($value);
				$sep='&';
		}

		$ch = curl_init();

		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_POST,count($fields));
		curl_setopt($ch,CURLOPT_POSTFIELDS,$postvars);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$result = curl_exec($ch);

		curl_close($ch);
		
		echo $result;
	}

	
	function format_national_board()
	{
		$nb = logic_get_national_board();
		
		$result = array();
		
		foreach ($nb as $k=>$v)
		{
			$u = logic_get_user_by_id($v['uid']);
			$result[] = array("name"=>"{$u['profile_firstname']} {$u['profile_lastname']}", "title"=>$v['role'], "email"=>$u['private_email'], "phone"=>"+".logic_fix_mobile_phone_number($u['private_mobile']));
		}
		
		return $result;	
	}
	
	function format_clubs()
	{
		$c = logic_get_clubs();
		$result = array();
		
		foreach($c as $k=>$v)
		{
			if ($v['cid']!=442)
			{
				$result[] = array("name"=>$v['name'], "email"=>logic_club_mail($v['cid']), "address"=>$v['meeting_place']);
			}
		}
		
		return $result;
	}
	
	function format_meetings()
	{
		$m = fetch_meetings("where end_time>now() and cid!=442 order by start_time asc", 100); 
		
		$result = array();
		
		foreach ($m as $k => $v)
		{
			
		
			$result[] = array(
				"internal_id" => $v['mid'],
				"title" => $v['title'],
				"description" => trim(strip_tags($v['description'])),
				"start_time" => substr($v['start_time'], 0, 10),
				"end_time" => substr($v['end_time'], 0, 10),
				"table" => $v['name'],
				"location" => $v['location']
			);
			
			
		}
		return $result;
	}
	
	
	
	function push_all_data_to_rtidatahub()
	{
		if (defined("RTIDATAHUB_APIKEY"))
		{
			$nb = format_national_board();
			$c = format_clubs();
			$m = format_meetings();
			
			push_data_to_rtidatahub("NATIONALBOARD", $nb);
			push_data_to_rtidatahub("TABLE", $c);
			push_data_to_rtidatahub("MEETING", $m);
		}
	}
	
	// push_all_data_to_rtidatahub();
	
	$json = pull_data_from_rtidatahub("NATIONALBOARD");
	
	echo $json;

	
	$data = json_decode($json);
	
	
	echo "<pre>".print_r($data,true);
	
?>