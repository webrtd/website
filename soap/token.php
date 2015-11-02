<?	
	chdir($_SERVER['DOCUMENT_ROOT']);

	require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/config_terms.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/logic.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/sessionhandler.php';

	function build_token($user)
	{
		$token_salt = "1-2-3-I-LOVE-RTD";
		$str = $token_salt.$user['password'];
		$uid = $user['uid'];
		$sql = "select md5(concat('{$token_salt}',password)) as token from user where uid={$uid}";
		$data = get_one_data_row($sql);
		return $data['token'];
	}
	
	function get_title()
	{
		return "RTDapp";
	}
		
	function verify_token($token)
	{
		$token_salt = "1-2-3-I-LOVE-RTD";
		$sql = "select uid,username,password from user where STRCMP(md5(concat('{$token_salt}',password)),'{$token}')=0";
		$data = get_one_data_row($sql);
		if (isset($data['uid'])) 
		{
			$_SESSION['user'] = logic_login($data['username'], $data['password'], true);
			logic_update_last_page_view();
			return true;
		}
		else
		{
			session_destroy();
			session_start();
			return false;
		}		
	}
?>