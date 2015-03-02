<?php
//include("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
// validate login and password

$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa', 'KAR'=>'Karnataka', 'HAR'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh',''=>'Other','HAY'=>'Haryana');

?>
<script type="text/javascript">

function setCircleData(circleCode) {  
	var xmlhttp;
	if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	} else { // code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) { //alert(xmlhttp.responseText);
			document.getElementById("langDiv").innerHTML=xmlhttp.responseText;
	    }
	}
	var url="langValue.php?circle="+circleCode+"&case=1";
	//alert(url);
	xmlhttp.open("GET",url,true);
	xmlhttp.send();	
}

function showMainMenu(lang,circle) { 
	var xmlhttp;
	if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	} else { // code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) { 
			document.getElementById("maindiv").innerHTML=xmlhttp.responseText;
	    }
	}
	var url="langValue.php?circle="+circle+"&case=2&lang="+lang;
	//alert(url);
	xmlhttp.open("GET",url,true);
	xmlhttp.send();	
}

function showContent(service,circle,lang) {
	var xmlhttp;
	if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	} else { // code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			if(service == 'bg') {
				document.getElementById('ac1Div').style.display = 'none';
				document.getElementById('serviceDiv').style.display = 'block';
				document.getElementById("serviceDiv").innerHTML=xmlhttp.responseText;
			} else if(service == 'ac') { 
				document.getElementById('ac1Div').style.display = 'table-row';
				document.getElementById('serviceDiv').style.display = 'none';
				document.getElementById("ACdiv1").innerHTML=xmlhttp.responseText; 
			} else if(service == 'mu') { 
				document.getElementById('ac1Div').style.display = 'table-row';
				document.getElementById('serviceDiv').style.display = 'none';
				document.getElementById("ACdiv1").innerHTML=xmlhttp.responseText; 
			}
	    }
	}
	var url="langValue.php?circle="+circle+"&case=3&lang="+lang+"&service="+service;
	//alert(url);
	xmlhttp.open("GET",url,true);
	xmlhttp.send();	
}

function showACData(clipValue,circle,lang,service) {
	var xmlhttp;
	if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	} else { // code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			document.getElementById('ac2Div').style.display = 'table-row';
			document.getElementById('serviceDiv').style.display = 'none';
			document.getElementById("ACdiv2").innerHTML=xmlhttp.responseText; 
		}
	}
	var url="langValue.php?circle="+circle+"&case=4&lang="+lang+"&service="+service+"&clip="+clipValue;
	//alert(url);
	xmlhttp.open("GET",url,true);
	xmlhttp.send();	
}

function showClipData(filename,circle,lang,service) {
	var xmlhttp;
	if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	} else { // code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			document.getElementById('ac3Div').style.display = 'table-row';
			document.getElementById('serviceDiv').style.display = 'none';
			document.getElementById("ACdiv3").innerHTML=xmlhttp.responseText; 
		}
	}
	var url="langValue.php?circle="+circle+"&case=5&lang="+lang+"&service="+service+"&file="+filename;
	//alert(url);
	xmlhttp.open("GET",url,true);
	xmlhttp.send();	
}
</script>

<form action='demo.php' method='post' name="frm1" onSubmit="return checkfield()">
<table width="70%" align="center" style="border:2px;">
	<tr>
		<td width="20%" height="20px">Select Circle</td>
		<td><select name="circle" id="circle" onchange="setCircleData(this.value);">
				<option value="">Select Circle</option>
				<?php foreach($circle_info as $circle_id=>$circle_val) { ?>
					<option value=<?php echo $circle_id?>><?php echo $circle_val;?></option>
				<?php } ?>
			</select>
		</td>
	</tr>
	<tr>
		<td width="20%" height="20px">Select Language</td>
		<td><div id='langDiv'><select name="lang" id="lang">
				<option value="">Select Language</option>
			</select></div>
		</td>
	</tr>
	<tr>
		<td width="20%" height="20px">Menu List</td>
		<td><div id='maindiv'>Main menu List</div></td>
	</tr>
	<tr>
		<td colspan='2'><div id='serviceDiv'></div></td>
	</tr>
	<tr id="ac1Div" style="display:none">
		<td width="20%" height="20px">Audio Data</td>
		<td><div id='ACdiv1'></div></td>
	</tr>
	<tr id="ac2Div" style="display:none">
		<td width="20%" height="20px">AudioCinema Clip Data</td>
		<td><div id='ACdiv2'></div></td>
	</tr>
	<tr id="ac3Div" style="display:none">
		<td width="20%" height="20px"></td>
		<td><div id='ACdiv3'></div></td>
	</tr>
</table>