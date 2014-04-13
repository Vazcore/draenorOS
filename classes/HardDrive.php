<?php
require_once "Settings.php";
require_once "Bd.php";
require_once "User.php";

class HardDrive{
	private $total_space;
	private $cluster_size;	
	private $bd;
	private $user;

	function __construct(){
		$base = new Bd();
		$this->bd = $base->get_connection();		
		//$this->user = new User();
		$this->total_space = Settings::DISK_SPACE;
		$this->cluster_size = Settings::CLUSTER_SPACE;
	}

	function init(){
		// Очистка БД таблиц
		$this->bd->query("TRUNCATE TABLE os_clusters");
		$this->bd->query("TRUNCATE TABLE os_nodes");
		// End truncate

		for ($i=1; $i <= $this->get_total_clusters(); $i++) { 
			if($i <= ceil(Settings::OS_SIZE/Settings::CLUSTER_SPACE)){
				$type = "S";
			}else{
				$type = "U";
			}
			$this->bd->query("INSERT INTO os_clusters (type,link,cluster_id,data) VALUES ('$type', '0', '$i', 'None') ");	
		}
	}
	
	
	function get_total_clusters() {
		return $this->total_space/$this->cluster_size;
	}
	
	function get_free_space(){
		// Bit Map
		// + os place
		$fr_s = $this->total_space - Settings::OS_SIZE;
		return $fr_s;		
	}
	
	function get_home_dir(){
		$h_d = Settings::OS_SIZE/$this->cluster_size + 1;
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

		$res = $this->bd->query("SELECT * FROM os_nodes WHERE parent='$dir_id' ");
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