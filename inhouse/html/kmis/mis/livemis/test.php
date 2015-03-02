<?php 
echo "hi";
echo $processlog = "/var/www/html/kmis/mis/livemis/livekpi_uninor".date('Ymd').".txt";echo "<br/>";
echo $deleted_file = "/var/www/html/kmis/mis/livemis/livekpi_uninor".date("Ymd",mktime(0,0,0,date("m"),date("d")-1,date("Y"))).".txt";
?>
