<?php
// connect database
$dbc = mysql_connect("192.168.100.224", "ivr", "ivr");

// select database
mysql_select_db("reliance_hungama", $dbc);

        $fileName = $_POST['name'];
        mysql_query("INSERT INTO reliance_hungama.charging(ani) VALUES('$fileName')");
        $inserted_id = mysql_insert_id($dbc);

        if($inserted_id > 0) { // if success
                echo "uploaded file: " . $fileName;
        }

}
?>

