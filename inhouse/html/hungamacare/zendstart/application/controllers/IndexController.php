<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
       // echo "HUNGAMA";
          $url="http://119.82.69.212/hungamacare/zendstart/public/index.php/signup";
          $this->_helper->redirector->gotoUrl($url);
    }


}

