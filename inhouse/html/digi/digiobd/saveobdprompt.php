<?php
echo $obd_form_prompt_file=$_FILES['obd_form_prompt_file']['name'];
/*
Uploaded Wav file should be save on below path:

/172.16.56.42/home/smita/OBD/bengaliobd.wav
/172.16.56.42/home/smita/OBD/nepaliobd.wav
/172.16.56.42/home/smita/OBD/indianobd.wav

/172.16.56.43/home/smita/OBD/bengaliobd.wav
/172.16.56.43/home/smita/OBD/nepaliobd.wav
/172.16.56.43/home/smita/OBD/indianobd.wav

*/
/*
if(!empty($obd_form_prompt_file)){
echo $pathtoobdpromptfile= "obdrecording/prompt/";
if(copy($_FILES['obd_form_prompt_file']['tmp_name'], $pathtoobdpromptfile))
{
echo "Success";
}
else
{
echo "Fail";
}
*/

if(!empty($obd_form_prompt_file)){
$i = strrpos($obd_form_prompt_file,".");
$l = strlen($obd_form_prompt_file) - $i;
$ext = substr($obd_form_prompt_file,$i+1,$l);
$createobdfilename= $obd_form_prompt_file;
//echo $createobdfilename= "_obdrecording_".$curdate.'.'.$ext;
echo "<br>";
echo $pathtoobdfile= "obdrecording/prompt/".$createobdfilename;

if(copy($_FILES['obd_form_prompt_file']['tmp_name'], $pathtoobdfile))
{
echo "Success";
}
else
{
echo "Fail";
}
}
?>