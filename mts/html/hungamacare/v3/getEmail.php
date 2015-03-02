<?php

session_start();
require_once("incs/db.php");

if (isset($_REQUEST['query'])) {
    $query = $_REQUEST['query'];
    $sql = mysql_query("SELECT email FROM master_db.live_user_master WHERE email LIKE '%{$query}%'");
    $array = array();
    while ($row = mysql_fetch_assoc($sql)) {
        $array[] = $row['email'];
    }
    echo json_encode($array); //Return the JSON Array
}
?>