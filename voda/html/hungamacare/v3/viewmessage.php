<?php
require_once("../2.0/incs/db.php");
$rule_id = $_REQUEST['rule_id'];
$action = $_REQUEST['act'];


$messageDisplayQuery="select * from master_db.tbl_new_sms_engagement where rule_id='".$rule_id."'";
$querymessagedisplay = mysql_query($messageDisplayQuery, $dbConn);
$rulemessagecount=  mysql_num_rows($querymessagedisplay);
$rule_array = mysql_fetch_array(mysql_query("SELECT rule_name FROM master_db.tbl_rule_engagement where id='" . $rule_id . "'", $dbConn));

?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="myModalLabel"><?php echo $rule_array['rule_name']; ?>Message </h4>
</div>
<div class="modal-body">
    <?php if($action=='view'){ ?>
        <table class="table table-bordered table-condensed">
<?php if($rulemessagecount>0){ ?>
            <tr>
<td align="center" colspan="2">Message</td>
<td align="center" colspan="2">Status</td>
<td align="center" colspan="2">Action</td>

            </tr>
            
            <?php while($message_array = mysql_fetch_array($querymessagedisplay)) { ?>
            <tr>
<td align="center" colspan="2"><?php echo $message_array['message']; ?> </td>
<td align="center" colspan="2"><?php if($message_array['status']=='10'){ echo 'Processed'; } else if($message_array['status']=='1') { echo 'Active'; } else if($message_array['status']=='5') { echo 'Deleted'; } ?> </td>
<!--<td align="center" colspan="2"><?php if($message_array['status']=='1'){ ?><a href="javascript:void(0)" onclick="showeditmessage('<?php echo $message_array['id']; ?>')">Edit</a><?php }else{ echo 'N/A'; } ?> </td>-->
<td align="center" colspan="2"><?php if($message_array['status']=='1'){ ?><!--button type="button" class="btn btn-danger" onclick="SubmitEditMessage('<?php echo $message_array['id']; ?>')">Delete</button--><a href="javascript:void(0)" onclick="deleteMessage('<?php echo $message_array['id']; ?>')">Delete</a><?php }else{ echo 'N/A'; } ?> </td>

            </tr>
            <?php }
}





else {
    
 
    
    ?>
                        <tr>
<td align="center" colspan="2"><strong>There is No Message in this rule Id.</strong></td>
            </tr>
            <?php } ?>
        </table>
        <?php }
        

        
        else{ 
    
 $id= $_REQUEST['id'];
//echo $id;

if($action=='del'){
  $updateMsh = "update master_db.tbl_new_sms_engagement set status = '5' where id='" . $id. "'";
$msgupdate = mysql_query($updateMsh, $dbConn); 
}
            
 //$edit_message= mysql_fetch_array($querymessagedisplay);
            ?>
            
<!--<form id="form-edit" name="form-edit" method="post" enctype="multipart/form-data">
        <table class="table table-bordered table-condensed">
<tr>
<td align="center" colspan="2">Message</td>
<td align="center" colspan="2">
    
    <textarea name="message" id="message" ><?php echo $edit_message['message']; ?></textarea></td></tr>
<tr>
    <td align="center" colspan="2"></td>
<td align="center" colspan="2"><button type="button" class="btn btn-primary" onclick="SubmitEditMessage('<?php echo $edit_message['id']; ?>')">Save Message</button></td>
</tr>

        </table>
</form>-->
            <?php } ?> 
            </div>
<div class="modal-footer">
    
</div>
