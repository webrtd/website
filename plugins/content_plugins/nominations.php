<?
	if ($_SERVER['REQUEST_URI'] == $_SERVER['PHP_SELF']) header("location: /");
		
	content_plugin_register('nominations', 'content_handle_nomination', 'Rollenominering');

	function content_handle_nomination()
	{
		if (!logic_is_admin()) return term('article_must_be_logged_in');
		$rid = $_REQUEST['nominations'];
		
		if (isset($_REQUEST['nid']))
		{
			if (isset($_REQUEST['reject']))
			{
				logic_reject_nomination($_REQUEST['nid']);			
			}
			else
			{
				logic_approve_nomination($_REQUEST['nid']);			
			}
			
		}
		
		$result = array(
			"role" => logic_get_role_description($rid),
			"result" =>	addslashes(json_encode(logic_get_nominations($rid)))
			);
		return term_unwrap('nominations', $result);
	}
?>