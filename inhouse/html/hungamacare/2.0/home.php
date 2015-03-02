<?php
$SKIP=1;
ini_set('display_errors','0');
//require_once("incs/database.php");
require_once("incs/db.php");
//require_once("../incs/GraphColors-D.php");
//require_once("../../ContentBI/base.php");
//asort($AR_SList);

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- include all required CSS & JS File start here -->
<?php 
require_once("main-header.php");
?>
<!-- include all required CSS & JS File end here -->
	
</head>

<body>

<div class="navbar navbar-inner">
<a href="#menu-bar" class="second"><button class="btn btn-primary"><i class="icon-align-justify"></i> Menu</button></a>
</div>

<div class="container">

<div class="row">

<div class="page-header">
  <h1>Select Services <small>&nbsp;&nbsp;</small></h1>
</div>
<!-- include for direct login access -->
<?php 
require_once("sessioninfo.php");
?>
<!-- include for direct login access end here -->
<div class="tab-pane active" id="pills-basic">
			<div class="tab-content">
			
			<div id="BillDump" class="tab-pane active">
	<form id="form-BillDump">
			<table class="table table-bordered table-condensed">
           <tr>
                <td width="16%" height="32" align="left"><span>Service</span></td>
                <td align="left">
				<!--select name="Tbl" id="Tbl"-->
				       <select name="service_info" id="service_info" onchange="javascript:getModuleList(this.value)">
	<?php
$serviceArray=array('TataDoCoMoMX'=>'1001','RIAUninor'=>'1409','RIATataDoCoMo'=>'1009','RIATataDoCoMocdma'=>'1609','TataIndicom54646'=>'1602','TataDoCoMo54646'=>'1002','UninorAstro'=>'1416','UninorRT'=>'1412','TataDoCoMoMXcdma'=>'1601','RIATataDoCoMovmi'=>'1809','RedFMUninor'=>'1409','Uninor54646'=>'1402','Reliance54646'=>'1202','RedFMTataDoCoMo'=>'1010','TataDoCoMoFMJ'=>'1005','REDFMTataDoCoMocdma'=>'1610','REDFMTataDoCoMovmi'=>'1810','TataDoCoMoMXvmi'=>'1801','TataDoCoMoFMJcdma'=>'1605','MTVTataDoCoMocdma'=>'1603','MTVUninor'=>'1403','RelianceCM'=>'1208','MTVReliance'=>'1203','MTVTataDoCoMo'=>'1003');
						  $listservices=$_SESSION["access_service"];
						  $services = explode(",", $listservices);
					?>
                 
                        <option value="">Select any one--</option>
                            <?php foreach ($serviceArray as $k => $v)
                                  {
                                    if(in_array($k,$services))
                                       {
$service_main_name="select value from misdata.base where service='$k' and type='Name'";
$service_main = mysql_query($service_main_name,$dbConn_218) or die(mysql_error());
$row_service_main = mysql_fetch_array($service_main);	
                             ?>
                        <!--option value="<?php echo $v;?>"><?php echo $k;?></option-->
						<option value="<?php echo $v;?>"><?php echo $row_service_main['value'];?></option>
						
                      <?php } } ?>
                       </select>                
            </td>
                </tr>
   </table>	
</form>   
							</div>
								
								
							  </div><!-- /.tab-content -->
							
						</div>

</div>
</div>


<!-- Footer section start here-->
  <?php
 require_once("footer.php");
  ?>
<!-- Footer section end here-->
    
 	<script>
	$('#listService-refresh').hide();
	// This creates submit handler for the form
$('#listService-refresh').on('click', function() {
		location.reload();
	});
	
	
		
    </script>

<script>
    $(".second").pageslide({ direction: "right", modal: true });
</script>
</body>
</html>