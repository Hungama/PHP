<?php
include("session.php");
error_reporting(0);
//include database connection file
if ($_SESSION["id"] == "279") {
    echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=listallmissed_test.php">';
} else {
    include("db.php");
    $today = date("Y-m-d");
    $displaydate;
    if ($_POST['action'] == 1) {

        //$StartDate = date("Y-m-d",strtotime($_POST['obd_form_startdate']));
        $FromDate = date("Y-m-d", strtotime($_POST['from']));
        if(!empty($_POST['to']))
        {
        $ToDate = date("Y-m-d", strtotime($_POST['to']));
        }
        //$daterange="CALLDATE BETWEEN '$FromDate' AND '$ToDate'";
        if (!empty($FromDate) && !empty($ToDate)) {
            $daterange = "CALLDATE BETWEEN '$FromDate' AND '$ToDate'";
        } else {
            if (!empty($FromDate)) {
                $daterange = "CALLDATE ='$FromDate'";
                $ToDate=$FromDate;
            }
            if (!empty($ToDate)) {
                $daterange = "CALLDATE = '$ToDate'";
                $FromDate=$ToDate;
            }
        }


        $stype = strtolower($_POST['stype']);
        if (!empty($stype)) {
            switch ($stype) {
                case 'unique':
                    $sqlwhere = "group by APARTY";
					$flag=1;
                    break;
                case 'repeat':
                    $getcount = ",count(*) as total";
                    $sqlwhere = "group by APARTY HAVING total > 1";
					$flag=1;
                    break;
            }
        }
    $sql_getmsisdnlist = mysql_query("select APARTY,CALLDATE,CALLTIME,CIRCLE,CALLDURATION,RECORDEDSTATUS,RECIEVERID,CFCOMPLETE,LEGTYPE,DNIS,SMOKERSTATUS,SONGID $getcount from Hungama_PRINCEIVR.tbl_pinceivr_details  WHERE  $daterange $sqlwhere order by CALLTIME desc");
    } else {
        $sql_getmsisdnlist = mysql_query("select APARTY,CALLDATE,CALLTIME,CIRCLE,CALLDURATION,RECORDEDSTATUS,RECIEVERID,CFCOMPLETE,LEGTYPE,DNIS,SMOKERSTATUS,SONGID from Hungama_PRINCEIVR.tbl_pinceivr_details  WHERE  date(CALLDATE) = '$today' order by CALLTIME desc");
		//echo "select APARTY,CALLDATE,CALLTIME,CIRCLE,CALLDURATION,RECORDEDSTATUS,RECIEVERID,CFCOMPLETE,LEGTYPE,DNIS,SMOKERSTATUS,SONGID from Hungama_PRINCEIVR.tbl_pinceivr_details  WHERE  date(CALLDATE) = '$today' order by CALLTIME desc";
        $displaydate = $today;
    }
    $totalrecord = mysql_num_rows($sql_getmsisdnlist);

    //get all consolidated data for IVR
    $Query = "SELECT 'TotalCalls' as type ,count(*) as total FROM Hungama_PRINCEIVR.tbl_pinceivr_details
UNION 
SELECT 'UninqueCallers' as type , COUNT(distinct APARTY)  as total FROM Hungama_PRINCEIVR.tbl_pinceivr_details
UNION 
select  'CallMinuteUsed' as type , sum(CALLDURATION) as total  from Hungama_PRINCEIVR.tbl_pinceivr_details";
    $statusResult = mysql_query($Query);
    while ($row1 = mysql_fetch_array($statusResult)) {
        $type = $row1['type'];
        $status[$type] = $row1['total'];
    }
    $getDNIS = mysql_query("SELECT dnis,mappeddnis FROM Hungama_PRINCEIVR.tbl_princeivr_dnismapping");
    while ($row2 = mysql_fetch_array($getDNIS)) {
        $dnis = $row2['dnis'];
        $dnismapped[$dnis] = $row2['mappeddnis'];
        //echo $row2['mappeddnis'];
    }

    //get all repeat caller count
    $RepeatCaller = "SELECT APARTY, COUNT(*) c FROM Hungama_PRINCEIVR.tbl_pinceivr_details GROUP BY APARTY HAVING c > 1";
    $repeatCallerQuery = mysql_query($RepeatCaller);
    $totalRepeatCaller = mysql_num_rows($repeatCallerQuery);

    $circle_info = array('DEL' => 'Delhi', 'GUJ' => 'Gujarat', 'WBL' => 'WestBengal', 'BIH' => 'Bihar', 'RAJ' => 'Rajasthan', 'UPW' => 'UP WEST', 'MAH' => 'Maharashtra', 'APD' => 'Andhra Pradesh', 'UPE' => 'UP EAST', 'ASM' => 'Assam', 'TNU' => 'Tamil Nadu', 'KOL' => 'Kolkata', 'NES' => 'NE', 'CHN' => 'Chennai', 'ORI' => 'Orissa', 'KAR' => 'Karnataka', 'HAR' => 'Haryana', 'PUB' => 'Punjab', 'MUM' => 'Mumbai', 'MPD' => 'Madhya Pradesh', 'JNK' => 'Jammu-Kashmir', 'PUB' => "Punjab", 'KER' => 'Kerala', 'HPD' => 'Himachal Pradesh', '' => 'Other', 'HAY' => 'Haryana');
    ?> 
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html>
        <head>
            <title>Admin</title>
            <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
            <style media="all" type="text/css">@import "css/all.css";</style>
            <script language="javascript" type="text/javascript" src="datetimepicker/datetimepicker.js"></script>
            <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
            <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
            <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
            <script>
                $(function() {
                    $("#from").datepicker({
                        defaultDate: "+1w",
                        changeMonth: true,
                        numberOfMonths: 3,
                        onClose: function(selectedDate) {
                            $("#to").datepicker("option", "minDate", selectedDate);
                        }
                    });
                    $("#to").datepicker({
                        defaultDate: "+1w",
                        changeMonth: true,
                        numberOfMonths: 3,
                        onClose: function(selectedDate) {
                            $("#from").datepicker("option", "maxDate", selectedDate);
                        }
                    });
                });
            </script>
            <style>
                table.listing th {
                    background:#9097A9;
                    color:#fff;
                    /*	padding:5px;*/
                }
                #center-column4 {
                    float:left;
                    width:700px;
                    /*background:url(../img/bg-center-column.jpg) no-repeat left top;*/
                    min-height:584px;
                    padding:12px 16px 0 13px;
                }
  th.sno {
  width: 15%
}
            </style>
        </head>
        <body>

            <div id="main">
                <div id="header">
                    <a href="#" class="logo">
                        <!--img src="img/Hlogo.png" width="282" height="80" alt=""/-->
                        <h1>PrinceIVR</h1>
                    </a>
                </div>
                <div id="middle" >
                    <div id="left-column">
    <?php include('left-sidebar.php'); ?>	
                    </div>
                    <div id="center-column1" style="width:650px">
                        <div class="top-bar">
                            <h1>Call Log IVR</h1>
                        </div>

                        <div class="table" style="width:600px">
                            <!--img src="img/bg-th-left.gif" width="8" height="7" alt="" class="left" />
                            <img src="img/bg-th-right.gif" width="7" height="7" alt="" class="right" /-->
                            <table class="listing" cellpadding="0" cellspacing="0" style="width:600px" >
                                <form action="listallCallLogs.php" method="post">
                                    <tr class="bg">
                                        <td>
                                            <!--select name="circle" id="circle">
                                            <option value="">Select Circle</option>
    <?php foreach ($circle_info as $circle_id => $circle_val) { ?>
                                                        <option value="<?php echo $circle_id; ?>" <?php if ($circle_id == strtoupper($circle)) {
            echo "selected";
        } ?>><?php echo $circle_val; ?></option>
    <?php } ?>
                                    </select-->
                                            <select name="stype" id="stype">
                                                <option value="">Select Type</option>
                                                <option value="unique" <?php if ($stype == 'unique') {
        echo "selected";
    } ?>><?php echo 'Unique Caller'; ?></option>
                                                <option value="repeat" <?php if ($stype == 'repeat') {
        echo "selected";
    } ?>><?php echo 'Repeat Caller'; ?></option>
                                            </select>
                                        </td>
                                        <td colspan="10"><strong>Select Date &nbsp;&nbsp;&nbsp;</strong>
                                        <!--input type="text" id="startdate" maxlength="25" size="25" name="obd_form_startdate" value="<?php echo $displaydate; ?>">
                                        <a href="javascript:NewCal('startdate','ddmmmyyyy',true,24)"><img src="img/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a-->

                                            <label for="from">From</label>
                                            <input type="text" id="from" name="from" value="<?php echo $FromDate; ?>" autocomplete="off"/>
                                            <label for="to">to</label>
                                            <input type="text" id="to" name="to" value="<?php echo $ToDate; ?>" autocomplete="off"/>
                                            <input type="hidden" name="action" value="1" />
                                            <input type="submit" name="submit" value="Go"/>
                                            &nbsp;&nbsp;
    <?php
    if ($totalrecord > 0) {
//if(0)
        ?>
                                                <a href="xls_alldata.php?sdate=<?= $displaydate ?>&stype=<?= $stype ?>&fdate=<?= $FromDate ?>&todate=<?= $ToDate ?>" title="Click to download file.">
                                                    <img src="img/download-icon.png" width="32" height="32" alt="" /></a>
                                                <?php
                                            }
                                            ?>
                                        </td>


                                    </tr>
                                </form>
                                <tr>
                                    <th>Total Calls rec. till date</th>
                                    <th>Unique Callers</th>
                                    <th>Repeat Callers</th>
                                    <th colspan="8">Call Sec Used</th>

                                </tr>	
                                <tr>
                                    <td><?php echo $status['TotalCalls']; ?></td>
                                    <td><?php echo $status['UninqueCallers']; ?></td>
                                    <td><?php echo $totalRepeatCaller; ?></td>
                                    <td colspan="8"><?php echo $status['CallMinuteUsed']; ?></td>

                                </tr>		

    <?php
    if ($totalrecord > 0) {
        ?>
                                    <tr><th colspan="11">Total no of <?= $totalrecord; ?> records found of date <?= $displaydate; ?>.</th></tr>
                                    <tr>
                                        <th><strong>S.No</strong></th>
                                        <th><strong>Date</strong></th>
                                        <th><strong>Time</strong></th>
                                        <th><strong>Circle</strong></th>
                                        <th><strong>Caller_Id</strong></th>
                                        <th><strong>Call Duration</strong></th>
                                        <th><strong>Name Recorded</strong></th>
                                        <th><strong>Song Dedicated</strong></th>
                                        <th><strong>Rec_ID</strong></th>
                                        <th><strong>Call Flow Completed</strong></th>
                                        <th><strong>DNIS</strong></th>
										<th><strong>Category</strong></th>
										<th><strong>SMOKERSTATUS</strong></th>
                                    </tr>
        <?php
        $i = 1;
		if($flag)
		{
		/******************start for repeat/unique user*************************/
		 while ($result_list = mysql_fetch_array($sql_getmsisdnlist)) {
            if (!empty($result_list['APARTY'])) {
			$sql_getcalllogs = mysql_query("select APARTY,CALLDATE,CALLTIME,CIRCLE,CALLDURATION,RECORDEDSTATUS,RECIEVERID,CFCOMPLETE,LEGTYPE,DNIS,SMOKERSTATUS,SONGID  from Hungama_PRINCEIVR.tbl_pinceivr_details  WHERE  $daterange and APARTY='".$result_list['APARTY']."' order by CALLTIME desc");
		while ($result_list = mysql_fetch_array($sql_getcalllogs)) 
			{
			?>
			
                                            <tr>
                                            <td><?= $i; ?></td>
                                                <td><?= trim($result_list['CALLDATE']) ?></td>
                                                <td><?= trim($result_list['CALLTIME']) ?></td>
                                                <td><?php if (!empty($result_list['CIRCLE'])) {
                                echo $circle_info[strtoupper($result_list['CIRCLE'])];
                            } else {
                                echo "--";
                            } ?></td>
                                                <td><?php if (!empty($result_list['APARTY'])) {
                                echo $result_list['APARTY'];
                            } else {
                                echo "--";
                            } ?></td>		
                                                <td><?php if (!empty($result_list['CALLDURATION'])) {
                                echo $result_list['CALLDURATION'];
                            } else {
                                echo "--";
                            } ?></td>
                                                <td><?php if (!empty($result_list['RECORDEDSTATUS'])) {
                                echo $result_list['RECORDEDSTATUS'];
                            } else {
                                echo "--";
                            } ?></td>
                                                <td><?php if (!empty($result_list['SONGID'])) {
                                echo $result_list['SONGID'];
                            } else {
                                echo "--";
                            } ?></td>
                                                <td><?php if (!empty($result_list['RECIEVERID'])) {
                                echo $result_list['RECIEVERID'];
                            } else {
                                echo "--";
                            } ?></td>
                                                <td><?php if (!empty($result_list['CFCOMPLETE'])) {
                                echo $result_list['CFCOMPLETE'];
                            } else {
                                echo "--";
                            } ?></td>
                     <td><?php if (!empty($result_list['DNIS'])) {
                        echo $dnismapped[$result_list['DNIS']];
                    } else {
                        echo "--";
                    } ?></td>
					 <td><?php if (!empty($result_list['LEGTYPE'])) {
                        echo $result_list['LEGTYPE'];
                    } else {
                        echo "--";
                    } ?></td>
					 <td><?php if (!empty($result_list['SMOKERSTATUS'])) {
                        echo $result_list['SMOKERSTATUS'];
                    } else {
                        echo "--";
                    } ?></td>
                                            </tr>

			<?php
			$i++;
			}
        ?>                <?php
                
            }
        }
		/******************for repeat/unique user*************************/
		}
		else
		{
        while ($result_list = mysql_fetch_array($sql_getmsisdnlist)) {
            if (!empty($result_list['APARTY'])) {
        ?>
                                            <tr>
                                            <td><?= $i; ?></td>
                                                <td><?= trim($result_list['CALLDATE']) ?></td>
                                                <td><?= trim($result_list['CALLTIME']) ?></td>
                                                <td><?php if (!empty($result_list['CIRCLE'])) {
                                echo $circle_info[strtoupper($result_list['CIRCLE'])];
                            } else {
                                echo "--";
                            } ?></td>
                                                <td><?php if (!empty($result_list['APARTY'])) {
                                echo $result_list['APARTY'];
                            } else {
                                echo "--";
                            } ?></td>		
                                                <td><?php if (!empty($result_list['CALLDURATION'])) {
                                echo $result_list['CALLDURATION'];
                            } else {
                                echo "--";
                            } ?></td>
                                                <td><?php if (!empty($result_list['RECORDEDSTATUS'])) {
                                echo $result_list['RECORDEDSTATUS'];
                            } else {
                                echo "--";
                            } ?></td>
                                                <td><?php if (!empty($result_list['SONGID'])) {
                                echo $result_list['SONGID'];
                            } else {
                                echo "--";
                            } ?></td>
                                                <td><?php if (!empty($result_list['RECIEVERID'])) {
                                echo $result_list['RECIEVERID'];
                            } else {
                                echo "--";
                            } ?></td>
                                                <td><?php if (!empty($result_list['CFCOMPLETE'])) {
                                echo $result_list['CFCOMPLETE'];
                            } else {
                                echo "--";
                            } ?></td>
                                                <td><?php if (!empty($result_list['DNIS'])) {
                        echo $dnismapped[$result_list['DNIS']];
                    } else {
                        echo "--";
                    } ?></td>
					 <td><?php if (!empty($result_list['LEGTYPE'])) {
                        echo $result_list['LEGTYPE'];
                    } else {
                        echo "--";
                    } ?></td>
					 <td><?php if (!empty($result_list['SMOKERSTATUS'])) {
                        echo $result_list['SMOKERSTATUS'];
                    } else {
                        echo "--";
                    } ?></td>
                                            </tr>
                <?php
                $i++;
            }
        }
		
		}
				
				
		

    } else {
        ?>
                                    <tr><th colspan="10">No records found.</th></tr>
        <?php
    }
    ?></table>
                            <p>&nbsp;</p>
                        </div>
                    </div>
                    <div id="right-column">
    <?php
    include('right-sidebar.php');
//close database connection
    mysql_close($con);
    ?>
                    </div>
                </div>
                <div id="footer"></div>
            </div>


        </body>
    </html>
    <?php }
?>
