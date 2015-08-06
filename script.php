<?php

require_once dirname(__FILE__) . "/conf/config.php";



$vinputs = array(
	'one' => array('1', '2', '3', '4'),
	);

$ainputs = array('one', 'two', 'three');

foreach($vinputs as $tpl => $input) {
	foreach($input as $filename) {
		$mp4 = TEMPLATES . '/' . $tpl . '/' . $filename . '.mp4';
		$ts = TEMPLATES . '/' . $tpl . '/' . $filename . '.ts';
		exec(AVCONV . ' -i ' . $mp4 . ' -map 0:1 -vf scale=' . SCALE . ' -c:v libx264 -b:v ' . VRATE . ' -y ' . $ts . " 2>&1", $output);
		var_dump($output);
	}
}

foreach($ainputs as $filename) {
		$mp3 = TEMPLATES . '/audio/' . $filename . '.mp3';
		$m4a = TEMPLATES . '/audio/' . $filename . '.m4a';
		exec(AVCONV . ' -i ' . $mp3 . ' -c:a libvo_aacenc -b:a ' . ARATE . ' -y ' . $m4a . " 2>&1", $output);
		var_dump($output);
}



?>