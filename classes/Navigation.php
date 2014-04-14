<?php
require_once "Draenor.php";

class Navigation extends Draenor{
	
	public $path;	
	
	function __construct(){
		// Code
	}
		
	function whereIam($variant = "none"){
		$user_id = $_SESSION['user_id'];
		$res = $this->database->link()->query("SELECT location_id FROM os_users WHERE id='$user_id' ");
		$row = $res->fetch_array();
		$loc_id = $row['location_id'];
		
		if($variant == "id"){
			return $loc_id;
		}else{			
			$res = $this->database->link()->query("SELECT * FROM os_nodes WHERE begin='$loc_id' ");
			$row = $res->fetch_array();
			$this->path = "/".$row['name'];				
			return $this->path;				
		}
	}
}
?>