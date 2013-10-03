<?
	/*
		login box plugin (c) 3kings.dk
		
		31-10-2012	rasmus@3kings.dk	draft
	*/
	
	if ($_SERVER['REQUEST_URI'] == $_SERVER['PHP_SELF']) header("location: /");
	
	plugin_register('LATESTMEMBERS', 'latestmembers');
	
	function latestmembers()
	{
		if (logic_is_member())
		{
			$members = logic_get_latest_members();
			
			$data = array();
			for($i=0;$i<sizeof($members);$i++)
			{
				$key_prefix = "member_{$i}_";
				foreach($members[$i] as $key => $value)
				{
					$data[$key_prefix.$key]=$value;
				}
			}
			
			return term_unwrap('latestmembers', $data);
		}
		else
		{
			return "";
		}
	}
	