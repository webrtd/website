<?

define("UNITTEST", TRUE);

$__test_data__failed__ =  Array();

class UnitTest
{
	
	function Assert($w)
	{
		global $__test_data__failed__;
		if (!$w)
		{
			$__test_data__failed__[] = get_class($this).": Assert failed\n".$this->StackTrace();
		}
	}
	
	function AssertFalse($w)
	{
		Assert(!$w);
	}
	
	function StackTrace()
	{
		ob_start();
		debug_print_backtrace();
		$trace = ob_get_contents();
		ob_end_clean();
		return $trace;	
	}
	
	
}

function TestExecutionReport()
{
	global $__test_data__failed__;
	
	if (empty($__test_data__failed__))
	{
		echo "\n\nTest OK\n\n";
	}
	else
	{
		echo "\n\nTest failed\n\n";
		foreach ($__test_data__failed__ as $d)
		{
			echo $d;
		}
	}
}

?>