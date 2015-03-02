<?php
include("session.php");
error_reporting(0);
//include database connection file
include("db.php");
$today=date("Y-m-d");
$displaydate;
$errorcode=array('unknown','busy','far_end_disconnect','error.connection.nor','noanswer');
$rand_keys = array_rand($errorcode, 2);

 $sql_getmsisdnlist = mysql_query("select * from hul_hungama.tbl_hul_subdetails limit 4");
 
 
	$totalrecord=mysql_num_rows($sql_getmsisdnlist);
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>Admin</title>
	<!--meta http-equiv="content-type" content="text/html; charset=iso-8859-1" /-->
	<style media="all" type="text/css">@import "css/all.css";</style>
	<script language="javascript" type="text/javascript" src="datetimepicker/datetimepicker.js"></script>
	
	<!--style media="all" type="text/css">@import "popup/css/styles.css";</style-->
	<STYLE>
 .ttip {border:1px solid black;font-size:12px;layer-background-color:lightyellow;background-color:lightyellow;width:200px;height:100px}
</STYLE>
<!--added for new table fixed column start here-->
<link href="master/Fixed-Header-Table-master/demo/css/960.css" rel="stylesheet" media="screen" />
        <link href="master/Fixed-Header-Table-master/css/defaultTheme.css" rel="stylesheet" media="screen" />
        <link href="master/Fixed-Header-Table-master/demo/css/myTheme.css" rel="stylesheet" media="screen" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
        <script src="master/Fixed-Header-Table-master/jquery.fixedheadertable.js"></script>
        <script src="master/Fixed-Header-Table-master/demo/demo.js"></script>
		<!--added for new table fixed column end here-->
	</head>
<body>
<div id="main">
	<div id="header">
		<a href="index.html" class="logo"><img src="img/Hlogo.png" width="282" height="80" alt=""/></a>
	</div>
	<div id="middle" >
		<div id="left-column">
		<?php include('left-sidebar.php');?>	
		</div>
		<div id="center-column1" style="width:700px">
			<div class="top-bar">
				<h1>List MSISDN </h1>
				</div>
		  <!--div class="select-bar">
		    <?php //echo $_REQUEST[msg];?>
			</div-->
			
			 <div class="table" style="width:700px">
	<?php echo 'Total no of records '.$totalrecord;?>
		
			   	<div class="container_12 divider">
        
        	<div class="grid_4 height400">
        		<table class="fancyTable" id="myTable03" cellpadding="0" cellspacing="0">
        		    <thead>
        		    <tr>
        		    <th>Msisdn</th>
					<th>ODB_NAME</span></th>
					<th>Status</span></th>					
					<th>Error_Code</span></th>
					<th>Service</span></th>
					</tr>
        		    </thead>
        		     <tbody>
					 <?php

if($totalrecord>0)
{?>
	<!--tr><th colspan="36" align="left">Total no of <?= $totalrecord;?> records found of date <?=$displaydate;?>.</th></tr-->
	<?php
	while($result_list = mysql_fetch_array($sql_getmsisdnlist))
				{
if(!empty($result_list['ANI']))
{

$i=0;

$getallobd=mysql_query("select ANI,Service,status,odb_name,error_code from hul_hungama.tbl_hulobd_success_fail_details where ANI='".$result_list['ANI']."' and service='HUL_PROMOTION' group by odb_name");

while($result_list_obd = mysql_fetch_array($getallobd))
				{?>
	<tr>
<td>
<?=$result_list_obd['ANI']?>
</td>
<td>
<?=$result_list_obd['odb_name']?>
</td>
<td>
<?=$result_list_obd['status']?>
</td>
<td>
<?=$result_list_obd['error_code']?>
</td>
<td>
<?=$result_list_obd['Service']?>
</td>
</tr>
     <?php
	 }
?>

<?php }

?>

<?php
}
}

else
{?>
<tr><td colspan="5">No records found.</td></tr>
<?php
}
?>
        		  </tbody>
        		</table>
        	</div>
        	<div class="clear"></div>
        </div>
		
				</div>
		</div>
		<div id="right-column">
		
<?php
//close database connection
mysql_close($con);
?>
	  </div>
	</div>
	<div id="footer"></div>
</div>
</body>
</html>