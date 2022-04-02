<?php 
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: ../index.php');
    exit();
}elseif($_SESSION['nivel'] == 1 OR $_SESSION['nivel'] == 7){
            $id_user = $_SESSION['id'];
            $usuario = $_SESSION['name_usuario'];
            $nivel = $_SESSION['nivel'];
}else{
    header('Location: ../index.php');
    exit();
} 
require '../app/logic/conn.php';
include_once 'recep_sections.php';
$error = '';
if(!empty($_POST)){
    $id_paciente = $_POST['id_paciente'];
    $nombres = ucwords(($_POST['nombres']));
    $a_paterno = ucwords(($_POST['a_paterno']));
    $a_materno = ucwords(($_POST['a_materno']));
    $genero = $_POST['genero'];
    $calle = ucwords(($_POST['calle']));
    $num_domicilio = $_POST['num_domicilio'];
    $colonia = ucwords(($_POST['colonia']));
    $cod_postal = $_POST['cod_postal'];
    $muni_alcaldia = ucwords(($_POST['muni_alcaldia']));
    $estado = $_POST['estado'];
    $tel_recados = $_POST['tel_recados'];
    $tel_casa = $_POST['tel_casa'];
    $tel_movil = $_POST['tel_movil'];
    $tel_oficina = $_POST['tel_oficina'];
    $ext_tel = $_POST['ext_tel'];
    $email = $_POST['email'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $ocupacion = ucwords(($_POST['ocupacion']));
    $nombre_titular = ucwords(($_POST['nombre_titular']));
    $usuario_captura = $_POST['usuario_captura'];

        $sql_update_paciente = "UPDATE paciente SET 
            nombres = '$nombres', 
            a_paterno = '$a_paterno', 
            a_materno = '$a_materno', 
            fecha_captura = CURRENT_TIMESTAMP,
            genero = '$genero', 
            calle = '$calle', 
            num_domicilio = '$num_domicilio', 
            colonia = '$colonia',
            cod_postal = '$cod_postal', 
            muni_alcaldia = '$muni_alcaldia', 
            estado = '$estado', 
            tel_recados = '$tel_recados', 
            tel_casa = '$tel_casa', 
            tel_movil = '$tel_movil', 
            tel_oficina = '$tel_oficina', 
            ext_tel = '$ext_tel', 
            email = '$email', 
            fecha_nacimiento = '$fecha_nacimiento', 
            ocupacion = '$ocupacion',
            nombre_titular = '$nombre_titular',  
            usuario_captura = '$usuario_captura' WHERE id_paciente = '$id_paciente';";
            
            if ($mysqli->query($sql_update_paciente) === TRUE) {
                echo '<script type="text/javascript">window.location.href="upd_paciente.php?idpac='.$id_paciente.'"</script>';
            } else {
                echo '
                        <h3 style="color: red; margin-top; 800px;">No se pudo actualizar al paciente favor de comunicarse con Sistemas</h3>
                    ';
            }
        
       
    }else{
        echo '
        <h3 style="color: red; margin-top; 800px;">No se ha recibido ninguna petición de alta de usuarios</h3>
        ';
    }

?>