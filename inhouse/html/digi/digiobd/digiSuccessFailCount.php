<?php
include("session.php");
error_reporting(0);
//include database connection file
include("db.php");
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <title>Admin</title>
        <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
        <style media="all" type="text/css">@import "css/all.css";</style>
        <script language="javascript" type="text/javascript" src="datetimepicker/datetimepicker.js"></script>
        <script language="javascript" type="text/javascript" src="js/validate.js"></script>

    </head>
    <body>
        <div id="main">
            <div id="header">
                <a href="index.html" class="logo"><img src="img/Hlogo.png" width="282" height="80" alt=""/></a>
                <!--ul id="top-navigation">
                        <li class="active"><span><span>Home</span></span></li>
                </ul-->
            </div>
            <div id="middle">
                <div id="left-column">
                    <?php include('left-sidebar.php'); ?>
                </div>
                <div id="center-column">
                    <div class="top-bar">
                        <!--h1>Upload OBT Data---Please don't use this file right now..it's under process..</h1-->
                        <h1>Day Wise Data</h1>

                    </div><br />
                    <div class="select-bar">
                        <?php echo $_REQUEST[msg]; ?>
                    </div>			
                    <div class="table">

                        <img src="img/bg-th-left.gif" width="8" height="7" alt="" class="left" />
                        <img src="img/bg-th-right.gif" width="7" height="7" alt="" class="right" />


                        <table class="listing form" cellpadding="0" cellspacing="0" style="width:100%">
                            <tr>
                                <th class="full" width="17.5%">Date</th>
                                <th class="full" width="16.5%">Total Count</th>
								<th class="full" width="16.5%">Success</th>
                                <th class="full" width="16.5%">Failure</th>
								<th class="full" width="16.5%">KeyPress</th>
                                
                            </tr>
                            <?php
                            $query = "select sum(filesize) as totalcount,date(uploadtime) as uploadtime  from master_db.tbl_obdrecording_log where date(uploadtime)>=date(subdate(now(),15)) and servicetype='DIGI' group by date(uploadtime) order by uploadtime desc ";
												
                            $result = mysql_query($query, $con);
                            $result_row = mysql_num_rows($result);

                            if ($result_row > 0) {
                                $con_digi = mysql_connect("172.16.56.42","billing","billing");
									if (!$con_digi)
									{
									die('Could not connect: ' . mysql_error("Could not connect to digi"));
									}
								while ($details = mysql_fetch_array($result)) {
								$query_Success = mysql_query("SELECT count(*) as 'Success' FROM db_obd.TBL_User_OBD where date(CALL_DATE)='".$details['uploadtime']."' and status=1",$con_digi);
								$result_success=mysql_fetch_array($query_Success);
								
								$query_Failure = mysql_query("SELECT count(*) as 'Failure' FROM db_obd.TBL_User_OBD where date(CALL_DATE)='".$details['uploadtime']."' and status!=1",$con_digi);
								$result_fail=mysql_fetch_array($query_Failure);
								
								$query_Keypress = mysql_query("SELECT count(*) as 'KeyPress' FROM db_obd.usercallhistory WHERE date(CALLSTARTTIME)='".$details['uploadtime']."'",$con_digi);
								$result_keypress=mysql_fetch_array($query_Keypress);
								?>
                                    <tr>
                                        <td class="last" width="16.5%"><?php echo $details['uploadtime']; ?></td>
                                        <td class="last" width="16.5%"><?php echo $details['totalcount']; ?></td>
                                        <td class="last" width="16.5%"><?php echo $result_success[0]; ?></td>
                                        <td class="last" width="16.5%"><?php echo $result_fail[0];; ?></td>
										<td class="last" width="16.5%"><?php echo $result_keypress[0]; ?></td>
										
                                    </tr>
                                    <?php
                                }
                            }
							mysql_close($con);  
							mysql_close($con_digi);  
                            ?>
                        </table>

                        <p>&nbsp;</p>
                    </div>
                </div>
                <div id="right-column">
                    <strong class="h">INFO</strong>
                    <div class="box">Information for OBD</div>
                </div>
            </div>
            <div id="footer"></div>
        </div>


    </body>
</html>