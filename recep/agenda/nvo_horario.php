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
$horario = $_POST['horario'];
$medico = $_POST['id_dr'];
$no_dia = $_POST['no_dia'];
$name_dia = $_POST['dia'];
$name_medico = $_POST['name_medico'];

$sql_new_horario = "INSERT INTO ag_horarios (IdDr, Dr, NumDiaSemana, Horario, IDHorario, dia) VALUES ($medico, '$name_medico', '$no_dia', '$horario', NULL, '$name_dia');";
echo $sql_new_horario;

if($mysqli->query($sql_new_horario) === true){    
    header('Location: admin_horarios.php?medico='.$medico.'&no_dia='.$no_dia);                    
}else{
    echo '<script>alert("Error al guardar el horario");
            window.location.href="admin_horarios.php?medico='.$medico.'&no_dia='.$no_dia.'";</script>';
    
}
}

?>