<?
	if ($_SERVER['REQUEST_URI'] == $_SERVER['PHP_SELF']) header("location: /");
		
	content_plugin_register('search', 'content_handle_search', 'S&oslash;g');

	function content_handle_search()
	{
		if (!logic_is_member()) return term('article_must_be_logged_in');
		$old = isset($_REQUEST['old']);
		$result = array(
			"result" =>	addslashes(json_encode(logic_search(addslashes($_REQUEST['search']),$old))),
			"search" => $_REQUEST['search']
			);
            
			set_title('S&oslash;g '.$_REQUEST['search']);
		return term_unwrap('search_results', $result);
	}
?>