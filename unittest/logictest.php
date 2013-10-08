<?

require_once 'unittest.php';
require_once 'mock_datafetcher.php';
require_once 'mock_session.php';
require_once '../config.php.distribution';
require_once '../includes/logic.php';

class SubmissionPeriod extends UnitTest
{
	function Run()
	{
		$this->AssertFalse(logic_club_board_submission_period("1"));
		$this->Assert(logic_club_board_submission_period("5"));
	}
};

class IsHonorary extends UnitTest
{
	function Run()
	{
		$this->Assert(logic_is_honorary(1));
		$this->AssertFalse(logic_is_honorary(0));
	}
}

class GetUsername extends UnitTest
{
	function Run()
	{
		mock_session_setup();
		$this->Assert(logic_get_current_username()!="");
		mock_session_clear();
		$this->AssertFalse(logic_get_current_username());
	}
}

class GetOtherMeetings extends UnitTest
{
	function Run()
	{
		$o = logic_get_other_meetings(1);
		$this->AssertFalse(empty($o));
		$o = logic_get_other_meetings("ok");
		$this->Assert(empty($o));
	}
}


$tests = array(
	new SubmissionPeriod(),
	new IsHonorary(),
	new GetUsername(),
	new GetOtherMeetings()
);


echo "\nTest suite running ....\n";
foreach ($tests as $t)
{
	echo "Running ".get_class($t)."\n";
	$t->Run();
}
TestExecutionReport();

?>