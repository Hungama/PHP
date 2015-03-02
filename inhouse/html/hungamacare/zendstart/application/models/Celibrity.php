<?php
class Application_Model_Celibrity
{
	protected $_dbTable;
	public $data1;
	
	public function init()
	{
		$this->date1 = new Zend_Date();
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
	
	public function getCelibrityDetails()
	{
		$resultSet = $this->getDbTable('Application_Model_CelibrityDetails');
		$order  = 'follow_up.tbl_celebrity_manager.Celeb_Id';
		$table = new Application_Model_CelibrityDetails();
		
		$select = $table->select();
		$select->from('follow_up.tbl_celebrity_manager');
		$select->order($order);

        $result = $resultSet->fetchAll($select);
		return $result;
	}

	public function getPushedMsgHistory($selectdate)
	{
		$this->date1 = new Zend_Date();
		if($selectdate=='')
			$selectdate=$this->date1->get('YYYY-MM-dd');
		
		$resultSet = $this->getDbTable('Application_Model_TblSubscription');
		$table = new Application_Model_TblSubscription();
		$select = $table->select();
		$order="COUNT(tbl_subscription.Ani) desc";
		$select->setIntegrityCheck(false);
		$select->from($table, array('COUNT(tbl_subscription.Ani) as count',"tbl_subscription.Celeb_id","tbl_celebrity_manager.Celeb_Name","tbl_subscription.Msg_Date"))->joinUsing('follow_up.tbl_celebrity_manager', 'Celeb_Id')->where("date(Msg_date)='".$selectdate."'", 'NEW');
		$select->group('tbl_subscription.Celeb_id');
		$select->order($order);
		$result = $resultSet->fetchAll($select);
		return $result;
	}
	public function getMsgStatus()
	{
		$this->date1 = new Zend_Date();
		$resultSet = $this->getDbTable('Application_Model_ContentDetails');
		$table = new Application_Model_ContentDetails();
		
		$select = $table->select();
		$select->setIntegrityCheck(false);
		
		$value = Zend_Registry::get('dbAdapter');
		
		$myQuery="select count(a.Date) as send_count,a.Celeb_id,(select count(b.Date) due_count from follow_up.tbl_content_manager b where  date(b.Date)>'".$this->date1->get('YYYY-MM-dd')."' and b.Celeb_id = a.Celeb_id ) count , (select b.Celeb_id from follow_up.tbl_content_manager b where  date(b.Date)>'".$this->date1->get('YYYY-MM-dd')."' and b.Celeb_id = a.Celeb_id group by b.Celeb_id) Celeb_id1,(select c.Celeb_name from follow_up.tbl_celebrity_manager c where c.Celeb_id = a.Celeb_id) Celeb_Name from follow_up.tbl_content_manager a  where  date(a.Date)<='".$this->date1->get('YYYY-MM-dd')."' group by a.Celeb_id";

		
		$stmt = $value->query($myQuery);
		$result = $stmt->fetchAll();
		return $result;
	}
	public function addCelebritydetails($celebrityName,$celebrityDesc)
	{
		if($celebrityName=='' || $celebrityDesc=='')
		{
			return "Celebrity Name/ Description can't be leave blank";
			exit;
		}
		$resultSet = $this->getDbTable('Application_Model_CelibrityDetails');
		$table = new Application_Model_CelibrityDetails();
		$select = $table->select();
		$select->from('follow_up.tbl_celebrity_manager')->where("Celeb_name='$celebrityName'");
		$result = $resultSet->fetchRow($select);
		if($result['Celeb_Id'])
		{
			return "Celebrity Already Created";
		}
		else
		{
			$data = array('Celeb_Name'=> "$celebrityName",'Celeb_Description' => "$celebrityDesc");
			$result=$table->insert($data);
			return "Celebrity Created";
		}
	}

	public function deleteCelebritydetails($cid)
	{
		$this->cid=$cid;
		$value = Zend_Registry::get('dbAdapter');
		$this->value1=implode(",",$this->cid);
		$deleteQuery="delete from follow_up.tbl_celebrity_manager where Celeb_id in(".$this->value1.")";
		$stmt = $value->query($deleteQuery);
	}

	public function downloadMessage($Celeb_id,$msgstatus)
	{
		$this->date1 = new Zend_Date();
		$resultSet = $this->getDbTable('Application_Model_ContentDetails');
		$table = new Application_Model_ContentDetails();
		
		$select = $table->select();
		$select->setIntegrityCheck(false);
		
		if($msgstatus=='due')
			$select->from($table, array('Celeb_id','tbl_celebrity_manager.Celeb_Name','Msg_text','Date'))->joinUsing('follow_up.tbl_celebrity_manager', 'Celeb_Id')->where("date(Date)>'".$this->date1->get('YYYY-MM-dd')."' and tbl_content_manager.Celeb_id='".$Celeb_id."' and tbl_celebrity_manager.Celeb_id=tbl_content_manager.Celeb_id", 'NEW');
		elseif($msgstatus=='send')
			$select->from($table, array('Celeb_id','tbl_celebrity_manager.Celeb_Name','Msg_text','Date'))->joinUsing('follow_up.tbl_celebrity_manager', 'Celeb_Id')->where("date(Date)<='".$this->date1->get('YYYY-MM-dd')."' and tbl_content_manager.Celeb_id='".$Celeb_id."' and tbl_celebrity_manager.Celeb_id=tbl_content_manager.Celeb_id", 'NEW');

		$result = $resultSet->fetchAll($select);
		$excellFile=date("Ymd").".csv";
		
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=$excellFile");
		echo "Date,Celeb_id,Celeb_Name,Msg_Text"."\r\n";

		foreach($result as $row)
		{
			$Msg_text=str_replace(',',' ',$row['Msg_text']); 
			echo $row['Date'].",".$row['Celeb_id'].",".$row['Celeb_Name'].",".$Msg_text."\r\n";
		}
	}

	public function searchCelibrity($celebrityname)
	{
		echo $celebrityname;
	}
}
?>