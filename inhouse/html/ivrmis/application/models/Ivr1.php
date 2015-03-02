<?php
session_start();
/**
 * Class for IVR model
 *
 * This class is used for IVR model 
 *
 * @version 1.0
 * @project GDP
 */

class Application_Model_Ivr1 {

    public function generatevlcumReport($data) {
		
        
    }
	/**
     * First time page loading
     *
     * This function is used to get operator list
     *
     * @param $data
     * @return  
     */
    public function generatemsisdnReport() {
       /*------ change as per requirment*/
       $contents = file_get_contents("http://192.168.100.212:1111/IVRMIS/FillData?username=".$_SESSION['name']); 
        return $contents;
    }
	/**
     * get report response function
     *
     * This function is used to get report reponse based on date and operator
     *
     * @param $data
     * @return  
     */
    public function getReportAjax($startdate,$operator){
	$contents="http://192.168.100.212:1111/IVRMIS/UtilizationReport?startdate=". $startdate.'&operator=' . $operator;
	//$contents=file_get_contents("http://192.168.100.212:1111/IVRMIS/UtilizationReport?startdate=". $startdate.'&operator=' . $operator ); 
	//return $contents;	
		$result=curl_init($contents);
		curl_setopt($result,CURLOPT_RETURNTRANSFER,TRUE);
		$res= curl_exec($result);
		curl_close($result);
		return $res;
	}
	/**
     * get report response function
     *
     * This function is used to get report reponse based on date and operator
     *
     * @param $data
     * @return  
     */
    public function getChartReport($data){
	 $yesterday_date=date("m/d/Y", mktime(0, 0, 0, date("m"),date("d")-1,date("Y")));
	 $contents=file_get_contents("http://192.168.100.212:1111/IVRMIS/UtilizationChart?startdate=". $yesterday_date.'&operator=' . 'Reliance'); 
	return $contents;	
		}
	 
	/**
     * get report response function
     *
     * This function is used to get report reponse based on date and operator
     *
     * @param $data
     * @return  
     */
    public function getReport(){
	 $yesterday_date=date("m/d/Y", mktime(0, 0, 0, date("m"),date("d")-1,date("Y")));
	$contents=file_get_contents("http://192.168.100.212:1111/IVRMIS/UtilizationReport?startdate=".$yesterday_date.'&operator=' . 'Reliance' );
	return $contents;	
		}
   public function getReportIntervalAjax($hour,$startdate,$operator){
                $contents=file_get_contents("http://192.168.100.212:1111/IVRMIS/TimeIntervalReport?hour=".$hour.'&startdate='. $startdate.'&operator='. $operator); 
		
return $contents;
		}


//------------------------------------------------------------------------------------------------------------------------------------------------------//	
      public function generateserviceReport($data) {
       // $contents = file_get_contents('http://192.168.4.41:8081/ReportGeneration/FillData');
         $contents = file_get_contents(MIS_service);
        return $contents;
    }

    public function generatemsisdnsReport($data) {
//        try {
//            $str = "";
            $str2 = "";
//
//            if (isset($data['ListBox1'])) {
//                foreach ($data['ListBox1'] as $one) {
//                    $str = $str . $one . ",";
//                }  // echo $str; 
//            }
//            // echo $str;exit();
//            $str = urlencode($str);
//
            if (isset($data['ListBox2'])) {
                foreach ($data['ListBox2'] as $one1) {
                    $str2 = $str2 . $one1 . ",";
                } // echo "hellllloooo ========>".$str2; 
            }
            $str2 = urlencode($str2);
         //   echo MIS_circlecalls;exit();
//
//            //$serviceData = $data['ListBox1'];
             $temp= MIS_circlecalls.'?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . '&ListBox2=' . $str2 .''  ; 
          // $temp = 'http://192.168.4.41:8081/IVRReport1/CircleTotalCalls?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] .  '&ListBox2=' . $str2 . '';
          echo $temp;
           echo"<iframe style='border:none' src=\"" . $temp . "\"width='900px' height=600>";
//            $contents = file_get_contents('http://192.168.4.41:8081/IVRReport/MsisdnSummary?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . '&ListBox8=' . $str . '&ListBox2=' . $str2 . '&group1=' . $data['group1'] . '');
//            //  print_r($contents);
//            return $contents;
//        } catch (Exception $e) {
//            var_dump($e);
//        }
//            $temp = 'http://192.168.4.41:8081/ChartWeb/ChartDemo';
//            echo"<iframe style='border:none' src=\"" . $temp . "\"width='900px' height=600>";
//            $contents = file_get_contents('http://192.168.4.41:8081/ChartWeb/ChartDemo');
//            //  print_r($contents);
//            return $contents;
        //echo "hello";
        
    }
      public function generatemsisdnpReport($data) {
//        try {
//            $str = "";
            $str2 = "";
//
//            if (isset($data['ListBox1'])) {
//                foreach ($data['ListBox1'] as $one) {
//                    $str = $str . $one . ",";
//                }  // echo $str; 
//            }
//            // echo $str;exit();
//            $str = urlencode($str);
//
           if (isset($data['ListBox2'])) {
                foreach ($data['ListBox2'] as $one1) {
                    $str2 = $str2 . $one1 . ",";
                } // echo "hellllloooo ========>".$str2; 
           }
            $str2 = urlencode($str2);
         // echo MIS_circlepulses;exit();
//            //$serviceData = $data['ListBox1'];
//            $temp = 'http://192.168.4.41:8081/IVRReport1/CircleTotalPulses?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . '&ListBox2=' . $str2 .  '';
//          echo $temp;
            $temp=  MIS_circlepulses.'?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . '&ListBox2=' . $str2 .''  ; 
            echo $temp;
          
            echo"<iframe style='border:none' src=\"" . $temp. "\"width='900px' height=600>";
//            $contents = file_get_contents('http://192.168.4.41:8081/IVRReport/MsisdnSummary?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . '&ListBox8=' . $str . '&ListBox2=' . $str2 . '&group1=' . $data['group1'] . '');
//            //  print_r($contents);
//            return $contents;
//        } catch (Exception $e) {
//            var_dump($e);
//        }
//            $temp = 'http://192.168.4.41:8081/ChartWeb/ChartDemo';
//            echo"<iframe style='border:none' src=\"" . $temp . "\"width='900px' height=600>";
//            $contents = file_get_contents('http://192.168.4.41:8081/ChartWeb/ChartDemo');
//            //  print_r($contents);
//            return $contents;
      //  echo "hello";
        
    }
      public function generatemsisdnduReport($data) {
//        try {
//            $str = "";
          $str2 = "";
//
//            if (isset($data['ListBox1'])) {
//                foreach ($data['ListBox1'] as $one) {
//                    $str = $str . $one . ",";
//                }  // echo $str; 
//            }
//            // echo $str;exit();
//            $str = urlencode($str);
//
        if (isset($data['ListBox2'])) {
                foreach ($data['ListBox2'] as $one1) {
                    $str2 = $str2 . $one1 . ",";
                } // echo "hellllloooo ========>".$str2; 
            }
            $str2 = urlencode($str2);
//
//            //$serviceData = $data['ListBox1'];
               $temp= MIS_circleduration.'?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . '&ListBox2=' . $str2 .''  ; 
           // $temp = 'http://192.168.4.41:8081/IVRReport1/CircleTotalDuration?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . '&ListBox2=' . $str2 . '';
            echo $temp;
            echo"<iframe style='border:none' src=\"" . $temp . "\"width='900px' height=600>";
//            $contents = file_get_contents('http://192.168.4.41:8081/IVRReport/MsisdnSummary?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . '&ListBox8=' . $str . '&ListBox2=' . $str2 . '&group1=' . $data['group1'] . '');
//            //  print_r($contents);
//            return $contents;
//        } catch (Exception $e) {
//            var_dump($e);
//        }
//            $temp = 'http://192.168.4.41:8081/ChartWeb/ChartDemo';
//            echo"<iframe style='border:none' src=\"" . $temp . "\"width='900px' height=600>";
//            $contents = file_get_contents('http://192.168.4.41:8081/ChartWeb/ChartDemo');
//            //  print_r($contents);
//            return $contents;
        //echo "hello";
        
    }
    public function generateservicesReport($data) {
//        try {
           $str = "";
//            $str2 = "";
//
            if (isset($data['ListBox1'])) {
                foreach ($data['ListBox1'] as $one) {
                    $str = $str . $one . ",";
                }  // echo $str; 
            }
            // echo $str;exit();
            $str = urlencode($str);
//
//            if (isset($data['ListBox2'])) {
//                foreach ($data['ListBox2'] as $one1) {
//                    $str2 = $str2 . $one1 . ",";
//                } // echo "hellllloooo ========>".$str2; 
//            }
//            $str2 = urlencode($str2);
//
////            //$serviceData = $data['ListBox1'];
          //  $temp = 'http://192.168.4.41:8081/IVRReport1/ServiceTotalCalls?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . '&ListBox8=' . $str .  '';
        $temp= MIS_servicecalls.'?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . '&ListBox8=' . $str .''  ;     
            echo $temp;
            echo"<iframe style='border:none' src=\"" . $temp . "\"width='900px' height=600>";
//
//           $contents = file_get_contents('http://192.168.4.41:8081/IVRReport/MsisdnSummary?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . '&ListBox8=' . $str . '&ListBox2=' . $str2 . '&group1=' . $data['group1'] . '');
//  print_r($contents);exit();
//            return $contents;
//        } catch (Exception $e) {
//            var_dump($e);
//        }
//            $temp = 'http://192.168.4.41:8081/ChartWeb/ChartDemo';
//            echo"<iframe style='border:none' src=\"" . $temp . "\"width='900px' height=600>";
//            $contents = file_get_contents('http://192.168.4.41:8081/ChartWeb/ChartDemo');
//            //  print_r($contents);
//            return $contents;
        echo "hello";
        
    }
       public function generateservicepReport($data) {
//        try {
            $str = "";
//            $str2 = "";
//
            if (isset($data['ListBox1'])) {
                foreach ($data['ListBox1'] as $one) {
                    $str = $str . $one . ",";
                }  // echo $str; 
            }
//            // echo $str;exit();
            $str = urlencode($str);
//
//            if (isset($data['ListBox2'])) {
//                foreach ($data['ListBox2'] as $one1) {
//                    $str2 = $str2 . $one1 . ",";
//                } // echo "hellllloooo ========>".$str2; 
//            }
//            $str2 = urlencode($str2);
//
//            //$serviceData = $data['ListBox1'];
//             $contents = file_get_contents('http://192.168.4.41:8081/IVRReport1/ServiceTotalPulses?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . '&ListBox8=' . $str .  '');
//           print_r($contents);exit();
             //$temp = 'http://192.168.4.41:8081/IVRReport1/ServiceTotalPulses?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . '&ListBox8=' . $str .  '';
           $temp= MIS_servicepulses.'?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . '&ListBox8=' . $str .''  ; 
            echo $temp;
            echo"<iframe style='border:none' src=\"" . $temp . "\"width='900px' height=600>";
//            $contents = file_get_contents('http://192.168.4.41:8081/IVRReport/MsisdnSummary?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . '&ListBox8=' . $str . '&ListBox2=' . $str2 . '&group1=' . $data['group1'] . '');
//            //  print_r($contents);
//            return $contents;
//        } catch (Exception $e) {
//            var_dump($e);
//        }
//            $temp = 'http://192.168.4.41:8081/ChartWeb/ChartDemo';
//            echo"<iframe style='border:none' src=\"" . $temp . "\"width='900px' height=600>";
//            $contents = file_get_contents('http://192.168.4.41:8081/ChartWeb/ChartDemo');
//            //  print_r($contents);
//            return $contents;
        echo "hello";
        
    }
       public function generateserviceduReport($data) {
//        try {
            $str = "";
//            $str2 = "";
//
            if (isset($data['ListBox1'])) {
                foreach ($data['ListBox1'] as $one) {
                    $str = $str . $one . ",";
                }  // echo $str; 
            }
//            // echo $str;exit();
            $str = urlencode($str);
//
//            if (isset($data['ListBox2'])) {
//                foreach ($data['ListBox2'] as $one1) {
//                    $str2 = $str2 . $one1 . ",";
//                } // echo "hellllloooo ========>".$str2; 
//            }
//            $str2 = urlencode($str2);
//
//            //$serviceData = $data['ListBox1'];
           // $temp = 'http://192.168.4.41:8081/IVRReport1/ServiceTotalDuration?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . '&ListBox8=' . $str .  '';
       $temp= MIS_serviceduration.'?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . '&ListBox8=' . $str .''  ;        
       echo $temp;    
       echo"<iframe style='border:none' src=\"" . $temp . "\"width='900px' height=600>";
//            $contents = file_get_contents('http://192.168.4.41:8081/IVRReport/MsisdnSummary?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . '&ListBox8=' . $str . '&ListBox2=' . $str2 . '&group1=' . $data['group1'] . '');
//            //  print_r($contents);
//            return $contents;
//        } catch (Exception $e) {
//            var_dump($e);
//        }
//            $temp = 'http://192.168.4.41:8081/ChartWeb/ChartDemo';
//            echo"<iframe style='border:none' src=\"" . $temp . "\"width='900px' height=600>";
//            $contents = file_get_contents('http://192.168.4.41:8081/ChartWeb/ChartDemo');
//            //  print_r($contents);
//            return $contents;
        echo "hello";
        
    }
     public function generatemsisdnchartReport($data) {
        //  print_r($data); 
        $str = "";
        $str2 = "";
         $ListBox2=(explode("#",$data[ListBox2]));
        if (isset($ListBox2)) {
            
            foreach ($ListBox2 as $one) {
                if($one!=""){
                $str = $str . $one . ",";
         
            }}
        }  // echo $str; 
        $str = urlencode($str);

//        if (isset($data['ListBox2'])) {
//            foreach ($data['ListBox2'] as $one1) {
//                $str2 = $str2 . $one1 . ",";
//            }
//        }  // echo "hellllloooo ========>".$str2; 
//        $str2 = urlencode($str2);

        //$serviceData = $data['ListBox1'];
       // $temp1 = 'http://192.168.4.41:8081/IVRReport1/CircleWiseSummary?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . '&ListBox2=' . $str  . '&group1=' . $data['group1'] . '';
      $temp1 = MIS_msisdnchart.'?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . '&ListBox2=' . $str  . '&group1=' . $data['group1'] . '';
        echo $temp1;
        echo"<iframe style='border:none' src=\"" . $temp1 . "\"width='900px' height=600>";
        // echo $temp1;
//        $contents = file_get_contents('http://192.168.4.41:8081/IVRReport1/CircleWiseSummary?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . '&ListBox2=' . $str  . '&group1=' . $data['group1'] . '');
//         print_r($contents);
    }
     public function generateservicechartReport($data) {
        //  print_r($data); //exit();
        $str = "";
        $str2 = "";
         $ListBox1=(explode("#",$data[ListBox1]));
        if (isset($ListBox1)) {
            
            foreach ($ListBox1 as $one) {
                if($one!=""){
                $str = $str . $one . ",";
         
            }}
        }  // echo $str; 
        $str = urlencode($str);

//        if (isset($data['ListBox2'])) {
//            foreach ($data['ListBox2'] as $one1) {
//                $str2 = $str2 . $one1 . ",";
//            }
//        }  // echo "hellllloooo ========>".$str2; 
//        $str2 = urlencode($str2);

        //$serviceData = $data['ListBox1'];
     //   $temp1 = 'http://192.168.4.41:8081/IVRReport1/MsisdnSummary?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . '&ListBox8=' . $str  . '&group1=' . $data['group1'] . '';
           $temp1 = MIS_servicechart.'?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . '&ListBox8=' . $str  . '&group1=' . $data['group1'] . '';
        
        echo $temp1;
        echo"<iframe style='border:none' src=\"" . $temp1 . "\"width='900px' height=600>";
        // echo $temp1;
        //$contents = file_get_contents('http://192.168.4.41:8081/IVRReport/MsisdnSummary?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . '&ListBox2=' . $str . '&ListBox2=' . $str2 . '&group1=' . $data['group1'] . '');
        // print_r($contents);
    }
//    

    public function generatemsisdndReport($data) {
        //  print_r($data); //exit();
          $str = "";
        $str2 = "";
         $ListBox2=(explode("#",$data[ListBox2]));
        if (isset($ListBox2)) {
            
            foreach ($ListBox2 as $one) {
                if($one!=""){
                $str = $str . $one . ",";
         
            }}
        }  // echo $str; 
        $str = urlencode($str);

        //$serviceData = $data['ListBox1'];
     //   $temp1 = 'http://192.168.4.41:8081/IVRReport1/CircleWiseDetailedReport?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . '&ListBox2=' . $str  . '&group1=' . $data['group1'] . '';
           $temp1 = MIS_circledetail.'?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . '&ListBox2=' . $str  . '&group1=' . $data['group1'] . '';
        
        echo $temp1;
        echo"<iframe style='border:none' src=\"" . $temp1 . "\"width='900px' height=600>";
//         echo $temp1;
      //  $contents = file_get_contents('http://192.168.4.41:8081/IVRReport1/MsisdnDetail?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . '&ListBox8=' . $str . '&ListBox2=' . $str2 . '&group1=' . $data['group1'] . '');
        // print_r($contents);
    }
    
    public function generateservicedReport($data) {
        //  print_r($data); //exit();
          $str = "";
        $str2 = "";
         $ListBox1=(explode("#",$data[ListBox1]));
        if (isset($ListBox1)) {
            
            foreach ($ListBox1 as $one) {
                if($one!=""){
                $str = $str . $one . ",";
         
            }}
        }  // echo $str; 
        $str = urlencode($str);

        //$serviceData = $data['ListBox1'];
      //  $temp1 = 'http://192.168.4.41:8081/IVRReport1/ServiceWiseDetailedReport?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . '&ListBox1=' . $str  . '&group1=' . $data['group1'] . '';
          $temp1 = MIS_servicedetail.'?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . '&ListBox1=' . $str  . '&group1=' . $data['group1'] . ''; 
        
        echo $temp1;
        echo"<iframe style='border:none' src=\"" . $temp1 . "\"width='900px' height=600>";
//         echo $temp1;
      //  $contents = file_get_contents('http://192.168.4.41:8081/IVRReport1/MsisdnDetail?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . '&ListBox8=' . $str . '&ListBox2=' . $str2 . '&group1=' . $data['group1'] . '');
        // print_r($contents);
    }

    public function generateshortReport($data) {
       // $contents = file_get_contents('http://192.168.4.41:8081/ReportGeneration/FillData');
        //  echo "http://192.168.4.41:8081/ReportGeneration/FillData";
        // print_r($contents);
        //print_r($_REQUEST);
          $contents = file_get_contents(MIS_short);
        return $contents;

        // print_r($data); 
        // $pack = urlencode("DOWNLOAD 7 AT 5");
        // $temp6='http://192.168.4.41:8081/ReportGeneration/DateWiseSummaryReport?startdate='.$data['startdate'].'&enddate='.$data['enddate'].'' ;
        //  echo $temp6;
        //echo"<iframe src=\"".$temp6."\"width='100%' height=600>";
        //$contents = file_get_contents('http://192.168.4.41:8081/ReportGeneration/DateWiseSummaryReport?startdate='.$data['startdate'].'&enddate='.$data['enddate'].'');
        //echo "http://192.168.4.41:8081/ReportGeneration/PackContentDetailReport?startdate=".$data['startdate']."&enddate=".$data['enddate']."";
        //print_r($contents);
        //  echo "helo";
    }

    public function generateshortsReport($data) {
        //    print_r($data); //exit();
        $str = "";
        $str2 = "";
        $str3 = "";
        $str4 = "";
//        print_r(($data['ListBox1']));
//        echo "sid";exit();
        if (isset($data['ListBox1'])) {
            foreach ($data['ListBox1'] as $one) {


                $str = $str . $one . ",";
            }
        } // echo $str; 
        $str = urlencode($str);
        if (isset($data['ListBox2'])) {
            foreach ($data['ListBox2'] as $one1) {

                $str2 = $str2 . $one1 . ",";
               
            }
        }// echo "hellllloooo ========>".$str2; 
        $str2 = urlencode($str2);
//         echo "sidhi";echo $str2;
//                exit();
        if (isset($data['ListBox3'])) {
            foreach ($data['ListBox3'] as $one2) {

                $str3 = $str3 . $one2 . ",";
            }
        }  // echo "hellllloooo ========>".$str3; 
        $str3 = urlencode($str3);
        if (isset($data['ListBox4'])) {
            foreach ($data['ListBox4'] as $one3) {

                $str4 = $str4 . $one3 . ",";
            }
        }// echo "hellllloooo ========>".$str4; 
        $str4 = urlencode($str4);

        //$serviceData = $data['ListBox1'];
        $temp = 'http://192.168.4.41:8081/IVRReport1/ShortPlanSummary?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . '&ListBox8=' . $str . '&ListBox2=' . $str2 . '&ListBox3=' . $str3 . '&ListBox4=' . $str4 . '&group1=' . $data['group1'] . '';
//         echo $temp; exit();
        echo"<iframe style='border:none; padding-bottom:32px' src=\"" . $temp . "\"width='900px' height=600>";
        $contents = file_get_contents('http://192.168.4.41:8081/IVRReport1/ShortPlanSummary?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . '&ListBox8=' . $str . '&ListBox2=' . $str2 . '&ListBox3=' . $str3 . '&ListBox4=' . $str4 . '&group1=' . $data['group1'] . '');
        // print_r($contents);
    }

    ///public function generateshort1Report($data) {
    //  $contents = file_get_contents('http://192.168.4.41:8081/ReportGeneration/FillData');
    //  echo "http://192.168.4.41:8081/ReportGeneration/FillData";
    //  print_r($contents);
      //print_r($_REQUEST);
    //  return $contents;
     // } 

    public function generateshortdReport($data) {
        //    print_r($data); //exit();
        $str = "";
        $str2 = "";
        $str3 = "";
        $str4 = "";

        if (isset($data['ListBox1'])) {
            foreach ($data['ListBox1'] as $one) {
                $str = $str . $one . ",";
            }
        } //echo $str; 
        $str = urlencode($str);
        if (isset($data['ListBox2'])) {
            foreach ($data['ListBox2'] as $one1) {

                $str2 = $str2 . $one1 . ",";
            }
        }// echo "hellllloooo ========>".$str2; 
        $str2 = urlencode($str2);
        if (isset($data['ListBox3'])) {
            foreach ($data['ListBox3'] as $one2) {
                $str3 = $str3 . $one2 . ",";
            }
        }//  echo "hellllloooo ========>".$str3; 
        $str3 = urlencode($str3);
        if (isset($data['ListBox4'])) {
            foreach ($data['ListBox4'] as $one3) {
                $str4 = $str4 . $one3 . ",";
            }
        } //  echo "hellllloooo ========>".$str4; 
        $str4 = urlencode($str4);

        //$serviceData = $data['ListBox1'];
        $temp = 'http://192.168.4.41:8081/IVRReport1/ShortPlanDetail?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . '&ListBox8=' . $str . '&ListBox2=' . $str2 . '&ListBox3=' . $str3 . '&ListBox4=' . $str4 . '&group1=' . $data['group1'] . '';
          echo $temp;
        echo"<iframe style='border:none' src=\"" . $temp . "\"width='900px' height=600>";
        $contents = file_get_contents('http://192.168.4.41:8081/IVRReport1/ShortPlanDetail?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . '&ListBox8=' . $str . '&ListBox2=' . $str2 . '&ListBox3=' . $str3 . '&ListBox4=' . $str4 . '&group1=' . $data['group1'] . '');
        //  print_r($contents);
    }

    public function generatetimeReport($data) {
        //$contents = file_get_contents('http://192.168.4.41:8081/ReportGeneration/FillData');
        // print_r($contents);
        // echo"<pre>";
        // print_r($data);
         $contents = file_get_contents(MIS_time);
        return($contents);
        // $data1="http://192.168.4.41:8081/IVRReport/MsisdnDetail?startdate=01/07/2011&enddate=30/07/2011&ListBox1=Reliance%2054646&ListBox2=Bihar,Kerla";
        //$contents = file_get_contents($data1);
        //echo "http://192.168.4.41:8081/ReportGeneration/FillData";
        //print_r($contents);
        //print_r($_REQUEST);
        //return $contents;
        // print_r($data); 
        // $pack = urlencode("DOWNLOAD 7 AT 5");
        // $temp6='http://192.168.4.41:8081/ReportGeneration/DateWiseSummaryReport?startdate='.$data['startdate'].'&enddate='.$data['enddate'].'' ;
        //  echo $temp6;
        //echo"<iframe src=\"".$temp6."\"width='100%' height=600>";
        //$contents = file_get_contents('http://192.168.4.41:8081/ReportGeneration/DateWiseSummaryReport?startdate='.$data['startdate'].'&enddate='.$data['enddate'].'');
        //echo "http://192.168.4.41:8081/ReportGeneration/PackContentDetailReport?startdate=".$data['startdate']."&enddate=".$data['enddate']."";
        //print_r($contents);
        //  echo "helo";
    }

    public function generatetimesReport($data) {
        //    print_r($data); //exit();
        $str = "";
        $str2 = "";
        $str3 = "";
        $str4 = "";
        if (isset($data['ListBox1'])) {
            foreach ($data['ListBox1'] as $one) {
                $str = $str . $one . ",";
            }
        }  // echo $str; 
        $str = urlencode($str);
        if (isset($data['ListBox2'])) {
            foreach ($data['ListBox2'] as $one1) {
                $str2 = $str2 . $one1 . ",";
            }
        }   //echo "hellllloooo ========>".$str2; 
        $str2 = urlencode($str2);
        if (isset($data['ListBox3'])) {
            foreach ($data['ListBox3'] as $one2) {
                $str3 = $str3 . $one2 . ",";
            }
        }  // echo "hellllloooo ========>".$str3; 
        $str3 = urlencode($str3);
        if (isset($data['ListBox4'])) {
            foreach ($data['ListBox4'] as $one3) {
                $str4 = $str4 . $one3 . ",";
            }
        } // echo "hellllloooo ========>".$str4; 
        $str4 = urlencode($str4);
        echo "hello";

        //$serviceData = $data['ListBox1'];
//        $temp = 'http://192.168.4.41:8081/IVRReport/TimeBased?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . '&ListBox8=' . $str . '&ListBox2=' . $str2 . '&ListBox3=' . $str3 . '&ListBox4=' . $str4 . '';
//        // echo $temp;
//        echo"<iframe  style='border:none' src=\"" . $temp . "\"width='900px' height=600>";
//        $contents = file_get_contents('http://192.168.4.41:8081/IVRReport/TimeBased?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . '&ListBox8=' . $str . '&ListBox2=' . $str2 . '&ListBox3=' . $str3 . '&ListBox4=' . $str4 . '');
        //      print_r($contents);
    }
     public function generatetimechartReport($data) {
           $str = "";
        $str2 = "";
        $str3 = "";
        $str4 = "";
       // echo "sidhi";
        // print_r($data[ListBox1]);exit();
         $ListBox1=(explode("#",$data[ListBox1]));
          $ListBox2=(explode("#",$data[ListBox2]));
           $ListBox3=(explode("#",$data[ListBox3]));
            $ListBox4=(explode("#",$data[ListBox4]));
       //print_r($ListBox1);exit();
//        if (isset($data['$ListBox1'])) {
//            foreach ($data['$ListBox1'] as $one) {
//                $str = $str . $one . ",";
//          echo "hellllllllllllpooooooo";      echo $str;exit();
//            }
//        }  // echo $str; 
//        $str = urlencode($str);
//        if (isset($data['$ListBox2'])) {
//            foreach ($data['$ListBox2'] as $one1) {
//                $str2 = $str2 . $one1 . ",";
//            }
//        }   //echo "hellllloooo ========>".$str2; 
//        $str2 = urlencode($str2);
//        if (isset($data['$ListBox3'])) {
//            foreach ($data['$ListBox3'] as $one2) {
//                $str3 = $str3 . $one2 . ",";
//            }
//        }  // echo "hellllloooo ========>".$str3; 
//        $str3 = urlencode($str3);
//        if (isset($data['ListBox4'])) {
//            foreach ($data['ListBox4'] as $one3) {
//                $str4 = $str4 . $one3 . ",";
//            }
//        } // echo "hellllloooo ========>".$str4; 
//        $str4 = urlencode($str4);
//        
//        echo  $str;echo  $str2;echo  $str3;echo  $str4;  //exit();
        if (isset($ListBox1)) {
            
            foreach ($ListBox1 as $one) {
                if($one!=""){
                $str = $str . $one . ",";
         
            }}
        }  // echo $str; 
        $str = urlencode($str);
//         echo "hellllllllllllpooooooo";      echo $str;exit();
        if (isset($ListBox2)) {
            
            foreach ($ListBox2 as $one) {
                if($one!=""){
                $str2 = $str2 . $one . ",";
         
            }}
        }  // echo $str; 
        $str2 = urlencode($str2);
      if (isset($ListBox3)) {
            
            foreach ($ListBox3 as $one2) {
                if($one2!=""){
                $str3= $str3 . $one2 . ",";
         
            }}
        }  // echo $str; 
        $str3 = urlencode($str3);
        if (isset($ListBox4)){
            
            foreach ($ListBox4 as $one3) {
                if($one3!=""){
                $str4 = $str4 . $one3 . ",";
         
            }}
        }  // echo $str; 
        $str4 = urlencode($str4);
        
      //  echo  $str;echo  $str2;echo  $str3;echo  $str4; exit();

        //$serviceData = $data['ListBox1'];
        //$temp = 'http://192.168.4.41:8081/IVRReport1/TimeBased?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . '&ListBox8=' . $str . '&ListBox2=' . $str2 . '&ListBox3=' . $str3 . '&ListBox4=' . $str4 . '&group1=' . $data['group1'] .'';
       // echo $temp;
        $temp = MIS_timesummary.'?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . '&ListBox8=' . $str . '&ListBox2=' . $str2 . '&ListBox3=' . $str3 . '&ListBox4=' . $str4 . '&group1=' . $data['group1'] .'';
       echo $temp;
        echo"<iframe  style='border:none' src=\"" . $temp . "\"width='900px' height=600>";
        $contents = file_get_contents('http://192.168.4.41:8081/IVRReport1/TimeBased?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . '&ListBox8=' . $str . '&ListBox2=' . $str2 . '&ListBox3=' . $str3 . '&ListBox4=' . $str4 .'&group1=' . $data['group1'] . '');
         
     
     }
    public function generatetimedReport($data) {
        //  print_r($data); exit();
        $str = "";
        $str2 = "";
        $str3 = "";
        $str4 = "";
        if (isset($data['ListBox1'])) {
            foreach ($data['ListBox1'] as $one) {
                $str = $str . $one . ",";
            }
        }  // echo $str; 
        $str = urlencode($str);
        if (isset($data['ListBox2'])) {
            foreach ($data['ListBox2'] as $one1) {
                $str2 = $str2 . $one1 . ",";
            }
        }  //echo "hellllloooo ========>".$str2; 
        $str2 = urlencode($str2);
        if (isset($data['ListBox3'])) {
            foreach ($data['ListBox3'] as $one2) {
                $str3 = $str3 . $one2 . ",";
            }
        }   //echo "hellllloooo ========>".$str3; 
        $str3 = urlencode($str3);
        if (isset($data['ListBox4'])) {
            foreach ($data['ListBox4'] as $one3) {
                $str4 = $str4 . $one3 . ",";
            }
        }  //echo "hellllloooo ========>".$str4; 
        $str4 = urlencode($str4);

        //$serviceData = $data['ListBox1'];
        $temp = 'http://192.168.4.41:8081/IVRReport1/ShortPlanSummary?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . '&ListBox8=' . $str . '&ListBox2=' . $str2 . '&ListBox3=' . $str3 . '&ListBox4=' . $str4 . '';
        // echo $temp;
        echo"<iframe style='border:none' src=\"" . $temp . "\"width='900px' height=600>";
        //       $contents = file_get_contents('http://192.168.4.65:8081/IVR/Msisdn?startdate='.$data['startdate'].'&enddate='.$data['enddate'].'&ListBox8='.$str.'&ListBox2='.$str2.'&ListBox3='.$str3.'&ListBox4='.$str4.'&group1='.$group1.'');
    }
    
    public function generatetimecReport($data) {
        //  print_r($data); exit();
        $str = "";
        $str2 = "";
        $str3 = "";
        $str4 = "";
        if (isset($data['ListBox1'])) {
            foreach ($data['ListBox1'] as $one) {
                $str = $str . $one . ",";
            }
        }  // echo $str; 
        $str = urlencode($str);
        if (isset($data['ListBox2'])) {
            foreach ($data['ListBox2'] as $one1) {
                $str2 = $str2 . $one1 . ",";
            }
        }  //echo "hellllloooo ========>".$str2; 
        $str2 = urlencode($str2);
        if (isset($data['ListBox3'])) {
            foreach ($data['ListBox3'] as $one2) {
                $str3 = $str3 . $one2 . ",";
            }
        }   //echo "hellllloooo ========>".$str3; 
        $str3 = urlencode($str3);
        if (isset($data['ListBox4'])) {
            foreach ($data['ListBox4'] as $one3) {
                $str4 = $str4 . $one3 . ",";
            }
        }  //echo "hellllloooo ========>".$str4; 
        $str4 = urlencode($str4);

        //$serviceData = $data['ListBox1'];
       // $temp = 'http://192.168.4.41:8081/IVRReport1/IntervalTotalCalls?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . '&ListBox8=' . $str . '&ListBox2=' . $str2 . '&ListBox3=' . $str3 . '&ListBox4=' . $str4 . '';
           $temp= MIS_timecalls.'?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . '&ListBox8=' . $str .'&ListBox2=' . $str2 . '&ListBox3=' . $str3 . '&ListBox4=' . $str4 .''  ; 
        echo $temp;
        echo"<iframe style='border:none' src=\"" . $temp . "\"width='900px' height=600>";
        //       $contents = file_get_contents('http://192.168.4.65:8081/IVR/Msisdn?startdate='.$data['startdate'].'&enddate='.$data['enddate'].'&ListBox8='.$str.'&ListBox2='.$str2.'&ListBox3='.$str3.'&ListBox4='.$str4.'&group1='.$group1.'');
    }
    public function generatetimepReport($data) {
        //  print_r($data); exit();
        $str = "";
        $str2 = "";
        $str3 = "";
        $str4 = "";
        if (isset($data['ListBox1'])) {
            foreach ($data['ListBox1'] as $one) {
                $str = $str . $one . ",";
            }
        }  // echo $str; 
        $str = urlencode($str);
        if (isset($data['ListBox2'])) {
            foreach ($data['ListBox2'] as $one1) {
                $str2 = $str2 . $one1 . ",";
            }
        }  //echo "hellllloooo ========>".$str2; 
        $str2 = urlencode($str2);
        if (isset($data['ListBox3'])) {
            foreach ($data['ListBox3'] as $one2) {
                $str3 = $str3 . $one2 . ",";
            }
        }   //echo "hellllloooo ========>".$str3; 
        $str3 = urlencode($str3);
        if (isset($data['ListBox4'])) {
            foreach ($data['ListBox4'] as $one3) {
                $str4 = $str4 . $one3 . ",";
            }
        }  //echo "hellllloooo ========>".$str4; 
        $str4 = urlencode($str4);

        //$serviceData = $data['ListBox1'];
      //  $temp = 'http://192.168.4.41:8081/IVRReport1/IntervalTotalPulses?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . '&ListBox8=' . $str . '&ListBox2=' . $str2 . '&ListBox3=' . $str3 . '&ListBox4=' . $str4 . '';
        
          $temp= MIS_timepulses.'?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . '&ListBox8=' . $str .'&ListBox2=' . $str2 . '&ListBox3=' . $str3 . '&ListBox4=' . $str4 .''  ; 
        echo $temp;
        echo"<iframe style='border:none' src=\"" . $temp . "\"width='900px' height=600>";
        //       $contents = file_get_contents('http://192.168.4.65:8081/IVR/Msisdn?startdate='.$data['startdate'].'&enddate='.$data['enddate'].'&ListBox8='.$str.'&ListBox2='.$str2.'&ListBox3='.$str3.'&ListBox4='.$str4.'&group1='.$group1.'');
    }
    public function generatetimeduReport($data) {
        //  print_r($data); exit();
        $str = "";
        $str2 = "";
        $str3 = "";
        $str4 = "";
        if (isset($data['ListBox1'])) {
            foreach ($data['ListBox1'] as $one) {
                $str = $str . $one . ",";
            }
        }  // echo $str; 
        $str = urlencode($str);
        if (isset($data['ListBox2'])) {
            foreach ($data['ListBox2'] as $one1) {
                $str2 = $str2 . $one1 . ",";
            }
        }  //echo "hellllloooo ========>".$str2; 
        $str2 = urlencode($str2);
        if (isset($data['ListBox3'])) {
            foreach ($data['ListBox3'] as $one2) {
                $str3 = $str3 . $one2 . ",";
            }
        }   //echo "hellllloooo ========>".$str3; 
        $str3 = urlencode($str3);
        if (isset($data['ListBox4'])) {
            foreach ($data['ListBox4'] as $one3) {
                $str4 = $str4 . $one3 . ",";
            }
        }  //echo "hellllloooo ========>".$str4; 
        $str4 = urlencode($str4);

        //$serviceData = $data['ListBox1'];
        //$temp = 'http://192.168.4.41:8081/IVRReport1/IntervalTotalDuration?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . '&ListBox8=' . $str . '&ListBox2=' . $str2 . '&ListBox3=' . $str3 . '&ListBox4=' . $str4 . '';
        
          $temp= MIS_timeduration.'?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . '&ListBox8=' . $str .'&ListBox2=' . $str2 . '&ListBox3=' . $str3 . '&ListBox4=' . $str4 .''  ; 
        echo $temp;
        echo"<iframe style='border:none' src=\"" . $temp . "\"width='900px' height=600>";
        //       $contents = file_get_contents('http://192.168.4.65:8081/IVR/Msisdn?startdate='.$data['startdate'].'&enddate='.$data['enddate'].'&ListBox8='.$str.'&ListBox2='.$str2.'&ListBox3='.$str3.'&ListBox4='.$str4.'&group1='.$group1.'');
    }
    
    
      public function generatetoptenalbumReport($data) {
        //$contents = file_get_contents('http://192.168.4.41:8081/ReportGeneration/FillData');
        // echo "http://192.168.4.41:8081/ReportGeneration/FillData";
        //  print_r($contents);
           echo "hello";
        //return $contents;
    }
    
     public function generatetoptenalbumnametReport($data) {
//        $contents = file_get_contents('http://192.168.4.41:8081/ReportGeneration/FillData');
//        // echo "http://192.168.4.41:8081/ReportGeneration/FillData";
//        //  print_r($contents);
//
//        return $contents;
         
         //echo "hello";
         //$temp = 'http://192.168.4.41:8081/IVRReport1/AlbumPlayTime?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate']  . '';
          
              $temp= MIS_albumtime.'?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . '' ; 
         echo $temp;
           echo"<iframe style='border:none' src=\"" . $temp . "\"width='900px' height=600>";
    }
      public function generatetoptenalbumnamecReport($data) {
//        $contents = file_get_contents('http://192.168.4.41:8081/ReportGeneration/FillData');
//        // echo "http://192.168.4.41:8081/ReportGeneration/FillData";
//        //  print_r($contents);
//
//        return $contents;
         
         //echo "hello";
              $temp= MIS_albumcount.'?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . '' ; 
          echo $temp;
           echo"<iframe style='border:none' src=\"" . $temp . "\"width='900px' height=600>";
    }
      public function generatetoptenalbumnamesReport($data) {
//        $contents = file_get_contents('http://192.168.4.41:8081/ReportGeneration/FillData');
//        // echo "http://192.168.4.41:8081/ReportGeneration/FillData";
//        //  print_r($contents);
//
//        return $contents;
         
         //echo "hello";
         // $temp = 'http://192.168.4.41:8081/IVRReport1/AlbumPlayedSongs?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate']  . '';
               $temp= MIS_albumsongs.'?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . '' ; 
          echo $temp;
           echo"<iframe style='border:none' src=\"" . $temp . "\"width='900px' height=600>";
    }
     public function generatetoptenalbsummaryReport($data) {
//        $contents = file_get_contents('http://192.168.4.41:8081/ReportGeneration/FillData');
//        // echo "http://192.168.4.41:8081/ReportGeneration/FillData";
//        //  print_r($contents);
//
//        return $contents;
//         
 // $temp1 = 'http://192.168.4.41:8081/IVRReport1/AlbumSummary?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . '&group1=' . $data['group1'] .'';
        
      $temp1 = MIS_albsummary.'?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . '&group1=' . $data['group1'] .'';    
         echo $temp1;
        echo"<iframe style='border:none' src=\"" . $temp1 . "\"width='900px' height=600>";
         
         echo "hello";
    }
    public function generatetoptenalbdetailReport($data){
     //   $temp1 = 'http://192.168.4.41:8081/IVRReport1/AlbumDetailedReport?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . '&group1=' . $data['group1'] .'';
        $temp1 = MIS_albdetail.'?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . '&group1=' . $data['group1'] .'';
        echo $temp1;
        echo"<iframe style='border:none' src=\"" . $temp1 . "\"width='900px' height=600>";
         
 //        echo "hello";
    
        
        
    }
       public function generatetoptenringtoneReport($data) {
        //$contents = file_get_contents('http://192.168.4.41:8081/ReportGeneration/FillData');
        // echo "http://192.168.4.41:8081/ReportGeneration/FillData";
        //  print_r($contents);
    //       echo "hello";
        //return $contents;
    }
    
     public function generatetoptenringtonetReport($data) {
//        $contents = file_get_contents('http://192.168.4.41:8081/ReportGeneration/FillData');
//        // echo "http://192.168.4.41:8081/ReportGeneration/FillData";
//        //  print_r($contents);
//
//        return $contents;
         
        // echo "hello";
       //   $temp = 'http://192.168.4.41:8081/IVRReport1/RingToneHits?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate']  . '';
           $temp= MIS_ringtonehits.'?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . '' ; 
         echo $temp;
           echo"<iframe style='border:none' src=\"" . $temp . "\"width='900px' height=600>";
    }
      public function generatetoptenringtonecReport($data) {
//        $contents = file_get_contents('http://192.168.4.41:8081/ReportGeneration/FillData');
//        // echo "http://192.168.4.41:8081/ReportGeneration/FillData";
//        //  print_r($contents);
//
//        return $contents;
         
         //echo "hello";
          
           $temp = 'http://192.168.4.41:8081/IVRReport1/RingtonePlayCount?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate']  . '';
          echo $temp;
           echo"<iframe style='border:none' src=\"" . $temp . "\"width='900px' height=600>";
    }
      public function generatetoptenringtonesReport($data) {
//        $contents = file_get_contents('http://192.168.4.41:8081/ReportGeneration/FillData');
//        // echo "http://192.168.4.41:8081/ReportGeneration/FillData";
//        //  print_r($contents);
//
//        return $contents;
         
         //echo "hello";
          
          $temp = 'http://192.168.4.41:8081/IVRReport1/RingtonePlaySongs?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate']  . '';
          echo $temp;
           echo"<iframe style='border:none' src=\"" . $temp . "\"width='900px' height=600>";
    }
     public function generatetoptenringtonesummaryReport($data) {
//        $contents = file_get_contents('http://192.168.4.41:8081/ReportGeneration/FillData');
//        // echo "http://192.168.4.41:8081/ReportGeneration/FillData";
//        //  print_r($contents);
//
//        return $contents;
//         
       //  $temp1 = 'http://192.168.4.41:8081/IVRReport1/RingtoneSummary?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . '&group1=' . $data['group1'] .'';
        $temp1 = MIS_ringtonesummary.'?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . '&group1=' . $data['group1'] .'';
         
         echo $temp1;
        echo"<iframe style='border:none' src=\"" . $temp1 . "\"width='900px' height=600>";
         
         echo "hello";
    }
    public function generatetoptenringtonedetailReport($data){
      //  $temp1 = 'http://192.168.4.41:8081/IVRReport1/RingtoneDetail?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . '&group1=' . $data['group1'] .'';
          $temp1 = MIS_rintonedetail.'?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . '&group1=' . $data['group1'] .'';
      
        
        echo $temp1;
        echo"<iframe style='border:none' src=\"" . $temp1 . "\"width='900px' height=600>";
         
         echo "hello";
    
        
        
    }

    
      public function generatetoptencategoryReport($data) {
        //$contents = file_get_contents('http://192.168.4.41:8081/ReportGeneration/FillData');
        // echo "http://192.168.4.41:8081/ReportGeneration/FillData";
        //  print_r($contents);
           echo "hello";
        //return $contents;
    }
    
     public function generatetoptencategorytReport($data) {
//        $contents = file_get_contents('http://192.168.4.41:8081/ReportGeneration/FillData');
//        // echo "http://192.168.4.41:8081/ReportGeneration/FillData";
//        //  print_r($contents);
//
//        return $contents;
 //$temp = 'http://192.168.4.41:8081/IVRReport1/CategoryPlayTime?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate']  . '';
          
     $temp= MIS_categorytime.'?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . ''  ;          
         echo $temp;
           echo"<iframe style='border:none' src=\"" . $temp . "\"width='900px' height=600>";
             
        // echo "hello";
    }
      public function generatetoptencategorycReport($data) {
//        $contents = file_get_contents('http://192.168.4.41:8081/ReportGeneration/FillData');
//        // echo "http://192.168.4.41:8081/ReportGeneration/FillData";
//        //  print_r($contents);
//
//        return $contents;
         
         //echo "hello";
 //   $temp = 'http://192.168.4.41:8081/IVRReport1/CategoryPlayCount?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate']  . '';
          $temp= MIS_categorycount.'?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . ''  ;
          echo $temp;
           echo"<iframe style='border:none' src=\"" . $temp . "\"width='900px' height=600>";

          
          
          
    }
      public function generatetoptencategorysReport($data) {
//        $contents = file_get_contents('http://192.168.4.41:8081/ReportGeneration/FillData');
//        // echo "http://192.168.4.41:8081/ReportGeneration/FillData";
//        //  print_r($contents);
//
//        return $contents;
           // $temp = 'http://192.168.4.41:8081/IVRReport1/CategoryPlayedSong?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate']  . '';
          $temp= MIS_categorysong.'?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . ''  ;
          
          echo $temp;
           echo"<iframe style='border:none' src=\"" . $temp . "\"width='900px' height=600>";
         
        
    }
     public function generatetoptencategorysummaryReport($data) {
//        $contents = file_get_contents('http://192.168.4.41:8081/ReportGeneration/FillData');
//        // echo "http://192.168.4.41:8081/ReportGeneration/FillData";
//        //  print_r($contents);
//
//        return $contents;
//         
    //     $temp1 = 'http://192.168.4.41:8081/IVRReport1/CategorySummary?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . '&group1=' . $data['group1'] .'';
          $temp1 = MIS_categorysummary.'?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . '&group1=' . $data['group1'] .'';
         echo $temp1;
        echo"<iframe style='border:none' src=\"" . $temp1 . "\"width='900px' height=600>";
         
         echo "hello";
    }
    public function generatetoptencategorydetailReport($data){
       //   $temp1 = 'http://192.168.4.41:8081/IVRReport/MsisdnSummary?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . '';
//         echo $temp1;
//        echo"<iframe style='border:none' src=\"" . $temp1 . "\"width='900px' height=600>";
         
     //     $temp1 = 'http://192.168.4.41:8081/IVRReport1/CategoryDetailReport?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . '&group1=' . $data['group1'] .'';
       
         $temp1 = MIS_categorydetail.'?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . '&group1=' . $data['group1'] .'';
     
        echo $temp1;
        echo"<iframe style='border:none' src=\"" . $temp1 . "\"width='900px' height=600>"; 
        
        echo "hello";
    
        
        
    }
    
     public function generatetoptenshortcodeReport($data) {
        //$contents = file_get_contents('http://192.168.4.41:8081/ReportGeneration/FillData');
        // echo "http://192.168.4.41:8081/ReportGeneration/FillData";
        //  print_r($contents);
           echo "hello";
        //return $contents;
    }
    
     public function generatetoptenshortcodetReport($data) {
//        $contents = file_get_contents('http://192.168.4.41:8081/ReportGeneration/FillData');
//        // echo "http://192.168.4.41:8081/ReportGeneration/FillData";
//        //  print_r($contents);
//
//        return $contents;
         
       //  echo "hello";
        // $temp = 'http://192.168.4.41:8081/IVRReport1/ShortCodePlayTime?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate']  . '';
          
             $temp= MIS_shortcodetime.'?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . ''  ;
         echo $temp;
           echo"<iframe style='border:none' src=\"" . $temp . "\"width='900px' height=600>";
    }
      public function generatetoptenshortcodecReport($data) {
//        $contents = file_get_contents('http://192.168.4.41:8081/ReportGeneration/FillData');
//        // echo "http://192.168.4.41:8081/ReportGeneration/FillData";
//        //  print_r($contents);
//
//        return $contents;
         
       //  echo "hello";
 
          // $temp = 'http://192.168.4.41:8081/IVRReport1/ShortCodePlayCount?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate']  . '';
          
              $temp= MIS_shortcodecount.'?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . ''  ;
          echo $temp;
           echo"<iframe style='border:none' src=\"" . $temp . "\"width='900px' height=600>";
          
          }
      public function generatetoptenshortcodesReport($data) {
//        $contents = file_get_contents('http://192.168.4.41:8081/ReportGeneration/FillData');
//        // echo "http://192.168.4.41:8081/ReportGeneration/FillData";
//        //  print_r($contents);
//
//        return $contents;
         
       //  echo "hello";
          //  $temp = 'http://192.168.4.41:8081/IVRReport1/ShortCodePlayedSong?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate']  . '';
         
              $temp= MIS_shortcodesong.'?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . ''  ;
          echo $temp;
           echo"<iframe style='border:none' src=\"" . $temp . "\"width='900px' height=600>";
    }
     public function generatetoptenshortcodesummaryReport($data) {
//        $contents = file_get_contents('http://192.168.4.41:8081/ReportGeneration/FillData');
//        // echo "http://192.168.4.41:8081/ReportGeneration/FillData";
//        //  print_r($contents);
//
//        return $contents;
//         
      //   $temp1  = 'http://192.168.4.41:8081/IVRReport1/ShortCodeSummary?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . '&group1=' . $data['group1'] .'';
        $temp1  = MIS_shortcodesumm.'?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . '&group1=' . $data['group1'] .'';
         echo $temp1;
        echo"<iframe style='border:none' src=\"" . $temp1 . "\"width='900px' height=600>";
//         echo $temp1;
//        echo"<iframe style='border:none' src=\"" . $temp1 . "\"width='900px' height=600>";
         
         echo "hello";
    }
    public function generatetoptenshortcodedetailReport($data){
       //   $temp1 = 'http://192.168.4.41:8081/IVRReport1/ShortCodeDetailReport?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . '&group1=' . $data['group1'] .'';
       $temp1 = MIS_shortcodedetail.'?startdate=' . $data['startdate'] . '&enddate=' . $data['enddate'] . '&group1=' . $data['group1'] .'';
         
          echo $temp1;
        echo"<iframe style='border:none' src=\"" . $temp1 . "\"width='900px' height=600>";
         
         echo "hello";
    
        
        
    }

    public function generatechpassReport($data) {
        // $temp='http://192.168.4.41:8081/IVRReport/ChangePassword?username='.$_SESSION['name'].'&oldpassword='.$data['Opass'].'&newpassword='.$data['Npass'].'&changepassword='.$data['Cpass'].'';
      //  $contents = file_get_contents('http://192.168.4.41:8081/IVRReport/ChangePassword?username=' . $_SESSION['name'] . '&oldpassword=' . $data['Opass'] . '&newpassword=' . $data['Npass'] . '&changepassword=' . $data['Cpass'] . '');
      $temp=MIS_chpass.'?username=' . $_SESSION['name'] . '&oldpassword=' . $data['Opass'] . '&newpassword=' . $data['Npass'] . '&changepassword=' . $data['Cpass'] . '';
        //echo "http://192.168.4.41:8081/ReportGeneration/FillData";
        echo $temp;
         $contents = file_get_contents($temp);
        //   print_r($contents);
        //print_r($_REQUEST);
        return $contents;
    }

    public function generatecreateReport($data) {
        // $contents = file_get_contents('http://192.168.4.41:8081/ReportGeneration/FillData');
        //echo "http://192.168.4.41:8081/ReportGeneration/FillData";
        //   print_r($contents);
        //print_r($_REQUEST);
        // return $contents;}
    }

    public function generatecreaterReport($data) {
        //$contents = file_get_contents('http://192.168.4.41:8081/ReportGeneration/FillData');
          $contents = file_get_contents(MIS_msisdn);
        // echo "http://192.168.4.41:8081/ReportGeneration/FillData";
        //  print_r($contents);
        return $contents;
    }

    public function generatecreatenewuReport($data) {
      //  $contents = file_get_contents('http://192.168.4.41:8081/ReportGeneration/FillData');
       $contents = file_get_contents(MIS_msisdn);  
      //  $contents = file_get_contents(MIS_msisdn);
        // echo "http://192.168.4.41:8081/ReportGeneration/FillData";
        //  print_r($contents);

        return $contents;
    }

    public function generatecreatenewuserReport($data) {
        $str = "";
        $str2 = "";

        //print_r($data);
        $service = $data;
        //print_r($service);
        if (is_array($service)) {
            if (isset($service['circle'])) {

                foreach ($service['circle'] as $key => $one) { // $str="";
                    //print_r($one);
                    // echo $key;
                    foreach ($one as $oneone) {
                        //    echo $oneone;
                        $str = $str . $oneone . "008";
                        // $str=$key."#*".$oneone;
                        $str = urlencode($str);

                        // $str=$oneone.",".$key."#*";
                    }
                    $str = $str . "001" . $key . "007";
                    $str = urlencode($str);
                    // echo($str);
                }
            }
            //$str2=$str."*".$str2;
            //      echo $str;
            $temp = 'http://192.168.4.41:8081/IVRReport1/RegisterUser?name=' . urlencode($data['name']) . '&user=' . $data['use'] . '&mobilen=' . $data['mobiln'] . '&str=' . $str . '';
            // echo $temp;
            // exit();
           // $contents = file_get_contents('http://192.168.4.41:8081/IVRReport1/RegisterUser?name=' . urlencode($data['name']) . '&user=' . $data['use'] . '&mobilen=' . $data['mobiln'] . '&str=' . $str . '');
             $contents = file_get_contents(MIS_createnewuser.'?name=' . urlencode($data['name']) . '&user=' . $data['use'] . '&mobilen=' . $data['mobiln'] . '&str=' . $str . '');
            return($contents);

            // while (list ($key, $value) = each ($service)) {
            //  foreach($data['circle['.$value.']'] as $one)

              //{     $str=$str.$one.",";
            //  }$str=$value."#*".$str;
            //  $str = urlencode($str);
            //  print_r($str);exit();
            //  } 
        }
    }

    public function generateupdatenewuserReport($data) {
        $str = "";
        $str2 = "";


        $service = $data;
        //print_r($service);

        if (is_array($service)) {
            if (isset($service['circle'])) {
                foreach ($service['circle'] as $key => $one) { // $str="";
                    //print_r($one);
                    // echo $key;
                    foreach ($one as $oneone) {
                        //    echo $oneone;
                        $str = $str . $oneone . "008";
                        // $str=$key."#*".$oneone;
                        $str = urlencode($str);

                        // $str=$oneone.",".$key."#*";
                    }
                    $str = $str . "001" . $key . "007";
                    $str = urlencode($str);
                }
            }
           // $contents = file_get_contents('http://192.168.4.41:8081/IVRReport1/UpdateUser?name=' . $data['name'] . '&user=' . $data['use'] . '&mobilen=' . $data['mobiln'] . '&str=' . $str . '');
             $contents = file_get_contents(MIS_updateuser.'?name=' . $data['name'] . '&user=' . $data['use'] . '&mobilen=' . $data['mobiln'] . '&str=' . $str . '');
            return($contents);
        }
    }

    public function generateupdateuserReport($data) {
        //$contents = file_get_contents('http://192.168.4.41:8081/ReportGeneration/FillData');
          $contents = file_get_contents(MIS_msisdn);
        return $contents;
    }

    public function generateupdateReport($data) {
    }

    public function generateupdaterReport($data) {
       // $contents = file_get_contents('http://192.168.4.41:8081/ReportGeneration/FillData');
          $contents = file_get_contents(MIS_msisdn);
        return $contents;
    }

    public function generateloginReport($data) {
      //  $contents = file_get_contents('http://192.168.4.41:8081/IVRReport1/UserLogin?username=' . $data['signin'] . '&password=' . $data['password'] . '');
   $contents = file_get_contents(MIS_login.'?username=' . $data['signin'] . '&password=' . $data['password'] . '');
             
        
        return $contents;
    }
}
