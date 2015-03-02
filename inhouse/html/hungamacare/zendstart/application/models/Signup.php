<?php
class Application_Model_Signup
{
	protected $_dbTable;
	public $date1;
	
	public function init()
	{
		
	}

	public function setDbTable($dbTable)
    {
		if (is_string($dbTable)) {
            $dbTable = new $dbTable();
		}
		$this->_dbTable = $dbTable;
		return $this;
    }
 
    public function getDbTable($tablename)
    {
		if (null === $this->_dbTable) {
            $this->setDbTable($tablename);
        }
		return $this->_dbTable;
    }
	
	public function save($login,$pass)
	{
		$this->date1 = new Zend_Date();
		$table = new Application_Model_MasterDb();
		$newRow = $table->createRow();
		
		// Set column values as appropriate for your application
		$newRow->username = $login;
		$newRow->password = $pass;
		$newRow->name = 'Follow Me Admin';
		$newRow->status = 1;
		$newRow->dbaccess = 'follow_up';
		$newRow->user_type = 'normal';
		$newRow->last_login = $this->date1->get('YYYY-MM-dd HH:mm:ss');
		$newRow->added_by = 'sysadmin';
		$newRow->added_on = $this->date1->get('YYYY-MM-dd HH:mm:ss');
		
		// INSERT the new row to the database
		$newRow->save();
	}
	
	public function checkLogin($login,$pwd)
	{
		$resultSet = $this->getDbTable('Application_Model_MasterDb');
		$table = new Application_Model_MasterDb();
		//$where="select id from master_db.ivr_web_user_master where username='".$login."' and password='".$pwd."'";
                $where="select id from master_db.live_user_master where username='".$login."' and password='".$pwd."'";
		$result = $resultSet->fetchRow($where);
		$entry = new Application_Model_Followup();
		$entry->setId($result->id);
		$entry->setUserName($result->username);
		$entry->setPassword($result->password);
		if (!$entry->getId()) {
               //throw new Exception('Wrong UserName/Password');
               //echo "Invalid UserName/Password";
               return 0;
        }
		return $entry->getId();
	}

	public function getContentDetials($celeb_name,$startdate)
	{
		$this->date1 = new Zend_Date();
		//if($startdate=='')			$startdate=$this->date1->get('YYYY-MM-dd');
		
		$this->view->mydate=$startdate;
		$order  = 'follow_up.tbl_celebrity_manager.Celeb_Id';
		$resultSet = $this->getDbTable('Application_Model_ContentDetails');
		$table = new Application_Model_ContentDetails();
		
		$select = $table->select();
		$select->setIntegrityCheck(false);
		$select->from('follow_up.tbl_content_manager');
		$select->joinUsing('follow_up.tbl_celebrity_manager', 'Celeb_Id');
		if($celeb_name!='' && $startdate=='')
			$select->where("follow_up.tbl_celebrity_manager.Celeb_Id=$celeb_name", 'NEW');
		elseif($celeb_name!='' && $startdate!='')
			$select->where("date(date)='".$startdate."' and follow_up.tbl_celebrity_manager.Celeb_Id=$celeb_name", 'NEW');
		elseif($celeb_name=='' && $startdate!='' )
			$select->where("date(date)='".$startdate."'", 'NEW');
		else
			$select->where("date(date)='".$this->date1->get('YYYY-MM-dd')."'", 'NEW');
		

		$select->order($order);

        $result = $resultSet->fetchAll($select);
		return $result;
	}
	

	public function getCelibrityName()
	{
		$order="Celeb_Id";
		$resultSet = $this->getDbTable('Application_Model_CelibrityDetails');
		$table = new Application_Model_CelibrityDetails();
		
		$select = $table->select();
		$select->setIntegrityCheck(false);

		$select->from('follow_up.tbl_celebrity_manager');
		$select->order($order);

        $result1 = $resultSet->fetchAll($select);
		return $result1;
		
	}

	public function createUser($login,$pass)
    {
		$this->CreateDatabaseConnection();
		$resultSet = $this->getDbTable();
		$rows = $this->save($login,$pass);
	}
}
?>