<?php 
require '../app/logic/conn.php';
$id_corte = $_GET['crcj'];
$sql_val_corte = "SELECT * FROM cortes_caja WHERE id_corte = '$id_corte'";
                        $res_val_corte = $mysqli->query($sql_val_corte);
                        $val_corte = $res_val_corte->num_rows;
                        $corte = mysqli_fetch_assoc($res_val_corte);                        

$fecha_corte = date('d/m/Y', strtotime($corte['fecha_corte']));
$cajero_corte = $corte['user_cajero']; 

$cobros_corte = $corte['detalle_cobros'];
$vales_corte = $corte['detalle_vales'];

$sql_montos_mp = "SELECT medio_pago, SUM(abono) MontoMP FROM caja where id_cobro IN ($cobros_corte) GROUP BY medio_pago ORDER BY medio_pago";
$res_montos_mp = $mysqli->query($sql_montos_mp);
//$val_montos_mp = $res_montos_mp->num_rows;

//Nutrientes y Medicamentos Orales
$sql_monto_nutri = "SELECT SUM(caja.total_orales) MontoOrales FROM caja WHERE id_cobro in ($cobros_corte)";
$res_monto_nutri = $mysqli->query($sql_monto_nutri);
$monto_nutri = mysqli_fetch_assoc($res_monto_nutri);
$total_nutrientes = $monto_nutri['MontoOrales'];

// Dental
$sql_monto_dental = "SELECT SUM(caja.abono) MontoDental, cita.tipo, tipos_cita.descrip_cita FROM   caja
INNER JOIN cita on caja.id_cita = cita.id_cita
INNER JOIN tipos_cita ON cita.tipo = tipos_cita.id_tipo_cita
where id_cobro IN ($cobros_corte)
AND cita.tipo = 90";
$res_monto_dental = $mysqli->query($sql_monto_dental);
$monto_dental = mysqli_fetch_assoc($res_monto_dental);
$total_dental = $monto_dental['MontoDental'];

// Pellet
$sql_monto_pellet = "SELECT SUM(caja.abono) MontoPellet, cita.tipo, tipos_cita.descrip_cita FROM   caja
INNER JOIN cita on caja.id_cita = cita.id_cita
INNER JOIN tipos_cita ON cita.tipo = tipos_cita.id_tipo_cita
where id_cobro IN ($cobros_corte)
AND cita.tipo = 92";
$res_monto_pellet = $mysqli->query($sql_monto_pellet);
$monto_pellet = mysqli_fetch_assoc($res_monto_pellet);
$total_pellet = $monto_pellet['MontoPellet'];

// Factor de Crecimiento
$sql_monto_factor = "SELECT SUM(caja.abono) MontoFactor, cita.tipo, tipos_cita.descrip_cita FROM   caja
INNER JOIN cita on caja.id_cita = cita.id_cita
INNER JOIN tipos_cita ON cita.tipo = tipos_cita.id_tipo_cita
where id_cobro IN ($cobros_corte)
AND cita.tipo = 91";
$res_monto_factor = $mysqli->query($sql_monto_factor);
$monto_factor = mysqli_fetch_assoc($res_monto_factor);
$total_factor = $monto_factor['MontoFactor'];

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../static/css/materialize.css">
    <link rel="stylesheet" href="../static/icons/iconfont/material-icons.css">
    <script type="text/javascript" src="../static/js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="../static/js/jquery.PrintArea.js"></script>
    <script src="../static/js/materialize.js"></script>
    <title>Impresión Corte de Caja-<?php echo $fecha_corte."-".$cajero_corte; ?></title>
    <style>
        .tabla{
            font-size: 10px !important;
            padding: 0 !important;
            margin: 0 !important;
        }
    </style>
</head>
<body>
<div id="recibo" style="max-height: 1100px; margin: 0%; background-color: #FFF;">
        <div class="row">
            <div class="col s4">
                <h5>Reporte de Ingresos</h5>
                <p style="font-size: 12px;;">Clínica de Medicina Alternativa SER <br>
                    Elena 9, Colonia Nativitas <br>
                    Del. Benito Juárez, Distrito Federal <br>
                    (55) 5579-9896, 6365-8396</p>
            </div>
            <div class="col s6">
            <ul class="collection">
                <li class="collection-item"><div>Cajero:<a href="#!" class="secondary-content"><?php echo $corte['user_cajero']; ?></a></div></li>
                <li class="collection-item"><div>Fecha del Corte:<a href="#!" class="secondary-content"><?php echo $fecha_corte; ?></a></div></li>
                <li class="collection-item"><div>Monto Ingresos:<a href="#!" class="secondary-content">$ <?php echo $corte['cobrado']; ?></a></div></li>
                <li class="collection-item"><div>Monto Egresos:<a href="#!" class="secondary-content">$ <?php echo $corte['monto_vales']; ?></a></div></li>
                <li class="collection-item"><div>Monto Corte:<a href="#!" class="secondary-content">$ <?php echo $corte['monto_corte']; ?></a></div></li>
            </ul>
            </div>
            <div class="col s2">
            <img src="../static/img/logo.png" style="max-height: 100px; float:right;">
            </div>
        </div>
        <div class="row">
            <div class="col s5">
            <ul class="collection with-header">
            <li class="collection-header"><h6>Desglose por medio de pago</h6></li>
                <?php 
                $total_val = 0;
                while($montos_mp = mysqli_fetch_assoc($res_montos_mp)){
                ?>
                <li class="collection-item"><div><?php echo $montos_mp['medio_pago'];?><a href="#!" class="secondary-content">$ <?php echo $montos_mp['MontoMP']; ?></a></div></li>
                <?php 
                $total_val = $total_val + $montos_mp['MontoMP'];
                    } // CIERRA WHILE MEDIOS DE PAGO
                ?>
                <li class="collection-header"><h6>Total: $ <?php echo $total_val; ?></h6></li>
            </ul>
            </div>
            <div class="col s7">
                <table>
                    <tbody>
                        <tr>
                            <th>Total Nutrientes/Med.Orales</th>
                            <td>$ <?php echo $total_nutrientes; ?></td>
                        </tr>
                        <tr>
                            <th>Total de Dental</th>
                            <td>$ <?php echo $total_dental; ?></td>
                        </tr>
                        <tr>
                            <th>Total de Pellet</th>
                            <td>$ <?php echo $total_pellet; ?></td>
                        </tr>
                        <tr>
                            <th>Total de Factor de Crecimiento</th>
                            <td>$ <?php echo $total_factor; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col s12">
                <h6>Detalle Reporte de Ingresos</h6>
                <table class="tabla">
                    <thead>
                        <tr>
                            <th>Cita</th>
                            <th>Horario</th>
                            <th>No. Cobro</th>
                            <th>Paciente</th>
                            <th>Clasificación Cita</th>
                            <th>Médico</th>
                            <th>Subtotal</th>
                            <th>Consulta</th>
                            <th>Descuento</th>
                            <th>Total a Pagar</th>
                            <th>Pagado</th>
                            <th>Medio Pago</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $val_abonos = 0;
                        $sql_det_cita = "SELECT caja.id_cita,
                        cita.horario,
                        caja.id_cobro,
                        CONCAT(paciente.nombres,' ',paciente.a_paterno,' ',paciente.a_materno) Nom_Paciente,
                        tipos_cita.descrip_cita,
                        CONCAT(user.nombre,' ',user.apellido) Nom_Medico,
                        caja.subtotal,
                        caja.consulta,
                        caja.descuento,
                        caja.total_cobro,
                        caja.abono,
                        caja.medio_pago
                        FROM   caja
                        INNER JOIN cita on caja.id_cita = cita.id_cita
                        INNER JOIN tipos_cita ON cita.tipo = tipos_cita.id_tipo_cita
                        INNER JOIN paciente ON cita.id_paciente = paciente.id_paciente
                        LEFT OUTER JOIN user ON cita.medico = user.id
                        where id_cobro IN ($cobros_corte)";
                        $res_detalle = $mysqli->query($sql_det_cita);
                        while($row_detalle = mysqli_fetch_assoc($res_detalle)){
                            ?>
                            <tr>
                                <td>CMA<?php echo $row_detalle['id_cita'] ?></td>
                                <td><?php echo $row_detalle['horario'] ?></td>
                                <td><?php echo $row_detalle['id_cobro'] ?></td>
                                <td><?php echo $row_detalle['Nom_Paciente'] ?></td>
                                <td><?php echo $row_detalle['descrip_cita'] ?></td>
                                <td><?php echo $row_detalle['Nom_Medico'] ?></td>
                                <td>$ <?php echo $row_detalle['subtotal'] ?></td>
                                <td>$ <?php echo $row_detalle['consulta'] ?></td>
                                <td><?php echo $row_detalle['descuento'] ?>%</td>
                                <td>$ <?php echo $row_detalle['total_cobro'] ?></td>
                                <td>$ <?php echo $row_detalle['abono'] ?></td>
                                <td><?php echo $row_detalle['medio_pago'] ?></td>
                            </tr>
                        <?php 
                                $val_abonos = $val_abonos + $row_detalle['abono'];
                            }   // Cierre while de detalle
                        ?>
                        <tr>
                            <td colspan="12"> Total Ingresos = $ <?php echo $val_abonos ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col s12">
            <h6>Detalle Reporte de Egresos</h6>
            <table class="tabla">
                <thead>
                    <tr>
                        <th>Concepto</th>
                        <th>Beneficiario</th>
                        <th>Autorizador</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    $sql_vales = "SELECT * FROM vales_salida WHERE id_vale IN ($vales_corte)";
                    $res_sql_vales = $mysqli->query($sql_vales);
                    $val_vales = $res_sql_vales->num_rows;
                    $val_egresos = 0;
                    if($val_vales > 0){
                        while($row_vales = mysqli_fetch_assoc($res_sql_vales)){
                            ?>
                            <tr>
                                <td><?php echo $row_vales['concepto']; ?></td>
                                <td><?php echo $row_vales['beneficiario']; ?></td>
                                <td><?php echo $row_vales['autorizador']; ?></td>
                                <td>$ <?php echo $row_vales['cantidad']; ?></td>
                            </tr>
                    <?php    
                                $val_egresos = $val_egresos + $row_vales['cantidad'];
                }
                    }
                ?>
                <tr>
                    <td colspan="4"> Total Egresos = $<?php echo $val_egresos; ?></td>
                </tr>
                </tbody>
            </table>
            </div>
        </div>
        <div class="row center align">
            <div class="col s2"></div>
            <div class="col s3">
            <br><br>
                <div class="divider" style="background-color: #000;"></div>
                <p>Entrega: <?php echo $cajero_corte; ?><br>(Fecha y firma)</p>
            </div>
            <div class="col s2"></div>
            <div class="col s3">
            <br><br>
                <div class="divider" style="background-color: #000;"></div>
                <p>Recibe<br>(Nombre fecha y firma)</p>
            </div>
            <div class="col s2"></div>
        </div>
</div> <!-- CIERRE DE DIV PRINCIPAL -->   
</body>
</html>