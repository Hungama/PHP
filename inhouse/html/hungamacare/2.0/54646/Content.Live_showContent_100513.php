<?php
session_start();
error_reporting(0);
require_once("db_connect_livecontent.php");
$languageData = array('01' => 'Hindi', '02' => 'English', '03' => 'Punjabi', '04' => 'Bhojpuri', '05' => 'Haryanavi', '06' => 'Bengali', '07' => 'Tamil', '08' => 'Telugu', '09' => 'Malayalam', '10' => 'Kannada', '11' => 'Marathi', '12' => 'Gujarati', '13' => 'Oriya', '14' => 'Kashmiri', '15' => 'Himachali', '16' => 'Chhattisgarhi', '17' => 'Assamese', '21' => 'Maithali', '19' => 'Nepali', '20' => 'Kumaoni', '18' => 'Rajasthani');
$circle_info = array('DEL' => 'Delhi', 'GUJ' => 'Gujarat', 'WBL' => 'WestBengal', 'BIH' => 'Bihar', 'RAJ' => 'Rajasthan', 'UPW' => 'UP WEST', 'MAH' => 'Maharashtra', 'APD' => 'Andhra Pradesh', 'UPE' => 'UP EAST', 'ASM' => 'Assam', 'TNU' => 'Tamil Nadu', 'KOL' => 'Kolkata', 'NES' => 'NE', 'CHN' => 'Chennai', 'ORI' => 'Orissa', 'KAR' => 'Karnataka', 'HAY' => 'Haryana', 'PUN' => 'Punjab', 'MUM' => 'Mumbai', 'MPD' => 'Madhya Pradesh', 'JNK' => 'Jammu-Kashmir', 'PUB' => "Punjab", 'KER' => 'Kerala', 'HPD' => 'Himachal Pradesh', '' => 'Other');
?>
<?php
$circle = strtoupper(trim($_GET['circle']));
$lang = trim($_GET['lang']);
$service = trim($_GET['cat']);
$musubcat = trim($_GET['musubcat']);
$case = trim($_REQUEST['cat']);
switch ($case) {
    case 'bg': if ($service == 'bg') {
            $flag = 0;
            $BGfilePath = "http://10.2.73.156:8080/hungama/config/AMUconfig/BGconfig/gossip.cfg";
            $lines = file($BGfilePath);
            $bgDataValue = array();
            foreach ($lines as $line_num => $BGData) {
                //$query="SELECT ";
                $bgDataValue[] = $BGData;
                $flag = 1;
            }
            ?>			  
            <div>
                <ul class="breadcrumb">
                    <li>  
                        <a href="javascript:void(0)" onclick="showMainMenu('<?= $lang ?>','<?= $circle ?>','AirtelEU')">Root</a> <span class="divider">/</span>  
                    </li>
                    <li class="active">  
                        Bollywood Gossip
                    </li>
                </ul>
            </div>				
            <?php if ($flag) { ?>
                <table align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1"  width="100%" class="table table-bordered table-condensed">		
                    <tr>
                        <td style="padding-left: 5px;" bgcolor="#ffffff" height="35" width="10%"><b>S.No#</b></td>
                        <td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>SongUniquecode</b></td>
                        <td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>ContentName</b></td>
                        <td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>AlbumName</b></td>
                        <td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>Language</b></td>
                    </tr>
                    <?php for ($i = 1; $i < count($bgDataValue); $i++) { ?>				  				 

                        <?php
                        $query = "select SongUniqueCode,ContentName,AlbumName,language,Genre from misdata.content_musicmetadata where SongUniqueCode='" . trim($bgDataValue[$i]) . "'";
                        $result = mysql_query($query, $dbConn_218);
                        $data = mysql_fetch_array($result);
                        //print_r($data);	
                        ?>
                        <tr>
                            <td style="padding-left: 5px;" bgcolor="#ffffff" height="35" align='center'><?php echo $i + 1; ?></td>
                            <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo trim($bgDataValue[$i]); ?></td>
                            <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo $data['ContentName']; ?></td>
                            <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo $data['AlbumName']; ?></td>
                            <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo $data['language']; ?></td>

                        </tr>
                <?php } ?>
                </table>
            <?php } else {
                echo "<div align='center'  class='alert alert-block'>No data Available</div>";
            } ?>		 
        <?php
        }
        break;
    case 'ac': $clipValue = $_REQUEST['clip'];
        $ACFullFilePath = "http://10.2.73.156:8080/hungama/config/AMUconfig/audiosongconfig/FullAudioClip/" . $clipValue . ".cfg";
        $lines1 = file($ACFullFilePath);
        $acFullDataValue = array();
        foreach ($lines1 as $line_num => $ACData2) {
            $acFullDataValue[] = $ACData2;
        }
        ?>

        <ul class="breadcrumb">
            <li>  
                <a href="javascript:void(0)" onclick="showMainMenu('<?= $lang ?>','<?= $circle ?>','AirtelEU')">Root</a> <span class="divider">/</span>  
            </li>
            <li>  
                <a href="javascript:void(0)" onclick="showContent('ac','<?= $circle ?>','<?= $lang ?>')">Audio Cinema</a> <span class="divider">/</span>  
            </li>  
            <li>  
                <a href="#" onclick="javascript:showACData('<?= $_SESSION['Sessionclip'] ?>','<?= $circle ?>','<?= $lang ?>','ac','<?= $_SESSION['bc_catname'] ?>');"><?= $_SESSION['bc_catname'] ?></a><span class="divider">/</span>
            </li>  
            <li class="active"><?= $clipValue; ?></li> 
        </ul> 
        <table align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1"  width="100%" class="table table-bordered table-condensed" >		
            <tr align='center'>
                <td style="padding-left: 5px;" bgcolor="#ffffff" height="35" width="10%"><b>S.No#</b></td>
                <td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>Song Code</b></td>
            </tr>
        <?php $j = 1;
        for ($i = 0; $i < count($acFullDataValue); $i++) {
            if ($acFullDataValue[$i]) {
                ?>
                    <tr>
                        <td style="padding-left: 5px;" bgcolor="#ffffff" height="35" align='center'><?php echo $j; ?></td>
                        <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo $acFullDataValue[$i]; ?></td>
                    </tr>
                <?php $j++;
            }
        } ?>
        </table><?php
        break;
    case 'mu': $clipValue = $_REQUEST['clip'];
        $ACFullFilePath = "http://10.2.73.156:8080/hungama/config/AMUconfig/songconfig/" . $clipValue . ".cfg";
        $lines1 = file($ACFullFilePath);
        $muFullDataValue = array();
        foreach ($lines1 as $line_num => $MUData2) {
            $muFullDataValue[] = $MUData2;
        }
        ?>
            <?php
            $query = "select * from master_db.tbl_subcategory_master where catID=substr('" . $clipValue . "',3,2)";
            $result = mysql_query($query, $dbConn);
            $data = mysql_fetch_row($result);
            $catName = $data[0]; //echo $clipValue;
            ?>
        <ul class="breadcrumb">  
            <li>  
                <a href="javascript:void(0)" onclick="showMainMenu('<?= $lang ?>','<?= $circle ?>','AirtelEU')">Root</a> <span class="divider">/</span>  
            </li>
            <li>  
                <a href="javascript:void(0)" onclick="showContent('mu','<?= $circle ?>','<?= $lang ?>')">Music Unlimited</a> <span class="divider">/</span>  
            </li>  
                    <?php
                    if ($musubcat == 'musub') {
                        ?>
                <li>
                    <a href="javascript:void(0)" onclick="showMUCateData('mu','<?php echo $circle; ?>','<?php echo $lang; ?>','Other Categories','1');">
                <?php
                echo $_SESSION['mucatname'];
                ?>
                    </a>
                </li>
                <li><span class="divider">/</span> 
                    <a href="javascript:void(0)" onclick="showMUSubData('<?php echo $lang; ?>','<?php echo $circle; ?>','mu');">
            <?php
            echo $languageData[$lang];
            ?>
                    </a>
                </li>
            <?php
        }
        ?>
            <li class="active"> <?php if ($musubcat == 'musub') { ?><span class="divider">/</span>  <?php } ?>
        <?= $languageData[$lang] . '-' . $catName; ?>
            </li>  

        </ul> 			

        <table align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" width="100%" class="table table-bordered table-condensed" id="example_mu">		
            <tr align='center'>
                <td style="padding-left: 5px;" bgcolor="#ffffff" height="35" width="10%"><b>S.No#</b></td>
                <td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>SongUniquecode</b></td>
                <td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>ContentName</b></td>
                <td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>AlbumName</b></td>
                <td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>Language</b></td>
                <td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>Ringtones </b></td>
                <td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>CRBT </b></td>
            </tr>
                    <?php
                    $j = 1;
                    for ($i = 0; $i < count($muFullDataValue); $i++) {
                        if ($muFullDataValue[$i]) {
                            $query = "select a.SongUniqueCode as SongUniqueCode,a.ContentName as ContentName,a.AlbumName as AlbumName,a.language as language,a.Genre as Genre,a.MT_ID as MT_ID,a.PT_ID as PT_ID,a.TT_ID as TT_ID,b.CRBTId_1 as CRBTId_1 from misdata.content_musicmetadata as a LEFT JOIN  misdata.content_servicedata as b ON a.SongUniqueCode=b.SongUniqueCode and b.Service='AirtelEU' where a.SongUniqueCode='" . trim(substr($muFullDataValue[$i], 4)) . "'";
                            $result = mysql_query($query, $dbConn_218);
                            $data = mysql_fetch_array($result);  //print_r($data);	
                            ?>
                    <tr>
                        <td style="padding-left: 5px;" bgcolor="#ffffff" height="35" align='center'><?php echo $j; ?></td>
                        <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo trim(substr($muFullDataValue[$i], 4)); ?></td>
                        <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo $data['ContentName']; ?></td>
                        <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo $data['AlbumName']; ?></td>
                        <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo $data['language']; ?></td>
                        <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;
                <?php //echo $data['MT_ID'].''.$data['PT_ID'].''.$data['TT_ID'];?>
                <?php if (!empty($data['MT_ID'])) { ?>	<span class="label label-important"><b>Mono</b></span>&nbsp;&nbsp;<?php } ?>
                <?php if (!empty($data['PT_ID'])) { ?>&nbsp;&nbsp;<span class="label label-info"><b>Poly</b></span>&nbsp;&nbsp;<?php } ?>
                <?php if (!empty($data['TT_ID'])) { ?>&nbsp;&nbsp;<span class="label label-success"><b>Tru </b></span>&nbsp;&nbsp;<?php } ?>
                        </td>
                        <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">
                <?php if (!empty($data['CRBTId_1'])) { ?>	<span class="label label-important"><b><?php echo $data['CRBTId_1']; ?></b></span>&nbsp;&nbsp;<?php } ?>
                        </td>
                    </tr>
                <?php $j++;
            }
        } ?>
        </table><?php
        break;
    case 'AirtelDevo': $clipValue = $_REQUEST['clip'];
        $relFullFilePath = "http://10.2.73.156:8080/hungama/config/dev/airm/songconfig/" . $clipValue . ".cfg";

        $lines1 = file($relFullFilePath);
        $relFullDataValue = array();
        foreach ($lines1 as $line_num => $RelData) {
            $relFullDataValue[] = $RelData;
        } $totalFileData = count($relFullDataValue);
        ?>

        <?php if ($totalFileData) { ?>
            <table align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1"  width="100%" class="table table-bordered table-condensed">		
                <tr align='center'>
                    <td style="padding-left: 5px;" bgcolor="#ffffff" height="35" width="10%"><b>S.No#</b></td>
                    <td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>SongUniquecode</b></td>
                    <td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>ContentName</b></td>
                    <td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>AlbumName</b></td>
                    <td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>Language</b></td>
                    <td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>Ringtones </b></td>
                    <td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>CRBT</b></td>
                </tr>
            <?php
            $j = 1;
            for ($i = 0; $i < count($relFullDataValue); $i++) {
                if ($relFullDataValue[$i]) {
                    $query = "select SongUniqueCode,ContentName,AlbumName,language,Genre,MT_ID,PT_ID,TT_ID from misdata.content_musicmetadata where SongUniqueCode='" . trim(substr($relFullDataValue[$i], 4)) . "'";

                    $result = mysql_query($query, $dbConn_218);
                    $data = mysql_fetch_array($result);  //print_r($data);	
                    ?>
                        <tr>
                            <td style="padding-left: 5px;" bgcolor="#ffffff" height="35" align='center'><?php echo $j; ?></td>
                            <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo trim(substr($relFullDataValue[$i], 4)); ?></td>
                            <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo $data['AlbumName'] ? $data['AlbumName'] : "-"; ?> </td>
                            <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo $data['ContentName'] ? $data['ContentName'] : "-"; ?>
                            </td>
                            <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo $data['language']; ?></td>
                            <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;
                    <?php if (!empty($data['MT_ID'])) { ?>	<span class="label label-important"><b>Mono</b></span>&nbsp;&nbsp;<?php } ?>
                    <?php if (!empty($data['PT_ID'])) { ?>&nbsp;&nbsp;<span class="label label-info"><b>Poly</b></span>&nbsp;&nbsp;<?php } ?>
                    <?php if (!empty($data['TT_ID'])) { ?>&nbsp;&nbsp;<span class="label label-success"><b>Tru </b></span>&nbsp;&nbsp;<?php } ?>
                            </td>
                            <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo '--'; ?></td>
                        </tr>
                    <?php $j++;
                }
            } ?>
            </table>
        <?php
        } else {
            echo "<div align='center'  class='alert alert-block'><h4>File Not Available</h4></div>";
        }
        break;
    // for music unlimited spl zone
    case 'mu_splzone': $splzoneFileName = $_REQUEST['clip'];
        $splzoneFileNamePath = "http://10.2.73.156:8080/hungama/config/AMUconfig/splzone/spconf/" . $splzoneFileName . ".cfg";
        $lines1 = file($splzoneFileNamePath);
        $muFullDataValue = array();
        foreach ($lines1 as $line_num => $MUData2) {
            $muFullDataValue[] = $MUData2;
        }
        ?>
            <?php
            $query = "select * from master_db.tbl_subcategory_master where catID=substr('" . $clipValue . "',3,2)";
            $result = mysql_query($query, $dbConn);
            $data = mysql_fetch_row($result);
            $catName = $data[0]; //echo $clipValue;
            $catName = $splzoneFileName . ".cfg";
            ?>
        <ul class="breadcrumb">
            <li>  
                <a href="javascript:void(0)" onclick="showMainMenu('<?= $lang ?>','<?= $circle ?>','AirtelEU')">Root</a> <span class="divider">/</span>  
            </li>
            <li>  
                <a href="javascript:void(0)" onclick="showContent('mu','<?= $circle ?>','<?= $lang ?>')">Music Unlimited</a> <span class="divider">/</span>  
            </li> 
            <li class="active">  
                Spl Zone
            </li> 

        </ul> 			

        <table align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" width="100%" class="table table-bordered table-condensed">		
            <tr align='center'>
                <td style="padding-left: 5px;" bgcolor="#ffffff" height="35" width="10%"><b>S.No#</b></td>
                <td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>SongUniquecode</b></td>
                <td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>ContentName</b></td>
                <td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>AlbumName</b></td>
                <td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>Language</b></td>
                <td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>Ringtones </b></td>
                <td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>CRBT</b></td>
            </tr>
        <?php
        $j = 1;
        for ($i = 0; $i < count($muFullDataValue); $i++) {
            if ($muFullDataValue[$i]) {

                $query = "select a.SongUniqueCode as SongUniqueCode,a.ContentName as ContentName,a.AlbumName as AlbumName,a.language as language,a.Genre as Genre,a.MT_ID as MT_ID,a.PT_ID as PT_ID,a.TT_ID as TT_ID,b.CRBTId_1 as CRBTId_1 from misdata.content_musicmetadata as a LEFT JOIN  misdata.content_servicedata as b ON a.SongUniqueCode=b.SongUniqueCode and b.Service='AirtelEU' where a.SongUniqueCode='" . trim(substr($muFullDataValue[$i], 4)) . "'";
                $result = mysql_query($query, $dbConn_218);
                $data = mysql_fetch_array($result);  //print_r($data);	
                ?>
                    <tr>
                        <td style="padding-left: 5px;" bgcolor="#ffffff" height="35" align='center'><?php echo $j; ?></td>
                        <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo trim(substr($muFullDataValue[$i], 4)); ?></td>
                        <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo $data['ContentName']; ?></td>
                        <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo $data['AlbumName']; ?></td>
                        <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo $data['language']; ?></td>
                        <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;
                    <?php //echo $data['MT_ID'].''.$data['PT_ID'].''.$data['TT_ID'];?>
                    <?php if (!empty($data['MT_ID'])) { ?>	<span class="label label-important"><b>Mono</b></span>&nbsp;&nbsp;<?php } ?>
                <?php if (!empty($data['PT_ID'])) { ?>&nbsp;&nbsp;<span class="label label-info"><b>Poly</b></span>&nbsp;&nbsp;<?php } ?>
                            <?php if (!empty($data['TT_ID'])) { ?>&nbsp;&nbsp;<span class="label label-success"><b>Tru </b></span>&nbsp;&nbsp;<?php } ?>
                        </td>
                        <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">
                            <?php //echo $data['CRBTId_1'];?>
                <?php if (!empty($data['CRBTId_1'])) { ?>	<span class="label label-important"><b><?php echo $data['CRBTId_1']; ?></b></span>&nbsp;&nbsp;<?php } ?>
                        </td>
                    </tr>
                            <?php $j++;
                        }
                    } ?>
        </table><?php
            break;
        case 'TataDoCoMoMX': $clipValue = $_REQUEST['clip'];
            $TDMXFullFilePath = "http://192.168.100.226:8081/hungama/config/config/tatm/songconfig/" . $clipValue . ".cfg";
            //	echo $TDMXFullFilePath = "http://10.2.73.156:8080/hungama/config/AMUconfig/songconfig/".$clipValue.".cfg";
            $lines1 = file($TDMXFullFilePath);
            $TDMXFullDataValue = array();
            foreach ($lines1 as $line_num => $TDMXData2) {
                $TDMXFullDataValue[] = $TDMXData2;
            }
            ?>
        <?php
        $query = "select * from master_db.tbl_subcategory_master where catID=substr('" . $clipValue . "',3,2)";
        $result = mysql_query($query, $dbConn);
        $data = mysql_fetch_row($result);
        $catName = $data[0]; //echo $clipValue;
        ?>
        <ul class="breadcrumb">  
            <li>  
                <a href="javascript:void(0)" onclick="showMainMenu('<?= $lang ?>','<?= $circle ?>','TataDoCoMoMX')">Root</a> <span class="divider">/</span>  
            </li>
            <!--li>  
              <a href="javascript:void(0)" onclick="showMainMenu('<?= $lang ?>','<?= $circle ?>','TataDoCoMoMX')">Docomo Endless</a> <span class="divider">/</span>  
            </li-->  
            <?php
            if ($musubcat == 'tdmxsub') {
                ?>
                <li>
                    <a href="javascript:void(0)" onclick="showTDMXCateData('TataDoCoMoMX','<?php echo $circle; ?>','<?php echo $lang; ?>','Other Categories','1');">
            <?php
            echo $_SESSION['mucatname'];
            ?>
                    </a>
                </li>
                <li><span class="divider">/</span> 
                    <a href="javascript:void(0)" onclick="showMUSubData('<?php echo $lang; ?>','<?php echo $circle; ?>','TataDoCoMoMX');">
                        <?php
                        echo $languageData[$lang];
                        ?>
                    </a>
                </li>
                <?php
            }
            ?>
            <li class="active"> <?php if ($musubcat == 'tdmxsub') { ?><span class="divider">/</span>  <?php } ?>
        <?= $languageData[$lang] . '-' . $catName; ?>
            </li>  

        </ul> 			

        <table align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" width="100%" class="table table-bordered table-condensed" id="example_TDMX">		
            <tr align='center'>
                <td style="padding-left: 5px;" bgcolor="#ffffff" height="35" width="10%"><b>S.No#</b></td>
                <td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>SongUniquecode</b></td>
                <td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>ContentName</b></td>
                <td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>AlbumName</b></td>
                <td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>Language</b></td>
                <td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>Ringtones </b></td>
                <td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>CRBT </b></td>
            </tr>
        <?php
        $j = 1;
        for ($i = 0; $i < count($TDMXFullDataValue); $i++) {
            if ($TDMXFullDataValue[$i]) {
                $query = "select a.SongUniqueCode as SongUniqueCode,a.ContentName as ContentName,a.AlbumName as AlbumName,a.language as language,a.Genre as Genre,a.MT_ID as MT_ID,a.PT_ID as PT_ID,a.TT_ID as TT_ID,b.CRBTId_1 as CRBTId_1 from misdata.content_musicmetadata as a LEFT JOIN  misdata.content_servicedata as b ON a.SongUniqueCode=b.SongUniqueCode and b.Service='TataDoCoMoMX' where a.SongUniqueCode='" . trim(substr($TDMXFullDataValue[$i], 4)) . "'";
                $result = mysql_query($query, $dbConn_218);
                $data = mysql_fetch_array($result);
                ?>
                    <tr>
                        <td style="padding-left: 5px;" bgcolor="#ffffff" height="35" align='center'><?php echo $j; ?></td>
                        <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo trim(substr($TDMXFullDataValue[$i], 4)); ?></td>
                        <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo $data['ContentName']; ?></td>
                        <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo $data['AlbumName']; ?></td>
                        <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo $data['language']; ?></td>
                        <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;
                <?php //echo $data['MT_ID'].''.$data['PT_ID'].''.$data['TT_ID']; ?>
                <?php if (!empty($data['MT_ID'])) { ?>	<span class="label label-important"><b>Mono</b></span>&nbsp;&nbsp;<?php } ?>
                <?php if (!empty($data['PT_ID'])) { ?>&nbsp;&nbsp;<span class="label label-info"><b>Poly</b></span>&nbsp;&nbsp;<?php } ?>
                            <?php if (!empty($data['TT_ID'])) { ?>&nbsp;&nbsp;<span class="label label-success"><b>Tru </b></span>&nbsp;&nbsp;<?php } ?>
                        </td>
                        <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">
                            <?php if (!empty($data['CRBTId_1'])) { ?>	<span class="label label-important"><b><?php echo $data['CRBTId_1']; ?></b></span>&nbsp;&nbsp;<?php } ?>
                        </td>
                    </tr>
                    <?php $j++;
                }
            } ?>
        </table><?php
        break;
    //TDMX spl zone handling
    /* MTSMU service content display code start here */
    case 'MTSMU': $clipValue = $_REQUEST['clip'];
        //http://10.130.14.106:8080/hungama/config/config/mtsm/songconfig/0101.cfg
        $MTSMUFullFilePath = "http://10.130.14.106:8080/hungama/config/config/mtsm/songconfig/" . $clipValue . ".cfg";
        $lines1 = file($MTSMUFullFilePath);
        $MTSMUFullDataValue = array();
        foreach ($lines1 as $line_num => $MTSMUData) {
            $MTSMUFullDataValue[] = $MTSMUData;
        }
        ?>
        <?php
        $query = "select * from master_db.tbl_subcategory_master where catID=substr('" . $clipValue . "',3,2)";
        $result = mysql_query($query, $dbConn);
        $data = mysql_fetch_row($result);
        $catName = $data[0]; //echo $clipValue;
        ?>
        <ul class="breadcrumb">  
            <li>  
                <a href="javascript:void(0)" onclick="showMainMenu('<?= $lang ?>','<?= $circle ?>','MTSMU')">Root</a> <span class="divider">/</span>  
            </li>
            <!--li>  
              <a href="javascript:void(0)" onclick="showMainMenu('<?= $lang ?>','<?= $circle ?>','MTSMU')">MTS - muZic Unlimited</a> <span class="divider">/</span>  
            </li-->  
                    <?php
                    if ($musubcat == 'mtsmusub') {
                        ?>
                <li>
                    <a href="javascript:void(0)" onclick="showMTSMUCateData('MTSMU','<?php echo $circle; ?>','<?php echo $lang; ?>','Other Categories','1');">
            <?php
            echo $_SESSION['mucatname'];
            ?>
                    </a>
                </li>
                <li><span class="divider">/</span> 
                    <a href="javascript:void(0)" onclick="showMUSubData('<?php echo $lang; ?>','<?php echo $circle; ?>','MTSMU');">
            <?php
            echo $languageData[$lang];
            ?>
                    </a>
                </li>
            <?php
        }
        ?>
            <li class="active"> <?php if ($musubcat == 'mtsmusub') { ?><span class="divider">/</span>  <?php } ?>
        <?= $languageData[$lang] . '-' . $catName; ?>
            </li>  

        </ul> 			

        <table align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" width="100%" class="table table-bordered table-condensed" id="example_TDMX">		
            <tr align='center'>
                <td style="padding-left: 5px;" bgcolor="#ffffff" height="35" width="10%"><b>S.No#</b></td>
                <td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>SongUniquecode</b></td>
                <td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>ContentName</b></td>
                <td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>AlbumName</b></td>
                <td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>Language</b></td>
                <td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>Ringtones </b></td>
                <td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>CRBT </b></td>
            </tr>
        <?php
        $j = 1;
        for ($i = 0; $i < count($MTSMUFullDataValue); $i++) {
            if ($MTSMUFullDataValue[$i]) {
                $query = "select a.SongUniqueCode as SongUniqueCode,a.ContentName as ContentName,a.AlbumName as AlbumName,a.language as language,a.Genre as Genre,a.MT_ID as MT_ID,a.PT_ID as PT_ID,a.TT_ID as TT_ID,b.CRBTId_1 as CRBTId_1 from misdata.content_musicmetadata as a LEFT JOIN  misdata.content_servicedata as b ON a.SongUniqueCode=b.SongUniqueCode and b.Service='" . $case . "' where a.SongUniqueCode='" . trim(substr($MTSMUFullDataValue[$i], 4)) . "'";
                $result = mysql_query($query, $dbConn_218);
                $data = mysql_fetch_array($result);
                ?>
                    <tr>
                        <td style="padding-left: 5px;" bgcolor="#ffffff" height="35" align='center'><?php echo $j; ?></td>
                        <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo trim(substr($MTSMUFullDataValue[$i], 4)); ?></td>
                        <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo $data['ContentName']; ?></td>
                        <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo $data['AlbumName']; ?></td>
                        <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo $data['language']; ?></td>
                        <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;
                    <?php //echo $data['MT_ID'].''.$data['PT_ID'].''.$data['TT_ID'];?>
                    <?php if (!empty($data['MT_ID'])) { ?>	<span class="label label-important"><b>Mono</b></span>&nbsp;&nbsp;<?php } ?>
                    <?php if (!empty($data['PT_ID'])) { ?>&nbsp;&nbsp;<span class="label label-info"><b>Poly</b></span>&nbsp;&nbsp;<?php } ?>
                    <?php if (!empty($data['TT_ID'])) { ?>&nbsp;&nbsp;<span class="label label-success"><b>Tru </b></span>&nbsp;&nbsp;<?php } ?>
                        </td>
                        <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">
                <?php if (!empty($data['CRBTId_1'])) { ?>	<span class="label label-important"><b><?php echo $data['CRBTId_1']; ?></b></span>&nbsp;&nbsp;<?php } ?>
                        </td>
                    </tr>
                <?php $j++;
            }
        } ?>
        </table><?php
        break;
    /* MTSMU service content display end here */
    case 'TataDoCoMoMX_splzone': $splzoneFileName = $_REQUEST['clip'];
        $splzoneFileNamePath = "http://192.168.100.226:8081/hungama/config/config/tatm/spconf/" . $splzoneFileName . ".cfg";
        $lines1 = file($splzoneFileNamePath);
        $muFullDataValue = array();
        foreach ($lines1 as $line_num => $MUData2) {
            $muFullDataValue[] = $MUData2;
        }
        ?>
        <?php
        $query = "select * from master_db.tbl_subcategory_master where catID=substr('" . $clipValue . "',3,2)";
        $result = mysql_query($query, $dbConn);
        $data = mysql_fetch_row($result);
        $catName = $data[0]; //echo $clipValue;
        $catName = $splzoneFileName . ".cfg";
        ?>
        <ul class="breadcrumb">
            <li>  
                <a href="javascript:void(0)" onclick="showMainMenu('<?= $lang ?>','<?= $circle ?>','TataDoCoMoMX')">Root</a> <span class="divider">/</span>  
            </li>
            <!--li>  
              <a href="javascript:void(0)" onclick="showMainMenu('<?= $lang ?>','<?= $circle ?>','TataDoCoMoMX')"> Docomo Endless</a> <span class="divider">/</span>  
            </li--> 
            <li class="active">
                Spl Zone
            </li> 

        </ul> 			

        <table align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" width="100%" class="table table-bordered table-condensed">		
            <tr align='center'>
                <td style="padding-left: 5px;" bgcolor="#ffffff" height="35" width="10%"><b>S.No#</b></td>
                <td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>SongUniquecode</b></td>
                <td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>ContentName</b></td>
                <td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>AlbumName</b></td>
                <td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>Language</b></td>
                <td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>Ringtones </b></td>
                <td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>CRBT</b></td>
            </tr>
        <?php
        $j = 1;
        for ($i = 0; $i < count($muFullDataValue); $i++) {
            if ($muFullDataValue[$i]) {

                $query = "select a.SongUniqueCode as SongUniqueCode,a.ContentName as ContentName,a.AlbumName as AlbumName,a.language as language,a.Genre as Genre,a.MT_ID as MT_ID,a.PT_ID as PT_ID,a.TT_ID as TT_ID,b.CRBTId_1 as CRBTId_1 from misdata.content_musicmetadata as a LEFT JOIN  misdata.content_servicedata as b ON a.SongUniqueCode=b.SongUniqueCode and b.Service='TataDoCoMoMX' where a.SongUniqueCode='" . trim(substr($muFullDataValue[$i], 4)) . "'";
                $result = mysql_query($query, $dbConn_218);
                $data = mysql_fetch_array($result);  //print_r($data);	
                ?>
                    <tr>
                        <td style="padding-left: 5px;" bgcolor="#ffffff" height="35" align='center'><?php echo $j; ?></td>
                        <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo trim(substr($muFullDataValue[$i], 4)); ?></td>
                        <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo $data['ContentName']; ?></td>
                        <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo $data['AlbumName']; ?></td>
                        <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo $data['language']; ?></td>
                        <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;
                <?php //echo $data['MT_ID'].''.$data['PT_ID'].''.$data['TT_ID']; ?>
                <?php if (!empty($data['MT_ID'])) { ?>	<span class="label label-important"><b>Mono</b></span>&nbsp;&nbsp;<?php } ?>
                <?php if (!empty($data['PT_ID'])) { ?>&nbsp;&nbsp;<span class="label label-info"><b>Poly</b></span>&nbsp;&nbsp;<?php } ?>
                <?php if (!empty($data['TT_ID'])) { ?>&nbsp;&nbsp;<span class="label label-success"><b>Tru </b></span>&nbsp;&nbsp;<?php } ?>
                        </td>
                        <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">
                            <?php //echo $data['CRBTId_1'];?>
                            <?php if (!empty($data['CRBTId_1'])) { ?>	<span class="label label-important"><b><?php echo $data['CRBTId_1']; ?></b></span>&nbsp;&nbsp;<?php } ?>
                        </td>
                    </tr>
                            <?php $j++;
                        }
                    } ?>
        </table><?php
                    break;
                //MTMS spl zone handling
                case 'MTSMU_splzone': $splzoneFileName = $_REQUEST['clip'];
                    $splzoneFileNamePath = "http://10.130.14.106:8080/hungama/config/config/mtsm/spconf/" . $splzoneFileName . ".cfg";
                    $lines1 = file($splzoneFileNamePath);
                    $mtsmuFullDataValue = array();
                    foreach ($lines1 as $line_num => $MTSMUData2) {
                        $mtsmuFullDataValue[] = $MTSMUData2;
                    }
                    ?>
        <?php
        $query = "select * from master_db.tbl_subcategory_master where catID=substr('" . $clipValue . "',3,2)";
        $result = mysql_query($query, $dbConn);
        $data = mysql_fetch_row($result);
        $catName = $data[0];
        $catName = $splzoneFileName . ".cfg";
        ?>
        <ul class="breadcrumb">
            <li>  
                <a href="javascript:void(0)" onclick="showMainMenu('<?= $lang ?>','<?= $circle ?>','MTSMU')">Root</a> <span class="divider">/</span>  
            </li>
            <!--li>  
              <a href="javascript:void(0)" onclick="showMainMenu('<?= $lang ?>','<?= $circle ?>','MTSMU')"> MTS - muZic Unlimited </a> <span class="divider">/</span>  
            </li--> 
            <li class="active"> 
                Spl Zone
            </li> 

        </ul> 			

        <table align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" width="100%" class="table table-bordered table-condensed">		
            <tr align='center'>
                <td style="padding-left: 5px;" bgcolor="#ffffff" height="35" width="10%"><b>S.No#</b></td>
                <td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>SongUniquecode</b></td>
                <td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>ContentName</b></td>
                <td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>AlbumName</b></td>
                <td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>Language</b></td>
                <td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>Ringtones </b></td>
                <td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>CRBT</b></td>
            </tr>
        <?php
        $j = 1;
        for ($i = 0; $i < count($mtsmuFullDataValue); $i++) {
            if ($mtsmuFullDataValue[$i]) {

                $query = "select a.SongUniqueCode as SongUniqueCode,a.ContentName as ContentName,a.AlbumName as AlbumName,a.language as language,a.Genre as Genre,a.MT_ID as MT_ID,a.PT_ID as PT_ID,a.TT_ID as TT_ID,b.CRBTId_1 as CRBTId_1 from misdata.content_musicmetadata as a LEFT JOIN  misdata.content_servicedata as b ON a.SongUniqueCode=b.SongUniqueCode and b.Service='MTSMU' where a.SongUniqueCode='" . trim(substr($mtsmuFullDataValue[$i], 4)) . "'";
                $result = mysql_query($query, $dbConn_218);
                $data = mysql_fetch_array($result);  //print_r($data);	
                ?>
                    <tr>
                        <td style="padding-left: 5px;" bgcolor="#ffffff" height="35" align='center'><?php echo $j; ?></td>
                        <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo trim(substr($mtsmuFullDataValue[$i], 4)); ?></td>
                        <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo $data['ContentName']; ?></td>
                        <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo $data['AlbumName']; ?></td>
                        <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo $data['language']; ?></td>
                        <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;
                <?php if (!empty($data['MT_ID'])) { ?>	<span class="label label-important"><b>Mono</b></span>&nbsp;&nbsp;<?php } ?>
                <?php if (!empty($data['PT_ID'])) { ?>&nbsp;&nbsp;<span class="label label-info"><b>Poly</b></span>&nbsp;&nbsp;<?php } ?>
                            <?php if (!empty($data['TT_ID'])) { ?>&nbsp;&nbsp;<span class="label label-success"><b>Tru </b></span>&nbsp;&nbsp;<?php } ?>
                        </td>
                        <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">
                            <?php if (!empty($data['CRBTId_1'])) { ?>	<span class="label label-important"><b><?php echo $data['CRBTId_1']; ?></b></span>&nbsp;&nbsp;<?php } ?>
                        </td>
                    </tr>
                            <?php $j++;
                        }
                    } ?>
        </table><?php
                    break;
                //AIMC spl zone handling

                /* start code for music world */
                case 'mw_54646':
                    $circle = strtolower(trim($_GET['circle']));
                    $lang = trim($_GET['lang']);
                    $service = trim($_GET['service']);
                    $operator = trim($_GET['operator']);
                    $data_value = trim($_GET['data_value']);
                    $ACfilePath = "http://192.168.100.226:8082/hungama/config/54646config_V2/" . $operator . "/mwconfig/songconfig/" . $data_value . ".cfg";
                    $lines = file($ACfilePath);
                    $iscount = count($lines);

                    $acDataValue = array();
                    foreach ($lines as $line_num => $ACData) {
                        $mtsmuFullDataValue[] = $ACData;
                        $flag = 1;
                    }
                    $query = "select * from master_db.tbl_subcategory_master where catID=substr('" . $clipValue . "',3,2)";
                    $result = mysql_query($query, $dbConn);
                    $data = mysql_fetch_row($result);
                    $catName = $data[0];
                    $catName = $splzoneFileName . ".cfg";
                    ?>
        <ul class="breadcrumb">
            <li>  
                <a href="javascript:void(0)" onclick="showMainMenu('<?= $lang ?>','<?= $circle ?>','MTSMU')">Root</a> <span class="divider">/</span>  
            </li>
            <li class="active"> 

            </li> 

        </ul> 			

        <table align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" width="100%" class="table table-bordered table-condensed">		
            <tr align='center'>
                <td style="padding-left: 5px;" bgcolor="#ffffff" height="35" width="10%"><b>S.No#</b></td>
                <td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>SongUniquecode</b></td>
                <td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>ContentName</b></td>
                <td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>AlbumName</b></td>
                <td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>Language</b></td>
                <td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>Ringtones </b></td>
                <td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>CRBT</b></td>
            </tr>
        <?php
        $j = 1;
        for ($i = 0; $i < count($mtsmuFullDataValue); $i++) {
            if ($mtsmuFullDataValue[$i]) {

                $query = "select a.SongUniqueCode as SongUniqueCode,a.ContentName as ContentName,a.AlbumName as AlbumName,a.language as language,a.Genre as Genre,a.MT_ID as MT_ID,a.PT_ID as PT_ID,a.TT_ID as TT_ID,b.CRBTId_1 as CRBTId_1 from misdata.content_musicmetadata as a LEFT JOIN  misdata.content_servicedata as b ON a.SongUniqueCode=b.SongUniqueCode and b.Service='54646' where a.SongUniqueCode='" . trim(substr($mtsmuFullDataValue[$i], 4)) . "'";
                $result = mysql_query($query, $dbConn_218);
                $data = mysql_fetch_array($result);  //print_r($data);	
                ?>
                    <tr>
                        <td style="padding-left: 5px;" bgcolor="#ffffff" height="35" align='center'><?php echo $j; ?></td>
                        <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo trim(substr($mtsmuFullDataValue[$i], 4)); ?></td>
                        <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo $data['ContentName']; ?></td>
                        <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo $data['AlbumName']; ?></td>
                        <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo $data['language']; ?></td>
                        <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;
                <?php if (!empty($data['MT_ID'])) { ?>	<span class="label label-important"><b>Mono</b></span>&nbsp;&nbsp;<?php } ?>
                <?php if (!empty($data['PT_ID'])) { ?>&nbsp;&nbsp;<span class="label label-info"><b>Poly</b></span>&nbsp;&nbsp;<?php } ?>
                <?php if (!empty($data['TT_ID'])) { ?>&nbsp;&nbsp;<span class="label label-success"><b>Tru </b></span>&nbsp;&nbsp;<?php } ?>
                        </td>
                        <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">
                <?php if (!empty($data['CRBTId_1'])) { ?>	<span class="label label-important"><b><?php echo $data['CRBTId_1']; ?></b></span>&nbsp;&nbsp;<?php } ?>
                        </td>
                    </tr>
                            <?php $j++;
                        }
                    } ?>
        </table><?php
            break;
        case 'mu': $clipValue = $_REQUEST['clip'];
            $ACFullFilePath = "http://10.2.73.156:8080/hungama/config/AMUconfig/songconfig/" . $clipValue . ".cfg";
            $lines1 = file($ACFullFilePath);
            $muFullDataValue = array();
            foreach ($lines1 as $line_num => $MUData2) {
                $muFullDataValue[] = $MUData2;
            }
                    ?>
        <?php
        $query = "select * from master_db.tbl_subcategory_master where catID=substr('" . $clipValue . "',3,2)";
        $result = mysql_query($query, $dbConn);
        $data = mysql_fetch_row($result);
        $catName = $data[0]; //echo $clipValue;
        ?>
        <ul class="breadcrumb">  
            <li>  
                <a href="javascript:void(0)" onclick="showMainMenu('<?= $lang ?>','<?= $circle ?>','AirtelEU')">Root</a> <span class="divider">/</span>  
            </li>
            <li>  
                <a href="javascript:void(0)" onclick="showContent('mu','<?= $circle ?>','<?= $lang ?>')">Music Unlimited</a> <span class="divider">/</span>  
            </li>  
        <?php
        if ($musubcat == 'musub') {
            ?>
                <li>
                    <a href="javascript:void(0)" onclick="showMUCateData('mu','<?php echo $circle; ?>','<?php echo $lang; ?>','Other Categories','1');">
            <?php
            echo $_SESSION['mucatname'];
            ?>
                    </a>
                </li>
                <li><span class="divider">/</span> 
                    <a href="javascript:void(0)" onclick="showMUSubData('<?php echo $lang; ?>','<?php echo $circle; ?>','mu');">
            <?php
            echo $languageData[$lang];
            ?>
                    </a>
                </li>
            <?php
        }
        ?>
            <li class="active"> <?php if ($musubcat == 'musub') { ?><span class="divider">/</span>  <?php } ?>
        <?= $languageData[$lang] . '-' . $catName; ?>
            </li>  

        </ul> 			

        <table align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" width="100%" class="table table-bordered table-condensed" id="example_mu">		
            <tr align='center'>
                <td style="padding-left: 5px;" bgcolor="#ffffff" height="35" width="10%"><b>S.No#</b></td>
                <td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>SongUniquecode</b></td>
                <td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>ContentName</b></td>
                <td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>AlbumName</b></td>
                <td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>Language</b></td>
                <td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>Ringtones </b></td>
                <td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><b>CRBT </b></td>
            </tr>
        <?php
        $j = 1;
        for ($i = 0; $i < count($muFullDataValue); $i++) {
            if ($muFullDataValue[$i]) {
                $query = "select a.SongUniqueCode as SongUniqueCode,a.ContentName as ContentName,a.AlbumName as AlbumName,a.language as language,a.Genre as Genre,a.MT_ID as MT_ID,a.PT_ID as PT_ID,a.TT_ID as TT_ID,b.CRBTId_1 as CRBTId_1 from misdata.content_musicmetadata as a LEFT JOIN  misdata.content_servicedata as b ON a.SongUniqueCode=b.SongUniqueCode and b.Service='AirtelEU' where a.SongUniqueCode='" . trim(substr($muFullDataValue[$i], 4)) . "'";
                $result = mysql_query($query, $dbConn_218);
                $data = mysql_fetch_array($result);  //print_r($data);	
                ?>
                    <tr>
                        <td style="padding-left: 5px;" bgcolor="#ffffff" height="35" align='center'><?php echo $j; ?></td>
                        <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo trim(substr($muFullDataValue[$i], 4)); ?></td>
                        <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo $data['ContentName']; ?></td>
                        <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo $data['AlbumName']; ?></td>
                        <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo $data['language']; ?></td>
                        <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;
                <?php //echo $data['MT_ID'].''.$data['PT_ID'].''.$data['TT_ID']; ?>
                <?php if (!empty($data['MT_ID'])) { ?>	<span class="label label-important"><b>Mono</b></span>&nbsp;&nbsp;<?php } ?>
                <?php if (!empty($data['PT_ID'])) { ?>&nbsp;&nbsp;<span class="label label-info"><b>Poly</b></span>&nbsp;&nbsp;<?php } ?>
                <?php if (!empty($data['TT_ID'])) { ?>&nbsp;&nbsp;<span class="label label-success"><b>Tru </b></span>&nbsp;&nbsp;<?php } ?>
                        </td>
                        <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">
                <?php if (!empty($data['CRBTId_1'])) { ?>	<span class="label label-important"><b><?php echo $data['CRBTId_1']; ?></b></span>&nbsp;&nbsp;<?php } ?>
                        </td>
                    </tr>
                <?php $j++;
            }
        } ?>
        </table><?php
        break;
} //switch case end maindiv
?>