<?php
$path_src="/var/www/html/airtel/CC/bulkuploads/1522/airtel_2860_1522_63_30_TELECALL_NA_active.txt";
$path_dest="/var/www/html/kmis/services/hungamacare/bulkuploads/1522/airtel_2860_1522_63_30_TELECALL_NA_active.txt";

$cmd="sshpass -p 'P#PO#MA#DI!&TOPO!H%' scp -r $path_src root@10.2.73.156:$path_dest";
$out = shell_exec($cmd);
/*
$connection = ssh2_connect('10.2.73.156', 22);
ssh2_auth_password($connection, 'root', 'Hun$$gam&&156$R$');
//ssh2_scp_send($connection, '/local/filename', '/remote/filename', 0644);
ssh2_scp_send($connection, $path, $path_dest, 0644);
echo "Done";
*/
?>
