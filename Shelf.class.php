<?php
	class Shelf {
		public $useCache = true;
		private $serverFilename;
		private $cacheFolder;
		private $cacheFilePath;
		private $cacheFile;

		public function __construct(){
			$this->serverFilename = $_SERVER['SCRIPT_FILENAME'];
			if(sizeof($_GET) > 0 || sizeof($_POST) > 0){
				$this->useCache = false;
			}
			ob_start();
		}

		public function write_cache(){
			$this->cacheFile = fopen($this->cacheFilePath, 'w');
			fwrite($this->cacheFile, ob_get_contents());
			fclose($this->cacheFile);
			ob_end_flush(); # Send the output to the browser
		}

		public function read_cache(){
			if (file_exists($this->cacheFilePath) && time() - $cachetime < filemtime($this->cacheFilePath)) {
				echo "<!-- Cached copy, generated ".date('H:i', filemtime($this->cacheFilePath))." -->\n";
				readfile($this->cacheFilePath);
				exit;
			}
		}
	}
?>