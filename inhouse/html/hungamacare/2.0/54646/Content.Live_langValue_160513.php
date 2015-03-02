<?php
session_start();
error_reporting(0);
require_once("db_connect_livecontent.php");

function get_contents($fileUrl) {
    file_get_contents($fileUrl);
    $response = $http_response_header;
    if (preg_match("|200|", $response[0])) {
        return 1;
    } else {
        return 0;
    }
}

$languageData = array('01' => 'Hindi', '02' => 'English', '03' => 'Punjabi', '04' => 'Bhojpuri', '05' => 'Haryanavi', '06' => 'Bengali', '07' => 'Tamil', '08' => 'Telugu', '09' => 'Malayalam', '10' => 'Kannada', '11' => 'Marathi', '12' => 'Gujarati', '13' => 'Oriya', '14' => 'Kashmiri', '15' => 'Himachali', '16' => 'Chhattisgarhi', '17' => 'Assamese', '21' => 'Maithali', '19' => 'Nepali', '20' => 'Kumaoni', '18' => 'Rajasthani');
$AudioCinemaData = array('0121' => 'Bollywood New Releases', '22' => 'Classics - Bollywood', '23' => 'Best of Bollywood', '24' => 'Love Hits', '21' => 'Hits');

$circle_info = array('DEL' => 'Delhi', 'GUJ' => 'Gujarat', 'WBL' => 'WestBengal', 'BIH' => 'Bihar', 'RAJ' => 'Rajasthan', 'UPW' => 'UP WEST', 'MAH' => 'Maharashtra', 'APD' => 'Andhra Pradesh', 'UPE' => 'UP EAST', 'ASM' => 'Assam', 'TNU' => 'Tamil Nadu', 'KOL' => 'Kolkata', 'NES' => 'NE', 'CHN' => 'Chennai', 'ORI' => 'Orissa', 'KAR' => 'Karnataka', 'HAY' => 'Haryana', 'PUN' => 'Punjab', 'MUM' => 'Mumbai', 'MPD' => 'Madhya Pradesh', 'JNK' => 'Jammu-Kashmir', 'PUB' => "Punjab", 'KER' => 'Kerala', 'HPD' => 'Himachal Pradesh', '' => 'Other');
$circle_AMC_array = array('APD' => '31', 'ASM' => '39', 'BIH' => '101', 'CHN' => '127', 'DEL' => '153', 'GUJ' => '202', 'HAY' => '218', 'HPD' => '222', 'JNK' => '251', 'KAR' => '292', 'KER' => '299', 'KOL' => '309', 'MPD' => '337', 'MAH' => '342', 'MUM' => '373', 'NES' => '400', 'ORI' => '413', 'PUB' => '442', 'RAJ' => '451', 'TNU' => '527', 'UPE' => '558', 'UPW' => '559', 'WBL' => '579');
$circle_navigation_language = array('31' => '1,13,2', '39' => '10,1', '101' => '1,4', '127' => '14,2', '153' => '1,2', '202' => 'Gujarat', '218' => '1', '222' => '8', '251' => '1,6', '292' => '15,1,14,2', '299' => '16,2', '309' => '1,3', '337' => '', '342' => '1,20', '373' => '1,20', '400' => '2,1', '413' => '7,1', '442' => '5,1', '451' => '1,19', '527' => '14,2,1', '558' => '1,4', '559' => '1', '579' => '1,3');
$language_AMC_array = array('1' => 'Hindi', '2' => 'English', '3' => 'Bengali', '4' => 'Bhojpuri', '5' => 'Punjabi', '6' => 'Kashmiri', '7' => 'Oriya', '8' => 'Himachali', '9' => 'chhatisgarhi', '10' => 'Assamese', '13' => 'Telugu', '14' => 'Tamil', '15' => 'Kannada', '16' => 'Malayalam', '17' => 'Haryanavi', '18' => 'Gujarati', '19' => 'Rajasthani', '20' => 'Marathi');

$case = trim($_REQUEST['case']);
$catname = $_GET['catname'];
$_SESSION['Sessionclip'] = trim($_GET['clip']);
$_SESSION['mucatname_other'] = trim($_GET['mucatname']);


switch ($case) {
    case '1': $circle = strtolower(trim($_GET['circle']));
        $service = trim($_GET['service']);
        if ($service == 'AirtelEU') {
            if ($circle == 'pub')
                $circle = 'pun';
            $filePath = "http://10.2.73.156:8080/hungama/config/AMUconfig/" . strtolower($circle) . "/langorder.cfg";
        } elseif ($service == 'AirtelDevo') {
            $filePath = "http://10.2.73.156:8080/hungama/config/dev/airm/" . strtolower($circle) . "/navlang.cfg";
        } elseif ($service == 'MTSDevo') {
            $filePath = "http://10.130.14.106:8080/hungama/config/dev/mtsm/" . strtolower($circle) . "/navlang.cfg";
        } elseif ($service == 'TataDoCoMoMX') {
            $filePath = "http://192.168.100.227:8081/hungama/config/config/tatm/" . strtolower($circle) . "/langorder.cfg";
            //	$filePath = "http://192.168.100.2271:8083/hungama/config/config/tatm/".strtolower($circle)."/langorder.cfg";
        } elseif ($service == 'MTSMU') {
            //$filePath = "http://10.130.14.106:8080/hungama/config/config/mtsm/".strtolower($circle)."/langorder.cfg";
            $filePath = "http://10.130.14.106:8080/hungama/config/config/mtsm/" . strtolower($circle) . "/langorder_existing.cfg";
        } elseif ($service == 'AircelMC') {
            $cid = $circle_AMC_array[strtoupper($circle)];
            $filePath = 'aircel-cache/langorder/' . $cid . '.cfg';
            //$filePath = "Content.Live_AircelMC.php?cid=".$cid;
        } elseif ($service == '54646') {
            $operator = trim($_GET['operator']);
            $circle_array = array('tnu', 'apd', 'ker', 'kar');
            if (in_array($circle, $circle_array)) {
                $filePath = 'http://192.168.100.226:8082/hungama/config/54646config_V2/langorder-' . strtolower($circle) . '.cfg';
            } else {
                $filePath = 'http://192.168.100.226:8082/hungama/config/54646config_V2/langorder-otherlang.cfg';
            }
        }
        $lines = file($filePath);
        $iscount = count($lines);
        $lang = array();
        foreach ($lines as $line_num => $langData) {
            $langId = trim($langData);

            if ($service == 'AircelMC') {
                $langName = $language_AMC_array[$langId];
            } else {
                $langName = $languageData[$langId];
            }

            $lang[$langId] = $langName;
        }
        ?>
        <?php if ($service == '54646') { ?>
            <select id="lang" name="lang" onchange="showMainMenu_54646(this.value,'<?php echo $circle; ?>','<?php echo $service; ?>','<?php echo $operator; ?>');" class='txt'>
            <?php } else { ?>
                <select id="lang" name="lang" onchange="showMainMenu(this.value,'<?php echo $circle; ?>','<?php echo $service; ?>');" class='txt'>
                <?php } ?>
                <option value="">Select Language</option>
                <?php foreach ($lang as $langcode => $langName) { ?>
                    <option value="<?php echo $langcode; ?>"><?php echo $langName; ?></option>
                <?php } ?>
            </select><?php
        break;
    case '2': $circle = strtolower(trim($_GET['circle']));
        $service = trim($_GET['service']);
        $lang = trim($_GET['lang']);
        if ($service == "AirtelEU") {
            if ($circle == 'pub')
                $circle = 'pun';
                    ?>			  
                <div align='left' class="tab-content">
                    <div class="alert">Displaying For Airtel AirtelEU For <strong><?php echo $circle_info[strtoupper($circle)]; ?></strong> For <strong><?php echo $languageData[$lang]; ?></strong> Navigation Language
                    </div>
                </div>
                <div id="mainmenu_cat_div_eu">
                    <table width="100%" class="table table-condensed table-bordered" id="example">
                        <thead> <tr>
                                <td><span class="label">&nbsp;&nbsp;&nbsp;1&nbsp;&nbsp;&nbsp;</span>&nbsp;<a href="#" onclick="showContent('ac','<?php echo $circle; ?>','<?php echo $lang; ?>');">Audio Cinema</a></td>
                                <td>
                                    <span class="label">&nbsp;&nbsp;&nbsp;2&nbsp;&nbsp;&nbsp;</span>&nbsp;<a href="javascript:void(0);" onclick="showContent_data('bg','<?php echo $circle; ?>','<?php echo $lang; ?>')">Bollywood Gossip</a>
                                </td>
                                <td><span class="label">&nbsp;&nbsp;&nbsp;3&nbsp;&nbsp;&nbsp;</span>&nbsp;<a href="#" onclick="showContent('mu','<?php echo $circle; ?>','<?php echo $lang; ?>');">Music Unlimited</a></td>
                            </tr>
                        </thead>					  
                    </table>
                </div>
                <?php
            } elseif ($service == "AirtelDevo") {

//navigation language array for religion

                $hindu_nav_lang_array = array('01' => 'Hindi', '06' => 'Bengali', '04' => 'Bhojpuri', '17' => 'Assamese', '12' => 'Gujarati', '10' => 'Kannada', '09' => 'Malayalam', '11' => 'Marathi', '07' => 'Tamil', '08' => 'Telugu', '18' => 'Rajasthani', '16' => 'Chhatisgarhi', '14' => 'Kashmiri', '13' => 'Oriya');
                $muslim_nav_lang_array = array('01' => 'Hindi', '14' => 'Kashmiri', '09' => 'Malayalam', '07' => 'Tamil');
                $christian_nav_lang_array = array('02' => 'English', '01' => 'Hindi', '09' => 'Malayalam');
                $sikh_nav_lang_array = array('03' => 'Punjabi');
                $buddhism_nav_lang_array = array('01' => 'Hindi');
                $jainism_nav_lang_array = array('01' => 'Hindi');
                $navlang = trim($_GET['navlang']);
                if ($navlang == 'undefined') {
                    $navlang = $lang;
                }
                //$lang=$navlang;

                $filePath = "http://10.2.73.156:8080/hungama/config/dev/airm/songconfig/mainmenu.cfg";
                $lines = file($filePath);
                $iscount = count($lines);

                $religionMenu = array();
                foreach ($lines as $line_num => $RelData) {
                    $religionMenu[] = $RelData;
                }
                ?>	
                <div align='left' class="tab-content">
                    <div class="alert">
                        Displaying For Airtel Devotional For <strong><?php echo $circle_info[strtoupper($circle)]; ?></strong> For <strong><?php echo $languageData[$navlang]; ?></strong> Navigation Language
                    </div>
                </div>


                <div id="mainmenu_cat_div_devo">  
                    <table class="table table-bordered">
                        <tr> 
                            <?php
                            $k = 1;
                            $i = -1;
                            for ($j = 0; $j <= count($religionMenu); $j++) {
                                $i++;
                                if ($i % 3 == 0 && $i != 0) {
                                    echo "</tr><tr>";
                                }
                                if (!empty($religionMenu[$j])) {
                                    ?>

                                    <td><span class="label">&nbsp;&nbsp;&nbsp;<?php echo $k; ?>&nbsp;&nbsp;&nbsp;</span>

                                        <?php
                                        if (trim($religionMenu[$j]) == 'hindu') {
                                            if (array_key_exists($lang, $hindu_nav_lang_array)) {
                                                $nav_lang = $lang;
                                            } else {
                                                $nav_lang = '01';
                                            }
                                        }
                                        if (trim($religionMenu[$j]) == 'muslim') {
                                            if (array_key_exists($lang, $muslim_nav_lang_array)) {
                                                $nav_lang = $lang;
                                            } else {
                                                $nav_lang = '01';
                                            }
                                        }
                                        if (trim($religionMenu[$j]) == 'sikh') {
                                            if (array_key_exists($lang, $sikh_nav_lang_array)) {
                                                $nav_lang = $lang;
                                            } else {
                                                $nav_lang = '03';
                                            }
                                        }
                                        if (trim($religionMenu[$j]) == 'christian') {
                                            if (array_key_exists($lang, $christian_nav_lang_array)) {
                                                $nav_lang = $lang;
                                            } else {
                                                $nav_lang = '02';
                                            }
                                        }
                                        if (trim($religionMenu[$j]) == 'buddhism') {
                                            if (array_key_exists($lang, $buddhism_nav_lang_array)) {
                                                $nav_lang = $lang;
                                            } else {
                                                $nav_lang = '01';
                                            }
                                        }
                                        if (trim($religionMenu[$j]) == 'jainism') {
                                            if (array_key_exists($lang, $jainism_nav_lang_array)) {
                                                $nav_lang = $lang;
                                            } else {
                                                $nav_lang = '01';
                                            }
                                        }
                                        ?>

                                        <a href="javascript:void(0);" onclick="showDevoContent('<?php echo trim($religionMenu[$j]); ?>','<?php echo $nav_lang; ?>','<?php echo $circle; ?>','<?php echo $navlang; ?>','AirtelDevo')">
                                            <?php echo ucwords($religionMenu[$j]); ?>
                                        </a>



                                    </td>
                                    <?php
                                    $k++;
                                }
                            }
                            ?>
                            <?php
                            for ($k1 = 1; $k1 < (3 - $i % 3); $k1++) {
                                //  echo "<td>&nbsp;</td>";
                            }
                            ?>
                        </tr>
                    </table>
                </div>
                <?php
            }
            /* for MTS- Bhakti Sagar start here */ elseif ($service == "MTSDevo") {

//navigation language array for religion

                $hindu_nav_lang_array = array('01' => 'Hindi', '06' => 'Bengali', '04' => 'Bhojpuri', '17' => 'Assamese', '12' => 'Gujarati', '10' => 'Kannada', '09' => 'Malayalam', '11' => 'Marathi', '07' => 'Tamil', '08' => 'Telugu', '18' => 'Rajasthani', '16' => 'Chhatisgarhi', '14' => 'Kashmiri', '13' => 'Oriya');
                $muslim_nav_lang_array = array('01' => 'Hindi', '14' => 'Kashmiri', '09' => 'Malayalam', '07' => 'Tamil');
                $christian_nav_lang_array = array('02' => 'English', '01' => 'Hindi', '09' => 'Malayalam');
                $sikh_nav_lang_array = array('03' => 'Punjabi');
                $buddhism_nav_lang_array = array('01' => 'Hindi');
                $jainism_nav_lang_array = array('01' => 'Hindi');
                $navlang = trim($_GET['navlang']);
                if ($navlang == 'undefined') {
                    $navlang = $lang;
                }
                //$lang=$navlang;

                $filePath = "http://10.130.14.106:8080/hungama/config/dev/mtsm/songconfig/mainmenu.cfg";
                $lines = file($filePath);
                $iscount = count($lines);

                $religionMenu = array();
                foreach ($lines as $line_num => $RelData) {
                    $religionMenu[] = $RelData;
                }
                ?>	
                <div align='left' class="tab-content">
                    <div class="alert">
                        Displaying For MTS - Bhakti Sagar For <strong><?php echo $circle_info[strtoupper($circle)]; ?></strong> For <strong><?php echo $languageData[$navlang]; ?></strong> Navigation Language
                    </div>
                </div>


                <div id="mainmenu_cat_div_devo">  
                    <table class="table table-bordered">
                        <tr> 
                            <?php
                            $k = 1;
                            $i = -1;
                            for ($j = 0; $j <= count($religionMenu); $j++) {
                                $i++;
                                if ($i % 3 == 0 && $i != 0) {
                                    echo "</tr><tr>";
                                }
                                if (!empty($religionMenu[$j])) {
                                    ?>

                                    <td><span class="label">&nbsp;&nbsp;&nbsp;<?php echo $k; ?>&nbsp;&nbsp;&nbsp;</span>

                                        <?php
                                        if (trim($religionMenu[$j]) == 'hindu') {
                                            if (array_key_exists($lang, $hindu_nav_lang_array)) {
                                                $nav_lang = $lang;
                                            } else {
                                                $nav_lang = '01';
                                            }
                                        }
                                        if (trim($religionMenu[$j]) == 'muslim') {
                                            if (array_key_exists($lang, $muslim_nav_lang_array)) {
                                                $nav_lang = $lang;
                                            } else {
                                                $nav_lang = '01';
                                            }
                                        }
                                        if (trim($religionMenu[$j]) == 'sikh') {
                                            if (array_key_exists($lang, $sikh_nav_lang_array)) {
                                                $nav_lang = $lang;
                                            } else {
                                                $nav_lang = '03';
                                            }
                                        }
                                        if (trim($religionMenu[$j]) == 'christian') {
                                            if (array_key_exists($lang, $christian_nav_lang_array)) {
                                                $nav_lang = $lang;
                                            } else {
                                                $nav_lang = '02';
                                            }
                                        }
                                        if (trim($religionMenu[$j]) == 'buddhism') {
                                            if (array_key_exists($lang, $buddhism_nav_lang_array)) {
                                                $nav_lang = $lang;
                                            } else {
                                                $nav_lang = '01';
                                            }
                                        }
                                        if (trim($religionMenu[$j]) == 'jainism') {
                                            if (array_key_exists($lang, $jainism_nav_lang_array)) {
                                                $nav_lang = $lang;
                                            } else {
                                                $nav_lang = '01';
                                            }
                                        }
                                        ?>

                                        <a href="javascript:void(0);" onclick="showDevoContent('<?php echo trim($religionMenu[$j]); ?>','<?php echo $nav_lang; ?>','<?php echo $circle; ?>','<?php echo $navlang; ?>','MTSDevo')">
                                            <?php echo ucwords($religionMenu[$j]); ?>
                                        </a>



                                    </td>
                                    <?php
                                    $k++;
                                }
                            }
                            ?>
                            <?php
                            for ($k1 = 1; $k1 < (3 - $i % 3); $k1++) {
                                //  echo "<td>&nbsp;</td>";
                            }
                            ?>
                        </tr>
                    </table>
                </div>
                <?php
            }
            /* MTS Bhakti Sagar End here */ elseif ($service == "TataDoCoMoMX") {
                /* For docomo endless start here */
                $DOCOMOfilePath = "http://192.168.100.227:8081/hungama/config/config/tatm/" . $circle . "/mainmenuorder.cfg";
                $lines = file($DOCOMOfilePath);
                $iscount = count($lines);

                $muDataValue = array();
                foreach ($lines as $line_num => $MUData) {
                    $muDataValue[] = $MUData;
                }
                ?>
                <div align='left' class="tab-content">
                    <div class="alert">
                        Displaying For Tata DoCoMo - Endless Music For <strong><?php echo $circle_info[strtoupper($circle)]; ?></strong> For <strong><?php echo $languageData[$lang]; ?></strong> Navigation Language
                    </div>
                </div>
                <div id="docomo_mainmenu" class="tab-pane">
                    <!--ul class="breadcrumb">  
                <li>  
                <a href="javascript:void(0)" onclick="showMainMenu('<?= $lang ?>','<?= $circle ?>','TataDoCoMoMX')">Root</a> <span class="divider">/</span>  
                </li>  
                <li class="active">Docomo Endless</li> 
                </ul-->	 

                    <table class="table table-bordered">
                        <tr> 
                            <?php
                            $k = 1;
                            $i = -1;
                            for ($j = 0; $j <= count($muDataValue); $j++) {
                                $i++;
                                if ($i % 3 == 0 && $i != 0) {
                                    echo "</tr><tr>";
                                }
                                if (!empty($muDataValue[$j])) {
                                    if ($muDataValue[$j] == '18') {
                                        $lang1 = substr($muDataValue[$j], 0, 2);
                                        $album = "Other Categories";
                                        $flag = 2;
                                    } else if ($muDataValue[$j] == 00) {
                                        $lang = trim($_GET['lang']);
                                        //read file here for spl zone content
                                        $todaytime = date(jm);
                                        $SPLZONEFilePath = "http://192.168.100.226:8081/hungama/config/mod/" . $lang . "_spzone.cfg";
                                        $checkzonefile = get_contents($SPLZONEFilePath);
                                        if ($checkzonefile) {
                                            $SPLZONEFilePath = "http://192.168.100.226:8081/hungama/config/mod/" . $lang . "_spzone.cfg";
                                            $mainsplzonefilePath = '';
                                            $lines = file($SPLZONEFilePath);
                                            $allani = array();
                                            foreach ($lines as $line_num => $datename) {
                                                $spzoneCfile = explode(":", trim($datename));
                                                if ($spzoneCfile[0] == $todaytime) {

                                                    $mainsplzonefilePath = $lang . "00_" . $spzoneCfile[1];
                                                }
                                            }
                                        }
                                        $flag = 9;
                                    } else {
                                        $query = "select * from master_db.tbl_subcategory_master where catID=substr('" . $muDataValue[$j] . "',3,2)";
                                        $result = mysql_query($query, $dbConn);
                                        $data = mysql_fetch_row($result);
                                        $flag = 0;
                                        if (!$data[0])
                                            $album = 'Content Not Available';
                                        elseif ($data[0] == 'unplugged')
                                            $album = 'Content Not Available';
                                        else {
                                            $lang1 = substr($muDataValue[$j], 0, 2);
                                            $album = $languageData[$lang1] . "-" . $data[0];
                                            $flag = 1;
                                        }
                                    }
                                    ?>

                                    <td><span class="label">&nbsp;&nbsp;&nbsp;<?php echo $k; ?>&nbsp;&nbsp;&nbsp;</span>

                                        <?php if ($flag == 1) { ?>
                                            <a href="javascript:void(0);" onclick="showContent_data_docomo('TataDoCoMoMX','<?php echo $circle; ?>','<?php echo $lang; ?>','<?php echo trim($muDataValue[$j]); ?>','<?php echo $album; ?>')"><?php echo $album; ?></a>

                                        <?php } elseif ($flag == 2) { ?><a href="#" onclick="showTDMXCateData('TataDoCoMoMX','<?php echo $circle; ?>','<?php echo $lang; ?>','Other Categories','1');"><?php echo $album; ?></a><?php
                    } elseif ($flag == 3) {
                                            ?><a href="#" onclick="showMUspData('TataDoCoMoMX','<?php echo $circle; ?>','<?php echo $lang; ?>');"><?php echo $album; ?></a><?php
                    } elseif ($flag == 9) {
                        if ($checkzonefile) {
                                                ?>
                                                <a href="javascript:void(0);" onclick="showContent_data_docomo('TataDoCoMoMX_splzone','<?php echo $circle; ?>','<?php echo $lang; ?>','<?php echo trim($mainsplzonefilePath); ?>','SPL ZONE')"><?php echo 'SPL Zone'; ?></a>
                                                <?php
                                            } else {
                                                ?>
                                                <?php echo 'SPL Zone'; ?>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </td>
                                    <?php
                                    $k++;
                                }
                            }
                            ?>
                            <?php
                            for ($k1 = 1; $k1 < (3 - $i % 3); $k1++) {
                                //  echo "<td>&nbsp;</td>";
                            }
                            ?>
                        </tr>
                    </table>
                </div>					
                <?php
                /* For docomo endless end here */
            }
            /* MTSMU Service code start here */ elseif ($service == "MTSMU") {
                $MTSMUfilePath = "http://10.130.14.106:8080/hungama/config/config/mtsm/" . $circle . "/mainmenuorder.cfg";
                $lines = file($MTSMUfilePath);
                $iscount = count($lines);

                $muDataValue = array();
                foreach ($lines as $line_num => $MUData) {
                    $muDataValue[] = $MUData;
                }
                ?>
                <div align='left' class="tab-content">
                    <div class="alert">
                        Displaying For MTS - muZic Unlimited For <strong><?php echo $circle_info[strtoupper($circle)]; ?></strong> For <strong><?php echo $languageData[$lang]; ?></strong> Navigation Language
                    </div>
                </div>
                <div id="mtsmu_mainmenu" class="tab-pane">

                    <table class="table table-bordered">
                        <tr> 
                            <?php
                            $k = 1;
                            $i = -1;
                            for ($j = 0; $j <= count($muDataValue); $j++) {
                                $i++;
                                if ($i % 3 == 0 && $i != 0) {
                                    echo "</tr><tr>";
                                }
                                if (!empty($muDataValue[$j])) {
                                    if ($muDataValue[$j] == '24') {
                                        $lang1 = substr($muDataValue[$j], 0, 2);
                                        $album = "Other Categories";
                                        $flag = 2;
                                    } else if ($muDataValue[$j] == 00) {
                                        $lang = trim($_GET['lang']);
                                        //read file here for spl zone content
                                        $todaytime = date(jm);
                                        $SPLZONEFilePath = "http://10.130.14.106:8080/hungama/config/mod/" . $lang . "_spzone.cfg";
                                        $checkzonefile = get_contents($SPLZONEFilePath);
                                        if ($checkzonefile) {
                                            $SPLZONEFilePath = "http://10.130.14.106:8080/hungama/config/mod/" . $lang . "_spzone.cfg";
                                            $mainsplzonefilePath = '';
                                            $lines = file($SPLZONEFilePath);
                                            $allani = array();
                                            foreach ($lines as $line_num => $datename) {
                                                $spzoneCfile = explode(":", trim($datename));
                                                if ($spzoneCfile[0] == $todaytime) {

                                                    $mainsplzonefilePath = $lang . "00_" . $spzoneCfile[1];
                                                }
                                            }
                                        }
                                        $flag = 9;
                                    } else {
                                        $query = "select * from master_db.tbl_subcategory_master where catID=substr('" . $muDataValue[$j] . "',3,2)";
                                        $result = mysql_query($query, $dbConn);
                                        $data = mysql_fetch_row($result);
                                        $flag = 0;
                                        if (!$data[0])
                                            $album = 'Content Not Available';
                                        elseif ($data[0] == 'unplugged')
                                            $album = 'Content Not Available';
                                        else {
                                            $lang1 = substr($muDataValue[$j], 0, 2);
                                            $album = $languageData[$lang1] . "-" . $data[0];
                                            $flag = 1;
                                        }
                                    }
                                    ?>

                                    <td><span class="label">&nbsp;&nbsp;&nbsp;<?php echo $k; ?>&nbsp;&nbsp;&nbsp;</span>

                                        <?php if ($flag == 1) { ?>
                                            <a href="javascript:void(0);" onclick="showContent_data_mtsmu('MTSMU','<?php echo $circle; ?>','<?php echo $lang; ?>','<?php echo trim($muDataValue[$j]); ?>','<?php echo $album; ?>')"><?php echo $album; ?></a>

                                        <?php } elseif ($flag == 2) { ?><a href="#" onclick="showMTSMUCateData('MTSMU','<?php echo $circle; ?>','<?php echo $lang; ?>','Other Categories','1');"><?php echo $album; ?></a><?php
                    } elseif ($flag == 3) {
                                            ?><a href="#" onclick="showMUspData('MTSMU','<?php echo $circle; ?>','<?php echo $lang; ?>');"><?php echo $album; ?></a><?php
                    } elseif ($flag == 9) {
                        if ($checkzonefile) {
                                                ?>
                                                <a href="javascript:void(0);" onclick="showContent_data_mtsmu('MTSMU_splzone','<?php echo $circle; ?>','<?php echo $lang; ?>','<?php echo trim($mainsplzonefilePath); ?>','SPL ZONE')"><?php echo 'SPL Zone'; ?></a>
                                                <?php
                                            } else {
                                                ?>
                                                <?php echo 'SPL Zone'; ?>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </td>
                                    <?php
                                    $k++;
                                }
                            }
                            ?>
                            <?php
                            for ($k1 = 1; $k1 < (3 - $i % 3); $k1++) {
                                //  echo "<td>&nbsp;</td>";
                            }
                            ?>
                        </tr>
                    </table>
                </div>					
                <?php
            }
            /* MTSMU service end here */
            /* AircelMC Service code start here */ elseif ($service == "AircelMC") {
                $circleid = $circle_AMC_array[strtoupper($circle)];
                $AircelMCfilePath = "http://cmis.hungamavoice.com/MIS/SHVuZ2FtYSBhbmFseXRpa2VzIGRvbid0IGRhcmUgdG91Y2ggdGhpcyBmb2xkZXIgZWxzZSB5b3Ug/2.0/Conent.Live_Aircel_Menu.php?a=menu&c=" . $circleid . "&l=" . $lang;

                $getcirclemenu = file_get_contents($AircelMCfilePath);
                $circlefile = 'aircel-cache/circle/' . $circleid . '.cir';

                if (file_exists($circlefile)) {
                    //echo "Local Call";
                } else {
                    //echo "Aircel Server Call";
                    error_log($getcirclemenu, 3, $circlefile);
                }


                $lines = file($circlefile);
                $iscount = count($lines);

                $AMMCDataValue = array();
                foreach ($lines as $line_num => $MCData) {
                    $AMMCDataValue[] = $MCData;
                }
                //print_r($AMMCDataValue);
                ?>
                <div align='left' class="tab-content">
                    <div class="alert">
                        Displaying For Aircel- Music Connect For <strong><?php echo $circle_info[strtoupper($circle)]; ?></strong> For <strong><?php echo $languageData[$lang]; ?></strong> Navigation Language
                    </div>
                </div>
                <div id="aircelMC_mainmenu" class="tab-pane">

                    <table class="table table-bordered">
                        <tr> 
                            <?php
                            $k = 1;
                            $i = -1;
                            for ($j = 0; $j <= count($AMMCDataValue); $j++) {
                                $i++;
                                if ($i % 3 == 0 && $i != 0) {
                                    echo "</tr><tr>";
                                }

                                if (!empty($AMMCDataValue[$j])) {
                                    $menuid = explode("#", $AMMCDataValue[$j]);
                                    if ($menuid[0] != '111') {
                                        ?>
                                        <td><span class="label">&nbsp;&nbsp;&nbsp;<?php echo $k; ?>&nbsp;&nbsp;&nbsp;</span>

                                            <a href="javascript:void(0);" onclick="showContent_data_aicelmc('AMCMU','<?php echo trim($menuid[0]); ?>','<?php echo trim($menuid[1]); ?>')"><?php echo $menuid[1]; ?></a>
                                        </td>
                                        <?php
                                    } $k++;
                                }
                            }
                            ?>
                            <?php
                            for ($k1 = 1; $k1 < (3 - $i % 3); $k1++) {
                                // echo "<td>&nbsp;</td>";
                            }
                            ?>
                        </tr>
                    </table>
                </div>					
                <?php
            }
            /* AircelMC Service code end here */ elseif ($service == "54646") {
                $operator = trim($_GET['operator']);
                if ($circle == 'pub')
                    $circle = 'pun';
                ?>			  
                <div align='left' class="tab-content">
                    <div class="alert">Displaying For 54646 For <strong><?php echo $circle_info[strtoupper($circle)]; ?></strong> For <strong><?php echo $languageData[$lang]; ?></strong> Navigation Language
                    </div>
                </div>
                <div id="mainmenu_cat_div_eu">
                    <table width="100%" class="table table-condensed table-bordered" id="example">
                        <thead> <tr>
                                <td><span class="label">&nbsp;&nbsp;&nbsp;1&nbsp;&nbsp;&nbsp;</span>&nbsp;<a href="#" onclick="showContent_54646('54646','<?php echo $circle; ?>','<?php echo $lang; ?>','<?php echo $operator; ?>');">Music World</a></td>
                                <td>
                                    <span class="label">&nbsp;&nbsp;&nbsp;2&nbsp;&nbsp;&nbsp;</span>&nbsp;<a href="javascript:void(0);" onclick="showMainMenu_54646('<?php echo $lang; ?>','<?php echo $circle; ?>','lg_54646','<?php echo $operator; ?>');">Love Guru</a>
                                </td>
                                <td><span class="label">&nbsp;&nbsp;&nbsp;3&nbsp;&nbsp;&nbsp;</span>&nbsp;<a href="#" onclick="showContent_54646('cw_54646','<?php echo $circle; ?>','<?php echo $lang; ?>','<?php echo $operator; ?>');">Celebrity World</a></td>
                                <td><span class="label">&nbsp;&nbsp;&nbsp;3&nbsp;&nbsp;&nbsp;</span>&nbsp;<a href="#" onclick="showContent_54646('ac_54646','<?php echo $circle; ?>','<?php echo $lang; ?>','<?php echo $operator; ?>');">Audio Cinema</a></td>
                            </tr>
                        </thead>					  
                    </table>
                </div>
                <?php
            }
            elseif ($service == "lg_54646") {
                $operator = trim($_GET['operator']);
                if ($circle == 'pub')
                    $circle = 'pun';
                ?>			  
                <div align='left' class="tab-content">
                    <div class="alert">Displaying For 54646 For <strong><?php echo $circle_info[strtoupper($circle)]; ?></strong> For <strong><?php echo $languageData[$lang]; ?></strong> Navigation Language
                    </div>
                </div>
                <ul class="breadcrumb">  
                    <li>  
                        <a href="javascript:void(0)" onclick="showMainMenu_54646('<?php echo $lang; ?>','<?php echo $circle; ?>','54646','<?php echo $operator; ?>');">Root</a> <span class="divider">/</span>  
                    </li>  
                    <li class="active">Love Guru</li> 
                </ul>
                <div id="mainmenu_cat_div_eu">
                    <table width="100%" class="table table-condensed table-bordered" id="example">
                        <thead> <tr>
                                <td><span class="label">&nbsp;&nbsp;&nbsp;1&nbsp;&nbsp;&nbsp;</span>&nbsp;<a href="#" onclick="">Dusro ki problem</a></td>
                                <td>
                                    <span class="label">&nbsp;&nbsp;&nbsp;2&nbsp;&nbsp;&nbsp;</span>&nbsp;<a href="javascript:void(0);" onclick="">Apni prblm record</a>
                                </td>
                                <td><span class="label">&nbsp;&nbsp;&nbsp;3&nbsp;&nbsp;&nbsp;</span>&nbsp;<a href="#" onclick="">Love sutra(SMS)</a></td>
                            </tr>
                        </thead>					  
                    </table>
                </div>
                <?php
            }

            /* 54646 Service code end here */
            break;
        case '3': $circle = strtolower(trim($_GET['circle']));
            $lang = trim($_GET['lang']);
            $service = trim($_GET['service']);
            if ($circle == 'pub')
                $circle = 'pun';

            if ($service == 'ac') {
                $ACfilePath = "http://10.2.73.156:8080/hungama/config/AMUconfig/audiosongconfig/" . $circle . "/audiocinema_main.cfg";
                //echo $ACfilePath;
                $lines = file($ACfilePath);
                $iscount = count($lines);

                $acDataValue = array();
                foreach ($lines as $line_num => $ACData) {
                    $acDataValue[] = $ACData;
                    $flag = 1;
                }
                ?>

                <!--table align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1"  width="80%" class="table table-condensed table-bordered">
                 <thead><tr>
                                <th style="padding-left: 5px;" bgcolor="#ffffff" height="35" width='20%' align='center'>DTMF</th>
                                <th style="padding-left: 5px;" bgcolor="#ffffff" height="35" align='center'>Category Name</th>
                        </tr>	
                </thead-->	
                <ul class="breadcrumb">  
                    <li>  
                        <a href="javascript:void(0)" onclick="showMainMenu('<?= $lang ?>','<?= $circle ?>','AirtelEU')">Root</a> <span class="divider">/</span>  
                    </li>  
                    <li class="active">Audio Cinema</li> 
                </ul>
                <div id="tabs4-pane2" class="tab-pane">
                    <!--- table box start for audio cinema here-->
                    <table class="table table-bordered">
                        <tr> 					
                            <?php
                            $i = -1;
                            for ($j = 0; $j <= count($acDataValue); $j++) {
                                $i++;
                                if ($i % 3 == 0 && $i != 0) {
                                    echo "</tr><tr>";
                                }
                                if ($acDataValue[$j]) {
// get category name start here

                                    $AudioCinemaData = array('0121' => 'Bollywood New Releases', '22' => 'Classics - Bollywood', '23' => 'Best of Bollywood', '24' => 'Love Hits', '21' => 'Hits');
                                    foreach ($AudioCinemaData as $k => $v) {
                                        //	echo trim($acDataValue[$j])."<br>";
                                        if (trim($acDataValue[$j]) == '0121') {
                                            $catgname = "Bollywood New Releases";
                                        } else {
                                            if ($k == substr(trim($acDataValue[$j]), -2)) {
                                                $catgname = $v;
                                            }
                                        }
                                    }


                                    $lang1 = substr($acDataValue[$j], 0, 2);
                                    $album = $languageData[$lang1] . "-" . $catgname;
                                    $flag = 1;
                                    ?>

                                    <?php ?> 
                                    <td><span class="label">&nbsp;&nbsp;&nbsp;<?php echo $j + 1; ?>&nbsp;&nbsp;&nbsp;</span>

                                        <?php if ($flag) { ?>
                                            <a href='#' onclick="javascript:showACData('<?php echo trim($acDataValue[$j]); ?>','<?php echo $circle; ?>','<?php echo $lang; ?>','ac','<?php echo $album; ?>');">
                                                <?php echo $album; ?></a><?php
                    } else {
                        echo trim($album);
                    }
                                            ?>


                                    </td>





                                    <?php
                                }
                            }
                            ?>	

                            <?php
                            for ($k1 = 1; $k1 <= (3 - $i % 3); $k1++) {
                                echo "<td>&nbsp;</td>";
                                // echo "<td>&nbsp;</td>";
                            }
                            ?>
                        </tr>
                    </table>
                    <!--- table box end here-->
                </div>						
                <!--/table--><?php
            } elseif ($service == 'mu') {
                $MUfilePath = "http://10.2.73.156:8080/hungama/config/AMUconfig/" . $circle . "/mainmenuorder.cfg";
                $lines = file($MUfilePath);
                $iscount = count($lines);

                $muDataValue = array();
                foreach ($lines as $line_num => $MUData) {
                    $muDataValue[] = $MUData;
                }
                            ?>
                <ul class="breadcrumb">  
                    <li>  
                        <a href="javascript:void(0)" onclick="showMainMenu('<?= $lang ?>','<?= $circle ?>','AirtelEU')">Root</a> <span class="divider">/</span>  
                    </li>  
                    <li class="active">Music Unlimited</li> 
                </ul>	 
                <div id="tabs4-pane2" class="tab-pane">
                    <table class="table table-bordered">
                        <tr> 
                            <?php
                            $k = 1;
                            $i = -1;
                            for ($j = 0; $j <= count($muDataValue); $j++) {
                                $i++;
                                if ($i % 3 == 0 && $i != 0) {
                                    echo "</tr><tr>";
                                }
                                if (!empty($muDataValue[$j])) {
                                    if ($muDataValue[$j] == '24') {
                                        $lang1 = substr($muDataValue[$j], 0, 2);
                                        $album = "Other Categories";
                                        $flag = 2;
                                    } else if ($muDataValue[$j] == 00) {
                                        $lang = trim($_GET['lang']);
                                        //read file here for spl zone content
                                        $todaytime = date(jm);
                                        $SPLZONEFilePath = "http://10.2.73.156:8080/hungama/config/AMUconfig/splzone/mod/" . $lang . "_spzone.cfg";
                                        $checkzonefile = get_contents($SPLZONEFilePath);
                                        if ($checkzonefile) {
                                            $SPLZONEFilePath = "http://10.2.73.156:8080/hungama/config/AMUconfig/splzone/mod/" . $lang . "_spzone.cfg";
                                            $mainsplzonefilePath = '';
                                            $lines = file($SPLZONEFilePath);
                                            $allani = array();
                                            foreach ($lines as $line_num => $datename) {
                                                $spzoneCfile = explode(":", trim($datename));
                                                if ($spzoneCfile[0] == $todaytime) {

                                                    $mainsplzonefilePath = $lang . "00_" . $spzoneCfile[1];
                                                }
                                            }
                                        }



                                        $flag = 9;
                                    } else {
                                        $query = "select * from master_db.tbl_subcategory_master where catID=substr('" . $muDataValue[$j] . "',3,2)";
                                        //echo "<br>";	
                                        $result = mysql_query($query, $dbConn);
                                        $data = mysql_fetch_row($result);
                                        $flag = 0;
                                        if (!$data[0])
                                            $album = 'Content Not Available';
                                        elseif ($data[0] == 'unplugged')
                                            $album = 'Content Not Available';
                                        else {
                                            $lang1 = substr($muDataValue[$j], 0, 2);
                                            $album = $languageData[$lang1] . "-" . $data[0];
                                            $flag = 1;
                                        }
                                    }
                                    ?>

                                    <!--- table box start here-->
                                    <?php ?> 
                                    <td><span class="label">&nbsp;&nbsp;&nbsp;<?php echo $k; ?>&nbsp;&nbsp;&nbsp;</span>

                                        <?php if ($flag == 1) { ?>
                                            <a href="javascript:void(0);" onclick="showContent_data('mu','<?php echo $circle; ?>','<?php echo $lang; ?>','<?php echo trim($muDataValue[$j]); ?>','<?php echo $album; ?>')"><?php echo $album; ?></a>

                                        <?php } elseif ($flag == 2) { ?><a href="#" onclick="showMUCateData('mu','<?php echo $circle; ?>','<?php echo $lang; ?>','Other Categories','1');"><?php echo $album; ?></a><?php
                    } elseif ($flag == 3) {
                                            ?><a href="#" onclick="showMUspData('mu','<?php echo $circle; ?>','<?php echo $lang; ?>');"><?php echo $album; ?></a><?php
                    } elseif ($flag == 9) {
                        if ($checkzonefile) {
                                                ?>
                                                <a href="javascript:void(0);" onclick="showContent_data('mu_splzone','<?php echo $circle; ?>','<?php echo $lang; ?>','<?php echo trim($mainsplzonefilePath); ?>','SPL ZONE')"><?php echo 'SPL Zone'; ?></a>
                                                <?php
                                            } else {
                                                ?>
                                                <?php echo 'SPL Zone'; ?>
                                                <?php
                                            }
                                        }
                                        ?>



                                    </td>


                                    <!--- table box end here-->


                                    <?php
                                    $k++;
                                }
                            }
                            ?>
                            <?php
                            for ($k1 = 1; $k1 < (3 - $i % 3); $k1++) {
                                //  echo "<td>&nbsp;</td>";
                            }
                            ?>
                        </tr>
                    </table>
                </div>					
                <!--/table-->

                <?php
            }
            break;
        case '4': $service = trim($_GET['service']);
            $circle = strtolower(trim($_GET['circle']));
            $lang = trim($_GET['lang']);
            if ($circle == 'pub')
                $circle = 'pun';
            $catname = $_GET['catname'];
            $_SESSION['bc_catname'] = $catname;
            $_SESSION['mucatname'] = $_GET['mucatname'];
            if ($service == 'ac') {
                $clipCfg = trim($_GET['clip']);
                $ACClipFilePath = "http://10.2.73.156:8080/hungama/config/AMUconfig/audiosongconfig/" . $clipCfg . "-clip.cfg";
                $lines = file($ACClipFilePath);
                $iscount = count($lines);

                $acDataValue = array();
                foreach ($lines as $line_num => $ACData1) {
                    $acClipDataValue[] = $ACData1;
                }
                ?>
                <ul class="breadcrumb">
                    <li>  
                        <a href="javascript:void(0)" onclick="showMainMenu('<?= $lang ?>','<?= $circle ?>','AirtelEU')">Root</a> <span class="divider">/</span>  
                    </li>
                    <li>  
                        <a href="javascript:void(0)" onclick="showContent('ac','<?= $circle ?>','<?= $lang ?>')">Audio Cinema</a> <span class="divider">/</span>  
                    </li>  
                    <li class="active"><?= $catname; ?></li> 
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
                    <?php
                    $k = 1;
                    for ($i = 0; $i < count($acClipDataValue); $i++) {
                        $tempFileName = explode(".", $acClipDataValue[$i]);
                        if ($tempFileName[1] != 'wav') {
                            ?>
                            <!--tr>
                                    <td style="padding-left: 5px;" bgcolor="#ffffff" height="35" width='20%' align='center'><?php echo $k; ?></td>
                                    <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;
                            <a href="javascript:void(0);" onclick="showContent_data('ac','<?php echo $circle; ?>','<?php echo $lang; ?>','<?php echo trim($acClipDataValue[$i]); ?>')"><?php echo $acClipDataValue[$i]; ?></a>
                            </td>
                            </tr-->
                            <?php
                            $query = "select SongUniqueCode,ContentName,AlbumName,language,Genre from misdata.content_musicmetadata where SongUniqueCode='" . trim($acClipDataValue[$i]) . "'";
                            $result = mysql_query($query, $dbConn_218);
                            $data = mysql_fetch_array($result);
                            //print_r($data);	
                            ?>
                            <tr>
                                <td style="padding-left: 5px;" bgcolor="#ffffff" height="35" align='center'><?php echo $i + 1; ?></td>
                                <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo trim($acClipDataValue[$i]); ?></td>
                                <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo $data['ContentName']; ?></td>
                                <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo $data['AlbumName']; ?></td>
                                <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">&nbsp;&nbsp;<?php echo $data['language']; ?></td>

                            </tr>
                            <?php
                            $k++;
                        }
                    }
                    ?>		
                </table><?php
        } elseif ($service == 'mu') {
            $MUCatFilePath = "http://10.2.73.156:8080/hungama/config/AMUconfig/" . $circle . "/catorder.cfg";
            $lines = file($MUCatFilePath);
            $iscount = count($lines);

            $muCatDataValue = array();
            $startfrom = trim($_REQUEST['startfrom']);
            /* 	$m=0;
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
            switch ($startfrom) {
                case '1':
                    $m = 0;
                    foreach ($lines as $line_num => $MUData) {
                        if ($m < 6) {
                            $langCode = trim($MUData);
                            $langName = $languageData[$langCode];
                            $muCatDataValue[$langCode] = $langName;
                        } else {
                            break;
                        }
                        $m++;
                    }
                    break;
                case '2':
                    $m = 6;
                    $c = 1;
                    foreach ($lines as $line_num => $MUData) {

                        if ($c > 6) {
                            if ($m < 12) {
                                $langCode = trim($MUData);
                                $langName = $languageData[$langCode];
                                $muCatDataValue[$langCode] = $langName;
                                $m++;
                            } else {
                                $m++;
                            }
                        }
                        //$m++;
                        $c++;
                    }
                    break;
                case '3':
                    $c = 1;
                    foreach ($lines as $line_num => $MUData) {
                        if ($c > 12 && $c <= 18) {
                            $langCode = trim($MUData);
                            $langName = $languageData[$langCode];
                            $muCatDataValue[$langCode] = $langName;
                        }
                        $c++;
                    }

                    break;
                case '4':
                    $m = 18;
                    $c = 1;
                    foreach ($lines as $line_num => $MUData) {
                        if ($c > 18) {
                            if ($m < 24) {
                                $langCode = trim($MUData);
                                $langName = $languageData[$langCode];
                                $muCatDataValue[$langCode] = $langName;
                                $m++;
                            } else {
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
                        <a href="javascript:void(0)" onclick="showMainMenu('<?= $lang ?>','<?= $circle ?>','AirtelEU')">Root</a> <span class="divider">/</span>  
                    </li>
                    <li>  
                        <a href="javascript:void(0)" onclick="showContent('mu','<?= $circle ?>','<?= $lang ?>')">Music Unlimited</a> <span class="divider">/</span>  
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
                          } */
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
                            $i = -1; //for($j=0;$j<=count($muCatDataValue);$j++) {
                            foreach ($muCatDataValue as $key => $value) {// echo $value."***";
                                $i++;
                                if ($i % 3 == 0 && $i != 0) {
                                    echo "</tr><tr>";
                                }
                                ?> 
                                <td><span class="label">&nbsp;&nbsp;&nbsp;<?php echo $i + 1; ?>&nbsp;&nbsp;&nbsp;</span>
                                    <a href='#' onclick="javascript:showMUSubData('<?php echo $key; ?>','<?php echo $circle; ?>','mu');"><?php echo $value; ?></a>
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
                            <tr><td <?php
                if (!$i) {
                    echo 'rowspan="2"';
                }
                            ?> ><ul class="pager"><li class="previous">
                            <?php if ($startfrom > 1 || $startfrom == 4) { ?>
                                                                                                    
                                                                                                    <a href="#" style="color:#97310e" onclick="showMUCateData('mu','<?php echo $circle; ?>','<?php echo $lang; ?>','Other Categories','<?= $startfrom - 1 ?>');">Previous</a>
                                                                                                    
                                <?php
                            }
                            if (!$i) {
                                echo "</li></ul></td></tr>";
                            } else {
                                echo "</li>
</ul></td><td>&nbsp;</td><td style='text-align:right'><ul class=\"pager\"><li class=\"next\">";
                                ?>
                                <?php if ($startfrom != 4) { ?>
                                                                                                                                                                            
                                                                                                                                                                <a href="#" style="color:#97310e" onclick="showMUCateData('mu','<?php echo $circle; ?>','<?php echo $lang; ?>','Other Categories','<?= $startfrom + 1 ?>');">Next</a>

                                    <?php
                                }
                                echo "</li>
</ul></td></tr>";
                            }
                            ?>
                            -->						
                        </tr>
                    </table>
                    <div class="dataTables_paginate paging_bootstrap pagination">
                        <ul>
                            <li class="prev">
                                <?php if ($startfrom > 1 || $startfrom == 4) { ?>
                                    <a href="#" style="color:#97310e" onclick="showMUCateData('mu','<?php echo $circle; ?>','<?php echo $lang; ?>','Other Categories','<?= $startfrom - 1 ?>');">&larr;Previous</a>
                                    <?php
                                } else {
                                    ?>
                                    <a href="#" >&larr;Previous</a>
                                    <?php
                                }
                                ?>
                            </li>
                            <li class="next">
                                <?php if ($startfrom != 4) { ?>
                                    <a href="#" style="color:#97310e" onclick="showMUCateData('mu','<?php echo $circle; ?>','<?php echo $lang; ?>','Other Categories','<?= $startfrom + 1 ?>');">Next&rarr; </a>
                                    <?php
                                } else {
                                    ?>
                                    <a href="#" >Next&rarr; </a>
                                <?php } ?>
                            </li></ul></div>   
                </div>
                <!-- code end here-->


                <?php
            }
            /* for docomo endlsess other cate start here */ elseif ($service == 'TataDoCoMoMX') {

                $TDMXCatFilePath = "http://192.168.100.227:8081/hungama/config/config/tatm/" . $circle . "/catorder.cfg";
                $lines = file($TDMXCatFilePath);
                $iscount = count($lines);

                $Tlines = count(file($TDMXCatFilePath));
                $TDMXCatDataValue = array();
                $startfrom = trim($_REQUEST['startfrom']);
                $stpoint = '';
                $endpoint = '';

                if ($startfrom == 1) {
                    $stpoint = 0;
                    $endpoint = 6;
                } else {
                    $stpoint = ($startfrom - 1) * 6;
                    $endpoint = $stpoint + 6;
                }
//echo $stpoint."******".$endpoint;


                switch ($startfrom) {
                    case '1':
                        $m = 0;
                        foreach ($lines as $line_num => $MUData) {
                            if ($m < 6) {
                                $langCode = trim($MUData);
                                $langName = $languageData[$langCode];
                                $TDMXCatDataValue[$langCode] = $langName;
                            } else {
                                break;
                            }
                            $m++;
                        }
                        break;
                    case '2':
                        $m = 6;
                        $c = 1;
                        foreach ($lines as $line_num => $MUData) {

                            if ($c > 6) {
                                if ($m < 12) {
                                    $langCode = trim($MUData);
                                    $langName = $languageData[$langCode];
                                    $TDMXCatDataValue[$langCode] = $langName;
                                    $m++;
                                } else {
                                    $m++;
                                }
                            }
                            //$m++;
                            $c++;
                        }
                        break;
                    case '3':
                        $c = 1;
                        foreach ($lines as $line_num => $MUData) {
                            if ($c > 12 && $c <= 18) {
                                $langCode = trim($MUData);
                                $langName = $languageData[$langCode];
                                $TDMXCatDataValue[$langCode] = $langName;
                            }
                            $c++;
                        }

                        break;
                    case '4':
                        $m = 18;
                        $c = 1;
                        foreach ($lines as $line_num => $MUData) {
                            if ($c > 18) {
                                if ($m < 24) {
                                    $langCode = trim($MUData);
                                    $langName = $languageData[$langCode];
                                    $TDMXCatDataValue[$langCode] = $langName;
                                    $m++;
                                } else {
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
                        <a href="javascript:void(0)" onclick="showMainMenu('<?= $lang ?>','<?= $circle ?>','TataDoCoMoMX')">Root</a> <span class="divider">/</span>  
                    </li>
                    <!--li>  
                      <a href="javascript:void(0)" onclick="showMainMenu('<?= $lang ?>','<?= $circle ?>','TataDoCoMoMX')">Docomo Endless</a> <span class="divider">/</span>  
                    </li--> 
                    <li class="active">
                        <?php
                        echo $_SESSION['mucatname'];
                        ?>
                    </li>
                </ul> 
                <!-- new code added for MU Others category data start here -->	

                <div id="tabs4_othr" class="tab-pane" >
                    <table class="table table-bordered">
                        <tr> 					
                            <?php
                            $i = -1;
                            foreach ($TDMXCatDataValue as $key => $value) {
                                $i++;
                                if ($i % 3 == 0 && $i != 0) {
                                    echo "</tr><tr>";
                                }
                                ?> 
                                <td><span class="label">&nbsp;&nbsp;&nbsp;<?php echo $i + 1; ?>&nbsp;&nbsp;&nbsp;</span>
                                    <a href='#' onclick="javascript:showMUSubData('<?php echo $key; ?>','<?php echo $circle; ?>','TataDoCoMoMX');"><?php echo $value; ?></a>
                                </td>
                            <?php } ?>	
                            <?php ?>

                        </tr>
                    </table>
                    <div class="dataTables_paginate paging_bootstrap pagination">
                        <ul>
                            <li class="prev">
                                <?php if ($startfrom > 1 || $startfrom == 4) { ?>
                                    <a href="#" style="color:#97310e" onclick="showTDMXCateData('TataDoCoMoMX','<?php echo $circle; ?>','<?php echo $lang; ?>','Other Categories','<?= $startfrom - 1 ?>');">&larr;Previous</a>
                                    <?php
                                } else {
                                    ?>
                                    <a href="#" >&larr;Previous</a>
                                    <?php
                                }
                                ?>
                            </li>
                            <li class="next">
                                <?php
//echo (($Tlines%6)<$startfrom+1)."<br>";
//echo $nav=($Tlines%6);
                                if ($startfrom < 3) {
                                    ?>
                                    <a href="#" style="color:#97310e" onclick="showTDMXCateData('TataDoCoMoMX','<?php echo $circle; ?>','<?php echo $lang; ?>','Other Categories','<?= $startfrom + 1 ?>');">Next&rarr; </a>
                                    <?php
                                } else {
                                    ?>
                                    <a href="#" >Next&rarr; </a>
                                <?php } ?>
                            </li></ul></div>   
                </div>
                <!-- code end here-->


                <?php
            }
            /* docomo endlsess other category end here */

            /* MTSMU Other category code start here */ elseif ($service == 'MTSMU') {
                $MTSMUCatFilePath = "http://10.130.14.106:8080/hungama/config/config/mtsm/" . $circle . "/catorder.cfg";
                $lines = file($MTSMUCatFilePath);
                $iscount = count($lines);

                $Tlines = count(file($MTSMUCatFilePath));
                $MTSMUCatDataValue = array();
                $startfrom = trim($_REQUEST['startfrom']);
                $stpoint = '';
                $endpoint = '';

                if ($startfrom == 1) {
                    $stpoint = 0;
                    $endpoint = 6;
                } else {
                    $stpoint = ($startfrom - 1) * 6;
                    $endpoint = $stpoint + 6;
                }
//echo $stpoint."******".$endpoint;


                switch ($startfrom) {
                    case '1':
                        $m = 0;
                        foreach ($lines as $line_num => $MTSMUData) {
                            if ($m < 6) {
                                $langCode = trim($MTSMUData);
                                $langName = $languageData[$langCode];
                                $MTSMUCatDataValue[$langCode] = $langName;
                            } else {
                                break;
                            }
                            $m++;
                        }
                        break;
                    case '2':
                        $m = 6;
                        $c = 1;
                        foreach ($lines as $line_num => $MTSMUData) {

                            if ($c > 6) {
                                if ($m < 12) {
                                    $langCode = trim($MTSMUData);
                                    $langName = $languageData[$langCode];
                                    $MTSMUCatDataValue[$langCode] = $langName;
                                    $m++;
                                } else {
                                    $m++;
                                }
                            }
                            //$m++;
                            $c++;
                        }
                        break;
                    case '3':
                        $c = 1;
                        foreach ($lines as $line_num => $MTSMUData) {
                            if ($c > 12 && $c <= 18) {
                                $langCode = trim($MTSMUData);
                                $langName = $languageData[$langCode];
                                $MTSMUCatDataValue[$langCode] = $langName;
                            }
                            $c++;
                        }

                        break;
                    case '4':
                        $m = 18;
                        $c = 1;
                        foreach ($lines as $line_num => $MTSMUData) {
                            if ($c > 18) {
                                if ($m < 24) {
                                    $langCode = trim($MTSMUData);
                                    $langName = $languageData[$langCode];
                                    $MTSMUCatDataValue[$langCode] = $langName;
                                    $m++;
                                } else {
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
                        <a href="javascript:void(0)" onclick="showMainMenu('<?= $lang ?>','<?= $circle ?>','MTSMU')">Root</a> <span class="divider">/</span>  
                    </li>
                    <!--li>  
                      <a href="javascript:void(0)" onclick="showMainMenu('<?= $lang ?>','<?= $circle ?>','MTSMU')">MTS - muZic Unlimited</a> <span class="divider">/</span>  
                    </li--> 
                    <li class="active">
                        <?php
                        echo $_SESSION['mucatname'];
                        ?>
                    </li>
                </ul> 
                <!-- new code added for MU Others category data start here -->	

                <div id="tabs4_othr" class="tab-pane" >
                    <table class="table table-bordered">
                        <tr> 					
                            <?php
                            $i = -1;
                            foreach ($MTSMUCatDataValue as $key => $value) {
                                $i++;
                                if ($i % 3 == 0 && $i != 0) {
                                    echo "</tr><tr>";
                                }
                                ?> 
                                <td><span class="label">&nbsp;&nbsp;&nbsp;<?php echo $i + 1; ?>&nbsp;&nbsp;&nbsp;</span>
                                    <a href='#' onclick="javascript:showMUSubData('<?php echo $key; ?>','<?php echo $circle; ?>','MTSMU');"><?php echo $value; ?></a>
                                </td>
                            <?php } ?>	
                            <?php ?>

                        </tr>
                    </table>
                    <div class="dataTables_paginate paging_bootstrap pagination">
                        <ul>
                            <li class="prev">
                                <?php if ($startfrom > 1 || $startfrom == 4) { ?>
                                    <a href="#" style="color:#97310e" onclick="showMTSMUCateData('MTSMU','<?php echo $circle; ?>','<?php echo $lang; ?>','Other Categories','<?= $startfrom - 1 ?>');">&larr;Previous</a>
                                    <?php
                                } else {
                                    ?>
                                    <a href="#" >&larr;Previous</a>
                                    <?php
                                }
                                ?>
                            </li>
                            <li class="next">
                                <?php
//echo (($Tlines%6)<$startfrom+1)."<br>";
//echo $nav=($Tlines%6);
                                if ($startfrom < 3) {
                                    ?>
                                    <a href="#" style="color:#97310e" onclick="showMTSMUCateData('MTSMU','<?php echo $circle; ?>','<?php echo $lang; ?>','Other Categories','<?= $startfrom + 1 ?>');">Next&rarr; </a>
                                    <?php
                                } else {
                                    ?>
                                    <a href="#" >Next&rarr; </a>
                                <?php } ?>
                            </li></ul></div>   
                </div>
                <!-- code end here-->


                <?php
            }

            /* MTSMU other category code end here */
            break;
        case '5': $circle = strtolower(trim($_GET['circle']));
            $lang = trim($_GET['lang']);
            $_SESSION['othesubcate'] = $languageData[$lang];
            $service = trim($_GET['service']);
            if ($service == 'ac') {
                $fullFileCfg = trim($_GET['file']);
                if ($circle == 'pub')
                    $circle = 'pun';

                $ACFullFilePath = "http://10.2.73.156:8080/hungama/config/AMUconfig/audiosongconfig/FullAudioClip/" . $fullFileCfg . ".cfg";
                $lines1 = file($ACFullFilePath);
                $iscount = count($lines);

                $acFullDataValue = array();
                foreach ($lines1 as $line_num => $ACData2) {
                    $acFullDataValue[] = $ACData2;
                }
                ?>
                <div align='center' width="95%"><b>Audio Cinema Full Data</b></div>	
                <table align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1"  width="80%" class="table table-condensed table-bordered">		
                    <thead>
                        <tr align='center'>
                            <td style="padding-left: 5px;" bgcolor="#ffffff" height="35" width="10%">S.No#</td>
                            <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">Song Code</td>
                        </tr>
                    </thead>
                    <?php
                    $j = 1;
                    for ($i = 0; $i < count($acFullDataValue); $i++) {
                        if ($acFullDataValue[$i]) {
                            ?>
                            <tr>
                                <td style="padding-left: 5px;" bgcolor="#ffffff" height="35" width="10%"><?php echo $j; ?></td>
                                <td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><?php echo $acFullDataValue[$i]; ?></td>
                            </tr>
                            <?php
                            $j++;
                        }
                    }
                    ?>
                </table><?php
        } elseif ($service == 'mu') {
            $MUFullFilePath = "http://10.2.73.156:8080/hungama/config/AMUconfig/" . $circle . "/" . $lang . "_suborder.cfg";
            $lines1 = file($MUFullFilePath);
            $iscount = count($lines);

            $muCatValue = array();
            foreach ($lines1 as $line_num => $MUData2) {
                $muCatValue[] = $MUData2;
            }
                    ?>	
                <ul class="breadcrumb">
                    <li>  
                        <a href="javascript:void(0)" onclick="showMainMenu('<?= $lang ?>','<?= $circle ?>','AirtelEU')">Root</a> <span class="divider">/</span>  
                    </li>
                    <li>  
                        <a href="javascript:void(0)" onclick="showContent('mu','<?= $circle ?>','<?= $lang ?>')">Music Unlimited</a> <span class="divider">/</span>  
                    </li> 

                    <li>
                        <a href="javascript:void(0)" onclick="showMUCateData('mu','<?php echo $circle; ?>','<?php echo $lang; ?>','Other Categories','1');">
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
                        $i = -1;
                        for ($j = 0; $j <= count($muCatValue); $j++) {
                            $i++;
                            if ($i % 3 == 0 && $i != 0) {
                                echo "</tr><tr>";
                            }
                            if ($muCatValue[$j]) {
                                if ($muCatValue[$j] == '24') {
                                    $lang1 = substr($muCatValue[$j], 0, 2);
                                    $album = "Other Categories";
                                    $flag = 2;
                                } else {
                                    $query = "select * from master_db.tbl_subcategory_master where catID=substr('" . $muCatValue[$j] . "',3,2)";
                                    $result = mysql_query($query, $dbConn);
                                    $data = mysql_fetch_row($result);
                                    $flag = 0;
                                    if (!$data[0])
                                        $album = 'Content Not Available';
                                    elseif ($data[0] == 'unplugged')
                                        $album = 'Content Not Available';
                                    else {
                                        $lang1 = substr($muCatValue[$j], 0, 2);
                                        $album = $languageData[$lang1] . "-" . $data[0];
                                        $flag = 1;
                                    }
                                }
                                ?>

                                <?php ?> 
                                <td><span class="label">&nbsp;&nbsp;&nbsp;<?php echo $j + 1; ?>&nbsp;&nbsp;&nbsp;</span>

                                    <?php if ($flag) { ?>
                                        <a href='#' onclick="showContent_data('mu','<?php echo $circle; ?>','<?php echo $lang; ?>','<?php echo trim($muCatValue[$j]); ?>','<?php echo $album; ?>','musub')">
                                            <?php echo $album; ?></a><?php
                    } else {
                        echo trim($album);
                    }
                                        ?>


                                </td>
                                <?php
                            }
                        }
                        ?>	

                        <?php
                        for ($k1 = 1; $k1 <= (3 - $i % 3); $k1++) {
                            echo "<td>&nbsp;</td>";
                        }
                        ?>
                    </tr>
                </table>
                <?php
            } // end of elseif
            //tatadocmo endless service sub category code start here 
            elseif ($service == 'TataDoCoMoMX') {
                $MUFullFilePath = "http://192.168.100.227:8081/hungama/config/config/tatm/" . $circle . "/" . $lang . "_suborder.cfg";
                $lines1 = file($MUFullFilePath);
                $iscount = count($lines1);

                $muCatValue = array();
                foreach ($lines1 as $line_num => $MUData2) {
                    $muCatValue[] = $MUData2;
                }
                ?>	
                <ul class="breadcrumb">
                    <li>  
                        <a href="javascript:void(0)" onclick="showMainMenu('<?= $lang ?>','<?= $circle ?>','TataDoCoMoMX')">Root</a> <span class="divider">/</span>  
                    </li>
                    <!--li>  
                      <a href="javascript:void(0)" onclick="showMainMenu('<?= $lang ?>','<?= $circle ?>','TataDoCoMoMX')">Docomo Endless</a> <span class="divider">/</span>  
                    </li--> 

                    <li>
                        <a href="javascript:void(0)" onclick="showTDMXCateData('TataDoCoMoMX','<?php echo $circle; ?>','<?php echo $lang; ?>','Other Categories','1');">
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
                        $i = -1;
                        for ($j = 0; $j <= count($muCatValue); $j++) {
                            $i++;
                            if ($i % 3 == 0 && $i != 0) {
                                echo "</tr><tr>";
                            }
                            if ($muCatValue[$j]) {
                                if ($muCatValue[$j] == '24') {
                                    $lang1 = substr($muCatValue[$j], 0, 2);
                                    $album = "Other Categories";
                                    $flag = 2;
                                } else {
                                    $query = "select * from master_db.tbl_subcategory_master where catID=substr('" . $muCatValue[$j] . "',3,2)";
                                    $result = mysql_query($query, $dbConn);
                                    $data = mysql_fetch_row($result);
                                    $flag = 0;
                                    if (!$data[0])
                                        $album = 'Content Not Available';
                                    elseif ($data[0] == 'unplugged')
                                        $album = 'Content Not Available';
                                    else {
                                        $lang1 = substr($muCatValue[$j], 0, 2);
                                        $album = $languageData[$lang1] . "-" . $data[0];
                                        $flag = 1;
                                    }
                                }
                                ?>

                                <?php
                                ?> 
                                <td><span class="label">&nbsp;&nbsp;&nbsp;<?php echo $j + 1; ?>&nbsp;&nbsp;&nbsp;</span>

                                    <?php if ($flag) { ?>
                                        <a href='#' onclick="showContent_data_docomo('TataDoCoMoMX','<?php echo $circle; ?>','<?php echo $lang; ?>','<?php echo trim($muCatValue[$j]); ?>','<?php echo $album; ?>','tdmxsub')">
                                            <?php echo $album; ?></a><?php
                    } else {
                        echo trim($album);
                    }
                                        ?>


                                </td>
                                <?php
                            }
                        }
                        ?>	

                        <?php
                        for ($k1 = 1; $k1 <= (3 - $i % 3); $k1++) {
                            echo "<td>&nbsp;</td>";
                        }
                        ?>
                    </tr>
                </table>
                <?php
            }
            //tatadocmo endless service sub category code end here 
            //MTSMU service other category section start here
            elseif ($service == 'MTSMU') {
                $MTSMUFullFilePath = "http://10.130.14.106:8080/hungama/config/config/mtsm/" . $circle . "/" . $lang . "_suborder.cfg";
                $lines1 = file($MTSMUFullFilePath);
                $iscount = count($lines1);

                $MTSMUCatValue = array();
                foreach ($lines1 as $line_num => $MTSMUData) {
                    $MTSMUCatValue[] = $MTSMUData;
                }
                ?>	
                <ul class="breadcrumb">
                    <li>  
                        <a href="javascript:void(0)" onclick="showMainMenu('<?= $lang ?>','<?= $circle ?>','MTSMU')">Root</a> <span class="divider">/</span>  
                    </li>
                    <!--li>  
                      <a href="javascript:void(0)" onclick="showMainMenu('<?= $lang ?>','<?= $circle ?>','MTSMU')">MTS - muZic Unlimited</a> <span class="divider">/</span>  
                    </li--> 

                    <li> 
                        <a href="javascript:void(0)" onclick="showMTSMUCateData('MTSMU','<?php echo $circle; ?>','<?php echo $lang; ?>','Other Categories','1');">
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

                <table class="table table-bordered">
                    <tr> 					
                        <?php
                        $i = -1;
                        for ($j = 0; $j <= count($MTSMUCatValue); $j++) {
                            $i++;
                            if ($i % 3 == 0 && $i != 0) {
                                echo "</tr><tr>";
                            }
                            if ($MTSMUCatValue[$j]) {
                                if ($MTSMUCatValue[$j] == '24') {
                                    $lang1 = substr($MTSMUCatValue[$j], 0, 2);
                                    $album = "Other Categories";
                                    $flag = 2;
                                } else {
                                    $query = "select * from master_db.tbl_subcategory_master where catID=substr('" . $MTSMUCatValue[$j] . "',3,2)";
                                    $result = mysql_query($query, $dbConn);
                                    $data = mysql_fetch_row($result);
                                    $flag = 0;
                                    if (!$data[0])
                                        $album = 'Content Not Available';
                                    elseif ($data[0] == 'unplugged')
                                        $album = 'Content Not Available';
                                    else {
                                        $lang1 = substr($MTSMUCatValue[$j], 0, 2);
                                        $album = $languageData[$lang1] . "-" . $data[0];
                                        $flag = 1;
                                    }
                                }
                                ?>

                                <?php ?> 
                                <td><span class="label">&nbsp;&nbsp;&nbsp;<?php echo $j + 1; ?>&nbsp;&nbsp;&nbsp;</span>

                                    <?php if ($flag) { ?>
                                        <a href='#' onclick="showContent_data_mtsmu('MTSMU','<?php echo $circle; ?>','<?php echo $lang; ?>','<?php echo trim($MTSMUCatValue[$j]); ?>','<?php echo $album; ?>','mtsmusub')">
                                            <?php echo $album; ?></a><?php
                    } else {
                        echo trim($album);
                    }
                                        ?>


                                </td>
                                <?php
                            }
                        }
                        ?>	

                        <?php
                        for ($k1 = 1; $k1 <= (3 - $i % 3); $k1++) {
                            echo "<td>&nbsp;</td>";
                        }
                        ?>
                    </tr>
                </table>
                <?php
            }
            //MTSMU service other category section end here 
            break;
        case '6': $lang = $_GET['lang'];
            $religion = $_GET['religion'];
            $circle = $_GET['circle'];
            $navlang = $_GET['navlang'];
            $devoservicename = $_GET['devoservicename'];

            $catData_dayspl = '';
//$catData_dayspl = array('hindu_0'.$lang=>'Day SPL','temple-'.$lang=>'Temples','myth_stories-'.$lang=>'Mythological Stories');
            $catData_dayspl = array('hindu_00' . date(w) => 'Day SPL', 'temple-' . $lang => 'Temples', 'myth_stories-' . $lang => 'Mythological Stories', 'muslim_000' => 'SPL ZONE', 'budh_000' => 'SPL ZONE', 'jain_000' => 'SPL ZONE', 'sikh_000' => 'SPL ZONE', 'christian_000' => 'SPL ZONE', 'church-' . $lang => 'Church', 'gurudwara-' . $lang => 'Gurudwara');
            if ($religion == 'hindu' && $lang == '01') {
                $day = date("D");
                $mday = date("d");
                $relFileName = $religion . $lang . "_" . strtolower($day) . ".cfg";
                //$catData_dayspl = array('hindu_0'.$lang=>'Day SPL','temple-'.$lang=>'Temples','myth_stories-'.$lang=>'Mythological Stories');
            } else {
                $relFileName = $religion . $lang . ".cfg";
            }
            if ($devoservicename == 'AirtelDevo') {
                $relFilePath = "http://10.2.73.156:8080/hungama/config/dev/airm/songconfig/" . $relFileName;
            } else {
                $relFilePath = "http://10.130.14.106:8080/hungama/config/dev/mtsm/songconfig/" . $relFileName;
            }

            $lines1 = file($relFilePath);
            $relCategoryData = array();
            foreach ($lines1 as $line_num => $RelData1) {
                $relCategoryData[] = $RelData1;
            } //print_r($relCategoryData); 
            ?>
            <ul class="breadcrumb">  
                <li>  
                    <a href="javascript:void(0)" onclick="showMainMenu('<?= $lang ?>','<?= $circle ?>','<?php echo $devoservicename; ?>','<?= $navlang ?>')">Root</a> <span class="divider">/</span>  
                </li>  
                <li class="active"><?php echo ucwords($religion); ?></li> 
            </ul>			
            <?php if (count($relCategoryData)) { ?>

                <!--- added for new table div-->
                <table class="table table-bordered">
                    <tr> 
                        <?php
                        $k = 1;
                        $i = -1;
                        for ($j = 0; $j < count($relCategoryData); $j++) {
                            $i++;
                            if ($i % 3 == 0 && $i != 0) {
                                echo "</tr><tr>";
                            }
                            $dataArray = explode("-", $relCategoryData[$j]);
                            $total = "";
                            $total = count($dataArray);
                            $catData = "";
                            if ($dataArray[$total - 1] == 0) {
                                for ($l = 0; $l < $total - 1; $l++) {
                                    if ($l == 0)
                                        $catData = $dataArray[0];  //$catData = substr($relCategoryData[$i], 0, -2);
                                    else
                                        $catData .="-" . $dataArray[$l];
                                }
                            } else {

                                //$catData = $relCategoryData[$j];
                                //for handling- temple/myth-stories and others which have 'xxxxx-1' in format
                                $catData = $dataArray[0] . '-' . $lang;
                            }
                            ?>

                            <td><span class="label">&nbsp;&nbsp;&nbsp;<?php echo $k; ?>&nbsp;&nbsp;&nbsp;</span>

                                <a href="javascript:void(0);" onclick="showDevoContent_main('<?php echo $devoservicename; ?>','<?php echo $circle; ?>','<?php echo $lang; ?>','<?php echo trim($catData) ?>','<?php echo $religion; ?>','<?php echo $navlang; ?>')">

                                    <?php
                                    if (array_key_exists($catData, $airtel_devotional_mapping)) {
                                        echo $airtel_devotional_mapping[$catData];
                                    } else {
                                        /* echo $mystring = $catData;
                                          echo $findme   = $religion;
                                          echo $pos = strpos($mystring, $findme);
                                         */
                                        if (array_key_exists($catData, $catData_dayspl)) {
                                            echo $catData_dayspl[$catData];
                                        } else {
                                            echo $catData;
                                        }
                                    }
                                    ?>
                                </a>


                            </td>
                            <?php
                            $k++;
                        }
                        ?>
                        <?php
                        for ($k1 = 1; $k1 < (3 - $i % 3); $k1++) {
                            echo "<td>&nbsp;</td>";
                        }
                        ?>
                    </tr>
                </table>
                <!--- added for new table div end here-->

                <!--table align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1"  width="80%" class="table table-condensed table-bordered">
                        <thead><tr align='center'>
                                <th style="padding-left: 5px;" bgcolor="#ffffff" height="35" width="20%">DTMF</th>
                                <th style="padding-left: 5px;" bgcolor="#ffffff" height="35">Category Name</th>
                        </tr> 
                        </thead>
                <?php /* for($i=0;$i<count($relCategoryData);$i++) { 
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


                 */ ?>
                        <tr>
                                <td style="padding-left: 5px;" bgcolor="#ffffff" height="35" width="20%"  align='center'><?php //$j=$i+1; echo $j;                 ?></td>
                                <td style="padding-left: 5px;" bgcolor="#ffffff" height="35">
                <a href="javascript:void(0);" onclick="showDevoContent_main('AirtelDevo','<?php //echo $circle;                 ?>','<?php //echo $lang;                 ?>','<?php //echo trim($catData)                 ?>','<?php //echo $religion;                 ?>')">

                <?php /*
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
                  <?php } */ ?>
                </table-->
                <?php
            } else {
                echo "<div align='center'  class='alert alert-block'>Data Not Available</div>";
            }
            break;
        case '7': $circle = strtolower(trim($_GET['circle']));
            $lang = trim($_GET['lang']);
            $service = trim($_GET['service']);
            $operator = trim($_GET['operator']);
            if ($circle == 'pub')
                $circle = 'pun';
            $ACfilePath = "http://192.168.100.226:8082/hungama/config/54646config_V2/" . $operator . "/mwconfig/mw_" . $circle . ".cfg";
            $lines = file($ACfilePath);
            $iscount = count($lines);

            $acDataValue = array();
            foreach ($lines as $line_num => $ACData) {
                $acDataValue[] = $ACData;
                $flag = 1;
            }
            ?>
            <ul class="breadcrumb">  
                <li>  
                    <a href="javascript:void(0)" onclick="showMainMenu_54646('<?php echo $lang; ?>','<?php echo $circle; ?>','<?php echo $service; ?>','<?php echo $operator; ?>');">Root</a> <span class="divider">/</span>  
                </li>  
                <li class="active">Music World</li> 
            </ul>
            <div id="tabs4-pane" class="tab-pane">
                <!--- table box start for audio cinema here-->
                <table class="table table-bordered">
                    <tr> 					
                        <?php
                        $i = -1;
                        for ($j = 0; $j <= count($acDataValue); $j++) {
                            $i++;
                            if ($i % 3 == 0 && $i != 0) {
                                echo "</tr><tr>";
                            }
                            if ($acDataValue[$j]) {
                                ?>

                                <?php ?> 
                                <td><span class="label">&nbsp;&nbsp;&nbsp;<?php echo $j + 1; ?>&nbsp;&nbsp;&nbsp;</span>

                                    <?php if ($acDataValue[$j] == '00') { ?>
                                        <a href='#' onclick="showSpecialZone_data_54646('54646','<?php echo $circle; ?>','<?php echo $lang; ?>','<?php echo $operator; ?>','<?php echo trim($acDataValue[$j]); ?>','tdmxsub')">
                                            <?php echo "SPL ZONE"; ?></a>
                                        <?php
                                    } else {
                                        $query = "select * from master_db.tbl_subcategory_master where catID=substr('" . $acDataValue[$j] . "',3,2)";
                                        $result = mysql_query($query, $dbConn);
                                        $data = mysql_fetch_row($result);
                                        $flag = 0;
                                        if (!$data[0])
                                            $album = 'Content Not Available';
                                        elseif ($data[0] == 'unplugged')
                                            $album = 'Content Not Available';
                                        else {
                                            $lang1 = substr($acDataValue[$j], 0, 2);
                                            $album = $languageData[$lang1] . "-" . $data[0];
                                            $flag = 1;
                                        }

                                        if (1) {
                                            ?>
                                            <a href='#' onclick="showContent_data_54646('54646','<?php echo $circle; ?>','<?php echo $lang; ?>','<?php echo $operator; ?>','<?php echo trim($acDataValue[$j]); ?>','tdmxsub')">
                                                <?php echo $album; ?></a><?php
                    } else {
                        //echo trim($acDataValue[$j]);//$album
                        echo trim($album);
                    }
                }
                                        ?>
                                </td>
                                <?php
                            }
                        }
                        ?>	

                        <?php
                        for ($k1 = 1; $k1 <= (3 - $i % 3); $k1++) {
                            echo "<td>&nbsp;</td>";
                        }
                        ?>
                    </tr>
                </table>
                <!--- table box end here-->
            </div>						
            <!--/table--><?php
                break;
            case '8': $circle = strtolower(trim($_GET['circle']));
                $lang = trim($_GET['lang']);
                $service = trim($_GET['service']);
                $operator = trim($_GET['operator']);
                if ($circle == 'pub')
                    $circle = 'pun';
                // $ACfilePath = "http://192.168.100.226:8082/hungama/config/54646config_V2/" . $operator . "/CelebrityWorld/StarInterview-" . $lang . ".cfg";
                // http://192.168.100.226:8082/hungama/config/54646config_V2/unim/audiosongconfig/audiocinema_main.cfg
                $ACfilePath = "http://192.168.100.226:8082/hungama/config/54646config_V2/" . $operator . "/audiosongconfig/audiocinema_main.cfg";
                $lines = file($ACfilePath);
                $iscount = count($lines);

                $acDataValue = array();
                foreach ($lines as $line_num => $ACData) {
                    $acDataValue[] = $ACData;
                    $flag = 1;
                }
                        ?>
            <ul class="breadcrumb">  
                <li>  
                    <a href="javascript:void(0)" onclick="showMainMenu_54646('<?php echo $lang; ?>','<?php echo $circle; ?>','54646','<?php echo $operator; ?>');">Root</a> <span class="divider">/</span>  
                </li>  
                <li class="active">Audio Cinema</li> 
            </ul>
            <div id="tabs4-pane" class="tab-pane">
                <!--- table box start for audio cinema here-->
                <table class="table table-bordered">
                    <tr> 					
                        <?php
                        $i = -1;
                        for ($j = 0; $j <= count($acDataValue); $j++) {
                            $i++;
                            if ($i % 3 == 0 && $i != 0) {
                                echo "</tr><tr>";
                            }
                            if ($acDataValue[$j]) {
                                ?>

                                <?php ?> 
                                <td><span class="label">&nbsp;&nbsp;&nbsp;<?php echo $j + 1; ?>&nbsp;&nbsp;&nbsp;</span>

                                    <?php
                                    $query = "select * from master_db.tbl_subcategory_master where catID=substr('" . $acDataValue[$j] . "',3,2)";
                                    $result = mysql_query($query, $dbConn);
                                    $data = mysql_fetch_row($result);
                                    $flag = 0;
                                    if (!$data[0])
                                        $album = 'Content Not Available';
                                    elseif ($data[0] == 'unplugged')
                                        $album = 'Content Not Available';
                                    else {
                                        $lang1 = substr($acDataValue[$j], 0, 2);
                                        $album = $languageData[$lang1] . "-" . $data[0];
                                        $flag = 1;
                                    }

                                    if (1) {
                                        ?>
                                        <a href='#' onclick="showContent_data_54646('ac_54646','<?php echo $circle; ?>','<?php echo $lang; ?>','<?php echo $operator; ?>','<?php echo trim($acDataValue[$j]); ?>','tdmxsub')">
                                            <?php echo $album; ?></a><?php
                    } else {
                        //echo trim($acDataValue[$j]);//$album
                        echo trim($album);
                    }
                                        ?>
                                </td>
                                <?php
                            }
                        }
                        ?>	

                        <?php
                        for ($k1 = 1; $k1 <= (3 - $i % 3); $k1++) {
                            echo "<td>&nbsp;</td>";
                        }
                        ?>
                    </tr>
                </table>
                <!--- table box end here-->
            </div>						
            <!--/table--><?php
                break;
            case '9': $circle = strtolower(trim($_GET['circle']));
                $lang = trim($_GET['lang']);
                $service = trim($_GET['service']);
                $operator = trim($_GET['operator']);
                $operator = trim($_GET['operator']);
                if ($circle == 'pub')
                    $circle = 'pun';
                        ?>			  
            <div align='left' class="tab-content">
                <div class="alert">Displaying For 54646 For <strong><?php echo $circle_info[strtoupper($circle)]; ?></strong> For <strong><?php echo $languageData[$lang]; ?></strong> Navigation Language
                </div>
            </div>
            <ul class="breadcrumb">  
                <li>  
                    <a href="javascript:void(0)" onclick="showMainMenu_54646('<?php echo $lang; ?>','<?php echo $circle; ?>','54646','<?php echo $operator; ?>');">Root</a> <span class="divider">/</span>  
                </li>  
                <li class="active">Celebrity World</li> 
            </ul>
            <div id="mainmenu_cat_div_eu">
                <table width="100%" class="table table-condensed table-bordered" id="example">
                    <thead> <tr>
                            <td><span class="label">&nbsp;&nbsp;&nbsp;1&nbsp;&nbsp;&nbsp;</span>&nbsp;<a href="#" onclick="showContent_data_54646('cw_54646','<?php echo $circle; ?>','<?php echo $lang; ?>','<?php echo $operator; ?>','<?php echo trim($acDataValue[$j]); ?>','tdmxsub')">Interview</a></td>
                        </tr>
                    </thead>					  
                </table>
            </div>
            <?php
            break;
            ?>
        <?php
    } //switch case end maindiv?>