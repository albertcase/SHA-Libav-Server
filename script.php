<?php

require_once dirname(__FILE__) . "/conf/config.php";



$vinputs = array(
	'one' => array('1', '2', '3', '4'),
	'two' => array('1', '2', '3', '4'),
	'three' => array('1', '2', '3', '4'),
	);

$ainputs = array('one', 'two', 'three');

$origin_video = array(1, 2, 3);

foreach($origin_video as $filename) {
	$source = TEMPLATES . '/' . $filename . '.mov';
	$mp4 = TEMPLATES . '/' . $filename . '.mp4';
	exec(AVCONV . ' -i ' . $source . ' -vf scale=' . SCALE . ' -c:v libx264 -b:v ' . VRATE . ' -c:a libvo_aacenc -b:a ' . ARATE . ' -y ' . $mp4 . " 2>&1", $output);
	var_dump($output);
}

foreach($vinputs as $tpl => $input) {
	foreach($input as $filename) {
		$source = TEMPLATES . '/' . $tpl . '/' . $filename . '.mov';
		$ts = TEMPLATES . '/' . $tpl . '/' . $filename . '.ts';
		exec(AVCONV . ' -i ' . $source . ' -map 0:0 -vf scale=' . SCALE . ' -c:v libx264 -b:v ' . VRATE . ' -y ' . $ts . " 2>&1", $output);
		var_dump($output);
	}
}

foreach($ainputs as $filename) {
		$source = TEMPLATES . '/audio/' . $filename . '.wav';
		$m4a = TEMPLATES . '/audio/' . $filename . '.m4a';
		exec(AVCONV . ' -i ' . $source . ' -c:a libvo_aacenc -b:a ' . ARATE . ' -y ' . $m4a . " 2>&1", $output);
		var_dump($output);
}

?>