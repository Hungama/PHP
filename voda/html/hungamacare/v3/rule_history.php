<?php
ini_set('display_errors', '1');
$PAGE_TAG = 'sms-kci';
include "includes/constants.php";
include "includes/language.php";
require_once("../2.0/incs/db.php");
//$serviceArray = array('1515' => 'Airtel - Sarnam');
$serviceArray = array('1301' => 'VodafoneMU', '1302' => 'Vodafone54646');

$circle_info = array('DEL' => 'Delhi', 'GUJ' => 'Gujarat', 'WBL' => 'WestBengal', 'BIH' => 'Bihar', 'RAJ' => 'Rajasthan', 'UPW' => 'UP WEST', 'MAH' => 'Maharashtra',
    'APD' => 'Andhra Pradesh', 'UPE' => 'UP EAST', 'ASM' => 'Assam', 'TNU' => 'Tamil Nadu', 'KOL' => 'Kolkata', 'NES' => 'NE', 'CHN' => 'Chennai', 'ORI' => 'Orissa',
    'KAR' => 'Karnataka', 'HAY' => 'Haryana', 'PUN' => 'Punjab', 'MUM' => 'Mumbai', 'MPD' => 'Madhya Pradesh', 'JNK' => 'Jammu-Kashmir', 'PUB' => "Punjab", 'KER' => 'Kerala',
    'HPD' => 'Himachal Pradesh');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="favicon.png">
        <title><?php echo "RULE HISTORY"; ?></title>
        <?php
        echo CONST_CSS;
        echo EDITINPLACE_CSS;
        ?>

    </head>

    <body onload="javascript:viewUploadhistory('me');">
        <div class="container">
            <?php
            include "includes/menu.php";
            ?>
            <div class="row">
                <div class="col-md-12"><h4><?php echo "RULE History"; ?></h4></div>
            </div>    
            <div class="row">

            </div>
            <?php
            $get_query = "select id,rule_name,added_on from ";
            $get_query .=" master_db.tbl_rule_engagement nolock where status=1 order by id desc limit 20";
//echo $get_query;
            $query = mysql_query($get_query, $dbConn);
            $numofrows = mysql_num_rows($query);
            if ($numofrows == 0) {
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <div width="85%" align="left" class="txt">
                            <div class="alert alert-block">
                                <h4>Ooops!</h4>Hey,  we couldn't seem to find any record.
                            </div>
                        </div>
                        <?php
                    } else {
                        ?>
                        <center><div width="85%" align="left" class="txt">
                                <div class="alert alert" ><a href="javascript:void(0)" onclick="javascript:viewUploadhistory('<?php echo $uploadfor; ?>')" id="Refresh"><i class="icon-refresh"></i></a>
                                    <?php
                                    $limit = 20;
                                    echo " Displaying last " . $limit . " records";
                                    ?>
                                    </i>
                                </div></div><center>
                                <TABLE class="table table-condensed table-bordered">
                                    <thead>
                                        <TR height="30">
                                            <th align="left"><?php echo 'Rule ID'; ?></th>
                                            <th align="left"><?php echo 'Rule Name'; ?></th>
                                            <th align="left"><?php echo 'Added On'; ?></th>
                                            <th align="left"><?php echo 'Last Processed at'; ?></th>
                                            <th align="left"><?php echo 'Next Schedule'; ?></th>
                                            <th align="left"><?php echo 'Manage Rule'; ?></th>
                                        </TR>
                                    </thead>
                                    <?php
                                    while ($summarydata = mysql_fetch_array($query)) {
                                        ?>
                                        <TR height="30">
                                            <TD><?php echo $summarydata['id']; ?></TD>
                                            <TD><?php echo $summarydata['rule_name']; ?></TD>
                                            <TD><?php echo $summarydata['added_on']; ?></TD>
                                            <TD><?php echo $summarydata['added_on']; ?></TD>
                                            <TD><?php echo $summarydata['added_on']; ?></TD>
                                            <TD>
                                                <a href="#" onclick="showViewConfirm('<?php echo $summarydata['id']; ?>','view');">View</a>&nbsp;&nbsp;|&nbsp;&nbsp;  
                                                <a href="#" onclick="showPauseResumeConfirm('<?php echo $summarydata['id']; ?>','del')">Pause</a> 
                                            </TD>

                                        </TR>
                                        <?php
                                    }
                                    echo "</TABLE>";
                                }
                                ?>

                                <div id="grid-active"></div>
                                </div>
                                <br/>
                                <div id = "alert_placeholder"></div>
                                <div class="alert alert-danger" style='display:none' id="error_box"></div>
                                <div id="grid-view_upload_history"></div> 
                                </div> 

                                <br/>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div id="loading"><img src="<?php echo IMG_LOADING; ?>" border="0" /></div> 
                                    </div>

                                </div>   
                                <div class="row">
                                    <div class="col-md-12" id="grid">

                                    </div>
                                </div>
                                </div>  

                                </div>  

                                <?php
                                echo CONST_JS;
                                echo EDITINPLACE_JS;
                                ?>
                                <script>
     
                                </script>
                                </body>
                                </html>