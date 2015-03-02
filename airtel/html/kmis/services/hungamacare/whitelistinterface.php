<?php
ob_start();
session_start();
include("config/dbConnect.php");
$rest = substr($service_info,0,-2);

$logoPath='images/logo.png';
	
include ("header.php");

$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP West','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP East','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh');

$user_id=$_SESSION['usrId'];
if(!$user_id) $user_id=$_REQUEST['usrId'];

if($user_id)
{ ?>
<html>
<head><title>Whitelist Interface: Airtel</title>
<script type="text/javascript">

function logout()
{
window.parent.location.href = 'index.php?logerr=logout';
}

function ShowItem()
{
	var Index = document.getElementById("dnis").value;
	var mySplitResult = Index.split("-");
    document.getElementById("lc").value = mySplitResult[1];
 }  

 function validateForm()
{	
	if((checkService(document.getElementById("service").value) )&&(checkCircle(document.getElementById("circle").value) )&&(checkPhone(document.getElementById("ani").value,'error'))&&(checkDnis(document.getElementById("dnis").value) ))
	{
		   getfield();
		   return false;
	}
	else
	{
		return false;
	}
}
function getfield()
{
	var service=document.getElementById('service').value;
	var circle=document.getElementById('circle').value;
	var msisdn=document.getElementById('ani').value;
	var dnis=document.getElementById('dnis').value;
	var operator=document.getElementById('operator').value;
	var action='active';
	var serviceName = document.getElementById('service')[document.getElementById('service').selectedIndex].innerHTML;
	MakeRequest(service,circle,msisdn,dnis,action,operator,serviceName);
}

function MakeRequest(service,circle,msisdn,dnis,action,operator,serviceName) {
	var xmlHttp = getXMLHttp();
	xmlHttp.onreadystatechange = function()
	{
		if(xmlHttp.readyState == 4) { 
		  HandleResponse(xmlHttp.responseText,action);
		}
	}

	var queryString = "list.php?service="+service+"&circle="+circle+"&msisdn="+msisdn+"&dnis="+dnis+"&action=getRecord&operator="+operator+"&sN="+serviceName;	
	xmlHttp.open("GET", queryString, true);
	xmlHttp.send(null);
}

function getXMLHttp()
{
  var xmlHttp

  try {
    //Firefox, Opera 8.0+, Safari
    xmlHttp = new XMLHttpRequest();
  } catch(e) {
    //Internet Explorer
    try {
      xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
    } catch(e) {
      try {
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
      } catch(e) {
        alert("Your browser does not support AJAX!");
        return false;
      }
    }
  }
  return xmlHttp;
}

function HandleResponse(response,action)
{
	var responseValue=response.split("-");
	//alert(response);	
	/*if(responseValue[0]=='already exits') {			
		var r=confirm(" You are already Subscribed.Do you want to continue?");
		if (r==true) {
			window.location = "http://10.2.73.156/kmis/services/hungamacare/list.php?action=updateRecord&msisdn="+responseValue[1]+"&Scode="+ responseValue[2]+"&Lcode="+ responseValue[3]+"&operator="+responseValue[4]+"&service="+responseValue[5]+"&circle="+responseValue[6]
		} else {
			alert("user not updated");
		}		
	} else if(response=='done') {
		alert('user created successfullly');
	}*/		
} 

function checkService(field)  {      
	if (field =='0')  {
		alert('please select a service');
		return false;
	} else {
		return true;
	}
}

function checkCircle(field) {      
	if (field =='0') {
		alert('please select a circle');
		return false;
	} else {
		return true;
	}
}

function checkDnis(field) {      
	if (field =='0- ') {
		alert('please select a dnis');
		return false;
   } else {
		return true;
   }	
}

function checkPhone(field, errorMsg) 
{
	phoneRegex = "^0{0,1}[1-9]{1}[0-9]{2}[\s]{0,1}[\-]{0,1}[\s]{0,1}[0-9]{1}[0-9]{6}$";
	/*if (field.match(phoneRegex)) {
		return true;
	} else {
		alert('Please Enter 10 Digit Number');
		return false;
	}*/
	return true;
}

function getDnis()
{
	var xmlhttp;
	var service=document.getElementById('service').value;
	if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} else {// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		 //alert(xmlhttp.responseText);
		document.getElementById("dnis1").innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET","list.php?action=getDnis&service1="+service,true);
	xmlhttp.send();
}

function show_prompt() {
	var name=prompt("Please enter your name","Harry Potter");
	if (name!=null && name!="") {
		document.write("<p>Hello " + name + "! How are you today?</p>");
	}
}
</script>
</head>
<body>
<?php
$operator='airtel';
$query1="select count(*) from master_db.tbl_service_master where operator='".$operator."'";
$queryresult1=mysql_query($query1);
$row1= mysql_fetch_row($queryresult1);

$query="select service_id, service_name from master_db.tbl_service_master where operator='".$operator."'";
$queryresult=mysql_query($query);
for($i=0;$i<$row1[0];$i++)
{
	$row[$i]= mysql_fetch_array($queryresult);
}
 
// print_r($row);
mysql_close($dbConn);
?>
<div id='res'></div>
<table align ='center'>
	<tr>
		<td align='right' colspan='2'><a href="status.php"><font color='red' size='2'>Show Status</font></a></td>
	 </tr>
</table>

<form name='whitlistinterface' method='POST' action='list.php'  onsubmit="return validateForm();">
	<table align='center' border='2'>
		<tr>
			<td align ='center' ><font size='2' >Service</font></td>
			<td><select name="service" id="service" onchange="javascript:getDnis();">
			<option value='0'>Select Service</option>
			<?php for($k=0;$k<$row1[0];$k++) {?>
			<option value='<?php echo $row[$k]['service_id'] ?>'><?php echo $row[$k]['service_name'] ?></option>
			<?php } ?>
			</select></td>
		</tr>
		<tr>
			<td align ='center' ><font size='2' >Circle</font></td>
			<td><select name="circle" id="circle">
			<option value='0'>Select Circle</option>
			<option value='PAN'>All</option>
			<?php foreach($circle_info as $key=>$value) {?>
			<option value='<?php echo $key ?>'><?php echo $circle_info[$key]  ?></option>
			<?php }?>
			</select></td>
		</tr>
		<tr>
			<td align ='center' ><font size='2' >MDN</font></td>
			<td><input type='text' name='ani' id='ani' value=""></td>
		</tr>
		<tr>
			<td align ='center' ><font size='2' >DNIS</font></td>
			<td id='dnis1'>Select Service</td>
		</tr>
		<tr>
			<input type='hidden'  id='operator' value="<?php  echo $operator;?>">
			<td align ='center' ><font size='2' >LongCode</font></td>
			<td><input type='text' name='longcode'  id="lc" readonly></td>
		</tr>
		<tr>
			<td colspan='3' align ='center' ><input type="submit"  value="submit"  name="submit" > </td>
		</tr>
	</table>
</form>

</body>
</html>
<?php } ?>