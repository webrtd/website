<?
	/*
		title plugin (c) 3kings.dk
		
		23-02-2013	rasmus@3kings.dk	draft
	*/
	
	if ($_SERVER['REQUEST_URI'] == $_SERVER['PHP_SELF']) header("location: /");
	
	mobile_plugin_register('TITLE', 'get_mobile_title');
  
  $mobile_page_title = term('mobile_page_title');
  
  function get_mobile_title()
  {
    global $mobile_page_title;
    if (logic_is_member())
    {
      return term_unwrap('mobile_title_member',array("TITLE"=>$mobile_page_title));
    }
    else
    {
      return term_unwrap('mobile_title_not_member',array("TITLE"=>$mobile_page_title));
    }
  }
  
  function set_mobile_title($title)
  {
    global $mobile_page_title;
    $mobile_page_title=$title;
    
  }
  
  
?>