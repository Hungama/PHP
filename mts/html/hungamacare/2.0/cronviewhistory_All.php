<?php
$todaydate=date("Y-m-d");
$sid = $_GET['sid'];
$bid = $_GET['bid'];
$Added_On = $_GET['Added_On'];
$lastmodify = $_GET['lastmodify'];
//echo $sid."#".$bid."#".$Added_On."#".$lastmodify."<br>";
$serviceDescArray = array('1123' => 'MTS - Monsoon Dhamaka', '1423' => 'Uninor - Khelo India Jeeto India');
function createDateRangeArray($strDateFrom,$strDateTo) {
  // takes two dates formatted as YYYY-MM-DD and creates an
  // inclusive array of the dates between the from and to dates.

  // could test validity of dates here but I'm already doing
  // that in the main script

  $aryRange=array();

  $iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2),     substr($strDateFrom,8,2),substr($strDateFrom,0,4));
  $iDateTo=mktime(1,0,0,substr($strDateTo,5,2),     substr($strDateTo,8,2),substr($strDateTo,0,4));

  if ($iDateTo>=$iDateFrom) {
    array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry

    while ($iDateFrom<$iDateTo) {
      $iDateFrom+=86400; // add 24 hours
      array_push($aryRange,date('Y-m-d',$iDateFrom));
    }
  }
  return $aryRange;
}
$alldated=createDateRangeArray($Added_On,$lastmodify);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <!-- include all required CSS & JS File start here -->
        <?php
        require_once("main-header.php");
        ?>
        <!-- include all required CSS & JS File end here -->
  </head>

    <body>
 <div width="85%" align="left" class="txt">
            <div class="alert alert" >
			<a href="sms_engagement.php">Go Back</a>&nbsp;&nbsp;
		<?php
		echo "Cron schedule history for " . $serviceDescArray[$sid] . "";
		?>
			   </div></div>
  <div class="container">
            <div class="row">          
		  <TABLE class="table table-condensed table-bordered">
                <thead>
                    <TR height="30">
                        <th align="left"><?php echo 'Id'; ?></th>
                        <th align="left"><?php echo 'File Date'; ?></th>
                        <th align="left"><?php echo 'Output File'; ?></th>
                    </TR>
                </thead>
<?php
				foreach($alldated as $d_val)
{
$fileurl="http://10.130.14.106/cotestlogs/".$sid.'_'.$bid.'_'.$d_val.'.txt';
?>
 <TR height="30">
                        <td align="left"><?php echo $bid; ?></td>
                        <td align="left"><?php echo $d_val; ?></td>
                        <td align="left"><a href="<?php echo $fileurl;?>" target="_blank">View</a></td>
                    </TR>
<?php
}
?>
                </TABLE>
				
            </div>
        </div>
        <!-- Footer section start here-->
        <?php
        require_once("footer.php");
        ?>
        <!-- Footer section end here-->
        <script src="assets/js/jquery.pageslide.js"></script>   
		  <!-- added for file uplaod using bootstarp api-->
		   <script>
		    $(".second").pageslide({ direction: "right", modal: true });
        </script>
    </body>
</html>