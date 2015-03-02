<?php
session_start();
$loginid = $_SESSION['loginId'];
require_once("../2.0/incs/db.php");

if (isset($_REQUEST['act']) && $_REQUEST['act'] != '') {
      if ($_REQUEST['act'] == 'del') {
        $updatePauseQuery = "update vodafone_radio.tbl_radio_messageInterface set status=5 WHERE id='" . $_REQUEST['id'] . "'";
        mysql_query($updatePauseQuery, $dbConn);
        $message="Message deleted successfully.";
		?>
		<div width="85%" align="left" class="txt">
        <div class="alert alert-danger">
            <?php echo $message;?>
        </div>
		</div>

    <?php
	}
}

//Multiple deletion code
if (isset($_POST["sub"])) {
	$errmsg = '';;
	if (count($_POST["ids"]) > 0 ) {
		$all = implode(",", $_POST["ids"]);
/* //log query		
$logquery="select * from vodafone_radio.tbl_radio_messageInterface nolock where  id in($all)";
$query = mysql_query($logquery, $dbConn);
while ($deletedata = mysql_fetch_array($query)) {
	$sno=$deletedata['sno'];
	$message=$deletedata['message'];
	$type=$deletedata['type'];
	$circle=$deletedata['circle'];
	$priority=$deletedata['priority'];
	$status=$deletedata['status'];
	$added_on=$deletedata['added_on'];
	$added_by=$deletedata['added_by'];
$logPath = "logs/Request_delete" . date('Ymd') . ".txt";
$logData = $sno . "#" . $message . "#".$type. "#" . $circle . "#".$priority ."#" . $status . "#" . $added_on . "#"
 ."#" . $added_by . "#" . date("Y-m-d H:i:s") . "\n";
error_log($logData, 3, $logPath);
}
sleep(10); */

$sql = "update vodafone_radio.tbl_radio_messageInterface set status=5 WHERE id in($all)";
$query_delete = mysql_query($sql, $dbConn);
header('location:rule_creation.php#hangup');
		if ( @mysql_query($sql,$dbConn)) {
			$errmsg = successMessage("Rows has been deleted successfully");
		} else {
			$errmsg = errorMessage("Error while deleting.". mysql_error());	
		}
	} else {
		$errmsg = errorMessage("You need to select atleast one checkbox to delete!");
	}
	
}
//

$circle_info = array('DEL' => 'Delhi', 'GUJ' => 'Gujarat', 'WBL' => 'WestBengal', 'BIH' => 'Bihar', 'RAJ' => 'Rajasthan', 'UPW' => 'UP WEST', 'MAH' => 'Maharashtra',
    'APD' => 'Andhra Pradesh', 'UPE' => 'UP EAST', 'ASM' => 'Assam', 'TNU' => 'Tamil Nadu', 'KOL' => 'Kolkata', 'NES' => 'NE', 'CHN' => 'Chennai', 'ORI' => 'Orissa',
    'KAR' => 'Karnataka', 'HAY' => 'Haryana', 'PUN' => 'Punjab', 'MUM' => 'Mumbai', 'MPD' => 'Madhya Pradesh', 'JNK' => 'Jammu-Kashmir', 'PUB' => "Punjab", 'KER' => 'Kerala',
    'HPD' => 'Himachal Pradesh','PAN'=>'PAN');
	
$get_query = "select id,sno,message,type,circle,priority,added_on,added_by from ";
$get_query .=" vodafone_radio.tbl_radio_messageInterface nolock where status=1 and type='hangup' order by added_on DESC";

$query = mysql_query($get_query, $dbConn);
$numofrows = mysql_num_rows($query);
if ($numofrows == 0) {
    ?>
    <div width="85%" align="left" class="txt">
        <div class="alert alert-block">
            <h4>Ooops!</h4>Hey,  we couldn't seem to find any record.
        </div>
    </div>
    <?php
} else {
    ?>
    <center><div width="85%" align="left" class="txt">
            
            <div class="alert alert" >
                
                <a href="javascript:void(0);viewhanguphistory();" id="Refresh"><i class="fui-eye"></i></a>             
                <?php
                $limit = 100;
                echo " Displaying last " . $limit . " records";
                ?>
                </i>
            </div></div></center>
			<form name="f" method="post" action="viewhangupmessagelist_rahul.php">
        <div>
          <input type="submit" name="sub" value="Delete" class="submit_button" onClick="javscript:return confirm('Are you sure you want to delete?');" >
        </div>
        <?php echo $errmsg; ?>
    <TABLE class="table table-condensed table-bordered">
        <thead>
            <TR height="30">
			<th align="left"><input type="checkbox" name="chk_all" class="chk_all"></th>
				<th align="left"><?php echo 'Id'; ?></th>
                <th align="left"><?php echo 'Type'; ?></th>
                <th align="left" width="30%"><?php echo 'Message'; ?></th>
                <th align="left"><?php echo 'Circle'; ?></th>
                <th align="left"><?php echo 'Added On'; ?></th>
                <th align="left"><?php echo 'Added By'; ?></th>
				<th align="left"><?php echo 'Action'; ?></th>
            </TR>
        </thead>
        <?php
        $i=1;
        while ($summarydata = mysql_fetch_array($query)) {
            ?>
            <TR height="30">
			<td><input type="checkbox" name="ids[]" class="checkboxes" value="<?php echo $summarydata['id']; ?>" >
			
                <TD><?php echo $i; 
                ////echo $summarydata['id']; ?></TD>
                <TD><?php echo $summarydata['type']; ?></TD>
				<TD><?php echo $summarydata['message']; ?></TD>
				<TD><?php echo $circle_info[strtoupper($summarydata['circle'])]; ?></TD>
				<TD><?php echo date('j-M \'y g:i a', strtotime($summarydata['added_on'])); ?></TD>
				<TD><?php echo $summarydata['added_by']; ?></TD>
                 <TD>
                    <a href="javascript:void(0)" onclick="deleteHangUp('del','<?php echo $summarydata['id']; ?>')">Delete</a>
               </TD>

            </TR>
            <?php
            $i++;
        }
        echo "</TABLE>";
    }
    ?>
	</form>

    <?php mysql_close($dbConn);
    ?>
	
	<script type="text/javascript" src="js/jquery-1.9.0.min.js"></script>
	<script type="text/javascript">
$(document).ready(function () { 

	// binding the check all box to click event
    $(".chk_all").click(function () {
	
		var checkAll = $(".chk_all").prop('checked');
		if (checkAll) {
			$(".checkboxes").prop("checked", true);
		} else {
			$(".checkboxes").prop("checked", false);
		}	
        
    });
 
    // if all checkbox are selected, check the selectall checkbox and vise versa
    $(".checkboxes").click(function(){
 
        if($(".checkboxes").length == $(".subscheked:checked").length) {
            $(".chk_all").attr("checked", "checked");
        } else {
            $(".chk_all").removeAttr("checked");
        }
 
    });
	
});
</script>
<script type="text/javascript">
                
 function  deleteHangUp(act,id)
            {
var answer = confirm("Are You Sure To Delete This Hangup Message.");
                if(answer){ 
                }else{ 
                    return false;
                }
               
                $('#loading').show();
                $.ajax({
	     
                    url: 'viewhangupmessagelist.php',
                    data: 'id='+id+'&act='+act,
                    type: 'get',
                    cache: false,
                    dataType: 'html',
                    success: function (abc) {
                        $('#grid-view_upload_history').html(abc);
                        $('#loading').hide();
                    }
						
                });
                
            }
                </script>