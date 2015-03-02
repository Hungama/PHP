<?php
/* Remove this line below in Production/Test environment once DB and Login is integrated */
//$AR_PList = array('revenue');
$AR_PList = explode(",", $_SESSION["access_sec"]);
?><div class="navbar navbar-default navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#"><img src="images/logo.png" border="0" alt="Hungama" /></a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="#"><i class="icon-home ics"></i></li></a>
			 

            <?php
                if(in_array("bulk_sms",$AR_PList)) { if($_SESSION['loginId']!='tdb.bulk'){?>
                	<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">SMS <b class="caret"></b></a>
               		<ul class="dropdown-menu">
                   <?php //echo item("bulk_sms","bulk_sms","../EngagemnentBox/rule_creation.php","SMS Engagement");?>
                   <?php echo item("bulk_sms","bulk_sms","../2.0/sms_bulk_upload.php","SMS Bulk Upload");?>
                   
                    </ul>
                </li>
                <?php }} ?>
				
				<?php
                if(in_array("bulk",$AR_PList)) {?>
                	<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Uploads <b class="caret"></b></a>
               		<ul class="dropdown-menu">
                   <?php echo item("bulk","bulk","../2.0/bulk_upload.php","Bulk Upload");?>
                  </ul>
                </li>
                <?php } ?>
				
              	<?php
                if(in_array("sms-kci",$AR_PList) || in_array("whitelist",$AR_PList) || in_array("switch_cc",$AR_PList) || in_array("ads_edit",$AR_PList)) {?>
                	<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Configuration <b class="caret"></b></a>
               		<ul class="dropdown-menu">
                   <?php echo item("whitelist","whitelist","../2.0/whitelist_vodafone_bulk_upload.php","Whitelisting(Voda)");?>
                   <?php echo item("switch_cc","switch_cc","../2.0/uninor_switch_configuration.php","Switch Control");?>
                   <?php echo item("sms-kci","sms-kci","SMSKCI.Services.php","SMS KCI's");?>
				   <?php echo item("ads_edit","ads_edit","add_campaign.php","Ad Control(IVR)");?>
                   
                    </ul>
                </li>
                <?php } ?>
				
               <?php 
			    if(in_array("cc",$AR_PList)) {
			   echo item("cc","cc","customer_ccare.php","Customer Care"); } ?>              
			 <?php
			  		  /*
                if(in_array("revenue",$AR_PList)) {?>
                	<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Customer Care <b class="caret"></b></a>
               		<ul class="dropdown-menu">
                   <?php echo item("revenue","cc","../2.0/customer_care.php","Customer Care");?>
                   <?php echo item("revenue","cc","customer_ccare.php","Customer Care (Beta)");?>             
                    </ul>
                </li>
				
                <?php } */?>
            
            
              </ul>
            </li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
                      
                
            <li><a href="logout.php">Signout</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>
    
<?php

function item ($Code,$Tag,$URL,$Text,$drop=false) {
	global $AR_PList;
	global $CURPAGE_TAG;
	
	$currentFile = $_SERVER["PHP_SELF"];
	$parts = Explode('/', $currentFile);
	$Actual_CURPAGE = str_replace(".php","",strtolower($parts[count($parts) - 1]));
	
  if(in_array($Code,$AR_PList)) {
	  $E = '<li '.(strcasecmp($Actual_CURPAGE,$Tag)==0 ? 'class="active"':'').'><a href="'.$URL.'">'.$Text.'</a></li>';
	return($E);
	}
}

?>    