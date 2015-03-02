<?php
include("session.php");
include("db.php");
$msisdn=$_REQUEST['msisdn'];
$type=$_REQUEST['type'];

if($type==1)
{
	//find missed call of a user
$sql_getmsisdninfo = mysql_query("select ANI,date_time,DNIS,circle,operator from newseleb_hungama.tbl_max_bupa_details where ANI='".$msisdn."' order by date_time DESC");
$isfound=mysql_num_rows($sql_getmsisdninfo);
if($isfound==0)
{
echo "<tr><th class=\"full\" colspan=\"4\">MSISDN  Information</th></tr>";
echo "<tr>
						<th>MSISDN</th>
						<th>Date & Time</th>
						<th>Circle</th>
						<th>Operator</th>
						</tr>";
	
echo "<tr><td class=\"first style1\" colspan=\"4\"><center>No record found</center></td></tr>";
}
else
{
echo "<tr><th class=\"full\" colspan=\"4\">MSISDN  Information</th></tr>";
echo "<tr>
						<th>MSISDN</th>
						<th>Date & Time</th>
						<th>Circle</th>
						<th>Operator</th>
						</tr>";
	while($result_info = mysql_fetch_array($sql_getmsisdninfo))
	{
	echo "<tr>
						<td>$result_info[ANI]</td>
						<td>$result_info[date_time]</td>
						<td>$result_info[circle]</td>
						<td>$result_info[operator]</td>
						</tr>";
	}
}
}
else
{
	//find content usages of a user
$sql_getmsisdninfo = mysql_query("select ANI,SUM(duration) as duration ,operator,circle from hul_hungama.tbl_hulobd_success_fail_details where ANI='".$msisdn."'");
$isfound=mysql_num_rows($sql_getmsisdninfo);
if($isfound==0)
{
//echo "<tr><th class=\"full\" colspan=\"4\">Content Usages Information</th></tr>";
echo "<tr>
						<th>MSISDN</th>
                        <th>Duration(Till date -in sec)</th>
						<th>Operator</th>
						<th>Circle</th>
						</tr>";
	
echo "<tr><td class=\"first style1\" colspan=\"4\"><center>No record found</center></td></tr>";
}
else
{
//echo "<tr><th class=\"full\" colspan=\"4\">Content Usages Information</th></tr>";
echo "<tr>
						<th>MSISDN</th>
						<th>Duration(Till date -in sec)</th>
						<th>Operator</th>
						<th>Circle</th>
						</tr>";
	while($result_info = mysql_fetch_array($sql_getmsisdninfo))
	{
	echo "<tr>
						<td>$result_info[ANI]</td>
						<td>$result_info[duration]</td>
						<td>$result_info[operator]</td>
						<td>$result_info[circle]</td>
						</tr>";
	}
}
}
?>