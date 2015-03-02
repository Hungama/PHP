<?php if(!$flag) { ?>
	<?php if($_SESSION['usrId'] != 215) { ?>
		<!--a href="javascript:void(0);" onclick="openWindow(<?php echo $msisdn;?>,<?php echo $service_info;?>,'<?php echo $subsrv;?>')" style="text-decoration:none"><FONT COLOR="#0033FF" size='2px'>
		<B><span class="label label-info" id="">Click here to view subscription history<span></B></FONT></a>|-->

		<a href="javascript:void(0);" onclick="viewbillinghistory(<?php echo $msisdn;?>,<?php echo $service_info;?>,'<?php echo $subsrv;?>')" style="text-decoration:none">
		<FONT COLOR="#0033FF" size='2px'>
		<B><span class="label label-info" id="">Click here to view subscription history<span></B></FONT></a>

		<?php if($service_info!=2121){ ?>		
		<!--a href="javascript:void(0);" onclick="openWindow1('viewchargingDetails',<?php echo $msisdn;?>,<?php echo $service_info;?>)" style="text-decoration:none">
		<FONT COLOR="#0033FF" size='2px'><B><span class="label label-info">Click here to view Recharge/MCoupen history</span></B></FONT></a-->
		<a href="javascript:void(0);" onclick="viewchargingDetails(<?php echo $msisdn;?>,<?php echo $service_info;?>)" style="text-decoration:none">
		<FONT COLOR="#0033FF" size='2px'><B><span class="label label-info">Click here to view Recharge/MCoupen history</span></B></FONT></a>
		<? }	else {	?>
			<!--a href="javascript:void(0);" onclick="openWindow1('viewMessageDetails',<?php echo $msisdn;?>,<?php echo $service_info;?>)" style="text-decoration:none">
		<FONT COLOR="#0033FF" size='2px'>
		<B><span class="label label-info">Click here to view Message history</span></B></FONT></a-->

<a href="javascript:void(0);" onclick="viewMessageDetails('viewMessageDetails',<?php echo $msisdn;?>,<?php echo $service_info;?>)" style="text-decoration:none">
		<FONT COLOR="#0033FF" size='2px'><B><span class="label label-info">Click here to view Message history</span></B></FONT></a>
<?}?>

			<?php if($_SESSION['usrId']==1 || $_SESSION['usrId']==265) {  ?>
		<!--a href="javascript:void(0);" onclick="openWindow3('viewsMousDetail',<?php echo $msisdn;?>,<?php echo $service_info;?>)"><FONT COLOR="#0033FF" size='2px'><B>
		<span class="label label-important">Click here to view MOUS history</span></B></FONT></a-->
		
		<a href="javascript:void(0);" onclick="viewMessageDetails('viewsMousDetail',<?php echo $msisdn;?>,<?php echo $service_info;?>)" style="text-decoration:none">
		<FONT COLOR="#0033FF" size='2px'><B><span class="label label-info">Click here to view MOUS history</span></B></FONT></a>
		<?php } ?>
	<?php }?>
<?php }?>