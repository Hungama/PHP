<?
Zend_Loader::registerAutoload();
$configuration = new Zend_Config_Ini('./config/configurations.ini','development');
echo $config->database->params->host;
?>