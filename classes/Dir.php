<?php

require_once "OS.php";
require_once "Bd.php";
require_once "BitMap.php";

class Dir{

	function __construct($name,$location){
		$base = new Bd();
		$os = new OS();
		$bd  = $base->get_connection();

		$bm = new BitMap();
		$id = $bm->getCluster("U");

		$date = date("d-m-Y");
		$type = "U";
		$file_kind = "D";
		$access = "7-7-5";
		$user_id = $_SESSION['user_id'];

		if($id){
			$atrs = array($name,$location,($id+0), $date, $type, $file_kind, $access);
			$size = $os->calcSize($atrs);
			$bd->query("INSERT INTO os_nodes (type,file_kind,access,begin,size,name,parent,date,creator) VALUES ('$type','$file_kind','$access','$id', '$size','$name',$location,'$date','$user_id') ");
			$bd->query("UPDATE os_clusters SET type = '$type', status='busy' WHERE cluster_id='$id' ");
			if($location != "0" && $location != "-1"){
				$res = $bd->query("SELECT data FROM os_clusters WHERE cluster_id = '$location' ");
				$row = $res->fetch_array();
				if($row['data'] == "None"){
					$path = $id;
				}else{
					$path = $row['data'].";".$id;
				}
				$bd->query("UPDATE os_clusters SET data = '$path' WHERE cluster_id='$location' ");
			}
		}else{
			echo "Ошибка! Нет места на диске!";
		}

	}
}

?>