<?php
require_once "User.php";
require_once "HardDrive.php";
require_once "Bd.php";
require_once "Config.php";

class Navigation {
	
	public $path;
	private $user;
	private $hd;
	private $bd;
	
	function __construct(){
		$this->user = new User;
		$this->hd = new HardDrive();		
		$base = new Bd();
		$this->bd  = $base->get_connection();
	}
		
	function whereIam($variant){
		$user_id = $_SESSION['user_id'];
		$res = $this->bd->query("SELECT location_id FROM os_users WHERE id='$user_id' ");
		$row = $res->fetch_array();
		$loc_id = $row['location_id'];
		
		if($variant == "id"){
			return $loc_id;
		}else{			
			$res = $this->bd->query("SELECT * FROM os_nodes WHERE begin='$loc_id' ");
			$row = $res->fetch_array();
			$this->path = "/".$row['name'];				
			return $this->path;				
		}
	}
}
?>