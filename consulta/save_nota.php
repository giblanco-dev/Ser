<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Consulta</title>
    <link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/materialize.css">
    <script type="text/javascript" src="../js/jquery-3.3.1.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body style="background-image: url('../img/background_login.png'); background-size: cover;">
    
<?php 
require_once '../app/logic/conn.php';

if(!empty($_POST)){
    $id_cita = $_POST['id_cita'];
    $nota = $_POST['nota_evo'];
    //echo $id_cita;
    //echo $nota;
  

    $sql_nota_evo = "UPDATE consulta SET nota_evolucion = '$nota' WHERE id_cita = '$id_cita'";

    $sql_cita = "UPDATE cita SET consulta = 1 WHERE id_cita = '$id_cita'";

    if($mysqli->query($sql_nota_evo) === TRUE && $mysqli->query($sql_cita) === TRUE){
        echo '<script type="text/javascript">
        swal({
            title: "Listo",
            text: "Se guardo la nota de evolución de la Cita CSA'.$id_cita.'",
            icon: "success",
            button: "Volver",
          }).then(function() {
            window.location = "index.php";
        });
        </script>';
    }else{
        echo '<script type="text/javascript" async="async">alert("Ha ocurrido un error, intente nuevamente \n , de lo contrario contacte con el administrador del sistema");window.location.href="index.php"</script>';
    }
}


?>
</body>
</html>