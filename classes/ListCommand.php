<?php
require_once "Settings.php";
require_once "HardDrive.php";
require_once "Navigation.php";
require_once "User.php";
require_once "OS.php";

class ListCommand {
	private $allInfo;
	private $Settings;	
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
		return $this->desc." : ".Settings::DISK_SPACE;
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
		if(!isset($this->allInfo[1]) OR trim($this->allInfo[1]) == ""){
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
		return $this->desc." : ".$this->nav->whereIam("none");	
	}

	// Выйти из системы
	function os_wlogout(){
		return $this->desc." : ".$this->user->log_out();	
	}

	function os_wcluster_size(){
		return $this->desc." : ".Settings::CLUSTER_SPACE;		
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
		if(!isset($this->allInfo[1]) OR trim($this->allInfo[1]) == ""){
			echo "Ошибка! Не указано имя каталога";			
		}else{
			return $this->desc." : ".$this->os->createNode("U", "D", $this->allInfo[1], $this->nav->whereIam("id"));			
		}
	}

	// Удаление директории
	function os_wrmd(){
		$parent_dir_id = $this->nav->whereIam("id");
		if(!isset($this->allInfo[1]) OR trim($this->allInfo[1]) == ""){
			echo "Ошибка! Не указано имя каталогя для удаления";
		}else{
			return $this->desc." : ".$this->os->removeDir($parent_dir_id, $this->allInfo[1]);
		}		
	}

	// Просмотр содержимвого директории
	function os_wls(){
		$dir_id = $this->nav->whereIam("id");
		return $this->desc."<font color='green'>".$this->nav->whereIam()."</font> : ".$this->hd->showWhatInDir($dir_id);
	}

	// Переход в указанную директорию
	function os_wgo(){
		$parent_dir_id = $this->nav->whereIam("id");
		if(!isset($this->allInfo[1]) OR trim($this->allInfo[1]) == ""){
			echo "Ошибка! Не указано имя каталогя для перехода";
		}else{
			$dirs = $this->hd->showWhatInDir($parent_dir_id, "dirs");		
			return $this->os->moveToDir($this->allInfo[1], $dirs);
		}		
	}

	function os_wgoback(){
		$local_dir_id = $this->nav->whereIam("id");
		return $this->os->moveBack($local_dir_id);
	}

}
?>