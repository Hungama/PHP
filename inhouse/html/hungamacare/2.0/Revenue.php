<?php
$SKIP = 1;
ini_set('display_errors','1');
$start = (float) array_sum(explode(' ',microtime())); 




require_once("incs/database.php");
require_once("../../ContentBI/base.php");
require_once("../../cmis/base.php");
require_once("../incs/GraphColors-D.php");
///// TEMP VARS ////
$Service = "'UninorMU'";
$Circle = "'Bihar','UP-West','UP-East','Mumbai'";
$StartDate = '2012-08-20';
$EndDate = '2012-09-20';
$GRP_Service = 'Service[]=UninorMU';
$GRP_Circle = 'Circle[]=Bihar&Circle[]=UP-West&Circle[]=UP-East&Circle[]=Mumbai';

////////////////////

if(!isset($StartDate)) {
    $StartDate = date("Y-m-d",(time()-3600*24*22));
}


if(!isset($EndDate)) {
    $EndDate = date("Y-m-d",(time()-3600*24*15));
}


?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
 <link href="assets/css/bootstrap.css" rel="stylesheet" />
  <link href="assets/css/style.css" rel="stylesheet" />
<link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
<link href="assets/css/datepicker.css" rel="stylesheet" />
<link href="assets/css/icons-sprites.css" rel="stylesheet" />
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    
    
<title>Untitled Document</title>
</head>

<body>

	<!--- Site Code -->
    
   <?php include "Menu.php" ;?>

    <div class="container-fluid">
      <div class="hero-unit">

<button type="button" class="btn small" data-toggle="modal" data-target="#myModal">Select Services</button>
    
    
     <div class="modal hide fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Select Services</h3>
  </div>
    

  <div class="modal-body">
    		<?php include "incs/modalServices.php";?>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <button class="btn btn-primary">Save changes</button>
  </div>
	</div>
    
    
    
    <button type="button" class="btn small" data-toggle="modal" data-target="#Circles">Select Circles</button>
    
    
     <div class="modal hide fade" id="Circles" tabindex="-1" role="dialog" aria-labelledby="CirclesLabel" aria-hidden="true">
		<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="CirclesLabel">Select Circles</h3>
  </div>
    

  <div class="modal-body">
    		<?php include "incs/modalCircles.php";?>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <button class="btn btn-primary">Save changes</button>
  </div>
	</div>
    
    
             
             
            <button class="btn small" id="dp4" data-date-format="yyyy-mm-dd" data-date="<?php echo $StartDate;?>">from: <?php echo date('D M j',strtotime($StartDate));?></button>
            <button  class="btn small" id="dp5" data-date-format="yyyy-mm-dd" data-date="<?php echo $EndDate;?>">to: <?php echo date('D M j',strtotime($EndDate));?></button>
            <div class="alert alert-error hide" id="alert">
				<strong>Oh snap!</strong>
			  </div>
              
             
						<input type="hidden" id="startDate" />
						<input type="hidden" id="endDate" />
		  			
                    
       </div>
       
       
       <div class="row-fluid">
        <!--/span-->
       	<div class="shortcuts">
        		<a href="javascript:;" class="shortcut">
								<h1>Revenue</h1>
                                <hr />
                                <h2>1,039,0293 <span class="label label-success">+3%</span></h2>

                                
                                <h3>1,039,0293 <span class="label label-important">+3%</span><br/><small>Daily Revenue</small></h3></p>

							</a>
      
       
     
     <a href="javascript:;" class="shortcut">
								<h1>ARPU</h1>
                                <hr />
                                <h2>Rs. 5.01 <span class="label label-success">+3%</span></h2>

                                
                                <h3>103,913 <span class="label label-important">+3%</span><br/><small>CHURN</small></h3></p>

							</a>
        
        
        
        
        <a href="javascript:;" class="shortcut">
								<h1>Act. Rev.</h1>
                                <hr />
                                <h2>1,039,0293 <span class="label label-success">+3%</span></h2>

                                
                                <h3>193,0193 <span class="label label-important">+3%</span><br/><small>Avg. Act. Revenue</small></h3></p>

							</a>

        

        		<a href="javascript:;" class="shortcut">
								<h1>Usage</h1>
                                <hr />
                                <h2>10:90:81 hrs <span class="label label-success">+3%</span></h2>

                                
                                <h3>5,918 <span class="label label-important">+3%</span><br/><small>Total Call Volume</small></h3></p>

							</a>
        </div>
       
       
            <div class="btn-group" style="position:relative; top: 35px; z-index: 999999999; left: 7px;">
              <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                More
                <span class="caret"></span>
              </a>
              <ul class="dropdown-menu">
                <!-- dropdown menu links -->
                <li><a href="#">Revenue Trending</a></li>
                <li><a href="#">Call Patterns</a></li>
                <li><a href="#">Consumer Base</a></li>
              </ul>
            </div>
         <div class="hero-unit" style="padding: 5px;"><div id="date_trend" style="height: 210px; width: auto"></div>
            <!-- <h1>Hello, world!</h1> -->
            
            
           
           
            
            
          </div> 
          
          <div class="row-fluid">
            <div class="span4 box-widget">
				<div class="box-widget-head">
			<div class="pull-left"><i class="icon-user"></i> Visitors</div>
			<div class="pull-right btn-group sharp">
				&nbsp;
			</div>
		   </div>
        
                      <div><div id="pieCircleRev" style="min-width: 350px; height:250px; padding: 10px;"></div></div>
             
            </div><!--/span-->
            <div class="span4 box-widget">
             <div class="box-widget-head">
			<div class="pull-left"><i class="icon-user"></i> Visitors</div>
			<div class="pull-right btn-group sharp">
				&nbsp;
			</div>
		   </div>
              <p><img src="assets/img/tmp_pie.png" alt="" /></p>
              
            </div><!--/span-->
            <div class="span4 box-widget">
              <div class="box-widget-head">
			<div class="pull-left"><i class="icon-user"></i> Visitors</div>
			<div class="pull-right btn-group sharp">
				&nbsp;
			</div>
		   </div>
              <p><img src="assets/img/tmp_pie.png" alt="" /></p>
              
            </div><!--/span-->
          </div><!--/row-->
          <div class="row-fluid">
            <div class="span4 box-widget">
               <div class="box-widget-head">
			<div class="pull-left"><i class="icon-user"></i> Visitors</div>
			<div class="pull-right btn-group sharp">
				&nbsp;
			</div>
		   </div>
              <p><img src="assets/img/tmp_pie.png" alt="" /></p>
              
            </div><!--/span-->
            <div class="span4 box-widget">
               <div class="box-widget-head">
			<div class="pull-left"><i class="icon-user"></i> Visitors</div>
			<div class="pull-right btn-group sharp">
				&nbsp;
			</div>
		   </div>
              <p><img src="assets/img/tmp_pie.png" alt="" /></p>
              
            </div><!--/span-->
            <div class="span4 box-widget">
               <div class="box-widget-head">
			<div class="pull-left"><i class="icon-user"></i> Visitors</div>
			<div class="pull-right btn-group sharp">
				&nbsp;
			</div>
		   </div>
              <p><img src="assets/img/tmp_pie.png" alt="" /></p>
              
            </div><!--/span-->
          </div><!--/row-->
       
      </div><!--/row-->

      <hr>

      <footer>
        <p>&copy; Company 2012</p>
      </footer>

    </div>
    
    <!-- End Site Code -->




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
    <script src="assets/js/bootstrap-datepicker.js"></script>
    <script src="assets/js/date.format.js"></script>
    
   <script type="text/javascript" src="charts/js/highcharts.js"></script>
    <script src="snippets/daytrend.revenue.php?Tag=Dialouts&TagName=Dialouts&Start=<?php echo $StartDate;?>&End=<?php echo $EndDate."&".$GRP_Service."&".$GRP_Circle;?>"></script>
    <script src="snippets/pie.circles.php?Start=<?php echo $StartDate;?>&End=<?php echo $EndDate."&".$GRP_Service."&".$GRP_Circle;?>"></script>


<script>


		


		 
		  
		  
		$(function(){
			window.prettyPrint && prettyPrint();
			
			
			
			var startDate = new Date(<?php echo str_replace("-",",",$StartDate);?>);
			var endDate = new Date(<?php echo str_replace("-",",",$EndDate);?>);
			
			$('#dp4').val(startDate);
			$('#dp5').val(endDate);
			
			$('#dp4').datepicker()
				.on('changeDate', function(ev){
					if (ev.date.valueOf() > endDate.valueOf()){
						$('#alert').show().find('strong').text('The start date can not be greater then the end date');
					} else {
						$('#alert').hide();
						startDate = new Date(ev.date);
						$('#startDate').text($('#dp4').data('date'));
					}

					$('#dp4').datepicker('hide');
					
					var date_chng = dateFormat(new Date($('#dp4').data('date')), 'ddd mmm dd');

					$('#dp4').html('from: ' + date_chng);
					$('#dp4').blur();
				});
			$('#dp5').datepicker()
				.on('changeDate', function(ev){
					if (ev.date.valueOf() < startDate.valueOf()){
						alert(startDate + '-' + ev.date);
						$('#alert').show().find('strong').text('The end date can not be less then the start date');
					} else {
						$('#alert').hide();
						endDate = new Date(ev.date);
						$('#endDate').text($('#dp5').data('date'));
					}
					
					var date_chng = dateFormat(new Date($('#dp5').data('date')), 'ddd mmm dd');
					$('#dp5').datepicker('hide');
					$('#dp5').html('to: ' + date_chng);
					$('#dp5').blur();
				});
		});
		
		
	</script>

</body>
</html>