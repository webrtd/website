<?

  function stacktrace()
  {
				ob_start();
				debug_print_backtrace();
				$trace = ob_get_contents();
				ob_end_clean();
        return $trace.print_r($_SERVER,true); 		    		
  }

?>