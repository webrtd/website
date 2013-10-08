<?
	function mock_session_clear()
	{
		$_SESSION['user'] = '';
	}
	
	function mock_session_setup()
	{
		$_SESSION['user'] = array(
			'uid' => 1,
			'username' => 'Dummy',
			'cid' => 1,
			'active_roles' => array(array('rid'=>ADMIN_ROLE_RID))
		);
	}
?>