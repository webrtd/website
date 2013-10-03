<?
	/*
		article box plugin (c) 3kings.dk
		
		31-10-2012	rasmus@3kings.dk	draft
	*/
	
	if ($_SERVER['REQUEST_URI'] == $_SERVER['PHP_SELF']) header("location: /");
	
	plugin_register('ARTICLEBOX', 'articlebox');
	

	$box_article_html = "";

	function box_walk_articles(&$item)
	{	
		global $box_article_html;
	
	
		if ($item['public'] || logic_is_member())
		{
			
			if (!empty($item['children']))
			{
				$box_article_html .= "<li class=parent><a href=?aid={$item['aid']}>{$item['title']}</a>";
				$box_article_html .= "<ul>";
				array_walk($item['children'], 'box_walk_articles');
				$box_article_html .= "</ul>";
				
			}
			else
			{
				$box_article_html .= "<li><a href=?aid={$item['aid']}>{$item['title']}</a>";
			}
			
			$box_article_html .= "</li>";
		}
	}

	
	
	function articlebox()
	{
		global $box_article_html;
		$content = term('article_pretext');
		
    $articles = cache_get("article_menu");
    if (!$articles)
    {
      $articles = logic_get_articles();
      cache_put("article_menu", $articles);
    }
		array_walk($articles, 'box_walk_articles');
		$content .= "<ul id=articles>$box_article_html</ul>";	
/*		
		$content .= "
		<script>$(function() {
				$('#adminmenu').menu();
			});</script>
		<ul id=adminmenu>
			<li><a href=#>".term('admin_edit_article')."</a>
			<ul>
			$admin_article_html
			<li><a href=?admin=article&edit=-1>".term('admin_create_article')."</a></li>
			</ul></li>
		</ul>
		";
*/		
		return $content;
	}
?>