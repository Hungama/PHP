<?php
define('CONST_CSS','

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap-timepicker.css">
<link rel="stylesheet" href="css/bootstrap-timepicker.min.css">

<!-- Theme -->
<link rel="stylesheet" href="css/flat-ui.css">
<link rel="stylesheet" href="css/hungamaweb.css">
<link rel="stylesheet" href="css/bootstrap-select.css">
<link rel="stylesheet" href="css/bootstrap.min-tp.css">

<!-- IE Issues Fix -->
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.min.js"></script>
      <script src="js/respond.js"></script>
    <![endif]-->

<!-- Fonts & Icons -->
<link rel="stylesheet" href="css/fontello.css">
<!--[if IE 7]>
    <link rel="stylesheet" href="css/fontello-ie7.css">
<![endif]-->

');


//Footers
define('CONST_JS','<!-- jQuery (necessary for Bootstrap\'s JavaScript plugins) -->
<!-- Latest compiled and minified JavaScript -->
	<script src="js/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>
        <script src="js/application.js"></script>
	<script src="js/jquery-ui-1.10.3.custom.min.js"></script>
    <script src="js/jquery.ui.touch-punch.min.js"></script>
    <script src="js/bootstrap-select.js"></script>
    <script src="js/bootstrap-switch.js"></script>
    <script src="js/flatui-checkbox.js"></script>
    <script src="js/flatui-radio.js"></script>
    <script src="js/jquery.tagsinput.js"></script>
    <script src="js/jquery.placeholder.js"></script>
    <script src="js/bootstrap-timepicker.js"></script>
    <script src="js/bootstrap-timepicker.min.js"></script>
	<script>
	$("select").selectpicker({style: \'btn btn-primary\', menuStyle: \'dropdown-inverse\'});
	function toggle(id){
		
		if( $("#all-"+id).is(":visible") ) {
			$("#"+id).selectpicker("selectAll");
			$("#all-"+id).toggle();
			$("#none-"+id).toggle();
		}
		else {
			$("#"+id).selectpicker("deselectAll");
			$("#all-"+id).toggle();
			$("#none-"+id).toggle();
		
		}
	}	
	</script>');

// Date Range JS
define('DATERANGE_JS','
<script type="text/javascript" src="js/moment.min.js"></script>
<script type="text/javascript" src="js/daterangepicker.js"></script>');

define('DATERANGE_CSS','
<link rel="stylesheet" type="text/css" media="all" href="css/daterangepicker.css" />');



// Edit In Palce

define('EDITINPLACE_CSS','<link rel="stylesheet" type="text/css" media="all" href="css/bootstrap-editable.css" />');
define('EDITINPLACE_JS','<script type="text/javascript" src="js/bootstrap-editable.min.js"></script>');

?>