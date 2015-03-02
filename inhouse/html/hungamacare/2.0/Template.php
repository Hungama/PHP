<?php
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
 <link href="assets/css/bootstrap.css" rel="stylesheet" />
 <link href="assets/css/jquery.pageslide.css" rel="stylesheet"  />
  <link href="assets/css/style.css" rel="stylesheet" />
<link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
<link href="assets/css/datepicker.css" rel="stylesheet" />

<link href="assets/css/icons-sprites.css" rel="stylesheet" />
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <style>
    #pageslide{-webkit-text-size-adjust:none;background:#dd4814 url(../images/menuBg.gif) top left repeat-y;}
.pages h3{margin:0;font-size:20px;}
.contentWrap{width:310px;margin:0 auto;padding:15px 5px 0 5px;}
#menu{width:260px;height:100%;display:block!important;float:left;color:#fff;}
#menu h3{font-family:arial;font-size:12px;margin:0;background-color:#dd4814;padding:4px 0 4px 10px;background:-webkit-gradient(linear,left top,left bottom,color-stop(5%,rgba(90,89,89,1)),color-stop(85%,rgba(66,65,65,1)));border-top:solid #6b6b6b 1px;border-bottom:solid #3d3d3d 1px;text-shadow:0 -1px 1px #333;}

#menu ul{margin:0;padding:0;width:inherit;}
#menu ul li{list-style-type:none;margin:0;}
#menu ul li a:link, #menu ul li a:visited{border-bottom:solid #EB5028 1px;box-shadow:0 1px 0 #727272;color:#fff;font-size:14px;font-family:arial;text-decoration:none;width:250px;display:block;padding:10px 0 10px 10px;text-shadow:0 1px 1px #000;}

#menu ul li a:hover,#menu ul li a:active{background-color:#FAAD89;}
.active{background-color:#FAAD89;background:-webkit-gradient(linear,left top,left bottom,color-stop(0%,#1e1d1d),color-stop(21%,#C84814));}
    </style>
    
<title>Untitled Document</title>
</head>

<body>

<a href="#modal" class="second">Link text</a>
<div id="modal" style="display:none;"><div id="menu">
 

	<ul>
		<li class="active"><a href="#home" class="contentLink">Home </a></li>
		<li class="contentLink">
        Select Services:<br/>
        <iframe src="multiselect/index.html" frameborder="0" marginheight="0" marginwidth="0" scrolling="no" width="270" height="200" >
        </iframe> 
        </li>
		<li><a href="#home" class="contentLink">Portfolio </a></li>
		<li><a href="#home" class="contentLink">Contact </a></li>
	</ul>

</div></div>


  <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap-transition.js"></script>
    <script src="assets/js/bootstrap-alert.js"></script>
    <script src="assets/js/bootstrap-modal.js"></script>
    <script src="assets/js/bootstrap-dropdown.js"></script>
    <script src="assets/js/bootstrap-scrollspy.js"></script>
    <script src="assets/js/bootstrap-tab.js"></script>
    <script src="assets/js/bootstrap-tooltip.js"></script>
    <script src="assets/js/bootstrap-popover.js"></script>
    <script src="assets/js/bootstrap-button.js"></script>
    <script src="assets/js/bootstrap-collapse.js"></script>
    <script src="assets/js/bootstrap-carousel.js"></script>
    <script src="assets/js/bootstrap-typeahead.js"></script>
    <script src="assets/js/bootstrap-datepicker.js"></script>
    <script src="assets/js/date.format.js"></script>
    <script src="assets/js/jquery.pageslide.js"></script>
    
  
<script>
    $(".second").pageslide({ direction: "right", modal: true });
</script>

</body>
</html>