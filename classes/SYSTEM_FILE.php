<?php

require_once "Draenor.php";

class SYSTEM_FILE extends Draenor{
		
	private $name;
	private $date;
	private $parent;
	private $begin;

	function __construct(){
		// code
		parent::__construct();
	}

	function init($name, $parent){
		
		$id = $this->bm->getCluster("S");
		
		if($id){
			$this->name = $name;
			$this->parent = $parent;
			$this->date = date("d-m-Y");
			$this->begin = $id;
			$type = "S";
			$file_kind = "F";
			$access = "0-0-0";
			$user_id = $_SESSION['user_id'];

			echo "INIT";
			$atrs = array($name,$parent,($id+0), $this->date, $type, $file_kind, $access);
			$size = $this->os->calcSize($atrs);

			$this->database->link()->query("INSERT INTO os_nodes (type,file_kind,access,begin,size,name,parent,date,creator) VALUES ('S','F','0-0-0','$id', '$size','$name', $parent, '$this->date','$user_id') ");
			$this->database->link()->query("UPDATE os_clusters SET type = 'S', status='busy' WHERE cluster_id='$id' ");
		}else{
			echo "Ошибка! Нет места на диске!";
		}
	}
}

?>