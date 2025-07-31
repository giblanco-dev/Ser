<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guardar Devolución</title>
    <link rel="shortcut icon" href="../../static/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../../static/css/materialize.css">
    <script type="text/javascript" src="../../static/js/jquery-3.3.1.min.js"></script>
    <script src="../../static/js/sweetalert.min.js"></script>
</head>
<body style="background-image: url('../../static/img/background_login.png'); background-size: cover;">
<?php    
require '../../app/logic/conn.php';
if(!empty($_POST)){

   
    $monto_devolucion = $_POST['cantidad'];
    $comentarios_devolucion = $_POST['concepto'];
    $fecha_devolucion = $_POST['fecha_devo'];
    $user_devolucion = $_POST['id_cajero'];
    $autoriza_devolucion = $_POST['autoriza'];

    $cobro = $_POST['id_cobro'];

    $sql_devo = "UPDATE caja SET monto_devolucion = '$monto_devolucion',
                motivo_devolucion = '$comentarios_devolucion',
                fecha_devolucion = NOW(),
                user_devolucion = '$user_devolucion',
                autoriza_devolucion = '$autoriza_devolucion',
                abono = abono -'$monto_devolucion'
                WHERE id_cobro = '$cobro';";
        
        if ($mysqli->query($sql_devo) === TRUE){
            echo '<script type="text/javascript">
            swal({
                title: "La devolución del Cobro con el ID: '.$cobro.'",
                text: "Ha sido registrado por: '.$monto_devolucion.'",
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