<?
	/*
		content plugin report - used to generate reports from the system (c) 3kings.dk
		
		13-06-2013	rasmus@3kings.dk	draft
	*/

	if ($_SERVER['REQUEST_URI'] == $_SERVER['PHP_SELF']) header("location: /");
		
	content_plugin_register('reports', 'content_handle_reports', 'Rapporter');

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
							$roles[] = $v['shortname'];
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
			
			$data .= get_html_table("select C.name as Klub, C.meeting_place as Moedested, C.meeting_time as Moedetid, C.charter_date as Charterdato, CC.name as Charterklub, C.webpage as WWW from club C inner join club CC on CC.cid=C.charter_club_cid where C.district_did={$d['did']}");
		}
		die($data);
	}
	
	function do_member_stats()
	{
				$data = "";
				$c = logic_get_country("",0);
				foreach($c['districts'] as $k=>$d)
				{
					
					$data .= "<h1>{$d['name']}</h1>";
				
					$ddata = logic_get_clubs($d['did']);
					foreach($ddata as $k=>$club)
					{
						$data .= "<h2>{$club['name']}</h2>";
						$stats = logic_get_club_stats($club['cid']);
						$data .= "<table width=100% border=1><tr><th>Klubår</th><th>Start</th><th>Slut</th><th>Tilgang</th><th>Afgang</th><th>Exit</th></tr>";
						foreach($stats as $range => $range_data)
						{
							$diff = $range_data['new'] - $range_data['exit'];
							$data .= "<tr>";
							$data .= "<td>{$range}</td><td>{$range_data['start']}</td><td>{$range_data['end']}</td><td>{$range_data['new']}</td><td>{$range_data['exit']}</td><td>$diff</td>";
							$data .= "</tr>";
						}
						
						$data .= "</table>";
//						$data .= "<pre>".print_r($stats, true)."</pre>";
					}
				}
				
				
				die($data);
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
		
		$chairmen = logic_get_all_club_chairmen();
		echo "<tr>
			<th>Club</th>
			<th>Firstname</th>
			<th>Surname</th>
			<th>Address</th>
			<th>City</th>
			<th>Country</th>
			<th>Phone</th>
			<th>Mail</th>
		</tr>";
		
		foreach($chairmen as $m)
		{
			$u = logic_get_user_by_id($m['uid']);
			$c = logic_get_club($u['cid']);
			echo "<tr>
				<td>{$c['name']}</td>
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
		
		
		die();
		
		
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
	
	function content_handle_reports()
	{
		if (!logic_is_member()) return term('article_must_be_logged_in');

		if (isset($_REQUEST['f']))
		{
			$f = $_REQUEST['f'];
			
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