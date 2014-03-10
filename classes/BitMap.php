<?php
require_once "Bd.php";
require_once "Config.php";

class BitMap{
	private $bd;

	function __construct(){
		$base = new Bd();
		$this->bd  = $base->get_connection();
	}

	function getCluster($type){
		if($type == "S"){
			$from_cluster = 1;
			$s_clusters = ceil(Config::OS_SIZE/Config::CLUSTER_SPACE);
		}else{
			$from_cluster = ceil(Config::OS_SIZE/Config::CLUSTER_SPACE) + 1;			
			$s_clusters = ceil(Config::DISK_SPACE/Config::CLUSTER_SPACE);			
		}		
		$res = $this->bd->query("SELECT * FROM os_clusters WHERE (type = '$type' AND (cluster_id BETWEEN $from_cluster AND $s_clusters)) AND status = 'free' ");
		if($res->num_rows == 0){
			return false;
		}else{
			$row = $res->fetch_array();
			return $row['cluster_id'];
		}
	}
}

?>