<?
	/*
		login box plugin (c) 3kings.dk
		
		31-10-2012	rasmus@3kings.dk	draft
		13-03-2013	rasmus@3kings.dk	fixed unread messages in imap check
		04-09-2015	rasmus@3kings.dk	missing password fixed
	*/
	
	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/class.phpmailer.php';
	
	if ($_SERVER['REQUEST_URI'] == $_SERVER['PHP_SELF']) header("location: /");
	
	plugin_register('LOGINBOX', 'loginbox');
	
	
	function build_hash($username, $password_hash)
	{
		return md5($username.$password_hash.COOKIE_SALT);
	}
  
  function get_cookie_name() 
  {
		$sn = $_SERVER['SERVER_NAME'];
		$cookie = $sn.'_LOGIN_COOKIE';
    return $cookie;
  }

	function auto_login()
	{
		$cookie = unserialize($_COOKIE[get_cookie_name()]);
		$verify = build_hash($cookie['username'],$cookie['hash1']);
		if ($verify == $cookie['hash2'])
		{
			$_SESSION['user'] = logic_login($cookie['username'], $cookie['hash1']);
		}
	}

	function send_password()
	{
			$user = logic_get_user_by_username($_REQUEST['sendpassword']);
			if ($user)
			{
				if (defined('GENERATE_NEW_USER_PASSWORD') && GENERATE_NEW_USER_PASSWORD)
				{
					$password = logic_generate_password($user);
				}
				else
				{
					$password = DEFAULT_NEW_USER_PASSWORD;	
				}
				$data = array(
					'username' => $user['username'],
					'password' => $password,
					'last_page_view' => '0000-00-00'
				);
				logic_save_user($user['uid'], array('password'=>md5($password)));
				
				logic_save_mail($user['private_email'], term('mail_new_password_subject'), term_unwrap('mail_new_password_content', $data));
				return term('new_password_sent');
			}
			else
			{
				return term('error_user_not_found');
			}
	}
	function check_club_mail($club)
	{
		if (NB_MAIL_POSTFIX != '@rtd.dk')	return;
		$i = logic_check_clubmail($club);
		if ($i>0)
		{
			$pwd = $club['webmail_password'];
			$box = logic_club_mail($club['cid']);
			echo term_unwrap("unread_mail_notify",array("Unread"=>$i,"mailbox"=>$box, "webmail_password"=>$pwd));
		}
		else if ($i<0)
		{
			echo (term('unable_to_open_mailbox'));
			
		}
	}
		
	function manual_login()
	{
		$user = logic_login($_REQUEST['username'], $_REQUEST['password']);
		if ($user!==false) 
		{
			$_SESSION['user'] = $user;
			$html = "";		
			
			if (isset($_REQUEST['remember']))
			{
				$cookie = array(
					"username" => $_SESSION['user']['username'],
					"hash1" => $_SESSION['user']['password'],
					"hash2" => build_hash($_SESSION['user']['username'], $_SESSION['user']['password'])
				);
				setcookie(get_cookie_name(), serialize($cookie), time()+3600*24*30, "/", str_replace("www.", "", $_SERVER['HTTP_HOST']));
			}
			
			$show_news = logic_should_show_news();
			if (logic_should_update_details())
			{
				$html .= term_unwrap('user_should_update_details', $_SESSION['user']);
			}
			else if ($show_news)
			{
				$html .= term_unwrap('user_should_see_news', array('nid'=>$show_news));
			}
			if (!isset($_REQUEST['redirect']) || $_REQUEST['redirect'] == '/?logout')
			{
					$html .= "<script>document.location.href='/';</script>";
			}
			else
			{
		
					$html .= "<script>document.location.href='{$_REQUEST['redirect']}';</script>";
			}
			
			if (logic_is_secretary() || logic_is_chairman()) check_club_mail(logic_get_club($_SESSION['user']['cid']));
			
			die($html);
			
		}
		else $error_str = term('login_incorrect');
	}
	
	function loginbox()
	{
		if (!logic_is_member() && isset($_COOKIE[get_cookie_name()]))
		{
			auto_login();
		}
		$error_str = "";
		if (isset($_REQUEST['sendpassword']))
		{
			die(send_password());
		}
		if (isset($_REQUEST['logout']))
		{
			unset($_SESSION['user']);
			setcookie(get_cookie_name(),'');
		}
		else if (isset($_REQUEST['login']))
		{
			manual_login();
		}
		if (isset($_SESSION['user']))
		{
			$data = addslashes(json_encode(logic_get_duties($_SESSION['user']['uid'])));
			return "<script>var notification_update_json = '$data';</script>".term_unwrap('login_content', $_SESSION['user']);
		}
		else
		{
			return term_unwrap('login_prompt',$_SERVER);
		}
	}
	
?>
