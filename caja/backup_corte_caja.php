<?php
use Dompdf\Dompdf;
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
$citas_corte = $corte['detalle_citas'];
$monto_vales_salida = $corte['monto_vales'];

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

ob_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    

    <link rel="stylesheet" href="../static/bootstrap/css/bootstrap.css">
   
    <title>Impresión Corte de Caja-<?php echo $fecha_corte."-".$cajero_corte; ?></title>
    <style>
        .tabla{
            font-size: 10px !important;
            padding: -10 !important;
            margin: -10 !important;
            border: 1px solid black;
                border-collapse: collapse;
            
        }
        td{
            padding: 0;
            border: 1px solid black;
                border-collapse: collapse;
        }
        th{
            padding: 0;
            border: 1px solid black;
                border-collapse: collapse;
        }
        
    </style>
</head>
<body>

        <div class="row">
            <div class="col-12">
                <b><p style="font-size: 14px;">Corte de Turno. || Cajero: <?php echo $corte['user_cajero']; ?><br>
                Fecha: <?php echo $fecha_corte; ?> <br>
                Clínica de Medicina Alternativa SER S.C.</p></b><br>
            </div>
            <div class="col-3">
            <ul class="list-group" style="font-size: 12px;">
                <?php 
                $total_val = 0;
                while($montos_mp = mysqli_fetch_assoc($res_montos_mp)){
                ?>
                <li class="list-group-item" style="padding: 0;"><?php echo $montos_mp['medio_pago'];?>   $ <?php echo $montos_mp['MontoMP']; ?></li>
                <?php 
                $total_val = $total_val + $montos_mp['MontoMP'];
                    } // CIERRA WHILE MEDIOS DE PAGO
                ?>
                <li class="list-group-item" style="padding: 0;"><b>Total: $ <?php echo $total_val; ?></b></li>
            </ul>
            </div>
            <div class="col-5">
            <table style="font-size:12px;" >
                    <tbody>
                    <tr>
                            <th>Total Cobros</th>
                            <td><b>$ <?php echo $total_val; ?></b></td>
                        </tr>
                        <tr>
                            <th>(-)Nutrientes/Med.Orales</th>
                            <td>$ <?php echo $total_nutrientes; ?></td>
                        </tr>
                        <tr>
                            <th>(-)Dental</th>
                            <td>$ <?php echo $total_dental; ?></td>
                        </tr>
                        <tr>
                            <th>(-)Pellet</th>
                            <td>$ <?php echo $total_pellet; ?></td>
                        </tr>
                        <tr>
                            <th>(-)Factor de Crecimiento</th>
                            <td>$ <?php echo $total_factor; ?></td>
                        </tr>
                        <tr>
                            <th>(-)Vales de Salida</th>
                            <td>$ <?php echo $monto_vales_salida; ?></td>
                        </tr>
                        <tr style="background-color: #9c9c9c;">
                            
                            <th colspan="2" style="text-align: center; font-size:14px;"><b>$ <?php echo $total_val - $total_nutrientes- $total_dental - $total_pellet - $total_factor - $monto_vales_salida; ?></b></th>
                        </tr>
                    </tbody>
                </table>
            </div>
            
        </div>
       
        <div class="row">
            <div class="col">
                <table class="tabla">
                    <thead>
                        <tr>
                            <th colspan="9">Detalle Citas</th>
                        </tr>
                        <tr>
                            <th>Cita</th>
                            <th>Horario</th>
                            <th>No. Cobro</th>
                            <th>Paciente</th>
                            <!--th>Clasificación Cita</th-->
                            <th>Médico</th>
                            <th>Total</th>
                            <!--th>Consulta</th-->
                            <th>Descuento</th>
                            <!--th>Total a Pagar</th-->
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
                        usuario Medico,
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
                        where id_cobro IN ($cobros_corte) AND cita.tipo = 0";
                        $res_detalle = $mysqli->query($sql_det_cita);
                        
                        while($row_detalle = mysqli_fetch_assoc($res_detalle)){
                            ?>
                            <tr>
                                <td>CMA<?php echo $row_detalle['id_cita'] ?></td>
                                <td><?php echo $row_detalle['horario'] ?></td>
                                <td><?php echo $row_detalle['id_cobro'] ?></td>
                                <td><?php echo $row_detalle['Nom_Paciente'] ?></td>
                                <!--td><?php //echo $row_detalle['descrip_cita'] ?></td-->
                                <td><?php 
                                if($row_detalle['Nom_Medico'] == 'Cargos Extra'){
                                    $id_cita_nota = $row_detalle['id_cita'];
                                    $sql_nota = "SELECT nota_evolucion FROM consulta WHERE id_cita = '$id_cita_nota'";
                                    $res_nota = $mysqli->query($sql_nota);
                                    $row_nota = mysqli_fetch_assoc($res_nota);
                                    $nota = $row_nota['nota_evolucion'];
                                    $nota_format = explode("|", $nota);
                                    echo $nota_format[0];

                                }else{
                                    echo strtoupper($row_detalle['Medico']);
                                }
                                ?>
                                </td>
                                <td>$ <?php echo $row_detalle['subtotal'] + $row_detalle['consulta'] ?></td>
                                <td><?php echo $row_detalle['descuento'] ?>%</td>
                                <!--td>$ <?php //echo $row_detalle['total_cobro'] ?></td-->
                                <td>$ <?php echo $row_detalle['abono'] ?></td>
                                <td><?php echo $row_detalle['medio_pago'] ?></td>
                            </tr>
                        <?php 
                                $val_abonos = $val_abonos + $row_detalle['abono'];
                            }   // Cierre while de detalle
                        ?>
                        <tr>
                            <td colspan="9"> Total Ingresos por Consultas = $ <?php echo $val_abonos ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div> 
            <div class="row" style="margin-top: 10px;">
            <div class="col">
            <table class="tabla">
                    <thead>
                        <tr>
                        <th colspan="9">Detalle Egresos Dental Pellet y Factor de Crecimiento</th>
                        </tr>
                        <tr>
                            <th>Cita</th>
                            <th>Horario</th>
                            <th>No. Cobro</th>
                            <th>Paciente</th>
                            <!--th>Clasificación Cita</th-->
                            <th>Médico</th>
                            <th>Total</th>
                            <!--th>Consulta</th-->
                            <th>Descuento</th>
                            <!--th>Total a Pagar</th-->
                            <th>Pagado</th>
                            <th>Medio Pago</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $val_egresos = 0;
                        $sql_det_egre = "SELECT caja.id_cita,
                        cita.horario,
                        caja.id_cobro,
                        CONCAT(paciente.nombres,' ',paciente.a_paterno,' ',paciente.a_materno) Nom_Paciente,
                        tipos_cita.descrip_cita,
                        CONCAT(user.nombre,' ',user.apellido) Nom_Medico,
                        usuario Medico,
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
                        where id_cobro IN ($cobros_corte) AND cita.tipo <> 0 ORDER BY tipos_cita.descrip_cita";
                        $res_det_egre = $mysqli->query($sql_det_egre);
                        while($row_det_egre = mysqli_fetch_assoc($res_det_egre)){
                            ?>
                            <tr>
                                <td>CMA<?php echo $row_det_egre['id_cita'],$row_det_egre['descrip_cita']; ?></td>
                                <td><?php echo $row_det_egre['horario'] ?></td>
                                <td><?php echo $row_det_egre['id_cobro'] ?></td>
                                <td><?php echo $row_det_egre['Nom_Paciente'] ?></td>
                                <!--td><?php //echo $row_detalle['descrip_cita'] ?></td-->
                                <td><?php echo strtoupper($row_det_egre['Medico']); ?></td>
                                <td>$ <?php echo $row_det_egre['subtotal'] + $row_det_egre['consulta'] ?></td>
                                <td><?php echo $row_det_egre['descuento'] ?>%</td>
                                <!--td>$ <?php //echo $row_detalle['total_cobro'] ?></td-->
                                <td>$ <?php echo $row_det_egre['abono'] ?></td>
                                <td><?php echo $row_det_egre['medio_pago'] ?></td>
                            </tr>
                        <?php 
                                $val_egresos = $val_egresos + $row_det_egre['abono'];
                            }   // Cierre while de detalle
                        ?>
                        <tr>
                            <td colspan="12"> Total Egresos Dental, Pellet y FCrec = $ <?php echo $val_egresos ?></td>
                        </tr>
                    </tbody>
                </table>
            
            </div>
            </div>
            <div class="row" style="margin-top: 10px;">
                <div class="col">
                <table class="tabla">
                <thead>
                    <tr>
                        <th colspan="4">Vales de Salida</th>
                    </tr>
                    <tr>
                        <th>Concepto</th>
                        <th>Beneficiario</th>
                        <th>Autorizador</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    $val_egresos = 0;
                    if($vales_corte != ''){
                    $sql_vales = "SELECT * FROM vales_salida WHERE id_vale IN ($vales_corte)";
                    $res_sql_vales = $mysqli->query($sql_vales);
                    $val_vales = $res_sql_vales->num_rows;
                    
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
                }
                ?>
                <tr>
                    <td colspan="4"> Total Vales = $<?php echo $val_egresos; ?></td>
                </tr>
                </tbody>
            </table>
                </div>
            <div class="col">
            <table class="tabla">
                <thead>
                    <tr>
                        <th colspan="4">Detalle Nutrientes y Medicamentos Orales</th>
                    </tr>
                    <tr>
                        <th>Cita</th>
                        <th>Medicamento</th>
                        <th>Cantidad</th>
                        <th>Monto</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    $sql_med_oral = "SELECT * FROM rec_med_orales WHERE id_cita in ($citas_corte) and cancelado = 0";
                    $res_det_orales = $mysqli->query($sql_med_oral);
                    $val_med_orales = $res_det_orales->num_rows;
                    $val_total_orales = 0;
                    if($val_med_orales > 0){
                        
                        while($row_med_orales = mysqli_fetch_assoc($res_det_orales)){
                            ?>
                            <tr>
                                <td>CMA<?php echo $row_med_orales['id_cita']; ?></td>
                                <td><?php echo $row_med_orales['med_oral']; ?></td>
                                <td><?php echo $row_med_orales['cantidad_med']; ?></td>
                                <td>$ <?php echo $row_med_orales['monto']; ?></td>
                            </tr>
                    <?php    
                                $val_total_orales = $val_total_orales + $row_med_orales['monto'];
                }
                    }
                ?>
                <tr>
                    <td colspan="4"> Total Medicamentos Orales = $<?php echo $val_total_orales; ?></td>
                </tr>
                </tbody>
            </table>
            </div>
            </div>
            <div class="row" style="margin-top: 10px;">
            <div class="col">
                <?php 
                $sql_monto_efectivo = "SELECT SUM(abono) MontoEfectivo FROM caja where id_cobro IN ($cobros_corte) and medio_pago = 'EFECTIVO'";
                $res_efectivo = $mysqli->query($sql_monto_efectivo);
                $monto_efectivo = mysqli_fetch_assoc($res_efectivo);
                ?>
                <table class="tabla">
                    <tr>
                        <th colspan="7">Desglose de Efectivo</th>
                    </tr>
                    <tr>
                        <th>Total Efectivo</th>                        
                        <th>Total Nutrientes</th>                        
                        <th>Total Dental</th>                        
                        <th>Total Factor Pellet</th>                        
                        <th>Total Factor Crecimiento</th>                         
                        <th>Total Vales</th>
                        
                        <?php 
                        $resto_efectivo = $monto_efectivo['MontoEfectivo'] - $total_nutrientes - $total_dental
                                        - $total_pellet - $total_factor - $val_egresos;
                        ?>
                        <th>Efectivo a Entregar:</th>
                        
                    </tr>
                    <tr>
                    <td>$ <?php echo $monto_efectivo['MontoEfectivo']; ?></td>
                    <td>$ <?php echo $total_nutrientes; ?></td>
                    <td>$ <?php echo $total_dental; ?></td>
                    <td>$ <?php echo $total_pellet; ?></td>
                    <td>$ <?php echo $total_factor; ?></td>
                    <td>$ <?php echo $val_egresos; ?></td>
                    <th>$ <?php echo $resto_efectivo; ?></th>
                    </tr>
                </table>
            </div>
            </div>
        
        <div class="row" style="margin-top: 50px;">
            <div class="col-2"></div>
            <div class="col-3 text-center" >
                <hr style="height: 2px; background-color: #000;">
                <p style="font-size: 12px;">Entrega: <?php echo $cajero_corte; ?></p>
            </div>
            <div class="col-2"></div>
            <div class="col-3 text-center">
                <hr style="height: 2px; background-color: black;">
                <p style="font-size: 12px;">Recibe:</p>
                            </div>
            <div class="col s2"></div>
        </div>
 
</body>
</html>
<?php

/* $html_corte = ob_get_clean();

// //echo $html_etiquetas;

 require_once '../lib/dompdf/autoload.inc.php';

 $dompdf = new Dompdf();

$options = $dompdf->getOptions();
 $options->set(array('isRemoteEnabled'=>true));
$dompdf->setOptions($options); 

$dompdf->loadHtml($html_corte);

// //$dompdf->setPaper(array(0, 0, 170.0784 , 113.38546));

 $dompdf->render();

 $dompdf->stream("Corte".$fecha_corte."-".$cajero_corte.".pdf",array("Attachment" => false)); */




?>