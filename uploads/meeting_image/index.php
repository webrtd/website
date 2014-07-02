<?
/*
	image fetcher
	
	05-11-2012	rasmus@3kings.dk 	draft
	09-11-2012	rasmus@3kings.dk	added session handler
*/
			

	require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/config_terms.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/logic.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/sessionhandler.php';
	
	session_start();
	
	function load_image($fn)
	{
		$i = @imagecreatefromjpeg($fn);
		if (!$i) $i=@imagecreatefromgif($fn);
		if (!$i) $i=@imagecreatefrompng($fn);
		if (!$i) $i=@imagecreatefromjpg(CLUB_LOGO_PATH."/0.jpg");
		$s = getimagesize($fn);
		return array("image" => $i, "size" => $s);
	}


  function image_crop($image, $new_height, $new_width)
  {
	 $width = imagesx($image);
	 $height = imagesy($image);
  
    $croppedimage = imagecreatetruecolor($new_width, $new_height);
    
    $sx = ($width-$new_width)/4;
    $sy = ($height-$new_height)/4;
    imagecopy($croppedimage, $image, 0, 0, $sx, $sy, $new_width, $new_height);
    return $croppedimage;
  }

  function scale_width($image, $new_width)
  {
	 $width = imagesx($image);
	 $height = imagesy($image);
   
   $ratio = $new_width / $width;
   
   $sx = ceil($width*$ratio);
   $sy = ceil($height*$ratio);
   	 
   
   $scaledimage = imagecreatetruecolor($sx, $sy);
   
   imagecopyresampled($scaledimage, $image, 0,0,0,0, $sx, $sy, $width, $height);
   return $scaledimage;
  }	
	
  function scale_height($image, $new_height)
  {
	 $width = imagesx($image);
	 $height = imagesy($image);
   
   $ratio = $new_height / $height;
   
   $sx = ceil($width*$ratio);
   $sy = ceil($height*$ratio);
   
   $scaledimage = imagecreatetruecolor($sx, $sy);
   
   imagecopyresampled($scaledimage, $image, 0,0,0,0, $sx, $sy, $width, $height);
   return $scaledimage;
  }	


	if (logic_is_member() || logic_is_mummy())
	{
		if (!isset($_REQUEST['miid']) || $_REQUEST['miid']=="0" || $_REQUEST['miid']=="1")
		{
			$filepath = MEETING_IMAGES_UPLOAD_PATH."/noimage.png";
		}
		else
		{
			$filepath = logic_get_meeting_image($_REQUEST['miid']);
		}

		if (stripos($filepath,".jpg") || stripos($filepath, ".jpeg")) {$fn = "rtd.jpg"; $mime = "image/jpeg";}
		else if (stripos($filepath, ".png")) {$fn = "rtd.png"; $mime = "image/png";}
		else if (stripos($filepath, ".gif")) {$fn = "rtd.gif"; $mime = "image/gif";}
		else {$fn="whatever.txt"; $mime = "application/octet-stream";}
		
		$sn = $_SERVER['SERVER_NAME'];
		$hashfile = sys_get_temp_dir().'/{$sn}-'.md5($_SERVER['REQUEST_URI']);
		
		if (isset($_REQUEST['landscape']))
		{
			if (!file_exists($hashfile))
			{ 
				$w = $_REQUEST['w'];
				$h = $_REQUEST['h'];
				
				$i = load_image($filepath);
				
				if ($w > $h)	$scaled = scale_width($i['image'], $w);
				else $scaled = scale_height($i['image'], $h);
				
				$cropped = image_crop($scaled, $h, $w);
				imagejpeg($cropped,$hashfile);
			}
			header("Content-type: image/jpeg");
			die(file_get_contents($hashfile));
		}
		else if (isset($_REQUEST['portrait']))
		{
			$i = load_image($filepath);
		}
		else if (isset($_REQUEST['quad']))
		{
			if (!file_exists($hashfile))
			{
				$i = load_image($filepath);
				$s = $_REQUEST['s'];
				if ($i['size'][0] < $s)	$scaled = scale_width($i['image'], $s);
				else $scaled = scale_height($i['image'], $s);
				$cropped = image_crop($scaled, $s, $s);
				imagejpeg($cropped,$hashfile);
			}
			header("Content-type: image/jpeg");
			die(file_get_contents($hashfile));
		}
		else if(isset($_REQUEST['w']))
		{
			if (!file_exists($hashfile)) 
			{
				$i = load_image($filepath);
				$scaled = scale_width($i['image'], $_REQUEST['w']);
				imagejpeg($scaled,$hashfile);
			}
			header("Content-type: image/jpeg");
			die(file_get_contents($hashfile));
		}
		else 
		{
			header("Content-type: $mime");
			die(file_get_contents($filepath));
		}
	}
	else
	{
		
		echo term('article_must_be_logged_in');
	}

?>