<?php
include("dbconfig.php");
?>
<html>
<head>
<title>------------</title>

</head>
<body leftmargin="0" topmargin="0">
   <BR/>
<BR/>
  <table align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" width="40%">
    <tbody><tr> 
      <td align="center" bgcolor="#ffffff"> 
        <table class="txt2" bgcolor="#e6e6e6" border="0" cellpadding="0" cellspacing="1" width="100%">
          <tbody><tr> 
            <td colspan="2" align="center" bgcolor="#ffffff" height="25">&nbsp;</td>
          </tr><form name="frm" action="callcenter.php" method="post" onSubmit="">
          <tr> 
            <td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><strong>Select Services</strong>  
              : </td>
            <td style="padding-left: 5px;" bgcolor="#ffffff" height="35"><label>
			<?php
			$get_service="select distinct (service_name) from master_db.tbl_apps_service";
			$query1 = mysql_query($get_service, $livecon);
			?>
              <select name="operator" id="operator" >
                <option value="0">-Select services-</option>
			<?php
			while($row2 = mysql_fetch_array($query1))
			{
			$op_name=$row2['service_name'];
			if(($op_name == "") || ($op_name=='null'))
			{
			echo "hello";
			}
			else{
			?>
            <option value="<?=$op_name?>"><?=$op_name?></option>
            <?php
			}
			}
			?>
              </select>
            </label></td>
          </tr>
          <tr align="center"> 
            <td style="padding-left: 5px;" colspan="2" bgcolor="#ffffff" height="35"> 
              <input name="submit" class="submit" value="" type="submit" src="submit.jpg">
             &nbsp;&nbsp;&nbsp;</td>
          </tr></form>
        </tbody></table>
      </td>
    </tr>
  </tbody></table>
<br><br>
</div>  
</body>
</html>