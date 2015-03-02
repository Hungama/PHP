<?php
session_start();
require_once("../../../db.php");
error_reporting(0);

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
	$StartDate='2014-10-01';
	//$StartDate= date("Y-m-d",mktime(0,0,0,date("m")-1,date("d"),date("Y")));
}

if(!isset($EndDate)) {

	$EndDate= date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")));
}

$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa', 'KAR'=>'Karnataka', 'HAY'=>'Haryana','PUB'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','KER'=>'Kerala','HPD'=>'Himachal Pradesh',''=>'Other');
$cirlceColorCode=array('DEL'=>'88bbc8','GUJ'=>'88bbc8','WBL'=>'ed7a53','BIH'=>'bbdce3','RAJ'=>'9FC569','UPW'=>'bbdce3','MAH'=>'9a3b1b','APD'=>'5a8022','UPE'=>'9FC569','ASM'=>'2c7282','TNU'=>'2c7282','KOL'=>'ed7a53','NES'=>'2c7282','CHN'=>'2c7282','ORI'=>'ed7a53','KAR'=>'2c7282','HAY'=>'9FC569','PUB'=>'2c7282','MUM'=>'9FC569','MPD'=>'2c7282','JNK'=>'9FC569');
$circleNameCode=array('tatm'=>'Tata - Docomo','tatc'=>'Tata - Indicom','airc'=>'Aircel','relm'=>'Reliance-GSM','relc'=>'Reliance-CDMA','vodm'=>'Vodafone','airm'=>'Airtel','unim'=>'Uninor','mtsm'=>'MTS');
require_once("alldataTataTiscon.php");

$getDashbordChart_missedCallNewChart="select count(*) as total, day(date_time) as day,Month(date_time) as month
from Hungama_Tatasky.tbl_tata_pushobd nolock  where date(date_time) between '".$StartDate."' and '".$EndDate."' and ANI!='' group by date(date_time) order by Month(date_time),day ASC";
$query_missedCallNewChart = mysql_query($getDashbordChart_missedCallNewChart,$con);

$getDashbordChart_UniqueCallNewChart="select count(distinct(ANI)) as total_unique,day(date_time) as day,Month(date_time) as month
from Hungama_Tatasky.tbl_tata_pushobd nolock  where date(date_time) between '".$StartDate."' and '".$EndDate."' and ANI!='' group by date(date_time) order by Month(date_time),day ASC";
$query_uniqueCallNewChart = mysql_query($getDashbordChart_UniqueCallNewChart,$con);

$getDashbordChart_missedCallHourWise="select count(*) as total, hour(date_time) as hour
from Hungama_Tatasky.tbl_tata_pushobd nolock  where date(date_time) between '".$StartDate."' and '".$EndDate."' and ANI!='' group by hour(date_time) order by hour(date_time) ASC";
$query_missedCallHourWiseChart = mysql_query($getDashbordChart_missedCallHourWise,$con);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Tata Tiscon Missed Call Campaign</title>
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
	<link href="css/new-excel-css.css" rel="stylesheet" type="text/css" />
	

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
        gridThickness: 0.3,
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
	
while($data_missedCallNewChart= mysql_fetch_array($query_missedCallNewChart))
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
	
while($data_uniqueCallNewChart= mysql_fetch_array($query_uniqueCallNewChart))
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
	
	<!-- Hour wise graph start here -->
	   var chart_12 = new CanvasJS.Chart("chartContainer_hourwise",
    {
      title:{
        text: ""
    },
    axisX:{
        title: "Hour",
        gridThickness: 0.3
    },
    axisY: {
        title: "Total Count"
    },
    data: [
    {   
        type: "area",
        dataPoints: [
	<?php
	
while($data_missedCallHourWise= mysql_fetch_array($query_missedCallHourWiseChart))
{
$hour=$data_missedCallHourWise['hour'];
$total_missed_callHourWise=$data_missedCallHourWise['total'];
?>
{ x: <?php echo $hour;?>, y: <?php echo $total_missed_callHourWise;?>},
<?php
}
?>
  ]
    }
    ]
});

    chart_12.render();
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
                <a class="navbar-brand" href="#">Tata Tiscon<span class="slogan">Campaign</span></a>
				<!--img src="Logo2.png" border=0 /-->
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon16 icomoon-icon-arrow-4"></span>
                </button>
            </div> 
            <div class="collapse navbar-collapse navbar-ex1-collapse">
               
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
<form id="rangepicker" action="dashboardTataTiscon_newexcel.php" method="post">					
  <div id="rangepickerA" class="btn small btn-xs" >Date:
    <!--i class="icon-calendar icon-large"></i-->
    <input type="text" value="<?php if(!$_POST) { echo date("m/d/Y", strtotime($StartDate)); ?> - <?php echo date("m/d/Y");} else { echo date("m/d/Y",strtotime($StartDate))." - ".date("m/d/Y",strtotime($EndDate));}?>" id="rangeA" name="rangeA"  style="font-size: 1.0em;" size="25"/>
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

function setChartType(type)
{
if(type==1)
{
//visitor day wise Chart
document.getElementById("visitor_chart1").style.display="inline";
document.getElementById("visitor_chart2").style.display="none";
}
else if(type==2)
{
//visitor hour wise chart
document.getElementById("visitor_chart1").style.display="none";
document.getElementById("visitor_chart2").style.display="inline";
}
else
{
alert('Please select chart type.');
}
}
</script>
<?php //data fetch query_missedCallHourWiseChart
$sql_query=mysql_query("select Date,Circle,CapsuleName,TotalMissedCallsReceived,TotalOBDsMade,TotalOBDsSuccessfull,
TotalUniqueOBDs,TotalMinutesConsumed,AverageDuration_OBD,PeakCallingHour,Hindi,Bengali,Tamil,IsMitr,NotSel,
TotalNewUsers from Hungama_Tatasky.tbl_dailymisMitrExcelReport nolock where date between '".$StartDate."' and '".$EndDate."'
and IsMitr=0 order by 
date desc",$con);
$num_row=mysql_num_rows($sql_query);

?>
				                                   

<div class="search">
<div class="circular-item tipB" title="Tata Tiscon Automation Report">
<a href="http://182.72.55.117/hungamacare/missedcall/admin/html/excel/contents-display.php"> 
<span class="icon icomoon-icon-download"></span></a>
<input type="hidden" value="<?php echo $num_row; ?>"  style="width:50px;height:50px;" />
<!--class="blueCircle"-->
</div>
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
<li class="active">
Tata Tiscon Dashboard
</li>
</ul>

</div><!-- End .heading-->



<div class="row">
<table border="0" cellpadding="0" cellspacing="0" id="sheet0" class="sheet0 gridlines">
<col class="col0">
<col class="col1">
<col class="col2">
<col class="col3">
<col class="col4">
<col class="col5">
<col class="col6">
<col class="col7">
<col class="col8">
<col class="col9">
<col class="col10">
<col class="col11">
<col class="col12">
<col class="col13">
<col class="col14">
<col class="col15">
<col class="col16">
<col class="col17">
<col class="col18">
<col class="col19">
<col class="col20">
<col class="col21">
<col class="col22">
<col class="col23">
<col class="col24">
<col class="col25">
		<tbody>
<tr class="row0">
<td class="column0 style1 s" rowspan="3">Date</td>
<td class="column1 style1 s" rowspan="3">GEOGRAPHIC DISPERSION</td>
<td class="column2 style1 s" rowspan="3">Capsule Name</td>
<td class="column3 style1 s" rowspan="3">Total Missed Calls Received</td>
<td class="column4 style8 s" colspan="11">All User</td>
<td class="column15 style16 s" colspan="11">REGISTERED MITR MEMBERS</td>
</tr>
<tr class="row1">
<td class="column4 style9 s" rowspan="2">Total OBDs Made</td>
<td class="column5 style9 s" rowspan="2">Total OBDs Successful</td>
<td class="column6 style9 s" rowspan="2">Total New Users</td>
<td class="column7 style9 s" rowspan="2">Total Unique Users</td>
<td class="column8 style9 s" rowspan="2">Total Minutes Consumed</td>
<td class="column9 style9 s" rowspan="2">Average Duration/OBD(In Sec)</td>
<td class="column10 style9 s" rowspan="2">Peak Calling Hour</td>
<td class="column11 style11 s" colspan="4">MOST PREFERED LANGUAGE</td>
<td class="column15 style17 s" rowspan="2">Total OBDs Made</td>
<td class="column16 style20 s" rowspan="2">Total OBDs Successful</td>
<td class="column17 style20 s" rowspan="2">Total New Users</td>
<td class="column18 style20 s" rowspan="2">Total Unique Users</td>
<td class="column19 style20 s" rowspan="2">Total Minutes Consumed</td>
<td class="column20 style20 s" rowspan="2">Average Duration/OBD(In Sec)</td>
<td class="column21 style20 s" rowspan="2">Peak Calling Hour</td>
<td class="column22 style22 s" colspan="4">MOST PREFERED LANGUAGE</td>
</tr>
<tr class="row2">
<td class="column11 style14 s">Hindi</td>
<td class="column12 style14 s">Bengali</td>
<td class="column13 style14 s">Tamil</td>
<td class="column14 style15 s">NotSel</td>
<td class="column22 style15 s">Hindi</td>
<td class="column23 style15 s">Bengali</td>
<td class="column24 style15 s">Tamil</td>
<td class="column25 style15 s">NotSel</td>
</tr>
<?php 
while($mydata=mysql_fetch_array($sql_query))
{
?>
<tr class="row248">
<td class="column0 style1 s" ><?php echo $mydata['Date']; ?></td>
<td class="column1 style1 s"><?php echo $mydata['Circle']; ?></td>
<td class="column2 style1 s"><?php echo $mydata['CapsuleName']; ?></td>
<td class="column3 style1 s"><?php echo $mydata['TotalMissedCallsReceived']; ?></td>
<td class="column4 style1 s"><?php echo $mydata['TotalOBDsMade']; ?></td>
<td class="column5 style1 s"><?php echo $mydata['TotalOBDsSuccessfull']; ?></td>
<td class="column6 style1 s "><?php echo $mydata['TotalNewUsers']; ?></td>
<td class="column7 style1 s"><?php echo $mydata['TotalUniqueOBDs']; ?></td>
<td class="column8 style1 s"><?php echo $mydata['TotalMinutesConsumed']; ?></td>
<td class="column9 style1 s"><?php echo $mydata['AverageDuration_OBD']; ?></td>
<td class="column10 style1 s"><?php echo $mydata['PeakCallingHour']; ?></td>
<td class="column11 style1 s"><?php echo $mydata['Hindi']; ?></td>
<td class="column12 style1 s"><?php echo $mydata['Bengali']; ?></td>
<td class="column13 style1 s"><?php echo $mydata['Tamil']; ?></td>
<td class="column14 style1 s"><?php echo $mydata['NotSel']; ?></td>
<!--non mitr data start-->

<?php 
$sql_query_data=mysql_query("select TotalOBDsMade,TotalOBDsSuccessfull,TotalUniqueOBDs,TotalMinutesConsumed,AverageDuration_OBD,PeakCallingHour,Hindi,Bengali,Tamil,IsMitr,NotSel,TotalNewUsers from Hungama_Tatasky.tbl_dailymisMitrExcelReport nolock where date(date)='".$mydata['Date']."' and IsMitr=1  and Circle= '".$mydata['Circle']."'",$con);
$num_rows=mysql_num_rows($sql_query_data);
$data_rows=mysql_fetch_array($sql_query_data);
if($num_rows>0)
{
?>
<td class="column15 style1 s "><?php echo $data_rows['TotalOBDsMade']; ?></td>
<td class="column16 style1 s"><?php echo $data_rows['TotalOBDsSuccessfull']; ?></td>
<td class="column17 style1 s"><?php echo $data_rows['TotalNewUsers']; ?></td>
<td class="column18 style1 s"><?php echo $data_rows['TotalUniqueOBDs'] ?></td>
<td class="column19 style1 s"><?php echo $data_rows['TotalMinutesConsumed']; ?></td>
<td class="column20 style1 s"><?php echo $data_rows['AverageDuration_OBD']; ?></td>
<td class="column21 style1 s"><?php echo $data_rows['PeakCallingHour']; ?></td>
<td class="column22 style1 s"><?php echo $data_rows['Hindi']; ?></td>
<td class="column23 style1 s"><?php echo $data_rows['Bengali']; ?></td>
<td class="column24 style1 s"><?php echo $data_rows['Tamil']; ?></td>
<td class="column25 style1 s"><?php echo $data_rows['NotSel']; ?></td>
<?php } else { ?>
<td class="column15 style1 s"></td>
<td class="column16 style1 s"></td>
<td class="column17 style1 s"></td>
<td class="column18 style1 s"></td>
<td class="column19 style1 s"></td>
<td class="column20 style1 s "></td>
<td class="column21 style1 s"></td>
<td class="column22 style1 s"></td>
<td class="column23 style1 s"></td>
<td class="column24 style1 s "></td>
<td class="column25 style1 s "></td>

<?php } ?>
</tr>
<?php } ?>
</table>



</div>

			
				
              
					
					
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
setChartType(1);
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
        			label: "Total unique Visitors", 
        			data: d2,
        			lines: {fillColor: "#fff8f2"},
        			points: {fillColor: "#ed7a53"}
        		} 

        	], options);
	        
    });
    }//end if
*/
  /*  //pie visits graph
	if (divElement.hasClass('pieStats')) {
	$(function () {
	   var data = [
		    { label: "%<?php echo $newvisist_percetage;?> New Visitor",  data: <?php echo $newvisist_percetage;?>, color: "#88bbc8"},
		    { label: "%<?php echo $retruning_percetage;?> Returning Visitor",  data: <?php echo $retruning_percetage;?>, color: "#ed7a53"}
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
*/
//pie visits graph
	if (divElement.hasClass('pieStats')) {
	$(function () {
	   var data = [
	   <?php foreach($alloperatorCount as $cpname=>$cpTotalcount)
	   { 
	   ?>
{ label: " <?php echo $circle_info[$cpname];?>",  data: <?php echo $cpTotalcount;?>, color: "#<?php echo $cirlceColorCode[$cpname]?>"},
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
var data = <?php echo $allMissedCallChart2;?>;
//var data = [[1, 0], [2, <?php echo $total_user?>]];
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
	
	var data = <?php echo $allUniqueCallChart2;?>;
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
	
	var data = <?php echo $allAvgMissedCallarray;?>;
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
	
	var data = <?php echo $chartAvgMissedCallPerDayarrayChart;?>;
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
	});
	*/
	//setChartType(1);
	var data = <?php echo $allAdsChart2;?>;
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
