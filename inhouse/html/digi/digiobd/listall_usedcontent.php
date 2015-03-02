<?php
include("session.php");
error_reporting(0);
//include database connection file
$addno=rand(50, 120);
$addno=60;
include("db.php");
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>Admin</title>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<style media="all" type="text/css">@import "css/all.css";</style>
	<!--added for new table fixed column start here-->
<!--link href="master/Fixed-Header-Table-master/demo/css/960.css" rel="stylesheet" media="screen" />
        <link href="master/Fixed-Header-Table-master/css/defaultTheme.css" rel="stylesheet" media="screen" />
        <link href="master/Fixed-Header-Table-master/demo/css/myTheme.css" rel="stylesheet" media="screen" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
        <script src="master/Fixed-Header-Table-master/jquery.fixedheadertable.js"></script>
        <script src="master/Fixed-Header-Table-master/demo/demo.js"></script-->
		<!--added for new table fixed column end here-->
	</head>
<body>
<div id="main">
	<div id="header">
		<a href="index.html" class="logo"><img src="img/Hlogo.png" width="282" height="80" alt=""/></a>
	</div>
	<div id="middle">
		<div id="left-column">
		<?php include('left-sidebar.php');?>	
		</div>
		<div id="center-column">
			<div class="top-bar">
				<h1>Total content usages </h1>
				</div>
		  <div class="select-bar">
		    <?php echo $_REQUEST[msg];?>
			</div>
			<table class="listing" cellpadding="0" cellspacing="0" style="width:600px" >
			<table>
			<!--div style="height:600px;overflow:scroll;"-->
			 <!--div class="container_12 divider">
        
        	<div class="grid_4 height400"-->
        		<!--table class="fancyTable" id="myTable03" cellpadding="0" cellspacing="0">
				<img src="img/bg-th-left.gif" width="8" height="7" alt="" class="left" />
				<img src="img/bg-th-right.gif" width="7" height="7" alt="" class="right" /-->
				<?php
				$sql_getmsisdnlist = mysql_query("select count(*) as totalno, ANI,SUM(duration) as duration ,operator,circle from hul_hungama.tbl_hulobd_success_fail_details group by ANI");
				$totalrecord=mysql_num_rows($sql_getmsisdnlist);
				?>
			<!--table class="fancyTable" id="myTable03" cellpadding="0" cellspacing="0"-->
			<table class="listing" cellpadding="0" cellspacing="0" style="width:600px" >
			<!--tr>
					<th colspan="5" align="left">
<?php
/*
 
// $i=0;
$totalrecord=mysql_num_rows($sql_getmsisdnlist);
if($totalrecord>0)
{

?>
				<!--a href="xls_listallmissed.php?sdate=<?=$StartDate?>&dtype=usages" title="Click to download file.">
						<img src="img/download-icon.png" width="32" height="32" alt="" /></a-->
<?php
} */
?>
					</th>
				</tr-->
				  <thead>
					  <tr>
					<!--th class="first" width="70">S.No</th-->
					<th class="first">Msisdn</th>
					<th>Duration(Till date -in sec)</th>
					<!--th>Operator</th>
					<th>Circle</th-->
					<th>Total No of Missed Call</th>
					<th>Details</th>
					
				</tr>
</thead>
<?php
	while($result_list = mysql_fetch_array($sql_getmsisdnlist))
				{
				//$i++;
				if($result_list['ANI']!='') {
 $sql_getmissedmsisdn = mysql_query("select count(*) as totalno, ANI from newseleb_hungama.tbl_max_bupa_details where ANI='".$result_list['ANI']."'");
				 $result_list_missed = mysql_fetch_array($sql_getmissedmsisdn);
	if(!empty($result_list['duration'])) 
{
if(!empty($result_list['duration'])) { $cmy='YES';} else {$cmy='NO';}
				if(!empty($result_list['totalno'])) {$cmyF=$result_list['totalno'];} else { $cmyF="--";}
$avgvalue=$result_list['duration']/$result_list['totalno'];
$avgfrq=round($avgvalue, 0, PHP_ROUND_HALF_UP);
$atsc=$avgfrq.' sec';
} else {
$atsc="--";
}

					?>
					<tr>
						
						<!--td class="first style1"><?=$i?></td-->
						<td><?=$result_list['ANI']?></td>
						<td><?=$result_list['duration']?></td>
						<!--td><?//=$result_list['operator']?></td>
						<td><?//=$result_list['circle']?></td-->
						<td><?=$result_list_missed['totalno']?></td>
						<td>
						<?php
echo '<pre>';
echo "<b>CMA</b>-".$cmy."<br>";
echo "<b>CMAF</b>-".$cmyF."<br>";
echo "<b>ATS</b>-".$atsc."</br>";
echo '</pre>';
?>
						</td>
     				</tr>
				<?php
				}	}
				
?>
		
					</table>
					<!--/div></div-->
				    <!--/div--> 
		  </div>
		</div>
		<div id="right-column">
<?php include('right-sidebar.php');
//close database connection
mysql_close($con);
?>
	  </div>
	</div>
	<div id="footer"></div>
</div>


</body>
</html>