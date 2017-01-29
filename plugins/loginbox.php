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

	function auto_login()
	{ 
		$sn = $_SERVER['SERVER_NAME'];
		$cookie = unserialize($_COOKIE[$sn.'_LOGIN_COOKIE']);
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
	   
        update_option('issession','no');             
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
             
			logic_wordpress_synch_user_roles();
							
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
				$html .= "<script>document.location.href='{$_SERVER['HTTP_REFERER']}';</script>";
			}
			else
			{		
				$html .= "<script>document.location.href='{$_REQUEST['redirect']}';</script>";
			}
			
			if (logic_is_secretary() || logic_is_chairman()) check_club_mail(logic_get_club($_SESSION['user']['cid']));
			
			die($html);
			
		}
		else 
		{			
		$error_str = term('login_incorrect'); 
		}
	}
	
	function loginbox()
	{                
		if (!logic_is_member() && isset($_COOKIE['RTD_LOGIN_COOKIE']))
		{			
			auto_login();
		}
		$error_str = "";
		if (isset($_REQUEST['sendpassword']))
		{
			$error_str .= send_password();
		}
		if (isset($_REQUEST['logout']))
		{
			wp_logout();
			session_destroy(); //destroy the session
			setcookie('RTD_LOGIN_COOKIE','');
			header("location: http://".$_SERVER['HTTP_HOST']); //to redirect back to "index.php" after logging out
			exit();                            
		}
		else if (isset($_REQUEST['login']))
		{			
			manual_login();
		}         
        
		if (isset($_SESSION['user']))
		{
            update_option('issession','no');
			$data = addslashes(json_encode(logic_get_duties($_SESSION['user']['uid'])));
      
      $s = logic_get_club_year_start(); 
      $e = logic_get_club_year_end();
      $sql = "select mid, title, start_time, (select name from club where club.cid=meeting.cid) as club from meeting where start_time>'{$s}' and end_time<'{$e}' and (tags like '%Distriktsmøde%' or tags like '%Landsmøde%') order by start_time asc";
      $meetings = addslashes(json_encode(get_data($sql)));
      
 /*     $meetings = fetch_meetings("where start_time>'{$s}' and end_time<'{$e}' (tags like '%DM-arrangør%' or tags like '%LM-arrangør%')")
      $meetings = addslashes(json_encode($meetings));
*/      
			return "<script>var notification_update_json = '$data'; var not_meetings='$meetings';</script>".term_unwrap('login_content', $_SESSION['user']);
		}
		else
		{  
            update_option('issession','yes');        		
			return term_unwrap('login_prompt',$_SERVER);
		}
	}
	
?>
