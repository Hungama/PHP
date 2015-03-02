<?php
ini_set('display_errors', '1');
$PAGE_TAG = 'sms-kci';
include "includes/constants.php";
include "includes/language.php";
require_once("incs/db.php");
$serviceArray = Array('1101' => 'MTS - muZic Unlimited');
$circle_info = array('CHN' => 'Chennai', 'GUJ' => 'Gujarat', 'KAR' => 'Karnataka', 'KER' => 'Kerala', 'KOL' => 'Kolkata', 'RAJ' => 'Rajasthan', 'TNU' => 'Tamil Nadu', 'UPW' => 'UP WEST', 'WBL' => 'WestBengal', 'DEL' => 'Delhi', 'ALL' => 'ALL');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="favicon.png">
        <title><?php echo "CREATE RULE"; ?></title>
        <?php
        echo CONST_CSS;
        echo EDITINPLACE_CSS;
        ?>

    </head>

    <body>
        <div class="container">
            <?php
            include "includes/menu.php";
            ?>
            <div class="row">
                <div class="col-md-12"><h4><?php echo "RULE Engine"; ?></h4></div>
            </div>    
            <div class="row">
                <div class="col-md-8">
                    <h6>Add New Rule</h6></div>
                <div class="col-md-4">
                    <!--    	<div class="btn-group btn-group-xs pull-right">
                      <button type="button" class="btn btn-info">Upload TSV</button>
                      <button type="button" class="btn btn-success">Download TSV</button>
                    </div><br/>-->
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <form id="form-active" name="form-active" method="post" enctype="multipart/form-data">
                        <table class="table table-bordered table-condensed">
                            <tr>
                                <td align="left" width="16%" height="32"><span>Rule Name</span></td>
                                <td align="left" colspan="2">
                                    <input type="text" id="rule_name" name="rule_name"/>
                                </td>
                            </tr>
                            <tr>
                                <td align="left" width="16%" height="32"><span>Service Name</span></td>
                                <td align="left" colspan="2"><select name="service" id="service" data-width="auto">
                                        <option value="0">Select Service</option>
                                        <?php foreach ($serviceArray as $s_id => $s_val) {
                                            ?>
                                            <option value="<?php echo $s_id; ?>"><?php echo $s_val; ?></option>
                                        <?php } ?>
                                    </select></td>

                            </tr>
                            <tr>
                                <td align="left" width="16%" height="32"><span>Circle</span></td>
                                <td align="left" colspan="2"><select name="circle" id="circle" data-width="auto">
                                        <option value="0">Select Circle</option>
                                        <?php foreach ($circle_info as $c_id => $c_val) {
                                            ?>
                                            <option value="<?php echo $c_id; ?>"><?php echo $c_val; ?></option>
                                        <?php } ?>
                                    </select></td>

                            </tr>
                            <tr>
                                <td align="left" width="16%" height="32"><span>Service Base</span></td>
                                <td align="left" colspan="2">
                                    <input type="radio" id="service_base_active" name="service_base" value="1" checked="checked"/>&nbsp; Active &nbsp;&nbsp;&nbsp;
                                    <input type="radio" id="service_base_pending" name="service_base" value="0"/>&nbsp; Pending &nbsp;&nbsp;&nbsp;
                                    <input type="radio" id="service_base_both" name="service_base" value="0"/>&nbsp; Both
                                </td>
                            </tr>
                            <tr>
                                <td align="left" width="16%" height="32"><span>Filter Base</span></td>
                                <td align="left" colspan="2">
                                    <select name="filter_base" id="filter_base" data-width="auto" onchange="setScenarios(this.value)">
                                        <option value="0">Select Filter Base</option>
                                        <?php
                                        $selectQuery = "SELECT Fid,description FROM master_db.tbl_filter_base WHERE status=1";
                                        $querySel = mysql_query($selectQuery, $dbConn);
                                        while ($row = mysql_fetch_array($querySel)) {
                                            ?>
                                            <option value="<?php echo $row['Fid']; ?>"><?php echo $row['description']; ?></option>
                                        <?php } ?>
                                    </select></td>
                            </tr>
                            <tr>
                                <td align="left" width="16%" height="32"><span>Scenarios</span></td>
                                <td align="left" colspan="2">
                                    <select name="scenarios" id="scenarios"></select>
                                </td>
                            </tr>
                            <tr>
                                <td align="left" width="16%" height="32">DND scrubbing</td>
                                <td>
                                    <input type="radio" id="dnd_scrubbing_yes" name="dnd_scrubbing" value="1" checked="checked"/>&nbsp; Yes &nbsp;&nbsp;&nbsp;
                                    <input type="radio" id="dnd_scrubbing_no" name="dnd_scrubbing" value="0"/>&nbsp; No &nbsp;&nbsp;&nbsp;
                                </td>
                                <td valign="middle"><button class="btn btn-primary">Submit</button>
                                    <a href="javascript:;" class="btn btn-primary">Reset</a></td>
                            </tr>
                        </table>
                    </form>
                </div>
                <br/>
            </div> 


            <div  class="row"><div class="col-md-12">
                    <ul id="myTab" class="nav nav-pills">
                        <!--                        <li class="active"><a href="#SMS" data-toggle="tab">Create Rule</a></li>-->
                        <!--                        <li class=""><a href="#CallHangups" data-toggle="tab">Call Hangups</a></li>
                                                <li class=""><a href="#Footer" data-toggle="tab">Footer Messages</a></li>-->
                        <!-- Expand this to include Other types as well if there are -->
                    </ul>
                </div></div>

            <div id="myTabContent" class="tab-content">

                <div id="SMS" class="tab-pane fade active in">
                </div>

                <div id="CallHangups" class="tab-pane fade">
                </div>				 

                <div id="Footer" class="tab-pane fade">
                </div>				 

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
    <div id = "alert_placeholder"></div>
    <?php
    echo CONST_JS;
    echo EDITINPLACE_JS;
    ?>
    <script>
        (function($) {
            $.fn.extend( {
                limiter: function(limit, elem) {
                    $(this).on("keyup focus", function() {
                        setCount(this, elem);
                    });
                    function setCount(src, elem) {
                        var chars = src.value.length;
                        if (chars > limit) {
                            src.value = src.value.substr(0, limit);
                            chars = limit;
                        }
                        elem.html( (limit - chars)+' characters left' );
                    }
                    setCount($(this)[0], elem);
                }
            });
        })(jQuery);


        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            var parts = decodeURI(e.target).split('#');
            $.fn.AjaxAct(parts[1],'');
        });

        function setScenarios(filter_base) { 
            var xmlhttp;
            if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp=new XMLHttpRequest();
            } else { // code for IE6, IE5
                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange=function() {
                if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                    document.getElementById('scenarios').innerHTML=xmlhttp.responseText;
                }
            }	
            var url="getScenerios.php?filter_base="+filter_base;
            xmlhttp.open("GET",url,true);
            xmlhttp.send();	
        }
        $("form#form-active").submit(function(){  
            var isok = checkfield('form-active');
            if(isok)
            {
                document.getElementById('alert_placeholder').style.display='none';
                $('#loading').show();
                var formData = new FormData($("form#form-active")[0]);
                $.ajax({
                    url: 'rule_creation_process.php',
                    type: 'POST',
                    data: formData,
                    async: false,
                    success: function (data) {
                        document.getElementById('grid-active').style.display='inline';
                        document.getElementById('grid-active').innerHTML=data;
                        resestForm('active');    
                        //viewUploadhistory('3 Days');
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });

                return false;
            }
            else
            {
                return false;
            }
        });
        function checkfield(type) { 
            $('#loading').hide();
            document.getElementById('alert_placeholder').style.display='inline';
            var rule_name=document.forms[type]["rule_name"].value;
            var service=document.forms[type]["service"].value;
            var circle=document.forms[type]["circle"].value;
            var filter_base=document.forms[type]["filter_base"].value;        
            var scenarios=document.forms[type]["scenarios"].value;
            if (rule_name== '') {
                bootstrap_alert.warning('<?php echo 'Please enter rule name;' ?>');
                return false;
            } else if (service=='0' || service=="") {
                bootstrap_alert.warning('<?php echo 'Please select service'; ?>');
                return false;
            }
            else if(circle=='' || circle == '0')
            {   
                bootstrap_alert.warning('<?php echo 'Please select circle'; ?>');
                return false;
            }
            else if(filter_base=='' || filter_base == '0')
            {	
                bootstrap_alert.warning('<?php echo 'Please select filter base'; ?>');
                return false;
            }
            if (scenarios=='0' || scenarios=="") {
                bootstrap_alert.warning('<?php echo 'Please select scenarios'; ?>');
                return false;
            }
		
            $('#loading').show();
            hideMessageBox();
            //return false;
            return true;
        }

        var elem = $("#counter");
        $("#msg").limiter(160, elem);
    </script>
</body>
</html>