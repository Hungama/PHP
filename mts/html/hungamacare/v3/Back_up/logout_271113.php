<?php
setcookie("Hng_Voice_BI_ABC", 0, time() - 3600 * 2); /* expire in 1 hour */
;
setcookie("Hng_Voice_BI_ABC", 0, time() - 3600 * 2, "/", "", false); /* expire in 1 hour */
;
header("Location: login.php?ERROR=500");
exit;
?>