<?php
date_default_timezone_set("Asia/Calcutta");

//MASTER DATABASE ACCESS VARIABLES
 $DB_HOST_M     = 'database.master'; //'10.2.73.156'; //DB HOST
 $DB_USERNAME_M = 'billing';  //DB Username
 $DB_PASSWORD_M = 'billing';  //DB Password
 $DB_DATABASE_M = 'master_db';  //Datbase Name
 $db_m = $DB_DATABASE_M;


//Airtel DATABASE ACCESS VARIABLES
 $DB_HOST_AIRTEL_HUNGAMA     = 'database.master'; //'10.2.73.156'; //DB HOST
 $DB_USERNAME_AIRTEL_HUNGAMA = 'billing';  //DB Username
 $DB_PASSWORD_AIRTEL_HUNGAMA = 'billing';  //DB Password
 $DB_DATBASE_AIRTEL_HUNGAMA = 'airtel_hungama';  //Datbase Name
 $db_airtel_hungama = $DB_DATBASE_AIRTEL_HUNGAMA;
 $SUBS_TABLE_AIRTEL_HUNGAMA="tbl_mtv_subscription";
 $UNSUBS_TABLE_AIRTEL_HUNGAMA="tbl_mtv_unsub";

 //Airtel DATABASE ACCESS VARIABLES
 $DB_HOST_AIRTEL_VH1     = 'database.master'; //'10.2.73.156'; //DB HOST
 $DB_USERNAME_AIRTEL_VH1 = 'billing';  //DB Username
 $DB_PASSWORD_AIRTEL_VH1 = 'billing';  //DB Password
 $DB_DATBASE_AIRTEL_VH1 = 'airtel_vh1';  //Datbase Name
 $db_airtel_vh1 = $DB_DATBASE_AIRTEL_VH1;
 $SUBS_TABLE_AIRTEL_VH1="tbl_jbox_subscription";
 $UNSUBS_TABLE_AIRTEL_VH1="tbl_jbox_unsub";
?>