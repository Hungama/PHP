<?php
include 'db.php';
$optid=$_REQUEST['p'];
if($optid=='01')
{
//echo "Modi campaigns in Mandi, calls PM 'Maun Mohan Singh Kejriwal questions Jaipal's removal from petroleum ministry";
echo "<ul style='list-style:none'><li>First</li><li>Second</li><li>Third</li><li>Four</li><li>Five</li></ul>";
}
else if($optid=='02')
{
echo "Being a star wife does not guarantee good style. Maybe these ladies must learn a little from their husbands";
}
else if($optid=='03')
{
echo "Their blood maybe blue, but love is blind! Here's a look at royals who gave us fairytale romances.";
}
else
{
echo "Invalid option";
}
?>