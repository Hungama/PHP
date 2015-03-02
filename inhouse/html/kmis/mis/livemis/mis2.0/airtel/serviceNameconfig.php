<?php

function getServiceName($service_id)
{
	switch($service_id)
		{
			case '1501':
				$service_name='AirtelEU';
			break;
			case '1502':
				$service_name='Airtel54646';
			break;
			case '1503':
				$service_name='MTVAirtel';
			break;
			case '1511':
				$service_name='AirtelGL';
			break;
			case '1507':
				$service_name='VH1Airtel';
			break;
			case '1509':
				$service_name='RIAAirtel';
			break;
			case '1518':
				$service_name='AirtelComedy';
			break;
			case '1513':
				$service_name='AirtelMND';
			break;
			case '1514':
				$service_name='AirtelPD';
			break;
			case '1517':
				$service_name='AirtelSE';
			break;
			case '1515':
				$service_name='AirtelDevo';
			break;
			case '1520':
				$service_name='AirtelPK';
			break;
			case '15221':
				$service_name='AirtelRegKK'; //planid-64 (21)
			break;
			case '15222':
				$service_name='AirtelRegTN'; //planid-63 (22)
			break;
			case '15112':
				$service_name='WAPAirtelLDR';//planid( 93,94,95,96)
			break;
			case '1527':
				$service_name='WAPAirtelLDR';//planid( 93,94,95,96)
			break;
              }
		return $service_name;
}

$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan',
    'UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu',
    'KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAY'=>'Haryana','HAR'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh');

?>