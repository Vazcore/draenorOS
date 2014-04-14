<?php

require_once "Draenor.php";

class Dir extends Draenor{

	function __construct(){
		// code
		parent::__construct();
	}

	function init($name,$location){
		$id = $this->bm->getCluster("U");

		$date = date("d-m-Y");
		$type = "U";
		$file_kind = "D";
		$access = "7-7-5";
		$user_id = $_SESSION['user_id'];

		if($id){
			$atrs = array($name,$location,($id+0), $date, $type, $file_kind, $access);
			$size = $this->os->calcSize($atrs);
			$this->database->link()->query("INSERT INTO os_nodes (type,file_kind,access,begin,size,name,parent,date,creator) VALUES ('$type','$file_kind','$access','$id', '$size','$name',$location,'$date','$user_id') ");
			$this->database->link()->query("UPDATE os_clusters SET type = '$type', status='busy' WHERE cluster_id='$id' ");
			if($location != "0" && $location != "-1"){
				$res = $this->database->link()->query("SELECT data FROM os_clusters WHERE cluster_id = '$location' ");
				$row = $res->fetch_array();
				if($row['data'] == "None"){
					$path = $id;
				}else{
					$path = $row['data'].";".$id;
				}
				$this->database->link()->query("UPDATE os_clusters SET data = '$path' WHERE cluster_id='$location' ");
			}
		}else{
			echo "Ошибка! Нет места на диске!";
		}
	}
}

?>