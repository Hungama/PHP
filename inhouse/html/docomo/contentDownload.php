<?php
foreach (getallheaders() as $name => $value) {
    echo $name.":". $value."\r\n";
}
echo "<pre>";
print_r(getallheaders());
?>