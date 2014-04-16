<?php
require_once "Draenor.php";

class Commands extends Draenor{
	
	function __construct(){		
		parent::__construct();
	}

	function isLogin(){		
		if(isset($_SESSION['user_id'])){
			return true;
		}else{			
			return false;
		}
	}

	function send($command){
		if($this->isLogin()){
			$readyCommand = $this->parseCommand($command);				
		}else{
			return $this->user->login_user($command);
		}
	}
	
	function parseCommand($command){
		$parts = explode(" ", $command);
		$result = $this->database->link()->query("SELECT * FROM os_commands WHERE name = '$parts[0]' ");
		if($result->num_rows == 0){
			echo "Ошибка! Такой команды не существует!";
		}else{
			$row = $result->fetch_array();
			$parts['desc'] = $row['desc'];			
			if(isset($parts[1])){
				if($parts[1] == "--desc"){
					echo "<font color='orange'>Подсказка: описание комманды ".$parts[0].". </font>".$row['desc'];
				}else{
					$this->initProccess($parts);
				}
			}else{
				$this->initProccess($parts);
			}			
		}
	}
	
	function initProccess($command) {		
		$func = "os_".$command[0];		
		$this->lc->init($command);
		echo $this->lc->$func();		
	}

	function get_command_desc($name){
		$res = $this->database->link()->query("SELECT desc FROM os_commands WHERE name = '$name' ");
		$row = $res->fetch_array();
		return $row['desc'];
	}
	
}
?>