<?php 
session_start();
include('/var/www/html/kmis/services/hungamacare/config/dbConnect.php');
if($_SESSION['authid']) { 
	include('header.php'); ?>
<script type="text/javascript">

function ShowItem() {
	var Index = document.getElementById("dnis");
	//if(!Index) Index = document.getElementById("dnis1");
	var mySplitResult = Index.value.split("-");
	document.getElementById("lc").value = mySplitResult[1];
} 

function ShowItem1() {
	var Index = document.getElementById("dnis1");
	//if(!Index) Index = document.getElementById("dnis1");
	var mySplitResult = Index.value.split("-");
	document.getElementById("lc").value = mySplitResult[1];
} 

function validateForm() {
	if((checkService(document.getElementById("operator").value))&&(checkPhone(document.getElementById("ani").value,'error')))
	{
		getfield();
		return false;
	} else {
		return false;
	}
}

function getfield() {
	var operator=document.getElementById('operator').value;
	if(operator == 'tatm') var service=document.getElementById('service').value;
	else if(operator == 'unim') var service=document.getElementById('service1').value;

	if(operator == 'tatm') var circle=document.getElementById('circle1').value;
	else if(operator == 'unim') var circle=document.getElementById('circle2').value;

	if(operator == 'tatm') var dnis=document.getElementById('dnis1').value;
	else if(operator == 'unim') var dnis=document.getElementById('dnis').value;

	var msisdn=document.getElementById('ani').value;
	//var dnis=document.getElementById('dnis').value;	
	var action='active';
	//alert(service+","+circle+","+msisdn+","+dnis+","+action+","+operator); return false;
	MakeRequest(service,circle,msisdn,dnis,action,operator);
}

function MakeRequest(service,circle,msisdn,dnis,action,operator) {
	var xmlHttp = getXMLHttp();
	xmlHttp.onreadystatechange = function() {
		if(xmlHttp.readyState == 4) {
			HandleResponse(xmlHttp.responseText,action);
		}
	}

	var queryString = "list.php?service="+service+"&circle="+circle+"&msisdn="+msisdn+"&dnis="+dnis+"&case=insert&op="+operator;	
	//alert(queryString); return false;
	xmlHttp.open("GET", queryString, true);
	xmlHttp.send(null);
}

function getXMLHttp()
{
  var xmlHttp
  try
  {
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
	if(responseValue[0]=='already exits') {
		alert('User is already Creadted for the Given service ');		
	} else {
		if(response=='done')
			alert('user created successfullly');
	}
}

function checkService(field)  {      
	if (field =='0')  {
		alert('please select a service');
		return false;
	} else {
		return true;
	}
}

function checkCircle(field)  {      
	if (field =='0')  {
		alert('please select a circle');
		return false;
	} else {
		return true;
	}
}

function checkDnis(field) 
{      
	if (field =='0- ') {
		alert('please select a dnis');
		return false;
	} else {
		return true;
	}
}

function checkPhone(field, errorMsg) 
{
	phoneRegex = "^0{0,1}[1-9]{1}[0-9]{2}[\s]{0,1}[\-]{0,1}[\s]{0,1}[1-9]{1}[0-9]{6}$";
	return true;
	//alert(isnumeric(field));
	/*if (field.match(phoneRegex)) {
		return true;
	} else {
		alert('Please Enter 10 Digit Number');
		return false;
	}*/
}

function ShowService(service) {
	if(service == 'tatm') {
		document.getElementById('service1').style.display='none';
		document.getElementById('service').style.display='block';
		document.getElementById('circle1').style.display='block';
		document.getElementById('circle2').style.display='none';
		document.getElementById('dnis1').style.display='block';
		document.getElementById('dnis').style.display='none';
	} else if(service == 'unim') { 
		document.getElementById('service').style.display='none';
		document.getElementById('service1').style.display='block';
		document.getElementById('circle1').style.display='none';
		document.getElementById('circle2').style.display='block';
		//document.getElementById('dnis').style.display='block';
		//document.getElementById('dnis1').style.display='none';		
	}	
}

function showdnis(sid) {
	var xmlhttp;
	if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	} else { // code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			document.getElementById("newDnis").innerHTML='';
			document.getElementById("newDnis").innerHTML=xmlhttp.responseText;
	    }
	}
	
	var queryString = "list.php?sId="+sid+"&case=dnis";	
	//alert(queryString); //return false;
	xmlhttp.open("GET", queryString, true);
	xmlhttp.send();
}
</script>

<body>
<?php
//$operator=$_GET['operator'];
echo "<pre>";
// docomo service
$query1="select service_id, service_name from master_db.tbl_service_master where substr(service_id,1,2)=10";
$queryresult1=mysql_query($query1);
while($row= mysql_fetch_array($queryresult1)) {
	$sid = $row['service_id'];
	$docomoService[$sid]=$row['service_name'];
}

// uninor service
$query12="select service_id, service_name from master_db.tbl_service_master where service_id IN ('1402','1409','1412','1410','1416','1403')";
$queryresult12=mysql_query($query12);
while($row2= mysql_fetch_array($queryresult12)) {
	$sid = $row2['service_id'];
	$uninorService[$sid]=$row2['service_name'];
}

$circle=array('gujarat'=>'GUJ'); 

$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAR'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh',''=>'Other','HAY'=>'Haryana');
?>
<form name='whitlistinterface'  method='POST' action='list.php'  onsubmit="return validateForm();">
<table align='center' border='2' width='30%'>
<tr>
<td>&nbsp;&nbsp;<B>Operator</B></td>
<td><select name="operator" id="operator" onchange="ShowService(this.value);">
		<option value='0'>Select Operator</option>
		<!--<option value='tatm'>Tata Docomo</option>-->
		<option value='unim'>Uninor</option>
	</select></td>
</tr>
<tr>
<td>&nbsp;&nbsp;<B>Service</B></td>
<td><select name="service" id="service" style='display:block;' onchange='showdnis(this.value);'>
		<option value='0'>Select Service</option>
		<?php foreach($docomoService as $key1=>$value1) {?>
		<option value='<?php echo $key1; ?>'><?php echo $value1; ?></option>
		<?php } ?>
      </select><select name="service1" id="service1" style='display:none;' onchange='showdnis(this.value);'>
		<option value='0'>Select Service</option>
		<?php foreach($uninorService as $key=>$value) {?>
		<option value='<?php echo $key; ?>'><?php echo $value; ?></option>
		<?php } ?>
      </select></td>
</tr>
<tr>
<td>&nbsp;&nbsp;<B>Circle</B></td>
<td><select name="circle1" id="circle1" style='display:block;'>
	<option value='0'>Select Circle</option>
	<option value='PAN'>All</option>
	<?php foreach($circle as $key=>$value) {?>
		<option value='<?php echo $value ?>'><?php echo $key ?></option>
	<?php } ?>
	</select><select name="circle2" id="circle2" style='display:none;'>
	<option value='0'>Select Circle</option>
	<?php foreach($circle_info as $key2=>$value2) {?>
		<option value='<?php echo $key2; ?>'><?php echo $value2; ?></option>
	<?php } ?>
	</select></td>
</tr>
<tr>
	<td>&nbsp;&nbsp;<B>MDN</B></td>
	<td><input type='text' name='ani' id='ani' value="" maxlength='10'></td>
</tr>
<tr>
<td>&nbsp;&nbsp;<B>DNIS</B></td>
<td><div id='newDnis'><select name="shortcode" id="dnis" onchange="ShowItem()" style='display:block;'>
		<option value='0- '>Select DNIS</option>
		<?php for($k=0;$k<$row3[0];$k++) {
			$dnisValue=$row4[$k]['DNIS']."-".$row4[$k]['LongCode']; ?>
		<option value='<?php echo $dnisValue ?>'><?php echo $row4[$k]['DNIS'] ?></option>
		<?php }  ?>
	</select>
	</div></td>
</tr>
<tr>
<td>&nbsp;&nbsp;<B>LongCode</B></td>
<td><input type='text' name='longcode'  id="lc" readonly></td>
</tr>
<tr>
<td colspan='3' align ='center' ><input type="submit"  value="submit"  name="submit" </td>
</tr>
</table>
</body>
</html>
<?php } else {
	$redirect = "index.php?logerr=invalid";
	header("Location: $redirect");
} ?>