<?php 
include("session.php");
error_reporting(0);
//include database connection file
include("db.php");
//$operatorlist=array('docomo','reliance','uninor','Indicom','Etislat');
$operatorlist=array('docomo'=>'10','reliance'=>'12','uninor'=>'14','Indicom'=>'16');
//Uninor: 8546048759,Tata Indicom :- 9200337880,tatadocomo :- 8109249272,Reliance :-     9883095103,MTS:- 8459078905,Vodafone MDN=’9953998989’,Airtel :9910040744 
$mdnOpreatorArray=array('uninor'=>'8546048759','Indicom'=>'9200337880','docomo'=>'8109249272','reliance'=>'9883095103','mts'=>'8459078905','vodafone'=>'9953998989','airtel'=>'9910040744');
/*foreach ($mdnOpreatorArray as $k1 => $v1)
{
}*/
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>Admin</title>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<style media="all" type="text/css">@import "css/all.css";</style>
	<script type="text/javascript" src="js/ajax-data.js"></script>
	<script language="javascript" type="text/javascript" src="datetimepicker/datetimepicker.js"></script>

</head>
<body>
<div id="main">
	<div id="header">
		<a href="index.html" class="logo"><img src="img/Hlogo.png" width="282" height="80" alt=""/></a>
		<!--ul id="top-navigation">
			<li class="active"><span><span>Home</span></span></li>
		</ul-->
	</div>
	<div id="middle">
		<div id="left-column">
			<?php include('left-sidebar.php');?>
			</div>
		<div id="center-column">
			<div class="top-bar">
				<!--h1>Upload OBT Data---Please don't use this file right now..it's under process..</h1-->
				<h1>Admin-Home</h1>
				
				</div><br />
		  <div class="select-bar">
		    <?php echo $_REQUEST[msg];?>
			</div>
			 <div class="table">
				
				<img src="img/bg-th-left.gif" width="8" height="7" alt="" class="left" />
				<img src="img/bg-th-right.gif" width="7" height="7" alt="" class="right" />

				<form name="obd_up_form" method="post" action="#">
				<table class="listing form" cellpadding="0" cellspacing="0">
					<tr>
						<th class="full" colspan="2">&nbsp;</th>
					</tr>
			<tr class="bg">

				<td class="first"><strong>Please select Operator<span style="color:red">&nbsp;*</span></strong></td>
						<td class="last">
                       <select name="obd_form_operator" id="obd_form_operator" onchange="getServicesinfo(this.value,'op')">
					   <option value="">Select operator</option>
					<?php
						foreach($operatorlist as $operator=> $value) 
							{
							echo "<option value=\"$value\">$operator</option>";
							}
					?>
						</select>
						</td>
					</tr>
					<tr class="bg">
						<td class="first"><strong>Please select Service<span style="color:red">&nbsp;*</span></strong></td>
						<td class="last">
						<select name="service_info" id="obd_form_service" onchange="getServicesinfo(this.value,'pp')">
                        </select>
						</td>
					</tr>
					<tr class="bg">
						<td class="first"><strong>Please select Price Point</strong></td>
						<td class="last">
                       <select name="obd_form_pricepoint" id="obd_form_pricepoint" onchange="getPlannfo(this.value)" disabled='true'>
						</select>
						<!--span id="planid_dd"></span-->
						<span id="pricepoint_dd"></span>
						</td>
					</tr>
					<!--tr>
						<td class="first" width="172"><strong>Amount<span style="color:red">&nbsp;*</span></strong></td>
						<td class="last"><input type="hidden"  name="obd_form_amount" id="obd_form_amount" readonly="true"/></td>
					</tr-->
					<tr class="bg">
						<td class="first"><strong>Please select MSISDN<span style="color:red">&nbsp;*</span></strong></td>
						<td class="last">
                       <select name="msisdn" id="msisdn">
						<!--option value="">Please select MDN</option>
						<option value="7417099724">7417099724</option-->
					</select>
					<!--input type="text"  name="msisdn" id="msisdn" readonly="true"/-->
						<input type="hidden"  name="obd_form_amount" id="obd_form_amount" readonly="true"/>
						</td>
					</tr>
					<tr class="bg">
						<td class="first"><strong></strong></td>
						<td class="last">
					<input type="button" name="getstatus_btn" id="getstatus_btn" value="Get Status" onclick="getMdnStatus()" style="color: #FFF;background-color: #900;font-weight:bold;"/>&nbsp;&nbsp;
					<!--input type="button" name="subscribe_btn" id="subscribe_btn" value="Subscribe"/-->
					<div id="showinfo" style="text-align:center;width:100%;font-weight:normal;color:#ffffff;font-size:12px"></div>
					</td>
					</tr>
					</table>
					</form>
	        <span id="show_status"></span>
		  </div>
		</div>
		<!--div id="right-column">
			<strong class="h">INFO</strong>
			<div class="box">Information for Uninor</div>
	  </div-->
	</div>
	<div id="footer"></div>
</div>


</body>
</html>