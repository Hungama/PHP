<?php
session_start();
require_once("../../../db.php");

if(empty($_SESSION['loginId']))
{
session_destroy();
Header("location:index.php?ERROR=502");
}

if(isset($_POST['rangeA'])) {
list($o_F,$o_T) = explode(" - ",$_POST['rangeA']);
list($o_T_M,$o_T_D,$o_T_Y) = explode("/",$o_T);
list($o_F_M,$o_F_D,$o_F_Y) = explode("/",$o_F);
$EndDate = date("Y-m-d",mktime(0,0,0,$o_T_M,$o_T_D,$o_T_Y));
$StartDate = date("Y-m-d",mktime(0,0,0,$o_F_M,$o_F_D,$o_F_Y));
}
if(!isset($StartDate)) {
	//$StartDate= date("Y-m-d",mktime(0,0,0,date("m")-1,date("d"),date("Y")));
	$StartDate='2014-02-28';
}

if(!isset($EndDate)) {

	$EndDate= date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")));
}
$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa', 'KAR'=>'Karnataka', 'HAY'=>'Haryana','PUB'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh',''=>'Other');

require_once("alldataGLC1.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Good Life Club</title>
    <meta name="author" content="SuggeElson" />
    <meta name="description" content="Supr admin template - new premium responsive admin template. This template is designed to help you build the site administration without losing valuable time.Template contains all the important functions which must have one backend system.Build on great twitter boostrap framework" />
    <meta name="keywords" content="admin, admin template, admin theme, responsive, responsive admin, responsive admin template, responsive theme, themeforest, 960 grid system, grid, grid theme, liquid, masonry, jquery, administration, administration template, administration theme, mobile, touch , responsive layout, boostrap, twitter boostrap" />
    <meta name="application-name" content="Supr admin template" />

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Force IE9 to render in normal mode -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- Le styles -->
    <!-- Use new way for google web fonts 
    http://www.smashingmagazine.com/2012/07/11/avoiding-faux-weights-styles-google-web-fonts -->
    <!-- Headings -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css' />
    <!-- Text -->
    <link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet' type='text/css' /> 
    <!--[if lt IE 9]>
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400" rel="stylesheet" type="text/css" />
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:700" rel="stylesheet" type="text/css" />
    <link href="http://fonts.googleapis.com/css?family=Droid+Sans:400" rel="stylesheet" type="text/css" />
    <link href="http://fonts.googleapis.com/css?family=Droid+Sans:700" rel="stylesheet" type="text/css" />
    <![endif]-->

    <!-- Core stylesheets do not remove -->
    <link id="bootstrap" href="css/bootstrap/bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="css/bootstrap/bootstrap-theme.css" rel="stylesheet" type="text/css" />
    <link href="css/supr-theme/jquery.ui.supr.css" rel="stylesheet" type="text/css"/>
    <link href="css/icons.css" rel="stylesheet" type="text/css" />

    <!-- Plugins stylesheets -->
    <link href="plugins/misc/qtip/jquery.qtip.css" rel="stylesheet" type="text/css" />
    <link href="plugins/misc/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css" />
    <link href="plugins/misc/search/tipuesearch.css" type="text/css" rel="stylesheet" />

    <link href="plugins/forms/uniform/uniform.default.css" type="text/css" rel="stylesheet" />

    <!-- Main stylesheets -->
    <link href="css/main.css" rel="stylesheet" type="text/css" /> 

    <!-- Custom stylesheets ( Put your own changes here ) -->
    <link href="css/custom.css" rel="stylesheet" type="text/css" /> 

    <!--[if IE 8]><link href="css/ie8.css" rel="stylesheet" type="text/css" /><![endif]-->
    
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script type="text/javascript" src="js/libs/excanvas.min.js"></script>
      <script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
      <script type="text/javascript" src="js/libs/respond.min.js"></script>
    <![endif]-->
    
    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="images/favicon.ico" />
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/apple-touch-icon-144-precomposed.png" />
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/apple-touch-icon-114-precomposed.png" />
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/apple-touch-icon-72-precomposed.png" />
    <link rel="apple-touch-icon-precomposed" href="images/apple-touch-icon-57-precomposed.png" />
    
    <!-- Windows8 touch icon ( http://www.buildmypinnedsite.com/ )-->
    <meta name="application-name" content="Supr"/> 
    <meta name="msapplication-TileColor" content="#3399cc"/> 

    <!-- Load modernizr first -->
    <script type="text/javascript" src="js/libs/modernizr.js"></script>

	    <!-- range picker-->
		<link rel="stylesheet" type="text/css" media="all" href="bootstrap-daterangepicker-master/daterangepicker.css" />
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
		<script type="text/javascript" src="bootstrap-daterangepicker-master/date.js"></script>
		<script type="text/javascript" src="bootstrap-daterangepicker-master/daterangepicker.js"></script>
	<!-- end here -->
	 <!-- for google chart api-->
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	
<script type="text/javascript">
   google.load('visualization', '1', {
    'packages': ['geochart']
});
google.setOnLoadCallback(drawMarkersMap);


function drawMarkersMap() {

    var newInfo = google.visualization.arrayToDataTable
(
	[
        ['City','Clicks'],
<?php echo $MAP_SET_NEWChart;?>
/*
['Andhra Pradesh',45],
['Assam',834],
['Bihar',46],
['Jharkhand',86],
['Delhi',11],
['Karnataka',25],
['Kolkata',288],
['Maharashtra',71],
['Goa',31],
['Mumbai',15],
['Arunachal Pradesh',686],
['Manipur',6],
['Meghalaya',28],
['Mizoram',68],
['Orissa',163],
['Punjab',37],
['Rajasthan',24],
['Tamil Nadu',70],*/
  ]
);

        
	  
 var chart_div = new google.visualization.GeoChart(document.getElementById('chart_div'));

    chart_div.draw(newInfo, {
        width: 380,
		height: 240,
        datalessRegionColor: '#efefef',
        tooltip: {
            textStyle: {
                color: 'green'
            },
            showColorCode: false
        },
        displayMode: 'markers',
        region: 'IN',
        resolution: 'provinces'
		
		//colorAxis:{ minValue : 0, maxValue : 1000, colors : ['#800000','#A52A2A']}
    });

    google.visualization.events.addListener(chart_div, 'select', function() {
        var selection = chart_div.getSelection();
        
        // if same city is clicked twice in a row
        // it is "unselected", and selection = []
		/*
        if(typeof selection[0] !== "undefined") {
          var value = newInfo.getValue(selection[0].row, 0);
          alert('City is: ' + value);
        }
		*/
    });

};

 </script>
    </head>
      
    <body onresize="myFunction()">
    <!-- loading animation -->
    <div id="qLoverlay"></div>
    <div id="qLbar"></div>
        
    <div id="header">
        <nav class="navbar navbar-default" role="navigation">
            <div class="navbar-header">
                <!--a class="navbar-brand" href="#">Good Life<span class="slogan">Club</span></a-->
				<img src="Logo2.png" border=0 />
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon16 icomoon-icon-arrow-4"></span>
                </button>
            </div> 
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <!--ul class="nav navbar-nav">
                    <li class="active">
                        <a href="#"><span class="icon16 icomoon-icon-screen-2"></span> <span class="txt">Dashboard</span></a>
                    </li>
                   <?php
				   //include("allcampaginlist.php");
				   ?>
                </ul-->
              <?php
			  include("header_glc.php");
			  ?>
              
            </div><!-- /.nav-collapse -->
        </nav><!-- /navbar --> 

    </div><!-- End #header -->

    <div id="wrapper">

        <!--Responsive navigation button-->  
        <!--div class="resBtn">
            <a href="#"><span class="icon16 minia-icon-list-3"></span></a>
        </div-->
        
        <!--Left Sidebar collapse button-->  
        <div class="collapseBtn leftbar hide-sidebar">
             <a href="#" class="tipR" title="Hide Left Sidebar"><span class="icon12 minia-icon-layout"></span></a>
        </div>

       <!--Body content-->
        <div id="content" class="clearfix">
            <div class="contentwrapper"><!--Content wrapper-->

                <div class="heading">

              <!--h3>Dashboard</h3--> 
<div class="col-lg-8">					
<form id="rangepicker" action="dashboardGLC1.php" method="post">					
  <div id="rangepickerA" class="btn small btn-xs" >Date:
    <!--i class="icon-calendar icon-large"></i-->
    <input type="text" value="<?php if(!$_POST) { echo date("m/d/Y", strtotime('-30 day')); ?> - <?php echo date("m/d/Y");} else { echo date("m/d/Y",strtotime($StartDate))." - ".date("m/d/Y",strtotime($EndDate));}?>" id="rangeA" name="rangeA"  style="font-size: 1.0em;" size="25"/>
</div>
<!--input type="submit" class="btn btn-info" /-->
<button class="btn btn-info btn-xs" href="#">Go</button>
</form>
</div>
<script type="text/javascript">
$('#rangepickerA').daterangepicker(
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
	  $('#rangeA').val(start.toString('MM/dd/yy') + ' - ' + end.toString('MM/dd/yy'));
    }
);
</script>
				                                   


  <div class="search">
                 <span><b></b></span>
</div>
                  
                    
                    <ul class="breadcrumb">
                        <li>You are here:</li>
                        <li>
                            <a href="#">
                                <span class="icon16 icomoon-icon-screen-2"></span>
                            </a> 
                            <span class="divider">
                                <span class="icon16 icomoon-icon-arrow-right-3"></span>
                            </span>
                        </li>
                        <!--li class="active">Dashboard</li-->
						<li class="active">
						 <!--span class="divider">
                                <span class="icon16 icomoon-icon-arrow-right-3">
								
								</span>
                            </span-->
						GLC Dashboard
						</li>
						  
                    </ul>

                </div><!-- End .heading-->

			
				
               <div class="row">

                    <div class="col-lg-8">
                        <div class="centerContent">
                             <ul class="bigBtnIcon">
                                <li>
                                    <a href="#" title="Total Missed calls" class="tipB">
                                        <span class="icon icomoon-icon-users"></span>
                                        <span class="txt">Total Missed Calls</span>
                                        <span class="notification"><?php echo $total_user;?></span>
										<!--span class="notification"><?php echo $total_user_allnew;?></span-->
                                    </a>
                                </li>
                                <li>
                                    <a href="#" title="Total Unique visitors" class="tipB">
                                        <span class="icon icomoon-icon-support"></span>
                                        <span class="txt">Total Unique Visitors</span>
                                        <span class="notification blue"><?php echo $total_unique_user;?></span>
										 <!--span class="notification blue"><?php echo $total_unique_user_allnew;?></span-->
                                    </a>
                                </li>
                                <li>
                                    <a href="#" title="Average Missed calls per user" class="pattern tipB">
                                        <span class="icon icomoon-icon-bubbles-2"></span>
                                        <span class="txt">Average Missed Calls</span>
                                        <span class="notification green"><?php echo $avgmissedperday;?></span>
										<!--span class="notification green"><?php echo $avgmissedperday_allnew;?></span-->
                                    </a>
                                </li>
                                <li>
                                    <a href="#" title="OBD's Attended- Promotional" class="pattern tipB">
                                        <span class="icon icomoon-icon-basket"></span>
                                        <span class="txt">Promotional OBD's Attended</span>
                                        <span class="notification"><?php echo $totalOBD_attended_Promotional;?></span>
                                    </a>
                                </li>
								   <li>
                                    <a href="#" title="Total Minutes consumed through OBD" class="pattern tipB">
                                        <span class="icon icomoon-icon-basket"></span>
                                        <!--span class="txt">Content OBD's attended</span-->
										<span class="txt">Total Minutes Consumed</span>
                                        <span class="notification"><?php echo $totalOBD_attended_Content;?></span>
                                    </a>
                                </li>
                                
                            </ul>
                        </div>
                    </div><!-- End .span8 -->
                    <div class="col-lg-4">
					
                        <div class="centerContent">
                            <div dir="ltr" class="circle-stats">
                                
                                <div class="circular-item tipB" title="Most heard category">
                                    <!--span class="icon icomoon-icon-fire"></span-->
									<span class="icon">
									<img src="images/evergreen.jpg" width="26" height="26" align="center">
									</span>
                                    <input type="text" value="62" class="redCircle" />
                                </div>

                                <div class="circular-item tipB" title="Maximum content consumed by a user">
                                    <span class="icon icomoon-icon-busy"></span>
                                    <input type="text" value="<?= $maxDuration;?>" class="blueCircle" />
                                </div>

                                <div class="circular-item tipB" title="Total people targetted out of 900">
                                    <span class="icon icomoon-icon-target-2"></span>
                                    <input type="text" value="<?php echo $totalOBD_targettd;?>" class="greenCircle" />
                                </div>

                            </div>
                        </div>

                    </div><!-- End .span4 -->
                   <!-- End .span4 -->

                </div><!-- End .row -->

                <div class="row">

                    <div class="col-lg-8">

                        <div class="panel panel-default chart gradient">
                            <div class="panel-heading">
                                <h4>
                                    <span class="icon16 icomoon-icon-bars"></span>
                                    <span>Visitors Chart</span>
                                </h4>
                                <a href="#" class="minimize">Minimize</a>
                            </div>
                            <div class="panel-body" style="padding-bottom:0;">
                               <div class="visitors-chart" style="height: 230px;width:100%;margin-top:15px; margin-bottom:15px;"></div>
                       <ul class="chartShortcuts">
                                    <li>
                                        <a href="#">
                                            <span class="head">Total missed Calls</span>
                                            <span class="number"><?php echo $total_user;?></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <span class="head">Total Unique Visitor</span>
                                            <span class="number"><?php echo $total_unique_user;?></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <span class="head">Today's New Visitor(s)</span>
                                            <span class="number"><?php echo $totalNewUniqueVisitToday;?></span>
                                        </a>
                                    </li>
                                   
                                </ul>
                               
                            </div>

                        </div><!-- End .panel -->

                    </div><!-- End .span8 -->

                    <div class="col-lg-4">

                      <div class="sparkStats">
					  
				             <h4><?php echo $total_user;?> People gave missed call on this campaign <!--a href="#" class="icon tip" title="Configure">
							<span class="icon16 icomoon-icon-cog-2"></span></a--></h4>
                            <ul class="list-unstyled">
							
                                <li><span class="sparkLine_missedCall"></span> Total Missed Calls: <span class="number"><?php echo $total_user;?></span></li>
                                <li><span class="sparkLine_uniqueCall"></span> Total Unique Visitors: <span class="number"><?php echo $total_unique_user;?></span></li>
								<li><span class="sparkLine_AvgMissedCallPerDayCall"></span> Average Missed Calls Per User: <span class="number"><?php echo $avgmissedperday;?></span></li>
								<!--li><span class="sparkLine_missedCall1"></span> % of new visitor: <span class="number"><?php 
								echo $totalnewvisist_percetage_outofuniqueuser;
								?> </span></li-->
								
								<li><!--span class="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								</span-->
				<span class="sparkLine_newVisitor"></span>% Of New Visitor: <span class="number"><?php echo $totalnewvisist_percetage_outofuniqueuser;?></span>
                                </li>
								
								<li><span class="sparkLine_AvgMissedCall"></span> Avg missed Calls/Visitors : <span class="number"><?php echo $missed_calls_peruser;?></span></li>
								 <li title="% of User's who disconnected the OBD within 5 secs" class="pattern tipB"><span class="sparkLine_BounceRate"></span> Bounce Rate: <span class="number"><?php echo $btratePercentage;?>%</span>
                                </li>
								
							</ul>
                           
                        </div><!-- End .sparkStats -->    

                    </div><!-- End .span4 -->
 <!--div class="col-lg-4">

                        <div class="reminder">
                            <h4>Contest consumption - Mins of Usage
                                
                            </h4>
                            <ul>
                                <li class="clearfix">
                                    <div class="icon">
                                        <span class="icon32 icomoon-icon-basket gray"></span>
                                    </div>
                                    <span class="number"></span> 
                                    <span class="txt">Evergreen</span>
                                    
									 <span class="pull-right strong"><span class="number"><?php echo '7';?></span></span>
									
                                </li>
                                
                                
                                <li class="clearfix">
                                    <div class="icon">
                                        <span class="icon32 icomoon-icon-bubbles-2 blue"></span>
                                    </div>
                                    <span class="number"></span> 
                                    <span class="txt">Audio movie</span> 
                                      <span class="pull-right strong"><span class="number"><?php echo '27';?></span></span>
                                </li>
                                
							                                 
                            </ul>
                        </div>

                    </div--><!-- End .span4 -->
                </div><!-- End .row -->

                <div class="row">

                    <div class="col-lg-4">

                        <div class="panel panel-default gradient">

                            <div class="panel-heading">
                                <h4>
                                    <span class="icon16 icomoon-icon-pie"></span>
                                    <span>Visitors overview</span>
                                </h4>
                                <a href="#" class="minimize">Minimize</a>
                            </div>
                            <div class="panel-body">
                               <div class="pieStats" style="height: 270px; width:100%;">

                                </div>
                            </div>

                        </div><!-- End .panel -->

                     
                    </div><!-- End .span4 -->

                    <div class="col-lg-4">
                        <div class="panel panel-default gradient">

                            <div class="panel-heading">
                                <h4>
                                    <span class="icon16 icomoon-icon-thumbs-up"></span>
                                    <span>Content Consumption Split <!--span class="label label-success">
									<span class="icomoon-icon-arrow-up-2 white"></span>1268</span--></span>
                                </h4>
                                <a href="#" class="minimize">Minimize</a>
                            </div>
                            <div class="panel-body">
                              
                                <div class="vital-stats">
								<?php
								$dur1_percetage=percentage($dur1, $total_OBD_DURATION, 2);
								$dur2_percetage=percentage($dur2, $total_OBD_DURATION, 2);
								$dur3_percetage=percentage($dur3, $total_OBD_DURATION, 2);
								$dur4_percetage=percentage($dur4, $total_OBD_DURATION, 2);
								
								function getLabel($dur_percetage)
								{
								if($dur_percetage>30)
								$bar_label='progress-bar-success';
								else if($dur_percetage>20 && $dur_percetage<30)
								$bar_label='progress-bar-warning';
								else if($dur_percetage>10 && $dur_percetage<20)
								$bar_label='progress-bar-danger';
								else if($dur_percetage>0 && $dur_percetage<10)
								$bar_label='';
								return $bar_label;
								}
								$bar_label1=getLabel($dur1_percetage);
								$bar_label2=getLabel($dur2_percetage);
								$bar_label3=getLabel($dur3_percetage);
								$bar_label4=getLabel($dur4_percetage);
								?>
								<ul class="list-unstyled">
                                        <li>
                                            <span class="icon24 icomoon-icon-arrow-up-2 green"></span> 0-10 Sec
                                            <span class="pull-right strong"><?php echo $dur1;?></span>
                                            <div class="progress progress-striped">
                                                <div class="progress-bar <?php echo $bar_label1;?>" style="width: <?php echo $dur1_percetage;?>%;"></div>
                                            </div>
                                        </li>
                                        <li>
                                            <span class="icon24 icomoon-icon-arrow-up-2 green"></span> 11-30 Sec
                                            <span class="pull-right strong"><?php echo $dur2;?></span>
                                            <div class="progress progress-striped ">
                                                <div class="progress-bar <?php echo $bar_label2;?>" style="width: <?php echo $dur2_percetage;?>%;"></div>
                                            </div>
                                        </li>
                                        <li>
                                            <span class="icon24 icomoon-icon-arrow-down-2 red"></span> 31-1 Min
                                            <span class="pull-right strong"><?php echo $dur3;?></span>
                                            <div class="progress progress-striped ">
                                                <div class="progress-bar <?php echo $bar_label3;?>" style="width: <?php echo $dur3_percetage;?>%;"></div>
                                            </div>
                                        </li>
                                        <li>
                                            <span class="icon24 icomoon-icon-arrow-up-2 green"></span>1 Min Above
                                            <span class="pull-right strong"><?php echo $dur4;?></span>
                                            <div class="progress progress-striped ">
                                                <div class="progress-bar <?php echo $bar_label4;?>" style="width: <?php echo $dur4_percetage;?>%;"></div>
                                            </div>
                                        </li>

                                    </ul>
                                </div>

                            </div>

                        </div>
                    </div><!-- End .span4 -->

					                    <!--div class="col-lg-4">

                        <div class="reminder">
                            <h4>Contest consumption - Mins of Usage
                                
                            </h4>
                            <ul>
                                <li class="clearfix">
                                    <div class="icon">
                                        <span class="icon32 icomoon-icon-basket gray"></span>
                                    </div>
                                    <span class="number"></span> 
                                    <span class="txt">Evergreen</span>
                                    
									 <span class="pull-right strong"><span class="number"><?php echo '7';?></span></span>
									
      