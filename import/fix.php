<?
	require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/config_terms.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/logic.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/sessionhandler.php';

  /// fix meeting attendance for future meetings
  function fix_meeting_attendance()
  {
    global $g_db;
    $count_clubs = 0;
    $count_meetings = 0;
    $count_attendance = 0;
     
    $rs = $g_db->execute("select cid,name from club order by cid asc");
    while ($row = $g_db->fetchassoc($rs)) 
    {
      $count_clubs++;
      $cid = $row['cid'];
      $club = $row['name'];
      echo "<h1>$club</h1>";
      
      $meetings = logic_fetch_future_meetings_for_club($cid, "asc", 1000, false);
      $members = fetch_active_club_members($cid); 
      foreach ($meetings as $meeting)
      {
        $count_meetings++;
        echo "<h2>{$meeting['title']}</h2>";
        foreach($members as $member)
        {
          $count_attendance++;
          echo "<li>{$member['profile_firstname']} {$member['profile_lastname']}</li>";
          if ($cid!=167 && $cid!=206)
          {
            save_meeting_attendance($meeting['mid'], $member['uid']);
          }
          
        }
      }
    }
    echo "<font color=red size=20><li>Klubber: {$count_clubs}<li>Møder: {$count_meetings}<li>Rækker: {$count_attendance}</font>";
    echo "<script>alert('DONE');</script>";
  }
	
	function fix_members()
	{
		global $g_db;
		$sql = 
		"SELECT u.profile_firstname,u.profile_lastname,u.uid,u.profile_ended,u.profile_birthdate,u.profile_started FROM `user` u 
where 
u.profile_birthdate>'1972-06-30' 
and u.profile_ended='2012-06-30'
and u.profile_birthdate<'1972-12-31'";
		$rs = $g_db->execute($sql);
		while ($row = $g_db->fetchassoc($rs))
		{
			echo "<li>{$row['uid']}";
			logic_update_member_expiration($row['uid'],$row['profile_birthdate'],$row['profile_started']);
		}
		
	}
	
	
 ?>