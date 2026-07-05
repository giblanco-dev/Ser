<?php
$ServerName = "localhost";
$Username = "recovery_ser";
$Password = "recovery2026";
$NameBD = "ser_recovery";
$mysqli=new mysqli($ServerName, $Username, $Password, $NameBD); 

$mysqli->set_charset("utf8");

	if(mysqli_connect_errno()){
		echo 'Conexion Fallida : ', mysqli_connect_error();
		exit();
	}
?>