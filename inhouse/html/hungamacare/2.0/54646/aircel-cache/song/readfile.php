<?PHP
/*
$file_handle = fopen("song.txt", "rb");

while (!feof($file_handle) ) {

echo $line_of_text = fgets($file_handle);
//$parts = explode('#', $line_of_text);
//echo $parts[0]."**".$parts[1]."<br>";
//print $parts[0] . $parts[1]. "<BR>";

}
*/
$lines = file('song.txt');
$i=0;
						foreach ($lines as $line_num => $line) 
						{
						echo $line=trim($line);
						//echo $pos = strpos($line, '136434');
						$i++;
						 //$parts = explode('#', $line);
						//echo $parts[0]."***".$parts[1]."<br>";
					    }
						  
//fclose($file_handle);

?>