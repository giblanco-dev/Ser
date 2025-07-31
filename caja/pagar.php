<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../static/css/materialize.css">
    <link rel="stylesheet" href="../static/icons/iconfont/material-icons.css">
    <script src="../static/js/sweetalert.min.js"></script>
    <title>Pagar</title>
    <style>
        body{
            font-family: 'Roboto', sans-serif;
        }
        table{
            width: 100%;
            border-spacing: 1em;
        }
        
    </style>
</head>
<body style="background-color: #f5f5f5;">
<div class="row">
<div class="col s12">
<?php
include_once '../app/logic/conn.php';
if(!empty($_POST)){
    $id_cobro = $_POST['id_cobro'];
    $sql_val_pago = "SELECT saldo, status_pago, abono_efectivo, abono_tarjeta, abono_cheque, abono_otro, medio_pago FROM caja WHERE id_cobro = '$id_cobro'";
    $res_val_pago = $mysqli->query($sql_val_pago);
    $val_pago_ok = $res_val_pago->num_rows;

    if($val_pago_ok == 1){
        $row_val_pago = mysqli_fetch_assoc($res_val_pago);
        $saldo = $row_val_pago['saldo'];
        $status_pag = $row_val_pago['status_pago'];
        $efectivo_ant = $row_val_pago['abono_efectivo'];
        $tarjeta_ant = $row_val_pago['abono_tarjeta'];
        $cheque_anterior = $row_val_pago['abono_cheque'];
        $otro_ant = $row_val_pago['abono_otro'];
        $medio_pago_ant = $row_val_pago['medio_pago'];
    }

    $abono_efectivo = (float)$_POST['abono_efectivo'];
    $abono_tarjeta = (float)$_POST['abono_tarjeta'];
    $abono_cheque = (float)$_POST['abono_cheque'];
    $abono_otros = (float)$_POST['abono_otros'];
    
    $pago = $abono_efectivo + $abono_tarjeta + $abono_cheque + $abono_otros;
    //echo $pago;
    if($val_pago_ok > 1){
        echo '<script type="text/javascript">
        swal("","Cobro duplicado o no existe informar a sistemas y porporcionar ID'.$id_cobro.'", "error");  
        </script>';
    }elseif($saldo == 0 and $status_pag == 'SI'){
        echo '<script type="text/javascript">
        swal("","La cita ya fue pagada, por favor actualice la página", "warning");  
        </script>';

    }elseif($pago > $saldo){
        echo '<script type="text/javascript">
        swal("","Los montos de pago son mayores a el total de la cita,\nVolver a capturar montos", "error");  
        </script>';
    }elseif($pago < $saldo){
        echo '<script type="text/javascript">
        swal("","Los montos de pago son menores a el total de la cita,\nVolver a capturar montos", "error");  
        </script>';
    }elseif($pago == $saldo){

    $id_cobro = $_POST['id_cobro'];
    $med_pago = '';

    if($abono_efectivo > 0){
        $med_pago = $med_pago.'EFE/';
    }
    if($abono_tarjeta > 0){
        $med_pago = $med_pago.'TAR/';
    }
    if($abono_cheque > 0){
        $med_pago = $med_pago.'CHE/';
    }
    if($abono_otros > 0){
        $med_pago = $med_pago.'OTR/';
    }

    $med_pago_ok = rtrim($med_pago,"/");

    $total_efectivo = $abono_efectivo + $efectivo_ant;
    $total_tarjeta = $abono_tarjeta + $tarjeta_ant;
    $total_cheque = $abono_cheque + $cheque_anterior;
    $total_otros = $abono_otros + $otro_ant;

    $user = $_POST['user'];
    $id_cita = $_POST['id_cita'];

    $sql_up = "UPDATE caja SET abono = abono + '$pago', saldo = saldo - '$pago', medio_pago = CONCAT(medio_pago,' ','$med_pago_ok'),
                abono_efectivo = '$total_efectivo', abono_tarjeta = '$total_tarjeta', abono_cheque = '$total_cheque',
                abono_otro = '$total_otros', user_cobro = '$user',
                fecha_cobro = now() 
                WHERE id_cobro = '$id_cobro'";
    if($mysqli->query($sql_up) === TRUE){
        $pas1 = 1;
    }else{
        $pas1 = 0;
    }

    $sql_pagado = "SELECT saldo FROM caja WHERE id_cobro = '$id_cobro'";
    $res_pagado = $mysqli->query($sql_pagado);
    $val = $res_pagado->num_rows;

    if($val == 1){
        $row_saldo = mysqli_fetch_assoc($res_pagado);
        $saldo = $row_saldo['saldo'];

        if($saldo == 0){
            $sql_liq = "UPDATE caja SET status_pago = 'SI', fecha_cobro = now(), user_cobro = '$user' 
            WHERE id_cobro = '$id_cobro'";
            $sql_cita = "UPDATE cita SET pagado = 1 WHERE id_cita = '$id_cita'";

            if($mysqli->query($sql_liq)===True AND $mysqli->query($sql_cita)===True){
                $pas1 ++;
            }else{
                echo "ERROR FAVOR DE CONTACTAR A SISTEMAS CLAVE ERROR (NO SE PUDIERON ACTUALIZAR LOS ESTATUS DE CAJA Y CITA A PAGADO)COBRO ",$id_cobro," CITA",$id_cita;
            }
        }

    }else{
        echo "ERROR FAVOR DE CONTACTAR A SISTEMAS CLAVE ERROR (ID COBRO DUPLICADO)-",$id_cobro;
    }

    switch ($pas1){
        case 0:
            echo '<script type="text/javascript">
                swal("","ERROR FAVOR DE CONTACTAR A SISTEMAS CLAVE ERROR (NO SE PUDIERON ACTUALIZAR LOS ESTATUS DE CAJA Y CITA A PAGADO)COBRO '.$id_cobro.' CITA'.$id_cita.', "error");  
                </script>';
            break;
        case 1:
            echo '<script type="text/javascript">
                    swal("","Se actualizaron los importes de la Cita, aún existe adeudo", "success");  
                    </script>';
            break;
        case 2:
            echo '<script type="text/javascript">
                    swal("","", "success");  
                    </script>
                    <script type="text/javascript">
                    swal({
                        title: "",
                        text: "Se actualizaron los importes de la Cita, la cita ha sido liquidada",
                        icon: "success",
                        button: "Regresar",
                    }).then(function() {
                        window.location = "cobro.php?c='.$id_cita.'&u='.$user.'";
                    });
                    </script>';
            break;
        default:
            echo '<script type="text/javascript">
                swal("","Ha ocurrido un error. Contactar a Sistemas Clave de Error: NOUPDPago", "error");  
                </script>';
            break;
        }
        
    
    }else{
        echo '<script type="text/javascript">
                swal("","Ha ocurrido un error. Contactar a Sistemas Clave de Error: Verificar sumatoria de montos capturados", "error");  
                </script>';
    }    // Cierra If validación montos capturados

}// Cierra if validación de datos de formulario

?>
</div>
</div>
</body>
</html>