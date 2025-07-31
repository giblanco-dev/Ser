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
$fecha = $_POST['fecha'];
$estatus = $_POST['estatus'];
$colum = $_POST['colum'];
$medico = $_POST['medico'];
$mes = $_POST['mes'];
$new_estatus;

if($estatus == 1){
    $new_estatus = 0;
}else{
    $new_estatus = 1;
}

$anio = date("Y", strtotime($fecha));


$sql_upd_ag = "UPDATE ag_calendario SET $colum = $new_estatus WHERE Fecha = '$fecha'";

//echo $sql_upd_ag;

if($mysqli->query($sql_upd_ag) === true){
    header('Location: admin_calendar.php?medico='.$medico.'&fecha='.$fecha.'&anio='.$anio.'&mes='.$mes);
}else{
    echo '<script>alert("Error no se pudo actualizar la agenda");
            window.location.href="admin_calendar.php?medico='.$medico.'&fecha='.$fecha.'&anio='.$anio.'&mes='.$mes.'";</script>';
    
}
}

/*
  $id_medico = $_GET['medico'];
    $fecha = $_GET['fecha'];
    $anio = $_GET['anio'];
    $mes = $_GET['mes'];
*/

?>