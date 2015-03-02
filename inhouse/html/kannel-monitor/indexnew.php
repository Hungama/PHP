<?php

/*
 * kannel-status.php -- display a summarized kannel status page
 *
 * This php script acts as client for the status.xml output of
 * Kannel's bearerbox and aggregates information about smsc link
 * status and message flow. It is the first step to provide an
 * external Kannel Control Center interface via HTTP.
 *
 * Stipe Tolj <stolj@wapme.de>
 * Copyright (c) 2003 Kannel Group.
 */

include("xmlfunc.php");

/* config section: define which Kannel status URLs to monitor */

$configs = array(
            array( "base_url" => "http://192.168.100.212:13000",
                   "status_passwd" => "changemetoo",
                   "admin_passwd" => "changemenow",
                   "name" => "Kannel Gateway 1"
                 ),
            );

/* some constants */
$CONST_QUEUE_ERROR = 100;

$depth = array();
$status = array();

/* set php internal error reporting level */
error_reporting(0); 

      /* loop through all configured URLs */
    foreach ($configs as $inst => $config) {

                
        $xml_parser = xml_parser_create();
        xml_set_element_handler($xml_parser, "startElement", "endElement");

        /* get the status.xml URL of one config */
        $url = $config["base_url"]."/status.xml?password=".$config["status_passwd"];

        $status[$inst] = "";

        /* open the file description to the URL */
        if (($fp = fopen($url, "r"))) {

            /* read the XML input */
            while (!feof($fp)) {  
                $status[$inst] .= fread($fp, 500000);
            }

        } else {
        }     
        
        fclose($fp);

        /* get the status of this bearerbox */


       /* lokesh		
        if (!xml_parse($xml_parser, $status[$url], feof($fp))) {
            die(sprintf("XML error: %s at line %d",
                xml_error_string(xml_get_error_code($xml_parser)),
                xml_get_current_line_number($xml_parser)));
        }
        */ 

        xml_parser_free($xml_parser);
  }



	//echo get_queued($inst,$status[$inst],$_REQUEST[smsc_id]);
	$response=get_queued($inst,$status[$inst],$_REQUEST[smsc_id]);
	if($response=='')
	$response=-1;
	echo $response;



?>
