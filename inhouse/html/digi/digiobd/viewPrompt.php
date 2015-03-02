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
                        <h1>Prompt</h1>

                    </div><br />
                    <div class="select-bar">
                        <?php echo $_REQUEST[msg]; ?>
                    </div>			
                    <div class="table">

                        <img src="img/bg-th-left.gif" width="8" height="7" alt="" class="left" />
                        <img src="img/bg-th-right.gif" width="7" height="7" alt="" class="right" />


                        <table class="listing form" cellpadding="0" cellspacing="0" style="width:100%">
                            <tr>
                                <th class="full" width="17.5%">S.No</th>
                                <th class="full" width="16.5%">Prompt Name</th>
								<th class="full" width="16.5%">Action</th>
                                <?php
								$path1='http://119.82.69.212/digi/digiobd/obdrecording/prompt/bengaliobd.wav';
								$path2='http://119.82.69.212/digi/digiobd/obdrecording/prompt/nepaliobd.wav';
								$path3='http://119.82.69.212/digi/digiobd/obdrecording/prompt/indianobd.wav';
								?>
                            </tr>
                                  <tr>
								  <td class="last" width="16.5%">1</td>
                                    <td class="last" width="17.5%"><?php echo 'bengaliobd.wav'; ?></td>                                       
                                   <td class="last" width="16.5%">
								   <a href="<?php echo 'obdrecording/prompt/bengaliobd.wav'?>" target="_blank">Listen/Download</a>
								   </td>
                                 </tr>
								 <tr>
								  <td class="last" width="16.5%">2</td>
                                    <td class="last" width="17.5%"><?php echo 'nepaliobd.wav'; ?></td>                                       
                                   <td class="last" width="16.5%">
								   <a href="<?php echo 'obdrecording/prompt/nepaliobd.wav'?>" target="_blank">Listen/Download</a>
								   </td>
                                 </tr>
								 <tr>
								  <td class="last" width="16.5%">3</td>
                                    <td class="last" width="17.5%"><?php echo 'indianobd.wav'; ?></td>                                       
                                   <td class="last" width="16.5%">
								   <a href="javascript:void(0)" onClick="DHTMLSound('<?php echo $path3;?>')"><i class="icon-large icon-music">Listen/Download</a>
								   </td>
                                 </tr>
                                                      
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