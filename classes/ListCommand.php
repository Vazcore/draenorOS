<?php
require_once "Config.php";
require_once "HardDrive.php";
require_once "Navigation.php";
require_once "User.php";
require_once "OS.php";

class ListCommand {
	private $allInfo;
	private $config;	
	private $desc;
	private $hd;
	private $nav;
	private $user;
	private $os;
	
	function __construct($command){
		$this->allInfo = $command;
		$this->desc = $command['desc'];
		$this->hd = new HardDrive();
		$this->nav = new Navigation();
		$this->user = new User();
		$this->os = new OS();
	}
	
	// Общее дискоквое пространство
	function os_wds(){		
		return $this->desc." : ".Config::DISK_SPACE;
	}
	
	// Очистить окно дисплея консоли
	function os_wclear(){
		return $this->desc;		
	}

	// Общее количество кластеров
	function os_wtcls(){
		return $this->desc." : ".$this->hd->get_total_clusters();
	}
	
	// Создать файл
	function os_wcrf(){
		if(!isset($this->allInfo[1])){
			echo "Ошибка! Не указано имя файла";
		}else{
			//
		}
	}
	
	// Свободное место на диске
	function os_wfrs(){
		return $this->desc." : ".$this->hd->get_free_space();
	}

	// Текущее расположение пользователя
	function os_wpath(){
		return $this->desc." : ".$this->nav->whereIam();	
	}

	// Выйти из системы
	function os_wlogout(){
		return $this->desc." : ".$this->user->log_out();	
	}

	function os_wcluster_size(){
		return $this->desc." : ".Config::CLUSTER_SPACE;		
	}

	function os_wos_init(){
		$role = $this->user->getUserInfo();
		if($role['role'] != "Admin"){
			echo "Отказано в доступе!";
		}else{
			$this->os->os_init();
		}
	}

	// Создание директории
	function os_wcrd(){
		if(!isset($this->allInfo[1])){
			echo "Ошибка! Не указано имя каталога";
		}else{
			
		}
	}

}
?>