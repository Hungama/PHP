<?php
session_start();
require_once("language.php");
require_once("incs/db.php");
require_once("base.php");
//echo "<pre>";print_r($_POST);//die('here');
$getCurrentTimeQuery = "select now()";
                $timequery2 = mysql_query($getCurrentTimeQuery);
                $currentTime = mysql_fetch_row($timequery2);
   
   
if (empty($_SESSION['loginId'])) {
    echo "<div width=\"85%\" align=\"left\" class=\"txt\">
		<div class=\"alert alert-danger\">Your session has timed out. Please login again.</div></div>";
    exit;
} else {
    $uploadeby = $_SESSION['loginId'];
}
if ($_REQUEST['id'] && $_REQUEST['act']) {
        $swid = $_REQUEST['id'];
        $actionType = $_REQUEST['act'];
        if ($actionType == 'enable') {
            $startQuery = "UPDATE Vodafone_IVR.tbl_vodm_switch_config SET STATUS=1 WHERE swid=" . $swid;
            mysql_query($startQuery,$dbConn);
        } elseif ($actionType == 'disable') {
            $endQuery = "UPDATE Vodafone_IVR.tbl_vodm_switch_config SET STATUS=0 WHERE swid=" . $swid;
            mysql_query($endQuery,$dbConn);
        } elseif ($actionType == 'delete') {
		$delQuery = "UPDATE Vodafone_IVR.tbl_vodm_switch_config SET STATUS=5 WHERE swid=" . $swid;
            mysql_query($delQuery,$dbConn);
        }
    }
$get_query = "select swid,servicename,startdatetime,enddatetime,editby,STATUS,mode,switchtype,circle,filename,serviceid,swid from Vodafone_IVR.tbl_vodm_switch_config order by swid desc";
$query = mysql_query($get_query, $dbConn);
//$viewhistoryfor = ucfirst($uploadvaluearray[$uploadfor]);
$numofrows = mysql_num_rows($query);
if ($numofrows == 0) {
    ?>
    <div width="85%" align="left" class="txt">
        <div class="alert alert-block">
            <?php // echo ALERT_NO_RECORD_FOUND; ?>
            <h4>Ooops!</h4>Hey,  we couldn't seem to find any record
        </div>
    </div>
    <?php
} else {
    ?>
    <center><div width="85%" align="left" class="txt">
        <div class="alert alert" ><a href="javascript:void(0)" onclick="javascript:viewSMSUploadhistory('switch')" id="Refresh"><i class="icon-refresh"></i></a>
                <?php
                //$limit = 20;
                echo "Configuration list";
                ?>
                </i>
            </div></div><center>
            <TABLE class="table table-condensed table-bordered">
                <thead>
                    <TR height="30">
						<th align="left"><?php echo 'Switch Id'; ?></th>
                        <th align="left"><?php echo 'Service Name'; ?></th>
                        <th align="left"><?php echo 'Start Time'; ?></th>
                        <th align="left"><?php echo 'End Time'; ?></th>
                        <th align="left"><?php echo 'Added by'; ?></th>
                        <th align="left"><?php echo 'Status'; ?></th>
                        <th align="left"><?php echo 'Type'; ?></th>
                        <th align="left"><?php echo 'Switch Type'; ?></th>
                        <th align="left"><?php echo 'Circle'; ?></th>
                        <th align="left"><?php echo 'Action'; ?></th>
                    </TR>
                </thead>
                <?php
                while (list($switchid,$servicename, $startdatetime, $enddatetime, $editby, $STATUS, $mode, $switchtype, $circle, $filename, $serviceid, $swid) = mysql_fetch_array($query)) {

                     ?>
                    <TR height="30">
					 <TD><?php echo $switchid; ?></TD>
                        <TD><?php echo $servicename; ?></TD>
                        <TD><?php echo date('j-M \'y g:i a',strtotime($startdatetime)); ?></TD>
						<TD><?php echo date('j-M \'y g:i a',strtotime($enddatetime)); ?></TD>
						<TD><?php echo $editby; ?></TD>
                        <TD>						
						<?php 
						if($STATUS==1)
						{?>
						<span class="label label-success"><?php echo 'Active'; ?></span>
						<?php
						}
						elseif($STATUS==0)
						{?>
						<span class="label label-info"><?php echo 'De-Active'; ?></span>
						<?php
						}
						elseif($STATUS==5)
						{?>
						<span class="label label-success"><?php echo 'Completed'; ?></span>
						<?php
						}		
					?>
						
						</TD>
                        <TD><?php if($mode=='C') { echo 'Circle'; } else { echo 'File';} ?></TD>
                        <TD><span class="label label-info"><?php echo $switchtype; ?></span></TD>
                        <TD><?php
            if ($circle == '0') {
                echo "NA";
            } else {
                        ?>
                                <?php
                                echo $circle;
                            }
                            ?>
                        </TD>
                       <TD><?php if ($STATUS == 1) { ?>
					      <a href="#" onclick="showStatusConfirm('<?php echo $swid ?>','disable');"><span class="label label-warning"><?php echo 'Disable'; ?>
						</span>		
								</a>
                            <?php } else if ($STATUS == 0) { ?>
							
                                <a href="#" onclick="showStatusConfirm('<?php echo $swid ?>','enable');">
								<span class="label label-info">
								<?php echo 'Enable'; ?>
								</span>
								</a>
								
                            <?php } 
							?>
						<?php if ($STATUS == 5) { ?>
							<span class="label label-success">							
							<?php echo 'Completed'; ?>
							</span>
							</TD>
							<?php }	else {?>
						&nbsp;|&nbsp;
                            <a href="#" onclick="showStatusConfirm('<?php echo $swid ?>','delete');">
							<span class="label label-warning">
							<?php echo 'Delete'; ?></span>
							</a></TD>
						<?php }?>
							
                    </TR>	
                    <?php
                }
                echo "</TABLE>";
            }?>
			 <div align='left' class="tab-content">
			<div class="alert alert-info">
<ul>
<li>Switch Type - <b>type1_7days </b>: (7 days  free access to all non active user)</li>
<li>Switch Type - <b>type2_SplBase </b>: (7 days free access to  specific base ( File Upload))</li>
<li>Switch Type - <b>type3_OneDay</b> : (One day totally free access to entire base)</li>
<li>Switch Type - <b>type4_3Songs</b> : (Open offer three song selection then subscribe ( For no active user))</li>
</ul>
					</div>
				</div> 
            <?php
			mysql_close($dbConn);
            ?>