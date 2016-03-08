<?
	/*
		banner plugin (c) 3kings.dk
		
		03-11-2012	rasmus@3kings.dk	draft
		13-01-2014	rasmus@3kings.dk	rewamped for new banner system
	*/
	
	if ($_SERVER['REQUEST_URI'] == $_SERVER['PHP_SELF']) header("location: /");
	
	plugin_register('BANNER_1', 'banner1');
	plugin_register('BANNER_2', 'banner2');
	plugin_register('BANNER_3', 'banner3');
	
	function banner1()
	{
		if (!logic_is_member() && !logic_is_mummy()) return "";
    if (logic_is_mummy())
    {
  		return term_unwrap('banner_1',array());
    }
    else
    {
  		$dn = logic_get_district_name(logic_get_district_for_user($_SESSION['user']['uid']));		
  		return term_unwrap('banner_1',array('district'=>$dn));
    }
	}
	
	function banner2()
	{
		if (!logic_is_member() && !logic_is_mummy()) return "";
    if (logic_is_mummy())
    {
  		return term_unwrap('banner_2',array());
    }
    else
    {
  		$dn = logic_get_district_name(logic_get_district_for_user($_SESSION['user']['uid']));	
  		return term_unwrap('banner_2',array('district'=>$dn));
    }
	}
	
	function banner3()
	{
		if (!logic_is_member() && !logic_is_mummy()) return "";
    if (logic_is_mummy())
    {
  		return term_unwrap('banner_3',array());
    }
    else
    {
  		$dn = logic_get_district_name(logic_get_district_for_user($_SESSION['user']['uid']));		
  		return term_unwrap('banner_3',array('district'=>$dn));
    }
	}
?>