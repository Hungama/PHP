<?php
session_start();
//include("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
<title>Hungama Customer Care</title>
<link rel="stylesheet" href="style.css" type="text/css">
<style type="text/css">
<!--
.style3 {font-family: "Times New Roman", Times, serif}
-->
</style>
<script language="javascript">
function logout()
{
        window.parent.location.href = 'index.php?logerr=logout';
}
</script>
<script language="javascript">

 function checkfield(){   
        if(document.frm.upfile.value == "") {
                alert("Please upload file, Try again!");
                return false;
        }

        if(document.frm.upfile.value) {
                var file_name = document.frm.upfile.value;
                var ext = file_name.split('.');
                if(ext[1] == 'csv') {
                        return true;
                } else {
                        alert('Invalid file, Please upload csv file only.');
                        return false;
                }
        }
   return true;
}

</script>

</head>
<body leftmargin="0" topmargin="0" link="#000000" alink="#000000" bgcolor="#ffffff" text="#000000" marginheight="0" marginwidth="0" vlink="#000000">
<?php
       $logoPath='images/logo.png';
       include("header.php");
	//------ upload file or entry single number -------------------
        if($_SERVER['REQUEST_METHOD']=="POST" && ( isset($_FILES['upfile']) && !empty($_FILES['upfile']['name']) ))
        {
			$file = $_FILES['upfile'];
			$allowedExtensions = array("csv");

			function isAllowedExtension($fileName) {
					global $allowedExtensions;
					return in_array(end(explode(".", $fileName)), $allowedExtensions);
			}

			if(isAllowedExtension($file['name'])) {
				$uploaddir = "csvFiles/";
				if(!is_dir($uploaddir))
				{
					mkdir($uploaddir);
						chmod($uploaddir,0777);
				}

				$tempFileName = explode(".", $_FILES['upfile']['name']) ;
				$fileName = $tempFileName[0].".".$tempFileName[1];
				$filenametxt =  $tempFileName[0].".txt";

				$path = $uploaddir.$fileName;
				$txtFilePath="/var/www/html/kmis/services/hungamacare/csvFiles/txtFiles/".$filenametxt;

	            if(move_uploaded_file($_FILES['upfile']['tmp_name'], $path)) {
					$file_to_read="http://10.2.73.156/kmis/services/hungamacare/csvFiles/".$fileName;
                    $file_name=file($file_to_read);
                    $file_size=sizeof($file_name);
					if($file_size <= 20000) {	
						$msg = "File uploaded successfully.<br/>";	
                        for($i=1;$i<$file_size;$i++) {  //echo "<br/>";
							$writeData=explode(",",$file_name[$i]);
							$fileWriteLine = $writeData[0]."#".$writeData[1]."#".$writeData[2]."#".$writeData[3];
							error_log($fileWriteLine,3,$txtFilePath);
						}
        	            $msg .="Txt file created successfully<br/><br/>";
					} else {
						$msg .= "file size is more than 20000. Please upload again!";
						unlink($file_to_read);
			        }
               	} else {
               		$msg = "File not upload successfully, Please try again!<br/><br/>";
          		}
	         } else {
		       	$msg = "Invalid file type, Please try again!<br/><br/>";
			 }
		 }	
?>
<TABLE width="80%" align="center" border="0" cellpadding="0" cellspacing="0" class="txt">
      <TBODY>
      <?php  if($msg) { ?>
        <TR height="30" width="100%">
                <TD colspan="4" bgcolor="#FFFFFF" align="center"><?php echo $msg;?></TD>
        </TR>
      <?php } ?>
      </TBODY>
</TABLE>

 <form name="frm" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>" onSubmit="return checkfield()" enctype="multipart/form-data">
    <TABLE width="50%" align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" class="txt">
      <TBODY>
      <TR height="30">
        <TD bgcolor="#FFFFFF"><B>Browse File To Upload <FONT COLOR="#FF0000">[.csv file]</B></FONT></TD>
        <TD bgcolor="#FFFFFF">&nbsp;&nbsp;<INPUT name="upfile" id='upfile' type="file" class="in"></TD>
      </TR>
      <TR height="30">
        <TD bgcolor="#FFFFFF" colspan=2 align="center">
 <input type="hidden" name="service_id" value="<?php echo $_REQUEST['service_info']?>" />
                <input name="Submit" type="submit" class="txtbtn" value="Upload" onSubmit="return checkfield();"/></TD>
      </TR>
      </TBODY>
    </TABLE>
</form>
<br/><br/><br/><br/><br/><br/><br/><br/><br/>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
  <tbody>
  <tr>
    <td bgcolor="#0369b3" height="1"></td>
  </tr>
  <tr>
    <td class="footer" align="right" bgcolor="#ffffff"><b>Powered by Hungama</b></td>
  </tr><tr>
    <td bgcolor="#0369b3" height="1"></td>
  </tr>
</tbody></table>
</body>
</html>
<?php
   mysql_close($dbConn);
?>


