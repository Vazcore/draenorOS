<?php
require_once "Config.php";
require_once "HardDrive.php";
require_once "Bd.php";
require_once "User.php";
require_once "ListCommand.php";
require_once "Navigation.php";
require_once "BitMap.php";

class OS{
	protected $bd;
	protected $user;
	protected $hd;
	protected $lc;
	protected $nav;
	protected $bm;

	//structura
	private $start_cluster;
	private $end_cluster;
	// end structura

	function __construct(){
		$base = new Bd();
		$this->bd = $base->get_connection();			
	}
	
	/*
	function init(){
		$base = new Bd();
		$this->bd = $base->get_connection();
		
		$this->user = new User();
		
		$this->hd = new HardDrive();
		
		$this->lc = new ListCommand();
		
		$this->nav = new Navigation();
	}
	*/


	function os_init(){
		$this->start_cluster = 1;
		$this->end_cluster = ceil(Config::OS_SIZE/Config::CLUSTER_SPACE);		
		
		$this->hd = new HardDrive();
		$this->bm = new BitMap();

		// Фрагментация системы и реинициализация
		$this->hd->init();

		// Запись системных данных		
		$this->createNode("S","F","draenor.sys","sys");		

		$this->createNode("U","D","home","/");

	}


	function createNode($type, $file_kind, $name, $location){
		require_once "SYSTEM_FILE.php";
		//require_once "File.php";
		require_once "Dir.php";
		
		if($file_kind == "D"){
			$f_k = "каталог";
		}else{
			$f_k = "файл";
		}
		
			if($type == "S"){
				$sf = new SYSTEM_FILE($name, "sys");
			}elseif ($type == "U") {
				if($file_kind == "D"){
					// Dir
					$ud = new Dir($name, $location);
				}else{
					// File
				}
			}
		
	}

	function calcSize($attrs){
		$size = 0;

		foreach ($attrs as $key => $value) {
			if(is_numeric($value)){
				$size = $size + 4;
			}else{
				$size = $size + iconv_strlen($value);
			}
		}
		return $size;
	}

}
?>