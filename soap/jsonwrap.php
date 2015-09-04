<?
	require_once('include/nusoap.php');	
		
	function rtd_soap_call($func, $param)
	{
		$endpoint = "http://rtd.dk/soap/index.php";
		$mynamespace = "http://rtd.dk/soap/?wsdl";
		$client = new soapclient($endpoint);
		$response  = $client->call($func, $param, $mynamespace);
		return ($response);
	} 
	
	
	
	$func = $_POST['cb'];
	$params = isset($_POST['parameters'])?$_POST['parameters']:'';
	
	
	$data =  rtd_soap_call($func, $params);
	echo $data;
	
?>