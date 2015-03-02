<?php
   $db = new mysqli('119.82.69.210', 'weburl' ,'weburl', 'follow_up');
	if(!$db) {
		echo 'Could not connect to the database.';
	} else {
		if(isset($_POST['queryString'])) {
			$queryString = $db->real_escape_string($_POST['queryString']);
			if(strlen($queryString) >0) {

				$query = $db->query("select Celeb_id,Celeb_Name from follow_up.tbl_celebrity_manager WHERE Celeb_Name LIKE '$queryString%'");
				if($query) {
				echo '<ul>';
					while ($result = $query ->fetch_object()) {
	         			echo '<li onClick="fill(\''.addslashes($result->Celeb_Name).'\');">'.$result->Celeb_Name.'</li>';
	         		}
				echo '</ul>';
					
				} else {
					echo 'OOPS we had a problem :(';
				}
			} else {
				// do nothing
			}
		} else {
			echo 'There should be no direct access to this script!';
		}
	}
?>