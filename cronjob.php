<?
/*
	cron job for rtd (c) 3kings.dk
	
	06-11-2012	rasmus@3kings.dk draft
	26-02-2013  rasmus@3kings.dk mass mails with attachments
	12-03-2013	rasmus@3kings.dk fixed addslashes in db logning
	01-05-2013	rasmus@3kings.dk only failing crons are mailed to admin
	04-10-2013	rasmus@3kings.dk filtered out special clubs (e.g. RTI)
*/
  $path = realpath(dirname(__FILE__));
  chdir($path);
  
	require_once $path.'/config.php';
	require_once $path.'/config_terms.php';
	require_once $path.'/includes/mysqlconnect.php';
	require_once $path.'/includes/logic.php';
	
	
	require_once $path.'/includes/PHPMailer-phpmailer-5.2.0/class.phpmailer.php';

	
	
	
	$errors = array();

	function has_errors()
	{
		global $errors;
		return !empty($errors);
	}
	
	function do_error($what)
	{
		global $errors;
		$errors[] = $what;
	}
	
	
  function do_mail($to,$from,$subj,$body,$from_name="Mailsystem",$attachment=false)
  {
		try
		{
			$mail = new PHPMailer(true);
			//$mail->IsSMTP();
			$mail->IsMail();
			
			 $mail->Host     = SMTP_SERVER;
			
			$mail->SMTPDebug =2;
			$subj = strip_tags(html_entity_decode($subj,ENT_COMPAT,'UTF-8'));
			
			$mail->IsHTML(true);
			
			
			
			
			$mail->SetFrom($from);
			
			
			$recv = explode(";", $to);
			for ($i=0; $i<sizeof($recv); $i++)
			{
				$r = str_replace(";", "", $recv[$i]);
				$r = trim($r);
				if (!empty($r))
				{
					$mail->AddAddress($r, $r); 
				}
			}
			
			
			
			$mail->Subject  =  $subj;
			$mail->Body = nl2br($body);
			
			if ($body == '') return;
			
			$mail->AltBody = strip_tags(html_entity_decode($body,ENT_COMPAT,'UTF-8'));
			$mail->CharSet   = "UTF-8";

			
			  if ($attachment)
		  {
			foreach($attachment as $f)
			{
			  if (!$mail->AddAttachment($f['path'],$f['name']))
			  {
				do_error(print_r($f,true));	  
				do_error(print_r($mail->ErrorInfo,true));	  
				return false;
			  }
			}
		  }
		  $res = $mail->Send();
		  if (!$res)
		  {
			do_error(print_r($mail->ErrorInfo,true));	  
		  }
		  else
		  {
			usleep(1);
		  }
		  return $res;
		} catch (Exception $e)
		{
			do_error($e->getMessage());
		}
  }

	/**
	 * send mails in chunks of 200 items
	 * @param mixed[] $db database instance
	 * @return log file content
	 */
	function handle_mass_mailer($db)
	{
		$log = "<h2>Handle mass mailer</h2>\n";
    
    if (DISABLE_MAIL_SENDING)
    {
		do_error("Mail sending disabled");
      $log .= "<li>Mail sending disabled\n";
      return $log;
    }
    
    
		$sql = "select * from mass_mail where processed=0 order by submit_time asc limit 200";
		$rs = $db->execute($sql);
		while ($row = $db->fetchassoc($rs))
		{
			$subj = trim(((($row['mail_subject']))));
			$body = trim(((($row['mail_content']))));
                     
      if ($row['uid']>0)
      {
        $u = logic_get_user_by_id($row['uid']);

		
		if (USE_CLUB_MAILS)
		{
			$c = logic_get_club($u['cid']);
			$sender = $c['name'];
			$sender_mail = logic_club_mail($u['cid']);
		}
		else
		{
			$sender = "{$u['profile_firstname']} {$u['profile_lastname']}";
			$sender_mail = $u['private_email'];
		}
		
		
		$nb = logic_get_national_board();
		foreach($nb as $n)
		{
			if ($n['uid'] == $u['uid'])
			{
				if ($n['role_short'] == DISTRICT_CHAIRMAN_SHORT)
				{
					$did = logic_get_district_for_user($n['uid']);
					$dname = logic_get_district_name($did);
					$ddata = explode(" ", $dname);
					$dnum = $ddata[1];
					$sender_mail = $n['role_short'].$dnum.NB_MAIL_POSTFIX;
				}
				else
				{
					$sender_mail = $n['role_short'].NB_MAIL_POSTFIX;
				}
			}
		}
		
		
		
      }
      else
      {
        $sender = MASS_MAILER_REPLY_WHO;
        $sender_mail = MASS_MAILER_REPLY_MAIL;  
      }
      
      if ($row['aid']>0)
      {
        $attachment = get_attachment($row['aid']);
      	$fn = sys_get_temp_dir()."/".$attachment['filename'];
        $files = array();
	if ($attachment['filename']!='')
	{
		$files[] = array( "att"=>$attachment,
			"path" => MAIL_ATTACHMENT_UPLOAD_PATH.$row['aid'],
			"name" => $attachment['filename'], $row );
			
	}	
		if ($row['mail_receiver']=='')
		{
			do_error("Error sending {$row['id']} to {$row['mail_receiver']}");
			$log .= "<li>Error sending {$row['id']} to {$row['mail_receiver']}\n";
		}
        else if (!do_mail($row['mail_receiver'],$sender_mail,$subj,$body,$sender,$files))      
		{
			do_error("Error sending {$row['id']} to {$row['mail_receiver']}");
			$log .= "<li>Error sending {$row['id']} to {$row['mail_receiver']}\n";
		}
		else
		{
			$db->execute("update mass_mail set processed=1, processed_time=now() where id={$row['id']}");
			$log .= "<li>Mail {$row['id']} sent to {$row['mail_receiver']} from {$sender_mail}\n";
		}
      }
      else
      {
        if (!do_mail($row['mail_receiver'],$sender_mail,$subj,$body,$sender))
				{
					do_error("Error sending {$row['id']} to {$row['mail_receiver']}");
					$log .= "<li>Error sending {$row['id']} to {$row['mail_receiver']}\n";
				}
				else
				{
					$db->execute("update mass_mail set processed=1, processed_time=now() where id={$row['id']}");
					$log .= "<li>Mail {$row['id']} sent to {$row['mail_receiver']} from {$sender_mail}\n";
				}
      }
			
			
		}
		$log .= "<p>Done</p>\n";
		return $log;
	}
	
	/**
	 *	must only be called once a day - sends out reminder-mails for meetings without minutes on day 5, 14 and 19 after meeting ended
	 *	@param mixed[] $g_db database instance
	 *	@return logfile
	 */
	function handle_daily_tasks($g_db)
	{
		$log = "<h2>Daily task execution</h2>\n";


		// every Monday
		if (date("w")==1)
		{
			push_all_data_to_rtidatahub();
			
			if (defined('NB_MAIL_POSTFIX') && NB_MAIL_POSTFIX == '@rtd.dk')
			{
				$sql = "select cid from club";
				$rs = $g_db->execute($sql);
				while ($d = $g_db->fetchassoc($rs))
				{
					if (!logic_is_special_club($d['cid']))
					{
						$c = logic_get_club($d['cid']);
						$i = logic_check_clubmail($c);
						if ($i>0)
						{
							$s = logic_get_club_secretary($c['cid']);
							$p = logic_get_club_chairman($c['cid']);
							logic_send_mail($s['uid'], term('clubmail_notify_subj'), term('clubmail_notify_body'));
							$log .= "<li>Sending unread notify mail to {$c['name']}";
						}
					}
				}
			}
		}
		
		// 5 days
		$sql = "
				SELECT * FROM `meeting` 
				where 
				(minutes_date='' or minutes_date='0000-00-00' or minutes_date is null)
				and
				DATEDIFF(end_time,now())=-5
		";
		$rs = $g_db->execute($sql);
		while ($m = $g_db->fetchassoc($rs))
		{
			if (!logic_is_special_club($m['cid']))
			{
				$s = logic_get_club_secretary($m['cid']);
				// $f = logic_get_club_chairman($m['cid']);
				$subj = term_unwrap('minutes_reminder_5days_subject', $m);
				$text = term_unwrap('minutes_reminder_5days_text', $m);
				logic_save_mail($s['private_email'], $subj, $text);

				logic_save_mail(get_district_chairman_mail_from_club($m['cid']), $subj, $text);

				$log .= "<li>5 {$s['private_email']} $text\n";
			}
		}

		// 14 days
		$sql = "
				SELECT * FROM `meeting` 
				where 
				(minutes_date='' or minutes_date='0000-00-00' or minutes_date is null)
				and
				DATEDIFF(end_time,now())=-14
		";
		$rs = $g_db->execute($sql);
		while ($m = $g_db->fetchassoc($rs))
		{
			if (!logic_is_special_club($m['cid']))
			{
				$s = logic_get_club_secretary($m['cid']);
				$f = logic_get_club_chairman($m['cid']);
				$subj = term_unwrap('minutes_reminder_14days_subject', $m);
				$text = term_unwrap('minutes_reminder_14days_text', $m);
				$recv = array($s['private_email'],$f['private_email'],get_district_chairman_mail_from_club($m['cid']));
				logic_save_mail($recv, $subj, $text);

				$log .= "<li>14 {$s['private_email']}  $text\n";
			}
		}
		
		// 19 days
		$sql = "
				SELECT * FROM `meeting` 
				where 
				(minutes_date='' or minutes_date='0000-00-00' or minutes_date is null)
				and
				DATEDIFF(end_time,now())=-19
		";
		$rs = $g_db->execute($sql);
		while ($m = $g_db->fetchassoc($rs))
		{
			if (!logic_is_special_club($m['cid']))
			{
				$s = logic_get_club_secretary($m['cid']);
				$f = logic_get_club_chairman($m['cid']);
				$subj = term_unwrap('minutes_reminder_19days_subject', $m);
				$text = term_unwrap('minutes_reminder_19days_text', $m);
				$recv = array($s['private_email'],$f['private_email'],get_district_chairman_mail_from_club($m['cid']));
				logic_save_mail($recv, $subj, $text);
				$log .= "<li>19 {$s['private_email']} $text\n";
			}
		}
		
		return utf8_decode($log);
	}
	
	function clean_up_tmp()
	{
		$log = "<h2>Cleaning up tmp</h2>\n";
		$folder = sys_get_temp_dir();
		$d = dir($folder);
		if ($d)
		{
			while (false !== ($entry=$d->read()))
			{
				if (strpos($entry,"rtd-")!==false)
				{
					unlink($folder."/".$entry);
				}
			}
		}
		return $log;
	}


	if (PHP_SAPI=='cli' || isset($_REQUEST['pwd']) && $_REQUEST['pwd']==CRONJOB_PWD)
	{
	
	
		$last_run = $g_db->fetchsinglevalue($g_db->execute("select ts from cronjob order by ts desc limit 1"));
		$last_run_ts = strtotime($last_run);


		$g_db->execute("insert into cronjob (ts) values (now())");
		$logid = $g_db->insertid();
		$ts = date("Y-m-d, H:i:s");
		$log = "<h1>Run - $ts</h1>\n";

		$now_ts = time();
		if (isset($_REQUEST['daily']) || strcmp(date('d',$now_ts),date('d',$last_run_ts))!=0)
		{
			$log .= clean_up_tmp();
			$log .= handle_daily_tasks($g_db);
		}		

		$log .= handle_mass_mailer($g_db);	

		$log = addslashes($log);
		
		$g_db->execute("update cronjob set log='$log' where id=$logid");		
	
		if (has_errors())
		{
			echo "mailing ".print_r($errors,true);
			do_mail(ADMIN_MAIL,ADMIN_MAIL,"Website cronjob log $logid","Log output:\n".print_r($errors,true));	
		}
		
		echo $log;
		
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
				if (!empty($v['charter_club_cid']))
				{
					$chairman = logic_get_club_chairman($v['cid']);
					$email = $chairman['private_email'];
					if (empty($email)) $email = logic_club_mail($v['cid']);
					$result[] = array("name"=>$v['name'], "email"=>$email, "address"=>$v['meeting_place']);
				}
		}
				
		return $result;
	}
	
	function format_meetings()
	{
		$m = fetch_meetings("where end_time>now() and M.cid!=442 order by start_time asc", 100); 
		 
		$result = array();
		
		foreach ($m as $k => $v)
		{
			if ($v['name'] != "" && $v['name'] != "RTI")
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
			
			echo "<h1>rti - nationalboard</h1>";
			
			push_data_to_rtidatahub("NATIONALBOARD", $nb);
			echo "<h1>rti - tables</h1>";
			push_data_to_rtidatahub("TABLE", $c);
			echo "<h1>rti - meetings</h1>";
			push_data_to_rtidatahub("MEETING", $m);
		}
	}
	
	
?>