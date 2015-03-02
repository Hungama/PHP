<?php

mysql_connect("localhost","kunalk.arora","google");
mysql_select_db("misdata");

$USERNAME=$_REQUEST['username'];
$ACT = $_REQUEST['act'];

require_once("../../../ContentBI/base.php");

//echo "select * from public_acts where username='".$USERNAME."' and type='".$ACT."' order by ID DESC limit 30";exit;

$Query_ALL = mysql_query("select id from public_acts where username='".$USERNAME."' and type='".$ACT."'") or die(mysql_error());
$COUNT_ALL = mysql_num_rows($Query_ALL);
$Query = mysql_query("select * from public_acts where username='".$USERNAME."' and type='".$ACT."' order by ID DESC limit 30") or die(mysql_error());
$Count = mysql_num_rows($Query);
?>
<?php if($Count == 0) {?>
    <div class="alert alert-block">
  
  <h4>Ooops!</h4>
  Hey, we couldn't seem to find any of your last requests....
</div> 

<?php 
exit;
} ?>
<div class="well well-small">
 		<a href="javascript:$.fn.AjaxAct('<?php echo $ACT;?>','');" id="Refresh"><i class="icon-refresh"></i></a> Displaying <?php echo $Count;?> of last <?php echo $COUNT_ALL;?> requests
</div><table class="table table-condensed table-bordered">
     <thead> <tr>
        <th width="7%" align="left">ID</th>
        <th width="14%" align="left">Service</th>
        <th width="15%" align="left">Added On</th>
        <th width="11%" align="left">Status</th>
        <th width="17%" align="left">Processing 
          Started at</th>
        <th width="21%" align="left">Completed At</th>
        <th width="17%" align="left">Output File</th>
      </tr></thead>
      <?php
		
		

      
	  while($T = mysql_fetch_array($Query)) {

		switch($ACT) {
		
	case 'ContentDump':		
		
		 list($Circles,$From,$To,$Type,$Service) = explode('|',$T['filename'],5);
		 break;	
		
	case 'Social':
	     list($Circles,$From,$To,$Service) = explode('|',$T['filename'],5);
		break;
	case 'MDNDump':
		list($Junk,$Service,$Random) = explode('____',$T['filename']);
		break;
		
		default:
		
		 list($Circles,$From,$To,$Type,$Tbl) = explode('|',$T['filename'],5);
		 list($Table,$ColVal,$Service) = explode(",",$Tbl);
		}
		
	?>
      <tr>
        <td align="left"><?php echo $T['id'];?></td>
        <td align="left"><nobr><?php echo $Service_DESC[$Service]["Name"];?></nobr></td>
        <td align="left"><?php if($T['added']) echo date('j-M g:i a',strtotime($T['added']));?></td>
        <td align="left"><span class="label label-<?php echo Colorize($T['status']);?>"><?php echo $T['status'];?></span></td>
        <td align="left"><?php if($T['started']) echo date('j-M g:i a',strtotime($T['started']));?></td>
        <td align="left"><?php if($T['completed']) echo date('j-M g:i a',strtotime($T['completed']));?></td>
        <td align="left"><?php if(file_exists("../../../cmis/tmp/".$T['output_file']) && strcmp($T["status"],"Processed") == 0) {echo "<a href='../../cmis/tmp/".$T['output_file']."'>Download</a>";?>
          (<?php echo number_format($T['mdn_out'])." KB)";} else{
			?><?php  
		  }?></td>
      </tr>
      <?php } ?>
    
    </table>
    <?php
@mysql_close();
?>
<?php
function Colorize($IN) {
switch($IN) {
	case 'Processed':
	return 'success';
	break;	
	case 'Processing':
	return 'warning';
	break;	
	case 'Queued':
	return 'info';
	break;	
	case 'Error':
	return 'error';
	break;	
	
	default: 
	return '';
	
}
}
?>