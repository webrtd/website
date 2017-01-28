<form action=http://webmail.wannafind.dk/atmail.php method=post>
<input type=hidden name=account value="rt111@roundtable.dk">
<input type=hidden name=password value="RT-111password">
<input type=submit>
</form>
<?
die();

require_once $_SERVER['DOCUMENT_ROOT'].'/includes/mysqlconnect.php';
/*
$logos = array(
"sites/rtd.dk/files/pictures/klublogos/logo_0.jpg" => "RT1 - København"   ,
"sites/rtd.dk/files/pictures/klublogos/untitled_0.gif" => "RT101 - Hobro"  ,
"sites/rtd2.dk/files/pictures/media/rt103_logo_3d-3.png" => "RT103 - Hadsund-Mariager",
"sites/rtd.dk/files/pictures/klublogos/roundtable_logofigur_rgb.jpg" => "RT104 - Aars" ,
"sites/rtd2.dk/files/pictures/media/absolute.jpg" => "RT105 - Assens"                   ,
"sites/rtd2.dk/files/pictures/media/Vandmarke_RT.jpg" => "RT106 - Toftlund"              ,
"sites/rtd2.dk/files/pictures/media/RT108_logo.jpg" => "RT108 - Esbjerg"                  ,
"sites/rtd2.dk/files/pictures/media/toplogo1.gif" => "RT11 - Frederiksberg"                ,
"sites/rtd2.dk/files/pictures/media/RT113.jpg" => "RT113 - Brædstrup"                       ,
"sites/rtd2.dk/files/pictures/media/rt_logo6.jpg" => "RT114 - Egtved"                        ,
"sites/rtd2.dk/files/pictures/media/nyt_billede1.jpg" => "RT115 - Løgstør"                    ,
"sites/rtd2.dk/files/pictures/media/pin.jpg" => "RT116 - Kolding"                              ,
"sites/rtd2.dk/files/pictures/media/gth0078l.jpg" => "RT117 - Vojens"                           ,
"sites/rtd2.dk/files/pictures/media/RT119_Logo.jpg" => "RT119 - Greve"                           ,
"sites/rtd2.dk/files/pictures/media/vikingb.jpg" => "RT12 - Roskilde"                             ,
"sites/rtd2.dk/files/pictures/media/RT120.JPG" => "RT120 - Tinglev"                                ,
"sites/rtd2.dk/files/pictures/media/rt_logo1.jpg" => "RT121 - Faaborg"                              ,
"sites/rtd.dk/files/pictures/klublogos/euromeeting_2010_083_copy.jpg" => "RT122 - Skærbæk"           ,
"sites/rtd2.dk/files/pictures/media/..._R_O_U_N_D__T_A_B_L_E__1_2_3__V_A_M_D_R_U_P.jpg" => "RT123 - Vamdrup",
"sites/rtd.dk/files/pictures/klublogos/logo_4f.jpg" => "RT13 - Vejle"                                        ,
"sites/rtd2.dk/files/pictures/media/rt_1301.jpg" => "RT130 - Frederiksborg"                                   ,
"sites/rtd.dk/files/pictures/klublogos/rt8000logo.jpg" => "RT131 - Århus 8000"                                 ,
"sites/rtd.dk/files/pictures/klublogos/logort132.jpg" => "RT132 - Christianshavn"                               ,
"sites/rtd.dk/files/pictures/klublogos/rt_15_23.png" => "RT15 - Holbæk"                                          ,
"sites/rtd2.dk/files/pictures/media/RT17.JPG" => "RT17 - Herning"                                                 ,
"sites/rtd.dk/files/pictures/klublogos/pin_rtd_holstebro_0.jpg" => "RT19 - Holstebro"                              ,
"sites/rtd2.dk/files/pictures/media/DP1.jpg" => "RT2 - Århus"                                                       ,
"sites/rtd2.dk/files/pictures/media/RT20.jpg" => "RT20 - Fredericia"                                                 ,
"sites/rtd2.dk/files/pictures/media/Logo_gron.jpg" => "RT21 - Nexø"                                                   ,
"sites/rtd2.dk/files/pictures/media/stortlogo17.jpg" => "RT23 - Næstved"                                               ,
"sites/rtd2.dk/files/pictures/media/pin1.jpg" => "RT24 - Ringkøbing"                                                    ,
"sites/rtd.dk/files/pictures/klublogos/image002.jpg" => "RT25 - Vordingborg"                                             ,
"sites/rtd.dk/files/pictures/klublogos/RT26logo50a.jpg" => "RT26 - Nykøbing F"                                            ,
"sites/rtd.dk/files/pictures/klublogos/091017_rt_logo3cm_skaerm_kw.jpg" => "RT28 - Amager"                                 ,
"sites/rtd2.dk/files/pictures/media/RT-30_LOGO_3_JPG.jpg" => "RT30 - Hillerød"                                              ,
"sites/rtd2.dk/files/pictures/media/rt-01konverteret.jpg" => "RT32 - Haderslev"                                              ,
"sites/rtd2.dk/files/pictures/media/RT_33_Thisted_logo.jpg" => "RT33 - Thisted"                                               ,
"sites/rtd.dk/files/pictures/klublogos/rt34logo.png" => "RT34 - Ribe"                                                          ,
"sites/rtd.dk/files/pictures/klublogos/rt36_logo.jpg" => "RT36 - Glostrup"                                                      ,
"sites/rtd2.dk/files/pictures/media/Billede1.jpg" => "RT38 - Svendborg"                                                          ,
"sites/rtd2.dk/files/pictures/media/RT39_logo.jpg" => "RT39 - Nakskov"                                                            ,
"sites/rtd2.dk/files/pictures/media/RT4_Logo.JPG" => "RT4 - Horsens"                                                               ,
"sites/rtd2.dk/files/pictures/media/RT40_logo.jpg" => "RT40 - Præstø"                                                               ,
"sites/rtd2.dk/files/pictures/media/RT42logo.JPG" => "RT42 - Nørresundby"                                                            ,
"sites/rtd2.dk/files/pictures/media/logo23.jpg" => "RT43 - Skjern"                                                                    ,
"sites/rtd2.dk/files/pictures/media/rt_pin_jpg.jpg" => "RT44 - Skive"                                                                  ,
"sites/rtd2.dk/files/pictures/media/stortlogo1_rt.jpg" => "RT45 - Køge"                                                                 ,
"sites/rtd2.dk/files/pictures/media/rt_tur_146.jpg" => "RT47 - Kalundborg"                                                               ,
"sites/rtd2.dk/files/pictures/media/rt48.jpg" => "RT48 - Hørsholm-Rungsted"                                                               ,
"sites/rtd.dk/files/pictures/klublogos/RT49.jpg" => "RT49 - Sønderborg"                                                                    ,
"sites/rtd2.dk/files/pictures/media/n53051887990_4602.jpg" => "RT50 - Varde"                                                                ,
"sites/rtd2.dk/files/pictures/media/rt51_logo.jpg" => "RT51 - Korsør"                                                                        ,
"sites/rtd2.dk/files/pictures/media/_stortlogo14.jpg" => "RT52 - Rønne"                                                                       ,
"sites/rtd2.dk/files/pictures/media/rtviking.JPG" => "RT53 - Odder"                                                                            ,
"sites/rtd2.dk/files/pictures/media/rt55_mid.jpg" => "RT55 - Humlebæk"                                                                          ,
"sites/rtd.dk/files/pictures/klublogos/nlogo_round_table_nyborg_nr._58.jpg" => "RT58 - Nyborg"                                                   ,
"sites/rtd.dk/files/pictures/klublogos/rt_59_pin_stor.jpg" => "RT59 - Virum"                                                                      ,
"sites/rtd2.dk/files/pictures/media/stortlogo11.jpg" => "RT6 - Randers"                                                                            ,
"sites/rtd2.dk/files/pictures/media/RT60-herlev.png" => "RT60 - Herlev"                                                                             ,
"sites/rtd2.dk/files/pictures/media/logo13.jpg" => "RT63 - Struer"                                                                                   ,
"sites/rtd.dk/files/pictures/klublogos/odense-rotary-rt-64.jpg" => "RT64 - Odense"                                                                    ,
"sites/rtd.dk/files/pictures/klublogos/rt66logoweb.jpg" => "RT66 - Rødovre"                                                                            ,
"sites/rtd2.dk/files/pictures/media/Solvognen.jpg" => "RT67 - Nykøbing Sj."                                                                             ,
"sites/rtd.dk/files/pictures/klublogos/logo.jpg" => "RT68 - Lemvig "                                                                                     ,
"sites/rtd.dk/files/pictures/klublogos/DSC_0088.jpg-edited_0.jpg" => "RT69 - Aabenraa"                                                                    ,
"sites/rtd.dk/files/pictures/klublogos/logort70.png" => "RT70 - Esbjerg"                                                                                   ,
"sites/rtd.dk/files/pictures/klublogos/rtsvaerdlogo_rt71_2.jpg" => "RT71 - Birkerød"                                                                        ,
"sites/rtd.dk/files/pictures/klublogos/Lille-logo.jpg" => "RT75 - Skanderborg"                                                                               ,
"sites/rtd2.dk/files/pictures/media/header1.jpg" => "RT77 - Kruså"                                                                                            ,
"sites/rtd.dk/files/pictures/klublogos/rt78_logo.png" => "RT78 - Frederikssund"                                                                                ,
"sites/rtd.dk/files/pictures/klublogos/rt8web_0.jpg" => "RT8 - Ringsted"                                                                                        ,
"sites/rtd2.dk/files/pictures/media/rt81_logo_300px.jpg" => "RT81 - Aalborg"                                                                                     ,
"sites/rtd2.dk/files/pictures/media/RT-vikinger.jpg" => "RT83 - Horsens"                                                                                          ,
"sites/rtd2.dk/files/pictures/media/stortlogo15.jpg" => "RT85 - Møn"                                                                                               ,
"sites/rtd2.dk/files/pictures/media/RTlogo_Bla_.jpg" => "RT87 - Fredericia"                                                                                         ,
"sites/rtd2.dk/files/pictures/media/logo16.jpg" => "RT90 - Taastrup"                                                                                                 ,
"sites/rtd.dk/files/pictures/klublogos/dsc_0104_1024x680.jpg" => "RT92 - Bjerringbro"                                                                                 ,
"sites/rtd2.dk/files/pictures/media/RT93.jpg" => "RT93 - Grindsted"                                                                                                    ,
"sites/rtd2.dk/files/pictures/media/RT_Vikingelogo.JPG" => "RT95 - Kerteminde"                                                                                          ,
"sites/rtd2.dk/files/pictures/media/RT96__Randers_logo.jpg" => "RT96 - Randers"                                                                                          ,
"sites/rtd2.dk/files/pictures/media/99logo2.JPG" => "RT99 - Rødding"                                                                                                      
);

foreach ($logos as $url => $name)
{
  $data = explode(" ",$name);
  $rs = $g_db->execute("select cid from club where name like '%{$data[0]}%'");
  $cid = $g_db->fetchsinglevalue($rs);
  //echo "$cid - $name<br>";
  $url = "http://www.rtd.dk/$url";
  $fn = basename($url);
  $ext = strtolower(substr($fn, strrpos($fn, '.') + 1));
  //echo "<li>$fn - $ext";
  $data = file_get_contents($url);
  file_put_contents(CLUB_LOGO_PATH.$cid.".".$ext,$data);
  echo "<h1>$name</h1>";
  echo "<img src=/uploads/club_logos/{$cid}.{$ext}>";
  //echo "<h1>$name</h1><img src=\"\"><br>";
}
  */
  
  $rs = $g_db->execute("select distinct(company_business) from user order by company_business asc");
  while ($r=$g_db->fetcharray($rs))
  {
    echo "<li>".utf8_decode($r['company_business']);
  }
?>