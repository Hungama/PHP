<?php
/**
  * License: GNU LGPL (http://www.opensource.org/licenses/lgpl-license.html)
  *
  * This library is free software; you can redistribute it and/or
  * modify it under the terms of the GNU Lesser General Public
  * License as published by the Free Software Foundation; either
  * version 2.1 of the License, or (at your option) any later version.
  *
  * This library is distributed in the hope that it will be useful,
  * but WITHOUT ANY WARRANTY; without even the implied warranty of
  * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
  * Lesser General Public License for more details.
  *
  * You should have received a copy of the GNU Lesser General Public
  * License along with this library; if not, write to the Free Software
  * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
  * or download it here http://www.opensource.org/licenses/lgpl-license.html
  *
  * @project: phpMysqlCachingWrapper
  * @date: 04-12-2010
  * @version: 0.2 - php 4 / 5
  * @author Bilge Hauser
  * @email: cianti@cianti.de
  * @copyright: 2010 Bilge Hauser
  *  
  *  
  *  history:[
  *     08.12.2010 - Version 0.1 finished
  *     12.12.2010 - Implemented Class Registry
  *     31.12.2010 - Implemented Event Handling -> v 0.2
  *  ]
  **/
 
 // EVENTS that can be handled
 
 // CLASS_WRAPPER_DESTRUCT
 // CLASS_WRAPPER_QUERY_ERROR
 // CLASS_WRAPPER_CONNECT_ERROR
 // CLASS_WRAPPER_DBSELECT_ERROR
 // CLASS_WRAPPER_QUERY_BEFORE
 // CLASS_WRAPPER_QUERY_AFTER
 // CACHE_WRITE_BEFORE
 // CACHE_WRITE_AFTER
 // CACHE_READ_BEFORE
 // CACHE_READ_AFTER
 
// Register event handlers like
// $onDBQueryError = "mail('cianti@cianti.de', \$_SERVER['SERVER_NAME'].': Database query error', 'Warning: Database queries had an error on '.\$_SERVER['SERVER_NAME']);";
// $dbh->register_event('CLASS_WRAPPER_QUERY_ERROR',  $onDBQueryError);

// Or to access class functions
// $onBeforeCacheRead = "\$self->setMessageQue('Injected Text Before Cache Read');";
// $dbh->register_event('CACHE_READ_BEFORE', $onBeforeCacheRead);

// php < 5.2 needs json class 
// i will use json format to cache db queries in files.
// http://pear.php.net/pepr/pepr-proposal-show.php?id=198

if (!function_exists('json_encode')) {
	require_once($SITE_CONF['CLASS_PATH']   . 'json/json.class.php');
	$json = new Services_JSON();
	function json_encode($input = false) {
		return $json->encode($input);
	}
	
	function json_decode($input = false) {
		return $json->decode($input);
	}
}


class wrapper_registry{
	var $events						= array();
	
	// Register event for action
	function register_event($event=false, $function=false){
		if(!$event)return;
		if(!$function)return;
		// can handle multiple actions
		$this->events[$event]['actions'][] = create_function ('&$self', $function);
		return true;
	}
	// unregister event
	function unregister_event($event=false){
		if(!$event)return;
		if(!array_key_exists($event, $this->events))return;
		unset($this->events[$event]);
        return true;
	}
	
	function call_event($event=false){
		if($this->is_inDebugMode())$this->setMessageQue(date("d-m-Y h:i:s").'- Line :' . __LINE__.' - CALL EVENT:'.$event);
		if(!$event)return;
		// check if event exist
		if(!isset($this->events[$event])) return;
		//check if any actions registered
		if(!isset($this->events[$event]['actions'])) return;
		if(count($this->events[$event]['actions']) < 1) return;

		foreach($this->events[$event]['actions'] as $action){
			if(function_exists($action)){
				if($this->is_inDebugMode())$this->setMessageQue(date("d-m-Y h:i:s").'- Line :' . __LINE__.' - Registered Function:'.$action.' found');
			    $action(&$this);	
				if($this->is_inDebugMode())$this->setMessageQue(date("d-m-Y h:i:s").'- Line :' . __LINE__.' - Registered Function:'.$action.' executed');
			}else{
				if($this->is_inDebugMode())$this->setMessageQue(date("d-m-Y h:i:s").'- Line :' . __LINE__.' - Registered Function:'.$action.' not found');
			}
		}
		return true;
	}
	
}

 
class cache_controller extends wrapper_registry{
	var $connected 					= false;
	var $cache_dir    				= false;
	var $cache_ttl    				= 120;
	var $cache_id	  				= false;
	var $cache_suffix 				= 'cache';
	var $cache_content				= array();
	var $debug  		 			= false;
	var $messageQue             	= array();
    var $use_cache_controller		= false;


	function is_inDebugMode(){
		return $this->debug;
	}

	function getMessageQue(){
		return $this->messageQue;
	}
	
	function setMessageQue($message){
		$this->messageQue[] = $message;
	}
	
	function read_cache($query=false){
		if (!$query) return false;
		if (file_exists($this->cache_dir.$this->cache_id.'.'.$this->cache_suffix)){
		 	$this->get_resultFromCache();
			$this->cache_id=false;
			return $this->cache_content;	
		}else{
			return false;
		}
		
	}
  	
	function is_cacheValid($query=false){
  		if (!$query) return false;
		if (!$this->cache_id) $this->generateCacheId($query);
		if (!$this->cache_id) return false;
		$fileAge = $this->getCacheAge();
		
		if ($fileAge){
			if($this->is_inDebugMode())$this->setMessageQue(date("d-m-Y h:i:s").'- Line :' . __LINE__.' - Cache ID:'.$this->cache_id.' - CACHE FOUND');
			// 
			if ($fileAge < $this->cache_ttl){ 
				if($this->is_inDebugMode())$this->setMessageQue(date("d-m-Y h:i:s").'- Line :' . __LINE__.' - Cache ID:'.$this->cache_id.' - CACHE VALID');
				return true;
		    }else if($fileAge && !$this->connected){
				if($this->is_inDebugMode())$this->setMessageQue(date("d-m-Y h:i:s").'- Line :' . __LINE__.' - Cache ID:'.$this->cache_id.' - CACHE VALID DUE DATABASE DISCONNECTED');
				return true;
			}else{
				if($this->is_inDebugMode())$this->setMessageQue(date("d-m-Y h:i:s").'- Line :' . __LINE__.' - Cache ID:'.$this->cache_id.' - CACHE NOT VALID');
				return false;
			}
		}else{
			if($this->is_inDebugMode())$this->setMessageQue(date("d-m-Y h:i:s").'- Line :' . __LINE__.' - Cache ID:'.$this->cache_id.' - ID NOT FOUND');
			return false;
		}
		
  	}
  
  
	
	function generateCacheId($query=''){
		if (!$this->use_cache_controller && !$this->cache_dir) return false;
		if(stristr($query, 'SELECT') === FALSE){
			$this->cache_id = false;
     		if($this->is_inDebugMode())$this->setMessageQue(date("d-m-Y h:i:s").'- Line :' . __LINE__.' - Cache ID:'.$this->cache_id.' - NOT GENERATED ID, NO SELECT');
		}else{
			$this->cache_id = md5($query);
     		if($this->is_inDebugMode())$this->setMessageQue(date("d-m-Y h:i:s").'- Line :' . __LINE__.' - Cache ID:'.$this->cache_id.' - GENERATED ID');
		}
		 
	}
	// get cache file age in seconds
    function getCacheAge(){
		if (file_exists($this->cache_dir.$this->cache_id.'.'.$this->cache_suffix) && is_file($this->cache_dir.$this->cache_id.'.'.$this->cache_suffix)){
			// get file date
			$FileCreationTime = filemtime($this->cache_dir.$this->cache_id.'.'.$this->cache_suffix);
			// Calculate file age in seconds
			$FileAge = time() - $FileCreationTime;
			if($this->is_inDebugMode())$this->setMessageQue(date("d-m-Y h:i:s").'- Line :' . __LINE__.' - Cache ID:'.$this->cache_id.' - GET FILE AGE : '.$FileAge.' seconds');
			return $FileAge;
		}else{
			 return false;
		}
    }

    function is_cachable($query){
    	// check for cache id
    	if (!$this->cache_id) return false;
		// Only selects are cachable 		
		if(stristr($query, 'SELECT') === FALSE)  return false;
		$fileAge = $this->getCacheAge();
		// no file so cache anyway
		if (!$fileAge) return true;
		// if cache file and file is older then ttl cache it
		if ($fileAge > $this->cache_ttl)return true;
		// else cache is valid
		return false;
    }
	
	function write_cache($query=false, $result=false){
		if (!$query && !$result) return false;
		if (!$this->cache_id) return false;
		if ($this->is_cachable($query)){
			$this->cache_content['id'] = $this->cache_id;
			$this->cache_content['ttl'] = $this->cache_ttl;
			$this->cache_content['timestamp'] = time();
			$this->cache_content['data'] = $result;
		 	$this->put_resultToCache();
			$this->cache_id=false;
			return true;	
		}else{
			return false;
		}
		
	}

	function put_resultToCache(){
		if ($this->cache_id){
		if (file_exists($this->cache_dir.$this->cache_id.'.'.$this->cache_suffix) && is_file($this->cache_dir.$this->cache_id.'.'.$this->cache_suffix)){
			if($this->is_inDebugMode())$this->setMessageQue(date("d-m-Y h:i:s").'- Line :' . __LINE__.' - Cache ID:'.$this->cache_id.' - DELETE');
			unlink($this->cache_dir.$this->cache_id.'.'.$this->cache_suffix);
		}
		if($this->is_inDebugMode())$this->setMessageQue(date("d-m-Y h:i:s").'- Line :' . __LINE__.' - Cache ID:'.$this->cache_id.' - WRITE');
		$this->call_event('CACHE_WRITE_BEFORE');
		file_put_contents($this->cache_dir.$this->cache_id.'.'.$this->cache_suffix, json_encode($this->cache_content));
		$this->call_event('CACHE_WRITE_AFTER');
		}
	}
	
	function get_resultFromCache(){
		if ($this->cache_id){
			if($this->is_inDebugMode())$this->setMessageQue(date("d-m-Y h:i:s").'- Line :' . __LINE__.' - Cache ID:'.$this->cache_id.' - READ');
			$this->call_event('CACHE_READ_BEFORE');
			$this->cache_content = json_decode(file_get_contents($this->cache_dir.$this->cache_id.'.'.$this->cache_suffix), true);
			$this->call_event('CACHE_READ_AFTER');
		}
	}

} // End class cache_controller

// Events:
// CLASS_WRAPPER_DESTRUCT
// CLASS_WRAPPER_QUERY_ERROR
// CLASS_WRAPPER_CONNECT_ERROR
// CLASS_WRAPPER_DBSELECT_ERROR
// CLASS_WRAPPER_QUERY_BEFORE
// CLASS_WRAPPER_QUERY_AFTER
 

class mysql_wrapper extends cache_controller{
	var $mysql_user   				= false;
	var $mysql_pass  				= false;
	var $mysql_host  				= false;
	var $mysql_db	 				= false;
	var $mysql_persistent  			= false;
	var $mysql_socket   			= false;
	var $mysql_use_socket   		= false;
	var $result	 					= array();
	var $last_result				= array();
	var $num_rows					= false;
	var $last_num_rows				= false;
    var $db_connection   			= false;
	var $db_error  		 			= false;
	var $log_path 					= false;
	var $last_query					= array();
	
    // constructor
	function __construct($SITE_CONF) {
		$this->mysql_user   		= $SITE_CONF['DB_USER'];
		$this->mysql_pass   		= $SITE_CONF['DB_PASS'];
		$this->mysql_host   		= $SITE_CONF['DB_HOST'];
		$this->mysql_db	  			= $SITE_CONF['DB_DATABASE'];
		$this->mysql_persistent 	= $SITE_CONF['DB_PERSISTENT'];
		$this->mysql_socket   		= $SITE_CONF['DB_SOCKET_PATH'];
		$this->mysql_use_socket 	= $SITE_CONF['DB_USE_SOCKET'] ;
	    $this->cache_dir 			= $SITE_CONF['DB_CACHE_PATH'];
		$this->cache_ttl 			= $SITE_CONF['DB_CACHE_TTL']; 
		$this->debug				= $SITE_CONF['DEBUG'] ;
		$this->use_cache_controller	= $SITE_CONF['DB_USE_CACHE']; 
		$this->log_path 			= $SITE_CONF['DEBUG_LOGPATH'];
		// Connect
		if (!$this->connected && $this->mysql_persistent && $this->mysql_use_socket) $this->_socketPconnect(); 
		if (!$this->connected && !$this->mysql_persistent && $this->mysql_use_socket) $this->_socketConnect(); 
		if (!$this->connected && !$this->mysql_persistent && !$this->mysql_use_socket) $this->_connect(); 
		if (!$this->connected && $this->mysql_persistent && !$this->mysql_use_socket) $this->_pconnect(); 
        // select db
		$sel = false;
		if ($this->connected && $this->db_connection) $sel = @mysql_select_db($this->mysql_db, $this->db_connection);
		if ($this->connected && $this->db_connection &&!$sel) $this->_setError(2, 'Mysql selecting DB '.$this->mysql_db.' Failed.');
		if (!$this->db_connection) $this->connected = false;
  	}
    
	//destructor
  	function __destruct(){
		if (!$this->mysql_persistent && $this->db_connection) mysql_close($this->db_connection) || $this->_setError(4, 'Mysql Disconnect Error : '.mysql_error());
		if($this->is_inDebugMode())$this->setMessageQue(date("d-m-Y h:i:s").'- Line :' . __LINE__.' - - WRITE LOG: '.$this->log_path);
		$this->_writeLog();
		// Call Event handler
        $this->call_event('CLASS_WRAPPER_DESTRUCT');
	}	
	// Constructor php 4
    function mysql_wrapper($SITE_CONF){
    	register_shutdown_function(array(&$this, "__destruct"));
    	return $this->__construct($SITE_CONF); // forward php4 to __construct
    }
	
	# retrieve one row
	function get_row($query='',$counter=0){
		if ($query){
			$this->query($query);
		}
		$this->cache_id = false;
		if (count($this->result) > 0){
		   return $this->result[$counter];	
		}else{
		   return false;
		}
		
	}

	# retrieve multiple rows
	function get_rows($query=null, $counter=0){
		if ($query){
			$this->query($query);
		}
		$this->cache_id = false;
	    return $this->result;
	}
	
	# retrieve num rows
	function get_num_rows(){
	    return count($this->result);
	}

	# retrieve last result
	function get_last_result(){
	    return $this->last_result;
	}


	// query
	function query($query){
		// Save query
		$this->last_query = $query;
      	// lookup cache
        $is_cached = $this->is_cacheValid($query);
		// if not connected  and not cached return empty array
		if (!$this->connected && !$is_cached) return array();
		if($this->is_inDebugMode())$this->setMessageQue(date("d-m-Y h:i:s").'- Line :' . __LINE__.' -  - SQL QUERY: '. $query);
		// if not cached query database 
		if(!$is_cached) $this->call_event('CLASS_WRAPPER_QUERY_BEFORE');
		if(!$is_cached) $result = @mysql_query($query,$this->db_connection);
		if(!$is_cached) $this->call_event('CLASS_WRAPPER_QUERY_AFTER');
        // is in cache
		if($is_cached){
			// read cache
        	$this->get_resultFromCache();
		    // save last result	
			if($this->result)$this->last_result = $this->result;
			//get Result
			if($this->is_inDebugMode())$this->setMessageQue(date("d-m-Y h:i:s").'- Line :' . __LINE__.' -  - QUERY RESULT FROM CACHE');
        	$this->result =  $this->cache_content['data'];
			$this->num_rows = count($this->result);		
   			$result = false;
		}
		
		if ($result ){
		    // save last result	
			if($this->result)$this->last_result = $this->result;
			$this->result=array();	
			$i=0;
			// convert result to array, cause cached results are arrays too
			// so we dont have to care about arrays or result instances 
			while(($this->result[] = @mysql_fetch_assoc($result)) || array_pop($this->result));	
			// write to cache
			$this->write_cache($query, $this->result);
			// count result
			$this->num_rows = count($this->result);		
			if($this->is_inDebugMode())$this->setMessageQue(date("d-m-Y h:i:s").'- Line :' . __LINE__.' -  - QUERY RESULT: '. $this->num_rows);
			mysql_free_result($result);
			if($this->num_rows){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	
	// return last error
	function getError(){
		return $this->db_error;
	}


	// return connected
	function is_connected(){
		return $this->connected;
	}

	// private
	// write / append log to logdir
    function _writeLog(){
    	if($this->is_inDebugMode()){
    		file_put_contents($this->log_path, "\n".implode("\n", $this->getMessageQue()), FILE_APPEND);
		}
    }
    // normal connect (tcp)
    function _connect(){
    	$this->db_connection = @mysql_connect($this->mysql_host, $this->mysql_user, $this->mysql_pass); 
		if (!$this->db_connection) $this->_setError(1, mysql_error());
		if (!$this->db_error) $this->_setConnected();
    }

    // persistent connect (tcp)
    function _pconnect(){
    	$this->db_connection = @mysql_pconnect($this->mysql_host, $this->mysql_user, $this->mysql_pass);
		if (!$this->db_connection) $this->_setError(1, mysql_error());
		if (!$this->db_error) $this->_setConnected();
    }

    // normal connect (socket)
    function _socketConnect(){
    	$this->db_connection = @mysql_connect('localhost:'.$this->$mysql_socket, $this->mysql_user, $this->mysql_pass);
		if (!$this->db_connection) $this->_setError(1, mysql_error());
		if (!$this->db_error) $this->_setConnected();
    }

    // persistent connect (socket)
    function _socketPconnect(){
    	$this->db_connection = @mysql_pconnect('localhost:'.$this->$mysql_socket, $this->mysql_user, $this->mysql_pass);
		if (!$this->db_connection) $this->_setError(1, mysql_error());
		if (!$this->db_error) $this->_setConnected();
    }
	
	function _setError($type=1, $message){
		if ($type == 1){ // not connected
			$this->connected = false;
			$this->db_connection = false;
			// Call Event handler
    	    $this->call_event('CLASS_WRAPPER_CONNECT_ERROR');


		}else if ($type == 2){ // db select error
			// Call Event handler
    	    $this->call_event('CLASS_WRAPPER_DBSELECT_ERROR');

		}else if ($type == 3){ // db query error
			// Call Event handler
    	    $this->call_event('CLASS_WRAPPER_QUERY_ERROR');

		}else if ($type == 4){ // db disconnect error
			$this->connected = false;
			$this->db_connection = false;
		}
		$this->db_error = $message;
		if($this->is_inDebugMode())$this->setMessageQue(date("d-m-Y h:i:s").'- Line :' . __LINE__.' -  - '.$message);
	}

	function _setConnected(){
		$this->connected = true;
		if($this->is_inDebugMode())$this->setMessageQue(date("d-m-Y h:i:s").'- Line :' . __LINE__.' -  - DATABASE CONNECTED');
	}
} // End class mysql_wrapper
?>