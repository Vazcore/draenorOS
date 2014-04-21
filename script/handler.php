<?php
	if(isset($_POST['type'])){
		$type = $_POST['type'];		
		// Requests
		switch($type){
			case "command":				
				require_once "../classes/Commands.php";
				$commands = new Commands();
				$data = $_POST['d'];
				$commands->send($data);
				break;

			case "send file data":
				require_once "../classes/OS.php";
				$os = new OS();			
				$cluster_id = $_POST['id'];
				$data = $_POST['f_data'];	
				$os->write_to_file($data, $cluster_id);				
				break;

			case "open_file":
				require_once "../classes/OS.php";
				$os = new OS();		
				if(isset($_POST['begin_cluster'])){
					$start_cluster = $_POST['begin_cluster'];
					echo $os->get_file_data(intval($start_cluster));
				}					
				break;

			case "show proc":
				require_once "../classes/Proccess.php";
				$proc = new Proccess();
				$proc->procStatus();
				break;
			
			default:
				break;
		}
	}
?>