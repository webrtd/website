      var AJAX_END_POINT = "https://rtd.dk/soap/jsonwrap.php";
      var BODE_END_POINT = "https://rtd.dk/bode/json.php";
      var CURRENT_USER = null;
      var CLUB_MEMBERS = null;
      var MSG_CNT = 1;
      var USER_CAN_EDIT = false;
      var PREDEFINED_BODER = [];

      function timed_msg(id)
      {
        setTimeout(function(){$("#"+id).remove();}, 5000);
      }
      
      function put_msg(msg)
      {
        var id = 'msg_'+MSG_CNT;
        var html = '<div id='+id+' class="alert alert-info" role="alert">'+msg+'</div>';
        $("#msg_area").append(html);
        timed_msg(id);
        MSG_CNT++;
      }
      
      function betaling_done()
      {
        do_enable_button('#betaling_bode');
        put_msg('Betaling registreret!');
        refresh_boder();
        return false;
      }

      function put_predefined()
      {
        var data = {
          cid:CURRENT_USER.cid,
        };
      }
      
      function put_betaling()
      {
        var val = -$("#betaling_val").val();
        var uid = $("#betaling_users").val();
        var msg = 'Betaling registreret af '+CURRENT_USER.profile_firstname+' '+CURRENT_USER.profile_lastname;

        var data = {
          ticket_uid:CURRENT_USER.uid,
          cid:CURRENT_USER.cid,
          uid:$("#betaling_users").val(),
          txt:msg,
          val:-$("#betaling_val").val()
        };
        

        do_disable_button('#betaling_bode');
        do_bode_request('put', data, betaling_done, do_network_error);
        
        return false;
      }
      
      function bode_done(v)
      {
        put_msg('Bøden er tildelt. Forsæt det gode arbejde!');
        do_enable_button("#button_bode");
        refresh_boder();
      }
      
      function get_roles(uid)
      {
        var val = false;
        $.each(CLUB_MEMBERS, function(k,u)
        {
          if (parseInt(u.uid) == parseInt(uid)) 
          {
            console.log('get_roles '+u.roles);
            val =  u.roles;
            return;
          }
        }
        );
        return val;
      }

function remove_bode(in_tid,in_uid)
{
  var data = 
  {
    tid: in_tid,
    uid: in_uid,
    cid: CURRENT_USER.cid
  };

  do_bode_request('remove', data, function(v){
    console.log(v);
    put_msg('Bøden er slettet.');
    refresh_boder();
  }, do_network_error);
  
}
      
      function get_name(uid)
      {
        var val = uid;
        $.each(CLUB_MEMBERS, function(k,u)
        {
          if (parseInt(u.uid) == parseInt(uid)) 
          {
            val =  u.profile_firstname+' '+u.profile_lastname;
            return;
          }
        }
        );
        return val;
      }
      
      function refresh_boder_done(v)
      {
        
        var summaries = {};
        var txts = {};
        
        
        $.each(CLUB_MEMBERS, function(k,u)
        {
          summaries[u.uid] = 0;
        }
        );
        
        var html = '<tr><th>Navn</th><th>Tekst</th><th>Bøde</th></tr>';
        var counter = 0;
        $.each(v, function(k, bode)
        {
          summaries[bode.uid] += parseInt(bode.amount);
          if (parseInt(bode.amount)!=0) console.log(bode);
          txts[bode.text] = bode.text;
          if (USER_CAN_EDIT)
          {
            html += '<tr><td>'+get_name(bode.uid)+'<br><i>'+get_roles(bode.uid)+'</i></td><td>'+bode.text+'<br><i>'+get_name(bode.ticket_uid)+', '+bode.ts+'</i></td><td>'+bode.amount+'<br><a href=# onclick=remove_bode('+bode.tid+','+bode.uid+');><span class="glyphicon glyphicon-trash"></span></a></td></tr>';          }
          else
          {
            html += '<tr><td>'+get_name(bode.uid)+'<br><i>'+get_roles(bode.uid)+'</i></td><td>'+bode.text+'<br><i>'+get_name(bode.ticket_uid)+', '+bode.ts+'</i></td><td>'+bode.amount+'</td></tr>';
          }
          counter ++;
        }
        );
        $("#bode_list").html(html);
        $("#detaljer_count").html(counter);
        
        var summary = '<tr><th>Navn</th><th>Sum</th></tr>';
        var total = 0;
        $.each(summaries, function(uid, val)
        {
          summary += '<tr><td>'+get_name(uid)+'<br><i>'+get_roles(uid)+'</i></td><td>'+val+'</td></tr>';
          total += val;
        }
        );
        $("#bode_list_summary").html(summary);
        $("#opsummering_count").html(total+' kr');
      }
      
      function refresh_boder()
      {
        var data = {cid:CURRENT_USER.cid,year:0};
        do_bode_request('list', data, refresh_boder_done, do_network_error);  
      }
      
      function put_bode()
      {
        var data = {
          ticket_uid:CURRENT_USER.uid,
          cid:CURRENT_USER.cid,
          uid:$("#bode_users").val(),
          txt:$("#bode_txt").val(),
          val:$("#bode_val").val()
        };
        
        console.log(data);

        do_disable_button('#button_bode');
        do_bode_request('put', data, bode_done, do_network_error);
        
        return false;
      }
      
      function hide_element(id)
      {
        $(id).hide();
      }
      
      function show_element(id)
      {
        $(id).show();
      }
    
      function do_disable_button(id)
      {
        $(id).attr('disabled','');
      }
      
      function do_enable_button(id)
      {
        $(id).removeAttr('disabled');
      }
      
      function do_network_error()
      {
        alert('Fejl. Kan ikke få fat i serveren.');
      }
      
      
      function do_get_club_data(clubid, in_success, in_error)
      {
        do_soap_request('soap_get_club',  { cid: parseInt(clubid), token: CURRENT_USER.token }, in_success, in_error);
      }
      
      function show_club_data(v)
      {
        $("#club_name").html(v.name);
      }
      
      
      function setup_user_roles(roles)
      {
        var r = roles.toLowerCase();
        
        if (r.indexOf('formand')>=0 || r.indexOf('sekretær')>=0 || r.indexOf('kasserer')>=0 || r.indexOf('inspektør')>=0 || r.indexOf('administrator')>=0)
        {
          USER_CAN_EDIT = true;
        }
      }
      
      function show_club_users(v)
      {
        var html = '';
        
        CLUB_MEMBERS = v;
        
        $.each(v, function(k,u)
        {
          if (u.uid == CURRENT_USER.uid) setup_user_roles(u.roles);
          html += '<option value='+u.uid+'>'+u.profile_firstname+' '+u.profile_lastname+'</option>';
        });
        $("#bode_users").html(html);
        $("#betaling_users").html(html);
        
        if (!USER_CAN_EDIT)
        {
          hide_element("#betaling_tab");
          $("#button_betaling").attr('disabled','');
        }
        else
        {
          $("#button_betaling").removeAttr('disabled');
        }
        refresh_boder();
      }
      
      function show_meetings(meetings)
      {
        var predef_txt = '';
        $.each(meetings, function(k,v) {
          predef_txt += '<option value="'+v.title+'">'+v.title+'</option>';
        });
       
        if (predef_txt == '') {
          hide_element('#bode_predef_txt');
        }
        else {
          show_element('#bode_predef_txt');
          $("#bode_predef_txt").html(predef_txt);
        }
      }
      
      function do_login_accepted(v)
      {
        if (v === false) 
        {
          do_login_failed();
        }
        else
        {
          CURRENT_USER = v;
          hide_element("#content_login");
          show_element("#content_main");
          
          do_soap_request('soap_get_active_club_members', { cid: parseInt(CURRENT_USER.cid), token: CURRENT_USER.token }, show_club_users, do_network_error);
          
          do_get_club_data(CURRENT_USER.cid, show_club_data, do_network_error);
          
          do_soap_request('soap_get_meetings', {cid: parseInt(CURRENT_USER.cid), token: CURRENT_USER.token}, show_meetings, do_network_error);
          
          var husk_login = ($("#husk_login").is(':checked'));
          
          if (husk_login)
          {
            localStorage.setItem("rtd_bode_huskekage", JSON.stringify(v));  
          }
          
          $("#you").val(v.profile_firstname+' '+v.profile_lastname);
          
          refresh_predefined_boder();
          
        }
      }
                          
      function predef_remove(in_pid)
      {
        do_bode_request('remove_predefined', {pid:in_pid, cid:parseInt(CURRENT_USER.cid)}, function(v){
          put_msg('Bødestørrelse fjernet.');
          refresh_predefined_boder();
        }, do_network_error)
        
      }

      function put_predefined()
      {
        console.log('put predefined');
        
        
        var data = {
          cid : parseInt(CURRENT_USER.cid),
          val : $("#predef_val").val(),
          msg : $("#predef_msg").val()
        };
        
        console.log(data);
        
        do_bode_request('put_predefined', {cid:parseInt(CURRENT_USER.cid), val:$("#predef_val").val(), msg:$("#predef_msg").val()}, function(v){
          put_msg('Bødestørrelse tilføjet.');
          refresh_predefined_boder();
        }, do_network_error)
        
        return false;
      }


      function refresh_predefined_boder()
      {
        do_bode_request('get_predefined', {cid:parseInt(CURRENT_USER.cid)}, 
        function(v)
        {
          
          
          var html = '<tr><th width=20%>Beløb</th><th>Tekst</th><th width=20%></th></tr>';
          var predef_html = '<option value=-1>Vælg</option>';
          
          $.each(v, function(k,v){
            PREDEFINED_BODER[v.pid] = v;
            predef_html += '<option value='+v.pid+'>'+v.amount+' kr. '+v.message+'</option>';
            html += '<tr><td>'+v.amount+'</td><td>'+v.message+'</td><td><input type=button value=Slet class="form-control btn-danger" onclick=predef_remove('+v.pid+'); /></td></tr>';
          });
          
          console.log(PREDEFINED_BODER);
          
          
          $("#pre_bode_list").html(html);
          $("#bode_predef").html(predef_html);
          
        },
        do_network_error
        );        
      }
      
      function do_login_failed()
      {
        put_msg('Kunne ikke logge ind. Prøv igen.');
        do_enable_button('#button_login');
      }
      
      function do_login()
      {
        var u = $("#login").val();
        var p = $("#password").val();
        
        do_disable_button('#button_login');
        
        do_soap_request('soap_login', { username: u, password: p }, do_login_accepted, do_login_failed);

        return false;
      }

     function do_bode_request(func, params, in_success, in_error)
     {
      var export_data = 
      {
        do: func,
        parameters: params 
      };
        

      $.ajax(
      {
        url: BODE_END_POINT,
        type: 'post',
        data: export_data
      })
      .done(function(v) 
      {
        in_success($.parseJSON(v));
      })
      .fail(function(xhr, text, error) 
      {
        in_error();
      });
     }

      
     function do_soap_request(func, params, in_success, in_error)
     {
      var export_data = 
      {
        cb: func,
        parameters: params
      };

      $.ajax(
      {
        url: AJAX_END_POINT,
        type: 'post',
        data: export_data
      })
      .done(function(v) 
      {
        in_success($.parseJSON(v));
      })
      .fail(function(xhr, text, error) 
      {
        in_error();
      });
     }

    function do_logoff()
    {
      localStorage.clear();
      document.location.href='/bode';
    }

  
    function do_auto_login()
    {
      var login = localStorage.getItem('rtd_bode_huskekage');
      if (login !== null)
      {
        var v = $.parseJSON(login);
        do_login_accepted(v);
      }
    }
    
    function use_predef_bode(pid)
    {
      if (pid>=0)
      {
          var bode = PREDEFINED_BODER[pid];
          $("#bode_val").val(bode.amount);
          var m = bode.message+', '+ $("#bode_predef_txt").val();
          $("#bode_txt").val(m);
      }
    }

    do_auto_login();

