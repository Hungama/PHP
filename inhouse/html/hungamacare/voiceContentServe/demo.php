<?php
if ($_REQUEST['contid']) {
    $contid = $_REQUEST['contid'];
}
if ($_REQUEST['pin']) {
    $pin = $_REQUEST['pin'];
}
$fileName='1093147.mp3';
$file = 'http://119.82.69.212/hungamacare/voiceContentServe/contentid/'.$fileName; 
?>
<a href="<?php echo $file;?>">Click To Download</a>

				<?php
				//header("Content-type: application/x-file-to-save"); 
				//header("Content-Disposition: attachment; filename=".basename($file)); 
				//readfile($file);
				
?>