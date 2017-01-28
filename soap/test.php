<?
	require_once('include/nusoap.php');	

	$login = "kaae";
	$password = "password";
	$param = array('username'=>$login, 'password'=>$password);

	
	
	function rtd_soap_call($func, $param)
	{
		$endpoint = "http://www.rtd.dk/soap/index.php";
		$mynamespace = "http://www.rtd.dk/soap/?wsdl";
		$client = new soapclient($endpoint);
		$response  = $client->call($func, $param, $mynamespace);
		echo "<pre>";
		print_r($response);
		echo "</pre>";
		return json_decode($response);
	}
	
	
	
	$user = rtd_soap_call('soap_login',$param);
	
	$token = $user->token;	
	$results = rtd_soap_call('soap_get_user_year_details_stats', array('token'=>$token, 'uid'=>$user->uid));
	echo "<h1>Output</h1>";
	echo "<pre>".print_r($results,true);
?>
