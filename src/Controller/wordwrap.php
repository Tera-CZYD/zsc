<?php
namespace App\Controller;
require("fpdf181/fpdf.php");
function hex2dec($couleur = "#000000"){
    $R = substr($couleur, 1, 2);
    $rouge = hexdec($R);
    $V = substr($couleur, 3, 2);
    $vert = hexdec($V);
    $B = substr($couleur, 5, 2);
    $bleu = hexdec($B);
    $tbl_couleur = array();
    $tbl_couleur['R']=$rouge;
    $tbl_couleur['G']=$vert;
    $tbl_couleur['B']=$bleu;
    return $tbl_couleur;
}

//conversion pixel -> millimeter in 72 dpi
function px2mm($px){
    return $px*25.4/72;
}

function txtentities($html){
    $trans = get_html_translation_table(HTML_ENTITIES);
    $trans = array_flip($trans);
    return strtr($html, $trans);
}


class ConductPDF extends FPDF {

  function Circle($x, $y, $r, $style='D')
  {
      $this->Ellipse($x,$y,$r,$r,$style);
  }

  function Ellipse($x, $y, $rx, $ry, $style='D')
  {
      if($style=='F')
          $op='f';
      elseif($style=='FD' || $style=='DF')
          $op='B';
      else
          $op='S';
      $lx=4/3*(M_SQRT2-1)*$rx;
      $ly=4/3*(M_SQRT2-1)*$ry;
      $k=$this->k;
      $h=$this->h;
      $this->_out(sprintf('%.2F %.2F m %.2F %.2F %.2F %.2F %.2F %.2F c',
          ($x+$rx)*$k,($h-$y)*$k,
          ($x+$rx)*$k,($h-($y-$ly))*$k,
          ($x+$lx)*$k,($h-($y-$ry))*$k,
          $x*$k,($h-($y-$ry))*$k));
      $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c',
          ($x-$lx)*$k,($h-($y-$ry))*$k,
          ($x-$rx)*$k,($h-($y-$ly))*$k,
          ($x-$rx)*$k,($h-$y)*$k));
      $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c',
          ($x-$rx)*$k,($h-($y+$ly))*$k,
          ($x-$lx)*$k,($h-($y+$ry))*$k,
          $x*$k,($h-($y+$ry))*$k));
      $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c %s',
          ($x+$lx)*$k,($h-($y+$ry))*$k,
          ($x+$rx)*$k,($h-($y+$ly))*$k,
          ($x+$rx)*$k,($h-$y)*$k,
          $op));
  }


  //Cell with horizontal scaling if text is too wide
  function CellFit($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='', $scale=false, $force=true){

    //Get string width
    $str_width=$this->GetStringWidth($txt);

    //Calculate ratio to fit cell
    if($w==0)
        $w = $this->w-$this->rMargin-$this->x;
    $ratio = ($w-$this->cMargin*2)/$str_width;

    $fit = ($ratio < 1 || ($ratio > 1 && $force));
    if ($fit)
    {
        if ($scale)
        {
            //Calculate horizontal scaling
            $horiz_scale=$ratio*100.0;
            //Set horizontal scaling
            $this->_out(sprintf('BT %.2F Tz ET',$horiz_scale));
        }
        else
        {
            //Calculate character spacing in points
            $char_space=($w-$this->cMargin*2-$str_width)/max(strlen($txt)-1,1)*$this->k;
            //Set character spacing
            $this->_out(sprintf('BT %.2F Tc ET',$char_space));
        }
        //Override user alignment (since text will fill up cell)
        $align='';
    }

    //Pass on to Cell method
    $this->Cell($w,$h,$txt,$border,$ln,$align,$fill,$link);

    //Reset character spacing/horizontal scaling
    if ($fit){

      $this->_out('BT '.($scale ? '100 Tz' : '0 Tc').' ET');

    }

  }

  function TextWithDirection($x, $y, $txt, $direction='R')
  {
      if ($direction=='R')
          $s=sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET',1,0,0,1,$x*$this->k,($this->h-$y)*$this->k,$this->_escape($txt));
      elseif ($direction=='L')
          $s=sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET',-1,0,0,-1,$x*$this->k,($this->h-$y)*$this->k,$this->_escape($txt));
      elseif ($direction=='U')
          $s=sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET',0,1,-1,0,$x*$this->k,($this->h-$y)*$this->k,$this->_escape($txt));
      elseif ($direction=='D')
          $s=sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET',0,-1,1,0,$x*$this->k,($this->h-$y)*$this->k,$this->_escape($txt));
      else
          $s=sprintf('BT %.2F %.2F Td (%s) Tj ET',$x*$this->k,($this->h-$y)*$this->k,$this->_escape($txt));
      if ($this->ColorFlag)
          $s='q '.$this->TextColor.' '.$s.' Q';
      $this->_out($s);
  }

  function TextWithRotation($x, $y, $txt, $txt_angle, $font_angle=0)
  {
      $font_angle+=90+$txt_angle;
      $txt_angle*=M_PI/180;
      $font_angle*=M_PI/180;

      $txt_dx=cos($txt_angle);
      $txt_dy=sin($txt_angle);
      $font_dx=cos($font_angle);
      $font_dy=sin($font_angle);

      $s=sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET',$txt_dx,$txt_dy,$font_dx,$font_dy,$x*$this->k,($this->h-$y)*$this->k,$this->_escape($txt));
      if ($this->ColorFlag)
          $s='q '.$this->TextColor.' '.$s.' Q';
      $this->_out($s);
  }

  //Cell with horizontal scaling only if necessary
  function CellFitScale($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
  {
      $this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,true,false);
  }

  //Cell with horizontal scaling always
  function CellFitScaleForce($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
  {
      $this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,true,true);
  }

  //Cell with character spacing only if necessary
  function CellFitSpace($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
  {
      $this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,false,false);
  }

  //Cell with character spacing always
  function CellFitSpaceForce($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
  {
      //Same as calling CellFit directly
      $this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,false,true);
  }

  function IncludeJS($script) {
    $this->javascript=$script;
  }

  function _putjavascript() {
    $this->_newobj();
    $this->n_js=$this->n;
    $this->_out('<<');
    $this->_out('/Names [(EmbeddedJS) '.($this->n+1).' 0 R]');
    $this->_out('>>');
    $this->_out('endobj');
    $this->_newobj();
    $this->_out('<<');
    $this->_out('/S /JavaScript');
    $this->_out('/JS '.$this->_textstring($this->javascript));
    $this->_out('>>');
    $this->_out('endobj');
  }

  function _putresources() {
    $this->_putextgstates();
    parent::_putresources();
    if (!empty($this->javascript)) {
      $this->_putjavascript();
    }
  }

  function _putcatalog() {
    parent::_putcatalog();
    if (!empty($this->javascript)) {
      $this->_out('/Names <</JavaScript '.($this->n_js).' 0 R>>');
    }
  }

  //----------------FOR OPACITY---------------------------

    protected $extgstates = array();

    // alpha: real value from 0 (transparent) to 1 (opaque)
    // bm:    blend mode, one of the following:
    //          Normal, Multiply, Screen, Overlay, Darken, Lighten, ColorDodge, ColorBurn,
    //          HardLight, SoftLight, Difference, Exclusion, Hue, Saturation, Color, Luminosity
    function SetAlpha($alpha, $bm='Normal')
    {
      // set alpha for stroking (CA) and non-stroking (ca) operations
      $gs = $this->AddExtGState(array('ca'=>$alpha, 'CA'=>$alpha, 'BM'=>'/'.$bm));
      $this->SetExtGState($gs);
    }

    function AddExtGState($parms)
    {
      $n = count($this->extgstates)+1;
      $this->extgstates[$n]['parms'] = $parms;
      return $n;
    }

    function SetExtGState($gs)
    {
      $this->_out(sprintf('/GS%d gs', $gs));
    }

    function _enddoc()
    {
      if(!empty($this->extgstates) && $this->PDFVersion<'1.4')
        $this->PDFVersion='1.4';
      parent::_enddoc();
    }

    function _putextgstates()
    {
      for ($i = 1; $i <= count($this->extgstates); $i++)
      {
        $this->_newobj();
        $this->extgstates[$i]['n'] = $this->n;
        $this->_put('<</Type /ExtGState');
        $parms = $this->extgstates[$i]['parms'];
        $this->_put(sprintf('/ca %.3F', $parms['ca']));
        $this->_put(sprintf('/CA %.3F', $parms['CA']));
        $this->_put('/BM '.$parms['BM']);
        $this->_put('>>');
        $this->_put('endobj');
      }
    
    }
    function _putresourcedict()
    {
      parent::_putresourcedict();
      $this->_put('/ExtGState <<');
      foreach($this->extgstates as $k=>$extgstate)
        $this->_put('/GS'.$k.' '.$extgstate['n'].' 0 R');
      $this->_put('>>');
    }
 
  //-----------------------------------------------------------------
  
  function SetDash($black=null, $white=null)
  {
      if($black!==null)
          $s=sprintf('[%.3F %.3F] 0 d',$black*$this->k,$white*$this->k);
      else
          $s='[] 0 d';
      $this->_out($s);
  }
  
  function vcell($c_width,$c_height,$x_axis,$text){

    $w_w=$c_height/3;

    $w_w_1=7;

    $w_w1=14;

    $w_w2=21;

    $len = strlen($text);// check the length of the cell and splits the text into 7 character each and saves in a array 

    $lengthToSplit = 23;

    $lastSpace = strpos($text,' ');

    // var_dump($lastSpace);
    if($len>$lengthToSplit){

      $w_text=str_split($text,$lengthToSplit);

      $this->SetX($x_axis);

      $this->Cell($c_width,$w_w_1,$w_text[0],0,0,'C');

      if(isset($w_text[1])) {

        $this->SetX($x_axis);

        $this->Cell($c_width,$w_w1,$w_text[1],0,0,'C');

      }
      if(isset($w_text[2])) {

        $this->SetX($x_axis);

        $this->Cell($c_width,$w_w2,$w_text[2],0,0,'C');

      }

      $this->SetX($x_axis);

      $this->Cell($c_width,$c_height,'','LTRB',0,'C',0);

    }else{

      $this->SetX($x_axis);
      $this->Cell($c_width,$c_height,$text,'LTRB',0,'C',0);
    }

  }
  
  function SetFooter($bool = true){

    $this->footerBool = $bool;

  }

  function Footer(){

    if($this->footerBool){

      // Position at 1.5 cm from bottom

      $this->SetY(-15);

      // Arial italic 8

      $this->SetFont('Arial','I',8);

      // Page number=

      if($this->footerSystem){

        $this->Image('https://esmiszscmst.mycreativepanda.ph/assets/img/zscmst-qr.png',8,$this->getY()-5,12,12);

        $this->Cell(0,5,'This is a system generated report.',0,1,'C');  

      }

      $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,1,'C');      

    }

    if($this->footerDtr){

      $this->SetY(-46.5);

      $this->Line(3,$this->getY()-1,105,$this->getY()-1);

      $this->Line(110,$this->getY()-1,212,$this->getY()-1);

      $this->SetFont('Arial','',8);

      $y = $this->getY();

      $this->Cell(8,5,'',0,0,'L');

      $this->MultiCell(90,3.5,'I certify on my honor that the above is a true and correct report of the hours of work performed, record of which was made daily at the time of arrival and departure from office.',0,'C');

      $this->SetXY(115,$y);

      $this->MultiCell(90,3.5,'I certify on my honor that the above is a true and correct report of the hours of work performed, record of which was made daily at the time of arrival and departure from office.',0,'C');

      $this->Image('http://ehrmiszscmst.ednc.solutions/assets/img/dtr_qr.png',-1,$this->getY()-3,32,32);
      $this->Image('http://ehrmiszscmst.ednc.solutions/assets/img/dtr_qr.png',105,$this->getY()-3,32,32);

      $this->Ln(6.5);
      $this->Line(32,$this->getY(),90,$this->getY());
      $this->Line(140,$this->getY(),197,$this->getY());
      $this->SetFont('Arial','BI',7.5);
      $this->Cell(8,5,'',0,0,'L');
      $this->Cell(102.5,5,'VERIFIED as to the prescribed office hours',0,0,'C');
      $this->Cell(5,5,'',0,0,'L');
      $this->Cell(102.5,5,'VERIFIED as to the prescribed office hours',0,0,'C');
      $this->Ln(10.5);
      $this->Line(32,$this->getY(),90,$this->getY());
      $this->Line(140,$this->getY(),197,$this->getY());
      $this->Cell(8,5,'',0,0,'L');
      $this->Cell(102.5,5,'In-Charge',0,0,'C');
      $this->Cell(5,5,'',0,0,'L');
      $this->Cell(102.5,5,'In-Charge',0,0,'C');
      $this->Ln(8.5);
      $this->SetFont('Arial','',8);
      $this->Cell(3.5,5,'',0,0,'L');
      $this->Cell(20.5,5,'11751476812',0,0,'L');
      $this->Cell(3.5,5,'',0,0,'L');
      $this->Cell(102.5,5,'11751476812',0,0,'R');

    }

    if($this->footerSaln){

      // Position at 1.5 cm from bottom

      $this->SetY(-27);

      // Arial italic 8

      if(!$this->isFinished){
        $this->SetFont('bookman','I',10);
        $this->Cell(-1,5,'',0,0,'L');  
        $this->Cell(0,5,'* Additional sheet/s may be used, if necessary.',0,1,'L');     
      }else{
        $this->SetFont('bookman','I',10);
        $this->Ln(5);
      }
      // Page number=


      $this->Cell(0,5,'Page '.$this->PageNo().' of {nb}',0,1,'C');    
      $this->Line(113,$this->GetY() - 1,121,$this->GetY() - 1);  

    }

  }

  function myCell($w, $h, $x, $t){

    $height = $h/3;
    $first = $height+2;
    $second = $height+$height+$height+3;
    $len = strlen($t);
    if($len>20){
      $txt = str_split($t,20);
      $this->SetX($x);
      $this->Cell($w,$first,$txt[0],'','','');
      $this->SetX($x);
      $this->Cell($w,$second,$txt[1],'','','');
      $this->SetX($x);
      $this->Cell($w,$h,'','LTRB',0,'C',0);
    }else {
        $this->SetX($x);
        $this->Cell($w,$h,$t,'LTRB',0,'C',0);
    }

  }
    function myCell1($w, $h, $x, $t){

        $height = $h/3;
        $first = $height+2;
        $second = $height+$height+$height+3;
        $len = strlen($t);
        if($len>50){
            $txt = str_split($t,50);
            $this->SetX($x);
            $this->Cell($w,$first,$txt[0],'','','');
            $this->SetX($x);
            $this->Cell($w,$second,$txt[1],'','','');
            $this->SetX($x);
            $this->Cell($w,$h,'','LTRB',0,'C',0);
        }else {
            $this->SetX($x);
            $this->Cell($w,$h,$t,'LTRB',0,'C',0);
        }

    }
    function myCell2($w, $h, $x, $t){

        $height = $h/3;
        $first = $height+2;
        $second = $height+$height+$height+3;
        $len = strlen($t);
        if($len>13){
            $txt = str_split($t,13);
            $this->SetX($x);
            $this->Cell($w,$first,$txt[0],'','','');
            $this->SetX($x);
            $this->Cell($w,$second,$txt[1],'','','');
            $this->SetX($x);
            $this->Cell($w,$h,'','LTRB',0,'C',0);
        }else {
            $this->SetX($x);
            $this->Cell($w,$h,$t,'LTRB',0,'C',0);
        }

    }
    function myCell3($w, $h, $x, $t){

        $height = $h/3;
        $first = $height+2;
        $second = $height+$height+$height+3;
        $len = strlen($t);
        if($len>29){
            $txt = str_split($t,29);
            $this->SetX($x);
            $this->Cell($w,$first,$txt[0],0,0,0);
            $this->SetX($x);
            $this->Cell($w,$second,$txt[1],0,0,0);
            $this->SetX($x);
            $this->Cell($w,$h,'','LTRB',0,'L',0);
        }else {
            $this->SetX($x);
            $this->Cell($w,$h,$t,'LTRB',0,'L',0);
        }

    }
    function myCell4($w, $h, $x, $t){

        $height = $h/3;
        $first = $height+2;
        $second = $height+$height+$height+3;
        $len = strlen($t);
        if($len>85){
            $txt = str_split($t,85);
            $this->SetX($x);
            $this->Cell($w,$first,$txt[0],'','','');
            $this->SetX($x);
            $this->Cell($w,$second,$txt[1],'','','');
            $this->SetX($x);
            $this->Cell($w,$h,'','LTRB',0,'C',0);
        }else {
            $this->SetX($x);
            $this->Cell($w,$h,$t,'LTRB',0,'C',0);
        }

    }
  function myCell5($w, $h, $x, $t){

    $height = $h/3;
    $first = $height+2;
    $second = $height+$height+$height+3;
    $len = strlen($t);
    if($len>30){
      $txt = str_split($t,30);
      $this->SetX($x);
      $this->Cell($w,$first,$txt[0],'','','');
      $this->SetX($x);
      $this->Cell($w,$second,$txt[1],'','','');
      $this->SetX($x);
      $this->Cell($w,$h,'','LTRB',0,'C',0);
    }else {
      $this->SetX($x);
      $this->Cell($w,$h,$t,'LTRB',0,'C',0);
   }

  }
  function myCell6($w, $h, $x, $t){

    $height = $h/3;
    $first = $height+2;
    $second = $height+$height+$height+3;
    $len = strlen($t);
    if($len>145){
      $txt = str_split($t,145);
      $this->SetX($x);
      $this->Cell($w,$first,$txt[0],0,0,'');
      $this->SetX($x);
      $this->Cell($w,$second,$txt[1],'','','');
      $this->SetX($x);
      $this->Cell($w,$h,'','LTRB',0,'C',0);
    }else {
      $this->SetX($x);
      $this->Cell($w,$h,$t,'LTRB',0,'C',0);
   }

  }
  function myCellmulti($w, $h, $x, $t){

    $height = 2;
    $first = $height+2;
    $second = $height+$height+$height+3;
    $third = $second+5;
    $forth = $third+5;
    $fifth = $forth+5;
    $sixth = $fifth+5;
    $seven = $sixth+5;
    $eight = $seven+5;
    $len = strlen($t);
    if($len>30){
      $txt = str_split($t,30);
      $this->SetX($x);
      $this->Cell($w,$first,$txt[0],'','','');
      $this->SetX($x);
      $this->Cell($w,$second,@$txt[1],'','','');
      $this->SetX($x);
      $this->Cell($w,$third,@$txt[2],'','','');
      $this->SetX($x);
      $this->Cell($w,$forth,@$txt[3],'','','');
      $this->SetX($x);
      $this->Cell($w,$fifth,@$txt[4],'','','');
      $this->SetX($x);
      $this->Cell($w,$sixth,@$txt[5],'','','');
      $this->SetX($x);
      $this->Cell($w,$seven,@$txt[6],'','','');
      $this->SetX($x);
      $this->Cell($w,$eight,@$txt[7],'','','');
      $this->SetX($x);
      $this->Cell($w,$h,'','LTRB',0,'C',0);
    }else {
      $this->SetX($x);
      $this->Cell($w,$h,$t,'LTRB',0,'C',0);
   }

  }
  var $widths;
var $aligns;

function SetWidths($w)
{
    //Set the array of column widths
    $this->widths=$w;
}

function SetAligns($a)
{
    //Set the array of column alignments
    $this->aligns=$a;
}
function subWrite($h, $txt, $link='', $subFontSize=12, $subOffset=0)
{
    // resize font
    $subFontSizeold = $this->FontSizePt;
    $this->SetFontSize($subFontSize);
    
    // reposition y
    $subOffset = ((($subFontSize - $subFontSizeold) / $this->k) * 0.3) + ($subOffset / $this->k);
    $subX        = $this->x;
    $subY        = $this->y;
    $this->SetXY($subX, $subY - $subOffset);

    //Output text
    $this->Write($h, $txt, $link);

    // restore y position
    $subX        = $this->x;
    $subY        = $this->y;
    $this->SetXY($subX,  $subY + $subOffset);

    // restore font size
    $this->SetFontSize($subFontSizeold);
}

//prints row without border
  function RowNoBorder($data,$type = ''){

    //Calculate the height of the row

    $nb=0;

    for($i=0;$i<count($data);$i++){

      $nb = max($nb,$this->NbLines($this->widths[$i],$data[$i]));

    }

    $h=5*$nb;

    //Issue a page break first if needed

    $this->CheckPageBreakLegalL($h,$type);

    //Draw the cells of the row

    for($i=0;$i<count($data);$i++){

      $w=$this->widths[$i];

      $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';

      //Save the current position

      $x=$this->GetX();

      $y=$this->GetY();

      //Draw the border

      // $this->Rect($x,$y,$w,$h);

      //Print the text

      $this->MultiCell($w,5,$data[$i],0,$a);

      //Put the position to the right of the cell

      $this->SetXY($x+$w,$y);

    }

    //Go to the next line

    $this->Ln($h);

  }

  function Row($data,$type = '')
    {
    //Calculate the height of the row
    $nb=0;
    for($i=0;$i<count($data);$i++)
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
    $h=5*$nb;
    //Issue a page break first if needed
    $this->CheckPageBreak($h,$type);
    //Draw the cells of the row
    for($i=0;$i<count($data);$i++)
    {
        $w=$this->widths[$i];
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
        //Save the current position
        $x=$this->GetX();
        $y=$this->GetY();
        //Draw the border
        $this->Rect($x,$y,$w,$h);
        //Print the text
        $this->MultiCell($w,5,$data[$i],0,$a);
        //Put the position to the right of the cell
        $this->SetXY($x+$w,$y);
    }
    //Go to the next line
    $this->Ln($h);
  }
  function Row3($data,$type = '')
    {
    //Calculate the height of the row
    $nb=0;
    for($i=0;$i<count($data);$i++)
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
    $h=4*$nb;
    //Issue a page break first if needed
    $this->CheckPageBreak($h,$type);
    //Draw the cells of the row
    for($i=0;$i<count($data);$i++)
    {
        $w=$this->widths[$i];
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
        //Save the current position
        $x=$this->GetX();
        $y=$this->GetY();
        //Draw the border
        $this->Rect(0,0,0,0);
        //Print the text
        $this->MultiCell($w,4,$data[$i],0,$a);
        //Put the position to the right of the cell
        $this->SetXY($x+$w,$y);
    }
    //Go to the next line
    $this->Ln($h);
  }

  function Row2($data,$type = ''){

    //Calculate the height of the row

    $nb=0;

    for($i=0;$i<count($data);$i++){

      $nb = max($nb,$this->NbLines($this->widths[$i],$data[$i]));

    }

    $h=5*$nb;

    //Issue a page break first if needed

    $this->CheckPageBreak2($h,$type);

    //Draw the cells of the row

    for($i=0;$i<count($data);$i++){

      $w=$this->widths[$i];

      $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';

      //Save the current position

      $x=$this->GetX();

      $y=$this->GetY();

      //Draw the border

      $this->Rect($x,$y,$w,$h);

      //Print the text

      $this->MultiCell($w,5,$data[$i],0,$a);

      //Put the position to the right of the cell

      $this->SetXY($x+$w,$y);

    }

    //Go to the next line

    $this->Ln($h);

  }

  function RowIpcr($data,$type = ''){

    //Calculate the height of the row

    $nb=0;

    for($i=0;$i<count($data);$i++){

      $nb = max($nb,$this->NbLines($this->widths[$i],$data[$i]));

    }

    $h=5*$nb;

    //Issue a page break first if needed

    $this->CheckPageBreakIpcr($h,$type);

    //Draw the cells of the row

    for($i=0;$i<count($data);$i++){

      $w=$this->widths[$i];

      $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';

      //Save the current position

      $x=$this->GetX();

      $y=$this->GetY();

      //Draw the border

      $this->Rect($x,$y,$w,$h);

      //Print the text

      $this->MultiCell($w,5,$data[$i],0,$a);

      //Put the position to the right of the cell

      $this->SetXY($x+$w,$y);

    }

    //Go to the next line

    $this->Ln($h);

  }

  function CheckPageBreakIpcr($h,$type = ''){

    //If the height h would cause an overflow, add a new page immediately

    if($this->GetY()+$h>$this->PageBreakTrigger){

      $this->SetMargins(10,10,10);
      
      $this->AddPage("L", "legal", 0);
      
    }
    
  }

  function RowAppointment($data,$type = ''){

    //Calculate the height of the row

    $nb=0;

    for($i=0;$i<count($data);$i++){

      $nb = max($nb,$this->NbLines($this->widths[$i],$data[$i]));

    }

    $h=4*$nb;

    //Issue a page break first if needed

    $this->CheckPageBreakAppointment($h,$type);

    //Draw the cells of the row

    for($i=0;$i<count($data);$i++){

      $w=$this->widths[$i];

      $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';

      //Save the current position

      $x=$this->GetX();

      $y=$this->GetY();

      //Draw the border

      $this->Rect($x,$y,$w,$h);

      //Print the text

      $this->MultiCell($w,4,$data[$i],0,$a);

      //Put the position to the right of the cell

      $this->SetXY($x+$w,$y);

    }

    //Go to the next line

    $this->Ln($h);

  }

  function CheckPageBreakAppointment($h,$type = ''){

    //If the height h would cause an overflow, add a new page immediately

    if($this->GetY()+$h>$this->PageBreakTrigger){

      $this->AddPage("L", "legal", 0);
      
    }
    
  }

  function RowSaln($data,$type = ''){

    //Calculate the height of the row

    $nb=0;

    for($i=0;$i<count($data);$i++){

      $nb = max($nb,$this->NbLines($this->widths[$i],$data[$i]));

    }

    $h=5*$nb;

    //Issue a page break first if needed

    $this->CheckPageBreakSaln($h,$type);

    //Draw the cells of the row

    for($i=0;$i<count($data);$i++){

      $w=$this->widths[$i];

      $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';

      //Save the current position

      $x=$this->GetX();

      $y=$this->GetY();

      //Draw the border

      $this->Rect($x,$y,$w,$h);

      //Print the text

      $this->MultiCell($w,5,$data[$i],0,$a);

      //Put the position to the right of the cell

      $this->SetXY($x+$w,$y);

    }

    //Go to the next line

    $this->Ln($h);

  }

  function CheckPageBreakSaln($h,$type = ''){

    //If the height h would cause an overflow, add a new page immediately

    if($this->GetY()+$h>$this->PageBreakTrigger){

      $this->AddPage("P",array(215.9,330.2),0);
      
    }
    
  }


  function RowAppointment2($data,$type = ''){

    //Calculate the height of the row

    $nb=0;

    for($i=0;$i<count($data);$i++){

      $nb = max($nb,$this->NbLines($this->widths[$i],$data[$i]));

    }

    $h=4*$nb;

    //Issue a page break first if needed

    $this->CheckPageBreakAppointment2($h,$type);

    //Draw the cells of the row

    for($i=0;$i<count($data);$i++){

      $w=$this->widths[$i];

      $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';

      //Save the current position

      $x=$this->GetX();

      $y=$this->GetY();

      //Draw the border

      // $this->Rect($x,$y,$w,$h);

      //Print the text

      $this->MultiCell($w,4,$data[$i],0,$a);

      //Put the position to the right of the cell

      $this->SetXY($x+$w,$y);

    }

    //Go to the next line

    $this->Ln($h);

  }
  
  function CheckPageBreakAppointment2($h,$type = ''){

    //If the height h would cause an overflow, add a new page immediately

    if($this->GetY()+$h>$this->PageBreakTrigger){

      $this->AddPage("L", "A4", 0);
      
    }
    
  }

  function RowAppointmentPlantilla($data,$year = ''){

    //Calculate the height of the row

    $nb=0;

    for($i=0;$i<count($data);$i++){

      $nb = max($nb,$this->NbLines($this->widths[$i],$data[$i]));

    }

    $h=4*$nb;

    //Issue a page break first if needed

    $this->CheckPageBreakAppointmentPlantilla($h,$year);

    //Draw the cells of the row

    for($i=0;$i<count($data);$i++){

      $w=$this->widths[$i];

      $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';

      //Save the current position

      $x=$this->GetX();

      $y=$this->GetY();

      //Draw the border

      // $this->Rect($x,$y,$w,$h);

      //Print the text

      $this->MultiCell($w,4,$data[$i],0,$a);

      //Put the position to the right of the cell

      $this->SetXY($x+$w,$y);

    }

    //Go to the next line

    $this->Ln($h);

  }
  
  function CheckPageBreakAppointmentPlantilla($h,$year = ''){

    //If the height h would cause an overflow, add a new page immediately

    if($this->GetY()+$h>$this->PageBreakTrigger){

      $this->SetMargins(5,5,5);
      $this->AddPage("L", "A4", 0);
      $this->SetFont("Arial", 'B', 8);
      $this->Cell(0,5,'Republic of the Philippines',0,1,'C');
      $this->Cell(0,5,'DEPARTMENT OF BUDGET AND MANAGEMENT',0,1,'C');
      $this->SetFont("Arial", 'B', 9);
      $this->Cell(0,5,'PERSONAL SERVICES ITEMIZATION AND PLANTILLA OF PERSONNEL (PSIPOP)',0,1,'C');
      $this->Cell(0,5,'for the Fiscal Year : '.$year,0,1,'C');
      $this->Ln(10);
      $this->Rect(5,$this->getY(),156,10);
      $this->Rect(161,$this->getY(),130,10);
      $this->SetFont("Arial", 'B', 7.5);
      $this->Cell(155,5,'Department : Department of Social Welfare and Development',0,0,'L');
      $this->Cell(140,5,'Bureau/Agency : National Authority for Child Care',0,0,'L');
      $this->Ln(10);
      $this->Cell(45,5,'','LTR',0,'C');
      $this->Cell(40,5,'','LTR',0,'C');
      $this->Cell(33,5,'','LTR',0,'C');
      $this->Cell(4,5,'','LTR',0,'C');
      $this->Cell(12,5,'AREA','LTR',0,'C');
      $this->Cell(4,5,'L','LTR',0,'C');
      $this->Cell(18,5,'','LTR',0,'C');
      $this->Cell(37,5,'','LTR',0,'C');
      $this->Cell(5,5,'','LTR',0,'C');
      $this->Cell(14,5,'','LTR',0,'C');
      $this->Cell(11,5,'','LTR',0,'C');
      $this->Cell(20,5,'','LTR',0,'C');
      $this->Cell(17,5,'','LTR',0,'C');
      $this->Cell(5,5,'S','LTR',0,'C');
      $this->Cell(21,5,'','LTR',0,'C');
      $this->Ln(4);
      $this->Cell(45,5,'','LR',0,'C');
      $this->Cell(40,5,'','LR',0,'C');
      $this->Cell(33,5,'','LR',0,'C');
      $this->Cell(4,5,'S','LR',0,'C');
      $this->Cell(7,5,'C','LTR',0,'C');
      $this->Cell(5,5,'T','LTR',0,'C');
      $this->Cell(4,5,'E','LR',0,'C');
      $this->Cell(18,5,'','LR',0,'C');
      $this->Cell(37,5,'','LR',0,'C');
      $this->Cell(5,5,'S','LR',0,'C');
      $this->Cell(14,5,'DATE','LR',0,'C');
      $this->Cell(11,5,'','LR',0,'C');
      $this->Cell(20,5,'DATE OF','LR',0,'C');
      $this->Cell(17,5,'DATE OF','LR',0,'C');
      $this->Cell(5,5,'T','LR',0,'C');
      $this->Cell(21,5,'CIVIL','LR',0,'C');
      $this->Ln(4);
      $this->Cell(45,5,'','LR',0,'C');
      $this->Cell(40,5,'POSITION TITLE and','LR',0,'C');
      $this->Cell(33,5,'ANNUAL SALARY','LR',0,'C');
      $this->Cell(4,5,'T','LR',0,'C');
      $this->Cell(7,5,'O','LR',0,'C');
      $this->Cell(5,5,'Y','LR',0,'C');
      $this->Cell(4,5,'V','LR',0,'C');
      $this->Cell(18,5,'P/P/A','LR',0,'C');
      $this->Cell(37,5,'NAME OF INCUMBENT','LR',0,'C');
      $this->Cell(5,5,'E','LR',0,'C');
      $this->Cell(14,5,'OF','LR',0,'C');
      $this->Cell(11,5,'TIN','LR',0,'C');
      $this->Cell(20,5,'ORIGINAL','LR',0,'C');
      $this->Cell(17,5,'LAST','LR',0,'C');
      $this->Cell(5,5,'A','LR',0,'C');
      $this->Cell(21,5,'SERVICE','LR',0,'C');
      $this->Ln(4);
      $this->Cell(45,5,'ITEM NUMBER','LR',0,'C');
      $this->Cell(40,5,'SALARY GRADE','LR',0,'C');
      $this->Cell(18,5,'AUTHORIZED','LTR',0,'C');
      $this->Cell(15,5,'ACTUAL','LTR',0,'C');
      $this->Cell(4,5,'E','LR',0,'C');
      $this->Cell(7,5,'D','LR',0,'C');
      $this->Cell(5,5,'P','LR',0,'C');
      $this->Cell(4,5,'E','LR',0,'C');
      $this->Cell(18,5,'ATTRIBUTION','LR',0,'C');
      $this->Cell(37,5,'','LR',0,'C');
      $this->Cell(5,5,'X','LR',0,'C');
      $this->Cell(14,5,'BIRTH','LR',0,'C');
      $this->Cell(11,5,'','LR',0,'C');
      $this->Cell(20,5,'APPOINTMENT','LR',0,'C');
      $this->Cell(17,5,'PROMOTION','LR',0,'C');
      $this->Cell(5,5,'T','LR',0,'C');
      $this->Cell(21,5,'ELIGIBILITY','LR',0,'C');
      $this->Ln(4);
      $this->Cell(45,5,'','LR',0,'C');
      $this->Cell(40,5,'','LR',0,'C');
      $this->Cell(18,5,'','LR',0,'C');
      $this->Cell(15,5,'','LR',0,'C');
      $this->Cell(4,5,'P','LR',0,'C');
      $this->Cell(7,5,'E','LR',0,'C');
      $this->Cell(5,5,'E','LR',0,'C');
      $this->Cell(4,5,'L','LR',0,'C');
      $this->Cell(18,5,'','LR',0,'C');
      $this->Cell(37,5,'','LR',0,'C');
      $this->Cell(5,5,'','LR',0,'C');
      $this->Cell(14,5,'','LR',0,'C');
      $this->Cell(11,5,'','LR',0,'C');
      $this->Cell(20,5,'','LR',0,'C');
      $this->Cell(17,5,'','LR',0,'C');
      $this->Cell(5,5,'U','LR',0,'C');
      $this->Cell(21,5,'','LR',0,'C');
      $this->Ln(4);
      $this->Cell(45,5,'','LR',0,'C');
      $this->Cell(40,5,'','LR',0,'C');
      $this->Cell(18,5,'','LR',0,'C');
      $this->Cell(15,5,'','LR',0,'C');
      $this->Cell(4,5,'','LR',0,'C');
      $this->Cell(7,5,'','LR',0,'C');
      $this->Cell(5,5,'','LR',0,'C');
      $this->Cell(4,5,'','LR',0,'C');
      $this->Cell(18,5,'','LR',0,'C');
      $this->Cell(37,5,'','LR',0,'C');
      $this->Cell(5,5,'','LR',0,'C');
      $this->Cell(14,5,'','LR',0,'C');
      $this->Cell(11,5,'','LR',0,'C');
      $this->Cell(20,5,'','LR',0,'C');
      $this->Cell(17,5,'','LR',0,'C');
      $this->Cell(5,5,'S','LR',0,'C');
      $this->Cell(21,5,'','LR',0,'C');
      $this->Ln();
      $this->Cell(45,5,'(1)','LBR',0,'C');
      $this->Cell(40,5,'(2)','LBR',0,'C');
      $this->Cell(18,5,'(3)','LBR',0,'C');
      $this->Cell(15,5,'(4)','LBR',0,'C');
      $this->Cell(4,5,'(5)','LBR',0,'C');
      $this->Cell(7,5,'(6)','LBR',0,'C');
      $this->Cell(5,5,'(7)','LBR',0,'C');
      $this->Cell(4,5,'(8)','LBR',0,'C');
      $this->Cell(18,5,'(9)','LBR',0,'C');
      $this->Cell(37,5,'(10)','LBR',0,'C');
      $this->Cell(5,5,'(11)','LBR',0,'C');
      $this->Cell(14,5,'(12)','LBR',0,'C');
      $this->Cell(11,5,'(13)','LBR',0,'C');
      $this->Cell(20,5,'(14)','LBR',0,'C');
      $this->Cell(17,5,'(15)','LBR',0,'C');
      $this->Cell(5,5,'(16)','LBR',0,'C');
      $this->Cell(21,5,'(17)','LBR',0,'C');
      $this->Ln();
      $this->SetFont("Arial", '', 6.5);
      $this->SetWidths(array(45,41,17,15,4,7,5,3,23,34,3,14,18,14,17,5,21));
      $this->SetAligns(array('L','L','R','R','L','L','L','L','L','L','L','L','L','L','C','C','C'));

    }
    
  }

  function RowPublic($data,$type = ''){

    //Calculate the height of the row

    $nb=0;

    for($i=0;$i<count($data);$i++){

      $nb = max($nb,$this->NbLines($this->widths[$i],$data[$i]));

    }

    $h=5*$nb;

    //Issue a page break first if needed

    $this->CheckPageBreakPublic($h,$type);

    //Draw the cells of the row

    for($i=0;$i<count($data);$i++){

      $w=$this->widths[$i];

      $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';

      //Save the current position

      $x=$this->GetX();

      $y=$this->GetY();

      //Draw the border

      $this->Rect($x,$y,$w,$h);

      //Print the text

      $this->MultiCell($w,5,$data[$i],0,$a);

      //Put the position to the right of the cell

      $this->SetXY($x+$w,$y);

    }

    //Go to the next line

    $this->Ln($h);

  }

  

  function RowReport($data,$type = ''){

    //Calculate the height of the row

    $nb=0;

    for($i=0;$i<count($data);$i++){

      $nb = max($nb,$this->NbLines($this->widths[$i],$data[$i]));

    }

    $h=1.5*$nb;

    //Issue a page break first if needed

    $this->CheckPageBreakReport($h,$type);

    //Draw the cells of the row

    for($i=0;$i<count($data);$i++){

      $w=$this->widths[$i];

      $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';

      //Save the current position

      $x=$this->GetX();

      $y=$this->GetY();

      //Draw the border

      // $this->Rect($x,$y,$w,$h);

      //Print the text

      $this->MultiCell($w,2.5,$data[$i],0,$a);

      //Put the position to the right of the cell

      $this->SetXY($x+$w,$y);

    }

    //Go to the next line

    $this->Ln($h);

  }

  function CheckPageBreakReport($h,$type = ''){

    //If the height h would cause an overflow, add a new page immediately

    if($this->GetY()+$h>$this->PageBreakTrigger){

      $this->AddPage("L", "Letter", 0);
      
    }
    
  }

  function CheckPageBreakPublic($h,$type = ''){

    //If the height h would cause an overflow, add a new page immediately

    if($this->GetY()+$h>$this->PageBreakTrigger){

      $this->AddPage("L", "A4", 0);
      
    }
    
  }

  function RowSr($data,$type = ''){

    //Calculate the height of the row

    $nb=0;

    for($i=0;$i<count($data);$i++){

      $nb = max($nb,$this->NbLines($this->widths[$i],$data[$i]));

    }

    $h=4.5*$nb;

    //Issue a page break first if needed

    $this->CheckPageBreakSr($h,$type);

    //Draw the cells of the row

    for($i=0;$i<count($data);$i++){

      $w=$this->widths[$i];

      $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';

      //Save the current position

      $x=$this->GetX();

      $y=$this->GetY();

      //Draw the border

      // $this->Rect($x,$y,$w,$h);

      //Print the text

      $this->MultiCell($w,4.5,$data[$i],'LR',$a);

      //Put the position to the right of the cell

      $this->SetXY($x+$w,$y);

    }

    //Go to the next line

    $this->Ln($h);

  }

  function CheckPageBreakSr($h,$type = ''){

    //If the height h would cause an overflow, add a new page immediately

    if($this->GetY()+$h>$this->PageBreakTrigger){

      $this->AddPage("P", "Legal", 0);
      
    }
    
  }

  function RowLegalL($data,$type = ''){

    //Calculate the height of the row

    $nb=0;

    for($i=0;$i<count($data);$i++){

      $nb = max($nb,$this->NbLines($this->widths[$i],$data[$i]));

    }

    $h=5*$nb;

    //Issue a page break first if needed

    $this->CheckPageBreakLegalL($h,$type);

    //Draw the cells of the row

    for($i=0;$i<count($data);$i++){

      $w=$this->widths[$i];

      $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';

      //Save the current position

      $x=$this->GetX();

      $y=$this->GetY();

      //Draw the border

      $this->Rect($x,$y,$w,$h);

      //Print the text

      $this->MultiCell($w,5,$data[$i],0,$a);

      //Put the position to the right of the cell

      $this->SetXY($x+$w,$y);

    }

    //Go to the next line

    $this->Ln($h);

  }

  function CheckPageBreakLegalL($h,$type = ''){

    //If the height h would cause an overflow, add a new page immediately

    if($this->GetY()+$h>$this->PageBreakTrigger){

      $this->AddPage("L", "Legal", 0);
      
    }
    
  }

  function RowLegalP($data,$type = ''){

    //Calculate the height of the row

    $nb=0;

    for($i=0;$i<count($data);$i++){

      $nb = max($nb,$this->NbLines($this->widths[$i],$data[$i]));

    }

    $h=4*$nb;

    //Issue a page break first if needed

    $this->CheckPageBreakLegalP($h,$type);

    //Draw the cells of the row

    for($i=0;$i<count($data);$i++){

      $w=$this->widths[$i];

      $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';

      //Save the current position

      $x=$this->GetX();

      $y=$this->GetY();

      //Draw the border

      $this->Rect($x,$y,$w,$h);

      //Print the text

      $this->MultiCell($w,4,$data[$i],0,$a);

      //Put the position to the right of the cell

      $this->SetXY($x+$w,$y);

    }

    //Go to the next line

    $this->Ln($h);

  }

  function CheckPageBreakLegalP($h,$type = ''){

    //If the height h would cause an overflow, add a new page immediately

    if($this->GetY()+$h>$this->PageBreakTrigger){

      $this->AddPage("P", "Legal", 0);
      
    }
    
  }

  function RowLegalTor($data,$type = ''){

    //Calculate the height of the row

    $nb=0;

    for($i=0;$i<count($data);$i++){

      $nb = max($nb,$this->NbLines($this->widths[$i],$data[$i]));

    }

    $h=4*$nb;

    //Issue a page break first if needed

    $this->CheckPageBreakLegalTor($h,$type);

    //Draw the cells of the row

    for($i=0;$i<count($data);$i++){

      $w=$this->widths[$i];

      $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';

      //Save the current position

      $x=$this->GetX();

      $y=$this->GetY();

      //Draw the border

      // $this->Rect($x,$y,$w,$h);

      //Print the text

      $this->MultiCell($w,4,$data[$i],'LR',$a);

      //Put the position to the right of the cell

      $this->SetXY($x+$w,$y);

    }

    //Go to the next line

    $this->Ln($h);

  }

  function CheckPageBreakLegalTor($h,$type = ''){

    //If the height h would cause an overflow, add a new page immediately

    if($this->GetY()+$h>$this->PageBreakTrigger){

      $this->SetMargins(5, 9, 5);
      $this->AddPage("P", "Legal", 0);
      $this->SetAutoPageBreak(false);
      $this->Image($this->serverUrl() . '/assets/img/zam.png', 6.5, 22,35, 35);
      $this->SetFont("Times", '', 12);
      $this->Cell(0, 5, 'ZSCMST-OCR 3.10.I-I5', 0, 0, 'L');
      $this->SetFont("Times", '', 10);
      $this->Ln(5);
      $this->Cell(-7);
      $this->Cell(0, 5, 'Republic of the Philippines', 0, 0, 'C');
      $this->Ln(5);
      $this->SetFont("Times", 'B', 11);
      $this->Cell(-5);
      $this->Cell(0, 5, strtoupper($this->Global->Settings('lgu_name')), 0, 0, 'C');
      $this->Ln(4.5);
      $this->SetFont("Times", '', 10);
      $this->Cell(0, 6, $this->Global->Settings('address'), 0, 0, 'C');

      $this->Ln(15);
      $this->SetFont("Times", '', 14);
      $this->Cell(-6);
      $this->Cell(0, 6, 'OFFICE OF THE COLLEGE REGISTRAR', 0, 0, 'C');
      $this->Ln(7);
      $this->SetFont("Times", '', 17);
      $this->Cell(45, 8, '', 0, 0, 'C');
      $this->Cell(115, 8, 'OFFICIAL TRANSCRIPT OF RECORDS', 1, 0, 'C');

      $this->Ln(10);
      $this->SetFont("Times", '', 11);
      $this->Line(27, $pdf->getY()+5, 110, $pdf->getY()+5);
      $this->Line(150, $pdf->getY()+5, 200, $pdf->getY()+5);
      $this->Cell(10, 5, '', 0, 0, 'L');
      $this->Cell(13, 5, 'Name: ', 0, 0, 'L');
      $this->SetFont("Times", 'B', 11);
      $this->Cell(90, 5, strtoupper($type['Student']['last_name'].', '.$type['Student']['first_name'].' '.$type['Student']['middle_name']), 0, 0, 'L');
      $this->SetFont("Times", '', 11);
      $this->Cell(33, 5, 'Date of Admission: ', 0, 0, 'L');
      $this->Cell(80, 5, fdate($type['StudentApplication']['approved_date'],'m/d/Y'), 0, 0, 'L');
      $this->Line(38, $pdf->getY() + 11, 80, $pdf->getY() + 11);
      $this->Line(93, $pdf->getY() + 11, 110, $pdf->getY() + 11);
      $this->Line(148, $pdf->getY() + 11, 200, $pdf->getY() + 11);
      $this->Ln(6);
      $this->Cell(10, 5, '', 0, 0, 'L');
      $this->Cell(23, 5, 'Date of Birth: ', 0, 0, 'L');
      $this->Cell(45, 5, fdate($type['Student']['date_of_birth'],'m/d/Y'), 0, 0, 'L');
      $this->Cell(10, 5, 'Sex:', 0, 0, 'L');
      $this->Cell(25, 5, $type['Student']['gender'], 0, 0, 'L');
      $this->Cell(30, 5, 'Valid Credential: ', 0, 0, 'L');
      $this->Cell(80, 5, '', 0, 0, 'L');
      $this->Ln(6);
      $this->Line(35, $pdf->getY() + 5, 110, $pdf->getY() + 5);
      $this->Line(140, $pdf->getY() + 5, 155, $pdf->getY() + 5);
      $this->Line(173, $pdf->getY() + 5, 200, $pdf->getY() + 5);
      $this->Cell(10, 5, '', 0, 0, 'L');
      $this->Cell(20, 5, 'Birth Place: ', 0, 0, 'L');
      $this->Cell(83, 5, $type['Student']['place_of_birth'], 0, 0, 'L');
      $this->Cell(23, 5, 'Civil Status: ', 0, 0, 'L');
      $this->Cell(15, 5, $type['Student']['civil_status'], 0, 0, 'L');
      $this->Cell(17, 5, 'Religion:', 0, 0, 'L');
      $this->Cell(25, 5, $type['Student']['religion'], 0, 0, 'L');
      $this->Ln(6);
      $this->SetFont("Times", '', 11);
      $this->Line(40, $pdf->getY()+5, 110, $pdf->getY()+5);
      $this->Line(148, $pdf->getY()+5, 200, $pdf->getY()+5);
      $this->Cell(10, 5, '', 0, 0, 'L');
      $this->Cell(28, 5, 'Home Address: ', 0, 0, 'L');
      $this->Cell(75, 5, '', 0, 0, 'L');
      $this->Cell(31, 5, 'Parent / Guardian: ', 0, 0, 'L');
      $this->Cell(80, 5, '', 0, 0, 'L');
      $this->Ln(7);
      $this->SetFont("Times", '', 10);
      $this->Rect(20, $pdf->GetY(), 175, 21);
      $this->Cell(15, 5, '', 0, 0, 'L');
      $this->Cell(60, 5, 'Preliminar Education: ', 0, 0, 'L');
      $this->Cell(60, 5, 'Name of School', 0, 0, 'L');
      $this->Cell(31, 5, 'Address', 0, 0, 'L');
      $this->Cell(80, 5, 'School Year', 0, 0, 'L');
      $this->Ln(4);
      $this->Cell(15, 5, '', 0, 0, 'L');
      $this->Cell(60, 5, 'Intermediate: ', 0, 0, 'L');
      $this->Ln(4);
      $this->Cell(15, 5, '', 0, 0, 'L');
      $this->Cell(60, 5, 'Secondary: ', 0, 0, 'L');
      $this->Ln(4);
      $this->Cell(15, 5, '', 0, 0, 'L');
      $this->Cell(60, 5, 'Senior High School: ', 0, 0, 'L');    
      $this->Ln(4);
      $this->Cell(15, 5, '', 0, 0, 'L');
      $this->Cell(60, 5, 'College: ', 0, 0, 'L');
      $this->Ln(6);
      $this->SetFont("Times", '', 10);
      $this->Line(42, $pdf->getY()+5, 185, $pdf->getY()+5);
      $this->Cell(20, 5, '', 0, 0, 'L');
      $this->Cell(13, 5, 'DEGREE: ', 0, 0, 'L');
      $this->Ln(6);
      $this->Line(40, $pdf->getY()+5, 185, $pdf->getY()+5);
      $this->Cell(20, 5, '', 0, 0, 'L');
      $this->Cell(13, 5, 'MAJOR: ', 0, 0, 'L');
      $this->Ln(6);
      $this->Line(67, $pdf->getY()+5, 110, $pdf->getY()+5);
      $this->Line(156, $pdf->getY()+5, 185, $pdf->getY()+5);
      $this->Cell(20, 5, '', 0, 0, 'L');
      $this->Cell(43, 5, 'DATE OF GRADUATION: ', 0, 0, 'L');
      $this->Cell(51, 5, '', 0, 0, 'L');
      $this->Cell(38, 5, 'ACADEMIC AWARDS: ', 0, 0, 'L');
      $this->Cell(13, 5, '', 0, 0, 'L');

      $this->AddPage("P", "Legal", 0);
      
    }
    
  }

  function RowLegalPor($data,$type = ''){

    //Calculate the height of the row

    $nb=0;

    for($i=0;$i<count($data);$i++){

      $nb = max($nb,$this->NbLines($this->widths[$i],$data[$i]));

    }

    $h=5*$nb;

    //Issue a page break first if needed

    $this->CheckPageBreakLegalPor($h,$type);

    //Draw the cells of the row

    for($i=0;$i<count($data);$i++){

      $w=$this->widths[$i];

      $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';

      //Save the current position

      $x=$this->GetX();

      $y=$this->GetY();

      //Draw the border

      // $this->Rect($x,$y,$w,$h);

      //Print the text

      $this->MultiCell($w,5,$data[$i],0,$a);

      //Put the position to the right of the cell

      $this->SetXY($x+$w,$y);

    }

    //Go to the next line

    $this->Ln($h);

  }

  function CheckPageBreakLegalPor($h,$type = ''){

    //If the height h would cause an overflow, add a new page immediately

    if($this->GetY()+$h>$this->PageBreakTrigger){

      $this->AddPage("P", "Legal", 0);
      
    }
    
  }

  function RowPayroll($data,$type = ''){

    //Calculate the height of the row

    $nb=0;

    for($i=0;$i<count($data);$i++){

      $nb = max($nb,$this->NbLines($this->widths[$i],$data[$i]));

    }

    $h=4*$nb;

    //Issue a page break first if needed

    $this->CheckPageBreakPayroll($h,$type);

    //Draw the cells of the row

    for($i=0;$i<count($data);$i++){

      $w=$this->widths[$i];

      $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';

      //Save the current position

      $x=$this->GetX();

      $y=$this->GetY();

      //Draw the border

      $this->Rect($x,$y,$w,$h);

      //Print the text

      $this->MultiCell($w,4,$data[$i],0,$a);

      //Put the position to the right of the cell

      $this->SetXY($x+$w,$y);

    }

    //Go to the next line

    $this->Ln($h);

  }

  function CheckPageBreakPayroll($h,$type = ''){

    //If the height h would cause an overflow, add a new page immediately

    if($this->GetY()+$h>$this->PageBreakTrigger){

      $this->AddPage("L", "A4", 0);
      
    }
    
  }

  function RowPayGenCasual($data,$type = ''){

    //Calculate the height of the row

    $nb=0;

    for($i=0;$i<count($data);$i++){

      $nb = max($nb,$this->NbLines($this->widths[$i],$data[$i]));

    }

    $h=4*$nb;

    //Issue a page break first if needed

    $this->CheckPageBreakPayGenCasual($h,$type);

    //Draw the cells of the row

    for($i=0;$i<count($data);$i++){

      $w=$this->widths[$i];

      $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';

      //Save the current position

      $x=$this->GetX();

      $y=$this->GetY();

      //Draw the border

      // $this->Rect($x,$y,$w,$h);

      //Print the text

      $this->MultiCell($w,4,$data[$i],0,$a);

      //Put the position to the right of the cell

      $this->SetXY($x+$w,$y);

    }

    //Go to the next line

    $this->Ln($h);

  }

  function CheckPageBreakPayGenCasual($h,$type = ''){

    //If the height h would cause an overflow, add a new page immediately

    if($this->GetY()+$h>$this->PageBreakTrigger){

      $this->AddPage("P", "Legal", 0);
      
    }
    
  }

  function RowPayrollLegal($data,$type = ''){

    //Calculate the height of the row

    $nb=0;

    for($i=0;$i<count($data);$i++){

      $nb = max($nb,$this->NbLines($this->widths[$i],$data[$i]));

    }

    $h=4*$nb;

    //Issue a page break first if needed

    $this->CheckPageBreakPayrollLegal($h,$type);

    //Draw the cells of the row

    for($i=0;$i<count($data);$i++){

      $w=$this->widths[$i];

      $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';

      //Save the current position

      $x=$this->GetX();

      $y=$this->GetY();

      //Draw the border

      $this->Rect($x,$y,$w,$h);

      //Print the text

      $this->MultiCell($w,4,$data[$i],0,$a);

      //Put the position to the right of the cell

      $this->SetXY($x+$w,$y);

    }

    //Go to the next line

    $this->Ln($h);

  }

  function CheckPageBreakPayrollLegal($h,$type = ''){

    //If the height h would cause an overflow, add a new page immediately

    if($this->GetY()+$h>$this->PageBreakTrigger){

      $this->AddPage("L", "Legal", 0);
      
    }
    
  }

  function RowPayroll2($data,$type = ''){

    //Calculate the height of the row

    $nb=0;

    for($i=0;$i<count($data);$i++){

      $nb = max($nb,$this->NbLines($this->widths[$i],$data[$i]));

    }

    $h=5*$nb;

    //Issue a page break first if needed

    $this->CheckPageBreakPayroll2($h,$type);

    //Draw the cells of the row

    for($i=0;$i<count($data);$i++){

      $w=$this->widths[$i];

      $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';

      //Save the current position

      $x=$this->GetX();

      $y=$this->GetY();

      //Draw the border

      $this->Rect($x,$y,$w,$h);

      //Print the text

      $this->MultiCell($w,5,$data[$i],0,$a);

      //Put the position to the right of the cell

      $this->SetXY($x+$w,$y);

    }

    //Go to the next line

    $this->Ln($h);

  }

  function CheckPageBreakPayroll2($h,$type = ''){

    //If the height h would cause an overflow, add a new page immediately

    if($this->GetY()+$h>$this->PageBreakTrigger){

      $this->AddPage("L", "Legal", 0);
      
    }
    
  }


  function RowA4Por($data,$type = ''){

    //Calculate the height of the row

    $nb=0;

    for($i=0;$i<count($data);$i++){

      $nb = max($nb,$this->NbLines($this->widths[$i],$data[$i]));

    }

    $h=5*$nb;

    //Issue a page break first if needed

    $this->CheckPageBreakA4Por($h,$type);

    //Draw the cells of the row

    for($i=0;$i<count($data);$i++){

      $w=$this->widths[$i];

      $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';

      //Save the current position

      $x=$this->GetX();

      $y=$this->GetY();

      //Draw the border

      $this->Rect($x,$y,$w,$h);

      //Print the text

      $this->MultiCell($w,5,$data[$i],0,$a);

      //Put the position to the right of the cell

      $this->SetXY($x+$w,$y);

    }

    //Go to the next line

    $this->Ln($h);

  }

  function CheckPageBreakA4Por($h,$type = ''){

    //If the height h would cause an overflow, add a new page immediately

    if($this->GetY()+$h>$this->PageBreakTrigger){

      $this->AddPage("P", "A4", 0);
      
    }
    
  }

  function RowA4($data,$type = ''){

    //Calculate the height of the row

    $nb=0;

    for($i=0;$i<count($data);$i++){

      $nb = max($nb,$this->NbLines($this->widths[$i],$data[$i]));

    }

    $h=4*$nb;

    //Issue a page break first if needed

    $this->CheckPageBreakA4($h,$type);

    //Draw the cells of the row

    for($i=0;$i<count($data);$i++){

      $w=$this->widths[$i];

      $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';

      //Save the current position

      $x=$this->GetX();

      $y=$this->GetY();

      //Draw the border

      $this->Rect($x,$y,$w,$h);

      //Print the text

      $this->MultiCell($w,4,$data[$i],0,$a);

      //Put the position to the right of the cell

      $this->SetXY($x+$w,$y);

    }

    //Go to the next line

    $this->Ln($h);

  }

  function CheckPageBreakA4($h,$type = ''){

    //If the height h would cause an overflow, add a new page immediately

    if($this->GetY()+$h>$this->PageBreakTrigger){

      $this->AddPage("L", "A4", 0);
      
    }
    
  }

  function RowA4Land($data,$type = ''){

    //Calculate the height of the row

    $nb=0;

    for($i=0;$i<count($data);$i++){

      $nb = max($nb,$this->NbLines($this->widths[$i],$data[$i]));

    }

    $h=5*$nb;

    //Issue a page break first if needed

    $this->CheckPageBreakA4Land($h,$type);

    //Draw the cells of the row

    for($i=0;$i<count($data);$i++){

      $w=$this->widths[$i];

      $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';

      //Save the current position

      $x=$this->GetX();

      $y=$this->GetY();

      //Draw the border
      
      if($data[$i] !== ''){

        $this->Rect($x,$y,$w,$h);

      }

      //Print the text

      $this->MultiCell($w,5,$data[$i],0,$a);


      //Put the position to the right of the cell

      $this->SetXY($x+$w,$y);

    }

    //Go to the next line

    $this->Ln($h);

  }

  function CheckPageBreakA4Land($h,$type = ''){

    //If the height h would cause an overflow, add a new page immediately

    if($this->GetY()+$h>$this->PageBreakTrigger){

      $this->AddPage("L", "A4", 0);
      
    }
    
  }

  function RowEmployee($data,$type = ''){

    //Calculate the height of the row

    $nb=0;

    for($i=0;$i<count($data);$i++){

      $nb = max($nb,$this->NbLines($this->widths[$i],$data[$i]));

    }

    $h=5*$nb;

    //Issue a page break first if needed

    $this->CheckPageBreakEmployee($h,$type);

    //Draw the cells of the row

    for($i=0;$i<count($data);$i++){

      $w=$this->widths[$i];

      $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';

      //Save the current position

      $x=$this->GetX();

      $y=$this->GetY();

      //Draw the border

      $this->Rect($x,$y,$w,$h);

      //Print the text

      $this->MultiCell($w,5,$data[$i],0,$a);

      //Put the position to the right of the cell

      $this->SetXY($x+$w,$y);

    }

    //Go to the next line

    $this->Ln($h);

  }

  function CheckPageBreakEmployee($h,$type = ''){

    //If the height h would cause an overflow, add a new page immediately

    if($this->GetY()+$h>$this->PageBreakTrigger){

      $this->AddPage("L", "Letter", 0);
      
    }
    
  }

  function CheckPageBreak2($h,$type = ''){

    //If the height h would cause an overflow, add a new page immediately

    if($this->GetY()+$h>$this->PageBreakTrigger){

      $this->AddPage("P", "legal", 0);
      
    }
    
  }
function CheckPageBreak($h,$type = '')
{
  if($type == 'L'){
    //If the height h would cause an overflow, add a new page immediately
    if($this->GetY()+$h>$this->PageBreakTrigger)
        $this->AddPage("L", "A4", 0);
  }else{
  //If the height h would cause an overflow, add a new page immediately
    if($this->GetY()+$h>$this->PageBreakTrigger)
        $this->AddPage("P", "A4", 0);
  }
    
}

function NbLines($w,$txt)
{
    //Computes the number of lines a MultiCell of width w will take
    $cw=&$this->CurrentFont['cw'];
    if($w==0)
        $w=$this->w-$this->rMargin-$this->x;
    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
    $s=str_replace("\r",'',$txt);
    $nb=strlen($s);
    if($nb>0 and $s[$nb-1]=="\n")
        $nb--;
    $sep=-1;
    $i=0;
    $j=0;
    $l=0;
    $nl=1;
    while($i<$nb)
    {
        $c=$s[$i];
        if($c=="\n")
        {
            $i++;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
            continue;
        }
        if($c==' ')
            $sep=$i;
        $l+=$cw[$c];
        if($l>$wmax)
        {
            if($sep==-1)
            {
                if($i==$j)
                    $i++;
            }
            else
                $i=$sep+1;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
        }
        else
            $i++;
    }
    return $nl;
}


//variables of html parser
protected $B;
protected $I;
protected $U;
protected $HREF;
protected $fontList;
protected $issetfont;
protected $issetcolor;

function __construct($orientation='P', $unit='mm', $format='A4')
{
    //Call parent constructor
    parent::__construct($orientation,$unit,$format);

    //Initialization
    $this->B=0;
    $this->I=0;
    $this->U=0;
    $this->HREF='';

    $this->tableborder=0;
    $this->tdbegin=false;
    $this->tdwidth=0;
    $this->tdheight=0;
    $this->tdalign="L";
    $this->tdbgcolor=false;

    $this->oldx=0;
    $this->oldy=0;

    $this->fontlist=array("arial","times","courier","helvetica","symbol");
    $this->issetfont=false;
    $this->issetcolor=false;
}

//////////////////////////////////////
//html parser

  
function WriteHTML($html)
{
    $html=strip_tags($html,"<b><u><i><a><img><p><br><strong><em><font><tr><blockquote><hr><td><tr><table><sup>"); //remove all unsupported tags
    $html=str_replace("\n",'',$html); //replace carriage returns with spaces
    $html=str_replace("\t",'',$html); //replace carriage returns with spaces
    $a=preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE); //explode the string
    foreach($a as $i=>$e)
    {
        if($i%2==0)
        {
            //Text
            if($this->HREF)
                $this->PutLink($this->HREF,$e);
            elseif($this->tdbegin) {
                if(trim($e)!='' && $e!="&nbsp;") {
                    $this->Cell($this->tdwidth,$this->tdheight,$e,$this->tableborder,'',$this->tdalign,$this->tdbgcolor);
                }
                elseif($e=="&nbsp;") {
                    $this->Cell($this->tdwidth,$this->tdheight,'',$this->tableborder,'',$this->tdalign,$this->tdbgcolor);
                }
            }
            else
                $this->Write(5,stripslashes(txtentities($e)));
        }
        else
        {
            //Tag
            if($e[0]=='/')
                $this->CloseTag(strtoupper(substr($e,1)));
            else
            {
                //Extract attributes
                $a2=explode(' ',$e);
                $tag=strtoupper(array_shift($a2));
                $attr=array();
                foreach($a2 as $v)
                {
                    if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
                        $attr[strtoupper($a3[1])]=$a3[2];
                }
                $this->OpenTag($tag,$attr);
            }
        }
    }
}

function OpenTag($tag, $attr)
{
    //Opening tag
    switch($tag){

        case 'SUP':
            if( !empty($attr['SUP']) ) {    
                //Set current font to 6pt     
                $this->SetFont('','',6);
                //Start 125cm plus width of cell to the right of left margin         
                //Superscript "1" 
                $this->Cell(2,2,$attr['SUP'],0,0,'L');
            }
            break;

        case 'TABLE': // TABLE-BEGIN
            if( !empty($attr['BORDER']) ) $this->tableborder=$attr['BORDER'];
            else $this->tableborder=0;
            break;
        case 'TR': //TR-BEGIN
            break;
        case 'TD': // TD-BEGIN
            if( !empty($attr['WIDTH']) ) $this->tdwidth=($attr['WIDTH']/4);
            else $this->tdwidth=40; // Set to your own width if you need bigger fixed cells
            if( !empty($attr['HEIGHT']) ) $this->tdheight=($attr['HEIGHT']/6);
            else $this->tdheight=6; // Set to your own height if you need bigger fixed cells
            if( !empty($attr['ALIGN']) ) {
                $align=$attr['ALIGN'];        
                if($align=='LEFT') $this->tdalign='L';
                if($align=='CENTER') $this->tdalign='C';
                if($align=='RIGHT') $this->tdalign='R';
            }
            else $this->tdalign='L'; // Set to your own
            if( !empty($attr['BGCOLOR']) ) {
                $coul=hex2dec($attr['BGCOLOR']);
                    $this->SetFillColor($coul['R'],$coul['G'],$coul['B']);
                    $this->tdbgcolor=true;
                }
            $this->tdbegin=true;
            break;

        case 'HR':
            if( !empty($attr['WIDTH']) )
                $Width = $attr['WIDTH'];
            else
                $Width = $this->w - $this->lMargin-$this->rMargin;
            $x = $this->GetX();
            $y = $this->GetY();
            $this->SetLineWidth(0.2);
            $this->Line($x,$y,$x+$Width,$y);
            $this->SetLineWidth(0.2);
            $this->Ln(1);
            break;
        case 'STRONG':
            $this->SetStyle('B',true);
            break;
        case 'EM':
            $this->SetStyle('I',true);
            break;
        case 'B':
        case 'I':
        case 'U':
            $this->SetStyle($tag,true);
            break;
        case 'A':
            $this->HREF=$attr['HREF'];
            break;
        case 'IMG':
            if(isset($attr['SRC']) && (isset($attr['WIDTH']) || isset($attr['HEIGHT']))) {
                if(!isset($attr['WIDTH']))
                    $attr['WIDTH'] = 0;
                if(!isset($attr['HEIGHT']))
                    $attr['HEIGHT'] = 0;
                $this->Image($attr['SRC'], $this->GetX(), $this->GetY(), px2mm($attr['WIDTH']), px2mm($attr['HEIGHT']));
            }
            break;
        case 'BLOCKQUOTE':
        case 'BR':
            $this->Ln(5);
            break;
        case 'P':
            $this->Ln(10);
            break;
        case 'FONT':
            if (isset($attr['COLOR']) && $attr['COLOR']!='') {
                $coul=hex2dec($attr['COLOR']);
                $this->SetTextColor($coul['R'],$coul['G'],$coul['B']);
                $this->issetcolor=true;
            }
            if (isset($attr['FACE']) && in_array(strtolower($attr['FACE']), $this->fontlist)) {
                $this->SetFont(strtolower($attr['FACE']));
                $this->issetfont=true;
            }
            if (isset($attr['FACE']) && in_array(strtolower($attr['FACE']), $this->fontlist) && isset($attr['SIZE']) && $attr['SIZE']!='') {
                $this->SetFont(strtolower($attr['FACE']),'',$attr['SIZE']);
                $this->issetfont=true;
            }
            break;
    }
}

function CloseTag($tag)
{
    //Closing tag
    if($tag=='SUP') {
    }

    if($tag=='TD') { // TD-END
        $this->tdbegin=false;
        $this->tdwidth=0;
        $this->tdheight=0;
        $this->tdalign="L";
        $this->tdbgcolor=false;
    }
    if($tag=='TR') { // TR-END
        $this->Ln();
    }
    if($tag=='TABLE') { // TABLE-END
        $this->tableborder=0;
    }

    if($tag=='STRONG')
        $tag='B';
    if($tag=='EM')
        $tag='I';
    if($tag=='B' || $tag=='I' || $tag=='U')
        $this->SetStyle($tag,false);
    if($tag=='A')
        $this->HREF='';
    if($tag=='FONT'){
        if ($this->issetcolor==true) {
            $this->SetTextColor(0);
        }
        if ($this->issetfont) {
            $this->SetFont('arial');
            $this->issetfont=false;
        }
    }
}

function SetStyle($tag, $enable)
{
    //Modify style and select corresponding font
    $this->$tag+=($enable ? 1 : -1);
    $style='';
    foreach(array('B','I','U') as $s) {
        if($this->$s>0)
            $style.=$s;
    }
    $this->SetFont('',$style);
}

function PutLink($URL, $txt)
{
    //Put a hyperlink
    $this->SetTextColor(0,0,255);
    $this->SetStyle('U',true);
    $this->Write(5,$txt,$URL);
    $this->SetStyle('U',false);
    $this->SetTextColor(0);
}
function WordWrap(&$text, $maxwidth){
    $text = trim($text);
    if ($text==='')
        return 0;
    $space = $this->GetStringWidth(' ');
    $lines = explode("\n", $text);
    $text = '';
    $count = 0;

    foreach ($lines as $line)
    {
        $words = preg_split('/ +/', $line);
        $width = 0;

        foreach ($words as $word)
        {
            $wordwidth = $this->GetStringWidth($word);
            if ($wordwidth > $maxwidth)
            {
                // Word is too long, we cut it
                for($i=0; $i<strlen($word); $i++)
                {
                    $wordwidth = $this->GetStringWidth(substr($word, $i, 1));
                    if($width + $wordwidth <= $maxwidth)
                    {
                        $width += $wordwidth;
                        $text .= substr($word, $i, 1);
                    }
                    else
                    {
                        $width = $wordwidth;
                        $text = rtrim($text)."\n".substr($word, $i, 1);
                        $count++;
                    }
                }
            }
            elseif($width + $wordwidth <= $maxwidth)
            {
                $width += $wordwidth + $space;
                $text .= $word.' ';
            }
            else
            {
                $width = $wordwidth + $space;
                $text = $text."\n".$word.' ';
                $count++;
            }
        }
        $text = $text."\n";
        $count++;
    }
    $text = $text;
    return $count;
}

 //MultiCell with bullet
    function MultiCellBlt($w, $h, $blt, $txt, $border=0, $align='J', $fill=false)
    {
        //Get bullet width including margins
        $blt_width = $this->GetStringWidth($blt)+$this->cMargin*2;

        //Save x
        $bak_x = $this->x;

        //Output bullet
        $this->Cell($blt_width,$h,$blt,0,'',$fill);

        //Output text
        $this->MultiCell($w-$blt_width,$h,$txt,$border,$align,$fill);

        //Restore x
        $this->x = $bak_x;
    }

  function WriteTag($w, $h, $txt, $border=0, $align="J", $fill=false, $padding=0){
    $this->wLine=$w;
    $this->hLine=$h;
    $this->Text=trim($txt);
    $this->Text=preg_replace("/\n|\r|\t/","",$this->Text);
    $this->border=$border;
    $this->align=$align;
    $this->fill=$fill;
    $this->Padding=$padding;

    $this->Xini=$this->GetX();
    $this->href="";
    $this->PileStyle=array();   
    $this->TagHref=array();
    $this->LastLine=false;
    $this->NextLineBegin=array();

    $this->SetSpace();
    $this->Padding();
    $this->LineLength();
    $this->BorderTop();

    while($this->Text!=""){

      $this->MakeLine();

      $this->PrintLine();

    }

    $this->BorderBottom();
  
  }

  function SetStyle2($tag, $family, $style, $size, $color, $indent=-1, $bullet=''){

    $tag = trim($tag);

    $this->TagStyle[$tag]['family'] = trim($family);

    $this->TagStyle[$tag]['style'] = trim($style);

    $this->TagStyle[$tag]['size'] = trim($size);

    $this->TagStyle[$tag]['color'] = trim($color);

    $this->TagStyle[$tag]['indent'] = $indent;

    $this->TagStyle[$tag]['bullet'] = $bullet;
  
  }

  // Private Functions

  function SetSpace(){

    $tag = $this->Parser($this->Text);

    $this->FindStyle($tag[2],0);

    $this->DoStyle(0);

    $this->Space = $this->GetStringWidth(" ");

  }

  function Padding(){

    if(preg_match("/^.+,/",$this->Padding)) {
      $tab=explode(",",$this->Padding);
      $this->lPadding=$tab[0];
      $this->tPadding=$tab[1];
      if(isset($tab[2]))
        $this->bPadding=$tab[2];
      else
        $this->bPadding=$this->tPadding;
      if(isset($tab[3]))
        $this->rPadding=$tab[3];
      else
        $this->rPadding=$this->lPadding;
    }else{
      $this->lPadding=$this->Padding;
      $this->tPadding=$this->Padding;
      $this->bPadding=$this->Padding;
      $this->rPadding=$this->Padding;
    }
    if($this->tPadding<$this->LineWidth)
      $this->tPadding=$this->LineWidth;
  }

  function LineLength(){
    if($this->wLine==0)
      $this->wLine=$this->w - $this->Xini - $this->rMargin;

    $this->wTextLine = $this->wLine - $this->lPadding - $this->rPadding;
  }

  function BorderTop(){
    $border=0;
    if($this->border==1)
      $border="TLR";
    $this->Cell($this->wLine,$this->tPadding,"",$border,0,'C',$this->fill);
    $y=$this->GetY()+$this->tPadding;
    $this->SetXY($this->Xini,$y);
  }

  function BorderBottom(){
    $border=0;
    if($this->border==1)
      $border="BLR";
    $this->Cell($this->wLine,$this->bPadding,"",$border,0,'C',$this->fill);
  }

  function DoStyle($ind){
    if(!isset($this->TagStyle[$ind]))
      return;

    $this->SetFont($this->TagStyle[$ind]['family'],
      $this->TagStyle[$ind]['style'],
      $this->TagStyle[$ind]['size']);

    $tab=explode(",",$this->TagStyle[$ind]['color']);
    if(count($tab)==1)
      $this->SetTextColor($tab[0]);
    else
      $this->SetTextColor($tab[0],$tab[1],$tab[2]);
  }

  function FindStyle($tag, $ind){
    $tag=trim($tag);

    // Family
    if($this->TagStyle[$tag]['family']!="")
      $family=$this->TagStyle[$tag]['family'];
    else
    {
      foreach($this->PileStyle as $val)
      {
        $val=trim($val);
        if($this->TagStyle[$val]['family']!="") {
          $family=$this->TagStyle[$val]['family'];
          break;
        }
      }
    }

    // Style
    $style="";
    $style1=strtoupper($this->TagStyle[$tag]['style']);
    if($style1!="N")
    {
      $bold=false;
      $italic=false;
      $underline=false;
      foreach($this->PileStyle as $val)
      {
        $val=trim($val);
        $style1=strtoupper($this->TagStyle[$val]['style']);
        if($style1=="N")
          break;
        else
        {
          if(strpos($style1,"B")!==false)
            $bold=true;
          if(strpos($style1,"I")!==false)
            $italic=true;
          if(strpos($style1,"U")!==false)
            $underline=true;
        } 
      }
      if($bold)
        $style.="B";
      if($italic)
        $style.="I";
      if($underline)
        $style.="U";
    }

    // Size
    if($this->TagStyle[$tag]['size']!=0)
      $size=$this->TagStyle[$tag]['size'];
    else
    {
      foreach($this->PileStyle as $val)
      {
        $val=trim($val);
        if($this->TagStyle[$val]['size']!=0) {
          $size=$this->TagStyle[$val]['size'];
          break;
        }
      }
    }

    // Color
    if($this->TagStyle[$tag]['color']!="")
      $color=$this->TagStyle[$tag]['color'];
    else
    {
      foreach($this->PileStyle as $val)
      {
        $val=trim($val);
        if($this->TagStyle[$val]['color']!="") {
          $color=$this->TagStyle[$val]['color'];
          break;
        }
      }
    }
     
    // Result
    $this->TagStyle[$ind]['family']=$family;
    $this->TagStyle[$ind]['style']=$style;
    $this->TagStyle[$ind]['size']=$size;
    $this->TagStyle[$ind]['color']=$color;
    $this->TagStyle[$ind]['indent']=$this->TagStyle[$tag]['indent'];
  }

  function Parser($text){
    $tab=array();
    // Closing tag
    if(preg_match("|^(</([^>]+)>)|",$text,$regs)) {
      $tab[1]="c";
      $tab[2]=trim($regs[2]);
    }
    // Opening tag
    else if(preg_match("|^(<([^>]+)>)|",$text,$regs)) {
      $regs[2]=preg_replace("/^a/","a ",$regs[2]);
      $tab[1]="o";
      $tab[2]=trim($regs[2]);

      // Presence of attributes
      if(preg_match("/(.+) (.+)='(.+)'/",$regs[2])) {
        $tab1=preg_split("/ +/",$regs[2]);
        $tab[2]=trim($tab1[0]);
        foreach($tab1 as $i=>$couple)
        {
          if($i>0) {
            $tab2=explode("=",$couple);
            $tab2[0]=trim($tab2[0]);
            $tab2[1]=trim($tab2[1]);
            $end=strlen($tab2[1])-2;
            $tab[$tab2[0]]=substr($tab2[1],1,$end);
          }
        }
      }
    }
    // Space
    else if(preg_match("/^( )/",$text,$regs)) {
      $tab[1]="s";
      $tab[2]=' ';
    }
    // Text
    else if(preg_match("/^([^< ]+)/",$text,$regs)) {
      $tab[1]="t";
      $tab[2]=trim($regs[1]);
    }

    $begin=strlen($regs[1]);
    $end=strlen($text);
    $text=substr($text, $begin, $end);
    $tab[0]=$text;

    return $tab;
  }

  function MakeLine(){
    $this->Text.=" ";
    $this->LineLength=array();
    $this->TagHref=array();
    $Length=0;
    $this->nbSpace=0;

    $i=$this->BeginLine();
    $this->TagName=array();

    if($i==0) {
      $Length=$this->StringLength[0];
      $this->TagName[0]=1;
      $this->TagHref[0]=$this->href;
    }

    while($Length<$this->wTextLine)
    {
      $tab=$this->Parser($this->Text);
      $this->Text=$tab[0];
      if($this->Text=="") {
        $this->LastLine=true;
        break;
      }

      if($tab[1]=="o") {
        array_unshift($this->PileStyle,$tab[2]);
        $this->FindStyle($this->PileStyle[0],$i+1);

        $this->DoStyle($i+1);
        $this->TagName[$i+1]=1;
        if($this->TagStyle[$tab[2]]['indent']!=-1) {
          $Length+=$this->TagStyle[$tab[2]]['indent'];
          $this->Indent=$this->TagStyle[$tab[2]]['indent'];
          $this->Bullet=$this->TagStyle[$tab[2]]['bullet'];
        }
        if($tab[2]=="a")
          $this->href=$tab['href'];
      }

      if($tab[1]=="c") {
        array_shift($this->PileStyle);
        if(isset($this->PileStyle[0]))
        {
          $this->FindStyle($this->PileStyle[0],$i+1);
          $this->DoStyle($i+1);
        }
        $this->TagName[$i+1]=1;
        if($this->TagStyle[$tab[2]]['indent']!=-1) {
          $this->LastLine=true;
          $this->Text=trim($this->Text);
          break;
        }
        if($tab[2]=="a")
          $this->href="";
      }

      if($tab[1]=="s") {
        $i++;
        $Length+=$this->Space;
        $this->Line2Print[$i]="";
        if($this->href!="")
          $this->TagHref[$i]=$this->href;
      }

      if($tab[1]=="t") {
        $i++;
        $this->StringLength[$i]=$this->GetStringWidth($tab[2]);
        $Length+=$this->StringLength[$i];
        $this->LineLength[$i]=$Length;
        $this->Line2Print[$i]=$tab[2];
        if($this->href!="")
          $this->TagHref[$i]=$this->href;
       }

    }

    trim($this->Text);
    if($Length>$this->wTextLine || $this->LastLine==true)
      $this->EndLine();
  }

  function BeginLine(){
    $this->Line2Print=array();
    $this->StringLength=array();

    if(isset($this->PileStyle[0]))
    {
      $this->FindStyle($this->PileStyle[0],0);
      $this->DoStyle(0);
    }

    if(count($this->NextLineBegin)>0) {
      $this->Line2Print[0]=$this->NextLineBegin['text'];
      $this->StringLength[0]=$this->NextLineBegin['length'];
      $this->NextLineBegin=array();
      $i=0;
    }
    else {
      preg_match("/^(( *(<([^>]+)>)* *)*)(.*)/",$this->Text,$regs);
      $regs[1]=str_replace(" ", "", $regs[1]);
      $this->Text=$regs[1].$regs[5];
      $i=-1;
    }

    return $i;
  }

  function EndLine(){
    if(end($this->Line2Print)!="" && $this->LastLine==false) {
      $this->NextLineBegin['text']=array_pop($this->Line2Print);
      $this->NextLineBegin['length']=end($this->StringLength);
      array_pop($this->LineLength);
    }

    while(end($this->Line2Print)==="")
      array_pop($this->Line2Print);

    $this->Delta=$this->wTextLine-end($this->LineLength);

    $this->nbSpace=0;
    for($i=0; $i<count($this->Line2Print); $i++) {
      if($this->Line2Print[$i]=="")
        $this->nbSpace++;
    }
  }

  function PrintLine(){
    $border=0;
    if($this->border==1)
      $border="LR";
    $this->Cell($this->wLine,$this->hLine,"",$border,0,'C',$this->fill);
    $y=$this->GetY();
    $this->SetXY($this->Xini+$this->lPadding,$y);

    if($this->Indent>0) {
      if($this->Bullet!='')
        $this->SetTextColor(0);
      $this->Cell($this->Indent,$this->hLine,$this->Bullet);
      $this->Indent=-1;
      $this->Bullet='';
    }

    $space=$this->LineAlign();
    $this->DoStyle(0);
    for($i=0; $i<count($this->Line2Print); $i++)
    {
      if(isset($this->TagName[$i]))
        $this->DoStyle($i);
      if(isset($this->TagHref[$i]))
        $href=$this->TagHref[$i];
      else
        $href='';
      if($this->Line2Print[$i]=="")
        $this->Cell($space,$this->hLine,"         ",0,0,'C',false,$href);
      else
        $this->Cell($this->StringLength[$i],$this->hLine,$this->Line2Print[$i],0,0,'C',false,$href);
    }

    $this->LineBreak();
    if($this->LastLine && $this->Text!="")
      $this->EndParagraph();
    $this->LastLine=false;
  }

  function LineAlign(){
    $space=$this->Space;
    if($this->align=="J") {
      if($this->nbSpace!=0)
        $space=$this->Space + ($this->Delta/$this->nbSpace);
      if($this->LastLine)
        $space=$this->Space;
    }

    if($this->align=="R")
      $this->Cell($this->Delta,$this->hLine);

    if($this->align=="C")
      $this->Cell($this->Delta/2,$this->hLine);

    return $space;
  }

  function LineBreak(){
    $x=$this->Xini;
    $y=$this->GetY()+$this->hLine;
    $this->SetXY($x,$y);
  }

  function EndParagraph(){
    $border=0;
    if($this->border==1)
      $border="LR";
    $this->Cell($this->wLine,$this->hLine/2,"",$border,0,'C',$this->fill);
    $x=$this->Xini;
    $y=$this->GetY()+$this->hLine/2;
    $this->SetXY($x,$y);
  }
  
    
}

?>
