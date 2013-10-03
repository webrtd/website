<?
  echo file_get_contents("http://maps.googleapis.com/maps/api/geocode/json?sensor=true&address=".urlencode($_REQUEST['address']));
?>