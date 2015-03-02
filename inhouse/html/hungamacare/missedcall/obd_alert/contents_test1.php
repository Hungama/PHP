<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php
error_reporting(0);
$curdate = date("Y_m_d_H_i_s");
$message = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">';
$message .= "<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
			</head><body>";
$message .= "<table rules='all' style='border-color: #666;font-size:12px;width:100%' border='0' cellpadding='2'>
<tr><td>Hi All,<br><br>
This is a test email.<br><br>
</td></tr></table>";
$message .="</body></html>";
echo $message;
$htmlfilename = 'emailcontenttest_' . date('Ymd') . '.html';
$file = fopen($htmlfilename, "w");
fwrite($file, $message);
?>