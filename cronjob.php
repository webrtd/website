<?
/*
	cron job for rtd (c) 3kings.dk
	
	06-11-2012	rasmus@3kings.dk draft
	26-02-2013  rasmus@3kings.dk mass mails with attachments
	12-03-2013	rasmus@3kings.dk fixed addslashes in db logning
	01-05-2013	rasmus@3kings.dk only failing crons are mailed to admin
	04-10-2013	rasmus@3kings.dk filtered out special clubs (e.g. RTI)
*/
  $path = "/var/www/vhosts/rtd.dk/test2012/";
  
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
	
  		$mail = new PHPMailer();
		$mail->IsMail();
		
  		$mail->Host     = SMTP_SERVER;
  		
		$mail->SMTPDebug =1;
		$subj = strip_tags(html_entity_decode($subj,ENT_COMPAT,'UTF-8'));
		
		$mail->IsHTML(true);
		
		$mail->SetFrom($from, $from_name);
  		$mail->AddAddress($to, $to);  
  		$mail->Subject  =  $subj;
		$mail->Body = nl2br($body);
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

        $sender = "{$u['profile_firstname']} {$u['profile_lastname']}";
        $sender_mail = $u['private_email'];
		
		$nb = logic_get_national_board();
		foreach($nb as $n)
		{
			if ($n['uid'] == $u['uid'])
			{
				$sender_mail = $n['role_short'].NB_MAIL_POSTFIX;
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
		
		// delete old users from coming meetings (except if they are honorary members)
		//logic_is_honorary
		$sql = "select MA.maid,U.uid,M.mid,M.title,M.start_time,U.profile_ended from meeting M 
				inner join meeting_attendance MA on MA.mid=M.mid
				inner join user U on MA.uid=U.uid
				where 
				M.start_time>now()
				and
				U.profile_ended<now()";
		$rs = $g_db->execute($sql);
		while ($d=$g_db->fetchassoc($rs))
		{
			if (!logic_is_honorary($d['uid']))
			{
				$u = logic_get_user_by_id($d['uid']);
				$log .= "<li>Removing {$d['uid']} {$u['profile_firstname']} {$u['profile_lastname']} from {$d['mid']}";
				delete_meeting_attendance_for_uid($d['mid'],$d['uid']);
			}
		}

		// every Monday
		if (date("w")==1)
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
				$recv = array($s['private_email'],$f['private_email']);
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
				$recv = array($s['private_email'],$f['private_email']);
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

?>