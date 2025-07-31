<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: ../index.php');
    exit();
}elseif($_SESSION['nivel'] == 1 OR $_SESSION['nivel'] == 7){
            $id_user = $_SESSION['id'];
            $usuario = $_SESSION['name_usuario'];
            $nivel = $_SESSION['nivel'];
}else{
    header('Location: ../../../index.php');
    exit();
}

include_once '../../app/logic/conn.php';

if(!empty($_GET))
{
$id_agenda = $_GET['iag'];
$medico = $_GET['m'];
$fecha_agenda = $_GET['fa'];
$id_cita = $_GET['c'];

$sql_cancela_cita = "DELETE FROM cita WHERE id_cita = '$id_cita' AND confirma = 1 and pagado = 0;";
if ($mysqli->query($sql_cancela_cita) === TRUE) {
   
    $sql_libera_ag = "DELETE FROM agenda WHERE id_agenda = $id_agenda";

if($mysqli->query($sql_libera_ag) === true){    
    header('Location: ../agenda?medico='.$medico.'&fecha='.$fecha_agenda);                    
}else{
    echo '<script>alert("Cita liberada. Error no se pudo liberar la agenda");
            window.location.href="../agenda?medico='.$medico.'&fecha='.$fecha_agenda.'";</script>';
    
}

}else{
    echo '<script>alert("Error no se pudo liberar la cita");
            window.location.href="../agenda?medico='.$medico.'&fecha='.$fecha_agenda.'";</script>';
}


}

?>