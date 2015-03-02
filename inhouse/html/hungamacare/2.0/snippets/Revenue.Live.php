 <?php
mysql_connect("localhost","kunalk.arora","google");
mysql_select_db("misdata");

require_once("../../../ContentBI/base.php");


//print_r($_REQUEST['Circle']);exit;

function Format($Num,$Decimal='0') {
return ($Num==0)?"-":number_format($Num,$Decimal);
}

if(isset($_REQUEST['Circle'])) {
	$Circle = "'".join("','", $_REQUEST['Circle'])."'";
	//$GRP_Circle = "Circle[]=".str_replace(" ","+",join("&Circle[]=",$_REQUEST['Circle']))."";
    //$Circle = '';
} else {
    $Circle = '';
	$GRP_Circle = '';
    
}
//print_r($Circle);exit;
$Date=$_REQUEST['Date'];
$ServiceQuery=$_REQUEST['Service'];

$MODES_DEACTIVATION = array();
$MODES_ACTIVATION = array();
  
  
  
  if(strlen($ServiceQuery)>3) { 
  
 if(strcmp($ServiceQuery,'DIGIMA')==0){
	 $DATE_TIMEZONE_SHIFT = ' DATE_SUB(DATE,INTERVAL 60 MINUTE) as Date';
	 $TIMEZONE_SHIFT =' All times below are +2:30 IST (+8:00 GMT)';
 } else{
	 $DATE_TIMEZONE_SHIFT = 'Date';	 
 }
 

  
  ?>
  
  
  
  <?php
  

 if(strcmp("mobisur",strtolower(substr($ServiceQuery,0,7))) != 0) {
	 
	 
  $Query = mysql_query("select Service, Circle, ".$DATE_TIMEZONE_SHIFT.", Type, sum(Value) as Value, sum(Revenue) as Revenue from livemis where Service='$ServiceQuery' and Date >='$Date 1:00:00' and Date <= '".date("Y-m-d",strtotime($Date)+24*60*60)." 00:00:00' and circle in ($Circle) group by Service, Circle, Date, Type") or die(mysql_error());
  $ACT = array();
  $REN = array();
  $TOP = array();
  $DCT = array();
  $FAIL_ACT = array();
  $FAIL_REN = array();
  $FOLLOW = array();
  $TICKET = array();
  $CALL_T = array();
  $CALL_TF = array();
  
  $REV_ACT = array();
  $REV_REN = array();
  $REV_TOP = array();
  $REV_FOLLOW = array();
  $REV_TICKET = array();
  $DTH_ACT=0;
  $DTH_ACT_REV=0;
  $DTH_REN=0;
  $DTH_REN_REV=0;
  $DTH_TOP=0;
  $DTH_TOP_REV=0;
  $DTH_DCT=0;

  $DTH_FOLLOW=0;
  $DTH_FOLLOW_REV=0;
  $DTH_TICKET=0;
  $DTH_TICKET_REV=0;
  
  while($Result = mysql_fetch_array($Query)) {
	//echo strtotime($Result['Date'])."<br>";
		if(strcmp(strtolower(substr($Result['Type'],0,3)),'act') == 0 && strcmp(strtolower($Result['Type']),"active_base") != 0 && strcmp(strtolower(substr($Result['Type'],0,17)),'activation_follow') != 0 && strcmp(strtolower(substr($Result['Type'],0,17)),'activation_ticket') != 0) {
			$ACT[date("G",strtotime($Result['Date']))][$Result['Type']] += $Result['Value'];
			$REV_ACT[date("G",strtotime($Result['Date']))][$Result['Type']] += $Result['Revenue'];
			
			$DTH_ACT += $Result['Value'];
			$DTH_ACT_REV += $Result['Revenue'];
			
		} elseif(strcmp(strtolower(substr($Result['Type'],0,3)),'ren') == 0) {
			$REN[date("G",strtotime($Result['Date']))][$Result['Type']] += $Result['Value'];
			$REV_REN[date("G",strtotime($Result['Date']))][$Result['Type']] += $Result['Revenue'];
			
			$DTH_REN += $Result['Value'];
			$DTH_REN_REV += $Result['Revenue'];
			
		} elseif(strcmp(strtolower(substr($Result['Type'],0,3)),'top') == 0) {
			$TOP[date("G",strtotime($Result['Date']))][$Result['Type']] += $Result['Value'];
			$REV_TOP[date("G",strtotime($Result['Date']))][$Result['Type']] += $Result['Revenue'];
			
			$DTH_TOP += $Result['Value'];
			$DTH_TOP_REV += $Result['Revenue'];
			
		}  elseif(strcmp(strtolower(substr($Result['Type'],0,8)),'calls_tf') == 0) {
			$CALL_TF[date("G",strtotime($Result['Date']))][$Result['Type']] += $Result['Value'];
			
			
			
		} elseif(strcmp(strtolower(substr($Result['Type'],0,7)),'calls_t') == 0) {
			$CALL_T[date("G",strtotime($Result['Date']))][$Result['Type']] += $Result['Value'];
			
		} elseif(strcmp(strtolower(substr($Result['Type'],0,3)),'dea') == 0) {
			$DCT[date("G",strtotime($Result['Date']))][$Result['Type']] += $Result['Value'];
			
			$DTH_DCT += $Result['Value'];
			
		}  elseif(strcmp(strtolower(substr($Result['Type'],0,17)),'activation_follow') == 0) {
			$FOLLOW[date("G",strtotime($Result['Date']))][$Result['Type']] += $Result['Value'];
			$REV_FOLLOW[date("G",strtotime($Result['Date']))][$Result['Type']] += $Result['Revenue'];
			
			
			$DTH_FOLLOW += $Result['Value'];
			$DTH_FOLLOW_REV += $Result['Revenue'];
			
		} elseif(strcmp(strtolower(substr($Result['Type'],0,17)),'activation_ticket') == 0) {
			$TICKET[date("G",strtotime($Result['Date']))][$Result['Type']] += $Result['Value'];
			$REV_TICKET[date("G",strtotime($Result['Date']))][$Result['Type']] += $Result['Revenue'];
			
			$DTH_TICKET += $Result['Value'];
			$DTH_TICKET_REV += $Result['Revenue'];
			
			
		} elseif(strcmp(strtolower(substr($Result['Type'],0,15)),'mode_activation') == 0) {
			$MODEACT[date("G",strtotime($Result['Date']))][$Result['Type']] += $Result['Value'];
					if(!in_array($Result['Type'],$MODES_ACTIVATION)) {
						array_push($MODES_ACTIVATION,$Result['Type']);
					}
			
		} elseif(strcmp(strtolower(substr($Result['Type'],0,17)),'mode_deactivation') == 0) {
			$MODEDCT[date("G",strtotime($Result['Date']))][$Result['Type']] += $Result['Value'];
					if(!in_array($Result['Type'],$MODES_DEACTIVATION)) {
						array_push($MODES_DEACTIVATION,$Result['Type']);
					}
			
		}  elseif(strcmp(strtolower(substr($Result['Type'],0,8)),'fail_act') == 0) {
			$FAIL_ACT[date("G",strtotime($Result['Date']))][$Result['Type']] += $Result['Value'];
					
			
		}  elseif(strcmp(strtolower(substr($Result['Type'],0,8)),'fail_ren') == 0) {
			$FAIL_REN[date("G",strtotime($Result['Date']))][$Result['Type']] += $Result['Value'];
					
			
		} 
		
		
  } 
 	
	
  $R_ACT = 0;$R_REN = 0;$R_TOP = 0; $R_FOLLOW=0;$R_TICKET=0;
  for($i=1;$i<=24;$i++) {
	  			if($i==24) {
					$j=0;
				} else{
					$j=$i;
				}
				$HTML_ACT .= '<td align="right">'.(is_array($ACT[$j])?number_format(array_sum($ACT[$j])):'-').'</td>';
				$HTML_REN .= '<td align="right">'.(is_array($REN[$j])?number_format(array_sum($REN[$j])):'-').'</td>';
				$HTML_TOP .= '<td align="right">'.(is_array($TOP[$j])?number_format(array_sum($TOP[$j])):'-').'</td>';
				$HTML_DCT .= '<td align="right">'.(is_array($DCT[$j])?number_format(array_sum($DCT[$j])):'-').'</td>';
				$HTML_CALLTF .= '<td align="right">'.(is_array($CALL_TF[$j])?number_format(array_sum($CALL_TF[$j])):'-').'</td>';
				$HTML_CALLT .= '<td align="right">'.(is_array($CALL_T[$j])?number_format(array_sum($CALL_T[$j])):'-').'</td>';
				$HTML_FAILACT .= '<td align="right">'.(is_array($FAIL_ACT[$j])?number_format(array_sum($FAIL_ACT[$j])):'-').'</td>';
				$HTML_FAILREN .= '<td align="right">'.(is_array($FAIL_REN[$j])?number_format(array_sum($FAIL_REN[$j])):'-').'</td>';
				$HTML_FOLLOW .= '<td align="right">'.(is_array($FOLLOW[$j])?number_format(array_sum($FOLLOW[$j])):'-').'</td>';
				$HTML_TICKET .= '<td align="right">'.(is_array($TICKET[$j])?number_format(array_sum($TICKET[$j])):'-').'</td>';
				
				if(is_array($CALL_TF[$j])) {
				$TOTAL_CALLTF += array_sum($CALL_TF[$j]);
				}
				if(is_array($CALL_T[$j])) {
				$TOTAL_CALLT += array_sum($CALL_T[$j]);
				}
				if(is_array($FAIL_ACT[$j])) {
				$TOTAL_FAILACT += array_sum($FAIL_ACT[$j]);
				}
				if(is_array($FAIL_REN[$j])) {
				$TOTAL_FAILREN += array_sum($FAIL_REN[$j]);
				}
				
			$HTML_REV_ACT .= '<td align="right">'.(is_array($REV_ACT[$j])?number_format(array_sum($REV_ACT[$j])):'-').'</td>'; 
			$HTML_REV_REN .= '<td align="right">'.(is_array($REV_REN[$j])?number_format(array_sum($REV_REN[$j])):'-').'</td>'; 
			$HTML_REV_TOP .= '<td align="right">'.(is_array($REV_TOP[$j])?number_format(array_sum($REV_TOP[$j])):'-').'</td>'; 
			$HTML_REV_FOLLOW .= '<td align="right">'.(is_array($REV_FOLLOW[$j])?number_format(array_sum($REV_FOLLOW[$j])):'-').'</td>'; 
			$HTML_REV_TICKET .= '<td align="right">'.(is_array($REV_TICKET[$j])?number_format(array_sum($REV_TICKET[$j])):'-').'</td>'; 
			
			$R_ACT += (is_array($REV_ACT[$j])?array_sum($REV_ACT[$j]):0) ;
			$R_REN += (is_array($REV_REN[$j])?array_sum($REV_REN[$j]):0);
			$R_TOP += (is_array($REV_TOP[$j])?array_sum($REV_TOP[$j]):0);
			$R_FOLLOW += (is_array($REV_FOLLOW[$j])?array_sum($REV_FOLLOW[$j]):0);
			$R_TICKET += (is_array($REV_TICKET[$j])?array_sum($REV_TICKET[$j]):0);
			$RREV = (is_array($REV_ACT[$j])?(array_sum($REV_ACT[$j])):'0') + (is_array($REV_REN[$j])?(array_sum($REV_REN[$j])):'0') + (is_array($REV_TOP[$j])?array_sum($REV_TOP[$j]):'0') + (is_array($REV_FOLLOW[$j])?(array_sum($REV_FOLLOW[$j])):'0') + (is_array($REV_TICKET[$j])?(array_sum($REV_TICKET[$j])):'0');
			$GREV += $RREV;
		
			$REV .= '<td align="right">'.Format($RREV).'</td>';
			$GROSS_REV .= '<td align="right">'.Format($GREV).'</td>';
				//echo $REV;
	}
  
  
  if(count($MODES_ACTIVATION)>0) {
					foreach($MODES_ACTIVATION as $mode_of_activation) {
						$MODE_ACT[$mode_of_activation] =0;

							 $HTML_MODES_ACT .= '<tr><td>'.str_replace("MODE_ACTIVATION_","",strtoupper($mode_of_activation)).'</td>';
							 for($i=1;$i<=24;$i++) {
									if($i==24) {
										$j=0;
									} else{
										$j=$i;
									}
							$MODE_ACT[$mode_of_activation] += $MODEACT[$j][$mode_of_activation];

							$HTML_MODES_ACT .= '<td align="right">'.(($MODEACT[$j][$mode_of_activation])>0?number_format(($MODEACT[$j][$mode_of_activation])):'-').'</td>';
							 }
							 $HTML_MODES_ACT .= '<td align="right"><strong>'.Format($MODE_ACT[$mode_of_activation]).'</strong></td>';
							  $HTML_MODES_ACT .= '</tr>';
					}
				}
				
	if(count($MODES_DEACTIVATION)>0) {
					foreach($MODES_DEACTIVATION as $mode_of_deactivation) {
						$MODE_DCT[$mode_of_deactivation] =0;
							 $HTML_MODES_DCT .= '<tr><td>'.str_replace("MODE_DEACTIVATION_","",strtoupper($mode_of_deactivation)).'</td>';
							 for($i=1;$i<=24;$i++) {
									if($i==24) {
										$j=0;
									} else{
										$j=$i;
									}
									$MODE_DCT[$mode_of_deactivation] += $MODEDCT[$j][$mode_of_deactivation];
							$HTML_MODES_DCT .= '<td align="right">'.(($MODEDCT[$j][$mode_of_deactivation])>0?number_format(($MODEDCT[$j][$mode_of_deactivation])):'-').'</td>';
							 }
							$HTML_MODES_DCT .= '<td align="right"><strong>'.Format($MODE_DCT[$mode_of_deactivation]).'</strong></td>';

							  $HTML_MODES_DCT .= '</tr>';
					}
				}
				
				$HTML_CALLTF .= '<td align="right">'.Format($TOTAL_CALLTF).'</td>';
				$HTML_CALLT .= '<td align="right">'.Format($TOTAL_CALLT).'</td>';
				$HTML_FAILACT .= '<td align="right">'.Format($TOTAL_FAILACT).'</td>';
				$HTML_FAILREN .= '<td align="right">'.Format($TOTAL_FAILREN).'</td>';
	
				
  //	print_r($ACT.$REN.$TOP.$DCT); exit;
  
	  ?> 
    <div class="alert"><a href="#" id="Refresh"><i class="icon-refresh"></i></a> Displaying Live Revenue KPI's for <?php echo $Service_DESC[$ServiceQuery]["Name"];?> </div>  
      <script>
      
      $('#Refresh').on('click', function() {
		  $('#go').trigger('click');
	  });
      </script>
      <?php
	  
	  if($_REQUEST['MOS'] ==1) {
		  
		  
	  
	  
	  ?>
      <div class="btn-group">
              <button class="btn btn-primary" type="button">01-06</button>
              <button class="btn btn-primary" type="button">07-12</button>
              <button class="btn btn-primary" type="button">13-18</button>
              <button class="btn btn-primary" type="button">19-24</button>
              <button class="btn btn-primary" type="button">Total</button>
      </div>
      
      <?php } 
	  
 }}?>
      