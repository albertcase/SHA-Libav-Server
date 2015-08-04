<?php

class Libav {

	private $images;
	private $video_tpl;
	private $audio_tpl;
	private $config;

	public function __construct(array $images, $video_tpl, $audio_tpl, array $config = array()){
		$this->images = $images;
		$this->video_tpl = $video_tpl;
		$this->audio_tpl = $audio_tpl;
		$this->config = $config ? $config : array('video_rate' => '600k', 'audio_rate' => '48k', 'scale' => '404:720');
		$this->filename = md5(rand(0, 10000) . time());
 	}

	public function makeVideo(){
		$full_ts = $this->makeConcat();
		$mp3 = $this->getAudioTplResource();
		$generate = GENERATE . '/' . $this->filename . '_g.mp4';
		exec(AVCONV . ' -i ' . $mp3 . ' -i ' . $full_ts . ' -vf scale=' . $this->config['scale'] . ' -c:v libx264 -c:a libvo_aacenc -b:v ' . $this->config['video_rate'] . ' -b:a ' . $this->config['audio_rate']  . ' ' . $generate . ' 2>&1', $output);
		$this->cleanCache();
		return HOST . '/generate/' . $this->filename . '_g.mp4';
	}

	private function makeConcat(){
		$tpl_ts_list = $this->getVideoTplResource();
		$user_ts_list = $this->convertPngsToTs();
		$prepare = array();
		$counts = count($this->images) + 1;

		for($i = 0; $i < $counts; $i++) {
			if(isset($tpl_ts_list[$i]))
				$prepare[] = $tpl_ts_list[$i];
			if(isset($user_ts_list[$i]))
				$prepare[] = $user_ts_list[$i];
		}

		$concat = 'concat:' . implode('|', $prepare);
		$full_ts = CACHE . '/' . $this->filename . '_g.ts';
		exec(AVCONV . ' -i "' . $concat . '" -c copy ' . $full_ts . ' 2>&1', $output);
		return $full_ts;
	}

	private function convertPngsToTs($duration = '0.33'){
		$i = 1;
		$return = array();
		foreach($this->images as $image){
			$filename = $this->filename . '_' . $i;
			$img = CACHE . '/' . $filename . '.png';
			$ts = CACHE . '/' . $filename . '.ts';
			$data = base64_decode(preg_replace('/^data\:(.*)\;base64\,/', '', $image));
			file_put_contents($img, $data);
			exec(AVCONV . ' -loop 1 -i ' . $img . ' -r 25 -t ' . $duration . ' ' . $ts . ' 2>&1', $output);
			$return[] = $ts;
			$i++;
		}
		return $return;
	}

	private function getVideoTplResource(){
		$base_path = TEMPLATES . '/';
		$mapping = array(
			'vone' => 'one',
			'vtwo' => 'two',
			'vthree' => 'three',
			'vfour' => 'four',
			);
		$return = array();
		for($i = 1; $i <= count($this->images) + 1; $i++) {
			$return[] = TEMPLATES . '/' . $mapping[$this->video_tpl] . '/' . $i . '.ts';
		}
		return $return;
	}

	private function getAudioTplResource(){
		$base_path = TEMPLATES . '/audio';
		$mapping = array(
			'aone' => 'one',
			'atwo' => 'two',
			'athree' => 'three',
			'afour' => 'four',
			);
		return $base_path . '/' . $mapping[$this->audio_tpl] . '.mp3';
	}

	private function cleanCache(){
		$counts = count($this->images);
		for($i = 1; $i <= $counts; $i++) {
			unlink(CACHE . '/' . $this->filename . '_' . $i . '.png');
			unlink(CACHE . '/' . $this->filename . '_' . $i . '.ts');
		}
		unlink(CACHE . '/' . $this->filename . '_g.ts');
	}

}

?>