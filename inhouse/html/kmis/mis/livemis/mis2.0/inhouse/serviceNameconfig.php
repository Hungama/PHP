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
        case '1001':
            $service_name = 'TataDoCoMoMX';
            break;
        case '1003':
            $service_name = 'MTVTataDoCoMo';
            break;
        case '1002':
            $service_name = 'TataDoCoMo54646';
            break;
        case '1005':
            $service_name = 'TataDoCoMoFMJ';
            break;
        case '1202':
            $service_name = 'Reliance54646';
            break;
        case '1203':
            $service_name = 'MTVReliance';
            break;
        case '1208':
            $service_name = 'RelianceCM';
            break;
        case '1201':
            $service_name = 'RelianceMM';
            break;
        case '1403':
            $service_name = 'MTVUninor';
            break;
        case '1402':
            $service_name = 'Uninor54646';
            break;
        case '1410':
            $service_name = 'REDFMUninor';
            break;
        case '1602':
            $service_name = 'TataIndicom54646';
            break;
        case '1601':
            $service_name = 'TataDoCoMoMXcdma';
            break;
        case '1603':
            $service_name = 'MTVTataDoCoMocdma';
            break;
        case '1605':
            $service_name = 'TataDoCoMoFMJcdma';
            break;
        case '1609':
            $service_name = 'RIATataDoCoMocdma';
            break;
        case '1009':
            $service_name = 'RIATataDoCoMo';
            break;
        case '1409':
		case '1413':
            $service_name = 'RIAUninor';
            break;
        case '1801':
            $service_name = 'TataDoCoMoMXvmi';
            break;
		case '1902':
            $service_name = 'Aircel54646';
            break;
        case '1809':
            $service_name = 'RIATataDoCoMovmi';
            break;
        case '1010':
            $service_name = 'REDFMTataDoCoMo';
            break;
        case '1412':
            $service_name = 'UninorRT';
            break;
        case '1610':
            $service_name = 'REDFMTataDoCoMocdma';
            break;
        case '1810':
            $service_name = 'REDFMTataDoCoMovmi';
            break;
        case '1416':
            $service_name = 'UninorAstro';
            break;
        case '14021':
            $service_name = 'AAUninor';
            break;
        case '1408':
            $service_name = 'UninorSU';
            break;
        case '1418':
            $service_name = 'UninorComedy';
            break;
        case '2121':
            $service_name = 'SMSEtisalatNigeria';
            break;
        case '14101':
            $service_name = 'WAPREDFMUninor';
            break;
        case '1423':
            $service_name = 'UninorContest';
            break;
        case '1013':
            $service_name = 'TataDoCoMoMND';
            break;
        case '1613':
            $service_name = 'TataDoCoMoMNDcdma';
            break;
        case '1813':
            $service_name = 'TataDoCoMoMNDvmi';
            break;
        case '1430':
            $service_name = 'UninorVABollyAlerts';
            break;
        case '1431':
            $service_name = 'UninorVAFilmy';
            break;
        case '1432':
            $service_name = 'UninorVABollyMasala';
            break;
        case '1433':
            $service_name = 'UninorVAHealth';
            break;
        case '1434':
            $service_name = 'UninorVAFashion';
            break;
		case '1438':
            $service_name = 'SMSUninorFashion';
            break;
		case '1439':
            $service_name = 'SMSUninorGujarati';
            break;
		case '1440':
            $service_name = 'SMSUninorAlert';
            break;
	    case '1050':
		    $service_name ='WAPTataDoCoMoLDR';
			break;
    }
    return $service_name;
}

$circle_info = array('DEL' => 'Delhi', 'GUJ' => 'Gujarat', 'WBL' => 'WestBengal', 'BIH' => 'Bihar', 'RAJ' => 'Rajasthan', 'UPW' => 'UP WEST', 'MAH' => 'Maharashtra', 'APD' => 'Andhra Pradesh',
    'UPE' => 'UP EAST', 'ASM' => 'Assam', 'TNU' => 'Tamil Nadu', 'KOL' => 'Kolkata', 'NES' => 'NE', 'CHN' => 'Chennai', 'ORI' => 'Orissa', 'KAR' => 'Karnataka', 'HAY' => 'Haryana', 'PUN' => 'Punjab', 'MUM' => 'Mumbai', 'MPD' => 'Madhya Pradesh', 'JNK' => 'Jammu-Kashmir', 'PUB' => "Punjab", 'KER' => 'Kerala', 'HPD' => 'Himachal Pradesh','OTH'=>'Others','UND' => 'Others',' ' => 'Others');
?>