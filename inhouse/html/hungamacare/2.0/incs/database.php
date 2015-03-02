<?php

$SITE_CONF = array();

$SITE_CONF['SITEROOT']        	= dirname ($_SERVER['SCRIPT_FILENAME']) . '/';

//echo $SITE_CONF['SITEROOT'];exit;
$SITE_CONF['DB_CACHE_PATH']   	= $SITE_CONF['SITEROOT'] . 'cache/';
$SITE_CONF['CLASS_PATH']         = $SITE_CONF['SITEROOT'].'incs/';
$SITE_CONF['DB_HOST']      		= 'localhost';
$SITE_CONF['DB_DATABASE']   		= 'misdata';
$SITE_CONF['DB_USER']      		= 'kunalk.arora';
$SITE_CONF['DB_PASS']      		= 'google';
$SITE_CONF['DB_PERSISTENT']		= false;
$SITE_CONF['DB_USE_SOCKET']      = false;
$SITE_CONF['DB_SOCKET_PATH']     = '/var/lib/mysql/mysql.sock';
$SITE_CONF['DB_USE_CACHE']      	= true;
$SITE_CONF['DB_CACHE_TTL']      	= 24*60*3; //Seconds
$SITE_CONF['DEBUG']      			= false;
$SITE_CONF['DEBUG_LOGPATH']      = $SITE_CONF['SITEROOT'] . 'log/phpMysqlCachingWrapper.log';

require_once($SITE_CONF['CLASS_PATH'] . 'db.class.php');

?>