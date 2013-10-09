<?

define("UNITTEST", TRUE);

$TestResults = array("ErrorCount" => 0, "OKCount" => 0);
$TestLog = "";

function StyleBoxError($content)
{
	return "<div style='border-radius:10px;background:red;color:white;padding:10px;'>".$content."</div>";
}
function StyleBoxOK($content)
{
	return "<div style='border-radius:10px;background:green;color:white;padding:10px;'>".$content."</div>";
}


class UnitTest
{
	function ReportError($w)
	{
		global $TestResults;
		global $TestLog;
		
		$TestResults['ErrorCount']++;
		$callers=debug_backtrace();
		$test_case = $callers[2]['class'].$callers[2]['type'].$callers[2]['function'].' at line '.$callers[2]['line'].' in '.$callers[2]['file'];
		$TestLog .= StyleBoxError("<a name=error><h3>".get_class($this).": $w failed</h3></a><i>{$test_case}</i>");
	}
	
	function ReportOK($w)
	{
		global $TestResults;
		global $TestLog;
		$TestResults['OKCount']++;
		$callers=debug_backtrace();
		$test_case = $callers[2]['class'].$callers[2]['type'].$callers[2]['function'].' at line '.$callers[2]['line'].' in '.$callers[2]['file'];
		$TestLog .= StyleBoxOK("<h3>".get_class($this).": $w</h3><i>{$test_case}</i>");
	}
	
	function AssertEqual($a,$b)
	{
		if ($a == $b)
		{
			$this->ReportOK("AssertEqual");
		}
		else
		{
			$this->ReportError("AssertEqual - Expected {$b} found {$a}");
		}
	}
	
	function Assert($w)
	{
		if (!$w)
		{
			$this->ReportError("Assert - {$w}");
			
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
			$this->ReportError("AssertFalse - {$w}");
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
	global $TestLog;
	global $TestResults;
	
	
	foreach ($tests as $t)
	{
		$TestLog .= "<h2>Running ".get_class($t)."</h2><ul>";
		$t->Run();
		$TestLog .= "</ul>";
	}
	
	$ok = $TestResults['OKCount'];
	$fail = $TestResults['ErrorCount'];
	$total = $ok+$fail;
	
	if ($fail>0)
	{
		$TestLog = "<h1>Test suite run</H1>".
							StyleBoxError("Total tests: {$total}. Passed: {$ok}. Failed: {$fail}").
		$TestLog;
	}
	else
	{
		$TestLog = "<h1>Test suite run</H1>".
							StyleBoxOK("Total tests: {$total}. Passed: {$ok}. Failed: {$fail}").
		$TestLog;
	}
	
	echo $TestLog;
}
?>