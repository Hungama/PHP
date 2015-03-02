<?php
error_reporting(0);
//defind all variable here
$msisdn='';
$flag='';
$serviceName='';
$status='';
$actDate='';
$deactDate='';
$lastRen='';
$renDate='';
$ratingId='';
$actMode='';
$deactMode='';
$planAmt='';
$chAmt='';
$msisdn = $_GET['msisdn'];
$flag = $_GET['flag'];
$logFile="/var/www/html/MTS/logs/statuscheck/log_".date('Ymd').".txt";
function checkmsisdn($msisdn, $flag) {
    if (strlen($msisdn) == 12 || strlen($msisdn) == 10) {
        if (strlen($msisdn) == 12) {
            if (substr($msisdn, 0, 2) == 91) {
                $msisdn = substr($msisdn, -10);
            } else {
                if ($flag == 1) {
                    echo "Failed";
                }
                exit;
            }
        }
    } elseif (strlen($msisdn) != 10) {
        if ($flag == 1) {
            echo "Failed";
        }
		else
		{
		 echo "Failed";
		}
        exit;
    }
    return $msisdn;
}

function getRatingId($chrgamount, $type, $serviceId, $planAmount) {

//all event RPID array will put here
$rpIdCPArray=array('30'=>'93002501','29'=>'92902500','28'=>'92802500','27'=>'92702500','26'=>'92602500','25'=>'92502500','24'=>'92402500','23'=>'92302500','22'=>'92202500','21'=>'9202500','20'=>'92002501','19'=>'91902500','18'=>'91802500','17'=>'91702500','16'=>'91602500','15'=>'91502501','14'=>'91402500','13'=>'91302500','12'=>'91202500','11'=>'91102500','10'=>'91002501','9'=>'90902500','8'=>'90802500','7'=>'90702501','6'=>'90602500','5'=>'90502501','4'=>'90402500','3'=>'90302501','2'=>'90202501','1'=>'90102501');

$rpIdJPArray=array('1'=>'90102503','2'=>'90202503','3'=>'90302503','4'=>'90402502','5'=>'90502503','6'=>'90602502','7'=>'90702503','8'=>'90802502','9'=>'90902502','10'=>'91002503','11'=>'91102502','12'=>'91202502','13'=>'91302502','14'=>'91402502','15'=>'91502503','16'=>'91602502','17'=>'91702502','18'=>'91802502','19'=>'91902502','20'=>'92002503','21'=>'9202502','22'=>'92202502','23'=>'92302502','24'=>'92402502','25'=>'92502502','26'=>'92602502','27'=>'92702502','28'=>'92802502','29'=>'92902502','30'=>'93002503');

$rpIdRPRArray=array('1'=>'90102502','2'=>'90202502','3'=>'90302502','4'=>'90402501','5'=>'90502502','6'=>'90602501','7'=>'90702502','8'=>'90802501','9'=>'90902501','10'=>'91002502','11'=>'91102501','12'=>'91202501','13'=>'91302501','14'=>'91402501','15'=>'91502502','16'=>'91602501','17'=>'91702501','18'=>'91802501','19'=>'91902501','20'=>'92002502','21'=>'9202501','22'=>'92202501','23'=>'92302501','24'=>'92402501','25'=>'92502501','26'=>'92602501','27'=>'92702501','28'=>'92802501','29'=>'92902501','30'=>'93002502');

$rpIdMUArray=array('1'=>'90102958','2'=>'90202912','4'=>'90402906','6'=>'90602909','8'=>'90802906','10'=>'91002974','12'=>'91202908','14'=>'91402906','16'=>'91602906','18'=>'91802908','20'=>'92002962','22'=>'92202906','24'=>'92402906','26'=>'92602906','28'=>'92802906','30'=>'93002969');

$rpIdEREDFMArray=array('1'=>'90102959','2'=>'90202914','3'=>'90302919','4'=>'90402908','5'=>'90502977','6'=>'90602911','7'=>'90702960','8'=>'90802908','9'=>'90902907','10'=>'91002976','11'=>'91102909','12'=>'91202910','13'=>'91302909','14'=>'91402908','15'=>'91502990','16'=>'91602908','17'=>'91702908','18'=>'91802910','19'=>'91902908','20'=>'92002964','21'=>'92102909','22'=>'92202908','23'=>'92302907','24'=>'92402908','25'=>'92502947','26'=>'92602908','27'=>'92702907','28'=>'92802908','29'=>'92902907','30'=>'93002971');

$rpIdMPDArray=array('1'=>'90102961','2'=>'90202916','3'=>'90302921','4'=>'90402910','5'=>'90502979','6'=>'90602913','7'=>'90702962','8'=>'90802910','9'=>'90902909','10'=>'91002978','11'=>'91102911','12'=>'91202912','13'=>'91302911','14'=>'91402910','15'=>'91502992','16'=>'91602910','17'=>'91702910','18'=>'91802912','19'=>'91902910','20'=>'92002966','21'=>'92102911','22'=>'92202910','23'=>'92302909','24'=>'92402910','25'=>'92502949','26'=>'92602910','27'=>'92702909','28'=>'92802910','29'=>'92902909','30'=>'93002973');

$rpIddevoArray=array('1.25'=>'901000000','2'=>'90202913','3'=>'90302918','4'=>'90402907','5'=>'90502976','6'=>'90602910','7'=>'90702959','8'=>'90802907','9'=>'90902906','10'=>'91002975','11'=>'91102908','12'=>'91202909','13'=>'91302908','14'=>'91402907','15'=>'91502989','16'=>'91602907','17'=>'91702907','18'=>'91802909','19'=>'91902907','20'=>'92002963','21'=>'92102908','22'=>'92202907','23'=>'92302906','24'=>'92402907','25'=>'92502946','26'=>'92602907','27'=>'92702906','28'=>'92802907','29'=>'92902906','30'=>'93002970');

$rpId54646Array=array('1'=>'90102962','2'=>'90202917','3'=>'90302922','4'=>'90402911','5'=>'90502980','6'=>'90602914','7'=>'90702963','8'=>'90802911','9'=>'90902910','10'=>'91002979','11'=>'91102912','12'=>'91202913','13'=>'91302912','14'=>'91402911','15'=>'91502993','16'=>'91602911','17'=>'91702911','18'=>'91802913','19'=>'91902911','20'=>'92002967','21'=>'92102912','22'=>'92202911','23'=>'92302910','24'=>'92402911','25'=>'92502950','26'=>'92602911','27'=>'92702910','28'=>'92802911','29'=>'92902910','30'=>'93002974');

$rpIdEVAArray=array('1'=>'90102960','2'=>'90202915','3'=>'90302920','4'=>'90402909','5'=>'90502978','6'=>'90602912','7'=>'90702961','8'=>'90802909','9'=>'90902908','10'=>'91002977','11'=>'91102910','12'=>'91202911','13'=>'91302910','14'=>'91402909','15'=>'91502991','16'=>'91602909','17'=>'91702909','18'=>'91802911','19'=>'91902909','20'=>'92002965','21'=>'92102910','22'=>'92202909','23'=>'92302908','24'=>'92402909','25'=>'92502948','26'=>'92602909','27'=>'92702908','28'=>'92802909','29'=>'92902908','30'=>'93002972');

//end here
    $ratingId = "";
    switch ($serviceId) {
        case '1111':if ($type == 'sub') {
                switch ($planAmount) {
                    case '30':
                        if ($chrgamount == 30)
                            $ratingId = "93003008";
                        else if ($chrgamount == 25)
                            $ratingId = "92503004";
                        else if ($chrgamount == 20)
                            $ratingId = "92003008";
                        else if ($chrgamount == 15)
                            $ratingId = "91503004";
                        else if ($chrgamount == 11)
                            $ratingId = "91103002";
                        else if ($chrgamount == 7)
                            $ratingId = "90703000";
                        else if ($chrgamount == 5)
                            $ratingId = "90503004";
                        else
                            $ratingId = "901253002";
                        break;
                    case '11':
                        if ($chrgamount == 11)
                            $ratingId = "91103000";
                        else if ($chrgamount == 7)
                            $ratingId = "90703000";
                        else if ($chrgamount == 5)
                            $ratingId = "90503004";
                        else
                            $ratingId = "901253002";
                        break;
                    default: if ($chrgamount == '1.25')
                            $ratingId = "901253000";
                        else
                            $ratingId = "Not Found";
                        break;
                }
            } elseif ($type == 'resub') {
                switch ($planAmount) {
                    case '30':
                        if ($chrgamount == 30)
                            $ratingId = "93003009";
                        else if ($chrgamount == 25)
                            $ratingId = "92503005";
                        else if ($chrgamount == 20)
                            $ratingId = "92003009";
                        else if ($chrgamount == 15)
                            $ratingId = "91503005";
                        else if ($chrgamount == 11)
                            $ratingId = "91103003";
                        else if ($chrgamount == 7)
                            $ratingId = "90703001";
                        else if ($chrgamount == 5)
                            $ratingId = "90503005";
                        else
                            $ratingId = "901253003";
                        break;
                    case '11':
                        if ($chrgamount == 11)
                            $ratingId = "91103001";
                        else if ($chrgamount == 7)
                            $ratingId = "90703001";
                        else if ($chrgamount == 5)
                            $ratingId = "90503005";
                        else
                            $ratingId = "901253003";
                        break;
                    default: if ($chrgamount == '1.25')
                            $ratingId = "901253001";
                        else
                            $ratingId = "Not Found";
                        break;
                }
            }
			elseif ($type == 'event') {
			$ratingId=$rpIddevoArray[$chrgamount];
			}
			else
			{
			$ratingId=$rpIddevoArray[$chrgamount];
			}
            break;
        case '1110':
            if ($type == 'sub') {
                switch ($planAmount) {
                    case '30':
                        if ($chrgamount == 30)
                            $ratingId = "93002938";
                        else if ($chrgamount == 20)
                            $ratingId = "92002943";
                        else if ($chrgamount == 15)
                            $ratingId = "91502954";
                        else if ($chrgamount == 10)
                            $ratingId = "91002953";
                        else
                            $ratingId = "90502958";
                        break;
                    case '10':
                        if ($chrgamount == 10)
                            $ratingId = "91002951";
                        else
                            $ratingId = "90502958";
                        break;
                    default:
                        $ratingId = "Not Found";
                        break;
                }
            } elseif ($type == 'resub') {
                switch ($planAmount) {
                    case '30':
                        if ($chrgamount == 30)
                            $ratingId = "93002939";
                        else if ($chrgamount == 20)
                            $ratingId = "92002944";
                        else if ($chrgamount == 15)
                            $ratingId = "91502955";
                        else if ($chrgamount == 10)
                            $ratingId = "91002954";
                        else
                            $ratingId = "90502959";
                        break;
                    case '10':
                        if ($chrgamount == 10)
                            $ratingId = "91002952";
                        else
                            $ratingId = "90502959";
                        break;
                    default:
                        $ratingId = "Not Found";
                        break;
                }
            }
			elseif ($type == 'event') {
			$ratingId=$rpIdEREDFMArray[$chrgamount];
			}
			else
			{
			$ratingId=$rpIdEREDFMArray[$chrgamount];
			}
            break;
        case '1106':
            if ($type == 'sub') {
                switch ($planAmount) {
                    case '15':
                        if ($chrgamount == 15)
                            $ratingId = "91502957";
                        elseif ($chrgamount == 12)
                            $ratingId = "91202904";
                        elseif ($chrgamount == 10)
                            $ratingId = "91002956";
                        elseif ($chrgamount == 7)
                            $ratingId = "90702929";
                        elseif ($chrgamount == 5)
                            $ratingId = "90502961";
                        elseif ($chrgamount == 2)
                            $ratingId = "90202908";
                        else
                            $ratingId = "90102928"; //chrgamt=1
                        break;
                    case 10:
                        if ($chrgamount == 10)
                            $ratingId = "91002956";
                        elseif ($chrgamount == 7)
                            $ratingId = "90702929";
                        elseif ($chrgamount == 5)
                            $ratingId = "90502961";
                        elseif ($chrgamount == 2)
                            $ratingId = "90202908";
                        else
                            $ratingId = "90102928"; //chrgamt=1
                        break;
                    case 5:
                        if ($chrgamount == 5)
                            $ratingId = "90502961";
                        elseif ($chrgamount == 2)
                            $ratingId = "90202908";
                        else
                            $ratingId = "90102928"; //chrgamt=1
                        break;
                    default:
                        $ratingId = "Not Found";
                        break;
                }
            } elseif ($type == 'resub') {
                switch ($planAmount) {
                    case 15:
                        if ($chrgamount == 15)
                            $ratingId = "91502958";
                        elseif ($chrgamount == 12)
                            $ratingId = "91202905";
                        elseif ($chrgamount == 10)
                            $ratingId = "91002957";
                        elseif ($chrgamount == 7)
                            $ratingId = "90702930";
                        elseif ($chrgamount == 5)
                            $ratingId = "90502962";
                        elseif ($chrgamount == 2)
                            $ratingId = "90202909";
                        else
                            $ratingId = "90102929"; //chrgamt=1
                        break;
                    case 10:
                        if ($chrgamount == 10)
                            $ratingId = "91002957";
                        elseif ($chrgamount == 7)
                            $ratingId = "90702930";
                        elseif ($chrgamount == 5)
                            $ratingId = "90502962";
                        elseif ($chrgamount == 2)
                            $ratingId = "90202909";
                        else
                            $ratingId = "90102929"; //chrgamt=1
                        break;
                    case 5:
                        if ($chrgamount == 5)
                            $ratingId = "90502962";
                        elseif ($chrgamount == 2)
                            $ratingId = "90202909";
                        else
                            $ratingId = "90102929"; //chrgamt=1
                        break;
                    default:
                        $ratingId = "Not Found";
                        break;
                }
            }
            break;
        case '1101':
            if ($type == 'sub') {
                if ($chrgamount == 30 || $chrgamount == 20 || $chrgamount == 10)
                    $ratingId = "9" . $chrgamount . "03006";
                elseif ($chrgamount == 2)
                    $ratingId = "90" . $chrgamount . "03000";
                else {
                    if ($chrgamount < 10) {
                        $ratingId = "90" . $chrgamount . "03000";
                    } else {
                        $ratingId = "9" . $chrgamount . "03000";
                    }
                }
            } elseif ($type == 'resub') {
                if ($chrgamount == 30 || $chrgamount == 20 || $chrgamount == 10)
                    $ratingId = "9" . $chrgamount . "03007";
                elseif ($chrgamount == 2)
                    $ratingId = "90" . $chrgamount . "03001";
                else {
                    if ($chrgamount < 10) {
                        $ratingId = "90" . $chrgamount . "03001";
                    } else {
                        $ratingId = "9" . $chrgamount . "03001";
                    }
                }
            }
			elseif ($type == 'event') {
			$ratingId=$rpIdMUArray[$chrgamount];
			}
			else
			{
			$ratingId=$rpIdMUArray[$chrgamount];
			}
            break;
        case '1102':
            if ($type == 'sub') {
                $ratingId = $chrgamount . "03000";
            } elseif ($type == 'resub') {
                $ratingId = $chrgamount . "03001";
            }
			elseif ($type == 'event') {
			$ratingId=$rpId54646Array[$chrgamount];
			}
			else
			{
			$ratingId=$rpId54646Array[$chrgamount];
			}
            break;
        case '1103':
            if ($type == 'sub') {
                if ($chrgamount % 2 == 0)
                    $ratingId = "9" . $chrgamount . "03003";
                else
                    $ratingId = "9" . $chrgamount . "03002";
            } elseif ($type == 'resub') {
                if ($chrgamount % 2 == 0)
                    $ratingId = "9" . $chrgamount . "03004";
                else
                    $ratingId = "9" . $chrgamount . "03003";
            }
            break;
          case '1123':
            if ($type == 'sub') {
               ///////////////////////
			   switch ($chrgamount) {
										case 30:
											$ratingId="93003013";
										 break;
										case 25:
											$ratingId="92503008";
										 break;
										case 20:
											$ratingId="92003013";
										 break;
										case 15:
											$ratingId="91503008";
										 break;
										case 10:
											$ratingId="91003011";
										 break;
										 case 5:
										 	$ratingId="90503008";
										 break;
										 case 3:
										  	$ratingId="90303009";
										 break;
										case 2:
											$ratingId="90203010";
										 break;
										case 1:
											$ratingId="90103010";
										 break;
						}
		   } elseif ($type == 'resub') {
							switch($chrgamount)
									{
										case 30:
											$ratingId="93003014";
										 break;
										case 25:
											$ratingId="92503009";
										 break;
										case 20:
											$ratingId="92003014";
										 break;
										case 15:
											$ratingId="91503009";
										 break;
										case 10:
											$ratingId="91003012";
										 break;
										 case 5:
										 	$ratingId="90503009";
										 break;
										 case 3:
										  	$ratingId="90303010";
										 break;
										case 2:
											$ratingId="90203011";
										 break;
										case 1:
											$ratingId="90103011";
										 break;
									}
            }
			elseif ($type == 'event') {
			$ratingId=$rpIdCPArray[$chrgamount];
			}
			else
			{
			$ratingId=$rpIdCPArray[$chrgamount];
			}
			
            break;
		case '1126':
            if ($type == 'sub') {
               ///////////////////////
			   switch ($chrgamount) {
										case 1:
												$ratingId="90103012";
												break;
											case 2:
												$ratingId="90203012";
												break;
											case 3:
												$ratingId="90303011";
												break;
											case 5:
												$ratingId="90503010";
												break;
											case 10:
												$ratingId="91003013";
												break;
											case 15:
												$ratingId="91503010";
												break;
											case 20:
												$ratingId="92003015";
												break;
											case 25:
												$ratingId="92503010";
												break;
											case 30:
												$ratingId="93003015";
												break;
						}
		   } elseif ($type == 'resub') {
							switch($chrgamount)
									{
											case 1:
												$ratingId="90103013";
												break;
											case 2:
												$ratingId="90203013";
												break;
											case 3:
												$ratingId="90303012";
												break;
											case 5:
												$ratingId="90503011";
												break;
											case 10:
												$ratingId="91003014";
												break;
											case 15:
												$ratingId="91503011";
												break;
											case 20:
												$ratingId="92003016";
												break;
											case 25:
												$ratingId="92503011";
												break;
											case 30:
												$ratingId="93003016";
												break;
									}
            }
			elseif ($type == 'event') {
			$ratingId=$rpIdRPRArray[$chrgamount];
			}
			else
			{
			$ratingId=$rpIdRPRArray[$chrgamount];
			}
            break;
			case '1125':
            if ($type == 'sub') {
               
			   switch ($chrgamount) {
										case 30:
											$ratingId="93003010";
										 break;
										case 25:
											$ratingId="92503006";
										 break;
										case 20:
											$ratingId="92003010";
										 break;
										case 15:
											$ratingId="91503006";
										 break;
										case 10:
											$ratingId="91003008";
										 break;
										 case 5:
										 	$ratingId="90503006";
										 break;
										 case 3:
										  	$ratingId="90303001";
										 break;
										case 2:
											$ratingId="90203002";
										 break;
										case 1:
											$ratingId="90103002";
										 break;
						}
		   } elseif ($type == 'resub') {
							switch($chrgamount)
									{
										case 30:
											$ratingId="93003011";
										 break;
										case 25:
											$ratingId="92503007";
										 break;
										case 20:
											$ratingId="92003011";
										 break;
										case 15:
											$ratingId="91503007";
										 break;
										case 10:
											$ratingId="91003009";
										 break;
										 case 5:
											$ratingId="90503007";
										 break;
										 case 3:
											$ratingId="90303002";
										 break;
										case 2:
											$ratingId="90203003";
										 break;
										case 1:
											$ratingId="90103003";
										 break;
									}
            }
			elseif ($type == 'event') {
			$ratingId=$rpIdJPArray[$chrgamount];
			}
			else
			{
			$ratingId=$rpIdJPArray[$chrgamount];
			}
            break;			
			case '1113':
            if ($type == 'sub') {
                  switch ($chrgamount) {
							case 1:
								$ratingId="90103006";
							 	break;
							case 2:
								$ratingId="90203006";
							 	break;
							case 3:
								$ratingId="90303005";
							 	break;
							case 5:
								$ratingId="90502972";
								break;
							case 10:
								$ratingId="91002969";
								break;
							case 15:
								$ratingId="91502971";
								break;
							case 20:
								$ratingId="92002957";
								break;
							case 25:
								$ratingId="92502942";
								break;
							case 30:
								$ratingId="93002950";
								break;
						}
		   } elseif ($type == 'resub') {
							switch($chrgamount)
									{
							case 1:
								$ratingId="90103007";
								break;
							case 2:
								$ratingId="90203007";
								break;
							case 3:
								$ratingId="90303006";
								break;
							case 5:
								$ratingId="90502973";
								break;
							case 10:
								$ratingId="91002970";
								break;
							case 15:
								$ratingId="91502972";
								break;
							case 20:
								$ratingId="92002958";
								break;
							case 25:
								$ratingId="92502943";
								break;
							case 30:
								$ratingId="93002951";
								break;
									}
            }
			elseif ($type == 'event') {
			$ratingId=$rpIdMPDArray[$chrgamount];
			}
			else
			{
			$ratingId=$rpIdMPDArray[$chrgamount];
			}
            break;
			
			case '1116':
            if ($type == 'sub') {
                switch ($planAmount) {
				case 30:
									if($chrgamount==30)
											$ratingId="93002948";
									else if($chrgamount==25)
											$ratingId="92502940";
									else if($chrgamount==20)
											$ratingId="92002955";
									else if($chrgamount==15)
											$ratingId="91502969";
									else if($chrgamount==10)
											$ratingId="91002965";
									else if($chrgamount==7)
											$ratingId="90702939";
									else if($chrgamount==5)
											$ratingId="90502968";
									else
											$ratingId="90102938";
								break;
								case 10:
									if($chrgamount==10)
										$ratingId="91002965";
									else if($chrgamount==7)
										$ratingId="90702939";
									else if($chrgamount==5)
										$ratingId="90502968";
									else
										$ratingId="90102938";
									break;
								case 7:
									if($chrgamount==7)
										$ratingId="90702939";
									else if($chrgamount==5)
										$ratingId="90502968";
									else
										$ratingId="90102938";
									break;
								case 5:
									if($chrgamount==5)
										$ratingId="90502968";
									else
										$ratingId="90102938";
									break;
								case 1:
										$ratingId="90102938";
									break;
								case 0:
										$ratingId="90003012";
									break;
							default:
							$ratingId = "Not Found";
							break;
                    
                }
            } elseif ($type == 'resub') {
                switch ($planAmount) {
                    case 30:
									if($chrgamount==30)
											$ratingId="93002949";
									else if($chrgamount==25)
											$ratingId="92502941";
									else if($chrgamount==20)
											$ratingId="92002956";
									else if($chrgamount==15)
											$ratingId="91502970";
									else if($chrgamount==10)
											$ratingId="91002966";
									else if($chrgamount==7)
											$ratingId="90702940";
									else if($chrgamount==5)
											$ratingId="90502969";
									else
											$ratingId="90102939";
								break;
								case 10:
									if($chrgamount==10)
										$ratingId="91002966";
									else if($chrgamount==7)
										$ratingId="90702940";
									else if($chrgamount==5)
										$ratingId="90502969";
									else
										$ratingId="90102939";
									break;
								case 7:
									if($chrgamount==7)
										$ratingId="90702940";
									else if($chrgamount==5)
										$ratingId="90502969";
									else
										$ratingId="90102939";
									break;
								case 5:
									if($chrgamount==5)
										$ratingId="90502969";
									else
										$ratingId="90102939";
									break;
								case 1:
										$ratingId="90102939";
									break;

                    default:
                        $ratingId = "Not Found";
                        break;
                }
            }
			elseif ($type == 'event') {
			$ratingId=$rpIdEVAArray[$chrgamount];
			}
			else
			{
			$ratingId=$rpIdEVAArray[$chrgamount];
			}
            break;
    }
    return $ratingId;
}

$msisdn = checkmsisdn($msisdn, $flag);

$con = mysql_connect("database.master_mts", "billing", "billing");
if (!$con) {
    //die('We are facing some temporarily Problem , please try later : ');
    echo 'We are facing some temporarily Problem , please try later : ';
}

$flag = 0;
$tblList = array('1101' => array('mts_radio.tbl_radio_subscription', 'mts_radio.tbl_radio_unsub'), '1102' => array('mts_hungama.tbl_jbox_subscription', 'mts_hungama.tbl_jbox_unsub'), '1103' => array('mts_mtv.tbl_mtv_subscription', 'mts_mtv.tbl_mtv_unsub'), '1106' => array('mts_starclub.tbl_jbox_subscription', 'mts_starclub.tbl_jbox_unsub'), '1110' => array('mts_redfm.tbl_jbox_subscription', 'mts_redfm.tbl_jbox_unsub'), '1111' => array('dm_radio.tbl_digi_subscription', 'dm_radio.tbl_digi_unsub'), '1125' => array('mts_JOKEPORTAL.tbl_jokeportal_subscription', 'mts_JOKEPORTAL.tbl_jokeportal_unsub'), '1126' => array('mts_Regional.tbl_regional_subscription', 'mts_Regional.tbl_regional_unsub'), '1123' => array('Mts_summer_contest.tbl_contest_subscription', 'Mts_summer_contest.tbl_contest_unsub'),'1116' => array('mts_voicealert.tbl_voice_subscription', 'mts_voicealert.tbl_voice_unsub'),'1113' => array('mts_mnd.tbl_character_subscription1', 'mts_mnd.tbl_character_unsub1'));

$total_service = sizeof($tblList);
/*
$billibngTbl = "master_db.tbl_billing_success";
$serviceData = mysql_query("select distinct(service_id),event_type from " . $billibngTbl . " nolock where msisdn='" . $msisdn . "' and event_type in('SUB','EVENT','RESUB','SUB_RETRY')");
$countData = mysql_num_rows($serviceData);

if (!$countData) {

    $serviceData = mysql_query("select distinct(service_id),event_type from master_db.tbl_billing_success_backup nolock where msisdn='" . $msisdn . "' and event_type in('SUB','EVENT','RESUB','SUB_RETRY')");
    $countData = mysql_num_rows($serviceData);
    $billibngTbl = "master_db.tbl_billing_success_backup";
}
*/
    $serviceData = mysql_query("select service_id,event_type from master_db.tbl_billing_success nolock where msisdn='" . $msisdn . "' and event_type in('SUB','EVENT','RESUB','SUB_RETRY') GROUP BY service_id UNION (select service_id,event_type from master_db.tbl_billing_success_backup nolock where msisdn='" . $msisdn . "' and event_type in('SUB','EVENT','RESUB','SUB_RETRY') GROUP BY service_id) ORDER BY service_id");
    $countData = mysql_num_rows($serviceData);
	
if ($countData) {
    header("Content-type: text/xml");
    echo "<?xml version='1.0' encoding='ISO-8859-1'?" . ">\n";
    echo "<ROOT>\n";
	$count=0;
    while ($row = mysql_fetch_array($serviceData)) {
	  
        $serviceId = $row['service_id'];
		$eventtype = $row['event_type'];
	  if ($count != $serviceId)
	  {
	     $count=$serviceId;
	    
        $serData = mysql_query("SELECT Servicename FROM master_db.tbl_app_service_master nolock WHERE Serviceid='" . $serviceId . "'");
        list($serviceName) = mysql_fetch_array($serData);
        $serviceName = $serviceId;
        $subTable = $tblList[$serviceId][0];
        $unsubTable = $tblList[$serviceId][1];
        
        $noDetail = array();
        $noDetail['msisdn'] = $msisdn;
        
        $check_subquery = "select ani,date_format(sub_date,'%d-%m-%Y %H:%i:%s') as sub_date,date_format(renew_date,'%d-%m-%Y %H:%i:%s') as renew_date, mode_of_sub, status, chrg_amount,plan_id,RPID from " . $subTable . " nolock where ANI='" . $msisdn . "'";
		//echo $check_subquery."<br>";
        $subData = mysql_query($check_subquery);
        while ($rowSub = mysql_fetch_array($subData)) {
            $noDetail['actDate'] = $rowSub['sub_date'];
            $noDetail['renDate'] = $rowSub['renew_date'];
            $noDetail['actMode'] = $rowSub['mode_of_sub'];
            $noDetail['status'] = $rowSub['status'];
            $noDetail['chrgAmt'] = $rowSub['chrg_amount'];
            $noDetail['plan_id'] = $rowSub['plan_id'];
			$noDetail['RPID'] = $rowSub['RPID'];
        }

        $check_unsubquery = "select mode_of_sub,date_format(unsub_date,'%d-%m-%Y %H:%i:%s') as unsub_date,unsub_reason from " . $unsubTable . " nolock where ANI='" . $msisdn . "'";
        $unsubData = mysql_query($check_unsubquery);
        $unsubCount = mysql_num_rows($subData);
        while ($rowUnSub = mysql_fetch_array($unsubData)) {
            $noDetail['deactMode'] = $rowUnSub['mode_of_sub'];
            $noDetail['deactDate'] = $rowUnSub['unsub_date'];
        }

        //$billingData = mysql_query("select date_format(date_time,'%d-%m-%Y %H:%i:%s') as date_time, chrg_amount from " . $billibngTbl . " nolock where msisdn='" . $msisdn . "' and event_type = 'RESUB' and service_id='" . $serviceId . "'");
		$billingData = mysql_query("select date_format(date_time,'%d-%m-%Y %H:%i:%s') as date_time, chrg_amount from master_db.tbl_billing_success nolock where msisdn='" . $msisdn . "' and event_type = 'RESUB' and service_id='" . $serviceId . "' UNION select date_format(date_time,'%d-%m-%Y %H:%i:%s') as date_time, chrg_amount from master_db.tbl_billing_success_backup nolock where msisdn='" . $msisdn . "' and event_type = 'RESUB' and service_id='" . $serviceId . "'");

        while ($rowResub = mysql_fetch_array($billingData)) {
            $noDetail['lastRen'] = $rowResub['date_time'];
            $noDetail['lastRenAmt'] = $rowResub['chrg_amount'];
        }

        $planData = mysql_query("select iAmount from master_db.tbl_plan_bank nolock where Plan_id=" . $noDetail['plan_id']);
        list($planAmount) = mysql_fetch_array($planData);

        if ($noDetail['lastRenAmt']) {
            $ratingId = getRatingId($noDetail['lastRenAmt'], 'resub', $serviceId, $planAmount);
            $chargeAmt = $noDetail['lastRenAmt'];
			
			}
		elseif($eventtype=='EVENT') {
					$ratingId = getRatingId($noDetail['chrgAmt'], 'event', $serviceId, $planAmount);
					$chargeAmt = $noDetail['chrgAmt'];
					
				}
			else {
            $ratingId = getRatingId($noDetail['chrgAmt'], 'sub', $serviceId, $planAmount);
            $chargeAmt = $noDetail['chrgAmt'];
			
        }
		//print_r($noDetail);

        if ($noDetail['status'] == 1)
            $status = "Active";
        elseif ($noDetail['status'] == 0)
            $status = "Not Active";
        elseif ($noDetail['status'] == 11)
            $status = "Pending";

       if ($noDetail['status'] == 1) {
            $actDate = $noDetail['actDate'] ? $noDetail['actDate'] : "";
            $deactDate = $noDetail['deactDate'] ? $noDetail['deactDate'] : "";
            $renDate = $noDetail['renDate'] ? $noDetail['renDate'] : "";
            $lastRen = $noDetail['lastRen'] ? $noDetail['lastRen'] : "";
            $actMode = $noDetail['actMode'] ? $noDetail['actMode'] : "";
            $deactMode = $noDetail['deactMode'] ? $noDetail['deactMode'] : "";
            $planAmt = $planAmount ? $planAmount : "";
            $chAmt = $chargeAmt ? $chargeAmt : "";
			$ratingId = $noDetail['RPID'] ? $noDetail['RPID'] : "";

            echo "<SERVICE>\n";
            echo "<SVCNAME>" . $serviceName . "</SVCNAME>\n";
            echo "<SVCSTATUS>" . $status . "</SVCSTATUS>\n";
            echo "<ACTDATE>" . $actDate . "</ACTDATE>\n";
            echo "<DEACTDATE>" . $deactDate . "</DEACTDATE>\n";
            echo "<RENDATE>" . $lastRen . "</RENDATE>\n";
            echo "<NEXTRENDATE>" . $renDate . "</NEXTRENDATE>\n";
			echo "<LASTRENDATE>" . $lastRen . "</LASTRENDATE>\n";
            echo "<RATINGID>" . $ratingId . "</RATINGID>\n";
            echo "<ACTMODE>" . $actMode . "</ACTMODE>\n";
            echo "<DEACTMODE>" . $deactMode . "</DEACTMODE>\n";
            echo "<PLANAMOUNT>" . $planAmt . "</PLANAMOUNT>\n";
            echo "<CHAGREAMOUNT>" . $chAmt . "</CHAGREAMOUNT>\n";
            echo "</SERVICE>\n";
        }
		}
$responseMessage=$msisdn."#".$serviceName."#".$status."#".$actDate."#".	$deactDate."#".	$lastRen."#".$renDate."#".$ratingId."#".$actMode."#".$deactMode."#".$planAmt."#".$chAmt."#".date('Y-m-d H:i:s')."\r\n";
error_log($responseMessage,3,$logFile);	
    
	}
    echo "</ROOT>\n";

} else {
    header("Content-type: text/xml");
    echo "<?xml version='1.0' encoding='ISO-8859-1'?" . ">\n";
    echo "<ROOT>\n";
    echo "<SVCSTATUS>No Record Found.</SVCSTATUS>\n";
    echo "</ROOT>\n";
}

if ($con) {
    mysql_close($con);
}
?>