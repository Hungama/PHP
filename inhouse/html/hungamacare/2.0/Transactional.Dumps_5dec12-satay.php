<?php
$SKIP = 1;
ini_set('display_errors','0');


require_once("incs/database.php");
require_once("../incs/GraphColors-D.php");
require_once("../../ContentBI/base.php");
//asort($AR_SList);

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
 <link href="assets/css/bootstrap.css" rel="stylesheet" />
 <link href="assets/css/jquery.pageslide.css" rel="stylesheet"  />
  <link href="assets/css/style.css" rel="stylesheet" />
<link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    
    
<title>Transactional Data Dumps</title>
<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
</head>

<body>

<div class="container">

<div class="row">

<div class="page-header">
  <h1>Transactional Data Dumps<small>&nbsp;&nbsp;finest &amp; most granular data</small></h1>
</div>

		
        

<div class="tab-pane active" id="pills-basic">
							<!--<h3>Pills</h3>-->
							<div class="tabbable">
							  <ul class="nav nav-pills">
							    <li class="active"><a href="#tabs4-pane1" data-toggle="tab">Billing Data</a></li>
							    <li class=""><a href="#tabs4-pane2" data-toggle="tab">Calling Data</a></li>
							    <li class=""><a href="#tabs4-pane3" data-toggle="tab">Content Data</a></li>
							    <li class=""><a href="#tabs4-pane4" data-toggle="tab">Mobile # Status</a></li>
							    <li class=""><a href="#tabs4-pane5" data-toggle="tab">Social Sharing Data</a></li>
							  </ul>
							  <div class="tab-content">
							    <div id="tabs4-pane1" class="tab-pane active">
<table class="table table-bordered">
              <tr>
                <td width="16%" align="left"><span class="Text_a_7">Select Service</span></td>
                <td align="left"><select name="Tbl" class="fbbluebox" id="Tbl">
                    <?php
		  sksort($Service_DESC);
		  foreach($Service_DESC as $SvName=>$Service) {
			
			if(in_array($SvName,$AR_SList)) {		
			if($Service["CallingTable"] && strcmp("Rel54646",$SvName) != 0 && $Service['CallingTable'] != false) {
			?>
                    <option value="<?php echo $Service["CallingTable"];?>,<?php echo $Service["CallingTableExtra"];?>,<?php echo $SvName;?>"><?php echo $Service["Name"];?></option>
                    <?php	
			}
			}
			
		  }
		  ?>
                </select></td>
                <td width="17%" height="32" class="Text_a_7">Circles</td>
                <td width="31%" align="left"><a href="#?w=700" rel="divCircles" class="poplight"><img src="images/dropdownCircles.jpg" border="0" /></a>
                  <?php include "incs/divCircles.php";?></td>
              </tr>
              <tr class="Text_a_7">
                <td>Start Date (yyyy-mm-dd)</td>
                <td><span id="sprytextfield1">
                    <label>
                      <input name="Date_FROM" type="text" class="fbbluebox" id="Date_FROM" />
                    </label>
                  <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldInvalidFormatMsg">Invalid format.</span></span></td>
                <td>End Date (yyyy-mm-dd)</td>
                <td height="23"><span id="sprytextfield2">
                    <label>
                      <input name="Date_TO" type="text" class="fbbluebox" id="Date_TO" />
                    </label>
                  <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldInvalidFormatMsg">Invalid format.</span></span></td>
</tr>
              <tr>
                <td><p class="Text_a_7">Dump Type </p></td>
                <td> <input name="DumpType" type="radio" class="fbbluebox" id="radio2" value="2" />&nbsp;<span class="label label-important">
                   Live </span>&nbsp;&nbsp;&nbsp;<input name="DumpType" type="radio" class="fbbluebox" id="radio" value="1" />&nbsp;<span class="label label-info">
                    Non Live </span>&nbsp;&nbsp;&nbsp;<input name="DumpType" type="radio" class="fbbluebox" id="radio3" value="3" checked="checked" />&nbsp;<span class="label label-success">
                    Both</span></td>
                <td colspan="2" align="center"><span class="Text_a_7">
                    <input name="button3" type="submit" class="ui-state-error" id="button3" value="Submit" style="padding: 20px;" />
                </span></td>
              </tr>
              <tr>
                <td colspan="4"><small>* for Aircel MC, Uninor Devotional, MU, MyMusic, Videocon VMusic &amp; Reliance MusicMania select Both</small></td>
              </tr>
              </table>
									<!-- list subscribed services here with sms/email icons -->
                                  
							    </div>
							    <div id="tabs4-pane2" class="tab-pane">
							    
                                </div>
							    <div id="tabs4-pane3" class="tab-pane">
							      <h4>Pane 3 Content</h4>
							      <p>Ut porta rhoncus ligula, sed fringilla felis feugiat eget. In non purus quis elit iaculis tincidunt. Donec at ultrices est.</p>
							    </div>
							    <div id="tabs4-pane4" class="tab-pane">
							      <h4>Pane 4 Content</h4>
							      <p>Donec semper vestibulum dapibus. Integer et sollicitudin metus. Vivamus at nisi turpis. Phasellus vel tellus id felis cursus hendrerit. Suspendisse et arcu felis, ac gravida turpis. Suspendisse potenti.</p>
							    </div>
							  </div><!-- /.tab-content -->
							</div><!-- /.tabbable -->
						</div>
           
          <table class="table table-bordered"> <tr>
        <td width="7%" align="left">ID</td>
        <td width="12%" align="left">Service</td>
        <td width="15%" align="left">Added On</td>
        <td width="11%" align="left">Status</td>
        <td width="17%" align="left">Processing 
          Started at</td>
        <td width="21%" align="left">Completed At</td>
        <td width="17%" align="left">Output File</td>
      </tr>
            <?php
						$Query = mysql_query("select * from public_acts where username='ankur.saxena' order by ID DESC limit 30") or die(mysql_error());
	  while($T = mysql_fetch_array($Query)) {

		 list($Circles,$From,$To,$Type,$Tbl) = explode('|',$T['filename'],5);
		 list($Table,$ColVal,$Service) = explode(",",$Tbl);
	  ?><tr >
        <td align="left"><?php echo $T['id'];?></td>
        <td align="left"><?php echo $Service_DESC[$Service]["Name"];?></td>
        <td align="left"><?php echo $T['added'];?></td>
        <td align="left"><?php echo $T['status'];?></td>
        <td align="left"><?php echo $T['started'];?></td>
        <td align="left"><?php echo $T['completed'];?></td>
        <td align="left"><?php if(file_exists("../../cmis/tmp/".$T['output_file']) && strcmp($T["status"],"Processed") == 0) {echo "<a href='../../cmis/tmp/".$T['output_file']."'>Download</a>";?>
          (<?php echo number_format($T['mdn_out'])." KB)";} else{
			?><?php  
		  }?></td>
      </tr>
      
      <?php } ?></table>

</div>
</div>
<div id="listService" class="modal hide fade" data-cache="false" >
    <div class="modal-header">
      <button class="close" data-dismiss="modal">&times;</button>
      
      <h3 id="listService-Title">Title</h3>
    </div>
    <div class="modal-body">            
        <div id="modalContent" style="display:none;">

        </div>
    </div>
    <div class="modal-footer">
      <a href="#" class="btn btn-info" data-dismiss="modal" id="listService-close" >Close</a>
      <a href="#" class="btn btn-info" data-dismiss="modal" id="listService-refresh" >Reload Alerts</a>
      <a href="#" class="btn btn-danger" id="listService-remove" >Remove Alerts</a>
      <a href="#" class="btn btn-success" id="listService-submit" >Save Changes</a>
    </div>
</div>  
  <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap-transition.js"></script>
    <script src="assets/js/bootstrap-alert.js"></script>
    <script src="assets/js/bootstrap-modal.js"></script>
    <script src="assets/js/bootstrap-dropdown.js"></script>
    <script src="assets/js/bootstrap-scrollspy.js"></script>
    <script src="assets/js/bootstrap-tab.js"></script>
    <script src="assets/js/bootstrap-tooltip.js"></script>
    <script src="assets/js/bootstrap-popover.js"></script>
    <script src="assets/js/bootstrap-button.js"></script>
    <script src="assets/js/bootstrap-collapse.js"></script>
    <script src="assets/js/bootstrap-carousel.js"></script>
    <script src="assets/js/bootstrap-typeahead.js"></script>
    
    <script src="assets/js/jquery.pageslide.js"></script>
    
 	<script>
$('#listService-refresh').hide();
	
    $("a[data-toggle=modal]").click(function() 
{   
    var service = $(this).attr('data-service');
    var title = $(this).attr('data-title');
	            
	$('#modalContent').html('<img src="assets/img/loading-circle-48x48.gif" border="0" alt="loading.." />');
	$('#listService-Title').text(title);
	//alert(essay_id);
    $.ajax({
        cache: false,
        type: 'GET',
        url: 'snippets/User.Alerts.EditService.php',
        data: 'username=<?php echo $username;?>&service='+service,
        success: function(data) 
        {
            $('#listService').show();
            $('#modalContent').show().html(data);
        }
    });
});

// This creates submit handler for the form


// This creates the on click handler for the submit button
$('#listService-submit').on('click', function() {
    // This actually submits the form
    
	// e.preventDefault();
	 //alert($('#comment_form').serialize() + '&action=send');
        // validate form actions cleaned for clearity.
		var n = $("input:checkbox:checked").length;
		var k = $("input:radio:checked").length;
		
		if(k==0) {
		$('#alert-no-alert_type').show();
		return false();	
		}
		
		if(n==0) {
		$('#alert-no-circle').show();
		return false();	
		}
		


        $.ajax({
            url: 'snippets/User.Alerts.EditService-Post.php',
            data: $('#listService_form').serialize() + '&action=send',
            type: 'post',
            cache: false,
            dataType: 'html',
            success: function (xhr) {
                /*
                more code here...
                */
				$('#listService-submit').hide();
				$('#listService-remove').hide();

				$('#modalContent').html(xhr);
                //alert('OK!');
            }
			
        });
	
	
	
	
});
    
	$('#listService-remove').on('click', function() {
		//alert('Hello');
			$.ajax({
				url: 'snippets/User.Alerts.EditService-Post.php',
				data: $('#listService_form').serialize() + '&action=del',
				type: 'post',
				cache: false,
				dataType: 'html',
				success: function (xhr) {
					/*
					more code here...
					*/
					$('#listService-submit').hide();
					$('#listService-remove').hide();
	
					$('#modalContent').html(xhr);
					//alert('OK!');
				}
				
			});
	});
	$('#listService-refresh').on('click', function() {
		location.reload();
	});
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "date", {format:"yyyy-mm-dd", hint:"YYYY-MM-DD", validateOn:["change"], useCharacterMasking:true});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "date", {format:"yyyy-mm-dd", hint:"YYYY-MM-DD", useCharacterMasking:true, validateOn:["change"]});
    </script>

</body>
</html>