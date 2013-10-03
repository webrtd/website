<?

  function cache_get($key)
  {
    $fn = sys_get_temp_dir()."/rtd-".md5($key);
    if (!file_exists($fn))
    {
      return false;
    }
    else return unserialize(file_get_contents($fn));
  }
  
  function cache_invalidate($key)
  {
    $fn = sys_get_temp_dir()."/rtd-".md5($key);
    @unlink($fn);
  }
  
  function cache_put($key,$data) 
  {
    $fn = sys_get_temp_dir()."/rtd-".md5($key);
    file_put_contents($fn,serialize($data));
  }

?>