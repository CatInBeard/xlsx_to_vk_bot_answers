<?php 
	include_once('config.php');
	if(isset($_POST['text'])&isset($_POST['pass'])){
		if($_POST['pass']=$passcode){
			$link = mysqli_connect($mysql['host'], $mysql['user'], $mysql['password'], $mysql['dbname']);
			$text=mysqli_real_escape_string($link,$_POST['text']);
			mysqli_query($link,"INSERT INTO `texts` SET `body`= '".$text."';");
			mysqli_close($link);
		}
	}
?>
