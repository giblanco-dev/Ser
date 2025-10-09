<?php
$server = "localhost";
$username = "medalter_dev";
$password = "medalter_ser";
$dbname = "7rhuzGEv6mA%";

// creamos la conexion con MySQL
try{
   $db = new PDO("mysql:host=$server;dbname=$dbname","$username","$password");
   $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
   die('No se pudo conectar con la base de datos');
}
 