<?php
session_start();
error_reporting(1);
require_once("incs/db.php");
require_once("language.php");
//check for existing session$_SESSION['loginId_mts']
if(empty($_SESSION['loginId_mts']))
{
echo "<div width=\"85%\" align=\"left\" class=\"txt\">
		<div class=\"alert alert-danger\">Your session has timed out. Please login again.</div></div>";
exit;
}
else
{
$uploadeby_mts=$_SESSION['loginId_mts'];
}

if(isset($_FILES['upfile']) && !empty($_FILES['upfile']['name'])) {
$orgfilename=$_FILES['upfile']['name'];
 //check for valid file content start here 
$lines = file($_FILES['upfile']['tmp_name']);
$isok;
$count=0;
foreach ($lines as $line_num => $mobno) 
{
$mno=trim($mobno);
if(!empty($mno))
{
if(is_numeric($mno) && strlen($mno)==10) {
$isok=1;
$count++;
    } else {
$isok=2;
break;
  }
}
  }
if($isok==2)
{
echo "<div width=\"85%\" align=\"left\" class=\"txt\">"; ?>
<div class="alert alert-danger"><?php echo FILEUPLOADEERROR;?></div></div>
<?php
exit;
}
else if($count>20000)
{
echo "<div width=\"85%\" align=\"left\" class=\"txt\">
<div class=\"alert alert-danger\">Please upload file of less than 1,000 numbers otherwise it will not process.</div></div>";
exit;
}
	 
	 //check for valid file content end here
	   $newamount = "";
		$channel=$_POST['channel'];
if($_POST['upfor']=='active')
{
if($_REQUEST['service_info']=='1116')
{
$lang_id=$_POST['lang'];
}
else
{
$lang_id=$_POST['lang_active'];
}
}
else if($_POST['upfor']=='deactive')
{
$lang_id=$_POST['lang_deactive'];
}
else if($_POST['upfor']=='renewal')
{
if($_REQUEST['service_info']=='1116')
{
$lang_id=$_POST['lang'];
}
else
{
$lang_id=$_POST['lang_renewal'];
}
}
else
{
$lang_id="01";
}
	
		$planId=trim($_REQUEST['price']);
		$planData = explode("-",$planId);
		if(count($planData)==2) {
			$planId = $planData[0];
			$getAmount = $planData[1];
		}

		if(!$planId) $planId="";		
		

		$subtype="";

		if($_REQUEST['service_info'] == '11011') $serviceId ='1101';
		else $serviceId = $_REQUEST['service_info'];
		
		if($serviceId==1116) {
			$cat1=$_POST['cat1'];
			if($cat1) $subtype=$cat1;	
			else $subtype="N";	

			$cat2=$_POST['cat2'];
			if($cat2) $subtype .="-".$cat2;	
			else $subtype .="-N";

			//$lang=$_POST['lang'];
			$lang=$lang_id;
			if($lang) $subtype .="-".$lang;	
			else $subtype .="-N";

			//if($_POST['lang']) $lang=$_POST['lang'];
			if($lang_id) $lang=$lang_id;
			else $lang="01";		
		} else {
			//if($_POST['lang']) $lang=$_POST['lang'];
			if($lang_id) $lang=$lang_id;
			else $lang="01";		
		}

		
			$file = $_FILES['upfile'];
			$qryBatch = mysql_query("select max(batch_id) from billing_intermediate_db.bulk_upload_history", $dbConn);
			list($batchId) = mysql_fetch_array($qryBatch);
			if($batchId)
				$batchId = $batchId + 1;
			else
				$batchId = 1;
				
			if(!$getAmount) { 
				$selAmount="select iAmount from master_db.tbl_plan_bank where plan_id=".$planId;
				$qryAmount = mysql_query($selAmount,$dbConn);
				list($getAmount) = mysql_fetch_array($qryAmount);
			}
			$SafeFile = explode(".", $_FILES['upfile']['name']);
			$makFileName = str_replace(" ","_",$SafeFile[0])."_".$batchId."_".date("YmdHis").".".$SafeFile[1];

			$uploaddir = "/var/www/html/hungamacare/bulkuploads/".$serviceId."/";
			$path = $uploaddir.$makFileName;
			if(move_uploaded_file($_FILES['upfile']['tmp_name'], $path))
			{
				$succCount=0;
				$failCount=0;
				$file_size=$count;
				$thisTime = date("Y-m-d H:i:s");
				$dbaccess='mts';
				$Uploadquery="insert into billing_intermediate_db.bulk_upload_history(batch_id, service_type, channel, price_point, file_name, added_by, added_on, upload_for,status,operator,total_file_count,service_id,amount,language) values('".$batchId."','".$subtype."', '".$channel."', '".$planId."', '".$makFileName."', '".$uploadeby_mts."', '".$thisTime."', '".$_POST['upfor']."',0,'".$dbaccess."','".$file_size."','".$serviceId."','".$getAmount."','".$lang."')";
				$queryIns = mysql_query($Uploadquery, $dbConn);
				$msg = $orgfilename." has been successfully uploaded. Generated Reference ID is ".$batchId;
				echo "<div width=\"85%\" align=\"left\" class=\"txt\"><div class=\"alert alert-success\">$msg</div></div>";
				
				
			} else { 
				
                echo "<div width=\"85%\" align=\"left\" class=\"txt\">
				<div class=\"alert alert-danger\">There seem to be error in the contents of the file. Please check the file you selected for upload.</div></div>";
				}
				
			
		}
	
	exit;
?>