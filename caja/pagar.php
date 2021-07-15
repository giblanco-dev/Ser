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

    $pago = $_POST['pago'];
    $id_cobro = $_POST['id_cobro'];
    $med_pago = $_POST['med_pago'];
    $user = $_POST['user'];
    $id_cita = $_POST['id_cita'];

    $sql_up = "UPDATE caja SET abono = abono + '$pago', saldo = saldo - '$pago', medio_pago = '$med_pago', user_cobro = '$user' 
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
            }
        }

    }else{
        echo "ERROR FAVOR DE CONTACTAR A SISTEMAS CLAVE ERROR +1CAJA-",$id_cobro;
    }

    switch ($pas1){
        case 0:
            echo '<script type="text/javascript">
                swal("Ha ocurrido un error favor de contactar a Sistemas", "error");  
                </script>';
            break;
        case 1:
            echo '<script type="text/javascript">
                    swal("Se actualizaron los importes de la Cita, aún existe adeudo", "success");  
                    </script>';
            break;
        case 2:
            echo '<script type="text/javascript">
                    swal("Se actualizaron los importes de la Cita, la cita ha sido liquidada", "success");  
                    </script>';
            break;
        default:
            echo '<script type="text/javascript">
                swal("Ha ocurrido un error. Contactar a Sistemas Clave de Error: NOUPDPago", "error");  
                </script>';
            break;
        }
        
    


}// Cierra if validación de datos de formulario




?>
</div>
</div>
</body>
</html>