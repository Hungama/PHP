<?php
$file = 'http://202.87.41.147/hungamawap/aircel/wap_sub/AllAircelVisitorRequestMISNew_20141203.txt';
$newfile ='logs/AllAircelVisitorRequestMISNew_20141203.txt';

if ( copy($file, $newfile) ) {
    echo "Copy success!";
}else{
    echo "Copy failed.";
}
?>