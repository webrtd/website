<?
	/*
		content plugin calendar (c) 3kings.dk
		
		05-03-2013	rasmus@3kings.dk	draft
	*/

	if ($_SERVER['REQUEST_URI'] == $_SERVER['PHP_SELF']) header("location: /");
		
	content_plugin_register('cal', 'content_handle_calendar', 'Kalender');
	
	function content_handle_calendar()
	{
		$data =logic_get_calendar_meetings();
		$colors = array(
			"red", "green", "navy", "blue", 
			"purple", "lightgreen", "gray", "teal", "fuchsia", "black"
		);
		
		$country_events = array();
		$d = "<p><table cellpadding=5><tr>";
		$map_events = array();
		foreach ($data as $district => $meetings)
		{
			$c = current($colors);
			next($colors);
			
			$d .= "<td bgcolor=$c color=white align=center><a href='/?cal=$district'><font color=white>$district</a></a></td>";

			if ($_REQUEST['cal']=="" || $_REQUEST['cal']==$district)
			{
				$events = array();
				foreach ($meetings as $m)
				{
					$title = addslashes($m['name']." ".$m['title']);
					$start = ($m['start_time']);
					$end = ($m['end_time']);
					$url = "/?mid={$m['mid']}";
					$loc = $m['location'];//explode(" - ", $title);
					 
					$map_events[] = array(
					"title" => $title,
					"start"=>$start,
					"end"=>$end,
					"url"=>$url,
					"date"=>date("Y-m-d", strtotime($start)),
					"location"=>urlencode($loc)
					);
					
					
					$events[] = "
					{
						title : '{$title}',
						start : '{$start}',
						end : '{$end}',
						url : '{$url}'
					}";
				}
				$event_str = implode(",", $events);
				$country_events[] = "{events:[{$event_str}],color:'{$c}'}\n";
			}
		}
		$d .= "</tr></table></p>";
		
		$event_str = implode(",", $country_events);
		
		if (isset($_REQUEST['map']))
		{
			return term_unwrap('calendar_map', array('title'=>$_REQUEST['cal'],"colors" => $d, "data" => json_encode($map_events)));
		}
		else
		{
			return term_unwrap('calendar', array('title'=>$_REQUEST['cal'],"colors" => $d, "events" => $event_str));
		}
	}
?>