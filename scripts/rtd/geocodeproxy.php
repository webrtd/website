<?
	session_start();
	 
	if (isset($_SESSION['geocoder']) && isset($_SESSION['geocoder'][$_REQUEST['address']]))
	{
		echo $_SESSION['geocoder'][$_REQUEST['address']];
	}
	else
	{
		$data = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?sensor=true&key=AIzaSyBzzWTmKtzToWksHsNMHmAT0bLd_PoOEC4&address=".urlencode($_REQUEST['address']));

		if (!isset($_SESSION['geocoder']))
		{
			$_SESSION['geocoder'] = array();
		}
		
		$_SESSION['geocoder'][$_REQUEST['address']]=$data;
		echo $data;
		
	}


  
?>