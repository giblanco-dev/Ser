<?php 
require_once '../../app/logic/conn.php';

if(!empty($_POST)){
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apaterno'];
    $nivel = $_POST['nivel'];

    $user = strtolower(substr($nombre,0,1).$apellido);
    
    echo $nombre,"<br>";
    echo $apellido,"<br>";
    echo $nivel,"<br>";
    echo $user,"<br>";

    $sql_in_user = "INSERT INTO user (nombre, apellido, usuario, password, nivel )
                    values ('$nombre','$apellido','$user','12345678','$nivel')";
    if($mysqli->query($sql_in_user) === True){
        echo '<script type="text/javascript" async="async">alert("Usuario '.$user.' registrado en sistema");window.location.href="../users.php"</script>';
    }else{
        echo '<script type="text/javascript" async="async">alert("El Usuario '.$user.' no se pudo registrar en sistema \n Favor de contactar con sistemas");window.location.href="../users.php"</script>';
    }

}

?>