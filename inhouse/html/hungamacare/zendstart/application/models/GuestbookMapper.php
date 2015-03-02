<?php
class Application_Model_GuestbookMapper
{
    protected $_dbTable;
 
    public function setDbTable($dbTable)
    {
		if (is_string($dbTable)) {
            $dbTable = new $dbTable();
		}
		$this->_dbTable = $dbTable;
		return $this;
    }
 
    public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable('Application_Model_DailyReportCricket');
        }
		return $this->_dbTable;
    }
 
    public function save(Application_Model_Guestbook $guestbook)
    {
        $data = array(
            'email'   => $guestbook->getEmail(),
            'comment' => $guestbook->getComment(),
            'created' => date('Y-m-d H:i:s'),
        );
 
        if (null === ($id = $guestbook->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }
 
    public function find($id, Application_Model_Guestbook $guestbook)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $guestbook->setId($row->id)
                  ->setEmail($row->email)
                  ->setComment($row->comment)
                  ->setCreated($row->created);
    }
 
    public function fetchAll()
    {
        $this->CreateDatabaseConnection();
		$resultSet = $this->getDbTable();
		$table = new Application_Model_DailyReportCricket();
		$rows = $table->find(1992980);
		echo "athar<pre>";
		print_r($rows[0]);
		exit;
		$entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Guestbook();
            $entry->setId($row->id)
                  ->setEmail($row->email)
                  ->setComment($row->comment)
                  ->setCreated($row->created);
            $entries[] = $entry;
        }
        return $entries;
    }
	public function CreateDatabaseConnection()
	{
		$configuration = new Zend_Config_Ini("./config/configurations.ini",'development');
		$dbAdapter = Zend_Db::factory($configuration->database);
		Zend_Db_Table_Abstract::setDefaultAdapter($dbAdapter);
		$registry = Zend_Registry::getInstance();
		$registry->configuration = $configuration;
		$registry->dbAdapter     = $dbAdapter;
	}
}
?>