<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Corte de Caja</title>
    <link rel="shortcut icon" href="../../static/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../../static/css/materialize.css">
    <script type="text/javascript" src="../../static/js/jquery-3.3.1.min.js"></script>
    <script src="../../static/js/sweetalert.min.js"></script>
</head>
<body style="background-image: url('../../static/img/background_login.png'); background-size: cover;">
<?php

$hoy = date("Y-m-d");
    
require '../../app/logic/conn.php';
if(!empty($_POST)){
    $cajero = $_POST['cajero'];
    $id_cajero = $_POST['id_cajero'];
    $val_user = mysqli_real_escape_string($mysqli,$_POST['val_user']);
    $val_pass = mysqli_real_escape_string($mysqli,$_POST['val_pass']);
   
    $sql_val_cajero = "SELECT CONCAT(user.nombre,' ',user.apellido) nombre_completo, user.usuario, user.password, user.id,
        user.nivel, niveles.descripcion, niveles.id nivel_id
        FROM user INNER JOIN niveles ON user.nivel = niveles.nivel 
        WHERE user.usuario = '$val_user' and user.password = '$val_pass' AND user.id = '$id_cajero'";
    $res_val_cajero = $mysqli->query($sql_val_cajero);
    $no_rows = $res_val_cajero->num_rows;

    if($no_rows == 1){
        //echo "Cajero_si existe";
        $row_cajero = mysqli_fetch_assoc($res_val_cajero);

        $nivel = $row_cajero['nivel'];
        $id_user_caja = $row_cajero['id'];

        if($nivel == 'caja' AND $id_user_caja = $id_cajero){
                //echo "Cajero correcto validado";

                $sql_cobros = "SELECT user_cobro, COUNT(user_cobro) No_Cobros, SUM(abono) Cobrado, GROUP_CONCAT(id_cita) Citas_Cobradas, GROUP_CONCAT(id_cobro) Detalle_Cobros FROM caja
                WHERE user_cobro = '$id_user_caja' and DATE(fecha_cobro) = '$hoy' ORDER BY id_cita";

                $sql_vales = "SELECT id_user, COUNT(id_user) no_vales, SUM(cantidad) total_vales, GROUP_CONCAT(id_vale) Vales FROM vales_salida 
                                WHERE id_user = '$id_user_caja' and fecha_vale = '$hoy'";

                $sql_val_corte = "SELECT * FROM cortes_caja WHERE cajero_corte = '$id_user_caja' AND fecha_corte = '$hoy'";
                $res_val_corte = $mysqli->query($sql_val_corte);
                $val_corte = $res_val_corte->num_rows;

                if($val_corte == 0){
                    $res_cobros = $mysqli->query($sql_cobros);
                    $res_vales = $mysqli->query($sql_vales);

                    $val_cobros = $res_cobros->num_rows;

                    if($val_cobros == 1){
                        $cobros = mysqli_fetch_assoc($res_cobros);
                        $vales = mysqli_fetch_assoc($res_vales);

                        $fecha_corte = $hoy;
                        $cajero_corte = $id_user_caja;
                        //$user_cajero = $cajero;
                        $cant_cobros = $cobros['No_Cobros'];
                        $cobrado = $cobros['Cobrado'];
                        $detalle_citas = $cobros['Citas_Cobradas'];
                        $detalle_cobros = $cobros['Detalle_Cobros'];
                        $vales_registrados = $vales['no_vales'];
                        $monto_vales = $vales['total_vales'];
                        $detalle_vales = $vales['Vales'];

                        $monto_corte = $cobrado - $monto_vales;

                        if($monto_corte < 0){
                            $mensaje_monto_error = " (El monto del corte es negativo)";
                        }else{
                            $mensaje_monto_error = "";
                        }

                        $guarda_corte = "INSERT INTO cortes_caja
                                        (fecha_corte, cajero_corte, user_cajero, cobros, cobrado, detalle_citas,
                                        detalle_cobros, vales_registrados, monto_vales, detalle_vales, monto_corte, contador_imp)
                                        VALUES
                                        ('$fecha_corte', '$cajero_corte', '$cajero', '$cant_cobros', '$cobrado',
                                        '$detalle_citas', '$detalle_cobros', '$vales_registrados', '$monto_vales',
                                        '$detalle_vales', '$monto_corte', 0)";
                        if($mysqli->query($guarda_corte) === True){
                            echo '<script type="text/javascript">
                                    swal({
                                        title: "Corte de caja del cajero: '.$cajero.'",
                                        text: "Ha sido registrado por: $'.$monto_corte.$mensaje_monto_error.'",
                                        icon: "success",
                                        button: "Regresar",
                                    }).then(function() {
                                        window.location = "../corte_caja.php";
                                    });
                                    </script>';
                        }else{

                        }



                    }else{
                        echo '<script type="text/javascript" async="async">
                        alert("Ha ocurrido un error. \n No hay cobros por parte del cajero");
                        window.location.href="../";
                        </script>';                
                    }


                }else{
                    echo '<script type="text/javascript" async="async">
                        alert("Ya existe un corte de caja para el usuario del día de hoy. \n Contacte con el Administrador del sistema ");
                        window.location.href="../";
                        </script>';                
                }
        
        }else{
            echo '<script type="text/javascript" async="async">
                        alert("Usuario incorrecto. \n El usuario no pudo ser validado");
                        window.location.href="../";
                        </script>';                
        }
    }else{
        echo '<script type="text/javascript" async="async">
                        alert("Usuario incorrecto. \n El usuario no pudo ser validado");
                        window.location.href="../";
                        </script>';                
    }

   /*
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
 */   
}   // Cierre valida post no vacío



    ?>
</body>
</html>