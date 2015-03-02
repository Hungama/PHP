<?php

class UserController extends Zend_Controller_Action {

    public function initAction() {
        $this->params = $this->generateParams();
        $this->view->params = $this->generateParams();
    }
    
    private function generateParams() {
        $params = $this->_request->getParams();
        return $params;
    }


    public function loginAction() {
        $this->view->params = $this->generateParams();
        $mis = new Application_Model_User();
        if ($this->getRequest()->isPost()) {
           $this->view->output = $mis->generateloginReport($_POST);
           $resp1 = trim($mis->generateloginReport($_POST)); 
            $this->view->response = $resp1;
            if ($resp1 == 1) {
                $_SESSION['name'] = $_POST['id'];
                $_SESSION['pass'] = $_POST['pass'];
                $_SESSION['role'] = 'admin';
                $this->_redirect('ivr1/report/');
            } 
            elseif ($resp1 == 2) {
                $_SESSION['name'] = $_POST['id'];
                $_SESSION['pass'] = $_POST['pass'];
                $_SESSION['role'] = 'user';
                $this->_redirect('ivr1/report/');
            } 
            else {
                $this->view->errorMessage = "Invalid username or password. Please try again.";
            }
           
        }
        $this->_helper->layout()->setLayout('ivr');
    }
    public function forgotpassAction() {
        $mis = new Application_Model_User();

        if ($this->getRequest()->isPost()) { 
           $output = trim($mis->generateforgotpassReport($_POST));
            //  print_r($_POST);
            //$mis->generateviewReport($_POST);
        
        // $resp= $mis->generateshort1Report($_POST);
        // $this->view->response=$resp;
        $this->view->output=$output;
        
        if($output==1)
        $this->_redirect('user/login/successmessage2/Your password has been successfully sent.');
        //$this->view->successmessage2="Your password has been successfully sent .";
        
        }        $this->_helper->layout()->setLayout('ivr');
    }
     public function forgotpass1Action() {
        $mis = new Application_Model_User();

        if ($this->getRequest()->isPost()) {
           $output = $mis->generateforgotpass1Report($_POST);}
            $this->_helper->layout()->setLayout('ivr');
           }
    
      public function logoutAction() {
        session_destroy();
        $this->_redirect('user/login');
   }

}
