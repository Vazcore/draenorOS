<?php

include_once "Draenor.php";

class Proccess extends Draenor{
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

		$ram = rand(1, 1000);

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
		}
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
			echo "<tr>";
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
	}
}