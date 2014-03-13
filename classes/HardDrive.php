<?php
require_once "Config.php";
require_once "Bd.php";
require_once "User.php";

class HardDrive{
	private $total_space = Config::DISK_SPACE;
	private $cluster_size = Config::CLUSTER_SPACE;
	
	private $bd;
	private $user;

	function __construct(){
		$base = new Bd();
		$this->bd = $base->get_connection();
		//$this->user = new User();
	}

	function init(){
		// Очистка БД таблиц
		$this->bd->query("TRUNCATE TABLE os_clusters");
		$this->bd->query("TRUNCATE TABLE os_nodes");
		// End truncate

		for ($i=1; $i <= $this->get_total_clusters(); $i++) { 
			if($i <= ceil(Config::OS_SIZE/Config::CLUSTER_SPACE)){
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
		$fr_s = $this->total_space - Config::OS_SIZE;
		return $fr_s;		
	}
	
	function get_home_dir(){
		$h_d = Config::OS_SIZE/$this->cluster_size + 1;
		return $h_d;
	}

	function showWhatInDir($dir_id){
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
		
		return $html;

	}
}
?>