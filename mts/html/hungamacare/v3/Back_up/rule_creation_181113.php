<?php
ini_set('display_errors', '1');
$PAGE_TAG = 'sms-kci';
include "includes/constants.php";
include "includes/language.php";
require_once("incs/db.php");
$serviceArray = Array('1101' => 'MTS - muZic Unlimited');
//$FilerBaseArray = Array('CU' => 'Calling users', 'NCU' => 'Non calling users', 'AOS' => 'Age on service','CD' => 'CRBT downloaders',
//    'CND' => 'CRBT non downloaders', 'RD' => 'RT downloaders','RND' => 'RT non downloaders');
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
                                <td align="left" width="16%" height="32"><span>Service Base</span></td>
                                <td align="left" colspan="2">
                                    <input type="radio" id="service_base_active" name="service_base" value="1" />&nbsp; Active &nbsp;&nbsp;&nbsp;
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
                                    <div id="ScenariosDiv" name="ScenariosDiv">
                                        <select name="scenarios" id="scenarios"></select>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td align="left" width="16%" height="32">DND scrubbing</td>
                                <td>
                                    <input type="radio" id="dnd_scrubbing_yes" name="dnd_scrubbing" value="1" />&nbsp; Yes &nbsp;&nbsp;&nbsp;
                                    <input type="radio" id="dnd_scrubbing_no" name="dnd_scrubbing" value="0"/>&nbsp; No &nbsp;&nbsp;&nbsp;
                                </td>
                                <td valign="middle"><a href="javascript:;" class="btn btn-primary">Submit</a>
                                    <a href="javascript:;" class="btn btn-primary">Reset</a></td>
                            </tr>
                            <!-- date range section end here -->
                        </table>
                    </form>
                </div>
                <br/>
            </div> 


            <div  class="row"><div class="col-md-12">
                    <ul id="myTab" class="nav nav-pills">
                        <li class="active"><a href="#SMS" data-toggle="tab">Create Rule</a></li>
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

        $.fn.AjaxAct = function(act,xhr) {
            if(!xhr) {
                $('#loading').show();
                $('#grid').html('');	

            }
		
            $.ajax({
                url: 'snippets/test.php',
                data: '&type='+act,
                type: 'post',
                cache: false,
                dataType: 'html',
                success: function (abc) {
                    $('#grid').html(abc);
                }
						
            });
					
					
            $('#loading').hide();
            $('#grid').show();
	
        };
        $(document).ready(function() {
            if (location.hash !== '') $('a[href="' + location.hash + '"]').tab('show');
            return $('a[data-toggle="tab"]').on('shown', function(e) {
                return location.hash = $(e.target).attr('href').substr(1);
            });
        });
        //'CU' => 'Calling users', 'NCU' => 'Non calling users', 'AOS' => 'Age on service','CD' => 'CRBT downloaders',
        // 'CND' => 'CRBT non downloaders', 'RD' => 'RT downloaders','RND' => 'RT non downloaders'
        function setScenarios(filter_base) { alert(filter_base);
            if(filter_base == 'CU'){
                document.getElementById('ScenariosDiv').innerHTML = "<select name='scenarios' id='scenarios'><option value='>10 MOUs'>Active subscriber with Little usage (Less than 10 MOUS in last 10 days) >10</option><option value='10-30 MOUs'>Active subscriber with medium usage (More than 10, But less than 30 MOUS  in last 10 days) Between 10 to 30</option><option value='>30 MOUs'>Active subscriber with High usage (More than 30 MOUS in last 10 days) <30</option><option value='<5 Min'>Usage less than > 5 mins in last 1 day</option><option value='<20 Min'>Usage more than < 20 mins in last 1 day</option><option value='1 Days'>Called in last 1 day</option><option value='3 Days'>Called in last 3 days</option><option value='5 Days'>Called in last 5 days</option><option value='7 Days'>Called in last 7 days</option><option value='15 Days'>Called in last 15 days</option><option value='>2 Times'>Called more than 2 times in last 1 day</option><option value='>4 Times'>Called more than 4 times in last 1 day</option><option value='>6 Times'>Called more than 6 times in last 1 day</option></select>"; 
            }else if(filter_base == 'NCU'){
                document.getElementById('ScenariosDiv').innerHTML = "<select name='scenarios' id='scenarios'><option value='3 Days'>Not called in 3 days from activation</option><option value='5 Days'>Not called in 5 days from activation</option><option value='7 Days'>Not called in 7 days from activation</option><option value='15 Days'>Not called in 15 days from activation</option></select>";
            }else if(filter_base == 'AOS'){
                document.getElementById('ScenariosDiv').innerHTML = "<select name='scenarios' id='scenarios'><option value='0-5 Days'>0-5 days</option><option value='5-10 Days'>5-10 days</option><option value='10-20 Days'>10-20 days</option><option value='20-30 Days'>20-30 days</option><option value='>30 Days'>More than 30 days</option></select>";
            }else if(filter_base == 'CD'){
                document.getElementById('ScenariosDiv').innerHTML = "<select name='scenarios' id='scenarios'><option value='1 Days'>Downloaded/changed 1 or more CRBT in last 1 day</option><option value='5 Days'>Downloaded 2 or more CRBT in last 5 day</option></select>";
            }else if(filter_base == 'CND'){
                document.getElementById('ScenariosDiv').innerHTML = "<select name='scenarios' id='scenarios'><option value='3 Days'>No CRBT Download in 3 days from activation</option><option value='5 Days'>No CRBT Download in 5 days from activation</option><option value='7 Days'>No CRBT Download in 7 days from activation</option><option value='15 Days'>No CRBT Download in 15 days from activation</option></select>";
            }else if(filter_base == 'RD'){
                document.getElementById('ScenariosDiv').innerHTML = "<select name='scenarios' id='scenarios'><option value='1 Days'>Downloaded 1 or more RT in last 1 day</option><option value='5 Days'>Downloaded 2 or more RT in last 5 day</option></select>";
            }else if(filter_base == 'RND'){
                document.getElementById('ScenariosDiv').innerHTML = "<select name='scenarios' id='scenarios'><option value='3 Days'>No RT Download in 3 days from activation</option><option value='5 Days'>No RT Download in 5 days from activation</option><option value='7 Days'>No RT Download in 7 days from activation</option><option value='15 Days'>No RT Download in 15 days from activation</option></select>";
            }
        }
        var elem = $("#counter");
        $("#msg").limiter(160, elem);
    </script>
</body>
</html>