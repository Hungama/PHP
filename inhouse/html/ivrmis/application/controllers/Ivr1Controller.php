<?php
/**
 * Class for Ivr1Controller controller
 *
 * This class is used for banner management
 *
 * @version 1.0
 * @project IVR-MIS
 */

class Ivr1Controller extends Zend_Controller_Action {
	
    /**
     * init function
     *
     * This function is the first function that gets called whenever this controller initiates
     *
     * @see
     * @return
     */
    public function init() {

        if (!isset($_SESSION['name'])) {
            $this->_redirect('user/login');
        }

        $this->params = $this->generateParams();
        $this->view->params = $this->generateParams();
    }
     /**
     * generatereport function
     *
     * This function is called to generate report the paramers array for data and operator
     *
     * @see
     * @return string
     */
	public function reportAction(){
		$mis = new Application_Model_Ivr1();
       	$resp = $mis->generatemsisdnReport();
		$data=explode('#-*',$resp);
		$resp=explode(',',$data['0']);
        $this->view->response = $resp;
		$stats= $mis->getReport();
		$this->view->statsreport=$stats; 
		$yesterday_date=date("m/d/Y", mktime(0, 0, 0, date("m"),date("d")-1,date("Y")));
		$this->view->startdate=$yesterday_date;
		$this->view->operator='Reliance';
		$this->_helper->layout()->setLayout('ivr1');
	}
	public function reportajaxAction(){
		//print_r($_SERVER);
		$mis = new Application_Model_Ivr1();
		$stats= $mis->getReportAjax($this->_getParam('startdate'),$this->_getParam('operator'));
		$this->view->startdate=$this->_getParam('startdate');
		$this->view->operator=$this->_getParam('operator');
		echo $this->view->statsreport=$stats; die;

	}
	public function reportintervalAction(){
                $mis = new Application_Model_Ivr1();
		$stats= $mis->getReportIntervalAjax($this->_getParam('hour'),$this->_getParam('startdate'),$this->_getParam('operator'));
		echo $this->view->statsreportinterval=$stats; die;
	}

//----------------------------------------------------------------------------------------------------------------------------------//
    public function vlcumAction() {
        //$mis=new Application_Model_Mis();

        if ($this->getRequest()->isPost()) {
            //$mis->generateviewReport($_POST);
        }
        $this->_helper->layout()->setLayout('ivr1');
    }

    public function msisdnAction() {
        $mis = new Application_Model_Ivr1();
        $resp = $mis->generatemsisdnReport($_POST);
        $this->view->response = $resp;
        $this->_helper->layout()->setLayout('ivr1');
    }
    
      public function serviceAction() {
        $mis = new Application_Model_Ivr1();
        //
        //
        //  if ($this->getRequest()->isPost()) 
        //{$this->view->output=$mis->generatemsisdn2Report($_POST);
        //  print_r($_POST);
        //  foreach($data['ListBox1'] as $str)
        // {      $str=$str.$data['ListBox1'].",";
        // }   echo $str; 
        //  }
        //  
        $resp = $mis->generateserviceReport($_POST);
        //
        //
        //
        //print_r($resp);
        //exit();
        $this->view->response = $resp;

        $this->_helper->layout()->setLayout('ivr1');
    }

    public function msisdnsAction() {
        $mis = new Application_Model_Ivr1();
        
      if ($this->getRequest()->isPost()) {
//          if(isset($data['ListBox1']) && ($data['ListBox2']))
//          {
            $this->view->ListBox2 = $_POST['ListBox2'];
            //$this->view->ListBox2 = $_POST['ListBox2'];
            $this->view->startdate = $_POST['startdate'];
            $this->view->enddate = $_POST['enddate'];
            $this->view->output = $mis->generatemsisdnsReport($_POST);
            //$this->view->data=$_POST;
            // print_r($_POST);
            //  foreach($data['ListBox1'] as $str)
            // {      $str=$str.$data['ListBox1'].",";
            // }   echo $str; 
       // }
        
//        else{
//             $resp = $mis->generatemsisdnReport($_POST);
//              $this->view->response = $resp;
//              $_SESSION['notselected']='not';
//          if($_SESSION['notselected']=='not');
//        {
//             $this->view->output = $mis->generatemsisdnsReport($_POST);
//        }
//              
//        }    }
            
        // $resp= $mis->generatemsisdnReport($_POST);
        //print_r($resp);
        // exit();
        //    $this->view->response=$resp;
    
      }
        $this->_helper->layout()->setLayout('ivr1');
    }
    
    
    
      public function msisdnduAction() {
        $mis = new Application_Model_Ivr1();
        
      if ($this->getRequest()->isPost()) {
//          if(isset($data['ListBox1']) && ($data['ListBox2']))
//          {
            $this->view->ListBox2 = $_POST['ListBox2'];
            //$this->view->ListBox2 = $_POST['ListBox2'];
            $this->view->startdate = $_POST['startdate'];
            $this->view->enddate = $_POST['enddate'];
            $this->view->output = $mis->generatemsisdnduReport($_POST);
            //$this->view->data=$_POST;
            // print_r($_POST);
            //  foreach($data['ListBox1'] as $str)
            // {      $str=$str.$data['ListBox1'].",";
            // }   echo $str; 
       // }
        
//        else{
//             $resp = $mis->generatemsisdnReport($_POST);
//              $this->view->response = $resp;
//              $_SESSION['notselected']='not';
//          if($_SESSION['notselected']=='not');
//        {
//             $this->view->output = $mis->generatemsisdnsReport($_POST);
//        }
//              
//        }    }
            
        // $resp= $mis->generatemsisdnReport($_POST);
        //print_r($resp);
        // exit();
        //    $this->view->response=$resp;
    
      }
        $this->_helper->layout()->setLayout('ivr1');
    }
    
      public function msisdnpAction() {
        $mis = new Application_Model_Ivr1();
        
      if ($this->getRequest()->isPost()) {
//          if(isset($data['ListBox1']) && ($data['ListBox2']))
//          {
            $this->view->ListBox2 = $_POST['ListBox2'];
            //$this->view->ListBox2 = $_POST['ListBox2'];
            $this->view->startdate = $_POST['startdate'];
            $this->view->enddate = $_POST['enddate'];
            $this->view->output = $mis->generatemsisdnpReport($_POST);
            //$this->view->data=$_POST;
            // print_r($_POST);
            //  foreach($data['ListBox1'] as $str)
            // {      $str=$str.$data['ListBox1'].",";
            // }   echo $str; 
       // }
        
//        else{
//             $resp = $mis->generatemsisdnReport($_POST);
//              $this->view->response = $resp;
//              $_SESSION['notselected']='not';
//          if($_SESSION['notselected']=='not');
//        {
//             $this->view->output = $mis->generatemsisdnsReport($_POST);
//        }
//              
//        }    }
            
        // $resp= $mis->generatemsisdnReport($_POST);
        //print_r($resp);
        // exit();
        //    $this->view->response=$resp;
    
      }
        $this->_helper->layout()->setLayout('ivr1');
    }

    public function servicesAction() {
        $mis = new Application_Model_Ivr1();
        
      if ($this->getRequest()->isPost()) {
//          if(isset($data['ListBox1']) && ($data['ListBox2']))
//          {
            $this->view->ListBox1 = $_POST['ListBox1'];
            //$this->view->ListBox2 = $_POST['ListBox2'];
            $this->view->startdate = $_POST['startdate'];
            $this->view->enddate = $_POST['enddate'];
            $this->view->output = $mis->generateservicesReport($_POST);
            //$this->view->data=$_POST;
            // print_r($_POST);
            //  foreach($data['ListBox1'] as $str)
            // {      $str=$str.$data['ListBox1'].",";
            // }   echo $str; 
       // }
        
//        else{
//             $resp = $mis->generatemsisdnReport($_POST);
//              $this->view->response = $resp;
//              $_SESSION['notselected']='not';
//          if($_SESSION['notselected']=='not');
//        {
//             $this->view->output = $mis->generatemsisdnsReport($_POST);
//        }
//              
//        }    }
            
        // $resp= $mis->generatemsisdnReport($_POST);
        //print_r($resp);
        // exit();
        //    $this->view->response=$resp;
    
      }
        $this->_helper->layout()->setLayout('ivr1');
    }
     public function servicepAction() {
        $mis = new Application_Model_Ivr1();
        
      if ($this->getRequest()->isPost()) {
//          if(isset($data['ListBox1']) && ($data['ListBox2']))
//          {
            $this->view->ListBox1 = $_POST['ListBox1'];
            //$this->view->ListBox2 = $_POST['ListBox2'];
            $this->view->startdate = $_POST['startdate'];
            $this->view->enddate = $_POST['enddate'];
            $this->view->output = $mis->generateservicepReport($_POST);
            //$this->view->data=$_POST;
            // print_r($_POST);
            //  foreach($data['ListBox1'] as $str)
            // {      $str=$str.$data['ListBox1'].",";
            // }   echo $str; 
       // }
        
//        else{
//             $resp = $mis->generatemsisdnReport($_POST);
//              $this->view->response = $resp;
//              $_SESSION['notselected']='not';
//          if($_SESSION['notselected']=='not');
//        {
//             $this->view->output = $mis->generatemsisdnsReport($_POST);
//        }
//              
//        }    }
            
        // $resp= $mis->generatemsisdnReport($_POST);
        //print_r($resp);
        // exit();
        //    $this->view->response=$resp;
    
      }
        $this->_helper->layout()->setLayout('ivr1');
    }
     public function serviceduAction() {
        $mis = new Application_Model_Ivr1();
        
      if ($this->getRequest()->isPost()) {
//          if(isset($data['ListBox1']) && ($data['ListBox2']))
//          {
            $this->view->ListBox1 = $_POST['ListBox1'];
            //$this->view->ListBox2 = $_POST['ListBox2'];
            $this->view->startdate = $_POST['startdate'];
            $this->view->enddate = $_POST['enddate'];
            $this->view->output = $mis->generateserviceduReport($_POST);
            //$this->view->data=$_POST;
            // print_r($_POST);
            //  foreach($data['ListBox1'] as $str)
            // {      $str=$str.$data['ListBox1'].",";
            // }   echo $str; 
       // }
        
//        else{
//             $resp = $mis->generatemsisdnReport($_POST);
//              $this->view->response = $resp;
//              $_SESSION['notselected']='not';
//          if($_SESSION['notselected']=='not');
//        {
//             $this->view->output = $mis->generatemsisdnsReport($_POST);
//        }
//              
//        }    }
            
        // $resp= $mis->generatemsisdnReport($_POST);
        //print_r($resp);
        // exit();
        //    $this->view->response=$resp;
    
      }
        $this->_helper->layout()->setLayout('ivr1');
    }
    
     public function msisdnchartAction() {
        $mis = new Application_Model_Ivr1();

        if ($this->getRequest()->isPost()) {
          //if(isset($data['ListBox1']) && ($data['ListBox2']))
         //{   
             $this->view->ListBox2 = $_POST['ListBox2'];
            //$this->view->ListBox2 = $_POST['ListBox2'];
            $this->view->startdate = $_POST['startdate'];
            $this->view->enddate = $_POST['enddate'];
        
            $this->view->output = $mis->generatemsisdnchartReport($_POST);
            // print_r($_POST);
            //  foreach($data['ListBox1'] as $str)
            // {      $str=$str.$data['ListBox1'].",";
            // }   echo $str; 
        }
        //   $resp= $mis->generatemsisdnReport($_POST);
        //print_r($resp);
        // exit();
        // $this->view->response=$resp;
//            else{
//             $resp = $mis->generatemsisdnReport($_POST);
//              $this->view->response = $resp;
//              $_SESSION['notselected']='not';
//          if($_SESSION['notselected']=='not');
//        {
//             $this->view->output = $mis->generatemsisdnchartReport($_POST);
//        }
//              
//        }  }

        $this->_helper->layout()->setLayout('ivr1');
    }
    
      public function servicechartAction() {
        $mis = new Application_Model_Ivr1();

        if ($this->getRequest()->isPost()) {
          //if(isset($data['ListBox1']) && ($data['ListBox2']))
         //{   
               $this->view->ListBox1 = $_POST['ListBox1'];
            //$this->view->ListBox2 = $_POST['ListBox2'];
            $this->view->startdate = $_POST['startdate'];
            $this->view->enddate = $_POST['enddate'];

            $this->view->output = $mis->generateservicechartReport($_POST);
            // print_r($_POST);
            //  foreach($data['ListBox1'] as $str)
            // {      $str=$str.$data['ListBox1'].",";
            // }   echo $str; 
        }
        //   $resp= $mis->generatemsisdnReport($_POST);
        //print_r($resp);
        // exit();
        // $this->view->response=$resp;
//            else{
//             $resp = $mis->generatemsisdnReport($_POST);
//              $this->view->response = $resp;
//              $_SESSION['notselected']='not';
//          if($_SESSION['notselected']=='not');
//        {
//             $this->view->output = $mis->generatemsisdnchartReport($_POST);
//        }
//              
//        }  }

        $this->_helper->layout()->setLayout('ivr1');
    }
    
     public function servicedAction() {
        $mis = new Application_Model_Ivr1();

        if ($this->getRequest()->isPost()) {
//          if(isset($data['ListBox1']) && ($data['ListBox2']))
//          {
     
          //if(isset($data['ListBox1']) && ($data['ListBox2']))
         //{   
               $this->view->ListBox1 = $_POST['ListBox1'];
            //$this->view->ListBox2 = $_POST['ListBox2'];
            $this->view->startdate = $_POST['startdate'];
            $this->view->enddate = $_POST['enddate'];

            $this->view->output = $mis->generateservicedReport($_POST);}
        //   $resp= $mis->generatemsisdnReport($_POST);
        //print_r($resp);
        // exit();
        // $this->view->response=$resp;
          

        $this->_helper->layout()->setLayout('ivr1');
    }

    public function msisdndAction() {
        $mis = new Application_Model_Ivr1();

        if ($this->getRequest()->isPost()) {
//          if(isset($data['ListBox1']) && ($data['ListBox2']))
//          {
     
          //if(isset($data['ListBox1']) && ($data['ListBox2']))
         //{   $this->view->ListBox2 = $_POST['ListBox2'];
            //$this->view->ListBox2 = $_POST['ListBox2'];
            
              $this->view->ListBox2 = $_POST['ListBox2'];
            $this->view->startdate = $_POST['startdate'];
            $this->view->enddate = $_POST['enddate']; 
            

            $this->view->output = $mis->generatemsisdndReport($_POST);}
        //   $resp= $mis->generatemsisdnReport($_POST);
        //print_r($resp);
        // exit();
        // $this->view->response=$resp;
          

        $this->_helper->layout()->setLayout('ivr1');
    }
//     public function msisdndchartAction() {
//        $mis = new Application_Model_Ivr1();
//
//        if ($this->getRequest()->isPost()) {
//          //if(isset($data['ListBox1']) && ($data['ListBox2']))
//         //{   
//            
//
//            $this->view->output = $mis->generatemsisdndchartReport($_POST);
//            // print_r($_POST);
//            //  foreach($data['ListBox1'] as $str)
//            // {      $str=$str.$data['ListBox1'].",";
//            // }   echo $str; 
//        }
//        //   $resp= $mis->generatemsisdnReport($_POST);
//        //print_r($resp);
//        // exit();
//        // $this->view->response=$resp;
////            else{
////             $resp = $mis->generatemsisdnReport($_POST);
////              $this->view->response = $resp;
////              $_SESSION['notselected']='not';
////          if($_SESSION['notselected']=='not');
////        {
////             $this->view->output = $mis->generatemsisdnchartReport($_POST);
////        }
////              
////        }  }
//
//        $this->_helper->layout()->setLayout('ivr1');
//    }

    public function shortAction() {
        $mis = new Application_Model_Ivr1();

        // if ($this->getRequest()->isPost()) 
        //   {$this->view->output=$mis->generateshortReport($_POST);
        //   print_r($_POST);
        //$mis->generateviewReport($_POST);
        //   }
        $resp = $mis->generateshortReport($_POST);
        $this->view->response = $resp;
        $this->_helper->layout()->setLayout('ivr1');
    }

    public function shortsAction() {
        $mis = new Application_Model_Ivr1();
//          print_r($data[$startdate]);
//      print_r($data[$ListBox1]);
//        
//           print_r($this->_request->getParams());
//           exit();

        if ($this->getRequest()->isPost()) {
                 if(isset($data['ListBox1']) && ($data['ListBox2']) && ($data['ListBox3']) && ($data['ListBox4']))
          {
            $this->view->output = $mis->generateshortsReport($_POST);
            //  print_r($_POST);
            //$mis->generateviewReport($_POST);
          }
          
           else{
             $resp = $mis->generateshortReport($_POST);
              $this->view->response = $resp;
              $_SESSION['notselected']='not';
          if($_SESSION['notselected']=='not');
        {
             $this->view->output = $mis->generateshortsReport($_POST);
        }
              
        }  
        }
        // $resp= $mis->generateshort1Report($_POST);
        // $this->view->response=$resp;
        $this->_helper->layout()->setLayout('ivr1');
    }

    public function shortdAction() {
        $mis = new Application_Model_Ivr1();

        if ($this->getRequest()->isPost()) 
             {
                 if(isset($data['ListBox1']) && ($data['ListBox2']) && ($data['ListBox3']) && ($data['ListBox4']))
          {
            $this->view->output = $mis->generateshortdReport($_POST);
            //  print_r($_POST);
            //$mis->generateviewReport($_POST);
          }
          
            else{
             $resp = $mis->generateshortReport($_POST);
              $this->view->response = $resp;
              $_SESSION['notselected']='not';
          if($_SESSION['notselected']=='not');
        {
             $this->view->output = $mis->generateshortdReport($_POST);
        }
              
        } 
             }
          
            //  print_r($_POST);
            //$mis->generateviewReport($_POST);
        
        // $resp= $mis->generateshort1Report($_POST);
        // $this->view->response=$resp;
        $this->_helper->layout()->setLayout('ivr1');
    }

    public function timeAction() {
        $mis = new Application_Model_Ivr1();

        //  if ($this->getRequest()->isPost()) 
        //      {$this->view->output=$mis->generatetimeReport($_POST);
        //  print_r($_POST);
        //$mis->generateviewReport($_POST);
        // }
        $resp = $mis->generatetimeReport($_POST);
        $this->view->response = $resp;
        $this->_helper->layout()->setLayout('ivr1');
    }
    
      public function timecAction() {
        $mis = new Application_Model_Ivr1();

          if ($this->getRequest()->isPost()){ 
        //      {$this->view->output=$mis->generatetimeReport($_POST);
        //  print_r($_POST);
        //$mis->generateviewReport($_POST);
        // }
          $this->view->ListBox1 = $_POST['ListBox1'];
          $this->view->ListBox2 = $_POST['ListBox2'];
          $this->view->ListBox3 = $_POST['ListBox3'];
          $this->view->ListBox4 = $_POST['ListBox4'];
            $this->view->startdate = $_POST['startdate'];
            $this->view->enddate = $_POST['enddate'];
        $resp = $mis->generatetimecReport($_POST);
        $this->view->response = $resp;}
        $this->_helper->layout()->setLayout('ivr1');
    }
    
      public function timepAction() {
        $mis = new Application_Model_Ivr1();

          if ($this->getRequest()->isPost()){ 
        //      {$this->view->output=$mis->generatetimeReport($_POST);
        //  print_r($_POST);
        //$mis->generateviewReport($_POST);
        // }
          $this->view->ListBox1 = $_POST['ListBox1'];
          $this->view->ListBox2 = $_POST['ListBox2'];
          $this->view->ListBox3 = $_POST['ListBox3'];
          $this->view->ListBox4 = $_POST['ListBox4'];
            $this->view->startdate = $_POST['startdate'];
            $this->view->enddate = $_POST['enddate'];
        $resp = $mis->generatetimepReport($_POST);
        $this->view->response = $resp;}
        $this->_helper->layout()->setLayout('ivr1');
    }
    
     public function timeduAction() {
        $mis = new Application_Model_Ivr1();

          if ($this->getRequest()->isPost()){ 
        //      {$this->view->output=$mis->generatetimeReport($_POST);
        //  print_r($_POST);
        //$mis->generateviewReport($_POST);
        // }
          $this->view->ListBox1 = $_POST['ListBox1'];
          $this->view->ListBox2 = $_POST['ListBox2'];
          $this->view->ListBox3 = $_POST['ListBox3'];
          $this->view->ListBox4 = $_POST['ListBox4'];
            $this->view->startdate = $_POST['startdate'];
            $this->view->enddate = $_POST['enddate'];
        $resp = $mis->generatetimeduReport($_POST);
        $this->view->response = $resp;}
        $this->_helper->layout()->setLayout('ivr1');
    }
    
    

    public function timesAction() {
        $mis = new Application_Model_Ivr1();

        if ($this->getRequest()->isPost()) {
            //print_r($_POST);exit();
              $this->view->ListBox1 = $_POST['ListBox1'];
            $this->view->ListBox2 = $_POST['ListBox2'];
              $this->view->ListBox3 = $_POST['ListBox3'];
            $this->view->ListBox4 = $_POST['ListBox4'];
            $this->view->startdate = $_POST['startdate'];
            $this->view->enddate = $_POST['enddate'];
            
                 if(isset($data['ListBox1']) && ($data['ListBox2']) && ($data['ListBox3']) && ($data['ListBox4']))
          {
            $this->view->output = $mis->generatetimesReport($_POST);
            //  print_r($_POST);
            //$mis->generateviewReport($_POST);
        }
        else{
             $resp = $mis->generatetimeReport($_POST);
              $this->view->response = $resp;
              $_SESSION['notselected']='not';
          if($_SESSION['notselected']=='not');
        {
             $this->view->output = $mis->generatetimesReport($_POST);
        }
              
        }  
             } // $resp= $mis->generatetime1Report($_POST);
        //  $this->view->response=$resp;
        $this->_helper->layout()->setLayout('ivr1');
    }
     public function timechartAction() {
        $mis = new Application_Model_Ivr1();
        //echo "hello";//print_r($data[$ListBox1]);
       //print_r($data[$startdate]);
      //print_r($data[$ListBox1]);
      //$response=$this->_request->getParams();
     // print_r($response['ListBox1']);
       // print_r($this->_request->getParams());
      //print_r($data[$startdate]);
      //print_r($data[$ListBox1]);
        //print_r($_POST);
         if ($this->getRequest()->isPost()) {
//        print_r(explode("#",$_POST[ListBox1]));
//        print_r(explode("#",$_POST[ListBox2]));
//        print_r(explode("#",$_POST[ListBox3]));
//        print_r(explode("#",$_POST[ListBox4]));
//      $ListBox1=(explode("#",$_POST[ListBox1]));
//       $ListBox2=(explode("#",$_POST[ListBox2]));
//        $ListBox3=(explode("#",$_POST[ListBox3]));
//         $ListBox4=(explode("#",$_POST[ListBox4]));

       
            
               //  if(isset($data['ListBox1']) && ($data['ListBox2']) && ($data['ListBox3']) && ($data['ListBox4']))
          //{
            $this->view->output = $mis->generatetimechartReport($_POST);
            //  print_r($_POST);
            //$mis->generateviewReport($_POST);
        //}
        //else{
//             $resp = $mis->generatetimeReport($_POST);
//              $this->view->response = $resp;
//              $_SESSION['notselected']='not';
//          if($_SESSION['notselected']=='not');
//        {
//             $this->view->output = $mis->generatetimechartReport($_POST);
//        }
//              
//        }  
             } // $resp= $mis->generatetime1Report($_POST);
        //  $this->view->response=$resp;
        $this->_helper->layout()->setLayout('ivr1');
    }

    public function timedAction() {
        $mis = new Application_Model_Ivr1();

        if ($this->getRequest()->isPost()) {
            
               if(isset($data['ListBox1']) && ($data['ListBox2']) && ($data['ListBox3']) && ($data['ListBox4']))
          {
            $this->view->output = $mis->generatetimedReport($_POST);
            //  print_r($_POST);
            //$mis->generateviewReport($_POST);
        }
          else{
             $resp = $mis->generatetimeReport($_POST);
              $this->view->response = $resp;
              $_SESSION['notselected']='not';
          if($_SESSION['notselected']=='not');
        {
             $this->view->output = $mis->generatetimedReport($_POST);
        }
              
        } 
        }
        // $resp= $mis->generatetime1Report($_POST);
        //  $this->view->response=$resp;
        $this->_helper->layout()->setLayout('ivr1');
    }

    public function chpassAction() {
        $mis = new Application_Model_Ivr1();
//
        if ($this->getRequest()->isPost()) {
                    if($_SESSION['role'] == 'admin')
 {
     if($_SESSION['pass']!= $_POST['Opass'])
          $this->_redirect('ivr1/chpass/errorMessage/Sorry! Old Password does not matches');
        //  $this->view->errorMessage = "Sorry! Old Password is not same as your original password";
 }else
     if($_SESSION['role'] == 'user')
     {
         if($_SESSION['pass']!=$_POST['Opass'])
        $this->_redirect('ivr1/chpass/errorMessage/Sorry! Old Password is not same as your original password');
     }
//             echo $_SESSION['pass'];
//               echo $_POST['Opass'];exit();
            $output = $mis->generatechpassReport($_POST);
            //echo '-'.$output.'-';exit();
            $this->view->output = trim($output);
            if (trim($output) == "success") {
                $this->_redirect('ivr1/chpass/successMessage/Password has been succesfully reset');
               
        
            }
        }
        $this->_helper->layout()->setLayout('ivr1');
    }

    public function createrAction() {
        $mis = new Application_Model_Ivr1();
        $resp = $mis->generatecreaterReport($_POST);
        $this->view->response = $resp;
        $this->_helper->layout()->setLayout('ivr1');
    }

    public function createnewuAction() {
        $mis = new Application_Model_Ivr1();
        // if ($this->getRequest()->isPost()) {
   //     print_r($_POST);
        
        $resp = $mis->generatecreatenewuReport($_POST);
        $this->view->response = $resp;
        $this->_helper->layout()->setLayout('ivr1');
        $option = explode("#-*", $resp);
        //$option2=explode(",",$option[1]);

        $option1 = explode(",", $option[0]);
        $this->view->option1 = $option1;
        $this->view->name = $_POST['namee'];
         $this->view->ListBox2 = $_POST['ListBox2'];
        //print_r($_POST);exit();
        $this->view->user = $_POST['user'];
        $this->view->mobilen = $_POST['mobilen'];
        $this->_helper->layout()->setLayout('ivr1');
    }

    public function createnewuserAction() {
        $mis = new Application_Model_Ivr1();
        if ($this->getRequest()->isPost()) {
            //     print_r($_POST);exit();
            $resp = trim($mis->generatecreatenewuserReport($_POST));
           // print_r($resp);
    
            if ($resp == 1) {
              // alert("User has been succesfully created");
                     $this->_redirect('ivr1/creater/successMessage/User successfully created');
                     return true;
            }
             else {
              //  $this->view->errorMessage = "User already exist";
            $this->_redirect('ivr1/creater/errorMessage/User already exist');
            }
        }
    }

    public function updateuserAction() {
        $mis = new Application_Model_Ivr1();
        if ($this->getRequest()->isPost()) {
            $resp = $mis->generateupdateuserReport($_POST);
            $this->view->response = $resp;
            $this->_helper->layout()->setLayout('ivr1');
            $option = explode("#-*", $resp);
            //$option2=explode(",",$option[1]);

            $option1 = explode(",", $option[0]);
            $this->view->option1 = $option1;
             $this->view->name = $_POST['id'];
         $this->view->ListBox2 = $_POST['ListBox2'];
        //print_r($_POST);exit();
        $this->view->user = $_POST['username'];
        $this->view->mobilen = $_POST['Usermobile'];
       // $this->_helper->layout()->setLayout('ivr1');
        }
        $this->_helper->layout()->setLayout('ivr1');
    }
    
     public function updatenewuserAction() {
        $mis = new Application_Model_Ivr1();
        if ($this->getRequest()->isPost()) {
            //     print_r($_POST);exit();
            $resp = $mis->generateupdatenewuserReport($_POST);
                if ($resp == 1) {
              // alert("User has been succesfully created");
                     $this->_redirect('ivr1/updater/successMessage/Information is successfully updated');
                     return true;
            }
             else {
              //  $this->view->errorMessage = "User already exist";
            $this->_redirect('ivr1/updater/errorMessage/Sorry!Information is not updated');
            }
        }
    }

    public function updaterAction() {
        $mis = new Application_Model_Ivr1();
        $resp = $mis->generateupdaterReport($_POST);
        $this->view->response = $resp;
        $this->_helper->layout()->setLayout('ivr1');
    }

    public function createAction() {
        $mis = new Application_Model_Ivr1();
        // print_r($_POST);exit();

        if ($this->getRequest()->isPost()) {
            $this->view->output = $mis->generatecreateReport($_POST);
        }
        $this->_helper->layout()->setLayout('ivr1');
    }

    public function updateAction() {
        $mis = new Application_Model_Ivr1();
        // print_r($_POST);exit();

        if ($this->getRequest()->isPost()) {
            $this->view->output = $mis->generateupdateReport($_POST);
        }
        $this->_helper->layout()->setLayout('ivr1');
    }
    
    public function toptenalbumAction() {
        $mis = new Application_Model_Ivr1();

         if ($this->getRequest()->isPost()) {
        //   {$this->view->output=$mis->generateshortReport($_POST);
        //   print_r($_POST);
        //$mis->generateviewReport($_POST);
        //   }
        $resp = $mis->generatetoptenalbumReport($_POST);
        $this->view->response = $resp;}
        $this->_helper->layout()->setLayout('ivr1');
    }
    
     public function toptenalbumnametAction() {
        $mis = new Application_Model_Ivr1();

         if ($this->getRequest()->isPost()) {
        //   {$this->view->output=$mis->generateshortReport($_POST);
        //   print_r($_POST);
        //$mis->generateviewReport($_POST);
        //   }
        $resp = $mis->generatetoptenalbumnametReport($_POST);
        $this->view->response = $resp;
         $this->view->startdate = $_POST['startdate'];
            $this->view->enddate = $_POST['enddate'];
        }
        $this->_helper->layout()->setLayout('ivr1');
    }
      public function toptenalbumnamecAction() {
        $mis = new Application_Model_Ivr1();

         if ($this->getRequest()->isPost()) {
        //   {$this->view->output=$mis->generateshortReport($_POST);
        //   print_r($_POST);
        //$mis->generateviewReport($_POST);
        //   }
        $resp = $mis->generatetoptenalbumnamecReport($_POST);
        $this->view->response = $resp;
         $this->view->startdate = $_POST['startdate'];
            $this->view->enddate = $_POST['enddate'];
        }
        $this->_helper->layout()->setLayout('ivr1');
    }
    
     public function toptenalbumnamesAction() {
        $mis = new Application_Model_Ivr1();

         if ($this->getRequest()->isPost()) {
        //   {$this->view->output=$mis->generateshortReport($_POST);
        //   print_r($_POST);
        //$mis->generateviewReport($_POST);
        //   }
        $resp = $mis->generatetoptenalbumnamesReport($_POST);
        $this->view->response = $resp;
         $this->view->startdate = $_POST['startdate'];
            $this->view->enddate = $_POST['enddate'];
        }
        $this->_helper->layout()->setLayout('ivr1');
    }
    
     public function toptenalbsummaryAction() {
        $mis = new Application_Model_Ivr1();

        if ($this->getRequest()->isPost()) {
            
              $this->view->startdate = $_POST['startdate'];
            $this->view->enddate = $_POST['enddate'];
          $this->view->output = $mis->generatetoptenalbsummaryReport($_POST);}
            $this->_helper->layout()->setLayout('ivr1');
    }
public function toptenalbdetailAction()
{
     $mis = new Application_Model_Ivr1();

        if ($this->getRequest()->isPost()) {
            
              $this->view->startdate = $_POST['startdate'];
            $this->view->enddate = $_POST['enddate'];
          $this->view->output = $mis->generatetoptenalbdetailReport($_POST);}
            $this->_helper->layout()->setLayout('ivr1');
    
}


//         public function toptencategAction() {
//        $mis = new Application_Model_Ivr1();
//
//         if ($this->getRequest()->isPost()) {
//        //   {$this->view->output=$mis->generateshortReport($_POST);
//        //   print_r($_POST);
//        //$mis->generateviewReport($_POST);
//        //   }
//        $resp = $mis->generatetoptencategReport($_POST);
//        $this->view->response = $resp;}
//        $this->_helper->layout()->setLayout('ivr1');
//    }
//    
//     public function toptencategtAction() {
//        $mis = new Application_Model_Ivr1();
//
//         if ($this->getRequest()->isPost()) {
//        //   {$this->view->output=$mis->generateshortReport($_POST);
//        //   print_r($_POST);
//        //$mis->generateviewReport($_POST);
//        //   }
//        $resp = $mis->generatetoptenalbumnametReport($_POST);
//        $this->view->response = $resp;
//         $this->view->startdate = $_POST['startdate'];
//            $this->view->enddate = $_POST['enddate'];
//        }
//        $this->_helper->layout()->setLayout('ivr1');
//    }
//      public function toptenalbumnamecAction() {
//        $mis = new Application_Model_Ivr1();
//
//         if ($this->getRequest()->isPost()) {
//        //   {$this->view->output=$mis->generateshortReport($_POST);
//        //   print_r($_POST);
//        //$mis->generateviewReport($_POST);
//        //   }
//        $resp = $mis->generatetoptenalbumnamecReport($_POST);
//        $this->view->response = $resp;
//         $this->view->startdate = $_POST['startdate'];
//            $this->view->enddate = $_POST['enddate'];
//        }
//        $this->_helper->layout()->setLayout('ivr1');
//    }
//    
//     public function toptenalbumnamesAction() {
//        $mis = new Application_Model_Ivr1();
//
//         if ($this->getRequest()->isPost()) {
//        //   {$this->view->output=$mis->generateshortReport($_POST);
//        //   print_r($_POST);
//        //$mis->generateviewReport($_POST);
//        //   }
//        $resp = $mis->generatetoptenalbumnamesReport($_POST);
//        $this->view->response = $resp;
//         $this->view->startdate = $_POST['startdate'];
//            $this->view->enddate = $_POST['enddate'];
//        }
//        $this->_helper->layout()->setLayout('ivr1');
//    }
//    
//     public function toptenalbsummaryAction() {
//        $mis = new Application_Model_Ivr1();
//
//        if ($this->getRequest()->isPost()) {
//          $this->view->output = $mis->generatetoptenalbsummaryReport($_POST);}
//            $this->_helper->layout()->setLayout('ivr1');
//    }
//public function toptenalbdetailAction()
//{
//     $mis = new Application_Model_Ivr1();
//
//        if ($this->getRequest()->isPost()) {
//          $this->view->output = $mis->generatetoptenalbdetailReport($_POST);}
//            $this->_helper->layout()->setLayout('ivr1');
//    
//}

    public function toptenringtoneAction() {
        $mis = new Application_Model_Ivr1();

         if ($this->getRequest()->isPost()) {
        //   {$this->view->output=$mis->generateshortReport($_POST);
        //   print_r($_POST);
        //$mis->generateviewReport($_POST);
        //   }
        $resp = $mis->generatetoptenringtoneReport($_POST);
        $this->view->response = $resp;}
        $this->_helper->layout()->setLayout('ivr1');
    }
    
     public function toptenringtonetAction() {
        $mis = new Application_Model_Ivr1();

         if ($this->getRequest()->isPost()) {
        //   {$this->view->output=$mis->generateshortReport($_POST);
        //   print_r($_POST);
        //$mis->generateviewReport($_POST);
        //   }
        $resp = $mis->generatetoptenringtonetReport($_POST);
        $this->view->response = $resp;
         $this->view->startdate = $_POST['startdate'];
            $this->view->enddate = $_POST['enddate'];
        }
        $this->_helper->layout()->setLayout('ivr1');
    }
      public function toptenringtonecAction() {
        $mis = new Application_Model_Ivr1();

         if ($this->getRequest()->isPost()) {
        //   {$this->view->output=$mis->generateshortReport($_POST);
        //   print_r($_POST);
        //$mis->generateviewReport($_POST);
        //   }
        $resp = $mis->generatetoptenringtonecReport($_POST);
        $this->view->response = $resp;
         $this->view->startdate = $_POST['startdate'];
            $this->view->enddate = $_POST['enddate'];
        }
        $this->_helper->layout()->setLayout('ivr1');
    }
    
     public function toptenringtonesAction() {
        $mis = new Application_Model_Ivr1();

         if ($this->getRequest()->isPost()) {
        //   {$this->view->output=$mis->generateshortReport($_POST);
        //   print_r($_POST);
        //$mis->generateviewReport($_POST);
        //   }
        $resp = $mis->generatetoptenringtonesReport($_POST);
        $this->view->response = $resp;
         $this->view->startdate = $_POST['startdate'];
            $this->view->enddate = $_POST['enddate'];
        }
        $this->_helper->layout()->setLayout('ivr1');
    }
    
     public function toptenringtonesummaryAction() {
        $mis = new Application_Model_Ivr1();

        if ($this->getRequest()->isPost()) {
              $this->view->startdate = $_POST['startdate'];
            $this->view->enddate = $_POST['enddate'];
          $this->view->output = $mis->generatetoptenringtonesummaryReport($_POST);}
            $this->_helper->layout()->setLayout('ivr1');
    }
public function toptenringtonedetailAction()
{
     $mis = new Application_Model_Ivr1();

        if ($this->getRequest()->isPost()) {
              $this->view->startdate = $_POST['startdate'];
            $this->view->enddate = $_POST['enddate'];
          $this->view->output = $mis->generatetoptenringtonedetailReport($_POST);}
            $this->_helper->layout()->setLayout('ivr1');
    
}

public function toptencategoryAction() {
        $mis = new Application_Model_Ivr1();

         if ($this->getRequest()->isPost()) {
        //   {$this->view->output=$mis->generateshortReport($_POST);
        //   print_r($_POST);
        //$mis->generateviewReport($_POST);
        //   }
        $resp = $mis->generatetoptencategoryReport($_POST);
        $this->view->response = $resp;}
        $this->_helper->layout()->setLayout('ivr1');
    }
    
     public function toptencategorytAction() {
        $mis = new Application_Model_Ivr1();

         if ($this->getRequest()->isPost()) {
        //   {$this->view->output=$mis->generateshortReport($_POST);
        //   print_r($_POST);
        //$mis->generateviewReport($_POST);
        //   }
        $resp = $mis->generatetoptencategorytReport($_POST);
        $this->view->response = $resp;
         $this->view->startdate = $_POST['startdate'];
            $this->view->enddate = $_POST['enddate'];
        }
        $this->_helper->layout()->setLayout('ivr1');
    }
      public function toptencategorycAction() {
        $mis = new Application_Model_Ivr1();

         if ($this->getRequest()->isPost()) {
        //   {$this->view->output=$mis->generateshortReport($_POST);
        //   print_r($_POST);
        //$mis->generateviewReport($_POST);
        //   }
        $resp = $mis->generatetoptencategorycReport($_POST);
        $this->view->response = $resp;
         $this->view->startdate = $_POST['startdate'];
            $this->view->enddate = $_POST['enddate'];
        }
        $this->_helper->layout()->setLayout('ivr1');
    }
    
     public function toptencategorysAction() {
        $mis = new Application_Model_Ivr1();

         if ($this->getRequest()->isPost()) {
        //   {$this->view->output=$mis->generateshortReport($_POST);
        //   print_r($_POST);
        //$mis->generateviewReport($_POST);
        //   }
        $resp = $mis->generatetoptencategorysReport($_POST);
        $this->view->response = $resp;
         $this->view->startdate = $_POST['startdate'];
            $this->view->enddate = $_POST['enddate'];
        }
        $this->_helper->layout()->setLayout('ivr1');
    }
    
     public function toptencategorysummaryAction() {
        $mis = new Application_Model_Ivr1();

        if ($this->getRequest()->isPost()) {
              $this->view->startdate = $_POST['startdate'];
            $this->view->enddate = $_POST['enddate'];
          $this->view->output = $mis->generatetoptencategorysummaryReport($_POST);}
            $this->_helper->layout()->setLayout('ivr1');
    }
public function toptencategorydetailAction()
{
     $mis = new Application_Model_Ivr1();

        if ($this->getRequest()->isPost()) {
              $this->view->startdate = $_POST['startdate'];
            $this->view->enddate = $_POST['enddate'];
          $this->view->output = $mis->generatetoptencategorydetailReport($_POST);}
            $this->_helper->layout()->setLayout('ivr1');
    
}

public function toptenshortcodeAction() {
        $mis = new Application_Model_Ivr1();

         if ($this->getRequest()->isPost()) {
        //   {$this->view->output=$mis->generateshortReport($_POST);
        //   print_r($_POST);
        //$mis->generateviewReport($_POST);
        //   }
        $resp = $mis->generatetoptenshortcodeReport($_POST);
        $this->view->response = $resp;}
        $this->_helper->layout()->setLayout('ivr1');
    }
    
     public function toptenshortcodetAction() {
        $mis = new Application_Model_Ivr1();

         if ($this->getRequest()->isPost()) {
        //   {$this->view->output=$mis->generateshortReport($_POST);
        //   print_r($_POST);
        //$mis->generateviewReport($_POST);
        //   }
        $resp = $mis->generatetoptenshortcodetReport($_POST);
        $this->view->response = $resp;
         $this->view->startdate = $_POST['startdate'];
            $this->view->enddate = $_POST['enddate'];
        }
        $this->_helper->layout()->setLayout('ivr1');
    }
      public function toptenshortcodecAction() {
        $mis = new Application_Model_Ivr1();

         if ($this->getRequest()->isPost()) {
        //   {$this->view->output=$mis->generateshortReport($_POST);
        //   print_r($_POST);
        //$mis->generateviewReport($_POST);
        //   }
        $resp = $mis->generatetoptenshortcodecReport($_POST);
        $this->view->response = $resp;
         $this->view->startdate = $_POST['startdate'];
            $this->view->enddate = $_POST['enddate'];
        }
        $this->_helper->layout()->setLayout('ivr1');
    }
    
     public function toptenshortcodesAction() {
        $mis = new Application_Model_Ivr1();

         if ($this->getRequest()->isPost()) {
        //   {$this->view->output=$mis->generateshortReport($_POST);
        //   print_r($_POST);
        //$mis->generateviewReport($_POST);
        //   }
        $resp = $mis->generatetoptenshortcodesReport($_POST);
        $this->view->response = $resp;
         $this->view->startdate = $_POST['startdate'];
            $this->view->enddate = $_POST['enddate'];
        }
        $this->_helper->layout()->setLayout('ivr1');
    }
    
     public function toptenshortcodesummaryAction() {
        $mis = new Application_Model_Ivr1();

        if ($this->getRequest()->isPost()) {
              $this->view->startdate = $_POST['startdate'];
            $this->view->enddate = $_POST['enddate'];
          $this->view->output = $mis->generatetoptenshortcodesummaryReport($_POST);}
            $this->_helper->layout()->setLayout('ivr1');
    }
public function toptenshortcodedetailAction()
{
     $mis = new Application_Model_Ivr1();

        if ($this->getRequest()->isPost()) {
              $this->view->startdate = $_POST['startdate'];
            $this->view->enddate = $_POST['enddate'];
          $this->view->output = $mis->generatetoptenshortcodedetailReport($_POST);}
            $this->_helper->layout()->setLayout('ivr1');
    
}


    private function generateParams() {


        $params = $this->_request->getParams();


        return $params;
    }

    //$this->_helper->layout()->setLayout('ivr1');



    /* public function welcomeAction()
      {
      $mis=new Application_Model_Ivr1();
      // print_r($_POST);exit();

      if ($this->getRequest()->isPost())
      {
      $this->view->output=$mis->generatewelcomeReport($_POST);


      }
      $this->_helper->layout()->setLayout('ivr1');

      } */
}

/*   public function shortAction()
    {
        $mis=new Application_Model_Ivr1();
        
        if ($this->getRequest()->isPost()) 
        
              {$this->view->output=$mis->generateshortReport($_POST);
            print_r($_POST);
            //$mis->generateviewReport($_POST);
        }
          $resp= $mis->generateshort1Report($_POST);
           $this->view->response=$resp;
          $this->_helper->layout()->setLayout('ivr1');

    }*/
    
       
    /*public function timeAction()
    {
        //$mis=new Application_Model_Mis();
        
        if ($this->getRequest()->isPost()) 
        {
            //$mis->generateviewReport($_POST);
        }
          $this->_helper->layout()->setLayout('ivr1');

    }*/
