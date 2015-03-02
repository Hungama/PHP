<?php
$SKIP=1;
ini_set('display_errors','0');


require_once("incs/database.php");
require_once("../incs/GraphColors-D.php");
require_once("../../ContentBI/base.php");
//asort($AR_SList);

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
 <link href="assets/css/bootstrap.css" rel="stylesheet" />
 <link href="assets/css/jquery.pageslide.css" rel="stylesheet"  />
  <link href="assets/css/style.css" rel="stylesheet" />
<link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    
    
<title>My Alerts</title>
</head>

<body>

<div class="navbar navbar-inner">
<a href="#menu-bar" class="second"><button class="btn btn-primary"><i class="icon-align-justify"></i> Menu</button></a>
</div>

<div class="container">

<div class="row">

<div class="page-header">
  <h1>My Alerts<small>&nbsp;&nbsp;manage your alerts</small></h1>
</div>
<?php

								  $GetSelected = mysql_query("select t.id, t.alert_type as 'alert_type', t.service as service, b.value as name from tbl_usermanager_alerts t, base b where t.service=b.service and b.type='Name' and t.username='".$username."' order by b.value ASC") or die(mysql_error());
				$Count_of_Alerts = mysql_num_rows($GetSelected);
				//echo $username;				  
		 ?>

<div class="tab-pane active" id="pills-basic">
							<!--<h3>Pills</h3>-->
							<?php if(in_array('revenue',$AR_PList)) { ?><div class="tabbable">
							  <ul class="nav nav-pills">
							    <li class="active"><a href="#tabs4-pane1" data-toggle="tab">My Active Alerts</a></li>
							    <li class=""><a href="#tabs4-pane2" data-toggle="tab" id="ttip" rel="tooltip" data-placement="bottom" data-original-title="Click here to start setting up alerts for yourself!">Inactive Alerts</a></li>

							  <!--  <li class=""><a href="#tabs4-pane3" data-toggle="tab">Tab 3</a></li>
							    <li class=""><a href="#tabs4-pane4" data-toggle="tab">Tab 4</a></li> -->
							  </ul>
                              <?php } ?>
							  <div class="tab-content">
							    <div id="tabs4-pane1" class="tab-pane active">
							      
                                 
									<!-- list subscribed services here with sms/email icons -->
                                
                                 <?php 
								  $MyServices = array();
								 
								 if($Count_of_Alerts == 0 && in_array('revenue',$AR_PList)) {?>
                                 
                                 
                                 	
                                            <div class="alert alert-block">
                                      
                                      <h4>Oops! No Alerts!</h4>
                                        Seems like you don't have any alerts set for yourself.
                                    </div>

<?php } elseif(!in_array('revenue',$AR_PList)) { ?>  <div class="alert alert-block">
                                      
                                      <h4>Oops! No access to Alerts!</h4>
                                        Seems like you don't have access enabled for alerts.
                                    </div><?php } else{ ?> <table class="table table-bordered">

								 <tr> <?php
								  
								  $i=-1;
								  while($RSelected = mysql_fetch_array($GetSelected)) {
								 $i++; 
								 
								 array_push($MyServices,$RSelected['service']);
								 
								 if($i%3==0 && $i !=0) {
									 echo "</tr><tr>";
								 }
									 ?> 
                                 <td><?php
								 	if(strcmp($RSelected['alert_type'],'E') == 0) {
								 ?><span class="label label-info">Email</span><?php } else{
									 ?><span class="label label-success">&nbsp;SMS&nbsp;</span><?php } ?>
								 	<a href="#listService" data-toggle='modal' data-title="<?php echo $RSelected['name'];?>" data-service="<?php echo $RSelected['service'];?>"><?php echo $RSelected['name'];?></a>
                                 </td>
                                 
                                 
								   <?php }
								   
								   for($k=1;$k<(3-$i%3);$k++) {
									   
									   echo "<td>&nbsp;</td>";
								   }
								    ?>
                                  </tr>
                                  </table>
                                  <?php } ?>
							    </div>
							    <div id="tabs4-pane2" class="tab-pane">
							    <!-- Non Subscribed Services -->
                                
                                <table class="table table-bordered">

								 <tr> <?php
								if(count($MyServices) > 0) {
									  sksort($MyServices);
								  $Diff = array_diff($AR_SList,$MyServices);
								  sksort($Diff,"Name",TRUE);
								  $i=-1;
								} else{
									$Diff = $AR_SList;	
								}
									
									foreach($Diff as $RSelected) {
								
								if($Service_DESC[$RSelected]['livemis'] == true) {
									 $i++; 
								 

								 if($i%3==0 && $i !=0) {
									 echo "</tr><tr>";
								 }
									 ?> 
                                 <td><span class="label">Silent</span>
								 <a href="#listService" data-toggle='modal' data-title="<?php echo $Service_DESC[$RSelected]['Name'];?>" data-service="<?php echo $RSelected;?>"><?php echo $Service_DESC[$RSelected]['Name'];?></a>
                                 </td>
                                 
                                 
								   <?php }
									}
								   
								   for($k=1;$k<(3-$i%3);$k++) {
									   
									   echo "<td>&nbsp;</td>";
								   }
								    ?>
                                  </tr>
                                  </table>
                                
                                
                                <!-- End of Non Subscribed Services -->
                                
                                </div>
							    <div id="tabs4-pane3" class="tab-pane">
							      <h4>Pane 3 Content</h4>
							      <p>Ut porta rhoncus ligula, sed fringilla felis feugiat eget. In non purus quis elit iaculis tincidunt. Donec at ultrices est.</p>
							    </div>
							    <div id="tabs4-pane4" class="tab-pane">
							      <h4>Pane 4 Content</h4>
							      <p>Donec semper vestibulum dapibus. Integer et sollicitudin metus. Vivamus at nisi turpis. Phasellus vel tellus id felis cursus hendrerit. Suspendisse et arcu felis, ac gravida turpis. Suspendisse potenti.</p>
							    </div>
							  </div><!-- /.tab-content -->
							</div><!-- /.tabbable -->
						</div>

</div>
</div>
<div id="listService" class="modal hide fade" data-cache="false" >
    <div class="modal-header">
      <button class="close" data-dismiss="modal">&times;</button>
      
      <h3 id="listService-Title">Title</h3>
    </div>
    <div class="modal-body">            
        <div id="modalContent" style="display:none;">

        </div>
    </div>
    <div class="modal-footer">
      <a href="#" class="btn btn-info" data-dismiss="modal" id="listService-close" >Close</a>
      <a href="#" class="btn btn-info" data-dismiss="modal" id="listService-refresh" >Reload Alerts</a>
      <a href="#" class="btn btn-danger" id="listService-remove">Remove Alerts</a>
      <a href="#" class="btn btn-success" id="listService-submit">Save Changes</a>
    </div>
</div>  

<?php

include "Menu-Vertical.php";

?>

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
    
    <script src="assets/js/jquery.pageslide.js"></script>
    
 	<script>
	
				$('#listService-refresh').hide();
	
    $("a[data-toggle=modal]").click(function() 
{   
    var service = $(this).attr('data-service');
    var title = $(this).attr('data-title');
	            
	$('#modalContent').html('<img src="assets/img/loading-circle-48x48.gif" border="0" alt="loading.." />');
	$('#listService-Title').text(title);
	//alert(essay_id);
    $.ajax({
        cache: false,
        type: 'GET',
        url: 'snippets/User.Alerts.EditService.php',
        data: 'username=<?php echo $username;?>&service='+service,
        success: function(data) 
        {
            $('#listService').show();
            $('#modalContent').show().html(data);
        }
    });
});

// This creates submit handler for the form


// This creates the on click handler for the submit button
$('#listService-submit').on('click', function() {
    // This actually submits the form
    
	// e.preventDefault();
	 //alert($('#comment_form').serialize() + '&action=send');
        // validate form actions cleaned for clearity.
		var n = $("input:checkbox:checked").length;
		var k = $("input:radio:checked").length;
		
		if(k==0) {
		$('#alert-no-alert_type').show();
		return false();	
		}
		
		if(n==0) {
		$('#alert-no-circle').show();
		return false();	
		}
		


        $.ajax({
            url: 'snippets/User.Alerts.EditService-Post.php',
            data: $('#listService_form').serialize() + '&action=send',
            type: 'post',
            cache: false,
            dataType: 'html',
            success: function (xhr) {
                /*
                more code here...
                */
				$('#listService-submit').hide();
				$('#listService-remove').hide();

				$('#modalContent').html(xhr);
                //alert('OK!');
            }
			
        });
	
	
	
	
});
    
	$('#listService-remove').on('click', function() {
		//alert('Hello');
			$.ajax({
				url: 'snippets/User.Alerts.EditService-Post.php',
				data: $('#listService_form').serialize() + '&action=del',
				type: 'post',
				cache: false,
				dataType: 'html',
				success: function (xhr) {
					/*
					more code here...
					*/
					$('#listService-submit').hide();
					$('#listService-remove').hide();
	
					$('#modalContent').html(xhr);
					//alert('OK!');
				}
				
			});
	});
	$('#listService-refresh').on('click', function() {
		location.reload();
	});
	
	<?php if($Count_of_Alerts == 0 && in_array('revenue',$AR_PList)) { ?>
	$('#ttip').tooltip('show');
	<?php } ?>
	
	
		
    </script>

<script>
    $(".second").pageslide({ direction: "right", modal: true });
</script>
</body>
</html>