<?
// header('Content-Type: application/javascript');
	chdir($_SERVER['DOCUMENT_ROOT']);
	require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/config_terms.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/logic.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/cache.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/sessionhandler.php';
	
	session_start();
	
	$country = logic_get_country("");
	$clubs = logic_get_clubs();
	
	$marker = "";
	
	$m = array();
	
	
	function google_map_create($lat,$lng)
	{
	    echo "
			var google_map_markers = [];
			{
				document.write('<div id=map style=\'width:100%; height:100%\'></div>');
			  var map;
				map = new google.maps.Map(document.getElementById('map'), {
				  center: {lat: {$lat}, lng: {$lng}},
				  zoom: 7
				});
			  }";
	}
	
	
	function google_map_add_marker($location)
	{
			echo "
				{
					var url = '/scripts/rtd/geocodeproxy.php?address={$location}&sensor=true';
					$.ajax( url ).done(function(data)
					{
						var result = jQuery.parseJSON(data);
						console.log(result);
						var latt = -1;
						var lngt = -1;
						var found=false;
						$.each(result.results, function(k,v) {
							latt = v.geometry.location.lat;
							lngt = v.geometry.location.lng;
							found=true;
						});
						if (found)
						{
							var marker = new google.maps.Marker({
									  position: {lat: latt, lng: lngt},
									  map: map,
									  title: '{$location}'
									});
							google_map_markers.push(marker);
							console.log('Found {$location}');
						}
						else
						{
							console.log('Not found {$location}');
						}
					});
				}
				";
	}
	
	function js_put($t)
	{
		echo "document.write('{$t}');\n";
	}
	
	
	js_put('<form action=/scripts/rtd/formmail.php method=post><select name=who>');
	for ($i=0; $i<sizeof($country['districts']); $i++)
	{
		$d = $country['districts'][$i];
		$df = "df".str_replace("Distrikt ", "", $d['name']);
		js_put("<option value={$df}>{$d['description']}</option>");
	}
	js_put("<option value=lf>Hele landet</option>");
	js_put("<option value=vlf>Annoncer</option>");
	js_put("<option value=ls>Medlemskartotek</option>");
	js_put("<option value=web>Teknik</option>");
	js_put('</select>');
	js_put('<input type=email name=email placeholder="Din e-mail" required>');
	js_put('<input type=text name=name placeholder="Dit navn" required>');
	js_put('<input type=text name=subject placeholder="Emne" required>');
	js_put('<textarea name=body placeholder="Din besked" required></textarea>');
	js_put('<input type=submit value=Send class="btn btn-info margin-btm"></form>');
	
	
	
	
	
	google_map_create("56.162939","10.203921");
	
	foreach($clubs as $c=>$club)
	{
		$city = (substr($club['name'], strpos($club['name'], ' ')+3)).",Denmark";
		if (!isset($m[$city]) && $city!=',Denmark')
		{
			google_map_add_marker($city);		
			$m[$city]=true;
		}
	}
	

?>