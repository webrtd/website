<?
  echo file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?sensor=true&key=AIzaSyDeA42UtQuqZ3c6Si7HDjoWjH9G_5N4dro&address=".urlencode($_REQUEST['address']));
  
?>