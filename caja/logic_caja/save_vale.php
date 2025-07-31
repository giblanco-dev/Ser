<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guardar Vale de Salida</title>
    <link rel="shortcut icon" href="../../static/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../../static/css/materialize.css">
    <script type="text/javascript" src="../../static/js/jquery-3.3.1.min.js"></script>
    <script src="../../static/js/sweetalert.min.js"></script>
</head>
<body style="background-image: url('../../static/img/background_login.png'); background-size: cover;">
<?php

    
require '../../app/logic/conn.php';
if(!empty($_POST)){
    $fecha_vale = $_POST['fecha_vale'];
    $cajero = $_POST['cajero'];
    $id_cajero = $_POST['id_cajero'];
    $cantidad = $_POST['cantidad'];
    $autorizador = $_POST['autoriza'];
    $beneficiario = $_POST['recibe'];
    $concepto = $_POST['concepto'];


   $sql_save_vale = "INSERT INTO vales_salida (id_user, user, fecha_vale, cantidad, autorizador, beneficiario, concepto)
                    VALUES ('$id_cajero', '$cajero','$fecha_vale','$cantidad','$autorizador','$beneficiario','$concepto')";
    if ($mysqli->query($sql_save_vale) === TRUE){
        echo '<script type="text/javascript">
        swal({
            title: "Vale de Salida para: '.$beneficiario.'",
            text: "Ha sido registrado por: '.$cantidad.'",
            icon: "success",
            button: "Regresar",
          }).then(function() {
            window.location = "../vale_salida.php";
        });
        </script>';
    }else{
        echo '<script type="text/javascript" async="async">alert("Ha ocurrido un error, intente nuevamente \n , de lo contrario contacte con el administrador del sistema");window.location.href="../"</script>';


    }
    
}



    ?>
</body>
</html>