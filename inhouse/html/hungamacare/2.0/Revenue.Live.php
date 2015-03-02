<?php

$PAGE_TAG = 'revenue-live';
ini_set('display_errors','1');

require_once("incs/database.php");
require_once("../incs/GraphColors-D.php");
require_once("../../ContentBI/base.php");
require_once("incs/Mobile_Detect.php");

    $detect = new Mobile_Detect;

if($detect->isMobile() || $detect->isTablet()) {
	
	$MOS = 1;	
}

	
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
 <link href="assets/css/bootstrap.css" rel="stylesheet" />
 <link href="assets/css/jquery.pageslide.css" rel="stylesheet"  />
  <link href="assets/css/style.css" rel="stylesheet" />
<link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
<link href="assets/css/responsive-tables.css" rel="stylesheet">
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    
    
<title>LIVE Revenue KPI's</title>

</head>

<body><?php echo $MOS;?>
<form id="livemis">

<div class="navbar navbar-inner">
<div class="container-fluid">
<a href="#menu-bar" class="second brand"><button class="btn btn-primary"><i class="icon-align-justify"></i> Menu</button></a>
		
        <div class="btn-group pull-right"><select name="Service" id="Service" class="span2">
              <option>Select Service</option>
                  <?php
		  sksort($Service_DESC);
		  foreach($Service_DESC as $SvName=>$Service) {
			
			if(in_array($SvName,$AR_SList)) {		
			if($Service["livemis"] == true) {
			?>
                  <option value="<?php echo $SvName;?>"><?php echo $Service["Name"];?></option>
                  <?php	
			}
			}
			
		  }
		  ?>
                  
                </select>
                
                <?php if($MOS != 1) {?>
                <select onFocus="$('#Circles').modal('show');" class="span2">
                <option disabled="disabled">Select Circles</option></select>
                <?php } else{?>
                
                <select name="Circle[]" size="1" multiple="multiple" class="span2">
              <option disabled="disabled">Select Circles</option>
                  <?php
		 // ksort($AR_CList);
		  foreach($AR_CList as $circle) {
			
			
			?>
                  <option value="<?php echo $circle;?>"><?php echo $circle;?></option>
                  <?php	
			
			
		 		 }
		  ?>
                  
                </select>
                <?php } ?>
                
                
                <select name="Date" class="span1" id="Date">
                <option value="<?php echo date("Y-m-d", time()-24*60*60);?>" <?php echo (strcmp($Date,(date("Y-m-d", time()-24*60*60)))==0?'selected':'');?>><?php echo date("d-M", time()-24*60*60);?></option>
                <option value="<?php echo date("Y-m-d");?>"  <?php echo (strcmp($Date,(date("Y-m-d")))==0?'selected':'');?>><?php echo date("d-M");?></option>
                </select>&nbsp;<button type="button" class="pull-right  btn-primary" id="go"><i class="icon-white icon-th"></i>&nbsp;Go&nbsp; <i class="icon-forward icon-white"></i></button>
           <!-- <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
              <i class="icon-th"></i> Select here<span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
              <li><a href="#"><select name="Service" id="Service">
              <option>Select Service</option>
                  <?php
		  sksort($Service_DESC);
		  foreach($Service_DESC as $SvName=>$Service) {
			
			if(in_array($SvName,$AR_SList)) {		
			if($Service["livemis"] == true) {
			?>
                  <option value="<?php echo $SvName;?>"><?php echo $Service["Name"];?></option>
                  <?php	
			}
			}
			
		  }
		  ?>
                  
                </select></a></li>
              <li><a href="#" data-toggle="modal" data-target="#Circles"><select><option>Select Circles</option></select></a>
              <li><a href="#"><select name="Date" class="fbbody" id="Date">
                <option value="<?php echo date("Y-m-d", time()-24*60*60);?>" <?php echo (strcmp($Date,(date("Y-m-d", time()-24*60*60)))==0?'selected':'');?>>Yesterday <?php echo date("D M j", time()-24*60*60);?></option>
                <option value="<?php echo date("Y-m-d");?>"  <?php echo (strcmp($Date,(date("Y-m-d")))==0?'selected':'');?>>Today <?php echo date("D M j");?></option>
                </select></a></li>
              <li class="divider"></li>
              <li><button type="button" class="btn btn-primary pull-right" id="go">Go</button></li>

            </ul> -->
          </div>

</div>

</div>

<div class="container">

<div class="row">

<div class="page-header">
  <h1>Live Revenue KPI's<small>&nbsp;&nbsp;realtime window</small></h1>
</div>

</div>

	 <div id="loading"><img src="assets/img/loading-circle-48x48.gif" border="0" /></div> 
     <div id="alert-success" class="alert alert-success">dd</div> 
     <div id="grid" class="pull-left">dd</div>      
    
</div>


<?php

include "Menu-Vertical.php";

?>
 <div class="modal hide fade" id="Circles" tabindex="-1" role="dialog" aria-labelledby="CirclesLabel" aria-hidden="true">
		<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="CirclesLabel">Select Circles</h3>
  </div>
    

  <div class="modal-body">
        <a href="#" id="listService-toggle" class="pull-right well-small"><small>Toggle Selection</small></a>

    		<?php include "incs/modalCircles.php";?>
  </div>
  <div class="modal-footer">
    <!-- <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>-->
    <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Save changes</button>
  </div>
	</div>
    </form>
    
    
    
  <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap-alert.js"></script>
    <script src="assets/js/bootstrap-modal.js"></script>
    <script src="assets/js/bootstrap-dropdown.js"></script>
    <script src="assets/js/bootstrap-button.js"></script>
    <script src="assets/js/bootstrap-typeahead.js"></script>
    <script src="assets/js/bootstrap-collapse.js"></script>
    
    <script src="assets/js/jquery.pageslide.js"></script>
    <script src="assets/js/responsive-tables.js"></script>

<script>
		$('#go').on('click', function() {
		//alert('Hello');
			$('#loading').show();
			$('#alert-success').hide();
			$('#grid').hide();
			$('#grid').html('');
				
			$.ajax({
				url: 'snippets/Revenue.Live.php?MOS=<?php echo $MOS;?>',
				data: $('#livemis').serialize(),
				type: 'post',
				cache: false,
				dataType: 'html',
				success: function (xhr) {

						$('#loading').hide();
						$('#grid').html(xhr);
						$('#grid').show();
	
	
				}
				
			});
	});



$('#loading').hide();
$('#alert-success').hide();
$('#grid').hide();
    $(".second").pageslide({ direction: "right", modal: true });
	
	$('#alert-no-alert_type').hide();
var tog = false; // or true if they are checked on load 
 $('#listService-toggle').click(function() { 
    $("input[type=checkbox]").attr("checked",!tog); 
  tog = !tog; 
 });
 


 
</script>
</body>
</html>