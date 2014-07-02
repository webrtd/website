<?
	if ($_SERVER['REQUEST_URI'] == $_SERVER['PHP_SELF']) header("location: /");
		
	content_plugin_register('admin_download', 'content_admin_download', 'Download');

	function stalker()
	{
		$sql ="
SELECT 
U.last_page_view as TIME,
CONCAT('<a href=/?uid=',U.uid,'>',U.profile_firstname, ' ', U.profile_lastname,'</a>') as NAME,
CONCAT('<a href=', U.last_page_url,'>',U.last_page_title,'</a>') as PAGE, 
CONCAT('<a href=?cid=',U.cid,'>',(SELECT C.name FROM club C where C.cid=U.cid LIMIT 1),'</a>') as KLUB
FROM user U WHERE U.last_page_view>DATE_SUB(NOW(), INTERVAL 1 DAY) ORDER BY U.last_page_view DESC
					";		
		
		if (isset($_REQUEST['frame']))
		{
			die('<meta http-equiv="refresh" content="5">'.get_html_table($sql,true));
		}
		else
		{
			return "<iframe frameborder=0 src=?admin_download=stalker&frame=true width=100% height=1000px></iframe>";
		}
	}
	
	function newsletter()
	{
		set_title('Newsletter');
		if (isset($_REQUEST['newsletter']) && $_REQUEST['newsletter']=='send')
		{
			$title = $_REQUEST['title'];
			$content = $_REQUEST['content'];
			  $attachment_id = 0;
			  $uid = $_REQUEST['sender_uid'];
			  if (!is_numeric($uid)) $uid=$_SESSION['user']['uid'];
			  if (isset($_FILES['file']))
			  {
				$attachment_id = logic_upload_mail_attachment($_FILES['file']);
			  }
			  if (isset($_REQUEST['testmail']))
			  {
				logic_save_mail($_SESSION['user']['private_email'], "TEST: ".$title, $content,$attachment_id,$uid);
			  }
			  else
			  {
					$roles = $_REQUEST['roles'];
					$districts = $_REQUEST['districts'];
					$count = logic_send_newsletter($roles,$districts,$title,$content,$attachment_id,$uid);
					return term_unwrap('admin_newsletter_sent', array("count"=>$count));
			}
		}
		$data = array("title" => isset($_REQUEST['title'])?$_REQUEST['title']:"",
		              "content" => isset($_REQUEST['content'])?$_REQUEST['content']:term_unwrap('newsletter_default_content',$_SESSION['user']),
		              "role" => $_SESSION['user']['national_board_member'],
                  "uid" => $_SESSION['user']['uid'],
		              "district" => logic_get_district_name(logic_get_district_for_user($_SESSION['user']['uid'])));
		              
		return term_unwrap('admin_newsletter_form', $data);
	}

	function backup_tables($tables = '*')
	{
 		header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=rtd_backup.sql');
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');

	  $host = DATABASE_HOST;
	  $user = DATABASE_USER;
	  $pass = DATABASE_PASSWORD;
	  $name = DATABASE_NAME;
	  $link = mysql_connect($host,$user,$pass);
	  mysql_select_db($name,$link);
	  
	  //get all of the tables
	  if($tables == '*')
	  {
	    $tables = array();
	    $result = mysql_query('SHOW TABLES');
	    while($row = mysql_fetch_row($result))
	    {
	      $tables[] = $row[0];
	    }
	  }
	  else
	  {
	    $tables = is_array($tables) ? $tables : explode(',',$tables);
	  }
	  
	  //cycle through
	  foreach($tables as $table)
	  {
	    $result = mysql_query('SELECT * FROM '.$table);
	    $num_fields = mysql_num_fields($result);
	    
	    echo 'DROP TABLE '.$table.';';
	    $row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
	    echo  "\n\n".$row2[1].";\n\n";
	    
	    for ($i = 0; $i < $num_fields; $i++) 
	    {
	      while($row = mysql_fetch_row($result))
	      {
	        echo 'INSERT INTO '.$table.' VALUES(';
	        for($j=0; $j<$num_fields; $j++) 
	        {
	          $row[$j] = addslashes($row[$j]);
	          $row[$j] = str_replace("\n","\\n",$row[$j]);
	          if (isset($row[$j])) { echo  '"'.$row[$j].'"' ; } else { echo '""'; }
	          if ($j<($num_fields-1)) { echo ','; }
	        }
	        echo ");\n";
	      }
	    }
	    echo "\n\n\n";
	  }
	  die();
  }

	function output_file($fn)
	{
		$fh = fopen($fn, "rb");
		while (!feof($fh))
		{
			echo fread($fh, 8192);
		}
		fclose($fh);
	}

	function sqlcsv($sql)
	{
		$db = get_db();
		$rs = $db->execute($sql);
		
		$fn = tempnam(sys_get_temp_dir(), "csv-").'.csv';
		$fh = fopen($fn, "wt");
		
		$headers_written = false;
		while ($row = $db->fetchassoc($rs))
		{
			foreach ($row as $key => $value) 
			{
				$value = str_replace("\n", "", $value);
				$value = str_replace("\r", "", $value);
				$row[$key] = $value;
			}
			if (!$headers_written)
			{
				fputcsv($fh, array_keys($row),';');
				$headers_written = true;
			}
			fputcsv($fh, $row,';');
		}
		fclose($fh);
		return $fn;
	}
	
	function clubmail()
	{
		if (!isset($_FILES['clubmail']))
		{
			return term('update_clubmail');
		}
		else
		{
			$html = "<h1>Updating</h1><ul>";
			$p = xml_parser_create();
			xml_parser_set_option($p, XML_OPTION_CASE_FOLDING, 0);
			xml_parser_set_option($p, XML_OPTION_SKIP_WHITE, 1);
			xml_parse_into_struct($p, file_get_contents($_FILES['clubmail']['tmp_name']), $vals, $index);
			xml_parser_free($p);
			
			$email = false;
			$password = false;
			while (current($vals)!==false)
			{
				$c = current($vals);
				if ($c['tag']=='account')
				{
					if (isset($c['attributes']['email']))
					{
						$email = $c['attributes']['email'];
					}
				}
				if ($c['tag']=='password')
				{
					$password = $c['value'];
					$html .= "<li>$email ";
					$db = get_db();
					$db->execute("update club set webmail_password='{$password}' where name like '%{$email} -%'");
					$email=$password=false;
				}
				next($vals);
			}
			$html .= "</ul>";
			return $html;
		}
	}
	
	function newboards()
	{
		$d = logic_get_country("",0);
		$data = $d['districts'];
		for ($i=0;$i<sizeof($data);$i++)
		{
			$data[$i]['clubs'] = logic_get_clubs($data[$i]['did']);
			for ($j=0;$j<sizeof($data[$i]['clubs']);$j++)
			{
				$data[$i]['clubs'][$j]['board'] = logic_get_club_board_period($data[$i]['clubs'][$j]['cid'],1);
			}
		}
		return term_unwrap('admin_new_boards', $data, true);
		//return "<pre>".print_r($data,true)."</pre>";
	}
	
	function sysstat()
	{
		if (isset($_REQUEST['clear_mail_queue']))
		{
			fire_sql("update mass_mail set processed=1");
		}
		$data = array(
			"time" => strftime("%c"), 
			"mailqueue" => get_html_table("select mail_subject as SUBJECT, concat('<a href=\'/?search=',mail_receiver,'\'>',mail_receiver,'</a>') as RECEIVER, submit_time TIME, filename FILE from mass_mail MAIL left join mass_mail_attachment ATT on ATT.aid=MAIL.aid where processed=0 order by id asc limit 100",true),
			"mailsent" => get_html_table("select mail_subject as SUBJECT, concat('<a href=\'/?search=',mail_receiver,'\'>',mail_receiver,'</a>') as RECEIVER, submit_time TIME, filename FILE from mass_mail MAIL left join mass_mail_attachment ATT on ATT.aid=MAIL.aid where processed=1 order by id desc limit 100",true),
			"mailqueuesize" => get_html_table("select count(*) as QUEUE from mass_mail where processed=0"),
			"popularpages" => get_html_table("select previous as URL,counter as CLICK from tracker order by counter desc limit 20"),
			"popularsearch" => get_html_table("select q as QUERY,count as CLICK from search order by count desc limit 25"),
			"syslog" => get_html_table("select remote_addr as IP, logtext as ERROR, ts as TIME from log order by ts desc limit 25"),
			"log" => get_html_table("select * from cronjob order by ts desc limit 5")/*,
			"popularpeople" => get_html_table(
			"select 
distinct uvt.uid as UID,
(select count(*) from user_view_tracker temp where temp.uid=uvt.uid and temp.ts>date_sub(now(),interval 1 month)) as CLICK 
from user_view_tracker uvt 
order by CLICK 
limit 10")*/

			
		);
		return term_unwrap("admin_sysstat", $data);
	}
	
	function yearstats()
	{
		$html = "";
		for ($i=-1; $i!=1; $i++)
		{
			$ys = logic_get_club_year_start($i);
			$ye = logic_get_club_year_end($i);
			$members = fetch_member_count(" and profile_started<='{$ye}' and profile_ended>'{$ye}'", "" );
			$exits = fetch_member_count(" and profile_ended>='{$ys}' and profile_ended<'{$ye}'");
			$html .= "<h1>{$ys}-{$ye}</h1><li>Total: {$members}<li>Expected exit: {$exits}";
		}
		die($html);
	}

	function content_admin_download()
	{
		$f = $_REQUEST['admin_download'];
		if (!logic_is_national_board_member()) return term('article_must_be_logged_in');

		if ($f == 'stalker')
		{
			return stalker();
		}
		
		if ($f == 'yearstats')
		{
			return yearstats();
		}
		
		if ($f == 'sysstat')
		{
			return sysstat();
		}
		
		if ($f=='newboards')
		{
			return newboards();
		}
		
		if ($f=='newsletter')
		{
			return newsletter();
		}

		if ($f == 'backup_db')
		{
			backup_tables();
		}	
		
		if ($f == "clubmail")
		{
			return clubmail();
		}

		if ($f == 'clubs')
		{
			$sql = "select C.cid as CID, C.name as CLUB, C.charter_date as CHARTERDATE, CC.name as CHARTERCLUB, CC.cid as CHARTERCLUB_CID, D.NAME as DISTRICT from club C inner join district D on C.district_did=D.did inner join club CC on CC.cid=C.charter_club_cid";
			$data = get_data($sql);
			foreach($data as $row)
			{
				echo utf8_decode("CID_{$row['CID']} [shape=box,label=\"{$row['CLUB']},\\nChartret: {$row['CHARTERDATE']} af {$row['CHARTERCLUB']}\"];\n");
				echo "CID_{$row['CHARTERCLUB_CID']} -- CID_{$row['CID']};\n";
				//echo utf8_decode("\"{$row['CHARTERCLUB']}\" -> \"{$row['CLUB']}\"<br>");
			}
		/*
				$xml = (get_xml("select C.cid as CID, C.name as CLUB, C.charter_date as CHARTERDATE, CC.name as CHARTERCLUB, D.NAME as DISTRICT from club C inner join district D on C.district_did=D.did inner join club CC on CC.cid=C.charter_club_cid"));
				header('Content-Description: File Transfer');
				header('Content-Type: application/octet-stream');
				header('Content-Disposition: attachment; filename='.$f.date('-Ymd').'.xml');
				header('Content-Transfer-Encoding: binary');
				header('Expires: 0');
				header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
				header('Pragma: public');
				die($xml);
				*/
				die();
		}
		
		if ($f == 'xtable')
		{
			$y = date("Y");
			$sql = 
				"select 
				U.uid as UID,U.profile_firstname as Fornavn,U.profile_lastname as Efternavn,U.profile_birthdate as Foedselsdato, U.profile_started as CharterDato,U.profile_ended as Udmeldelsesdato, U.last_page_view as SidsteLogin, U.private_address as Vej, U.private_houseno as HusNr, U.private_houseletter as Bogstav, U.private_housefloor Etage, U.private_houseplacement Side, U.private_zipno as PostNr, U.private_city as Bynavn, U.private_mobile as MobilTlf, U.private_email as Email,  U.xtable_transfer as XTable_Transfer,
				C.name as Klub, 
				D.name as Distrikt
				from user U
				inner join club C on U.cid=C.cid
				inner join district D on C.district_did=D.did
				where U.xtable_transfer=1 and U.profile_ended>='{$y}-06-30' and U.profile_ended<='{$y}-07-01' 
				order by U.profile_firstname";
				$xml = (get_xml($sql));

				header('Content-Description: File Transfer');
				header('Content-Type: application/octet-stream');
				header('Content-Disposition: attachment; filename='.$f.date('-Ymd').'.xml');
				header('Content-Transfer-Encoding: binary');
				header('Expires: 0');
				header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
				header('Pragma: public');
//				header('Content-Length: ' . size($xml));		
				die($xml);				
		}
		else if ($f == 'all')
		{
			$sql = 
				"select 
				U.uid as UID,U.profile_firstname as Fornavn,U.profile_lastname as Efternavn,U.profile_birthdate as Foedselsdato, U.profile_started as CharterDato,U.profile_ended as Udmeldelsesdato, U.last_page_view as SidsteLogin, U.private_address as Vej, U.private_houseno as HusNr, U.private_houseletter as Bogstav, U.private_housefloor Etage, U.private_houseplacement Side, U.private_zipno as PostNr, U.private_city as Bynavn, U.private_mobile as MobilTlf, U.private_email as Email, 
				C.name as Klub, 
				D.name as Distrikt,
				RD.shortname as Rolle
				from user U
				inner join club C on U.cid=C.cid
				inner join district D on C.district_did=D.did
				inner join role R on R.uid=U.uid
				inner join role_definition RD on RD.rid=R.rid
				order by U.profile_firstname";
				$xml = (get_xml($sql));
				header('Content-Description: File Transfer');
				header('Content-Type: application/octet-stream');
				header('Content-Disposition: attachment; filename='.$f.date('-Ymd').'.xml');
				header('Content-Transfer-Encoding: binary');
				header('Expires: 0');
				header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
				header('Pragma: public');
//				header('Content-Length: ' . size($xml));		
				die($xml);				
		}

		if ($f == 'future')
		{
			$sql = "
				select 
				U.uid as UID,U.profile_firstname as Fornavn,U.profile_lastname as Efternavn,U.profile_birthdate as Foedselsdato, U.profile_started as CharterDato,U.profile_ended as Udmeldelsesdato, U.last_page_view as SidsteLogin,  U.private_mobile as MobilTlf, U.private_email as Email, 
				C.name as Klub, 
				D.name as Distrikt,
				RD.shortname as Rolle
				from user U
				inner join club C on U.cid=C.cid
				inner join district D on C.district_did=D.did
				inner join role R on R.uid=U.uid
				inner join role_definition RD on RD.rid=R.rid
				where R.end_date>now() and R.start_date>now()
				order by U.profile_firstname
							";
				$fn = sqlcsv($sql);
				header('Content-Description: File Transfer');
				header('Content-Type: application/octet-stream');
				header('Content-Disposition: attachment; filename='.$f.date('-Ymd').'.csv');
				header('Content-Transfer-Encoding: binary');
				header('Expires: 0');
				header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
				header('Pragma: public');
				header('Content-Length: ' . filesize($fn));		
				output_file($fn);
				unlink($fn);
				die();
		}
		if ($f == 'active')
		{
			$sql = "
				select 
				U.uid as UID,U.profile_firstname as Fornavn,U.profile_lastname as Efternavn,U.profile_birthdate as Foedselsdato, U.profile_started as CharterDato,U.profile_ended as Udmeldelsesdato, U.last_page_view as SidsteLogin, U.private_address as Vej, U.private_houseno as HusNr, U.private_houseletter as Bogstav, U.private_housefloor Etage, U.private_houseplacement Side, U.private_zipno as PostNr, U.private_city as Bynavn, U.private_mobile as MobilTlf, U.private_email as Email, 
				C.name as Klub, 
				D.name as Distrikt,
				RD.shortname as Rolle
				from user U
				inner join club C on U.cid=C.cid
				inner join district D on C.district_did=D.did
				inner join role R on R.uid=U.uid
				inner join role_definition RD on RD.rid=R.rid
				where R.end_date>now() and R.start_date<now()
				order by U.profile_firstname
							";
		
		
			if (isset($_REQUEST['xml']))
			{
				$xml = (get_xml($sql));
				header('Content-Description: File Transfer');
				header('Content-Type: application/octet-stream');
				header('Content-Disposition: attachment; filename='.$f.date('-Ymd').'.xml');
				header('Content-Transfer-Encoding: binary');
				header('Expires: 0');
				header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
				header('Pragma: public');
//				header('Content-Length: ' . size($xml));		
				die($xml);
			}
			else if (isset($_REQUEST['table']))
			{
				die(utf8_decode(get_html_table($sql)));
			}
			else
			{
			$fn = sqlcsv($sql);
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename='.$f.date('-Ymd').'.csv');
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Pragma: public');
			header('Content-Length: ' . filesize($fn));		
			output_file($fn);
			unlink($fn);
			die();
			}
		}
		
	}
?>