<!DOCTYPE HTML>
<?php
require_once("../../../db.php");
$StartDate= date("Y-m-d",mktime(0,0,0,date("m")-1,date("d"),date("Y")));
$EndDate= date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")));

$getDashbordChart_data="select sum(totalcount) as totalcount,day(report_date) as day,Month(report_date) as month
from Inhouse_IVR.tbl_advertisment_Dashboard nolock  where date(report_date)
 between '".$StartDate."' and '".$EndDate."'  group by date(report_date) order by day(report_date) ASC";
$query_dashChart_info = mysql_query($getDashbordChart_data,$con);

$chartMissedCallarray=array();
$gettotalmissedcallcount=0;
$gettotalmissedcalldayscount=0;
$montharray=array('1'=>'JAN','2'=>'FEB','3'=>'MAR','4'=>'APR','5'=>'MAY','6'=>'JUN','7'=>'JUL','8'=>'AUG','9'=>'SEP','10'=>'OCT','11'=>'NOV','12'=>'DEC');

?>
<html>
<head>  
<script type="text/javascript">

window.onload = function () {
    var chart = new CanvasJS.Chart("chartContainer",
    {
      title:{
        text: "Visitor Chart"
    },
    axisX:{
        title: "Date",
        gridThickness: 1
    },
    axisY: {
        title: "Total Count"
    },
    data: [
    {        
        type: "line",
        dataPoints: [//array
	<?php
	while($data= mysql_fetch_array($query_dashChart_info))
{
$day=$data['day'];
$month=$data['month']-1;
$total_missed_call=$data['totalcount'];
?>
{ x: new Date(2014, <?php echo $month;?>, <?php echo $day;?>), y: <?php echo $total_missed_call;?>},
<?php
}
?>
        
        ]
    },
        
        {        
        type: "line",
        dataPoints: [
      { x: new Date(2014, 4, 1), y: 154},
{ x: new Date(2014, 3, 24), y: 1165},
{ x: new Date(2014, 3, 25), y: 156},
{ x: new Date(2014, 3, 26), y: 10221},
{ x: new Date(2014, 3, 27), y: 15228},
{ x: new Date(2014, 3, 28), y: 92239},
{ x: new Date(2014, 3, 29), y: 12336},
{ x: new Date(2014, 3, 30), y: 133},
        ]
		}
      
    ]
});

    chart.render();
}
</script>
<script type="text/javascript" src="http://canvasjs.com/assets/script/canvasjs.min.js"></script>
</head>
<body>
<div id="chartContainer" style="height: 300px; width: 100%;">
</div>
</body>
</html>