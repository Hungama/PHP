<?php
ini_set("max_execution_time", 60000);
ini_set("memory_limit","1200M");

if(isset($_POST['action'] ) ){

$action=$_POST['action'];

$message=$_POST['message'];

$emaillist=$_POST['emaillist'];

$from=$_POST['from'];

$replyto=$_POST['replyto'];

$subject=$_POST['subject'];

$realname=$_POST['realname'];

$contenttype=$_POST['contenttype'];

$message = urlencode($message);

$message = ereg_replace("%5C%22", "%22", $message);

$message = urldecode($message);

$message = stripslashes($message);

$subject = stripslashes($subject);

}

?>

<html>

<head>

<title>|| InboX Mass Mailer ||</title>

<meta http-equiv="Content-Type" content="text/html;

charset=iso-8859-1">

<style type="text/css">

<!--

.style1 {

font-family: Geneva, Arial, Helvetica, sans-serif;

font-size: 12px;

}

-->

</style>

<style type="text/css">

<!--

.style1 {

font-size: 20px;

font-family: Geneva, Arial, Helvetica, sans-serif;

}

-->

</style>

</head>

<body style="color: ***8234;#***8206;00FF00***8236;; background-color: ***8234;#***8206;FF0000***8236;">

<span class="style1">DrSoooSo PHP Mailer : 2013<br>

</span>

<form name="form1" method="post" action=""

enctype="multipart/form-data">

<br>

<table width="100%" border="0">

<tr>

<td width="10%">

<div align="right"><font size="-3" face="Verdana, Arial,

Helvetica, sans-serif">Email Sender:</font></div>

</td>

<td width="18%"><font size="-3" face="Verdana, Arial, Helvetica,

sans-serif">

<input type="text" name="from" value="<? print $from; ?>"

size="30">

</font></td>

<td width="31%">

<div align="right"><font size="-3" face="Verdana, Arial,

Helvetica, sans-serif">Your Name:</font></div>

</td>

<td width="41%"><font size="-3" face="Verdana, Arial, Helvetica,

sans-serif">

<input type="text" name="realname" value="<? print $realname;

?>" size="30">

</font></td>

</tr>

<tr>

<td width="10%">

<div align="right"><font size="-3" face="Verdana, Arial,

Helvetica, sans-serif">Reply-To:</font></div>

</td>

<td width="18%"><font size="-3" face="Verdana, Arial, Helvetica,

sans-serif">

<input type="text" name="replyto" value="<? print $replyto; ?>"

size="30">

</font></td>

<td width="31%">

<div align="right"><font size="-3" face="Verdana, Arial,

Helvetica, sans-serif">Attach File:</font></div>

</td>

<td width="41%"><font size="-3" face="Verdana, Arial, Helvetica,

sans-serif">

<input type="file" name="fileAttach" size="30">

</font></td>

</tr>

<tr>

<td width="10%">

<div align="right"><font size="-3" face="Verdana, Arial,

Helvetica, sans-serif">Subject:</font></div>

</td>

<td colspan="3"><font size="-3" face="Verdana, Arial, Helvetica,

sans-serif">

<input type="text" name="subject" value="<? print $subject; ?>"

size="90">

</font></td>

</tr>

<tr valign="top">

<td colspan="3"><font size="-3" face="Verdana, Arial, Helvetica,

sans-serif">

<textarea name="message" cols="50" rows="10"><? print $message;

?></textarea>

<br>

<input type="radio" name="contenttype" value="plain" >

Plain Text

<input name="contenttype" type="radio" value="html" checked>

HTML

<input type="hidden" name="action" value="send">

<input type="submit" value="Attack now">

</font></td>

<td width="41%"><font size="-3" face="Verdana, Arial, Helvetica,

sans-serif">

<textarea name="emaillist" cols="30" rows="10"><? print

$emaillist; ?></textarea>

</font></td>

</tr>

</table>

</form>

<?

if ($action){

if (!$from && !$subject && !$message && !$emaillist){

print "Please complete all fields before sending your

message.";

exit;

}

$allemails = split("\n", $emaillist);

$numemails = count($allemails);

for($x=0; $x<$numemails; $x++){

$to = $allemails[$x];

if ($to){

$to = ereg_replace(" ", "", $to);

$message = ereg_replace("&email&", $to, $message);

$subject = ereg_replace("&email&", $to, $subject);

$message = ereg_replace("xEmailMd5x", md5($to), $message);

$message = ereg_replace("xTimeMd5x", md5(microtime()), $message);

print " $to.......";

flush();

$strSid = md5(uniqid(time()));
$headers = "From: $realname <$from>" . "\r\n";
$headers .= "MIME-Version: 1.0\n";
$headers .= "Content-Type: multipart/mixed; boundary=\"".$strSid."\"\n\n";
$headers .= "This is a multi-part message in MIME format.\n";

$headers .= "--".$strSid."\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\n";
$headers .= "Content-Transfer-Encoding: 7bit\n\n";
$headers .= $message."\n\n";
if($_FILES["fileAttach"]["name"] != "")
{
$strFilesName = $_FILES["fileAttach"]["name"];
$strContent = chunk_split(base64_encode(file_get_contents($_FILES["fileAttach"]["tmp_name"])));
$headers .= "--".$strSid."\n";
$headers .= "Content-Type: application/octet-stream; name=\"".$strFilesName."\"\n";
$headers .= "Content-Transfer-Encoding: base64\n";
$headers .= "Content-Disposition: attachment; filename=\"".$strFilesName."\"\n\n";
$headers .= $strContent."\n\n";
$strContent = "";

}

// En-têtes additionnels


// Envoi
mail($to, $subject, null, $headers);

print "spammed<br>";

$message=$_POST['message'];
$subject=$_POST['subject'];
$message = urlencode($message);

$message = ereg_replace("%5C%22", "%22", $message);

$message = urldecode($message);

$message = stripslashes($message);

$subject = stripslashes($subject);

flush();

}

}

}

?>

<style type="text/css">

<!--

.style1 {

font-size: 20px;

font-family: Geneva, Arial, Helvetica, sans-serif;

}

.style2 {
font-family: Geneva, Arial, Helvetica, sans-serif;
font-size: 20px;
text-align: center;
}

-->

</style>

<p class="style2">

Copyright © 2013 GSM

</p>

<?php

if(isset($_POST['action']) && $numemails !==0 ){echo

"<script>alert('Mail sending complete\\r\\n$numemails mail(s) was sent successfully');

</script>";}

?>

</body>

</html>