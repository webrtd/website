<?php
	/*
		content plugin minutes (c) 3kings.dk
		
		02-11-2012	rasmus@3kings.dk	draft
		15-11-2012	rasmus@3kings.dk	minutes
		20-11-2012 	rasmus@3kings.dk 	minute template, image upload, etc.
	*/

	if ($_SERVER['REQUEST_URI'] == $_SERVER['PHP_SELF']) header("location: /");
		
	content_plugin_register('mid', 'content_handle_meeting', 'M�de');

 
    function fix_minutes($text, $allowed_tags = '<b><i><sup><sub><em><strong><u><br><div>')
    {
		return $text;
		return strip_tags($text, "<b><p><a><li><ul><img>");
        mb_regex_encoding('UTF-8');
        //replace MS special characters first
        $search = array('/&lsquo;/u', '/&rsquo;/u', '/&ldquo;/u', '/&rdquo;/u', '/&mdash;/u');
        $replace = array('\'', '\'', '"', '"', '-');
        $text = preg_replace($search, $replace, $text);
        //make sure _all_ html entities are converted to the plain ascii equivalents - it appears
        //in some MS headers, some html entities are encoded and some aren't
        $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
        //try to strip out any C style comments first, since these, embedded in html comments, seem to
        //prevent strip_tags from removing html comments (MS Word introduced combination)
        if(mb_stripos($text, '/*') !== FALSE){
            $text = mb_eregi_replace('#/\*.*?\*/#s', '', $text, 'm');
        }
        //introduce a space into any arithmetic expressions that could be caught by strip_tags so that they won't be
        //'<1' becomes '< 1'(note: somewhat application specific)
        $text = preg_replace(array('/<([0-9]+)/'), array('< $1'), $text);
        $text = strip_tags($text, $allowed_tags);
        //eliminate extraneous whitespace from start and end of line, or anywhere there are two or more spaces, convert it to one
        $text = preg_replace(array('/^\s\s+/', '/\s\s+$/', '/\s\s+/u'), array('', '', ' '), $text);
        //strip out inline css and simplify style tags
        $search = array('#<(strong|b)[^>]*>(.*?)</(strong|b)>#isu', '#<(em|i)[^>]*>(.*?)</(em|i)>#isu', '#<u[^>]*>(.*?)</u>#isu');
        $replace = array('<b>$2</b>', '<i>$2</i>', '<u>$1</u>');
        $text = preg_replace($search, $replace, $text);
        //on some of the ?newer MS Word exports, where you get conditionals of the form 'if gte mso 9', etc., it appears
        //that whatever is in one of the html comments prevents strip_tags from eradicating the html comment that contains
        //some MS Style Definitions - this last bit gets rid of any leftover comments */
        $num_matches = preg_match_all("/\<!--/u", $text, $matches);
        if($num_matches){
              $text = preg_replace('/\<!--(.)*--\>/isu', '', $text);
        }
        return $text;
    } 

	function content_handle_edit_minutes(&$meeting)
    {
    	$html = "";
		
    		if ($_REQUEST['minutes_edit']=='save')
    		{                
				$meeting = logic_save_meeting_minutes($meeting['mid'], $_REQUEST['minutes']);
				logic_upload_meeting_image($_FILES['minutes_images'],$meeting['mid']);
				logic_upload_meeting_file($_FILES['minutes_file'],$meeting['mid']);
				
				if (!empty($_REQUEST['links_link']))
				{
					for ($i=0; $i<sizeof($_REQUEST['links_link']); $i++)
					{
						$s = $_REQUEST['links_source'][$i];
						$l = $_REQUEST['links_link'][$i];
						logic_add_meeting_link($meeting['cid'],$meeting['mid'], $s, $l);
					}
				}
				
				
				if (!empty($_REQUEST['deletelink']))
				{
					foreach($_REQUEST['deletelink'] as $key => $mlid)
					{
						logic_delete_meeting_link($mlid, $meeting['cid']);
					}
				}
				
				//die("<pre>".print_r($_REQUEST,true));
				
				if (!empty($_REQUEST['deleteimage']))
				{
					foreach($_REQUEST['deleteimage'] as $key => $img)
					{
						logic_delete_meeting_image($img);
					}
				}
				
				if (!empty($_REQUEST['deletefile']))
				{
					foreach($_REQUEST['deletefile'] as $key => $file)
					{
						logic_delete_meeting_file($file);
					}
				}


				if (isset($_REQUEST['finish_minutes']))
				{
					logic_finish_meeting_minutes($meeting['mid'], isset($_REQUEST['mail_minutes']));				
					header("location: ?cid={$meeting['cid']}");
					die();
				}
				
				$meeting = logic_get_meeting($meeting['mid']);
			}
    		
    		$stats = logic_meeting_stats($meeting);
	/*		
			// update with fresh statistics
			$meeting['minutes_number_of_participants'] = $stats['accepted'];
			$meeting['minutes_number_of_rejections'] = $stats['rejected'];
			$meeting['minutes_percentage'] = $stats['percentage'];
*/


			$images = "";
			if (!empty($meeting['images']))
			{
                $i=1;
				foreach ($meeting['images'] as $img)
				{
					$images .= "<p><img src=/uploads/meeting_image/?miid={$img['miid']}&w=100 width=100px><input type=checkbox name=deleteimage[] value={$img['miid']} id=\"check".$i."img\"><label for=\"check".$i."img\">Slet</label></p>";
                    $i++;
				}
			}
			
			$images .= "<br>";
			
			$meeting['images_html'] = $images;

      $files = "<ul>";
      if (!empty($meeting['files']))
      {
        for($i=0;$i<sizeof($meeting['files']);$i++)
        {
          $f = $meeting['files'][$i];
          $files .= "<li><a href=/uploads/meeting_file?mfid={$f['mfid']} target=_blank>{$f['filename']}</a><br><input type=checkbox name=deletefile[] value={$f['mfid']} id=\"check".$i."files\"><label for=\"check".$i."files\">Slet</label>";
        }
      }
      $files .= "</ul>";
      
			$meeting['files_html'] = $files;
			
		$links = logic_get_meeting_links($meeting['mid']);
		$links_html = "<ul class='meting_links'>";
        $k=1;	
        		
		foreach($links as $l)
		{
            if($l['media_source'] == 'vm')
            {
                $link = $l['media_link'];
                $link = str_replace('http://vimeo.com/', 'http://vimeo.com/api/v2/video/', $link) . '.php';
                $html_returned = unserialize(file_get_contents($link));
                $thumb_url = $html_returned[0]['thumbnail_small'];

                $icon = $thumb_url;
                $wid = '';
            }
            else if($l['media_source'] == 'fb')
            {
                $icon = "http://dev.rtd.dk/template/images/facebook.jpg";
                $wid = '';
            }
            else if($l['media_source'] == 'yt')
            {
                $link = substr($l['media_link'], strpos($l['media_link'], "=") + 1);
                $icon = "http://img.youtube.com/vi/".$link."/2.jpg";
                $wid = '100px';
            }
            			
			$links_html .= "<li><a href='{$l['media_link']}' target=_blank><img width='{$wid}' src='{$icon}'></a><input type=checkbox name=deletelink[] value={$l['mlid']} id=\"check".$k."link\"><label for=\"check".$k."link\"> Slet</label></li>";
            $k++;
		}
		
		$links_html .= "</ul>";
		
		$meeting['links_html'] = $links_html;

			$html .= term_unwrap('meeting_minutes_edit', $meeting);
			
			return $html;
    }

	function content_handle_edit_meeting($mid)
	{
		$cid = isset($_REQUEST['club_id'])?$_REQUEST['club_id']:$_SESSION['user']['cid'];
		
		if (isset($_REQUEST['meeting']))
		{
//			die(print_r($_REQUEST,true));
			$mid = logic_save_meeting($_REQUEST['meeting'],$_REQUEST['mid'], $cid);
			if (file_exists($_FILES["file"]["tmp_name"]))
			{
				logic_upload_meeting_image($_FILES['file'], $mid);
			}
			
			
			
			if (!empty($_REQUEST['deleteimage']))
			{
				foreach($_REQUEST['deleteimage'] as $key => $img)
				{
					logic_delete_meeting_image($img);
				}
			}
			
			if (isset($_REQUEST['send_invitations']))
			{
				$errors = logic_send_invitations($mid);
				if (!empty($errors))
				{
					die(term_unwrap('meeting_error_send', array('ERROR'=>implode($errors,', '))));
				}
			}
			
			header("location: /?mid=$mid");
			die();
		}
		

		$meeting = logic_get_meeting($mid);
		
		if ($mid>0) 
		{
			$duties = logic_get_meeting_duties($mid);
			$cid = $meeting['cid'];
		}
		else 
		{
			$duties = array();
			$cid = $_SESSION['user']['cid'];
		}
		
		
		
		$member_select = "<option value=0>Ingen valgt</option>";
		$active_members = logic_get_active_club_members($cid);		
		foreach ($active_members as $m)
		{
			$member_select .= "<option value=\"{$m['uid']}\">{$m['profile_firstname']} {$m['profile_lastname']}</option>";
		}
		
		$meeting['member_select'] = $member_select;
		
		
		$images = "";
		if (!empty($meeting['images']))
		{
            $i=1;
			foreach ($meeting['images'] as $img)
			{
				$images .= "<p><img src=/uploads/meeting_image/?miid={$img['miid']} width=100px><input type=checkbox name=deleteimage[] value={$img['miid']} id=\"check".$i."img\"><label for=\"check".$i."img\">Slet</label></p>";
                $i++;
			}
		}
		
		$images .= "<br>";

		$did = get_district_for_club($cid);
		$dname = get_district_name( $did );
		$meeting['district'] = $dname['name'];
		
		$html = "<form action=. method=post enctype=\"multipart/form-data\" onsubmit='return validatemeeting();'>
						<input type=hidden name=mid value=\"$mid\">
						<input type=hidden name=club_id value=\"$cid\">
						<input type=hidden name=edit value=ok>
						".term_unwrap('meeting_edit', $meeting)."
						$images
						<input type=submit value='".term('save_meeting')."' class=\"btn\">
						</form>
						";
		
		return $html;
	}
	
	function content_handle_ics($meeting)
	{
		header("Content-Type: text/Calendar");
		header("Content-Disposition: inline; filename='RTD-{$meeting['mid']}.ics'");
		die(logic_build_ics($meeting));
	}
	
  function content_handle_meeting_collection($seed)
  {
  	$seed = str_replace("/", "99", $seed);
    $items = logic_get_minutes_collection($seed,logic_get_district_for_user($_SESSION['user']['uid']), $_SESSION['user']['cid']);
    return term_unwrap('minutes_collection', array('seed'=>$seed,'data'=>addslashes(json_encode($items))));
  }
	
	function content_handle_meeting()
	{
		$meeting = logic_get_meeting($_REQUEST['mid']);
		if (!$meeting) return term('meeting_deleted');

		if (!logic_is_member() && !logic_is_mummy()) return term('article_must_be_logged_in');
		
		if (isset($_REQUEST['unlock']) && logic_may_edit_meeting($meeting['cid']))
		{
			logic_unlock_meeting_minutes($_REQUEST['mid']);
		}


    if (isset($_REQUEST['collection']))
    {
      return content_handle_meeting_collection($_REQUEST['collection']);
    }
		
		if (isset($_REQUEST['delete']) && $_REQUEST['mid']>0)
		{
			logic_delete_meeting($_REQUEST['mid']);
			header("location: /?cid=".$_SESSION['user']['cid']);
		}
	
		// update with fresh statistics
		

		
		if (isset($_REQUEST['ics']))
		{
			return content_handle_ics($meeting);
		}

		
		if (($_REQUEST['mid']<0 || isset($_REQUEST['edit'])) && logic_may_edit_meeting($_SESSION['user']['cid']) || $_REQUEST['mid'] == '-1')
		{
			return content_handle_edit_meeting($_REQUEST['mid']);
		}
		else if (($_REQUEST['mid']<0 || isset($_REQUEST['minutes_edit'])) && logic_may_edit_meeting($_SESSION['user']['cid']) && (!logic_meeting_minutes_finished($meeting)))
		{
			return content_handle_edit_minutes($meeting);
		}
		else
		{
			$meeting = logic_get_meeting($_REQUEST['mid']);

			if (isset($_REQUEST['attendance']))
			{
				logic_save_meeting_attendance($meeting['cid'], $meeting['mid'], $_REQUEST['attendance']['uid'], $_REQUEST['attendance']['accept'], $_REQUEST['attendance']['comment']);
			}


			$meeting['location'] = strip_tags($meeting['location']);
			$duties = logic_get_meeting_duties($meeting['mid']);
		    $stats = logic_meeting_stats($meeting);
/*
		echo "<!--";
		$meeting['minutes_number_of_externals'] = $stats['external'];
		$meeting['minutes_number_of_participants'] = $stats['accepted'];
		$meeting['minutes_number_of_rejections'] = $stats['rejected'];
		$meeting['minutes_percentage'] = $stats['percentage'];
		print_r($stats);
		echo "-->";
*/



			
			// show header
			$html = '<div class="container meeting_technog">
						<div class="col-xs-12 col-sm-8 col-md-10 right-part">
							<article class="post single-post">';
                            			
			$may_edit_meeting = logic_may_edit_meeting($meeting['cid']) && !logic_meeting_minutes_finished($meeting);
			if ($may_edit_meeting)
			{
				$html .= term_unwrap('meeting_edit_header', $meeting);
			}
			
			if (logic_may_edit_meeting($meeting['cid']) && logic_meeting_minutes_finished($meeting))
			{
				$html .= term_unwrap('meeting_admin_unlock_minutes', $meeting);
			}
			
			// show header img - if exists
			if (!empty($meeting['images'])) 
			{
				$top_img = array('img' => $meeting['images'][0]['miid']);
				$html .= '<div class="post-heading">
        					<div class="thumbnail">';
				$html .= term_unwrap('meeting_top_image', $top_img);
				$html .= '</div>
							</div>';
			}
            $html .= term_unwrap('meeting_header', $meeting);
			
			
			// show invitation            
			    $html .= '<div class="post-content">';
				$html .= '';
                $day = date('d',strtotime($meeting['start_time']));
                $month = date('M',strtotime($meeting['start_time']));
                $fullday = date('F',strtotime($meeting['start_time']));
                $year = date('Y',strtotime($meeting['start_time']));
                $starting_time = date('H:i',strtotime($meeting['start_time']));
				
				$startdate = date('Y-m-d',strtotime($meeting['start_time']));
				$enddate = date('Y-m-d',strtotime($meeting['end_time']));
				
				if(strtotime($startdate) == strtotime($enddate))
				{
                	$final_time = date('H:i',strtotime($meeting['end_time']));
				}
				else
				{
					$final_time = date('d M F Y H:i',strtotime($meeting['end_time']));
				}
                
                $meeting['day'] = $day;
                $meeting['month'] = $month;
                $meeting['year'] = $year;
                $meeting['starting_time'] = $starting_time;
                $meeting['final_time'] = $final_time;
                $meeting['fullday'] = $fullday;
                    
                    $files = logic_get_meeting_files($meeting['mid']);  
                                
					$html .= term_unwrap('meeting_invite1', $meeting);
					$html .= '<div class="col-xs-12 col-sm-6">';
                    if($files)
                    {
                    $html .= '<a class="btn btn-xs" href="/uploads/meeting_file?mfid='.$files[0]['mfid'].'">Download m&oslash;dereferat</a>';
                    }
					$html .= '<h3 class="title">Pligter</h3>';
					$html .= '<dl class="dl-horizontal">';
                    //echo "<pre>"; print_r($duties);
                    
                    if(!empty($duties)) {                       
					$html .= term_unwrap('meeting_duties', $meeting);
                    }
                    
					foreach($duties as $duty => $user)
					{ 
						if (strstr($duty,'ext')!==false)
						{
							$k = str_replace('uid', 'text', $duty);
							$user['duty'] = strip_tags($meeting[$k]);
						}
						else
						{
							$user['duty'] = term($duty);
						}
						
						$html .= term_unwrap('meeting_duty', $user);
					}
					
					$html .= '</dl>';
                    
					$html .= '</div>';
					$html .= term_unwrap('meeting_invite2', $meeting);
				$html .= '';
			$html .= '</div></article>';
            
            // gallery images
			if (sizeof($meeting['images'])>1)
			{
                $html .= "<div class='row'><h3>M&oslash;debilleder</h3>";
				for ($i=1;$i<sizeof($meeting['images']);$i++)
				{                    
					$top_img = array('img' => $meeting['images'][$i]['miid']);
					$html .= term_unwrap('meeting_bottom_image', $top_img);
				}
                $html .= "</div>";
			}
            
            //$html .= term_unwrap('meeting_invite', $meeting);
			$links = logic_get_meeting_links($meeting['mid']);
			if (!empty($links))
			{
				$html .= term_unwrap('meeting_links', $links, true);
			}
			
			// show duties
			
			/*foreach($duties as $duty => $user)
			{
				if (strstr($duty,'ext')!==false)
				{
					$k = str_replace('uid', 'text', $duty);
					$user['duty'] = strip_tags($meeting[$k]);
				}
				else
				{
					$user['duty'] = term($duty);
				}
				
				$html .= term_unwrap('meeting_duty', $user);
			}*/
			
			
			
			
			
				if (logic_is_club_secretary($meeting['cid']) || logic_is_admin() || logic_is_national_board_member())
				{
          if (isset($_REQUEST['commandoraid']))
          {            
            fire_sql("update meeting_attendance set accepted=0, response_date=now(), comment='Commandoraid' where mid='{$meeting['mid']}'");
            /*die("update meeting_attendance set accepted=0, response_date=now(), comment='Commandoraid' where mid='{$meeting['mid']}'");*/
          }
          
        
          $foreign_data = get_data(
            "select role.uid, (select concat(user.profile_firstname,' ', user.profile_lastname) from user where user.uid=role.uid) as member , role.end_date, now(),
(select (select name from club where club.cid=user.cid) from user where user.uid=role.uid) as club

from role where (role.rid=26 or role.rid=6) and (role.end_date>now() and role.start_date<now()) order by club asc"
          );
					$html .= term_unwrap('meeting_attendance_secretary_add', 
          array("allmembers"=>$foreign_data,
                "members"=>logic_get_active_club_members($meeting['cid']), 
                "mid" => $meeting['mid']), true);
				}
			
			
			// show minutes
			if (logic_meeting_minutes_finished($meeting))
			{
				if (isset($_REQUEST['rating']))
				{
				  logic_put_meeting_rating($meeting['mid'],$_SESSION['user']['uid'],$_REQUEST['rating']);
				}
				$html .= term_unwrap('meeting_rating', logic_get_meeting_rating($meeting['mid']));
				if (!logic_is_mummy())
				if (!logic_meeting_rated($meeting['mid'],$_SESSION['user']['uid']))
				{
				  $html .= term_unwrap('meeting_rate_form', $meeting);
				}
				$meeting['minutes'] = fix_minutes($meeting['minutes']);
				$meeting['minutes_3min'] = fix_minutes($meeting['minutes_3min']);
				$meeting['minutes_letters'] = fix_minutes($meeting['minutes_letters']);
				$html .= term_unwrap('meeting_minutes', $meeting);


				$html .= term_unwrap('meeting_attendance_pre', $stats);
				
				$attendance = fetch_meeting_attendance($meeting['mid']);
				
				
				foreach($attendance as $k => $v)
				{
                    $v['mid'] = $meeting['mid'];
					if ($v['accepted']=='0')
					{
						$v['status'] = term('meeting_attendance_no');
					}
					else if ($v['response_date']=='')
					{
						$v['status'] = term('meeting_attendance_idle');
					}
					else 
					{
						$v['status'] = term('meeting_attendance_yes');
					}
					if ($may_edit_meeting)
					{
						$html .= term_unwrap('meeting_attendance_item_edit', $v);
					}
					else
					{
						$html .= term_unwrap('meeting_attendance_item', $v);
					}
					
				}
				$html .= term('meeting_attendance_post');
			}
			else
			{
				$stats = logic_meeting_stats($meeting);
				
				$html .= term_unwrap('meeting_attendance_pre', $stats);
				
				$attendance = fetch_meeting_attendance($meeting['mid']);
				
				
				foreach($attendance as $k => $v)
				{
                    $v['mid'] = $meeting['mid'];
					if ($v['accepted']=='0')
					{
						$v['status'] = term('meeting_attendance_no');
					}
					else if ($v['response_date']=='')
					{
						$v['status'] = term('meeting_attendance_idle');
					}
					else 
					{
						$v['status'] = term('meeting_attendance_yes');
					}
					if ($may_edit_meeting)
					{
						$html .= term_unwrap('meeting_attendance_item_edit', $v);
					}
					else
					{
						$html .= term_unwrap('meeting_attendance_item', $v);
					}
					
				}
				$html .= term('meeting_attendance_post');
				
		
			
				if (logic_show_attendance_form($meeting) || logic_is_special_club($meeting['cid']))
				{
					$data = array_merge($meeting, $_SESSION['user']);
					$html .= term_unwrap('meeting_attendance_form', $data);
				}
			}
			
			$files = logic_get_meeting_files($meeting['mid']);
      if (!empty($files)) $html .= term_unwrap('meeting_files', array('files'=>json_encode($files)));      			
            
			set_title($meeting['title']);	
			$html .= '</div>
			</div>'	;
			
			if (logic_may_edit_meeting($meeting['cid']))
			{
				$html .= term_unwrap('meeting_views', array('DATA'=>json_encode(fetch_meeting_views($meeting['mid']))));
			}
			
			
			return $html;
		}
	}


?>