<?
	/*
		content plugin (c) 3kings.dk
		
		23-02-2013	rasmus@3kings.dk	draft
		02-07-2014	ramsus@3kings.dk	added vcard
	*/
	
	if ($_SERVER['REQUEST_URI'] == $_SERVER['PHP_SELF']) header("location: /");
	
	mobile_plugin_register('CONTENT', 'get_mobile_content');

  function redir($where)
  {
    header("location: $where");
    die();
  }  
  
  function do_login()
  {
		$user = logic_login($_REQUEST['username'], $_REQUEST['password']);
		if ($user!==false) 
		{
			$_SESSION['user'] = $user;
			redir("/m/?cid={$user['cid']}");
    }
  }

  function do_logoff()
  {
			unset($_SESSION['user']);
      redir("?");
  }
  
  function do_content()
  {
	if (isset($_REQUEST['download']))
	{
		$folder = MOBILE_DOWNLOAD_PATH;
		$d = dir($folder);
		$data = array();
		while (false !== ($entry = $d->read())) 
		{
			if (!is_dir($folder.$entry))
			{
				$fdata = explode(".", $entry);
				$name = $fdata[0];
				$name = str_replace("aa", "å", $name);
				$name = str_replace("_", " ", $name);
				$data[$name] = array(
					"name" => $name,
					"url" => MOBILE_DOWNLOAD_PATH_WEB.$entry
				);
			}
		}
		$d->close();		
		ksort($data);
		return term_unwrap('mobile_download_page', $data, true);
	}
    else if (isset($_REQUEST['did']))
    {
      $did = $_REQUEST['did'];
      set_mobile_title(logic_get_district_name($did));
      $district = logic_get_country($did);
      $district['clubs'] = logic_get_clubs($did);
      return term_unwrap('mobile_district_page', $district, true);
    }
    else if (isset($_REQUEST['uid']))
    {
		if (isset($_REQUEST['vcard']))
		{
			
			header('Content-type: text/x-vcard');
			header('Content-Disposition: attachment; filename="info.vcard"');
			die(logic_get_vcard($_REQUEST['uid']));
		}

		$user = logic_get_user_by_id($_REQUEST['uid']);
      $user['club'] = logic_get_club($user['cid']);
      set_mobile_title($user['profile_firstname']." ".$user['profile_lastname']);
      return term_unwrap('mobile_user_page', $user, true);
    }
    else if (isset($_REQUEST['cid'])) 
    {
      $cid = $_REQUEST['cid'];
      $data = array(
        "club" => logic_get_club($cid),
        "members" => logic_get_active_club_members($cid),
        "meetings" => logic_fetch_future_meetings_for_club($cid,"asc",100),
		"clubmail" => logic_club_mail($cid)
      );
      set_mobile_title($data['club']['name']);
      
      return term_unwrap('mobile_club_page', $data, true);
    }
    else if (isset($_REQUEST['mid']))
    {
      $meeting = logic_get_meeting($_REQUEST['mid']);
	  
	  if (isset($_REQUEST['attend']))
	  {
		$a = $_REQUEST['attend'];
		if (isset($a['accept']))
		{
			logic_save_meeting_attendance($meeting['cid'], $meeting['mid'],$_SESSION['user']['uid'],"1",$a['comment']);
			return term_unwrap('mobile_meeting_accept', $meeting);
		}
		else
		{
			if ($a['comment']=="")
			{
				return term_unwrap('mobile_meeting_reject_no_comment', $meeting);
			}
			else
			{
				logic_save_meeting_attendance($meeting['cid'], $meeting['mid'],$_SESSION['user']['uid'],"0",$a['comment']);
				return term_unwrap('mobile_meeting_reject', $meeting);
			}
		}
	  }
	  else
	  {
		  foreach ($meeting as $key=>$value) 
		  {
			if (is_string($value)) $meeting[$key] = strip_tags($value);
		  }
		  
		  $meeting['uid'] = $_SESSION['user']['uid'];
		  $meeting['attendance'] = addslashes(json_encode(fetch_meeting_attendance($meeting['mid'])));
		  set_mobile_title($meeting['title']);
		  if (isset($_REQUEST['debug'])) die(print_r($meeting));
		  return term_unwrap('mobile_meeting', $meeting);
	  }
    }
    else if (isset($_REQUEST['search']))
    {
      $q = $_REQUEST['search']; 
      $data = logic_search($q);
      $data['keyword'] = $q;
      set_mobile_title($q);
      return term_unwrap('mobile_search_page', $data, true);
    }
    else
    {
      set_mobile_title(term('mobile_title_front'));
      $users = logic_latest_users();
      $country = logic_get_country("");
      return term_unwrap('mobile_front_page', $country, true).term_unwrap('mobile_latest_users', $users, true);
    }
  }
  
  function get_mobile_content()
  {
    if (isset($_REQUEST['login']))
    {
      do_login();
    }
    if (isset($_REQUEST['logoff']))
    {
      do_logoff();
    }
    
    if (logic_is_member())
    {
      return do_content();
    }
    else
    {
      return term_unwrap('mobile_login',$_SERVER);
    }
  }
  
  
  
?>