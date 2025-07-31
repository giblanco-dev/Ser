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

if(!empty($_POST))
{
$id_horario = $_POST['id_horario'];
$medico = $_POST['id_dr'];
$no_dia = $_POST['no_dia'];

$sql_libera_ho = "DELETE FROM ag_horarios WHERE IDHorario = $id_horario AND IdDr = $medico";

if($mysqli->query($sql_libera_ho) === true){    
    header('Location: admin_horarios.php?medico='.$medico.'&no_dia='.$no_dia);                    
}else{
    echo '<script>alert("Error no se pudo eliminar el horario");
            window.location.href="admin_horarios.php?medico='.$medico.'&no_dia='.$no_dia.'";</script>';
    
}
}

?>