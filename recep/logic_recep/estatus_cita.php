<?php
echo '<body style="background-color: #2d83a0;"></body>';
require '../../app/logic/conn.php';
if(!empty($_GET['cita'])){
    $cita = $_GET['cita'];

    $sql_confirma_cita = "UPDATE cita SET confirma = 1 WHERE id_cita = '$cita'";
    if ($mysqli->query($sql_confirma_cita) === TRUE) {
        echo '<script type="text/javascript" async="async">alert("Cita_CSA'.$cita.' Confirmada");window.location.href="../"</script>';
    }else{
        echo '<script type="text/javascript" async="async">alert("Ha ocurrido un error, intente nuevamente \n , de lo contrario contacte con el administrador del sistema");window.location.href="../"</script>';
    }
}

if(!empty($_GET['cancela'])){
    $cita_cancela = $_GET['cancela'];

    $sql_cancela_cita = "UPDATE cita SET confirma = 3 WHERE id_cita = '$cita_cancela'";
    if ($mysqli->query($sql_cancela_cita) === TRUE) {
        echo '<script type="text/javascript" async="async">alert("Cita_CSA'.$cita_cancela.' ha sido cancelada");window.location.href="../"</script>';
    }else{
        echo '<script type="text/javascript" async="async">alert("Ha ocurrido un error, intente nuevamente \n , de lo contrario contacte con el administrador del sistema");window.location.href="../"</script>';
    }
}

if(!empty($_GET['asistencia'])){
    $cita_asiste = $_GET['asistencia'];

    $sql_asiste_cita = "UPDATE cita SET confirma = 2 WHERE id_cita = '$cita_asiste'";
    if ($mysqli->query($sql_asiste_cita) === TRUE) {
        echo '<script type="text/javascript" async="async">alert("Paciente Cita_CSA'.$cita_asiste.' se está en espera de pasar a Consulta");window.location.href="../"</script>';
    }else{
        echo '<script type="text/javascript" async="async">alert("Ha ocurrido un error, intente nuevamente \n , de lo contrario contacte con el administrador del sistema");window.location.href="../"</script>';
    }
}
?>