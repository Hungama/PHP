<?php  
class CelibrityController extends Zend_Controller_Action  
{  
	public $id;
	public $celebrity;
	public $result;
	public $response1;
	public $target_path;
	public $fileData;
	public $fileCount; 
	public $insertQuery; 
	public $dateArray;
	public $stmt;
	
	
	public function init()
	{
		$this->celebrity=new Application_Model_Celibrity();
		$value = Zend_Registry::get('dbAdapter');
	}
	public function indexAction()  
	{  
		//$this->result=$this->celebrity->getCelibrityDetails();
		//$this->view->response=$this->result;
           //echo "Under Construction.";
	}  

	public function uploadindexAction()  
	{  
		if($this->_request->isPost())
		{
			$this->target_path = "uploads/";
			if(!is_dir($this->target_path))
			{
				mkdir($this->target_path);
				chmod($this->target_path,0777);
			}
			$this->FileExt=explode(".",basename($_FILES['uploadedfile']['name']));
			if($this->FileExt[1]=='csv')
			{
				$this->target_path = $this->target_path . basename($_FILES['uploadedfile']['name']); 
				if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $this->target_path)) 
				{
					$this->view->response="File ". $_FILES['uploadedfile']['name']." Uploaded Successfully";
					chmod($_FILES['uploadedfile'],0777);
				}
				elseif($_FILES['uploadedfile']['name'])
				{
					$this->view->response="There are some problem please try later";
				}
			}
			else
			{
				$this->view->response="Only CSV file allowed";
			}
		}
		$this->insertFileIntoDataBase($this->target_path);
		if($_FILES['uploadedfile']['name'])
			$this->view->response="File Uploaded Successfully";
		else
			$this->view->response="File format should be only .CSV with only <b>celebid,date,msg</b> column<br>there should be no comma(,) in the entire file,date format should be in changeable format ";

	}  

	public function insertFileIntoDataBase($uploadedFile)
	{
		$this->uploadedFile=$uploadedFile;
		$value = Zend_Registry::get('dbAdapter');
		$this->fileContent=file($this->uploadedFile);
		$this->fileCount=sizeof($this->fileContent);
		
		for($this->i=1;$this->i<$this->fileCount;$this->i++)
		{
			$this->fileData=explode(",",$this->fileContent[$this->i]);
			if(trim($this->fileData[0])!='')
			{
				$this->insertDate=date("Y-m-d",strtotime($this->fileData[1]));
				$this->replacedValue=str_replace('-',",",addslashes($this->fileData[2]));
				//$mymsg=addslashes($this->fileData[3]);

				$this->insertQuery="insert into follow_up.tbl_content_manager values('',".$this->fileData[0].",'".$this->insertDate."','".$this->replacedValue."',now())";
				$this->stmt = $value->query($this->insertQuery);
			}
		}
	}
	
	public function pushedmsghistoryAction()
	{
		$this->result=$this->celebrity->getPushedMsgHistory($this->_request->getPost('startdate'));
		$this->view->response=$this->result;
	}
	public function showmsgstatusAction()
	{
		$this->result=$this->celebrity->getMsgStatus();
		$this->view->response=$this->result;
	}
	
	public function addcelebrityAction()
	{
		if($this->_request->isPost())
		{
			$this->result=$this->celebrity->addCelebritydetails($this->_request->getPost('Cname'),$this->_request->getPost('Cdesc'));
			$this->view->response=$this->result;
		}
	}
	public function deletecelebrityAction()
	{
		$this->result=$this->celebrity->getCelibrityDetails();
		$this->view->response=$this->result;
		
		if($this->_request->isPost())
		{
			$this->_request->getPost('CId');
			$this->result=$this->celebrity->deleteCelebritydetails($this->_request->getPost('CId'));
			$this->result=$this->celebrity->getCelibrityDetails();
			$this->view->response=$this->result;
			$this->view->responseMsg="Deleted Successfully";
		}
	}
	public function downloadmsgAction()
	{
		$msgTime='due';
		$this->result=$this->celebrity->downloadMessage($this->_request->getParam('Celeb_id'),$msgTime);

	}
	public function downloadsendmsgAction()
	{
		$msgTime='send';
		$this->result=$this->celebrity->downloadMessage($this->_request->getParam('Celeb_id'),$msgTime);
	}
	public function searchcelebrityAction()
	{
		if($this->_request->isPost())
		{
			$this->result=$this->celebrity->searchCelibrity($this->_request->getParam('srcCelebrity'));
		}
	}
}
?>
