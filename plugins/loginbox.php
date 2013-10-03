<?
	/*
		login box plugin (c) 3kings.dk
		
		31-10-2012	rasmus@3kings.dk	draft
		13-03-2013	rasmus@3kings.dk	fixed unread messages in imap check
	*/
	
	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/class.phpmailer.php';
	
	if ($_SERVER['REQUEST_URI'] == $_SERVER['PHP_SELF']) header("location: /");
	
	plugin_register('LOGINBOX', 'loginbox');
	
	
	function build_hash($username, $password_hash)
	{
		return md5($username.$password_hash.COOKIE_SALT);
	}

	function auto_login()
	{
		$cookie = unserialize($_COOKIE['RTD_LOGIN_COOKIE']);
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
				$data = array(
					'username' => $user['username'],
					'password' => DEFAULT_NEW_USER_PASSWORD,
					'last_page_view' => '0000-00-00'
				);
				logic_save_user($user['uid'], array('password'=>md5(DEFAULT_NEW_USER_PASSWORD)));
				
				logic_save_mail($user['private_email'], term('mail_new_password_subject'), term_unwrap('mail_new_password_content', $data));
				return term('new_password_sent');
			}
			else
			{
				return term('error_user_not_found');
			}
	}
/*
function pop3_login($host,$port,$user,$pass,$folder="INBOX",$ssl=false)
{
	return imap_open("{{$host}:{$port}/novalidate-cert}INBOX", $user, $pass);
}
function pop3_stat($connection)       
{
    $check = imap_mailboxmsginfo($connection);
    return ((array)$check);
} 
*/
function check_club_mail($club)
{
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
/*
	$data = explode(" ", $club['name']);
	$mailbox = strtolower($data[0])."@roundtable.dk";
	$password = trim($club['webmail_password']); // "RT-".substr($data[0], 2)."password";
	// $club['webmail_password']; //	
	$conn = pop3_login("mail.roundtable.dk", "143", $mailbox, $password);
	if ($conn)
	{
		$stat = pop3_stat($conn);
		$stat['mailbox'] = $mailbox;
		if ($stat['Unread']>0) echo term_unwrap("unread_mail_notify",$stat);
	}
	else
	{
		die();
		die("<script>alert('Kodeordet til {$mailbox} matcher ikke vores database. Opdater venligst!');document.location.href='/?cid={$club['cid']}&edit';</script>");
		logic_save_mail(ADMIN_MAIL, "Unable to open clubmail $mailbox", "Failed checking clubmail $mailbox on rtd.dk");
	}
*/
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
				setcookie("RTD_LOGIN_COOKIE", serialize($cookie), time()+3600*24*30, "/");
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
		/* disabled 10-06-2013
		if (!logic_is_member() && isset($_COOKIE['RTD_LOGIN_COOKIE']))
		{
			auto_login();
		}
		*/
		$error_str = "";
		if (isset($_REQUEST['sendpassword']))
		{
			$error_str .= send_password();
		}
		if (isset($_REQUEST['logout']))
		{
			unset($_SESSION['user']);
			setcookie('RTD_LOGIN_COOKIE','');
		}
		else if (isset($_REQUEST['login']))
		{
			manual_login();
		}
		
		if (isset($_SESSION['user']))
		{
			$data_array = logic_new_updates($_SESSION['user']['last_page_view']);
			$data_array['timestamp'] = $_SESSION['user']['last_page_view'];  
			$data = addslashes(json_encode($data_array));
			if ($_SESSION['user']['username']=='kaae')
			{
        //echo "<script>notify_build();</script>";
			  //echo "<script src=/scripts/rtd/notification.js.php></script>";
			}
			
			/*
			echo ;
				logic_update_last_page_view();
			}
			else echo "<script>var notification_update_json = '';</script>";		
		*//* 20-06-2013
			if (logic_get_current_username()=="kaae")
			{
				return "<script>var notification_update_json = '$data';</script>".term_unwrap('login_content_test', $_SESSION['user']);
			}
			else*/
			{
				return "<script>var notification_update_json = '$data';</script>".term_unwrap('login_content', $_SESSION['user']);
			}
		}
		else
		{
			return term_unwrap('login_prompt',$_SERVER);/*
		return "
			".term('login_pretext')."
			<form action=/ method=post>
			<script>if ('{$error_str}'!='') alert('{$error_str}');</script>
			<input type=hidden name=login value=now>
			<input type=hidden name=redirect value=\"{$_SERVER['REQUEST_URI']}\">
			<input class=bar type=\"text\" name=\"username\" value=\"".term('login_username')."\" onfocus=\"this.value='';\"><br/>
			<input class=bar type=\"password\" name=\"password\" value=\"".term('login_password')."\" onfocus=\"this.value='';\"><br/>
			<input type=\"submit\" value=\"".term('login_login')."\">
			<a href=# onclick=\"var m=prompt('Indtast dit brugernavn for at f&aring; tilsendt kodeord til rtd.dk:'); if (m) document.location.href='?sendpassword='+m;\">Glemt kodeord</a><br/>
			<input type=checkbox name=remember> Husk mig
			</form>
		";*/
		}
	}
	
?>
