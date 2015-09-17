<?
 
function slack_msg($msg)
{
/*
 $url = "https://hooks.slack.com/services/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?payload=";

 $data = array(
  "text" => $msg
 );


 file_get_contents($url.urlencode(json_encode($data)));
*/
}



/**
 * notify LS and DF about new club board
 */
function event_new_club_board($cid,$event_data)
{
	$club = logic_get_club($cid);
	$dc = logic_get_district_chairman($club['district_did']);
	$cs = logic_get_club_secretary($cid);
	  
	$board = "";
	foreach($event_data as $rid => $uid)
	{
		$r = logic_get_role_name($rid);
		$u = logic_get_user_by_id($uid);
	
		$board .= "\n{$r}: {$u['profile_firstname']} {$u['profile_lastname']} - ".
						term_unwrap('new_club_board_link',$u).
						"\n";
	}

  $r = array($dc['private_email'], NATIONAL_SECRETARY_MAIL,$cs['private_email']);
  $subj = term_unwrap('new_club_board_subj', $club);
  $body = term_unwrap('new_club_board_body', $club).$board;
  logic_save_mail($r,$subj,$body);
}  


function event_user_on_leave($u)
{
	$club = logic_get_club($u['cid']);
	$dc = logic_get_district_chairman($club['district_did']);
	$cs = logic_get_club_secretary($club['cid']);
	$r = array($dc['private_email'], $cs['private_email'], NATIONAL_SECRETARY_MAIL, $u['private_email']);
	$subj = term_unwrap('user_on_leave_subj', $u);
	$body = term_unwrap('user_on_leave_body', $u);
	logic_save_mail($r, $subj, $body);
}

/**
 * role nomination notification to LS
 */
function event_role_nomination($uid, $rid, $reason)
{
  $data = array(
    "comment" => $reason
  );
  
  $data = array_merge($data,logic_get_user_by_id($uid));
  $data = array_merge($data, array("role"=>logic_get_role_name($rid)));                                                     
  $subj = term_unwrap('role_nomination_subj',$data);
  $body = term_unwrap('role_nomination_body', $data);
  logic_save_mail(NATIONAL_SECRETARY_MAIL,$subj,$body);
} 

/**
 * when a user resigns the user is informed, chairman and df
 * @param int $uid user id
 */  
function event_user_resign($uid,$why)
{
  $u = logic_get_user_by_id($uid);
	$club = logic_get_club($u['cid']);
	$dc = logic_get_district_chairman($club['district_did']);
  $cc = logic_get_club_chairman($club['cid']);
  
  $data = array_merge($u,$club);
  $subj = term_unwrap('user_resign_subj', $data);
  $body = term_unwrap('user_resign_body', $data);
  
  $r = array($u['private_email'], $cc['private_email']);
  logic_save_mail($r,$subj,$body);

  if (defined('RESIGN_SEND_ONLY_TO_WEB') && RESIGN_SEND_ONLY_TO_WEB)
  {
	$r = array(ADMIN_MAIL);
  }
  else
  {
  $r = array($dc['private_email'], NATIONAL_SECRETARY_MAIL, NATIONAL_PRESIDENT_MAIL, NATIONAL_VICE_PRESIDENT_MAIL);
  }
  $data['why'] = $why;
  $subj = term_unwrap('user_resign_subj', $data);
  $body = term_unwrap('user_resign_nb_body', $data);
  logic_save_mail($r,$subj,$body);
}

/** 
 * when a news item receives a new comment - the news author is notified
 * @param int $nid news id
 * @param int $did district id
 */
function event_news_comment($nid,$did)
{
	$news_item = logic_fetch_specific_news($nid);
	
	$subj = term_unwrap('news_comment_subj', array('did'=>$did, 'nid'=>$nid, 'title'=>$news_item['title']));
	$body = term_unwrap('news_comment_body', array('did'=>$did, 'nid'=>$nid, 'title'=>$news_item['title']));

	slack_msg($body);


	$already_mailed = array();
	


	if ($did != 0)
	{
		$dc = logic_get_district_chairman($did);
		$already_mailed[$dc['private_email']] = true;
		logic_save_mail($dc['private_email'], $subj, $body);
	}
	else
	{
		$already_mailed[ADMIN_MAIL] = true;
		
		logic_save_mail(ADMIN_MAIL, $subj, $body);
	}
	
	$comments = logic_get_news_comments($nid);
	for ($i=0;$i<sizeof($comments)-1;$i++)
	{
		$email = $comments[$i]['user']['private_email'];
		if (!isset($already_mailed[$email]))
		{
			logic_save_mail($email, $subj, $body);
			$already_mailed[$email]=true;
		}
	}
	
}
/**
 *	when a nomination for role change (e.g. honorary member) is rejected an email is sent to the club secretary
 *	@param int $nid nomination id
 */
function event_nomination_rejected($nid)
{
	$nom = fetch_nomination($nid);
	$usr = logic_get_user_by_id($nom['uid']);
	$secretary = logic_get_club_secretary($usr['cid']);
	
	$data = array_merge($usr, array('rejected_role'=>logic_get_role_name($nom['rid'])));
	
	$subj = term_unwrap('nomination_reject_subj', $data);
	$body = term_unwrap('nomination_reject_body', $data);
	
	logic_save_mail($secretary['private_email'], $subj, $body);
}

/**
 *	when a nomination for role change (e.g. honorary member) is accepted an email is sent to the club secretary
 *	@param int $nid nomination id
 */
function event_nomination_accepted($nid)
{
	$nom = fetch_nomination($nid);
	$usr = logic_get_user_by_id($nom['uid']);
	$secretary = logic_get_club_secretary($usr['cid']);
	
	$data = array_merge($usr, array('accepted_role'=>logic_get_role_name($nom['rid'])));
	
	$subj = term_unwrap('nomination_accept_subj', $data);
	$body = term_unwrap('nomination_accept_body', $data);
	
  $r = array(NATIONAL_SECRETARY_MAIL,$secretary['private_email']);
	logic_save_mail($r, $subj, $body);
}

/**
 * when a meeting minute is finished - send links to club members, district 
 * chairman
 * @param int $mid id of meeting  
 */ 
function event_minutes_finished($mid,$mail_to_members=true)
{
	if (!$mail_to_members) return;
	$meeting = logic_get_meeting($mid);
	$club = logic_get_club($meeting['cid']);
	$members = fetch_active_club_members($meeting['cid']);
	$dc = logic_get_district_chairman($club['district_did']);
	
//	$receivers = array();
//	$receivers[] = $dc['private_email'];
	$receivers = $dc['private_email']."; ";
	$error_users = array();
	
	for ($i=0;$i<sizeof($members);$i++) 
	{
		//if (filter_var($members[$i]['private_email'], FILTER_VALIDATE_EMAIL)) 
		{
			$receivers .=  $members[$i]['private_email']."; ";
//			$receivers[] = $members[$i]['private_email'];
		}
/*		else
		{
			$error_users[] = $members[$i];
		}*/
	}
	
	if (!empty($error_users))
	{
		$s = logic_get_club_secretary($club['cid']);
		$body = "";
		foreach($error_users as $u)
		{
			$body .= "{$u['profile_firstname']} {$u['profile_lastname']}\n";
		}
		$subj = term_unwrap('users_missing_email_subj', $club);
		logic_save_mail($s['private_email'], $subj, $body);
	}
	
	$subj = term_unwrap('minutes_completed_subject', $club);
	$text = term_unwrap('minutes_completed_content', $meeting);
 	logic_save_mail($receivers, $subj, $text);

	slack_msg($text);
}

/**
 * when a new user is created - send welcome mail to the new user, district
 * chairman, national preseident and national secretary
 * @param int $uid user id of new user
 */   
function event_new_user($uid)
{
  $data = logic_get_user_by_id($uid);
  $club = logic_get_club($data['cid']);
  $maildata = array(
    "name" => $data['profile_firstname'].' '.$data['profile_lastname'],
    "username" => $data['username'],
	"profile_birthdate" => $data['profile_birthdate'],
	"profile_started" => $data['profile_started'],
    "password" => DEFAULT_NEW_USER_PASSWORD,
    "club" => $club['name']
  );

  $subj = term('new_user_welcome_mail_subject');
  $body = term_unwrap('new_user_welcome_mail_content', $maildata);
  
  
  $did  = logic_get_district_for_user($uid);
  $dc = logic_get_district_chairmain($did);


  $recv = array($data['private_email'], $dc['private_email'], NATIONAL_SECRETARY_MAIL, NATIONAL_PRESIDENT_MAIL);
  logic_save_mail($recv, $subj, $body);
  }

/**
 * when meeting attendance is updated by a user (i.e. accepting or declining)
 * a mail is sent to the club secretary 
 * @param int $mid meeting id
 * @param int $cid club id
 * @param int $uid user tht has updated attendance
 * @param string $comment comment to response
 * @param bool $accept true if accept - false otherwise
  */       
function event_meeting_attendance($mid,$cid,$uid,$comment,$accept)
{
  $m = logic_get_meeting($mid);
  $u = logic_get_user_by_id($uid);
  
  $data = array_merge($m,$u,array('comment'=>$comment));
  
  $subj = $accept?term_unwrap('meeting_attendance_notify_accept_subj',$data):term_unwrap('meeting_attendance_notify_decline_subj', $data);
  $body = $accept?term_unwrap('meeting_attendance_notify_accept_body',$data):term_unwrap('meeting_attendance_notify_decline_body', $data);
  
  $cm = logic_get_club_secretary($cid);
  
  logic_save_mail($cm['private_email'],$subj,$body);
}


function event_nominate_resignation($who,$why) 
{
	$who['why'] = $why;
	$who['why_url'] = urlencode($why);
	$who = array_merge($who, logic_get_club($who['cid']));
	$subj = term_unwrap('resign_nominate_subj', $who);
	$body = term_unwrap('resign_nominate_body', $who);
	logic_save_mail(NATIONAL_SECRETARY_MAIL, $subj, $body);
}

?>