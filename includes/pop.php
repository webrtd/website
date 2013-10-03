<?
function pop3_login($host,$port,$user,$pass,$folder="INBOX",$ssl=false)
{
	@imap_timeout(IMAP_OPENTIMEOUT,5);
	return @imap_open("{{$host}:{$port}/novalidate-cert}INBOX", $user, $pass,0,1);
}
function pop3_stat($connection)       
{
    $check = @imap_mailboxmsginfo($connection);
    return ((array)$check);
} 
?>