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
	var now = new Date();
	$.each(values, function(i, row)
	{
		if (row.url_link.indexOf('stalker')==-1)
		{
			var y = parseInt(row.last_page_view.substring(0,4));
			var m = parseInt(row.last_page_view.substring(5,7));
			var d = parseInt(row.last_page_view.substring(8,10));
			var  h = parseInt(row.last_page_view.substring(11,13));
			var mm = parseInt(row.last_page_view.substring(14,16));

			var lastpageview = new Date();
			lastpageview.setFullYear(y);
			lastpageview.setMonth(m-1);
			lastpageview.setDate(d);
			lastpageview.setHours(h);
			lastpageview.setMinutes(mm);
						
			var diff = Math.round((now.getTime() - lastpageview.getTime())/60000.0);
			
			
			html = html + "<tr><td><img src='/uploads/user_image?uid="+row.id+"&landscape&w=24&h=36'></td><td><a href=/?uid="+row.id+">"+row.title+"</a> kiggede p&aring; <a href="+row.url_link+">"+row.url_title+"</a><br><i>"+diff+" minutter siden</i></td></tr>";
		}
	});
	html = html + "</table>";
	return html;
}

function date_to_time_stamp(data)
{
	var y = parseInt(data.substring(0,4));
	var m = parseInt(data.substring(5,7));
	var d = parseInt(data.substring(8,10));
	var  h = parseInt(data.substring(11,13));
	var mm = parseInt(data.substring(14,16));

	var lastpageview = new Date();
	lastpageview.setFullYear(y);
	lastpageview.setMonth(m-1);
	lastpageview.setDate(d);
	lastpageview.setHours(h);
	lastpageview.setMinutes(mm);
	
	return lastpageview.getTime();
}


function get_time_stamp(k,v)
{
	if (k=='uid')
	{
			return date_to_time_stamp(v.last_page_view);
	}
	else if (k=='mid')
	{
		return date_to_time_stamp(v.start_time);
	}
}

function time_to_text(diff)
{
	if (diff>60)
	{
		diff = Math.round(diff / 60.0);
		return diff+" timer";
	}
	else
	{
		return diff+" minutter";
	}
}


function get_html(k,row)
{
	var now = new Date();	
	var diff = Math.round((now.getTime() - get_time_stamp(k,row))/60000.0);
	
	if (k == 'uid')
	{
		return "<tr><td><img src='/uploads/user_image?uid="+row.id+"&landscape&w=24&h=36'></td><td><a href=/?uid="+row.id+">"+row.title+"</a> kiggede p&aring; <a href="+row.url_link+">"+row.url_title+"</a><br><i>"+time_to_text(diff)+" siden</i></td></tr>\n";
	}
	if (k == 'mid')
	{
		if (diff<0)
		{
			diff *= -1;
		return "<tr><td><img src=/uploads/user_image/?uid=-1&landscape&w=24&h=36></td><td>M&oslash;de <a href=?"+k+"="+row.id+" title='"+row.ts+"'>'"+row.title+"'</a><br><i>Starter om "+time_to_text(diff)+"</i></td></tr>";
		}
		else
		{
		return "<tr><td><img src=/uploads/user_image/?uid=-1&landscape&w=24&h=36></td><td>M&oslash;de <a href=?"+k+"="+row.id+" title='"+row.ts+"'>'"+row.title+"'</a><br><i>"+time_to_text(diff)+"  siden</i></td></tr>";
		}
	

	}
	else return "";
}

function notify_build()
{
  var notification_data = jQuery.parseJSON('<?=addslashes(json_encode($data))?>');
  var html = "";
  var cnt = 0;
  var global_count = 0;
  
  
  
  //console.log(notification_data);
  
  
  
  var timestamp_index = [];
  var data_index = [];
  $.each(notification_data, function(key,value)
  {
	$.each(value, function(i, row)
	{
		var ts = get_time_stamp(key, row);
		if (timestamp_index.indexOf(ts)==-1)
		{
			timestamp_index.push(ts);
			data_index[ts] = get_html(key,row);
		}
		else
		{
			data_index[ts] = data_index[ts] + get_html(key,row);
		}
	});
  });
  
  timestamp_index.sort();
  timestamp_index.reverse();

	html = '';
  $.each(timestamp_index, function(idx,v) {	
	html += data_index[v];
  });
  
//  console.log(html);
  return "<h1>Aktuelt</h1><div style='height: 330px; overflow: scroll; overflow-x: hidden;'><table>"+html+"</table></div>";
}

function old_notify_build()
{
  var notification_data = jQuery.parseJSON('<?=addslashes(json_encode($data))?>');
  var html = "";
  var cnt = 0;
  var global_count = 0;
  console.log(notification_data);
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
        };
        

		if (key=='uid') html += notify_build_lastusers(values);
		else
		{
			html = html + "<h1>"+title+"</h1><ul>";
			$.each(values, function(i, row){
				console.log(row);
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






