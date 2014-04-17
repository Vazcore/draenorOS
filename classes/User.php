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
			$res = $this->database->link()->query("SELECT name, home, role, location_id FROM os_users WHERE id = '$id' ");
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
					$user_desktop = $row['home'];
					$res = $this->database->link()->query("UPDATE os_users SET status = '1', location_id = '$user_desktop' WHERE id = '$this->user_id' ");
					echo "Добро пожаловать, ".$this->user_name;
					return $this->user_name;
				}else{
					echo "Ошибка! Комбинация имя пользователя и пароль - не совпадают!";
				}				
			}else{
				echo "Ошибка! Введите имя пользователя и пароль!";
			}
		}else{
			if($command == "wlogin"){
				echo "Введите имя пользователя и пароль!";	
			}else{
				echo "Требуется пройти процесс авторизации пользователя!";
			}
		}	
		
	}

	function log_out(){
		$res = $this->database->link()->query("UPDATE os_users SET status = '0' WHERE id = '$this->user_id' ");
		unset($_SESSION['user_id']);
		session_destroy();		
	}

	function createHomeDir($name, $location){
		$id = $this->bm->getCluster("U");

		$date = date("d-m-Y");
		$type = "U";
		$file_kind = "RD";
		$access = "7-5-5";
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
				return $id;
			}
		}else{
			return "Ошибка! Нет места на диске!";
		}
	}
}
?>