<?php
sleep(1000);
session_start();
require_once("incs/db.php");
$service_base = $_GET['service_base'];
echo "SELECT Fid,description FROM master_db.tbl_filter_base WHERE status=1  and service_base like'%" . $service_base . "%' order by description";
$Result = mysql_query("SELECT Fid,description FROM master_db.tbl_filter_base WHERE status=1  and service_base like'%" . $service_base . "%' order by description", $dbConn);
$numRow = mysql_num_rows($Result);
if ($numRow) {
    ?>
    <select id="filter_base" name="filter_base" data-width="70%" onchange="setScenarios(this.value)">
        <option value="0">Select Filter Base</option>
        <?php

        while ($row = mysql_fetch_array($Result)) {
            echo '<option value="' . $row['Fid'] . '">' . $row['description'] . '</option>';
        }
        echo "</select>";
    } else {
        echo '<select id="filter_base" name="filter_base" onchange="setScenarios(this.value)">';
        echo '<option value="">Select Filter Base</option>';
        echo "</select>";
    }
    ?>