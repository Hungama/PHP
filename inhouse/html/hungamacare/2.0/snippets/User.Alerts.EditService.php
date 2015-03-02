<?php
mysql_connect("localhost","kunalk.arora","google");
mysql_select_db("misdata");




$username = $_REQUEST['username'];
$service = $_REQUEST['service'];

$GetSelected = mysql_query("select t.id, t.alert_type as 'alert_type', t.service as service, t.circles as circles, b.value as map from tbl_usermanager_alerts t, base b where t.service=b.service and b.type='map_details' and t.service='".$service."' and username='".$username."' limit 1") or die(mysql_error());
	if(mysql_num_rows($GetSelected)==0) {
		$GetSelected = mysql_query("select '' as id, '' as 'alert_type', b.service as service, '' as circles, b.value as map from   base b where   b.type='map_details' and b.service='".$service."'  limit 1") or die(mysql_error());
	}
	$RSelected = mysql_fetch_array($GetSelected);
	$id = $RSelected['id'];
	
	$_REQUEST['Circle'] = explode(",",$RSelected['circles']);
	
	require_once("../../../cmis/maps/".$RSelected['map']);

	if(in_array("Others",$Sheet)) {
	$Delta = -1;	
	} else{
	$Delta = 0;	
	}
	$Count_Map = count($Sheet) + $Delta;
	//echo $Count_Map;
	
$GetCircles = mysql_query("select access_circle, notin from usermanager where username='".$username."' limit 1") or die(mysql_error());	
$RCircles = mysql_fetch_array($GetCircles);
$Ac_Circles = explode(",",$RCircles['access_circle']);

$Ac_Circles = array_intersect($Ac_Circles,$Sheet);

$NotIn = explode(",",$RCircles['notin']);
$Service = $RSelected['service'];
$temp_array = array();

foreach($Ac_Circles as $tp_circle) {
	if(in_array($Service."|".$tp_circle,$NotIn)) {
		array_remove_by_value($Ac_Circles,$tp_circle);
	}
}


$AR_CList = $Ac_Circles;
unset($Ac_Circles);




function array_remove_by_value($array, $value)
{
    return array_values(array_diff($array, array($value)));
}
	
?><script>
<?php if($id=='') {?>
	
	
	$('#listService-remove').hide();
	
	
<?php } ?>
$('#listService-submit').show();
$('#alert-no-circle').hide();
$('#alert-no-alert_type').hide();
var tog = false; // or true if they are checked on load 
 $('#listService-toggle').click(function() { 
    $("input[type=checkbox]").attr("checked",!tog); 
  tog = !tog; 
 });
</script>
<div  class="alert alert-error" id="alert-no-circle"><a class="close" data-dismiss="alert" href="#">&times;</a>You seem to have not selected any circle. Please select atleast one circle for us to save your preferences.
</div>
<div  class="alert alert-error" id="alert-no-alert_type"><a class="close" data-dismiss="alert" href="#">&times;</a>You seem to have not selected any alert preference - sms or email. Please select atleast one circle for us to save your preferences.
</div>

<form class="form-horizontal well" data-async data-target="#listService" target="#listService" action="/some-endpoint" method="POST" id="listService_form">
		 <input type="radio" name="alert_type" id="alert_type" value="E" <?php if(strcmp($RSelected['alert_type'],'E') == 0) {echo "checked";}?>> <span class="label label-info">Email</span>&nbsp;&nbsp;<input type="radio" name="alert_type" id="alert_type" value="S" <?php if(strcmp($RSelected['alert_type'],'S') == 0) {echo "checked";}?>> <span class="label label-success">&nbsp;SMS&nbsp;</span>
      
      <a href="#" id="listService-toggle" class="pull-right well-small"><small>Toggle Selection</small></a>
	  
	  <?php
	  include "../incs/modalCircles.php";
	  ?>
      <input type="hidden" name="PAN" id="PAN" value="<?php echo $Count_Map;?>" />
      <input type="hidden" name="ident" id="ident" value="<?php echo $service;?>" />
      <input type="hidden" name="username" id="username" value="<?php echo $username;?>" />
    </form>