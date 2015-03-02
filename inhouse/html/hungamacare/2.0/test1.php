<?php
session_start();
$SKIP=1;
ini_set('display_errors','0');
require_once("incs/db.php");
$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa', 'KAR'=>'Karnataka', 'HAR'=>'Haryana','PUB'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh',''=>'Other','HAY'=>'Haryana');
$query_liveservices = "select Service from misdata.base where type='LiveContent' and value in(1,'true')";	
$result_liveservices = mysql_query($query_liveservices,$dbConn_218) or die(mysql_error());
$live_services=array('AirtelEU'=>'Airtel - Entertainment Unlimited','AirtelDevo'=>'Airtel - Sarnam');
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- include all required CSS & JS File start here -->
<?php 
require_once("main-header.php");
?>
<!-- include all required CSS & JS File end here -->
<title>>Airtel EU: Content Information</title>
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
<script type="text/javascript">
</script>
</head>

<body>

<div class="navbar navbar-inner">
<div class="container-fluid">
<a href="#menu-bar" class="second"><button class="btn btn-primary"><i class="icon-align-justify"></i> Menu</button></a>

<div class="btn-group pull-right">
	<select name="service" id="service" class="span2" onchange="setServiceData();">
				<option value="">Select Service</option>
				
<?php
while($data_liveservices = mysql_fetch_array($result_liveservices))
{?>
<option value="<?php echo $data_liveservices[0];?>"><?php echo $live_services[$data_liveservices[0]];?></option>
<?php }?>
	<!--option value="devo">Airtel - Sarnam</option>
				<option value="eu">Airtel - Entertainment Unlimited</option-->
			
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
     <a href="#" onclick="javascript:mytable()">Click me</a>
<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered dataTable" id="example_mu" aria-describedby="example_info">
	<thead>
		<tr role="row"><th width="20%" class="sorting_asc" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 186px;" aria-label="DAC: activate to sort column ascending">DAC</th><th width="20%" class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 203px;" aria-label="SongUniqueCode: activate to sort column ascending">SongUniqueCode</th><th width="25%" class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 241px;" aria-label="Content Name: activate to sort column ascending">Content Name</th><th width="25%" class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 239px;" aria-label="Album Name: activate to sort column ascending">Album Name</th><th width="15%" class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 97px;" aria-label="Language: activate to sort column ascending">Language</th><th width="15%" class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 101px;" aria-label="SubCategory: activate to sort column ascending">SubCategory</th></tr>
	</thead>
	
	
<tbody class="px12" role="alert" aria-live="polite" aria-relevant="all"><tr class="odd"><td class=" sorting_1">522226000001</td><td class="">IN-S18-94-11768</td><td class="">EKI PREM</td><td class="">SURER ABESH</td><td class="">Bengali</td><td class="">Evergreen</td></tr><tr class="even"><td class=" sorting_1">522226000002</td><td class="">IN-S18-94-11769</td><td class="">JEEVAN NODIR</td><td class="">SURER ABESH</td><td class="">Bengali</td><td class="">Evergreen</td></tr><tr class="odd"><td class=" sorting_1">522226000003</td><td class="">IN-S18-94-11770</td><td class="">BANDHINI HRIDAY</td><td class="">SURER ABESH</td><td class="">Bengali</td><td class="">Evergreen</td></tr><tr class="even"><td class=" sorting_1">522226000004</td><td class="">IN-S18-94-11771</td><td class="">ANDHAKAR</td><td class="">SURER ABESH</td><td class="">Bengali</td><td class="">Evergreen</td></tr><tr class="odd"><td class=" sorting_1">522226000005</td><td class="">IN-S18-94-11772</td><td class="">KAKHONO MEGH</td><td class="">SURER ABESH</td><td class="">Bengali</td><td class="">Evergreen</td></tr><tr class="even"><td class=" sorting_1">522226000006</td><td class="">IN-S18-94-11773</td><td class="">AKASH JODI</td><td class="">SURER ABESH</td><td class="">Bengali</td><td class="">Evergreen</td></tr><tr class="odd"><td class=" sorting_1">522226000007</td><td class="">IN-S18-94-11774</td><td class="">KACHHE AACHHO</td><td class="">SURER ABESH</td><td class="">Bengali</td><td class="">Evergreen</td></tr><tr class="even"><td class=" sorting_1">522226000008</td><td class="">IN-S18-94-11775</td><td class="">KATO PATH</td><td class="">SURER ABESH</td><td class="">Bengali</td><td class="">Evergreen</td></tr><tr class="odd"><td class=" sorting_1">522226000009</td><td class="">IN-S18-94-11776</td><td class="">JEEVAN NODIR</td><td class="">SURER ABESH</td><td class="">Bengali</td><td class="">Evergreen</td></tr><tr class="even"><td class=" sorting_1">522226000010</td><td class="">IN-S18-04-62488</td><td class="">HOLI MEIN HUDDANG MACHA DE</td><td class="">DEVAR BHABHI</td><td class="">Bhojpuri</td><td class="">Popular</td></tr></tbody></table>

</div>


<!-- Footer section start here-->
  <?php
 require_once("footer.php");
  ?>
<!-- Footer section end here-->
    <script>
	$('#loading').hide();
$('#grid').hide();	
		
function showContent_data(cat,circle,lang,clip,rel) {
//alert('cat='+cat+'&circle='+circle+'&lang='+lang+'&clip='+clip+'&rel='+rel);
document.getElementById('mainmenu_cat_div_eu').style.display = 'none';
document.getElementById('ACdiv3').style.display = 'none';
document.getElementById('ac2Div').style.display = 'none';
document.getElementById('ACdiv1').style.display = 'none';

	   $('#loading').show();
		$('#grid').hide();
		$('#grid').html('');
		$.fn.GetContentDetails(cat,circle,lang,clip,rel);
	};
	
$.fn.GetContentDetails = function(cat,circle,lang,clip,rel) {
		$.ajax({
		
		//alert("cat="+cat+"&clip="+clip+"&circle="+circle+"&lang="+lang+"&rel="+rel);
				     	url: 'showContent.php',
					    data: 'cat='+cat+'&circle='+circle+'&lang='+lang+'&clip='+clip+'&rel='+rel,
						type: 'get',
						cache: false,
						dataType: 'html',
						success: function (abc) {
							$('#grid').html(abc);
							$('#loading').hide();
						}
						
					});
						
					$('#grid').show();
	
};

    $(".second").pageslide({ direction: "right", modal: true });
	
</script>
<script src="assets/js/jquery.dataTables.js"></script>
<script src="assets/js/TableTools.js"></script>
<script src="assets/js/ZeroClipboard.js"></script>
<script src="assets/js/DT_bootstrap.js"></script>
<script src="assets/js/dataTables.bootstrap.js"></script>  
</body>
</html>