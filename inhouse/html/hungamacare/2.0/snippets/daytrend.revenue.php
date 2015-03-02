<?php
header("Content-Type: text/javascript");

require_once("incs/database.php");
require_once("../../incs/core.php");
require_once("../../../ContentBI/base.php");
require_once("../../../cmis/base.php");
require_once("../../incs/queries_revenue-D.php");

$dbh = new mysql_wrapper($SITE_CONF);
	
	$value = $_COOKIE[$COOKIE_NAME];
	list($SList,$PList,$CList,$fname,$lname,$username) = explode(":::",$value);
	
	$UUU = mysql_query("select * from usermanager where username='".$username."' limit 1") or die(mysql_error());	
	$III = mysql_fetch_array($UUU);
	$notin = $III["notin"];
	$notin = explode(",",$notin);
	
	foreach($notin as $v) {
	$NotIn .= "'".$v."',";	
	}
	$NotIn = trim($NotIn,",");
	
	$Circle = "'".join("','", $_GET['Circle'])."'";
	$Service = "'".join("','", $_GET['Service'])."'";

	
	
	$StartDate = $_GET['Start'];
	$EndDate = $_GET['End'];
	include("../../incs/revenue.calc-D.php");
$Q_7 = QueryBuild(array('Service'=>$Service,'StartDate'=>$StartDate,'EndDate'=>$EndDate, 'Circle'=>$Circle, 'NotIn'=>$NotIn),$Query[7]);
//echo $Q_7;exit;
$R_7 = $dbh->get_row($Q_7);
$DATE_DIFF = $R_7['DATE_DIFF'];
	
	
	$i=0;

foreach($DATE_REV as $xDate=>$xRevenue) {
	$Categories .= "'".date("d",strtotime($xDate))."',";
    $Revenue .= ($xRevenue > 0 ? $xRevenue : 0).",";
    $DRR .= round($total_rev/$DATE_DIFF,1).",";
    $ActRev .= ($TREND_REV[date("Y-m-d",strtotime($xDate))]["act"] > 0 ? $TREND_REV[date("Y-m-d",strtotime($xDate))]["act"] : 0).",";
    $RenRev .= ($TREND_REV[date("Y-m-d",strtotime($xDate))]["ren"] > 0 ? $TREND_REV[date("Y-m-d",strtotime($xDate))]["ren"] : 0).",";
        
	$i++;
}

	$Categories = rtrim($Categories,",");
	$Revenue = rtrim($Revenue,",");
	$DRR = rtrim($DRR,",");
	$ActRev = rtrim($ActRev,",");
	$RenRev = rtrim($RenRev,",");	


	
	

?>
$(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'date_trend',
                type: 'line',
                marginRight: 10,
                marginBottom: 70
            },
            title: {
                text: 'Revenue Trending',
                x: 50 //center
            },
           
            xAxis: {
                categories: [<?php echo $Categories ;?>],
                tickInterval: 5
            },
            yAxis: {
                title: {
                    text: 'Revenue'
                },
                min: 0,
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                formatter: function() {
                        return '<b>'+ this.series.name +'</b><br/>'+
                        this.x +': '+ this.y +'';
                }
            },
                plotOptions: {
                series: {
                    marker: {
                            enabled: false
                    }
                }
                 },
                 
           legend: {
            align: 'right',
            verticalAlign: 'bottom',
            x: -5,
            y: 10,
            floating: false
        },
            series: [{
                name: 'Revenue',
                data: [<?php echo $Revenue;?>]
            }, {
                name: 'DRR',
                data: [<?php echo $DRR;?>]
            }, {
                name: 'Act Revenue',
                data: [<?php echo $ActRev;?>]
            }, {
                name: 'Ren Revenue',
                data: [<?php echo $RenRev;?>]
            }]
        });
    });
    
});