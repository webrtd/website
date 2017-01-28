<?php
require('../includes/logic.php');
require('../scripts/fpdf/fpdf.php');

class PDF extends FPDF
{
var $meeting = null;
var $club = null;
var $B=0;
var $I=0;
var $U=0;
var $HREF='';
function UTF8Decode(&$what)
{
  foreach($what as $k=>$v)
  {
    if (!is_array($v)) 
    {
      $what[$k]=strip_tags(nl2br((html_entity_decode(utf8_decode($v)))),"<b><a><i><p>");
      $what[$k] = str_ireplace("<p>", "", $what[$k]);
      $what[$k] = str_ireplace("</p>", "<br><br>", $what[$k]);
      while (strpos($what[$k], "  ")!==false)
      {
        $what[$k] = str_replace("  ", " ", $what[$k]);
      }
      $what[$k] = trim($what[$k]);
    }
  }
}

function SetClub($c)
{
  $this->club = $c;
  $this->UTF8Decode($this->club);
}
function SetMeeting(&$m)
{
  $this->meeting = $m;
  $this->UTF8Decode($this->meeting);
}

// Page header
function Header()
{
    // Logo
    $this->Image('../img/RT_Logo.png',10,6,30);
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Move to the right
    $this->Cell(80);
    // Title
    $this->Cell(30,10,$this->meeting['title'],0,0,'C');
    // Line break
    $this->Ln(30);

}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,$this->PageNo().'/{nb}',0,0,'C');
}
function BuildReport()
{
  $html = "<b>Møde</b><br>- Start: {$this->meeting['start_time']}<br>- Slut: {$this->meeting['end_time']}<br>- Sted: {$this->meeting['location']}<br><b>Deltagelse</b><br>- Deltagere: {$this->meeting['minutes_number_of_participants']}<br>- Mødeprocent: {$this->meeting['minutes_percentage']}<br><br><br>";
  $this->WriteHTML($html);
  
  if ($this->meeting['minutes']!='')
  {
    $this->WriteHTML("<b>Referat</b><br>{$this->meeting['minutes']}<br><br>");            
  } 
  
  if ($this->meeting['minutes_3min'])
  {
    $this->WriteHTML("<b>3. minutter</b><br>{$this->meeting['minutes_3min']}<br><br>");
  }

  if ($this->meeting['minutes_letters'])
  {
    $this->WriteHTML("<b>Breve</b><br>{$this->meeting['minutes_letters']}<br><br>");
  }
  
  foreach($this->meeting['images'] as $k=>$v)
  {
    $this->Image($v['filepath'],30,null,150);
  }
}
function WriteHTML($html)
{
    // HTML parser
    $html = str_replace("\n",' ',$html);
    $a = preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
    foreach($a as $i=>$e)
    {
        if($i%2==0)
        {
            // Text
            if($this->HREF)
                $this->PutLink($this->HREF,$e);
            else
                $this->Write(5,$e);
        }
        else
        {
            // Tag
            if($e[0]=='/')
                $this->CloseTag(strtoupper(substr($e,1)));
            else
            {
                // Extract attributes
                $a2 = explode(' ',$e);
                $tag = strtoupper(array_shift($a2));
                $attr = array();
                foreach($a2 as $v)
                {
                    if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
                        $attr[strtoupper($a3[1])] = $a3[2];
                }
                $this->OpenTag($tag,$attr);
            }
        }
    }
}

function OpenTag($tag, $attr)
{
    // Opening tag
    if($tag=='B' || $tag=='I' || $tag=='U')
        $this->SetStyle($tag,true);
    if($tag=='A')
        $this->HREF = $attr['HREF'];
    if($tag=='BR')
        $this->Ln(5);
}

function CloseTag($tag)
{
    // Closing tag
    if($tag=='B' || $tag=='I' || $tag=='U')
        $this->SetStyle($tag,false);
    if($tag=='A')
        $this->HREF = '';
}

function SetStyle($tag, $enable)
{
    // Modify style and select corresponding font
    $this->$tag += ($enable ? 1 : -1);
    $style = '';
    foreach(array('B', 'I', 'U') as $s)
    {
        if($this->$s>0)
            $style .= $s;
    }
    $this->SetFont('',$style);
}

function PutLink($URL, $txt)
{
    // Put a hyperlink
    $this->SetTextColor(0,0,255);
    $this->SetStyle('U',true);
    $this->Write(5,$txt,$URL);
    $this->SetStyle('U',false);
    $this->SetTextColor(0);
}
}

// Instanciation of inherited class
$pdf = new PDF();
$pdf->SetMeeting(logic_get_meeting($_REQUEST['mid']));
$pdf->SetClub(logic_get_club($pdf->meeting['cid']));
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->BuildReport();
$pdf->Output();
?>