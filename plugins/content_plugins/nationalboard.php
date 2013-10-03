<?
	/*
		content plugin admin terms - used to login as other users (c) 3kings.dk
		
		30-01-2013	rasmus@3kings.dk	draft
	*/

	if ($_SERVER['REQUEST_URI'] == $_SERVER['PHP_SELF']) header("location: /");
		
	content_plugin_register('nb', 'content_handle_nationalboard', 'Hovedbestyrelse');


	function content_handle_nationalboard()
	{
		//if (!logic_is_member()) return term('article_must_be_logged_in');
		
		$data = logic_get_national_board();
		return term_unwrap('national_board', $data, true);		
	}

?>