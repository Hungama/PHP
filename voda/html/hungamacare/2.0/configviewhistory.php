<?php
session_start();
//include("config/dbConnect.php");
require_once("language.php");
	require_once("incs/db.php");
	require_once("base.php");
	$uploadfor = $_GET['type'];
	$uploadfor='config';
	$uploadvaluearray = array('config'=>'54646 Category Configuration');
	$uploadedby=$_SESSION['loginId_voda'];
		//check for existing session
if(empty($_SESSION['loginId_voda']))
{
echo "<div width=\"85%\" align=\"left\" class=\"txt\">
		<div class=\"alert alert-danger\">Your session has timed out. Please login again.</div></div>";
exit;
}
else
{
$uploadeby_voda=$_SESSION['loginId_voda'];
}

	$get_query = "select Category,PlayDate,Circle,added_on,added_by from vodafone_hungama.tbl_cat_menu nolock where PlayDate>=date(now()) order by PlayDate desc";
	$query = mysql_query($get_query,$dbConn);
	$numofrows=mysql_num_rows($query);
if($numofrows==0)
{

?>
<div width="85%" align="left" class="txt">
<div class="alert alert-block">
<?php// echo ALERT_NO_RECORD_FOUND;?>
<h4>Ooops!</h4>Hey,  we couldn't seem to find any record  for <?php echo ucfirst($uploadvaluearray[$uploadfor]); ?>
</div>
</div>
<?php
}
else
{
?>
<center><div width="85%" align="left" class="txt">
<div class="alert alert" ><a href="javascript:void(0)" onclick="javascript:viewSMSUploadhistory('<?php echo $uploadfor;?>')" id="Refresh"><i class="icon-refresh"></i></a>
<?php 
$limit=100;
//echo ALERT_VIEW_UPLOAD_HISTORY;
echo "History for ".ucfirst($uploadvaluearray[$uploadfor]);

?>
</i>
</div></div><center>
<TABLE class="table table-condensed table-bordered">
   <thead>
  <TR height="30">
  <th align="left"><?php echo 'Category';?></th>
  <th align="left"><?php echo 'PlayDate';?></th>
	<th align="left"><?php echo 'Circle';?></th>
	<th align="left"><?php echo 'Added On';?></th>
	<th align="left"><?php echo 'Added By';?></th>
</TR>
 </thead>
 <?php
while(list($Category,$PlayDate,$Circle, $addedon,$addedby) = mysql_fetch_array($query)) {

?>
	  <TR height="30">
	  	<TD><?php echo $Category; ?></TD>
		<TD><?php if(!empty($PlayDate)){echo date('j-M \'y',strtotime($PlayDate));} ?></TD>
		<TD><?php echo $Circle; ?></TD>		
		<TD><?php if(!empty($addedon)){echo date('j-M \'y g:i a',strtotime($addedon));} ?></TD>
		<TD><?php echo $addedby; ?></TD>
		
	  </TR>	
<?php
}
echo "</TABLE>";
}
mysql_close($dbConn);
?>