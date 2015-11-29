<?
	$terms = array(
	  'organisation_fullname' => 'Round Table CHANGE THIS',
	  'organisation_shortname' => 'CHANGE THIS',
	'rtidatahub_js' => '
			{ 
				var nationalboard_json = "%%NATIONALBOARD%%";
				var meeting_json = "%%MEETING%%";
				var table_json = "%%TABLE%%";
				
				var nationalboard = $.parseJSON(nationalboard_json);
				var meeting = $.parseJSON(meeting_json);
				var tables = $.parseJSON(table_json);
				
				
				document.write("<div id=tabs><ul><li><a href=#rti_nb>National board</a></li><li><a href=#rti_tab>Clubs</a></li><li><a href=#rti_meeting>Meetings</a></li></ul>");

				document.write("<div id=rti_nb>"+nationalboard+"</div>");
				document.write("<div id=rti_tab>"+tables+"</div>");
				document.write("<div id=rti_meeting>"+meeting+"</div>");
				
				
				document.write("</div>");
				
				
				$( "#tabs" ).tabs();
				
				
				
//				document.write(tables);
				
				/*
				$.each( meeting, function( key, value ) {
					document.write("<h1>"+value.TITLE+" ("+value.ST+")</h1>"+"<p>"+value.LOC+", "+value.TABLENAME+", "+value.ORG+"</p>");
				});*/ 
				 
				
				console.log(nationalboard);
				console.log(meeting);
				console.log(table_json);
			}
	',
	'club_message_title' => 'Message for %%name%%',
	'club_message_body' =>
'%%message%%
---
From %%sender%%
',
	'club_message_prepare_send_club_admin' => '
		<h1>Send message to the clubs members</h1>
		<form action=?cid=%%cid%% method=post >
		<center>
		<textarea name=message style="width:99%;height:200px"></textarea>
		</center>
		<input type=checkbox value=sms name=sms>Send as text message 
		<input type=submit value="Send message"> 
		</form>
	',
	'club_message_prepare_send' => '
		<h1>Send message to the clubs members</h1>
		<form action=?cid=%%cid%% method=post >
		<center>
		<textarea name=message style="width:99%;height:200px"></textarea>
		</center>
		<input type=submit value="Send message">
		</form>
	',
	'club_message_sent' => '
		<h1>Message sent</h1>
		<i>%%message%%</i>
	',
	'club_gallery' => '
		<h1>Gallery</h1>
		<a name=gallery><div style="height: 330px; overflow: scroll; overflow-x: hidden;" id=gallery></div><br></a>
		<img width=100% src="/template/images/logo.png" id=gallery_pic>
		<script>
			var gallery_data = jQuery.parseJSON(\'%%data%%\');
			var gallery_html = "";
			$.each(gallery_data, function(i,v) {
				gallery_html = gallery_html + "<a href=#gallery onclick=gallery_show("+v.miid+")><img width=25% src=/uploads/meeting_image/?miid="+v.miid+"&quad&s=200 title=\'"+v.title+" ("+v.start_time+")\'></a>";
			});
			$("#gallery").append(gallery_html);
			
			function gallery_show(miid)
			{
				$("#gallery_pic").attr("src", "/uploads/meeting_image/?miid="+miid);
			}
			
		</script>
	
	',//http://rtd.dk/uploads/user_image?uid=9353&quad&s=200
	'banner_1' => "<!-- CHANGE THIS -->",
	'banner_2' => "<!-- CHANGE THIS -->",
	'banner_3' => "<!-- CHANGE THIS -->",
	'not_club_board_submission_period' => '<h1>Unable to nominate clubs board</h1><p>Club board nominations is open between April 1st - June 30th</p>',
	'birthday_js' => '
	{
	var birthday_data = jQuery.parseJSON(\'%%data%%\');
	$("#birthdaymembers").show();
	$("<h1>Dagens fødselarer</h1>").insertBefore("#birthdaymembers");
	var c = 0;
	var html = "";
	html += "<center><table width=100% class=clickable><tr>";
	$.each(birthday_data, function(i,m) {
		
		if (m.profile_image!=null && m.profile_image!="")
		{
			html += "<td valign=top width=100><a href=?uid="+m.uid+" title=\'"+m.profile_birthdate+"\'><img src=/uploads/user_image?uid="+m.uid+"&landscape&w=100&h=150><br>"+m.profile_firstname+" "+m.profile_lastname+"</a></td>";		
			c++;
		}
		if (c==5) 
		{
			c=0;
			html += "</tr><tr>";
		}
	});
		html += "</tr></table></center>";
		$("#birthdaymembers").append(html);
	}
	',
	
	'report_club_jubilee_header' => '<h1>Club anniversaries</h1>',
	'report_club_jubilee_year' => '<h2>%%year%% year</h2>',
	'report_club_jubilee_club' => '
		<li>
			%%club%%, %%district%%, charter %%charter_date%% by %%charter_club%%
		</li>
	',
	'report_member_jubilee_header' => '<h1>Member anniversaries</h1>',
	'report_member_jubilee_year' => '<h2>%%year%% year</h2>',
	'report_member_jubilee_member' => '
		<li>%%profile_firstname%% %%profile_lastname%%,
		charter %%profile_started%%,
		%%district%%, %%club%%</li>
	',
  'create_other_meeting' => '
  <h1>Create unofficial meeting</h1>
  <p>Note: Will not count in statistics and invitations will be sent immediately after creation.</p>
  <hr>
  <form action=?omid=-1 method=post>
  <table border=0 cellspacing=0 cellpadding=5>
  <tr>
    <td valign=top>
    Title:<br>
    <input class=field type=text name=data[title]><br>
    Location:<br>
    <input class=field type=text name=data[location]><br>
    </td>
    <td valign=top>
    Start:<br>
    <input class=field type=text name=data[start_time] value="" id=start_time><br>
    End:<br>
    <input class=field type=text name=data[end_time] value="" id=end_time><br>
    </td>
  </tr>
  </table>
  Invitation:<br>
  <textarea class=ckeditor name=data[description]></textarea><br>
  <input type=submit value=Create>
  </form>
  <script>
												$(function() {
													$("#start_time").datetimepicker({dateFormat:"yy-mm-dd",timeFormat:"HH:mm:ss"});
													$("#end_time").datetimepicker({dateFormat:"yy-mm-dd",timeFormat:"HH:mm:ss"});
												});
  </script>
  ',
	'reports' => '<h1>Reports</h1>
	<p>Member reports</p>
	<ul>
		<li><a href=?reports&f=networker>Networking data</a>
		<li><a href=?reports&f=post>Mail reports (members and honorary members)</a>
		<li><a href=?reports&f=memberstat>Member statistics</a>
		<li><a href=?reports&f=clubs>Club data</a>
		<li><a href=?reports&f=members>Member report</a>
		<li><a href=?reports&f=jubilees>Anniversaries</a>
		<li><a href=?reports&f=rti>Report for white book (RTI)</a>
		<li><a href=?admin_download=roleprint>Report of active roles</a>
		<li><a href=?admin_download=futureroleprint>Report of future roles</a>
	</ul>
	',
	"user_viewed" => '
	<h1>Others who viewed this profile</h1>
	<div id=peek></div>
	<script>
		var peekers = jQuery.parseJSON(\'%%data%%\');
		var peekhtml = "<table><tr>";
		$.each(peekers, function(i,m) {
		 peekhtml += "<td valign=top><center><a href=?uid="+m.uid+"><img src=/uploads/user_image?uid="+m.uid+"&landscape&w=100&h=166><br>"+m.profile_firstname+" "+m.profile_lastname+"<br></a></center></td>";
		});
		peekhtml += "</tr></table>";
		$("#peek").append(peekhtml);
	</script>
	',
	"admin_sysstat" => '
	<h1>Time</h1>
	Server time: %%time%%
	<h1>Error</h1>
	<div style="height: 330px; overflow: scroll; overflow-x: hidden;">
	%%syslog%%
	</div>
	<h1>Mail queue</h1>
	<button onclick="document.location.href=\'?admin_download=sysstat&clear_mail_queue=true\';">Empty queue</button>
	%%mailqueuesize%%
	%%mailqueue%%
	<h1>Mail history</h1>
	<div style="height: 330px; overflow: scroll; overflow-x: hidden;">
	%%mailsent%%
	</div>
	<h1>Cronjob</h1>
	%%log%%
	<h1>Popular pages</h1>
	%%popularpages%%
	<h1>Popular searches</h1>
	%%popularsearch%%
	',
	'randomuser_js' => '
	
	document.write("<div class=box id=leftbox><h3>Tabler</h3><a href=?uid=%%uid%%><br><center><table width=180px ><tr><td width=50px>");
	document.write("<img src=/uploads/user_image?uid=%%uid%%&landscape&w=50&h=84></td><td>");
	document.write("%%profile_firstname%% %%profile_lastname%%<br>");
	document.write("%%company_position%%, ");
	document.write("%%company_name%%");
	document.write("</td></tr></table></center></a></div>");
	',
	'user_on_leave_subj' => 'On leave from CHANGE THIS - %%profile_firstname%% %%profile_lastname%%',
	'user_on_leave_body' => 'As of today %%profile_firstname%% %%profile_lastname%% is on leave.',
	'users_missing_email_subj' => '%%name%% - has invalid email',
	'update_clubmail' => 'ONLY VALID FOR ROUND TABLE DENMARK',
	'district_calendar_show' =>
	'<p><a href="?cal=%%name%%">Show in calendar</a></p>',
	'calendar_map' => '
	<h1>Calendar %%title%%</h1>
	Date:
	<select id=e onchange=show_date(this.value);></select>
	<div id=map-canvas></div>
	<div id=locmap></div>
	 <script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAcfr95hzse9yjWMC_TX-WSJY9IxOp3C2o&sensor=true">
    </script>

	  <script>
		var mapOptions = {
			zoom: 8,
			center: new google.maps.LatLng(-34.397, 150.644),
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		var map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);



		var date_map = new Array();
		var map_events = jQuery.parseJSON(\'%%data%%\');
		$.each(map_events, function(i,m) {
			if (!date_map[m.date]) 
			{
				$("#e").append("<option value=\'"+m.date+"\'>"+m.date+"</option>");
				date_map[m.date]=new Array();
			}
			date_map[m.date].push(m);
		});

		function show_date(when)
		{
			$("#locmap").html("");
			for (i=0; i<date_map[when].length; i++)
			{
				$("#locmap").append("<li>"+date_map[when][i].title);
			}
		}
		
		function locate(what)
		{
			if (what=="") return;
			var url = "/scripts/rtd/geocodeproxy.php?address=="+what+"&sensor=false";
			
			$.ajax( url ).done(function(data) 
			{ 
				var result = jQuery.parseJSON(data);
				var lat = -1;
				var lng = -1;
				var found=false;
				$.each(result.results, function(k,v) {
					lat = v.geometry.location.lat;
					lng = v.geometry.location.lng;
					found=true;
				});
				if (!found) 
				{
					$("#locmap").html("<i>Unable to locate address. Be more specific.</i>");
				}
				else {
					var img = "http://maps.googleapis.com/maps/api/staticmap?center="+what+"&zoom=11&size=255x255&maptype=roadmap&markers=color:blue|label:O|"+lat+","+lng+"&sensor=false";
					var url = "https://maps.google.dk/?q="+what;
					$("#locmap").html("<a href=\""+url+"\" target=_blank><img src=\""+img+"\"/></a>");
				}
			});																										
		}

		</script>
	',
	'calendar' =>
	"
		<h1>Calendar %%title%%</h1>
		<link rel='stylesheet' type='text/css' href='/scripts/fullcalendar/fullcalendar/fullcalendar.css' />
		<script type='text/javascript' src='/scripts/fullcalendar/fullcalendar/fullcalendar.js'></script>		
		%%colors%%
		<table width=100%>
		<tr>
		<td align=left><input type=button id=prev value=Previous></td>
		<td align=right><input type=button id=next value=Next></td>
		</tr>
		</table>
		<div id='calendar' style='width:580px'></div>
		<script>

    $('#calendar').fullCalendar({
			theme: true,
			header: {
				left: 'title'
			},
			eventSources : [
			%%events%%
			]
		});			
$('#next').click(function() {
    $('#calendar').fullCalendar('next');
});     
$('#prev').click(function() {
    $('#calendar').fullCalendar('prev');
});		</script>
	",
	'edit_club_secretary'=>
	'
	<h1>Edit %%name%% - Secretary</h1>
	<form action=?cid=%%cid%% method=post enctype="multipart/form-data"> 
		<table>
		<tr><td>
		<p>Meeting place<br>
		<input type=text name=edit[meeting_place] value="%%meeting_place%%"></p>
		</td><td>
		<p>Meeting time<br>
		<input type=text name=edit[meeting_time] value="%%meeting_time%%"></p>
		</td></tr>
		<tr><td>
		<p>Ex-table password<br>
		<input type=text name=edit[mummy_password] value="%%mummy_password%%"></p>
		</td><td>
		<p>Webmail password<br>
		<input type=text name=edit[webmail_password] value="%%webmail_password%%"></p>
		</td></tr>
		<tr><td colspan=2>
		<p>Description<br>
		<textarea class=ckeditor name=edit[description]>%%description%%</textarea></p>
		</td></tr>
		<tr>
			<td><p>Website<br>
			<input type=text name=edit[webpage] value="%%webpage%%">
			</td>
		</tr>
		<tr><td>
		<p>Logo<br>
		<input type=file name=logo></p>
		</td><td>
		<img src=/uploads/club_logos/%%logo%% width=100px><br>
		</td></tr></table>
		<hr>
		<input type=submit value="Save">
	</form>
	',
	'edit_club_admin' =>
	'
	<h1>Edit %%name%% - Administrator</h1>
  <input type=button value="Permanently delete" onclick=confirm_delete_club(%%cid%%)>
  <script>
    function confirm_delete_club(cid)
    {
      if (confirm("Confirm deletion of club. All history will be erased."))
      {
        document.location.href="/?cid=%%cid%%&permanent_delete_club";
      }
    }
  </script>
  <h1>Data</h1>
	<form action=?cid=%%cid%% method=post enctype="multipart/form-data"> 
		<table>
		<tr><td colspan=2>
		<p>Club<br>
		<input type=text name=edit[name] value="%%name%%"></p>
		</td></tr>
		<tr><td>
		<p>Meeting location<br>
		<input type=text name=edit[meeting_place] value="%%meeting_place%%"></p>
		</td><td>
		<p>Meeting time<br>
		<input type=text name=edit[meeting_time] value="%%meeting_time%%"></p>
		</td></tr>
		<tr><td>
		<p>Charter date<br>
		<input type=text name=edit[charter_date] value="%%charter_date%%"></p>
		</td><td>
		<p>Charter club ID<br>
			<select name=edit[charter_club_cid] id=charter_club></select>
	<!--	<input type=text name=edit[charter_club_cid] value="%%charter_club_cid%%">
	-->
	</p>
		</td></tr>
		<tr><td>
		<p>Area ID<br>
		<input type=text name=edit[district_did] value="%%district_did%%"></p>
		</td>
		</tr>
		<tr><td>
		<p>Ex-table generic password<br>
		<input type=text name=edit[mummy_password] value="%%mummy_password%%"></p>
		</td><td>
		<p>Webmail password<br>
		<input type=text name=edit[webmail_password] value="%%webmail_password%%"></p>
		</td></tr>
		<tr><td colspan=2>
		<p>Description<br>
		<textarea class=ckeditor name=edit[description]>%%description%%</textarea></p>
		</td></tr>
		<tr>
			<td><p>Webpage<br>
			<input type=text name=edit[webpage] value="%%webpage%%">
			</td>
		</tr>
		<tr><td>
		<p>Logo<br>
		<input type=file name=logo></p>
		</td><td>
		<img src=/uploads/club_logos/%%logo%% width=100px><br>
		</td></tr></table>
		<hr>
		<input type=submit value="Save">
	</form>
  <script>
    var all_clubs = jQuery.parseJSON(\'%%all_clubs%%\');
    $.each(all_clubs, function(i,c) 
	{
		if (c.cid == "%%charter_club_cid%%")
		{
			$("#charter_club").append("<option value="+c.cid+" selected>"+c.name+"</option>");
		}
		else
		{
			$("#charter_club").append("<option value="+c.cid+" >"+c.name+"</option>");
		}
    });
  </script>
	',
	'unread_mail_notify' => '
  <script>
	if (confirm("You have new club mail waiting (%%Unread%%). Check?"))
	{
		document.location.href="http://webmail.wannafind.dk/";
	}
  </script>
  ',
  'unable_to_open_mailbox' => "<script>alert('Club mail password mismatch. Please fix.');</script>",
  'new_club_board_subj' => 'Next board: %%name%%',
  'new_club_board_body' => '%%name%% has nominated the future board. All roles are assigned.',
  'role_nomination_subj' => 'Nomination for %%role%%: %%profile_firstname%% %%profile_lastname%%',
  'role_nomination_body' => "
    %%profile_firstname%% %%profile_lastname%% is as of today nominated for  %%role%% with following reason:\n
    %%comment%%
	
	Profile: http://CHANGE THIS/?uid=%%uid%%
	Club: http://CHANGE THIS/?cid=%%cid%%
  ",
	'resignation_nominated' => '<script>alert("Resignation received.\nNational secretary must now approve.\nTake direct contact if this does not happen in due time.");document.location.href="/";</script>',
	'resignation_approved' => '<script>alert("Resignation executed. Message has been sent.");document.location.href="/";</script>',
	'resign_nominate_subj' => 'Resignation of %%profile_firstname%% %%profile_lastname%%',
	'resign_nominate_body' => 
	"Resignation of %%profile_firstname%% %%profile_lastname%% from %%name%%\n\n
	Motivation:\n\n%%why%%\n\nApproval link: http://CHANGE THIS/?uid=%%uid%%&resign=%%why_url%%&approve\n\n
	If National secretary is unable to approve, he must contact the chairman or secretary from %%name%% see http://CHANGE THIS/?cid=%%cid%%
	"
	,
	"user_should_see_news" =>
	'
	<script>
		if (confirm("There are new bulletins - see them?"))
		{
			document.location.href="?news=%%nid%%";
		}
	</script>
	',
	"news_item_show" => '
	<h1>%%title%%</h1>
	<p><i>%%posted%%</i></p>
	%%content%%
	',
  'news_archive' =>
  '<h1>News archive</h1>
  <ul id=newsitems></ul>
  <script>
    var newsitems = jQuery.parseJSON(\'%%data%%\');
    $.each(newsitems, function(i,n) {
      $("#newsitems").append("<li><a href=?news="+n.nid+">"+n.title+", "+n.posted+"</a>");
    });
  </script>
  ',
	'news_item_comment' => '
	<h1>Discussion</h1>
  <form action=?news method=post>
  <input type=hidden name=news id=nid>
  <textarea style="width:99%" name=comment placeholder="Your comment"></textarea>
  <input type=submit value="Save"> <i>You will receive an email when new comments are added</i>
  </form>
	<table id=comment width=100%></table>
	
	<script>
		var nc = jQuery.parseJSON(\'%%data%%\');
		var html = "";
		$("#nid").val(nc.nid);
		$.each(nc, function(i,c) {
      if (i!="nid")
      {
		html = 
		"<tr><td colspan=2><hr></td></tr>"+
		"<tr>"+
				"<td width=100px><img src=/uploads/user_image?uid="+c.uid+"&landscape&w=100&h=166></td>"+
				"<td valign=top>"+
				"<a href=?uid="+c.uid+">"+c.user.profile_firstname+" "+c.user.profile_lastname+"</a>, "+c.posted+"</p>"+
				c.content+
				"</td>"+
				"</tr>" + html;
		/*
		  	$("#comment").append("<tr>"+
				"<td width=100px><img src=/uploads/user_image?uid="+c.uid+"&landscape&w=100&h=166></td>"+
				"<td valign=top>"+
				"<a href=?uid="+c.uid+">"+c.user.profile_firstname+" "+c.user.profile_lastname+"</a>, "+c.posted+"</p>"+
				c.content+
				"</td>"+
				"</tr>"
				);
				*/
				/*
		  		c.content+
		  		"<p><a href=?uid="+c.uid+">"+c.user.profile_firstname+" "+c.user.profile_lastname+"</a>, "+c.posted+"</p><hr>"
		  	);
			*/
      }
		});
		$("#comment").append(html);
	</script>
	',
	'beta_latestnews_js' => '
		var news_data = jQuery.parseJSON(\'%%data%%\');
		$("#news").append("<h1>Nyhed - "+news_data.title+"</h1>");
		$("#news").append("<p><i>Skrevet "+news_data.posted+"</i></p>");
		$("#news").append(news_data.content);
		$("#news").append("<a href=?news="+news_data.nid+">Read more</a>");
		
		$.each(news_data.country.minutes, function(i,m) {
			if (m.images != null)
			{
				$("#news").append("<h1>"+m.name+": "+m.title+"</h1>");
				$("#news").append(m.images[0].miid);
			}
		});
		
	',
	'latestnews_js' => '
		function latestnewsjs()
		{
			var news_data_json = jQuery.parseJSON(\'%%data%%\');
			var first = true;
			var html  = "";
//			$("#news").append();
			
			$.each(news_data_json, function(i,news_data) {
				html = html + "<a href=?news="+news_data.nid+"><h1>"+news_data.title+" ("+news_data.count+" comments)</h1></a>" + news_data.content;
			});
			html = html + "<h1>Nyhedsarkiv</h1><p><ul><li><a href=?news>Visit news archive</a></ul></p>";
			$("#news").append(html);
		}
		latestnewsjs();
	',
  'mobile_search_page' => 
  '
  <form action=/m data-ajax=false>
  <h2>Søgeord</h2>
  		<div data-role="fieldcontain" class="ui-hide-label">
      <label for="search">Search:</label>
  		<input type="search" placeholder="Search" name="search" id="search" value="" data-mini=true />
  		</div>	
  <div id=results>
  <h2>Results</h2>
  <div data-role="collapsible-set" data-theme="c" data-content-theme="d">
      <div data-role="collapsible">
          <h3>Members (<span id=member_count></span>)</h3>
          
          <ul data-role="listview" data-inset="true" id="members">
          </ul>
      </div>
      <div data-role="collapsible">
          <h3>Meetings (<span id=meeting_count></span>)</h3>
        	<ul data-role="listview" data-inset="true" data-filter="false" id="meetings">
          </ul>
      </div>
      <div data-role="collapsible">
          <h3>Clubs (<span id=club_count></span>)</h3>
        	<ul data-role="listview" data-inset="true" data-filter="false" id="clubs">
          </ul>
      </div>
  </div>
  </div>
  </form>
  <script>
    var data = jQuery.parseJSON(\'%%data%%\');
    var cc = 0;
    var mc = 0;
    var meetc = 0;
    $("#search").attr("placeholder",data.keyword);
    if (data.keyword=="") $("#results").hide();
    $.each(data.users, function(a,u) {
      mc++;
      $("#members").append("<li><a data-rel=dialog rel=external href=?uid="+u.uid+"><img src=/uploads/user_image?uid="+u.uid+"&landscape&w=100&h=150><h3>"+u.profile_firstname+" "+u.profile_lastname+"</h3><p>"+u.club+"</p></a></ul>");
    });
    $.each(data.meetings, function(a,m) {
      meetc++;
     $("#meetings").append("<li><a data-rel=dialog href=?mid="+m.mid+"><h3>"+m.title+"</h3><p>"+m.start_time+"</p><p>"+m.name+"</p></a></li>");
    });
    $.each(data.clubs, function(a,c) {
      cc++;
      $("#clubs").append("<li><a data-ajax=false href=?cid="+c.cid+">"+c.name+"</a></li>");
    });
    $("#meeting_count").append(meetc);
    $("#member_count").append(mc);
    $("#club_count").append(cc);
  </script>
  ',
  'mobile_user_page' =>
  '    
    <ul id=data data-role="listview" data-theme="a" data-divider-theme="d">
      <li data-role="list-divider">
        <h2 id=name></h2>
        <p id=company></p>
        <p id=position></p>
      </li>
      <li id=mobil></li>
      <li id=email></li>
      <li id=address></li>
	  <li id=vcard></li>
      <li id=club></li>
    </ul>
    <script>                
      var data = jQuery.parseJSON(\'%%data%%\');
	  $("#vcard").append("<a href=?vcard&uid="+data.uid+" rel=external>Download contact</a>");
      $("#club").append("<a href=?cid="+data.club.cid+"><h3>"+data.club.name+"</h3></a>");
      $("#name").append(data.profile_firstname+" "+data.profile_lastname);
      $("#pic").attr("src","/uploads/user_image?uid="+data.uid+"&landscape&w=300&h=500");
      $("#company").append(data.company_name);
      $("#position").append(data.company_position);
      $("#mobil").append("<a title=Call href=\'tel:"+data.private_mobile+"\'><h3>Mobil privat</h3><p>"+data.private_mobile+"</p></a>");
      $("#email").append("<a title=Mail href=\'mailto:"+data.private_email+"\'><h3>Mail privat</h3><p>"+data.private_email+"</p></a>");
      var road = data.private_address+" "+data.private_houseno+data.private_houseletter+" "+data.private_housefloor+data.private_houseplacement;
      var city = data.private_zipno+" "+data.private_city;
      $("#address").append("<a href=\'http://maps.google.com?q="+road+","+city+"\' title=Map><h3>Home</h3><p>"+road+"<br>"+city+"</p></a>");
    </script>
  ',
  'mobile_club_page' => '
	<div data-role="collapsible"  data-theme="a" data-content-theme="a">
  <h3>Meetings</h3>
  <p>
	<ul data-role="listview" data-inset="true" data-filter="false" id="meetings">
  </ul>
  </p>
	</div>

	<div data-role="collapsible"  data-theme="a" data-content-theme="a">
	<h3>Contact</h3>
	<p>
	<a href=# id=mailclubmembers data-role="button">Mail members</a>
	<a href=# id=mailclub data-role="button">Mail club</a>
	</p>
	</div>
	<div data-role="collapsible"  data-theme="a" data-content-theme="a">
	<h3>Members</h3>
	<p>
	  <ul data-theme="a" data-role="listview" data-inset="true" data-filter="true" id="members">
	  </ul>
	  </p>
  </div>
  <script>
    var data = jQuery.parseJSON(\'%%data%%\');
	var mails = "";
    $.each(data.members, function(a,u) {
      $("#members").append("<li><a data-rel=dialog rel=external href=?uid="+u.uid+"><img src=/uploads/user_image?uid="+u.uid+"&landscape&w=100&h=150><h3>"+u.profile_firstname+" "+u.profile_lastname+"</h3><p>"+u.roles+"</p></a></ul>");
	  mails += ","+u.private_email;
    });
	mails = mails.substring(1);
	$("#mailclubmembers").attr("href","mailto:"+mails);
	$("#mailclub").attr("href","mailto:"+data.clubmail);
    $.each(data.meetings, function(a,m) {
     $("#meetings").append("<li><a data-rel=dialog href=?mid="+m.mid+"><h3>"+m.title+"</h3><p>"+m.start_time+"</p></a></li>");
    });
    
  </script>
  ',
  'mobile_title_front' => 'Whole organization',
  'mobile_meeting_accept' => '
  <h1>Sign up</h1>
  <h2>%%title%%</h2>
  <p>You have now been signed up and the club has been informed.</p>
  ',
  'mobile_meeting_reject_no_comment' => '
  <h1>Resign meeting</h1>
  <h2>%%title%%</h2>
  <p>You have not entered a reason for resigning the meeting.</p>
  ',
  'mobile_meeting_reject' => '
  <h1>Resign meeting</h1>
  <h2>%%title%%</h2>
  <p>You have now resigned the meeting and the club has been informed.</p>
  ',
  'mobile_meeting'=>'
    <h1>%%title%%</h1>
    <h2>%%name%%</h2>

    <ul data-role="listview" data-theme="d" data-divider-theme="d" id=members%%mid%%>
    <li data-role="list-divider">%%start_time%% - %%end_time%%</li>
    <li><a href="http://maps.google.com?q=%%location%%">
      <p>%%location%%</p>
      <p>%%meeting_description%%</p></a>
    </li>
    
	<li data-role="list-divider">Sign up</li>
		<li>
		<form action=/m method=get id=submit%%mid%%>
		<input type=hidden name=mid value=%%mid%%>
		<div data-role="fieldcontain">
			<fieldset data-role="controlgroup">
				<legend>Comment:</legend>
				<input type="text" name="attend[comment]" id="text-%%mid%%" class="custom" />
			</fieldset>
			<fieldset data-role="controlgroup">
				<legend>Sign up:</legend>
				<input type="checkbox" name="attend[accept]" id="checkbox-%%mid%%" onclick="$(\'#submit%%mid%%\').submit();" class="custom" />
				<label for="checkbox-%%mid%%">Signed up</label>
			</fieldset>
		</div>
		</li>
		</form>
	</li>

    <li data-role="list-divider"><h3>Attendees (<span id=count%%mid%%></span>)</h3></li>

    </ul>
    
    <script>    	
    		var count%%mid%%=0;

			function attend_toggle(mid)
			{
				var box = "#checkbox-%%mid%%";
				if (!$(box).is(":checked"))
				{
					var p = prompt("Please state reason for resigning the meeting:","");
					if (p && p !="")
					{
						var data = new Array();
						data["mid"] = %%mid%%;
						data["reject"] = p;
						$.mobile.changePage( "/m?mid=%%mid%%&reject="+p , {
							data: p,
							type: "post"
						});
					}
					else
					{
						$(box).attr("checked",true);
						$(box).checkboxradio("refresh");
					}
				}
				else
				{
						var data = new Array();
						data["mid"] = %%mid%%;
						data["accept"] = true;
						$.mobile.changePage( "/m?mid=%%mid%%&accept" , {
							data: p,
							type: "post"
						});

/*						$.mobile.changePage( "/m?mid=%%mid%%&accept", {
						transition: "pop",
						reverse: false,
						reloadPage: true,
						changeHash: false,
						role: ""
					});*/
				}
			}
			
			
	    	$.each(jQuery.parseJSON(\'%%attendance%%\'), function(a,u) {
	    	
	    		if (u.accepted==1) {
					if (%%uid%% == u.uid)
					{					
						 $("#checkbox-%%mid%%").attr("checked",true); 
					}
	    			count%%mid%%++;
	    			$("#members%%mid%%").append("<li data-icon=check><a data-rel=dialog href=?uid="+u.uid+"><img src=/uploads/user_image?uid="+u.uid+"&landscape&w=100&h=150><h3>"+u.profile_firstname+" "+u.profile_lastname+"</h3><p>"+u.name+"</p></a></ul>");
	    		}
	    		else $("#members%%mid%%").append("<li data-icon=minus><a data-rel=dialog href=?uid="+u.uid+"><img src=/uploads/user_image?uid="+u.uid+"&landscape&w=100&h=150><h3>"+u.profile_firstname+" "+u.profile_lastname+"</h3><p>"+u.name+"</p><p style=\'color:red\'>"+u.comment+"</p></a></ul>");
	    	});
	    	$("#count%%mid%%").append(count%%mid%%);
    </script>
  ',
  'mobile_district_page' => '
  <h2>Future meetings</h2>
	<ul data-theme="a" data-role="listview" data-inset="true" data-filter="false" id="future_meetings">
  </ul>
  <h2>Clubs</h2>
	<ul data-theme="a" data-role="listview" data-inset="true" data-filter="false" id="clubs">
  </ul>
  <script>
    var data  = jQuery.parseJSON(\'%%data%%\');
    $.each(data.clubs, function(a,c) {
      $("#clubs").append("<li><a data-ajax=false href=?cid="+c.cid+">"+c.name+"</a></li>");
    });
    $.each(data.meetings, function(a,m) {
     $("#future_meetings").append("<li><a data-rel=dialog href=?mid="+m.mid+"><h3>"+m.title+"</h3><p>"+m.start_time+"</p><p>"+m.name+"</p></a></li>");
    });
  </script>  
  ',
  'mobile_front_page' => '
  <h2>Future meetings</h2>
	<ul data-theme="a" data-role="listview" data-inset="true" data-filter="false" id="future_meetings">
  </ul>
  <h2>Areas</h2>
  <ul data-theme="a" data-role="listview" data-inset="true" data-filter="false" id="districts">
  </ul>  
  <script>
    var front_data = jQuery.parseJSON(\'%%data%%\');
    $.each(front_data.districts, function(a,d) {
      $("#districts").append("<li><a data-ajax=false href=?did="+d.did+"><h3>"+d.name+"</h3><p>"+d.description+"</p></a></li>");
    });
    
    $.each(front_data.meetings, function(a,m) {
     $("#future_meetings").append("<li><a data-rel=dialog href=?mid="+m.mid+"><h3>"+m.title+"</h3><p>"+m.start_time+"</p><p>"+m.name+"</p></a></li>");
    });
  </script>
  ',
  'mobile_latest_users' => 
  '
    <h2>Who is online?</h2>
		<ul data-theme="a" data-role="listview" data-inset="true" data-filter="false" id="club_page_contact">
    </ul>
	<script>
		var online_users = jQuery.parseJSON(\'%%data%%\');
		$.each(online_users, function(a,u) {
      $("#club_page_contact").append("<li><a data-rel=dialog href=?uid="+u.uid+"><img src=/uploads/user_image?uid="+u.uid+"&landscape&w=100&h=150><h3>"+u.profile_firstname+" "+u.profile_lastname+"</h3><p>"+u.club+"</p><p>Last update: "+u.last_page_view+"</p></a></ul>");
    });
  </script>
  
      ',
	  'mobile_download_page' =>
	  '<h1>Downloads</h1>
		  <ul data-theme="a" data-role="listview" data-inset="true" data-filter="false" id="dl">
		  </ul>  
	<script>
		var d = jQuery.parseJSON(\'%%data%%\');
		$.each(d, function(d,f) {
		$("#dl").append("<li><a rel=external href=\""+f.url+"\">"+f.name+"</a></li>");
    });
  </script>
	  
	  ',
  'mobile_title_member' => '
  <h1>%%TITLE%%</h1>
<a href="?logoff" data-role="button" data-icon="delete" class="ui-btn-right">Log af</a>
  ',
  'mobile_title_not_member' => '<h1>%%TITLE%%</h1>',
  'mobile_login' => '
	<p>This webapp is only for members. Enter credentials to continue.</p>
	<form class="ui-body ui-body-a ui-corner-all" method=post action="?login&redirect=%%REQUEST_URI%%" data-ajax="false" >
		<div data-role="fieldcontain" class="ui-hide-label">
			<label for="username">Login:</label>
			<input type="text" name="username" id="login_mail" value="" placeholder="Email or username"/>
		</div>
		<div data-role="fieldcontain" class="ui-hide-label">
			<label for="password">Password:</label>
			<input type="password" name="password" id="login_pass" value="" placeholder="password"/>
		</div>
		<button type="submit" data-theme="b" name="login_submit" value="" id="login_submit">Login</button>	
	</form>
  ',
  'mobile_menu_not_member' => '',
  'mobile_menu_member' => '
    <div data-role="navbar">
    	<ul>
    	<li><a data-ajax=false href="/m" data-role="button" data-icon="home" >Home</a></li>
    	<li><a href="http://CHANGE THIS" target=_blank rel="external" data-role="button" data-icon="forward">Desktop</a></li>
    	<li><a data-ajax=false href="/m?search" data-role="button" data-icon="search">Search</a></li>
    	<li><a data-ajax=false href="/m?download" data-role="button" data-icon="star">Downloads</a></li>
    </ul>
    </div>
  ',
  'mobile_page_title' => 'CHANGE THIS App',
	'stats' => '<h1>Statistics</h1>
			<div id="tabs">
		    <ul>
		    		<li><a href="#tabs-1" id=clubtitle>Overview</a></li>
		        <li><a href="#tabs-2" id=usrtitle>Anniversary</a></li>
		        <li><a href="#tabs-3" id=arttitle>Ratings</a></li>
		        <li><a href="#tabs-4" id=mtgtitle>News</a></li>
		    </ul>
		    <div id="tabs-1">
					<div id=overview>
						<table>
						<tr>
							<td>Members today</td>
							<td id=memberstoday></td>
						</tr>
						<tr>
							<td>
								Honorary members today
							<td id=honormembers></td>
						</tr>
						<tr>
						<td>
							Members as of July 1st this year
							<td id=membersyearstart></td>
						</tr>
						<tr>
						<td>
							Members as of July 1st next year
							<td id=membersyearend></td>
						</tr>
						<tr>
						<td>
							New members this year
							<td id=newmembers></td>
						</tr>
						<tr>
						<td>
							Exits this year
							<td id=exits></td>
						</tr>
						<tr>
						<td>
							Members exiting due to age limit as of June 30th
							<td id=exitduetoage></td>
						</tr>
						<tr>
						<td>
							Number of clubs
							<td id=clubs></td>
						</tr>
						<tr>
						<td>
						Average number of members per club
							<td id=avgclub></td>
						</tr>
						<tr>
						<td>
						Average age
							<td id=avgall></td>
						</tr>
						<tr>
						<td>
						Average age for new members
							<td id=avgnew></td>
						</tr>
						</table>
					</div>
		    </div>
		    <div id="tabs-2">
					<div id=usrres>
							<p><b id=jubilee_header>This year</b></p>
							<p><input id=nextyear type=button value="Next club year" onclick="document.location.href=\'?stats&modify=1\'">
							<input id=curryear type=button value="This club year" onclick="document.location.href=\'?stats&modify=0\'"></p>
							<p><select onchange=build(this.value);> <!-- CHANGE THIS TO FIT AREAS -->
								<option value="">Whole organization</option>
								<option value="Area 1">Area 1</option>
								<option value="Area 2">Area 2</option>
								<option value="Area 3">Area 3</option>
								<option value="Area 4">Area 4</option>
								<option value="Area 5">Area 5</option>
								<option value="Area 6">Area 6</option>
								<option value="Area 7">Area 7</option>
								<option value="Area 8">Area 8</option>
							</select></p>
							<a href=#cj>Show club anniversaries</a> | 
							<a href=#mj>Show member anniversaries</a>
							<hr>
							<a name=cj><p><b>Club anniversaries</b></p></a>
							<ul><div id=clubjubilees></div></ul>
							<hr>
							<a name=mj><p><b>Member anniversaries</b></p></a>
							<ul><div id=jubilees></div></ul>
					</div>
		    </div>
		    <div id="tabs-3">
					<b>Meeting rating</b>
					<p>Best rated clubs:</p>
					<ol id=clubrate></ol>
					<p>Best rated meeting:</p>
					<ol id=meetrate></ol>
		    </div>
		    <div id="tabs-4">
				<div id=notmsg></div>
			</div>
		</div>
		
	<script>
		var data = jQuery.parseJSON(\'%%data%%\');		
		$.each(data.notifications, function(cat,catdata) {
			if (catdata.length>0)
			{
				switch(cat)
				{
					case "aid" : $("#notmsg").append("<b>Articles</b><br>"); break;
					case "mid" : $("#notmsg").append("<b>Meetings</b><br>"); break;
					case "nid" : $("#notmsg").append("<b>News</b><br>"); break;
					case "ts" : $("#notmsg").append("<b>Tabler Service</b><br>"); break;
					case "uid" : $("#notmsg").append("<b>New members</b><br>"); break;
				};
				$("#notmsg").append("<ul>");
				$.each(catdata, function(i,e) {
					$("#notmsg").append("<li><a href=?"+cat+"="+e.id+">"+e.title+", "+e.ts);
				});
				$("#notmsg").append("</ul><br><br>");
			}
		});
		
		if (data.modify>0) 
		{
			$("#nextyear").hide();
			$("#jubilee_header").html("Next club year");
		}
		else
		{
			$("#curryear").hide();
		}
		
		
		
		$.each(data.meetings.best_club, function(i, c) {
			$("#clubrate").append("<li><a href=?cid="+c.cid+" target=_blank>"+c.data.name+"</a><br>Votes: "+c.count+"<br> Average: "+c.average+"</li>");
		});
		
		$.each(data.meetings.best_meeting, function(i, m) {
			$("#meetrate").append("<li><a href=?mid="+m.mid+" target=_blank>"+m.club.name+"<br> "+m.data.title+"</a><br>Votes: "+m.count+"<br> Average: "+m.average+"</li>");
		});
		
		
		function build_club(filter)
		{
			$("#clubjubilees").empty();
			$.each(data.club_jubilees, function(year, d) {
				$("#clubjubilees").append("<p><b>"+year+" years anniversary</b></p><p><ul>");
				$.each(d, function(foo, c) {
					if (filter=="" || filter==c.district)
					{
						$("#clubjubilees").append("<ul><p><a href=?cid="+c.cid+"><b>"+c.club+"</b></a><br>"+c.district+", Charter: "+c.charter_date+", Charter club: "+c.charter_club+"</p></ul>");
					}
				});
				$("#clubjubilees").append("</ul></p>");
			});
		}
		function build_member(filter)
		{
			$("#jubilees").empty();
			$.each(data.jubilees, function(year,d) {
				$("#jubilees").append("<p><b>"+year+" years anniversary</b></p><p><ul>");
				$.each(d, function(foo,m) {
					if (filter=="" || filter==m.district)
					{
						$("#jubilees").append("<ul><p><a href=?uid="+m.uid+">"+m.profile_firstname+" "+m.profile_lastname+"</a><br> "+m.club+", "+m.district+"<br>Charter "+m.profile_started+"</a><br><br></p></ul>");
					}
				});
				$("#jubilees").append("</ul></p>");
			});
		}
		
		function build(w)
		{
			build_club(w);
			build_member(w);
		}
		
		$("#memberstoday").append(data.details.member_count_today);
		$("#honormembers").append(data.details.honour_count_today);
		$("#membersyearstart").append(data.details.member_count_year_start);
		$("#membersyearend").append(data.details.member_count_year_end);
		$("#newmembers").append(data.details.new_member_count);
		$("#exits").append(data.details.exit_count_today);
		$("#exitduetoage").append(data.details.normal_exit_count);
		$("#clubs").append(data.details.club_count_today);
		$("#avgclub").append(data.details.club_avg_member_count);
		$("#avgall").append(data.details.member_avg_age);
		$("#avgnew").append(data.details.new_member_avg_age);
		build("");
		$( "#tabs" ).tabs();
	</script>
	',
	'admin_newsletter_sent' => '<h1>Send newsletter</h1><p>News letter sent to %%count%%.</p>',
	'newsletter_default_content' => 
	"\n\n---\n%%profile_firstname%% %%profile_lastname%%, %%national_board_member%%\n\n",
	
	'admin_newsletter_form' => '
	<h1>Send news letter<span id=who></span></h1>
	<form action=?admin_download=newsletter method=post enctype="multipart/form-data" onsubmit="return verify();">
	<input type=hidden name=newsletter value=send>
	<p><input type=checkbox name=testmail> Send testmail to you</p>
  <p id="sender">Sender UID:<br>
  <input type=text name=sender_uid value="%%uid%%" id=uid disabled></p>
	<p>Subject:<br>
	<input type=text name=title value="%%title%%"></p>
	<p>Message:<br>
	<textarea name=content style="width:98%;height:300px;">%%content%%</textarea></p>
	<h1>Attach</h1>
  <p>Vælg vedhæftet fil<br><input type="file" name="file" id="file"></p>
  <h1>To</h1>
	<p>Tick of who should receive the newsletter. First choose areas then roles.</p>
	<b>Roles</b>
	<ul>
		Club roles<br>
		<!-- CHANGE THIS -->
		<input type=checkbox onclick=c(this); name=roles[] value=6 id=M disabled>Medlem
		<input type=checkbox onclick=c(this); name=roles[] value=9 id=F disabled>F
		<input type=checkbox onclick=c(this); name=roles[] value=10 id=S disabled>S
		<input type=checkbox onclick=c(this); name=roles[] value=11 id=I disabled>I
		<input type=checkbox onclick=c(this); name=roles[] value=12 id=K disabled>K
		<input type=checkbox onclick=c(this); name=roles[] value=17 id=IRO disabled>IRO
		<input type=checkbox onclick=c(this); name=roles[] value=26 id=HM disabled>ÆM
		<input type=checkbox onclick=c(this); name=roles[] value=13 id=N disabled>N<br>
		<br>National board<br>
		<input type=checkbox onclick=c(this); name=roles[] value=14 id=DF disabled>DF
		<input type=checkbox onclick=c(this); name=roles[] value=15 id=LF disabled>LF
		<input type=checkbox onclick=c(this); name=roles[] value=16 id=VLF disabled>VLF
		<input type=checkbox onclick=c(this); name=roles[] value=19 id=NIRO disabled>NIRO
		<input type=checkbox onclick=c(this); name=roles[] value=36 id=ALF disabled>ALF<br>
		<br>Executive members<br>
		<input type=checkbox onclick=c(this); name=roles[] value=21 id=LS disabled>LS
		<input type=checkbox onclick=c(this); name=roles[] value=22 id=WEB disabled>WEB
		<input type=checkbox onclick=c(this); name=roles[] value=23 id=LK disabled>LK
		<input type=checkbox onclick=c(this); name=roles[] value=24 id=RED disabled>RED
		<input type=checkbox onclick=c(this); name=roles[] value=25 id=SHOP disabled>SHOP
		<input type=checkbox onclick=c(this); name=roles[] value=37 id=LA disabled>LA		
	</ul>
	<b>Areas</b>
	<ul>
		<!-- CHANGE THIS -->
		<input type=checkbox onclick=cd(this); name=districts[] value=14 id=D1 disabled>Distrikt 1 - Nordjylland<br>
		<input type=checkbox onclick=cd(this); name=districts[] value=15 id=D2 disabled>Distrikt 2 - Vestjylland<br>
		<input type=checkbox onclick=cd(this); name=districts[] value=16 id=D3 disabled>Distrikt 3 - Østjylland<br>
		<input type=checkbox onclick=cd(this); name=districts[] value=17 id=D4 disabled>Distrikt 4 - Syd- og Sønderjylland<br>
		<input type=checkbox onclick=cd(this); name=districts[] value=18 id=D5 disabled>Distrikt 5 - Trekantsområdet og Fyn<br>
		<input type=checkbox onclick=cd(this); name=districts[] value=19 id=D6 disabled>Distrikt 6 - Nordsjælland<br>
		<input type=checkbox onclick=cd(this); name=districts[] value=20 id=D7 disabled>Distrikt 7 - Sydsjælland og Lolland-Falster<br>
		<input type=checkbox onclick=cd(this); name=districts[] value=21 id=D8 disabled>Distrikt 8 - København, Bornholm og Grønland<br>
	</ul>
	<script>
	var role_count = 0;
	var district_count = 0;
	var r = "%%role%%";
	var d = "%%district%%";

	function verify()
	{
	 return true;
	}	
  
	
	$("#who").append("%%role%% %%district%%");
  
	function c(w) { if (w.checked) role_count--; else role_count++; }
	function cd(w) { if (w.checked) district_count--; else district_count++; }
	function enable(v) { $(v).removeAttr("disabled"); }

		enable("#M");
		enable("#F");
		enable("#S");
		enable("#I");
		enable("#K");
		enable("#IRO");
		enable("#HM");
		enable("#N");
		enable("#DF");
		enable("#LF");
		enable("#VLF");
		enable("#NIRO");
		enable("#ALF");
		enable("#LS");
		enable("#WEB");
		enable("#LK");
		enable("#RED");
		enable("#SHOP");
		enable("#LA");
		
		enable("#D1");
		enable("#D2");
		enable("#D3");
		enable("#D4");
		enable("#D5");
		enable("#D6");
		enable("#D7");
		enable("#D8");
	
	</script>
	<h1>Send</h1>
	<input type=submit value="Send newsletter">
	</form>
	',
	'mummy_login' =>'
	<h1>Ex-table login</h1>
	<form action=?mummy method=post>
	<p>Club (eg. RT132)<br><input type=text name=club></p>
	<p>Password<br><input type=password name=password></p>
	<input type=submit value="Login">
	</form>
	',
	
	'latestmembers_js' => '
		$("#latestmembers").append("<h1>Latest members</h1><div id=members></div>");
		var data = jQuery.parseJSON(\'%%data%%\');
		var c = 0;
		var html = "";
		html += "<center><table width=100%><tr>";
		$.each(data, function(i,m) {
			
						
			html += "<td valign=top width=100><a href=?uid="+m.uid+"><img src=/uploads/user_image?uid="+m.uid+"&landscape&w=100&h=150><br>"+m.profile_firstname+" "+m.profile_lastname+"<br>"+m.company_position.substring(0,16)+"</a></td>";
			
			c++;
			if (c==5) 
			{
				c=0;
				html += "</tr><tr>";
			}
		});
			html += "</tr></table></center>";
		$("#members").append(html);
	',
	'meeting_deleted' => 
	'<h1>Error</h1><p>The meeting you have tried to open has been deleted.</p>',
	'addthis' =>
	'
	',
	'national_board' =>
	'<!-- CHANGE THIS -->
	<a name=hb><h1>National board</h1></a>
	<table align=center width=400>
	<tr>
		<td id=lf></td>
		<td id=vlf></td>
	</tr>
	<tr><td colspan=2><hr></td></tr>
	<tr>
		<td id=iro></td>
		<td id=blank></td>
	</table>
	<a name=df><h1>Area chairmen</h1></a>
	<table align=center width=400>
	<tr>
		<td id=df1 valign=top></td>
		<td id=df2 valign=top></td>
	</tr>
	<tr><td colspan=2><hr></td></tr>
	<tr>
		<td id=df3 valign=top></td>
		<td id=df4 valign=top></td>
	</tr>
	<tr><td colspan=2><hr></td></tr>
	<tr>
		<td id=df5 valign=top></td>
		<td id=df6 valign=top></td>
	</tr>
	<tr><td colspan=2><hr></td></tr>
	<tr>
		<td id=df7 valign=top></td>
		<td id=df8 valign=top></td>
	</tr>
	</table>
	<a name=ex><h1>Executive comittee</h1></a>
	<table align=center width=400>
	<tr>
		<td id=ls valign=top></td>
		<td id=lk valign=top></td>
	</tr>
	<tr><td colspan=2><hr></td></tr>
	<tr>
		<td id=shop valign=top></td>
		<td id=web valign=top></td>
	</tr>
	<tr><td colspan=2><hr></td></tr>
	<tr>
		<td id=red valign=top></td>
		
	</tr>
	</table>
	<a name=others><h1>Others</h1></a>
	<table align=center width=300>
	<tr>
		<td id=alf></td>
		<td id=la></td>
	</tr>
	</table>
	<script>
		var data = jQuery.parseJSON(\'%%data%%\');
		
		function makehtml(v)
		{
			if (v)
			{
				var html = "";
				html += "<a href=?uid="+v.uid+" title=\""+v.role+": "+v.profile_firstname+" "+v.profile_lastname+"\"><img src=/uploads/user_image?uid="+v.uid+"&landscape&w=200&h=333><br>";
				html += "<b>"+v.role+"</b><br>";
				html += v.profile_firstname+" "+v.profile_lastname+"<br>";
				html += v.district+", ";
				html += v.club+"<br></a>";
				return html;
			}
			else
			{
				return "<i>Not found</i>";
			}
		}
		
		$("#lf").append(makehtml(data.LF));
		$("#vlf").append(makehtml(data.VLF));
		$("#iro").append(makehtml(data.NIRO));
		$("#df1").append(makehtml(data.DF1));
		$("#df2").append(makehtml(data.DF2));
		$("#df3").append(makehtml(data.DF3));
		$("#df4").append(makehtml(data.DF4));
		$("#df5").append(makehtml(data.DF5));
		$("#df6").append(makehtml(data.DF6));
		$("#df7").append(makehtml(data.DF7));
		$("#df8").append(makehtml(data.DF8));
		$("#lk").append(makehtml(data.LK));
		$("#ls").append(makehtml(data.LS));
		$("#shop").append(makehtml(data.SHOP));
		$("#web").append(makehtml(data.WEB));
		$("#red").append(makehtml(data.RED));
		$("#la").append(makehtml(data.LA));
		$("#alf").append(makehtml(data.ALF));
	</script>
	',
	'tabler_service' => '
	<h1>Tablerservice</h1>
	<p>Tablerservice is an internal forum for sharing ideas.</p>
	<p id=data></p>
	<form id=newentry method=post action=?ts><h1>Create entry</h1>
	<table width=100%>
	<tr><td width=50% valign=top>
	<b>Title</b><br><input type=text name=item[headline]><br>
	<b>Location</b><br><input type=text name=item[location]><br>
	</td><td valign=top>
	<b>Price</b><br><input id=price type=text name=item[price] onkeyup=><br>
	<b>Duration</b><br><input type=text name=item[duration]><br>
	<b>Contact</b><br><input type=text name=item[contact]><br>
	</td></tr></table>
	<b>Text</b><br>
	<textarea name=item[description] class=ckeditor></textarea>
	<input type=submit value=Save>
	</form>
	<script>		
		var data = jQuery.parseJSON(\'%%data%%\');
		
		function delitem(i)
		{
			if (confirm("Confirm deletion"))
			{
				document.location.href="?ts="+data.category.tsid+"&delete="+i;
			}
		}
		
		if (data.category)
		{
			$("#newentry").get(0).setAttribute("action", "?ts="+data.category.tsid);
			$("#data").append("<a href=?ts>Back</a><h1>"+data.category.headline+"</h1><div id=items></div>");
			$.each(data.items, function(i,item) {
				if(item.may_edit) { $("#items").append("<p><a href=# onclick=delitem("+item.tid+");>Delete</a></p>"); }
				$("#items").append("<p><b>"+item.headline+"</b></p><p>Location: "+item.location+"</p><p>Contact: "+item.contact+"</p><p>Price: "+item.price+"</p><p>Duration: "+item.duration+"</p>");
				$("#items").append("<ul>"+item.description+"</ul><hr>");
			});
		}
		else
		{
			$("#newentry").hide();
			$("#data").append("<h1>Categories</h1><ul id=categories>");
			$.each(data.categories, function(i,cat) {
				$("#categories").append("<li><a href=?ts="+cat.tsid+">"+cat.headline+"</a>");
			});
			$("#data").append("</ul>");
		}
	</script>
	',
	'user_should_update_details' =>
	'
	<script>
	if (confirm("Hi %%profile_firstname%% %%profile_lastname%%\nIt has been a while since you last updated your proflie. \nClick OK to do it now"))
	{
		document.location.href="/?uid=%%uid%%&edit";
	}
	</script>
	',
	'dashboard' => '
	<!--[if lt IE 9]><script language="javascript" type="text/javascript" src="/scripts/jqplot/excanvas.js"></script><![endif]-->
	<script type="text/javascript" src="/scripts/jqplot/jquery.jqplot.min.js"></script> 
	<script type="text/javascript" src="/scripts/jqplot/plugins/jqplot.barRenderer.min.js"></script>
	<script type="text/javascript" src="/scripts/jqplot/plugins/jqplot.categoryAxisRenderer.min.js"></script>
	<script type="text/javascript" src="/scripts/jqplot/plugins/jqplot.canvasAxisTickRenderer.min.js"></script>
	<script type="text/javascript" src="/scripts/jqplot/plugins/jqplot.canvasTextRenderer.min.js"></script>

	<h1 id=dashboard>Dashboard: </h1>
	<table width=100%><tr><td id=dashboardintro valign=top></td><td valign=top id=dashboardlogo></td></tr></table>
	<div id=download></div>
	<h1>Statistics</h1>
	
	<div id="memberstatchart" style="height:300px; width:100%;"></div>

	<table id=memberstat width=100%>
	<tr><th>Year</th><th>Members (start)</th><th>Members (end)</th><th>New</th><th>Exits</th><th>Diff</th></tr>
	</table>
	
	<h1>Meeting statistics</h1>
	<div id="meetstatchart" style="height:300px; width:100%;"></div>
	<p id=meetingcount>Home meetings: </p>
	<table id=meetingstat width=100%>
	<tr><th>Name</th><th>This year</th><th>Last year</th></tr>
	</table>
  <h1>Turn up per meeting</h1>
  <table id=meeting_details width=100%></table>
  <h1>Turn up per member</h1>
  <div id=details></div>
  <link rel="stylesheet" type="text/css" href="/scripts/jqplot/jquery.jqplot.min.css" />

	<script>
	var data = jQuery.parseJSON(\'%%data%%\');

	var memberstat_data_start = [];
	var memberstat_data_exit = [];
	var memberstat_data_new = [];
	var memberstat_data_ticks = [];
	
	var meetstat_data_ticks = [];
	var meetstat_data_current = [];

	
	$("#dashboard").append(data.club.name);
		$("#dashboardintro").append(data.club.description);
		$("#dashboardlogo").append("<img border=1 width=100% src=\"/uploads/club_logos/"+data.club.logo+"\">");
		$("#download").append("<a href=?dashboard="+data.club.cid+"&download>Show in table view</a>");
		var i = 0;
		$.each(data.club_stats, function(y,d) {
			memberstat_data_ticks.push(y.substring(0,4));
			memberstat_data_start.push(d.start);
			memberstat_data_exit.push(d.exit);
			memberstat_data_new.push(d.newmembers);
			i++;
			$("#memberstat").append("<tr><td align=center>"+y+"</td><td align=center>"+d.start+"</td><td align=center>"+d.end+"</td><td  align=center>"+d.newmembers+"</td><td align=center>"+d.exit+"</td><td align=right>"+(d.end-d.start)+"</td></tr>");
		});
		
		var meeting_count = 0;
		$.each(data.members, function(m,d) {
			var attendance = 0;
			var old_attendance = 0;
			$.each(d.stats, function(a,b) {
				old_attendance = attendance;
				attendance = b.attendance;
				meeting_count = b.total;
			});
			meetstat_data_current.push([d.profile_firstname + " " + d.profile_lastname,attendance]);
			//meetstat_data_current.push(attendance);
			$("#meetingstat").append("<tr><td><a href=#"+d.uid+">"+d.profile_firstname+" "+d.profile_lastname+"</a></td><td>"+attendance+" %</td><td>"+old_attendance+" %</td></tr>");
      
      $("#details").append("<a name="+d.uid+"><p><a href=?uid="+d.uid+">"+d.profile_firstname+" "+d.profile_lastname+"</a></p></a><ul>")
      $.each(d.details, function(a,b) {
      	if ($("#"+b.mid).length==0)
      	{
      		$("#meeting_details").append("<tr><td valign=top><a name="+b.mid+"><a href=?mid="+b.mid+" target=_blank>"+b.title+"</a></a></td><td valign=top id="+b.mid+"></td></tr><tr><td colspan=2><hr></td></tr>");
      	}
      	$("#"+b.mid).append("<li><a href=#"+d.uid+">"+d.profile_firstname+"\n"+d.profile_lastname+"</a>");
        $("#details").append("<li><a target=_blank href=?mid="+b.mid+">"+b.start_time+": "+b.title+", "+b.club+"</a></li>")
      });
      
      $("#details").append("</ul>");
		});
		$("#meetingcount").append(meeting_count);
		
		// update graphs
		$(document).ready(function(){  
			$.jqplot("meetstatchart", [meetstat_data_current],
					{
						seriesDefaults : { renderer:$.jqplot.BarRenderer, pointLabels: { show: true } },
						axes: { xaxis: { renderer: $.jqplot.CategoryAxisRenderer,tickRenderer: $.jqplot.CanvasAxisTickRenderer ,        tickOptions: {          angle: -90        } }}
					}
					);
		
		   $.jqplot("memberstatchart", 
					[memberstat_data_start, memberstat_data_exit, memberstat_data_new],
					{
						axesDefaults: { pad: 2.0 },
						legend: { show: true },
						seriesDefault : {
							pointLabels: { show: true }
						},
						series: [{label:"Members"},{label:"Exit"},{label:"New"}],
						axes: { xaxis: { renderer: $.jqplot.CategoryAxisRenderer, ticks: memberstat_data_ticks }}
					}
					);
		}); 
		
	</script>
	',	
	'meeting_admin_unlock_minutes' =>
	'<h2>Sekretærværktøjer</h2><a href=?mid=%%mid%%&unlock>Unlock minutes of meeting</a>',
	'business_search' => '<h1>Business</h1>
	<p>
	Choose business:<br>
	<select id=biz name=biz onchange="biz(this.value);"></select><br>
	<div id=company_section>Company:<br>
	<select id=company name=company onchange="company(this.value)";></select></div>
	<div id=res></div>
	<script>
		var data = jQuery.parseJSON(\'%%data%%\');

		function biz(v)
		{
			document.location.href="?biz="+v;
		}
		
		function company(v)
		{
			document.location.href="?biz="+data.search+"#"+v;
		}
		
		$.each(data.businesses, function(k,v) {
			if (data.search == v.company_business)
			{
				$("#biz").append("<option selected value=\""+v.company_business+"\">"+v.company_business+"</option>");
			}
			else
			{
				$("#biz").append("<option value=\""+v.company_business+"\">"+v.company_business+"</option>");
			}
		});
		
		var res_html = "<table width=100%><tr>";
		var past = "pandekage";
		var cnt = 0;
		var companies = 0;
		$.each(data.results, function(k,v) {
			if (v.company_name.indexOf(past)==-1)
			{
				res_html += "</tr></table><a name=\""+v.company_name+"\"><h1>"+v.company_name+"</h1></a><table width=100%><tr>";
				past = v.company_name;
				$("#company").append("<option value=\""+v.company_name+"\">"+v.company_name+"</option>");
				cnt = -1;
			}
			
			if (cnt == 1)
			{
				res_html += "</tr><tr>";
				cnt = 0;
			}
			else cnt++;
			
			res_html += 
							 "<td width=100px><a href=?uid="+v.uid+"><img src=/uploads/user_image?uid="+v.uid+"&landscape&w=100&h=150></a></td>"
							 +"<td valign=top><a href=?uid="+v.uid+">"
							 +v.profile_firstname+" "+v.profile_lastname+"</a><br>"
							 +v.company_position+"<br>"
							 +v.company_address+", "+v.company_zipno+" "+v.company_city+"<br>"
							 +"Phone: "+v.company_phone+"<br>"
							 +"Mail: <a href=mailto:"+v.company_email+">"+v.company_email+"</a>"
							 
							 +"</td>"
							 ;
			companies++;
		});
		res_html += "</table>";
		$("#res").append(res_html);
		if (companies==0) $("#company_section").hide();
	</script>
	
	',
  'user_resign_subj' => 'Resignation in %%name%%',
  'user_resign_body' => 'It is hereby confirmed that  %%profile_firstname%% %%profile_lastname%% has been resigned as of today from %%name%%',
  'user_resign_nb_body' => "%%profile_firstname%% %%profile_lastname%% has been resigned as of today\n\nMotivation:\n\n%%why%%",
	'news_comment_subj' => 'New comment for: %%title%%',
	'news_comment_body' => 'Click here to see the comment: http://CHANGE THIS/?news=%%nid%%',
	'club_member_stat' => '
	<h1>Member statistics</h1>
	<table id=stat width=100%>
	<tr><th>Year</th><th>Members (start)</th><th>Members (end)</th><th>New</th><th>Exit</th><th>Diff</th></tr>
	</table>
	<script>
		var stats = jQuery.parseJSON(\'%%data%%\');
		$.each(stats, function(y,d) {
			$("#stat").append("<tr><td align=center>"+y+"</td><td align=center>"+d.start+"</td><td align=center>"+d.end+"</td><td  align=center>"+d.newmembers+"</td><td align=center>"+d.exit+"</td><td align=right>"+(d.end-d.start)+"</td></tr>");
		});
	</script>
	',
	'user_stats' =>
	'<h1>Meeting statistics</h1>
	<table id=stats width=100%>
	<tr><th>Year</th><th>Club meetings</th><th>Participation</th><th>Commando raid</th><th>Turn up</th></tr>
	</table>
	<script>
	var stats = jQuery.parseJSON(\'%%data%%\');
	$.each(stats, function(year,data) {
		$("#stats").append("<tr><td align=center>"+year+"</td><td align=center>"+data.total+"</td><td align=center>"+data.accepted+" ("+data.reject+")</td><td align=center>"+data.non_home_meeting+"</td><td align=center>"+data.attendance+" %</td></tr>");
	});
	</script>
	',
	'admin_new_boards' => '
	<h1>Future board - whole organization</h1>
	<div id=data></div>
	<script>
		var b=jQuery.parseJSON(\'%%data%%\');
		$.each(b, function(i,d) {
			$("#data").append("<h1>"+d.name+" - "+d.description+"</h1>");
			$.each(d.clubs, function(j,c) {
				$("#data").append("<p><a href=?cid="+c.cid+">"+c.name+"</a><ul id=c"+c.cid+"></ul>");
				$.each(c.board, function(k,m) {
					$("#c"+c.cid).append("<li><a target=_blank href=?uid="+m.uid+">"+m.rolename+": "+m.firstname+" "+m.lastname+"</a>");
				});
				$("#data").append("</p>");
			});
		});
	</script>
	',
	'new_club_board_submitted' => '
	<h1>New board nominated</h1>
	<p>Nomination received and persisted. </p>',
	'review_club_board' => '
	<h1>Future board</h1>
	<p>The following has been received from your club.</p>
	<ul id=board></ul>
	<script>
	var b=jQuery.parseJSON(\'%%data%%\');
	$.each(b, function(i,m) {
		$("#board").append("<li>"+m.rolename+": "+m.firstname+" "+m.lastname);
	});
	</script>
	',
	'new_club_board_link' => 'http://CHANGE THIS/?uid=%%uid%%',
	'new_club_board' => '
	<h1>Board %%period_start%% - %%period_end%%</h1>
	<p>Nominate future board.</p>
<p>
	<form action=?kbp method=post onsubmit="return validate_kbp(this);">
	<table id=board></table>
	<input type=submit value="Nominate board">
	</form>
	<script>
		var club_board_roles = jQuery.parseJSON(\'%%board_roles%%\');	             
		var new_board_selection = new Object();
		
		Object.size = function(obj) {
			var size=0,key;
			for(key in obj) {
				if (obj.hasOwnProperty(key)) size++;
			}
			return size;
		}
		
		function validate_kbp(frm)
		{
			var err = "";
			
			if (Object.size(new_board_selection) != club_board_roles.length)
			{
				alert("All roles must be filled");
				return false;
			}

			var old_board_count = 0;			
			$.each(club_board_roles, function(key,value) {
				if (value) 
				{
					// exclude iro
					if (key != 17) old_board_count++;			
				}
		  });
		  
		  if (old_board_count==0)
		  {
		  	err += "- Atleast one member must continue in the new board.\n";
		  }
		  
		  if (old_board_count>3)
		  {
		  	err += "- A maximum of 3 members can continue in the new board.\n";
		  }
		  
			// if (err != "") alert("Følgende punkter kræver dispensation fra LF:\n"+err);			
			
			return true;
		}
		
		function eval_item(cur_role,r,d,s)
		{
		}
		var members = jQuery.parseJSON(\'%%club_members%%\');
		
		var htmlstr = "";
		$.each(club_board_roles, function(key,value) {
			var membershtml = "";
			$.each(members, function(key,m) {		  
			membershtml = membershtml +"<input onclick=\'eval_item(\""+value.description+"\",\""+m.roles+"\",\""+m.profile_ended+"\",\""+m.profile_started+"\");\' type=radio value="+m.uid+" name=role["+value.rid+"]>"+m.profile_firstname+" "+m.profile_lastname+", Ud: "+m.profile_ended+"<br>";
		  });


			 $("#board").append("<tr><td valign=top><b>"+value.description+"</b></td><td>"+membershtml+"<hr></td></tr>");	    
	  });
	</script>
	
	',
	'move_user_nomination_done_subj' => 'Change of club executed for %%member_name%%',
	'move_user_nomination_done_body' => '
	It is hereby confirmed that %%member_name%% has moved from %%source_club_name%% to %%target_club_name%%.
	',
	'move_user_nomination_subj' => 'Request for change of club %%source_club_name%% -> %%target_club_name%%',
	'move_user_nomination_body' => "
	It is hereby requested that %%member_name%% is moved from %%source_club_name%% to %%target_club_name%%. Approve and execute on this link: http://CHANGE THIS/?approval&uid=%%member_uid%%&move=%%target_club_id%%\n
	Comment:\n\n
	
	%%comment%%

	",
	'move_user_nominated_done' =>
	'
		<h1>Move of %%profile_firstname%% %%profile_lastname%%</h1>
		<p>Move completed.</p>
	',
	
	'move_user_nominated' =>
	'
		<h1>Move of %%profile_firstname%% %%profile_lastname%%</h1>
		<p>Request received. National secretary must now approve.</p>		
	',
	'move_user_nominate' =>
	'
		<h1>Move of %%profile_firstname%% %%profile_lastname%%</h1>
		<form action=?uid=%%uid%% method=post onsubmit="return evaluate_move_member();">
		<p>
		To:
		<select id=clubs name=move></select>
		</p>
		<p>Comment:</p>
		<textarea style="width:98%;height:300px" name=comment id=comment></textarea>
		<p><input type=submit value="Move member"></p>		
		</form>
	  <script>
		var result = jQuery.parseJSON(\'%%clubs%%\');	             
		// alert(result);
		var htmlstr = "";
		$.each(result, function(key,value) {
			htmlstr = htmlstr+"<option value="+value.cid+">"+value.name+"</option>";
	    
	  });
	  $("#clubs").html(htmlstr);
	  
	  function evaluate_move_member()
	  {
	  	if (CKEDITOR.instances.comment.getData()=="") 
	  	{
	  		alert("Please enter a comment");
	  		return false;
	  	}
	  	return true;
	  }
	  </script>
		
	',
	'minutes_reminder_5days_subject' => 'Reminder: Remeber to create minutes for %%title%% (5 days)',
	'minutes_reminder_5days_text' => 'We are missing minutes of meeting for "%%title%%" held on %%start_time%% complete via: http://CHANGE THIS/?mid=%%mid%%',
	'minutes_reminder_14days_subject' => 'Reminder: Remember to create minutes for %%title%% (14 days)',
	'minutes_reminder_14days_text' => 'We are missing minutes of meeting for "%%title%%" held on %%start_time%% complete via: http://CHANGE THIS/?mid=%%mid%%',
	'minutes_reminder_19days_subject' => 'Reminder: Remember to create minutes for %%title%% (19 days)',
	'minutes_reminder_19days_text' => 'We are missing minutes of meeting for "%%title%%" held on %%start_time%% complete via: http://CHANGE THIS/?mid=%%mid%%',
	'minutes_completed_subject' => 'Minutes of meeting - %%name%%',
	'minutes_completed_content' => 'Minutes of meeting for "%%title%%" has been completed. Meeting held on %%start_time%%. Link: http://CHANGE THIS/?mid=%%mid%%',
  'district_chairman_post_news' =>
  '<h2>Create entry</h2>
  <form action=?country=%%did%% method=post id=dnews>
  Title:<br><input type=text name=news[title]><br>
  Content:<br>
  <textarea name=news[content] class=ckeditor></textarea><br>
  <input type=submit value="Save">
  </form>
  <hr>
  '    ,
  'district_clubs' => '<h2>Clubs</h2>',
  'district_chairman' => '
  <table cellspacing=5>
  <tr>
    <td valign=top><a href=?uid=%%uid%%><img src=/uploads/user_image?uid=%%uid%% width=100px></a></td>
    <td valign=top><b>Areas chairman</b><br>
    %%profile_firstname%% %%profile_lastname%%<br>
    Mobile: %%private_mobile%%<br>
    Mail: <a href=mailto:%%private_email%%>%%private_email%%</a><br>
    </td>
    <td valign=top width=50% style="border-left: 1px solid black;padding-left:5px;">
    <b>%%title%%</b><br>%%content%%<br>
    <i>%%posted%%</i>
    <div id=comments></div>
    <hr>
    <form action=?country=%%did%% method=post>
    <input type=hidden name=nid value=%%nid%%>
    <textarea style="width:100%" name=comment></textarea>
    <input type=submit value="Save">
    </form>
    </td>
  </tr>
  </table>
  <script>
  var c = jQuery.parseJSON(\'%%comments%%\');
	  $.each(c,function(k,v){
	  	$("#comments").append("<hr>"+v.content+"<br><br><i><a href=?uid="+v.user.uid+">"+v.user.profile_firstname+" "+v.user.profile_lastname+"</a>, "+v.posted+"</i>");
	  });
  </script>
  '     ,
  'minutes_collection' => '
  <h1>Minutes of meetings (%%seed%%)</h1>
<hr>
  <ul id=data></ul>
  <script>
  
	var result = jQuery.parseJSON(\'%%data%%\');
             
	$.each(result, function(key,value) {
    $("#data").append("<li><a href=?mid="+value.mid+" target=_blank>"+value.title+" "+value.start_time+", "+value.club+"</a>");    
  });
  </script>
  ',                                                                                     
	'banner_admin' => '
	<h1>Webbanners</h1>
	<ul id=banners>
	</ul>
	<script>
		var r = jQuery.parseJSON(\'%%data%%\');
		$.each(r,function(k,v){
			$("#banners").append("<li>"+v.title+": <a href=?banner&img="+v.bid+">Billede</a>");
		});
	</script>
	<h1>Tilføj</h1>
	<form method=post action=?banner enctype="multipart/form-data">	
	Beskrivelse: <input type=text name=upload[title]><br>
	Position: <select name=upload[position]><option value=1>1: Venstre</option><option value=2>2: Højre top</option><option value=3>3: Højre bund</option></select><br>
	Startdato: <input type=text name=upload[startdate] id=startdate><br>
	Slutdato: <input type=text name=upload[enddate] id=enddate><br>
	Billede: <input type=file name=file><br>
	<input type=submit value="Gem">	
	</form>
	<script>
		$(function() {
			$("#startdate").datepicker({dateFormat:"yy-mm-dd",changeYear: true});
			$("#enddate").datepicker({dateFormat:"yy-mm-dd",changeYear: true});
		});
	</script>
	',
  'meeting_attendance_notify_accept_subj' => 'Sign up for meeting: %%profile_firstname%% %%profile_lastname%%',
  'meeting_attendance_notify_decline_subj' => 'Resign from meeting: %%profile_firstname%% %%profile_lastname%%',
  'meeting_attendance_notify_accept_body' => '%%profile_firstname%% %%profile_lastname%% has signed up for %%title%% (%%start_time%%). %%comment%%.',
  'meeting_attendance_notify_decline_body' => '%%profile_firstname%% %%profile_lastname%% has resigned from %%title%% (%%start_time%%). %%comment%%.',  
  'new_user_welcome_mail_subject' => 'Welcome to CHANGE THIS',
  'new_user_welcome_mail_content' =>
  'Hi %%name%%
  
  Welcome to CHANGE THIS. You can use our websites using the following links:
  
  Link: http://CHANGE THIS
  Username: %%username%%
  Password: %%password%%
  Club: %%club%%          
  
  Link: http://m.rtd.dk
  Brugernavn: %%username%%
  Kodeord: %%password%%
  Klub: %%club%%

  Please make sure that the following information is correct:
  
  Birth date: %%profile_birthdate%%
  Charter date: %%profile_started%%
  ',
	'error_pre' => '<h1>Error</h1><p><ul>',
	'error_post' => '</ul></p>',
	'error_username_exists' => '<li>Username exists',
	'error_not_all_fields_filled_in' => '<li>All fields must be filled in',
	'new_password_sent' => '<script>alert("You will receive an email within 5-10 minutes");document.location.href="/";</script>',
	'error_user_not_found' => '<script>alert("Unknown username or email");document.location.href="/";</script>',
	'mail_new_password_subject' => 'Password',
	'mail_new_password_content' => 
'To login use the following information:

Username: %%username%% 
Password: %%password%%

',
	'search_results' =>
	'
		<h1>Search - %%search%%</h1>
		<div id="tabs">
		    <ul>
		        <li><a href="#tabs-1" id=usrtitle>Members</a></li>
		        <li><a href="#tabs-2" id=clubtitle>Clubs</a></li>
		        <li><a href="#tabs-3" id=arttitle>Articles</a></li>
		        <li><a href="#tabs-4" id=mtgtitle>Meetings</a></li>
		    </ul>
		    <div id="tabs-1">
					<b>Members</b>
					<p>
					<input type=button value="Search Ex-tablers" onclick="document.location.href=\'?search=%%search%%&old\';">
					</p>
					<div id=usrres></div>
		    </div>
		    <div id="tabs-2">
					<b>Clubs</b>
					<div id=clubres></div>
		    </div>
		    <div id="tabs-3">
					<b>Articles</b>
					<div id=artres></div>
		    </div>
		    <div id="tabs-4">
					<b>Meetings</b>
					<div id=mtgres></div>
		    </div>
		</div>
		
		<script>
			$(function() {
				
				var result = jQuery.parseJSON(\'%%result%%\');

				console.log(result.users);
				var count = 0;
				$.each(result.users, function(key,value) {
					count++;
					$("#usrres").append("<li><a href=?uid="+value.uid+">"+value.profile_firstname+" "+value.profile_lastname+", "+value.club+", Phone: "+value.private_phone+"</a>");
				});
				if (count==0) $("#usrres").append("<i>Nothing</i>");
				$("#usrtitle").append(" ("+count+")");
				
				var art_count = 0;
				$.each(result.articles, function(key,value) {
					art_count++;
					$("#artres").append("<li><a href=?aid="+value.aid+">"+value.title+"</a>");
				});
				if (art_count==0) $("#artres").append("<i>Nothing</i>");
				$("#arttitle").append(" ("+art_count+")");

				var club_count = 0;
				$.each(result.clubs, function(key,value) {
					club_count++;
					$("#clubres").append("<li><a href=?cid="+value.cid+">"+value.name+"</a>");
				});
				if (club_count==0) $("#clubres").append("<i>Nothing</i>");
				$("#clubtitle").append(" ("+club_count+")");

				var meeting_count = 0;
				$.each(result.meetings, function(key,value) {
					meeting_count++;
					$("#mtgres").append("<li><a href=?mid="+value.mid+">"+value.title+", "+value.start_time+", "+value.club+"</a>");
				});
				if (meeting_count==0) $("#mtgres").append("<i>Ingen match</i>");
				$("#mtgtitle").append(" ("+meeting_count+")");

				$( "#tabs" ).tabs();
        
        
        if (count==0) $("#tabs").tabs("select", "#tabs-2");
        if (club_count==0 && count==0) $("#tabs").tabs("select", "#tabs-3");
        if (count==0 && art_count==0 && club_count==0) $("#tabs").tabs("select", "#tabs-4");


			});
		
		</script>
	',
	'user_create_error' => '<p><font color=red>Error creating member</font></p>',
	'user_create' => '
		<h1>Create member</h1>
		<form action=?uid=-1 method=post onsubmit="return newuser(this);">
    <table width=100% border=0>
    <tr><td colspan=2><h1>Data</h1></td></tr>
    <tr><td valign=top>
  		<p>First name<br>
  		<input type=text name=data[profile_firstname] value="%%profile_firstname%%" id=firstname></p>
  		<p>Last name<br>
  		<input type=text name=data[profile_lastname] value="%%profile_lastname%%" id=lastname></p>
    </td><td valign=top>
  		<p>Birth date<br>
  		<input type=text name=data[profile_birthdate] value="%%profile_birthdate%%" id=birthdate></p>
  		<p>Charter date<br>
  		<input type=text name=data[profile_started] value="%%profile_started%%" id=charterdate></p>
    </td></tr>
    <tr><td colspan=2><h1>Contact</h1></td></tr>
    <tr><td valign=top>
		<p>Private address<br>
		<input id=vej type=text name=data[private_address] value="%%private_address%%"></p>
		<p>House no<br>
		<input id=nr type=text name=data[private_houseno] value="%%private_houseno%%"></p>
		<p>House letter<br>
		<input id=type=text name=data[private_houseletter] value="%%private_houseletter%% "></p>
		<p>Floor<br>
		<input type=text name=data[private_housefloor] value="%%private_housefloor%% "></p>
		<p>Side<br>
		<input type=text name=data[private_houseplacement] value="%%private_houseplacement%% "></p>
		<p>Postal code<br>
		<input type=text name=data[private_zipno] value="%%private_zipno%%"></p>
		<p>City<br>
		<input type=text name=data[private_city] value="%%private_city%%"></p>
    </td><td valign=top>
		<p>Phone<br>
		<input type=text name=data[private_phone] value="%%private_phone%%"></p>
		<p>Mobile<br>
		<input type=text name=data[private_mobile] value="%%private_mobile%%"></p>
		<p>Mail<br>
		<input type=text name=data[private_email] value="%%private_email%%" id=mail></p>
    </td></tr>
    </table>
    <hr>
		<input type=submit value=Save>
		</form>
		<script>
		
			$(function() {
				$("#charterdate").datepicker({dateFormat:"yy-mm-dd",changeYear: true});
				$("#birthdate").datepicker({dateFormat:"yy-mm-dd",changeYear: true,minDate:"-35Y"});
			});
			
			function newuser(frm)
			{
				for (var i=0; i<frm.elements.length; i++)
				{
				  if (frm.elements[i].value=="")
				  {
					alert("All fields must be filled!");
					return false;
				  }
				}
				var d1 = new Date($("#birthdate").val());
				var d2 = new Date();
				var d1Y = d1.getFullYear();
				var d2Y = d2.getFullYear();
				var d1M = d1.getMonth();
				var d2M = d2.getMonth();
				var diff = (d2M+12*d2Y)-(d1M+12*d1Y);
        return true;
			}
		</script>
	',
	'user_role_add' => '
  <h1>Delete permanently</h1>
  <input type=button onclick=confirm_delete(%%uid%%) value="Delete">
  <script>
    function confirm_delete(uid)
    {
      if (confirm("Confirm deletion."))
      {
        document.location.href="?uid=%%uid%%&permanent_delete";
      }
    }
  </script>
	<h1>Assign role</h1>
	<ul>
	<form action=?uid=%%uid%% method=post>
	<p>Role<br>
	
	<select name=newrole[rid] id=roles>	
	</select></p>
	<p>Start<br>
	<input type=text name=newrole[start_date] id=new_role_start></p>
	<p>End<br>
	<input type=text name=newrole[end_date] id=new_role_end></p>
	<input type=submit value="Save">
	</form>
	</ul>
		<script>
			$(function() {
				$("#new_role_start").datepicker({dateFormat:"yy-mm-dd",changeYear: true});
				$("#new_role_end").datepicker({dateFormat:"yy-mm-dd",changeYear: true});
				
				var roles = jQuery.parseJSON(\'%%roles_json%%\');
				var html = "";
				for (var i=0;i<roles.length;i++)
				{
					html += "<option value="+roles[i].rid+">"+roles[i].shortname+"</option>";
				}
				$("#roles").append(html);
			});
		</script>
	',
	'user_role_item_admin' => '<li>%%description%% (%%start_date_fixed%% - %%end_date_fixed%%)<br>
	<a href="javascript:if(confirm(\'End: %%description%%. Ok?\')){document.location.href=\'?uid=%%uid%%&end_role=%%riid%%\';}">End</a>
	<a href="javascript:if(confirm(\'Delete: %%description%%. Ok?\')){document.location.href=\'?uid=%%uid%%&delete_role=%%riid%%\';}">Delete</a>',
	'user_role_item' => '<li>%%description%% (%%start_date_fixed%% - %%end_date_fixed%%)',
	'user_role_pre' => '<h1>Roles</h1><p><ul>',
	'user_role_post' => '</ul></p>',
	'user_nominated_fail' => '<p>No access</p>',
	'user_nominated_ok' => '<p>Nomiation received</p>',
	'user_profile_edit_link' =>
	'<h1 onclick="$(\'#tools\').toggle();">Profile tools</h1>
	<p id=tools>
	<a href=?sendpassword=%%private_email%%>Reset password</a> |
	<a href=?uid=%%uid%%&edit>Edit profile</a> | 
	<a href=# onclick=ctoty(%%uid%%);>Club TOTY</a> |
	<a href=# onclick=honorary(%%uid%%);>Honorary member</a> |
	<a href=# onclick=onleave(%%uid%%);>Leave</a> |
  <a href=# onclick=resign(%%uid%%);>Resign</a> |
	<a href=?uid=%%uid%%&move>Move</a>
	<div id=onleave_dialog style="display:none">
		<p>Leave</p>
		<input type=button value="Confirm leave" onclick="document.location.href=\'?uid=%%uid%%&leave=true\';">
	</div>
  <div id=resign_dialog style="display:none;">
  <p>Member exit</p>
  <p>Comment for resigning %%profile_firstname%% %%profile_lastname%%</p>
  <input id=resign_text type=text name=resign_text><input type=button value="Resign" onclick=confirm_resignation();>
  </div>
  <div id=honorary_dialog style="display:none">
  <p>Honorary member</p>
  <p>Comment for nomiating %%profile_firstname%% %%profile_lastname%% as honorary member</p>
  <input id=honorary_text type=text name=honorary_text><input type=button value="Nominate" onclick=confirm_honorary();>
  </div>
	<script>
    function confirm_resignation()
    {
      var t = $("#resign_text").val();
      if (t=="") alert("Please add comment!");
      else document.location.href="?uid=%%uid%%&resign="+t; 
    }
    function resign(uid)
    {
      $("#resign_dialog").dialog({modal:true});
    }
    function confirm_honorary()
    {
      var t = $("#honorary_text").val();
      if (t=="") alert("Please add comment!");
      else document.location.href="?uid=%%uid%%&honorary="+t; 
    }
	
	function ctoty(uid)
	{
		if (confirm("Confirm nomination"))
		{
			document.location.href="?uid=%%uid%%&ctoty=%%uid%%"; 
		}
	}
	
	
	function onleave(uid)
	{
		$("#onleave_dialog").dialog({modal:true});
	}
		function honorary(uid)
		{
      $("#honorary_dialog").dialog({modal:true});
		}
		// $("#tools").hide();
	</script>
	</p>',
	'user_profile_edit_admin' =>
	'	<h1>Edit profile - administrator</h1>
		<form method=post action=?uid=%%uid%%&edit=save enctype="multipart/form-data">
		<p>Passworld<br>
		<i>Filling in password will change the password. Leaving it blank will keep the same password.</i><br>
		<input type=text name=password value="">
		</p>
		<p>Username<br>
		<input type=text name=data[username] value="%%username%%"></p>
		<p>Photo<br>
		<img src=/uploads/user_image?uid=%%uid%%&quad&s=200><br>
		Change: <input type=file name=profile_image>
		</p>
		</p>
		<p>First name<br>
		<input type=text name=data[profile_firstname] value="%%profile_firstname%%"></p>
		<p>Last name<br>
		<input type=text name=data[profile_lastname] value="%%profile_lastname%%"></p>
		<p>Birth date<br>
		<input type=text name=data[profile_birthdate] value="%%profile_birthdate%%" id=birthdate></p>
		<p>Charter date<br>
		<input type=text name=data[profile_started] value="%%profile_started%%" id=charterdate></p>
		<p><b>Exit date</b><br>
		<input type=text disabled value="%%profile_ended%%"></p>
		<p>Tekst<br>
		<textarea name=data[private_profile] class=ckeditor>%%private_profile%%</textarea></p>
		<p>Profile display<br>
		<select name=data[view_tracker] id=xtable>
			<option value=1>Yes, show who has seen my profile</option>			
			<option value=0>No, dont show who has seen my profile</option>
		</select><br>
		</p>
		
		<h2>Home</h2>
		<p>Address<br>
		<input type=text name=data[private_address] value="%%private_address%%"></p>
		<p>House no<br>
		<input type=text name=data[private_houseno] value="%%private_houseno%%"></p>
		<p>House letter<br>
		<input type=text name=data[private_houseletter] value="%%private_houseletter%%"></p>
		<p>Floor<br>
		<input type=text name=data[private_housefloor] value="%%private_housefloor%%"></p>
		<p>Side<br>
		<input type=text name=data[private_houseplacement] value="%%private_houseplacement%%"></p>
		<p>Postal no<br>
		<input type=text name=data[private_zipno] value="%%private_zipno%%"></p>
		<p>City<br>
		<input type=text name=data[private_city] value="%%private_city%%"></p>
		<p>Country<br>
		<input type=text name=data[private_country] value="%%private_country%%"></p>
		<p>Phone<br>
		<input type=text name=data[private_phone] value="%%private_phone%%"></p>
		<p>Mobile<br>
		<input type=text name=data[private_mobile] value="%%private_mobile%%"></p>
		<p>Mail<br>
		<input type=text name=data[private_email] value="%%private_email%%"></p>
		
		<h2>Work</h2>
		<p>Company<br>
		<input type=text name=data[company_name] value="%%company_name%%"></p>
		<p>Position<br>
		<input type=text name=data[company_position] value="%%company_position%%"></p>
		<p>Business<br>
		<select name=data[company_business] id=biz></select><input type=button onclick=add_biz(); value="Tilføj branche"/>
		</p>
		<p>Company profile<br>
		<textarea name=data[company_profile] class=ckeditor>%%company_profile%%</textarea></p>
		<p>Address<br>
		<input type=text name=data[company_address] value="%%company_address%%"></p>
		<p>Postal no<br>
		<input type=text name=data[company_zipno] value="%%company_zipno%%"></p>
		<p>City<br>
		<input type=text name=data[company_city] value="%%company_city%%"></p>
		<p>Country<br>
		<input type=text name=data[company_country] value="%%company_country%%"></p>
		<p>Phone<br>
		<input type=text name=data[company_phone] value="%%company_phone%%"></p>
		<p>Mail<br>
		<input type=text name=data[company_email] value="%%company_email%%"></p>
		<p>Web pgae<br>
		<i>Remember http:// </i><br>
		<input type=text name=data[company_web] value="%%company_web%%"></p>
		<hr>
		<p>Transfer to EX-Table<br>
		<select name=data[xtable_transfer] id=xtable>
			<option value=1>Yes, Ex-table may contact me when I exit</option>			
			<option value=2>Yes, transfer me to Ex-table when I exit</option>
			<option value=0>No, Ex-table may not contact me when I exit</option>
		</select><br>
		</p>
		<script>$("#xtable").val(%%xtable_transfer%%);</script>		
		<hr>
		<input type=submit value="Save">
		</form>
		<button value="Undo" onclick="javascript:window.history.back();">Undo changes</button>
		<script>
			function add_biz()
			{
				var b = prompt("Business:");
				if (b)
				{
				 if( !/[\w\s\;\:\.\,]+/gi.test( b ) )
					{
						alert("Business may only contain letters and numbers");
						add_biz();
					}
					else
					{
						$("#biz").append("<option selected value=\""+b+"\">"+b+"</option>");
					}
				}
			}
			
			var biz = jQuery.parseJSON(\'%%businesses_list%%\');
			$.each(biz, function(c,v) {
				if ("%%company_business%%" == v.company_business)
				{
					$("#biz").append("<option selected value=\""+v.company_business+"\">"+v.company_business+"</option>");
				}
				else
				{
					$("#biz").append("<option value=\""+v.company_business+"\">"+v.company_business+"</option>");
				}
			});
		
			$(function() {
				$("#charterdate").datepicker({dateFormat:"yy-mm-dd",changeYear: true});
				$("#birthdate").datepicker({dateFormat:"yy-mm-dd",changeYear: true,yearsRange:"-40:c",});
			});
		</script>
		',
			'user_profile_edit_user' =>
	'
		<h1>Edit profile</h1>
		<form method=post action=?uid=%%uid%%&edit=save enctype="multipart/form-data">
		<table>
		<tr>
		<td valign=top>
			<p>Password<br>
			<input type=text name=password value=""><br>
			<i>Leave blank to keep current password</i>
			</p>
		</td>
		<td valign=top>
			<p>Username<br>
			<input type=text name=data[username] value="%%username%%"></p>
		</td>
		<tr>
		<td valign=top>
			<p>First name<br>
			<input type=text disabled value="%%profile_firstname%%"></p>
		</td>
		<td valign=top>
			<p>Last name<br>
			<input type=text disabled value="%%profile_lastname%%"></p>
		</td>
		</tr>
		<tr><td colspan=2>
		<p>Photo<br>
		<img src=/uploads/user_image?uid=%%uid%%&quad&s=200><br>
		Change:<br><input type=file name=profile_image>
		</p>
		</td>
		</table>
		<p>Profile text<br>
		<textarea name=data[private_profile] class=ckeditor>%%private_profile%%</textarea></p>
		<p>Profile display<br>
		<select name=data[view_tracker] id=xtable>
			<option value=1>Yes, show who has seen my profile</option>			
			<option value=0>No, dont show who has seen my profile</option>
		</select><br>
		</p>
		
		<h2>Home</h2>
		<table>
		<tr>
		<td valign=top>
			<p>Address<br>
			<input type=text name=data[private_address] value="%%private_address%%"></p>
		</td>
		<td valign=top>
			<p>House no<br>
			<input type=text name=data[private_houseno] value="%%private_houseno%%" size=4></p>
		</td>
		<td valign=top>
			<p>Letter<br>
			<input type=text name=data[private_houseletter] value="%%private_houseletter%%" size=4></p>
		</td>
		<td valign=top>
			<p>Floor<br>
			<input type=text name=data[private_housefloor] value="%%private_housefloor%%" size=4></p>
		</td>
		<td valign=top>
			<p>Side<br>
			<input type=text name=data[private_houseplacement] value="%%private_houseplacement%%" size=4></p>
		</td>
		</tr></tabl><table>
		<tr>
		<td valign=top>
			<p>Postal no<br>
			<input type=text name=data[private_zipno] value="%%private_zipno%%"></p>
		</td>
		<td valign=top>
			<p>City<br>
			<input type=text name=data[private_city] value="%%private_city%%"></p>
		</td>
		</tr>
		<tr>
			<td valign=top>
			<p>Country<br>
			<input type=text name=data[private_country] value="%%private_country%%"></p>
			</td>
			<td></td>
		</tr>
		</table>
		<table>
		<tr>
		<td>
		<p>Phone<br>
		<input type=text name=data[private_phone] value="%%private_phone%%" required></p>
		</td>
		<td>
		<p>Mobile<br>
		<input type=text name=data[private_mobile] value="%%private_mobile%%" required></p>
		</td>
		<td>
		<p>Mail<br>
		<input type=text name=data[private_email] value="%%private_email%%" required></p>
		</td></tr></table>
		
		<h2>Work</h2>
		<table><tr><td valign=top>
		<p>Company<br>
		<input type=text name=data[company_name] value="%%company_name%%"></p>
		</td><td valign=top>
		<p>Position<br>
		<input type=text name=data[company_position] value="%%company_position%%"></p>
		</td></tr></table>
		<p>Business<br>
		<select name=data[company_business] id=biz></select><input type=button onclick=add_biz(); value="Tilføj branche"/></p>
		<p>Company profile<br>
		<textarea name=data[company_profile] class=ckeditor>%%company_profile%%</textarea></p>
		<table><tr>
		<td>
			<p>Address<br>
			<input type=text name=data[company_address] value="%%company_address%%"></p>
		</td>
		<td>
			<p>Postal no<br>
			<input size=4 type=text name=data[company_zipno] value="%%company_zipno%%"></p>
		</td>
		<td>
			<p>City<br>
			<input type=text name=data[company_city] value="%%company_city%%"></p>
		</td>
		<td>
			<p>Country<br>
			<input type=text name=data[company_country] value="%%company_country%%"></p>
		</td></tr></table>
		<table>
		<tr>
		<td valign=top>
			<p>Phone<br>
			<input type=text name=data[company_phone] value="%%company_phone%%" required></p>
		</td>
		<td valign=top>
			<p>Mail<br>
			<input type=text name=data[company_email] value="%%company_email%%" required></p>
		</td>
		<td>
			<p>Webpage<br>
			<input type=text name=data[company_web] value="%%company_web%%"></p>
			<i>Remember http:// </i>
		</td></tr></table>
		<hr>
		<p>Transfer to Ex-Table<br>
		<select name=data[xtable_transfer] id=xtable>
			<option value=1>Yes, Ex-Table may contact me when I exit</option>			
			<option value=2>Yes, transfer me to Ex-Table when I exit</option>
			<option value=0>No, Ex-Table may not contact me when I exit</option>
		</select><br>
		</p>
		<script>$("#xtable").val(%%xtable_transfer%%);</script>		
		<hr>
		<table width=100%>
		<tr>
		<td align=left><input type=submit value="Save"></td>
		<td align=right><button value="Undo" onclick="javascript:window.history.back();">Undo</button></td>
		</tr></table>
		</form>
		<script>
			function add_biz()
			{
				var b = prompt("Business:");
				if (b)
				{
				 if( !/[\w\s\;\:\.\,]+/gi.test( b ) )
					{
						alert("Business may only contain letters or numbers");
						add_biz();
					}
					else
					{
						$("#biz").append("<option selected value=\""+b+"\">"+b+"</option>");
					}
				}
			}
			
			var biz = jQuery.parseJSON(\'%%businesses_list%%\');
			$.each(biz, function(c,v) {
				if ("%%company_business%%" == v.company_business)
				{
					$("#biz").append("<option selected value=\""+v.company_business+"\">"+v.company_business+"</option>");
				}
				else
				{
					$("#biz").append("<option value=\""+v.company_business+"\">"+v.company_business+"</option>");
				}
			});
		</script>
	',
		'user_profile_edit_secretary' =>
	'
		<h1>Edit profile - Secretary</h1>
		<form method=post action=?uid=%%uid%%&edit=save enctype="multipart/form-data">
		<p>Password<br>
		<i>Leave blank to keep current password</i><br>
		<input type=text name=password value="">
		</p>
		<p>Usernanme<br>
		<input type=text name=data[username] value="%%username%%"></p>
		<!--- <p>Photo<br>
		<img src=/uploads/user_image?uid=%%uid%%&quad&s=200><br>
		Change: <input type=file name=profile_image>
		</p>--->
		<p>First name<br>
		<input type=text name=data[profile_firstname] value="%%profile_firstname%%"></p>
		<p>Last name<br>
		<input type=text name=data[profile_lastname] value="%%profile_lastname%%"></p>
		<p>Text<br>
		<textarea name=data[private_profile] class=ckeditor>%%private_profile%%</textarea></p>
		<p>Profile display<br>
		<select name=data[view_tracker] id=xtable>
			<option value=1>Yes, show who has seen my profile</option>			
			<option value=0>No, dont show who has seen my profile</option>
		</select><br>
		</p>
		
		<h2>Home</h2>
		<p>Address<br>
		<input type=text name=data[private_address] value="%%private_address%%"></p>
		<p>House no<br>
		<input type=text name=data[private_houseno] value="%%private_houseno%%"></p>
		<p>House letter<br>
		<input type=text name=data[private_houseletter] value="%%private_houseletter%%"></p>
		<p>Floor<br>
		<input type=text name=data[private_housefloor] value="%%private_housefloor%%"></p>
		<p>Side<br>
		<input type=text name=data[private_houseplacement] value="%%private_houseplacement%%"></p>
		<p>Postal no<br>
		<input type=text name=data[private_zipno] value="%%private_zipno%%"></p>
		<p>City<br>
		<input type=text name=data[private_city] value="%%private_city%%"></p>
		<p>Phone<br>
		<input type=text name=data[private_phone] value="%%private_phone%%"></p>
		<p>Mobile<br>
		<input type=text name=data[private_mobile] value="%%private_mobile%%"></p>
		<p>Mail<br>
		<input type=text name=data[private_email] value="%%private_email%%"></p>
		
		<h2>Work</h2>
		<p>Company<br>
		<input type=text name=data[company_name] value="%%company_name%%"></p>
		<p>Position<br>
		<input type=text name=data[company_position] value="%%company_position%%"></p>
		<p>Business<br>
		<select name=data[company_business] id=biz></select><input type=button onclick=add_biz(); value="Tilføj branche"/></p>
		<p>Company profile<br>
		<textarea name=data[company_profile] class=ckeditor>%%company_profile%%</textarea></p>
		<p>Address<br>
		<input type=text name=data[company_address] value="%%company_address%%"></p>
		<p>Postal no<br>
		<input type=text name=data[company_zipno] value="%%company_zipno%%"></p>
		<p>City<br>
		<input type=text name=data[company_city] value="%%company_city%%"></p>
		<p>Country<br>
		<input type=text name=data[company_country] value="%%company_country%%"></p>
		<p>Phone<br>
		<input type=text name=data[company_phone] value="%%company_phone%%"></p>
		<p>Mail<br>
		<input type=text name=data[company_email] value="%%company_email%%"></p>
		<p>Webpage<br>
		<i>Remember http:// </i><br>
		<input type=text name=data[company_web] value="%%company_web%%"></p>
		<hr>
		<p>Transfer to EX-Table<br>
		<select name=data[xtable_transfer] id=xtable>
			<option value=1>Yes, Ex-table may contact me when I exit</option>			
			<option value=2>Yes, I want to transfer to Ex-table when I exit</option>
			<option value=0>No, Ex-table may not contact me when I exit</option>
		</select><br>
		</p>
		<script>$("#xtable").val(%%xtable_transfer%%);</script>		
		<hr>
		<input type=submit value="Save">
		</form>
		<button value="Undo" onclick="javascript:window.history.back();">Undo</button>
		<script>
			function add_biz()
			{
				var b = prompt("Business:");
				if (b)
				{
				 if( !/[\w\s\;\:\.\,]+/gi.test( b ) )
					{
						alert("Business may only contain letters and numbers");
						add_biz();
					}
					else
					{
						$("#biz").append("<option selected value=\""+b+"\">"+b+"</option>");
					}
				}
			}
			
			var biz = jQuery.parseJSON(\'%%businesses_list%%\');
			$.each(biz, function(c,v) {
				if ("%%company_business%%" == v.company_business)
				{
					$("#biz").append("<option selected value=\""+v.company_business+"\">"+v.company_business+"</option>");
				}
				else
				{
					$("#biz").append("<option value=\""+v.company_business+"\">"+v.company_business+"</option>");
				}
			});
		</script>
	',
  'user_profile_club' => 
  '<h1><a href=?cid=%%cid%%>%%name%%</a></h1>',
	'user_profile' =>
	'
		<h1>%%profile_firstname%% %%profile_lastname%%</h1>
		<table width=578px cellspacing=5 border=0>
		<tr>
		<td valign=top>
		<p><img src="/uploads/user_image?uid=%%uid%%&landscape&w=300&h=500"></p>
		</td>
		<td valign=top>
		<!--<h1>Privat</h1>-->
		<p>Birth date: %%profile_birthdate%%, Charter: %%profile_started%%, Exit: %%profile_ended%%. <br>Online: %%last_page_view%%.</p>
		<p>%%private_profile%%</p>
		<p>Address: 
			<ul>%%private_address%% %%private_houseno%% %%private_houseletter%% %%private_housefloor%% %%private_houseplacement%%<br>
			%%private_zipno%% %%private_city%%, %%private_country%%<br>
			Phone: %%private_phone%%, Mobil: %%private_mobile%%<br>
			Email: <a href=mailto:%%private_email%%>%%private_email%%</a><br>
			</ul>
		</p>
		<!--<h1>Arbejde</h1>-->
		<p>Company: <a href="?biz=%%company_business%%#%%company_name%%">%%company_name%%</a></p>
		<p>Position: <a href="?search=%%company_position%%">%%company_position%%</a><br>Branche: <a href="?biz=%%company_business%%">%%company_business%%</a></p>
		<p>%%company_profile%%</p>
		<p>Address:
		<ul>
			%%company_address%%<br>
			%%company_zipno%% %%company_city%%, %%company_country%%<br>
			Phone: %%company_phone%%<br>
			Mail: <a href=mailto:%%company_email%%>%%company_email%%</a><br>
			Web: <a href="%%company_web%%" target=_blank>%%company_web%%</a><br>
		</ul>
		</p>
		<p>
		Meetings: <a href=?dashboard=%%cid%%#%%uid%%>Details</a>
		</p>
		</td></tr></table>
		<h1>Message</h1>
		<form action=index.php?uid=%%uid%% method=post>
		<input type=hidden name=uid value=%%uid%%>
		<textarea name=message style="width:95%;height=200px;"></textarea><br>
		<input type=submit value=Send>
		</form>
	',
	'club_missing_minutes' => '<a name=nominutes><h1>Missing minutes</h1></a>',
	'meeting_links' => '
		<div id=links><h1>Links</h1></div>
		
		<script>
		  var links_data = jQuery.parseJSON(\'%%data%%\');
		  
		  $.each(links_data, function(i,j) {
			var s = j.media_source;
			var l = j.media_link;
			
			if (s == "vm")
			{
				var id = l.replace("http://vimeo.com/","");
				$(\'<iframe src="//player.vimeo.com/video/\'+id+\'" width="100%" height="300" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>\').appendTo($("#links"));
			}
			else if (s == "yt")
			{
				
				var id = l.replace("http://youtu.be/", "");
				var id = id.replace("http://www.youtube.com/watch?v=", "");
				$(\'<iframe width="100%" height="300" src="//www.youtube.com/embed/\'+id+\'" frameborder="0" allowfullscreen></iframe>\').appendTo($("#links"));
				
			}
		  });
		  
		</script>
		
	',
	'meeting_minutes_edit' => '
		<script>
		function add_pics()
		{
			$("<br><input type=file name=minutes_images[] onchange=verify_image(this);>").appendTo($("#pics"));
		}
		
		function add_links()
		{
			$("<br>Link: <input type=text name=links_link[]><select name=links_source[]><option value=fb>Facebook</option><option value=yt>Youtube</option><option value=vm>Vimeo</option></select>").appendTo($("#links"));
		}
		
		function verify_image(what)
		{
			var fn = what.value;
			var ext = fn.substring(fn.lastIndexOf('.') + 1);
			if (!(/\.(gif|jpg|jpeg|png)$/i).test(fn))
			{
				what.value = "";
				what.focus();
				alert("Only JPG/PNG/GIF");
			}
		}
		</script>
		<h1>Edit minutes - %%title%%</h1>
		<form method=post action="?mid=%%mid%%&minutes_edit=save" enctype="multipart/form-data" onsubmit="return evaluate_meeting();">
		<h2>Meeting</h2>
		<textarea class=ckeditor name=minutes[minutes] id=meeting_minutes>%%minutes%%</textarea>
		<h2>Activity</h2>
		<textarea class=ckeditor name=minutes[minutes_3min] id=meeting_minutes_3min>%%minutes_3min%%</textarea>
		<h2>Minutes</h2>
		<textarea class=ckeditor name=minutes[minutes_letters] id=meeting_minutes_letters>%%minutes_letters%%</textarea>
		<h2>Links</h2>
		%%links_html%%
		<div id="links">
		</div>
		<input type=button value="Add links..." onclick="add_links();">
		<h2>Photos</h2>
		%%images_html%%
		<div id="pics">
		<input type=file name=minutes_images[]   class=multi accept="gif|jpg|png">
		</div>
    <h2>Attach</h2>
    %%files_html%%
    <input type=file name=minutes_file id=minutes_file>
		<h2>Participants</h2>
    <p><b>Participatns</b></p>
		<input type=text disabled name=minutes[minutes_number_of_participants] value="%%minutes_number_of_participants%%">
		<p><b>Resigned</b></p>
		<input type=text disabled name=minutes[minutes_number_of_rejections] value="%%minutes_number_of_rejections%%">
		<p><b>Percent</b></p>
		<input type=text disabled value="%%minutes_percentage%%%">
		<p><a href=# onclick="if (confirm(\'Leave page without saving?\')) document.location.href=\'?mid=%%mid%%\';">Meeting statistics can only be change here</a></p>

		<h2>Minubtes</h2>
		<p>Minutes completed <input type=checkbox name=finish_minutes id=finish_minutes></p>
		<p>Send minutes to members <input type=checkbox name=mail_minutes id=mail_minutes checked></p>
		<input type=submit value="Save">
		</form>
		<script>
		function evaluate_meeting()
		{
			if (document.getElementById("finish_minutes").checked==1)
			{
				return confirm("Please confirm that everything is completed");
			}
			else return true;
		}
		</script>
	',
			'mail_invitation_duty_ext1_uid' =>
'',
			'mail_invitation_duty_ext2_uid' =>
'',
			'mail_invitation_duty_ext3_uid' =>
'',
			'mail_invitation_duty_ext4_uid' =>
'',
			'mail_invitation_duty_meeting_responsible_uid' =>
'',
		'mail_invitation_duty_letters2_uid' => 
'',
		'mail_invitation_duty_letters1_uid' => 
'',
		'mail_invitation_duty_3min_uid' => 
'',
		'mail_invitation' => 
'Dear member

You are invited for the meeting on %%start_time%% - %%end_time%%

Duties:
%%duty_text%%

Minutes:
- Minutes 1: http://CHANGE THIS/?mid=%%mid%%&collection=%%mid%%
- Minutes 2: http://CHANGE THIS/?mid=%%mid%%&collection=%%mid%%/2


Location:
%%location%%

Remember to resign online:
http://CHANGE THIS/?mid=%%mid%%

%%meeting_description%%

',
		'mail_invitation_subject' => 'Invitation: %%title%%',
		'admin_term_edit' => 'Edit language',
		'latestmembers' =>
		'
								<h1>Latest members</h1>
								<script>
									$(function(){
										$("#slides").slides(
										{
											play: 5000,
											randomize: true,
											pagination: true
										}
										);
									});
								</script>								
								<div id="slides">
									<div class="slides_container">
										<div>
											<table width=100% cellspacing=5 cellpadding=5 border=0>
											<tr>		
												<td valign=top>
																<img src="/uploads/user_image?uid=%%member_0_uid%%&landscape&w=100&h=150" width=100 height=100><br>
																<a href=?uid=%%member_0_uid%%>%%member_0_profile_firstname%% %%member_0_profile_lastname%%</a><br>
																%%member_0_company_position%%<br>
																<a href=?cid=%%cid%%>%%member_0_clubname%%</a>
												</td>								
												<td valign=top>
																<img src="/uploads/user_image?uid=%%member_1_uid%%&landscape&w=100&h=150" width=100 height=100><br>
																<a href=?uid=%%member_1_uid%%>%%member_1_profile_firstname%% %%member_1_profile_lastname%%</a><br>
																%%member_1_company_position%%<br>
																<a href=?cid=%%cid%%>%%member_1_clubname%%</a>
												</td>								
												<td valign=top>
																<img src="/uploads/user_image?uid=%%member_2_uid%%&landscape&w=100&h=150" width=100 height=100><br>
																<a href=?uid=%%member_2_uid%%>%%member_2_profile_firstname%% %%member_2_profile_lastname%%</a><br>
																%%member_2_company_position%%<br>
																<a href=?cid=%%cid%%>%%member_2_clubname%%</a>
												</td>								
												<td valign=top>
																<img src="/uploads/user_image?uid=%%member_3_uid%%&landscape&w=100&h=150" width=100 height=100><br>
																<a href=?uid=%%member_3_uid%%>%%member_3_profile_firstname%% %%member_3_profile_lastname%%</a><br>
																%%member_3_company_position%%<br>
																<a href=?cid=%%cid%%>%%member_3_clubname%%</a>
												</td>								
												<td valign=top>
																<img src="/uploads/user_image?uid=%%member_4_uid%%&landscape&w=100&h=150" width=100 height=100><br>
																<a href=?uid=%%member_4_uid%%>%%member_4_profile_firstname%% %%member_4_profile_lastname%%</a><br>
																%%member_4_company_position%%<br>
																<a href=?cid=%%cid%%>%%member_4_clubname%%</a>
												</td>								
											</tr>
											</table>
										</div>
									</div>
									<div class="slides_container">
										<div>
											<table width=100% cellspacing=5 cellpadding=5 border=0>
											<tr>		
												<td valign=top>
																<img src="/uploads/user_image?uid=%%member_5_uid%%&landscape&w=100&h=150" width=100 height=100><br>
																<a href=?uid=%%member_5_uid%%>%%member_5_profile_firstname%% %%member_5_profile_lastname%%</a><br>
																%%member_5_company_position%%<br>
																<a href=?cid=%%cid%%>%%member_5_clubname%%</a>
												</td>								
												<td valign=top>
																<img src="/uploads/user_image?uid=%%member_6_uid%%&landscape&w=100&h=150" width=100 height=100><br>
																<a href=?uid=%%member_6_uid%%>%%member_6_profile_firstname%% %%member_6_profile_lastname%%</a><br>
																%%member_6_company_position%%<br>
																<a href=?cid=%%cid%%>%%member_6_clubname%%</a>
												</td>								
												<td valign=top>
																<img src="/uploads/user_image?uid=%%member_7_uid%%&landscape&w=100&h=150" width=100 height=100><br>
																<a href=?uid=%%member_7_uid%%>%%member_7_profile_firstname%% %%member_7_profile_lastname%%</a><br>
																%%member_7_company_position%%<br>
																<a href=?cid=%%cid%%>%%member_7_clubname%%</a>
												</td>								
												<td valign=top>
																<img src="/uploads/user_image?uid=%%member_8_uid%%&landscape&w=100&h=150" width=100 height=100><br>
																<a href=?uid=%%member_8_uid%%>%%member_8_profile_firstname%% %%member_8_profile_lastname%%</a><br>
																%%member_8_company_position%%<br>
																<a href=?cid=%%cid%%>%%member_8_clubname%%</a>
												</td>								
												<td valign=top>
																<img src="/uploads/user_image?uid=%%member_9_uid%%&landscape&w=100&h=150" width=100 height=100><br>
																<a href=?uid=%%member_9_uid%%>%%member_9_profile_firstname%% %%member_9_profile_lastname%%</a><br>
																%%member_9_company_position%%<br>
																<a href=?cid=%%cid%%>%%member_9_clubname%%</a>
												</td>								
											</tr>
											</table>
										</div>
									</div>
								
									<div class="slides_container">
										<div>
											<table width=100% cellspacing=5 cellpadding=5 border=0>
											<tr>		
												<td valign=top>
																<img src="/uploads/user_image?uid=%%member_10_uid%%&landscape&w=100&h=150" width=100 height=100><br>
																<a href=?uid=%%member_10_uid%%>%%member_10_profile_firstname%% %%member_10_profile_lastname%%</a><br>
																%%member_10_company_position%%<br>
																<a href=?cid=%%cid%%>%%member_10_clubname%%</a>
												</td>								
												<td valign=top>
																<img src="/uploads/user_image?uid=%%member_11_uid%%&landscape&w=100&h=150" width=100 height=100><br>
																<a href=?uid=%%member_11_uid%%>%%member_11_profile_firstname%% %%member_11_profile_lastname%%</a><br>
																%%member_11_company_position%%<br>
																<a href=?cid=%%cid%%>%%member_11_clubname%%</a>
												</td>								
												<td valign=top>
																<img src="/uploads/user_image?uid=%%member_12_uid%%&landscape&w=100&h=150" width=100 height=100><br>
																<a href=?uid=%%member_12_uid%%>%%member_12_profile_firstname%% %%member_12_profile_lastname%%</a><br>
																%%member_12_company_position%%<br>
																<a href=?cid=%%cid%%>%%member_12_clubname%%</a>
												</td>								
												<td valign=top>
																<img src="/uploads/user_image?uid=%%member_13_uid%%&landscape&w=100&h=150" width=100 height=100><br>
																<a href=?uid=%%member_13_uid%%>%%member_13_profile_firstname%% %%member_13_profile_lastname%%</a><br>
																%%member_13_company_position%%<br>
																<a href=?cid=%%cid%%>%%member_13_clubname%%</a>
												</td>								
												<td valign=top>
																<img src="/uploads/user_image?uid=%%member_14_uid%%&landscape&w=100&h=150" width=100 height=100><br>
																<a href=?uid=%%member_14_uid%%>%%member_14_profile_firstname%% %%member_14_profile_lastname%%</a><br>
																%%member_14_company_position%%<br>
																<a href=?cid=%%cid%%>%%member_14_clubname%%</a>
												</td>								
											</tr>
											</table>
										</div>
									</div>
								
								</div>								
		',
		'latestmembers_pre' => '<h1>Latest members</h1>
								<script>
									$(function(){
										$("#slides").slides(
										{
											play: 5000,
											randomize: true,
											pagination: true
										}
										);
									});
								</script>								
								<div id="slides">
								<div class="slides_container"><div><table width=100% cellspacing=5 cellpadding=5 border=0><tr>
								',
		'latestmembers_item' => '<td valign=top>
												<img src="http://rtd.dk/%%profile_image%%" width=100 height=100><br>
												<a href=?uid=%%uid%%>%%profile_firstname%% %%profile_lastname%%</a><br>
												%%company_position%%<br>
												<a href=?cid=%%cid%%>%%clubname%%</a>
								</td>',
		'latestmembers_split' => '</tr></table></div><div><table width=100% cellspacing=5 cellpadding=5 border=0><tr>',
		'latestmembers_post' => '</tr></table></div></div></div>',


		'statsbox_advanced_link' => '<div class=stats><a href=?stats>More</a></div><br>',
		'statsbox' => 	'<h3>Stats</h3><br>
						<div class=stats>
							<li>Members: %%allmembers%%
							<li>Honorary: %%honorary%%
							<li>New: %%newmembers%%
							<li>Exit: %%leavingmembers%%
							<li>Avg. age: %%avgage%% år
						</div>
						',
		'club_latest_minutes' => '<h2>Lates minutes</h2>',
		'club_archive' => '<h1>Archive</h1><a href=?cid=%%cid%%&archive>Archive of old meetings</a>',
    'club_other_meetings' => '
    <div id=container_other_meetings>
      <h1>Other events</h1>
	  <table width=100% cellspacing=0 cellpadding=0 border=0>
	  <tr><td width=50% valign=top>
	  <p><b>Birthdays this month</b></p>
	  <ul id=birthdays></ul>
	  </td><td width=50% valign=top>
	  <p><b>Meetings</b></p>
      <ul id=other_meetings></ul>
	  </td></tr></table>
      <div id=other_meetings_data style="display:none"></div>
    </div>
    <script>
      var other_data = jQuery.parseJSON(\'%%data%%\');
	  
	  $.each(other_data.birthday, function(i,j) {
		$("#birthdays").append("<li><a href=?uid="+j.uid+">"+j.profile_firstname+" "+j.profile_lastname+", "+j.profile_birthdate+"</a>");
	  });
	  
      var c = 0;
      $.each(other_data.meetings, function(k,m) {
        $("#other_meetings").append("<li name=omid_link_"+m.omid+"><a href=#omid_link_"+m.omid+" onclick=show_om("+m.omid+")>"+m.title+" ("+m.start_time+")</a>");
        $("#other_meetings_data").append("<div id=omid_"+m.omid+"><h1>"+m.title+"</h1>"+m.start_time+" - "+m.end_time+"<br><br>"+m.description+"</div>")
      });
      
      function show_om(omid)
      {
        $("#omid_"+omid).dialog({modal:true});
      
        
      }
    </script>
    ',
    'club_other_meetings_secretary' => '
    <div id=container_other_meetings>
      <h1>Other events</h1>
	  <table width=100% cellspacing=0 cellpadding=0 border=0>
	  <tr><td width=50% valign=top>
	  <p><b>Birthdays this month</b></p>
	  <ul id=birthdays></ul>
	  </td><td width=50% valign=top>
	  <p><b>Meetings</b></p>
      <ul id=other_meetings></ul>
	  </td></tr></table>
      <div id=other_meetings_data style="display:none"></div>
    </div>
    <script>
      var other_data = jQuery.parseJSON(\'%%data%%\');
	  
	  $.each(other_data.birthday, function(i,j) {
		$("#birthdays").append("<li><a href=?uid="+j.uid+">"+j.profile_firstname+" "+j.profile_lastname+", "+j.profile_birthdate+"</a>");
	  });
	  
      var c = 0;
      $.each(other_data.meetings, function(k,m) {
        $("#other_meetings").append("<li name=omid_link_"+m.omid+"><a href=#omid_link_"+m.omid+" onclick=show_om("+m.omid+")>"+m.title+" ("+m.start_time+")</a>");
        $("#other_meetings_data").append("<div id=omid_"+m.omid+"><h1>"+m.title+"</h1>"+m.start_time+" - "+m.end_time+"<br><br>"+m.description+"<p><a href=?cid="+m.cid+"&delete_omid="+m.omid+">Delete</a></div>")
      });
      
      function show_om(omid)
      {
        $("#omid_"+omid).dialog({modal:true});
      
        
      }
    </script>
    ',
		'club_future_meetings' => '
		<div id=next></div>
		<h2>Meetings</h2>
		<div style="height: 330px; overflow: scroll; overflow-x: hidden;">
		<table width=100% border=0>
		<tr>
			<td valign=top width=50%>Meetings:<table id=other></table></td>
			<td valign=top width=50%>Minutes:<table id=minutes></table></td>
		</tr>
		</table>
		</div>
		
		<script>
				var data = jQuery.parseJSON(\'%%data%%\');
	      var i = 0;
				$.each(data, function(k,m) {
					if (i==0)
					{
						if (m.images && m.images[0])
						{
							$("#next").append("<a href=?mid="+m.mid+"><h2>Next: "+m.title+", "+m.start_time+"</h2><img width=100% src=/uploads/meeting_image/?miid="+m.images[0].miid+"&landscape&w=570&h=300></a>");
						}
						else
						{
							$("#next").append("<a href=?mid="+m.mid+"><h2>Next: "+m.title+", "+m.start_time+"</h2><i>No photo</i></a>");
						}
					}
					else
					{
						if (m.images && m.images[0])
						{
							$("#other").append("<tr><td valign=top><img src=/uploads/meeting_image/?miid="+m.images[0].miid+"&landscape&w=100&h=150 width=100></td><td valign=top><a href=?mid="+m.mid+">"+m.title+"<br>"+m.start_time+"</a></td></tr>");
						}
						else
						{
						$("#other").append("<tr><td valign=top><img src=/uploads/club_logos/0.jpg width=100></td><td valign=top><a href=?mid="+m.mid+">"+m.title+"<br>"+m.start_time+"</a></td></tr>");
						}
					}
					i++;
				}); 
		
		</script>
		',
		'club_minutes' => '
		<script>
				var minutes_data = jQuery.parseJSON(\'%%data%%\');
				$.each(minutes_data, function(k,m) {
						if (m.images[0])
						{
							$("#minutes").append("<tr><td valign=top><img src=/uploads/meeting_image/?miid="+m.images[0].miid+"&landscape&w=100&h=150 width=100></td><td valign=top><a href=?mid="+m.mid+">"+m.title+"<br>"+m.start_time+"</a></td></tr>");
						}
						else
						{
						$("#minutes").append("<tr><td valign=top><img src=/uploads/club_logos/0.jpg width=100></td><td valign=top><a href=?mid="+m.mid+">"+m.title+"<br>"+m.start_time+"</a></td></tr>");
						}
				}); 
		
		</script>
		',
		'club_minutes_archive' => '
		<h1>Archive</h1>
		Calendar year: <select id=years onchange=y(this.value);></select>
		<hr>
		<table id=minutes width=100%>
		</table>
		<script>
				function y(v)
				{
					document.location.href="#"+v;
				}
				var minutes_data = jQuery.parseJSON(\'%%data%%\');
				var old_y = 0;
				$.each(minutes_data, function(k,m) {
						var y = m.start_time.substring(m.start_time.indexOf(",")+1);
						var yt = "";
						if (y!=old_y)
						{
							$("#years").append("<option value="+y+">"+y+"</option>");
							yt = "<a name="+y+"><b>"+y+"</b></a>";
							old_y=y;
						}
						if (m.images[0])
						{
							$("#minutes").append("<tr><td width=100px valign=top>"+yt+"</td><td valign=top><img src=/uploads/meeting_image/?miid="+m.images[0].miid+"&landscape&w=100&h=150 width=100></td><td valign=top><a href=?mid="+m.mid+">"+m.title+"<br>"+m.start_time+"</a></td></tr>");
						}
						else
						{
						$("#minutes").append("<tr><td valign=top>"+yt+"</td><td valign=top><img src=/uploads/club_logos/0.jpg width=100></td><td valign=top><a href=?mid="+m.mid+">"+m.title+"<br>"+m.start_time+"</a></td></tr>");
						}
				}); 
		
		</script>
		',
		'club_future_meetings_item' => '<li><a href=?mid=%%mid%%>%%start_time%%: %%title%%</a>',
		
		'club_secretary_tools' => '
															<h1 onclick="$(\'#stools\').toggle();">Secretary tools</h1>
															<p id=stools>
															<a href=/uploads/article_file/?afid=50>Help</a> |
															<a href=?uid=-1>Create member</a> |
															<a href=?mid=-1&club=%%cid%%>Create meeting</a> |
															<a href=?kbp>Nominate future board</a> |
															<a href=?cid=%%cid%%&edit>Edit club</a> |
															<a href=?dashboard>Dashboard</a>
															</p>
															
															',
		'special_club_page' => '<h1>%%name%%</h1>',
    'special_club_page_admin' => '<h1>Create meeting</h1>
    <form action=?cid=%%cid%%>
    <p>Title<br><input type=text name=meeting[title]></p>
		<p>Start<br>
		<input class=field type=text name=meeting[start_time] value="" id=start_time></p>
		<p>End<br>
		<input class=field type=text name=meeting[end_time] value="" id=end_time></p>
		<p>Location<br>
		<input class=field id=loctext type=text name=meeting[location] value="" onkeyup=locate(this.value);></p>
		<div id=locmap></div>
    <input type=hidden name=cid value=%%cid%%>
    <input type=submit value=Opret>
    </form>
											<script>
												function locate(what)
												{
													if (what=="") return;
													var url = "/scripts/rtd/geocodeproxy.php?address=="+what+"&sensor=false";
													
													$.ajax( url ).done(function(data) 
													{ 
														var result = jQuery.parseJSON(data);
														var lat = -1;
														var lng = -1;
														var found=false;
														$.each(result.results, function(k,v) {
															lat = v.geometry.location.lat;
															lng = v.geometry.location.lng;
															found=true;
														});
														if (!found) 
														{
															$("#locmap").html("<i>Not found</i>");
														}
														else {
															var img = "http://maps.googleapis.com/maps/api/staticmap?center="+what+"&zoom=11&size=255x255&maptype=roadmap&markers=color:blue|label:O|"+lat+","+lng+"&sensor=false";
															var url = "https://maps.google.dk/?q="+what;
															$("#locmap").html("<a href=\""+url+"\" target=_blank><img src=\""+img+"\"/></a>");
														}
													});																										
												}
												
												locate($("#loctext").val());
												
												$(function() {
													$("#start_time").datetimepicker({dateFormat:"yy-mm-dd",timeFormat:"HH:mm:ss"});
													$("#end_time").datetimepicker({dateFormat:"yy-mm-dd",timeFormat:"HH:mm:ss"});
												});
                        </script>
    ',
    'club_header' => '
											<h1>%%name%%</h1>
                      <table width=100% border=0 cellspacing=0>
                      <tr>
                      <td>
											<p>Meeting: %%meeting_place%%, %%meeting_time%%</p>
											<p>%%description%%</p>
											<p>
												Links
												<ul>
												<li><a href=?cid=%%cid%%&ics>Download calendar (ics)</a>
												<li><a href="?cid=%%cid%%&message" target=_blank>Message to members</a>
												<li><a href="%%webpage%%" target=_blank>Club webpage</a>
												<li><a href=?cid=%%cid%%&gallery>Gallery</a>
												</ul>
											</p>
                      </td><td width=200px>
                      <img style="border: 1px solid black;" src=/uploads/club_logos/%%logo%% width=200px align=right>
                      </td></tr></table>
										',
		'club_members' => '
				<div id=clubmembers></div>
			<script>
				var result = jQuery.parseJSON(\'%%members%%\');
				html = "<table width=100%><tr>";
        var i = 0;
				$.each(result, function(key,value) 
				{
          html += "<td valign=top width=100px><a href=?uid="+value.uid+"><img border=1 width=100px src=/uploads/user_image?uid="+value.uid+"&landscape&w=100&h=150></a></td>";
          html += "<td valign=top><a href=?uid="+value.uid+"><b>"+value.profile_firstname+" "+value.profile_lastname+"</b></a><br>"+value.roles+"<br>"+value.company_position+"<br>"+value.company_name+"<br>Mobil: "+value.private_mobile+"<br></td>";
          i++;
          if (i==2) { i=0; html += "</tr><tr>"; }					
				});
        html += "</tr></table>";
				$("#clubmembers").append(html);
			</script>
		',
		'club_board' => '<h2>Club</h2><input type=button value="Show current and former members" onclick="document.location.href=document.location.href+\'&allmembers\';">',
		'club_board_member'=>'',
		'duty_meeting_responsible_uid' => 'Responsible',
		'duty_3min_uid' => '3. minutes',
		'duty_letters1_uid' => 'Letters',
		'duty_letters2_uid' => 'Letters (2)',
		'duty_ext1_uid' => 'Ekstra',
		'duty_ext2_uid' => 'Ekstra(2)',
		'meeting_attendance_pre' => '</ul><h2>Attendance</h2>
		<p>Attendees: %%total%%. From the club: %%accepted%% - resignations from the club: %%rejected%%. Percent: %%percentage%% %</p>
		<table width=100% border=0><tr><th width=30%>Name</th><th width=20%>Status</th><th>Comment</th><th>Club</th></tr>',
		'meeting_attendance_post' => '</table>',
		'meeting_attendance_secretary_add' => '
		<hr>
		Add member: 
		<select id=accept_uid>
		<option value=0>-- choose --</option>
		</select>
		<input type=button onclick=signup() value=Add>
		<script>
			var signup_mid = 0;
			function signup()
			{
				var uid = $("#accept_uid").val();
				if (uid!=0)
				{
					document.location.href="?mid="+signup_mid+"&attendance[uid]="+uid+"&attendance[accept]=1&attendance[comment]=Added+by+secretary";
				}
			}
			function build_signup()
			{
				var data = jQuery.parseJSON(\'%%data%%\');
				signup_mid = data.mid;
				$.each(data.members, function(a,b) {
					$("#accept_uid").append("<option value="+b.uid+">"+b.profile_firstname+" "+b.profile_lastname+"</option>");
				});
			}
			build_signup();
		</script>
		',
		'meeting_attendance_yes' => 'Accepted',
		'meeting_attendance_no' => 'Declined',
		'meeting_attendance_idle' => 'Acceped',
		'meeting_attendance_item_edit' => '
															<tr>
																<td><a href=?uid=%%uid%%>%%profile_firstname%% %%profile_lastname%%</a></td>
																<td title="Svardato: %%response_date%%">%%status%% <br> 
																<a href="?mid=%%mid%%&attendance[uid]=%%uid%%&attendance[accept]=0&attendance[comment]=Resigned+by+S">Resign</a>
																<a href="?mid=%%mid%%&attendance[uid]=%%uid%%&attendance[accept]=1&attendance[comment]=Added+by+S">Accept</a>
																</td>
																<td>%%comment%%<br>Date: %%response_date%%</td>
																<td>%%club_name%%</td>
															</tr>
															',

		'meeting_attendance_item' => '
															<tr>
																<td><a href=?uid=%%uid%%>%%profile_firstname%% %%profile_lastname%%</a></td>
																<td title="Date: %%response_date%%">%%status%%</td>
																<td>%%comment%%<br>Date: %%response_date%%</td>
																<td>%%club_name%%</td>
															</tr>
		',
		'meeting_attendance_form' => '
															<h2>Sign up</h2>
															<form action=. method=post>
															<input type=hidden name=mid value=%%mid%%>
															<input type=hidden name=attendance[uid] value=%%uid%%>
															<p>
															<input type=radio name=attendance[accept] value=1 checked>Yes, I will join <br/>
															<input type=radio name=attendance[accept] value=0>No, I will not join  <br/>
															</p>
															<p>
															Comment:<br>
															<input type=text name=attendance[comment] value="" required>
															</p>
															<input type=submit value="Send">
															</form>
		',
		'save_meeting' => 'Save',
		'meeting_edit_header' => '<h1 onclick="$(\'#stools\').toggle();">Secretary tools</h1>	
															<p id=stools>
															<a href=?mid=%%mid%%&edit>Edit</a> |
															<a href=# onclick="javascript:if(confirm(\'Confirm deletion\')) document.location.href=\'?mid=%%mid%%&delete\';">Delete</a> |
															<a href=?mid=%%mid%%&minutes_edit>Edit minutes</a>
															',
		'meeting_duties' => '<a name=duty><h2>Duties</h2></a>
		<p>Letters:
		<ul>
		<li><a href=?mid=%%mid%%&collection=%%mid%% target=_blank>Letters 1</a></li>
		<li><a href=?mid=%%mid%%&collection=%%mid%%/2 target=_blank>Letters 2</a></li>
		</ul></p><hr>Responsible:
		',
		'meeting_duty' => '<li>%%duty%% - <a href=?uid=%%uid%%>%%profile_firstname%% %%profile_lastname%%</a>',
		'meeting_rating' => '<h2>Rating</h2><p>Rating: %%rating%%/10 - %%count%% votes</p>',
    'meeting_files' =>
    '
    <div id=embed></div>
    <h2>Attachments</h2>
    <ul id=download_files></ul>
    <script>
		var result = jQuery.parseJSON(\'%%files%%\');
		$.each(result, function(key,value) {
			if (value.filename.indexOf(".pdf")>0)
			{
				var file_url = "/uploads/meeting_file?mfid="+value.mfid;
				var html = "<object data="+file_url+" width=100% height=500px><p></p></object>";
				$("#embed").append(html);				
			}
      $("#download_files").append("<li><a href=/uploads/meeting_file?mfid="+value.mfid+">"+value.filename+"</a>");
    }); 
    </script>
    <h2>Photos</h2>
    ',
    'meeting_rate_form' =>
    '
    <p>Rate: <select name=rating onchange="document.location.href=\'?mid=%%mid%%&rating=\'+this.value;">
    <option>Choose</option>
    <option value=0>0 - Poorest</option>
    <option value=1>1</option>
    <option value=2>2</option>
    <option value=3>3</option>
    <option value=4>4</option>
    <option value=5>5</option>
    <option value=6>6</option>
    <option value=7>7</option>
    <option value=8>8</option>
    <option value=9>9</option>
    <option value=10>10 - Best</option>
    </select>         </p>
    ',
    'meeting_minutes' => 
		'<h2>Minutes</h2>
		<p>On: %%minutes_date%%, Participants: %%minutes_number_of_participants%%, Resigned: %%minutes_number_of_rejections%%</p>
		<div id=ref0_content><h2>Minutes</h2>
		<p>%%minutes%%</p></div>
		<div id=ref1_content><h2>3 minutes</h2>
		<p>%%minutes_3min%%</p></div>
		<div id=id=ref2_content><h2>Letters</h2>
		<p>%%minutes_letters%%</p></div>
    <script>
      if (!$("#ref0_content").html()) $("#ref0").hide();
      if (!$("#ref1_content").html()) $("#ref1").hide();
      if (!$("#ref2_content").html()) $("#ref2").hide();
    </script>
		',
		'meeting_header' => "<div align=right><a target=_blank href=?mid=%%mid%%&print title=Print><img src=/template/images/icon_print.png></a> <a href=?mid=%%mid%%&ics title='Add to calendar'><img src=/template/images/icon_calendar.png></a>&nbsp;&nbsp;&nbsp;&nbsp;</div>",
		'meeting_top_image' => '<a href="/uploads/meeting_image/?miid=%%img%%&w=800" target=_blank><img src="/uploads/meeting_image/?miid=%%img%%&landscape&w=570&h=300" width=100%></a>',
		'meeting_bottom_image' => '<a href="/uploads/meeting_image/?miid=%%img%%&w=800"  target=_blank"><img src="/uploads/meeting_image/?miid=%%img%%&landscape&w=570&h=300"></a>',
		'meeting_invite' => '
												<h1>%%title%%</h1><a href="?cid=%%cid%%"><h2>%%name%%</h2></a>
												<p>%%meeting_description%%</p>
												<p>Start: %%start_time%%, End: %%end_time%%</p>
												<h2>Location</h2>
												<table width=100%>
												<tr>
												<td valign=top>%%location%%</td>
												<td valign=top width=400><div id=locmap></div></td>
												</tr></table>
												<script>
												function locate(what)
												{
													if (what=="") return;
													var url = "/scripts/rtd/geocodeproxy.php?address=="+what+"&sensor=false";
													
													$.ajax( url ).done(function(data) 
													{ 
														var result = jQuery.parseJSON(data);
														var lat = -1;
														var lng = -1;
														var found=false;
														$.each(result.results, function(k,v) {
															lat = v.geometry.location.lat;
															lng = v.geometry.location.lng;
															found=true;
														});
														if (!found) 
														{
															$("#locmap").html("<i>No map!</i>");
														}
														else {
															var whaturl = encodeURI(what);
															
															var img = "http://maps.googleapis.com/maps/api/staticmap?center="+whaturl+"&zoom=11&size=400x400&maptype=roadmap&markers=color:blue|label:O|"+lat+","+lng+"&sensor=false";
															var url = "https://maps.google.dk/?q="+whaturl;
															$("#locmap").html("<a href=\""+url+"\" target=_blank><img src=\""+img+"\"/></a>");
														}
													});																										
												}
												
												locate("%%location%%");
												</script>
												',
		'meeting_edit' => '
											<h1>Edit meeting</h1>
											<table width=100%>
											<tr>
											<td valign=top>
											<p>Title<br>
											<input class=field type=text name=meeting[title] value="%%title%%"></p>
											
											<p>Start<br>
											<input class=field type=text name=meeting[start_time] value="%%start_time%%" id=start_time></p>
											<p>End<br>
											<input class=field type=text name=meeting[end_time] value="%%end_time%%" id=end_time></p>
											</td>
											<td valign=top width=300>
											<p>Location<br>
											<input class=field id=loctext type=text name=meeting[location] value="%%location%%" onkeyup=locate(this.value);></p>
											<div id=locmap></div>
											</td></tr></table>
											<h2>Text</h2>
											<textarea name=meeting[description] class=ckeditor>%%meeting_description%%</textarea>
											<h2>Duties</h2>

											<p>3 minutes<br>
											<select name=meeting[duty_3min_uid] id=duty_3min_uid class=userlookup value="%%duty_3min_uid%%">%%member_select%%</select></p>
											<p>Letters 1<br>
											<select name=meeting[duty_letters1_uid] id=duty_letters1_uid class=userlookup value="%%duty_letters1_uid%%">%%member_select%%</select></p>
											<p>Letters 2<br>
											<select name=meeting[duty_letters2_uid] id=duty_letters2_uid class=userlookup value="%%duty_letters2_uid%%">%%member_select%%</select></p>
											<p>Responsible<br>
											<select name=meeting[duty_meeting_responsible_uid] id=duty_meeting_responsible_uid class=userlookup value="%%duty_meeting_responsible_uid%%">%%member_select%%</select></p>
											
											<h2>Other duties</h2>
											<p>Duty #1
											<ul>
											<p>Description<br>
											<input class=field type=text name=meeting[duty_ext1_text] id=duty_ext1_text class=userlookup value="%%duty_ext1_text%%"></p>
											<p>Responsible<br>
											<select name=meeting[duty_ext1_uid] id=duty_ext1_uid class=userlookup value="%%duty_ext1_uid%%">%%member_select%%</select></p>
											</ul>
											</p>

											<p>Duty #2
											<ul>
											<p>Description<br>
											<input class=field type=text name=meeting[duty_ext2_text] id=duty_ext2_text class=userlookup value="%%duty_ext2_text%%"></p>
											<p>Responsible<br>
											<select name=meeting[duty_ext2_uid] id=duty_ext2_uid class=userlookup value="%%duty_ext2_uid%%">%%member_select%%</select></p>
											</ul>
											</p>
												
											<p>Duty #3
											<ul>
											<p>Description<br>
											<input class=field type=text name=meeting[duty_ext3_text] id=duty_ext3_text class=userlookup value="%%duty_ext3_text%%"></p>
											<p>Ansvarlig<br>
											<select name=meeting[duty_ext3_uid] id=duty_ext3_uid class=userlookup value="%%duty_ext3_uid%%">%%member_select%%</select></p>
											</ul>
											</p>
												
											<p>Duty #4
											<ul>
											<p>Description<br>
											<input class=field type=text name=meeting[duty_ext4_text] id=duty_ext4_text class=userlookup value="%%duty_ext4_text%%"></p>
											<p>Responsible<br>
											<select name=meeting[duty_ext4_uid] id=duty_ext4_uid class=userlookup value="%%duty_ext4_uid%%">%%member_select%%</select></p>
											</ul>
											</p>
											
											<h2>Photos</h2>
											<p>Add (jpg/png/gif)<br>
											<input type="file" name="file" id="file" /></p>
											<h2>Invitation</h2>
											<p><input type=checkbox name=send_invitations id=send_invitations>Send invitation to members</p>
												
											
											<script>
												function locate(what)
												{
													if (what=="") return;
													var url = "/scripts/rtd/geocodeproxy.php?address=="+what+"&sensor=false";
													
													$.ajax( url ).done(function(data) 
													{ 
														var result = jQuery.parseJSON(data);
														var lat = -1;
														var lng = -1;
														var found=false;
														$.each(result.results, function(k,v) {
															lat = v.geometry.location.lat;
															lng = v.geometry.location.lng;
															found=true;
														});
														if (!found) 
														{
															$("#locmap").html("<i>Not found</i>");
														}
														else {
															var whaturl = encodeURI(what);
															var img = "http://maps.googleapis.com/maps/api/staticmap?center="+whaturl+"&zoom=11&size=255x255&maptype=roadmap&markers=color:blue|label:O|"+lat+","+lng+"&sensor=false";
															var url = "https://maps.google.dk/?q="+whaturl;
															$("#locmap").html("<a href=\""+url+"\" target=_blank><img src=\""+img+"\"/></a>");
														}
													});																										
												}
												
												locate($("#loctext").val());
												
												$(function() {
													$("#duty_3min_uid").val("%%duty_3min_uid%%");
													$("#duty_letters1_uid").val("%%duty_letters1_uid%%");
													$("#duty_letters2_uid").val("%%duty_letters2_uid%%");
													$("#duty_meeting_responsible_uid").val("%%duty_meeting_responsible_uid%%");
													$("#duty_ext1_uid").val("%%duty_ext1_uid%%");
													$("#duty_ext2_uid").val("%%duty_ext2_uid%%");
													$("#duty_ext3_uid").val("%%duty_ext3_uid%%");
													$("#duty_ext4_uid").val("%%duty_ext4_uid%%");
												
													$("#start_time").datetimepicker({dateFormat:"yy-mm-dd",timeFormat:"HH:mm:ss"});
													$("#end_time").datetimepicker({dateFormat:"yy-mm-dd",timeFormat:"HH:mm:ss"});
													
													$("#start_time").change(
														function() {
															$("#end_time").val( $("#start_time").val() );
														}
													);
												});
												
												function validatemeeting()
												{
													if ($("#send_invitations").is(":checked"))
													{
														return confirm("Confirm: Save and send to members");
													}
													else
													{
														return confirm("Confirm: Save without sending to members");
													}
												}
											</script>
											',		
		'country_all_country' => 'Whole country',
		'country_all_district' => 'Whole area',
		'country_latest_minutes' => '<h2>Latest minutes</h2>			
				<div class="slider-wrapper theme-bar"><div id="country_future_minutes"></div></div>
        <div id=country_titles></div>
		',
		'country_future_minutes_item' => 
		'
			<script>
				var result = jQuery.parseJSON(\'%%data%%\');
				html = "";
        titles = "";
				$.each(result, function(key,value) 
				{
					html += "<img src=/uploads/meeting_image/?miid="+value.image+"&landscape&w=570&h=300 title=\"#mid-title-"+value.mid+"\"/>";
          titles += "<div class=\"nivo-html-caption\" id=\"mid-title-"+value.mid+"\"><a href=?mid="+value.mid+" style=\"color: white;\">"+value.start_time+": "+value.title+", "+value.name+"</a></div>";
				});
				$("#country_future_minutes").append(html);
        $("#country_titles").append(titles);
				$("#country_future_minutes").nivoSlider();
			</script>
		',
		'country_future_meeting_item_pic' => '<img src="/uploads/meeting_image/?miid=%%miid%%&landscape&w=570&h=300" width=100%>',
		'country_future_meeting_item_no_pic' => '',
		'country_future_meeting_item' => '<li><a href=?mid=%%mid%%>%%start_time%%: %%title%%, %%name%%</a></li>',
		'country_future_meetings' => '<h2>Future meetings</h2>
		<table width=100% id=future_meetings>
		</table>
		<script>
			var future_meetings = jQuery.parseJSON("%%data%%");
			var c = -1;
			var fm_html = "<tr>";
			$.each(future_meetings, function(k,v) {
				var img = v.images[0]?v.images[0].miid:"1";
				fm_html += 
					"<td valign=top width=150>"
					+"<a href=?mid="+v.mid+">"
					+"<img src=/uploads/meeting_image/?miid="+img+"&quad&s=150>"
					+"</a>"
					+"</td>"
					+"<td valign=top>"
					+"<a href=?mid="+v.mid+">"
					+v.title
					+"</a>"
					+"<br>"
					+v.start_time
					+"<br>"
					+v.name
					+"</td>";
				
				if ((c%2) == 0)	fm_html += "</tr>\n";
				c++;
			});
			
			fm_html += "</tr>";
			
			$("#future_meetings").append(fm_html);
		</script>
		',
		'country_choose_district' => '<b>Choose area</b><br>',
		'country_choose_club' => '<b>Choose club</b><br>',
		'country_header' => '<h1>Whole country</h1>',
		
		'login_pretext' => '<h3>Login</h3>',
		'login_prompt' => '
			<div id=normal_login>
			<h3>Login</h3>
			<center>
			<form action=/ method=post>
			<input type=hidden name=login value=now>
			<input type=hidden name=redirect value="%%REQUEST_URI%%">
			<input class=bar type=text id=login_username name=username value="" onfocus="this.value=\'\';"><br>
			<input class=bar type=password id=login_password name=password value=""><br>
			
			<input type=submit value="Login"> <input type=checkbox name=remember> Remember me <br>
			<a href=# onclick="send_password();">Lost password</a> |
			<a href=# onclick="mummy_login();">Ex-table login</a><br/>
			</form>
			</center>
			
			</div>
			<div id=mummy_login style="display:none">
				<h3>Ex-table</h3>
				<center>
				<form action=?mummy method=post>
				<input type=text class=bar  name=club placeholder="Club (eg. RT132)"><br>
				<input type=password class=bar name=password><br>
				<input type=submit value="Login"><br>
				<a href="/?aid=3">Lost password</a> |
				<a href=# onclick="normal_login();">Login</a><br/>
				</center>
				</form>			
			</div>
			
			
			
			<script>
			function normal_login()
			{
				$("#mummy_login").hide("slow");
				$("#normal_login").show("slow");
			}
			function mummy_login()
			{
				$("#normal_login").hide("slow");
				$("#mummy_login").show("slow");
			}
			function verify_login()
			{
				if ($("#login_username").val()=="" || $("#login_password").val()=="")
				{
					alert("Missing username and password");
					return false;
				}
				return true;
			}
			function send_password()
			{
				var m = prompt("Enter username or email and we will reset your passwird:");
				if (m && m!="") document.location.href="?sendpassword="+m;
			}
			</script>
			',
		'login_incorrect' => '<p><font color=white>Bad credentials</font></p>',
		'login_content_test' => '
												<h3>MEDLEM</h3>
												<div class=profile>
                        <a href=?uid=%%uid>%%profile_firstname%% %%profile_lastname%%</a>
                        <a href=?logout>Log af</a> | <a href=?uid=%%uid%%&edit>Rediger</a>
						<br>
                      <hr>                    
						<span id=notify_link></span><br>
												
                        <a href=?cid=%%cid%%>Min klub</a><br>
  												
												</div>
<script src=/scripts/rtd/notification.js.php></script>',

		'login_content' => '
												<h3>MEMBER</h3>
												<div class=profile id=profilebox>
                        <a href=?uid=%%uid%%>%%profile_firstname%% %%profile_lastname%%</a><br>
                        <a href=?logout>Log off</a> | <a href=?uid=%%uid%%&edit>Edit</a> | <a href=?cid=%%cid%%>Club</a>
						<br>
                        <hr>Duties:<div id=duty_field class=stats></div>
                        <script>
							var dutydata = jQuery.parseJSON(notification_update_json);
							var cnt = 0;
							$.each(dutydata, function(key,value) {
								cnt++;
								var d = new Date(value.start_time);
								$("#duty_field").append("<li><a href=\"?mid="+value.mid+"#duty\" title=\""+value.title+" ("+value.start_time+")\">"+value.duty+"</a>");
							});
							if (cnt==0) $("#duty_field").append("<li><i>Ingen</i>");
						</script>
												</div>
',
'nomination_reject_subj' => 'Nomination for %%rejected_role%% rejected',
'nomination_reject_body' => 'Nomination of %%profile_firstname%% %%profile_lastname%% for %%rejected_role%% has been rejected.',
'nomination_accept_subj' => 'Nomination for %%accepted_role%% approved',
'nomination_accept_body' => 'Nomination of %%profile_firstname%% %%profile_lastname%% for %%accepted_role%% has been approved.',
		'nominations' => '
			<h1>Nominations %%role%%</h1>
				<h2>Add role</h2>
				<ul id=addrole>
				</ul>
			<script>
				var roledata = jQuery.parseJSON(\'%%result%%\');
				$.each(roledata.add, function(key,value)
				{
					$("#addrole").append(
						"<li>"+
						value.profile_firstname+
						" "+
						value.profile_lastname+
						", "+
						value.club+
						"<br> Start: "+
						value.date_start+
						", End: "+
						value.date_end+
						", Birth date: "+
						value.profile_birthdate+						
						"<br>Comment: <i>"+
            value.nominator_comment+"</i><br>"+
						"<a href=?nominations="+value.rid+"&nid="+value.nid+">Approve %%role%%</a> | <a href=?nominations="+value.rid+"&nid="+value.nid+"&reject>Reject %%role%%</a><br><br>"
					);
				});
			</script>
		',
		'admin_takeover' => 'Takeover profile',
		'admin_box_national_board' => '
		<ul id=nbmenu>
			<li class=parent>
				<a href=#>HB</a>
				<ul>
					<li><a href=/uploads/article_file/?afid=49>Help</a></li>
					<li><a href=?admin_download=newboards>Future board</a></li>
					<li><a href=?admin_download=future>Download: Future board</a></li>
					<li><a href=?admin_download=active&xml>Download: Members</a></li>
					<li><a href=?admin_download=clubs>Download: Clubs</a></li>
					<li><a href=?admin_download=newsletter>News letters</a></li>	
				</ul>
			</li>				
		</ul>
		',
		'admin_box_secretary' => '
		<ul id=secretarymenu>
			<li class=parent>
				<a href=#>Secretary</a>
				<ul>
					<li><a href=/uploads/article_file/?afid=50>Help</a></li>
					<li><a href=?uid=-1>Create member</a></li>
					<li><a href=?mid=-1>Create meeting</a></li>
          <li><a href=?omid>Create other event</a></li>
					<li><a href=?kbp>Future board</a></li>
					<li><a href=?cid=%%cid%%#nominutes>Create minute</a></li>					
					<li><a href=?dashboard>Dashboard</a></li>
					<li><a href=?cid=%%cid%%&edit>Edit club</a></li>
				</ul>
			</li>				
		</ul>
		',
		'admin_box' => '
			<ul id=adminmenu>
				<li class=parent><a href=#>Admin</a>
				<ul>
          <li><a href=?cid=-1>Create club</a>
					<li><a href=?reports>Reports</a>
 					<li><a href=?admin_download=all>XML: Members</a>
 					<li><a href=?admin_download=xtable>XML: X-table</a>
					<li><a href=?takeover>Takeover profile</a></li>
					<li><a href=?nominations=26>Honorary</a></li>
					<li><a href=?nominations=38>Club TOTY</a></li>
					<li><a href=?admin=article&edit=-1>Create article</a></li>
					<li><a href=?admin_download=newsletter>News letter</a></li>
					<li><a href=/cronjob.php?pwd=k4rk1ud>Start cronjob</a></li>
					<li><a href=?admin_download=sysstat>System status</a></li>
					<li><a href=?admin_download=stalker>Stalker</a></li>
					<li><a href=?admin_download=backup_db>Backup DB</a></li>
					<li><a href=/scripts/sqlbuddy target=_blank>DB Admin</a></li>
					<li><a href=?admin_download=sms>SMS Admin</a></li>
				</ul></li>
			</ul>
		<script>
			var admincontent = jQuery.parseJSON(\'%%articles%%\');
			
			function admin_walk(data)
			{
				var html = "";
				$.each(data, function(key,value) 
				{
					html += "<li><a href=?admin=article&edit="+value.aid+">Rediger: "+value.title+"</a>";
					if (value.children instanceof Object && value.children.length>0)
					{
						html += "<ul>";
						html += admin_walk(value.children);
						html += "</ul>";
					}
					html += "</li>";
				});
				return html;
			}
			
//			$("#adminarticles").append(admin_walk(admincontent.articles));
//			$("#adminmenu").menu();
		</script>
		',
		'admin_required' => 'Not admin',
		'article_edit' => 'Edit article',
		'article_title' => 'Title',
		'article_public' => 'Public',
		'article_private' => 'Private (members only)',
		'article_content' => 'Text',
		'article_save' => 'Save',
		'article_last_update' => 'Latest update: ',
		'article_access' => 'Access',
		'login_username' => 'Username',
		'login_password' => 'Password',
		'login_login' => 'Login &raquo;',
		'dialog_error' => 'Error',
		'article_placement' => 'Placement',
		'article_weight' => 'Weight (0=top, 10=bund)',
		'article_parent' => 'Parent',
		'article_must_be_logged_in' => 'Not logged in',
		'article_pretext' => '',
		'no_access' => '<h1>No access</h1><p>Insufficient rights to performed the chosen action.</p>'
	);
	
	function term($t)
	{
		
		global $terms;
		if (isset($terms[$t])) 
		{
			if (isset($_REQUEST['term_debug'])) return "{$t}:{$terms[$t]}";
			return $terms[$t];
		}
		else die("Term: $t not defined - please do so in config_terms.php");
	}
	
	function term_unwrap($t, $data, $json=false)  
	{
		$str = term($t);
		if (!empty($data))
		{
			if (!$json)
			{
				foreach($data as $key => $value)
				{
					if (!is_array($value)) $str = str_replace("%%$key%%", $value, $str);
				}
			}
			else
			{
				$str = str_replace("%%data%%", addslashes(json_encode($data)), $str);
			}
		}
		if (isset($_REQUEST['term_debug'])) return "{$t}:$str";
		else return $str;
	}
?>