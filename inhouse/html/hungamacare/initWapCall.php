<html>
<head>
<script type="text/javascript">
    function init(){
        var linkPage = document.getElementById('callUs').href;
        window.location.href = linkPage;
    }
    onload=init;
</script>
</head>
<body>
<?php 
$ani=$_REQUEST['ani'];
//9990434653
$userAgent=$_SERVER['HTTP_USER_AGENT']; 
$logpath="/var/www/html/hungamacare/log/clickTocall/ClickToCalllog_".date('Ymd').".txt";
$logData=$ani."#".$userAgent."#".date("Y-m-d H:i:s")."\n";
error_log($logData,3,$logpath);

if (stristr($userAgent, 'Nokia')){ 
?> 
         <a href="wtai://wp/mc;+91<?=$ani?>" id="callUs">Call Us!</a> 
<?php 
}else{ 
    /* work for iOS,Android Browser,webOS Browser,Symbian browser,Internet Explorer, 
     Opera Mini and low-end devices browsers.*/ 
?> 
         <a href="tel:+91<?=$ani?>" id="callUs">Call Us!</a> 
<?php 
} 
?>
</body>
</html>