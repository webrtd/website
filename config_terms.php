<?php
	$terms = array(
    'rtidatahub_js' => '
			{
				var nationalboard_json = "%%NATIONALBOARD%%";
				var meeting_json = "%%MEETING%%";
				var table_json = "%%TABLE%%";

				var nationalboard = $.parseJSON(nationalboard_json);
				var meeting = $.parseJSON(meeting_json);
				var tables = $.parseJSON(table_json);


				document.write("<div id=tabs><ul><li><a href=#rti_nb>Hovedbestyrelser</a></li><li><a href=#rti_tab>Klubber</a></li><li><a href=#rti_meeting>Møder</a></li></ul>");

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
	'club_message_title' => 'Besked til %%name%%',
	'club_message_body' =>
'%%message%%
---
Fra %%sender%%
http://rtd.dk/?uid=%%uid%%
',
	'club_message_prepare_send_club_admin' => '
		<h4>Send besked til klubbens aktive medlemmer</h4>
		<form action=?cid=%%cid%% method=post >
		<center>
		<textarea name=message style="width:99%;height:200px" class="form-control"></textarea>
		</center>
		<input type=checkbox value=sms name=sms class="form-control">Send som SMS
		<input type=submit value="Send besked" class="btn">
		</form>
	',
	'club_message_prepare_send' => '
		<h4>Send besked til klubbens aktive medlemmer</h4>
		<form action=?cid=%%cid%% method=post >
		<center>
		<textarea name=message style="width:99%;height:200px" class="form-control"></textarea>
		</center>
		<input type=submit value="Send besked" class="btn">
		</form>
	',
	'club_message_sent' => '
		<h1>Besked afsendt til klubbens aktive medlemmer</h1>
		<i>%%message%%</i>
	',
	'club_gallery' => '
		<h1 style="clear:both;">Galleri</h1>
        <div class="row gallery">
        </div>
		<!--<a name=gallery><div style="height: 330px; overflow: scroll; overflow-x: hidden;" id=gallery></div><br></a>-->
		<img src="/template/images/logo.png" id=gallery_pic>
		<script>
            var host = "<?php echo $_SERVER["HTTP_HOST"]; ?>";
			var gallery_data = jQuery.parseJSON(\'%%data%%\');
			var gallery_html = "";
            //alert(host);
			$.each(gallery_data, function(i,v) {                
				gallery_html = gallery_html + "<div class=col-sm-4><div class=thumbnail><a class=\"fancybox\" rel=\"gallery1\" href=/uploads/meeting_image/?miid="+v.miid+"><img src=/uploads/meeting_image/?miid="+v.miid+"&quad&s=200></a></div></div>";
			});

			$(".gallery.row").append(gallery_html);            
            
			function gallery_show(miid)
			{
				$("#gallery_pic").attr("src", "/uploads/meeting_image/?miid="+miid);
			}

		</script>

	',//http://rtd.dk/uploads/user_image?uid=9353&quad&s=200
  'organisation_fullname' => 'Round Table Danmark',
  'organisation_shortname' => 'RTD',
	'banner_1' => "
<!--/* OpenX Javascript Tag v2.8.10 */-->
<div class='banner1 mybanners'>
<script type='text/javascript'><!--//<![CDATA[
   var m3_u = (location.protocol=='https:'?'https://openx.rtd.dk/openx/www/delivery/ajs.php':'http://openx.rtd.dk/openx/www/delivery/ajs.php');
   var m3_r = Math.floor(Math.random()*99999999999);
   if (!document.MAX_used) document.MAX_used = ',';
   document.write (\"<scr\"+\"ipt type='text/javascript' src='\"+m3_u);
   document.write (\"?zoneid=3\");
   document.write ('&amp;cb=' + m3_r);
   if (document.MAX_used != ',') document.write (\"&amp;exclude=\" + document.MAX_used);
   document.write (document.charset ? '&amp;charset='+document.charset : (document.characterSet ? '&amp;charset='+document.characterSet : ''));
   document.write (\"&amp;loc=\" + escape(window.location));
   if (document.referrer) document.write (\"&amp;referer=\" + escape(document.referrer));
   if (document.context) document.write (\"&context=\" + escape(document.context));
   if (document.mmm_fo) document.write (\"&amp;mmm_fo=1\");
   document.write (\"'><\/scr\"+\"ipt>\");
//]]>--></script><noscript><a href='http://openx.rtd.dk/openx/www/delivery/ck.php?n=ab3a97c8&amp;cb=INSERT_RANDOM_NUMBER_HERE' target='_blank'><img src='http://openx.rtd.dk/openx/www/delivery/avw.php?zoneid=3&amp;cb=INSERT_RANDOM_NUMBER_HERE&amp;n=ab3a97c8' border='0' alt='' /></a></noscript>
</div>
	<script>
			/*$(document).ready(function(){
				//$('.right-part').parent().prepend('<div class=\'col-xs-12 col-xs-4 col-md-2\' id=banners></div>');
				//$('#banners').append($('.banner2'));
			});*/

		</script>

	",
	'banner_2' => "
<!--/* OpenX Javascript Tag v2.8.10 */-->
	<div class='banner2 mybanners'>
<script type='text/javascript'>
<!--//<![CDATA[
   var m3_u = (location.protocol=='https:'?'https://openx.rtd.dk/openx/www/delivery/ajs.php':'http://openx.rtd.dk/openx/www/delivery/ajs.php');
   var m3_r = Math.floor(Math.random()*99999999999);
   if (!document.MAX_used) document.MAX_used = ',';
   document.write (\"<scr\"+\"ipt type='text/javascript' src='\"+m3_u);
   document.write (\"?zoneid=2\");
   document.write ('&amp;cb=' + m3_r);
   if (document.MAX_used != ',') document.write (\"&amp;exclude=\" + document.MAX_used);
   document.write (document.charset ? '&amp;charset='+document.charset : (document.characterSet ? '&amp;charset='+document.characterSet : ''));
   document.write (\"&amp;loc=\" + escape(window.location));
   if (document.referrer) document.write (\"&amp;referer=\" + escape(document.referrer));
   if (document.context) document.write (\"&context=\" + escape(document.context));
   if (document.mmm_fo) document.write (\"&amp;mmm_fo=1\");
   document.write (\"'><\/scr\"+\"ipt>\");
//]]>--></script><noscript><a href='http://openx.rtd.dk/openx/www/delivery/ck.php?n=a7db3e4b&amp;cb=INSERT_RANDOM_NUMBER_HERE' target='_blank'><img src='http://openx.rtd.dk/openx/www/delivery/avw.php?zoneid=2&amp;cb=INSERT_RANDOM_NUMBER_HERE&amp;n=a7db3e4b' border='0' alt='' /></a></noscript>
	</div>
	<script>
		/*$(document).ready(function(){
			//$('.right-part').parent().prepend('<div class=\'col-xs-12 col-xs-4 col-md-2\' id=banners></div>');
			//$('#banners').append($('.banner2'));
		});*/

	</script>
	",
	'banner_3' => "
<!--/* OpenX Javascript Tag v2.8.10 */-->
<div class='banner3 mybanners'>
<script type='text/javascript'><!--//<![CDATA[
   var m3_u = (location.protocol=='https:'?'https://openx.rtd.dk/openx/www/delivery/ajs.php':'http://openx.rtd.dk/openx/www/delivery/ajs.php');
   var m3_r = Math.floor(Math.random()*99999999999);
   if (!document.MAX_used) document.MAX_used = ',';
   document.write (\"<scr\"+\"ipt type='text/javascript' src='\"+m3_u);
   document.write (\"?zoneid=1\");
   document.write ('&amp;cb=' + m3_r);
   if (document.MAX_used != ',') document.write (\"&amp;exclude=\" + document.MAX_used);
   document.write (document.charset ? '&amp;charset='+document.charset : (document.characterSet ? '&amp;charset='+document.characterSet : ''));
   document.write (\"&amp;loc=\" + escape(window.location));
   if (document.referrer) document.write (\"&amp;referer=\" + escape(document.referrer));
   if (document.context) document.write (\"&context=\" + escape(document.context));
   if (document.mmm_fo) document.write (\"&amp;mmm_fo=1\");
   document.write (\"'><\/scr\"+\"ipt>\");
//]]>--></script><noscript><a href='http://openx.rtd.dk/openx/www/delivery/ck.php?n=a14fdb7c&amp;cb=INSERT_RANDOM_NUMBER_HERE' target='_blank'><img src='http://openx.rtd.dk/openx/www/delivery/avw.php?zoneid=1&amp;cb=INSERT_RANDOM_NUMBER_HERE&amp;n=a14fdb7c' border='0' alt='' /></a></noscript>
	</div>
	<script>
		$(document).ready(function(){
			//$('#banners').append($('.banner3'));
		});

	</script>
	",
	'not_club_board_submission_period' => '<h1>Kan ikke indstille bestyrelse</h1><p>Det er kun muligt at indstille kommende bestyrelse i perioden 1. april - 30. juni</p>',
	'birthday_js' => '
	{
		$("#birthdaymemberss").css("display","block");
		if($("#birthdaymembers").length > 0)
		{
			var birthday_data = jQuery.parseJSON(\'%%data%%\');
			$("#birthdaymemberss").show();
            //var home_birth_content = "<div class=\"title title-section\"><h2>Dagens F&oslash;dselarer</h2><p>Tillykke med dagen til alle</p><span class=sticker><i class=\"icon fa fa-flag\"></i></span></div>";

			var c = 0;
			var html = "";
			html += "<div class=row>";
			$.each(birthday_data, function(i,m) {

				if (m.profile_image!=null && m.profile_image!="")
				{
                    var profile_firstname = "";
                    if(m.profile_firstname != "" && m.profile_firstname != null)
                    {
                        profile_firstname = m.profile_firstname;
                    }
                    else
                    {
                        profile_firstname = "";
                    }

                    var profile_lastname = "";
                    if(m.profile_lastname != "" && m.profile_lastname != null)
                    {
                        profile_lastname = m.profile_lastname;
                    }
                    else
                    {
                        profile_lastname = "";
                    }

                    var company_position = "";
                    if(m.company_position != "" && m.company_position != null)
                    {
                        company_position = m.company_position;
                    }
                    else
                    {
                        company_position = "";
                    }

					html += "<div class=\"col-xs-4 col-xs-2 col-md-2\"><div class=\"col-sm-offset-2 simplemember\"><div class=member-heading><a class=userpic href=?uid="+m.uid+" title=\'"+m.profile_birthdate+"\'><span class=\"btn btn-icon-user\"></span><img src=/uploads/user_image?uid="+m.uid+"&landscape&w=300&h=500></a><div class=title><h5><a href=?uid="+m.uid+">"+profile_firstname+" "+profile_lastname+"</a></h5><p>"+company_position+"</p></div></div></div></div>";
					c++;
				}
				if (c==5)
				{
					c=0;
					html += "";
				}
			});
				html += "</div>";
				$("#birthdaymemberss.container").append(html);

                //$(home_birth_content).insertBefore("#birthdaymemberss .row");
		}
	}
	',

	'report_club_jubilee_header' => '<h1>Klubjubilæer</h1>',
	'report_club_jubilee_year' => '<h2>%%year%% år</h2>',
	'report_club_jubilee_club' => '
		<li>
			%%club%%, %%district%%, chartret %%charter_date%% af %%charter_club%%
		</li>
	',
	'report_member_jubilee_header' => '<h1>Medlemsjubilarer</h1>',
	'report_member_jubilee_year' => '<h2>%%year%% år</h2>',
	'report_member_jubilee_member' => '
		<li>%%profile_firstname%% %%profile_lastname%%,
		chartret %%profile_started%%,
		%%district%%, %%club%%</li>
	',
  'create_other_meeting' => '
  <h1>Opret andre møder</h1>
  <p>Bem&aelig;rk: M&oslash;der af denne type vil ikke blive inkluderet i m&oslash;destatistikken. Invitationen udsendes umiddelbart efter m&oslash;det er oprettet.</p>
  <hr>
  <form action=?omid=-1 method=post>
  <table border=0 cellspacing=0 cellpadding=5>
  <tr>
    <td valign=top>
    Overskrift:<br>
    <input class="field form-control" type=text name=data[title]><br>
    Lokation:<br>
    <input class="field form-control" type=text name=data[location]><br>
    </td>
    <td valign=top>
    Starttidspunkt:<br>
    <input class="field form-datepicker form-control" type=text name=data[start_time] value="" id=start_time><br>
    Sluttidspunkt:<br>
    <input class="field form-datepicker form-control" type=text name=data[end_time] value="" id=end_time><br>
    </td>
  </tr>
  </table>
  Invitation:<br>
  <textarea class=ckeditor name=data[description]></textarea><br>
  <input type=submit value=Opret class=btn>
  </form>
  <script>
												$(function() {
													$("#start_time").datetimepicker({dateFormat:"yy-mm-dd",timeFormat:"HH:mm:ss"});
													$("#end_time").datetimepicker({dateFormat:"yy-mm-dd",timeFormat:"HH:mm:ss"});
												});
  </script>
  ',
	'reports' => '<h1>Rapporter</h1>
	<p>Udtræk af medlemskartoteket</p>
	<ul>
        <li><a href=?reports&f=networker>RTD Networker data</a>
		<li><a href=?reports&f=post>Adresseudtræk til bl.a. Excalibur (medlemmer+æm)</a>
		<li><a href=?reports&f=memberstat>Medlemsstatistik</a>
		<li><a href=?reports&f=clubs>Klubdata</a>
		<li><a href=?reports&f=members>Medlemsudtræk</a>
		<li><a href=?reports&f=jubilees>Klub- og medlemsjubilæer</a>
		<li><a href=?reports&f=rti>Udtræk til Hvid Bog (RTI)</a>
        <li><a href=?admin_download=roleprint>Udskrift af aktive roller</a>
		<li><a href=?admin_download=futureroleprint>Udskrift af kommende roller</a>
	</ul>
	',
	"user_viewed" => '
	<div class="container container-image user_list" style="background-image:url(img/Light-Rays-Dark-Blue-Background.jpg)">
		<div class="title title-section">
			<h2>ANDRE DER HAR SET DENNE PROFIL</h2>
			<span class="sticker">
				<i class="icon icomoon-users"></i>
			</span>
		</div><!-- .title.title-section -->
		<div id=peek class=row></div>
		<script>
			var peekers = jQuery.parseJSON(\'%%data%%\');
			var peekhtml = "";
			
			$.each(peekers, function(i,m) {
                var profile_firstname = "";
                if(m.profile_firstname != "" && m.profile_firstname != null)
                {
                    profile_firstname = m.profile_firstname;
                }
                else
                {
                    profile_firstname = "";
                }

                var profile_lastname = "";
                if(m.profile_lastname != "" && m.profile_lastname != null)
                {
                    profile_lastname = m.profile_lastname;
                }
                else
                {
                    profile_lastname = "";
                }

                var company_position = "";
                if(m.company_position != "" && m.company_position != null)
                {
                    company_position = m.company_position;
                }
                else
                {
                    company_position = "";
                }


			 peekhtml += "<div class=\"col-xs-4 col-xs-2 col-md-2\"><div class=\"22 simplemember\"><div class=member-heading><a href=?uid="+m.uid+" class=userpic><span class=\"btn btn-icon-user\"></span><img src=/uploads/user_image?uid="+m.uid+"&landscape&w=300&h=300 alt="+m.profile_firstname+"></a><div class=title><h5><a href=?uid="+m.uid+">"+profile_firstname+" "+profile_lastname+"</a></h5><p>"+company_position+"</p></div></div></div></div>";
			 });

			$("#peek").append(peekhtml);
		</script>
	</div>
	',
	"admin_sysstat" => '
	<h1>Tid</h1>
	Servertid: %%time%%
	<h1>Fejl </h1>
	<div class="feji">
	%%syslog%%
	</div>
	<h1>Mailk&oslash;</h1>
	<button class="btn btn-info margin-btm" onclick="document.location.href=\'?admin_download=sysstat&clear_mail_queue=true\';">Slet mailk&oslash;</button>
	%%mailqueuesize%%
    <div class="sub_rec">
	%%mailqueue%%
    </div>
	<h1>Udsendt mail</h1>
	<div style="height: 330px; overflow-y: scroll;">
	%%mailsent%%
	</div>
	<h1>Cronjob</h1>
	%%log%%
	<h1>Popul&aelig;resider</h1>
	%%popularpages%%
	<h1>Popul&aelig;res&oslash;gninger</h1>
	%%popularsearch%%
	',
	'randomuser_js' => '    
	document.write("<div class=\"col-xs-12 random_mem col-sm-offset-2\"><div id=duty_field class=stats></div><div class=member><div class=member-heading><a href=?uid=%%uid%% class=userpic><span class=\"btn btn-icon-user\"></span>");
	document.write("<img src=/uploads/user_image?uid=%%uid%%&landscape&w=300&h=500></td><td>");
	document.write("<div class=title><h3><a href=?uid=%%uid%%>%%profile_firstname%% %%profile_lastname%%</a></h3>");
	document.write("%%company_position%%, ");
	document.write("<p>%%company_name%%</p>");
	document.write("</div></a></div></div></div>");
	$(".statistik h2").text("Statistik");
	$(".statistik_content").addClass("col-xs-8");
  
        var dutydata = jQuery.parseJSON(notification_update_json);
        var cnt = 0;
        $.each(dutydata, function(key,value) {
        cnt++;
        var d = new Date(value.start_time);
        $("#duty_field").append("<li><a href=\"?mid="+value.mid+"#duty\" title=\""+value.title+" ("+value.start_time+")\">"+value.duty+"</a>");
        });
        if (cnt==0) $("#duty_field").append("<li><i>Ingen</i>");  
	',
	'user_on_leave_subj' => 'Orlov fra RTD - %%profile_firstname%% %%profile_lastname%%',
	'user_on_leave_body' => 'Dags dato er %%profile_firstname%% %%profile_lastname%% på orlov fra RTD. Se mere på http://rtd.dk/?uid=%%uid%%',
	'users_missing_email_subj' => '%%name%% - medlemmer med ugyldig email',
	'update_clubmail' => '
	<form action=?admin_download=clubmail method=post enctype="multipart/form-data" class="clubmail_cls">
	<p>Gå til mailadmin.wannafind.dk og download XML fil og indlæs nedenfor:</p>
	<input type=file name=clubmail>
	<input type=submit class="btn">
	</form>
	',
	'district_calendar_show' =>
	'<p><a class="btn dis_btn_link" href="?cal=%%name%%">Vis m&oslash;der i kalender</a></p>',
	'calendar_map' => '
	<h1>Kalender %%title%%</h1>
	Dato:
	<select id=e onchange=show_date(this.value);></select>
	<div id=map-canvas></div>
	<div id=locmap></div>
	 <script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAcfr95hzse9yjWMC_TX-WSJY9IxOp3C2o&sensor=true">
    </script>

	  <script>
		var mapOptions = {
			zoom: 8,
			center: new google.maps.LatLng(-34.397, 150.444),
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
					$("#locmap").html("<i>Kunne ikke finde adressen. Indtast f.eks. Christiansborg, 1240 København K</i>");
				}
				else {
					var img = "http://maps.googleapis.com/maps/api/staticmap?center="+what+"&zoom=col-sm-offset-2&size=255x255&maptype=roadmap&markers=color:blue|label:O|"+lat+","+lng+"&sensor=false";
					var url = "https://maps.google.dk/?q="+what;
					$("#locmap").html("<a href=\""+url+"\" target=_blank><img src=\""+img+"\"/></a>");
				}
			});
		}

		</script>
	',
	'calendar' =>
	"
		<h1>Kalender %%title%%</h1>
		<link rel='stylesheet' type='text/css' href='/scripts/fullcalendar/fullcalendar/fullcalendar.css' />
		<script type='text/javascript' src='/scripts/fullcalendar/fullcalendar/fullcalendar.js'></script>
		%%colors%%
		<table width=100% class=prev_nxt_tbl>
		<tr>
		<td align=left><input type=button id=prev value=Forrige class=\"btn btn-blue\"></td>
		<td align=right style=text-align:right><input type=button id=next value='N&aelig;ste' class=\"btn btn-blue\"></td>
		</tr>
		</table>
		<div id='calendar' class='fc ui-widget' style='width:100%'></div>
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
	<h1>Rediger klub %%name%% - Sekretær</h1>
	<form action=?cid=%%cid%% method=post enctype="multipart/form-data">
		<table>
		<tr><td>
		<p>Mødested<br>
		<input type=text name=edit[meeting_place] value="%%meeting_place%%" class="form-control"></p>
		</td><td>
		<p>Mødetid<br>
		<input type=text name=edit[meeting_time] value="%%meeting_time%%" class="form-control"></p>
		</td></tr>
		<tr><td>
		<p>Mumie kodeord<br>
		<input type=text name=edit[mummy_password] value="%%mummy_password%%" class="form-control"></p>
		</td><td>
		<p>Webmail kodeord<br>
		<input type=text name=edit[webmail_password] value="%%webmail_password%%" class="form-control"></p>
		</td></tr>
		<tr><td colspan=2>
		<p>Beskrivelse<br>
		<textarea class=ckeditor name=edit[description]>%%description%%</textarea></p>
		</td></tr>
		<tr>
			<td><p>Web<br>
			<input type=text name=edit[webpage] value="%%webpage%%" class="form-control">
			</td>
		</tr>
		<tr><td>
		<p>Klublogo<br>
		<input type=file name=logo></p>
		</td><td>
		<img src=\"/uploads/club_logos/%%logo%%\" width=100px><br>
		</td></tr></table>
		<hr>
		<input type=submit value="Gem &aelig;ndringer" class="btn">
	</form>
	',
	'edit_club_admin' =>
	'
	<h1>Rediger klub %%name%% - Administrator</h1>
  <input type=button class="btn btn-info margin-btm" value="Permanent slet" onclick=confirm_delete_club(%%cid%%)>
  <script>
    function confirm_delete_club(cid)
    {
      if (confirm("Bekræft sletning af klubben. Alle historiske data vil blive fjernet!"))
      {
        document.location.href="/?cid=%%cid%%&permanent_delete_club";
      }
    }
  </script>
  <h1>Data</h1>
	<form action=?cid=%%cid%% method=post enctype="multipart/form-data" class="tbl1">
		<div class="row" style="display:block;">
		<div class="col-xs-12">
		<p>Klubnavn<br>
		<input type=text name=edit[name] value="%%name%%" class="form-control"></p>
		</div>
        <div class="col-xs-12">
		<p>Chairman name<br>
		<input type=text name=edit[chairman_name] value="%%chairman_name%%" class="form-control"></p>
		</div>
		<div class="col-xs-12">
		<p>M&oslash;dested<br>
		<input type=text name=edit[meeting_place] value="%%meeting_place%%" class="form-control"></p>
		</div>
        <div class="col-xs-12">
		<p>M&oslash;detid<br>
		<input type=text name=edit[meeting_time] value="%%meeting_time%%" class="form-control"></p>
		</div>
		<div class="col-xs-12">
		<p>Charter dato<br>
		<input type=text name=edit[charter_date] value="%%charter_date%%" class="form-control form-datepicker"></p>
		</div>
        <div class="col-xs-12">
		<p>Charter klub ID<br>
			<select name=edit[charter_club_cid] id=charter_club></select>
	<!--	<input type=text name=edit[charter_club_cid] value="%%charter_club_cid%%">
	-->
	</p>
		</div>
		<div class="col-xs-12">
		<p>Distrikt ID<br>
		<input type=text name=edit[district_did] value="%%district_did%%" class="form-control"></p>
		</div>
		<div class="col-xs-12">
		<p>Mumie kodeord<br>
		<input type=text name=edit[mummy_password] value="%%mummy_password%%" class="form-control"></p>
		</div>
        <div class="col-xs-12">
		<p>Webmail kodeord<br>
		<input type=text name=edit[webmail_password] value="%%webmail_password%%" class="form-control"></p>
		</div>
		<div class="col-xs-12">
		<p>Beskrivelse<br>
		<textarea class=ckeditor name=edit[description]>%%description%%</textarea></p>
		</div>
		<div class="col-xs-12"><p>Web<br>
			<input type=text name=edit[webpage] value="%%webpage%%" class="form-control">
		</div>
		<div class="col-xs-12">
		<p style="float:left;">Klublogo<br>
		<input type=file name=logo></p>

		<img src=/uploads/club_logos/%%logo%% width=100px><br>
		</div>
        </div>
		<hr>
		<input type=submit value="Gem &aelig;ndringer" class="btn">
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
	if (confirm("Der er nye mails i klubmailen (antal: %%Unread%%). Check nu?"))
	{
		// atmail.php?account=%%mailbox%%&password=%%webmail_password%%
		document.location.href="http://webmail.wannafind.dk/";
	}
  </script>
  ',
  'unable_to_open_mailbox' => "<script>alert('Kodeordet til klubmailen matcher ikke vores database. Opdater venligst!');</script>",
  'new_club_board_subj' => 'Kommende bestyrelse: %%name%%',
  'new_club_board_body' => '%%name%% har d.d. indstillet kommende bestyrelsesposter på rtd.dk - alle poster er besat.',
  'role_nomination_subj' => 'Indstilling til %%role%%: %%profile_firstname%% %%profile_lastname%%',
  'role_nomination_body' => "
    %%profile_firstname%% %%profile_lastname%% er d.d. indstillet til %%role%% med følgende begrundelse:\n
    %%comment%%

	Profil: http://www.rtd.dk/?uid=%%uid%%
	Klub: http://www.rtd.dk/?cid=%%cid%%
  ",
	'resignation_nominated' => '<script>alert("Udmeldelsen er modtaget.\nLS skal nu godkende.\nSker dette ikke inden for rimelig tid kan der rettes henvendelse til ls@rtd.dk");document.location.href="/";</script>',
	'resignation_approved' => '<script>alert("Udmeldelsen er effektureret - medlem, F, DF, VLF og LF er informeret");document.location.href="/";</script>',
	'resign_nominate_subj' => 'Udmeldelse af %%profile_firstname%% %%profile_lastname%%',
	'resign_nominate_body' =>
	"Udmeldelse af %%profile_firstname%% %%profile_lastname%% fra %%name%%\n\n
	Motivation fra S:\n\n%%why%%\n\nGodkend via dette link: http://rtd.dk/?uid=%%uid%%&resign=%%why_url%%&approve\n\n
	Hvis LS ikke kan godkende udmeldelsen skal der rettes henvendelse til S/F fra %%name%% - se http://rtd.dk/?cid=%%cid%%
	"
	,
	"user_should_see_news" =>
	'
	<script>
		if (confirm("Der er kommet en nyhed fra RTD siden sidste besøg. Vil du se den nu?"))
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
  '<div id=newsitems class=container-out news-page>
    <div class="title title-section">
        <h3>Nyhedsarkiv</h3>
        <span class="sticker">
            <i class="icon fa fa-bullhorn"></i>
        </span>
    </div>
  
    <div class="grid-wrap created">        
        <section class="posts grid carousel11" data-columns="3"></section>
    </div>  
  </div>
  <script>
    var newsitems = jQuery.parseJSON(\'%%data%%\');
    var html  = "";
    $.each(newsitems, function(i,n) {
        var title = "";
        if(n.title != "" && n.title != null)
        {
            title = "<a href=?news="+n.nid+">"+n.title+"</a>";
        }
        else
        {
            title = "";
        }

        var cotn = n.content;

        html = html + "<article class=\"post post-latest post-type-image\">";
        html = html + "<div class=post-content>";
        html = html + "<div class=title>";
        html = html + "<h2 class=h4>"+title+"</h2>";
        html = html + "<p class=meta>";
        html = html + "<span class=meta-date>"+n.posted+"</span>";
        html = html + "</p></div>";
        html = html + "<div class=text>"+cotn.substring(0,300)+"<a href=?news="+n.nid+">...L&aelig;s mere...</a></div>";
        html = html + "</div></article>";

      //$("#newsitems").append("<li><a href=?news="+n.nid+">"+n.title+", "+n.posted+"</a>");
    });
    $("#newsitems .carousel11").append(html);
  </script>
  ',
	'news_item_comment' => '
	<h1>Debat</h1>
  <form action=?news method=post>
  <input type=hidden name=news id=nid>
  <textarea style="width:99%" name=comment placeholder="Din kommentar" class="form-control"></textarea>
  <input type=submit value="Gem kommentar" class="btn"> <i>Du modtager en mail når der kommer opdateringer i kommentarene</i>
  </form>
	<section class="comments devider-top devider-heavy devider-margin-medium">
        <div class="title title-main">
        <h4>Kommentarer</h4>
        </div>
        <ul class="comments-content">
        </ul>
    </section>

	<script>
		var nc = jQuery.parseJSON(\'%%data%%\');
		var html = "";
		$("#nid").val(nc.nid);

		$.each(nc, function(i,c) {

          if (i!="nid")
          {
            html = html + "<li>";
            html = html + "<div class=comment><div class=comment-heading><a class=avatar href=#><span class=\"btn btn-icon-user\"></span>";
            html = html + "<img src=/uploads/user_image?uid="+c.uid+"&landscape&w=100&h=144 alt=Member></a></div>";
            html = html + "<div class=comment-content><div class=title><a href=?uid="+c.uid+">"+c.user.profile_firstname+" "+c.user.profile_lastname+"</a> <p class=meta><span class=meta-date>"+c.posted+"</span></p></div>";
            html = html + "<div class=text>"+c.content+"</div></div></div></li>";
          }
		});

		$(".comments ul.comments-content").append(html);

        var len = $( "ul.comments-content li" ).length;
        $(".comments > .title.title-main h4").append("<span>"+len+"</span>");

	</script>
	',
	'beta_latestnews_js' => '
		var news_data = jQuery.parseJSON(\'%%data%%\');
		$("#newss").append("<h1>Nyhed - "+news_data.title+"</h1>");
		$("#newss").append("<p><i>Skrevet "+news_data.posted+"</i></p>");
		$("#newss").append(news_data.content);
		$("#newss").append("<a href=?news="+news_data.nid+">L&aelig;s mere</a>");

		$.each(news_data.country.minutes, function(i,m) {
			if (m.images != null)
			{
				$("#newss").append("<h1>"+m.name+": "+m.title+"</h1>");
				$("#newss").append(m.images[0].miid);
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
                var title = "";
                if(news_data.title != "" && news_data.title != null)
                {
                    title = "<a href=?news="+news_data.nid+">"+news_data.title+"</a>";
                }
                else
                {
                    title = "";
                }

                var cotn = news_data.content;

                html = html + "<article class=\"post post-latest post-type-image\">";
                html = html + "<div class=post-content>";
                html = html + "<div class=title>";
                html = html + "<h2 class=h4>"+title+"</h2>";
                html = html + "<p class=meta>";
                html = html + "<span class=meta-date>"+news_data.posted+"</span>";
                html = html + "</p></div>";
                html = html + "<div class=text>"+cotn.substring(0,300)+"<a href=?news="+news_data.nid+">...L&aelig;s mere...</a></div>";
                html = html + "</div></article>";
			});
			//html = html + "<h1>Nyhedsarkiv</h1><p><ul><li><a href=?news>Find gamle nyheder i arkivet</a><li><a href=\"mailto:web@rtd.dk\">Forslå en nyhed</a></ul></p>";
			//$("#newss").append(html);

            $(".news-page .carousel").append(html);
            $(".news-page.container-out").show();
            //$(".container-out.news-page").insertAfter("#page-content .container .col-md-10 #content");
		}

		$("#newss").css("display","block");
		if($("#news").length > 0)
		{
			latestnewsjs();
		}
	',
  'mobile_search_page' =>
  '
  <form action=/m data-ajax=false>
  <h2>Søgeord</h2>
        <div data-role="fieldcontain" class="ui-hide-label">
        <label for="search">S&oslash;geord:</label>
        <input type="search" placeholder="Søgeord" name="search" id="search" value="" data-mini=true />
        </div>
  <div id=results>
  <h2>Resultater</h2>
  <div data-role="collapsible-set" data-theme="c" data-content-theme="d">
      <div data-role="collapsible">
          <h3>Medlemmer (<span id=member_count></span>)</h3>

          <ul data-role="listview" data-inset="true" id="members">
          </ul>
      </div>
      <div data-role="collapsible">
          <h3>Møder (<span id=meeting_count></span>)</h3>
        	<ul data-role="listview" data-inset="true" data-filter="false" id="meetings">
          </ul>
      </div>
      <div data-role="collapsible">
          <h3>Klubber (<span id=club_count></span>)</h3>
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
	  $("#vcard").append("<a href=?vcard&uid="+data.uid+" rel=external>Download kontakt</a>");
      $("#club").append("<a href=?cid="+data.club.cid+"><h3>"+data.club.name+"</h3></a>");
      $("#name").append(data.profile_firstname+" "+data.profile_lastname);
      $("#pic").attr("src","/uploads/user_image?uid="+data.uid+"&landscape&w=300&h=500");
      $("#company").append(data.company_name);
      $("#position").append(data.company_position);
      $("#mobil").append("<a title=Opkald href=\'tel:"+data.private_mobile+"\'><h3>Mobil privat</h3><p>"+data.private_mobile+"</p></a>");
      $("#email").append("<a title=Mail href=\'mailto:"+data.private_email+"\'><h3>Mail privat</h3><p>"+data.private_email+"</p></a>");
      var road = data.private_address+" "+data.private_houseno+data.private_houseletter+" "+data.private_housefloor+data.private_houseplacement;
      var city = data.private_zipno+" "+data.private_city;
      $("#address").append("<a href=\'http://maps.google.com?q="+road+","+city+"\' title=Kort><h3>Bopæl</h3><p>"+road+"<br>"+city+"</p></a>");
    </script>
  ',
  'mobile_club_page' => '
	<div data-role="collapsible"  data-theme="a" data-content-theme="a">
  <h3>Møder</h3>
  <p>
	<ul data-role="listview" data-inset="true" data-filter="false" id="meetings">
  </ul>
  </p>
	</div>

	<div data-role="collapsible"  data-theme="a" data-content-theme="a">
	<h3>Kontakt</h3>
	<p>
	<a href=# id=mailclubmembers data-role="button">Mail medlemmer</a>
	<a href=# id=mailclub data-role="button">Mail klub</a>
	</p>
	</div>
	<div data-role="collapsible"  data-theme="a" data-content-theme="a">
	<h3>Medlemmer</h3>
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
  'mobile_title_front' => 'RTD - Hele landet',
  'mobile_meeting_accept' => '
  <h1>Mødetilmelding</h1>
  <h2>%%title%%</h2>
  <p>Du er nu tilmeldt mødet og klubben har fået besked om din tilmelding.</p>
  ',
  'mobile_meeting_reject_no_comment' => '
  <h1>Mødeafbud</h1>
  <h2>%%title%%</h2>
  <p>Du har ikke indtastet en begrundelse for afbudet og systemet kan derfor ikke afmelde mødet. Prøv igen.</p>
  ',
  'mobile_meeting_reject' => '
  <h1>Mødeafbud</h1>
  <h2>%%title%%</h2>
  <p>Du er nu afmeldt mødet og klubben har fået besked om din afmelding.</p>
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

	<li data-role="list-divider">Tilmelding</li>
		<li>
		<form action=/m method=get id=submit%%mid%%>
		<input type=hidden name=mid value=%%mid%%>
		<div data-role="fieldcontain">
			<fieldset data-role="controlgroup">
				<legend>Kommentar:</legend>
				<input type="text" name="attend[comment]" id="text-%%mid%%" class="custom form-control" />
			</fieldset>
			<fieldset data-role="controlgroup">
				<legend>Tilmeld:</legend>
				<input type="checkbox" name="attend[accept]" id="checkbox-%%mid%%" onclick="$(\'#submit%%mid%%\').submit();" class="custom" />
				<label for="checkbox-%%mid%%">Tilmeldt</label>
			</fieldset>
		</div>
		</li>
		</form>
	</li>

    <li data-role="list-divider"><h3>Tilmeldte (<span id=count%%mid%%></span>)</h3></li>

    </ul>

    <script>
    		var count%%mid%%=0;

			function attend_toggle(mid)
			{
				var box = "#checkbox-%%mid%%";
				if (!$(box).is(":checked"))
				{
					var p = prompt("Angiv venligst årsag til afmelding:","");
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
  <h2>Kommende m&oslash;der</h2>
	<ul data-theme="a" data-role="listview" data-inset="true" data-filter="false" id="future_meetings">
  </ul>
  <h2>Klubber</h2>
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
  <h2>Kommende m&oslash;der</h2>
	<ul data-theme="a" data-role="listview" data-inset="true" data-filter="false" id="future_meetings">
  </ul>
  <h2>Distrikter</h2>
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
    <h2>Hvem er online nu?</h2>
		<ul data-theme="a" data-role="listview" data-inset="true" data-filter="false" id="club_page_contact">
    </ul>
	<script>
		var online_users = jQuery.parseJSON(\'%%data%%\');
		$.each(online_users, function(a,u) {
      $("#club_page_contact").append("<li><a data-rel=dialog href=?uid="+u.uid+"><img src=/uploads/user_image?uid="+u.uid+"&landscape&w=100&h=150><h3>"+u.profile_firstname+" "+u.profile_lastname+"</h3><p>"+u.club+"</p><p>Sidst set: "+u.last_page_view+"</p></a></ul>");
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
	<p>Denne app er kun for medlemmer af Round Table Danmark. Indtast loginoplysninger nedenfor for at tilgå data.</p>
	<form class="ui-body ui-body-a ui-corner-all" method=post action="?login&redirect=%%REQUEST_URI%%" data-ajax="false" >
		<div data-role="fieldcontain" class="ui-hide-label">
			<label for="username">Email adresse:</label>
			<input type="text" name="username" id="login_mail" value="" placeholder="Email eller brugernavn"/>
		</div>
		<div data-role="fieldcontain" class="ui-hide-label">
			<label for="password">Kodeord:</label>
			<input type="password" name="password" id="login_pass" value="" placeholder="Kodeord"/>
		</div>
		<button type="submit" data-theme="b" name="login_submit" value="" id="login_submit" class="btn">Login</button>
	</form>
  ',
  'mobile_menu_not_member' => '',
  'mobile_menu_member' => '
    <div data-role="navbar">
    	<ul>
    	<li><a data-ajax=false href="/m" data-role="button" data-icon="home" >Forside</a></li>
    	<li><a href="http://www.rtd.dk" target=_blank rel="external" data-role="button" data-icon="forward">Desktopudgave</a></li>
    	<li><a data-ajax=false href="/m?search" data-role="button" data-icon="search">S&oslash;g</a></li>
    	<li><a data-ajax=false href="/m?download" data-role="button" data-icon="star">Publikationer</a></li>
    </ul>
    </div>
  ',
  'mobile_page_title' => 'RTD App',
	'stats' => '<h1>Statistik</h1>
			<div id="tabs">
		    <ul>
		    		<li><a href="#tabs-1" id=clubtitle>Oversigt</a></li>
		        <li><a href="#tabs-2" id=usrtitle>Jubilæum</a></li>
		        <li><a href="#tabs-3" id=arttitle>Møderating</a></li>
		        <li><a href="#tabs-4" id=mtgtitle>Siden sidst</a></li>
		    </ul>
		    <div id="tabs-1">
					<div id=overview>
						<table>
						<tr>
							<td>Antal medlemmer pr. d.d.</td>
							<td id=memberstoday></td>
						</tr>
						<tr>
							<td>
								Herudover antal Ærexsedlemmer pr. d.d.
							<td id=honormembers></td>
						</tr>
						<tr>
						<td>
							Antal medlemmer pr. 1/7 d.å.
							<td id=membersyearstart></td>
						</tr>
						<tr>
						<td>
							Antal medlemmer pr. 1/7 n.å
							<td id=membersyearend></td>
						</tr>
						<tr>
						<td>
							Antal nye medlemmer i år
							<td id=newmembers></td>
						</tr>
						<tr>
						<td>
							Antal udmeldelser i år
							<td id=exits></td>
						</tr>
						<tr>
						<td>
							Antal der falder for aldersgrænsen pr. 30/4
							<td id=exitduetoage></td>
						</tr>
						<tr>
						<td>
							Antal klubber pr. d.d.
							<td id=clubs></td>
						</tr>
						<tr>
						<td>
						Gns. antal medlemmer pr. klub
							<td id=avgclub></td>
						</tr>
						<tr>
						<td>
						Gns. alder for medlemmerne
							<td id=avgall></td>
						</tr>
						<tr>
						<td>
						Gns. alder for nye medlemmer
							<td id=avgnew></td>
						</tr>
						</table>
					</div>
		    </div>
		    <div id="tabs-2">
					<div id=usrres>
							<p><b id=jubilee_header>Indeværende år</b></p>
							<p><input id=nextyear type=button value="Vis næste klubår" onclick="document.location.href=\'?stats&modify=1\'">
							<input id=curryear type=button value="Vis indeværende klubår" onclick="document.location.href=\'?stats&modify=0\'"></p>
							<p><select onchange=build(this.value);>
								<option value="">Hele landet</option>
								<option value="Distrikt 1">Distrikt 1</option>
								<option value="Distrikt 2">Distrikt 2</option>
								<option value="Distrikt 3">Distrikt 3</option>
								<option value="Distrikt 4">Distrikt 4</option>
								<option value="Distrikt 5">Distrikt 5</option>
								<option value="Distrikt 4">Distrikt 4</option>
								<option value="Distrikt 7">Distrikt 7</option>
								<option value="Distrikt 8">Distrikt 8</option>
							</select></p>
							<a href=#cj>Vis klubjubilæer</a> |
							<a href=#mj>Vis Medlemsjubilæer</a>
							<hr>
							<a name=cj><p><b>Klubjubilæer</b></p></a>
							<ul><div id=clubjubilees></div></ul>
							<hr>
							<a name=mj><p><b>Medlemsjubilæer</b></p></a>
							<ul><div id=jubilees></div></ul>
					</div>
		    </div>
		    <div id="tabs-3">
					<b>Møderating</b>
					<p>Bedst ratede klubber:</p>
					<ol id=clubrate></ol>
					<p>Bedst ratede møder:</p>
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
					case "aid" : $("#notmsg").append("<b>Artikler</b><br>"); break;
					case "mid" : $("#notmsg").append("<b>Møder</b><br>"); break;
					case "nid" : $("#notmsg").append("<b>Nyheder</b><br>"); break;
					case "ts" : $("#notmsg").append("<b>Tabler Service</b><br>"); break;
					case "uid" : $("#notmsg").append("<b>Nye medlemmer</b><br>"); break;
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
			$("#jubilee_header").html("Næste klubår");
		}
		else
		{
			$("#curryear").hide();
		}



		$.each(data.meetings.best_club, function(i, c) {
			$("#clubrate").append("<li><a href=?cid="+c.cid+" target=_blank>"+c.data.name+"</a><br>Stemmer: "+c.count+"<br> Gennemsnit: "+c.average+"</li>");
		});

		$.each(data.meetings.best_meeting, function(i, m) {
			$("#meetrate").append("<li><a href=?mid="+m.mid+" target=_blank>"+m.club.name+"<br> "+m.data.title+"</a><br>Stemmer: "+m.count+"<br> Gennemsnit: "+m.average+"</li>");
		});


		function build_club(filter)
		{
			$("#clubjubilees").empty();
			$.each(data.club_jubilees, function(year, d) {
				$("#clubjubilees").append("<p><b>"+year+" års jubilarer</b></p><p><ul>");
				$.each(d, function(foo, c) {
					if (filter=="" || filter==c.district)
					{
						$("#clubjubilees").append("<ul><p><a href=?cid="+c.cid+"><b>"+c.club+"</b></a><br>"+c.district+", Charterdato: "+c.charter_date+", Charterklub: "+c.charter_club+"</p></ul>");
					}
				});
				$("#clubjubilees").append("</ul></p>");
			});
		}
		function build_member(filter)
		{
			$("#jubilees").empty();
			$.each(data.jubilees, function(year,d) {
				$("#jubilees").append("<p><b>"+year+" års jubilarer</b></p><p><ul>");
				$.each(d, function(foo,m) {
					if (filter=="" || filter==m.district)
					{
						$("#jubilees").append("<ul><p><a href=?uid="+m.uid+">"+m.profile_firstname+" "+m.profile_lastname+"</a><br> "+m.club+", "+m.district+"<br>Optaget "+m.profile_started+"</a><br><br></p></ul>");
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
	'admin_newsletter_sent' => '<h1>Udsend nyhedsbrev</h1><p>Nyhedsbrevet er udsendt til %%count%% modtagere.</p>',
	'newsletter_default_content' =>
	"\n\n---\n%%profile_firstname%% %%profile_lastname%%, %%national_board_member%%\n\nHUSK:\nRTD på Facebook: https://www.facebook.com/roundtabledk\nRTD på LinkedIn: http://www.linkedin.com/groups?gid=48578\n",

	'admin_newsletter_form' => '
	<h1>Udsend nyhedsbrev <span id=who></span></h1>
	<form action=?admin_download=newsletter method=post enctype="multipart/form-data" class="news_form" onsubmit="return verify();">
	<input type=hidden name=newsletter value=send>
	<p><input type=checkbox name=testmail id=testmail><label for=testmail>Udsend pr&oslash;vemail til dig selv</label></p>
  <p id="sender">Afsender UID:<br>
  <input type=text name=sender_uid value="%%uid%%" id=uid disabled></p>
	<p>Overskrift:<br>
	<input type=text name=title value="%%title%%"></p>
	<p>Indhold:<br>
	<textarea name=content style="width:98%;height:300px;">%%content%%</textarea></p>
	<h1>Vedh&aelig;ft</h1>
  <p>V&aelig;lg vedh&aelig;ftet fil<br><input type="file" name="file" id="file"></p>
  <h1>Modtagere</h1>
	<p>Marker f&oslash;rst hvilke roller nyhedsbrevet skal ramme og efterf&oslash;lgende hvilke distrikter. Det er s&acirc;ledes muligt at sende nyhedsbreve til f.eks. alle F i Distrikt 2, etc.</p>
	<b>Roller</b>
	<ul>
		Klubroller<br>
		<input type=checkbox onclick=c(this); name=roles[] id="roles_1" value=4 id=M> <label for="roles_1">Medlem</label>
		<input type=checkbox onclick=c(this); name=roles[] id="roles_2" value=9 id=F> <label for="roles_2">F</label>
		<input type=checkbox onclick=c(this); name=roles[] id="roles_3" value=10 id=S> <label for="roles_3">S</label>
		<input type=checkbox onclick=c(this); name=roles[] id="roles_4" value=col-sm-offset-2 id=I> <label for="roles_4">I</label>
		<input type=checkbox onclick=c(this); name=roles[] id="roles_5" value=12 id=K> <label for="roles_5">K</label>
		<input type=checkbox onclick=c(this); name=roles[] id="roles_6" value=17 id=IRO> <label for="roles_6">IRO</label>
		<input type=checkbox onclick=c(this); name=roles[] id="roles_7" value=24 id=HM> <label for="roles_7">&AElig;M</label>
		<input type=checkbox onclick=c(this); name=roles[] id="roles_8" value=13 id=N> <label for="roles_8">N<br></label>
		<br>R&oslash;dk&aelig;de<br>
		<input type=checkbox onclick=c(this); name=roles[] id="roles_9" value=14 id=DF><label for="roles_9">DF</label>
		<input type=checkbox onclick=c(this); name=roles[] id="roles_10" value=15 id=LF><label for="roles_10">LF</label>
		<input type=checkbox onclick=c(this); name=roles[] id="roles_col-sm-offset-2" value=14 id=VLF><label for="roles_col-sm-offset-2">VLF</label>
		<input type=checkbox onclick=c(this); name=roles[] id="roles_12" value=19 id=NIRO><label for="roles_12">NIRO</label>
		<input type=checkbox onclick=c(this); name=roles[] id="roles_13" value=34 id=ALF><label for="roles_13">ALF<br></label>
		<br>Bl&acirc;k&aelig;de<br>
		<input type=checkbox onclick=c(this); name=roles[] id="roles_14" value=21 id=LS><label for="roles_14">LS</label>
		<input type=checkbox onclick=c(this); name=roles[] id="roles_15" value=22 id=WEB><label for="roles_15">WEB</label>
		<input type=checkbox onclick=c(this); name=roles[] id="roles_16" value=23 id=LK><label for="roles_16">LK</label>
		<input type=checkbox onclick=c(this); name=roles[] id="roles_17" value=24 id=RED><label for="roles_17">RED</label>
		<input type=checkbox onclick=c(this); name=roles[] id="roles_18" value=25 id=SHOP><label for="roles_18">SHOP</label>
		<input type=checkbox onclick=c(this); name=roles[] id="roles_19" value=37 id=LA><label for="roles_19">LA</label>
	</ul>
	<b>Distrikter</b>
	<ul>
		<input type=checkbox onclick=cd(this); name=districts[] id="districts_1" value=14 id=D1><label for="districts_1">Distrikt 1 - Nordjylland<br></label>
		<input type=checkbox onclick=cd(this); name=districts[] id="districts_2" value=15 id=D2><label for="districts_2">Distrikt 2 - Vestjylland<br></label>
		<input type=checkbox onclick=cd(this); name=districts[] id="districts_3" value=16 id=D3><label for="districts_3">Distrikt 3 - &Oslash;stjylland<br></label>
		<input type=checkbox onclick=cd(this); name=districts[] id="districts_4" value=17 id=D4><label for="districts_4">Distrikt 4 - Syd- og S&oslash;nderjylland<br></label>
		<input type=checkbox onclick=cd(this); name=districts[] id="districts_5" value=18 id=D5><label for="districts_5">Distrikt 5 - Trekantsomr&acirc;det og Fyn<br></label>
		<input type=checkbox onclick=cd(this); name=districts[] id="districts_6" value=19 id=D4><label for="districts_6">Distrikt 6 - Nordsj&aelig;lland<br></label>
		<input type=checkbox onclick=cd(this); name=districts[] id="districts_7" value=20 id=D7><label for="districts_7">Distrikt 7 - Sydsj&aelig;lland og Lolland-Falster<br></label>
		<input type=checkbox onclick=cd(this); name=districts[] id="districts_8" value=21 id=D8><label for="districts_8">Distrikt 8 - K&oslash;benhavn, Bornholm og Gr&oslash;nland<br></label>
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

	</script>
	<h1>Udsend</h1>
	<input type=submit value="Udsend nyhedsbrev" class="btn">
	</form>
	',
	'mummy_login' =>'
	<h1>Mumielogin</h1>
	<form action=?mummy method=post>
	<p>Klub (f.eks. RT132)<br><input type=text name=club></p>
	<p>Password<br><input type=password name=password></p>
	<input type=submit value="Login" class="btn">
	</form>
	',

	'latestmembers_js' => '
	$("#latestmemberss").css("display","block");
	if($("#latestmembers").length > 0)
	{
		$("#latestmemberss").append("<div class=\"title title-section\"><h2>Seneste Medlemmer</h2><p>Velkommen til de nye medlemmer.</p><span class=sticker><i class=\"icon icomoon-users\"></i></span></div><div id=members class=row></div>");
		var data = jQuery.parseJSON(\'%%data%%\');
		var c = 0;
		var html = "";
		$.each(data, function(i,m) {

			if (c==5)
			{
				html += "<div class=clearfix></div>";
			}

			html += "<div class=\"col-xs-6 col-xs-2 col-md-2 \"><div class=member-heading><a href=?uid="+m.uid+" class=userpic><span class=\"btn btn-icon-user\"></span><img src=/uploads/user_image?uid="+m.uid+"&landscape&w=300&h=500><div class=title><h5><a href=?uid="+m.uid+">"+m.profile_firstname+" "+m.profile_lastname+"</a></h5><p>"+m.company_position.substring(0,14)+"</p></div></div></div>";

			c++;
			if (c==5)
			{
				c=0;
				html += "";
			}
		});
		$("#members").append(html);
	}
	',
	'meeting_deleted' =>
	'<h1>Advarsel</h1><p>M&oslash;det du pr&oslash;ver at tilg&acirc; er desv&aelig;rre slettet. Hvis du mener dette er en fejl bedes du kontakte din sekret&aelig;r.</p>',
	'addthis' =>
	'
	',
	'national_board' =>
	'
	<div class="container">
		<div class="row">
			<a name=hb><h1>Hovedbestyrelse</h1></a>
			<div class="col-sm-12">
				<div class="" id="lf"></div>
				<div class="" id="vlf"></div>
				<div class="" id="iro"></div>
				<div class="" id="blank"></div>
			</div>
		</div>
		<div class="row">
			<a name=df><h1>Distriktsformænd</h1></a>
			<div class="col-sm-12">
				<div class="" id="df1"></div>
				<div class="" id="df2"></div>
				<div class="" id="df3"></div>
				<div class="" id="df4"></div>
				<div class="" id="df5"></div>
				<div class="" id="df6"></div>
				<div class="" id="df7"></div>
				<div class="" id="df8"></div>
			</div>
		</div>
		<div class="row">
			<a name=ex><h1>Eksekutiv komité</h1></a>
			<div class="col-sm-12">
				<div class="" id="ls"></div>
				<div class="" id="lk"></div>
				<div class="" id="shop"></div>
				<div class="" id="web"></div>
				<div class="" id="red"></div>
			</div>
		</div>
		<div class="row">
			<a name=others><h1>Øvrige</h1></a>
			<div class="col-sm-12">
				<div class="" id="alf"><p id="la"></p></div>

			</div>
		</div>
	</div>
	<script>
		var data = jQuery.parseJSON(\'%%data%%\');

		function makehtml(v)
		{
			if (v)
			{
				/*var html = "";
				html += "<a href=?uid="+v.uid+" title=\""+v.role+": "+v.profile_firstname+" "+v.profile_lastname+"\"><img src=/uploads/user_image?uid="+v.uid+"&landscape&w=200&h=333><br>";
				html += "<b>"+v.role+"</b><br>";
				html += v.profile_firstname+" "+v.profile_lastname+"<br>";
				html += v.district+", ";
				html += v.club+"<br></a>";
				return html;*/
                console.log(v);

                var con = "";
                if(v.private_email != "")
                {
                    con += "<ul class=\"social\" animation=\"\" animation-from-right=\"\"><li><a href=mailto:"+v.private_email+" class=\"mail\" target=\"_blank\"></a></li></ul>";
                }
                else if(v.company_email != "")
                {
                    con += "<ul class=\"social\" animation=\"\" animation-from-right=\"\"><li><a href=mailto:"+v.company_email+" class=\"mail\" target=\"_blank\"></a></li></ul>";
                }
                else
                {
                    con += "";
                }

                var html = "";
				html += "<div class=\"col-xs-4 all_members\"><div class=\"member\"><div class=\"member-heading\">";
                html += "<a class=\"userpic\" href=?uid=\"+v.uid+\"><span class=\"btn btn-icon-user\"></span><img src=/uploads/user_image?uid="+v.uid+"&landscape&w=200&h=333></a>";
                html += con;
				html += "<div class=\"title\">";
				html += "<h4><a href=?uid=\"+v.uid+\">"+v.profile_firstname+" "+v.profile_lastname+"</a></h4>";
                html += "<p><strong>"+v.role+"</strong></p>";
				html += "<p>"+v.district+"</p>";
				html += "<p>"+v.club+"</p></div>";
                html += "</div></div></div>";
				return html;
			}
			else
			{
				return "<i>Ikke fundet</i>";
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
	<p>Tablerservice er en intern markedsplads/idekatalog til brug for klubberne ved planlægning af møder og netværksarrangementer. Står du med kendskab til en god taler eller den perfekte lokation til et møde opfordres du til at tilføje den i kataloget.</p>
	<p id=data></p>
	<form id=newentry method=post action=?ts><h1>Opret indlæg</h1>
	<table width=100%>
	<tr><td width=50% valign=top>
	<b>Overskrift</b><br><input type=text name=item[headline] class="form-control"><br>
	<b>Sted</b><br><input type=text name=item[location] class="form-control"><br>
	</td><td valign=top>
	<b>Pris</b><br><input id=price type=text name=item[price] class="form-control" onkeyup=><br>
	<b>Tid</b><br><input type=text name=item[duration] class="form-control"><br>
	<b>Kontakt</b><br><input type=text name=item[contact] class="form-control"><br>
	</td></tr></table>
	<b>Tekst</b><br>
	<textarea name=item[description] class=ckeditor></textarea>
	<input type=submit value=Gem class="btn">
	</form>
	<script>
		var data = jQuery.parseJSON(\'%%data%%\');

		function delitem(i)
		{
			if (confirm("Bekræft sletning af indlæg"))
			{
				document.location.href="?ts="+data.category.tsid+"&delete="+i;
			}
		}

		if (data.category)
		{
			$("#newentry").get(0).setAttribute("action", "?ts="+data.category.tsid);
			$("#data").append("<a href=?ts>Tilbage til oversigt</a><h1>"+data.category.headline+"</h1><div id=items></div>");
			$.each(data.items, function(i,item) {
				if(item.may_edit) { $("#items").append("<p><a href=# onclick=delitem("+item.tid+");>Slet indl&aelig;g</a></p>"); }
				$("#items").append("<p><b>"+item.headline+"</b></p><p>Sted: "+item.location+"</p><p>Kontakt: "+item.contact+"</p><p>Pris: "+item.price+"</p><p>Tid: "+item.duration+"</p>");
				$("#items").append("<ul>"+item.description+"</ul><hr>");
			});
		}
		else
		{
			$("#newentry").hide();
			$("#data").append("<h1>Kategorier</h1><ul id=categories>");
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
	if (confirm("Hej %%profile_firstname%% %%profile_lastname%%\nDet er længe siden dine profiloplysninger er blevet opdateret. \nKlik OK for at gøre det nu:"))
	{
		document.location.href="/?uid=%%uid%%&edit";
	}
	</script>
	',
	'dashboard_old' => '
	<h1 id=dashboard>Dashboard: </h1>
	<table width=100%><tr><td id=dashboardintro valign=top></td><td valign=top id=dashboardlogo></td></tr></table>
	<div id=download></div>
	<h1>Medlemsstatistik</h1>
	<table id=memberstat width=100%>
	<tr><th>Klub&acirc;r</th><th>Medlemstal (start)</th><th>Medlemstal (slut)</th><th>Tilgang</th><th>Afgang</th><th>Exit</th></tr>
	</table>
	<h1>M&oslash;destatistik</h1>
	<p id=meetingcount>Hjemmem&oslash;der i &acirc;r:</p>
	<table id=meetingstat width=100%>
	<tr><th>Navn</th><th>M&oslash;deprocent i &acirc;r</th><th>M&oslash;deprocent sidste &acirc;r</th></tr>
	</table>
  <h1>Fremm&oslash;de per m&oslash;de</h1>
  <table id=meeting_details width=100%></table>
  <h1>Fremm&oslash;de per medlem</h1>
  <div id=details></div>
	<script>
	var data = jQuery.parseJSON(\'%%data%%\');
		$("#dashboard").append(data.club.name);
		$("#dashboardintro").append(data.club.description);
		$("#dashboardlogo").append("<img border=1 src=\"/uploads/club_logos/"+data.club.logo+"\">");
		$("#download").append("<a href=?dashboard="+data.club.cid+"&download>Vis i tabelform</a>");
		$.each(data.club_stats, function(y,d) {
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
			$("#meetingstat").append("<tr><td><a href=#"+d.uid+">"+d.profile_firstname+" "+d.profile_lastname+"</a></td><td>"+attendance+" %</td><td>"+old_attendance+" %</td></tr>");

      $("#details").append("<a name="+d.uid+"><p><a href=?uid="+d.uid+">"+d.profile_firstname+" "+d.profile_lastname+"</a></p></a><ul>")
      $.each(d.details, function(a,b) {
      	if ($("#"+b.mid).length==0)
      	{
      		$("#meeting_details").append("<tr><td valign=top><a name="+b.mid+"><a href=?mid="+b.mid+" target=_blank>"+b.title+"</a></a></td><td valign=top id="+b.mid+"></td></tr><tr><td colspan=2><hr></td></tr>");
      	}
      	$("#"+b.mid).append("<li><a href=#"+d.uid+">"+d.profile_firstname+" "+d.profile_lastname+"</a>");
        $("#details").append("<li><a target=_blank href=?mid="+b.mid+">"+b.start_time+": "+b.title+", "+b.club+"</a></li>")
      });

      $("#details").append("</ul>");
		});
		$("#meetingcount").append(meeting_count);
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
	<h1>Medlemsstatistik</h1>

	<div id="memberstatchart" style="height:300px; width:100%;"></div>

    <div class="memberchart_stat">
	<table id=memberstat width=100%>
	<tr><th>Klub&acirc;r</th><th>Medlemstal (start)</th><th>Medlemstal (slut)</th><th>Tilgang</th><th>Afgang</th><th>Exit</th></tr>
	</table>
    </div>

	<h1>M&oslash;destatistik</h1>
	<div id="meetstatchart" style="height:300px; width:100%;"></div>
	<p id=meetingcount>Hjemmem&oslash;der i &acirc;r:</p>
	<table id=meetingstat width=100%>
	<tr><th>Navn</th><th>M&oslash;deprocent i &acirc;r</th><th>M&oslash;deprocent sidste &acirc;r</th></tr>
	</table>
  <h1>Fremm&oslash;de per m&oslash;de</h1>
  <table id=meeting_details width=100%></table>
  <h1>Fremm&oslash;de per medlem</h1>
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
		$("#dashboardlogo").append("<img border=1 src=\"/uploads/club_logos/"+data.club.logo+"\">");
		$("#download").append("<a href=?dashboard="+data.club.cid+"&download>Vis i tabelform</a>");
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
		jQuery(document).ready(function($){
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
						series: [{label:"Medlemmer"},{label:"Afgang"},{label:"Tilgang"}],
						axes: { xaxis: { renderer: $.jqplot.CategoryAxisRenderer, ticks: memberstat_data_ticks }}
					}
					);
		});

	</script>
	',
	'meeting_admin_unlock_minutes' =>
	'<h2>Sekret&aelig;rv&aelig;rkt&oslash;jer</h2><a href=?mid=%%mid%%&unlock>Lås referat op</a>',
	'business_search' => '<div class="biz_bank"><h1>Brancheoversigt</h1>
	<p class="biz_bank_p">
	Vælg branche:<br>
	<select id=biz name=biz onchange="biz(this.value);"></select><br>
	<div id=company_section>Vælg virksomhed:<br>
	<select id=company name=company onchange="company(this.value)";></select></div>
	<div id=res></div>
	</div>
	<script>
		var data = jQuery.parseJSON(\'%%data%%\');

		function biz(v)
		{
			document.location.href="?biz="+v;

		}

		function company(v)
		{
			//document.location.href="?biz="+data.search+"#"+v;

			 $("html, body").animate({
       			 scrollTop: $("#"+v).offset().top-70
    		}, 1500);
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

		var res_html = "<div class=biz_bank_user>";
		var past = "pandekage";
		var cnt = 0;
		var companies = 0;
		$.each(data.results, function(k,v) {
			if (v.company_name.indexOf(past)==-1)
			{

				res_html += "<div class=clearfix></div><a id=\""+v.cid+"\" name=\""+v.company_name+"\"><h2>"+v.company_name+"</h2></a>";
				past = v.company_name;
				$("#company").append("<option value=\""+v.cid+"\">"+v.company_name+"</option>");
				cnt = -1;
			}

			if (cnt == 1)
			{
				res_html += "<div class=clearfix></div>";
				cnt = 0;
			}
			else cnt++;

			res_html +=
							 "<div class=my_class><div class=my_class_left><a href=?uid="+v.uid+"><img src=/uploads/user_image?uid="+v.uid+"&landscape&w=100&h=150></a></div>"
							 +"<div class=my_class_right><h5><a href=?uid="+v.uid+">"
							 +v.profile_firstname+" "+v.profile_lastname+"</a></h5>"
							 +v.company_position+"<br>"
							 +v.company_address+", "+v.company_zipno+" "+v.company_city+"<br>"
							 +"Tlf: "+v.company_phone+"<br>"
							 +"Mail: <a href=mailto:"+v.company_email+">"+v.company_email+"</a>"

							 +"</div></div>"
							 ;
			companies++;
		});
		res_html += "</div>";
		$("#res").append(res_html);
		if (companies==0) $("#company_section").hide();
	</script>

	',
  'user_resign_subj' => 'Udmeldelse i %%name%%',
  'user_resign_body' => 'Det bekræftes herved at %%profile_firstname%% %%profile_lastname%% er udmeldt per dags dato af %%name%%',
  'user_resign_nb_body' => "%%profile_firstname%% %%profile_lastname%% er udmeldt per dags dato\n\nMotivation:\n\n%%why%%",
	'news_comment_subj' => 'Ny kommentar til: %%title%%',
	'news_comment_body' => 'Klik på dette link for at se kommentaren: http://www.rtd.dk/?news=%%nid%%',
	'club_member_stat' => '
	<div class="title title-section">
		<h2>Medlemsstatistik</h2>
		<span class="sticker">
			<i class="icon icomoon-stats"></i>
		</span>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<table class="table table-striped" id=stat>
				<tr>
					<th>Klub&acirc;r</th><th>Medlemstal (start)</th><th>Medlemstal (slut)</th><th>Tilgang</th><th>Afgang</th><th>Exit</th>
				</tr>
			</table>
		</div>
	</div>

	<script>
		var stats = jQuery.parseJSON(\'%%data%%\');
		$.each(stats, function(y,d) {
			$("#stat").append("<tr><td>"+y+"</td><td>"+d.start+"</td><td>"+d.end+"</td><td>"+d.newmembers+"</td><td>"+d.exit+"</td><td>"+(d.end-d.start)+"</td></tr>");
		});
	</script>
	',
	'user_stats' =>
	'<div id="page-content" class="meetstatistic_data" role="main"><div class="container container-light user_condensed">
		<div class="title title-section">
			<h2>M&oslash;destatistik</h2>

			<span class="sticker">
				<i class="icon icomoon-stats"></i>
			</span>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<table id=stats class="table meetstatistic table-condensed 22" width="100%">
				<tr>
					<th width="1%">År</th>
					<th width="1%">Antal klubm&oslash;der i alt</th>
					<th width="1%">M&oslash;dedeltagelse</th>
					<th width="1%">Udem&oslash;der</th>
					<th>M&oslash;deprocent</th>
				</tr>
				</table>


				<p>Forklaring: "Hjemmem&oslash;der" angiver fremm&oslash;de ved klubbens egne m&oslash;der. Tallet i parentes angiver antal afbud til hjemmem&oslash;der. "Udem&oslash;der" angiver antal udem&oslash;der hvor deltagelse er registreret. "M&oslash;deprocent" beregnes som (deltagelse ved hjemmem&oslash;der+udem&oslash;der / antal hjemmem&oslash;der).</p>
				<script>
				var stats = jQuery.parseJSON(\'%%data%%\');
				$.each(stats, function(year,data) {
					$("#stats").append("<tr><td style=\'word-wrap:no-wrap\'>"+year+"</td><td>"+data.total+"</td><td>"+data.accepted+" ("+data.reject+")</td><td>"+data.non_home_meeting+"</td><td><div class=\'skill\'><div class=\'bar \' data-value=\'"+data.attendance+"\' style=\"height:40px;\"></div></div></td></tr>");
				});
				</script>
			</div>
		</div>
	</div></div>
	',
	'admin_new_boards' => '
	<h1>Kommende bestyrelser - hele landet</h1>
	<p>Nedenfor ses en liste over de indrapporterede bestyrelser p&acirc; RTD.DK</p>
	<div id=data></div>
	<script>
		var b=jQuery.parseJSON(\'%%data%%\');
		$.each(b, function(i,d) {
            console.log(d);
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
	<h1>Bestyrelse indsendt</h1>
	<p>Indstillingen er modtaget og behandlet. Husk at kontakte LF skriftlig hvis den tiltrædende bestyrelse kræver dispensation ifht. Blå Bog.</p>',
	'review_club_board' => '
	<h1>Kommende bestyrelse i din klub</h1>
	<p>Nedenstående oplysninger er registreret i forbindelse med den kommende bestyrelse i din klub. Er der &aelig;ndringer til nedenstående kan der rettes henvendelse til landssekretæren.</p>
	<ul id=board></ul>
	<script>
	var b=jQuery.parseJSON(\'%%data%%\');
	$.each(b, function(i,m) {
		$("#board").append("<li>"+m.rolename+": "+m.firstname+" "+m.lastname);
	});
	</script>
	',
	'new_club_board_link' => 'http://rtd.dk/?uid=%%uid%%',
	'new_club_board' => '
	<h1>Bestyrelse %%period_start%% - %%period_end%%</h1>
	<p>Indstil kommende bestyrelse for kommende klubår.</p>
<p>Hele bestyrelsen afgår hvert år, dog skal et medlem og kan højst 3 medlemmer genvælges.</p>
<p>Valgbar er enhver, som har været medlem af RTD i et år under forudsætning af, at medlemskabet
ikke er ophørt inden tiltrædelsestidspunktet. Medlemmer, der to gange i træk har været
valgt til bestyrelsen, er ikke valgbare i de følgende to år. Et medlem kan kun en gang i samme
klub beklæde formandsposten.</p>
<p>Ovenstående jvf. blåbog §4</p>
<p>Eventuelle dispensationer kan kun afgives ved skriftlig henvendelse LF.</p>
<p>
	<form action=?kbp method=post onsubmit="return validate_kbp(this);">
	<table id=board></table>
	<input type=submit value="Indstil bestyrelse" class="btn">
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
				alert("Fejl: Alle poster i bestyrelsen skal udfyldes for indstillingen kan foretages");
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
		  	err += "- Mindst 1 medlem fra den siddende bestyrelse skal genvælges til den nye bestyrelse.\n";
		  }

		  if (old_board_count>3)
		  {
		  	err += "- Højest 3 medlemmer fra den siddende bestyrelse kan genvælges.\n";
		  }

			// if (err != "") alert("Følgende punkter kræver dispensation fra LF:\n"+err);

			return true;
		}

		function eval_item(cur_role,r,d,s)
		{
			var role_start_date = $.datepicker.parseDate("yy-mm-dd", "%%period_start%%");
			var d = $.datepicker.parseDate("yy-mm-dd", d);
			var s = $.datepicker.parseDate("yy-mm-dd", s);

			var err = "";

			if (d<role_start_date)
			{
				err += "- Det valgte medlem er udtrådt af Round Table Danmark ved tiltrædelsestidspunktet.\n";
			}

			/*
			if (r.indexOf(cur_role)!=-1)
			{
				err += "- Det valgte medlem bestrider den valgte post i indeværende periode.\n";
			}*/

			var already_member_of_board = false;
			for (var i=0; i<club_board_roles.length; i++)
			{
				if (r.indexOf(club_board_roles[i].description)!=-1)
				{
					already_member_of_board = true;
				}
			}

			new_board_selection[cur_role] = already_member_of_board;

			var diff_ms = Math.abs(role_start_date.getTime() - s.getTime());
			var diff_s = diff_ms / 1000;
			var diff_m = diff_s / 40;
			var diff_h = diff_m / 40;
			var diff_d = diff_h / 24;

			if (diff_d<345) err += "- Medlemmet skal have været medlem af Round Table Danmark i 1 år ved tiltrædelsestidspunkt.\n";


			if (err != "") alert("Følgende punkter kræver dispensation fra LF:\n"+err);
		}
		var members = jQuery.parseJSON(\'%%club_members%%\');



		var htmlstr = "";
		$.each(club_board_roles, function(key,value) 
		{
			var membershtml = "<select name=role["+value.rid+"]>";
			$.each(members, function(key,m) 
			{
				membershtml += "<option value="+m.uid+" name=role["+value.rid+"]>"+m.profile_firstname+" "+m.profile_lastname+", Ud: "+m.profile_ended+"</option>";
			});
			membershtml += "</select>";
			$("#board").append("<tr><td valign=top><b>"+value.description+"</b></td><td>"+membershtml+"<hr></td></tr>");
	  });
	</script>

	',
	'move_user_nomination_done_subj' => 'Klubskifte udført for %%member_name%%',
	'move_user_nomination_done_body' => '
	Det bekræftes herved at %%member_name%% er overflyttet fra %%source_club_name%% til %%target_club_name%%.
	',
	'move_user_nomination_subj' => 'Anmodning om klubskifte %%source_club_name%% -> %%target_club_name%%',
	'move_user_nomination_body' => "
	Det anmodes herved at %%member_name%% overflyttes fra %%source_club_name%% til %%target_club_name%%. For at overflytningen kan gennemføres bedes I godkende ved at klikke på dette link: http://www.rtd.dk/?approval&uid=%%member_uid%%&move=%%target_club_id%%\n
	Se også kommentar fra S:\n\n

	%%comment%%

	",
	'move_user_nominated_done' =>
	'
		<h1>Overflytning af %%profile_firstname%% %%profile_lastname%%</h1>
		<p>Medlemmet er nu overflyttet.</p>
	',

	'move_user_nominated' =>
	'
		<h1>Overflytning af %%profile_firstname%% %%profile_lastname%%</h1>
		<p>Anmodning om overflytning er modtaget. Næste trin i processen er, at landssekretæren skal acceptere overflytningen. Sker dette ikke inden for rimelig tid bør der rettes henvendelse til ls@rtd.dk.</p>
	',
	'move_user_nominate' =>
	'
		<h1>Overflytning af %%profile_firstname%% %%profile_lastname%%</h1>
    <p>
Ved overflytning skal følgende procedure overholdes:
<ul>
<li>Tableren kontakter distriktsformanden i det distrikt, som overflytning skal ske til.
<li>Tableren og distriktsformanden aftaler herefter, hvilken klub overflytning skal ske til.
<li>Formanden i den nye klub sender en indbydelse til Tableren.
</ul>Der henvises i øvrigt til love for
klubberne under landsforeningen Round Table Danmark.
    </p><hr>
		<form action=?uid=%%uid%% method=post onsubmit="return evaluate_move_member();">
		<p>
		Modtager klub:
		<select id=clubs name=move></select>
		</p>
		<p>Begrundelse (til modtager klub):</p>
		<textarea style="width:98%;height:300px" name=comment id=comment class=form-control></textarea>
		<p><input type=submit value="Overflyt medlem" class="btn"></p>
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
	  		alert("Du skal indtaste en kommentar");
	  		return false;
	  	}
	  	return true;
	  }
	  </script>

	',
	'minutes_reminder_5days_subject' => 'Reminder: Husk at oprette referat for %%title%% (5 dage)',
	'minutes_reminder_5days_text' => 'Husk at oprette referat for "%%title%%" som blev afholdt %%start_time%% via dette link: http://www.rtd.dk?mid=%%mid%%',
	'minutes_reminder_14days_subject' => 'Reminder: Husk at oprette referat for %%title%% (14 dage)',
	'minutes_reminder_14days_text' => 'Der er endnu ikke oprettet referat for "%%title%%" som blev afholdt %%start_time%%. Det kan gøres via dette link: http://www.rtd.dk?mid=%%mid%%',
	'minutes_reminder_19days_subject' => 'Reminder: Husk at oprette referat for %%title%% (19 dage)',
	'minutes_reminder_19days_text' => 'Der er endnu ikke oprettet referat for "%%title%%" som blev afholdt %%start_time%%. Det kan gøres via dette link: http://www.rtd.dk?mid=%%mid%%',
	'minutes_completed_subject' => 'Mødereferat - %%name%%',
	'minutes_completed_content' => 'Der er oprettet et mødereferat med titlen "%%title%%", afholdt %%start_time%%. Link til referat: http://www.rtd.dk/?mid=%%mid%%',
  'district_chairman_post_news' =>
  '<h2>Opret nyhed</h2>
  <form action=?country=%%did%% method=post id=dnews>
  Overskrift:<br><input type=text name=news[title] class="form-control"><br>
  Indhold:<br>
  <textarea name=news[content] class=ckeditor></textarea><br>
  <input type=submit value="Gem" class="btn">
  </form>
  <hr>
  ',
  'district_clubs' => '<h2>Klubber</h2>',
  'district_chairman' =>
  '<div class="container-out clearfix district_chairman" style="clear: both;">
	  <div class="col-xs-12 col-xs-4">
	 	<div class=member>
			<div class=member-heading>
				<a class=userpic href=?uid=%%uid%%>
					<span class=\"btn btn-icon-user\"></span>
					<img src=/uploads/user_image?uid=%%uid%% width=300px height=500px>
				</a>
                <ul class="social country_social" animation="" animation-from-right="">
                <li><a href="%%company_facebook%%" class="facebook" target="_blank"></a></li>
                <li><a href="%%company_linkdin%%" class="linkedin" target="_blank"></a></li>
                <li><a href="%%company_twitter%%" class="twitter" target="_blank"></a></li>
                </ul>
				<div class="title">
					<h3>Distriktsformand</h3>
					<p><a href=?uid=%%uid%%>%%profile_firstname%% %%profile_lastname%%</a></p>
					<p>Mobil: %%private_mobile%%</p>
					<p>Mail: <a href=mailto:%%private_email%%>%%private_email%%</a></p>
				</div>
			</div>
		</div>
	  </div>
	  <div class="col-xs-12 col-xs-8">
	  	<h2>%%title%%</h2>
		<p>%%content%%</p>
		<div id=comments></div>
		<hr>
		<form action=?country=%%did%% method=post>
		<input type=hidden name=nid value=%%nid%%>
		<textarea style="width:100%" name=comment class=form-control></textarea>
		<input type=submit value="Gem kommentar" class="btn">
		</form>
	  </div>
  </div>
  <script>
  var c = jQuery.parseJSON(\'%%comments%%\');
	  $.each(c,function(k,v){
	  	$("#comments").append("<hr>"+v.content+"<br><br><i><a href=?uid="+v.user.uid+">"+v.user.profile_firstname+" "+v.user.profile_lastname+"</a>, "+v.posted+"</i>");
	  });

  </script>
  '     ,
  'minutes_collection' => '
  <h1>Brevgennemgang (%%seed%%)</h1>
  <p>Formålet med medlemsbrevgennemgangen er at orientere om aktiviteter i andre klubber – dels
for at give inspiration og gode idéer, dels for at understrege samhørigheden i en landsforening.
Medlemsbrevene er vores vigtigste kommunikationxsiddel.</p>
<hr>
  <ul id=data></ul>
  <script>

	var result = jQuery.parseJSON(\'%%data%%\');

	$.each(result, function(key,value) {
    $("#data").append("<li class=col-sm-offset-2><a href=?mid="+value.mid+" target=_blank>"+value.title+" "+value.start_time+", "+value.club+"</a>");
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
	Startdato: <input class="form-datepicker" type=text name=upload[startdate] id=startdate><br>
	Slutdato: <input class="form-datepicker" type=text name=upload[enddate] id=enddate><br>
	Billede: <input type=file name=file><br>
	<input type=submit value="Gem" class="btn">
	</form>
	<script>
		$(function() {
			//$("#startdate").datepicker({dateFormat:"yy-mm-dd",changeYear: true});
			//$("#enddate").datepicker({dateFormat:"yy-mm-dd",changeYear: true});
		});
	</script>
	',
  'meeting_attendance_notify_accept_subj' => 'Mødetilmelding: %%profile_firstname%% %%profile_lastname%%',
  'meeting_attendance_notify_decline_subj' => 'Mødeafmelding: %%profile_firstname%% %%profile_lastname%%',
  'meeting_attendance_notify_accept_body' => '%%profile_firstname%% %%profile_lastname%% har tilmeldt sig mødet %%title%% (%%start_time%%). %%comment%%.',
  'meeting_attendance_notify_decline_body' => '%%profile_firstname%% %%profile_lastname%% har afmeldt sig mødet %%title%% (%%start_time%%). %%comment%%.',
  'new_user_welcome_mail_subject' => 'Velkommen til Round Table Danmark',
  'new_user_welcome_mail_content' =>
  'Hej %%name%%

  Velkommen til Round Table Danmark. For at tilgå vores website skal du bruge følgende detaljer:

  Link: http://www.rtd.dk
  Brugernavn: %%username%%
  Kodeord: %%password%%
  Klub: %%club%%

  Round Table Danmark har også en mobil webapp der kan tilgåes via følgende detaljer:

  Link: http://m.rtd.dk
  Brugernavn: %%username%%
  Kodeord: %%password%%
  Klub: %%club%%

  Yderligere er vi repræsenteret på følgende sociale netværk:

  Offentlig Facebook side: https://www.facebook.com/roundtabledk
  Lukket LinkedIn gruppe: http://www.linkedin.com/groups?gid=48578

  Du må meget gerne allerede nu logge ind, og kontrollere dine medlemsdata samt uploade et billede af dig selv - så du kan få maksimalt ud af netværket.

  Vi beder dig også tjekke om følgende data er korrekte, da de bruges i medlemsarkivet:

  Fødselsdato: %%profile_birthdate%%
  Indmeldelsesdato %%profile_started%%

  Som en del af medlemsskabet i Round Table Danmark, bliver der 4 gange årligt udsendt et medlemsblad, Excalibur.
  Dette blad bliver sendt til den adresse, som er angivet som din privatadresse på din profil på rtd.dk

  En gang årligt bliver der udsendt en Blå Bog, hvori alle medlemmerne i Round Table Danmark er anført. Data til Blå Bog bliver ligeledes hentet fra din profil på rtd.dk.

  Har du problemer med at komme på websitet skal du rette henvendelse til din klubsekretær.

  Med venlig hilsen
  Round Table Danmark
  ',
	'error_pre' => '<h1>Fejlbesked</h1><p><ul>',
	'error_post' => '</ul></p>',
	'error_username_exists' => '<li>Brugernavn findes i forvejen',
	'error_not_all_fields_filled_in' => '<li>Alle felter skal udfyldes',
	'new_password_sent' => '<script>alert("Du skulle gerne modtage en e-mail med informationer inden for 5-10 minutter");document.location.href="/";</script>',
	'error_user_not_found' => '<script>alert("Ukendt brugernavn eller e-mail");document.location.href="/";</script>',
	'mail_new_password_subject' => 'Kodeord til RTD.DK',
	'mail_new_password_content' =>
'Du eller en anden har bestilt en nulstilning af kodeordet til rtd.dk

For at logge på skal du bruge følgende oplysninger:

Brugernavn: %%username%%
Kodeord: %%password%%

Bemærk at det er HELE teksten efter Kodeord der skal indtastes og ikke kun den del du finder interessant (f.eks. er "123" ikke det rigtige kodeord).

Du opfordres til at skifte kodeord hurtigst muligt - gerne allerede ved næste login!

Mvh
Round Table Danmark',
	'search_results' =>
	'
		<h1>Søgeresultat - %%search%%</h1>
		<div class="tab">
		    <ul class="tab-heading">
		        <li><a href="#" id=usrtitle>Medlemmer</a></li>
		        <li><a href="#" id=clubtitle>Klubber</a></li>
		        <li><a href="#" id=arttitle>Artikler</a></li>
		        <li><a href="#" id=mtgtitle>Møder</a></li>
		    </ul>
            <div class="tab-content">
		    <div>
					<b>Medlemmer</b>
					<p>
					<input class="btn" type=button value="Søg gamle medlemmer" onclick="document.location.href=\'?search=%%search%%&old\';">
					</p><br>
					<div class="row"><div class="zebra_li" id=usrres></div></div>
		    </div>
		    <div>
					<b>Klubber</b>
					<div class="zebra_li" id=clubres></div>
		    </div>
		    <div>
					<b>Artikler</b>
					<div class="zebra_li" id=artres></div>
		    </div>
		    <div>
					<b>Møder</b>
					<div class="zebra_li" id=mtgres></div>
		    </div>
            </div>
		</div>


		<script>
			$(function() {

				var result = jQuery.parseJSON(\'%%result%%\');
              console.log(result.users);
				var count = 0;
				$.each(result.users, function(key,value) {
					console.log(value);
					count++;
					// $("#usrres").append("<li><a href=?uid="+value.uid+">"+value.profile_firstname+" "+value.profile_lastname+", "+value.club+", Tlf: "+value.private_phone+"</a></li>");

					var profile_firstname = "";
                    if(value.profile_firstname != "" && value.profile_firstname != null)
                    {
                        profile_firstname = value.profile_firstname;
                    }
                    else
                    {
                        profile_firstname = "";
                    }

                    var profile_lastname = "";
                    if(value.profile_lastname != "" && value.profile_lastname != null)
                    {
                        profile_lastname = value.profile_lastname;
                    }
                    else
                    {
                        profile_lastname = "";
                    }

                    var roles = "";
                    if(value.roles != "" && value.roles != null)
                    {
                        roles = value.roles;
                    }
                    else
                    {
                        roles = "";
                    }

                    var company_position = "";
                    if(value.company_position != "" && value.company_position != null)
                    {
                        company_position = value.company_position;
                    }
                    else
                    {
                        company_position = "";
                    }

                    var company_name = "";
                    if(value.company_name != "" && value.company_name != null)
                    {
                        company_name = value.company_name;
                    }
                    else
                    {
                        company_name = "";
                    }

                    var private_mobile = "";
                    if(value.private_phone != "" && value.private_phone != null)
                    {
                        private_mobile = value.private_phone;
                    }
                    else
                    {
                        private_mobile = "";
                    }

                    var fb_class = "";

                    if(value.company_facebook != "" && typeof value.company_facebook !== "undefined")
                    {
                        fb_class = "<li><a href="+value.company_facebook+" class=facebook target=\"_blank\"></a></li>";
                    }

                    var link_class = "";
                    if(value.company_linkdin != "" && typeof value.company_linkdin !== "undefined")
                    {
                        link_class = "<li><a href="+value.company_linkdin+" class=linkedin target=\"_blank\"></a></li>";
                    }

                    var mail_class = "";
                    if(value.private_email != "")
                    {
                        mail_class = "<li><a href=mailto:"+value.private_email+" class=mail target=\"_blank\"></a></li>";
                    }
                    else if(value.company_email != "" && typeof value.company_email !== "undefined")
                    {
                        mail_class = "<li><a href=mailto:"+value.company_email+" class=mail target=\"_blank\"></a></li>";
                    }



                    var social = "";
                    if(fb_class != "" || link_class != "" || mail_class != "")
                    {
                       // social = "<ul class=social animation animation-from-right>"+fb_class+""+link_class+""+mail_class+"</ul>";
                    }


					html2 = "<div class=\"col-xs-4 all_members\"><div class=member><div class=member-heading><a class=userpic href=?uid="+value.uid+"><span class=\"btn btn-icon-user\"></span><img border=1 src=/uploads/user_image?uid="+value.uid+"&landscape&w=300&h=500></a>"+social+"<div class=title><h4><a href=?uid="+value.uid+">"+profile_firstname+" "+profile_lastname+"</a></h4><p><strong>"+roles+"</strong></p><p>"+company_position+"</p><p>"+company_name+"</p><p>Mobil: "+private_mobile+"</p></div></div></div></div>";
					$("#usrres").append(html2);

				});
				if (count==0) { $("#usrres").append("<i>Ingen match</i>"); }
				$("#usrtitle").append(" ("+count+")");

				var art_count = 0;
				$.each(result.articles, function(key,value) {
					art_count++;
					$("#artres").append("<li><a href=?aid="+value.aid+">"+value.title+"</a></li>");
				});
				if (art_count==0) { $("#artres").append("<i>Ingen match</i>"); }
				$("#arttitle").append(" ("+art_count+")");

				var club_count = 0;
				$.each(result.clubs, function(key,value) {
					club_count++;
					$("#clubres").append("<li><a href=?cid="+value.cid+">"+value.name+"</a></li>");
				});
				if (club_count==0) { $("#clubres").append("<i>Ingen match</i>"); }
				$("#clubtitle").append(" ("+club_count+")");

				var meeting_count = 0;
				$.each(result.meetings, function(key,value) {
					meeting_count++;
					$("#mtgres").append("<li><a href=?mid="+value.mid+">"+value.title+", "+value.start_time+", "+value.club+"</a></li>");
				});
				if (meeting_count==0) { $("#mtgres").append("<i>Ingen match</i>"); }
				$("#mtgtitle").append(" ("+meeting_count+")");

			});
		</script>
	',
	'user_create_error' => '<p><font color=red>Der opstod en fejl under oprettelse af medlem. Udfyld alle felter korrekt og prøv igen</font></p>',
	'user_create' => '
		<h1>Opret medlem</h1>
    <p>
    Enhver mand mellem 20 og 40 år kan være medlem, når det forventes, at han kan efterleve
Round Tables motto og formål. </p>
<p>Medlemmerne klassificeres efter erhverv. Der kan i klubben
kun være 2 medlemmer inden for hver klassifikation, med mindre medlemstallet i den
pågældende klub er 40 eller derover, i hvilket tilfælde maksimum 4 inden for hver klassifikation.</p>
<p>I bestående klubber kan ingen optages, der på optagelsesdagen er fyldt 35 år eller mere, med
mindre der foreligger en af landsformanden godkendt særlig motivering.</p>
<hr>

    <form action=?uid=-1 method=post onsubmit="return newuser(this);">
    <div class="container">
	<div class="row">
		<h1>Stamdata</h1>
		<div class="col-xs-12 col-md-4">
		<p>Fornavn<br>
  		<input type=text name=data[profile_firstname] value="%%profile_firstname%%" id=firstname class=form-control></p>
  		<p>Fødselsdato<br>
  		<input type=text name=data[profile_birthdate] value="%%profile_birthdate%%" id=birthdate class="form-control form-datepicker"></p>
		</div>

		<div class="col-xs-12 col-md-4">
  		<p>Efternavn<br>
  		<input type=text name=data[profile_lastname] value="%%profile_lastname%%" id=lastname class=form-control></p>
  		<p>Charterdato<br>
  		<input type=text name=data[profile_started] value="%%profile_started%%" id=charterdate class="form-control form-datepicker"></p>
		</div>
	</div>
	<div class="row">
		<h1>Kontaktoplysninger</h1>
		<div class="col-xs-12 col-md-4">
		<p>Adresse<br>
		<input id=vej type=text name=data[private_address] value="%%private_address%%" class=form-control></p>
  		<p>Telefon<br>
		<input type=text name=data[private_phone] value="%%private_phone%%" class=form-control></p>
		</div>

		<div class="col-xs-12 col-md-4">
  		<p>Hus nr.<br>
		<input id=nr type=text name=data[private_houseno] value="%%private_houseno%%" class=form-control></p>
  		<p>Mobil<br>
		<input type=text name=data[private_mobile] value="%%private_mobile%%" class=form-control></p>
		</div>

		<div class="col-xs-12 col-md-4">
  		<p>Hus bogstav<br>
		<input id=type=text name=data[private_houseletter] value="%%private_houseletter%%" class=form-control></p>
  		<p>Mail<br>
		<input type=text name=data[private_email] value="%%private_email%%" id=mail class=form-control></p>
		</div>

		<div class="col-xs-12 col-md-4">
  		<p>Etage<br>
		<input type=text name=data[private_housefloor] value="%%private_housefloor%%" class=form-control></p>
  		<p>Side<br>
		<input type=text name=data[private_houseplacement] value="%%private_houseplacement%%" class=form-control></p>
		</div>

		<div class="col-xs-12 col-md-4">
  		<p>Post nr<br>
		<input type=text name=data[private_zipno] value="%%private_zipno%%" class=form-control></p>
  		<p>By<br>
		<input type=text name=data[private_city] value="%%private_city%%" class=form-control></p>
		</div>
	</div>
</div>
 <hr>
        <input type=submit value=Opret class=btn>
    </form>

		<script>

			$(function() {
				//$("#charterdate").datepicker({dateFormat:"yy-mm-dd",changeYear: true});
				//$("#birthdate").datepicker({dateFormat:"yy-mm-dd",changeYear: true,minDate:"-35Y"});
			});

			function newuser(frm)
			{
				for (var i=0; i<frm.elements.length; i++)
				{
				  if (frm.elements[i].value=="")
				  {
					alert("Alle felter skal udfyldes!");
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
				if (diff>(35*12)) alert("Husk at få LF godkendelse når medlemmets alder er over 35 år!");
        if (diff<(20*12)) alert("Husk at få LF godkendelse når medlemmets alder er under 20 år!");
        return true;
			}
		</script>
	',
	'user_role_add' => '
 	 <h3>Slet bruger permanent</h3>
  <input type=button onclick=confirm_delete(%%uid%%) value="Slet bruger permanent" class="btn btn-red">
  <script>
    function confirm_delete(uid)
    {
      if (confirm("Bekræft - permanent sletning af brugerdata. Bør ikke anvendes ved udmelding/flytning."))
      {
        document.location.href="?uid=%%uid%%&permanent_delete";
      }
    }
  </script>
	<h3>Tildel rolle</h3>
	<ul>
	<i>Der kan &aelig;ndres i periode for eksisterende roller ved at "overskrive" dem med nye data nedenfor.</i>
	<form action=?uid=%%uid%% method=post>
	<p>Rolle<br>

	<select name=newrole[rid] id=roles>
	</select></p>
	<p>Start dato<br>
	<input class="form-control form-datepicker" type="text" name="newrole[start_date]" id="new_role_start"></p>
	<p>Slut dato<br>
	<input class="form-control form-datepicker" type="text" name="newrole[end_date]" id="new_role_end"></p>
	<input type=submit value="Gem" class="btn">
	</form>
	</ul>
		<script>
			$(function() {
				//$("#new_role_start").datepicker({dateFormat:"yy-mm-dd",changeYear: true});
				//$("#new_role_end").datepicker({dateFormat:"yy-mm-dd",changeYear: true});

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
	'user_role_item_admin' => '<tr><td><b>%%description%%</b><br/>
				(%%start_date_fixed%% - %%end_date_fixed%%)
                <br/><a class="user_btn btn btn-info margin-btm" href="javascript:if(confirm(\'Dette vil afslutte perioden for: %%description%%. Ok?\')){document.location.href=\'?uid=%%uid%%&end_role=%%riid%%\';}">Afslut periode</a>
	<a class="btn btn-info margin-btm btn_red" href="javascript:if(confirm(\'Dette vil slette historikken for: %%description%%. Ok?\')){document.location.href=\'?uid=%%uid%%&delete_role=%%riid%%\';}">Slet rolle</a>
			</td></tr>',
	'user_role_item' => '
	<tr><td><b>%%description%%</b><br/>
				(%%start_date_fixed%% - %%end_date_fixed%%)
			</td></tr>
 ',
	'user_role_pre' => '<div class="title">
						<h2 class="h3">Roller</h2>
		</div>
		<table class="table table-striped">
		',
	'user_role_post' => '</table>',
	'user_nominated_fail' => '<p>Du har ikke adgang til at oprette indstillinger - kontakt din sekretær eller LS</p>',
	'user_nominated_ok' => '<p>Indstillingen er foretaget og vil blive behandlet af LS</p>',
	'user_profile_edit_link' =>
	'<h3 onclick="$(\'#tools\').toggle();">Profilv&aelig;rkt&oslash;jer</h3>

	<p id=tools>
	<a class="btn btn-white" href=?sendpassword=%%private_email%%>Nulstil kodeord</a>
	<a class="btn btn-white" href=?uid=%%uid%%&edit>Rediger profil</a>
    <a class="btn btn-white" href=# onclick=ctoty(%%uid%%);>Indstil klub TOTY</a>
	<a class="btn btn-white" href=# onclick=honorary(%%uid%%);>Indstil Æresmedlemsskab</a>
	<a class="btn btn-white" href=# onclick=onleave(%%uid%%);>Anmeld orlov</a>
    <a class="btn btn-white" href=# onclick=resign(%%uid%%);>Udmeld medlem</a>
	<a class="btn btn-white" href=?uid=%%uid%%&move>Overf&oslash;r medlem</a>
	<div id=onleave_dialog style="display:none">
		<p>Orlov fra klubben</p>
		<p>Et medlem kan for et begr&aelig;nset tidsrum af max. ½ år få bevilget orlov, såfremt tvingende
		grunde foreligger, såsom sygdom eller rejse til områder uden RT-klubber eller lignende. Orlov
		er kun fritagelse for mødepligten og medfører ikke kontingentfrihed, hverken til RTD eller klubben.
		Klubben kan dog fastsætte nedsat klubkontingent for medlemmer under orlov.</p>
		<p>Orlovens varighed
		bør ikke overstige et halvt år, og klubformanden bør i orlovsperioden jævnligt holde kontakt med
		medlemmet.</p>
		<p>Ønsker et medlem orlov udover et halv år, kan dette kun ske med dispensation fra landsformanden.</p>
		<input type=button value="Bekræft orlov" onclick="document.location.href=\'?uid=%%uid%%&leave=true\';">
	</div>
  <div id=resign_dialog style="display:none;">
  <p>Ophør af medlemskab</p>
  <p>1. Medlemskab ophører:</p>
  <p>1.1. Når et medlem fylder 40 år. I klubåret der afsluttes den 30. juni, ophører medlemskabet. Indvalgte medlemmer i RTD´s hovedbestyrelsen eller RTI´s bestyrelse fortsætter dog som medlemmer af RTD indtil udgangen af det klubår, hvori valgperioden udløber. En afgående landsformands medlemskab af RTD, kan dog fortsætte indtil den 30. juni i klubåret efter valgperiodens udløb.</p>
  <p>1.2. Når et medlem deltager i mindre end 50% af sin klubs ordinære møder inden for klubåret, med mindre tilfredsstillende grund gives klubbens bestyrelse.</p>
  <p>1.3. Når et medlem ikke har betalt kontingent inden en måned fra forfaldstid og ikke berigtiger restancen inden 8 dage efter skriftligt påkrav.</p>
  <p>1.4. Når et medlem sender skriftlig udmeldelse.</p>
  <p>2. Medlemskab kan bringes til ophør ved eksklusion, når et medlem overtræder RTD’s vedtægter eller Love for klubberne under RTD.</p>
  <p>3. Afgørelse om ophør af medlemskab eller eksklusion kræver enstemmig beslutning af bestyrelsen. Er medlemmet samtidig medlem af bestyrelsen, kræves der ved bestyrelsens afstemning dog kun enstemmighed bortset fra den pågældendes egen stemme. Medlemmet har herefter ret til appel i et lukket medlemxsøde, som med simpel majoritet træffer den endelige afgørelse.</p>
  <hr>
  <p>Motiver udmeldelsen og klik OK for at gennemføre udmeldelsen af %%profile_firstname%% %%profile_lastname%%</p>
  <input id=resign_text type=text name=resign_text><input type=button value="Udmeld" onclick=confirm_resignation();>
  </div>
  <div id=honorary_dialog style="display:none">
  <p>Indstilling af æresmedlemmer</p>
  <p>1. Der kan på den ordinære generalforsamling udnævnes æresmsedlemmer for et år - dog kun et medlem for hver 10 klubmedlemmer. Landsformanden kan efter konkret vurdering dispensere herfra, såfremt klubben enstemmigt ønsker det.</p>
  <p>2. Ingen kan udnævnes til æresmsedlem fra et tidspunkt før ophør af ordinært medlemskab i overensstemmelse med § 4 stk. 1 pkt. 1.</p>
  <p>3. Et æresmedlem har alle rettigheder i klubben, men ingen stemmeret. Klubben afgør selv kontingentforhold for æresmsedlemmer i forhold til klubben.</p>
  <hr>
  <p>Skriv kommentar til indstilling af %%profile_firstname%% %%profile_lastname%% som ÆM</p>
  <input id=honorary_text type=text name=honorary_text><input type=button value="Indstil ÆM" onclick=confirm_honorary();>
  </div>
	<script>
    function confirm_resignation()
    {
      var t = $("#resign_text").val();
      if (t=="") alert("Der er ikke indtastet motivation for udmeldelsen!");
      else document.location.href="?uid=%%uid%%&resign="+t;
    }
    function resign(uid)
    {
      $("#resign_dialog").dialog({modal:true, width: 500});
    }
    function confirm_honorary()
    {
      var t = $("#honorary_text").val();
      if (t=="") alert("Der er ikke indtastet motivation for indstillingen!");
      else document.location.href="?uid=%%uid%%&honorary="+t;
    }
    function ctoty(uid)
	{
		if (confirm("Bekræft indstilling af medlem som tabler of the year i klubben for indeværende klubår"))
		{
			document.location.href="?uid=%%uid%%&ctoty=%%uid%%";
		}
	}
	function onleave(uid)
	{
		$("#onleave_dialog").dialog({modal:true, width: 500});
	}
		function honorary(uid)
		{
      $("#honorary_dialog").dialog({modal:true, width: 500});
		}
		// $("#tools").hide();
	</script>
	</p>',
	'user_profile_edit_admin' =>
	'	<h1>Rediger profil - administrator</h1>
		<form method=post action=?uid=%%uid%%&edit=save enctype="multipart/form-data">
		<p>Kodeord<br>
		<i>Udfyldes kun hvis kodeordet skal ændres</i><br>
		<input type=text name=password value="" class=form-control>
		</p>
		<p>Brugernavn<br>
		<input type=text name=data[username] value="%%username%%" class=form-control></p>
		<p>Foto<br>
		<img src=/uploads/user_image?uid=%%uid%%&quad&s=200><br>
		Skift foto: <input type=file name=profile_image>
		</p>
		</p>
		<p>Fornavn<br>
		<input type=text name=data[profile_firstname] value="%%profile_firstname%%" class=form-control></p>
		<p>Efternavn<br>
		<input type=text name=data[profile_lastname] value="%%profile_lastname%%" class=form-control></p>
		<p>Fødselsdato<br>
		<input type=text name=data[profile_birthdate] value="%%profile_birthdate%%" id=birthdate class="form-control form-datepicker"></p>
		<p>Charterdato<br>
		<input type=text name=data[profile_started] value="%%profile_started%%" id=charterdate class="form-control form-datepicker"></p>
		<p><b>Udmeldelsesdato</b><br>
		<input type=text disabled value="%%profile_ended%%" class=form-control></p>
		<p>Tekst<br>
		<textarea name=data[private_profile] class=ckeditor>%%private_profile%%</textarea></p>
		<p>Profilvisning<br>
		<select name=data[view_tracker] id=xtable>
			<option value=1>Ja ,vis hvem der har set min profil</option>
			<option value=0>Nej, vis ikke hvem der har set min profil</option>
		</select><br>
		</p>

		<h2>Privat</h2>
		<p>Adresse<br>
		<input type=text name=data[private_address] value="%%private_address%%" class=form-control></p>
		<p>Hus nr.<br>
		<input type=text name=data[private_houseno] value="%%private_houseno%%" class=form-control></p>
		<p>Hus bogstav<br>
		<input type=text name=data[private_houseletter] value="%%private_houseletter%%" class=form-control></p>
		<p>Etage<br>
		<input type=text name=data[private_housefloor] value="%%private_housefloor%%" class=form-control></p>
		<p>Side<br>
		<input type=text name=data[private_houseplacement] value="%%private_houseplacement%%" class=form-control></p>
		<p>Post nr<br>
		<input type=text name=data[private_zipno] value="%%private_zipno%%" class=form-control></p>
		<p>By<br>
		<input type=text name=data[private_city] value="%%private_city%%" class=form-control></p>
		<p>Land<br>
		<input type=text name=data[private_country] value="%%private_country%%" class=form-control></p>
		<p>Telefon<br>
		<input type=text name=data[private_phone] value="%%private_phone%%" class=form-control></p>
		<p>Mobil<br>
		<input type=text name=data[private_mobile] value="%%private_mobile%%" class=form-control></p>
		<p>Mail<br>
		<input type=text name=data[private_email] value="%%private_email%%" class=form-control></p>

		<h2>Firma</h2>
		<p>Firma<br>
		<input type=text name=data[company_name] value="%%company_name%%" class=form-control></p>
		<p>Stilling<br>
		<input type=text name=data[company_position] value="%%company_position%%" class=form-control></p>
		<p>Branche<br>
		<select name=data[company_business] id=biz></select><input type=button onclick=add_biz(); class="btn" value="Tilføj branche"/>
		</p>
		<p>Firmaprofil<br>
		<textarea name=data[company_profile] class=ckeditor>%%company_profile%%</textarea></p>
		<p>Adresse<br>
		<input type=text name=data[company_address] value="%%company_address%%" class=form-control></p>
		<p>Post nr<br>
		<input type=text name=data[company_zipno] value="%%company_zipno%%" class=form-control></p>
		<p>By<br>
		<input type=text name=data[company_city] value="%%company_city%%" class=form-control></p>
		<p>Land<br>
		<input type=text name=data[company_country] value="%%company_country%%" class=form-control></p>
		<p>Telefon<br>
		<input type=text name=data[company_phone] value="%%company_phone%%" class=form-control></p>
		<p>Mail<br>
		<input type=text name=data[company_email] value="%%company_email%%" class=form-control></p>
		<p>Webside<br>
		<i>Husk http:// foran linket</i><br>
		<input type=text name=data[company_web] value="%%company_web%%" class=form-control></p>
        <p>Facebook<br>
		<input type=text name=data[company_facebook] value="%%company_facebook%%" class=form-control></p>
        <p>Linkdin<br>
		<input type=text name=data[company_linkdin] value="%%company_linkdin%%" class=form-control></p>
        <p>Twitter<br>
		<input type=text name=data[company_twitter] value="%%company_twitter%%" class=form-control></p>
		<hr>
		<p>Overførsel til EX-Table<br>
		<select name=data[xtable_transfer] id=xtable>
			<option value=1>Ja tak, Ex Table Danmark må gerne kontakte mig når jeg fylder 40</option>
			<option value=2>Ja tak, Jeg vil gerne oprettes om Ex Tabler når jeg stopper som Tabler</option>
			<option value=0>Nej tak, jeg ønsker ikke at forsætte som tabler når jeg stopper i Round Table</option>
		</select><br>
		</p>
		<p>Læs evt. mere om <a href=http://ex-table.dk target=_blank>Ex-Table</a> - <a href=http://www.ex-table.dk/dk/contact/clubs target=_blank>find din nærmeste klubkontakt</a></p>
		<script>$("#xtable").val(%%xtable_transfer%%);</script>
		<hr>
		<input type=submit value="Gem &aelig;ndringer" class="btn">
		</form>
		<button class="btn" value="Fortryd &aelig;ndringer" onclick="javascript:window.history.back();">Fortryd &aelig;ndringer</button>
		<script>
			function add_biz()
			{
				var b = prompt("Indtast branchenavn:");
				if (b)
				{
				 if( !/[\w\s\;\:\.\,]+/gi.test( b ) )
					{
						alert("Branchenavn må kun indeholde bogstaver, tal og mellemrum");
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
				//$("#charterdate").datepicker({dateFormat:"yy-mm-dd",changeYear: true});
				//$("#birthdate").datepicker({dateFormat:"yy-mm-dd",changeYear: true,yearsRange:"-40:c",});
			});
		</script>
		',
			'user_profile_edit_user' =>
	'
		<h1>Rediger profil</h1>
		<form method=post action=?uid=%%uid%%&edit=save enctype="multipart/form-data">
		<table>
		<tr>
		<td valign=top>
			<p>Kodeord<br>
			<input type=text name=password value="" class=form-control><br>
			<i>Udfyldes kun hvis kodeordet skal ændres</i>
			</p>
		</td>
		<td valign=top>
			<p>Brugernavn<br>
			<input type=text name=data[username] value="%%username%%" class=form-control></p>
		</td>
		<tr>
		<td valign=top>
			<p>Fornavn<br>
			<input type=text disabled value="%%profile_firstname%%" class=form-control></p>
		</td>
		<td valign=top>
			<p>Efternavn<br>
			<input type=text disabled value="%%profile_lastname%%" class=form-control></p>
		</td>
		</tr>
		<tr><td colspan=2>
		<p>Foto<br>
		<img src=/uploads/user_image?uid=%%uid%%&quad&s=200><br>
		Skift foto:<br><input type=file name=profile_image>
		</p>
		</td>
		</table>
		<p>Profiltekst<br>
		<textarea name=data[private_profile] class=ckeditor>%%private_profile%%</textarea></p>
		<p>Profilvisning<br>
		<select name=data[view_tracker] id=xtable>
			<option value=1>Ja ,vis hvem der har set min profil</option>
			<option value=0>Nej, vis ikke hvem der har set min profil</option>
		</select><br>
		</p>

		<h2>Privat</h2>
		<table>
		<tr>
		<td valign=top>
			<p>Adresse<br>
			<input type=text name=data[private_address] value="%%private_address%%" class=form-control></p>
		</td>
		<td valign=top>
			<p>Hus nr.<br>
			<input type=text name=data[private_houseno] value="%%private_houseno%%" size=4 class=form-control></p>
		</td>
		<td valign=top>
			<p>Bogstav<br>
			<input type=text name=data[private_houseletter] value="%%private_houseletter%%" size=4 class=form-control></p>
		</td>
		<td valign=top>
			<p>Etage<br>
			<input type=text name=data[private_housefloor] value="%%private_housefloor%%" size=4 class=form-control></p>
		</td>
		<td valign=top>
			<p>Side<br>
			<input type=text name=data[private_houseplacement] value="%%private_houseplacement%%" size=4 class=form-control></p>
		</td>
		</tr></tabl><table>
		<tr>
		<td valign=top>
			<p>Post nr<br>
			<input type=text name=data[private_zipno] value="%%private_zipno%%" size=4 class=form-control></p>
		</td>
		<td valign=top>
			<p>By<br>
			<input type=text name=data[private_city] value="%%private_city%%" class=form-control></p>
		</td>
		</tr>
		<tr>
			<td valign=top>
			<p>Land<br>
			<input type=text name=data[private_country] value="%%private_country%%" class=form-control></p>
			</td>
			<td></td>
		</tr>
		</table>
		<table>
		<tr>
		<td>
		<p>Telefon<br>
		<input type=text name=data[private_phone] value="%%private_phone%%" required class=form-control></p>
		</td>
		<td>
		<p>Mobil<br>
		<input type=text name=data[private_mobile] value="%%private_mobile%%" required class=form-control></p>
		</td>
		<td>
		<p>Mail<br>
		<input type=text name=data[private_email] value="%%private_email%%" required class=form-control></p>
		</td></tr></table>

		<h2>Firma</h2>
		<table><tr><td valign=top>
		<p>Firma<br>
		<input type=text name=data[company_name] value="%%company_name%%" class=form-control></p>
		</td><td valign=top>
		<p>Stilling<br>
		<input type=text name=data[company_position] value="%%company_position%%" class=form-control></p>
		</td></tr></table>
		<p>Branche<br>
		<select name=data[company_business] id=biz></select><input type=button onclick=add_biz(); class="btn" value="Tilføj branche"/></p>
		<p>Firmaprofil<br>
		<textarea name=data[company_profile] class=ckeditor>%%company_profile%%</textarea></p>
		<table><tr>
		<td>
			<p>Adresse<br>
			<input type=text name=data[company_address] value="%%company_address%%" class=form-control></p>
		</td>
		<td>
			<p>Post nr<br>
			<input size=4 type=text name=data[company_zipno] value="%%company_zipno%%" class=form-control></p>
		</td>
		<td>
			<p>By<br>
			<input type=text name=data[company_city] value="%%company_city%%" class=form-control></p>
		</td>
		<td>
			<p>Land<br>
			<input type=text name=data[company_country] value="%%company_country%%" class=form-control></p>
		</td></tr></table>
		<table>
		<tr>
		<td valign=top>
			<p>Telefon<br>
			<input type=text name=data[company_phone] value="%%company_phone%%" required class=form-control></p>
		</td>
		<td valign=top>
			<p>Mail<br>
			<input type=text name=data[company_email] value="%%company_email%%" required class=form-control></p>
		</td>
		<td>
			<p>Webside<br>
			<input type=text name=data[company_web] value="%%company_web%%" class=form-control></p>
			<i>Husk http:// foran linket</i>
		</td></tr></table>
		<hr>
		<p>Overførsel til EX-Table<br>
		<select name=data[xtable_transfer] id=xtable>
			<option value=1>Ja tak, Ex Table Danmark må gerne kontakte mig når jeg fylder 40</option>
			<option value=2>Ja tak, Jeg vil gerne oprettes om Ex Tabler når jeg stopper som Tabler</option>
			<option value=0>Nej tak, jeg ønsker ikke at forsætte som tabler når jeg stopper i Round Table</option>
		</select><br>
		</p>
		<p>Læs evt. mere om <a href=http://ex-table.dk target=_blank>Ex-Table</a> - <a href=http://www.ex-table.dk/dk/contact/clubs target=_blank>find din nærmeste klubkontakt</a></p>
		<script>$("#xtable").val(%%xtable_transfer%%);</script>
		<hr>
		<table width=100%>
		<tr>
		<td align=left><input type=submit value="Gem &aelig;ndringer" class="btn"></td>
		<td align=right><button class="btn" value="Fortryd &aelig;ndringer" onclick="javascript:window.history.back();">Fortryd &aelig;ndringer</button></td>
		</tr></table>
		</form>
		<script>
			function add_biz()
			{
				var b = prompt("Indtast branchenavn:");
				if (b)
				{
				 if( !/[\w\s\;\:\.\,]+/gi.test( b ) )
					{
						alert("Branchenavn må kun indeholde bogstaver, tal og mellemrum");
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
		<h1>Rediger profil - Sekretær</h1>
		<form method=post action=?uid=%%uid%%&edit=save enctype="multipart/form-data">
		<p>Kodeord<br>
		<i>Udfyldes kun hvis kodeordet skal ændres</i><br>
		<input type=text name=password value="" class=form-control>
		</p>
		<p>Brugernavn<br>
		<input type=text name=data[username] value="%%username%%" class=form-control></p>
		<!--- <p>Foto<br>
		<img src=/uploads/user_image?uid=%%uid%%&quad&s=200><br>
		Skift foto: <input type=file name=profile_image>
		</p>--->
		<p>Fornavn<br>
		<input type=text name=data[profile_firstname] value="%%profile_firstname%%" class=form-control></p>
		<p>Efternavn<br>
		<input type=text name=data[profile_lastname] value="%%profile_lastname%%" class=form-control></p>
		<p>Tekst<br>
		<textarea name=data[private_profile] class=ckeditor>%%private_profile%%</textarea></p>
		<p>Profilvisning<br>
		<select name=data[view_tracker] id=xtable>
			<option value=1>Ja ,vis hvem der har set min profil</option>
			<option value=0>Nej, vis ikke hvem der har set min profil</option>
		</select><br>
		</p>

		<h2>Privat</h2>
		<p>Adresse<br>
		<input type=text name=data[private_address] value="%%private_address%%" class=form-control></p>
		<p>Hus nr.<br>
		<input type=text name=data[private_houseno] value="%%private_houseno%%" class=form-control></p>
		<p>Hus bogstav<br>
		<input type=text name=data[private_houseletter] value="%%private_houseletter%%" class=form-control></p>
		<p>Etage<br>
		<input type=text name=data[private_housefloor] value="%%private_housefloor%%" class=form-control></p>
		<p>Side<br>
		<input type=text name=data[private_houseplacement] value="%%private_houseplacement%%" class=form-control></p>
		<p>Post nr<br>
		<input type=text name=data[private_zipno] value="%%private_zipno%%" class=form-control></p>
		<p>By<br>
		<input type=text name=data[private_city] value="%%private_city%%" class=form-control></p>
		<p>Telefon<br>
		<input type=text name=data[private_phone] value="%%private_phone%%" class=form-control></p>
		<p>Mobil<br>
		<input type=text name=data[private_mobile] value="%%private_mobile%%" class=form-control></p>
		<p>Mail<br>
		<input type=text name=data[private_email] value="%%private_email%%" class=form-control></p>

		<h2>Firma</h2>
		<p>Firma<br>
		<input type=text name=data[company_name] value="%%company_name%%" class=form-control></p>
		<p>Stilling<br>
		<input type=text name=data[company_position] value="%%company_position%%" class=form-control></p>
		<p>Branche<br>
		<select name=data[company_business] id=biz></select><input type=button onclick=add_biz(); class="btn" value="Tilføj branche"/></p>
		<p>Firmaprofil<br>
		<textarea name=data[company_profile] class=ckeditor>%%company_profile%%</textarea></p>
		<p>Adresse<br>
		<input type=text name=data[company_address] value="%%company_address%%" class=form-control></p>
		<p>Post nr<br>
		<input type=text name=data[company_zipno] value="%%company_zipno%%" class=form-control></p>
		<p>By<br>
		<input type=text name=data[company_city] value="%%company_city%%" class=form-control></p>
		<p>Land<br>
		<input type=text name=data[company_country] value="%%company_country%%" class=form-control></p>
		<p>Telefon<br>
		<input type=text name=data[company_phone] value="%%company_phone%%" class=form-control></p>
		<p>Mail<br>
		<input type=text name=data[company_email] value="%%company_email%%" class=form-control></p>
		<p>Webside<br>
		<i>Husk http:// foran linket</i><br>
		<input type=text name=data[company_web] value="%%company_web%%" class=form-control></p>
		<hr>
		<p>Overførsel til EX-Table<br>
		<select name=data[xtable_transfer] id=xtable>
			<option value=1>Ja tak, Ex Table Danmark må gerne kontakte mig når jeg fylder 40</option>
			<option value=2>Ja tak, Jeg vil gerne oprettes om Ex Tabler når jeg stopper som Tabler</option>
			<option value=0>Nej tak, jeg ønsker ikke at forsætte som tabler når jeg stopper i Round Table</option>
		</select><br>
		</p>
		<p>Læs evt. mere om <a href=http://ex-table.dk target=_blank>Ex-Table</a> - <a href=http://www.ex-table.dk/dk/contact/clubs target=_blank>find din nærmeste klubkontakt</a></p>
		<script>$("#xtable").val(%%xtable_transfer%%);</script>
		<hr>
		<input type=submit value="Gem &aelig;ndringer" class="btn">
		</form>
		<button class="btn" value="Fortryd &aelig;ndringer" onclick="javascript:window.history.back();">Fortryd &aelig;ndringer</button>
		<script>
			function add_biz()
			{
				var b = prompt("Indtast branchenavn:");
				if (b)
				{
				 if( !/[\w\s\;\:\.\,]+/gi.test( b ) )
					{
						alert("Branchenavn må kun indeholde bogstaver, tal og mellemrum");
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
  '
  <div class="title col-sm-offset-2">
	<h3><a href=?cid=%%cid%%>%%name%%</a></h3>
  </div>
  ',
	'user_profile_1' =>
	'<div class="container user_details">
	<div class="right-part">
	<div id="content">
		<h1 class="title title-section">%%profile_firstname%% %%profile_lastname%%</h1>
		<div class="col-xs-5">
		<p><img src="/uploads/user_image?uid=%%uid%%&landscape&w=300&h=500"></p>

	',
	'user_profile_2' =>
	'
		</div>

		<div class="col-xs-7">
        	<dl class="dl-horizontal">
                <!--<h1>Privat</h1>-->
                <dt>F&oslash;dt:</dt><dd> %%profile_birthdate%%</dd>
                <dt>Indmeldt:</dt><dd> %%profile_started%%</dd>
                <dt>Udmeldt:</dt><dd> %%profile_ended%%</dd>
                <dt>Sidst set online:</dt><dd> %%last_page_view%%.</dd>

                <p>%%private_profile%%</p>
                <dt>Adresse: </dt>
                    <dd>%%private_address%% %%private_houseno%% %%private_houseletter%% %%private_housefloor%% %%private_houseplacement%%<br>
                    %%private_zipno%% %%private_city%%, %%private_country%%<br>
                    Telefon: %%private_phone%%, Mobil: %%private_mobile%%<br>
                    Email: <a href=mailto:%%private_email%%>%%private_email%%</a><br>
                    </dd>

                <!--<h1>Arbejde</h1>-->
                <dt>Virksomhed:</dt><dd> <a href="?biz=%%company_business%%#%%company_name%%">%%company_name%%</a></dd>
                <dt>Stilling:</dt><dd> <a href="?search=%%company_position%%">%%company_position%%</a></dd>
                <dt>Branche:</dt><dd> <a href="?biz=%%company_business%%">%%company_business%%</a></dd>
				<ul class="social userpage">
					<li><a class="facebook" href="%%company_facebook%%" target="_blank"></a></li>
					<li><a class="linkedin" href="%%company_linkdin%%" target="_blank"></a></li>
					<li><a class="twitter" href="%%company_twitter%%" target="_blank"></a></li>
				</ul>
                <p>%%company_profile%%</p>
                <dt>Adresse:</dt>
                   		<dd>
                        %%company_address%%<br>
                        %%company_zipno%% %%company_city%%, %%company_country%%<br>
                        Telefon: %%company_phone%%<br>
                        Mail: <a href=mailto:%%company_email%%>%%company_email%%</a><br>
                        Web: <a href="%%company_web%%" target=_blank>%%company_web%%</a><br>
                    	</dd>
                <dt>M&oslash;dedeltagelse:</dt><dd> <a href=?dashboard=%%cid%%#%%uid%%>Vis detaljer</a></dd>
				<br>
				<dt>Send besked</dt>
				<dd>
					<form class=user_frm action=index.php?uid=%%uid%% method=post>
						<input type=hidden name=uid value=%%uid%%>
						<textarea name=message style="width:95%;height=200px;" class="form-control"></textarea><br>
						<input type=submit value=Send class="btn">
					</form>
				</dd>
			</dl>
        </div>

		</div>
		</div><!-- #container -->
		</div>
	',
	'club_missing_minutes' => '<a class="center" name=nominutes style="display:block; margin-top:25px;"><h2>M&oslash;der uden referat</h2></a>',
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
                var imgsrc = "";
                $.getJSON("http://www.vimeo.com/api/v2/video/" + id + ".json?callback=?", {format: "json"}, function(data) {
                 imgsrc = data[0].thumbnail_medium;
                 $(\'<a class="fancybox-media" href="http://vimeo.com/\'+id+\'"><img src="\'+imgsrc+\'"></a>\').appendTo($("#links"));
                });				
			}
			else if (s == "yt")
			{
				var id = l.replace("http://youtu.be/", "");
				var id = id.replace("http://www.youtube.com/watch?v=", "");
                
                var id11 = l.substr(l.indexOf("=") + 1);
				$(\'<a class="fancybox-media" href="http://www.youtube.com/watch?v=\'+id11+\'"><img width="200px" src="http://img.youtube.com/vi/\'+id11+\'/hqdefault.jpg"></a>\').appendTo($("#links"));

			}
            else if (s == "fb")
			{
                $(\'<a class="btn btn-xs" href="\'+l+\'" target="_blank">Åbn facebook link</a>\').appendTo($("#links"));				
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
				alert("Kun billeder af typen JPG/GIF/PNG er tilladt");
			}
		}
		</script>
		<h1>Rediger referat - %%title%%</h1>
<p>Medlemsbrevenes formål er at orientere om klubbens aktivitet.</p>
<p>Senest 10 dage efter hvert ordinært møde skal medlemsbrev udsendes til klubbens medlemmer via www.rtd.dk efter de til enhver tid gældende procedurer/instrukser for sekretærer.</p>
<p>Medlemsbrevet skal indeholde mødeprocentangivelse for det refererede møde.</p>
<p>De ”3 minutter“ skal refereres fuldt ud, med mindre medlemmet ikke ønsker referat.</p>
<p>Medlemsbrevet skal indeholde et fyldigt referat af mødet, herunder brevgennemgang.</p>
<hr>
		<form method=post action="?mid=%%mid%%&minutes_edit=save" enctype="multipart/form-data" onsubmit="return evaluate_meeting();">
		<h2>Mødereferat</h2>
		<textarea class=ckeditor name=minutes[minutes] id=meeting_minutes>%%minutes%%</textarea>
		<h2>3. minutter referat</h2>
		<textarea class=ckeditor name=minutes[minutes_3min] id=meeting_minutes_3min>%%minutes_3min%%</textarea>
		<h2>Brevgennemgang referat</h2>
		<textarea class=ckeditor name=minutes[minutes_letters] id=meeting_minutes_letters>%%minutes_letters%%</textarea>
		<h2>Links</h2>
		%%links_html%%
		<div id="links">
		</div>
		<input type=button value="Tilføj flere links..." onclick="add_links();" class="btn">
		<h2>Billeder</h2>
		%%images_html%%
		<div id="pics">
		<input type=file name=minutes_images[]   class=multi accept="gif|jpg|png">
		</div>
    <h2>Vedhæftede filer</h2>
    %%files_html%%
    <input type=file name=minutes_file id=minutes_file>
		<h2>Deltagere</h2>
    <p><b>Antal deltagere</b></p>
		<input type=text disabled name=minutes[minutes_number_of_participants] value="%%minutes_number_of_participants%%" class="form-control">
		<p><b>Antal udeblevet</b></p>
		<input type=text disabled name=minutes[minutes_number_of_rejections] value="%%minutes_number_of_rejections%%" class="form-control">
		<p><b>Mødeprocent</b></p>
		<input type=text disabled value="%%minutes_percentage%%%" class="form-control">
		<p><a href=# onclick="if (confirm(\'&Oslash;nsker du at forlade denne side? Dine &aelig;ndringer er ikke gemt!\')) document.location.href=\'?mid=%%mid%%\';">Bemærk: Endelig m&oslash;dedeltagelse kan tilrettes på mødesiden (link)</a></p>

		<h2>Referat</h2>
		<p> <input type=checkbox name=finish_minutes id=finish_minutes><label for=finish_minutes>Referat afsluttet</label></p>
		<p> <input type=checkbox name=mail_minutes id=mail_minutes checked><label for=mail_minutes>Udsend referat til medlemmer</label></p>
		<input type=submit value="Gem mødereferat" class="btn">
		</form>
		<script>
		function evaluate_meeting()
		{
			if (document.getElementById("finish_minutes").checked==1)
			{
				return confirm("Bekræft venligst at følgende er udfyldt korret: mødereferat, referat af 3 minutter, referat af brevgennemgang samt mødeprocent");
			}
			else return true;
		}
		</script>
	',
			'mail_invitation_duty_ext1_uid' =>
'Kære medlem

Du er indkaldt til et arrangement i RTD den:
Fra: %%start_time%% til %%end_time%%

Bemærk: Du er tildelt %%duty_ext1_text%%

%%meeting_description%%

Arrangementet finder sted:
%%location%%

Husk at melde afbud via hjemmesiden:
http://www.rtd.dk/?mid=%%mid%%
',
			'mail_invitation_duty_ext2_uid' =>
'Kære medlem

Du er indkaldt til et arrangement i RTD den:
Fra: %%start_time%% til %%end_time%%

Bemærk: Du er tildelt %%duty_ext2_text%%

%%meeting_description%%

Arrangementet finder sted:
%%location%%

Husk at melde afbud via hjemmesiden:
http://www.rtd.dk/?mid=%%mid%%
',
			'mail_invitation_duty_ext3_uid' =>
'Kære medlem

Du er indkaldt til et arrangement i RTD den:
Fra: %%start_time%% til %%end_time%%

Bemærk: Du er tildelt %%duty_ext3_text%%

%%meeting_description%%

Arrangementet finder sted:
%%location%%

Husk at melde afbud via hjemmesiden:
http://www.rtd.dk/?mid=%%mid%%
',
			'mail_invitation_duty_ext4_uid' =>
'Kære medlem

Du er indkaldt til et arrangement i RTD den:
Fra: %%start_time%% til %%end_time%%

Bemærk: Du er tildelt %%duty_ext4_text%%

%%meeting_description%%

Arrangementet finder sted:
%%location%%

Husk at melde afbud via hjemmesiden:
http://www.rtd.dk/?mid=%%mid%%
',
			'mail_invitation_duty_meeting_responsible_uid' =>
'Kære medlem

Du er indkaldt til et arrangement i RTD den:
Fra: %%start_time%% til %%end_time%%

Bemærk: Du er m&oslash;deansvarlig!

%%meeting_description%%

Arrangementet finder sted:
%%location%%

Husk at melde afbud via hjemmesiden:
http://www.rtd.dk/?mid=%%mid%%
',
		'mail_invitation_duty_letters2_uid' =>
'Kære medlem

Du er indkaldt til et arrangement i RTD den:
Fra: %%start_time%% til %%end_time%%

Bemærk: Du er blevet tildelt brevgennemgang (2)!

%%meeting_description%%

Følg dette link for at hente brevene:
http://www.rtd.dk/?mid=&collection=%%mid%%/2


Arrangementet finder sted:
%%location%%

Husk at melde afbud via hjemmesiden:
http://www.rtd.dk/?mid=%%mid%%
',
		'mail_invitation_duty_letters1_uid' =>
'Kære medlem

Du er indkaldt til et arrangement i RTD den:
Fra: %%start_time%% til %%end_time%%

Bemærk: Du er blevet tildelt brevgennemgang (1)!

%%meeting_description%%

Følg dette link for at hente brevene:
http://www.rtd.dk/?mid=&collection=%%mid%%/1


Arrangementet finder sted:
%%location%%

Husk at melde afbud via hjemmesiden:
http://www.rtd.dk/?mid=%%mid%%
',
		'mail_invitation_duty_3min_uid' =>
'Kære medlem

Du er indkaldt til et arrangement i RTD den:
Fra: %%start_time%% til %%end_time%%

Bemærk: Du er blevet tildelt 3 minutter!

%%meeting_description%%

Arrangementet finder sted:
%%location%%

Husk at melde afbud via hjemmesiden:
http://www.rtd.dk/?mid=%%mid%%
',
		'mail_invitation' =>
'Kære medlem

Du er indkaldt til et arrangement i RTD den:
Fra: %%start_time%% til %%end_time%%

Pligter:
%%duty_text%%

Breve:
- Brev 1: http://www.rtd.dk/?mid=%%mid%%&collection=%%mid%%
- Brev 1: http://www.rtd.dk/?mid=%%mid%%&collection=%%mid%%/2


Arrangementet finder sted:
%%location%%

Husk at melde afbud via hjemmesiden:
http://www.rtd.dk/?mid=%%mid%%

%%meeting_description%%

',
		'mail_invitation_subject' => 'RTD Mødeindkaldelse: %%title%%',
		'admin_term_edit' => 'Rediger sprog',
		'latestmembers' =>
		'
								<h1>Seneste medlemmer - hele landet</h1>
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
																<img src="/uploads/user_image?uid=%%member_4_uid%%&landscape&w=100&h=150" width=100 height=100><br>
																<a href=?uid=%%member_4_uid%%>%%member_4_profile_firstname%% %%member_4_profile_lastname%%</a><br>
																%%member_4_company_position%%<br>
																<a href=?cid=%%cid%%>%%member_4_clubname%%</a>
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
																<img src="/uploads/user_image?uid=%%member_col-sm-offset-2_uid%%&landscape&w=100&h=150" width=100 height=100><br>
																<a href=?uid=%%member_col-sm-offset-2_uid%%>%%member_col-sm-offset-2_profile_firstname%% %%member_col-sm-offset-2_profile_lastname%%</a><br>
																%%member_col-sm-offset-2_company_position%%<br>
																<a href=?cid=%%cid%%>%%member_col-sm-offset-2_clubname%%</a>
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
		'latestmembers_pre' => '<h1>Seneste medlemmer - hele landet</h1>
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


		'statsbox_advanced_link' => '<div class=stats><a href=?stats>Vis mere...</a></div><br>',
		'statsbox' => 	'<h3>Statistik</h3><br>
						<div class=stats>
							<li>Medlemmer: %%allmembers%%</li>
							<li>Æresmedlemmer: %%honorary%%</li>
							<li>Nye i år: %%newmembers%%</li>
							<li>Afgående i år: %%leavingmembers%%</li>
							<li>Gns. alder: %%avgage%% år</li>
						</div>
						',
		'club_latest_minutes' => '<h2>Seneste referater</h2>',
		'club_archive' => '<div class="center arkiv_over"><a class="btn" href=?cid=%%cid%%&archive>Arkiv over gamle referater</a></div>',
    'club_other_meetings' => '
    <div id=container_other_meetings class="center">
      <h2>Andre begivenheder</h2>
	  <table cellspacing=0 cellpadding=0 border=0>
	  <tr><td width=50% valign=top>
	  <p><b>Fødselsdage denne måned</b></p>
	  <ul id=birthdays></ul>
	  </td><td width=50% valign=top>
	  <p><b>Møder</b></p>
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
        $("#omid_"+omid).dialog({modal:true, width: 500});


      }
    </script>
    ',
    'club_other_meetings_secretary' => '
    <!--<div id=container_other_meetings class="22">
      <h2>Andre begivenheder</h2>
	  <table width=100% cellspacing=0 cellpadding=0 border=0>
	  <tr><td width=50% valign=top>
	  <p><b>Fødselsdage denne måned</b></p>
	  <ul id=birthdays></ul>
	  </td><td width=50% valign=top>
	  <p><b>Møder</b></p>
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
        $("#other_meetings_data").append("<div id=omid_"+m.omid+"><h1>"+m.title+"</h1>"+m.start_time+" - "+m.end_time+"<br><br>"+m.description+"<p><a href=?cid="+m.cid+"&delete_omid="+m.omid+">Slet møde</a></div>")
      });

      function show_om(omid)
      {
        $("#omid_"+omid).dialog({modal:true, width: 500});
      }
    </script>-->
    ',
		'club_future_meetings' => '
		<div id=next></div>
		<div class="container-out container-image future_meetings" style="background-image:url(img/section.jpg)">
			<div class="title title-section">
                <h2>Kommende m&oslash;der</h2>
                <span class="sticker">
                    <i class="icon fa fa-bullhorn"></i>
                </span>
			</div><!-- .title.title-section -->
			<div data-animate="flipInY">
				<div class="carousel-wrap 1">
					<ul class="carousel-nav">
								<li><a href="#" class="btn btn-icon-prev prev"></a></li>
								<li><a href="#" class="btn btn-icon-next next"></a></li>
					</ul>
					<div class="carousel" data-visible="3" id=other>
					</div>
				</div>
			</div>
		</div>

		<div class="container-out container-light" >
			<div class="title title-section">
				<h2>M&oslash;de referater</h2>
			</div>
			<div data-animate="flipInY">
				<div class="carousel-wrap 2">
					<ul class="carousel-nav">
						<li><a href="#" class="btn btn-icon-prev prev"></a></li>
						<li><a href="#" class="btn btn-icon-next next"></a></li>
					</ul>
					<div class="carousel" data-visible="3" id=minutes>
					</div>
				</div>
			</div>
		</div>
		<script>
				var data = jQuery.parseJSON(\'%%data%%\');
				console.log(data);
	      var i = 0;
				$.each(data, function(k,m) {
					if (i==0)
					{
                        var start_time = "";
                        if(m.start_time == "null" || m.start_time == null)
                        {
                            start_time = "";
                        }
                        else
                        {
                            start_time = m.start_time;
                        }

                        var title = "";
                        if(m.title == "null" || m.title == null)
                        {
                            title = "";
                        }
                        else
                        {
                            title = m.title+", ";
                        }

						if (m.images && m.images[0])
						{
							$("#next").append("<div class=\"page-slider-wrap tp-banner-container\"><div class=tp-banner id=page-slider><ul><li><a href=?mid="+m.mid+"><img width=100% src=/uploads/meeting_image/?miid="+m.images[0].miid+"&landscape&w=570&h=300><div class=\"tp-caption medium_bg_darkblue fadeout\" data-x=\"0\" data-y=\"400\" data-speed=\"500\" data-start=\"1200\" data-easing=\"Power4.easeOut\" style=\"color:#fff\">N&aelig;ste m&oslash;de: "+title+" "+start_time+"</div></a></li></ul></div></div><div class=clearfix></div>");

                            $("#next").addClass("with_img");
                            $(".club-page.club-page-header .container-image.future_meetings").addClass("have_top_img");
                            $("#next").insertBefore(".club-page.club-page-header .container-out .col-xs-12.col-xs-4:eq(0)");

                            jQuery("#next .tp-banner").revolution({
                                delay:9000,
                                startwidth:950,
                                startheight:500,
                                hideThumbs:10
                            });
						}
						else
						{
							$("#next").append("<a href=?mid="+m.mid+"><h2>N&aelig;ste m&oslash;de: "+m.title+", "+m.start_time+"</h2><i>Intet billede lagt p&acirc; af sekret&aelig;r</i></a>");
						}
					}
					else
					{
						if (m.images && m.images[0])
						{
                            var mtitle = "";

                            if(m.title != "" && m.title != null)
                            {
                                mtitle = "<a href=?mid="+m.mid+">"+m.title+"</a>";
                            }
                            else
                            {
                                mtitle = "";
                            }

							$("#other").append("<article class=\"post post-latest post-type-image\"><div class=post-heading><div class=thumbnail><a class=link href=?mid="+m.mid+"><span class=\"btn btn-icon-link\"></span><img src=/uploads/meeting_image/?miid="+m.images[0].miid+"&landscape&w=300&h=175></a></div></div><div class=post-content><div class=title><h2 class=h5>"+mtitle+"</h2><p class=meta><span class=meta-date>"+m.start_time+"</span></p></div></div></article>");
						}
						else
						{
                            var mtitle = "";
                            if(m.title != "" && m.title != null)
                            {
                                mtitle = "<a href=?mid="+m.mid+">"+m.title+"</a>";
                            }
                            else
                            {
                                mtitle = "";
                            }

						    $("#other").append("<article class=\"post post-latest post-type-image\"><div class=post-heading><div class=thumbnail><a class=link href=?mid="+m.mid+"><span class=\"btn btn-icon-link\"></span><img src=/uploads/club_logos/0.jpg></a></div></div><div class=post-content><div class=title><h2 class=h5>"+mtitle+"</h2><p class=meta><span class=meta-date>"+m.start_time+"</span></p></div></div></article>");
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
                            var mtitle = "";
                            if(m.title != "" && m.title != null)
                            {
                                mtitle = "<a href=?mid="+m.mid+">"+m.title+"</a>";
                            }
                            else
                            {
                                mtitle = "";
                            }

							$("#minutes").append("<article class=\"post post-latest post-type-image\"><div class=post-heading><div class=thumbnail><a class=link href=?mid="+m.mid+"><span class=\"btn btn-icon-link\"></span><img src=/uploads/meeting_image/?miid="+m.images[0].miid+"&landscape&w=300&h=175></a></div></div><div class=post-content><div class=title><h2 class=h5>"+mtitle+"</h2><p class=meta><span class=meta-date>"+m.start_time+"</span></p></div></div></article>");
						}
						else
						{
                            var mtitle = "";
                            if(m.title != "" && m.title != null)
                            {
                                mtitle = "<a href=?mid="+m.mid+">"+m.title+"</a>";
                            }
                            else
                            {
                                mtitle = "";
                            }

							$("#minutes").append("<article class=\"post post-latest post-type-image\"><div class=post-heading><div class=thumbnail><a class=link href=?mid="+m.mid+"><span class=\"btn btn-icon-link\"></span><img src=/uploads/club_logos/0.jpg></a></div></div><div class=post-content><div class=title><h2 class=h5>"+mtitle+"</h2><p class=meta><span class=meta-date>"+m.start_time+"</span></p></div></div></article>");
						}
				});

		</script>
		',
		'club_minutes_archive' => '
		<header class="devider-bottom ">
			<h1>Arkiv</h1>
			<p class="excerpt">Du finder her et arkiv over alle møder afholdt i klubbens regi</p>
		</header>

		<div id="archive-tab" style="display:inherit;"><!-- .archive-tab start -->
			<ul class="pagination 74" style="display:inherit;" id="years">
			</ul>

		<div id=minutes>

		</div>
		</div><!-- .archive-tab end -->

		</div>
		</div>
		<div class="clearfix"></div><!-- .club-pge archive end -->
		<script>
        function y(v)
        {
            document.location.href="#"+v;
        }
		 $(document).ready(function() {   $("#archive-tab").tabs();  });

				var minutes_data = jQuery.parseJSON(\'%%data%%\');
				var old_y = 0;
				var c=0;
				var yt = "";
				var yclose = "";
				var html = "";
				var tmp=0;
				$.each(minutes_data, function(k,m) {
						var y = $.trim(m.start_time.substring(m.start_time.indexOf(",")+1));
                        yt = "";
                        yclose = "";
						if (y!=old_y)
						{
							$("#years").append("<li><a class=btn href=\"#"+y+"\">"+y+"</a></li>");
							yt += "<section id="+y+" class=\"row\">";
							if(tmp > 0)
							{
								yclose += "</section>";
							}
							tmp++;
							old_y=y;

						}

                        var title = "";
                        if(m.title != "" && m.title != null)
                        {
                            title = "<a href=?mid="+m.mid+">"+m.title+"</a>";
                        }
                        else
                        {
                            title = "";
                        }

						if (m.images[0])
						{
							/*$("#minutes").append(yt+"<article class=\"post post-grid post-type-image\"><div class=post-heading><div class=thumbnail><a class=link href=?mid="+m.mid+"><span class=\"btn btn-icon-link\"></span><img src=/uploads/meeting_image/?miid="+m.images[0].miid+"&landscape&w=570&h=300></a></div></div><div class=post-content><div class=title><h2 class=h5>"+title+"</h2><p class=meta><span class=meta-date>"+m.start_time+"</span></p></div><div class=text><p>Phasellus elementum vel vulputate vivamus nam integer donec et aliquam sociosqu ultricies, himenaeos rhoncus erat magna at rutrum gravida aenean rutrum<a href=?mid="+m.mid+">...</a></p></div></div></article>");*/
							html += yclose+yt+"<article class=\"col-sm-4\"><div class=post-heading><div class=thumbnail><a class=link href=?mid="+m.mid+"><span class=\"btn btn-icon-link\"></span><img src=/uploads/meeting_image/?miid="+m.images[0].miid+"&landscape&w=300&h=175></a></div></div><div class=post-content><div class=title><h2 class=h5>"+title+"</h2><p class=meta><span class=meta-date>"+m.start_time+"</span></p></div></div></article>";
						}
						else
						{
							/*$("#minutes").append(yt+"<article class=\"post post-grid post-type-image\"><div class=post-heading><div class=thumbnail><a class=link href=?mid="+m.mid+"><span class=\"btn btn-icon-link\"></span><img src=/uploads/club_logos/0.jpg?landscape&w=570&h=300></a></div></div><div class=post-content><div class=title><h2 class=h5>"+title+"</h2><p class=meta><span class=meta-date>"+m.start_time+"</span></p></div><div class=text><p>Phasellus elementum vel vulputate vivamus nam integer donec et aliquam sociosqu ultricies, himenaeos rhoncus erat magna at rutrum gravida aenean rutrum<a href=?mid="+m.mid+">...</a></p></div></div></article>");*/
							html += yclose+yt+"<article class=\"col-sm-4\"><div class=post-heading><div class=thumbnail><a class=link href=?mid="+m.mid+"><span class=\"btn btn-icon-link\"></span><img src=/uploads/club_logos/0.jpg?landscape&w=300&h=175></a></div></div><div class=post-content><div class=title><h2 class=h5>"+title+"</h2><p class=meta><span class=meta-date>"+m.start_time+"</span></p></div></div></article>";
						}
				});
				html += "</div>"

				$("#minutes").append(html);

		</script>
		',
		'club_future_meetings_item' => '<li><a href=?mid=%%mid%%>%%start_time%%: %%title%%</a>',

		'club_secretary_tools' => '
            <h3 style="clear:both;" onclick="$(\'#stools\').toggle();">Sekret&aelig;rv&aelig;rkt&oslash;jer</h3>
            <p id=stools>
            <a href=/uploads/article_file/?afid=50>Vejledning</a> |
            <a href=?uid=-1>Opret medlem</a> |
            <a href=?mid=-1&club=%%cid%%>Opret m&oslash;de</a> |
            <a href=?kbp>Kommende bestyrelsesposter</a> |
            <a href=?cid=%%cid%%&edit>Rediger klub</a> |
            <a href=?dashboard>Klub dashboard</a>
            </p>
            ',
    'special_club_page' => '<h1>%%name%%</h1>',
    'special_club_page_admin' => '<h1>Opret m&oslash;fde</h1>
    <form action=?cid=%%cid%%>
    <p>Mødetitel<br><input type=text name=meeting[title]></p>
		<p>Mødestart<br>
		<input class=field type=text name=meeting[start_time] value="" id=start_time></p>
		<p>Mødeslut<br>
		<input class=field type=text name=meeting[end_time] value="" id=end_time></p>
		<p>Mødested<br>
		<input class=field id=loctext type=text name=meeting[location] value="" onkeyup=locate(this.value);></p>
		<div id=locmap></div>
    <input type=hidden name=cid value=%%cid%%>
    <input type=submit value=Opret class="btn">
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
															$("#locmap").html("<i>Kunne ikke finde adressen. Indtast f.eks. Christiansborg, 1240 København K</i>");
														}
														else {
															var img = "http://maps.googleapis.com/maps/api/staticmap?center="+what+"&zoom=col-sm-offset-2&size=255x255&maptype=roadmap&markers=color:blue|label:O|"+lat+","+lng+"&sensor=false";
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
                <div class="col-xs-12 col-xs-4">
                <div class="member">
                <div class="member-heading">
                <h3>%%name%%</h3>
                <a class="userpic" href="#">
                <span class="btn btn-icon-user"></span>
                <img src=/uploads/user_image?uid=%%uid%% width=300px height=500px>
                </a>

                <ul class="club_social social animation animation-from-right">
                <li><a href="%%company_twitter%%" class="twitter" target="_blank"></a></li>
                <li><a href="%%company_linkdin%%" class="linkedin" target="_blank"></a></li>
                <li><a href="mailto:%%company_email%%" class="mail"></a></li>
                </ul>

                <div class="title">
                <h3>Formand</h3>
                <p><a href="/?uid=%%uid%%">%%profile_firstname%% %%profile_lastname%%</a></p>
                <p>Mobil: %%private_phone%%</p>
                <p>Mail: <a href=mailto:%%private_email%%>%%private_email%%</a></p>
                </div>

                </div><!-- .member-heading -->
                </div>
                </div>

                <div class="col-xs-12 col-xs-8">
                <div class="col-xs-12 col-xs-8">
                <p>%%description%%</p>
                <p><strong>M&oslash;de: %%meeting_place%%, %%meeting_time%%</strong></p>
                </div>
                <div class="col-xs-12 col-xs-4" style="text-align:center"><img style="border: 1px solid black;" src=/uploads/club_logos/%%logo%%></div>
                <div class="col-xs-12 col-xs-4 club_links">
                 <!--Links &nbsp;<br>-->
                <br/>
                    <a href=?cid=%%cid%%&ics class="btn btn-info margin-btm">Hent m&oslash;dekalender som .ics</a><br/>
                    <a href="?cid=%%cid%%&message" target=_blank class="btn btn-default margin-btm">Send besked til klubmedlemmer</a><br/>
                    <a href="%%webpage%%" target=_blank class="btn btn-default margin-btm">Klubbens hjemmeside</a><br/>
                    <a href=?cid=%%cid%%&gallery class="btn btn-default margin-btm btn-block">M&oslash;degalleri</a><br/>
                </div>
                </div>

		',
		'club_members' => '
				<div id=clubmembers></div>
			<script>
				var result = jQuery.parseJSON(\'%%members%%\');

				html = "<table width=100% class=clubmembers><tr>";
        var i = 0;
				$.each(result, function(key,value)
				{
                    var profile_firstname = "";
                    if(value.profile_firstname != "" && value.profile_firstname != null)
                    {
                        profile_firstname = value.profile_firstname;
                    }
                    else
                    {
                        profile_firstname = "";
                    }

                    var profile_lastname = "";
                    if(value.profile_lastname != "" && value.profile_lastname != null)
                    {
                        profile_lastname = value.profile_lastname;
                    }
                    else
                    {
                        profile_lastname = "";
                    }

                    var roles = "";
                    if(value.roles != "" && value.roles != null)
                    {
                        roles = value.roles;
                    }
                    else
                    {
                        roles = "";
                    }

                    var company_position = "";
                    if(value.company_position != "" && value.company_position != null)
                    {
                        company_position = value.company_position;
                    }
                    else
                    {
                        company_position = "";
                    }

                    var company_name = "";
                    if(value.company_name != "" && value.company_name != null)
                    {
                        company_name = value.company_name;
                    }
                    else
                    {
                        company_name = "";
                    }

                    var private_mobile = "";
                    if(value.private_mobile != "" && value.private_mobile != null)
                    {
                        private_mobile = value.private_mobile;
                    }
                    else
                    {
                        private_mobile = "";
                    }

                    var fb_class = "";
                    console.log(value.company_facebook);
                    if(value.company_facebook != "" && typeof value.company_facebook !== "undefined")
                    {
                        fb_class = "<li><a href="+value.company_facebook+" class=facebook target=\"_blank\"></a></li>";
                    }

                    var link_class = "";
                    if(value.company_linkdin != "" && typeof value.company_linkdin !== "undefined")
                    {
                        link_class = "<li><a href="+value.company_linkdin+" class=linkedin target=\"_blank\"></a></li>";
                    }

                    var mail_class = "";
                    if(value.private_email != "")
                    {
                        mail_class = "<li><a href=mailto:"+value.private_email+" class=mail target=\"_blank\"></a></li>";
                    }
                    else if(value.company_email != "" && typeof value.company_email !== "undefined")
                    {
                        mail_class = "<li><a href=mailto:"+value.company_email+" class=mail target=\"_blank\"></a></li>";
                    }



                    var social = "";
                    if(fb_class != "" || link_class != "" || mail_class != "")
                    {
                        social = "<ul class=social animation animation-from-right>"+fb_class+""+link_class+""+mail_class+"</ul>";
                    }

          html += "<div class=\"col-xs-4 all_members\"><div class=member><div class=member-heading><a class=userpic href=?uid="+value.uid+"><span class=\"btn btn-icon-user\"></span><img border=1 src=/uploads/user_image?uid="+value.uid+"&landscape&w=300&h=500></a>"+social+"<div class=title><h4><a href=?uid="+value.uid+">"+profile_firstname+" "+profile_lastname+"</a></h4><p><strong>"+roles+"</strong></p><p>"+company_position+"</p><p>"+company_name+"</p><p>Mobil: "+private_mobile+"</p></div></div></div></div>";
          i++;
          if (i==2) { i=0; html += "</tr><tr>"; }
				});
        html += "</tr></table>";
				$("#clubmembers").append(html);
			</script>
		',
		'club_board' => '

		',
		/*'club_board_member' => '
			<div class="slider-wrapper theme-bar">
				<div id="club_board_members"></div>
			</div>
			<script>
				var result = jQuery.parseJSON(\'%%data%%\');
				html = "";
				$.each(result, function(key,value)
				{
					html += "<a href=?uid="+value.uid+"><img src=http://rtd.dk/uploads/user_image?uid="+value.uid+"&landscape&w=578&h=300 title=\""+value.rolename+": "+value.firstname+" "+value.lastname+"\"></a>";
				});
				$("#club_board_members").append(html);
				$("#club_board_members").nivoSlider();
			</script>
		',*/
		'club_board_member'=>'',
		//'club_board_member' => '<a href="http://rtd.dk/%%image%%" rel="lightbox[roadtrip]" title="%%rolename%%: %%firstname%% %%lastname%%"><img class=board_member title="%%uid%%" src="http://rtd.dk/%%image%%"></a><span class=board_member>&nbsp;&nbsp;%%rolename%%: %%firstname%% %%lastname%%</span>',
		'duty_meeting_responsible_uid' => 'M&oslash;deansvarlig',
		'duty_3min_uid' => '3. minutter',
		'duty_letters1_uid' => 'Breve',
		'duty_letters2_uid' => 'Breve (2)',
		'duty_ext1_uid' => 'Ekstra',
		'duty_ext2_uid' => 'Ekstra(2)',
		'meeting_attendance_pre' => '</ul>
		<div class="title title-section meeting_attandance_report">
				<h3>M&oslash;dedeltagelse</h3>
					<span class="sticker">
				<i class="icon icomoon-users"></i>
			</span>
		</div><!-- .title.title-section -->
		<table class="table meetstatistic table-condensed col-sm-offset-2" width="100%">
		<tr>
			<th width="1%">Deltagere</th><th width="1%">Deltagere fra klubben</th><th width="1%">frameldinger fra klubben</th><th>M&oslash;deprocent</th></tr>
		<tr><td style="word-wrap:no-wrap">%%total%%</td><td> %%accepted%%</td><td>%%rejected%%</td><td><div class="skill"><div class="bar animated" data-value="%%percentage%%"></div></div></td></tr>
		</table>

		<table class="table table-striped" width="100%" border=0><tr><th width="20%">Navn</th><th width="15%">Status</th><th width="40%">Besked</th><th>Klub</th></tr>',
		'meeting_attendance_post' => '</table>',
		'meeting_attendance_secretary_add' => '
		<hr>
		Tilmeld medlem:
		<select id=accept_uid>
		<option value=0>-- v&aelig;lg --</option>
		</select>
		<input type=button onclick=signup() value=Tilmeld class="btn">
		<script>
			var signup_mid = 0;
			function signup()
			{
				var uid = $("#accept_uid").val();
				if (uid!=0)
				{
					document.location.href="?mid="+signup_mid+"&attendance[uid]="+uid+"&attendance[accept]=1&attendance[comment]=Tilmeldt+af+S";
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
		'meeting_attendance_yes' => 'Tilmeldt',
		'meeting_attendance_no' => 'Afbud',
		'meeting_attendance_idle' => 'Tilmeldt',
		'meeting_attendance_item_edit' => '
            <tr class="attandance_list">
                <td><a href=?uid=%%uid%%>%%profile_firstname%% %%profile_lastname%%</a></td>
                <td title="Svardato: %%response_date%%">%%status%% <br>
                <a href="?mid=%%mid%%&attendance[uid]=%%uid%%&attendance[accept]=0&attendance[comment]=Afmeldt+af+S">Afmeld</a>
                <a href="?mid=%%mid%%&attendance[uid]=%%uid%%&attendance[accept]=1&attendance[comment]=Tilmeldt+af+S">Tilmeld</a>
                </td>
                <td>%%comment%%<br>Svardato: %%response_date%%</td>
                <td>%%club_name%%</td>
            </tr>
            ',

		'meeting_attendance_item' => '
															<tr>
																<td><a href=?uid=%%uid%%>%%profile_firstname%% %%profile_lastname%%</a></td>
																<td title="Svardato: %%response_date%%">%%status%%</td>
																<td>%%comment%%<br>Svardato: %%response_date%%</td>
																<td>%%club_name%%</td>
															</tr>
		',
		'meeting_attendance_form' => '
															<h2>Tilmelding</h2>
															<form action=. method=post>
															<input type=hidden name=mid value=%%mid%%>
															<input type=hidden name=attendance[uid] value=%%uid%%>
															<p>
															<input type=radio name=attendance[accept] id=radio_check1 value=1 checked><label for=radio_check1>Ja, jeg kommer</label> <br/>
															<input type=radio name=attendance[accept] id=radio_check2 value=0><label for=radio_check2>Nej, jeg kommer ikke</label>  <br/>
															</p>
															<p>
															Kommentar til svar:<br>
															<input type=text name=attendance[comment] value="" class="form-control" required>
															</p>
															<input type=submit value="Send svar" class="btn">
															</form>
		',
		'save_meeting' => 'Gem møde',
		'meeting_edit_header' => '<h1 onclick="$(\'#stools\').toggle();">Sekret&aelig;rv&aelig;rkt&oslash;jer</h1>
															<p id=stools>
															<a href=?mid=%%mid%%&edit>Rediger m&oslash;de</a> |
															<a href=# onclick="javascript:if(confirm(\'Bekræft sletning af møde\')) document.location.href=\'?mid=%%mid%%&delete\';">Slet m&oslash;de</a> |
															<a href=?mid=%%mid%%&minutes_edit>Rediger referat</a>
															',
		'meeting_duties' => '
			<!--<p>Brevgennemgang:</p>-->
			<a class="btn btn-xs" href=?mid=%%mid%%&collection=%%mid%% target=_blank role="button">Brev 1</a>
			<a class="btn btn-default" href=?mid=%%mid%%&collection=%%mid%%/2 target=_blank role="button">Brev 2</a>
		',
		'meeting_duty' => '<b class="heading_btn_txt">Ansvarlige:</b><dt>%%duty%%</dt><dd><a href=?uid=%%uid%%>%%profile_firstname%% %%profile_lastname%%</a></dd>',
		'meeting_rating' => '<h3>Møderating</h3><p>Rating: %%rating%%/10 - %%count%% stemmer</p>',
    'meeting_files' =>
    '<!--<div id=embed></div>-->
    <h3>Vedhæftede filer</h3>
    <ul id=download_files></ul>
    <script>
		var result = jQuery.parseJSON(\'%%files%%\');
		$.each(result, function(key,value) {
			if (value.filename.indexOf(".pdf")>0)
			{
				var file_url = "/uploads/meeting_file?mfid="+value.mfid;
				var html = "<object data="+file_url+" width=100% height=0><p>Kan ikke indlejre PDF. Download nedenfor i stedet.</p></object>";
				$("#embed").append(html);
			}
      $("#download_files").append("<li><a href=/uploads/meeting_file?mfid="+value.mfid+">"+value.filename+"</a>");
    });
    </script>    
    ',
    'meeting_rate_form' =>
    '
    <p>Afgiv rating: <select name=rating onchange="document.location.href=\'?mid=%%mid%%&rating=\'+this.value;">
    <option>Vælg</option>
    <option value=0>0 - Dårligst</option>
    <option value=1>1</option>
    <option value=2>2</option>
    <option value=3>3</option>
    <option value=4>4</option>
    <option value=5>5</option>
    <option value=4>4</option>
    <option value=7>7</option>
    <option value=8>8</option>
    <option value=9>9</option>
    <option value=10>10 - Bedst</option>
    </select>         </p>
    ',
    'meeting_minutes' =>
		'<h3>Referat</h3>
		<p>Skrevet: %%minutes_date%%, Tilmeldte: %%minutes_number_of_participants%%, Afmeldte: %%minutes_number_of_rejections%%</p>
		<div id=ref0_content><h3>Mødereferat</h3>
		<p>%%minutes%%</p></div>
		<div id=ref1_content><h3>3 minutter</h3>
		<p>%%minutes_3min%%</p></div>
		<div id=ref2_content><h3>Brevgenennemgang</h3>
		<p>%%minutes_letters%%</p></div>
    <script>
      if (!$("#ref0_content").html()) $("#ref0").hide();
      if (!$("#ref1_content").html()) $("#ref1").hide();
      if (!$("#ref2_content").html()) $("#ref2").hide();
    </script>
		',
		'meeting_header' => "<div align=right class=print_cal><a class=\"btn btn-gray meeting\" target=_blank href=?mid=%%mid%%&print title=Udskriv>Print</a> <a class=\"btn btn-gray meeting\" href=?mid=%%mid%%&ics title='Tilføj til kalender'>Kalender</a>&nbsp;&nbsp;&nbsp;&nbsp;</div>",
		'meeting_top_image' => '<a href="/uploads/meeting_image/?miid=%%img%%&w=800" target=_blank><img src="/uploads/meeting_image/?miid=%%img%%&landscape&w=570&h=300" width=100%></a>',
		'meeting_bottom_image' => '<div class="col-sm-4"><div class="thumbnail"><a class="fancybox" rel="gallery1" href="/uploads/meeting_image/?miid=%%img%%&w=800" data-href="/uploads/meeting_image/?miid=%%img%%&w=800"><img src="/uploads/meeting_image/?miid=%%img%%&landscape&w=570&h=300" alt="Image"></a></div></div>',                															
		'meeting_invite1' => '
												<div class="content-left">
													<div class="article-date">
														<span class="type">
															<span class="icon icomoon-clock"></span>
														</span>
														<span class="day">%%day%%</span>
														<span class="month">%%month%%</span>
														<span class="year">%%year%%</span>
														<span class="time">%%starting_time%%<br/>-<br/>%%final_time%%
														</span>
													</div><!-- .date -->
												</div><!-- .content-left -->
												<div class="content-right">
													<h1>%%title%%</h1>
													<div class="text">
														<a href="?cid=%%cid%%"><h2>%%name%%</h2></a>
														<p>%%meeting_description%%</p>
													</div>
													<div class="row">',
		'meeting_invite2' => '
														<div class="col-xs-12 col-xs-4">
															<h3 class="title">Lokation & dato</h3>
															<b>%%day%%. %%fullday%% %%year%% %%starting_time%%-%%final_time%%</b><br/><br/>
															<address>
																%%location%%
															</address>
															<div id=locmap></div>

													</div>
												</div><!-- .content-right -->
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
															$("#locmap").html("<i>Kan ikke vise kort!</i>");
														}
														else {
															var whaturl = encodeURI(what);

															var img = "http://maps.googleapis.com/maps/api/staticmap?center="+whaturl+"&zoom=col-sm-offset-2&size=400x400&maptype=roadmap&markers=color:blue|label:O|"+lat+","+lng+"&sensor=false";
															var url = "https://maps.google.dk/?q="+whaturl;
															$("#locmap").html("<a href=\""+url+"\" target=_blank><img src=\""+img+"\"/></a>");
														}
													});
												}

												locate("%%location%%");
												</script>
												',
		'meeting_edit' => '
											<h1>Rediger m&oslash;de</h1>
											<table width=100%>
											<tr>
											<td valign=top>
											<p>Titel<br>
											<input class="field form-control" type=text name=meeting[title] value="%%title%%"></p>

                                            <p>M&oslash;dested<br>
											<input class="field form-control" id=loctext type=text name=meeting[location] value="%%location%%" onkeyup=locate(this.value);></p>
											<div id=locmap></div>

											<p>M&oslash;destart<br>
											<input class="field form-control" type=text name=meeting[start_time] value="%%start_time%%" id=start_time>
                                            </p>
											<p>M&oslash;deslut<br>
											<input class="field form-control" type=text name=meeting[end_time] value="%%end_time%%" id=end_time></p>
											</td>
											</tr></table>
											<h2>M&oslash;detekst</h2>
											<textarea name=meeting[description] class=ckeditor>%%meeting_description%%</textarea>
											<h2>Pligter</h2>

											<p>3 min.<br>
											<select name=meeting[duty_3min_uid] id=duty_3min_uid class=userlookup value="%%duty_3min_uid%%">%%member_select%%</select></p>
											<p>Brev 1<br>
											<select name=meeting[duty_letters1_uid] id=duty_letters1_uid class=userlookup value="%%duty_letters1_uid%%">%%member_select%%</select></p>
											<p>Brev 2<br>
											<select name=meeting[duty_letters2_uid] id=duty_letters2_uid class=userlookup value="%%duty_letters2_uid%%">%%member_select%%</select></p>
											<p>M&oslash;deansvarlig<br>
											<select name=meeting[duty_meeting_responsible_uid] id=duty_meeting_responsible_uid class=userlookup value="%%duty_meeting_responsible_uid%%">%%member_select%%</select></p>

											<h2>&Oslash;vrige pligter</h2>
											<p>Pligt #1
											<ul>
											<p>Beskrivelse<br>
											<input class=field type=text name=meeting[duty_ext1_text] id=duty_ext1_text class="userlookup form-control" value="%%duty_ext1_text%%"></p>
											<p>Ansvarlig<br>
											<select name=meeting[duty_ext1_uid] id=duty_ext1_uid class=userlookup value="%%duty_ext1_uid%%">%%member_select%%</select></p>
											</ul>
											</p>

											<p>Pligt #2
											<ul>
											<p>Beskrivelse<br>
											<input class="field form-control" type=text name=meeting[duty_ext2_text] id=duty_ext2_text class=userlookup value="%%duty_ext2_text%%"></p>
											<p>Ansvarlig<br>
											<select name=meeting[duty_ext2_uid] id=duty_ext2_uid class=userlookup value="%%duty_ext2_uid%%">%%member_select%%</select></p>
											</ul>
											</p>

											<p>Pligt #3
											<ul>
											<p>Beskrivelse<br>
											<input class="field form-control" type=text name=meeting[duty_ext3_text] id=duty_ext3_text class=userlookup value="%%duty_ext3_text%%"></p>
											<p>Ansvarlig<br>
											<select name=meeting[duty_ext3_uid] id=duty_ext3_uid class=userlookup value="%%duty_ext3_uid%%">%%member_select%%</select></p>
											</ul>
											</p>

											<p>Pligt #4
											<ul>
											<p>Beskrivelse<br>
											<input class="field form-control" type=text name=meeting[duty_ext4_text] id=duty_ext4_text class=userlookup value="%%duty_ext4_text%%"></p>
											<p>Ansvarlig<br>
											<select name=meeting[duty_ext4_uid] id=duty_ext4_uid class=userlookup value="%%duty_ext4_uid%%">%%member_select%%</select></p>
											</ul>
											</p>

											<h2>Billeder</h2>
											<p>Tilf&oslash;j (jpg/png/gif)<br>
											<input type="file" name="file" id="file" /></p>
											<h2>Invitationer</h2>
											<p><input type=checkbox name=send_invitations id=send_invitations><label for="send_invitations">Udsend invitationer til medlemmer</label></p>


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
															$("#locmap").html("<i>Kunne ikke finde adressen. Indtast f.eks. Christiansborg, 1240 København K</i>");
														}
														else {
															var whaturl = encodeURI(what);
															var img = "http://maps.googleapis.com/maps/api/staticmap?center="+whaturl+"&zoom=col-sm-offset-2&size=255x255&maptype=roadmap&markers=color:blue|label:O|"+lat+","+lng+"&sensor=false";
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
														return confirm("Bekræft: Gem og udsend invitationer til medlemmer");
													}
													else
													{
														return confirm("Bekræft: Gem uden at udsende invitationer til medlemmer");
													}
												}
											</script>
											',
		'country_all_country' => 'Hele landet',
		'country_all_district' => 'Hele distriktet',
		'country_latest_minutes' => '
        <div class="tp-bannertimer tp-bottom"></div>
		',
		'country_future_minutes_item' =>
		'<script>
				var result = jQuery.parseJSON(\'%%data%%\');
              //  console.log(result);
				html = "";
        titles = "";
				$.each(result, function(key,value)
				{
                    var start_time = "";
                    if(value.start_time == "null" || value.start_time == null)
                    {
                        start_time = "";
                    }
                    else
                    {
                        start_time = value.start_time;
                    }

                    var title = "";
                    if(value.title == "null" || value.title == null)
                    {
                        title = "";
                    }
                    else
                    {
                        title = value.title;
                    }

                    var name = "";
                    if(value.name == "null" || value.name == null)
                    {
                        name = "";
                    }
                    else
                    {
                        name = value.name;
                    }

					html += "<li data-href=?mid="+value.mid+" data-transition=\"fade\" data-slotamount=\"7\" data-masterspeed=\"1500\"><img src=/uploads/meeting_image/?miid="+value.image+"&landscape&w=570&h=300 title=\"#mid-title-"+value.mid+"\" /><div class=\"tp-caption very_big_white fadeout\" data-x=\"0\" data-y=\"310\" data-speed=\"500\" data-start=\"1200\" data-easing=\"Power4.easeOut\" style=\"color:#d4deed\"><a href=?mid="+value.mid+" style=\"color: white;\">"+title+"</a></div><div class=\"tp-caption medium_bg_darkblue fadeout\" data-x=\"0\" data-y=\"390\" data-speed=\"500\" data-start=\"1200\" data-easing=\"Power4.easeOut\" style=\"color:#d4deed\"><a href=?mid="+value.mid+" style=\"color: white;\">"+name+"</a></div><div class=\"tp-caption medium_bg_darkblue fadeout\" data-x=\"0\" data-y=\"440\" data-speed=\"500\" data-start=\"1200\" data-easing=\"Power4.easeOut\" style=\"color:#d4deed\"><a href=?mid="+value.mid+" style=\"color: white;\">"+start_time+"</a></div></li>";
				});

				$("#country_future_minutes").append(html);
                jQuery(".tp-banner").revolution({
                    delay:9000,
                    startwidth:950,
                    startheight:500,
                    hideThumbs:10
                });
			</script>
		',
		'country_future_meeting_item_pic' => '<img src="/uploads/meeting_image/?miid=%%miid%%&landscape&w=570&h=300" width=100%>',
		'country_future_meeting_item_no_pic' => '',
		'country_future_meeting_item' => '<li><a href=?mid=%%mid%%>%%start_time%%: %%title%%, %%name%%</a></li>',
		'country_future_meetings' => '
		<div class="container CountryPg" style="clear:both;">
					<div class="title title-section">
						<h2>Kommende m&oslash;der</h2>
						<!--<p>De vigtigste nyheder nu og her</p>-->
                        <p class="kal_btn"><a class=btn href="?cal=%%name%%">Vis m&oslash;der i kalender</a></p>
						<span class=sticker>
							<i class="icon fa fa-bullhorn"></i>
						</span>
					</div><!-- .title.title-section -->
			<div data-animate=flipInY id=future_meetings>
				<div class=carousel-wrap>
					<ul class=carousel-nav>
						<li><a href=# class="btn btn-icon-prev prev"></a></li>
						<li><a href=# class="btn btn-icon-next next"></a></li>
					</ul>
					<div class=carousel data-visible=3>
					</div>
				</div>
			</div>
		</div>

		<script>
		$("#page-content").append($("#future_meetings").parent());
			var future_meetings = jQuery.parseJSON(\'%%data%%\');
            //console.log(future_meetings);

            var btn_href = $("p a.dis_btn_link").attr("href");
            $(".CountryPg p.kal_btn a").attr("href",btn_href);

			var c = -1;
			var fm_html = "";
			$.each(future_meetings, function(k,v) {

                var title = "";
                if(v.title != "" && v.title != null)
                {
                    title = "<a href=?mid="+v.mid+">"+v.title+"</a>";
                }
                else
                {
                    title = "";
                }

				var img = v.images[0]?v.images[0].miid:"1";
					fm_html +=
					"<article class=\"post post-latest post-type-image\">"
					+"<div class=\"post-heading\"><div class=thumbnail>"
					+"<a class=link href=?mid="+v.mid+"><span class=\"btn btn-icon-link\"></span>"
					+"<img src=/uploads/meeting_image/?miid="+img+"&landscape&w=570&h=300>"
					+"</a>"
					+"</div></div>"
					+"<div class=post-content><div class=title>"
					+"<h2 class=h4>"+title+"</h2>"
					+"<p class=meta>"
					+"<span class=meta-date>"+v.start_time+"</span>"
					+"<span class=meta-club>"+v.name+"</span>"
					+"</p></div></div></article>";


				if ((c%2) == 0)	fm_html += "";
				c++;
			});

			$("#future_meetings .carousel").append(fm_html);

		</script>
		',
		'country_choose_district' => '<b style="display: block;clear:both;">V&aelig;lg distrikt/landsdel</b><br>',
		'country_choose_club' => '<b>V&aelig;lg klub/by</b><br>',
		'country_header' => '<h1>Hele landet</h1>',

		'login_pretext' => '<h3>Login</h3>',
		'login_prompt' => '
			<div id=normal_login>
			<h3>RT Login</h3>
			<center>
			<form action=/ method=post>
			<input type=hidden name=login value=now>
			<input type=hidden name=redirect value="%%REQUEST_URI%%">
			<input class=bar type=text id=login_username name=username value="Brugernavn" onfocus="this.value=\'\';"><br>
			<input class=bar type=password id=login_password name=password value=""><br>

			<input type=submit value="Login" class="btn"> <input type=checkbox name=remember> Husk login <br>
			<a href=# onclick="send_password();">Glemt kodeord</a> |
			<a href=# onclick="mummy_login();">Mumielogin</a><br/>
			</form>
			</center>

			</div>
			<div id=mummy_login style="display:none">
				<h3>Mumie</h3>
				<center>
				<form action=?mummy method=post>
				<input type=text class=bar  name=club placeholder="Klub (f.eks. RT132)"><br>
				<input type=password class=bar name=password><br>
				<input type=submit value="Login" class="btn"><br>
				<a href="/?aid=3">Glemt kodeord</a> |
				<a href=# onclick="normal_login();">RT login</a><br/>
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
					alert("Brugernavn og kodeord skal indtastes");
					return false;
				}
				return true;
			}
			function send_password()
			{
				var m = prompt("Indtast dit brugrenavn. Herefter sender systemet kodeordet til dig på mail:");
				if (m && m!="") document.location.href="?sendpassword="+m;
			}
			</script>
			',
		'login_incorrect' => '<p><font color=white>Ugyldigt brugernavn/kodeord!</font></p>',
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
												<h3>MEDLEM</h3>
												<div class=profile id=profilebox>
                        <a href=?uid=%%uid%%>%%profile_firstname%% %%profile_lastname%%</a><br>
                        <a href=?logout>Log af</a> | <a href=?uid=%%uid%%&edit>Rediger</a> | <a href=?cid=%%cid%%>Min klub</a>
						<br>
                        <hr>Kommende pligter:<div id=duty_field class=stats></div>
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
'nomination_reject_subj' => 'Indstilling til %%rejected_role%% afvist',
'nomination_reject_body' => 'Indstillingen for %%profile_firstname%% %%profile_lastname%% til %%rejected_role%% er d.d. afvist. Kontakt LS/LF hvis du/I ikke er enige i beslutningen.',
'nomination_accept_subj' => 'Indstilling til %%accepted_role%% godkendt',
'nomination_accept_body' => 'Indstillingen for %%profile_firstname%% %%profile_lastname%% til %%accepted_role%% er d.d. godkendt. Kontakt LS/LF hvis du/I ikke er enige i beslutningen.',
		'nominations' => '
			<h1>Indstillinger %%role%%</h1>
				<h2>Tilf&oslash;j rolle</h2>
				<ul id=addrole>
				</ul>
			<script>
				var roledata = jQuery.parseJSON(\'%%result%%\');
				$.each(roledata.add, function(key,value)
				{
					console.log(value);
					$("#addrole").append(
						"<li>"+value.profile_firstname+" "+value.profile_lastname+", "+value.club+
						"<br> Start: "+
						value.date_start+
						", Slut: "+
						value.date_end+
						", Født: "+
						value.profile_birthdate+
						"<br>Kommentar: <i>"+
            value.nominator_comment+"</i><br>"+
						"<a href=?nominations="+value.rid+"&nid="+value.nid+">Godkend %%role%%</a> | <a href=?nominations="+value.rid+"&nid="+value.nid+"&reject>Afvis %%role%%</a><br><br>"
					);
				});
			</script>
		',
		'admin_takeover' => 'Overtag profil',
		'admin_box_national_board' => '
		<ul id=nbmenu>
			<li class=parent>
				<a href=#>HB</a>
				<ul>
                    <li><a href=/uploads/article_file/?afid=49>Vejledning</a></li>
					<li><a href=?admin_download=newboards>Kommende bestyrelser</a></li>
					<li><a href=?admin_download=future>Download: Kommende bestyrelser</a></li>
					<li><a href=?admin_download=active&xml>Download: Medlemmer</a></li>
					<li><a href=?admin_download=clubs>Download: Klubber</a></li>
					<li><a href=?admin_download=newsletter>Nyhedsbrev</a></li>
				</ul>
			</li>
		</ul>
		',
		'admin_box_secretary' => '
		<ul id=secretarymenu>
			<li class=parent>
				<a href=#>Sekretær</a>
				<ul>
                    <li><a href=/uploads/article_file/?afid=50>Vejledning</a></li>
					<li><a href=?uid=-1>Opret medlem</a></li>
					<li><a href=?mid=-1>Opret ordinært møde</a></li>
                    <li><a href=?omid>Opret uofficielt møde</a></li>
					<li><a href=?kbp>Kommende bestyrelse</a></li>
					<li><a href=?cid=%%cid%%#nominutes>Opret referat</a></li>
					<li><a href=?dashboard>Klub dashboard</a></li>
                    <li><a href=http://webmail.wannafind.dk/ target=_blank>Klubmail</a></li>
					<li><a href=?cid=%%cid%%&edit>Rediger klub</a></li>
				</ul>
			</li>
		</ul>
		',
		'admin_box' => '
			<ul id=adminmenu>
				<li class=parent><a href=#>Admin</a>
				<ul>
          <li><a href=?cid=-1>Opret klub</a>
					<li><a href=?reports>Udtræk til Blå Bog m.m.</a>
 					<li><a href=?admin_download=all>XML: Medlemsarkiv</a>
 					<li><a href=?admin_download=xtable>XML: X-table udtræk</a>
					<li><a href=?admin_download=clubmail>Opdater klubmails</a>
					<li><a href=?takeover>Overtag profil</a></li>
					<li><a href=http://ads.rtd.dk target=_blank>Webbanners</a></li>
					<li><a href=?nominations=24>Æresmedlemsskaber</a></li>
                    <li><a href=?nominations=38>Klub TOTY</a></li>
					<li><a href=?admin=article&edit=-1>Opret artikel</a></li>
					<li><a href=?admin_download=newsletter>Nyhedsbrev</a></li>
					<li><a href=/cronjob.php?pwd=k4rk1ud>Kør cronjob</a></li>
					<li><a href=?admin_download=sysstat>System status</a></li>
					<li><a href=?admin_download=stalker>Overvåg brugere</a></li>
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
		'admin_required' => 'Du har ikke administrator rettigheder',
		'article_edit' => 'Rediger artikel',
		'article_title' => 'Titel',
		'article_public' => 'Offentlig (alle)',
		'article_private' => 'Privat (kun medlemmer)',
		'article_content' => 'Tekst',
		'article_save' => 'Gem artikel',
		'article_last_update' => 'Seneste opdatering: ',
		'article_access' => 'Adgang',
		'login_username' => 'Brugernavn',
		'login_password' => 'Kodeord',
		'login_login' => 'Login &raquo;',
		'dialog_error' => 'Fejlbesked',
		'article_placement' => 'Artikelplacering',
		'article_weight' => 'V&aelig;gt (0=top, 10=bund)',
		'article_parent' => 'Indplacering',
		'article_must_be_logged_in' => 'Du skal være medlem og logget ind for at se indholdet',
		'article_pretext' => '',
		'no_access' => '<h1>Ingen adgang</h1><p>Du har ikke rettigheder til at udføre den forespurgte handling. Kontakt din klubsekretær, LS eller WEB hvis du mener dette er en fejl.</p>'
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
			//$str = utf8_encode($str);
		}
		if (isset($_REQUEST['term_debug'])) return "{$t}:$str";
		else return $str;
	}
?>