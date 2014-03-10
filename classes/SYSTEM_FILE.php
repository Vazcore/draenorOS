<?php

require_once "OS.php";
require_once "Bd.php";
require_once "BitMap.php";

	class SYSTEM_FILE{
		private $os;

		private $name;
		private $date;
		private $parent;
		private $begin;

		function __construct($name, $parent){
			$this->os = new OS();
			$base = new Bd();
			$this->bd  = $base->get_connection();

			$bm = new BitMap();

			$id = $bm->getCluster("S");
			
			if($id){
				$this->name = $name;
				$this->parent = $parent;
				$this->date = date("d-m-Y");
				$this->begin = $id;
				$type = "S";
				$file_kind = "F";
				$access = "0-0-0";


				$atrs = array($name,$parent,($id+0), $this->date, $type, $file_kind, $access);

				$size = $this->os->calcSize($atrs);

				$this->bd->query("INSERT INTO os_nodes (type,file_kind,access,begin,size,name,date) VALUES ('S','F','0-0-0','$id', '$size','$name','$this->date') ");
				$this->bd->query("UPDATE os_clusters SET type = 'S', status='busy' WHERE cluster_id='$id' ");
			}else{
				echo "Ошибка! Нет места на диске!";
			}
		}
	}
?>