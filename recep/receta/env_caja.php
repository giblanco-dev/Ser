<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../static/css/materialize.css">
    <link rel="stylesheet" href="../../static/icons/iconfont/material-icons.css">
    <script src="../../static/js/sweetalert.min.js"></script>
    <title>Enviar Cobro</title>
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
include_once '../../app/logic/conn.php';

if(!empty($_POST)){
$id_cita = $_POST['id_cita'];
$user = $_POST['user'];
$total_terapias = $_POST['terapias'];
$total_sueros = $_POST['sueros'];
$total_homeopaticos = $_POST['homeopaticos'];
$total_orales = $_POST['orales'];
$sub_total = $_POST['sub_total'];
$consulta = $_POST['consulta'];
$descuento = $_POST['descuentos'];
$flag_des = $_POST['flag'];

if($flag_des == 'OTROS'){
    $total_cobro = ($sub_total)-(($sub_total)*($descuento/100));
}else{
    $total_cobro = ($sub_total + $consulta)-(($total_terapias + $total_sueros + $total_homeopaticos)*($descuento/100));
}

//echo "el total es", $total_cobro;



$sql_val = "SELECT id_cita FROM caja WHERE id_cita = '$id_cita'";
$res_val = $mysqli->query($sql_val);
$val = $res_val->num_rows;

if($val == 0){

    $inser = "INSERT INTO caja (id_cita, user_registra, total_terapias, total_sueros, total_homeopaticos, total_orales, subtotal, consulta, descuento, id_cobro, total_cobro, status_pago, abono, saldo, medio_pago)
     VALUES ('$id_cita', '$user', '$total_terapias', '$total_sueros', '$total_homeopaticos', '$total_orales', '$sub_total', '$consulta', '$descuento', NULL, '$total_cobro', 'NO', 0, $total_cobro, '')";

        $upd_cita = "UPDATE cita SET caja = 1 WHERE id_cita = '$id_cita'";

        if(($mysqli->query($inser) === TRUE) AND ($mysqli->query($upd_cita) === TRUE)){
            echo '<script type="text/javascript">
            swal("Los importes de la cita CMA'.$id_cita.' fueron enviados.", "Total a pagar $ '.$total_cobro.' MXN", "success");  
            </script>';
        }else{
            echo '<script type="text/javascript">
            swal("No se pudo enviar los importes de la cita '.$id_cita.'.", "Favor de Contactar al administrador del Sistema", "error");  
            </script>';
        }

}elseif($val == 1){

    $upd = "UPDATE caja SET user_registra = '$user',
                total_terapias = '$total_terapias', 
                total_sueros = '$total_sueros', 
                total_homeopaticos = '$total_homeopaticos',
                total_orales = '$total_orales', 
                subtotal = '$sub_total', 
                consulta  = '$consulta', 
                descuento = '$descuento', 
                total_cobro = '$total_cobro',
                saldo = '$total_cobro'
                WHERE id_cita = '$id_cita'";

        if($mysqli->query($upd) === TRUE){
            echo '<script type="text/javascript">
            swal("Los importes de la cita CMA'.$id_cita.' fueron actualizados.", "Total a pagar $ '.$total_cobro.' MXN", "success");  
            </script>';
        }else{
            echo '<script type="text/javascript">
            swal("No se pudo actualizar los importes de la cita '.$id_cita.'.", "Favor de Contactar al administrador del Sistema", "error");  
            </script>';
        }

}else{
    echo '<script type="text/javascript">
    swal("Usted no debería estar aquí", "Favor de Contactar al administrador del Sistema", "error");  
    </script>';
}

}// Cierra if validación de datos de formulario




?>
</div>
</div>
</body>
</html>