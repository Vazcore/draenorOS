<?php
require_once "Draenor.php";

class HelpPanel extends Draenor{
	
	function __construct(){
		// code
	}

	function init(){
		// code
	}

	function list_commands(){
		$res = $this->database->link()->query("SELECT * FROM os_commands");
		echo "<table border='1'>";
		while ($row = $res->fetch_array()) {
			echo "<tr>";
			echo "<td>".$row['name']."<td>";
			echo "<td>".$row['desc']."<td>";
			echo "</tr>";
		}
		echo "</table>";
	}
}