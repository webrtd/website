<?

define("UNITTEST", TRUE);


class UnitTest
{
	function ReportError($w)
	{
		echo "<div style='background:red;color:white'>";
		echo "<h3>".get_class($this).": $w failed</h3>";
		echo "<pre>".$this->StackTrace()."</pre>";
		echo "</div>";
	}
	
	function ReportOK($w)
	{
		echo "<div style='background:green;color:white'>";
		echo "<h3>".get_class($this).": $w</h3>";
		echo "</div>";
	}
	
	function AssertEqual($a,$b)
	{
		if ($a == $b)
		{
			$this->ReportOK("AssertEqual");
		}
		else
		{
			$this->ReportError("AssertEqual");
		}
	}
	
	function Assert($w)
	{
		if (!$w)
		{
			$this->ReportError("Assert");
		}
		else
		{
			$this->ReportOK("Assert");
		}
	}
	
	function AssertFalse($w)
	{
		if ($w)
		{
			$this->ReportError("AssertFalse");
		}
		else
		{
			$this->ReportOK("AssertFalse");
		}
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

function RunUnitTests(&$tests)
{
	echo "<h1>Test suite running </H1>";
	foreach ($tests as $t)
	{
		echo "<h2>Running ".get_class($t)."</h2><ul>";
		$t->Run();
		echo "</ul>";
	}
}
?>