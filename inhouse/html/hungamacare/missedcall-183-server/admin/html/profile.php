<?php
session_start();
require_once("../../../db.php");
$campg_manager_id=$_SESSION['suid'];
if(empty($campg_manager_id))
{
session_destroy();
Header("location:index.php?ERROR=502");
}
$get_query="select id,firstname,lastname,email,city,company,noofemp,website,mobileno,registed_on,uid 
from Inhouse_IVR.tbl_missedcall_signup where uid='".$_SESSION['suid']."'";
$query = mysql_query($get_query,$con);
list($id, $firstname, $lastname,$email,$city,$company,$noofemp,$website,$mobileno,$registed_on,$uid) = mysql_fetch_array($query);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Campaign admin</title>
    <meta name="author" content="SuggeElson" />
    <meta name="description" content="Supr admin template - new premium responsive admin template. This template is designed to help you build the site administration without losing valuable time.Template contains all the important functions which must have one backend system.Build on great twitter boostrap framework" />
    <meta name="keywords" content="admin, admin template, admin theme, responsive, responsive admin, responsive admin template, responsive theme, themeforest, 960 grid system, grid, grid theme, liquid, masonry, jquery, administration, administration template, administration theme, mobile, touch , responsive layout, boostrap, twitter boostrap" />
    <meta name="application-name" content="Supr admin template" />

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Force IE9 to render in normla mode -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- Le styles -->
    <!-- Use new way for google web fonts 
    http://www.smashingmagazine.com/2012/07/11/avoiding-faux-weights-styles-google-web-fonts -->
    <!-- Headings -->
    <!-- <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css' />  -->
    <!-- Text -->
    <!-- <link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet' type='text/css' /> --> 
    <!--[if lt IE 9]>
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400" rel="stylesheet" type="text/css" />
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:700" rel="stylesheet" type="text/css" />
    <link href="http://fonts.googleapis.com/css?family=Droid+Sans:400" rel="stylesheet" type="text/css" />
    <link href="http://fonts.googleapis.com/css?family=Droid+Sans:700" rel="stylesheet" type="text/css" />
    <![endif]-->

    <!-- Core stylesheets do not remove -->
    <link id="bootstrap" href="css/bootstrap/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="css/bootstrap/bootstrap-theme.css" rel="stylesheet" type="text/css" />
    <link href="css/supr-theme/jquery.ui.supr.css" rel="stylesheet" type="text/css"/>
    <link href="css/icons.css" rel="stylesheet" type="text/css" />

    <!-- Plugin stylesheets -->
    <link href="plugins/misc/qtip/jquery.qtip.css" rel="stylesheet" type="text/css" />    
    <link href="plugins/forms/uniform/uniform.default.css" type="text/css" rel="stylesheet" />
    <link href="plugins/forms/select/select2.css" type="text/css" rel="stylesheet" />    
    <link href="plugins/forms/togglebutton/toggle-buttons.css" type="text/css" rel="stylesheet" />
    
    <!-- Main stylesheets -->
    <link href="css/main.css" rel="stylesheet" type="text/css" /> 

    <!-- Custom stylesheets ( Put your own changes here ) -->
    <link href="css/custom.css" rel="stylesheet" type="text/css" /> 

    <!--[if IE 8]><link href="css/ie8.css" rel="stylesheet" type="text/css" /><![endif]-->
    
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script type="text/javascript" src="js/libs/excanvas.min.js"></script>
      <script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
      <script type="text/javascript" src="js/libs/respond.min.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="images/favicon.ico" />
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/apple-touch-icon-144-precomposed.png" />
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/apple-touch-icon-114-precomposed.png" />
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/apple-touch-icon-72-precomposed.png" />
    <link rel="apple-touch-icon-precomposed" href="images/apple-touch-icon-57-precomposed.png" />
    
    <!-- Windows8 touch icon ( http://www.buildmypinnedsite.com/ )-->
    <meta name="application-name" content="Supr"/> 
    <meta name="msapplication-TileColor" content="#3399cc"/> 

    <!-- Load modernizr first -->
    <script type="text/javascript" src="js/libs/modernizr.js"></script>

    </head>
      
    <body>
    <!-- loading animation -->
    <div id="qLoverlay"></div>
    <div id="qLbar"></div>
    
    <div id="header">
        <nav class="navbar navbar-default" role="navigation">
            <div class="navbar-header">
                <a class="navbar-brand" href="dashboard.html">Campaign.<span class="slogan">admin</span></a>
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon16 icomoon-icon-arrow-4"></span>
                </button>
            </div> 
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="dashboard.php"><span class="icon16 icomoon-icon-screen-2"></span> <span class="txt">Dashboard</span></a>
                    </li>
                   <?php
				   include("allcampaginlist.php");
				   ?>
                 
                </ul>
              
                <ul class="nav navbar-right usernav">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="icon16 icomoon-icon-bell"></span><span class="notification">1</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="menu">
                                <ul class="notif">
                                    <li class="header"><strong>Notifications</strong> (1) items</li>
                                    <li>
                                        <a href="#">
                                            <span class="icon"><span class="icon16 icomoon-icon-user-plus"></span></span>
                                            <span class="event">1 New Message</span>
                                        </a>
                                    </li>
                                   
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle avatar" data-toggle="dropdown">
                            <img src="images/avatar.jpg" alt="" class="image" /> 
                            <span class="txt"><?php echo $_SESSION['semail'];?></span>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="menu">
                                <ul>
                                    <li><a href="#"><span class="icon16 icomoon-icon-user"></span>Edit profile</a></li>
                                  
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li><a href="logout.php"><span class="icon16 icomoon-icon-exit"></span><span class="txt"> Logout</span></a></li>
                </ul>
            </div><!-- /.nav-collapse -->
        </nav><!-- /navbar --> 

    </div><!-- End #header -->

    <div id="wrapper">

        <!--Responsive navigation button-->  
        <div class="resBtn">
            <a href="#"><span class="icon16 minia-icon-list-3"></span></a>
        </div>
        
        <!--Sidebar collapse button-->  
        <div class="collapseBtn leftbar">
             <a href="#" class="tipR" title="Hide sidebar"><span class="icon12 minia-icon-layout"></span></a>
        </div>

        <!--Sidebar background-->
        <div id="sidebarbg"></div>
        <!--Sidebar content-->
        <div id="sidebar">

            <div class="shortcuts">
                
            </div><!-- End search -->            

            <div class="sidenav">

                <div class="sidebar-widget" style="margin: -1px 0 0 0;">
                    <h5 class="title" style="margin-bottom:0">Navigation</h5>
                </div><!-- End .sidenav-widget -->

              
            </div><!-- End sidenav -->



        </div><!-- End #sidebar -->

        <!--Body content-->
        <div id="content" class="clearfix">
            <div class="contentwrapper"><!--Content wrapper-->

                <div class="heading">

                    <h3>User profile</h3>                    

                    <div class="resBtnSearch">
                        <a href="#"><span class="icon16 icomoon-icon-search-3"></span></a>
                    </div>

                    <!--div class="search">

                        <form id="searchform" action="#">
                            <input type="text" id="tipue_search_input" class="top-search" placeholder="Search here ..." />
                            <input type="submit" id="tipue_search_button" class="search-btn" value=""/>
                        </form>
                
                    </div--><!-- End search -->
                    
                    <ul class="breadcrumb">
                        <li>You are here:</li>
                        <li>
                            <a href="#" class="tip" title="back to dashboard">
                                <span class="icon16 icomoon-icon-screen-2"></span>
                            </a> 
                            <span class="divider">
                                <span class="icon16 icomoon-icon-arrow-right-3"></span>
                            </span>
                        </li>
                        <li class="active">User profile Page</li>
                    </ul>

                </div><!-- End .heading-->

                <!-- Build page from here: -->
                <div class="row">

                    <div class="col-lg-12">

                        <div class="page-header">
                            <h4>User profile</h4>
                        </div>

                        <form class="form-horizontal seperator" role="form" action="userAction.php" method="post">
                            <div class="form-group">
                                <label class="col-lg-2 control-label" for="username">FirstName:</label>
                                <div class="col-lg-10">
                                    <input class="form-control" id="name" name="fname" type="text" value="<?php echo $firstname;?>" />
                                </div>
                            </div><!-- End .form-group  -->
                              <div class="form-group">
                                <label class="col-lg-2 control-label" for="username">LastName:</label>
                                <div class="col-lg-10">
                                    <input class="form-control" id="name" name="lname" type="text" value="<?php echo $lastname;?>" />
                                </div>
                            </div><!-- End .form-group  -->
                            <div class="form-group">
                                <label class="col-lg-2 control-label" for="username">Email:</label>
                                <div class="col-lg-10">
                                    <input class="form-control" id="email" name="email" type="text" disabled="disabled" value="<?php echo $email;?>" />
                                </div>
                            </div><!-- End .form-group  -->
						<div class="form-group">
                                <label class="col-lg-2 control-label" for="username">City:</label>
                                <div class="col-lg-10">
                                    <input class="form-control" id="name" type="text" name="city" value="<?php echo $city;?>" />
                                </div>
                            </div><!-- End .form-group  -->
							<div class="form-group">
                                <label class="col-lg-2 control-label" for="username">Company Name:</label>
                                <div class="col-lg-10">
                                    <input class="form-control" id="name" type="text" name="cname" value="<?php echo $company;?>" />
                                </div>
                            </div><!-- End .form-group  -->
							<div class="form-group">
                                <label class="col-lg-2 control-label" for="username">No Of Employees:</label>
                                <div class="col-lg-10">
                                    <input class="form-control" id="name" type="text" name="noofemp" value="<?php echo $noofemp;?>" />
                                </div>
                            </div><!-- End .form-group  -->
							<div class="form-group">
                                <label class="col-lg-2 control-label" for="username">Website:</label>
                                <div class="col-lg-10">
                                    <input class="form-control" id="name" type="text" name="website" value="<?php echo $website;?>" />
                                </div>
                            </div><!-- End .form-group  -->
							<div class="form-group">
                                <label class="col-lg-2 control-label" for="username">Mobile No:</label>
                                <div class="col-lg-10">
                                    <input class="form-control" id="name" type="text" name="mobile" value="<?php echo $mobileno;?>" />
                                </div>
                            </div><!-- End .form-group  -->
							<div class="form-group">
                                <label class="col-lg-2 control-label" for="username">Registerd On:</label>
                                <div class="col-lg-10">
                                    <input class="form-control" id="name" type="text" disabled="disabled"  value="<?php echo date('j-M \'y g:i a', strtotime($registed_on));?>" />
								</div>
                            </div>
							<input id="suid" name="suid" type="hidden" value="<?php echo $uid;?>" />
							<!-- End .form-group  -->
                            
                            <div class="form-group">
                                <div class="col-lg-offset-2">
                                    <button type="submit" class="btn btn-info marginR10 marginL10">Save changes</button>
                                    <button class="btn btn-danger">Cancel</button>
                                </div>
                            </div><!-- End .form-group  -->
                            

                        </form>
                      
                    </div><!-- End .span12 -->

                </div><!-- End .row -->

                <div class="modal fade hide" id="myModal1">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span class="icon12 minia-icon-close"></span></button>
                        <h3>Chat layout</h3>
                    </div>
                    <div class="modal-body">
                        <ul class="messages">
                            <li class="user clearfix">
                                <a href="#" class="avatar">
                                    <img src="images/avatar2.jpeg" alt="" />
                                </a>
                                <div class="message">
                                    <div class="head clearfix">
                                        <span class="name"><strong>Lazar</strong> says:</span>
                                        <span class="time">25 seconds ago</span>
                                    </div>
                                    <p>
                                        Time to go i call you tomorrow.
                                    </p>
                                </div>
                            </li>
                            <li class="admin clearfix">
                                <a href="#" class="avatar">
                                    <img src="images/avatar3.jpeg" alt="" />
                                </a>
                                <div class="message">
                                    <div class="head clearfix">
                                        <span class="name"><strong>Sugge</strong> says:</span>
                                        <span class="time">just now</span>
                                    </div>
                                    <p>
                                        OK, have a nice day.
                                    </p>
                                </div>
                            </li>

                            <li class="sendMsg">
                                <form class="form-horizontal" action="#">
                                    <textarea class="elastic" id="textarea1" rows="1" placeholder="Enter your message ..." style="width:98%;"></textarea>
                                    <button type="submit" class="btn btn-info marginT10">Send message</button>
                                </form>
                            </li>
                            
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn" data-dismiss="modal">Close</a>
                    </div>
                </div>
                
            </div><!-- End contentwrapper -->
        </div><!-- End #content -->
    
    </div><!-- End #wrapper -->
    
    <!-- Le javascript
    ================================================== -->
    <!-- Important plugins put in all pages -->
    <script  type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
    <script type="text/javascript" src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="js/bootstrap/bootstrap.js"></script>  
    <script type="text/javascript" src="js/jquery.mousewheel.js"></script>
    <script type="text/javascript" src="js/libs/jRespond.min.js"></script>

    <!-- Charts plugins -->    
    <script type="text/javascript" src="plugins/charts/sparkline/jquery.sparkline.min.js"></script><!-- Sparkline plugin -->
   
    <!-- Misc plugins -->  
    <script type="text/javascript" src="plugins/misc/qtip/jquery.qtip.min.js"></script><!-- Custom tooltip plugin -->   
    <script type="text/javascript" src="plugins/misc/totop/jquery.ui.totop.min.js"></script> 

    <!-- Search plugin -->
    <script type="text/javascript" src="plugins/misc/search/tipuesearch_set.js"></script>
    <script type="text/javascript" src="plugins/misc/search/tipuesearch_data.js"></script><!-- JSON for searched results -->
    <script type="text/javascript" src="plugins/misc/search/tipuesearch.js"></script>

    <!-- Form plugins -->   
    <script type="text/javascript" src="plugins/forms/uniform/jquery.uniform.min.js"></script>
    <script type="text/javascript" src="plugins/forms/select/select2.min.js"></script>    
    <script type="text/javascript" src="plugins/forms/togglebutton/jquery.toggle.buttons.js"></script>
    
    <!-- Init plugins -->
    <script type="text/javascript" src="js/main.js"></script><!-- Core js functions -->
    <script type="text/javascript" src="js/empty.js"></script><!-- Init plugins only for page -->
    <script type="text/javascript">
    // document ready function
    $(document).ready(function() { 
      $( ".tipR" ).click();
	 $( ".tipR" ).hide();
        $("#tags").select2({
            tags:["red", "green", "blue", "orange"]
        });

        $('.iToggle-button').toggleButtons({
            width: 70,
            label: {
                enabled: "<span class='icon16 icomoon-icon-checkmark white'></span>",
                disabled: "<span class='icon16 icomoon-icon-close white marginL10'></span>"
            }
        });
    });//End document ready functions
    </script>

    </body>
</html>
