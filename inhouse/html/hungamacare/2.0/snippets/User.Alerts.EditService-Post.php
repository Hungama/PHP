<?php
mysql_connect("localhost","kunalk.arora","google");
mysql_select_db("misdata");

$username = $_REQUEST['username'];
//$id = $_REQUEST['id'];
$PAN = $_REQUEST['PAN'];
$alert_type = $_REQUEST['alert_type'];

$Circles = @join($_REQUEST['Circle'],",");

//echo count($_REQUEST['Circle']);


if(count($_REQUEST['Circle']) == $PAN) {
	$Circles_2 = 'PAN';	
}

if(!$id) {
	$id = 'NULL';	
}

$ident = $_REQUEST['ident'];


if(strcmp($_REQUEST['action'],'del')==0) {
mysql_query("delete from tbl_usermanager_alerts where username='".$username."' and service='".$ident."' limit 1") or die(mysql_error());

echo '<script>
	
	$(\'#listService-refresh\').show();
	$(\'#listService-close\').hide();
	
</script><div class="well">Hey I\'ve received your deletion request. Since I do this in a bulk processing everyday at 3 AM in morning, please note that these changes will apply after 3 AM of the next/current day.</div>';

exit;	
}



mysql_query("insert into tbl_usermanager_alerts values (".$id.",'".$username."','".$alert_type."','".$ident."','".$Circles."','".$Circles_2."') ON DUPLICATE KEY UPDATE alert_type='".$alert_type."', circles='".$Circles."', circles_pan='".$Circles_2."' ") or die(mysql_error());

echo '<script>
	
	$(\'#listService-refresh\').show();
	$(\'#listService-close\').hide();
	
</script><div class="well">Hey I\'ve received your updation request. Since I do this in a bulk processing everyday at 3 AM in morning, please note that these changes will apply after 3 AM of the next/current day.</div>';
?>