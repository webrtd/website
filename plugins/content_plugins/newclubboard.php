<?
	if ($_SERVER['REQUEST_URI'] == $_SERVER['PHP_SELF']) header("location: /");
		
	content_plugin_register('kbp', 'content_handle_new_club_board','Kommende bestyrelse');
	
	function content_handle_new_club_board()
	{
		if (!logic_is_secretary()) return term('article_must_be_logged_in');
		
		if (!logic_club_board_submission_period())
		{
			return term('not_club_board_submission_period');
		}

		$board = logic_get_club_board_period($_SESSION['user']['cid'],1);
		
		if (isset($_REQUEST['role']))
		{
			$start = logic_get_club_year_start(1);
			$end = logic_get_club_year_end(1);
			
			$err = false;
			
			$event_data = array();
			
			foreach ($_REQUEST['role'] as $rid => $uid)
			{
				$event_data[$rid] = $uid;
				logic_add_role1($uid, $rid, $start, $end);
			}

			event_new_club_board($_SESSION['user']['cid'], $event_data);
			return term('new_club_board_submitted');
		}
		else if (!empty($board))
		{
			return term_unwrap('review_club_board', $board, true);
		}
		else
		{
			$data = array(
				'board_roles' => addslashes(json_encode(logic_get_club_board_roles())),
				'club_members' => addslashes(json_encode(logic_get_active_club_members($_SESSION['user']['cid']))),
				'period_start' => logic_get_club_year_start(1),
				'period_end' => logic_get_club_year_end(1)
				
			);
			return term_unwrap('new_club_board',$data);		
		}
	}
?>