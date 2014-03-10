<?php
	if(isset($_POST['type'])){
		$type = $_POST['type'];
		$data = $_POST['d'];
		// Requests
		switch($type){
			case "command":
				require_once "../classes/Commands.php";
				$commands = new Commands();
				$commands->send($data);
				break;
			
			default:
				break;
		}
	}
?>