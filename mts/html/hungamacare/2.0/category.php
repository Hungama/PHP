<?php
require_once("incs/db.php");
$languageData = array('01' => 'Hindi', '02' => 'English', '03' => 'Punjabi', '04' => 'Bhojpuri', '05' => 'Haryanavi', '06' => 'Bengali', '07' => 'Tamil', '08' => 'Telugu', '09' => 'Malayalam', '10' => 'Kannada', '11' => 'Marathi', '12' => 'Gujarati', '13' => 'Oriya', '14' => 'Kashmiri', '15' => 'Himachali', '16' => 'Chhattisgarhi', '17' => 'Assamese', '21' => 'Maithali', '19' => 'Nepali', '20' => 'Kumaoni', '18' => 'Rajasthani');
$circle = $_GET['circle'];
//$DOCOMOfilePath = "http://192.168.100.227:8081/hungama/config/config/tatm/" . strtolower($circle) . "/mainmenuorder.cfg";
//$lines = file($DOCOMOfilePath);
//$iscount = count($lines);
echo "<option value=Other Categories>Other Categories</option>";
exit;
$muDataValue = array();
$category = array();
foreach ($lines as $line_num => $MUData) {
    $muDataValue[] = $MUData;
    if ($MUData == '18') {
        $category[] = "Other Categories";
        echo "<option value=Other Categories>Other Categories</option>";
    } else if ($MUData == 00) {
        $category[] = "SPL Zone";
        echo "<option value=SPL Zone>SPL Zone</option>";
    } else {
        $query = "select category from master_db.tbl_subcategory_master where catID=substr('" . $MUData . "',3,2)";
        $result = mysql_query($query, $dbConn);
        $data = mysql_fetch_row($result);
        $category[] = $data[0];
        $lang_key = substr($MUData,0,2);
        foreach ($languageData as $key => $value){ 
            if($lang_key == $key)
               echo $lang_value = $value;
        }
        echo "<option value=" . $lang_value."-".$data[0] . ">" . $lang_value."-".$data[0] . "</option>";
    }
    
}
?>
