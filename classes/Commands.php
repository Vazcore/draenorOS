<?php
require_once "Bd.php";
require_once "User.php";
class Commands {
	
	private $bd;	
	private $user;	
	
	function __construct(){		
		$base = new Bd();
		$this->bd = $base->get_connection();
		$this->user = new User();
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
			if(!$name = $this->user->login_user($command)){				
				echo "Войдите в систему (команда wlogin)";
			}else{
				echo "Добро пожаловать, ".$name;
			}			
		}
	}
	
	function parseCommand($command){
		$parts = explode(" ", $command);
		$result = $this->bd->query("SELECT * FROM os_commands WHERE name = '$parts[0]' ");
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
		require_once "ListCommand.php";
		$list_commands = new ListCommand($command);
		$func = "os_".$command[0];		
		echo $list_commands->$func();		
	}

	function get_command_desc($name){
		$res = $this->bd->query("SELECT desc FROM os_commands WHERE name = '$name' ");
		$row = $res->fetch_array();
		return $row['desc'];
	}
	
}
?>