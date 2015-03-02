<?php 
$psp="http://r5---sn-gxap5ojx-cvhe.c.youtube.com/videoplayback?algorithm=throttle-factor&burst=40&cp=U0hVSlJSVF9NU0NONV9KTFhKOnB6TE0tTjNYT0ZG&cpn=CP4QJcTplfsrLD_8&expire=1365276989&factor=1.25&fexp=902498%2C914045%2C901470%2C932000%2C932004%2C906383%2C902000%2C901208%2C919512%2C929903%2C925714%2C931202%2C900821%2C900823%2C931203%2C931401%2C906090%2C909419%2C908529%2C930807%2C919373%2C930803%2C906836%2C920201%2C929602%2C930101%2C900824%2C910223&id=148d9be38ee3f6db&ip=115.241.230.65&ipbits=8&itag=5&keepalive=yes&key=yt1&ms=au&mt=1365256217&mv=m&newshard=yes&ratebypass=yes&signature=3B31BF8BD73B772FA42EAD9A5BFD4B0634705C50.6FF96640206B0F7A005DFC50EC29555F0FCA647E&source=youtube&sparams=algorithm%2Cburst%2Ccp%2Cfactor%2Cid%2Cip%2Cipbits%2Citag%2Csource%2Cupn%2Cexpire&sver=3&upn=pt9smrZY-WA";
///$psp="youtube.com";

header("Content-type: video/flv");
header("Content-Disposition:attachment;filename=\"$psp\"");
//allways a good idea to let the browser know how much data to expect
header("Content-length: " . filesize($psp) . "\n\n"); 
echo file_get_contents($psp); //$psp should contain the full path to the video
?>