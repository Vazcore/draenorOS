<?php

class Draenor{
	private $classes = array(
		"database" => "Bd",
		"os"       => "OS",
		"bm"  	   => "BitMap",
		"commands" => "Commands",
		"dir"      => "Dir",
		"hd"       => "HardDrive",
		"lc"       => "ListCommand",
		"nav"      => "Navigation",
		"settings" => "Settings",
		"sf"       => "SYSTEM_FILE",
		"user"     => "User",
		"fil"	   => "Fil",
		"help"     => "Help"	 
	);

	private static $objects = array();

	function __construct(){
		if(!isset($_SESSION['user_id'])){
			//error_reporting(0);
			session_start();
		}
	}

	public function __get($name){
		if(isset(self::$objects[$name])){
			return (self::$objects[$name]);
		}

		if(!array_key_exists($name, $this->classes)){
			return null;
		}

		$class = $this->classes[$name];

		include_once($class.".php");

		self::$objects[$name] = new $class();

		return self::$objects[$name];
	}
}