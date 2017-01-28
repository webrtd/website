<?
	require_once '../includes/mysqlconnect.php';
	
	$rs = $g_db->execute("
select * from user U
inner join club C on C.cid=U.cid
inner join role R on R.uid=U.uid
inner join role_definition RD on RD.rid=R.rid
inner join district D on C.district_did=D.did
where U.username='kaae'
	");

	echo "<pre>";
	while ($row = $g_db->fetchassoc($rs))
	{
		echo (print_r($row,true));
	}

?>