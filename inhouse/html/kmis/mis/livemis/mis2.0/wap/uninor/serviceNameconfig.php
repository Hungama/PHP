<?php
function failureReason($reason) {
    switch ($reason) {
        case '1307': $reason = "OTHERS"; //"Invalid Or Missing Mode";
            break;
        case '1304': $reason = "OTHERS"; //"Invalid Or Missing MSISDN";
            break;
        case '999': $reason = "OTHERS"; //"Failed";
            break;
        case '1316': $reason = "OTHERS"; //"Subscription plan not exists with try and buy offer";
            break;
        case '1305': $reason = "BAL"; //"Insufficient balance";
            break;
        case '201': $reason = "GRACE";
            break;
    }
    return $reason;
}

function getServiceName($service_id) {
    switch ($service_id) {
       	case '1411':
            $service_name = 'WAPUninorLDR';
            break;
		case '1423':
            $service_name = 'WAPUninorContest';
            break;
			
    }
    return $service_name;
}

$circle_info = array('DEL' => 'Delhi', 'GUJ' => 'Gujarat', 'WBL' => 'WestBengal', 'BIH' => 'Bihar', 'RAJ' => 'Rajasthan', 'UPW' => 'UP WEST', 'MAH' => 'Maharashtra', 'APD' => 'Andhra Pradesh',
    'UPE' => 'UP EAST', 'ASM' => 'Assam', 'TNU' => 'Tamil Nadu', 'KOL' => 'Kolkata', 'NES' => 'NE', 'CHN' => 'Chennai', 'ORI' => 'Orissa', 'KAR' => 'Karnataka', 'HAY' => 'Haryana', 'PUN' => 'Punjab', 'MUM' => 'Mumbai', 'MPD' => 'Madhya Pradesh', 'JNK' => 'Jammu-Kashmir', 'PUB' => "Punjab", 'KER' => 'Kerala', 'HPD' => 'Himachal Pradesh','OTH'=>'Others','UND' => 'Others',' ' => 'Others');
?>