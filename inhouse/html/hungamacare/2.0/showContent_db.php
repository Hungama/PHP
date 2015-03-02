<?php
session_start();
//include ("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
require_once("incs/db.php");
$languageData = array('01'=>'Hindi','02'=>'English','03'=>'Punjabi','04'=>'Bhojpuri','05'=>'Haryanavi','06'=>'Bengali','07'=>'Tamil','08'=>'Telugu','09'=>'Malayalam','10'=>'Kannada','11'=>'Marathi','12'=>'Gujarati','13'=>'Oriya','14'=>'Kashmiri','15'=>'Himachali','16'=>'Chhattisgarhi','17'=>'Assamese', '21'=>'Maithali','19'=>'Nepali','20'=>'Kumaoni','18'=>'Rajasthani');
$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa', 'KAR'=>'Karnataka', 'HAR'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh',''=>'Other','HAY'=>'Haryana');

?>
<?php 
$circle=strtoupper(trim($_GET['circle']));
$lang = trim($_GET['lang']);	
$service = trim($_GET['cat']); 

$case=trim($_REQUEST['cat']);
switch($case) {
	case 'bg': if($service == 'bg') { $flag=0;
					$BGfilePath = "http://10.2.73.156:8080/hungama/config/AMUconfig/BGconfig/gossip.cfg"; 
					$lines = file($BGfilePath);
					$bgDataValue = array();
					foreach ($lines as $line_num => $BGData) {
						//$query="SELECT ";
						$bgDataValue[] = $BGData;
						$flag=1;
					} ?>			  
				  <div>
						<ul class="breadcrumb">
<li>  
    <a href="javascript:void(0)" onclick="showMainMenu('<?= $lang?>','<?= $circle?>','AirtelEU')">Root</a> <span class="divider">/</span>  
  </li>
  <li class="active">  
   Bollywood Gossip
  </li>
  </ul>
						<!--div class="well well-small">
						
						
						<B><FONT COLOR="#FF0000"><h3>Bollywood Gossip List</h3></FONT></B></div-->
<!--div class="well well-small">					
					<span class="label label-important"><b>Circle</b></span>&nbsp;&nbsp;<?php echo $circle_info[$circle];?>&nbsp;&nbsp;
					<span class="label label-info"><b>Language</b></span>&nbsp;&nbsp;<?php echo $languageData[$lang];?>
						</div-->
				  </div>				
				  <?php if($flag) { ?>
				  <table align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1"  width="100%" class="table table-bordered table-condensed">		
					  <tr>
						<td style="padding-left: 5px;" bgcolor="#ffffff" height="35" width="10%" align='center'><b>Sequence Number</b></td>
						<td style="padding-left: 5px;" bgcolor="#ffffff" height="35" align='center'><b>Song Code</b></td>
					  </tr>
					  <?php for($i=1; $i<count($bgDataValue); $i++) { ?>				  				 
						<tr>
							<td style="padding-left: 5px;" bgcolor="#ffffff" height="35" align='center'><?php echo $i;?></td>
							<td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo $bgDataValue[$i];?></td>
						</tr>
					  <?php } ?>
				  </table>
				  <?php } else { echo "<div align='center'  class='alert alert-block'>No data Available</div>";} ?>		 
			  <?php } 
	break; 
	case 'ac':	$clipValue = $_REQUEST['clip'];
				$ACFullFilePath = "http://10.2.73.156:8080/hungama/config/AMUconfig/audiosongconfig/FullAudioClip/".$clipValue.".cfg";
			    $lines1 = file($ACFullFilePath);
				$acFullDataValue = array();
				foreach ($lines1 as $line_num => $ACData2) {
					$acFullDataValue[] = $ACData2;
				} ?>
		
<ul class="breadcrumb">
<li>  
    <a href="javascript:void(0)" onclick="showMainMenu('<?= $lang?>','<?= $circle?>','AirtelEU')">Root</a> <span class="divider">/</span>  
  </li>
  <li>  
    <!--a href="#">Audio Cinema</a> <span class="divider">></span-->
	 <a href="javascript:void(0)" onclick="showContent('ac','<?= $circle?>','<?= $lang?>')">Audio Cinema</a> <span class="divider">/</span>  
  </li>  
  <li>  
    <!--a href="#" class="active"><?//= $_SESSION['bc_catname']?></a> <span class="divider">></span-->
	<a href="#" onclick="javascript:showACData('<?= $_SESSION['Sessionclip']?>','<?= $circle?>','<?= $lang?>','ac','<?= $_SESSION['bc_catname']?>');"><?= $_SESSION['bc_catname']?></a><span class="divider">/</span>
  </li>  
  <li class="active"><?= $clipValue;?></li> 
</ul> 
		<!--div align='left'class="tab-content">
						<div class="well well-small">
						<span class="label label-important"><b>Circle</b></span>&nbsp;&nbsp;<?php echo $circle_info[$circle];?>&nbsp;&nbsp;
						<span class="label label-info"><b>Language</b></span>&nbsp;&nbsp;<?php echo $languageData[$lang];?>&nbsp;&nbsp;
						<span class="label label-success"><b>ClipValue</b></span>&nbsp;&nbsp;<?php echo $clipValue;?>
					</div>
				</div-->
				  <table align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1"  width="100%" class="table table-bordered table-condensed" >		
					  <tr align='center'>
						<td style="padding-left: 5px;" bgcolor="#ffffff" height="35" width="10%"><b>Sequence Number</b></td>
						<td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>Song Code</b></td>
						<!--td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>Album Name</b></td>
						<td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>Song Name</b></td-->
					  </tr>
					<?php $j=1; for($i=0; $i<count($acFullDataValue); $i++) { if($acFullDataValue[$i]) { 
				/*
				$query = "select AlbumName,ContentName from master_db.master_content where SongUniqueCode='".trim($acFullDataValue[$i])."'";	
						$result = mysql_query($query);
						$data = mysql_fetch_array($result);
						*/
					?>
						<tr>
							<td style="padding-left: 5px;" bgcolor="#ffffff" height="35" align='center'><?php echo $j;?></td>
							<td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo $acFullDataValue[$i];?></td>
							<!--td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php //echo $data['AlbumName'];?></td>
							<td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php //echo $data['ContentName'];?></td-->
						</tr>
					<?php $j++;} } ?>
				</table><?php 
	break;
	case 'mu':	$clipValue = $_REQUEST['clip']; 
				$ACFullFilePath = "http://10.2.73.156:8080/hungama/config/AMUconfig/songconfig/".$clipValue.".cfg";
			    $lines1 = file($ACFullFilePath);
				$muFullDataValue = array();
				foreach ($lines1 as $line_num => $MUData2) {
					$muFullDataValue[] = $MUData2;
				} ?>
				<?php 
							$query = "select * from master_db.tbl_subcategory_master where catID=substr('".$clipValue."',3,2)";	
							$result = mysql_query($query,$dbConn);
							$data = mysql_fetch_row($result); 
							$catName = $data[0];//echo $clipValue;?>
<ul class="breadcrumb">  
<li>  
    <a href="javascript:void(0)" onclick="showMainMenu('<?= $lang?>','<?= $circle?>','AirtelEU')">Root</a> <span class="divider">/</span>  
  </li>
  <li>  
    <a href="javascript:void(0)" onclick="showContent('mu','<?= $circle?>','<?= $lang?>')">Music Unlimited</a> <span class="divider">/</span>  
  </li>  
 <?php /*if(!empty($_SESSION['othesubcate'])){?>
  <li>
  <a href="javascript:void(0)" onclick="showMUCateData('mu','<?php echo $circle;?>','<?php echo $lang;?>','Other Categories','1');">
 <?php
 echo $_SESSION['mucatname'];
 ?>
 </a>
 </li>
  <li class="active"><span class="divider">/</span> 
   <?php
 echo $_SESSION['othesubcate'];
 ?>
 </li>
<?php } */?>
 <li class="active">  
    <?= $languageData[$lang].'-'.$catName;?>
  </li>  
  
 
  
  <!--li class="active"><?//= $catName;?></li--> 
</ul> 			
			<!--div align='left' class="tab-content">
					
					<div class="well well-small">
					<span class="label label-important"><b>Circle</b></span>&nbsp;&nbsp;<?php echo $circle_info[$circle];?> &nbsp;&nbsp;
					<span class="label label-info"><b>Language</b></span>&nbsp;&nbsp;<?php echo $languageData[$lang];?>&nbsp;&nbsp;
					<span class="label label-success"><b>ClipValue</b></span>&nbsp;&nbsp;<?php echo $catName;?></br>
					</div>
				</div-->
<table align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" width="100%" class="table table-bordered table-condensed" >		
					  <tr align='center'>
						<td style="padding-left: 5px;" bgcolor="#ffffff" height="35" width="10%"><b>Sequence number</b></td>
						<td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>SongUniquecode</b></td>
						<td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>ContentName</b></td>
						<td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>AlbumName</b></td>
						<td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>Language</b></td>
						<td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>Ringtones </b></td>
						<td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>CRBT </b></td>
					</tr>
					<?php $j=1; for($i=0; $i<count($muFullDataValue); $i++) { if($muFullDataValue[$i]) { 
	//	$query = "select AlbumName,ContentName from master_db.master_content where SongUniqueCode='".trim(substr($muFullDataValue[$i],4))."'";
	//$query = "select SongUniqueCode,ContentName,AlbumName,language,Genre,MT_ID,PT_ID,TT_ID from misdata.content_musicmetadata where SongUniqueCode='".trim(substr($muFullDataValue[$i],4))."'";
	$query = "select a.SongUniqueCode as SongUniqueCode,a.ContentName as ContentName,a.AlbumName as AlbumName,a.language as language,a.Genre as Genre,a.MT_ID as MT_ID,a.PT_ID as PT_ID,a.TT_ID as TT_ID,b.CRBTId_1 as CRBTId_1 from misdata.content_musicmetadata as a LEFT JOIN  misdata.content_servicedata as b ON a.SongUniqueCode=b.SongUniqueCode and b.Service='AirtelEU' where a.SongUniqueCode='".trim(substr($muFullDataValue[$i],4))."'";
						$result = mysql_query($query,$dbConn_218);
						$data = mysql_fetch_array($result);  //print_r($data);	?>
						<tr>
							<td style="padding-left: 5px;" bgcolor="#ffffff" height="35" align='center'><?php echo $j;?></td>
							<td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo trim(substr($muFullDataValue[$i],4));?></td>
							<td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo $data['ContentName'];?></td>
							<td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo $data['AlbumName'];?></td>
							<td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo $data['language'];?></td>
							<td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;
							<?php //echo $data['MT_ID'].''.$data['PT_ID'].''.$data['TT_ID'];?>
						<?php if(!empty($data['MT_ID'])){?>	<span class="label label-important"><b>Mono</b></span>&nbsp;&nbsp;<?php }?>
						<?php if(!empty($data['PT_ID'])){?>&nbsp;&nbsp;<span class="label label-info"><b>Poly</b></span>&nbsp;&nbsp;<?php }?>
						<?php if(!empty($data['TT_ID'])){?>&nbsp;&nbsp;<span class="label label-success"><b>Tru </b></span>&nbsp;&nbsp;<?php }?>
							</td>
							<td style="padding-left: 5px;" bgcolor="#ffffff" height="35">
				<?php if(!empty($data['CRBTId_1'])){?>	<span class="label label-important"><b><?php echo $data['CRBTId_1'];?></b></span>&nbsp;&nbsp;<?php }?>
							</td>
						</tr>
					<?php $j++;} } ?>
				</table><?php
	break;
	case 'AirtelDevo': $clipValue = $_REQUEST['clip']; 
				$relFullFilePath = "http://10.2.73.156:8080/hungama/config/dev/airm/songconfig/".$clipValue.".cfg";
				
				$lines1 = file($relFullFilePath);
				$relFullDataValue = array();
				foreach ($lines1 as $line_num => $RelData) {
					$relFullDataValue[] = $RelData;
				} $totalFileData = count($relFullDataValue);?>
				
				<?php if ($totalFileData) { ?>
		<table align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1"  width="100%" class="table table-bordered table-condensed">		
		   		    <tr align='center'>
						<td style="padding-left: 5px;" bgcolor="#ffffff" height="35" width="10%"><b>Sequence number</b></td>
						<td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>SongUniquecode</b></td>
						<td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>ContentName</b></td>
						<td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>AlbumName</b></td>
						<td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>Language</b></td>
						<td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>Ringtones </b></td>
						<td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>CRBT</b></td>
					</tr>
					<?php $j=1; for($i=0; $i<count($relFullDataValue); $i++) { if($relFullDataValue[$i]) { 
$query = "select SongUniqueCode,ContentName,AlbumName,language,Genre,MT_ID,PT_ID,TT_ID from misdata.content_musicmetadata where SongUniqueCode='".trim(substr($relFullDataValue[$i],4))."'";
				
					$result = mysql_query($query,$dbConn_218);
					$data = mysql_fetch_array($result);  //print_r($data);	?>
					<tr>
						<td style="padding-left: 5px;" bgcolor="#ffffff" height="35" align='center'><?php echo $j;?></td>
						<td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo  trim(substr($relFullDataValue[$i],4));?></td>
						<td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo $data['AlbumName']?$data['AlbumName']:"-";?> </td>
						<td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo $data['ContentName']?$data['ContentName']: "-";?>
						</td>
<td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo $data['language'];?></td>
							<td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;
						<?php if(!empty($data['MT_ID'])){?>	<span class="label label-important"><b>Mono</b></span>&nbsp;&nbsp;<?php }?>
						<?php if(!empty($data['PT_ID'])){?>&nbsp;&nbsp;<span class="label label-info"><b>Poly</b></span>&nbsp;&nbsp;<?php }?>
						<?php if(!empty($data['TT_ID'])){?>&nbsp;&nbsp;<span class="label label-success"><b>Tru </b></span>&nbsp;&nbsp;<?php }?>
							</td>
							<td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo '--';?></td>
						</tr>
					<?php $j++;} } ?>
				</table>
				<?php } else { echo "<div align='center'  class='alert alert-block'><h4>File Not Available</h4></div>";}
	break;
	// for spl zone
		case 'mu_splzone':	$splzoneFileName = $_REQUEST['clip']; 
				$splzoneFileNamePath = "http://10.2.73.156:8080/hungama/config/AMUconfig/splzone/spconf/".$splzoneFileName.".cfg";
			    $lines1 = file($splzoneFileNamePath);
				$muFullDataValue = array();
				foreach ($lines1 as $line_num => $MUData2) {
					$muFullDataValue[] = $MUData2;
				} ?>
				<?php 
							$query = "select * from master_db.tbl_subcategory_master where catID=substr('".$clipValue."',3,2)";	
							$result = mysql_query($query,$dbConn);
							$data = mysql_fetch_row($result); 
							$catName = $data[0];//echo $clipValue;
							$catName=$splzoneFileName.".cfg";
							?>
<ul class="breadcrumb">
<li>  
    <a href="javascript:void(0)" onclick="showMainMenu('<?= $lang?>','<?= $circle?>','AirtelEU')">Root</a> <span class="divider">/</span>  
  </li>
  <li>  
    <a href="javascript:void(0)" onclick="showContent('mu','<?= $circle?>','<?= $lang?>')">Music Unlimited</a> <span class="divider">/</span>  
  </li> 
  <li class="active">  
    Spl Zone
  </li> 
  <!--li class="active">  
    <?= $catName;?>
  </li-->  
</ul> 			
			<!--div align='left' class="tab-content">
						<div class="well well-small">
						<span class="label label-important">Circle</span>&nbsp;&nbsp;<?php echo $circle_info[$circle];?>&nbsp;&nbsp;
						<span class="label label-info">Language</span>&nbsp;&nbsp;<?php echo $languageData[$lang];?>&nbsp;&nbsp;
						<span class="label label-success">File Name</span>&nbsp;&nbsp;<?php 
						//echo "<a href='".$splzoneFileNamePath."' target='_blank'>".$catName."</a>";
						echo "<a href='javascript:void(0)'>".$catName."</a>";
							?>&nbsp;&nbsp;
							</div>
				</div-->
		<table align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" width="100%" class="table table-bordered table-condensed">		
					  <tr align='center'>
						<td style="padding-left: 5px;" bgcolor="#ffffff" height="35" width="10%"><b>Sequence number</b></td>
						<td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>SongUniquecode</b></td>
						<td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>ContentName</b></td>
						<td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>AlbumName</b></td>
						<td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>Language</b></td>
						<td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>Ringtones </b></td>
						<td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>CRBT</b></td>
					</tr>
					<?php $j=1; for($i=0; $i<count($muFullDataValue); $i++) { if($muFullDataValue[$i]) { 
//$query = "select AlbumName,ContentName from master_db.master_content where SongUniqueCode='".trim(substr($muFullDataValue[$i],4))."'";	
//$query = "select SongUniqueCode,ContentName,AlbumName,language,Genre,MT_ID,PT_ID,TT_ID from misdata.content_musicmetadata where SongUniqueCode='".trim(substr($muFullDataValue[$i],4))."'";
$query = "select a.SongUniqueCode as SongUniqueCode,a.ContentName as ContentName,a.AlbumName as AlbumName,a.language as language,a.Genre as Genre,a.MT_ID as MT_ID,a.PT_ID as PT_ID,a.TT_ID as TT_ID,b.CRBTId_1 as CRBTId_1 from misdata.content_musicmetadata as a LEFT JOIN  misdata.content_servicedata as b ON a.SongUniqueCode=b.SongUniqueCode and b.Service='AirtelEU' where a.SongUniqueCode='".trim(substr($muFullDataValue[$i],4))."'";
						$result = mysql_query($query,$dbConn_218);
						$data = mysql_fetch_array($result);  //print_r($data);	?>
						<!--tr>
							<td style="padding-left: 5px;" bgcolor="#ffffff" height="35" align='center'><?php echo $j;?></td>
							<td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo $muFullDataValue[$i];?></td>
							<td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo $data['AlbumName'];?></td>
							<td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo $data['ContentName'];?></td>
						</tr-->
						
						<tr>
							<td style="padding-left: 5px;" bgcolor="#ffffff" height="35" align='center'><?php echo $j;?></td>
							<td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo trim(substr($muFullDataValue[$i],4));?></td>
							<td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo $data['ContentName'];?></td>
							<td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo $data['AlbumName'];?></td>
							<td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo $data['language'];?></td>
							<td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;
							<?php //echo $data['MT_ID'].''.$data['PT_ID'].''.$data['TT_ID'];?>
						<?php if(!empty($data['MT_ID'])){?>	<span class="label label-important"><b>Mono</b></span>&nbsp;&nbsp;<?php }?>
						<?php if(!empty($data['PT_ID'])){?>&nbsp;&nbsp;<span class="label label-info"><b>Poly</b></span>&nbsp;&nbsp;<?php }?>
						<?php if(!empty($data['TT_ID'])){?>&nbsp;&nbsp;<span class="label label-success"><b>Tru </b></span>&nbsp;&nbsp;<?php }?>
							</td>
							<td style="padding-left: 5px;" bgcolor="#ffffff" height="35">
							<?php //echo $data['CRBTId_1'];?>
							<?php if(!empty($data['CRBTId_1'])){?>	<span class="label label-important"><b><?php echo $data['CRBTId_1'];?></b></span>&nbsp;&nbsp;<?php }?>
							</td>
						</tr>
					<?php $j++;} } ?>
				</table><?php
	break;
} //switch case end maindiv
?>