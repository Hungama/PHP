<?php  
class SignupController extends Zend_Controller_Action  
{  
	public $id;
	public $signUp;
	public $content_details;
	public $celibrity_details;
	
	public function init()
	{
		$this->signUp=new Application_Model_Signup();
	}
	public function indexAction()  
	{  
	}  
        public function autherrorAction()
        {
           // echo "Please try again";
        }

        public function signupAction()  
	{
		if ($this->_request->isPost())  
		{  
			$this->id=$this->signUp->checkLogin($this->_request->getPost('login'),$this->_request->getPost('pass'));
			if($this->id)
			{
				$this->_helper->redirector('showcontentmanager');
			}
                        else
                        {
                            //$url = 'http://www.akrabat.com';
                            $url="http://119.82.69.212/hungamacare/zendstart/public/index.php/signup?logerr=invalid";
                           $this->_helper->redirector->gotoUrl($url);
                          //  $this->_helper->redirector('autherror');
                        }
		} 
	}
	public function showcontentmanagerAction()
	{
		$this->date1 = new Zend_Date();

		$this->view->mydate=$this->_request->getPost('startdate');
		if($this->_request->getPost('startdate'))
                $startdate=date("Y-m-d",strtotime($this->_request->getPost('startdate')));
		
		$this->content_details=$this->signUp->getContentDetials($this->_request->getPost('cName'),$startdate);
		$this->view->response=$this->content_details;
		
                $this->celibrity_details=$this->signUp->getCelibrityName();
		$this->view->response1=$this->celibrity_details;
		$this->view->ce_name=$this->_request->getPost('cName');
		
		if($this->_request->getPost('startdate')=='')
			$this->view->mydate=$this->date1->get('YYYY-MM-dd');
		else
			$this->view->mydate=$startdate;
	}
	public function showcelibritynameAction()
	{
		$this->celibrity_details=$this->signUp->getCelibrityName();
		$this->view->response=$this->celibrity_details;
	}
	
}
?>
