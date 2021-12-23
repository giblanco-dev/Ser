<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Consulta</title>
    <link rel="shortcut icon" href="../../static/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../../static/css/materialize.css">
    <script type="text/javascript" src="../../static/js/jquery-3.3.1.min.js"></script>
    <script src="../../static/js/sweetalert.min.js"></script>
</head>
<body style="background-image: url('../../static/img/background_login.png'); background-size: cover;">
<?php

    
require '../../app/logic/conn.php';
if(!empty($_GET['cita'])){
    $cita = $_GET['cita'];

    $sql_confirma_cita = "UPDATE cita SET confirma = 1 WHERE id_cita = '$cita'";
    if ($mysqli->query($sql_confirma_cita) === TRUE) {
        //echo '<script type="text/javascript" async="async">alert("Cita_CSA'.$cita.' Confirmada");window.location.href="../"</script>';
        echo '<script type="text/javascript">
        swal({
            title: "Cita_CSA'.$cita.' Confirmada",
            text: "Estatus de cita actualizado",
            icon: "success",
            button: "Regresar",
          }).then(function() {
            window.location = "../";
        });
        </script>';
    }else{
        echo '<script type="text/javascript" async="async">alert("Ha ocurrido un error, intente nuevamente \n , de lo contrario contacte con el administrador del sistema");window.location.href="../"</script>';
    }
}

if(!empty($_GET['cancela'])){
    $cita_cancela = $_GET['cancela'];

    $sql_cancela_cita = "UPDATE cita SET confirma = 3 WHERE id_cita = '$cita_cancela'";
    if ($mysqli->query($sql_cancela_cita) === TRUE) {
        //echo '<script type="text/javascript" async="async">alert("Cita_CSA'.$cita_cancela.' ha sido cancelada");window.location.href="../"</script>';
        echo '<script type="text/javascript">
        swal({
            title: "Cita_CSA'.$cita_cancela.' ha sido cancelada",
            text: "Estatus de cita actualizado",
            icon: "error",
            button: "Regresar",
          }).then(function() {
            window.location = "../";
        });
        </script>';
    }else{
        echo '<script type="text/javascript" async="async">alert("Ha ocurrido un error, intente nuevamente \n , de lo contrario contacte con el administrador del sistema");window.location.href="../"</script>';
    }
}

if(!empty($_GET['asistencia'])){
    $cita_asiste = $_GET['asistencia'];
    $medico = $_GET['m'];
    $sql_asiste_cita = "UPDATE cita SET confirma = 2 WHERE id_cita = '$cita_asiste'";
    $sql_reg_consulta = "INSERT INTO consulta (id_cita, ta, peso, id_medico) VALUES ('$cita_asiste','/','x','$medico')";
    if ($mysqli->query($sql_asiste_cita) === TRUE && $mysqli->query($sql_reg_consulta) === TRUE) {
        //echo '<script type="text/javascript" async="async">alert("Paciente Cita_CSA'.$cita_asiste.' se está en espera de pasar a Consulta");window.location.href="../"</script>';
        echo '<script type="text/javascript">
        swal({
            title: "Cita CMA'.$cita_asiste.' en espera de consulta",
            text: "Estatus de cita actualizado",
            icon: "success",
            button: "Regresar",
          }).then(function() {
            window.location = "../";
        });
        </script>';
    }else{
        echo '<script type="text/javascript" async="async">alert("Ha ocurrido un error, intente nuevamente \n , de lo contrario contacte con el administrador del sistema");window.location.href="../"</script>';
    }
}
    ?>
</body>
</html>