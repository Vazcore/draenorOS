<?php
require_once "Config.php";
require_once "Bd.php";

class HardDrive{
	private $total_space = Config::DISK_SPACE;
	private $cluster_size = Config::CLUSTER_SPACE;
	
	private $bd;

	function __construct(){
		$base = new Bd();
		$this->bd = $base->get_connection();
	}

	function init(){
		// Очистка БД таблиц
		$this->bd->query("TRUNCATE TABLE os_clusters");
		$this->bd->query("TRUNCATE TABLE os_nodes");
		// End truncate

		for ($i=1; $i <= $this->get_total_clusters(); $i++) { 
			if($i <= ceil(Config::OS_SIZE/Config::CLUSTER_SPACE)){
				$type = "S";
			}else{
				$type = "U";
			}
			$this->bd->query("INSERT INTO os_clusters (type,link,cluster_id,data) VALUES ('$type', '0', '$i', 'None') ");	
		}
	}
	
	
	function get_total_clusters() {
		return $this->total_space/$this->cluster_size;
	}
	
	function get_free_space(){
		// Bit Map
		// + os place
		$fr_s = $this->total_space - Config::OS_SIZE;
		return $fr_s;		
	}
	
	function get_home_dir(){
		$h_d = Config::OS_SIZE/$this->cluster_size + 1;
		return $h_d;
	}
}
?>