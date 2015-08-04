<?php

require_once dirname(__FILE__) . "/conf/config.php";



$inputs = array(
	'one' => array('1', '2', '3', '4'),
	);

foreach($inputs as $tpl => $input) {
	foreach($input as $filename) {
		$mp4 = TEMPLATES . '/' . $tpl . '/' . $filename . '.mp4';
		$ts = TEMPLATES . '/' . $tpl . '/' . $filename . '.ts';
		exec(AVCONV . ' -y -i ' . $mp4 . ' -map 0:1 -c:v mpeg2video -b:v 10000k ' . $ts . " 2>&1", $output);
		var_dump($output);
	}
}



?>