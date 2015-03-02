<?php
session_start();
require_once("../../../db.php");
ini_set('session.gc_maxlifetime', 3*24*60*60);

if (empty($_SESSION['loginId'])) {
    session_destroy();
    Header("location:index.php?ERROR=502");
}
$page = $_SERVER['PHP_SELF'];
if (isset($_POST['rangeA'])) {
    list($o_F, $o_T) = explode(" - ", $_POST['rangeA']);
    list($o_T_M, $o_T_D, $o_T_Y) = explode("/", $o_T);
    list($o_F_M, $o_F_D, $o_F_Y) = explode("/", $o_F);
    $EndDate = date("Y-m-d", mktime(0, 0, 0, $o_T_M, $o_T_D, $o_T_Y));
    $StartDate = date("Y-m-d", mktime(0, 0, 0, $o_F_M, $o_F_D, $o_F_Y));
}
if (!isset($StartDate)) {
    //$StartDate= date("Y-m-d",mktime(0,0,0,date("m")-1,date("d"),date("Y")));
    $StartDate = '2014-02-28';
}

if (!isset($EndDate)) {

    $EndDate = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
}
$circle_info = array('DEL' => 'Delhi', 'GUJ' => 'Gujarat', 'WBL' => 'WestBengal', 'BIH' => 'Bihar', 'RAJ' => 'Rajasthan', 'UPW' => 'UP WEST', 'MAH' => 'Maharashtra', 'APD' => 'Andhra Pradesh', 'UPE' => 'UP EAST', 'ASM' => 'Assam', 'TNU' => 'Tamil Nadu', 'KOL' => 'Kolkata', 'NES' => 'NE', 'CHN' => 'Chennai', 'ORI' => 'Orissa', 'KAR' => 'Karnataka', 'HAY' => 'Haryana', 'PUB' => 'Punjab', 'MUM' => 'Mumbai', 'MPD' => 'Madhya Pradesh', 'JNK' => 'Jammu-Kashmir', 'PUB' => "Punjab", 'KER' => 'Kerala', 'HPD' => 'Himachal Pradesh', '' => 'Other');

require_once("alldataGLC1.php");

$getDashbordChart_missedCallNewChart = "select count(*) as total, day(date_time) as day,Month(date_time) as month
from hul_hungama.tbl_hul_pushobd_sub nolock  where date(date_time) between '" . $StartDate . "' and '" . $EndDate . "' and ANI!='' and service='HUL' group by date(date_time) order by Month(date_time),day ASC";
$query_missedCallNewChart = mysql_query($getDashbordChart_missedCallNewChart, $con);

$getDashbordChart_UniqueCallNewChart = "select count(distinct(ANI)) as total_unique,day(date_time) as day,Month(date_time) as month
from hul_hungama.tbl_hul_pushobd_sub nolock  where date(date_time) between '" . $StartDate . "' and '" . $EndDate . "' and ANI!='' and service='HUL' group by date(date_time) order by Month(date_time),day ASC";
$query_uniqueCallNewChart = mysql_query($getDashbordChart_UniqueCallNewChart, $con);
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
<!--        <meta http-equiv="refresh" content="600;URL='<?php echo $page ?>'">-->


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
<?php echo $MAP_SET_NEWChart; ?>
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
                            gridThickness: 0.3
                        },
                        axisY: {
                            title: "Total Count"
                        },
                        data: [
                            {        //missed call
                                type: "line",
                                dataPoints: [
<?php
while ($data_missedCallNewChart = mysql_fetch_array($query_missedCallNewChart)) {
    $day = $data_missedCallNewChart['day'];
    $month = $data_missedCallNewChart['month'] - 1;
    $total_missed_callNew = $data_missedCallNewChart['total'];
    ?>
                                    { x: new Date(2014, <?php echo $month; ?>, <?php echo $day; ?>), y: <?php echo $total_missed_callNew; ?>},
    <?php
}
?>
                        ]
                    },
                    {        
                        type: "line",
                        dataPoints: [
<?php
while ($data_uniqueCallNewChart = mysql_fetch_array($query_uniqueCallNewChart)) {
    $day1 = $data_uniqueCallNewChart['day'];
    $month1 = $data_uniqueCallNewChart['month'] - 1;
    $total_unique_callNew = $data_uniqueCallNewChart['total_unique'];
    ?>
                                    { x: new Date(2014, <?php echo $month1; ?>, <?php echo $day1; ?>), y: <?php echo $total_unique_callNew; ?>},
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
                                    <input type="text" value="<?php
                    if (!$_POST) {
                        echo date("m/d/Y", strtotime('-30 day'));
                        ?> - <?php
                                           echo date("m/d/Y");
                                       } else {
                                           echo date("m/d/Y", strtotime($StartDate)) . " - " . date("m/d/Y", strtotime($EndDate));
                                       }
                    ?>" id="rangeA" name="rangeA"  style="font-size: 1.0em;" size="25"/>
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
                                        <a href="exportGLCData.php?StartDate=<?php echo $StartDate; ?>&EndDate=<?php echo $EndDate; ?>&type=total_missed_call" title="Total Missed calls" class="tipB">
                                            <span class="icon icomoon-icon-users"></span>
                                            <span class="txt">Total Missed Calls</span>
                                            <span class="notification"><?php echo $total_user; ?></span>
                                                                                    <!--span class="notification"><?php echo $total_user_allnew; ?></span-->
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" title="Total Unique visitors" class="tipB">
                                            <span class="icon icomoon-icon-support"></span>
                                            <span class="txt">Total Unique Visitors</span>
                                            <span class="notification blue"><?php echo $total_unique_user; ?></span>
                                                                                     <!--span class="notification blue"><?php echo $total_unique_user_allnew; ?></span-->
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" title="Average Missed calls per user" class="pattern tipB">
                                            <span class="icon icomoon-icon-bubbles-2"></span>
                                            <span class="txt">Average Missed Calls</span>
                                            <span class="notification green"><?php echo $avgmissedperday; ?></span>
                                                                                    <!--span class="notification green"><?php echo $avgmissedperday_allnew; ?></span-->
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" title="OBD's Attended- Promotional" class="pattern tipB">
                                            <span class="icon icomoon-icon-basket"></span>
                                            <span class="txt">Promotional OBD's Attended</span>
                                            <span class="notification"><?php echo $totalOBD_attended_Promotional; ?></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="exportGLCData.php?StartDate=<?php echo $StartDate; ?>&EndDate=<?php echo $EndDate; ?>&type=total_minutes_consumed" title="Total Minutes consumed through OBD" class="pattern tipB">
                                            <span class="icon icomoon-icon-basket"></span>
                                            <!--span class="txt">Content OBD's attended</span-->
                                            <span class="txt">Total Minutes Consumed</span>
                                            <span class="notification"><?php echo $totalOBD_attended_Content; ?></span>
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
<!--						 <a href="exportGLCData.php?StartDate=<?php echo $StartDate; ?>&EndDate=<?php echo $EndDate; ?>&type=most_heared_category">	-->
                                            <img src="images/evergreen.jpg" width="26" height="26" align="center">
                                                <!--                                                 </a>-->
                                        </span>
                                        <input type="text" value="62" class="redCircle" />
                                    </div>

                                    <div class="circular-item tipB" title="Maximum content consumed by a user">
                                        <span class="icon icomoon-icon-busy"></span>
    <!--                                    <a href="exportGLCData.php?StartDate=<?php echo $StartDate; ?>&EndDate=<?php echo $EndDate; ?>&type=most_heared_category" class="blueCircle" >
                                             <span class="notification"><?php echo $maxDuration; ?></span>
                                        </a>-->
                                        <input type="text" value="<?= $maxDuration; ?>" class="blueCircle" />
                                    </div>
                                    <?php
                                    $total_OBDUSer = 900;
                                    $OBDTargettedpercetage = ceil(percentage($totalOBD_targettd, $total_OBDUSer, 2));
                                    ?>
                                    <div class="circular-item tipB" title="Total people targetted">
                                        <!--span class="icon icomoon-icon-target-2"></span-->
                                        <span class="icon">
                                            <a href="exportGLCData.php?StartDate=<?php echo $StartDate; ?>&EndDate=<?php echo $EndDate; ?>&type=total_people_targeted">	
                                                %
                                            </a>
                                        </span>
                                        <input type="text" value="<?php echo $OBDTargettedpercetage; ?>" class="greenCircle" />
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
                                    <!--div class="visitors-chart" style="height: 230px;width:100%;margin-top:15px; margin-bottom:15px;"></div-->
                                    <table style="position:absolute;top:-17px;right:5px;;font-size:smaller;color:#3f3f3f"><tbody><tr><td class="legendColorBox"><div style="border:1px solid null;padding:1px"><div style="width:4px;height:0;border:5px solid rgb(136,187,200);overflow:hidden"></div></div></td><td class="legendLabel">Missed Calls&nbsp;&nbsp;</td><td class="legendColorBox"><div style="border:1px solid null;padding:1px"><div style="width:4px;height:0;border:5px solid rgb(237,122,83);overflow:hidden"></div></div></td><td class="legendLabel">Total unique Visitors&nbsp;&nbsp;</td></tr></tbody></table>
                                    <div id="chartContainer" style="height:230px;width:100%;margin-top:15px; margin-bottom:15px;"></div>
                                    <ul class="chartShortcuts">
                                        <li>
                                            <a href="#">
                                                <span class="head">Total missed Calls</span>
                                                <span class="number"><?php echo $total_user; ?></span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <span class="head">Total Unique Visitor</span>
                                                <span class="number"><?php echo $total_unique_user; ?></span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <span class="head">Today's New Visitor(s)</span>
                                                <span class="number"><?php echo $totalNewUniqueVisitToday; ?></span>
                                            </a>
                                        </li>

                                    </ul>

                                </div>

                            </div><!-- End .panel -->

                        </div><!-- End .span8 -->

                        <div class="col-lg-4">

                            <div class="sparkStats">

                                <h4><?php echo $total_user; ?> People gave missed call on this campaign <!--a href="#" class="icon tip" title="Configure">
                                           <span class="icon16 icomoon-icon-cog-2"></span></a--></h4>
                                <ul class="list-unstyled">

                                    <li><span class="sparkLine_missedCall"></span> Total Missed Calls: <span class="number"><?php echo $total_user; ?></span></li>
                                    <li><span class="sparkLine_uniqueCall"></span> Total Unique Visitors: <span class="number"><?php echo $total_unique_user; ?></span></li>
    <!--								<li><span class="sparkLine_AvgMissedCallPerDayCall"></span> Average Missed Calls Per User: <span class="number"><?php echo $avgmissedperday; ?></span></li>-->
                                                                    <!--li><span class="sparkLine_missedCall1"></span> % of new visitor: <span class="number"><?php
                                    echo $totalnewvisist_percetage_outofuniqueuser;
                                    ?> </span></li-->

                                    <!--								<li>span class="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                                    </span
                                                                    <span class="sparkLine_newVisitor"></span>% Of New Visitor: <span class="number"><?php echo $totalnewvisist_percetage_outofuniqueuser; ?></span>
                                                                    </li>-->

                                    <li><span class="sparkLine_AvgMissedCall"></span> Avg missed Calls/Visitors : <span class="number"><?php echo $missed_calls_peruser; ?></span></li>
                                     <!--li title="% of User's who disconnected the OBD within 5 secs" class="pattern tipB"><span class="sparkLine_BounceRate"></span> Bounce Rate: <span class="number"><?php echo $btratePercentage; ?>%</span>
    </li-->

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
                                                           
                                                                                                <span class="pull-right strong"><span class="number"><?php echo '7'; ?></span></span>
                                                                                               
                                                       </li>
                                                       
                                                       
                                                       <li class="clearfix">
                                                           <div class="icon">
                                                               <span class="icon32 icomoon-icon-bubbles-2 blue"></span>
                                                           </div>
                                                           <span class="number"></span> 
                                                           <span class="txt">Audio movie</span> 
                                                             <span class="pull-right strong"><span class="number"><?php echo '27'; ?></span></span>
                                                       </li>
                                                       
                                                                                                                
                                                   </ul>
                                               </div>
                       
                                           </div--><!-- End .span4 -->
                    </div><!-- End .row -->

                    <div class="row">

                        <!--       <div class="col-lg-4">
       
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
       
                                   </div> End .panel
       
       
                               </div><!-- End .span4  -->

                        <div class="col-lg-4">
                            <div class="panel panel-default gradient">

                                <div class="panel-heading">
                                    <h4>
                                        <span class="icon16 icomoon-icon-thumbs-up"></span>
                                        <span>Content Consumption Split(Per user) <!--span class="label label-success">
                                                                            <span class="icomoon-icon-arrow-up-2 white"></span>1268</span--></span>
                                    </h4>
                                    <a href="#" class="minimize">Minimize</a>
                                </div>
                                <div class="panel-body">

                                    <div class="vital-stats">
                                        <?php
                                        $dur1_percetage = percentage($dur1, $total_OBD_DURATION, 2);
                                        $dur2_percetage = percentage($dur2, $total_OBD_DURATION, 2);
                                        $dur3_percetage = percentage($dur3, $total_OBD_DURATION, 2);
                                        $dur4_percetage = percentage($dur4, $total_OBD_DURATION, 2);

                                        function getLabel($dur_percetage) {
                                            if ($dur_percetage > 30)
                                                $bar_label = 'progress-bar-success';
                                            else if ($dur_percetage > 20 && $dur_percetage < 30)
                                                $bar_label = 'progress-bar-warning';
                                            else if ($dur_percetage > 10 && $dur_percetage < 20)
                                                $bar_label = 'progress-bar-danger';
                                            else if ($dur_percetage > 0 && $dur_percetage < 10)
                                                $bar_label = '';
                                            return $bar_label;
                                        }

                                        $bar_label1 = getLabel($dur1_percetage);
                                        $bar_label2 = getLabel($dur2_percetage);
                                        $bar_label3 = getLabel($dur3_percetage);
                                        $bar_label4 = getLabel($dur4_percetage);
                                        ?>
                                        <ul class="list-unstyled">
                                            <li>
                                                <span class="icon24 icomoon-icon-arrow-up-2 green"></span> 0-10 Sec
                                                <span class="pull-right strong"><?php echo $dur1; ?></span>
                                                <div class="progress progress-striped">
                                                    <div class="progress-bar <?php echo $bar_label1; ?>" style="width: <?php echo $dur1_percetage; ?>%;"></div>
                                                </div>
                                            </li>
                                            <li>
                                                <span class="icon24 icomoon-icon-arrow-up-2 green"></span> 11-30 Sec
                                                <span class="pull-right strong"><?php echo $dur2; ?></span>
                                                <div class="progress progress-striped ">
                                                    <div class="progress-bar <?php echo $bar_label2; ?>" style="width: <?php echo $dur2_percetage; ?>%;"></div>
                                                </div>
                                            </li>
                                            <li>
                                                <span class="icon24 icomoon-icon-arrow-down-2 red"></span> 31-1 Min
                                                <span class="pull-right strong"><?php echo $dur3; ?></span>
                                                <div class="progress progress-striped ">
                                                    <div class="progress-bar <?php echo $bar_label3; ?>" style="width: <?php echo $dur3_percetage; ?>%;"></div>
                                                </div>
                                            </li>
                                            <li>
                                                <span class="icon24 icomoon-icon-arrow-up-2 green"></span>1 Min Above
                                                <span class="pull-right strong"><?php echo $dur4; ?></span>
                                                <div class="progress progress-striped ">
                                                    <div class="progress-bar <?php echo $bar_label4; ?>" style="width: <?php echo $dur4_percetage; ?>%;"></div>
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

                                     <span class="pull-right strong"><span class="number"><?php echo '7'; ?></span></span>
                                    
</li>


<li class="clearfix">
<div class="icon">
    <span class="icon32 icomoon-icon-bubbles-2 blue"></span>
</div>
<span class="number"></span> 
<span class="txt">Audio movie</span> 
  <span class="pull-right strong"><span class="number"><?php echo '27'; ?></span></span>
</li>

                                                     
</ul>
</div>

</div--><!-- End .span4 -->

                        <!--div class="col-lg-4">
    <div class="panel panel-default gradient">

        <div class="panel-heading">
            <h4>
                <span class="icon16 icomoon-icon-thumbs-up"></span>
                <span>Banner </span>
            </h4>
            <a href="#" class="minimize">Minimize</a>
        </div>
        <div class="panel-body">
          
          <center>  
                                            <img src="images/trial.gif" width="240" height="240" border="0"/>
                                            </center>

        </div>

    </div>
</div-->
                        <!-- End .span4 -->

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

                                    <div class="vital-stats" style="padding-bottom:23px">
                                        <!-- India Map -->
                                        <!--div id="chart_div" style="width:380px"></div-->
                                        <div id="chart_div" style="width:380px;height:220px"></div>
                                    </div>

                                </div>

                            </div>
                        </div><!-- End .span4 -->



                    </div><!-- End contentwrapper -->
                </div><!-- End #content -->

            </div><!-- End #wrapper -->

            <!-- Le javascript
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
                    /*
            if (divElement.hasClass('visitors-chart')) {
            $(function () {
                    var d1 = <?php echo $allMissedCallChart; ?>;
                    var d2 = <?php echo $allUniqueCallChart; ?>;
	
            //define placeholder class
                    var placeholder = $(".visitors-chart");
                    //graph options
                    var options = {
                                    grid: {
                                            show: true,
                                        aboveData: true,
                                        color: "#3f3f3f" ,
                                        labelMargin: 5,
                                        axisMargin: 0, 
                                        borderWidth: 0,
                                        borderColor:null,
                                        minBorderMargin: 5 ,
                                        clickable: true, 
                                        hoverable: true,
                                        autoHighlight: true,
                                        mouseActiveRadius: 20
                                    },
                            series: {
                                    grow: {
                                            active: false,
                                            stepMode: "linear",
                                            steps: 50,
                                            stepDelay: true
                                    },
                                lines: {
                                    show: true,
                                    fill: true,
                                    lineWidth: 4,
                                    steps: false
                                    },
                                points: {
                                    show:true,
                                    radius: 5,
                                    symbol: "circle",
                                    fill: true,
                                    borderColor: "#fff"
                                }
                            },
                            legend: { 
                                    position: "ne", 
                                    margin: [0,-25], 
                                    noColumns: 0,
                                    labelBoxBorderColor: null,
                                    labelFormatter: function(label, series) {
                                                // just add some space to labes
                                                return label+'&nbsp;&nbsp;';
                                             }
                            },
                            yaxis: { min: 0 },
                            xaxis: {ticks:11, tickDecimals: 0},
                            colors: chartColours,
                            shadowSize:1,
                            tooltip: true, //activate tooltip
                                    tooltipOpts: {
                                            content: "%s : %y.0",
                                            shifts: {
                                                    x: -30,
                                                    y: -50
                                            }
                                    }
                        };   
	
                    $.plot(placeholder, [ 

                            {
                                    label: "Missed Calls", 
                                    data: d1,
                                    lines: {fillColor: "#f2f7f9"},
                                    points: {fillColor: "#88bbc8"}
                            }, 
                            {	
                                    label: "Total unique Visitors", 
                                    data: d2,
                                    lines: {fillColor: "#fff8f2"},
                                    points: {fillColor: "#ed7a53"}
                            } 

                    ], options);
	        
        });
        }//end if
                     */
                    //pie visits graph
                    if (divElement.hasClass('pieStats')) {
                        $(function () {
                            var data = [
                                { label: "%<?php echo $newvisist_percetage; ?> New Visitor",  data: <?php echo $newvisist_percetage; ?>, color: "#88bbc8"},
                                { label: "%<?php echo $retruning_percetage; ?> Returning Visitor",  data: <?php echo $retruning_percetage; ?>, color: "#ed7a53"}
                            ];
		
                            $.plot($(".pieStats"), data, 
                            {
                                series: {
                                    pie: { 
                                        show: true,
                                        highlight: {
                                            opacity: 0.1
                                        },
                                        stroke: {
                                            color: '#fff',
                                            width: 3
                                        },
                                        startAngle: 2,
                                        label: {
                                            radius:1
                                        }
                                    },
                                    grow: {	active: false}
                                },
                                legend: { 
                                    position: "ne", 
                                    labelBoxBorderColor: null
                                },
                                grid: {
                                    hoverable: true,
                                    clickable: true
                                },
                                tooltip: true, //activate tooltip
                                tooltipOpts: {
                                    content: "%s : %y.1",
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
                var data = <?php echo $allMissedCallChart2; ?>;
                //var data = [[1, 0], [2, <?php echo $total_user ?>]];
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
	
                var data = <?php echo $allUniqueCallChart2; ?>;
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
	
                var data = <?php echo $allAvgMissedCallarray; ?>;
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
	
                var data = <?php echo $chartAvgMissedCallPerDayarrayChart; ?>;
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
	
                var data = <?php echo $chartbouncRateArray; ?>;
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
	
                var data = <?php echo $chartOBDNewVisitarray21; ?>;
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
                });
            </script>
    </body>

</html>
