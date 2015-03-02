<?php
session_start();
require_once("../../../db.php");

if (empty($_SESSION['loginId'])) {
    session_destroy();
    Header("location:index.php?ERROR=502");
}

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
<?php echo $MAP_SET_NEWChart; ?>
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
                            <form id="rangepicker"  method="post">					
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
                                or Msisdn: <input type="text" value="" id="msisdn" name="msisdn"  style="font-size: 1.0em;" size="25"/>
                                <button class="btn btn-info btn-xs" href="#" type="submit">Go</button>
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

                </div><!-- End #content -->
                <div class="col-lg-6" style="width:100%">

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4> 
                                <span>Search Result</span>
                            </h4>
                        </div>
                        <div class="panel-body">
                            <div id="grid-view_missedcall">
                                No Record Available
                            </div> 

                        </div>
                        <!-- End .panel -->

                    </div>
                </div>
<!--                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4> 
                                <span>OBD Search Result</span>
                            </h4>
                        </div>
                        <div class="panel-body">
                            <div id="grid-view_obd">
                                No Record Available
                            </div> 

                        </div>

                         End .panel 

                    </div> End .span6 
                </div>-->
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

                    if (divElement.hasClass('visitors-chart')) {
                        $(function () {
                            //some data
                            //var d1 = [[1, 0], [2, 6+randNum()], [3, 0], [4, 0],[5, 15+randNum()],[6, 18+randNum()],[7, 21+randNum()],[8, 15+randNum()],[9, 18+randNum()],[10, 21+randNum()],[11, 0],[12, 27+randNum()],[13, 30+randNum()],[14, 33+randNum()],[15, 24+randNum()],[16, 27+randNum()],[17, 30+randNum()],[18, 0],[19, 36+randNum()],[20, 39+randNum()],[21, 42+randNum()],[22, 45+randNum()],[23, 36+randNum()],[24, 39+randNum()],[25, 42+randNum()],[26, 45+randNum()],[27,38+randNum()],[28, 51+randNum()],[29, 55+randNum()], [30, 60+randNum()]];
                            //var d2 = [[1, randNum()-5], [2, randNum()-4], [3, randNum()-4], [4, randNum()],[5, 4+randNum()],[6, 4+randNum()],[7, 5+randNum()],[8, 5+randNum()],[9, 6+randNum()],[10, 6+randNum()],[11, 0],[12, 2+randNum()],[13, 3+randNum()],[14, 4+randNum()],[15, 4+randNum()],[16, 0],[17, 5+randNum()],[18, 5+randNum()],[19, 2+randNum()],[20, 2+randNum()],[21, 3+randNum()],[22, 3+randNum()],[23, 3+randNum()],[24, 0],[25, 4+randNum()],[26, 0],[27,5+randNum()],[28, 2+randNum()],[29, 2+randNum()], [30, 3+randNum()]];
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
            <script type="text/javascript">
                function checkfield() { 
                    var rangeA=document.forms["rangepicker"]["rangeA"].value;
                    var msisdn=document.forms["rangepicker"]["msisdn"].value;
                    if (rangeA== '' && msisdn=='') {
                        alert('Please select date range or enter msisdn');
                        return false;
                    } 
                    return true;
                }    
                $("form#rangepicker").submit(function(){ 
                    var isok = checkfield();
                    if(isok)
                    { 
                        $('#loading').show();
                        var formData = new FormData($("form#rangepicker")[0]);
                        $.ajax({
                            url: 'ShowMsisdnStatus_process.php',
                            type: 'POST',
                            data: formData,
                            async: false,
                            success: function (abc) {
                                //resestForm('rangepicker'); 
                                $('#grid-view_missedcall').html(abc);
                               // viewMsisdnDetails();
                            },
                            cache: false,
                            contentType: false,
                            processData: false
                        });
                    
                        return false;
                    }
                    else
                    {
                        return false;
                    }
                }); 
//                function viewMsisdnDetails() { 
//                    $.fn.GetMsisdnDetails();
//                };
//                $.fn.GetMsisdnDetails = function() {
//                    var formData = new FormData($("form#rangepicker")[0]);
//                    $.ajax({
//                        url: 'ShowOBD_process.php',
//                        type: 'POST',
//                        data: formData,
//                        async: false,
//                        success: function (abc) {
//                            $('#grid-view_obd').html(abc);
//                        },
//                        cache: false,
//                        contentType: false,
//                        processData: false						
//                    });
//                };
            </script>
    </body>

</html>
