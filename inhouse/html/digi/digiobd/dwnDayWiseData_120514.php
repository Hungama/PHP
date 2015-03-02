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
                                <th class="full" width="17.5%">OBD Filename</th>
                                <th class="full" width="16.5%">Circle</th>
								<th class="full" width="16.5%">CLI</th>
                                <th class="full" width="16.5%">Startdate</th>
								<th class="full" width="16.5%">Endtdate</th>
                                <th class="full" width="16.5%">Total no in file</th>
								<th class="full" width="16.5%">Added On</th>
								<th class="full" width="16.5%">Added By</th>
                                <th class="full" width="16.5%">Status</th>
                            </tr>
                            <?php
                            //$query = "select odb_filename,circle,prcocess_status,channel,planid,servicetype from master_db.tbl_obdrecording_log limit 20";
							$query ="select batchid,odb_filename,circle,status,cli,startdate,enddate,filesize,uploadtime,uploadedby "; 
							$query.="from master_db.tbl_obdrecording_log where date(uploadtime)>=date(subdate(now(),30)) and servicetype='DIGI' order by uploadtime desc ";
							
                            $result = mysql_query($query, $con);
                            $result_row = mysql_num_rows($result);

                            if ($result_row > 0) {
                                while ($details = mysql_fetch_array($result)) {
								
								if($details['status']==0)
								 { 
									 $status='Queued';
									 $filepath="obdrecording/".$details['odb_filename'];
								}
								  else if($details['status']==1)
								 { $status='Processing';
								  $filepath="javascript:void(0)";
								  }
								  else
								 {
									 $status='Completed';
									 $filepath="obdrecording/lock/".$details['odb_filename'];
								 }
                                    ?>
                                    <tr>
                                        <td class="last" width="17.5%"><a href="<?php echo $filepath;?>" target="_blank"><?php echo $details['odb_filename']; ?></a></td>
                                        <td class="last" width="16.5%"><?php echo $details['circle']; ?></td>
                                        <td class="last" width="16.5%"><?php echo $details['cli']; ?></td>
                                        <td class="last" width="16.5%"><?php echo $details['startdate']; ?></td>
                                        <td class="last" width="16.5%"><?php echo $details['enddate']; ?></td>
										<td class="last" width="16.5%"><?php echo $details['filesize']; ?></td>
										<td class="last" width="16.5%"><?php echo $details['uploadtime']; ?></td>
										<td class="last" width="16.5%"><?php echo $details['uploadedby']; ?></td>
										<td class="last" width="16.5%"><?php echo $status; ?></td>
                                    </tr>
                                    <?php
                                }
                            }
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