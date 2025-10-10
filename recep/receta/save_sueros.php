<?php 
include_once '../../app/logic/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cita = $_POST['id_cita'];
    $usuario = $_POST['user'];
    $suero = $_POST['suero'];

    $sql_insert_suero = "INSERT INTO rec_sueros (suero, id_cita, user_registra) VALUES ('$suero','$cita','$usuario');";
    echo $sql_insert_suero;
    
    if($mysqli->query($sql_insert_suero) === true){
        header("Location: sueros.php?c=$cita&u=$usuario");
        exit();
    } else {
        echo "Error al guardar el suero: " . $mysqli->error;
    }

} else {
    echo "No se han enviado datos.";
}

?>