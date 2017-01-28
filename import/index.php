<?
/*
	import functionality
	
	26-10-2012	rasmus@3kings.dk draft
*/
	require_once '../config.php';
	require_once '../includes/mysqlconnect.php';

	if ($_REQUEST['password']==IMPORT_PASSWORD)
	{
		$g_db->m_ShouldDie=false;
		
		require_once $_REQUEST[mapping];
		
		if (file_exists($_FILES[data][tmp_name])) $fh = fopen($_FILES[data][tmp_name], "rt");
		else if (file_exists("./data/".$_REQUEST[fromdisk])) $fh = fopen("./data/".$_REQUEST[fromdisk],"rt");
		
		$csv_keys = fgetcsv($fh);
		
		$csv_keys = array_flip($csv_keys);
		
		$sql = "";
		
		$sql_fields = " (`".implode("`,`", $mapping)."`)";
		
		$g_db->query("begin");
		
		while ($row = fgetcsv($fh))
		{
			$sql_values = array();
			foreach($mapping as $map_from => $map_to)
			{
				$csv_field_index = $csv_keys[$map_from];
				if (!isset($row[$csv_field_index]))
				{
					die ("Unable to load csv field: $map_from");
				}
				$sql_values[] = addslashes($row[$csv_field_index]);
			}
			
			$sql_values = " ('".implode("','", $sql_values)."')";
			
			$sql .= "INSERT IGNORE INTO $destination_table $sql_fields VALUES $sql_values;\n";

			if (isset($_REQUEST['sql']))
			{			
				echo "$sql<br>";
			}
			else
			{
				if (!$g_db->query($sql))
				{
					$str = mysql_error();
					$g_db->query("rollback");
					die("*** Query failed ***<br>\n<br>\n$sql\n<br>SQL Error: $str");
				}
			}			
			echo "<li>".current($row);
			$sql = "";			
		}
		
		$g_db->query("commit");
		
		
		
		fclose($fh);
		
		
	}



?>

<h1>Import data</h1>
<form action="." method="post" enctype="multipart/form-data">	
Password: <input type=password name=password value="<?=$_REQUEST[password]?>"><br>
Mapping: <select name=mapping>
<?
	$d = dir(".");
	while (false !== ($entry = $d->read()))
	{
		if (!strncmp($entry, "mapping.", strlen("mapping.")))
		{
			echo "<option value=\"$entry\">$entry</option>";
		}
	}
	$d->close();
?>
</select><br>

Load data from disk: <select name=fromdisk><option value="">Upload</option>
<?
	$d = dir("./data");
	while (false !== ($entry = $d->read()))
	{
		echo "<option value=\"$entry\">$entry</option>";
	}
	$d->close();
?>
</select><br>
Load data: <input type=file name=data><br>
Generate sql: <input type=checkbox name=sql><br>
<input type=submit name=Import>
	
</form>