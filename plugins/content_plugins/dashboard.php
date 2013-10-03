<?
/*
	content plugin minutes (c) 3kings.dk
	
	17-01-2013	rasmus@3kings.dk	draft
*/

if ($_SERVER['REQUEST_URI'] == $_SERVER['PHP_SELF']) header("location: /");

	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/pop.php';	
	content_plugin_register('dashboard', 'content_handle_dashboard', 'Dashboard');


function content_handle_dashboard()
{
	if (!logic_is_member()) return term('article_must_be_logged_in');
	
	if (is_numeric($_REQUEST['dashboard'])) $cid = $_REQUEST['dashboard'];
	else $cid = $_SESSION['user']['cid'];
	
	$data = array();
	$data['club'] = logic_get_club($cid);
	$data['members'] = logic_get_active_club_members($cid);
	
	//check_club_mail($data['club']);
	
	for($i=0;$i<sizeof($data['members']);$i++)
	{
		$data['members'][$i]['details'] = logic_get_user_year_details_stats($data['members'][$i]['uid']);
		$data['members'][$i]['stats'] = logic_get_user_stats($data['members'][$i]['uid'],$cid);
	}
	
	$data['club_stats'] = logic_get_club_stats($cid);
	
	$html = term_unwrap('dashboard', $data, true);

	$s = logic_get_club_year_start();
	$e = logic_get_club_year_end();
	$year_title = substr($s, 0, 4)."-".substr($e,0,4);
	
	if (isset($_REQUEST['download'])) 
	{
		$club_meetings = logic_get_club_meetings($cid);
		$attendance = array();
		
		$html = "<table border=1>";
		
		// headers
		$html .= "<tr>";
		$html .= "<th>{$data['club']['name']}</th>";
		$html .= "<th>Extern</th>"; 
		$html .= "<th>Total</th>";
		foreach ($club_meetings as $m)
		{
			$html .= "<th>{$m['title']}</th>";
			$attendance[$m['mid']] = fetch_meeting_attendance($m['mid']);
		}
		$html .= "</tr>";
		
		
		foreach($data['members'] as $u)
		{
			$html .= "<tr>";
			
			$html .= "<td>{$u['profile_firstname']} {$u['profile_lastname']}</td>";
			
			$html .= "<td>".$u['stats'][$year_title]['non_home_meeting']."</td>";
			$html .= "<td>".($u['stats'][$year_title]['accepted']+$u['stats'][$year_title]['non_home_meeting'])."</td>";
			foreach ($club_meetings as $m)
			{
				$attend = false;
				if (isset($attendance[$m['mid']]))
				{
					$a = &$attendance[$m['mid']];
					foreach ($a as $ma)
					{
						if ($ma['uid']==$u['uid']) $attend=true;
					}
				}
				if ($attend)
				{
					$html .= "<td>x</td>";
				}
				else
				{
					$html .= "<td></td>";
				}
			}
			
			$html .= "</tr>";
		}
		
		
		
		$html .= "</table>";
		
		echo utf8_decode($html);
		
		
	/*
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private",false);
		header("Content-Type: application/octet-stream");
		header("Content-Disposition: attachment; filename=\"dashboard-{$cid}.csv\";" );
		header("Content-Transfer-Encoding: binary");
		
		$csv_data = array();
		for ($i=0;$i<sizeof($data['members']); $i++)
		{
			$m = &$data['members'][$i];
			for ($j=0;$j<sizeof($m['details']);$j++)
			{
				$e = &$m['details'][$j];
				$csv_data[$e['title']][$m['uid']] = 'x';
				$csv_data[$e['title']]['--data--'] = logic_meeting_stats(logic_get_meeting($e['mid']));
				$csv_data[$e['title']]['internal'] = $e['cid']==$cid;
			}
		}
		if (isset($_REQUEST['debug'])) echo utf8_decode(print_r($data,true));
		
		$caption = "<table><tr>";
		$caption .= "<th>{$data['club']['name']}</th><th>#</th><th>Ude</th>";
		$guest = "<tr><td>Extern</td><td>-</td><td>-</td><td>-</td>";
		$intern = "<tr><td>Intern</td><td>-</td><td>-</td><td>-</td>";
		$total = "<tr><td>Total</td><td>-</td><td>-</td><td>-</td>";
		foreach ($csv_data as $meeting_title => $x)
		{
			if ($x['internal'])
			{
				$caption .= "<th>$meeting_title</th>";
			}
			else
			{
				$caption .= "<th>Extern<br>$meeting_title</th>";
			}
			
			$guest .= "<td>{$x['--data--']['external']}</td>";
			$intern .= "<td>{$x['--data--']['accepted']}</td>";
			$total .= "<td>{$x['--data--']['total']}</td>";
		}
		$total .= "</tr>";
		$guest .= "</tr>";
		$intern .= "</tr>";
		$caption .= "</tr>";
		echo utf8_decode($caption)."\n";
		echo utf8_decode($intern)."\n";
		echo utf8_decode($guest)."\n";
		echo utf8_decode($total)."\n";

		for ($i=0;$i<sizeof($data['members']); $i++)
		{
			$m = &$data['members'][$i];

			$row = "<tr>";
			$row .= "<td>{$m['profile_firstname']} {$m['profile_lastname']}</td>";
			
			
			$meeting_count = 0;
			$row_data = "";
			foreach ($csv_data as $meeting_title => $x)
			{
				if (isset($x[$m['uid']])) 
				{
					$row_data .= "<td>x</td>";
					$meeting_count++;
				}
				else $row_data .= "<td></td>";
			}
			
//			$row .= "<td>".($meeting_count/sizeof($csv_data))."</td>";
			$row .= "<td>".$meeting_count."</td>";
			$row .= "<td>".$m['stats'][$year_title]['non_home_meeting']."</td>";		
			$row .= $row_data;
			$row .= "</tr>";
			
			echo utf8_decode($row);
		}
		
		echo "</table>";
		*/
		
			
			
//		print_r($csv_data);
		die();
	}
	
	set_title('Dashboard - '.$data['club']['name']);
	
	return $html;
	
}
