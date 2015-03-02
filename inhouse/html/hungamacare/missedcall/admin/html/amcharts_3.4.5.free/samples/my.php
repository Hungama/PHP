<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<?php
include("alldataGLC.php");
?>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>amCharts examples</title>
        <link rel="stylesheet" href="style.css" type="text/css">
        <script src="../amcharts/amcharts.js" type="text/javascript"></script>
        <script src="../amcharts/serial.js" type="text/javascript"></script>

        <script type="text/javascript">
            var chart;

		var chartData = [];
		
           AmCharts.ready(function () {
                // generate some random data first
                generateChartData();
                // SERIAL CHART
                chart = new AmCharts.AmSerialChart();
                chart.pathToImages = "../amcharts/images/";
                chart.marginLeft = 0;
                chart.marginRight = 0;
                chart.marginTop = 0;
                chart.dataProvider = chartData;
                chart.categoryField = "date";

                // AXES
                // category
                var categoryAxis = chart.categoryAxis;
                categoryAxis.parseDates = true; // as our data is date-based, we set parseDates to true
                categoryAxis.minPeriod = "DD"; // our data is daily, so we set minPeriod to DD
                // value axis
                var valueAxis = new AmCharts.ValueAxis();
                valueAxis.inside = true;
                valueAxis.tickLength = 0;
                valueAxis.axisAlpha = 0;
                valueAxis.minimum = 0;
                valueAxis.maximum = 150;
                chart.addValueAxis(valueAxis);

				// second value axis (on the right)
               var valueAxis2 = new AmCharts.ValueAxis();
               valueAxis2.position = "right"; // this line makes the axis to appear on the right
               valueAxis2.axisColor = "#FCD202";
               valueAxis2.gridAlpha = 0;
               valueAxis2.axisThickness = 2;
               chart.addValueAxis(valueAxis2);
			   
                // GRAPH
                var graph = new AmCharts.AmGraph();
                graph.dashLength = 3;
				graph.title = "Missed Calls";
                graph.lineColor = "#7717D7";
                graph.valueField = "visits";
                graph.dashLength = 3;
                graph.bullet = "round";
                chart.addGraph(graph);

				var graph2 = new AmCharts.AmGraph();
				graph2.valueAxis = valueAxis2; // we have to indicate which value axis should be used
				graph2.title = "Unique Users";
                graph2.dashLength = 3;
                graph2.lineColor = "#006400";
                graph2.valueField = "missed";
                graph2.dashLength = 3;
                graph2.bullet = "square";
                chart.addGraph(graph2);

                // CURSOR
                var chartCursor = new AmCharts.ChartCursor();
                chartCursor.cursorAlpha = 0;
                chart.addChartCursor(chartCursor);

                // GUIDES are used to create horizontal range fills
                var guide = new AmCharts.Guide();
                guide.value = 0;
                guide.toValue = 105;
                guide.fillColor = "#CC0000";
                guide.fillAlpha = 0.2;
                guide.lineAlpha = 0;
                valueAxis.addGuide(guide);

                var guide = new AmCharts.Guide();
                guide.value = 105;
                guide.toValue = 110;
                guide.fillColor = "#CC0000";
                guide.fillAlpha = 0.15;
                guide.lineAlpha = 0;
                valueAxis.addGuide(guide);

                var guide = new AmCharts.Guide();
                guide.value = 110;
                guide.toValue = 115;
                guide.fillColor = "#CC0000";
                guide.fillAlpha = 0.1;
                guide.lineAlpha = 0;
                valueAxis.addGuide(guide);

                var guide = new AmCharts.Guide();
                guide.value = 115;
                guide.toValue = 120;
                guide.fillColor = "#CC0000";
                guide.fillAlpha = 0.05;
                guide.lineAlpha = 0;
                valueAxis.addGuide(guide);

                var guide = new AmCharts.Guide();
                guide.value = 120;
                guide.toValue = 125;
                guide.fillColor = "#0000cc";
                guide.fillAlpha = 0.05;
                guide.lineAlpha = 0;
                valueAxis.addGuide(guide);

                var guide = new AmCharts.Guide();
                guide.value = 125;
                guide.toValue = 130;
                guide.fillColor = "#0000cc";
                guide.fillAlpha = 0.1;
                guide.lineAlpha = 0;
                valueAxis.addGuide(guide);

                var guide = new AmCharts.Guide();
                guide.value = 130;
                guide.toValue = 135;
                guide.fillColor = "#0000cc";
                guide.fillAlpha = 0.15;
                guide.lineAlpha = 0;
                valueAxis.addGuide(guide);

                var guide = new AmCharts.Guide();
                guide.value = 135;
                guide.toValue = 140;
                guide.fillColor = "#0000cc";
                guide.fillAlpha = 0.2;
                guide.lineAlpha = 0;
                valueAxis.addGuide(guide);

                // WRITE
                chart.write("chartdiv");
            });

            // generate some random data
             function generateChartData() {
                var firstDate = new Date();
                firstDate.setDate(firstDate.getDate() - 10);
<?php
$js_alldate = json_encode($chartDateUnique);
$js_chartCountUnique = json_encode($chartCountUnique);
$js_chartCountMissed = json_encode($chartCountMissed);
?>
var alldate=<?php echo $js_alldate;?>;
var chartCountUnique=<?php echo $js_chartCountUnique;?>;
var chartCountMissed=<?php echo $js_chartCountMissed;?>;

               for (var i = 0; i < alldate.length; i++) {
				var date=alldate[i];
				var visits=chartCountUnique[i];
				var missed=chartCountMissed[i];
				
				chartData.push({
                        date: alldate[i],
                        visits: chartCountUnique[i],
						missed: chartCountMissed[i]
                    });
					
                }
            }
        </script>
    </head>

    <body>
        <div id="chartdiv" style="width: 100%; height: 400px;"></div>
    </body>

</html>