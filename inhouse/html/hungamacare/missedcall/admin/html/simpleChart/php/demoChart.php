<?php error_reporting (E_ALL & ~E_NOTICE); ?>
<?php 
    $server = "localhost";
    $user="root";
    $password="";  
    $database = "supr";

    $connection = mysql_connect($server,$user,$password);
    $db = mysql_select_db($database,$connection);

    $sql = mysql_query("SELECT * FROM visitors ORDER BY Id");

      while($result = mysql_fetch_array($sql))
      {
         $returnData[] = array($result['x_val'],$result['y_val']);
      }
      echo json_encode(($returnData), JSON_NUMERIC_CHECK);
	  exit;
?>
