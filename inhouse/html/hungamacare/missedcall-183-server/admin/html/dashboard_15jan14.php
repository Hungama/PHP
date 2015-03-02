<?php
session_start();
require_once("../../../db.php");
//$cpgid=$_SESSION['cpgid'];
$cpgid='PO0Ho20131216';
$getDashbord_RepeatUser=mysql_query("select msisdn ,count(*) as total from Inhouse_IVR.tbl_missedcall_smslist nolock  where cpgid='".$cpgid."'
group by msisdn HAVING total > 1",$con);
$totalrepeat_user=mysql_num_rows($getDashbord_RepeatUser);

$getDashbord_data="select count(*) as total, count(distinct(msisdn)) as total_unique,cpgname from Inhouse_IVR.tbl_missedcall_smslist nolock  where cpgid='".$cpgid."'";
$query_dash_info = mysql_query($getDashbord_data,$con);
list($total_user,$total_unique_user,$cpgmanager) = mysql_fetch_array($query_dash_info); 

//avg missed call perday
/*
$getAvgMissedCallPerDay_data="select count(msisdn), max(added_on),min(added_on),DATEDIFF(max(added_on),min(added_on)) ad todays from Inhouse_IVR.tbl_missedcall_smslist nolock  where cpgid='".$cpgid."'";
$query_AvgMissedCallPerDay_info = mysql_query($getAvgMissedCallPerDay_data,$con);
list($total_missedcall,$start_date,$end_date,$totaldays) = mysql_fetch_array($query_AvgMissedCallPerDay_info);
$avgmissedperday=ceil($total_missedcall/$totaldays);
*/

$getDailyVisits_data="select msisdn from Inhouse_IVR.tbl_missedcall_smslist nolock  where cpgid='".$cpgid."' and date(added_on)=date(now())";
$query_daily_info = mysql_query($getDailyVisits_data,$con);
$total_dailyvisit = mysql_num_rows($query_daily_info); 

$getDashbordChart_data="select count(*) as total, count(distinct(msisdn)) as total_unique,cpgname,day(added_on) as day
from Inhouse_IVR.tbl_missedcall_smslist nolock  where cpgid='".$cpgid."' group by date(added_on) order by day(added_on) ASC";
$query_dashChart_info = mysql_query($getDashbordChart_data,$con);

$chartMissedCallarray=array();
$chartUniqueCallarray=array();
$gettotalmissedcallcount=0;
$gettotalmissedcalldayscount=0;
while($data= mysql_fetch_array($query_dashChart_info))
{
$day=$data['day'];
$total_missed_call=$data['total'];
$total_unique_call=$data['total_unique'];
$avg_calls=ceil($total_missed_call/$total_unique_call);

$gettotalmissedcallcount=$gettotalmissedcallcount+$total_missed_call;
$gettotalmissedcalldayscount++;

$chartMissedCallarray[] = array($day,$total_missed_call);
$chartUniqueCallarray[] = array($day,$total_unique_call);
$chartAvgMissedCallarray[] = array($day,$avg_calls);
}

$avgmissedperday=ceil($gettotalmissedcallcount/$gettotalmissedcalldayscount);

//print_r ($chartMissedCallarray);
//print_r ($chartUniqueCallarray);
$allMissedCallChart=json_encode(($chartMissedCallarray), JSON_NUMERIC_CHECK);
$allUniqueCallChart=json_encode(($chartUniqueCallarray), JSON_NUMERIC_CHECK);
$allAvgMissedCallarray=json_encode(($chartAvgMissedCallarray), JSON_NUMERIC_CHECK);
print_r ($allAvgMissedCallarray);
mysql_close($con);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Supr admin <?php echo $cpgid;?></title>
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

    </head>
      
    <body>
    <!-- loading animation -->
    <div id="qLoverlay"></div>
    <div id="qLbar"></div>
        
    <div id="header">
        <nav class="navbar navbar-default" role="navigation">
            <div class="navbar-header">
                <a class="navbar-brand" href="dashboard.html">Supr.<span class="slogan">admin</span></a>
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon16 icomoon-icon-arrow-4"></span>
                </button>
            </div> 
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav">
                    <li class="active">
                        <a href="dashboard.html"><span class="icon16 icomoon-icon-screen-2"></span> <span class="txt">Dashboard</span></a>
                    </li>
                    
                </ul>
              
                <ul class="nav navbar-right usernav">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="icon16 icomoon-icon-bell"></span><span class="notification">3</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="menu">
                                <ul class="notif">
                                    <li class="header"><strong>Notifications</strong> (3) items</li>
                                    <li>
                                        <a href="#">
                                            <span class="icon"><span class="icon16 icomoon-icon-user-plus"></span></span>
                                            <span class="event">1 User is registred</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <span class="icon"><span class="icon16 icomoon-icon-bubble-3"></span></span>
                                            <span class="event">Jony add 1 comment</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <span class="icon"><span class="icon16 icomoon-icon-new"></span></span>
                                            <span class="event">admin Julia added post with a long description</span>
                                        </a>
                                    </li>
                                    <li class="view-all"><a href="#">View all notifications <span class="icon16 icomoon-icon-arrow-right-8"></span></a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle avatar" data-toggle="dropdown">
                            <img src="images/avatar.jpg" alt="" class="image" /> 
                            <span class="txt">admin@supr.com</span>
                            <b class="caret"></b>
                        </a>
                     
                    </li>
                    <li><a href="index.html"><span class="icon16 icomoon-icon-exit"></span><span class="txt"> Logout</span></a></li>
                </ul>
            </div><!-- /.nav-collapse -->
        </nav><!-- /navbar --> 

    </div><!-- End #header -->

    <div id="wrapper">

        <!--Responsive navigation button-->  
        <div class="resBtn">
            <a href="#"><span class="icon16 minia-icon-list-3"></span></a>
        </div>
        
        <!--Left Sidebar collapse button-->  
        <div class="collapseBtn leftbar">
             <a href="#" class="tipR" title="Hide Left Sidebar"><span class="icon12 minia-icon-layout"></span></a>
        </div>

        <!--Sidebar background-->
        <div id="sidebarbg"></div>
        <!--Sidebar content-->
        <div id="sidebar">

            <div class="shortcuts">
                <ul>
                    <li><a href="#" title="Support section" class="tip"><span class="icon24 icomoon-icon-support"></span></a></li>
                   
                </ul>
            </div><!-- End search -->            

            <div class="sidenav">

                <div class="sidebar-widget" style="margin: -1px 0 0 0;">
                    <h5 class="title" style="margin-bottom:0">Navigation</h5>
                </div><!-- End .sidenav-widget -->

                <div class="mainnav">
                   
                </div>
            </div><!-- End sidenav -->

           

        </div><!-- End #sidebar -->

        <!--Body content-->
        <div id="content" class="clearfix">
            <div class="contentwrapper"><!--Content wrapper-->

                <div class="heading">

                    <h3>Dashboard</h3>                    

                   
                    
                    <ul class="breadcrumb">
                        <li>You are here:</li>
                        <li>
                            <a href="#" class="tip" title="back to dashboard">
                                <span class="icon16 icomoon-icon-screen-2"></span>
                            </a> 
                            <span class="divider">
                                <span class="icon16 icomoon-icon-arrow-right-3"></span>
                            </span>
                        </li>
                        <li class="active">Dashboard</li>
                    </ul>

                </div><!-- End .heading-->

                <!-- Build page from here: -->
                <div class="row">

                    <div class="col-lg-8">
                        <div class="centerContent">
                  
                            <ul class="bigBtnIcon">
                                <li>
                                    <a href="#" title="I`m with gradient" class="tipB">
                                        <span class="icon icomoon-icon-users"></span>
                                        <span class="txt">Missed calls</span>
                                        <span class="notification"><?php echo $total_user;?></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <span class="icon icomoon-icon-support"></span>
                                        <span class="txt">Unique users</span>
                                        <span class="notification blue"><?php echo $total_unique_user;?></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" title="I`m with pattern" class="pattern tipB">
                                        <span class="icon icomoon-icon-bubbles-2"></span>
                                        <span class="txt">AVG Missed calls / day</span>
                                        <span class="notification green"><?php echo $avgmissedperday;?></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <span class="icon icomoon-icon-basket"></span>
                                        <span class="txt">Total minutes consumed</span>
                                        <span class="notification">0</span>
                                    </a>
                                </li>
                                
                            </ul>
                        </div>
                    </div><!-- End .span8 -->

                   

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
                                            <span class="head">Total Visits</span>
                                            <span class="number"><?php echo $total_user;?></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <span class="head">Uniqiue Visits</span>
                                            <span class="number"><?php echo $total_unique_user;?></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <span class="head">New Visits</span>
                                            <span class="number"><?php echo $total_dailyvisit;?></span>
                                        </a>
                                    </li>
                                   
                                </ul>
                               
                            </div>

                        </div><!-- End .panel -->

                    </div><!-- End .span8 -->

                    <div class="col-lg-4">

                        <div class="sparkStats">
                            <h4>389 people visited this site <!--a href="#" class="icon tip" title="Configure">
							<span class="icon16 icomoon-icon-cog-2"></span></a--></h4>
                            <ul class="list-unstyled">
                                <li><span class="sparkLine_missedCall"></span> Total customers missed call: <span class="number">509</span></li>
                                <li>
                                    <span class="sparkLine2"></span>
                                    Avg missed calls/customer: 
                                    <span class="number">389</span>
                                </li>
                                <li><span class="sparkLine3"></span> 
                                    Avg no of minutes customers hears: 
                                    <span class="number">42.88%</span>
                                </li>
                                <li><span class="sparkLine4"></span>
                                    New Visit- Daily: 
                                    <span class="number">20</span>
                                </li>
                                <li><span class="sparkLine5"></span>
                                    New vs Returning: 
                                    <span class="number">%</span>
                                </li>
                                <li><span class="sparkLine6"></span>
                                    Bounce Rate: <!--(Customes who hears & drop withing 1st prompt)--><span class="number">68.37%</span>
                                </li>                             

                            </ul>
                           
                        </div><!-- End .sparkStats -->
                        

                    </div><!-- End .span4 -->

                </div><!-- End .row -->

                <div class="row">

                   

                </div><!-- End .row -->

                <div class="row">

                   

                </div><!-- End .row -->
                
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
$(document).ready(function() { 	

	//------------- Full calendar  -------------//
	$(function () {
		var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();
		
		//front page calendar
		$('#calendar').fullCalendar({
			//isRTL: true,
			//theme: true,
			header: {
				left: 'title,today',
				center: 'prev,next',
				right: 'month,agendaWeek,agendaDay'
			},
			buttonText: {
	        	prev: '<span class="icon24 icomoon-icon-arrow-left-2"></span>',
	        	next: '<span class="icon24 icomoon-icon-arrow-right-3"></span>'
	    	},
			editable: true,
			events: [
				{
					title: 'All Day Event',
					start: new Date(y, m, 1)
				},
				{
					title: 'Long Event',
					start: new Date(y, m, d-5),
					end: new Date(y, m, d-2)
				},
				{
					id: 999,
					title: 'Repeating Event',
					start: new Date(y, m, d-3, 16, 0),
					allDay: false
				},
				{
					id: 999,
					title: 'Repeating Event',
					start: new Date(y, m, d+4, 16, 0),
					allDay: false
				},
				{
					title: 'Meeting',
					start: new Date(y, m, d, 10, 30),
					allDay: false
				},
				{
					title: 'Lunch',
					start: new Date(y, m, d, 12, 0),
					end: new Date(y, m, d, 14, 0),
					allDay: false,
					color: '#9FC569'
				},
				{
					title: 'Birthday Party',
					start: new Date(y, m, d+1, 19, 0),
					end: new Date(y, m, d+1, 22, 30),
					allDay: false,
					color: '#ED7A53'
				},
				{
					title: 'Click for Google',
					start: new Date(y, m, 28),
					end: new Date(y, m, 29),
					url: 'http://google.com/'
				}
			]
		});
		if(localStorage.getItem == 1 ) {
			$('#calendar').fullCalendar({isRTL: true});
		}
	});

	//circular progrress bar
	$(function () {

		$(".greenCircle").knob({
            'min':0,
            'max':100,
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
            'max':100,
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

	if (divElement.hasClass('visitors-chart')) {
	$(function () {
		//some data
//		var d1 = [[1, 3+randNum()], [2, 6+randNum()], [3, 9+randNum()], [4, 12+randNum()],[5, 15+randNum()],[6, 18+randNum()],[7, 21+randNum()],[8, 15+randNum()],[9, 18+randNum()],[10, 21+randNum()],[11, 24+randNum()],[12, 27+randNum()],[13, 30+randNum()],[14, 33+randNum()],[15, 24+randNum()],[16, 27+randNum()],[17, 30+randNum()],[18, 33+randNum()],[19, 36+randNum()],[20, 39+randNum()],[21, 42+randNum()],[22, 45+randNum()],[23, 36+randNum()],[24, 39+randNum()],[25, 42+randNum()],[26, 45+randNum()],[27,38+randNum()],[28, 51+randNum()],[29, 55+randNum()], [30, 60+randNum()]];
//		var d2 = [[1, randNum()-5], [2, randNum()-4], [3, randNum()-4], [4, randNum()],[5, 4+randNum()],[6, 4+randNum()],[7, 5+randNum()],[8, 5+randNum()],[9, 6+randNum()],[10, 6+randNum()],[11, 6+randNum()],[12, 2+randNum()],[13, 3+randNum()],[14, 4+randNum()],[15, 4+randNum()],[16, 4+randNum()],[17, 5+randNum()],[18, 5+randNum()],[19, 2+randNum()],[20, 2+randNum()],[21, 3+randNum()],[22, 3+randNum()],[23, 3+randNum()],[24, 2+randNum()],[25, 4+randNum()],[26, 4+randNum()],[27,5+randNum()],[28, 2+randNum()],[29, 2+randNum()], [30, 3+randNum()]];
		var d1 = <?php echo $allMissedCallChart;?>;
		var d2 = <?php echo $allUniqueCallChart;?>;
	
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
        			label: "Unique Users", 
        			data: d2,
        			lines: {fillColor: "#fff8f2"},
        			points: {fillColor: "#ed7a53"}
        		} 

        	], options);
	        
    });
    }//end if

    //pie visits graph
	if (divElement.hasClass('pieStats')) {
	$(function () {
	   var data = [
		    { label: "%78.75 New Visitor",  data: 78.75, color: "#88bbc8"},
		    { label: "%21.25 Returning Visitor",  data: 21.25, color: "#ed7a53"}
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
/*
//sparklines (making loop with random data for all 7 sparkline)
i=1;
for (i=1; i<8; i++) {
 	var data = [[1, 3+randNum()], [2, 5+randNum()], [3, 8+randNum()], [4, 11+randNum()],[5, 14+randNum()],[6, 17+randNum()],[7, 20+randNum()], [8, 15+randNum()], [9, 18+randNum()], [10, 22+randNum()]];
 	placeholder = '.sparkLine' + i;
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
}
*/
	var data = <?php echo $allMissedCallChart;?>;
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
	
/*
//sparkline in sidebar area
var positive = [1,5,3,7,8,6,10];
var negative = [10,6,8,7,3,5,1]
var negative1 = [7,6,8,7,6,5,4]

$('#stat1').sparkline(positive,{
	height:15,
	spotRadius: 0,
	barColor: '#9FC569',
	type: 'bar'
});
$('#stat2').sparkline(negative,{
	height:15,
	spotRadius: 0,
	barColor: '#ED7A53',
	type: 'bar'
});
$('#stat3').sparkline(negative1,{
	height:15,
	spotRadius: 0,
	barColor: '#ED7A53',
	type: 'bar'
});
$('#stat4').sparkline(positive,{
	height:15,
	spotRadius: 0,
	barColor: '#9FC569',
	type: 'bar'
});
//sparkline in widget
$('#stat5').sparkline(positive,{
	height:15,
	spotRadius: 0,
	barColor: '#9FC569',
	type: 'bar'
});

$('#stat6').sparkline(positive, { 
	width: 70,//Width of the chart - Defaults to 'auto' - May be any valid css width - 1.5em, 20px, etc (using a number without a unit specifier won't do what you want) - This option does nothing for bar and tristate chars (see barWidth)
	height: 20,//Height of the chart - Defaults to 'auto' (line height of the containing tag)
	lineColor: '#88bbc8',//Used by line and discrete charts to specify the colour of the line drawn as a CSS values string
	fillColor: '#f2f7f9',//Specify the colour used to fill the area under the graph as a CSS value. Set to false to disable fill
	spotColor: '#e72828',//The CSS colour of the final value marker. Set to false or an empty string to hide it
	maxSpotColor: '#005e20',//The CSS colour of the marker displayed for the maximum value. Set to false or an empty string to hide it
	minSpotColor: '#f7941d',//The CSS colour of the marker displayed for the mimum value. Set to false or an empty string to hide it
	spotRadius: 3,//Radius of all spot markers, In pixels (default: 1.5) - Integer
	lineWidth: 2//In pixels (default: 1) - Integer
});
*/	</script>
    </body>
</html>
