<?php
session_start();
include('service_config_Enterprise.php');
$service=$_GET['service_name'];
if(isset($service)){
$service_result=check_services($service);
list($section_dashboard_name,$section_missed,$section_unique,$section_average_missed,$section_total_minute,$section_average_duration,$section_maximum_duration,$section_no_of_obd,$section_new_visitor,$section_content_consumption,$section_chart_map)=$service_result;
include('/var/www/html/hungamacare/missedcall/admin/html/3/db.class.php');
include('/var/www/html/hungamacare/missedcall/admin/html/3/dashboardData.class.php');
$db = new Database();
$dash = new DashboardData();
$a=$db->connect();
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
$StartDate='2014-07-07'; }

if(!isset($EndDate)) {$EndDate= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));}
//class code implement in this interface.
$total_call=$dash->getAllCalls($db,$StartDate,$EndDate,$service);
$total_unique_users=$dash->getAllUniqueUsers($db,$StartDate,$EndDate,$service);
$missedcalls_peruser_class=round($total_call/$total_unique_users);
$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa', 'KAR'=>'Karnataka', 'HAY'=>'Haryana','PUB'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh',''=>'Other');
$cirlceColorCode=array('DEL'=>'88bbc8','GUJ'=>'88bbc8','WBL'=>'ed7a53','BIH'=>'bbdce3','RAJ'=>'9FC569','UPW'=>'bbdce3','MAH'=>'9a3b1b','APD'=>'5a8022','UPE'=>'9FC569','ASM'=>'2c7282','TNU'=>'2c7282','KOL'=>'ed7a53','NES'=>'2c7282','CHN'=>'2c7282','ORI'=>'ed7a53','KAR'=>'2c7282','HAY'=>'9FC569','PUB'=>'2c7282','MUM'=>'9FC569','MPD'=>'2c7282','JNK'=>'9FC569');
$cirlceColorCode2=array('Delhi'=>'88bbc8','Gujarat'=>'88bbc8','WestBengal'=>'ed7a53','Bihar'=>'bbdce3','Rajasthan'=>'9FC569','UP WEST'=>'bbdce3','Maharashtra'=>'9a3b1b','Andhra Pradesh'=>'5a8022','UP EAST'=>'9FC569','Assam'=>'2c7282','Tamil Nadu'=>'2c7282','Kolkata'=>'ed7a53','NE'=>'2c7282','Chennai'=>'2c7282','Orissa'=>'ed7a53','Karnataka'=>'2c7282','Haryana'=>'9FC569','Punjab'=>'2c7282','Mumbai'=>'9FC569','Madhya Pradesh'=>'2c7282','Jammu-Kashmir'=>'9FC569');
$circleNameCode=array('tatm'=>'Tata - Docomo','tatc'=>'Tata - Indicom','airc'=>'Aircel','relm'=>'Reliance-GSM','relc'=>'Reliance-CDMA','vodm'=>'Vodafone','airm'=>'Airtel','unim'=>'Uninor','mtsm'=>'MTS');
$getDashbordChart_missedCallNewChart=$dash->getVisitorsMissedCallsChart($db,$StartDate,$EndDate,$service);
$getDashbordChart_UniqueCallNewChart=$dash->getVisitorsUniqueCallsChart($db,$StartDate,$EndDate,$service);
######################################variable store the value####################33
$dateDiff=$dash->getDateDiff($db,$StartDate,$EndDate,$service);
$agecount=$dash->getTotalAgeVerified($db,$StartDate,$EndDate,$service);
$SongDwcount=$dash->getTotalSongDownload($db,$StartDate,$EndDate,$service);
$Obdcount=$dash->getTotalOBDSend($db,$StartDate,$EndDate,$service);
$MaxDura=$dash->getMaxListenDuration($db,$StartDate,$EndDate,$service);
$totalOBD_attended_Content=$dash->getTotalMinuteConsumesd($db,$StartDate,$EndDate,$service);
$avgListen=$dash->getAvgListenDuration($total_call,$totalOBD_attended_Content);
$totalAdCount_class=$dash->getTotalAdsCount($db,$StartDate,$EndDate,$service);
$totalAge_Verified_class=$dash->getTotalAgeVerified($db,$StartDate,$EndDate,$service);
$alloperatorCount_class=$dash->getVisitorsPieChartCircleWise($db,$StartDate,$EndDate,$service);
$avgmissedperday=$dash->getAvgMissedCallPerDay($total_call,$dateDiff);
$content_split_result=$dash->getContentConsuptionSplit($db,$StartDate,$EndDate,$service);
$missed_call_new_chart=$dash->getmissedcallmcd($db,$StartDate,$EndDate,$service);
$unique_call_new_chart=$dash->getuniquecallmcd($db,$StartDate,$EndDate,$service);
$obd_add_new_chart=$dash->getobdaddmcd($db,$StartDate,$EndDate,$service);
$today_new=$dash->today_new_visitor($db,$service);
list($allAvgMissedCall,$AvgMissedCallPerDay)=$dash->chartmissedcallperday($db,$StartDate,$EndDate,$service);
//require_once("alldataMCD_MIS_rahul.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $section_dashboard_name; ?></title>
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

  ]
);

        
	  
 var chart_div = new google.visualization.GeoChart(document.getElementById('chart_div'));

    chart_div.draw(newInfo, {
       // width: 380,
	//	height: 240,
        datalessRegionColor: 'transparent',
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
 
  <!-- new visitor chart start here-->
  <script type="text/javascript">

window.onload = function () {
    var chart_11 = new CanvasJS.Chart("chartContainer",
    {
      title:{
        text: ""
    },
    axisX:{
        title: "Date",
        gridThickness: 1,
		valueFormatString: "MMM DD YYYY"
    },
    axisY: {
        title: "Total Count"
    },
    data: [
    {        //missed call
        type: "line",
        dataPoints: [
	<?php
	
while($data_missedCallNewChart= mysql_fetch_array($getDashbordChart_missedCallNewChart))
{
$day=$data_missedCallNewChart['day'];
$month=$data_missedCallNewChart['month']-1;
$total_missed_callNew=$data_missedCallNewChart['total'];

?>
{ x: new Date(2014, <?php echo $month;?>, <?php echo $day;?>), y: <?php echo $total_missed_callNew;?>},
<?php
}
?>
  ]
    },
	  {        
        type: "line",
        dataPoints: [
	<?php
	
while($data_uniqueCallNewChart= mysql_fetch_array($getDashbordChart_UniqueCallNewChart))
{
$day1=$data_uniqueCallNewChart['day'];
$month1=$data_uniqueCallNewChart['month']-1;
$total_unique_callNew=$data_uniqueCallNewChart['total_unique'];
?>
{ x: new Date(2014, <?php echo $month1;?>, <?php echo $day1;?>), y: <?php echo $total_unique_callNew;?>},
<?php
}
?>
  ]
    }
    ]
});

    chart_11.render();
}
</script>
<script type="text/javascript" src="js/canvasjs.min.js"></script>
 <!-- end here-->
    </head>
      
    <body onresize="myFunction()">
    <!-- loading animation -->
    <div id="qLoverlay"></div>
    <div id="qLbar"></div>
        
    <div id="header">
        <nav class="navbar navbar-default" role="navigation">
            <div class="navbar-header">
<?php if($service=='EnterpriseMcDw'){ ?><a class="navbar-brand" href="#">McDowell's<span class="slogan"> Missed call Campaign</span></a><?php } elseif($service=='EnterpriseTiscon'){ ?><a class="navbar-brand" href="#">Tata Tiscon<span class="slogan">Campaign</span></a><?php } ?>
				
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
<form id="rangepicker" action="dashboard_MCD_MIS_rahul.php?service_name=<?php echo $service; ?>" method="post">					
  <div id="rangepickerA" class="btn small btn-xs" >Date:
    <!--i class="icon-calendar icon-large"></i-->
    <input type="text" value="<?php if(!$_POST) { echo date("m/d/Y", strtotime($StartDate)); ?> - <?php echo date("m/d/Y",strtotime($EndDate));} else { echo date("m/d/Y",strtotime($StartDate))." - ".date("m/d/Y",strtotime($EndDate));}?>" id="rangeA" name="rangeA"  style="font-size: 1.0em;" size="25"/>
</div>
<!--input type="submit" class="btn btn-info" /-->
<button class="btn btn-info btn-xs" href="#">Go</button>
</form>
</div>
<script type="text/javascript">
$('#rangepickerA').daterangepicker(
    {
        ranges: {
            //'Today': ['today', 'today'],
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
                                <span class="icon16 icomoon-icon-arrow-right-3">43
								
								</span>
                            </span-->
					<?php echo $section_dashboard_name; ?>
						</li>
						  
                    </ul>

                </div><!-- End .heading-->
<div class="row">
<div class="col-lg-8">
                        <div class="centerContent">
                             <ul class="bigBtnIcon">
<?php if($section_missed=='1'){ ?><li>
                                    <a href="#" title="Total Missed calls" class="tipB">
                                        <span class="icon icomoon-icon-users"></span>
                                        <span class="txt">Total Missed Calls</span>
                                        <span class="notification"><?php echo number_format($total_call);?></span>
										
                                    </a>
                                </li>
<?php }if($section_unique=='1'){ ?>
                                <li>
                                    <a href="#" title="Total Unique visitors" class="tipB">
                                        <span class="icon icomoon-icon-support"></span>
                                        <span class="txt">Total Unique Visitors</span>
                                        <span class="notification blue"><?php echo number_format($total_unique_users);?></span>
										
                                    </a>
                                </li>
                                 <?php }if($section_average_missed=='1'){ ?>
                               
                                <li>
                                    <a href="#" title="Average Missed calls per day" class="pattern tipB">
                                        <span class="icon icomoon-icon-bubbles-2"></span>
                                        <span class="txt">Average Missed Calls</span>
                                        <span class="notification green"><?php echo number_format($avgmissedperday);?></span>
										
                                    </a>
                                </li>
                                 <?php }if($section_total_minute=='1'){ ?>
                                  <li>
                                    <a href="#" title="Total Minutes consumed through OBD" class="pattern tipB">
                                        <span class="icon icomoon-icon-basket"></span>
					<span class="txt">Total Minutes Consumed</span>
                                        <span class="notification"><?php echo number_format($totalOBD_attended_Content);?></span>
                                    </a>
                                </li>
                                  <?php }if($section_average_duration=='1'){ ?>
								<li>
                                    <a href="#" title="Average duration of listening" class="pattern tipB">
                                        <span class="icon icomoon-icon-bubbles-2"></span>
                                        <span class="txt">Average Duration Listen</span>
                                        <span class="notification"><?php echo number_format($avgListen);?></span>
                                    </a>
                                </li>
                                   
                                   <?php }if($section_maximum_duration=='1'){ ?>
                                <li>
                                    <a href="#" title="Maximum duration of listening " class="pattern tipB">
                                        <span class="icon icomoon-icon-bubbles-2"></span>
                                        <span class="txt">Maximum Duration Listen</span>
                                        <span class="notification"><?php echo number_format($MaxDura);?></span>
                                    </a>
                                </li>
                                    <?php }if($section_no_of_obd=='1'){ ?>
								  <li>
                                    <a href="#" title="No. of OBD Pushed" class="pattern tipB">
                                        <span class="icon icomoon-icon-bubbles-2"></span>
                                        <span class="txt">No. of OBD Pushed</span>
                                        <span class="notification"><?php echo number_format($Obdcount);?></span>
                                    </a>
                                </li>
                                 <?php } ?>
								<!--li>
                                    <a href="#" title="No. of Song Download" class="pattern tipB">
                                        <span class="icon icomoon-icon-bubbles-2"></span>
                                        <span class="txt">No. of Song Download</span>
                                        <span class="notification"><?php echo number_format($totalSong_Downloaded);?></span>
                                    </a>
                                </li>
								<li>
                                    <a href="#" title="Age verified, when user presses *" class="pattern tipB">
                                        <span class="icon icomoon-icon-bubbles-2"></span>
                                        <span class="txt">Total Age verified</span>
                                        <span class="notification"><?php echo number_format($totalAge_Verified);?></span>
                                    </a>
                                </li-->
                            </ul>
                        </div>
                    </div>
					
					
					
					<!-- End .span8 -->
                    <div class="col-lg-4">
					
 <div class="centerContent">
                            <div dir="ltr" class="circle-stats">
 <div class="circular-item tipB" title="Total missed calls received">
<a href="exportMCDowellData.php?StartDate=<?php echo $StartDate;?>&EndDate=<?php echo $EndDate;?>&type=missedcall"><span class="icon icomoon-icon-download-2"></span></a>
<input type="hidden" value="89" class="greenCircle" />
 </div>
<div class="circular-item tipB" title="Usage of content per MDN on OBD">
                                   <a href="exportMCDowellData.php?StartDate=<?php echo $StartDate;?>&EndDate=<?php echo $EndDate;?>&type=content"> <span class="icon icomoon-icon-download"></span></a>
                                    <input type="hidden" value="97" class="blueCircle" />
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
<table style="position:absolute;top:-17px;right:5px;;font-size:smaller;color:#3f3f3f"><tbody><tr><td class="legendColorBox"><div style="border:1px solid null;padding:1px"><div style="width:4px;height:0;border:5px solid rgb(136,187,200);overflow:hidden"></div></div></td><td class="legendLabel">Missed Calls&nbsp;&nbsp;</td><td class="legendColorBox"><div style="border:1px solid null;padding:1px"><div style="width:4px;height:0;border:5px solid rgb(237,122,83);overflow:hidden"></div></div></td><td class="legendLabel">Total unique Visitors&nbsp;&nbsp;</td></tr></tbody></table>
                               <!--div class="visitors-chart" style="height: 230px;width:100%;margin-top:15px; margin-bottom:15px;"></div-->
							  
							    <div id="chartContainer" style="height: 230px;width:100%;margin-top:15px; margin-bottom:15px;"></div>
                       <ul class="chartShortcuts">
                           <?php  if($section_missed=='1'){ ?>
                                    <li>
                                        <a href="#">
                                            <span class="head">Total missed Calls</span>
                                       <span style="font-size:18px;color:#ed7a53;font-weight:700;"><?php echo number_format($total_call); ?></span>
                                        </a>
                                    </li>
                           <?php } if($section_unique=='1'){ ?>
                                    <li>
                                        <a href="#">
                                            <span class="head">Total Unique Visitor</span>
                                            <span style="font-size:18px;color:#ed7a53;font-weight:700;"><?php 
                                             echo number_format($total_unique_users);
                                            ?></span>
                                        </a>
                                    </li>
                           <?php }if($section_new_visitor=='1'){ ?>
                                    <li>
                                        <a href="#">
                                            <span class="head">Today's New Visitor(s)</span>
                                            <span style="font-size:18px;color:#ed7a53;font-weight:700;"><?php echo number_format($today_new);?></span>
                                        </a>
                                    </li>
                           <?php } ?>
                                   
                                </ul>
                               
                            </div>

                        </div><!-- End .panel -->

                    </div><!-- End .span8 -->

                    <div class="col-lg-4">

                      <div class="sparkStats">
					  
<h4><?php echo $total_call;?> People gave missed call on this campaign </h4>
<ul class="list-unstyled">
<?php  if($section_missed=='1'){ ?><li><span class="sparkLine_missedCall"></span> Total Missed Calls: <span class="number"><?php echo number_format($total_call);?></span></li><?php } if($section_unique=='1'){ ?>
<li><span class="sparkLine_uniqueCall"></span> Total Unique Visitors: <span class="number"><?php echo number_format($total_unique_users);?></span></li><?php } ?>
<li><span class="sparkLine_AvgMissedCallPerDayCall"></span> Average Missed Calls Per Day: <span class="number"><?php echo number_format($avgmissedperday);?></span></li>
<li><span class="sparkLine_AvgMissedCall"></span> Avg missed Calls/Visitors : <span class="number"><?php echo number_format($missedcalls_peruser_class);?></span></li>
<li><span class="sparkLine_adsChart"></span> Total Ad Impression: <span class="number"><?php echo number_format($totalAdCount_class);?></span></li>
<?php if(number_format($totalAge_Verified_class)!='0'){ ?><li><span class=""></span> Total Age verified (when user presses *): <span class="number"><?php echo number_format($totalAge_Verified_class);?></span></li><?php } ?>
<?php if(number_format($SongDwcount)!='0'){ ?><li><span class=""></span> No. of Song Download: <span class="number"><?php echo number_format($SongDwcount);?></span></li><?php } ?>
<!--li><span class=""></span> Promotional OBD: <span class="number"><?php echo number_format($totalPromoOBD_targettd);?></span></li>
<li><span class=""></span> Promotional OBD Pulse: <span class="number"><?php echo number_format($totalPromoOBDPulse_targettd);?></span></li-->
													
							</ul>
                           
                        </div><!-- End .sparkStats -->    

                    </div><!-- End .span4 -->

                </div><!-- End .row -->

                
                
                <div class="row">
                    
<?php if($section_content_consumption=='1') {?>
                    <div class="col-lg-4">
                        <div class="panel panel-default gradient">

                            <div class="panel-heading">
                                <h4>
                                    <span class="icon16 icomoon-icon-thumbs-up"></span>
                                    <span>Content Consumption Split <!--#############modified function here#############--></span>
                                </h4>
                                <a href="#" class="minimize">Minimize</a>
                            </div>
                            <div class="panel-body">
                              
<div class="vital-stats">
<?php
$split_check=explode('#',$content_split_result);
$total_OBD_DURATION= $split_check[0];
$dur1_percetage=$dash->percentage($split_check[1], $total_OBD_DURATION, 2);
$dur2_percetage=$dash->percentage($split_check[2], $total_OBD_DURATION, 2);
$dur3_percetage=$dash->percentage($split_check[3], $total_OBD_DURATION, 2);
$dur4_percetage=$dash->percentage($split_check[4], $total_OBD_DURATION, 2);
$dur5_percetage=$dash->percentage($split_check[5], $total_OBD_DURATION, 2);
$dur6_percetage=$dash->percentage($split_check[6], $total_OBD_DURATION, 2);
$bar_label1=$dash->getLabel($dur1_percetage);
$bar_label2=$dash->getLabel($dur2_percetage);
$bar_label3=$dash->getLabel($dur3_percetage);
$bar_label4=$dash->getLabel($dur4_percetage);
$bar_label5=$dash->getLabel($dur5_percetage);
$bar_label6=$dash->getLabel($dur6_percetage);
?>
<?php include('content_split_rahul.php'); ?></div></div>

                        </div>
                    </div><!-- End .span4 -->
<?php } if($section_chart_map==1){ ?>
					
					
					    <div class="col-lg-4">
                        <div class="panel panel-default gradient">

                            <div class="panel-heading">
                                <h4>
                                    <span class="icon16 icomoon-icon-thumbs-up"></span>
                                    <span>India Map</span>
                                </h4>
                                <a href="#" class="minimize">Minimize</a>
                            </div>
                            <div class="panel-body">
                              
                               <div class="vital-stats" style="padding-bottom:32px">
								<!-- India Map -->
							<div class="pieStats" style="height:270px; width:100%;"></div>
                                </div>

                            </div>

                        </div>
                    </div><!-- End .span4 -->
                    <?php } ?>
					
					
                                  
            </div><!-- End contentwrapper -->
        </div><!-- End #content -->
    
    </div><!-- End #wrapper -->
    
    <!-- Le javascript
    
    create chart by function
    ================================================== -->
    <!-- Important plugins put in all pages -->
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
    <script type="text/javascript" src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="js/bootstrap/bootstrap.js"></script>  
    <script type="text/javascript" src="js/jquery.mousewheel.js"></script>
    <script type="text/javascript" src="js/libs/jRespond.min.js"></script>

    <!-- Charts plugins -->
    <script type="text/javascript" src="plugins/charts/flot/jquery.flot.js"></script>
    <script type="text/javascript" src="plugins/charts/flot/jquery.flot.grow.js"></script>
    <script type="text/javascript" src="plugins/charts/flot/jquery.flot.pie.js"></script>
    <script type="text/javascript" src="plugins/charts/flot/jquery.flot.resize.js"></script>
    <script type="text/javascript" src="plugins/charts/flot/jquery.flot.tooltip_0.4.4.js"></script>
    <script type="text/javascript" src="plugins/charts/flot/jquery.flot.orderBars.js"></script>
    <script type="text/javascript" src="plugins/charts/sparkline/jquery.sparkline.min.js"></script><!-- Sparkline plugin -->
    <script type="text/javascript" src="plugins/charts/knob/jquery.knob.js"></script><!-- Circular sliders and stats -->

    <!-- Misc plugins -->
    <script type="text/javascript" src="plugins/misc/fullcalendar/fullcalendar.min.js"></script><!-- Calendar plugin -->
    <script type="text/javascript" src="plugins/misc/qtip/jquery.qtip.min.js"></script><!-- Custom tooltip plugin -->
    <script type="text/javascript" src="plugins/misc/totop/jquery.ui.totop.min.js"></script> <!-- Back to top plugin -->
    
    <!-- Search plugin -->
    <script type="text/javascript" src="plugins/misc/search/tipuesearch_set.js"></script>
    <script type="text/javascript" src="plugins/misc/search/tipuesearch_data.js"></script><!-- JSON for searched results -->
    <script type="text/javascript" src="plugins/misc/search/tipuesearch.js"></script>

    <!-- Form plugins -->
    <script type="text/javascript" src="plugins/forms/uniform/jquery.uniform.min.js"></script>
    
    <!-- Init plugins -->
    <script type="text/javascript" src="js/main.js"></script><!-- Core js functions -->
    <!--script type="text/javascript" src="js/dashboard.js"></script--><!-- Init plugins only for page -->

	<script type="text/javascript">
	// document ready function
function myFunction()
{

var w=window.outerWidth;
var h=window.outerHeight;
$( "#content" ).addClass( "clearfix hided" );
}
$(document).ready(function() { 	
	$( ".tipR" ).click();
	$( ".tipR" ).hide();


	//circular progrress bar
	$(function () {

		$(".greenCircle").knob({
            'min':0,
            'max':1000,
            'readOnly': true,
            'width': 80,
            'height': 80,
            'fgColor': '#9FC569',
            'dynamicDraw': true,
            'thickness': 0.2,
            'tickColorizeValues': true
        })
        $(".redCircle").knob({
            'min':0,
            'max':100,
            'readOnly': true,
            'width': 80,
            'height': 80,
            'fgColor': '#ED7A53',
            'dynamicDraw': true,
            'thickness': 0.2,
            'tickColorizeValues': true
        })
        $(".blueCircle").knob({
            'min':0,
            'max':500,
            'readOnly': true,
            'width': 80,
            'height': 80,
            'fgColor': '#88BBC8',
            'dynamicDraw': true,
            'thickness': 0.2,
            'tickColorizeValues': true
        })

	});

	var divElement = $('div'); //log all div elements

	//------------- Visitor chart -------------//

    //pie visits graph
	if (divElement.hasClass('pieStats')) {
	$(function () {
	   var data = [
	   <?php
           
          
          
           foreach($alloperatorCount_class as $cpname=>$cpTotalcount)
	   { 
	   ?>
{ label: " <?php echo $cpname;?>",  data: <?php echo $cpTotalcount;?>, color: "#<?php echo $cirlceColorCode2[$cpname]?>"},
<?php } ?>
		];
		
		$.plot($(".pieStats"), data, 
		{
			series: {
				pie: { 
					show: true,
					highlight: {
						opacity: 0.1
					},
					radius: 1,
					stroke: {
						color: '#fff',
						width: 2
					},
					startAngle: 2,
					combine: {
	                    color: '#353535',
	                    threshold: 0.05
	                },
	                label: {
	                    show: true,
	                    radius: 1,
	                    formatter: function(label, series){
	                        return '<div class="pie-chart-label">'+label+'&nbsp;'+Math.round(series.percent)+'%</div>';
	                    }
	                }				},
				grow: {	active: false}
			},
			legend: { 
	        	show:false
	    	},
			grid: {
	            hoverable: true,
	            clickable: true
	        },
	        tooltip: true, //activate tooltip
			tooltipOpts: {
				content: "%s : %y.1"+"%",
				shifts: {
					x: -30,
					y: -50
				}
			}
		});
	});
	}//end if

});//End document ready functions


//generate random number for charts
randNum = function(){
	//return Math.floor(Math.random()*101);
	return (Math.floor( Math.random()* (1+40-20) ) ) + 20;
}

var chartColours = ['#88bbc8', '#ed7a53', '#9FC569', '#bbdce3', '#9a3b1b', '#5a8022', '#2c7282'];
var data = <?php echo $missed_call_new_chart;?>;
//var data = [[1, 0], [2, <?php echo $total_call?>]];
//alert(data);
 	placeholder = '.sparkLine_missedCall';
	$(placeholder).sparkline(data, { 
		width: 100,//Width of the chart - Defaults to 'auto' - May be any valid css width - 1.5em, 20px, etc (using a number without a unit specifier won't do what you want) - This option does nothing for bar and tristate chars (see barWidth)
		height: 30,//Height of the chart - Defaults to 'auto' (line height of the containing tag)
		lineColor: '#88bbc8',//Used by line and discrete charts to specify the colour of the line drawn as a CSS values string
		fillColor: '#f2f7f9',//Specify the colour used to fill the area under the graph as a CSS value. Set to false to disable fill
		spotColor: '#467e8c',//The CSS colour of the final value marker. Set to false or an empty string to hide it
		maxSpotColor: '#9FC569',//The CSS colour of the marker displayed for the maximum value. Set to false or an empty string to hide it
		minSpotColor: '#ED7A53',//The CSS colour of the marker displayed for the mimum value. Set to false or an empty string to hide it
		spotRadius: 3,//Radius of all spot markers, In pixels (default: 1.5) - Integer
		lineWidth: 2//In pixels (default: 1) - Integer
	});
	
	var data = <?php echo $unique_call_new_chart;?>;
 	placeholder = '.sparkLine_uniqueCall';
	$(placeholder).sparkline(data, { 
		width: 100,//Width of the chart - Defaults to 'auto' - May be any valid css width - 1.5em, 20px, etc (using a number without a unit specifier won't do what you want) - This option does nothing for bar and tristate chars (see barWidth)
		height: 30,//Height of the chart - Defaults to 'auto' (line height of the containing tag)
		lineColor: '#88bbc8',//Used by line and discrete charts to specify the colour of the line drawn as a CSS values string
		fillColor: '#f2f7f9',//Specify the colour used to fill the area under the graph as a CSS value. Set to false to disable fill
		spotColor: '#467e8c',//The CSS colour of the final value marker. Set to false or an empty string to hide it
		maxSpotColor: '#9FC569',//The CSS colour of the marker displayed for the maximum value. Set to false or an empty string to hide it
		minSpotColor: '#ED7A53',//The CSS colour of the marker displayed for the mimum value. Set to false or an empty string to hide it
		spotRadius: 3,//Radius of all spot markers, In pixels (default: 1.5) - Integer
		lineWidth: 2//In pixels (default: 1) - Integer
	});
	
	/*var data = <?php echo $allAvgMissedCall;?>;
 	placeholder = '.sparkLine_AvgMissedCall';
	$(placeholder).sparkline(data, { 
		width: 100,//Width of the chart - Defaults to 'auto' - May be any valid css width - 1.5em, 20px, etc (using a number without a unit specifier won't do what you want) - This option does nothing for bar and tristate chars (see barWidth)
		height: 30,//Height of the chart - Defaults to 'auto' (line height of the containing tag)
		lineColor: '#88bbc8',//Used by line and discrete charts to specify the colour of the line drawn as a CSS values string
		fillColor: '#f2f7f9',//Specify the colour used to fill the area under the graph as a CSS value. Set to false to disable fill
		spotColor: '#467e8c',//The CSS colour of the final value marker. Set to false or an empty string to hide it
		maxSpotColor: '#9FC569',//The CSS colour of the marker displayed for the maximum value. Set to false or an empty string to hide it
		minSpotColor: '#ED7A53',//The CSS colour of the marker displayed for the mimum value. Set to false or an empty string to hide it
		spotRadius: 3,//Radius of all spot markers, In pixels (default: 1.5) - Integer
		lineWidth: 2//In pixels (default: 1) - Integer
	});
     */
	
	var data = <?php echo $AvgMissedCallPerDay;?>;
 	placeholder = '.sparkLine_AvgMissedCallPerDayCall';
	$(placeholder).sparkline(data, { 
		width: 100,//Width of the chart - Defaults to 'auto' - May be any valid css width - 1.5em, 20px, etc (using a number without a unit specifier won't do what you want) - This option does nothing for bar and tristate chars (see barWidth)
		height: 30,//Height of the chart - Defaults to 'auto' (line height of the containing tag)
		lineColor: '#88bbc8',//Used by line and discrete charts to specify the colour of the line drawn as a CSS values string
		fillColor: '#f2f7f9',//Specify the colour used to fill the area under the graph as a CSS value. Set to false to disable fill
		spotColor: '#467e8c',//The CSS colour of the final value marker. Set to false or an empty string to hide it
		maxSpotColor: '#9FC569',//The CSS colour of the marker displayed for the maximum value. Set to false or an empty string to hide it
		minSpotColor: '#ED7A53',//The CSS colour of the marker displayed for the mimum value. Set to false or an empty string to hide it
		spotRadius: 3,//Radius of all spot markers, In pixels (default: 1.5) - Integer
		lineWidth: 2//In pixels (default: 1) - Integer
	});
	
	/*var data = <?php echo $chartbouncRateArray;?>;
 	placeholder = '.sparkLine_BounceRate';
	$(placeholder).sparkline(data, { 
		width: 100,//Width of the chart - Defaults to 'auto' - May be any valid css width - 1.5em, 20px, etc (using a number without a unit specifier won't do what you want) - This option does nothing for bar and tristate chars (see barWidth)
		height: 30,//Height of the chart - Defaults to 'auto' (line height of the containing tag)
		lineColor: '#88bbc8',//Used by line and discrete charts to specify the colour of the line drawn as a CSS values string
		fillColor: '#f2f7f9',//Specify the colour used to fill the area under the graph as a CSS value. Set to false to disable fill
		spotColor: '#467e8c',//The CSS colour of the final value marker. Set to false or an empty string to hide it
		maxSpotColor: '#9FC569',//The CSS colour of the marker displayed for the maximum value. Set to false or an empty string to hide it
		minSpotColor: '#ED7A53',//The CSS colour of the marker displayed for the mimum value. Set to false or an empty string to hide it
		spotRadius: 3,//Radius of all spot markers, In pixels (default: 1.5) - Integer
		lineWidth: 2//In pixels (default: 1) - Integer
	});
	
	var data = <?php echo $chartOBDNewVisitarray21;?>;
 	placeholder = '.sparkLine_newVisitor';
	$(placeholder).sparkline(data, { 
		width: 100,//Width of the chart - Defaults to 'auto' - May be any valid css width - 1.5em, 20px, etc (using a number without a unit specifier won't do what you want) - This option does nothing for bar and tristate chars (see barWidth)
		height: 30,//Height of the chart - Defaults to 'auto' (line height of the containing tag)
		lineColor: '#88bbc8',//Used by line and discrete charts to specify the colour of the line drawn as a CSS values string
		fillColor: '#f2f7f9',//Specify the colour used to fill the area under the graph as a CSS value. Set to false to disable fill
		spotColor: '#467e8c',//The CSS colour of the final value marker. Set to false or an empty string to hide it
		maxSpotColor: '#9FC569',//The CSS colour of the marker displayed for the maximum value. Set to false or an empty string to hide it
		minSpotColor: '#ED7A53',//The CSS colour of the marker displayed for the mimum value. Set to false or an empty string to hide it
		spotRadius: 3,//Radius of all spot markers, In pixels (default: 1.5) - Integer
		lineWidth: 2//In pixels (default: 1) - Integer
	});*/
	
	var data = <?php echo $obd_add_new_chart;?>;
 	placeholder = '.sparkLine_adsChart';
	$(placeholder).sparkline(data, { 
		width: 100,//Width of the chart - Defaults to 'auto' - May be any valid css width - 1.5em, 20px, etc (using a number without a unit specifier won't do what you want) - This option does nothing for bar and tristate chars (see barWidth)
		height: 30,//Height of the chart - Defaults to 'auto' (line height of the containing tag)
		lineColor: '#88bbc8',//Used by line and discrete charts to specify the colour of the line drawn as a CSS values string
		fillColor: '#f2f7f9',//Specify the colour used to fill the area under the graph as a CSS value. Set to false to disable fill
		spotColor: '#467e8c',//The CSS colour of the final value marker. Set to false or an empty string to hide it
		maxSpotColor: '#9FC569',//The CSS colour of the marker displayed for the maximum value. Set to false or an empty string to hide it
		minSpotColor: '#ED7A53',//The CSS colour of the marker displayed for the mimum value. Set to false or an empty string to hide it
		spotRadius: 3,//Radius of all spot markers, In pixels (default: 1.5) - Integer
		lineWidth: 2//In pixels (default: 1) - Integer
	});
</script>
    </body>
	
</html>
<?php }else{ echo "<div align='center'><h2>you pass bad request</h2></div>" ; exit(); } ?>