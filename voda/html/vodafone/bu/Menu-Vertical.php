<div id="menu-bar" style="display:none;" ><div id="menu" class="span3">
<ul class="nav nav-list bs-docs-sidenav">
	<li><a href="#"><?php echo 'Welcome, '.$_SESSION["fullname"];?></a></li>
  <li <?php if(strcasecmp($CURPAGE,"home")==0) { echo "class=\"active\"";}?>><a href="home.php"><i class="icon-home"></i> Home</a></li>
   <li <?php if(strcasecmp($CURPAGE,"home")==0) { echo "class=\"active\"";}?>><a href="customer_care.php"><i class="icon-user"></i> Customer Care</a></li>
    <!--li <?php if(strcasecmp($CURPAGE,"home")==0) { echo "class=\"active\"";}?>><a href="bulk_upload.php"><i class="icon-upload"></i> Bulk Upload</a></li-->
  

  	<?php 
	/*echo item("cc","cc","customer_care.php","user","Customer Care");
  	echo item("bulk","bulk","bulk_upload.php","upload","Bulk Upload");
	echo item("bulk_sms","bulk_sms","sms_bulk_upload.php","comment","SMS Bulk Upload");*/?>
  
    

  <li><a href="logout.php"><i class="icon-eject"></i> Signout</a></li>
</ul>

</div></div>
<style>

.bs-docs-sidenav {
  width: 228px;
  margin: 30px 0 0;
  padding: 0;
  background-color: #fff;
  -webkit-border-radius: 6px;
     -moz-border-radius: 6px;
          border-radius: 6px;
  -webkit-box-shadow: 0 1px 4px rgba(0,0,0,.065);
     -moz-box-shadow: 0 1px 4px rgba(0,0,0,.065);
          box-shadow: 0 1px 4px rgba(0,0,0,.065);
}
.bs-docs-sidenav > li > a {
  display: block;
  width: 190px \9;
  margin: 0 0 -1px;
  
  border: 1px solid #e5e5e5;
}
.bs-docs-sidenav > li:first-child > a {
  -webkit-border-radius: 6px 6px 0 0;
     -moz-border-radius: 6px 6px 0 0;
          border-radius: 6px 6px 0 0;
}
.bs-docs-sidenav > li:last-child > a {
  -webkit-border-radius: 0 0 6px 6px;
     -moz-border-radius: 0 0 6px 6px;
          border-radius: 0 0 6px 6px;
}
.bs-docs-sidenav > .active > a {
  position: relative;
  z-index: 2;
  border: 0;
  text-shadow: 0 1px 0 rgba(0,0,0,.15);
  -webkit-box-shadow: inset 1px 0 0 rgba(0,0,0,.1), inset -1px 0 0 rgba(0,0,0,.1);
     -moz-box-shadow: inset 1px 0 0 rgba(0,0,0,.1), inset -1px 0 0 rgba(0,0,0,.1);
          box-shadow: inset 1px 0 0 rgba(0,0,0,.1), inset -1px 0 0 rgba(0,0,0,.1);
}
/* Chevrons */
.bs-docs-sidenav .icon-chevron-right {
  float: right;
  margin-top: 2px;
  margin-right: -6px;
  opacity: .25;
}
.bs-docs-sidenav > li > a:hover {
  background-color: #f5f5f5;
}
.bs-docs-sidenav a:hover .icon-chevron-right {
  opacity: .5;
}
.bs-docs-sidenav .active .icon-chevron-right,
.bs-docs-sidenav .active a:hover .icon-chevron-right {
  background-image: url(assets/img/glyphicons-halflings-white.png);
  opacity: 1;
}
.bs-docs-sidenav.affix {
  top: 40px;
}
.bs-docs-sidenav.affix-bottom {
  position: absolute;
  top: auto;
  bottom: 270px;
}




</style>
<?php
$AR_PList;
function item ($Code,$Tag,$URL,$Icon,$Text) {
	global $AR_PList;
	global $CURPAGE_TAG;
	
  if(in_array($Code,$AR_PList)) {
	  $E = '<li '.(strcasecmp($CURPAGE_TAG,$Tag)==0 ? 'class="active"':'').'><a href="'.$URL.'"><i class="icon-'.$Icon.'"></i> '.$Text.'</a></li>';
	return($E);
	}
}

?>