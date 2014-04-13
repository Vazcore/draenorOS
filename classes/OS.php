<?php
require_once "Settings.php";
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
		$this->nav = new Navigation();		
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
		$this->end_cluster = ceil(Settings::OS_SIZE/Settings::CLUSTER_SPACE);		
		
		$this->hd = new HardDrive();
		$this->bm = new BitMap();

		// Фрагментация системы и реинициализация
		$this->hd->init();

		// Запись системных данных		
		$this->createNode("S","F","draenor.sys","-1");		

		$this->createNode("U","D","home","0");

	}

	function alreadyExists($name, $parent){
		$res = $this->bd->query("SELECT name FROM os_nodes WHERE parent = '$parent' AND name = '$name' ");	
		if($res->num_rows != 0){
			return true;
		}else{
			return false;
		}
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
				$sf = new SYSTEM_FILE($name, $location);
			}elseif ($type == "U") {
				// Проверка на существование файла(каталога)
				if(!$this->alreadyExists($name, $location)){
					if($file_kind == "D"){
					// Dir
						$ud = new Dir($name, $location);
					}else{
						// File
					}
				}else{
					return "Ошибка! С таким именем уже существует!";
				}
			}
		
	}

	function bd_select($table, $filter = array()){
		// in Future
	}

	function removeDir($p_id, $dir){
		$res = $this->bd->query("SELECT begin FROM os_nodes WHERE parent = '$p_id' AND name = '$dir' ");
		$row = $res->fetch_array();
		$cl_id = $row['begin'];


		$res = $this->bd->query("SELECT data FROM os_clusters WHERE cluster_id = '$cl_id' ");
		$row = $res->fetch_array();
		if($row['data'] != "None"){
			return "Директория не пуста!";
		}else{
			$res = $this->bd->query("UPDATE os_clusters SET status='free' WHERE cluster_id = '$cl_id' ");
			$res = $this->bd->query("SELECT data FROM os_clusters WHERE cluster_id = '$p_id' ");
			$row = $res->fetch_array();
			$data = $row['data'];
			$pos_id = strpos($data, $cl_id);
			$ln = strlen($data);
			for ($i=$pos_id; $i <= $pos_id+$ln; $i++) { 
				$data[$i] = "";
			}
			$res = $this->bd->query("UPDATE os_clusters SET data='$data' WHERE cluster_id = '$p_id' ");
			$res = $this->bd->query("DELETE FROM os_nodes WHERE parent = '$p_id' AND name = '$dir' ");
			return " успешно выполнено";
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

	function moveToDir($dir_to, $dirs){
		$find_status = false;
		foreach ($dirs as $key => $dir) {
			if($dir_to == $dir['name']){
				$find_status = true;
				$dir_id = $dir['begin'];
			}
		}
		if(!$find_status){
			return "Ошибка! Директория с таким названием не найдена!";
		}else{			
			$user_id =  $_SESSION['user_id'];
			$this->bd->query("UPDATE os_users SET location_id='$dir_id' WHERE id = '$user_id' ");
		}
	}

	function moveBack($d_id){
		$res = $this->bd->query("SELECT parent FROM os_nodes WHERE begin = '$d_id' ");	
		$row = $res->fetch_array();
		if($row['parent'] == 0){
			return "Ошибка! Вы находитесь в корневой директории!";
		}else{
			$p_id = $row['parent'];
			$user_id =  $_SESSION['user_id'];
			$this->bd->query("UPDATE os_users SET location_id='$p_id' WHERE id = '$user_id' ");	
			return "Вы успешно переместились в директорию - ".$this->nav->whereIam();
		}
	}

}
?>