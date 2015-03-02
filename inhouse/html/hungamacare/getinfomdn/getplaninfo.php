<?php
include("session.php");
include("db.php");
$str=$_REQUEST['str'];
//list all services based on operator
$sql_planinfo = mysql_query("select iAmount from master_db.tbl_plan_bank where Plan_id='".$str."' order by iAmount ASC");
$isfound=mysql_num_rows($sql_planinfo);
$isfound=1;
if($isfound==0)
{
echo "NO Service found";
}
else
{
echo "<select name=\"obd_form_priceamount\" id=\"obd_form_priceamount\" onchange=\"setAmount(this.value)\">";
echo "<option value=\"\">Select amount</option>";
while($data=mysql_fetch_array($sql_planinfo))
{
echo "<option value=\"$data[iAmount]\">$data[iAmount]</option>";
}
echo "</select>";
}
mysql_close($con);
?>