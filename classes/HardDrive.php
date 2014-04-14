<?php
require_once "Draenor.php";

class HardDrive extends Draenor{
	
	function __construct(){		
		// Code		
	}

	function init(){
		// Очистка БД таблиц
		$this->database->link()->query("TRUNCATE TABLE os_clusters");
		$this->database->link()->query("TRUNCATE TABLE os_nodes");
		// End truncate

		for ($i=1; $i <= $this->get_total_clusters(); $i++) { 
			if($i <= ceil($this->settings->os_size/$this->settings->cluster_space)){
				$type = "S";
			}else{
				$type = "U";
			}
			$this->database->link()->query("INSERT INTO os_clusters (type,link,cluster_id,data) VALUES ('$type', '0', '$i', 'None') ");	
		}
	}
	
	
	function get_total_clusters() {
		return $this->settings->disk_space/$this->settings->cluster_space;
	}
	
	function get_free_space(){
		// Bit Map
		// + os place
		$total_user_space = $this->settings->disk_space - $this->settings->os_size;
		$res = $this->database->link()->query("SELECT status FROM os_clusters WHERE status = 'busy' AND type = 'U' ");
		$count_busy = $res->num_rows;
		$fr_s = $total_user_space - ($count_busy * intval($this->settings->cluster_space));
		return $fr_s." кБ";		
	}
	
	function get_home_dir(){
		$h_d = ($this->settings->os_size/$this->settings->cluster_space) + 1;
		return $h_d;
	}

	function showWhatInDir($dir_id, $flag = "none"){
		$dirs = array();
		$html = '
		<table border="1">
			<tr>
				<td>#</td>
				<td>Название</td>
				<td>Размер</td>
				<td>Дата срздания</td>
				<td>Доступ</td>
				<td> ID создателя</td>
			</tr>';

		$res = $this->database->link()->query("SELECT * FROM os_nodes WHERE parent='$dir_id'");
		if($res->num_rows != 0){
			while($row = $res->fetch_array()){
				$dirs[] = $row;
				$add_html = '
					<tr>
						<td>'.$row['begin'].'</td>
						<td>'.$row['name'].'</td>
						<td>'.$row['size'].'</td>
						<td>'.$row['date'].'</td>
						<td>'.$row['access'].'</td>
						<td>'.$row['creator'].'</td>
					</tr>
				';
				$html = $html.$add_html;
			}
		}else{
			$html = $html."<tr><td colspan='6'><font color='red'>Каталог - пуст!</font></td></tr>";
		}	
		$html = $html."</table>"; 
		
		if($flag == "dirs"){
			return $dirs;
		}else{
			return $html;
		}		

	}
}
?>