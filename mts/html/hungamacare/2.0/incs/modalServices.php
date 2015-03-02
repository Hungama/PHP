<?php
$Telcos = array("Aircel","Airtel","MTS","LoopMobile","Videocon","Uninor","Vodafone","TataDoCoMo","TataIndicom","International","BSNL","Reliance","Idea");
$COLS=2;
asort($Telcos);
$lower_case_Telcos = array_map('strtolower', $Telcos);

$Array_List_of_services = array();

foreach($AR_SList as $service) {
	
	if(!in_array(strtolower($Service_DESC[$service]["Operator"]),$lower_case_Telcos)) {
		$OPR = "international";
	} else{
	$OPR = 	strtolower($Service_DESC[$service]["Operator"]);
	}
	if(!is_array($Array_List_of_services[$OPR])) {
	$Array_List_of_services[$OPR] = array();	
	} 
	
	array_push($Array_List_of_services[$OPR] ,$service);
	
	
	
}
ksort($Array_List_of_services);
//print_r($Array_List_of_services);

?>
<table class="table table-condensed" style="font-size: 10px">
            	<?php foreach($Array_List_of_services as $operator=>$svc) { 
				$j=1;
				?>
                <tr>
                				<td rowspan="<?php echo ceil(count($svc)/$COLS);?>" ><div class="telcologos <?php echo strtolower(str_replace(' ','',$operator));?>"></div></td>
                				<?php foreach($svc as $i=>$service) { 
								if(strcmp("international",strtolower($operator))!=0) {
									list($Waste,$Name) = explode(" - ",$Service_DESC[$service]["Name"]);
								} else{
								$Name = 	$Service_DESC[$service]["Name"];
								}
								?>
                                
                                
                                <td><nobr><input type="checkbox" value="<?php echo $service;?>" name="Service[]" id="Service" />&nbsp;<?php echo $Name;?></nobr></td>
                                
								
								<?php 
								if($j%$COLS==0 && count($svc) !=$j) { echo '</tr><tr>';}
								
								if(count($svc)==$j)
								{
									$Residue = $COLS-count($svc)%$COLS;
									
									if($Residue != 0 && $Residue != $COLS) {
										for($a=1;$a<=$Residue;$a++) {
											echo "<td>&nbsp;</td>";	
										}
									}
								}
								
								
								$j++;
								} ?>
                </tr>
                
                <?php
				 		
				 
				 
				}?>
           </table>