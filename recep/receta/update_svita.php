<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Signos Vitales</title>
    <link rel="shortcut icon" href="../../static/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../../static/css/materialize.css">
    <script type="text/javascript" src="../../static/js/jquery-3.3.1.min.js"></script>
    <script src="../../static/js/sweetalert.min.js"></script>
</head>
<body style="background-color: #e0e0e0;">
    
<?php 
include_once '../../app/logic/conn.php';

if(!empty($_POST)){
    $t_a = $_POST['ta1'].'/'.$_POST['ta2'];
    $temp = $_POST['temp'];
    $frec_c = $_POST['fre_c'];
    $fre_r = $_POST['fre_r'];
    $oxi = $_POST['oxi'];
    $peso = $_POST['peso'];
    $talla = $_POST['talla'];
    $user_upd = $_POST['user'];
    $cita2 = $_POST['cita2'];
    $edad = $_POST['edad'];
    $alergias = $_POST['alergias'];

    $sql_svitales = "UPDATE consulta SET ta = '$t_a', temp = '$temp', fre_c = '$frec_c', fre_r = '$fre_r', oxi = '$oxi', peso = '$peso', talla = '$talla', user_act_svitales = '$user_upd',
                    edad = '$edad', alergias = '$alergias'
                     WHERE id_cita = '$cita2'";

    if($mysqli->query($sql_svitales) === TRUE){
        echo '<script type="text/javascript">
        swal({
            title: "Listo!",
            text: "Se actualizaron los signos vitales de la Cita CMA'.$cita2.'",
            icon: "success",
            button: "Volver",
          }).then(function() {
            window.location = "svitales.php?c='.$cita2.'&u='.$user_upd.'";
        });
        </script>';
    }else{
        echo '<script type="text/javascript" async="async">alert("Ha ocurrido un error, intente nuevamente \n , de lo contrario contacte con el administrador del sistema");window.location.href="svitales.php?c='.$cita2.'&u='.$user_upd.'"</script>';
    }
}
?>
</body>
</html>