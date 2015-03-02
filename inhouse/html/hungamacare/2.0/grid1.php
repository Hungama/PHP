<?php
session_start();
$SKIP=1;
ini_set('display_errors','0');
require_once("incs/db.php");
$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa', 'KAR'=>'Karnataka', 'HAR'=>'Haryana','PUB'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh',''=>'Other','HAY'=>'Haryana');
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php 
require_once("main-header.php");
?>
<!--style>
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



</style-->
</head>

<body>

<div class="navbar navbar-inner">
<div class="container-fluid">
<a href="#menu-bar" class="second"><button class="btn btn-primary"><i class="icon-align-justify"></i> Menu</button></a>

<div class="btn-group pull-right">
	<select name="service" id="service" class="span2" onchange="setServiceData();">
				<option value="">Select Service</option>
				<option value="devo">Airtel Devotional</option>
				<option value="eu">Airtel EU</option>
			</select>
		<select name="circle" id="circle" onchange="setCircleData(this.value);" class="span2">
				<option value="">Select Circle</option>
				<?php foreach($circle_info as $circle_id=>$circle_val) { ?>
					<option value=<?php echo $circle_id?>><?php echo $circle_val;?></option>
				<?php } ?>
			</select>
		<span id='langDiv'>
		<select name="lang" id="lang" class="span2">
				<option value="">Select Language</option>
			</select>
			</span>
		
       
          </div>
</div>

</div>

<div class="container">

<br><br><br>
     
     <table cellpadding="0" cellspacing="0" border="0"  id="example">
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
			<td colspan="6" class="dataTables_empty px12">Loading data from server</td>
		</tr>
	</tbody>
	<tr><td colspan="6"><br></br></td></tr>
</table>
</div>


<!-- Footer section start here-->
  <?php
 require_once("footer.php");
  ?>
<!-- Footer section end here-->
 <script src="assets/js/jquery.dataTables.js"></script>
<script src="assets/js/TableTools.js"></script>
<script src="assets/js/ZeroClipboard.js"></script>
<script src="assets/js/DT_bootstrap.js"></script>
<script src="assets/js/dataTables.bootstrap.js"></script>  
</body>
</html>