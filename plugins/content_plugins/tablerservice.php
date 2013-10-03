<?
	/*
		content plugin admin terms - used to login as other users (c) 3kings.dk
		
		29-01-2013	rasmus@3kings.dk	draft
	*/

	if ($_SERVER['REQUEST_URI'] == $_SERVER['PHP_SELF']) header("location: /");
		
	content_plugin_register('ts', 'content_handle_tablerservice', 'Tablerservice');


	function content_handle_tablerservice()
	{
		if (!logic_is_member()) return term('article_must_be_logged_in');

		$tsid = isset($_REQUEST['ts'])?$_REQUEST['ts']:"";
		
		if (isset($_REQUEST['item']))
		{
			logic_put_tabler_service_item($tsid,$_REQUEST['item']);
		}
		
		if (isset($_REQUEST['delete']))
		{
			logic_delete_tabler_service_item($_REQUEST['delete']);
		}

		
		$data = array();
		
		$data['categories'] = logic_get_tabler_service_categories();
		$data['category'] = logic_get_tabler_service_category($tsid);

		if ($data['category']!==false)
		{
			$data['items'] = logic_get_tabler_service_items($tsid);
			set_title('Tablerservice - '.$data['category']['headline']);
		}
		
		return term_unwrap('tabler_service', $data, true);		
	}

?>