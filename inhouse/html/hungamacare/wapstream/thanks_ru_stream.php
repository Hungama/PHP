<?php
	include('/usr/local/apache/htdocs/hungamawap/new_functions.php3');

	if($browser_support_id != 172)
		header("location: http://202.87.41.147/hungamawap/hungama/216288/W_thanks_ru.php3");

	$zone_id = 216288;
	$zone_name = "Index_RU";
	$page_id = 90838;
	$page_name = "thanks_ru";
	$cl_fol = "hungama";

	visitor_log($msisdn,$model,$Remote_add,$zone_id,$client_id,$page_id,0,$page_id);

	include('/usr/local/apache/htdocs/hungamawap/zone_exceptions.php3');

	include "/usr/local/apache/htdocs/vodafone/template/xhtml_head.php3";

	include "/usr/local/apache/htdocs/hungamawap/hungama/template/xhtml_head_newUI.php3";

	//some handsets do not support 100% width for tables thereby leading to side scroll
	//array defined in template/xhtml_head.php3
	if(in_array($Hkey, $arr_hs_ns_100_width))
		$table_attrib = " cellpadding='0' cellspacing='0' border='0' ";
	else
		$table_attrib = " cellpadding='0' cellspacing='0' border='0' width='100%' ";

$arr_logo_wd=array(91=>110,110=>110,118=>120,120=>120,165=>165,166=>165,198=>210,180=>210,210=>210,230=>230,240=>240,250=>250,280=>280,295=>295,310=>320,320=>320,342=>360,360=>360,352=>480,480=>480,515=>515,630=>640,640=>640,800=>800);
if(!$logo_wd)
 $logo_wd=91; 
$logo_wd=$arr_logo_wd[$logo_wd];
$logo_wd=$logo_wd;
?>
<body>
<table <?=$table_attrib?>>
<tr>	<td colspan="3" height="18" align="left" valign="middle">
		<table cellpadding="0" cellspacing="0"  width="100%" ><tr><td height="1"></td></tr></table>
		<table cellpadding="2" cellspacing="0" bgcolor="#cccccc" style="border-top:solid 1px red;text-align:center;" width="100%">
			<tr><td align="center"><a href='http://live.vodafone.in/vodafonelive/home/hp/default.aspx'>Home</a> | <a href='http://live.vodafone.in/vodafonelive/menu/menulist/default.aspx'>Menu</a> | <a  href='http://10.11.233.29/vodafone/61214/feedback.php3'>Feedback</a></td></tr>
		</table></td></tr>

<tr>
	<td align="left" valign="middle" colspan="3" bgcolor="" <? if(!in_array($Hkey, $arr_hs_no_height)) echo "height='".$ho."'";?> class='head_arial9'><img src='http://202.87.41.147/hungamawap/hungama/216288/thanks_ru/493701.gif' alt='*'/><br></td>
</tr>

<tr>
	<td align="left" valign="middle" colspan="3" bgcolor="" <? if(!in_array($Hkey, $arr_hs_no_height)) echo "height='".$ho."'";?> class='head_arial9'><font color="">&nbsp;Thank you For subscribing Vodafone Radio Unlimited</font><br></td>
</tr>

<tr>	<td colspan="3" height="18" align="left" valign="middle">
		<table cellpadding="0" cellspacing="0"  width="100%" ><tr><td height="1"></td></tr></table>
		<table cellpadding="2" cellspacing="0" bgcolor="#cccccc" style="border-top:solid 1px red;text-align:center;" width="100%">
			<tr><td align="center"><a href='http://live.vodafone.in/vodafonelive/home/hp/default.aspx'>Home</a> | <a href='http://live.vodafone.in/vodafonelive/menu/menulist/default.aspx'>Menu</a> | <a  href='http://10.11.233.29/vodafone/61214/feedback.php3'>Feedback</a></td></tr>
		</table></td></tr>
</table>
</body>
</html>
