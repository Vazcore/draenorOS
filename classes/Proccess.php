<?php

include_once "Draenor.php";

class Proccess extends Draenor{
	public $stat = array(); // Статичный приоритет - первая очередь процессов
	public $otn = array(); // относительный приоритет - вторая очередь процессов
	public $ochered = array();


	function __construct(){
		// code
		parent::__construct();
	}

	function createProcess(){
		// Генерация случайного приоритета
		$priority =  rand(1,100);
		$creator = $_SESSION['user_id'];

		$status = "born";		
		$lifetime = rand(1,20);

		$ram = rand(1, $this->settings->os_ram/2);

		$this->database->link()->query("INSERT INTO os_proccess (priority,status,lifeTime,ram,totalTime,system_status,creator) VALUES ('$priority', '$status', '$lifetime', '$ram', '0', 'user','$creator') ");

		return " Процесс успешно создан!";
	}

	function killAll(){
		$this->database->link()->query("TRUNCATE os_proccess");	
		return " успешно!";	
	}

	function procStatus(){
		
		if(isset($_POST['time'])){
			$time = $_POST['time'];
			$_SESSION['time'] = $time;
			
		}

		if(!isset($_SESSION['proc'])){
			$_SESSION['proc'] = 0;
		}

		// Каждую 1 сек строим очередь процессов (планировщик)		
		$this->build();		

		// Работа процессора с процессами 
		$this->dispetch($time, $proc);

		echo "<h2> Общее время: ".$time." секунд</h2>";
		$res = $this->database->link()->query("SELECT * FROM os_proccess");
		echo "<table>";
			echo "<tr>";
			echo "<td>#<td>";
			echo "<td>Приритет<td>";
			echo "<td>Статус<td>";
			echo "<td>ТВВ<td>";
			echo "<td>ТРАМ<td>";
			echo "<td>ОВ<td>";
			echo "<td>Создатель<td>";
			echo "<tr>";
		while ($row = $res->fetch_array()) {
			$mark = $row['status'];
			echo "<tr class = '".$mark."'>";
			echo "<td>".$row['id']."<td>";
			echo "<td>".$row['priority']."<td>";
			echo "<td>".$row['status']."<td>";
			echo "<td>".$row['lifeTime']."<td>";
			echo "<td>".$row['ram']."<td>";
			echo "<td>".$row['totalTime']."<td>";
			echo "<td>".$row['creator']."<td>";
			echo "<tr>";
		}
		echo "</table>";
		echo '<input type="hidden" id="what_proccess" value="0">';
	}

	function showAll(){
		echo "Список процессов: <br>";
		$res = $this->database->link()->query("SELECT * FROM os_proccess");
		echo "<ul>";
		$it = 0;
		while ($row = $res->fetch_array()) {
			$it++;
			echo "<li>";
			echo $row['id']." - ".$row['priority']." -  ".$row['status']."<br>";
			echo "</li>";
		}
		echo "</ul>";
	}

	function push($id, $int){
		$res = $this->database->link()->query("SELECT priority FROM os_proccess WHERE id = '$id' ");
		$row = $res->fetch_array();
		$priority = $row['priority'];
		if(($priority + $int) > 100){
			$priority = 100;
		}else{
			$priority = $priority + $int;
		}
		$res = $this->database->link()->query("UPDATE os_proccess SET priority = '$priority' WHERE id = '$id' ");
		if($res){
			return "Успешное повышение приоритета процесса #id".$id." на ".$int;
		}
	}

	function kill($id){
		$res = $this->database->link()->query("DELETE FROM os_proccess WHERE id = '$id' ");
		if($res){
			return "Успешно убит процесс - #id".$id;
		}
	}

	/*
	* Построение очереди процессов планировщиком
	*/	
	function build(){
		$this->otn = array();
		$this->stat = array();
		$this->ochered = array();

		$res = $this->database->link()->query("SELECT * FROM os_proccess WHERE status = 'born' OR status = 'work' OR status = 'wait' ORDER BY priority DESC ");
		while($row = $res->fetch_array()){
			if($row['lifeTime'] < 7 AND $row['ram'] < ($this->settings->os_ram/4)){
				$this->otn[]->id = $row['id'];
			}else{
				$this->stat[]->id = $row['id'];
			}
		}

		if(count($this->stat) > count($this->otn)){
			foreach ($this->stat as $key => $value) {
				$this->ochered[]->id = $value->id;
				if(isset($this->otn[$key]->id)){
					$this->ochered[]->id = $this->otn[$key]->id;
				}
			}
		}else{
			foreach ($this->otn as $key => $value) {
				$this->ochered[]->id = $value->id;
				if(isset($this->stat[$key]->id)){
					$this->ochered[]->id = $this->stat[$key]->id;
				}
			}
		}		
	}

	/*
	*  Работа регулировщика (диспетчер)
	*/
	function dispetch($time){
		if($_SESSION['proc'] == 0){
			$start = $this->ochered[0]->id;
		}else{
			$start = intval($_SESSION['proc']);
		}

		foreach ($this->ochered as $key => $proc) {
			
			if($proc->id == $start){
				$res = $this->database->link()->query("SELECT * FROM os_proccess WHERE id = '$start' ");
				$row = $res->fetch_array();
				$vv = $row['lifeTime'];
				$nachalo = $row['nachalo'];
				$konets = $row['konets'];
				$tt = $row['totalTime'];
				$status = $row['status'];
				if($nachalo == 0){
					$nachalo = $time;
				}
				if($tt >= $vv){					
					$konets = $time;
					$status = "finish";
					$this->database->link()->query("UPDATE os_proccess SET konets = '$konets', status = '$status' WHERE id = '$start' ");
					if(isset($this->ochered[$key+1]->id)){
						$start = $this->ochered[$key+1]->id;
					}else{
						$start = $this->ochered[0]->id;
					}					
					$_SESSION['proc'] = $start;
					continue;
				}else{
					$tt++;
					$status = "work";
					$this->database->link()->query("UPDATE os_proccess SET totalTime = '$tt', nachalo = '$nachalo', konets = '$konets', status = '$status' WHERE id = '$start' ");
					// Если время - четное, то пора делать кантовку (квант = 2 сек)
					if($time%2 == 0){
						$status = "wait";
						if(isset($this->ochered[$key+1]->id)){
							$_SESSION['proc'] = $this->ochered[$key+1]->id;
						}else{
							$_SESSION['proc'] = $this->ochered[0]->id;
						}
						// Изменяем статус на Ожидает (так как кантовка)
						$this->database->link()->query("UPDATE os_proccess SET status = '$status' WHERE id = '$start' ");						
					}else{
						$_SESSION['proc'] = $proc->id;
					}					
					break;
				}
			}

		}
	}	
}