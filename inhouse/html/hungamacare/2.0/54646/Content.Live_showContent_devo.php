<?php
session_start();
error_reporting(1);
require_once("db_connect_livecontent.php");
$languageData = array('01'=>'Hindi','02'=>'English','03'=>'Punjabi','04'=>'Bhojpuri','05'=>'Haryanavi','06'=>'Bengali','07'=>'Tamil','08'=>'Telugu','09'=>'Malayalam','10'=>'Kannada','11'=>'Marathi','12'=>'Gujarati','13'=>'Oriya','14'=>'Kashmiri','15'=>'Himachali','16'=>'Chhattisgarhi','17'=>'Assamese', '21'=>'Maithali','19'=>'Nepali','20'=>'Kumaoni','18'=>'Rajasthani');
$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa', 'KAR'=>'Karnataka', 'HAR'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh',''=>'Other','HAY'=>'Haryana');
$circle=strtoupper(trim($_GET['circle']));
$lang = trim($_GET['lang']);
$navlang = trim($_GET['navlang']);
$service = trim($_GET['cat']);
$case=trim($_REQUEST['cat']);
$clipValue = $_REQUEST['clip'];
$religion = $_REQUEST['rel'];

$catData_dayspl = array('hindu_00'.date(w)=>'Day SPL','temple-'.$lang=>'Temples','myth_stories-'.$lang=>'Mythological Stories','muslim_000'=>'Day SPL','budh_000'=>'SPL ZONE','jain_000'=>'SPL ZONE','sikh_000'=>'SPL ZONE','christian_000'=>'SPL ZONE','church-'.$lang=>'Church','gurudwara-'.$lang=>'Gurudwara');
$checkfortemples=explode('-',$clipValue);

switch($case) {
case 'AirtelDevo':
$relFullFilePath = "http://10.2.73.156:8080/hungama/config/dev/airm/songconfig/".$clipValue.".cfg";
				if($navlang=='undefined')
				{
				$navlang=$lang;
				}
				$lines1 = file($relFullFilePath);
				$relFullDataValue = array();
				foreach ($lines1 as $line_num => $RelData) {
					$relFullDataValue[] = $RelData;
				} $totalFileData = count($relFullDataValue);?>
	<ul class="breadcrumb">
<li>  
    <a href="javascript:void(0)" onclick="showMainMenu('<?= $lang?>','<?= $circle?>','AirtelDevo','<?= $navlang?>')">Root</a> <span class="divider">/</span>  
  </li>
  <li>  
    <a href="javascript:void(0)" onclick="showDevoContent('<?php echo $religion;?>','<?php echo $lang;?>','<?php echo $circle;?>','<?= $navlang?>','AirtelDevo')"><?php echo ucwords($religion);?></a> <span class="divider">/</span>  
  </li> 
  <li class="active">  
   <?php 
   if (array_key_exists($clipValue, $airtel_devotional_mapping)) {
    echo $airtel_devotional_mapping[$clipValue];
}
else
{
//echo $clipValue;
if (array_key_exists($clipValue, $catData_dayspl)) {
    echo $catData_dayspl[$clipValue];
}
else
{
echo $clipValue;
}

}
 ?>
  </li> 

</ul> 			
				<?php if ($totalFileData) { ?>
<!---- for temple/myth-stories & others start here----->
<?php
if(!empty($checkfortemples[1]))
{?>
	 <table class="table table-bordered">
								 <tr> 
					<?php $k=1;$i=-1; for($j=0;$j<count($relFullDataValue);$j++) { 
					 $i++; 
							 if($i%3==0 && $i !=0) {
									 echo "</tr><tr>";
								 }
				
						?>
<?php 
$temple_name_file=explode('-',$relFullDataValue[$j]);
$relFullFilePath_temple = "http://10.2.73.156:8080/hungama/config/dev/airm/songconfig/".trim($temple_name_file[0]).".cfg";
$content_temple = file($relFullFilePath_temple);
$org_templ_name = str_replace("__", "_", $content_temple[0]);
$temple_name=explode('_',$org_templ_name);
$query_temple = "select SongUniqueCode,ContentName from misdata.content_musicmetadata where SongUniqueCode='".$temple_name[1]."'";
				
		$result_temple = mysql_query($query_temple,$dbConn_218);
		$data_temple = mysql_fetch_array($result_temple); 		
?>
        <td><span class="label">&nbsp;&nbsp;&nbsp;<?php echo $k;?>&nbsp;&nbsp;&nbsp;</span>
							
<?php echo $data_temple[1];?>
</td>
		<?php $k++;}
					
					?>
<?php
for($k1=1;$k1<(3-$i%3);$k1++) {
								   echo "<td>&nbsp;</td>";
								   }
								    ?>
                                  </tr>
 </table>

<!---- for temple/myth-stories & others end here-----> 
		<?php } else {		?>
				
				
				
		<table align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1"  width="100%" class="table table-bordered table-condensed" role="grid">		
		   		    <tr align='center'>
						<td style="padding-left: 5px;" bgcolor="#ffffff" height="35" width="10%"><b>S.No#</b></td>
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
						<td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo $data['ContentName']?$data['ContentName']: "-";?>
						<td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo $data['AlbumName']?$data['AlbumName']:"-";?> </td>
						</td>
<td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo $data['language'];?></td>
							<td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;
						<?php if(!empty($data['MT_ID'])){?>	<span class="label label-important"><b>Mono</b></span>&nbsp;&nbsp;<?php }?>
						<?php if(!empty($data['PT_ID'])){?>&nbsp;&nbsp;<span class="label label-info"><b>Poly</b></span>&nbsp;&nbsp;<?php }?>
						<?php if(!empty($data['TT_ID'])){?>&nbsp;&nbsp;<span class="label label-success"><b>Tru </b></span>&nbsp;&nbsp;<?php }?>
							</td>
							<td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;</td>
						</tr>
					<?php $j++;} } ?>
				</table>
				
				<?php }} else { echo "<div align='center'  class='alert alert-block'>File Not Available</div>";}
break;
case 'MTSDevo':
$relFullFilePath = "http://10.130.14.106:8080/hungama/config/dev/mtsm/songconfig/".$clipValue.".cfg";
				if($navlang=='undefined')
				{
				$navlang=$lang;
				}
				$lines1 = file($relFullFilePath);
				$relFullDataValue = array();
				foreach ($lines1 as $line_num => $RelData) {
					$relFullDataValue[] = $RelData;
				} $totalFileData = count($relFullDataValue);?>
	<ul class="breadcrumb">
<li>  
    <a href="javascript:void(0)" onclick="showMainMenu('<?= $lang?>','<?= $circle?>','MTSDevo','<?= $navlang?>')">Root</a> <span class="divider">/</span>  
  </li>
  <li>  
    <a href="javascript:void(0)" onclick="showDevoContent('<?php echo $religion;?>','<?php echo $lang;?>','<?php echo $circle;?>','<?= $navlang?>','MTSDevo')"><?php echo ucwords($religion);?></a> <span class="divider">/</span>  
  </li> 
  <li class="active">  
   <?php 
   if (array_key_exists($clipValue, $airtel_devotional_mapping)) {
    echo $airtel_devotional_mapping[$clipValue];
}
else
{
//echo $clipValue;
if (array_key_exists($clipValue, $catData_dayspl)) {
    echo $catData_dayspl[$clipValue];
}
else
{
echo $clipValue;
}

}
 ?>
  </li> 

</ul> 			
				<?php if ($totalFileData) { ?>
<!---- for temple/myth-stories & others start here----->
<?php
if(!empty($checkfortemples[1]))
{?>
	 <table class="table table-bordered">
								 <tr> 
					<?php $k=1;$i=-1; for($j=0;$j<count($relFullDataValue);$j++) { 
					 $i++; 
							 if($i%3==0 && $i !=0) {
									 echo "</tr><tr>";
								 }
				
						?>
<?php 
$temple_name_file=explode('-',$relFullDataValue[$j]);
$relFullFilePath_temple = "http://10.130.14.106:8080/hungama/config/dev/mtsm/songconfig/".trim($temple_name_file[0]).".cfg";
$content_temple = file($relFullFilePath_temple);
$org_templ_name = str_replace("__", "_", $content_temple[0]);
$temple_name=explode('_',$org_templ_name);
$query_temple = "select SongUniqueCode,ContentName from misdata.content_musicmetadata where SongUniqueCode='".$temple_name[1]."'";
				
		$result_temple = mysql_query($query_temple,$dbConn_218);
		$data_temple = mysql_fetch_array($result_temple); 		
?>
        <td><span class="label">&nbsp;&nbsp;&nbsp;<?php echo $k;?>&nbsp;&nbsp;&nbsp;</span>
							
<?php echo $data_temple[1];?>
</td>
		<?php $k++;}
					
					?>
<?php
for($k1=1;$k1<(3-$i%3);$k1++) {
								   echo "<td>&nbsp;</td>";
								   }
								    ?>
                                  </tr>
 </table>

<!---- for temple/myth-stories & others end here-----> 
		<?php } else {		?>
				
				
				
		<table align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1"  width="100%" class="table table-bordered table-condensed" role="grid">		
		   		    <tr align='center'>
						<td style="padding-left: 5px;" bgcolor="#ffffff" height="35" width="10%"><b>S.No#</b></td>
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
						<td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo $data['ContentName']?$data['ContentName']: "-";?>
						<td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo $data['AlbumName']?$data['AlbumName']:"-";?> </td>
						</td>
<td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo $data['language'];?></td>
							<td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;
						<?php if(!empty($data['MT_ID'])){?>	<span class="label label-important"><b>Mono</b></span>&nbsp;&nbsp;<?php }?>
						<?php if(!empty($data['PT_ID'])){?>&nbsp;&nbsp;<span class="label label-info"><b>Poly</b></span>&nbsp;&nbsp;<?php }?>
						<?php if(!empty($data['TT_ID'])){?>&nbsp;&nbsp;<span class="label label-success"><b>Tru </b></span>&nbsp;&nbsp;<?php }?>
							</td>
							<td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;</td>
						</tr>
					<?php $j++;} } ?>
				</table>
				
				<?php }} else { echo "<div align='center'  class='alert alert-block'>File Not Available</div>";}
break;
               }
?>