<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
 <link href="assets/css/bootstrap.css" rel="stylesheet" />
 <link href="assets/css/jquery.pageslide.css" rel="stylesheet"  />
  <link href="assets/css/style.css" rel="stylesheet" />
<link href="assets/css/bootstrap-responsive.css" rel="stylesheet"/>
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
<title>Hungama Care</title>
	<script type="text/javascript" language="javascript">
function getModuleList(serviceid)
{
var xmlhttp;    
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
document.getElementById("listmodule").innerHTML=xmlhttp.responseText;
//alert(xmlhttp.responseText);
    }
  }
xmlhttp.open("GET","listmoduleinfo.php?serviceid="+serviceid,true);
xmlhttp.send();

}
</script>
<script src="assets/js/jquery.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/bootstrap-multiselect.js"></script>