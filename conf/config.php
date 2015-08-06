<?php

define("HOST","http://127.0.0.1:9042");

define("AVCONV", "/usr/bin/avconv");
define("TEMPLATES", dirname(__FILE__) . '/../templates');
define("GENERATE", dirname(__FILE__) . '/../generate');
define("CACHE", dirname(__FILE__) . '/../cache');


define("SCALE", '404:720');
define("VRATE", '600k');
define("ARATE", '48k');


function __autoload($class_name) {
    if(file_exists(dirname(__FILE__) . '/../lib/' . $class_name . '.php')) 
    	require_once dirname(__FILE__) . '/../lib/' . $class_name . '.php';
}

?>