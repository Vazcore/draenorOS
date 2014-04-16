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

			case "send file data":
				require_once "../classes/OS.php";
				$os = new OS();			
				$cluster_id = $_POST['id'];	
				$os->write_to_file($data, $cluster_id);				
				break;
			
			default:
				break;
		}
	}
?>