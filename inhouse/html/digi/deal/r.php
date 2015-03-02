<?php
$xmlstring = '<deal>
	<mainMenu>
		<id>1</id>	
		<menuHeading>Deals of the day 1</menuHeading>
	</mainMenu>
		<mainMenu>
		<id>2</id>	
		<menuHeading>Deals of the day 2</menuHeading>
	</mainMenu>
	<mainMenu>
		<id>3</id>	
		<menuHeading>Deals of the day 3</menuHeading>
	</mainMenu>
		<mainMenu>
		<id>4</id>	
		<menuHeading>Deals of the day 4</menuHeading>
	</mainMenu>
</deal>';

function list_xml($str) { 
  $root = simplexml_load_string($str); 
  list_node($root); 
} 

function list_node($node) { 
  foreach ($node as $element) { 
    echo $element. "\n"; 
    if ($element->children()) { 
      echo "<br/>"; 
      list_node($element); 
    } 
  } 
} 
list_xml($xmlstring);
?>