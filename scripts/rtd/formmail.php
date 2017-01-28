<?
  chdir($_SERVER['DOCUMENT_ROOT']);
	require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/logic.php';
	if (isset($_REQUEST['who']) && isset($_REQUEST['body']) && isset($_REQUEST['subject']) && isset($_REQUEST['name']) && isset($_REQUEST['email']))
	{
		if ($_REQUEST['email']=='' || $_REQUEST['name']=='')
		{
			die("<script>alert('Navn og afsender mail mangler!');history.go(-1);</script>");
		}
		$allowable_mails = array("lf", "vlf", "ls", "web", "iro","df1","df2","df3", "df4", "df5", "df6", "df7", "df8");
		if (in_array($_REQUEST['who'], $allowable_mails)) 
		{
			$body = "Besked fra {$_REQUEST['name']} - {$_REQUEST['email']}\n\n{$_REQUEST['body']}";
			$subj = $_REQUEST['subject'];
			save_mail("{$_REQUEST['who']}@rtd.dk", $subj, $body);
/*		
				$mail = new PHPMailer();
				$mail->IsSMTP();
				$mail->Host     = SMTP_SERVER;
				$mail->SMTPAuth = false;
				$mail->From     = $_REQUEST['email'];
				$mail->FromName = $_REQUEST['name'];
				$mail->AddAddress("{$_REQUEST['who']}@rtd.dk", $_REQUEST['who']);  
				$mail->Subject  =  $_REQUEST['subject'];
				$mail->Body     =  ($_REQUEST['body']);
				$mail->CharSet = "UTF-8";
        $mail->ContentType = "text/html";
				if(!$mail->Send())
				{
					die("<script>alert('Beskeden er ikke sendt {$mail->ErrorInfo}');document.location.href='/';</script>");
				}
				else
				{
					die("<script>alert('Beskeden er sendt');document.location.href='/';</script>");					
				}

*/
  				die("<script>alert('Beskeden er sendt');document.location.href='/';</script>");					
	      
				
		}
	}
	header("location: /");

?>