<?php
require_once "Draenor.php";

class ListCommand extends Draenor{
	private $allInfo;
	private $Settings;	
	private $desc;
	
	
	function __construct(){
		// code
	}

	function init($command){
		$this->allInfo = $command;
		$this->desc = $command['desc'];				
	}
	
	// Общее дискоквое пространство
	function os_wds(){		
		return $this->desc." : ".$this->settings->disk_space;
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
			return $this->desc." : ".$this->os->createNode("U","F", $this->allInfo[1], $this->nav->whereIam("id"));
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
		return $this->desc." : ".$this->settings->cluster_space;		
	}

	function os_wos_init(){
		$role = $this->user->getUserInfo();
		if($role['role'] != "Admin"){
			return "Ошибка! Отказано в доступе!";
		}else{
			return $this->desc.":".$this->os->os_init();
		}
	}

	// Создание директории
	function os_wcrd(){
		if(!isset($this->allInfo[1]) OR trim($this->allInfo[1]) == ""){
			echo "Ошибка! Не указано имя каталога";			
		}else{
			return $this->os->createNode("U", "D", $this->allInfo[1], $this->nav->whereIam("id"));			
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

	function os_wof(){
		if(!isset($this->allInfo[1]) OR trim($this->allInfo[1]) == ""){
			echo "Ошибка! Не указано имя файла для открытия";
			return false;
		}else{
			$local_dir_id = $this->nav->whereIam("id");			
			return $this->desc.":".$this->os->open_file($this->allInfo[1], $local_dir_id);
		}		
	}

	function os_wadduser(){
		if(!isset($this->allInfo[2]) OR trim($this->allInfo[2]) == ""){
			return "Ошибка! Не указан пароль для пользователя!";			
		}			
		if(!isset($this->allInfo[1]) OR trim($this->allInfo[1]) == ""){
			return "Ошибка! Не указано имя пользователя!";			
		}else{
			return $this->desc.":".$this->os->addUser($this->allInfo[1], $this->allInfo[2]);
		}					
	}

}
?>