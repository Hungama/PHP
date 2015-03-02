<?php
class DailyReportCricket extends Zend_Db_Table_Abstract
{
	protected $_name    = "dailyReportCricket";
	public function fetchAll()
    {
       echo $myQuery="select * from tbl_radio_calllog limit 10";
    }
	
}

//extends Zend_Db_Table_Abstract
?>