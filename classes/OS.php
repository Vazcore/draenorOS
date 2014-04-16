<?php
require_once "Draenor.php";

class OS extends Draenor{	

	//structura
	private $start_cluster;
	private $end_cluster;
	// end structura

	function __construct(){
		// code
		parent::__construct();
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
		$this->end_cluster = ceil($this->settings->os_size/$this->settings->cluster_space);		
		
		// Фрагментация системы и реинициализация
		$this->hd->init();

		// Запись системных данных		
		$this->createNode("S","F","draenor.sys","-1");		

		$this->createNode("U","D","home","0");
		return " успешно!";

	}

	function alreadyExists($name, $parent){
		$res = $this->database->link()->query("SELECT name FROM os_nodes WHERE parent = '$parent' AND name = '$name' ");	
		if($res->num_rows != 0){
			return true;
		}else{
			return false;
		}
	}


	function createNode($type, $file_kind, $name, $location){		
		
		if($file_kind == "D"){
			$f_k = "каталог";			
		}else{
			$f_k = "файл";
		}
		
			if($type == "S"){
				$sf = $this->sf->init($name, $location);				
			}elseif ($type == "U") {
				// Проверка на существование файла(каталога)
				if(!$this->alreadyExists($name, $location)){
					if($file_kind == "D"){
					// Dir						
						$ud = $this->dir->init($name, $location);
					}elseif($file_kind == "RD"){
						// Домашняя директория пользователя
						$urd = $this->user->createHomeDir($name, $location);
						return $urd;	
					}else{
						// File						
						$uf = $this->fil->init($name, $location);						
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
		$res = $this->database->link()->query("SELECT begin FROM os_nodes WHERE parent = '$p_id' AND name = '$dir' ");
		$row = $res->fetch_array();
		$cl_id = $row['begin'];


		$res = $this->database->link()->query("SELECT data FROM os_clusters WHERE cluster_id = '$cl_id' ");
		$row = $res->fetch_array();
		if($row['data'] != "None"){
			return "Директория не пуста!";
		}else{
			$res = $this->database->link()->query("UPDATE os_clusters SET status='free' WHERE cluster_id = '$cl_id' ");
			$res = $this->database->link()->query("SELECT data FROM os_clusters WHERE cluster_id = '$p_id' ");
			$row = $res->fetch_array();
			$data = $row['data'];
			$pos_id = strpos($data, $cl_id);
			$ln = strlen($data);
			for ($i=$pos_id; $i <= $pos_id+$ln; $i++) { 
				$data[$i] = "";
			}
			$res = $this->database->link()->query("UPDATE os_clusters SET data='$data' WHERE cluster_id = '$p_id' ");
			$res = $this->database->link()->query("DELETE FROM os_nodes WHERE parent = '$p_id' AND name = '$dir' ");
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
				break;
			}
		}
		if(!$find_status){
			return "Ошибка! Директория с таким названием не найдена!";
		}else{			
			$user_id =  $_SESSION['user_id'];
			$res = $this->database->link()->query("SELECT file_kind, name FROM os_nodes WHERE begin = '$dir_id' LIMIT 1 ");
			$row = $res->fetch_array();
			if($row['file_kind'] == 'D'){
				$this->database->link()->query("UPDATE os_users SET location_id='$dir_id' WHERE id = '$user_id' ");
				return "Совершен переход в директорию ".$dir_to;
			}elseif($row['file_kind'] == "RD"){
				$user_info = $this->user->getUser($user_id);
				if($user_info['name'] != $row['name'] AND $user_info['role'] != "Admin"){
					return "Ошибка! Доступ к рабочему окружению другого пользователя закрыт!";
				}else{
					$this->database->link()->query("UPDATE os_users SET location_id='$dir_id' WHERE id = '$user_id' ");
					return "Совершен переход в директорию ".$dir_to;
				}
			}else{
				return "Ошибка! Невозможен переход по файлу!";
			}
		}
	}

	function moveBack($d_id){
		$res = $this->database->link()->query("SELECT parent FROM os_nodes WHERE begin = '$d_id' ");	
		$row = $res->fetch_array();
		if($row['parent'] == 0){
			return "Ошибка! Вы находитесь в корневой директории!";
		}else{
			$p_id = $row['parent'];
			$user_id =  $_SESSION['user_id'];
			$this->database->link()->query("UPDATE os_users SET location_id='$p_id' WHERE id = '$user_id' ");	
			return "Вы успешно переместились в директорию - ".$this->nav->whereIam();
		}
	}

	private function get_file_data($begin_cluster){
		$file_data = "Пустой файл";
		$cluster = $begin_cluster;
		while ($cluster != 0) {
			$res = $this->database->link()->query("SELECT * FROM os_clusters WHERE cluster_id = '$cluster' LIMIT 1 ");
			$row = $res->fetch_array();
			if($row['data'] != "None"){
				$file_data = $row['data'];			
			}
			$cluster = $row['link'];
		}
		return $file_data;		
	}

	function open_file($f_name, $location_id){
		$res = $this->database->link()->query("SELECT * FROM os_nodes WHERE parent = '$location_id' AND name = '$f_name' AND file_kind = 'F' LIMIT 1 ");
		if($res->num_rows != 0){			
			$row = $res->fetch_array();
			$begin_cluster = $row['begin'];
			$file_data = $this->get_file_data($begin_cluster);
			return $this->fil->open_file_form($file_data, $f_name, $begin_cluster);
		}else{
			return "Ошибка! Нет такого файла!";
		}		
	}

	function write_to_file($data, $cluster_id){
		$res = $this->database->link()->query("UPDATE os_clusters SET data = '$data' WHERE cluster_id = '$cluster_id' ");
	}

	function addUser($name, $pass){
		$role = $this->user->getUserInfo();
		if($role['role'] != "Admin"){
			return "Ошибка! Отказано в доступе!";
		}else{
			$res = $this->database->link()->query("SELECT name FROM os_users WHERE name = '$name' ");
			if($res->num_rows != 0){
				return "Ошибка! Такой пользователь уже существует!";
			}else{
				$user_work_area = $this->createNode('U', 'RD', $name, (($this->settings->os_size/$this->settings->cluster_space)+1));
				
				$res = $this->database->link()->query("INSERT INTO os_users (name,pass,role,home,location_id,status) VALUES ('$name', '$pass','User', '$user_work_area', '$user_work_area','0') ");
				return " Пользователь ".$name." успешно создан!";
			}
		}
	}

}
?>