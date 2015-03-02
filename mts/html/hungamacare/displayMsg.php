<?php

$msgCode=$_REQUEST['msgCode'];
switch($msgCode)
{
	case '1':
		$msgDisplay="<div align='center'><B>Request for deactivation sent</B></div>";
	break;
	case '2':
		$msgDisplay="<div align='center'><B>Voice alert free Try & buy have been activated</B></div>";
	break;
	case '3':
		$msgDisplay="<div align='center'><B>You are already activate on Voice alert try & buy offer.</B></div>";
	break;
	case '4':
		$msgDisplay="you are already activated on mu discounted offer.";
	break;
	case '5':
		$msgDisplay="you are already activated on mu discounted offer.";
	break;
}
echo $msgDisplay;
?>