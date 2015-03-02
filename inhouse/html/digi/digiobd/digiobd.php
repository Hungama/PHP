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
    <script type="text/javascript">
        function setLangOption(circle) { 
            if(circle == 'Indian'){
                document.getElementById('select_lang').innerHTML = "<select name='obd_form_language' id='obd_form_language'><option value='01'>Hindi</option><option value='07'>Tamil</option></select>"; 
            }else if(circle == 'Nepali'){
                document.getElementById('select_lang').innerHTML = "<select name='obd_form_language' id='obd_form_language'><option value='19'>Nepali</option></select>"; 
            }else if(circle == 'Bengali'){
                document.getElementById('select_lang').innerHTML = "<select name='obd_form_language' id='obd_form_language'><option value='06'>Bengali</option></select>"; 
            }else{
                document.getElementById('select_lang').innerHTML = "<select name='obd_form_language' id='obd_form_language'><option value=''>Select any one--</option></select>"; 
            }
        }
    </script>
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
                        <h1>Upload DIGI OBD Data</h1>

                    </div><br />
                    <div class="select-bar">
                        <?php echo $_REQUEST[msg]; ?>
                    </div>
                    <h2 style="color:#FF0000;font-size:13px">(* Please upload file of less than 10000 numbers otherwise it will not process.)</h2>
                    <div class="table">

                        <img src="img/bg-th-left.gif" width="8" height="7" alt="" class="left" />
                        <img src="img/bg-th-right.gif" width="7" height="7" alt="" class="right" />

                        <form name="obd_up_form" method="post" action="savedigiobdfileinfo.php" onsubmit="return validate_digiobd_form()" enctype="multipart/form-data">
                            <table class="listing form" cellpadding="0" cellspacing="0">
                                <tr>
                                    <th class="full" colspan="2">Information</th>
                                </tr>
                                <tr class="bg">
                                    <td class="first"><strong>Please select circle</strong></td>
                                    <td class="last">
                                        <select name="obd_form_region" id="obd_form_region" onchange="javascript:setRegion(this.value);setLangOption(this.value);">
                                            <option value="">Select any one--</option>
                                            <option value="Indian">Indian</option>
                                            <option value="Nepali">Nepali</option>
                                            <option value="Bengali">Bengali</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr class="bg">
                                    <td class="first"><strong>Please select channel </strong></td>
                                    <td class="last">
                                        <select name="obd_form_channel" id="obd_form_channel" onchange="">
                                            <option value="">Select any one--</option>
                                            <option value="TOBD">TOBD</option>
                                            <option value="OBD">OBD </option>
											<option value="INFO">Informative</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr class="bg">
                                    <td class="first"><strong>Please select price point </strong></td>
                                    <td class="last">
                                        <select name="obd_form_pricepoint" id="obd_form_pricepoint">
                                            <option value="">Select any one--</option>
                                            <option value="1">1 RM</option>
                                            <option value="3">3 RM</option>
                                        </select>
                                    </td>
                                </tr>
<!--                                <tr class="bg">
                                    <td class="first"><strong>Please select language </strong></td>
                                    <td class="last">
                                        <select name="obd_form_language" id="obd_form_language">
                                            <option value="">--Select any one--</option>
                                            <option value="01">Hindi</option>
                                            <option value="06">Bengali</option>
                                            <option value="07">Tamil</option>
                                            <option value="19">Nepali</option>
                                        </select>
                                    </td>
                                </tr>-->
                                <tr class="bg" id="tr_lang" name="tr_lang">
					<td class="first"><strong>Please select language</strong></td>
					<td class="last">
                                            <div id="select_lang" name="select_lang">
                                                <select name="obd_form_language" id="obd_form_language">
                                                    <option value=''>Select any one--</option>
                                                </select>
                                            </div>
                                        </td>
                             </tr>
                                <tr>
                                    <td class="first" width="172"><strong>Upload mobile numbers</strong></td>
                                    <td class="last"><input type="file"  name="obd_form_mob_file" id="obd_form_mob_file"/></td>
                                </tr>

                                <tr class="bg">
                                    <td class="first"><strong>Upload Prompt</strong></td>
                                    <td class="last"><input type="file" name="obd_form_prompt_file" id="obd_form_prompt_file" /></td>
                                </tr>

                                <tr class="bg">
                                    <td class="first"><strong>CLI</strong></td>
                                    <td class="last"><input type="text" class="text" name="obd_form_cli" id="obd_form_cli" readonly="true"/></td>
                                </tr>
                                <tr class="bg">
                                    <td class="first"><strong>Circle</strong></td>
                                    <td class="last"><input type="text" class="text" name="obd_form_circle" id="obd_form_circle" readonly="true"/>

                                    </td>
                                </tr>
                                <tr class="bg">
                                    <td class="first"><strong>Start Date</strong></td>
                                    <td class="last"><input type="text" id="startdate" maxlength="25" size="25" name="obd_form_startdate"><a href="javascript:NewCal('startdate','ddmmmyyyy',true,24)"><img src="img/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
                                            <span class="descriptions">Pick start date..</span></td>
                                </tr>
                                <tr class="bg">
                                    <td class="first"><strong>End Date</strong></td>
                                    <td class="last"><input type="text" id="enddate" maxlength="25" size="25" name="obd_form_enddate"><a href="javascript:NewCal('enddate','ddmmmyyyy',true,24)"><img src="img/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
                                            <span class="descriptions">Pick end date..</span></td>
                                </tr>
                                <tr class="bg">
                                    <td class="first"><strong></strong></td>
                                    <td class="last"><input type="submit" name="submit" value="submit"/></td>
                                </tr>
                            </table>
                        </form>
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