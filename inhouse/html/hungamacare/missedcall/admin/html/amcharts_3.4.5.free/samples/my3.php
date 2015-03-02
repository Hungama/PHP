<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>amCharts examples</title>
        <link rel="stylesheet" href="style.css" type="text/css">
        <script src="../amcharts/amcharts.js" type="text/javascript"></script>
        <script src="../amcharts/serial.js" type="text/javascript"></script>
        
        <script type="text/javascript">
            var chart;
            
            var chartData = [
                {
                    "year": '1 March',
                    "germany": 5,
                    "uk": 3
                },
                {
                    "year": '2 March',
                    "germany": 2,
                    "uk": 6
                },
                {
                    "year": '3 March',
                    
                    "germany": 3,
                    "uk": 1
                },
                {
                    "year": '4 March',
                    
                    "germany": 4,
                    "uk": 1
                },
                {
                    "year": '5 March',
                    
                    "germany": 1,
                    "uk": 2
                },
                {
                    "year": '6 March',
                    
                    "germany": 2,
                    "uk": 1
                },
                {
                    "year": '7 March',
                   
                    "germany": 2,
                    "uk": 3
                },
                {
                    "year": '8 March',
                    
                    "germany": 1,
                    "uk": 5
                },
                {
                    "year": '9 March',
                    
                    "germany": 5,
                    "uk": 2
                },
                {
                    "year": '10 March',
                   
                    "germany": 3,
                    "uk": 6
                },
                {
                    "year": '11 March',
                    
                    "germany": 2,
                    "uk": 4
                }
            ];
            
            
            AmCharts.ready(function () {
                // SERIAL CHART
                chart = new AmCharts.AmSerialChart();
                chart.dataProvider = chartData;
                chart.categoryField = "year";
                chart.startDuration = 0.5;
                chart.balloon.color = "#000000";
            
                // AXES
                // category
                var categoryAxis = chart.categoryAxis;
                categoryAxis.fillAlpha = 1;
                categoryAxis.fillColor = "#FAFAFA";
                categoryAxis.gridAlpha = 0;
                categoryAxis.axisAlpha = 0;
                categoryAxis.gridPosition = "start";
                categoryAxis.position = "top";
            
                // value
                var valueAxis = new AmCharts.ValueAxis();
                valueAxis.title = "Place taken";
                valueAxis.dashLength = 5;
                valueAxis.axisAlpha = 0;
                valueAxis.minimum = 1;
                valueAxis.maximum = 150;
                valueAxis.integersOnly = true;
                valueAxis.gridCount = 1;
                valueAxis.reversed = true; // this line makes the value axis reversed
                chart.addValueAxis(valueAxis);
            
                // GRAPHS
            
                // Germany graph
                var graph = new AmCharts.AmGraph();
                graph.title = "Germany";
                graph.valueField = "germany";
                graph.balloonText = "place taken by Germany in [[category]]: [[value]]";
                graph.bullet = "round";
                chart.addGraph(graph);
            
                // United Kingdom graph
                var graph = new AmCharts.AmGraph();
                graph.title = "United Kingdom";
                graph.valueField = "uk";
                graph.balloonText = "place taken by UK in [[category]]: [[value]]";
                graph.bullet = "round";
                chart.addGraph(graph);
                
                // CURSOR
                var chartCursor = new AmCharts.ChartCursor();
                chartCursor.cursorPosition = "mouse";
                chartCursor.zoomable = false;
                chartCursor.cursorAlpha = 0;
                chart.addChartCursor(chartCursor);                
            
                // LEGEND
                var legend = new AmCharts.AmLegend();
                legend.useGraphSettings = true;
                chart.addLegend(legend);
            
                // WRITE
                chart.write("chartdiv");
            });
        </script>
    </head>
    
    <body>
        <div id="chartdiv" style="width: 100%; height: 400px;"></div>
    </body>

</html>