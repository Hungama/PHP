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
    <TABLE class="table table-condensed table-bordered">
        <thead>
            <TR height="30">
              
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

    <?php mysql_close($dbConn);
    ?>
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