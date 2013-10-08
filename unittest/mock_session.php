<?
	function mock_session_clear()
	{
		$_SESSION['user'] = '';
	}
	
	function mock_session_setup()
	{
		$_SESSION['user'] = array(
			'uid' => 1,
			'username' => 'Dummy'
		);
	}
?>