<?php
class Bd {
	private $link;
	
	function get_connection() {
		if(!$this->link){
			$this->link = new mysqli("localhost", "alexey", "1234", "os_draenor");
			$this->link->set_charset("utf8");
		}
		return $this->link;
	}
}
?>