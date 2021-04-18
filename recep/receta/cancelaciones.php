<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancelaciones</title>
    <link rel="shortcut icon" href="../../static/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../../static/css/materialize.css">
    <script type="text/javascript" src="../../static/js/jquery-3.3.1.min.js"></script>
    <script src="../../static/js/sweetalert.min.js"></script>
</head>
<body style="background-color: #f5f5f5;">
<?php
    
require '../../app/logic/conn.php';

// ************************** CANCELACIONES TERAPIAS ***************************
if(!empty($_GET['c_terapia'])){
    $id_terapia = $_GET['c_terapia'];
    $user_update = $_GET['u'];
    $sql_cancela_terapias = "UPDATE rec_terapias SET cancelado = 1, monto = 0, user_registra = '$user_update' WHERE id_registro = '$id_terapia'";
    if ($mysqli->query($sql_cancela_terapias) === TRUE) {
        echo '<script type="text/javascript">
        swal("Listo", "La terapia '.$id_terapia.' ha sido cancelada", "error");  
        </script>';
    }else{
        echo '<script type="text/javascript" async="async">alert("Ha ocurrido un error, intente nuevamente \n , de lo contrario contacte con el administrador del sistema");window.location.href="../"</script>';
    }
}

// ************************** CANCELACIONES SUEROS ***************************
if(!empty($_GET['c_suero'])){
    $id_suero = $_GET['c_suero'];
    $user_update = $_GET['u'];
    $sql_cancela_sueros = "UPDATE rec_sueros SET cancelado = 1, user_registra = '$user_update' WHERE id_registro = '$id_suero'";
    if ($mysqli->query($sql_cancela_sueros) === TRUE) {
        echo '<script type="text/javascript">
        swal("Listo", "Los complementos y el suero '.$id_suero.' ha sido cancelado", "error");  
        </script>';
    }else{
        echo '<script type="text/javascript" async="async">alert("Ha ocurrido un error, intente nuevamente \n , de lo contrario contacte con el administrador del sistema");window.location.href="../"</script>';
    }
}
?>

</body>
</html>