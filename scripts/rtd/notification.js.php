<?
	require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/config_terms.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/logic.php';
  require_once $_SERVER['DOCUMENT_ROOT'].'/includes/cache.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/sessionhandler.php';
	
	session_start();
die();
  if (!logic_is_member()) die();
	$data = logic_new_updates(date('Y-d-m'),time()-24 * 60 * 60);

?>
function notify_build()
{
  var notification_data = jQuery.parseJSON('<?=addslashes(json_encode($data))?>');
  var html = "";
  var cnt = 0;
  var global_count = 0;
  $.each(notification_data, function(key,values) {
    if (key != 'timestamp')
    {
      if (values && values.length>0)
      {
        switch (key)
        {
        case 'aid': title='Opdaterede artikler';break;
        case 'uid': title='Seneste medlemmer online';break;
        case 'nid': title='Nyheder';break;
        case 'mid': title='Aktuelle m&oslash;der';break;
        case 'ts':title='Nye emner i Tabler Service'; break;
        default: alert(key);
        };
        

        html = html + "<b>"+title+"</b><ul>";
        $.each(values, function(i, row){
          html = html + "<li><a href=?"+key+"="+row.id+" title='"+row.ts+"'>"+row.title+", "+row.ts.substring(11)+"</a>";
			global_count++;
        });
        html = html + "</ul>";
      }
    }                                               
  });
  
	
  if (html.length)
  {
    $("#notify_row").append("<td colspan=3>"+html+"</td>");
    $("#notify_row").show();
  }
}
