<?
	/*
		menu plugin (c) 3kings.dk
		
		23-02-2013	rasmus@3kings.dk	draft
	*/
	
	if ($_SERVER['REQUEST_URI'] == $_SERVER['PHP_SELF']) header("location: /");
	
	mobile_plugin_register('BOTTOM_MENU', 'get_mobile_menu');
  
  
  function get_mobile_menu()
  {
    if (logic_is_member())
    {                                  
      return term('mobile_menu_member');
    }
    else
    {
      return term('mobile_menu_not_member');
    }
  }
  
  
  
?>