<?php
function getServiceName($service_id) {
    switch ($service_id) {
        case 'EnterpriseMcDwOBD':
            $service_name = 'EnterpriseMcDwOBD';
            break;
		case 'EnterpriseAfricaGSKOBD':
            $service_name = 'EnterpriseAfricaGSKOBD';
            break;
		case 'EnterpriseTiscon':
            $service_name = 'EnterpriseTiscon';
            break;
		case 'EnterpriseMcDw':
            $service_name = 'EnterpriseMcDw';
            break;
		case 'EnterpriseAfricaGSK':
            $service_name = 'EnterpriseAfricaGSK';
            break;
		case 'EnterpriseMaxLifeIVR':
            $service_name = 'EnterpriseMaxLifeIVR';
            break;
			
		}
    return $service_name;
}

$circle_info = array('DEL' => 'Delhi', 'GUJ' => 'Gujarat', 'WBL' => 'WestBengal', 'BIH' => 'Bihar', 'RAJ' => 'Rajasthan', 'UPW' => 'UP WEST', 'MAH' => 'Maharashtra', 'APD' => 'Andhra Pradesh',
    'UPE' => 'UP EAST', 'ASM' => 'Assam', 'TNU' => 'Tamil Nadu', 'KOL' => 'Kolkata', 'NES' => 'NE', 'CHN' => 'Chennai', 'ORI' => 'Orissa', 'KAR' => 'Karnataka', 'HAY' => 'Haryana', 'PUN' => 'Punjab', 'MUM' => 'Mumbai', 'MPD' => 'Madhya Pradesh', 'JNK' => 'Jammu-Kashmir', 'PUB' => "Punjab", 'KER' => 'Kerala', 'HPD' => 'Himachal Pradesh','OTH'=>'Others','UND' => 'Others',' ' => 'Others');
?>