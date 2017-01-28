<?
	/*
		content plugin report - used to generate reports from the system (c) 3kings.dk
		
		13-06-2013	rasmus@3kings.dk	draft
	*/

	if ($_SERVER['REQUEST_URI'] == $_SERVER['PHP_SELF']) header("location: /");
		
	content_plugin_register('reports', 'content_handle_reports', 'Rapporter');

	function do_members_pure_data()
	{
		$data = "";
			$ddata = logic_get_clubs();
			foreach($ddata as $k=>$club)
			{
				$data .= "<h2>{$club['name']}</h2>\n";
				$sql = "select U.uid as UID, U.profile_firstname as Fornavn, U.profile_lastname as Efternavn, U.profile_started as Charterdato, U.profile_birthdate as Foedselsdato, U.private_address as Vej, U.private_houseno as HusNr, U.private_houseletter as Bogstav, U.private_housefloor Etage, U.private_houseplacement as Side, U.private_zipno PostNr, U.private_city as Bynavn, U.private_mobile as Mobil, U.private_email as Email, U.company_name as Firma, U.company_position as Titel from user U where cid={$club['cid']} order by U.profile_firstname ASC";

			
				
				$db = get_db();
				$rs = $db->execute($sql);
				
				
				$data .= "<table width=100% border=1>";
				
				$first = true;
				$count = 0;
				while ($row = $db->fetchassoc($rs))
				{
					if ($first)
					{
						$data .= "<tr>";
						foreach($row as $k=>$v)
						{
							$data .= "<th>$k</th>";
						}
						
						$data .= "<th>Roller</th>";
						$data .= "</tr>\n";
					}
					
					$data_row = "<tr>";
					foreach($row as $k=>$v)
					{
						$data_row .= "<td>$v</td>";
					}
					
					$r = logic_get_roles($row['UID'],true);
					$roles = array();
					$hide = true;
					foreach($r as $k=>$v)
					{
						if ($v['rid']==MEMBER_ROLE_RID) $hide=false;
						if ($v['rid']==HONORARY_ROLE_RID) $hide=false;
						if ($v['rid']!=MEMBER_ROLE_RID && $v['rid']!=ADMIN_ROLE_RID)
						{
							$roles[] = $v['description'];
						}
					}
					$data_row .= "<td>".implode(",",$roles)."</td>";
					$data_row .= "</tr>\n";
					if (!$hide) {
						$data .= $data_row;
						$count++;
					}
					
					$first=false;
				}
				$data .= "</table>";
				$data .= "<p>Antal medlemmer $count</p>";

			}
			echo $data;
			$data = "";
		
		die();
	}
	
	
	function do_members_data()
	{
		$data = "";
		$c = logic_get_country("",0);
		foreach($c['districts'] as $k=>$d)
		{
			
			$data .= "<h1>{$d['name']}</h1>";

			$ddata = logic_get_clubs($d['did']);
			foreach($ddata as $k=>$club)
			{
				$data .= "<h2>{$club['name']}</h2>\n";
				$sql = "select U.uid as UID, U.profile_firstname as Fornavn, U.profile_lastname as Efternavn, U.profile_started as Charterdato, U.profile_birthdate as Foedselsdato, U.private_address as Vej, U.private_houseno as HusNr, U.private_houseletter as Bogstav, U.private_housefloor Etage, U.private_houseplacement as Side, U.private_zipno PostNr, U.private_city as Bynavn, U.private_mobile as Mobil, U.private_email as Email, U.company_name as Firma, U.company_position as Titel from user U where cid={$club['cid']} order by U.profile_firstname ASC";

			
				
				$db = get_db();
				$rs = $db->execute($sql);
				
				
				$data .= "<table width=100% border=1>";
				
				$first = true;
				$count = 0;
				while ($row = $db->fetchassoc($rs))
				{
					if ($first)
					{
						$data .= "<tr>";
						foreach($row as $k=>$v)
						{
							$data .= "<th>$k</th>";
						}
						
						$data .= "<th>Roller</th>";
						$data .= "</tr>\n";
					}
					
					$data_row = "<tr>";
					foreach($row as $k=>$v)
					{
						$data_row .= "<td>$v</td>";
					}
					
					$r = logic_get_roles($row['UID'],true);
					$roles = array();
					$hide = true;
					foreach($r as $k=>$v)
					{
						if ($v['rid']==MEMBER_ROLE_RID) $hide=false;
						if ($v['rid']==HONORARY_ROLE_RID) $hide=false;
						if ($v['rid']!=MEMBER_ROLE_RID && $v['rid']!=ADMIN_ROLE_RID)
						{
							$roles[] = $v['description'];
						}
					}
					$data_row .= "<td>".implode(",",$roles)."</td>";
					$data_row .= "</tr>\n";
					if (!$hide) {
						$data .= $data_row;
						$count++;
					}
					
					$first=false;
				}
				$data .= "</table>";
				$data .= "<p>Antal medlemmer $count</p>";

			}
			echo $data;
			$data = "";
		}
		die();
	}
	
	function do_club_data()
	{
		$data = "";
		$c = logic_get_country("",0);
		foreach($c['districts'] as $k=>$d)
		{
			
			$data .= "<h1>{$d['name']}</h1>";
			
			$data .= get_html_table("select SUBSTRING_INDEX(SUBSTRING_INDEX(C.name, ' ',  3), ' ', -1) as ByNavn, C.name as Klub, C.meeting_place as Moedested, C.meeting_time as Moedetid, C.charter_date as Charterdato, CC.name as Charterklub, C.webpage as WWW from club C inner join club CC on CC.cid=C.charter_club_cid where C.district_did={$d['did']} order by ByNavn ASC");
		}
		die($data);
	}	

	function do_member_stats()
	{
				$data = "";
				$c = logic_get_country("",0);
				foreach($c['districts'] as $k=>$d)
				{
					
					echo "<h1>{$d['name']}</h1>";
					echo "<table border=1 width=100%>";
				
					$ddata = logic_get_clubs($d['did']);					
					
					$first = true;
					foreach($ddata as $k=>$club)
					{
						//$data .= "<h2>{$club['name']}</h2>";
						$stats = logic_get_club_stats($club['cid']);

						$keys = array_keys($stats);
						if ($first)


						{
							$first = false;
							echo "<tr>
								<th width=50%>Klub</th>
								<th>{$keys[0]}</th>
								<th>{$keys[1]}</th>
								<th>{$keys[2]}</th>



							</tr>";
						}
						
						
						
						
						$a = current($stats);
						$b = next($stats);
						$c = next($stats);
						
						
						$bb = $b['new']-$b['exit'];
						$cc = $c['new']-$c['exit'];
						
						
						
						echo "<tr>
							<td>{$club['name']}</td>
							<td>{$a['end']}</td>
							<td>{$bb}</td>
							<td>{$cc}</td>
						</tr>";
						
						// $data .= "<table width=100% border=1><tr><th>Klubår</th><th>Start</th><th>Slut</th><th>Tilgang</th><th>Afgang</th><th>Exit</th></tr>";
						//foreach($stats as $range => $range_data)
						//{
							
							//$diff = $range_data['new'] - $range_data['exit'];
							//$data .= "<tr>";
							//$data .= "<td>{$range}</td><td>{$range_data['start']}</td><td>{$range_data['end']}</td><td>{$range_data['new']}</td><td>{$range_data['exit']}</td><td>$diff</td>";
							//$data .= "</tr>";
						//}
						

//						$data .= "<pre>".print_r($stats, true)."</pre>";
					}
					
					echo "</table>";
					
//					die($data);
				}
				
				
				die();

	}
	
	function do_rti_report()
	{
		$national_board = logic_get_national_board();
		
		echo "<h1>National Board</h1>";
		echo "<table width=100% border=1>";
		echo "<tr>
			<th>Role</th>
			<th>Firstname</th>
			<th>Surname</th>
			<th>Address</th>
			<th>City</th>
			<th>Country</th>
			<th>Phone</th>
			<th>Mail</th>
		</tr>";
		foreach($national_board as $m)
		{
			$u = logic_get_user_by_id($m['uid']);
			$area = $m['role_short']==DISTRICT_CHAIRMAN_SHORT?" - {$m['district']}":"";
			echo "<tr>
			<td>{$m['role']} $area</td>
			<td>{$u['profile_firstname']}</td>
			<td>{$u['profile_lastname']}</td>
			<td>{$u['private_address']} {$u['private_houseno']} {$u['private_houseletter']} {$u['private_housefloor']} {$u['private_houseplacement']}</td>
			<td>{$u['private_zipno']} {$u['private_city']}</td>
			<td>{$u['private_country']}</td>
			<td>{$u['private_mobile']}</td>
			<td>{$u['private_email']}</td>
			</tr>";
		}
		
		
		echo "</table>";
		
		echo "<h1>Clubs</h1>";
		echo "<table width=100% border=1>";
		
		$chairmen = logic_get_all_club_chairmen(true);
		$html = "<tr>
      <th>Club No</th>
			<th>Club</th>
      <th>Club City</th>
			<th>LASTNAME</th>
			<th>Firstname</th>
			<th>Address</th>
			<th>Postal</th>
			<th>City</th>
			<th>Country</th>
			<th>Phone</th>
			<th>Mail</th>
			<th>Birthdate</th>
			<th>Business</th>
		</tr>";
		
    $clubs = array();
    
		foreach($chairmen as $m)
		{
			$u = logic_get_user_by_id($m['uid']);
			$c = logic_get_club($u['cid']);
      $clubno = substr($c['name'], 2);
      $clubno = substr($clubno, 0, strpos($clubno, ' '));
      $clubcity = substr($c['name'], strpos($c['name'], ' ')+3);
      $phone = strpos($u['private_mobile'],'+')===false?"+45 {$u['private_mobile']}":$u['private_mobile'];
			$clubs[$clubno] = "<tr>
        <td>{$clubno}</td>
				<td>{$c['name']}</td>
        <td>{$clubcity}</td>
				<td>{$u['profile_lastname']}</td>
				<td>{$u['profile_firstname']}</td>
				<td>{$u['private_address']} {$u['private_houseno']} {$u['private_houseletter']} {$u['private_housefloor']} {$u['private_houseplacement']}</td>
        <td>{$u['private_zipno']}</td>
				<td>{$u['private_city']}</td>
				<td>{$u['private_country']}</td>
				<td>{$phone}</td>
				<td>rt{$clubno}@rtd.dk</td>
				<td>{$u['profile_birthdate']}</td>
				<td>{$u['company_business']}</td>
			</tr>";
		}
    
    ksort($clubs);
    
    foreach($clubs as $k=>$v) $html .= $v; 
		
		
		$html .= "</table>";
		
		
    $html = str_replace('æ', 'Æ', $html);
    $html = str_replace('ø', 'Ø', $html);
    $html = str_replace('å', 'Å', $html);
		die(mb_strtoupper($html));
		
		
	}
	
	function do_jubilees()
	{
		$jdata = logic_get_member_jubilees();
		echo term('report_member_jubilee_header');
		
		foreach ($jdata as $year => $members)
		{
			if (!empty($members))
			{
				echo term_unwrap('report_member_jubilee_year', array('year'=>$year));
				foreach ($members as $member)
				{
					echo term_unwrap('report_member_jubilee_member', $member);
				}
			}
		}

		
		$cdata = logic_get_club_jubilees();
		echo term('report_club_jubilee_header');
		foreach($cdata as $year => $clubs)
		{
			if (!empty($clubs))
			{
				echo term_unwrap('report_club_jubilee_year', array('year'=>$year));
				foreach ($clubs as $club)
				{
					echo term_unwrap('report_club_jubilee_club', $club);
				}
			}
		}
		
		die();
	}
	
	function do_member_adresses()
	{
			$sql = "
				select 
				U.profile_firstname as Fornavn,U.profile_lastname as Efternavn, U.private_address as Vej, U.private_houseno as HusNr, U.private_houseletter as Bogstav, U.private_housefloor Etage, U.private_houseplacement Side, U.private_zipno as PostNr, U.private_city as Bynavn
				from user U
				inner join role R on R.uid=U.uid
				where R.end_date>now() and R.start_date<now() 
				and (R.rid=".MEMBER_ROLE_RID." or R.rid=".HONORARY_RID.")
				order by U.profile_firstname
							";
		
		
				$xml = (get_xml($sql));
				header('Content-Description: File Transfer');
				header('Content-Type: application/octet-stream');
				header('Content-Disposition: attachment; filename=members'.date('-Ymd').'.xml');
				header('Content-Transfer-Encoding: binary');
				header('Expires: 0');
				header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
				header('Pragma: public');
				die($xml);
	
	}
	
	
	function do_networker()
	{
		$sql = "select C.name as club, D.name as district, M.minutes_number_of_participants, M.minutes_number_of_rejections, M.title, M.minutes_date, M.end_time from meeting M 
		inner join club C on M.cid=C.cid
		inner join district D on D.did=C.district_did
		where  M.start_time>'".logic_get_club_year_start()."' and M.end_time<now()
		";
		// M.minutes_date is not null and
		die(get_html_table($sql));
	}
	
	function do_wall_of_fame()
	{
		$html = "";
		
		
		$archive = date("Y")-1942;
		
		for ($i=0; $i<$archive; $i++)
		{
			$start = logic_get_club_year_start(-$i);
			$end = str_replace("-07-01", "-12-31", $start);
			$sql = "SELECT CONCAT_WS(' ',user.profile_firstname,user.profile_lastname) as Navn, role_definition.description as Rolle, club.name as Klub, district.name as Distrikt FROM user inner join club on user.cid=club.cid inner join district on district.did=club.district_did inner join role on role.uid=user.uid inner join role_definition on role_definition.rid=role.rid WHERE role_definition.shortname IN ('NIRO','VLF','LF','LS','LK','WEB','SHOP','DF','ALF','LA','RED') AND role.start_date<'{$end}' AND role.end_date>'{$start}' order by role_definition.weight desc, district.name";
			$html .= "<h1>Hovedbestyrelse ".substr($start,0,4)."-".(substr($start,0,4)+1)."</h1>";
			$html .= get_html_table($sql);
		
		}
		return $html;
	}
	
	
	function content_handle_reports()
	{
		if (isset($_REQUEST['f']) && $_REQUEST['f']=='walloffame')
		{
			return do_wall_of_fame();
		}
		
	
		if (!logic_is_member()) return term('article_must_be_logged_in');

		if (isset($_REQUEST['f']))
		{
			$f = $_REQUEST['f'];


			if ($f=='networker')
			{
				do_networker();
			}
			if ($f=='post')
			{
				do_member_adresses();
			}

			echo '<meta http-equiv="content-type" content="text/html; charset=utf-8">';
			
			if ($f=='memberstat')
			{
				do_member_stats();			
			}
			if ($f == 'clubs')
			{
				do_club_data();
			}
			if ($f == 'members')
			{
				do_members_pure_data();
			}
			if ($f == 'members_district')
			{
				do_members_data();
			}
			if ($f == 'rti')
			{
				do_rti_report();
			}
			if ($f == 'jubilees')
			{
				do_jubilees();
			}
			
		}
		else return term('reports');		
	}

?>