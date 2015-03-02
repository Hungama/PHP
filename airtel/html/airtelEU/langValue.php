<?php 
$languageData = array('01'=>'Hindi','02'=>'English','03'=>'Punjabi','04'=>'Bhojpuri','05'=>'Haryanavi','06'=>'Bengali','07'=>'Tamil','08'=>'Telugu',		'09'=>'Malayalam',10=>'Kannada','11'=>'Marathi','12'=>'Gujarati','13'=>'Oriya','14'=>'Kashmiri','15'=>'Himachali','16'=>'Chhattisgarhi','17'=>'Assamese', '21'=>'Maithali','19'=>'Nepali','20'=>'Kumaoni','18'=>'Rajasthani');

$case=trim($_REQUEST['case']);
switch($case) {
	case '1': $circle=strtolower(trim($_GET['circle']));
		$filePath = "/var/lib/apache-tomcat-6.0.32/webapps/hungama/config/AMUconfig/".strtolower($circle)."/langorder.cfg";
		$lines = file($filePath);
		$lang = array();
		foreach ($lines as $line_num => $langData) {
			$langId=trim($langData);
			$langName = $languageData[$langId];	
			$lang[$langId]=$langName;
		}
		?>
		<select id="lang" name="lang" onchange="showMainMenu(this.value,'<?php echo $circle;?>');">
		<option value="">Select Language</option>
		<?php foreach ($lang as $langcode => $langName) {  ?>
			<option value="<?php echo $langcode;?>"><?php echo $langName;?></option>
		<?php }?>
		</select><?php 
	break; 
	case '2': $circle=strtolower(trim($_GET['circle']));
			  $lang = trim($_GET['lang']);	?>
		<select id="menu" name="menu" onchange="showContent(this.value,'<?php echo $circle;?>','<?php echo $lang;?>');">
			<option value="">Select Menu</option>
			<option value="ac">Audio Cinema</option>
			<option value="bg">Bollywood Gossip</option>
			<option value="mu">Music Unlimited</option>			
		</select><?php 
	break; 
	case '3': $circle=strtolower(trim($_GET['circle']));
			  $lang = trim($_GET['lang']);	
			  $service = trim($_GET['service']); 
			  if($service =='ac') { 
				  $ACfilePath = "/var/lib/apache-tomcat-6.0.32/webapps/hungama/config/AMUconfig/audiosongconfig/".$circle."/audiocinema_main.cfg";
				  $lines = file($ACfilePath);
					$acDataValue = array();
					foreach ($lines as $line_num => $ACData) {
						$acDataValue[] = $ACData;
						$flag=1;
					}?><select name='acMainData' id="acMainData" onchange="showACData(this.value,'<?php echo $circle;?>','<?php echo $lang;?>','ac');">
							<option value=''>Select Audio Data</option>	
							<?php for($j=1;$j<=count($acDataValue);$j++) { if($acDataValue[$j]) { ?>
							<option value='<?php echo $acDataValue[$j]?>'><?php echo $acDataValue[$j]?></option>	
							<?php } } ?>			  	
						</select> <?php 
			  } elseif($service == 'mu') { 
				$MUfilePath = "/var/lib/apache-tomcat-6.0.32/webapps/hungama/config/AMUconfig/".$circle."/mainmenuorder.cfg";
				$lines = file($MUfilePath);
				$muDataValue = array();
				foreach ($lines as $line_num => $MUData) {
					$muDataValue[] = $MUData;
				} ?><select name='muMainData' id="muMainData" onchange="showMUData(this.value,'<?php echo $circle;?>','<?php echo $lang;?>','ac');">
						<option value=''>Select MU Data</option>	
						<?php for($j=1;$j<=count($muDataValue);$j++) { if($muDataValue[$j]) { ?>
						<option value='<?php echo $muDataValue[$j]?>'><?php echo $muDataValue[$j]?></option>	
						<?php } } ?>			  	
					</select> <?php 
			  } elseif($service == 'bg') { $flag=0;
					$BGfilePath = "/var/lib/apache-tomcat-6.0.32/webapps/hungama/config/AMUconfig/BGconfig/gossip.cfg"; 
					$lines = file($BGfilePath);
					$bgDataValue = array();
					foreach ($lines as $line_num => $BGData) {
						$bgDataValue[] = $BGData;
						$flag=1;
					} ?>			  
				  <div align='center' width="95%"><b>Bollywood Gossip List</b></div>			
				  <?php if($flag) { ?>
				  <table border=1 width='60%' align='center'>		
					  <tr>
						<td width="10%">S.No</td>
						<td>Song Code</td>
					  </tr>
					  <?php for($i=1; $i<count($bgDataValue); $i++) { ?>				  				 
						<tr>
							<td><?php echo $i;?></td>
							<td><?php echo $bgDataValue[$i];?></td>
						</tr>
					  <?php } ?>
				  </table>
				  <?php } else { echo "<div align='center'>No data Available</div>";} ?>		 
			  <?php } ?>	
			  <?php 
	break; 
	case '4': $circle=strtolower(trim($_GET['circle']));
			  $lang = trim($_GET['lang']);	
			  $service = trim($_GET['service']); 
			  $clipCfg = trim($_GET['clip']); 

			  $ACClipFilePath = "/var/lib/apache-tomcat-6.0.32/webapps/hungama/config/AMUconfig/audiosongconfig/".$clipCfg."-clip.cfg";
			  $lines = file($ACClipFilePath);
				$acDataValue = array();
				foreach ($lines as $line_num => $ACData1) {
					$acClipDataValue[] = $ACData1;
				}?>
				<select name='acClip' id='acClip' onchange="showClipData(this.value,'<?php echo $circle;?>','<?php echo $lang;?>','ac')">
					<option value="">Select Clip Data</option>
					<?php for($i=0; $i<count($acClipDataValue); $i++) { if($acClipDataValue[$i]) { ?>
						<option value="<?php echo $acClipDataValue[$i];?>"><?php echo $acClipDataValue[$i];?></option>
					<?php } }?>					
				</select><?php
	break;
	case '5': $circle=strtolower(trim($_GET['circle']));
			  $lang = trim($_GET['lang']);	
			  $service = trim($_GET['service']); 
			  $fullFileCfg = trim($_GET['file']); 

			  $ACFullFilePath = "/var/lib/apache-tomcat-6.0.32/webapps/hungama/config/AMUconfig/audiosongconfig/FullAudioClip/".$fullFileCfg.".cfg";
			  $lines1 = file($ACFullFilePath);
				$acFullDataValue = array();
				foreach ($lines1 as $line_num => $ACData2) {
					$acFullDataValue[] = $ACData2;
				} ?>
				<div align='center' width="95%"><b>Audio Cinema Full Data</b></div>	
				  <table border=1 width='100%' align='center'>		
					  <tr>
						<td width="10%">S.No</td>
						<td>Song Code</td>
					  </tr>
					<?php $j=1; for($i=0; $i<count($acFullDataValue); $i++) { if($acFullDataValue[$i]) { ?>
						<tr>
							<td><?php echo $j;?></td>
							<td><?php echo $acFullDataValue[$i];?></td>
						</tr>
					<?php $j++;} } ?>
				</table><?php
	break; ?>
<?php } //switch case end maindiv?> 
