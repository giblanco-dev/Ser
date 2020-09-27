<?php
echo '<body style="background-color: #2d83a0;"></body>';
require '../../app/logic/conn.php';
if(!empty($_GET)){
    $cita = $_GET['cita'];

    $sql_confirma_cita = "UPDATE cita SET confirma = 1 WHERE id_cita = '$cita'";
    if ($mysqli->query($sql_confirma_cita) === TRUE) {
        echo '<script type="text/javascript" async="async">alert("Cita_CSA'.$cita.' Confirmada");window.location.href="../"</script>';
    }else{
        echo '<script type="text/javascript" async="async">alert("Ha ocurrido un error, intente nuevamente \n , de lo contrario contacte con el administrador del sistema");window.location.href="../"</script>';
    }
}else{
    echo '<script type="text/javascript" async="async">alert("No se ha recibido una petición por parte del sistema contacte con el administrador del sistema");window.location.href="../"</script>';
}

?>