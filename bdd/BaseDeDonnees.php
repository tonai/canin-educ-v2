<?php

	class BaseDeDonnees {
	
		function __construct() {
		}
		
		
		
		function connexion() {
			include("admin/config.php");
			$this->mysqli = mysqli_connect($db['hostName'], $db['userName'], $db['password']) or die (mysqli_error());
			mysqli_select_db($this->mysqli, $db['dataBase']) or die (mysqli_error());
		}
		
		
		
		function deconnexion() {
			mysqli_close($this->mysqli);
		}
		
		
		
		function select($select, $from, $where, $orderBy) {
			return mysqli_query($this->mysqli, "SELECT '$select' FROM $from WHERE $where' ORDER BY $orderBy");
		}
		
	}

?>