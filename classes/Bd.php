<?php
class Bd {
	private $link;
	
	function get_connection() {
		$this->link = new mysqli("localhost", "alexey", "1234", "os_draenor");
		return $this->link;
	}
}
?>