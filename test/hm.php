<?
/*function delTree($dir) { 
   $files = array_diff(scandir($dir), array('.','..')); 
    foreach ($files as $file) { 
      (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file"); 
	  
	  echo "<li> $file";
    } 
    return true; 
  } 
  
  echo sys_get_temp_dir();
  delTree(sys_get_temp_dir());        */
  
  $s = "&#114;&#97;&#115;&#109;&#117;&#115;&#64;&#51;&#107;&#105;&#110;&#103;&#115;&#46;&#100;&#107;";
  echo "<li>$s";
  $se = html_entity_decode($s);
  echo "<li>$se";
?> 
                                                                        