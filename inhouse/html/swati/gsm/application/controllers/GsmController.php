<?php

class GsmController extends Zend_Controller_Action
{
	
    	public function init()
	{
		$this->login=new Application_Model_User();
		$value = Zend_Registry::get('dbAdapter');
		
	}

	public function uploadAction()
	{
		
	}
	
	
}
?>
