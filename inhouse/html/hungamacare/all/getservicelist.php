<?php
include("session.php");
include("db.php");
$str=$_REQUEST['str'];
$type=$_REQUEST['type'];
if($type=='op')
{
//list all services based on operator
$sql_getservicelist = mysql_query("select service_id,operator,service_name,description from master_db.tbl_service_master where operator='".$str."'");
$isfound=mysql_num_rows($sql_getservicelist);
$isfound=1;
if($isfound==0)
{
echo "NO Service found";
}
else
{
echo "<option value=\"\">Select service</option>";
while($data=mysql_fetch_array($sql_getservicelist))
{
echo "<option value=\"$data[service_id]\">$data[service_name]</option>";
}
}
}
else if($type=='pp')
{
//list all price point based on service id
$sql_getpricepointlist = mysql_query("select Plan_id,iAmount from master_db.tbl_plan_bank where S_id='".$str."' order by Plan_id ASC");
$isfound=mysql_num_rows($sql_getpricepointlist);
$isfound=1;
if($isfound==0)
{
echo "No Price Point found";
}
else
{
//echo "<select name=\"obd_form_pricepoint\" id=\"obd_form_pricepoint\" onchange=\"getPlannfo(this.value)\">";
echo "<option value=\"\">Select pricepoint</option>";
while($data=mysql_fetch_array($sql_getpricepointlist))
{
echo "<option value=\"$data[Plan_id]\">$data[Plan_id]</option>";
}
}
//echo "</select>";
}
mysql_close($con);
?>