<?php
$SKIP = 1;
ini_set('display_errors','0');


require_once("../incs/database.php");
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
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
       <!-- range picker-->
	<link rel="stylesheet" type="text/css" media="all" href="bootstrap-daterangepicker-master/daterangepicker.css" />
		<script type="text/javascript" src="assets/js/jquery.js"></script>
		<script type="text/javascript" src="bootstrap-daterangepicker-master/date.js"></script>
		<script type="text/javascript" src="bootstrap-daterangepicker-master/daterangepicker.js"></script>
	<!-- end here -->
    
<title>Transactional Data Dumps</title>

</head>

<body>

<div class="navbar navbar-inner">
<a href="#menu-bar" class="second"><button class="btn btn-primary"><i class="icon-align-justify"></i> Menu</button></a>
</div>


<div class="container">

<div class="row">

<div class="page-header">
  <h1>Transactional Data Dumps<small>&nbsp;&nbsp;finest &amp; most granular data</small></h1>
</div>

		
        

<div class="tab-pane active" id="pills-basic">
							<!--<h3>Pills</h3>-->
							<div class="tabbable">
							  <ul class="nav nav-pills">
							    <li class="active"><a href="#BillDump" data-toggle="tab" data-act="BillDump">Billing Data</a></li>
							    <li class=""><a href="#CallDump" data-toggle="tab" data-act="CallDump">Calling Data</a></li>
							    <li class=""><a href="#ContentDump" data-toggle="tab"  data-act="ContentDump">Content Data</a></li>
							    <li class=""><a href="#MDNDump" data-toggle="tab"  data-act="MDNDump">Mobile # Status</a></li>
							    <li class=""><a href="#Social" data-toggle="tab"  data-act="Social">Social Sharing Data</a></li>
							    <li class=""><a href="#WAPDump" data-toggle="tab"  data-act="WAPDump">WAP Browsing Data</a></li>
							  </ul>
							  <div class="tab-content">
							    <div id="BillDump" class="tab-pane active">
                                

							<form id="form-BillDump"><table class="table table-bordered table-condensed">
              <tr>
                <td width="16%" height="32" align="left"><span>Service &amp; Circles</span></td>
                <td align="left"><select name="Tbl" id="Tbl">
                  <?php
		  sksort($Service_DESC);
		  foreach($Service_DESC as $SvName=>$Service) {
			
			if(in_array($SvName,$AR_SList)) {		
			if($Service["BillingTable"] && strcmp("Rel54646",$SvName) != 0 && $Service["BillingTable"] != false) {
			?>
                  <option value="<?php echo $Service["BillingTable"];?>,<?php echo $Service["BillingTableExtra"];?>,<?php echo $SvName;?>"><?php echo $Service["Name"];?></option>
                  <?php	
			}
			}
			
		  }
		  ?>
                  
                </select>&nbsp;&nbsp;<select onFocus="$('#Circles-BillDump').modal('show');" class="span2">
                <option disabled="disabled">Select Circles</option></select>
                </td>
                </tr>
<!-- date range section start here -->           
		   <tr class="Text_a_7">
                <td>Date Range</td>
                <td><span id="sprytextfield1">
                    <label>
                      <!--input name="Date_FROM" type="text"  id="Date_FROM" /-->
					      <div id="rangepicker-BillDump" class="" >
    <i class="icon-calendar icon-large"></i>
    <!--span><?php echo date("Y-m-d", strtotime('-30 day')); ?> - <?php echo date("Y-m-d"); ?></span-->
	<input type="text" value="<?php if(!$_POST) { echo date("Y-m-d", strtotime('-30 day')); ?> - <?php echo date("Y-m-d");} else{ echo date("Y-m-d",strtotime($StartDate))." - ".date("Y-m-d",strtotime($EndDate));}?>" id="Date_FROM-BillDump" name="Date_FROM"  style="font-size: 1.0em;" />
	
	<b class="caret"></b>
</div>
					  
                    </label></td>
                </tr>
<!-- date range section end here -->      
	  <tr>
                <td>Type of Billing Data</td>
                <td> <input name="DumpType" type="radio"  id="radio2" value="2">&nbsp;<span class="label label-important">
                  Failure </span>&nbsp;&nbsp;&nbsp;<input name="DumpType" type="radio"  id="radio" value="1">&nbsp;<span class="label label-info"> Success </span>&nbsp;&nbsp;&nbsp;<input name="DumpType" type="radio"  id="radio3" value="3" checked>&nbsp;<span class="label label-success">
                    Both </span><span class="pull-right"><button class="btn btn-primary" id="submit-BillDump" type="button">Submit</button></span></td>
                </tr>
              
              </table> <div class="modal hide fade" id="Circles-BillDump" tabindex="-1" role="dialog" aria-labelledby="CirclesLabel" aria-hidden="true">
		<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="CirclesLabel">Select Circles</h3>
  </div>
    

  <div class="modal-body">
        <a href="#" class="listService-toggle" class="pull-right well-small"><small>Toggle Selection</small></a>

    		<?php include "incs/modalCircles.php";?>
  </div>
  <div class="modal-footer">
    <!-- <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>-->
    <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Save changes</button>
  </div>
	</div></form>                                  
							    </div>
							    <div id="CallDump" class="tab-pane">
							    <form id="form-CallDump"><table class="table table-bordered table-condensed">
              <tr>
                <td width="16%" height="32" align="left"><span class="Text_a_7">Service &amp; Circles</span></td>
                <td align="left"><select name="Tbl"  id="Tbl">
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
                </select>&nbsp;&nbsp;<select onFocus="$('#Circles-CallDump').modal('show');" class="span2">
                <option disabled="disabled">Select Circles</option></select></td>
                <td rowspan="3" align="left" width="25%"><div class="well pull-right"><small>for Aircel MC, Uninor Devotional, MU, MyMusic, Videocon VMusic &amp; Reliance MusicMania select Both</small></div></td>
              </tr>
<!-- date range section start here -->           
		   <tr class="Text_a_7">
                <td>Date Range</td>
                <td><span id="sprytextfield1">
                    <label>
                      <!--input name="Date_FROM" type="text"  id="Date_FROM" /-->
					      <div id="rangepicker-CallDump" class="" >
    <i class="icon-calendar icon-large"></i>
    <!--span><?php echo date("Y-m-d", strtotime('-30 day')); ?> - <?php echo date("Y-m-d"); ?></span-->
	<input type="text" value="<?php if(!$_POST) { echo date("Y-m-d", strtotime('-30 day')); ?> - <?php echo date("Y-m-d");} else{ echo date("Y-m-d",strtotime($StartDate))." - ".date("Y-m-d",strtotime($EndDate));}?>" id="Date_FROM-CallDump" name="Date_FROM"  style="font-size: 1.0em;" />
	
	<b class="caret"></b>
</div>
					  
                    </label></td>
                </tr>
<!-- date range section end here -->      
	  <tr>
                <td>Type of Billing Data</td>
                <td> <input name="DumpType" type="radio"  id="radio2" value="2" />&nbsp;<span class="label label-important">
                  Live </span>&nbsp;&nbsp;&nbsp;<input name="DumpType" type="radio"  id="radio" value="1" />&nbsp;<span class="label label-info">
                    Non Live </span>&nbsp;&nbsp;&nbsp;<input name="DumpType" type="radio"  id="radio3" value="3" checked="checked" />&nbsp;<span class="label label-success">
                    Both </span><span class="pull-right"><button class="btn btn-primary" id="submit-CallDump" type="button">Submit</button></span></td>
                </tr>
              
              </table><div class="modal hide fade" id="Circles-CallDump" tabindex="-1" role="dialog" aria-labelledby="CirclesLabel" aria-hidden="true">
		<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="CirclesLabel">Select Circles</h3>
  </div>
    

  <div class="modal-body">
        <a href="#" class="listService-toggle" class="pull-right well-small"><small>Toggle Selection</small></a>

    		<?php include "incs/modalCircles.php";?>
  </div>
  <div class="modal-footer">
    <!-- <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>-->
    <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Save changes</button>
  </div>
	</div></form>
                                </div>
							    <div id="ContentDump" class="tab-pane">
							      
                                  <form id="form-ContentDump"><table class="table table-bordered table-condensed">
              <tr>
                <td width="16%" height="32" align="left"><span>Service &amp; Circles</span></td>
                <td align="left"><select name="Tbl"  id="Tbl">
          <?php
		  sksort($Service_DESC);
		  foreach($Service_DESC as $SvName=>$Service) {
			
			if(in_array($SvName,$AR_SList)) {		
			if($Service["ContentUsageTable"] && strcmp("Rel54646",$SvName) != 0) {
			?>
          <option value="<?php echo $SvName;?>"><?php echo $Service["Name"];?></option>
          <?php	
			}
			}
			
		  }
		  ?>
         
        </select>&nbsp;&nbsp;<select onFocus="$('#Circles-ContentDump').modal('show');" class="span2">
                <option disabled="disabled">Select Circles</option></select></td>
                </tr>
<!-- date range section start here -->           
		   <tr class="Text_a_7">
                <td>Date Range</td>
                <td><span id="sprytextfield1">
                    <label>
                      <!--input name="Date_FROM" type="text"  id="Date_FROM" /-->
					      <div id="rangepicker-ContentDump" class="" >
    <i class="icon-calendar icon-large"></i>
    <!--span><?php echo date("Y-m-d", strtotime('-30 day')); ?> - <?php echo date("Y-m-d"); ?></span-->
	<input type="text" value="<?php if(!$_POST) { echo date("Y-m-d", strtotime('-30 day')); ?> - <?php echo date("Y-m-d");} else{ echo date("Y-m-d",strtotime($StartDate))." - ".date("Y-m-d",strtotime($EndDate));}?>" id="Date_FROM-ContentDump" name="Date_FROM"  style="font-size: 1.0em;" />
	
	<b class="caret"></b>
</div>
					  
                    </label></td>
                </tr>
<!-- date range section end here -->      
	  <tr>
                <td>Type of Billing Data</td>
                <td> <input name="DumpType" type="radio"  id="radio2" value="1">&nbsp;<span class="label label-important">
                  IVR </span>&nbsp;&nbsp;&nbsp;<input name="DumpType" type="radio"  id="radio" value="2">&nbsp;<span class="label label-info"> RBT/RT/Others </span>&nbsp;&nbsp;&nbsp;<input name="DumpType" type="radio"  id="radio3" value="3" checked>&nbsp;<span class="label label-success"> Both </span><span class="pull-right"><button class="btn btn-primary" id="submit-ContentDump" type="button">Submit</button></span></td>
                </tr>
              
              </table><div class="modal hide fade" id="Circles-ContentDump" tabindex="-1" role="dialog" aria-labelledby="CirclesLabel" aria-hidden="true">
		<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="CirclesLabel">Select Circles</h3>
  </div>
    

  <div class="modal-body">
        <a href="#" class="listService-toggle" class="pull-right well-small"><small>Toggle Selection</small></a>

    		<?php include "incs/modalCircles.php";?>
  </div>
  <div class="modal-footer">
    <!-- <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>-->
    <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Save changes</button>
  </div>
	</div></form>
                                  
							    </div>
							        <div id="MDNDump" class="tab-pane">
							      
                                  <form id="form-MDNDump"><table class="table table-bordered table-condensed">
              <tr>
                <td width="16%" height="32" align="left"><span>Service</span></td>
                <td align="left"><select name="Tbl"  id="Tbl">
          <?php
		  sksort($Service_DESC);
		  foreach($Service_DESC as $SvName=>$Service) {
			
			if(in_array($SvName,$AR_SList)) {		
			if($Service["BillingTable"] && strcmp("Rel54646",$SvName) != 0) {
			?>
          <option value="<?php echo $SvName;?>"><?php echo $Service["Name"];?></option>
          <?php	
			}
			}
			
		  }
		  ?>
         
        </select>&nbsp;&nbsp;</td>
                </tr>
<!-- date range section start here -->           
		   <tr>
                <td>Mobile #'s</td>
                <td>			<textarea name="Numbers" cols="20" rows="8" id="Numbers" class="span4"></textarea><span class="pull-right"><button class="btn btn-primary" id="submit-MDNDump" type="button">Submit</button></span>
</td>
                </tr>

              
              </table></form>
                                  
							    </div>
                                
                                
                                 <div id="Social" class="tab-pane">
                                

							<form id="form-Social"><table class="table table-bordered table-condensed">
              <tr>
                <td width="16%" height="32" align="left"><span>Service &amp; Circles</span></td>
                <td align="left"><select name="Tbl" id="Tbl">
                  <?php
		  sksort($Service_DESC);
		  foreach($Service_DESC as $SvName=>$Service) {
			
			if(in_array($SvName,$AR_SList)) {		
			if($Service["Social"] && strcmp("Rel54646",$SvName) != 0) {
			?>
          <option value="<?php echo $SvName;?>"><?php echo $Service["Name"];?></option>
          <?php	
			}
			}
			
		  }
		  ?>
                  
                </select>&nbsp;&nbsp;<select onFocus="$('#Circles-Social').modal('show');" class="span2">
                <option disabled="disabled" >Select Circles</option></select>
                </td>
                </tr>
<!-- date range section start here -->           
		   <tr class="Text_a_7">
                <td>Date Range</td>
                <td><span id="sprytextfield1">
                    <label>
                      <!--input name="Date_FROM" type="text"  id="Date_FROM" /-->
					      <div id="rangepicker-Social" class="" >
    <i class="icon-calendar icon-large"></i>
    <!--span><?php echo date("Y-m-d", strtotime('-30 day')); ?> - <?php echo date("Y-m-d"); ?></span-->
	<input type="text" value="<?php if(!$_POST) { echo date("Y-m-d", strtotime('-30 day')); ?> - <?php echo date("Y-m-d");} else{ echo date("Y-m-d",strtotime($StartDate))." - ".date("Y-m-d",strtotime($EndDate));}?>" id="Date_FROM-Social" name="Date_FROM"  style="font-size: 1.0em;" />
	
	<b class="caret"></b>
<span class="pull-right"><button class="btn btn-primary" id="submit-Social" type="button">Submit</button></span></div>
					  
                    </label></td>
                </tr>
<!-- date range section end here -->      
	  </table> <div class="modal hide fade" id="Circles-Social" tabindex="-1" role="dialog" aria-labelledby="CirclesLabel" aria-hidden="true">
		<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="CirclesLabel">Select Circles</h3>
  </div>
    

  <div class="modal-body">
        <a href="#" class="listService-toggle" class="pull-right well-small"><small>Toggle Selection</small></a>

    		<?php include "incs/modalCircles.php";?>
  </div>
  <div class="modal-footer">
    <!-- <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>-->
    <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Save changes</button>
  </div>
	</div></form>                                  
							    </div>
							  
                                  <div id="WAPDump" class="tab-pane">
							      
                                  <form id="form-WAPDump"><table class="table table-bordered table-condensed">
              <tr>
                <td width="16%" height="32" align="left"><span>Service &amp; Circles</span></td>
                <td align="left"><select name="Tbl"  id="Tbl">
          <?php
		  sksort($Service_DESC);
		  foreach($Service_DESC as $SvName=>$Service) {
			
			if(in_array($SvName,$AR_SList)) {		
			if($Service["WAP"] && strcmp("Rel54646",$SvName) != 0) {
			?>
          <option value="<?php echo $SvName;?>"><?php echo $Service["Name"];?></option>
          <?php	
			}
			}
			
		  }
		  ?>
         
        </select>&nbsp;&nbsp;<select onFocus="$('#Circles-WAPDump').modal('show');" class="span2">
                <option disabled="disabled">Select Circles</option></select></td>
                </tr>
<!-- date range section start here -->           
		   <tr">
                <td>Date Range</td>
                <td><span id="sprytextfield1">
                    <label>
                      <!--input name="Date_FROM" type="text"  id="Date_FROM" /-->
					      <div id="rangepicker-WAPDump" class="" >
    <i class="icon-calendar icon-large"></i>
    <!--span><?php echo date("Y-m-d", strtotime('-30 day')); ?> - <?php echo date("Y-m-d"); ?></span-->
	<input type="text" value="<?php if(!$_POST) { echo date("Y-m-d", strtotime('-30 day')); ?> - <?php echo date("Y-m-d");} else{ echo date("Y-m-d",strtotime($StartDate))." - ".date("Y-m-d",strtotime($EndDate));}?>" id="Date_FROM-WAPDump" name="Date_FROM"  style="font-size: 1.0em;" />
	
	<b class="caret"></b>
</div>
					  
                    </label><span class="pull-right"><button class="btn btn-primary" id="submit-WAPDump" type="button">Submit</button></span></td>
                </tr>
<!-- date range section end here -->      
	 
              
              </table><div class="modal hide fade" id="Circles-WAPDump" tabindex="-1" role="dialog" aria-labelledby="CirclesLabel" aria-hidden="true">
		<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="CirclesLabel">Select Circles</h3>
  </div>
    

  <div class="modal-body">
        <a href="#" class="listService-toggle" class="pull-right well-small"><small>Toggle Selection</small></a>

    		<?php include "incs/modalCircles.php";?>
  </div>
  <div class="modal-footer">
    <!-- <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>-->
    <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Save changes</button>
  </div>
	</div></form>
                                  
							    </div>
                                
                                
                                
							  </div><!-- /.tab-content -->
							</div><!-- /.tabbable -->
						</div>
     <div id="loading"><img src="assets/img/loading-circle-48x48.gif" border="0" /></div> 
     <div id="alert-success" class="alert alert-success"></div> 
     <div id="grid">dd</div>      
          

</div>
</div>

<?php

include "Menu-Vertical.php";

?>

 
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
    
<script type="text/javascript">
    $(".second").pageslide({ direction: "right", modal: true });

$('#rangepicker-BillDump').daterangepicker(
    {
        ranges: {
            'Today': ['today', 'today'],
            'Yesterday': ['yesterday', 'yesterday'],
            'Last 7 Days': [Date.today().add({ days: -6 }), 'today'],
            'Last 30 Days': [Date.today().add({ days: -29 }), 'today'],
            'This Month': [Date.today().moveToFirstDayOfMonth(), Date.today().moveToLastDayOfMonth()],
            'Last Month': [Date.today().moveToFirstDayOfMonth().add({ months: -1 }), Date.today().moveToFirstDayOfMonth().add({ days: -1 })]
        }
    }, 
    function(start, end) {
    	  $('#Date_FROM-BillDump').val(start.toString('yyyy-mm-dd') + ' - ' + end.toString('yyyy-mm-dd'));
    }
);

$('#rangepicker-CallDump').daterangepicker(
    {
        ranges: {
            'Today': ['today', 'today'],
            'Yesterday': ['yesterday', 'yesterday'],
            'Last 7 Days': [Date.today().add({ days: -6 }), 'today'],
            'Last 30 Days': [Date.today().add({ days: -29 }), 'today'],
            'This Month': [Date.today().moveToFirstDayOfMonth(), Date.today().moveToLastDayOfMonth()],
            'Last Month': [Date.today().moveToFirstDayOfMonth().add({ months: -1 }), Date.today().moveToFirstDayOfMonth().add({ days: -1 })]
        }
    }, 
    function(start, end) {
    	  $('#Date_FROM-CallDump').val(start.toString('yyyy-mm-dd') + ' - ' + end.toString('yyyy-mm-dd'));
    }
);

$('#rangepicker-ContentDump').daterangepicker(
    {
        ranges: {
            'Today': ['today', 'today'],
            'Yesterday': ['yesterday', 'yesterday'],
            'Last 7 Days': [Date.today().add({ days: -6 }), 'today'],
            'Last 30 Days': [Date.today().add({ days: -29 }), 'today'],
            'This Month': [Date.today().moveToFirstDayOfMonth(), Date.today().moveToLastDayOfMonth()],
            'Last Month': [Date.today().moveToFirstDayOfMonth().add({ months: -1 }), Date.today().moveToFirstDayOfMonth().add({ days: -1 })]
        }
    }, 
    function(start, end) {
    	  $('#Date_FROM-ContentDump').val(start.toString('yyyy-mm-dd') + ' - ' + end.toString('yyyy-mm-dd'));
		  //alert('hello');
    }
);


$('#rangepicker-Social').daterangepicker(
    {
        ranges: {
            'Today': ['today', 'today'],
            'Yesterday': ['yesterday', 'yesterday'],
            'Last 7 Days': [Date.today().add({ days: -6 }), 'today'],
            'Last 30 Days': [Date.today().add({ days: -29 }), 'today'],
            'This Month': [Date.today().moveToFirstDayOfMonth(), Date.today().moveToLastDayOfMonth()],
            'Last Month': [Date.today().moveToFirstDayOfMonth().add({ months: -1 }), Date.today().moveToFirstDayOfMonth().add({ days: -1 })]
        }
    }, 
    function(start, end) {
    	  $('#Date_FROM-Social').val(start.toString('yyyy-mm-dd') + ' - ' + end.toString('yyyy-mm-dd'));
		  //alert('hello');
    }
);

$('#rangepicker-WAPDump').daterangepicker(
    {
        ranges: {
            'Today': ['today', 'today'],
            'Yesterday': ['yesterday', 'yesterday'],
            'Last 7 Days': [Date.today().add({ days: -6 }), 'today'],
            'Last 30 Days': [Date.today().add({ days: -29 }), 'today'],
            'This Month': [Date.today().moveToFirstDayOfMonth(), Date.today().moveToLastDayOfMonth()],
            'Last Month': [Date.today().moveToFirstDayOfMonth().add({ months: -1 }), Date.today().moveToFirstDayOfMonth().add({ days: -1 })]
        }
    }, 
    function(start, end) {
    	  $('#Date_FROM-WAPDump').val(start.toString('yyyy-mm-dd') + ' - ' + end.toString('yyyy-mm-dd'));
		  //alert('hello');
    }
);



$('a[data-toggle="tab"]').on('shown', function (e) {
  var parts = decodeURI(e.target).split('#');
		$.fn.AjaxAct(parts[1],'');
});


	$('#submit-BillDump').on('click', function() {
		//alert('Hello');
		$.fn.SubmitForm('BillDump');
	});

	$('#submit-CallDump').on('click', function() {
		//alert('Hello');
		$.fn.SubmitForm('CallDump');
	});
	

	$('#submit-ContentDump').on('click', function() {
		//alert('Hello');
		$.fn.SubmitForm('ContentDump');
	});
	$('#submit-MDNDump').on('click', function() {
		//alert('Hello');
		$.fn.SubmitForm('MDNDump');
	});
	$('#submit-Social').on('click', function() {
		//alert('Hello');
		$.fn.SubmitForm('Social');
	});
	$('#submit-WAPDump').on('click', function() {
		//alert('Hello');
		$.fn.SubmitForm('Social');
	});
	
	
	$.fn.SubmitForm = function(act) {
		
			$('#loading').show();
			$('#alert-success').hide();
			$('#grid').hide();
			$('#grid').html('');
			
			$.ajax({
				url: 'Transactional.'+act+'.Store.php',
				data: $('#form-'+act).serialize() + '&action=del&username=<?php echo $username;?>',
				type: 'post',
				cache: false,
				dataType: 'html',
				success: function (xhr) {
					/*
					more code here...
					*/
					
					/*
					Get Table
					
					*/
					$.fn.AjaxAct(act, xhr);
					
					//alert('OK!');
				}
				
			});

		
		
		
	};




$.fn.AjaxAct = function(act,xhr) {
		//alert(act);
		
		if(!xhr) {
						$('#loading').show();
						$('#grid').html('');	

					}
		
		$.ajax({
						url: 'snippets/Transactional.GetTable.php',
						data: '&action=del&username=<?php echo $username;?>&act='+act,
						type: 'post',
						cache: false,
						dataType: 'html',
						success: function (abc) {
							/*
							more code here...
							*/
			
							$('#grid').html(abc);
							//alert('OK!');
						}
						
					});
					
					
					
					$('#loading').hide();
					
					if(xhr) {
						$('#alert-success').show();
						$('#alert-success').html(xhr);	

					}
					$('#grid').show();
	
};



								$('#alert-success').hide();

					$.fn.AjaxAct('BillDump', '');
var tog = false; // or true if they are checked on load 
 $('.listService-toggle').click(function() { 
    $("input[type=checkbox]").attr("checked",!tog); 
  tog = !tog; 
 });


</script>  

</body>
</html>