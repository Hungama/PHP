<?php
require_once("incs/db.php");
$rule_id = $_REQUEST['rule_id'];
$action = $_REQUEST['act'];
//Message status means- 0-overwrite, 1-active, 5-deleted, 10 - processed
$messageDisplayQuery="select * from honeybee_sms_engagement.tbl_new_sms_engagement nolock where rule_id='".$rule_id."' and status in(5,1,10)";
$querymessagedisplay = mysql_query($messageDisplayQuery, $dbConn);
$rulemessagecount=  mysql_num_rows($querymessagedisplay);
$rule_array = mysql_fetch_array(mysql_query("SELECT rule_name FROM honeybee_sms_engagement.tbl_rule_engagement where id='" . $rule_id . "'", $dbConn));
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="myModalLabel">Rule Name- <?php echo $rule_array['rule_name']; ?></h4>
</div>
<div class="modal-body">
    
    <?php if($action=='del'){ 
$id= $_REQUEST['id'];
$updateMsh = "update honeybee_sms_engagement.tbl_new_sms_engagement set status = '5' where id='" . $id. "'";
$msgupdate = mysql_query($updateMsh, $dbConn);
    } else {
    ?>
    
    <form id="form-edit" name="form-edit" method="post" enctype="multipart/form-data">
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
<td align="center" colspan="2">
<?php
if($message_array['status']=='10')
$fileStatus='<span class="label label-info">Processed</span>';
else if($message_array['status']=='1') 
$fileStatus='<span class="label label-success">Active</span>';
else if($message_array['status']=='5') 
$fileStatus='<span class="label label-warning">Deleted</span>';

echo $fileStatus;
?>
</td>
<td align="center" colspan="2"><?php if($message_array['status']=='1'){ ?><a href="javascript:void(0)" onclick="deleteMessage('<?php echo $message_array['id']; ?>')">Delete</a><?php }else{ echo 'N/A'; } ?> </td>
</tr>
            <?php }
}else {?>
                        <tr>
<td align="center" colspan="2"><strong>There is No Message in this rule Id.</strong></td>
            </tr>
            <?php } ?>
        </table>
    </form>
    <?php } ?>
            </div>
<div class="modal-footer">
    
</div>
