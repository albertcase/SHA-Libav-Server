<?php

require_once dirname(__FILE__) . "/conf/config.php";

        $data = array(
                'images' => array(
                        base64_encode(file_get_contents('/vagrant/video_server/demo/4.png')),
                        base64_encode(file_get_contents('/vagrant/video_server/demo/5.png')),
                        base64_encode(file_get_contents('/vagrant/video_server/demo/6.png')),
                        ),
                'tpl_no' => 'one',
                 );
        
$mapping = array(
	'one' => DURATION_ONE,
	'two' => DURATION_TWO,
	'three' => DURATION_THREE,
);
$livav = new Libav($_POST['images'], $_POST['tpl_no'], $mapping[$_POST['tpl_no']]);
$video = $livav->makeVideo();

print json_encode(array('status' => 1, 'src' => $video));


?>
