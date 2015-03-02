<?php

mysql_connect("localhost",$dbUSERNAME,$dbPASSWORD);
mysql_select_db($dbDATABASE);

$Services = ($_REQUEST['Service'])?"'".join("','",$_REQUEST['Service'])."'":"";
$Circles = ($_REQUEST['Circle'])?"'".join("','",$_REQUEST['Circle'])."'":"";
list($Date_From,$Date_To) = explode(" - ",$_REQUEST['Date_current']);
list($Date_PFrom,$Date_PTo) = explode(" - ",$_REQUEST['Date_past']);


function QueryBuild($Param,$Query) {
	
if(strlen($Param['Circle']) > 1) {
$Query = str_replace('%CIRCLE_SET%',' and Circle in ('.$Param['Circle'].') ',$Query);
} else{
$Query = str_replace('%CIRCLE_SET%','',$Query);
}
//echo $Query;exit;
        if(strlen($Param['Service']) > 1) {
        $Query = str_replace('%Service%',' Service in ('.$Param['Service'].') and ',$Query);
       // $Query = str_replace('%Service_NOAND%',' where Service = \''.$Param['Service'].'\' ',$Query);
        } else{
        $Query = str_replace('%Service%','',$Query);
       // $Query = str_replace('%Service_NOAND%','',$Query);
        }
		
		
		if(strlen($Param['NotIn']) > 1) {
        $Query = str_replace('%NotIn%',' and concat(Service,"|",circle) not in ('.$Param['NotIn'].') ',$Query);
       // $Query = str_replace('%Service_NOAND%',' where Service = \''.$Param['Service'].'\' ',$Query);
        } else{
        $Query = str_replace('%NotIn%','',$Query);
       // $Query = str_replace('%Service_NOAND%','',$Query);
        }

$Query = str_replace('%StartDate%',$Param['StartDate'],$Query);
$Query = str_replace('%EndDate%',$Param['EndDate'],$Query);
return $Query;
}

function updownI($percent,$bit=false) {
	
	if($percent>0 && $bit == false) {
		return 'uparrow.png';
	} elseif($percent<0 && $bit == false) {
		return 'downarrow.png';
	} elseif($percent>0 && $bit == true) {
		return 'downarrow.png';
	} elseif($percent<0 && $bit == true) {
		return 'uparrow.png';
	}elseif($percent==0) {
		return 'flatarrow.png';
	}
	
}
function updown($percent,$bit=false) {
	
	if($percent>0 && $bit == false) {
		return 'text-success';
	} elseif($percent<0 && $bit == false) {
		return 'text-danger';
	} elseif($percent>0 && $bit == true) {
		return 'text-danger';
	} elseif($percent<0 && $bit == true) {
		return 'text-success';
	} elseif($percent==0) {
		return 'text-muted';	
	}
	
}


function array_to_json( $array ){

    if( !is_array( $array ) ){
        return false;
    }

    $associative = count( array_diff( array_keys($array), array_keys( array_keys( $array )) ));
    if( $associative ){

        $construct = array();
        foreach( $array as $key => $value ){

            // We first copy each key/value pair into a staging array,
            // formatting each key and value properly as we go.

            // Format the key:
            if( is_numeric($key) ){
                $key = "key_$key";
            }
            $key = "'".addslashes($key)."'";

            // Format the value:
            if( is_array( $value )){
                $value = array_to_json( $value );
            } else if( !is_numeric( $value ) || is_string( $value ) ){
                $value = "'".addslashes($value)."'";
            }

            // Add to staging array:
            $construct[] = "$key: $value";
        }

        // Then we collapse the staging array into the JSON form:
        $result = "{ " . implode( ", ", $construct ) . " }";

    } else { // If the array is a vector (not associative):

        $construct = array();
        foreach( $array as $value ){

            // Format the value:
            if( is_array( $value )){
                $value = array_to_json( $value );
            } else if( !is_numeric( $value ) || is_string( $value ) ){
                $value = "'".addslashes($value)."'";
            }

            // Add to staging array:
            $construct[] = $value;
        }

        // Then we collapse the staging array into the JSON form:
        $result = "[ " . implode( ", ", $construct ) . " ]";
    }

    return $result;
}



function PinGenerate($lenth =5) { 
    // makes a random alpha numeric string of a given lenth 
    $aZ09 = array_merge(range('A', 'Z'), range('a', 'z'),range(0, 9)); 
    $out =''; 
    for($c=0;$c < $lenth;$c++) { 
       $out .= $aZ09[mt_rand(0,count($aZ09)-1)]; 
    } 
    return $out; 
} 


?>