<?php
require_once "Draenor.php";

class User extends Draenor{
	private $user_id;
	public $user_name = "Неизвестный";
	public $user_role;
	public $user_loc;	
	
	function __construct(){
		//$this->init();		
		parent::__construct();		
	}

	function getUserInfo(){		
		if(isset($_SESSION['user_id'])){
			$id = $_SESSION['user_id'];
			$res = $this->database->link()->query("SELECT name, role, location_id FROM os_users WHERE id = '$id' ");
			$row = $res->fetch_array();
		}else{
			$row = array("name" => "Неизвестный", "role" => "Требуется войти в систему");
		}		
		return $row;
	}

	function getUser($id){		
			$res = $this->database->link()->query("SELECT name, role, location_id FROM os_users WHERE id = '$id' ");
			$row = $res->fetch_array();
		
		return $row;
	}

	function login_user($command){
		$homeDir = $this->hd->get_home_dir();	

		if(preg_match("/ /", $command)){
			$parts = explode(" ", $command);
			if(($parts[0] == "wlogin" && isset($parts[1])) && isset($parts[2])){
				$res = $this->database->link()->query("SELECT * FROM os_users WHERE name = '$parts[1]' AND pass = '$parts[2]' ");
				if($res->num_rows != 0){
					$row = $res->fetch_array();
					$_SESSION['user_id'] = $row['id'];	
					$this->user_id = $row['id'];		
					$this->user_name = $row['name'];
					$this->user_role = $row['role'];
					$this->user_loc = $row['location_id'];				
					$res = $this->database->link()->query("UPDATE os_users SET status = '1', location_id = '$homeDir' WHERE id = '$this->user_id' ");
					return $this->user_name;
				}else{
					return false;
				}				
			}else{
				return false;
			}
		}	
		
	}

	function log_out(){
		$res = $this->database->link()->query("UPDATE os_users SET status = '0' WHERE id = '$this->user_id' ");
		unset($_SESSION['user_id']);
		session_destroy();		
	}
}
?>