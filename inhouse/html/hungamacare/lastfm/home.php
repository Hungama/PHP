<?php
include("session.php");
include("db.php");
error_reporting(0);
//include database connection file
   $circle_info = array('DEL' => 'Delhi', 'GUJ' => 'Gujarat', 'WBL' => 'WestBengal', 'BIH' => 'Bihar', 'RAJ' => 'Rajasthan', 'UPW' => 'UP WEST', 'MAH' => 'Maharashtra', 'APD' => 'Andhra Pradesh', 'UPE' => 'UP EAST', 'ASM' => 'Assam', 'TNU' => 'Tamil Nadu', 'KOL' => 'Kolkata', 'NES' => 'NE', 'CHN' => 'Chennai', 'ORI' => 'Orissa', 'KAR' => 'Karnataka', 'HAR' => 'Haryana', 'PUB' => 'Punjab', 'MUM' => 'Mumbai', 'MPD' => 'Madhya Pradesh', 'JNK' => 'Jammu-Kashmir', 'PUB' => "Punjab", 'KER' => 'Kerala', 'HPD' => 'Himachal Pradesh', '' => 'Other', 'HAY' => 'Haryana');
    ?> 
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html>
        <head>
            <title>Admin</title>
            <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
            <style media="all" type="text/css">@import "css/all.css";</style>
            <script language="javascript" type="text/javascript" src="js/ajax-data.js"></script>
                
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
                        <img src="img/Hlogo.png" width="282" height="80" alt=""/>
                        
                    </a>
                </div>
                <div id="middle" >
                    <div id="left-column">
    <?php include('left-sidebar.php'); ?>	
                    </div>
                    <div id="center-column1" style="width:650px">
                        <div class="top-bar">
                            <h1>LastFM</h1>
                        </div>

                        <div class="table" style="width:600px">
                              <table class="listing" cellpadding="0" cellspacing="0" style="width:600px" >
                                <form action="#" method="post" onsubmit="return geResult()">
                                    <tr class="bg">
                                        <td>
                                        <select name="stype" id="stype">
                                            <option value="">Select any one-</option>
                                              <option value="album">Album</option>
											  <option value="track">Track</option>
                                        </select>
										<input type="text" name="searchstr" id="searchstr">
                                         <input type="submit" name="submit" value="Go" id="submit_button"/>
								
                                       </td>
                                    </tr>
                                </form>
                             </table>
							 
                            <div id="showinfo"></div>
						<center><img src="img/ajax-loader.gif" id="ajax_loader" style="display:none;"></center>
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