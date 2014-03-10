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

		if($id){
			$atrs = array($name,$location,($id+0), $date, $type, $file_kind, $access);
			$size = $os->calcSize($atrs);
			$bd->query("INSERT INTO os_nodes (type,file_kind,access,begin,size,name,date) VALUES ('$type','$file_kind','$access','$id', '$size','$name','$date') ");
			$bd->query("UPDATE os_clusters SET type = '$type', status='busy' WHERE cluster_id='$id' ");
		}else{
			echo "Ошибка! Нет места на диске!";
		}

	}
}

?>