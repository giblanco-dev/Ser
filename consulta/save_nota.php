<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Consulta</title>
    <link rel="shortcut icon" href="../static/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../static/css/materialize.css">
    <script type="text/javascript" src="../static/js/jquery-3.3.1.min.js"></script>
    <script src="../static/js/sweetalert.min.js"></script>
</head>
<body style="background-image: url('../static/img/background_login.png'); background-size: cover;">
    
<?php 
require_once '../app/logic/conn.php';

if(!empty($_POST)){
    $id_cita = $_POST['id_cita'];

    $flag_ex = $_POST['flag_ex'];
    if($flag_ex == 1){
        $folio = $_POST['folio'];
        $medico = $_POST['medico'];
        $comentarios = $_POST['nota_evo'];
        $nota = $folio."-".$medico."|".$comentarios;
    }else{
        $nota = $_POST['NotaRap'].' '.$_POST['nota_evo'];
    }

    //echo $id_cita;
    //echo $nota;
    if($nota != ""){

    $sql_nota_evo = "UPDATE consulta SET nota_evolucion = '$nota' WHERE id_cita = '$id_cita'";

    $sql_cita = "UPDATE cita SET consulta = 1 WHERE id_cita = '$id_cita'";

    if($mysqli->query($sql_nota_evo) === TRUE && $mysqli->query($sql_cita) === TRUE){
        echo '<script type="text/javascript">
        swal({
            title: "Listo",
            text: "Se guardo la nota de evolución de la Cita CMA'.$id_cita.'",
            icon: "success",
            button: "Volver",
          }).then(function() {
            window.location = "index.php";
        });
        </script>';
    }else{
        echo '<script type="text/javascript" async="async">alert("Ha ocurrido un error, intente nuevamente \n , de lo contrario contacte con el administrador del sistema");window.location.href="index.php"</script>';
    }
}else{
    echo '<script type="text/javascript" async="async">alert("No capturo nada en nota de evolución");window.location.href="index.php"</script>';
}
}


?>
</body>
</html>