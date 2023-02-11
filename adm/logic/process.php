<?php 
require_once '../../app/logic/conn.php';

if(!empty($_POST)){
    
    $id_proceso = $_POST['id_proceso'];

//  **************************************************** Proceso de alta de usuarios
    if($id_proceso == 'AltaUsuario'){
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apaterno'];
        $nivel = $_POST['nivel'];

        $user = strtolower(substr($nombre,0,1).$apellido);
        
        $sql_in_user = "INSERT INTO user (nombre, apellido, usuario, password, nivel )
                        values ('$nombre','$apellido','$user','12345678','$nivel')";
        if($mysqli->query($sql_in_user) === True){
            $titulo = "Registro exitoso";
            $texto = "Usuario: ".$nombre." ".$apellido;
            $icono = "success";
            $url_regreso = '../users.php';
        }else{
            $titulo = "Error al registrar al usuario";
            $texto = "Intente nuevamente o contacte al administrador del sistema";
            $icono = "error";
            $url_regreso = '../users.php';
        }

    } // Termina proceso de alta de usuarios

//  **************************************************** Proceso de alta de medicamentos homeopaticos
     if($id_proceso == 'registra_med_home'){
        $nombre_medicamento_hom = $_POST['nombre'];
        
        $sql_in_medhome = "INSERT INTO med_homeopaticos (id_med_hom, descrip_med_hom) VALUES (NULL, '$nombre_medicamento_hom');";
        if($mysqli->query($sql_in_medhome) === True){
            $titulo = "Registro exitoso";
            $texto = "Medicamento: ".$nombre_medicamento_hom;
            $icono = "success";
            $url_regreso = '../med_homeopaticos.php';
        }else{
            $titulo = "Error al registrar el medicamento";
            $texto = "Intente nuevamente o contacte al administrador del sistema";
            $icono = "error";
            $url_regreso = '../med_homeopaticos.php';
        }

    } // Termina proceso de alta de medicamentos homeopaticos


//  **************************************************** Proceso de alta de TRATAMIENTOS homeopaticos
    if($id_proceso == 'registra_trat_homeopatico'){
        $descrip_tratamiento = $_POST['nom_trat_homeopatico'];
        $precio_tratamiento = floatval($_POST['precio_trat_homeopatico']);

        $sql_in_trathome = "INSERT INTO tipo_trat_hom(des_tratamiento, costo, id_trat) VALUES ('$descrip_tratamiento', '$precio_tratamiento', NULL);";
        if($mysqli->query($sql_in_trathome) === True){
            $titulo = "Registro exitoso";
            $texto = "Nuevo tipo de tratamiento: ".$descrip_tratamiento;
            $icono = "success";
            $url_regreso = '../tratamientos.php';
        }else{
            $titulo = "Error al registrar el nuevo tipo de tratamiento";
            $texto = "Intente nuevamente o contacte al administrador del sistema";
            $icono = "error";
            $url_regreso = '../tratamientos.php';
        }

    } // Termina proceso de alta de TRATAMIENTOS homeopaticos


//  **************************************************** Proceso de alta de Terapias
if($id_proceso == 'registra_terapias'){
    $descrip_terapia = $_POST['descrip_terapia'];
    $precio_terapia = floatval($_POST['precio_terapia']);
    $max_terapias = intval($_POST['limite_terapias']);

    $sql_in_terapias = "INSERT INTO terapias(id_terapia, precio, activo, nom_terapia, max_terapias) VALUES (NULL, '$precio_terapia', 1, '$descrip_terapia', '$max_terapias');";
    if($mysqli->query($sql_in_terapias) === True){
        $titulo = "Registro exitoso";
        $texto = "Nuevo Terapia: ".$descrip_terapia;
        $icono = "success";
        $url_regreso = '../terapias.php';
    }else{
        $titulo = "Error al registrar la nueva terapia";
        $texto = "Intente nuevamente o contacte al administrador del sistema";
        $icono = "error";
        $url_regreso = '../terapias.php';
    }

} // Termina proceso de alta de Terapias

//  **************************************************** Proceso de alta de Sueros
if($id_proceso == 'alta_suero'){
    $descrip_suero = $_POST['descrip_suero'];
    $precio_suero = floatval($_POST['precio_suero']);
    
    $sql_in_suero = "INSERT INTO sueros(nom_suero, precio) VALUES ('$descrip_suero', '$precio_suero');";
    if($mysqli->query($sql_in_suero) === True){
        $titulo = "Registro exitoso";
        $texto = "Nuevo Suero: ".$descrip_suero;
        $icono = "success";
        $url_regreso = '../sueros.php';
    }else{
        $titulo = "Error al registrar la nueva terapia";
        $texto = "Intente nuevamente o contacte al administrador del sistema";
        $icono = "error";
        $url_regreso = '../sueros.php';
    }

} // Termina proceso de alta de Complementos de Suero

if($id_proceso == 'alta_complemento'){
    $descrip_complemento = $_POST['descrip_complemento'];
    $precio_complemento = floatval($_POST['precio_complemento']);
    
    $sql_in_complemento = "INSERT INTO complementos(nom_complemento, precio) VALUES ('$descrip_complemento', '$precio_complemento');";
    if($mysqli->query($sql_in_complemento) === True){
        $titulo = "Registro exitoso";
        $texto = "Nuevo Complemento: ".$descrip_complemento;
        $icono = "success";
        $url_regreso = '../complementos.php';
    }else{
        $titulo = "Error al registrar la nueva terapia";
        $texto = "Intente nuevamente o contacte al administrador del sistema";
        $icono = "error";
        $url_regreso = '../complementos.php';
    }

} // Termina proceso de alta de Complementos

//  **************************************************** Proceso de alta Med Orales y Nutrientes
if($id_proceso == 'AltaMedNutri'){
    $nombre_mednutri = $_POST['nombre_mednutri'];
    $precio_mednutri = floatval($_POST['precio']);
    $tipo_mednutri = $_POST['tipo'];
    $egreso = $_POST['egreso'];
    
    $sql_in_mednutri = "INSERT INTO med_orales(precio, activo, nom_med_oral, tipo, egreso) 
                    VALUES ($precio_mednutri, 1 ,'$nombre_mednutri', '$tipo_mednutri', '$egreso');";
                   
    if($mysqli->query($sql_in_mednutri) === True){
        $titulo = "Registro exitoso";
        $texto = "Medicamento/Nutriente: ".$nombre_mednutri;
        $icono = "success";
        $url_regreso = '../orales-nutri.php';
    }else{
        $titulo = "Error al registrar la nueva terapia";
        $texto = "Intente nuevamente o contacte al administrador del sistema";
        $icono = "error";
        $url_regreso = '../orales-nutri.php';
    }

} // Termina proceso de alta Med Orales y Nutrientes

//  *************************************************************************** Validacion peticiones GET ******************************************************
}elseif(!empty($_GET)){
    
    $id_proceso = $_GET['id_proceso'];

//  **************************************************** Proceso de reseteo de contraseñas
    if($id_proceso == 'ResetPass'){
        $id_user = $_GET['id_user'];
        $username = $_GET['nom_user'];

        $sql_resetpass = "UPDATE user SET password = '12345678' WHERE id = '$id_user'";
        if($mysqli->query($sql_resetpass) === True){
            $titulo = "Contraseña reestablecida correctamente";
            $texto = "Usuario: ".$username;
            $icono = "success";
            $url_regreso = '../users.php';
        }else{
            $titulo = "Error al restablecer contraseña";
            $texto = "Intente nuevamente o contacte al administrador del sistema";
            $icono = "error";
            $url_regreso = '../users.php';
        }

    }   // Termina proceso de reseteo de contraseña

//  ****************************************************    Proceso de eliminación de usuarios
    if($id_proceso == 'DelUser'){
        $id_user = $_GET['id_user'];
        $username = $_GET['nom_user'];
        
        $sql_deluser = "DELETE FROM user WHERE user.id = '$id_user'";
        if($mysqli->query($sql_deluser) === True){
            $titulo = "Usuario Eliminado";
            $texto = "Usuario: ".$username;
            $icono = "success";
            $url_regreso = '../users.php';
        }else{
            $titulo = "Error al eliminar usuario";
            $texto = "Intente nuevamente o contacte al administrador del sistema";
            $icono = "error";
            $url_regreso = '../users.php';
        }

    }   // Termina eliminacion de usuarios

//  **************************************************** Proceso de eliminación de medicamentos homeopaticos
    if($id_proceso == 'DelMedHome'){
        $id_medicamento = $_GET['id_med_home'];
        $nombre_med_home = $_GET['nombre_med_home'];
        
        $sql_delmedh = "DELETE FROM med_homeopaticos WHERE id_med_hom = '$id_medicamento'";
        if($mysqli->query($sql_delmedh) === True){
            $titulo = "Medicamento Eliminado";
            $texto = $nombre_med_home;
            $icono = "success";
            $url_regreso = '../med_homeopaticos.php';
        }else{
            $titulo = "Error al eliminar el medicamento";
            $texto = "Intente nuevamente o contacte al administrador del sistema";
            $icono = "error";
            $url_regreso = '../med_homeopaticos.php';
        }

    }   // Termina eliminacion de medicamentos homeopaticos

//  **************************************************** Proceso de eliminación de TRATAMIENTOS homeopaticos
    if($id_proceso == 'DelTratHome'){
        $id_tratamiento = $_GET['id_tratamiento'];
        $descrip_trat_home = $_GET['descrip_trat'];
        
        $sql_deltrath = "DELETE FROM tipo_trat_hom WHERE id_trat = '$id_tratamiento'";
        if($mysqli->query($sql_deltrath) === True){
            $titulo = "Tratamiento Homeopático Eliminado";
            $texto = $descrip_trat_home;
            $icono = "success";
            $url_regreso = '../tratamientos.php';
        }else{
            $titulo = "Error al eliminar el Tratamiento Homeopático";
            $texto = "Intente nuevamente o contacte al administrador del sistema";
            $icono = "error";
            $url_regreso = '../tratamientos.php';
        }

    }   // Termina eliminacion de TRATAMIENTOS homeopaticos

//  **************************************************** Proceso de eliminación de Terapias
if($id_proceso == 'DelTerapia'){
    $id_terapia = $_GET['id_terapia'];
    $descrip_terapia = $_GET['descrip_terapia'];
    
    $sql_delTerapia = "UPDATE terapias SET activo = 0 WHERE id_terapia = '$id_terapia'";
    if($mysqli->query($sql_delTerapia) === True){
        $titulo = "Terapia eliminada";
        $texto = $descrip_terapia;
        $icono = "success";
        $url_regreso = '../terapias.php';
    }else{
        $titulo = "Error al eliminar la Terapia";
        $texto = "Intente nuevamente o contacte al administrador del sistema";
        $icono = "error";
        $url_regreso = '../terapias.php';
    }

}   // Termina eliminacion de Terapias

//  **************************************************** Proceso de eliminación de Sueros
if($id_proceso == 'DelSuero'){
    $id_suero = $_GET['id_suero'];
    $descrip_suero = $_GET['descrip_suero'];
    
    $sql_delSuero = "DELETE FROM sueros WHERE id_suero = '$id_suero'";
    if($mysqli->query($sql_delSuero) === True){
        $titulo = "Suero eliminado";
        $texto = $descrip_suero;
        $icono = "success";
        $url_regreso = '../sueros.php';
    }else{
        $titulo = "Error al eliminar Suero";
        $texto = "Intente nuevamente o contacte al administrador del sistema";
        $icono = "error";
        $url_regreso = '../sueros.php';
    }

}   // Termina eliminacion de Sueros

//  **************************************************** Proceso de eliminación de Complementos de Suero
if($id_proceso == 'Delcomplemento'){
    $id_comple = $_GET['id_complemento'];
    $descrip_comple = $_GET['descrip_complemento'];
    
    $sql_delComplemento = "DELETE FROM complementos WHERE id_comple = '$id_comple'";
    if($mysqli->query($sql_delComplemento) === True){
        $titulo = "Complemento eliminado";
        $texto = $descrip_comple;
        $icono = "success";
        $url_regreso = '../complementos.php';
    }else{
        $titulo = "Error al eliminar Suero";
        $texto = "Intente nuevamente o contacte al administrador del sistema";
        $icono = "error";
        $url_regreso = '../complementos.php';
    }

}   // Termina eliminacion de Complementos de Suero

//  **************************************************** Proceso de inactivar med orales nutri
if($id_proceso == 'Inactivar_mednutri'){
    $id_mednutri = $_GET['id_mednutri'];
    $nom_med_nutri = $_GET['nom_mednutri'];
    $flag_mednutri = $_GET['flag_mednutri'];

    if($flag_mednutri == 1){
        $sql_active_mednutri = "UPDATE med_orales set activo = 0 WHERE id_med_oral = '$id_mednutri'";    
    }else{
        $sql_active_mednutri = "UPDATE med_orales set activo = 1 WHERE id_med_oral = '$id_mednutri'";    
    }
    
    if($mysqli->query($sql_active_mednutri) === True){
        if($flag_mednutri == 1){
            $titulo = "Inactivación correcta";
        }else{
            $titulo = "Activación correcta";
        }
        
        $texto = $nom_med_nutri;
        $icono = "success";
        $url_regreso = '../orales-nutri.php';
    }else{
        $titulo = "Error al eliminar Suero";
        $texto = "Intente nuevamente o contacte al administrador del sistema";
        $icono = "error";
        $url_regreso = '../orales-nutri.php';
    }

}   // Termina eliminacion de Complementos de Suero


}else{
            $titulo = "Error no hay petición GET o POST";
            $texto = "Intente nuevamente o contacte al administrador del sistema";
            $icono = "error";
            $url_regreso = '../';
        
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procesos Administración Sistema</title>
    <link rel="shortcut icon" href="../../static/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../../static/css/materialize.css">
    <script type="text/javascript" src="../../static/js/jquery-3.3.1.min.js"></script>
    <script src="../../static/js/sweetalert.min.js"></script>
</head>
<body style="background-image: url('../../static/img/background_login.png'); background-size: cover;">
<script type="text/javascript">
        swal({
            title: "<?php echo $titulo; ?>",
            text: "<?php echo $texto; ?>",
            icon: "<?php echo $icono; ?>",
            button: "Regresar",
          }).then(function() {
            window.location = "<?php echo $url_regreso; ?>";
        });
        </script>
</body>
</html>