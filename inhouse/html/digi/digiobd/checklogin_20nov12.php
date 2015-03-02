<?php 
session_start();
$_SESSION["n1"] = $_POST["obd_form_uname"];
$_SESSION["p1"] = $_POST["obd_form_pwd"];
?>
<?php include("db.php"); ?> 
<?php 
$name=$_POST["obd_form_uname"];
$password=$_POST["obd_form_pwd"];
$qr="select role from login_table where username = '".$name."' AND password= '".$password."' ";
$a=mysql_query($qr);
$c=mysql_fetch_array($a);
if(!$c)
{session_unset();
echo "<script>alert('Either User name or Password is incorrect')</script>";
echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=index.html">';
}
else
{
     if($c['role']=="admin")
      	{
            echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=digiobd.php">';
     	}
     else if($c['role']=="hul")
	    {
            echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=hulobd.php">';
     	}
	 else if($c['role']=="digi")
     	{
            echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=digiobd.php">';
     	}
$_SESSION["role"] =$c['role'];
}
?>