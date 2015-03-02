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
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Sales <b class="caret"></b></a>
               		<ul class="dropdown-menu">
                   <?php echo item("revenue","revenue","SalesDashboard.php","Sales Dashboard");?>
                   <?php echo item("revenue","revenue.live","Revenue.Live.php","LIVE KPI's");?>
                   <?php echo item("revenue","revenue.dashboard","Revenue.Dashboard.php","Monthly Dashboard");?>
                   <?php echo item("revenue","user.alerts","User.Alerts.php","Alerts");?>
                    </ul>
                </li>
                <?php } ?>
              	<?php
                if(in_array("recharge",$AR_PList)) {?>
                	<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Recharge <b class="caret"></b></a>
               		<ul class="dropdown-menu">
                   <?php echo item("recharge","recharge","Recharge.php","Recharge Now");?>
                   <?php echo item("recharge","recharge","Recharge.PendingApprovals.php","Pending Approvals");?>
                   <?php echo item("recharge","recharge","Recharge.MyView.php","My Transactions");?>
                    </ul>
                </li>
                <?php } ?>
               
			 <?php
                if(in_array("revenue",$AR_PList)) {?>
                	<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Data <b class="caret"></b></a>
               		<ul class="dropdown-menu">
                   <?php echo item("revenue","Transactional.Dumps","Transactional.Dumps.php","Transactional Dumps");?>
                   <?php echo item("revenue","ndnc","NDNC.php","NDNC Filtering");?>
                   <li class="divider"></li>
                   <?php echo item("revenue","sms_report","SMS.Dashboard.php","SMS Dashboard");?>
                    </ul>
                </li>
                <?php } ?>
            
            
              </ul>
            </li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
             <?php
                if(in_array("admin",$AR_PList)) {?>
                	<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Admin <b class="caret"></b></a>
               		<ul class="dropdown-menu">
                   <?php echo item("admin","admin.usermanager","Admin.Usermanager.php","User Manager");?>
                   <?php echo item("admin","admin.service","Admin.Services.php","Service Manager");?>
                   <li class="divider"></li>
				   <?php echo item("admin","admin.mis","Admin.Dispatch.php","MIS Dispatch");?>
                   <?php echo item("admin","admin.mis","Admin.Dispatch.php?Queue=1","MIS Queue");?>
                   <?php echo item("admin","admin.mis","Admin.Dispatch.php?Sent=1","MIS Dispatched");?>
                    </ul>
                </li>
                <?php } ?>
                
                
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