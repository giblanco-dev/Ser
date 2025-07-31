<?php 
require_once '../../app/logic/conn.php';

if(!empty($_POST)){
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apaterno'];
    $nivel = $_POST['nivel'];

    $user = substr($nombre,0,1).$apellido;
    echo $nombre;
    echo $apellido;
    echo $nivel;
    echo $user;

}

?>