<?php
$SKIP = 1;
ini_set('display_errors','0');
$start = (float) array_sum(explode(' ',microtime())); 

require_once("incs/database.php");
require_once("../../ContentBI/base.php");
require_once("../../cmis/base.php");
require_once("../incs/GraphColors-D.php");

?><html>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <link href="assets/css/bootstrap.css" rel="stylesheet" />
 
  <link href="assets/css/style.css" rel="stylesheet" />
<link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
<link href="assets/css/datepicker.css" rel="stylesheet" />
<link href="assets/css/icons-sprites.css" rel="stylesheet" />

<link href="assets/css/dataTables.bootstrap.css" rel="stylesheet" />

<link rel="stylesheet" href="assets/css/base.css" type="text/css" media="all" charset="utf-8" />

<style>
.px12 {
 font-size: 12px;	
}


div.dataTables_length label {
	float: left;
	text-align: left;
}


div.dataTables_filter label {
	float: right;
}

div.dataTables_filter input, div.dataTables_length select {
  width: 210px;
  
  display: inline-block;
  height: 30px;
  padding: 4px;
  margin-bottom: 9px;
  font-size: 13px;
  line-height: 18px;
  color: #555555;
}

div.dataTables_length select {
	width: 75px;
}

div.dataTables_info {
	padding-top: 8px;
}

div.dataTables_paginate {
	float: right;
	margin: 0;
}

table.table {
	clear: both;
	margin-bottom: 6px !important;
	max-width: none !important;
}

table.table thead .sorting,
table.table thead .sorting_asc,
table.table thead .sorting_desc,
table.table thead .sorting_asc_disabled,
table.table thead .sorting_desc_disabled {
	cursor: pointer;
	*cursor: hand;
}

table.table thead .sorting { background: url('assets/img/sort_both.png') no-repeat center right; }
table.table thead .sorting_asc { background: url('assets/img/sort_asc.png') no-repeat center right; }
table.table thead .sorting_desc { background: url('assets/img/sort_desc.png') no-repeat center right; }

table.table thead .sorting_asc_disabled { background: url('assets/img/sort_asc_disabled.png') no-repeat center right; }
table.table thead .sorting_desc_disabled { background: url('assets/img/sort_desc_disabled.png') no-repeat center right; }

table.dataTable th:active {
	outline: none;
}

/* Scrolling */
div.dataTables_scrollHead table {
	margin-bottom: 0 !important;
	border-bottom-left-radius: 0;
	border-bottom-right-radius: 0;
}

div.dataTables_scrollHead table thead tr:last-child th:first-child,
div.dataTables_scrollHead table thead tr:last-child td:first-child {
	border-bottom-left-radius: 0 !important;
	border-bottom-right-radius: 0 !important;
}

div.dataTables_scrollBody table {
	border-top: none;
	margin-bottom: 0 !important;
}

div.dataTables_scrollBody tbody tr:first-child th,
div.dataTables_scrollBody tbody tr:first-child td {
	border-top: none;
}

div.dataTables_scrollFoot table {
	border-top: none;
}




/*
 * TableTools styles
 */
.table tbody tr.active td,
.table tbody tr.active th {
	background-color: #08C;
	color: white;
}

.table tbody tr.active:hover td,
.table tbody tr.active:hover th {
	background-color: #0075b0 !important;
}

.table-striped tbody tr.active:nth-child(odd) td,
.table-striped tbody tr.active:nth-child(odd) th {
	background-color: #017ebc;
}

table.DTTT_selectable tbody tr {
	cursor: pointer;
	*cursor: hand;
}

div.DTTT .btn {
	color: #333 !important;
	font-size: 12px;
}

div.DTTT .btn:hover {
	text-decoration: none !important;
}


ul.DTTT_dropdown.dropdown-menu a {
	color: #333 !important; /* needed only when demo_page.css is included */
}

ul.DTTT_dropdown.dropdown-menu li:hover a {
	background-color: #0088cc;
	color: white !important;
}

/* TableTools information display */
div.DTTT_print_info.modal {
	height: 150px;
	margin-top: -75px;
	text-align: center;
}

div.DTTT_print_info h6 {
	font-weight: normal;
	font-size: 28px;
	line-height: 28px;
	margin: 1em;
}

div.DTTT_print_info p {
	font-size: 14px;
	line-height: 20px;
}



/*
 * FixedColumns styles
 */
div.DTFC_LeftHeadWrapper table,
div.DTFC_LeftFootWrapper table,
table.DTFC_Cloned tr.even {
	background-color: white;
}

div.DTFC_LeftHeadWrapper table {
	margin-bottom: 0 !important;
	border-top-right-radius: 0 !important;
	border-bottom-left-radius: 0 !important;
	border-bottom-right-radius: 0 !important;
}

div.DTFC_LeftHeadWrapper table thead tr:last-child th:first-child,
div.DTFC_LeftHeadWrapper table thead tr:last-child td:first-child {
	border-bottom-left-radius: 0 !important;
	border-bottom-right-radius: 0 !important;
}

div.DTFC_LeftBodyWrapper table {
	border-top: none;
	margin-bottom: 0 !important;
}

div.DTFC_LeftBodyWrapper tbody tr:first-child th,
div.DTFC_LeftBodyWrapper tbody tr:first-child td {
	border-top: none;
}

div.DTFC_LeftFootWrapper table {
	border-top: none;
}



</style>

<body>
<?php include "Menu.php";?>
<div  class="container">
<br><br><br>
     
     <table cellpadding="0" cellspacing="0" border="0"  class="table table-striped table-bordered" id="example">
	<thead>
		<tr>
			<th width="20%">DAC</th>
			<th width="20%">SongUniqueCode</th>
			<th width="25%">Content Name</th>
			<th width="25%">Album Name</th>
			<th width="15%">Language</th>
			<th width="15%">SubCategory</th>
		</tr>
	</thead>
	<tbody class="px12">
		<tr class="px12">
			<td colspan="5" class="dataTables_empty px12">Loading data from server</td>
		</tr>
	</tbody>
	
</table>



</div>
<script src="assets/js/jquery.js"></script>
<script src="assets/js/bootstrap-transition.js"></script>
<script src="assets/js/bootstrap-alert.js"></script>
<script src="assets/js/bootstrap-modal.js"></script>
<script src="assets/js/bootstrap-dropdown.js"></script>
<script src="assets/js/bootstrap-scrollspy.js"></script>
<script src="assets/js/bootstrap-tab.js"></script>
<script src="assets/js/bootstrap-tooltip.js"></script>
<script src="assets/js/bootstrap-popover.js"></script>
<script src="assets/js/bootstrap-button.js"></script>
<script src="assets/js/bootstrap-collapse.js"></script>
<script src="assets/js/bootstrap-carousel.js"></script>
<script src="assets/js/bootstrap-typeahead.js"></script>
<script src="assets/js/jquery.dataTables.js"></script>
<script src="assets/js/shCore.js"></script>
<script src="assets/js/TableTools.js"></script>
<script src="assets/js/ZeroClipboard.js"></script>
<script src="assets/js/DT_bootstrap.js"></script>
<script src="assets/js/dataTables.bootstrap.js"></script>


</body>

</html>
