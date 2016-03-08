<?
  chdir($_SERVER['DOCUMENT_ROOT']);
	require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/config_terms.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/logic.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/cache.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/sessionhandler.php';
	
	session_start();

	
	$country = logic_get_country(0);
	
		$count = 0;
		FOR ($i=0;$i<sizeof($country['minutes']);$i++)
		{
			$img = fetch_images_for_meeting($country['minutes'][$i]['mid']);
			IF (EMPTY($img))
			{
			}
			ELSE
			{
				$item = $country['minutes'][$i];
				$item['image'] = $img[0]['miid'];
				UNSET($item['minutes_letters']);
				UNSET($item['minutes_3min']);
				UNSET($item['minutes']);
				UNSET($item['description']);
				UNSET($item['location']);
				$item['title'] = str_replace("'", "", $item['title']);
				$minutes[] = $item;
				echo "<img src=?{$item['image']}>";
				$count ++;
			}
        }
?>