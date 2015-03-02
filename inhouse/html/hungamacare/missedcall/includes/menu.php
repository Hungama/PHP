<?php
/* Remove this line below in Production/Test environment once DB and Login is integrated */
$AR_PList = array('revenue');
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
                if(in_array("revenue",$AR_PList)) {?>
                	<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">SMS <b class="caret"></b></a>
               		<ul class="dropdown-menu">
                   <?php echo item("revenue","bulk_sms","../2.0/sms_engagement.php","SMS Engagement");?>
                   <?php echo item("revenue","bulk_sms","../2.0/sms_bulk_upload.php","SMS Bulk Upload");?>
                   
                    </ul>
                </li>
                <?php } ?>
				
				<?php
                if(in_array("revenue",$AR_PList)) {?>
                	<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Uploads <b class="caret"></b></a>
               		<ul class="dropdown-menu">
                   <?php echo item("revenue","bulk","../2.0/bulk_upload.php","Bulk Upload");?>
                  </ul>
                </li>
                <?php } ?>
				
              	<?php
                if(in_array("revenue",$AR_PList)) {?>
                	<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Configuration <b class="caret"></b></a>
               		<ul class="dropdown-menu">
                   <?php echo item("revenue","whitelist","../2.0/whitelist_vodafone_bulk_upload.php","Whitelisting(Voda)");?>
                   <?php echo item("revenue","switch_cc","../2.0/uninor_switch_configuration.php","Switch Control");?>
                   <?php echo item("revenue","sms_report","SMSKCI.Services.php","SMS KCI's");?>
                   
                    </ul>
                </li>
                <?php } ?>
               
			 <?php
                if(in_array("revenue",$AR_PList)) {?>
                	<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Customer Care <b class="caret"></b></a>
               		<ul class="dropdown-menu">
                   <?php echo item("revenue","cc","../2.0/customer_care.php","Customer Care");?>
                                
                    </ul>
                </li>
                <?php } ?>
            
            
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