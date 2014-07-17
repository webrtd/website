<?
/*
	02-07-2014	rasmus@3kings.dk	use $_SERVER to create cache files
*/
	function cache_get_key_file($key)
	{
		$sn = $_SERVER['SERVER_NAME'];
		$fn = sys_get_temp_dir()."/{$sn}-".md5($key).date("YmdH");
		return $fn;
	}

  function cache_get($key)
  {
	$fn = cache_get_key_file($key);
    if (!file_exists($fn))
    {
      return false;
    }
    else return unserialize(file_get_contents($fn));
  }
  
  function cache_invalidate($key)
  {
	$fn = cache_get_key_file($key);
    @unlink($fn);
  }
  
  function cache_put($key,$data) 
  {
	$fn = cache_get_key_file($key);
    file_put_contents($fn,serialize($data));
  }

?>