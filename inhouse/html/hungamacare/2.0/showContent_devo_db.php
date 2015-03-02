<?php
session_start();
//include ("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
require_once("incs/db.php");
$languageData = array('01'=>'Hindi','02'=>'English','03'=>'Punjabi','04'=>'Bhojpuri','05'=>'Haryanavi','06'=>'Bengali','07'=>'Tamil','08'=>'Telugu','09'=>'Malayalam','10'=>'Kannada','11'=>'Marathi','12'=>'Gujarati','13'=>'Oriya','14'=>'Kashmiri','15'=>'Himachali','16'=>'Chhattisgarhi','17'=>'Assamese', '21'=>'Maithali','19'=>'Nepali','20'=>'Kumaoni','18'=>'Rajasthani');
$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa', 'KAR'=>'Karnataka', 'HAR'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh',''=>'Other','HAY'=>'Haryana');
$circle=strtoupper(trim($_GET['circle']));
$lang = trim($_GET['lang']);	
$service = trim($_GET['cat']); 
$case=trim($_REQUEST['cat']);
$clipValue = $_REQUEST['clip'];

				$relFullFilePath = "http://10.2.73.156:8080/hungama/config/dev/airm/songconfig/".$clipValue.".cfg";
				
				$lines1 = file($relFullFilePath);
				$relFullDataValue = array();
				foreach ($lines1 as $line_num => $RelData) {
					$relFullDataValue[] = $RelData;
				} $totalFileData = count($relFullDataValue);?>
				
				<?php if ($totalFileData) { ?>
		<table align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1"  width="100%" class="table table-bordered table-condensed" role="grid">		
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
							<td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;</td>
						</tr>
					<?php $j++;} } ?>
				</table>
				<?php } else { echo "<div align='center'  class='alert alert-block'><h4>File Not Available</h4></div>";}
?>