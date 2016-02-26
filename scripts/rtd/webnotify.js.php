<?
	if (isset($_REQUEST['ajax']))
	{
		chdir($_SERVER['DOCUMENT_ROOT']);
		require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
		require_once $_SERVER['DOCUMENT_ROOT'].'/config_terms.php';
		require_once $_SERVER['DOCUMENT_ROOT'].'/includes/logic.php';
		require_once $_SERVER['DOCUMENT_ROOT'].'/includes/cache.php';
		require_once $_SERVER['DOCUMENT_ROOT'].'/includes/sessionhandler.php';

		
		function ammend_data($data)
		{
			$new_data = array();
			for ($i=0;$i<sizeof($data);$i++)
			{
				if ($data[$i]['refid'] != $_SESSION['user']['uid'])
				{
					$new_data[] = logic_get_user_by_id($data[$i]['refid']);
				}
			}
			return $new_data;
		}
		
		
		function logic_get_users_nearby()
		{
			$home = get_geolocation($_SESSION['user']['uid'], 'home');
			$work = get_geolocation($_SESSION['user']['uid'], 'work');
			
			return array(
				"home" => ammend_data(logic_get_geodata($home['lat'], $home['lng'], 'private')),
				"work" => ammend_data(logic_get_geodata($work['lat'], $work['lng'], 'private'))
			);
		}
		
		session_start();
		if (logic_is_member())
		{
			if ($_SESSION['user']['username']=='kaae')
			{
				$data = array(
					"mail" => logic_get_mail(), 
					"profile_view" => logic_get_user_tracker($_SESSION['user']['uid']), "ts" => date("Y-m-d H:i:s"),
					"geo" => logic_get_users_nearby()
				);
			}
			else
			{
				$data = array("mail" => logic_get_mail(), "profile_view" => "", "ts" => date("Y-m-d H:i:s"));
			}
			echo json_encode($data);
		}
		die();
	}
?>


function webnotify_get_last_index()
{
	var idx = localStorage.getItem('webnotify_index');
	
	
	if (idx)
	{
		return idx;
	}
	else
	{
		return 0;
	}
}

function webnotify_update_last_index(idx)
{
	localStorage.setItem('webnotify_index', idx);
}


function webnotify_process_profile_view(data)
{
	if (data && data.profile_view.length>0)
	{
		var old_view = sessionStorage.getItem('webnotify_profileviews');
		if (!old_view) 
		{
			old_view = [];
			for (var i=0; i<data.profile_view.length; ++i)
			{
				old_view.push(data.profile_view[i].uid);
			}
		}
		else
		{
			old_view = $.parseJSON(old_view);
		}
		
		for (var i=0; i<data.profile_view.length; ++i)
		{
			var item = data.profile_view[i];
			var notify = true;
			for (var j=0; j<old_view.length; ++j)
			{
				if (old_view[j] == item.uid) 
				{
					notify=false;
					break;
				}
			}
			
			if (notify)
			{
				old_view.push(item.uid);
				var notification_title = item.profile_firstname + ' ' + item.profile_lastname + ' har netop besøgt din profil';
				var notification_body = item.company_position+ ', '+item.company_name;
				var notification_icon = "/uploads/user_image/?uid="+item.uid+"&quad&s="+128;
				var n = new Notification(notification_title, { body: notification_body, icon: notification_icon, requireInteraction:true, data:item });
				n.onclick = function(e)
				{
					document.location.href = '/?uid='+e.target.data.uid;
				};
				
			}
		}
		sessionStorage.setItem('webnotify_profileviews',JSON.stringify(old_view));
	
	}
}

function webnotify_process_mail(data)
{
	if (data && data.mail.length>0)
	{
	
		var idx = webnotify_get_last_index();
		
		if (idx == 0)
		{
			idx = data[0].id - 1;
		}
		
		for (var i=0; i<data.mail.length; ++i)
		{
			var item = data.mail[i];
			
			if (item.id > idx)
			{
			
				if (item.SenderUID)
				{
					var notification_title = item.SenderFirstname + ' ' + item.SenderLastname + ': ' + item.mail_subject;
					var notification_body = item.mail_content;
					var notification_icon = "/uploads/user_image/?uid="+item.SenderUID+"&quad&s="+128;
					var n = new Notification(notification_title, { body: notification_body, icon: notification_icon, requireInteraction:true, data:item });
					n.onclick = function(e)
					{
						document.location.href = '/?uid='+e.target.data.SenderUID;
					};
				}
				else
				{
					var notification_title = item.mail_subject;
					var notification_body = item.mail_content;
					var notification_icon = "/img/RT_Logo.png";
					var n = new Notification(notification_title, { body: notification_body, icon: notification_icon, requireInteraction:true, data:item });
				}
				
				
				
				
				webnotify_update_last_index(item.id);
			}
		}
		
		
	}
}

function webnotify_process_geo(data)
{
	
	if (data.geo && data.geo.work && data.geo.home)
	{
		console.log(data.geo);
		var old_geo = sessionStorage.getItem('webnotify_geo');
		if (!old_geo)
		{
			old_geo = [];
			
			for (var i=0; i<data.geo.work.length; ++i)
			{
				old_geo.push(data.geo.work[i].uid);
			}

			for (var i=0; i<data.geo.home.length; ++i)
			{
				old_geo.push(data.geo.home[i].uid);
			}
		}
		else
		{
			old_geo = $.parseJSON(sessionStorage.getItem('webnotify_geo'));
		}
		
		for (var i=0; i<data.geo.work.length; ++i)
		{
			var item = data.geo.work[i];
			var notify = true;
			for (var j=0; j<old_geo.length; ++j)
			{
				if (old_geo[j] == item.uid)
				{
					notify = false;
					break;
				}
			}
			
			if (notify)
			{
				old_geo.push(item.uid);
				var notification_title = item.profile_firstname + ' ' + item.profile_lastname + ' er i nærheden af dit arbejde';
				var notification_body = item.company_position+ ', '+item.company_name;
				var notification_icon = "/uploads/user_image/?uid="+item.uid+"&quad&s="+128;
				var n = new Notification(notification_title, { body: notification_body, icon: notification_icon, requireInteraction:true, data:item });
				n.onclick = function(e)
				{
					document.location.href = '/?uid='+e.target.data.uid;
				};
			}
		}
		
		for (var i=0; i<data.geo.home.length; ++i)
		{
			var item = data.geo.home[i];
			var notify = true;
			for (var j=0; j<old_geo.length; ++j)
			{
				if (old_geo[j] == item.uid)
				{
					notify = false;
					break;
				}
			}
			
			if (notify)
			{
				old_geo.push(item.uid);
				var notification_title = item.profile_firstname + ' ' + item.profile_lastname + ' er i nærheden af din bopæl';
				var notification_body = item.company_position+ ', '+item.company_name;
				var notification_icon = "/uploads/user_image/?uid="+item.uid+"&quad&s="+128;
				var n = new Notification(notification_title, { body: notification_body, icon: notification_icon, requireInteraction:true, data:item });
				n.onclick = function(e)
				{
					document.location.href = '/?uid='+e.target.data.uid;
				};
			}
		}

		
		
		sessionStorage.setItem('webnotify_geo',JSON.stringify(old_geo));
		
		
	}
	
}


function webnotify_fetch_data()
{
	$.ajax({url:'/scripts/rtd/webnotify.js.php?ajax'}).done(function(json_data)
	{
		try
		{
			var data = $.parseJSON(json_data);
			webnotify_process_profile_view(data);
			webnotify_process_mail(data);
			webnotify_process_geo(data);
		}
		catch(e)
		{
			console.log(e);
			console.log(json_data);
		}
		
		

		
	});
}

if(window.Notification) 
{
	Notification.requestPermission(function(status) 
	{ 
		window.setInterval(webnotify_fetch_data, 5000);
	});
}
else 
{
	console.log("notifications not supported");
}