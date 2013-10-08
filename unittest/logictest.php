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

class DeleteOtherMeeting extends UnitTest
{
	function Run()
	{
		DBCallCountReset();
		mock_session_setup();
		logic_delete_other_meeting("fest");
		$this->AssertEqual(DBCallCountGet(),0);

		DBCallCountReset();
		logic_delete_other_meeting(1);
		$this->AssertEqual(DBCallCountGet(),1);
	}
}

class IsAdmin extends UnitTest
{
	function Run()
	{
		mock_session_setup();
		$this->Assert(logic_is_admin());
		
		mock_session_clear();
		$this->AssertFalse(logic_is_admin());
	}
}

class PutOtherMeeting extends UnitTest
{
	function Run()
	{
		DBCallCountReset();
		mock_session_clear();
		logic_put_other_meeting(array());
		$this->AssertEqual(DBCallCountGet(),0);

		DBCallCountReset();
		mock_session_setup();
		logic_put_other_meeting(array());
		$this->AssertEqual(DBCallCountGet(),0);
		
		DBCallCountReset();
		mock_session_setup();
		logic_put_other_meeting(array('title'=>'title','description'=>'desc','location'=>'nowhere','start_time'=>'2012-10-10','end_time'=>'2012-11-11'));
		$this->AssertEqual(DBCallCountGet(),1);
		
	}
}


$tests = array(
	new SubmissionPeriod(),
	new IsHonorary(),
	new GetUsername(),
	new GetOtherMeetings(),
	new DeleteOtherMeeting(),
	new IsAdmin(),
	new PutOtherMeeting()
);

RunUnitTests($tests);

?>