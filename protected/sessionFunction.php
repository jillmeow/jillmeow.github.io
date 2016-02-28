<?php
	function inputSession($str){
		if(isset($_SESSION[$str])){
			$name = $_SESSION[$str];
			echo "value='$name'";
		}
	}
?>