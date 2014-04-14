<?php
require_once "Draenor.php";

class BitMap extends Draenor{
	private $bd;

	function __construct(){
		// code
	}

	function getCluster($type){
		if($type == "S"){
			$from_cluster = 1;
			$s_clusters = ceil($this->settings->os_size/$this->settings->cluster_space);
		}else{
			$from_cluster = ceil($this->settings->os_size/$this->settings->cluster_space) + 1;			
			$s_clusters = ceil($this->settings->disk_space/$this->settings->cluster_space);			
		}		
		$res = $this->database->link()->query("SELECT * FROM os_clusters WHERE (type = '$type' AND (cluster_id BETWEEN $from_cluster AND $s_clusters)) AND status = 'free' ");
		if($res->num_rows == 0){
			return false;
		}else{
			$row = $res->fetch_array();
			return $row['cluster_id'];
		}
	}
}

?>