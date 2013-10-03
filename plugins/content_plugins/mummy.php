<?
	/*
		content plugin admin terms - used to login as other users (c) 3kings.dk
		
		18-02-2013	rasmus@3kings.dk	draft
	*/

	if ($_SERVER['REQUEST_URI'] == $_SERVER['PHP_SELF']) header("location: /");
		
	content_plugin_register('mummy', 'content_handle_mummy', 'Mumielogin');


	function content_handle_mummy()
	{
		if (isset($_REQUEST['club']))
		{
			$l = logic_mummy_login($_REQUEST['club'], $_REQUEST['password']);
			if ($l)
			{
				$_SESSION['mummy'] = $l;
			}
		}
		if (isset($_REQUEST['logout']))
		{
			unset($_SESSION['mummy']);
		}
	
		if (isset($_SESSION['mummy']))
		{
			die("<script>document.location.href='?cid={$_SESSION['mummy']['cid']}';</script>");
		}
		else
		{
			return term('mummy_login');
		}
	}

?>