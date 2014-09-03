<?
/*
	image fetcher
	
	27-11-2012	rasmus@3kings.dk 	draft
*/
			
  chdir($_SERVER['DOCUMENT_ROOT']);

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
		if (!$i) 
		{
		  return load_image(IMAGE_MISSING_PROFILE);
		}
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
           
	//if (logic_is_member() || logic_is_mummy())
	{
		$user = logic_get_user_by_id($_REQUEST['uid']);
		$filepath = $user['profile_image'];
		if ($filepath == "")
		{
			$filepath = IMAGE_MISSING_PROFILE;
		}
		else 
    {
      if (strpos($filepath,'sites/')!==false)
  		{
        $ext = ".".strtolower(pathinfo($filepath, PATHINFO_EXTENSION));
        $conn = ftp_connect(OLD_FTP_SERVER);
        ftp_login($conn, OLD_FTP_USER, OLD_FTP_PASSWORD);       
        $new_filepath = USER_IMAGES_UPLOAD_PATH.$_REQUEST['uid'].$ext;
        if (ftp_get($conn, $new_filepath, $filepath, FTP_BINARY))
        {
          chmod($new_filepath,0777);
          logic_update_profile_image($_REQUEST['uid'], $new_filepath);
          $filepath=$new_filepath;
        }
        ftp_close($conn);
  		}
  		else
  		{
        if (!file_exists($filepath))
        {
          $filepath = $_SERVER['DOCUMENT_ROOT'].'/uploads/user_image/'.$filepath;
        }
  		}
    }
		if (stripos($filepath,".jpg") || stripos($filepath, ".jpeg")) {$fn = "rtd.jpg"; $mime = "image/jpeg";}
		else if (stripos($filepath, ".png")) {$fn = "rtd.png"; $mime = "image/png";}
		else if (stripos($filepath, ".gif")) {$fn = "rtd.gif"; $mime = "image/gif";}
		else {$fn = "rtd.jpg"; $mime = "image/jpeg";}
		

//		die($filepath);
		
		$sn = $_SERVER['SERVER_NAME'];                                                           
		$hashfile = sys_get_temp_dir().'/{$sn}-uid-'.$user['uid'].'-'.md5($_SERVER['REQUEST_URI'].filemtime($filepath));

		
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
			//header("Content-type: image/jpeg");
			die(file_get_contents($hashfile));
		}
		else if (isset($_REQUEST['w']))
		{
			if (!file_exists($hashfile))
			{
				$i = load_image($filepath);
				$w = $_REQUEST['w'];
				$scaled = scale_width($i['image'], $w);
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
	/*else
	{
		
		echo term('article_must_be_logged_in');
	}*/

?>