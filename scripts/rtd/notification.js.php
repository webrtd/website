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
	
	if (isset($_REQUEST['json']))
	{
		die((json_encode($data)));
	}
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
	if (data.length<11)
	{
		var y = parseInt(data.substring(0,4));
		var m = parseInt(data.substring(5,7));
		var d = parseInt(data.substring(8,10));

		var lastpageview = new Date();
		lastpageview.setFullYear(y);
		lastpageview.setMonth(m-1);
		lastpageview.setDate(d);
		
		return lastpageview.getTime();
	}
	else
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
}


function get_time_stamp(k,v)
{
	if (k=='uid')
	{
			return date_to_time_stamp(v.last_page_view);
	}
	else if (k=='aid' || k=='attendance')
	{
		return date_to_time_stamp(v.ts);
	}
	else if (k=='news' || k=='news_comment')
	{
		return date_to_time_stamp(v.posted);
	}
	else if (k=='mid')
	{
		return date_to_time_stamp(v.start_time);
	}
	else if (k=='birthday')
	{
		return date_to_time_stamp(v.profile_birthdate);
	}
}

function time_to_text(diff)
{
	if (diff>60*24*365)
	{
		diff = Math.round(diff / (60.0*24.0*365.0));
		return diff+" &aring;r";
	}
	else if (diff>60*24*30)
	{
		diff = Math.round(diff / (60.0*24.0*30.0));
		if (diff==1) return diff+" m&aring;ned";
		else return diff+" m&aring;neder";
	}
	else
	if (diff>60*24)
	{
		diff = Math.round(diff / (60.0*24.0));
		if (diff==1) return diff+" dag";
		else return diff+" dage";
	}
	else
	if (diff>60)
	{
		diff = Math.round(diff / 60.0);
		if (diff==1) return diff+" time";
		else return diff+" timer";
	}
	else
	{
		if (diff==1) 	return diff+" minut";
		else	return diff+" minutter";
	}
}

jQuery.fn.flash = function( color, duration )
{
    var current = this.css( 'color' );
    this.animate( { color: 'rgb(' + color + ')' }, duration / 2 );
    this.animate( { color: current }, duration / 2 );
}


function get_html(k,row)
{
	var now = new Date();	
	var diff = Math.round((now.getTime() - get_time_stamp(k,row))/60000.0);

	 if (k == 'attendance')
	{
		var str = "";
		if (row.accepted == 0) str = "meldte afbud til";
		else str = "tilmeldte sig";
		return "<tr><td><img src='/uploads/user_image?uid="+row.uid+"&landscape&w=24&h=36'></td><td><a href=/?uid="+row.uid+">"+row.who+"</a> "+str+" <a href=/?mid="+row.mid+">"+row.title+"</a> <br><i>"+time_to_text(diff)+" siden</i></td></tr>\n";
	} else if (k=='aid')
	{
		return "<tr><td><img src='http://sproutit.scit.edu/images/ArticleIcon.gif' width=24></td><td>Artikel opdateret <a href=/?aid="+row.id+">"+row.title+"</a><br><i>"+time_to_text(diff)+" siden</i></td></tr>\n";
	}
	else	if (k=='news')
	{
		return "<tr><td><img src='http://chaotic-flow.com/wp-content/themes/chaotic-flow-theme/images/email-icon-48.png' width=24></td><td>Nyhed <a href=/?news="+row.id+">"+row.title+"</a><br><i>"+time_to_text(diff)+" siden</i></td></tr>\n";
	}
	else	if (k=='news_comment')
	{
		return "<tr><td><img src='https://cdn0.iconfinder.com/data/icons/duesseldorf/32/comment.png' width=24></td><td>Kommentar til nyhed <a href=/?news="+row.id+">"+row.title+"</a><br><i>"+time_to_text(diff)+" siden</i></td></tr>\n";
	}
	else if (k=='birthday')
	{
		return "<tr><td><img src='http://png-3.findicons.com/files/icons/2758/flag_icons/64/denmark.png' width=24></td><td><a href=/?uid="+row.uid+">"+row.profile_firstname+" "+row.profile_lastname+"</a> har f&oslash;dselsdag</td></tr>\n";
	}
	else if (k == 'uid')
	{
		return "<tr><td><img src='/uploads/user_image?uid="+row.id+"&landscape&w=24&h=36'></td><td><a href=/?uid="+row.id+">"+row.title+"</a> kiggede p&aring; <a href="+row.url_link+">"+row.url_title+"</a><br><i>"+time_to_text(diff)+" siden</i></td></tr>\n";
	}
	if (k == 'mid')
	{
		if (diff<0)
		{
			diff *= -1;
		return "<tr><td><img src=http://img.informer.com/icons/png/48/17/17189.png width=24></td><td>M&oslash;de <a href=?"+k+"="+row.id+" title='"+row.ts+"'>'"+row.title+"'</a><br><i>Starter om "+time_to_text(diff)+"</i></td></tr>";
		}
		else
		{
		return "<tr><td><img src=http://img.informer.com/icons/png/48/17/17189.png width=24></td><td>M&oslash;de <a href=?"+k+"="+row.id+" title='"+row.ts+"'>'"+row.title+"'</a><br><i>"+time_to_text(diff)+"  siden</i></td></tr>";
		}
	

	}
	else return "";
}

function notify_build()
{
	console.log('downloading');
	$.getJSON( "/scripts/rtd/notification.js.php?json", function( notification_data ) {
	console.log('downloaded');
  //var notification_data = jQuery.parseJSON('<?=addslashes(json_encode($data))?>');
  var html = "";
  var cnt = 0;
  var global_count = 0;
  
  
  
//  console.log(notification_data);
  
  
  
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
  
//  console.log(data_index);

	html = '';
  $.each(timestamp_index, function(idx,v) {	
	html += data_index[v];
  });
  
//  console.log(html);
	document.getElementById('notify_build').innerHTML = "<table>"+html+"</table>";
	
	 setTimeout(notify_build, 10000);
	 }) .fail(function() {
console.log( "error" );
});
}

document.write("<h1>Aktuelt</h1><div id=notify_build style='height: 830px; overflow: scroll; overflow-x: hidden;'></div>");
notify_build();