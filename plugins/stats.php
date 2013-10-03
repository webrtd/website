<?
	/*
		front page stats plugin (c) 3kings.dk
		
		03-11-2012	rasmus@3kings.dk	draft
	*/
	
	if ($_SERVER['REQUEST_URI'] == $_SERVER['PHP_SELF']) header("location: /");
	
	plugin_register('STATSBOX', 'statsbox');
	
	function statsbox()
	{
    $stats = cache_get("stats");
    if (!$stats)
    {
      
      $stats = logic_get_stats();
      cache_put("stats", $stats);
    }
    $stats['online'] = logic_get_online_users_count();
		
		return term_unwrap('statsbox', $stats).(logic_is_member()?term('statsbox_advanced_link'):'');
	}
?>