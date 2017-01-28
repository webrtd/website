<?
  require_once 'config.php';
  try
  {
    


    $db = new PDO('mysql:host=localhost;dbname=rtd_bode;', $db_user, $db_password);
    
    
    function db_execute($db, $sql, $vals)
    {
      $stmt = $db->prepare($sql);
      $stmt->execute($vals);
      return $stmt->fetchAll(PDO::FETCH_ASSOC);      
    }
    
    function get_club_year($year_modify)
    {
      if (date('m')<7)
      {
        return array('start'=>(date("Y")-1+$year_modify).'-07-01', 'end'=>(date("Y")+$year_modify).'-06-30');
      }
      else
      {
        return array('start'=>(date("Y")+$year_modify).'-07-01', 'end'=>(date("Y")+1+$year_modify).'-06-30');
      }
    }
    
    function get_ticket_club_year($db, $year_modify, $cid)
    {
      $club_year = get_club_year($year_modify);
      $sql = "SELECT * FROM ticket WHERE cid={$cid} AND ts>'{$club_year['start']}' AND ts<'{$club_year['end']}' ORDER BY ts DESC";
      return db_execute($db, $sql, array());
    }
    
    function remove_ticket($db, $uid, $cid, $tid)
    {
      $sql = "DELETE FROM ticket WHERE cid={$cid} AND uid={$uid} AND tid={$tid}";
      $db->exec($sql);
      return "Success";
    }
   
    function put_ticket($db, $cid, $ticket_uid, $uid, $txt, $val)
    {
      $sql = "INSERT INTO ticket (cid,ticket_uid,uid,amount,text,ts) VALUES ({$cid},{$ticket_uid},{$uid},{$val},'{$txt}',NOW())";
      $db->exec($sql);
      return "Success";
    }
    
    
    function put_predefined($db, $cid, $val, $msg)
    {
      $sql = "INSERT INTO predefined_ticket (cid,amount,message) VALUES ({$cid},{$val},'{$msg}')";
      $db->exec($sql);
      return "Success";
    }
    
    function remove_predefined($db, $cid, $pid)
    {
      $db->exec("DELETE FROM predefined_ticket WHERE cid={$cid} AND pid={$pid}");
    }
    
    function get_predefined($db, $cid)
    {
      return db_execute($db, "SELECT * FROM predefined_ticket WHERE cid={$cid} ORDER BY amount ASC");
    }
    
    
    function get_int_param($p)
    {
      if (isset($_REQUEST['parameters'][$p]) && is_numeric($_REQUEST['parameters'][$p]))
      {
        return $_REQUEST['parameters'][$p];
      }
      return false;
    }
    
    
    if (isset($_REQUEST['do']))
    {
      $do = $_REQUEST['do'];
      $data = array();
 //     print_r($_REQUEST);      
      if ($do == 'get_predefined')
      {
        $cid = get_int_param('cid');
        if ($cid !== false)
        {
          $data = get_predefined($db, $cid);
        }
      }
      else if ($do == 'remove_predefined')
      {
        $cid = get_int_param('cid');
        $pid = get_int_param('pid');
        if ($pid !== false && $cid !== false)
        {
          $data = remove_predefined($db, $cid, $pid);
        }
      }
      else if ($do == 'put_predefined')
      {
        $cid = get_int_param('cid');
        $val = get_int_param('val');
        $msg = $_REQUEST['parameters']['msg'];
        if ($cid !== false && $val !== false)
        {
          $data = put_predefined($db, $cid, $val, $msg);
        }
      }
      else if ($do == 'put')
      {
        $ticket_uid = get_int_param('ticket_uid');
        $cid = get_int_param('cid');
        $uid = get_int_param('uid');
        $txt = $_REQUEST['parameters']['txt'];
        $val = get_int_param('val');
        
        if ($ticket_uid !== false && $cid !== false && $uid!== false && $val!==false)
        {
          $data = put_ticket($db, $cid, $ticket_uid, $uid, $txt, $val);
        }
      }
      else if ($do == 'remove')
      {
        $uid = get_int_param('uid');
        $cid = get_int_param('cid');
        $tid = get_int_param('tid');
        if ($uid !== false && $cid !== false && $tid !== false)
        {
          $data = remove_ticket($db, $uid, $cid, $tid);
        }
      }
      else if ($do == 'list')
      {
        $year = get_int_param('year');
        $cid = get_int_param('cid');
        if ($year !== false && $cid !== false)
        {
          $data = get_ticket_club_year($db, $year, $cid);
        }
      }
      
      die(json_encode($data));
      
    }
    else
    {
      header("location: /");
    }
    
    
  }
  catch (Exception $e)
  {
    echo "<h1>Error</h1><pre>";
    print_r($e);
  }

?>