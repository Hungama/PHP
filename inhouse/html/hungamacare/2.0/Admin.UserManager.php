<?php
$SKIP = 1;
ini_set('display_errors','0');
$start = (float) array_sum(explode(' ',microtime())); 

require_once("incs/database.php");
require_once("../../ContentBI/base.php");
require_once("../../cmis/base.php");
require_once("../incs/GraphColors-D.php");
require_once("../incs/citylist.php");
unset($Service_DESC["Rel54646"]);

if($_POST['action'] == 1) {
	$Whole = explode(",",$_POST['Whole_SV']);

	$SVC = array();
	$CRL = array();

	$SECTIONS = join($_POST['SEC'],',');
	$SECTIONS = explode(',',$SECTIONS);
	sort($SECTIONS);
	$SECTIONS = join($SECTIONS,',');

	
	foreach($ANALYTIKES_ALERTS as $ALERTS) {
		
		$ALERT_UPDATE .= $ALERTS."='".($_POST[$ALERTS] != 1?0:1)."', ";
		
	}
	$ALERT_UPDATE = rtrim($ALERT_UPDATE,", ");
	

	$Last_Service = '';
	$New_NotIN = array();
	$Last_Circles = array();
	$Master_NOT = array();
	
	
	foreach($_POST['CHK'] as $Selection) {
	//echo $Selection."\n";
	
	$Whole = remove_item_by_value($Whole,$Selection);
	
	
	list($temp_svc,$temp_crl) = explode("|",$Selection);
	if(strcmp($Last_Service,$temp_svc) != 0 && strlen($Last_Service) > 3) {
		
		
		$temp_NOT = array_diff($Circles_NAME,$Last_Circles);
		//$this_NOT = array();
		
		foreach($temp_NOT as $X) {

				array_push($Master_NOT,$Last_Service."|".$X);	
			
			
		}
		
		
		
		//echo $Last_Service . " ends here with circles=".count($Last_Circles)." and missing circles as ".join($this_NOT,",")." \n";
		
		$Last_Circles = array();
		
			
	} 
	
	
		array_push($Last_Circles,$temp_crl);
		
	
			$Last_Service = $temp_svc;

	
	///////////////////////////////
	
	if(!in_array($temp_svc,$SVC) && strlen($temp_svc) > 0) {
				array_push($SVC,$temp_svc);	
	}
	
	if(!in_array($temp_crl,$CRL) && strlen($temp_crl) > 0) {
				array_push($CRL,$temp_crl);	
	}
	
	////////NOT IN//////////////////
	
	
	
	
	
	
		
	}
		//print_r($NewNOT);
		//exit;
	$temp_svc = '';
	$temp_crl = '';
		if(strcmp($Last_Service,$temp_svc) != 0 && strlen($Last_Service) > 3) {
		
		
		$temp_NOT = array_diff($Circles_NAME,$Last_Circles);
		//$this_NOT = array();
		
		foreach($temp_NOT as $X) {

				array_push($Master_NOT,$Last_Service."|".$X);	
			
			
		}
		
		
		
		//echo $Last_Service . " ends here with circles=".count($Last_Circles)." and missing circles as ".join($this_NOT,",")." \n";
		
		$Last_Circles = array();
		
			
	} 
	
	
		array_push($Last_Circles,$temp_crl);
		
	
			$Last_Service = $temp_svc;

	
	///////////////////////////////
	
	
	foreach($Master_NOT as $temp_notin) {
		
		list($temp_svc,$temp_crl) = explode("|",$temp_notin);
		
		if(!in_array($temp_crl,$CRL)) {
				$Master_NOT = remove_item_by_value($Master_NOT,$temp_notin);
		}
		
		if(!in_array($temp_svc,$SVC)) {
				$Master_NOT = remove_item_by_value($Master_NOT,$temp_notin);
		}
		
		
	}
	
	
	//$NotIn = join($Whole,",");
	$NotIn = join($Master_NOT,",");
	
	//print_r($NotIn);exit;
	
	$CRL = join($CRL,",");
	$SVC = join($SVC,",");
	
	$ac_flag = $_REQUEST['ac_flag'];
	$designation = $_REQUEST['designation'];
	$reportsto = $_REQUEST['reportsto'];
	$EmployeeCode = $_REQUEST['EmployeeCode'];
	$mobile = $_REQUEST['mobile'];
	$Location = $_REQUEST['Location'];
	
	mysql_query("update usermanager set access_service='".$SVC."', access_circle='".$CRL."', notin = '".$NotIn."', access_sec='".$SECTIONS."', ".$ALERT_UPDATE.", ac_flag='".$ac_flag."', designation='".$designation."', reportsto='".$reportsto."', EmployeeCode='".$EmployeeCode."', mobile='".$mobile."', Location='".$Location."' where username='".$_GET['username']."' limit 1") or die(mysql_error());
	
	$MSG = "Details for ".$_GET['username']." have been updated";
	
}

if($_GET['username']) {

$Query = mysql_query("select * from usermanager where username = '".$_GET['username']."' limit 1") or die(mysql_error());
$G = mysql_fetch_array($Query);
$CUR_SEC = explode(",",$G["access_sec"]); 
}

?><html>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <link href="assets/css/bootstrap.css" rel="stylesheet" />
  <link href="assets/css/style.css" rel="stylesheet" />
<link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
<link href="assets/css/datepicker.css" rel="stylesheet" />
<link href="assets/css/icons-sprites.css" rel="stylesheet" />

  <link rel="stylesheet" href="assets/css/base.css" type="text/css" media="all" charset="utf-8" />
  


<script type="text/javascript">
function MM_jumpMenuGo(objId,targ,restore){ //v9.0
  var selObj = null;  with (document) { 
  if (getElementById) selObj = getElementById(objId);
  if (selObj) eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0; }
}

function toggleAll(val,stag) {

var inputEls = document.getElementsByTagName('input');
for (var i = 0, tEl; tEl = inputEls[i]; i++) {
	inp = tEl.value;
	//alert(inp);
if (tEl.type == 'checkbox' && inp.indexOf(val) != -1) {
		if(tEl.checked == true) {
			tEl.checked = false;	
		} else{
			tEl.checked = true;	

		}
}
}
}

</script>
<style>
.px12 {
 font-size: 12px;	
}
</style>

<body><br><br><div class="container-fluid">
<div>

  
   <?php if($MSG) {?> <tr>
      <div class="alert  alert-success"><?php echo $MSG;?></div>
    </tr>
    <?php } ?>
   
   <form name="form" id="form"><div class="alert">You are current viewing details for 
  <select name="jumpMenu" style="font-size: 11px" id="jumpMenu">
    <?php 
	$Q = mysql_query("select username,ac_flag, concat(fname, ' ', IF(lname IS NOT NULL,lname,'')) as Name from usermanager order by ac_flag DESC, username ASC") or die(mysql_error());
	$OtherPeople =array();
	while($S = mysql_fetch_array($Q)) {
		if(!in_array($S['username'],$OtherPeople) && strcmp($_GET['username'],$S['username']) != 0) {
		array_push($OtherPeople,$S['username']);	
		}
	?><option value="Admin.UserManager.php?username=<?php echo $S["username"];?>" <?php if(strcmp($_GET['username'],$S["username"]) == 0) {echo "selected";} ?> ><?php if($S["ac_flag"] == 0) {  echo "[x] ";}?><?php echo $S["Name"];?></option>
    <?php } ?>
  </select>
  <input name="go_button" type="button" class="btn btn-primary" id= "go_button" onClick="MM_jumpMenuGo('jumpMenu','parent',0)" value="Go">
</div></form>
  <?php
if($_GET['username']) {
?> 
<form name="form1" method="post" action="">


	  <input name="action" type="hidden" id="action" value="1">
      <input name="Whole_SV" type="hidden" id="Whole_SV" value="<?php echo $Whole_SV;?>"></td>
     
<div class="tabbable"> <!-- Only required for left/right tabs -->
  <ul class="nav nav-tabs">
    <li><a href="#tab1" data-toggle="tab">User Profile</a></li>
    <li class="active"><a href="#tab2" data-toggle="tab">Sectional Access</a></li>
    <li><a href="#tab3" data-toggle="tab">Services &amp; Circles</a></li>
    <li><a href="#tab4" data-toggle="tab">Alerts <i class="icon-bell"></i></a></li>
  </ul>
  <div class="tab-content">
    <div class="tab-pane" id="tab1">

            <table class="table px12">
 			<tr>
            <td>Account Status</td>
            <td><select id="ac_flag" name="ac_flag">
            		<option value="0" <?php if($G['ac_flag'] == 0) {echo "selected";} ?>>Disabled</option>
                    <option value="1" <?php if($G['ac_flag'] == 1) {echo "selected";} ?> >Enabled</option>
                    </select></td>
            <td>Designation</td>
            <td>
            <select name="designation">
            <?php 
		foreach($ANALYTIKES_DESIGNATIONS as $desig) {
		?>
          <option value="<?php echo $desig;?>"  <?php if(strcmp($G['Designation'],$desig) == 0) {echo "selected";} ?>><?php echo $desig;?></option>
        <?php } ?>
            </select></td>
            <td>Reporting Manager</td>
            <td><select name="reportsto">
            <?php 
		foreach($OtherPeople as $reporting) {
		?>
          <option value="<?php echo $reporting;?>"  <?php if(strcmp($G['reportsto'],$reporting) ==0) {echo "selected";} ?>><?php echo $reporting;?></option>
        <?php } ?>
            </select></td>
            </tr><tr>
            <td>Employee Code</td>
            <td><input type="text" name="EmployeeCode" class="numbersOnly" value="<?php echo $G['EmployeeCode'];?>" /></td>
            
            
            <td>Mobile Number</td>
            <td><input type="text" name="mobile" class="numbersOnly" value="<?php echo $G['mobile'];?>" /></td>
            
            
            <td>Location</td>
            <td><select name="Location"><?php
              foreach($City as $CityCode=>$CityName) {
			  ?><option value="<?php echo $CityCode;?>" <?php if(strcmp("---",$CityCode)==0) {echo "disabled";}?>  <?php if(strcmp($G['Location'],$CityCode) ==0) {echo "selected";} ?>><?php echo $CityName;?></option><?php } ?></select></td>
            </tr>
</table>
    </div>
    <div class="tab-pane active" id="tab2">
      <p><?php 
		foreach($ANALYTIKES_SECS as $section) {
		?>
        <input type="checkbox" name="SEC[]" value="<?php echo $section;?>"  <?php if(in_array($section,$CUR_SEC)) {echo "checked";} ?>>
        <?php echo $section;?>
        <?php } ?></p>
    </div>
    
    
    <div class="tab-pane" id="tab3">
     <table width="100%" class="table table-condensed" id="Grid" style="font-size: 10px;">
        <thead  style="font-size: 10px;"> <tr>
          <th width="160">&nbsp;</th>
          <?php
		sksort($Service_DESC);
		$COLS = count($Circles_NAME);
        foreach($Circles_NAME as $circle) {
		?>
          <th width="26"><?php echo $CMAP[$circle];?></th>
          <?php } ?>
          <th>&nbsp;</th>
          </tr>
          
          
          <tr>
            <th>&nbsp;</th>
            <?php
		foreach($Circles_NAME as $circle) {
		?>
            <th align="center"><nobr>[<a href="javascript:toggleAll('|<?php echo $circle;?>',1);">X</a>]</nobr></th>
            <?php } ?>
            <th>&nbsp;</th>
          </tr></thead>
        <tbody> 
          <?php
		
		
      foreach($Service_DESC as $ServiceName=>$values) {
	  ?>
          <tr>
            <td width="160" ><nobr><?php echo $values["Name"];?></nobr></td>
            <?php for($i=1;$i<=$COLS;$i++) {
			$SV_Val = $ServiceName."|".$Circles_NAME[$i];
			$Whole_SV .= $SV_Val.",";
			
			if(substr_count($G["notin"],$SV_Val) == 0 && substr_count($G["access_service"],$ServiceName) != 0 && substr_count($G["access_circle"],$Circles_NAME[$i]) != 0) {
			
			$CHECKED = "checked";
			$COLOR = "green";	
				} else{
			$CHECKED = "";
			$COLOR = "#e2e2e2";	
			}
			
			?>
            <td  width="26" bgcolor="<?php echo $COLOR;?>"><input alt="<?php echo $Circles_NAME[$i];?>"  name="CHK[]" type="checkbox" value="<?php echo $SV_Val;?>" <?php echo $CHECKED;?>></td>
            <?php } ?>
            <td><nobr>[<a href="javascript:toggleAll('<?php echo $ServiceName;?>|',1);">X</a>]</nobr></td>
            </tr>
          <?php } 
		$Whole_SV = rtrim($Whole_SV,",");
		?></tbody>
      </table>
    </div>
    
    
    <div class="tab-pane" id="tab4">
      <p><?php 
		foreach($ANALYTIKES_ALERTS as $alert) {
		?>
          <input type="checkbox" name="  <?php echo $alert;?>" value="1" <?php if($G[$alert] == 1) {echo "checked";} ?>>
          <?php echo $alert;?>
        <?php } ?></p>
    </div>
    
  </div>
</div><br>
     <input name="button" type="submit" class="btn btn-primary" id="button" value="Submit">

</form>



<?php } ?>
<script src="assets/js/jquery.js"></script>
<script src="assets/js/bootstrap-transition.js"></script>
<script src="assets/js/bootstrap-alert.js"></script>
<script src="assets/js/bootstrap-modal.js"></script>
<script src="assets/js/bootstrap-dropdown.js"></script>
<script src="assets/js/bootstrap-scrollspy.js"></script>
<script src="assets/js/bootstrap-tab.js"></script>
<script src="assets/js/bootstrap-tooltip.js"></script>
<script src="assets/js/bootstrap-popover.js"></script>
<script src="assets/js/bootstrap-button.js"></script>
<script src="assets/js/bootstrap-collapse.js"></script>
<script src="assets/js/bootstrap-carousel.js"></script>
<script src="assets/js/bootstrap-typeahead.js"></script>
<script src="assets/js/jquery.fixheadertable.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#Grid').fixheadertable({
			colratio    : [200, 5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,50],
             height  : 200,
			     zebra      : true

        });
		
		jQuery('.numbersOnly').keyup(function () { 
    	this.value = this.value.replace(/[^0-9\.]/g,'');
		});
		
    });
	
</script>
</div></div>
</body>

</html>
<?php


function remove_item_by_value($array, $val = '', $preserve_keys = true) {
	if (empty($array) || !is_array($array)) return false;
	if (!in_array($val, $array)) return $array;

	foreach($array as $key => $value) {
		if ($value == $val) unset($array[$key]);
	}

	return ($preserve_keys === true) ? $array : array_values($array);
}

?>