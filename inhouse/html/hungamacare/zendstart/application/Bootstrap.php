<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initDatabaseAdapter()
		{
			$configuration = new Zend_Config_Ini("./config/configurations.ini",'development');
			$dbAdapter = Zend_Db::factory($configuration->database);
			Zend_Db_Table_Abstract::setDefaultAdapter($dbAdapter);
			$registry = Zend_Registry::getInstance();
			$registry->configuration = $configuration;
			$registry->dbAdapter     = $dbAdapter;
		}
}

