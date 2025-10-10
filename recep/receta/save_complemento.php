<?php 
include_once '../../app/logic/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cita = $_POST['id_cita'];
    $usuario = $_POST['user'];
    $id_complemento = $_POST['id_comple'];
    $id_regsuero = $_POST['id_regsuero'];

    $sql_insert_complemento = "INSERT INTO rec_complementos (id_complemento, id_cita, id_regsuero, user_registra) 
                                                        VALUES ('$id_complemento',$cita,'$id_regsuero','$usuario');";
    
    if($mysqli->query($sql_insert_complemento) === true){
        header("Location: sueros.php?c=$cita&u=$usuario");
        exit();
    } else {
        echo "Error al guardar el complemento: " . $mysqli->error;
    }

    

} else {
    echo "No se han enviado datos.";
}


?>