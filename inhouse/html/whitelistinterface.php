<html>
<head>
<script type="text/javascript">

function ShowItem()
{
  var Index = document.getElementById("dnis");
  var mySplitResult = Index.value.split("-");
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
	var action='active';
	MakeRequest(service,circle,msisdn,dnis,action);
}

function MakeRequest(service,circle,msisdn,dnis,action)
{
  var xmlHttp = getXMLHttp();
  xmlHttp.onreadystatechange = function()
  {
    if(xmlHttp.readyState == 4)
    {
      HandleResponse(xmlHttp.responseText,action);
    }
  }

var queryString = "?service="+service+"&circle="+circle+"&msisdn="+msisdn+"&dnis="+dnis;
	
	xmlHttp.open("GET", "list.php"+queryString, true);
	xmlHttp.send(null);
}

function getXMLHttp()
{
  var xmlHttp

  try
  {
    //Firefox, Opera 8.0+, Safari
    xmlHttp = new XMLHttpRequest();
  }
  catch(e)
  {
    //Internet Explorer
    try
    {
      xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
    }
    catch(e)
    {
      try
      {
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
      }
      catch(e)
      {
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
	if(responseValue[0]=='already exits')
	{
		alert('User is already Creadted for the Given service ');		
	}
	else
	{
		if(response=='done')
			alert('user created successfullly');
	}
}

function checkService(field) 
{      
		  if (field =='0') 
	{
			alert('please select a service');
			return false;
	 }
	else 
	{
		return true;
	}
}
function checkCircle(field) 
{      
		  if (field =='0') 
	{
			alert('please select a circle');
			return false;
	 }
	else 
	{
		return true;
	}
}
function checkDnis(field) 
{      
		  if (field =='0- ') 
	{
			alert('please select a dnis');
			return false;
	 }
	else 
	{
		return true;
	}
}
function checkPhone(field, errorMsg) 
{
	  phoneRegex = "^0{0,1}[1-9]{1}[0-9]{2}[\s]{0,1}[\-]{0,1}[\s]{0,1}[1-9]{1}[0-9]{6}$";
	 if (field.match(phoneRegex)) 
	{
			return true;
	 }
	else 
	{
		alert('Please Enter 10 Digit Number');
		return false;
	}
}

</script>
</head>
<body>
<?php
include_once '/var/www/html/kmis/services/hungamacare/config/dbConnect.php';
//$operator=$_GET['operator'];
echo "<pre>";
$query1="select count(*) from tbl_service_master where operator='docomo' ";
$queryresult1=mysql_query($query1);
$row1= mysql_fetch_row($queryresult1);
$query="select service_id, service_name from tbl_service_master where operator='docomo' ";
$queryresult=mysql_query($query);
for($i=0;$i<$row1[0];$i++)
{
	$row[$i]= mysql_fetch_array($queryresult);
 }
$circle=array('gujarat'=>'GUJ'); 
$query3="select count(*) from tbl_operator_dnis where operator='docomo' ";
$queryresult3=mysql_query($query3);
$row3= mysql_fetch_row($queryresult3);

$query4="select DNIS,LongCode from tbl_operator_dnis where operator='docomo' ";
$queryresult4=mysql_query($query4);
for($i=0;$i<$row3[0];$i++)
{
	$row4[$i]= mysql_fetch_array($queryresult4);
 }
?>
<form name='whitlistinterface'  method='POST' action='list.php'  onsubmit="return validateForm();">
<table align='center' border='2'>
<tr>
<td align ='center' ><font >Service</font></td>
<td><select name="service" id="service">
		<option value='0'>Select Service</option>
		<?php for($k=0;$k<$row1[0];$k++)
		{?>
		<option value='<?php echo $row[$k]['service_id'] ?>'><?php echo $row[$k]['service_name'] ?></option>
<?}?>

      </select></td>
</tr>
<tr>
<td align ='center' >Circle</td>
<td><select name="circle" id="circle">
<option value='0'>Select Circle</option>
<option value='PAN'>All</option>
		<?php foreach($circle as $key=>$value)
		{?>
		<option value='<?php echo $value ?>'><?php echo $key ?></option>
<?}?>
</select></td>
</tr>
<tr>
		<td align ='center' >MDN</td>
		<td><input type='text' name='ani' id='ani' value=""> 
		</td>
	</tr>
<tr>
<td align ='center' >DNIS</td>
<td><select name="shortcode" id="dnis" onchange="ShowItem()">
		<option value='0- '>Select DNIS</option>
		<?php for($k=0;$k<$row3[0];$k++)
		{
			$dnisValue=$row4[$k]['DNIS']."-".$row4[$k]['LongCode'];
			?>

		<option value='<?php echo $dnisValue ?>'><?php echo $row4[$k]['DNIS'] ?></option>
		
<? }  ?>
</select></td>

<tr>
<td align ='center' >LongCode</td>
<td><input type='text' name='longcode'  id="lc" readonly></td>
</tr>

<tr>
<td colspan='3' align ='center' ><input type="submit"  value="submit"  name="submit" </td>
</tr>

</table>
</body>
</html>
