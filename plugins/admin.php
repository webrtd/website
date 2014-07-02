<?
	/*
		admin box plugin (c) 3kings.dk
		
		31-10-2012	rasmus@3kings.dk	draft
	*/
	
	if ($_SERVER['REQUEST_URI'] == $_SERVER['PHP_SELF']) header("location: /");
	
	plugin_register('ADMINBOX', 'adminbox');
	

	$admin_article_html = "";

	function admin_walk_articles(&$item)
	{	
		global $admin_article_html;
	
	
		
		if (!empty($item['children']))
		{
			$admin_article_html .= "<li class=parent><a href=?admin=article&edit={$item['aid']}>{$item['title']}</a>";
			$admin_article_html .= "<ul>";
			array_walk($item['children'], 'admin_walk_articles');
			$admin_article_html .= "</ul>";
		}
		else
		{
			$admin_article_html .= "<li><a href=?admin=article&edit={$item['aid']}>{$item['title']}</a>";
		}
		
		$admin_article_html .= "</li>";
		
	}

	
	
	function adminbox()
	{
		global $admin_article_html;
		$content = "";
	
		if (logic_is_national_board_member())
		{
			$content .= term('admin_box_national_board');
		}
		
		if (logic_is_secretary())
		{
      $c = logic_get_club($_SESSION['user']['cid']);
      $data = array_merge($c, $_SESSION['user']);
    	$d = explode(" ", $c['name']);
    	$data['mailbox'] = strtolower($d[0])."@roundtable.dk";
      
			$content .= term_unwrap('admin_box_secretary', $data);	
		}
		
		if (logic_is_admin())
		{
			$articles=logic_get_articles();
			
			$data = array('articles'=>json_encode(array('articles'=>$articles)));
			$content .= term_unwrap('admin_box',$data);			
			
		}
		return $content;
	}
?>