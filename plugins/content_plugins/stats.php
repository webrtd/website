<?
/*
		content plugin stats (c) 3kings.dk
		
		22-02-2013	rasmus@3kings.dk	draft
	*/

	if ($_SERVER['REQUEST_URI'] == $_SERVER['PHP_SELF']) header("location: /");
		
	content_plugin_register('stats', 'content_handle_stats', 'Statistik');


	
	function content_handle_stats()
	{
		
		if (!logic_is_member())
		{
		  header("location: ?aid=-1");
		  die();
		}
	
		if (isset($_REQUEST['modify']))
		{
			$modify = $_REQUEST['modify'];
		}
		else
		{
			$modify = 0;
		}
		$data = array();
		$data['jubilees'] = logic_get_member_jubilees($modify);
		$data['club_jubilees'] = logic_get_club_jubilees($modify);
		$data['details'] = logic_get_detailed_stats();
		$data['meetings'] = logic_best_club_meetings();
		$data['modify']=$modify;
		$data['notifications'] = logic_new_updates(date("Y-m-d", time() - 60 * 60 * 24););


    if (isset($_REQUEST['debug']))echo "<pre>".print_r($data,true)."</pre>";
    $html = term_unwrap('stats', $data, true);
		return $html;
	}
?>
