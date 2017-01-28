<!DOCTYPE html>
<html lang="da">
  <head>
    <meta charset="utf-8">
    
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="apple-mobile-web-app-title" content="RTD Bøderegnskab">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    
<!--    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="apple-mobile-web-app-capable" content="yes">    
    <meta name="viewport" id="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0,user-scalable=no" />
-->
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>RTD Bøderegnskab</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="container">
          <div class="jumbotron" id="content_login">
              <h1>
                RTD Bøderegnskab
            </h1>
              <form id=form_login onsubmit="return do_login();">
                <div class="input-group">
                  <span class="input-group-addon glyphicon glyphicon-user"></span>
                  <input type=text id=login name=username placeholder="Brugernavn" class="form-control" required />
                  <input type=password id=password name=password placeholder="Password" class="form-control" required />
                  <input type=submit value="Login" class="form-control btn-primary"  id="button_login" />
                  <div class="checkbox">
                    <label><input type="checkbox" id=husk_login value="husk">Gem brugernavn og kodeord</label>
                  </div>                  
                  
                </div>
              </form>
          </div>
          <div id="content_main" style="display:none">
            <div class="jumbotron" id="content_main_heading">
                <h1 id="club_name"></h1>
                <div class="input-group">
                  <span class="input-group-addon glyphicon glyphicon-user"></span>
                  <input type=text id=you class=form-control disabled/>
                  <input type=button value="Log af" style="width: 50%" class="form-control btn-primary"  onclick="do_logoff();" />
                  <input type=button value="Opdater" style="width: 50%" class="form-control btn-primary"  onclick="refresh_boder();" />
                </div><br>
                <div id=msg_area></div>
            </div>
            <ul class="nav nav-pills">
              <li class="active"><a data-toggle="tab" href="#tildel">Bøde</a></li>

              <li class="dropdown">
                  <a class="dropdown-toggle" data-toggle="dropdown" href="#">Regnskab
                  <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a data-toggle="tab" href="#opsummering">Klub <span class="badge" id=opsummering_count></span></a></li>
                    <li><a data-toggle="tab" href="#detaljer">Bøder <span class="badge" id=detaljer_count></span></a></li>
                  </ul>
                </li>
              <li class="dropdown" id=betaling_tab>
                  <a class="dropdown-toggle" data-toggle="dropdown" href="#">Bestyrelse
                  <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a data-toggle="tab" href="#betaling">Betal</a></li>
                    <li><a data-toggle="tab" href="#bode_admin">Bødestørrelse</a></li>
                  </ul>
                </li>              
            </ul>

            <div class="tab-content">
                <div id="tildel" class="tab-pane fade in active">
                  <h3>
                  Bøde
                  </h3>
                  <form onsubmit="return put_bode();">
                    <div class="input-group">
                      <span class="input-group-addon glyphicon glyphicon-usd"></span>
                      <select id=bode_users class="form-control" required></select>
                      <select class=form-control id=bode_predef_txt required>
                      </select>
                      <select id=bode_predef class="form-control" required onchange=use_predef_bode(this.value);></select>
                      <input type=number placeholder=Beløb class=form-control id=bode_val required>
                      <input type=text placeholder=Tekst class=form-control id=bode_txt required>
                      <input type=submit value="Tildel" class="form-control btn-danger"  id="button_bode" />
                    </div>
                  </form><br>

              
              
                </div>

                <div id="bode_admin" class="tab-pane fade">
                  <h3>
                  Bødestørrelse
                  </h3>
                  <table id=pre_bode_list class="table table-striped" >
                  </table>
                  <table class="table table-striped" >
                    <form onsubmit="return put_predefined();" id=predef_create><tr><td width=20%><input id=predef_val required type=number class=form-control></td><td><input required class=form-control id=predef_msg type=text></td><td width=20%><input type=submit value=Tilføj class="form-control btn-primary"></td></tr></form>
                  </table>
                </div>

                <div id="opsummering" class="tab-pane fade">
                  <h3>
                  Klub
                  </h3>
                  <table id=bode_list_summary class="table table-striped">
                  </table>
                </div>
                <div id="detaljer" class="tab-pane fade">
                  <h3>
                  Bøder
                  </h3>
                  <table id=bode_list class="table table-striped">
                  </table>
                </div>
                <div id="betaling" class="tab-pane fade">
                  <h3>
                  Betal
                  </h3>
                      <form onsubmit="return put_betaling()">
                    <div class="input-group">
                        
                      <span class="input-group-addon glyphicon glyphicon-usd"></span>
                      <select id=betaling_users class="form-control" required></select>
                      <input type=number placeholder=Beløb class=form-control id=betaling_val required>

                      <input type=submit value="Registrer betaling" class="form-control btn-danger"  id="button_betaling" />
                    </div>
                      </form>
                </div>
            </div>  
          </div>
          
        </div>
    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="bode.js"></script>

  </body>
</html>