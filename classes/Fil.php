<?php

require_once "Draenor.php";

class Fil extends Draenor{
	
	function __construct(){
		// code
		parent::__construct();
	}

	function init($name, $location_id){
		$free_cluster = $this->bm->getCluster("U");

		if($free_cluster){
			$date = date("d-m-Y");
			$type = "U";
			$file_kind = "F";
			$access = "7-7-5";
			$user_id = $_SESSION['user_id'];

			$atrs = array($name, $location_id, $free_cluster, $date, $type, $file_kind, $access);
			$size = $this->os->calcSize($atrs);

			$this->database->link()->query("INSERT INTO os_nodes (type,file_kind,access,begin,size,name,parent,date,creator) VALUES ('$type','$file_kind','$access','$free_cluster','$size','$name','$location_id','$date','$user_id') ");
			$this->database->link()->query("UPDATE os_clusters SET status = 'busy', type = '$type' WHERE cluster_id = '$free_cluster' ");
			$res = $this->database->link()->query("SELECT * FROM os_clusters WHERE cluster_id = '$location_id' ");			
			$row = $res->fetch_array();
			if($row['data'] == "None"){
				$data_column = $free_cluster;
			}else{
				$data_column = $row['data'].";".$free_cluster;
			}
			$this->database->link()->query("UPDATE os_clusters SET data = '$data_column' WHERE cluster_id = '$location_id' ");			
			echo "Файл ".$name."txt успешно создан!";
			return true;
		}else{
			echo "Ошибка! Нет места на диске!";
			return false;
		}
	}

	function open_file_form($f_data, $f_name, $cluster_id){
		$html = '
		<script type="text/javascript">
			$("#send_f_data").click(function() {
				var text1 =  $("#data_area").text();
				alert(text1);
			});
		</script>
		<div id="file_form_cover">
			<h4>Файл - '.$f_name.'</h4>
			<input type="hidden" value="'.$cluster_id.'">
			<textarea id="data_area">'.$f_data.'</textarea>
			<br>
			<button id="send_f_data">Записать в файл</button>
		</div>
		';
		return $html;
	}
}