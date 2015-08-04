<?php

require_once dirname(__FILE__) . "/conf/config.php";

$livav = new Libav($_POST['images'], $_POST['video_tpl'], $_POST['audio_tpl'], array('video_rate' => '600k', 'audio_rate' => '48k', 'scale' => '404:720'));
$video = $livav->makeVideo();

print json_encode(array('status' => 1, 'src' => $video));

?>