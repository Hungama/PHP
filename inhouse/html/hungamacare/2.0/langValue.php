<?php
session_start();
//require_once("incs/db.php");
//include ("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
require_once("incs/db.php");
$languageData = array('01'=>'Hindi','02'=>'English','03'=>'Punjabi','04'=>'Bhojpuri','05'=>'Haryanavi','06'=>'Bengali','07'=>'Tamil','08'=>'Telugu','09'=>'Malayalam','10'=>'Kannada','11'=>'Marathi','12'=>'Gujarati','13'=>'Oriya','14'=>'Kashmiri','15'=>'Himachali','16'=>'Chhattisgarhi','17'=>'Assamese', '21'=>'Maithali','19'=>'Nepali','20'=>'Kumaoni','18'=>'Rajasthani');
$AudioCinemaData = array('0121'=>'Bollywood New Releases','22'=>'Classics - Bollywood','23'=>'Best of Bollywood','24'=>'Love Hits','21'=>'Hits');

$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa', 'KAR'=>'Karnataka', 'HAR'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh',''=>'Other','HAY'=>'Haryana');
$airtel_devotional_mapping= array('cat0131'=>'TheHolyBible','cat0132'=>'Gospelsongs','cat0133'=>'Dharmik Granth','cat0134'=>'Maryada Purshottam Shri Ram','cat0135'=>'Murlidharshri Krishna','cat0136'=>'DeviMaa','cat0137'=>'SankatmochanShri Hanuman','cat0138'=>'Bhagwan BholeShankar','cat0139'=>'MangalkarishriGanesh','cat0140'=>'Shridike Sai Baba','cat0141'=>'Bhajan Sangam','cat0142'=>'Aayaten ','cat0143'=>'Naat Shareif','cat0144'=>'Darood Sharief','cat0145'=>'Dua','cat0146'=>'Quwwalies','cat0147'=>'Muslim Devotional','cat0148'=>'Bhaktamber Stotra','cat0149'=>'Mantra/Chalisa','cat0150'=>'Aarti','cat0151'=>'Bhakti Geet','cat0152'=>'Vandana','cat0153'=>'Chants','cat0154'=>'Bhajans','cat0231'=>'The Holy Bible','cat0232'=>'Gospel songs','cat0233'=>'Hymns','cat0234'=>'Christmas Songs','cat0331'=>'Hukamnama','cat0332'=>'Paath','cat0333'=>'Mukhwak','cat0335'=>'Ardaas','cat0336'=>'DharmikGeet','cat0337'=>'Shabadkeertan','cat0338'=>'Gurbani','cat0431'=>'Devi Geet','cat0432'=>'Bhagwan Bhole Shankar Ke Bhajan','cat0433'=>'Chhath Pooja ke Geet','cat0434'=>'Bhajan Sangam','cat0631'=>'DebiMaagaan','cat0632'=>'ShriKrishnaBhajan','cat0633'=>'ShibaBhajan','cat0634'=>'BhajanSangam','cat0731'=>'BalajiBhajan','cat0732'=>'Ayyappa','cat0733'=>'Murugan','cat0734'=>'BhajanSangam','cat0739'=>'AayatenTamilTranslation','cat0831'=>'Suprabhatam','cat0832'=>'Ayyappa','cat0833'=>'Sai Baba','cat0834'=>'Hanuman','cat0835'=>'Ganesha','cat0836'=>'Krishna','cat0837'=>'BhajanSangam','cat0839'=>'Balaji Bhajan','cat0931'=>'AayatenMalayamTranslation
','cat0932'=>'ChristianDevotional','cat0935'=>'Krishna','cat0936'=>'Devi maa','cat0937'=>'Ganesha','cat0938'=>'Shiva','cat0939'=>'BhajanSangam','cat0940'=>'Mapilla Devotional','cat1031'=>'Suprabhatam','cat1032'=>'Hanuman','cat1033'=>'Bhajan','cat1231'=>'Shiv bhajan','cat1232'=>'Krishna Bhajan','cat1233'=>'Swaminarayan Kirtan','cat1234'=>'Bhajan Sangam','cat1431'=>'Naat Shareif','cat1432'=>'Hamud','cat1433'=>'Mankabhat','cat1434'=>'Manajhaat','cat1631'=>'Devi Geet','cat1632'=>'Bhajan Sangam','cat1731'=>'Bhajan Sangam','cat1732'=>'Shankardeb Bhajans','cat1831'=>'Khatu Shyam','cat1832'=>'Salasar Ke Balaji','cat1833'=>'Srinathji','cat1834'=>'Baba Ramdev','cat1835'=>'Goga Peer','cat1836'=>'Bhajan Sangam','cat1131'=>'sai Baba','cat1132'=>'GanpatiBhajan','cat1133'=>'Bhakti Geet');
$case=trim($_REQUEST['case']);
$catname = $_GET['catname']; 
$_SESSION['Sessionclip']=trim($_GET['clip']);
$_SESSION['mucatname_other']=trim($_GET['mucatname']);

switch($case) {
	case '1': $circle=strtolower(trim($_GET['circle']));
			  $service=trim($_GET['service']); 	
			if($service == 'AirtelEU') { 
				if($circle == 'pub') $circle ='pun';
				$filePath = "http://10.2.73.156:8080/hungama/config/AMUconfig/".strtolower($circle)."/langorder.cfg";
			} elseif ($service == 'AirtelDevo') { 				
				$filePath = "http://10.2.73.156:8080/hungama/config/dev/airm/".strtolower($circle)."/navlang.cfg";
			}
			elseif($service == 'TataDoCoMoMX')
			{
			$filePath = "http://192.168.100.227:8081/hungama/config/config/tatm/".strtolower($circle)."/langorder.cfg";
			}
		
			$lines = file($filePath);
			$lang = array();
			foreach ($lines as $line_num => $langData) {
				$langId=trim($langData);
				$langName = $languageData[$langId];	
				$lang[$langId]=$langName;
			} 	?>
			<select id="lang" name="lang" onchange="showMainMenu(this.value,'<?php echo $circle;?>','<?php echo $service;?>');" class='txt'>
			<option value="">Select Language</option>
			<?php foreach ($lang as $langcode => $langName) {  ?>
				<option value="<?php echo $langcode;?>"><?php echo $langName;?></option>
			<?php }?>
			</select><?php 
	break; 
	case '2': $circle=strtolower(trim($_GET['circle']));
			  $service=trim($_GET['service']); 		
			  $lang = trim($_GET['lang']);	
			  if($service == "AirtelEU") { if($circle == 'pub') $circle ='pun'; ?>			  
				 <div align='left' class="tab-content">
						<div class="alert">
		
			Displaying For Airtel AirtelEU For <strong><?php echo $circle_info[strtoupper($circle)];?></strong> For <strong><?php echo $languageData[$lang];?></strong> Navigation Language
					</div>
				</div>
				  <div id="mainmenu_cat_div_eu">
				  <table width="100%" class="table table-condensed table-bordered" id="example">
					 <thead> <tr>
						<td><span class="label">&nbsp;&nbsp;&nbsp;1&nbsp;&nbsp;&nbsp;</span>&nbsp;<a href="#" onclick="showContent('ac','<?php echo $circle;?>','<?php echo $lang;?>');">Audio Cinema</a></td>
						<td>
						<span class="label">&nbsp;&nbsp;&nbsp;2&nbsp;&nbsp;&nbsp;</span>&nbsp;<a href="javascript:void(0);" onclick="showContent_data('bg','<?php echo $circle;?>','<?php echo $lang;?>')">Bollywood Gossip</a>
						</td>
						<td><span class="label">&nbsp;&nbsp;&nbsp;3&nbsp;&nbsp;&nbsp;</span>&nbsp;<a href="#" onclick="showContent('mu','<?php echo $circle;?>','<?php echo $lang;?>');">Music Unlimited</a></td>
					  </tr>
                     </thead>					  
				  </table>
				  </div>
				  <?php 
			  } elseif($service == "AirtelDevo") { 
				$filePath = "http://10.2.73.156:8080/hungama/config/dev/airm/songconfig/mainmenu.cfg";
		        $lines = file($filePath);
				$religionMenu = array();
				foreach ($lines as $line_num => $RelData) {
					$religionMenu[]=$RelData;
				} ?>	
 <div align='left' class="tab-content">
						<div class="alert">
				Displaying For Airtel Devotional For <strong><?php echo $circle_info[strtoupper($circle)];?></strong> For <strong><?php echo $languageData[$lang];?></strong> Navigation Language
					</div>
				</div>
				<div id="mainmenu_cat_div_devo">
				  <table width="100%" class="table table-condensed table-bordered">
					<tr>
					<?php for($i=0;$i<count($religionMenu);$i++) { ?>
						<td width='20%'><a href="#" onclick="showDevoContent('<?php echo trim($religionMenu[$i]);?>','<?php echo $lang;?>','<?php echo $circle;?>')"><?php echo ucwords($religionMenu[$i]);?></a></td>
					<?php
					} ?>
					  </tr>				  
				  </table>
				  </div>
				  <?php
			  }
			  elseif($service == "TataDoCoMoMX")
			  {
			echo $DOCOMOfilePath = "http://192.168.100.227:8081/hungama/config/config/tatm/".$circle."/mainmenuorder.cfg";
				$lines = file($DOCOMOfilePath);
				$muDataValue = array();
				foreach ($lines as $line_num => $MUData) {
					$muDataValue[] = $MUData;
				} ?>
				<ul class="breadcrumb">  
  <li>  
    <a href="javascript:void(0)" onclick="showMainMenu('<?= $lang?>','<?= $circle?>','TataDoCoMoMX')">Root</a> <span class="divider">/</span>  
  </li>  
   <li class="active">Docomo Endless</li> 
</ul>	 
					 		<div id="tabs4-pane2" class="tab-pane">
		     <table class="table table-bordered">
								 <tr> 
					<?php $k=1;$i=-1; for($j=0;$j<=count($muDataValue);$j++) { 
					 $i++; 
							 if($i%3==0 && $i !=0) {
									 echo "</tr><tr>";
								 }
					if(!empty($muDataValue[$j])) { 
						if($muDataValue[$j] == '18') {
							$lang1=substr($muDataValue[$j],0,2);
							$album="Other Categories";								
							$flag=2;
							
						} 
			           else if($muDataValue[$j]==00)
					   {
					    $lang = trim($_GET['lang']);
					   //read file here for spl zone content
					$todaytime=date(jm);
					$SPLZONEFilePath = "http://10.2.73.156:8080/hungama/config/AMUconfig/splzone/mod/".$lang."_spzone.cfg";
$mainsplzonefilePath='';					
				$lines = file($SPLZONEFilePath);
$allani= array();
foreach ($lines as $line_num => $datename)
 {
$spzoneCfile=explode(":", trim($datename));
if($spzoneCfile[0]==$todaytime)
{

$mainsplzonefilePath=$lang."00_".$spzoneCfile[1];
}
}				   
					   $flag=9;
					   }
						else {
            		 $query = "select * from master_db.tbl_subcategory_master where catID=substr('".$muDataValue[$j]."',3,2)";	
						//echo "<br>";	
							$result = mysql_query($query,$dbConn);
							$data = mysql_fetch_row($result);
							$flag=0;
							if(!$data[0]) $album = 'Content Not Available';
							elseif($data[0] == 'unplugged') $album = 'Content Not Available';
							else { 
								$lang1=substr($muDataValue[$j],0,2);
								$album=$languageData[$lang1]."-".$data[0];								
								$flag=1;
							}
								
						
						
						} ?>
											
<!--- table box start here-->
<?php
							 
							
								
								 ?> 
                                 <td><span class="label">&nbsp;&nbsp;&nbsp;<?php echo $k;?>&nbsp;&nbsp;&nbsp;</span>
							
<?php if($flag==1) {?>
		<a href="javascript:void(0);" onclick="showContent_data('mu','<?php echo $circle;?>','<?php echo $lang;?>','<?php echo trim($muDataValue[$j]);?>','<?php echo $album;?>')"><?php echo $album;?></a>
							
<?php } elseif($flag==2) { ?><a href="#" onclick="showMUCateData('mu','<?php echo $circle;?>','<?php echo $lang;?>','Other Categories','1');"><?php echo $album;?></a><?php } 
elseif($flag==3) { 
?><a href="#" onclick="showMUspData('mu','<?php echo $circle;?>','<?php echo $lang;?>');"><?php echo $album;?></a><?php 
}
elseif($flag==9)
{
//echo '--SPL Zone';
?>
<a href="javascript:void(0);" onclick="showContent_data('mu_splzone','<?php echo $circle;?>','<?php echo $lang;?>','<?php echo trim($mainsplzonefilePath);?>','SPL ZONE')"><?php echo 'SPL Zone';?></a>
<?php
} ?>



							    </td>
								   
								   
<!--- table box end here-->
						
						
					<?php $k++;} 
					}
					?>
<?php
for($k1=1;$k1<(3-$i%3);$k1++) {
								 //  echo "<td>&nbsp;</td>";
								   }
								    ?>
                                  </tr>
               </table>
           </div>					
				<!--/table-->
			  <?php }
	break; 
	case '3': $circle=strtolower(trim($_GET['circle']));
			  $lang = trim($_GET['lang']);	
			  $service = trim($_GET['service']); 
			  if($circle == 'pub') $circle ='pun';
			
			  if($service =='ac') { 
				 $ACfilePath = "http://10.2.73.156:8080/hungama/config/AMUconfig/audiosongconfig/".$circle."/audiocinema_main.cfg";
				//echo $ACfilePath;
				  $lines = file($ACfilePath);
					$acDataValue = array();
					foreach ($lines as $line_num => $ACData) {
						$acDataValue[] = $ACData;
						$flag=1;
					}?>

					<!--table align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1"  width="80%" class="table table-condensed table-bordered">
					 <thead><tr>
							<th style="padding-left: 5px;" bgcolor="#ffffff" height="35" width='20%' align='center'>DTMF</th>
							<th style="padding-left: 5px;" bgcolor="#ffffff" height="35" align='center'>Category Name</th>
						</tr>	
					</thead-->	
					<ul class="breadcrumb">  
  <li>  
    <a href="javascript:void(0)" onclick="showMainMenu('<?= $lang?>','<?= $circle?>','AirtelEU')">Root</a> <span class="divider">/</span>  
  </li>  
   <li class="active">Audio Cinema</li> 
</ul>
<div id="tabs4-pane2" class="tab-pane">
<!--- table box start for audio cinema here-->
		     <table class="table table-bordered">
								 <tr> 					
						<?php 
						$i=-1; for($j=0;$j<=count($acDataValue);$j++) {
$i++;  if($i%3==0 && $i!=0) {
									 echo "</tr><tr>";
								 }
					if($acDataValue[$j]) { 
// get category name start here

$AudioCinemaData = array('0121'=>'Bollywood New Releases','22'=>'Classics - Bollywood','23'=>'Best of Bollywood','24'=>'Love Hits','21'=>'Hits');
			foreach ($AudioCinemaData as $k => $v)
							{
						//	echo trim($acDataValue[$j])."<br>";
						if(trim($acDataValue[$j])=='0121')
{
$catgname="Bollywood New Releases";
}
else
{
if($k==substr(trim($acDataValue[$j]),-2))
									{
									$catgname=$v;
									}
}	
							
									
							}


$lang1=substr($acDataValue[$j],0,2);
							$album=$languageData[$lang1]."-".$catgname;
							$flag=1;
				
						?>
						
<?php
							 
							
								 ?> 
                                 <td><span class="label">&nbsp;&nbsp;&nbsp;<?php echo $j+1;?>&nbsp;&nbsp;&nbsp;</span>
							
<?php if($flag) {?>
<a href='#' onclick="javascript:showACData('<?php echo trim($acDataValue[$j]);?>','<?php echo $circle;?>','<?php echo $lang;?>','ac','<?php echo $album;?>');">
<?php echo $album;?></a><?php }
 else { 
 echo trim($album);
 }?>


							    </td>
								   
								   

						
						
						<?php } } ?>	

<?php
		
for($k1=1;$k1<=(3-$i%3);$k1++) {
								echo "<td>&nbsp;</td>";
								// echo "<td>&nbsp;</td>";
								   }
								    ?>
                                  </tr>
               </table>
			   <!--- table box end here-->
           </div>						
					<!--/table--><?php 
			  } elseif($service == 'mu') { 
				$MUfilePath = "http://10.2.73.156:8080/hungama/config/AMUconfig/".$circle."/mainmenuorder.cfg";
				$lines = file($MUfilePath);
				$muDataValue = array();
				foreach ($lines as $line_num => $MUData) {
					$muDataValue[] = $MUData;
				} ?>
				<ul class="breadcrumb">  
  <li>  
    <a href="javascript:void(0)" onclick="showMainMenu('<?= $lang?>','<?= $circle?>','AirtelEU')">Root</a> <span class="divider">/</span>  
  </li>  
   <li class="active">Music Unlimited</li> 
</ul>	 
					 		<div id="tabs4-pane2" class="tab-pane">
		     <table class="table table-bordered">
								 <tr> 
					<?php $k=1;$i=-1; for($j=0;$j<=count($muDataValue);$j++) { 
					 $i++; 
							 if($i%3==0 && $i !=0) {
									 echo "</tr><tr>";
								 }
					if(!empty($muDataValue[$j])) { 
						if($muDataValue[$j] == '24') {
							$lang1=substr($muDataValue[$j],0,2);
							$album="Other Categories";								
							$flag=2;
							
						} 
			           else if($muDataValue[$j]==00)
					   {
					    $lang = trim($_GET['lang']);
					   //read file here for spl zone content
					$todaytime=date(jm);
					$SPLZONEFilePath = "http://10.2.73.156:8080/hungama/config/AMUconfig/splzone/mod/".$lang."_spzone.cfg";
$mainsplzonefilePath='';					
				$lines = file($SPLZONEFilePath);
$allani= array();
foreach ($lines as $line_num => $datename)
 {
$spzoneCfile=explode(":", trim($datename));
if($spzoneCfile[0]==$todaytime)
{

$mainsplzonefilePath=$lang."00_".$spzoneCfile[1];
}
}

					   
					   
					   
					   $flag=9;
					   }
						else {
            		 $query = "select * from master_db.tbl_subcategory_master where catID=substr('".$muDataValue[$j]."',3,2)";	
						//echo "<br>";	
							$result = mysql_query($query,$dbConn);
							$data = mysql_fetch_row($result);
							$flag=0;
							if(!$data[0]) $album = 'Content Not Available';
							elseif($data[0] == 'unplugged') $album = 'Content Not Available';
							else { 
								$lang1=substr($muDataValue[$j],0,2);
								$album=$languageData[$lang1]."-".$data[0];								
								$flag=1;
							}
								
						
						
						} ?>
											
<!--- table box start here-->
<?php
							 
							
								
								 ?> 
                                 <td><span class="label">&nbsp;&nbsp;&nbsp;<?php echo $k;?>&nbsp;&nbsp;&nbsp;</span>
							
<?php if($flag==1) {?>
		<a href="javascript:void(0);" onclick="showContent_data('mu','<?php echo $circle;?>','<?php echo $lang;?>','<?php echo trim($muDataValue[$j]);?>','<?php echo $album;?>')"><?php echo $album;?></a>
							
<?php } elseif($flag==2) { ?><a href="#" onclick="showMUCateData('mu','<?php echo $circle;?>','<?php echo $lang;?>','Other Categories','1');"><?php echo $album;?></a><?php } 
elseif($flag==3) { 
?><a href="#" onclick="showMUspData('mu','<?php echo $circle;?>','<?php echo $lang;?>');"><?php echo $album;?></a><?php 
}
elseif($flag==9)
{
//echo '--SPL Zone';
?>
<a href="javascript:void(0);" onclick="showContent_data('mu_splzone','<?php echo $circle;?>','<?php echo $lang;?>','<?php echo trim($mainsplzonefilePath);?>','SPL ZONE')"><?php echo 'SPL Zone';?></a>
<?php
} ?>



							    </td>
								   
								   
<!--- table box end here-->
						
						
					<?php $k++;} 
					}
					?>
<?php
for($k1=1;$k1<(3-$i%3);$k1++) {
								 //  echo "<td>&nbsp;</td>";
								   }
								    ?>
                                  </tr>
               </table>
           </div>					
				<!--/table-->
				
				<?php }	 
	break; 
	case '4': $service = trim($_GET['service']); 
			  $circle=strtolower(trim($_GET['circle']));
			  $lang = trim($_GET['lang']);	
			  if($circle == 'pub') $circle ='pun';
			  $catname = $_GET['catname']; 
			 $_SESSION['bc_catname']=$catname;
			  $_SESSION['mucatname']=$_GET['mucatname'];
			  if($service=='ac') { 
				  $clipCfg = trim($_GET['clip']); 
				$ACClipFilePath = "http://10.2.73.156:8080/hungama/config/AMUconfig/audiosongconfig/".$clipCfg."-clip.cfg";
				  $lines = file($ACClipFilePath);
					$acDataValue = array();
					foreach ($lines as $line_num => $ACData1) {
						$acClipDataValue[] = $ACData1;
					}?>
<ul class="breadcrumb">
<li>  
    <a href="javascript:void(0)" onclick="showMainMenu('<?= $lang?>','<?= $circle?>','AirtelEU')">Root</a> <span class="divider">/</span>  
  </li>
  <li>  
    <a href="javascript:void(0)" onclick="showContent('ac','<?= $circle?>','<?= $lang?>')">Audio Cinema</a> <span class="divider">/</span>  
  </li>  
 <li class="active"><?= $catname;?></li> 
</ul>  
					<table align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1"  width="80%" class="table table-condensed table-bordered">
						</thead>
						<!--tr align='center'>
							<th style="padding-left: 5px;" bgcolor="#ffffff" height="35" width='20%' width='20%'>S.No.</th>
							<th style="padding-left: 5px;" bgcolor="#ffffff" height="35">ClipName</th>	
						</tr-->
						  <tr align='center'>
						<td style="padding-left: 5px;" bgcolor="#ffffff" height="35" width="10%"><b>S.No#</b></td>
						<td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>SongUniquecode</b></td>
						<td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>ContentName</b></td>
						<td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>AlbumName</b></td>
						<td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>Language</b></td>
						</tr>
						</thead>
						<?php $k=1; for($i=0; $i<count($acClipDataValue); $i++) {
$tempFileName = explode(".", $acClipDataValue[$i]) ;
						if($tempFileName[1]!='wav') { ?>
						<!--tr>
							<td style="padding-left: 5px;" bgcolor="#ffffff" height="35" width='20%' align='center'><?php echo $k;?></td>
							<td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;
				<a href="javascript:void(0);" onclick="showContent_data('ac','<?php echo $circle;?>','<?php echo $lang;?>','<?php echo trim($acClipDataValue[$i]);?>')"><?php echo $acClipDataValue[$i];?></a>
		</td>
						</tr-->
					<?php	
					$query = "select SongUniqueCode,ContentName,AlbumName,language,Genre from misdata.content_musicmetadata where SongUniqueCode='".trim($acClipDataValue[$i])."'";
					$result = mysql_query($query,$dbConn_218);
						$data = mysql_fetch_array($result); 
						//print_r($data);	?>
						<tr>
							<td style="padding-left: 5px;" bgcolor="#ffffff" height="35" align='center'><?php echo $i+1;?></td>
							<td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo trim($acClipDataValue[$i]);?></td>
							<td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo $data['ContentName'];?></td>
							<td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo $data['AlbumName'];?></td>
							<td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo $data['language'];?></td>
						
						</tr>
						<?php $k++; } }?>		
					</table><?php
			  } elseif($service == 'mu') {
			$MUCatFilePath = "http://10.2.73.156:8080/hungama/config/AMUconfig/".$circle."/catorder.cfg";
				$lines = file($MUCatFilePath);
				$muCatDataValue = array();
				$startfrom=trim($_REQUEST['startfrom']);
			/*	$m=0;
				foreach ($lines as $line_num => $MUData) {
					if($m<6)
					{$langCode = trim($MUData);
					$langName = $languageData[$langCode];
					$muCatDataValue[$langCode] = $langName;}
					else 
					{
					break;
					}
				$m++;
				}
				*/
				switch($startfrom) {
case '1':
$m=0;
				foreach ($lines as $line_num => $MUData) {
					if($m<6)
					{$langCode = trim($MUData);
					$langName = $languageData[$langCode];
					$muCatDataValue[$langCode] = $langName;}
					else 
					{
					break;
					}
				$m++;
				}
break; 
	case '2':
	$m=6;
    $c=1;
				foreach ($lines as $line_num => $MUData) {
				
			if($c>6){
			if($m<12)
					{
					$langCode = trim($MUData);
					$langName = $languageData[$langCode];
					$muCatDataValue[$langCode] = $langName;
					$m++;
					}
					else 
					{
					$m++;
					}
					}
				//$m++;
				$c++;
				}
	break; 
	case '3':
	$c=1;
			foreach ($lines as $line_num => $MUData) {		
	        if($c>12 && $c<=18){
					$langCode = trim($MUData);
					$langName = $languageData[$langCode];
					$muCatDataValue[$langCode] = $langName;
					}
				$c++;				
				}
				
	break;		
	case '4':
	$m=18;
	 $c=1;
		foreach ($lines as $line_num => $MUData) {
	        if($c>18){
			if($m<24)
					{
					$langCode = trim($MUData);
					$langName = $languageData[$langCode];
					$muCatDataValue[$langCode] = $langName;
					$m++;
					}
					else 
					{
					$m++;
					}
					}
				$c++;
				
				}
		break;
} //switch case end maindiv

?>	
<ul class="breadcrumb">
<li>  
    <a href="javascript:void(0)" onclick="showMainMenu('<?= $lang?>','<?= $circle?>','AirtelEU')">Root</a> <span class="divider">/</span>  
  </li>
  <li>  
    <a href="javascript:void(0)" onclick="showContent('mu','<?= $circle?>','<?= $lang?>')">Music Unlimited</a> <span class="divider">/</span>  
  </li> 
  <li class="active">
 <?php
 /*
 if($startfrom!=4) {?>
 <a href="#" style="color:#97310e" onclick="showMUCateData('mu','<?php echo $circle;?>','<?php echo $lang;?>','Other Categories','<?= $startfrom+1 ?>');"><?= $_SESSION['mucatname'];?></a>
 <?php }
 else
 {
 echo $_SESSION['mucatname'];
 }*/
 echo $_SESSION['mucatname'];
 ?>
 </li>
  <!--li class="active"><span class="divider">/</span> 
   <?php
 // echo $_SESSION['othesubcate'];
 ?>
 </li-->
</ul> 
	<!-- new code added for MU Others category data start here -->	
		
<div id="tabs4_othr" class="tab-pane" >
		     <table class="table table-bordered">
								 <tr> 					
						<?php 
									
						$i=-1; //for($j=0;$j<=count($muCatDataValue);$j++) {
						foreach($muCatDataValue as $key=>$value) {// echo $value."***";
						$i++; 
						if($i%3==0 && $i !=0) {
						echo "</tr><tr>";
								 }
							 ?> 
                      <td><span class="label">&nbsp;&nbsp;&nbsp;<?php echo $i+1;?>&nbsp;&nbsp;&nbsp;</span>
				<a href='#' onclick="javascript:showMUSubData('<?php echo $key;?>','<?php echo $circle;?>','mu');"><?php echo $value;?></a>
						  </td>
							<?php } ?>	
<?php
/*
$comtd=7;
for($k1=1;$k1<(3-$comtd%3);$k1++) { if($startfrom!=4) {?>

							<?php }
								   }
								   */
		?>
		<!--
		<tr><td <?php if(!$i){echo 'rowspan="2"';}?> ><ul class="pager"><li class="previous">
		<?php
		   if($startfrom>1 || $startfrom==4 ) {?>
		
		<a href="#" style="color:#97310e" onclick="showMUCateData('mu','<?php echo $circle;?>','<?php echo $lang;?>','Other Categories','<?= $startfrom-1 ?>');">Previous</a>
		
		<?php }
		if(!$i){ echo "</li></ul></td></tr>"; } else {
		echo "</li>
</ul></td><td>&nbsp;</td><td style='text-align:right'><ul class=\"pager\"><li class=\"next\">";
		?>
		<?php
	    if($startfrom!=4) {?>
		
 <a href="#" style="color:#97310e" onclick="showMUCateData('mu','<?php echo $circle;?>','<?php echo $lang;?>','Other Categories','<?= $startfrom+1 ?>');">Next</a>
 
 <?php }
		echo "</li>
</ul></td></tr>";}
		  ?>
			-->						
                                  </tr>
               </table>
			<div class="dataTables_paginate paging_bootstrap pagination">
			<ul>
			<li class="prev">
				<?php
		   if($startfrom>1 || $startfrom==4 ) {?>
			<a href="#" style="color:#97310e" onclick="showMUCateData('mu','<?php echo $circle;?>','<?php echo $lang;?>','Other Categories','<?= $startfrom-1 ?>');">&larr;Previous</a>
			<?php }
			 else 
			 {?>
			<a href="#" >&larr;Previous</a>
			 <?php
			 }
			 ?>
			</li>
			<li class="next">
			 <?php if($startfrom!=4) {?>
			<a href="#" style="color:#97310e" onclick="showMUCateData('mu','<?php echo $circle;?>','<?php echo $lang;?>','Other Categories','<?= $startfrom+1 ?>');">Next&rarr; </a>
			 <?php }
			 else
			 {?>
			 <a href="#" >Next&rarr; </a>
			 <?php }?>
			</li></ul></div>   
</div>
			<!-- code end here-->
				
				
			 <?php }
	break;
	case '5': $circle=strtolower(trim($_GET['circle']));
			  $lang = trim($_GET['lang']);	
			  $_SESSION['othesubcate']=$languageData[$lang];
			  $service = trim($_GET['service']); 
			  if($service == 'ac') { 
			  $fullFileCfg = trim($_GET['file']); 
			  if($circle == 'pub') $circle ='pun';

			  $ACFullFilePath = "http://10.2.73.156:8080/hungama/config/AMUconfig/audiosongconfig/FullAudioClip/".$fullFileCfg.".cfg";
			  $lines1 = file($ACFullFilePath);
				$acFullDataValue = array();
				foreach ($lines1 as $line_num => $ACData2) {
					$acFullDataValue[] = $ACData2;
				} ?>
				<div align='center' width="95%"><b>Audio Cinema Full Data</b></div>	
				  <table align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1"  width="80%" class="table table-condensed table-bordered">		
					  <thead>
					  <tr align='center'>
						<td style="padding-left: 5px;" bgcolor="#ffffff" height="35" width="10%">S.No#</td>
						<td style="padding-left: 5px;" bgcolor="#ffffff" height="35">Song Code</td>
					  </tr>
					  </thead>
					<?php $j=1; for($i=0; $i<count($acFullDataValue); $i++) { if($acFullDataValue[$i]) { ?>
						<tr>
							<td style="padding-left: 5px;" bgcolor="#ffffff" height="35" width="10%"><?php echo $j;?></td>
							<td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><?php echo $acFullDataValue[$i];?></td>
						</tr>
					<?php $j++;} } ?>
				</table><?php
			  } elseif($service == 'mu') {
			  $MUFullFilePath = "http://10.2.73.156:8080/hungama/config/AMUconfig/".$circle."/".$lang."_suborder.cfg";
			    $lines1 = file($MUFullFilePath);
				$muCatValue = array();
				foreach ($lines1 as $line_num => $MUData2) {
					$muCatValue[] = $MUData2;
				} ?>	
				<ul class="breadcrumb">
<li>  
    <a href="javascript:void(0)" onclick="showMainMenu('<?= $lang?>','<?= $circle?>','AirtelEU')">Root</a> <span class="divider">/</span>  
  </li>
  <li>  
    <a href="javascript:void(0)" onclick="showContent('mu','<?= $circle?>','<?= $lang?>')">Music Unlimited</a> <span class="divider">/</span>  
  </li> 
  
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
</ul> 
				<!--- table box start for mu othercategy data cinema here-->
		     <table class="table table-bordered">
								 <tr> 					
						<?php 
						$i=-1; for($j=0;$j<=count($muCatValue);$j++) {
$i++; 	 if($i%3==0 && $i!=0) {
									 echo "</tr><tr>";
								 }
					if($muCatValue[$j]) {  
						if($muCatValue[$j] == '24') {
							$lang1=substr($muCatValue[$j],0,2);
							$album="Other Categories";								
							$flag=2;
						} else {
							$query = "select * from master_db.tbl_subcategory_master where catID=substr('".$muCatValue[$j]."',3,2)";	
							$result = mysql_query($query,$dbConn);
							$data = mysql_fetch_row($result);
							$flag=0;
							if(!$data[0]) $album = 'Content Not Available';
							elseif($data[0] == 'unplugged') $album = 'Content Not Available';
							else { 
									$lang1=substr($muCatValue[$j],0,2);
									$album=$languageData[$lang1]."-".$data[0];								
									$flag=1;
							}
						} 
						?>
						
<?php
							 
						
								 ?> 
                                 <td><span class="label">&nbsp;&nbsp;&nbsp;<?php echo $j+1;?>&nbsp;&nbsp;&nbsp;</span>
							
<?php if($flag) {?>
<a href='#' onclick="showContent_data('mu','<?php echo $circle;?>','<?php echo $lang;?>','<?php echo trim($muCatValue[$j]);?>','<?php echo $album;?>','musub')">
<?php echo $album;?></a><?php }
 else { 
 echo trim($album);
 }?>


							    </td>
<?php } }
 ?>	

<?php
		
for($k1=1;$k1<=(3-$i%3);$k1++) {
								echo "<td>&nbsp;</td>";
								}
								    ?>
                                  </tr>
               </table>
			   <!--- table box end here-->
				<!--table align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1"  width="80%" class="table table-condensed table-bordered">
					<thead>
					<tr align='center'>
						<th style="padding-left: 5px;" bgcolor="#ffffff" height="35" width="20%">DTMF1</th>
						<th style="padding-left: 5px;" bgcolor="#ffffff" height="35">Category Name</th>
					</tr>
					</thead>
					<?php /* $k=1; for($j=0;$j<=count($muCatValue);$j++) { if($muCatValue[$j]) {  
						if($muCatValue[$j] == '24') {
							$lang1=substr($muCatValue[$j],0,2);
							$album="Other Categories";								
							$flag=2;
						} else {
							$query = "select * from master_db.tbl_subcategory_master where catID=substr('".$muCatValue[$j]."',3,2)";	
							$result = mysql_query($query);
							$data = mysql_fetch_row($result);
							$flag=0;
							if(!$data[0]) $album = 'Content Not Available';
							elseif($data[0] == 'unplugged') $album = 'Content Not Available';
							else { 
									$lang1=substr($muCatValue[$j],0,2);
									$album=$languageData[$lang1]."-".$data[0];								
									$flag=1;
							}
						} ?>
						<tr>
							<td style="padding-left: 5px;" bgcolor="#ffffff" height="35" align='center'><?php echo $k;?></td>
							<td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><?php if($flag==1) {?>
					<a href="javascript:void(0);" onclick="showContent_data('mu','<?php echo $circle;?>','<?php echo $lang;?>','<?php echo trim($muCatValue[$j]);?>','<?php echo $album;?>')"><?php echo $album;?></a>
					<?php } else { echo $album; }?></td>					
						</tr>	
					<?php $k++;} } */?>			  	
				</table-->
			  <?php } // end of elseif
	break; 
	case '6': $lang=$_GET['lang'];
			$religion=$_GET['religion'];
			$circle=$_GET['circle'];

			if($religion == 'hindu' && $lang=='01') { 
				$day = date("D");
				$relFileName = $religion.$lang."_".strtolower($day).".cfg";
			} else { 
				$relFileName = $religion.$lang.".cfg"; 
			}
		$relFilePath = "http://10.2.73.156:8080/hungama/config/dev/airm/songconfig/".$relFileName;
			$lines1 = file($relFilePath);
			$relCategoryData = array();
			foreach ($lines1 as $line_num => $RelData1) {
				$relCategoryData[] = $RelData1;
			} //print_r($relCategoryData); 
			if(count($relCategoryData)) { ?>
			<table align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1"  width="80%" class="table table-condensed table-bordered">
				<thead><tr align='center'>
					<th style="padding-left: 5px;" bgcolor="#ffffff" height="35" width="20%">DTMF</th>
					<th style="padding-left: 5px;" bgcolor="#ffffff" height="35">Category Name</th>
				</tr> 
				</thead>
				<?php for($i=0;$i<count($relCategoryData);$i++) { 
				$dataArray = explode("-",$relCategoryData[$i]);
				$total = "";
				$total = count($dataArray);
				$catData = "";
				if($dataArray[$total-1] == 0) { 
					for($k=0;$k<$total-1;$k++) {
						if($k==0) $catData =$dataArray[0];  //$catData = substr($relCategoryData[$i], 0, -2);
						else $catData .="-".$dataArray[$k];
					}
				} else {  $catData = $relCategoryData[$i]; }
			

		?>
				<tr>
					<td style="padding-left: 5px;" bgcolor="#ffffff" height="35" width="20%"  align='center'><?php $j=$i+1; echo $j;?></td>
					<td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;&nbsp;
<!--a href="showContent.php?cat=devo&clip=<?php echo $catData?>&circle=<?php echo $circle; ?>&lang=<?php echo $lang; ?>&rel=<?php echo $religion; ?>"><?php echo $catData;?></a-->
<a href="javascript:void(0);" onclick="showDevoContent_main('AirtelDevo','<?php echo $circle;?>','<?php echo $lang;?>','<?php echo $catData?>','<?php echo $religion;?>')">
<?php
if (array_key_exists($catData, $airtel_devotional_mapping)) {
    echo $airtel_devotional_mapping[$catData];
}
else
{
echo $catData;
}
?>
</a>
					</td>
				</tr> 	
				<?php } ?>
			</table>
			<?php } else {
				echo "<div align='center' class='txt'><br/>Data Not Available</div>";
			}
	break; ?>
<?php } //switch case end maindiv?> 
