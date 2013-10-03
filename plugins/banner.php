<?
	/*
		banner plugin (c) 3kings.dk
		
		03-11-2012	rasmus@3kings.dk	draft
	*/
	
	if ($_SERVER['REQUEST_URI'] == $_SERVER['PHP_SELF']) header("location: /");
	
	plugin_register('BANNER_1', 'banner1');
	plugin_register('BANNER_2', 'banner2');
	plugin_register('BANNER_3', 'banner3');
	
	function banner1()
	{
		if (!logic_is_member() && !logic_is_mummy()) return "";
		$b = current(logic_get_banners(1, 1));
		return "<a target=_blank href=?banner&click={$b['bid']} title=\"{$b['title']}\"><img src=?banner&img={$b['bid']} class=box id=left_ad1></a>";
	}
	
	function banner2()
	{
		if (!logic_is_member() && !logic_is_mummy()) return "";
		$b = current(logic_get_banners(2, 1));
		return "<a target=_blank href=?banner&click={$b['bid']} title=\"{$b['title']}\"><img src=?banner&img={$b['bid']} class=box id=right_ad1></a>";
	}
	
	function banner3()
	{
		if (!logic_is_member() && !logic_is_mummy()) return "";
		$b = current(logic_get_banners(3, 1));
		return "<a target=_blank href=?banner&click={$b['bid']} title=\"{$b['title']}\"><img src=?banner&img={$b['bid']} class=box id=right_ad2></a>";
	}
?>