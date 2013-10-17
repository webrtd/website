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


class UpdateClub extends UnitTest
{
	function Run()
	{
		DBCallCountReset();
		mock_session_clear();
		logic_update_club(1, array());
		$this->AssertEqual(DBCallCountGet(),0);
		
		mock_session_setup();
		DBCallCountReset();
		logic_update_club(1, array());
		$this->AssertEqual(DBCallCountGet(),1);

		mock_session_setup();
		DBCallCountReset();
		logic_update_club("ok", array());
		$this->AssertEqual(DBCallCountGet(),0);

		mock_session_setup();
		DBCallCountReset();
		logic_update_club(1, "ok");
		$this->AssertEqual(DBCallCountGet(),0);
	}
}

class Login extends UnitTest
{
	function EmptyLogin()
	{
		mock_session_clear();
		DBCallCountReset();
		logic_login("","");
		$this->AssertEqual(DBCallCountGet(),0);
	}
	
	function UsernameLogin()
	{
		DBCallCountReset();
		$l=logic_login("test","test");
		$this->Assert(!empty($l));
	}

	function PrivateMailLogin()
	{
		DBCallCountReset();
		$l=logic_login("private@test.com","test");
		$this->Assert(!empty($l));
	}

	function CompanyMailLogin()
	{
		DBCallCountReset();
		$l=logic_login("company@test.com","test");
		$this->Assert(!empty($l));
	}
	
	function InjectionTest()
	{
		DBCallCountReset();
		$l=logic_login("' or 1=1 ; --", "test");
		$this->AssertEqual(DBCallCountGet(),0);
	}

	
	function Run()
	{
		$this->InjectionTest();
		$this->EmptyLogin();
		$this->UsernameLogin();
		$this->PrivateMailLogin();
		$this->CompanyMailLogin();
	}
}

class SaveMail extends UnitTest
{
	function BlankReceiver()
	{
		DBCallCountReset();
		logic_save_mail(" ", "subj", "body");	
		$this->AssertEqual(DBCallCountGet(),0);
	}
	
	function ArrayReceivers()
	{
		DBCallCountReset();
		$data = array("foo@bar.com", "example.com", "test@test.com");
		logic_save_mail($data, "subj", "body");
		$this->AssertEqual(DBCallCountGet(), 3);
	}
	
	function SingleReceiver()
	{
		DBCallCountReset();
		logic_save_mail("foo@bar.com", "subj", "body");
		$this->AssertEqual(DBCallCountGet(), 1);
	}
	
	function Run()
	{
		$this->BlankReceiver();
		$this->ArrayReceivers();
		$this->SingleReceiver();
	}
}

$tests = array(
	new SubmissionPeriod(),
	new IsHonorary(),
	new GetUsername(),
	new GetOtherMeetings(),
	new DeleteOtherMeeting(),
	new IsAdmin(),
	new PutOtherMeeting(),
	new UpdateClub(),
	new Login(),
	new SaveMail()
);

RunUnitTests($tests);

?>