<?php
$SKIP = 1;
ini_set('display_errors','0');
$start = (float) array_sum(explode(' ',microtime())); 

require_once("incs/database.php");
require_once("../../ContentBI/base.php");
require_once("../../cmis/base.php");
require_once("../incs/GraphColors-D.php");
sksort($Service_DESC);

$Query = mysql_query("select * from tbl_system_scheduler where tag='Content'") or die(mysql_error());
$Result = array();
while($Data = mysql_fetch_array($Query)) {
	$Result[strtolower($Data['service'])] = strtolower($Data['seqday']);	
}
$SEQDays = array('sun','mon','tue','wed','thu','fri','sat');
?><html>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <link href="assets/css/bootstrap.css" rel="stylesheet" />
 
  <link href="assets/css/style.css" rel="stylesheet" />
<link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
<link href="assets/css/datepicker.css" rel="stylesheet" />
<link href="assets/css/icons-sprites.css" rel="stylesheet" />
<link href="assets/css/token-input.css" rel="stylesheet" />
<link rel="stylesheet" href="assets/css/base.css" type="text/css" media="all" charset="utf-8" />

<style>
.px12 {
 font-size: 12px;	
}
.greencell {
background:#9F0;
height: 15px; width: 60px;  padding: -4px;
}
.greycell {
background: #e2e2e2;
height: 15px; width: 60px; padding: -4px;
	
}
</style>

<body>
<?php include "Menu.php";?>
<div class="container-fluid">
<br><br><br>
     <table width="100%"  id="Grid" style="font-size: 10px; background-color:transparent">
        <thead> <tr>
          <th>&nbsp;</th>
          <?php
		
		foreach($SEQDays as $Day) {
		?>
          <th><?php echo ucfirst($Day);?></th>
          <?php } ?>
          </tr>
          
          
         </thead>
        <tbody> 
          <?php
		
		
      foreach($Service_DESC as $ServiceName=>$values) {
	  ?>
          <tr>
          <td><?php echo $values['Name'];?></td>
          <?php for($i=0;$i<count($SEQDays);$i++) {?>
            <td><div class="<?php 
			if($Result[strtolower($ServiceName)]) {if(strcmp($SEQDays[$i],($Result[strtolower($ServiceName)])) == 0) {echo 'greencell';}} else{
			echo "greycell";	
			}
			?>">&nbsp;</div></td>
           <?php } ?>
           <tr>
		<?php } ?></tbody>
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
<script src="assets/js/jquery.fixheadertable.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#Grid').fixheadertable({
			colratio    : [300, 60,60,60,60,60,60,60],
             height  : 500,
			     zebra      : true

        });
		
		
		
		
    });
	
</script>
</body>

</html>
