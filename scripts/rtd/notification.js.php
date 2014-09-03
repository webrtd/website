<?
  chdir($_SERVER['DOCUMENT_ROOT']);
	require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/config_terms.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/logic.php';
  require_once $_SERVER['DOCUMENT_ROOT'].'/includes/cache.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/sessionhandler.php';
	
	session_start();

  if (!logic_is_member()) die();
	//$data = logic_new_updates(date('Y-d-m'),time()-24 * 60 * 60);
	$data = logic_new_updates(date("Y-m-d", time() - 60 * 60 * 24));
?>
function notify_build_lastusers(values)
{
	var html = "<h1>"+title+"</h1><table width=100%><tr>";
	var count = 0;
	$.each(values, function(i, row)
	{
		if (row.url_link.indexOf('stalker')==-1)
		{
			html = html + "<td valign=top width=100><a href=/?uid="+row.id+"><img src='/uploads/user_image?uid="+row.id+"&landscape&w=100&h=150'><br>"+row.title+"</a> / <a href="+row.url_link+">"+row.url_title+"</a></td>";
			count++;
			if (count == 5) 
			{
				html += "</tr><tr>";
				count = 0;
			}
		}
/*		<li>Indlægget <a href=?"+key+"="+row.id+" title='"+row.ts+"'>'"+row.title+"'</a> er opdateret "+row.ts;*/
	});
	html = html + "</tr></table>";
	return html;
}


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
        case 'aid': title='Opdaterede artikler på RTD';break;
        case 'uid': title='Hvem er online lige nu?';break;
        case 'news': title='Seneste nyheder og kommentarer';break;

        case 'mid': title='Aktuelle m&oslash;der i Round Table Danmark';break;
        case 'ts':title='Tabler Service'; break;
        default: alert(key);
        };
        

		if (key=='uid') html += notify_build_lastusers(values);
		else
		{
			html = html + "<h1>"+title+"</h1><ul>";
			$.each(values, function(i, row){
				html = html + "<li>Indl&aelig;gget <a href=?"+key+"="+row.id+" title='"+row.ts+"'>'"+row.title+"'</a> er opdateret "+row.ts;
				global_count++;
			});
			html = html + "</ul>";
		}
      }
    }                                               
  });
  
	return html;
}

document.write(notify_build());






