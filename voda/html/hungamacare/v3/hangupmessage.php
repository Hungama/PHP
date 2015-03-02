<?php
session_start();
error_reporting(1);
require_once("../2.0/incs/db.php");
require_once("../2.0/language.php");
$loginid = $_SESSION['loginId'];
if ($loginid == '') {
    Header("location:login.php?ERROR=500");
}
$service=$_REQUEST['service'];
$priority= $_REQUEST['priority'];
$type=$_REQUEST['type'];
$circle=$_REQUEST['circle1'];
$selQry = "select max(id) from vodafone_radio.tbl_radio_messageInterface";
$selQryEx = mysql_query($selQry, $dbConn);
$rule_id = mysql_fetch_row($selQryEx);
$obd_form_mob_file = $_FILES['upfile']['name'];
$curdate = date("Y_m_d-H_i_s");

if (isset($_FILES['upfile']) && !empty($_FILES['upfile']['name'])) {
        $lines = file($_FILES['upfile']['tmp_name']);
        $isok;
        $count = 0;
        foreach ($lines as $line_num => $mobno) {
            $mno = trim($mobno);
            if (!empty($mno)) {
                $count++;
            }
        }
       
        
        if ($count > 25000) {
            echo "<div width=\"85%\" align=\"left\" class=\"txt\">
  <div class=\"alert alert-danger\">Please upload file of less than 25,000 numbers otherwise it will not process.</div></div>";
            exit;
        }
        if (!empty($obd_form_mob_file)) {
            $i = strrpos($obd_form_mob_file, ".");
            $l = strlen($obd_form_mob_file) - $i;
            $ext = substr($obd_form_mob_file, $i + 1, $l);
            $ext = 'txt';
        

            $createfilename = "hangupmsgfile_" . $curdate . '.' . $ext;
            $pathtofile = "hangupmessageuploads/" . $createfilename;
            
         
            if (move_uploaded_file($_FILES['upfile']['tmp_name'], $pathtofile)) {
                ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
               
                $lines = file($pathtofile);
                $allmessage = '';
                foreach ($lines as $line_num => $msg) {
                    $allmessage.=$msg;
                }
              
                
 /*if (trim($allmessage) != '') {
$escape_msg = mysql_escape_string($allmessage);
$insertDump = "insert into vodafone_radio.tbl_radio_messageInterface(Message,type,circle,status,added_on,added_by) 
     values('$escape_msg','$type','$circle',1,now(),'$loginid' )";
                        if (mysql_query($insertDump, $dbConn)) {
                            $isupload = true;
                        } else {
                            $isupload = false;
                        }
                    }
                */
                
                
                
                $order = array("\r\n", "\n", "\r");
                $replace = '<br />';
                $newstr = str_replace($order, $replace, $allmessage);
                $totalmessage = explode("<br />", $newstr);
                
foreach($circle as $circledata)
{
$i=0;
foreach ($totalmessage as $allmessage) {
if (trim($allmessage) != '') {
                        $escape_msg = mysql_escape_string($allmessage);
                        $insertDump = "insert into vodafone_radio.tbl_radio_messageInterface(sno,Message,type,circle,status,added_on,added_by) 
     values($i,'$escape_msg','$type','$circledata',1,now(),'$loginid' )";
                        //echo $insertDump.'<br/>';
                        if (mysql_query($insertDump, $dbConn)) {
                           $isupload = true;
                            $i++;
                        } else {
                           $isupload = false;
                        }
                    }
                }
                
                }
                ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            }?>
            
   <div width="85%" align="left" class="txt">
        <div class="alert alert-success">
            <h6>Message saved successfully.</h6>
        </div>
    </div>
       <?php }
}
        
   
?>
