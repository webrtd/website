<?
	/*
		content plugin other meetings (c) 3kings.dk
		
		29-06-2013	rasmus@3kings.dk	draft
	*/

	if ($_SERVER['REQUEST_URI'] == $_SERVER['PHP_SELF']) header("location: /");
		
	content_plugin_register('omid', 'content_handle_other_meetings', 'Indkald');
  
  function content_handle_other_meetings()
  {
    $html = "";
    if (isset($_REQUEST['omid']) && is_numeric($_REQUEST['omid']))
    {
      $omid = $_REQUEST['omid'];
    }
    else
    {
      $omid = -1;
    }
    
    if ($omid<0)
    {
      if (logic_may_edit_meeting($_SESSION['user']['cid']))
      {
        if (isset($_REQUEST['data']))
        {
          logic_put_other_meeting($_REQUEST['data']);
          header("location: /?cid=".$_SESSION['user']['cid']);
          die();
        }
      
        $html .= term('create_other_meeting');
      }
      else
      {
        header("location: /?cid=".$_SESSION['user']['cid']);
        die();
      }
    }
    
    return $html;
  }
?>