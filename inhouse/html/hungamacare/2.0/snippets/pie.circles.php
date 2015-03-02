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
	
	
	

?>$(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'pieCircleRev',
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                width: 300
            },
            title: {
                text: 'Browser market shares at a specific website, 2010'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage}%</b>',
                percentageDecimals: 1
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        color: '#000000',
                        connectorColor: '#000000',
                        formatter: function() {
                            return '<b>'+ this.point.name +'</b>: '+ this.percentage +' %';
                        }
                    }
                }
            },
            series: [{
                type: 'pie',
                name: 'Browser share',
                data: [
                    ['Firefox',   45.0],
                    ['IE',       26.8],
                    {
                        name: 'Chrome',
                        y: 12.8,
                        sliced: true,
                        selected: true
                    },
                    ['Safari',    8.5],
                    ['Opera',     6.2],
                    ['Others',   0.7]
                ]
            }]
        });
    });
    
});