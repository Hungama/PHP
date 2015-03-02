<?php  
class GuestbookController extends Zend_Controller_Action
{
    public function indexAction()
    {
        $guestbook = new Application_Model_GuestbookMapper();
		echo ($this->view->entries = $guestbook->fetchAll());
    }
}
?>
