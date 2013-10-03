<?
/*
		content plugin article admin (c) 3kings.dk
		
		02-11-2012	rasmus@3kings.dk	draft
	*/

	if ($_SERVER['REQUEST_URI'] == $_SERVER['PHP_SELF']) header("location: /");
		
	content_plugin_register('cid', 'content_handle_club', 'Klub');

	function club_header($club)
	{
		$members = logic_get_active_club_members($club['cid']);
		$mails = array();
		foreach($members as $k=>$v)
		{
			$mails[] = $v['private_email'];
		}
		$club['membermails'] = implode(",",$mails);
		$html = term_unwrap('club_header', $club);
		return $html;
	}
	
	
	function club_book($club)
	{
		$members = logic_get_active_club_members($club['cid']);
		die(print_r($members,true));
	}
	
	function content_handle_club_ics($meetings,$club)
	{
			
			$fn = utf8_decode($club['name']).".ics";
			header("Content-Type: text/Calendar");
			header("Content-Disposition: inline; filename=\"$fn\"");

			$ics = 
"BEGIN:VCALENDAR
X-WR-CALNAME:Round Table Denmark Calendar
PRODID:-//Round Table Denmark//RTD.DK Calendar//EN
VERSION:2.0
CALSCALE:GREGORIAN
METHOD:PUBLISH
";

		for ($i=0;$i<sizeof($meetings);$i++)
		{
			$meeting = $meetings[$i];
			$start = strtotime($meeting['start_time']);
			$end = strtotime($meeting['end_time']);
			$title = utf8_decode($club['name']).": ".utf8_decode($meeting['title']);
			$description = utf8_decode(html_entity_decode(strip_tags(str_replace("<br>","\n",$meeting['description'])),ENT_QUOTES,'UTF-8'));
			$ics .=
"BEGIN:VEVENT
DTSTART:".date('Ymd',$start)."T".date('Hi',$start)."00
DTEND:".date('Ymd',$end)."T".date('Hi',$end)."00
SUMMARY:{$title}
LOCATION:{$meeting['location']}
DESCRIPTION:{$description}
UID:RTD-{$meeting['mid']}
CLASS:PUBLIC
END:VEVENT
";			
		}

$ics .= 
"END:VCALENDAR
";

			die($ics);


	}
	
  function content_handle_special_club($club)
  {
		if (isset($_REQUEST['ics']) && $club)
		{
			return content_handle_club_ics(logic_fetch_future_meetings_for_club($club['cid'], 'asc', 100, false),$club);
		}

    set_title($club['name']);
    $html = term_unwrap('special_club_page', $club);

		if (logic_is_admin())
		{
			$html .= term_unwrap('special_club_page_admin',$club);
      
      if (isset($_REQUEST['meeting']))
      {
        logic_save_meeting($_REQUEST['meeting'],-1, $club['cid']);
      }
		}

		$meetings = logic_fetch_future_meetings_for_club($club['cid'],"asc",100);
		$minutes = logic_fetch_minutes($club['cid'],"desc", 50);
		if (sizeof($meetings)) $html .= term_unwrap('club_future_meetings', $meetings, true);
		if (sizeof($minutes)) $html .= term_unwrap('club_minutes', $minutes, true);

		$missing_minutes = logic_meeting_with_no_minutes($club['cid']);
    if (sizeof($missing_minutes)>0)
    {
      $html .= term('club_missing_minutes');
  		for($i=0;$i<sizeof($missing_minutes);$i++)
  		{
  			$html .= term_unwrap('club_future_meetings_item', $missing_minutes[$i]);
  		}
    }

    return $html;
  }
  
	function content_handle_edit_club($club)
	{
		$data = $_REQUEST['edit'];
		if (is_array($data))
		{
			if (isset($_FILES['logo']))
			{
				$logo = logic_upload_club_logo($_FILES['logo'],$club['cid']);
			}
			logic_update_club($club['cid'], $data);
			$club = logic_get_club($club['cid']);
		}
		if (logic_is_admin()) 
		{
			$club['all_clubs'] = addslashes(json_encode(logic_get_clubs()));
			return term_unwrap('edit_club_admin', $club);
		}
		else return term_unwrap('edit_club_secretary', $club);
	}
	
	function content_handle_archive($club)
	{
		
		$html = club_header($club);

		$minutes = logic_fetch_minutes($club['cid'],"desc", 9999);
		$html .= term_unwrap('club_minutes_archive', $minutes, true);
		return $html;
	}
  
	function content_handle_club()
	{
		
		if (!logic_is_member() && !logic_is_mummy()) 
		{
		  header("location: ?aid=-1");
		  die();
		}
    
		$cid = isset($_REQUEST['cid'])?$_REQUEST['cid']:$_SESSION['user']['cid'];
		$club = logic_get_club($cid);
		
		if ((logic_is_admin() || logic_is_club_secretary($club['cid'])) && isset($_REQUEST['edit'])) 
		{
			return content_handle_edit_club($club);
		}
		
		if ((logic_is_admin() || logic_is_club_secretary($club['cid'])) && isset($_REQUEST['delete_omid'])) 
		{
			logic_delete_other_meeting($_REQUEST['delete_omid']);
		}

		
		if (isset($_REQUEST['book']))
		{
			return club_book($club);
		}

		
		if ($club['district_did']==0)
		{
		  return content_handle_special_club($club);
		}
		
		if (isset($_REQUEST['archive']))
		{
			return content_handle_archive($club);
		}
    
		$board = logic_get_club_board($cid);		



		if (isset($_REQUEST['ics']) && $club)
		{
			return content_handle_club_ics(logic_fetch_future_meetings_for_club($club['cid'], 'asc', 100, false),$club);
		}
	
	
		$html = club_header($club);

		if (!logic_is_mummy())		
		if (($_SESSION['user']['cid'] == $club['cid'] && logic_is_secretary()))
		{
			$html .= term_unwrap('club_secretary_tools',$club);
		}
	
	
		$meetings = logic_fetch_future_meetings_for_club($club['cid'],"asc",100);
		$minutes = logic_fetch_minutes_this_year($club['cid'],"desc", 30);
    $other_meetings = array("meetings" => logic_get_other_meetings($club['cid']), "birthday" => logic_get_club_birthdays($club['cid']));
		$html .= term_unwrap('club_future_meetings', $meetings, true);
		if (logic_is_admin() || logic_is_club_secretary($club['cid']))
		{
			$html .= term_unwrap('club_other_meetings_secretary', $other_meetings, true);
		}
		else
		{
			$html .= term_unwrap('club_other_meetings', $other_meetings, true);
		}
		
		
		$html .= term_unwrap('club_minutes', $minutes, true);
		$html .= term_unwrap('club_archive', $club);
/*		
		for($i=0;$i<sizeof($meetings);$i++)
		{
			$html .= term_unwrap('club_future_meetings_item', $meetings[$i]);
		}
		$html .= term('club_latest_minutes');
		$minutes = logic_fetch_minutes($club['cid'],"desc", 10);
		for($i=0;$i<sizeof($minutes);$i++)
		{
			$html .= term_unwrap('club_future_meetings_item', $minutes[$i]);
		}
*/		
		
		if (!logic_is_mummy())
		if (($_SESSION['user']['cid'] == $club['cid'] && logic_is_secretary()))
    {
      $html .= term('club_missing_minutes');
  		$missing_minutes = logic_meeting_with_no_minutes($club['cid']);
  		for($i=0;$i<sizeof($missing_minutes);$i++)
  		{
  			$html .= term_unwrap('club_future_meetings_item', $missing_minutes[$i]);
  		}
    }

		$html .= term('club_board');		
		$html .= term_unwrap('club_board_member', array('data'=>addslashes(json_encode($board))));
/*		foreach ($board as $k => $v)
		{
			$html .= term_unwrap('club_board_member', $v);
		}*/
		
		if (isset($_REQUEST['allmembers']))
		{
			$club_members = logic_get_all_club_members($club['cid']);
		}
		else
		{
			$club_members = logic_get_active_club_members($club['cid']);
		}
		
		$html .= term_unwrap('club_members', array('members'=>addslashes(json_encode($club_members))));
		

		$html .= term_unwrap('club_member_stat', logic_get_club_stats($club['cid']), true);

		set_title($club['name']);		
		return $html;
	}
?>
