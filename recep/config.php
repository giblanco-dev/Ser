<?php
$server = "localhost";
$username = "root";
$password = "xTNhJSP0)Ai}";
$dbname = "ser";

// creamos la conexion con MySQL
try{
   $db = new PDO("mysql:host=$server;dbname=$dbname","$username","$password");
   $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
   die('No se pudo conectar con la base de datos');
}
 