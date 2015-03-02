<?php

session_start();
require_once("incs/db.php");
$filter_base = $_GET['filter_base'];
$Result = mysql_query("SELECT Scid,description FROM master_db.tbl_filter_base_scenarios WHERE Fid='" . $filter_base . "'", $dbConn);
$numRow = mysql_num_rows($Result);
if ($numRow) {
    ?>
    <select  name="edit_scenarios" data-width="70%">
        <option value="0">Select Scenarios</option>
        <?php

        while ($row = mysql_fetch_array($Result)) {
            echo '<option value="' . $row['Scid'] . '">' . $row['description'] . '</option>';
        }
        echo '<option value="35">Test</option>';
        echo "</select>";
    } else {
        echo '<select id="scenarios" name="scenarios" data-width="auto">';
        echo '<option value="">Select Scenarios</option>';
        echo "</select>";
    }
    ?>