<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php
error_reporting(1);
include ("db.php");
$prevdate = date("Y-m-d", time() - 60 * 60 * 24);
$prevdate_email = date("Y-m-d", time() - 60 * 60 * 24);
//total count


$serviceArray=array('AircelMC'=>'Aircel - Music Connect','AircelMU'=>'Aircel - Limitless Music','AircelStore'=>'Aircel Store', 'BSNL'=>'BSNL Store', 'TataDoCoMoADT'=>'Docomo Store', 'TataDoCoMoMND'=>'Tata DoCoMo - Pyaar Ke Panne','TataDoCoMoMX'=>'Tata DoCoMo - Endless Music','VodafoneMU'=>'Vodafone - Radio Unlimited'
        ,'TataDoCoMoCrbt'=>'Docomo Crbt','TataDoCoMo54646'=>'Tata DoCoMo 54646');


$gettotalcountdatasql=mysql_query("select count(1) as total,service,affiliateid from misdata.tbl_browsing_wap nolock where date(datetime)='$prevdate' and service not in('AirtelDevo','UninorMyMusic','UninorSU','WAP') and affiliateid!=0
and char_length(affiliateid) = 4 group by service,affiliateid order by service",$con);
//begin of HTML message
$AircelMC=array();
$AircelMU=array();
$AircelStore=array();
$BSNL=array();
$TataDoCoMoADT=array();
$TataDoCoMoMND=array();
$TataDoCoMoMX=array();
$VodafoneMU=array();
$TataDoCoMoCrbt=array();
$TataDoCoMo54646=array();


while($result=mysql_fetch_array($gettotalcountdatasql))
{
 $sname=$result['service'];
if($sname=='AircelMC')
{
    $AircelMC[$result['affiliateid']]=$result[total];
}

elseif($sname=='AircelMU')
{
    $AircelMU[$result['affiliateid']]=$result[total];
}
 elseif($sname=='AircelStore')
{
    $AircelStore[$result['affiliateid']]=$result[total];
}  
elseif($sname=='BSNL')
{
    $BSNL[$result['affiliateid']]=$result[total];
}
elseif($sname=='TataDoCoMoADT')
{
    $TataDoCoMoADT[$result['affiliateid']]=$result[total];
}
elseif($sname=='TataDoCoMoMND')
{
    $TataDoCoMoMND[$result['affiliateid']]=$result[total];
}
elseif($sname=='TataDoCoMoMX')
{
    $TataDoCoMoMX[$result['affiliateid']]=$result[total];
}

elseif($sname=='VodafoneMU')
{
    $VodafoneMU[$result['affiliateid']]=$result[total];
}

elseif($sname=='TataDoCoMoCrbt')
{
    $TataDoCoMoCrbt[$result['affiliateid']]=$result[total];
}
elseif($sname=='TataDoCoMo54646')
{
    $TataDoCoMo54646[$result['affiliateid']]=$result[total];
}



}


$message = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">';
$message .= "<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
			</head><body>";
$message .= '<table border="1" cellspacing="0" cellpadding="2" style="font-family: Century Gothic, Arial">';
 $message .= "<tr><td colspan='3' align='center' >Waplog Report Affilaited Id Count</td></tr>";
 
$message .= '<tr><td  valign="middle" bgcolor="#FFFFFF" style="border-bottom: 1px solid #666; border-right: 1px solid #666; border-top: 1px solid #666;border-left: 1px solid #666"><strong>Service Name</strong> </td><td valign="middle" bgcolor="#FFFFFF" style="border-bottom: 1px solid #666; border-right: 1px solid #666; border-top: 1px solid #666;border-left: 1px solid #666"><strong>Affiliated Id</strong> </td><td valign="middle" bgcolor="#FFFFFF" style="border-bottom: 1px solid #666; border-right: 1px solid #666; border-top: 1px solid #666;border-left: 1px solid #666"><strong>Total Count</strong> </td></tr>';

$count=count($AircelMC);
if($count>1)
{
    $message .= "<tr style='background: #f2f2f2;'> <td ><strong>".$serviceArray['AircelMC']."</strong> </td><td colspan='2'><table style='border-color: #fffff;' border='0' width='100%' cellpadding='10'>";
    foreach($AircelMC as $key=>$value)
    {
$message .= "<tr><td><strong>".$key."</strong> </td><td style='text-align:right'><strong>".$value."</strong> </td></tr>";
        
    }
    $message .="</table></td></tr>";
}
else
{
foreach($AircelMC as $key=>$value)
    {
$message .= "<tr style='background: #f2f2f2;'><td><strong>".$serviceArray['AircelMC']."</strong></td><td><strong>".$key."</strong> </td><td style='text-align:right'><strong>".$value."</strong> </td></tr>";
        
    }
}

//aircelimu

$count=count($AircelMU);
if($count>1)
{
    $message .= "<tr style='background: #ADD8E6;'> <td ><strong>".$serviceArray['AircelMU']."</strong> </td><td colspan='2'><table style='border-color: #fffff;' border='0' width='100%' cellpadding='10'>";
    foreach($AircelMU as $key=>$value)
    {
$message .= "<tr><td><strong>".$key."</strong> </td><td style='text-align:right'><strong>".$value."</strong> </td></tr>";
        
    }
    $message .="</table></td></tr>";
}
else
{
foreach($AircelMU as $key=>$value)
    {
$message .= "<tr style='background: #ADD8E6;'><td><strong>".$serviceArray['AircelMU']."</strong></td><td><strong>".$key."</strong> </td><td style='text-align:right'><strong>".$value."</strong> </td></tr>";
        
    }
}
//$AircelStore
$count=count($AircelStore);
if($count>1)
{
    $message .= "<tr style='background: #f2f2f2;'> <td ><strong>".$serviceArray['AircelStore']."</strong> </td><td colspan='2'><table style='border-color: #fffff;' border='0' width='100%' cellpadding='10'>";
    foreach($AircelStore as $key=>$value)
    {
$message .= "<tr><td><strong>".$key."</strong> </td><td style='text-align:right'><strong>".$value."</strong> </td></tr>";
        
    }
    $message .="</table></td></tr>";
}
else
{
foreach($AircelStore as $key=>$value)
    {
$message .= "<tr style='background: #f2f2f2;'><td><strong>".$serviceArray['AircelStore']."</strong></td><td><strong>".$key."</strong> </td><td style='text-align:right'><strong>".$value."</strong> </td></tr>";
        
    }
}


//BSNL
$count=count($BSNL);
if($count>1)
{
    $message .= "<tr style='background: #ADD8E6;'> <td ><strong>".$serviceArray['BSNL']."</strong> </td><td colspan='2'><table style='border-color: #fffff;' border='0' width='100%' cellpadding='10'>";
    foreach($BSNL as $key=>$value)
    {
$message .= "<tr><td><strong>".$key."</strong> </td><td style='text-align:right'><strong>".$value."</strong> </td></tr>";
        
    }
    $message .="</table></td></tr>";
}

else
{
foreach($BSNL as $key=>$value)
    {
$message .= "<tr style='background: #ADD8E6;'><td><strong>".$serviceArray['BSNL']."</strong></td><td><strong>".$key."</strong> </td><td style='text-align:right'><strong>".$value."</strong> </td></tr>";
        
    }
}

//

//TataDoCoMoMND
$count=count($TataDoCoMoMND);
if($count>1)
{
    $message .= "<tr style='background: #f2f2f2;'> <td ><strong>".$serviceArray['TataDoCoMoMND']."</strong> </td><td colspan='2'><table style='border-color: #fffff;' border='0' width='100%' cellpadding='10'>";
    foreach($TataDoCoMoMND as $key=>$value)
    {
$message .= "<tr><td><strong>".$key."</strong> </td><td style='text-align:right'><strong>".$value."</strong> </td></tr>";
        
    }
    $message .="</table></td></tr>";
}
else
{
foreach($TataDoCoMoMND as $key=>$value)
    {
$message .= "<tr style='background: #f2f2f2;'><td><strong>".$serviceArray['TataDoCoMoMND']."</strong></td><td><strong>".$key."</strong> </td><td style='text-align:right'><strong>".$value."</strong> </td></tr>";
        
    }
}

//TataDoCoMoADT
$count=count($TataDoCoMoADT);
if($count>1)
{
    $message .= "<tr style='background: #ADD8E6;'> <td ><strong>".$serviceArray['TataDoCoMoADT']."</strong> </td><td colspan='2'><table style='border-color: #fffff;' border='0' width='100%' cellpadding='10'>";
    foreach($TataDoCoMoADT as $key=>$value)
    {
$message .= "<tr><td><strong>".$key."</strong> </td><td style='text-align:right'><strong>".$value."</strong> </td></tr>";
        
    }
    $message .="</table></td></tr>";
}
else
{
foreach($TataDoCoMoADT as $key=>$value)
    {
$message .= "<tr style='background: #ADD8E6;'><td><strong>".$serviceArray['TataDoCoMoADT']."</strong></td><td><strong>".$key."</strong> </td><td style='text-align:right'><strong>".$value."</strong> </td></tr>";
        
    }
}

//TataDoCoMoMx
$count=count($TataDoCoMoMX);
if($count>1)
{
    $message .= "<tr style='background: #f2f2f2;'> <td ><strong>".$serviceArray['TataDoCoMoMX']."</strong> </td><td colspan='2'><table style='border-color: #fffff;' border='0' width='100%' cellpadding='10'>";
    foreach($TataDoCoMoMX as $key=>$value)
    {
$message .= "<tr><td><strong>".$key."</strong> </td><td style='text-align:right'><strong>".$value."</strong> </td></tr>";
        
    }
    $message .="</table></td></tr>";
}
else
{
foreach($TataDoCoMoMX as $key=>$value)
    {
$message .= "<tr style='background: #f2f2f2;'><td><strong>".$serviceArray['TataDoCoMoMX']."</strong></td><td><strong>".$key."</strong> </td><td style='text-align:right'><strong>".$value."</strong> </td></tr>";
        
    }
}


//VodaphoneMu
$count=count($VodafoneMU);
if($count>1)
{
    $message .= "<tr style='background: #ADD8E6;'> <td ><strong>".$serviceArray['VodafoneMU']."</strong> </td><td colspan='2'><table style='border-color: #fffff;' border='0' width='100%' cellpadding='10'>";
    foreach($VodafoneMU as $key=>$value)
    {
$message .= "<tr><td><strong>".$key."</strong> </td><td style='text-align:right'><strong>".$value."</strong> </td></tr>";
        
    }
    $message .="</table></td></tr>";
}
else
{
foreach($VodafoneMU as $key=>$value)
    {
$message .= "<tr style='background: #ADD8E6;'><td><strong>".$serviceArray['VodafoneMU']."</strong></td><td><strong>".$key."</strong> </td><td style='text-align:right'><strong>".$value."</strong> </td></tr>";
        
    }
}



// Tatadocomo Crbt
$count=count($TataDoCoMoCrbt);
if($count>1)
{
    $message .= "<tr style='background: #ADD8E6;'> <td ><strong>".$serviceArray['TataDoCoMoCrbt']."</strong> </td><td colspan='2'><table style='border-color: #fffff;' border='0' width='100%' cellpadding='10'>";
    foreach($TataDoCoMoCrbt as $key=>$value)
    {
$message .= "<tr><td><strong>".$key."</strong> </td><td style='text-align:right'><strong>".$value."</strong> </td></tr>";
        
    }
    $message .="</table></td></tr>";
}
else
{
foreach($TataDoCoMoCrbt as $key=>$value)
    {
$message .= "<tr style='background: #ADD8E6;'><td><strong>".$serviceArray['TataDoCoMoCrbt']."</strong></td><td><strong>".$key."</strong> </td><td style='text-align:right'><strong>".$value."</strong> </td></tr>";
        
    }
}



// TataDoCoMo54646
$count=count($TataDoCoMo54646);
if($count>1)
{
    $message .= "<tr style='background: #ADD8E6;'> <td ><strong>".$serviceArray['TataDoCoMo54646']."</strong> </td><td colspan='2'><table style='border-color: #fffff;' border='0' width='100%' cellpadding='10'>";
    foreach($TataDoCoMo54646 as $key=>$value)
    {
$message .= "<tr><td><strong>".$key."</strong> </td><td style='text-align:right'><strong>".$value."</strong> </td></tr>";
        
    }
    $message .="</table></td></tr>";
}
else
{
foreach($TataDoCoMo54646 as $key=>$value)
    {
$message .= "<tr style='background: #ADD8E6;'><td><strong>".$serviceArray['TataDoCoMo54646']."</strong></td><td><strong>".$key."</strong> </td><td style='text-align:right'><strong>".$value."</strong> </td></tr>";
        
    }
}




$message .= "</table>";

$message .= "</body></html>";
echo $message;
$htmlfilename = 'emailcontentafid_' . date('Y_m_d') . '.html';
$file = fopen($htmlfilename, "w");
fwrite($file, $message);
fclose($file);
mysql_close($con);
?>