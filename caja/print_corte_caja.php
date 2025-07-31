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
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
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
        <div style="max-width: 21.59cm; margin-left:auto; margin-right:auto; background-color:#fff;">
        <div class="row">
            <div class="col-12">
                <b><p style="font-size: 14px;">Corte de Turno. || Cajero: <?php echo $corte['user_cajero']; ?><br>
                Fecha: <?php echo $fecha_corte; ?> <br>
                Clínica de Medicina Alternativa SER S.C.</p></b><br>
            </div>
            
       
        <div class="row align-self-center" style="margin-top: -20px;">
            <div class="col">
                <p style="text-align: center; font-size: 14px;"><b>Reporte de Ingresos detallados</b></p>
                <table class="tabla" style="width: 95%; margin-left: auto; margin-right: auto;">
                    <thead>
                        <tr>
                            <th>NO.</th>
                            <th>HORA<br>COBRO</th>
                            <th>PACIENTE</th>
                            <th>FOLIO</th>
                            <th>MEDICO</th>
                            <!--th>Clasificación Cita</th-->
                            
                            <th>EFECTIVO</th>
                            <!--th>Consulta</th-->
                            <th>TERMINAL</th>
                            <!--th>BANCO</th-->
                            <th>CHEQUE</th>
                            <th>OTRO</th>
                            <th>TOTAL</th>
                            <th>% Desc</th>
                            <th>$ Desc</th>
                            <th>Pag. Real</th>
                            <!--th>MED PAGO</th-->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $val_abonos = 0;
                        $total_montos_desc_cita = 0;
                        $sum_subtotales = 0;
                        $sql_det_cita = "SELECT caja.id_cita,
                        DATE_FORMAT(fecha_cobro, '%H:%i') AS horario,
                        caja.id_cobro,
                        CONCAT(paciente.nombres,' ',paciente.a_paterno,' ',paciente.a_materno) Nom_Paciente,
                        tipos_cita.descrip_cita,
                        CONCAT(user.nombre,' ',user.apellido) Nom_Medico,
                        user.iniciales,
                        usuario Medico,
                        caja.subtotal,
                        caja.consulta,
                        caja.descuento,
                        caja.total_cobro,
                        caja.abono_efectivo,
                        caja.abono_tarjeta,
                        caja.abono_cheque,
                        caja.abono_otro,
                        caja.abono,
                        caja.medio_pago
                        FROM   caja
                        INNER JOIN cita on caja.id_cita = cita.id_cita
                        INNER JOIN tipos_cita ON cita.tipo = tipos_cita.id_tipo_cita
                        INNER JOIN paciente ON cita.id_paciente = paciente.id_paciente
                        LEFT OUTER JOIN user ON cita.medico = user.id
                        where id_cobro IN ($cobros_corte) ORDER BY caja.fecha_cobro";
                        $res_detalle = $mysqli->query($sql_det_cita);
                        $contador_citas = 1;
                        $sum_efectivo = 0;
                        $sum_tarjetas = 0;
                        $sum_cheques = 0;
                        $sum_otros = 0;
                        while($row_detalle = mysqli_fetch_assoc($res_detalle)){
                            ?>
                            <tr>
                                <td><?php echo $contador_citas; ?></td>
                                <td><?php echo $row_detalle['horario'] ?></td>
                                <td><?php echo $row_detalle['Nom_Paciente'] ?></td>
                                <td>CMA<?php echo $row_detalle['id_cita'] ?></td>
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
                                    echo $row_detalle['iniciales'];
                                }
                                ?>
                                </td>

                                <?php 
                        // ****************  Impresion de pagos por medio de pago
                                
                            echo "<td>$ ".$row_detalle['abono_efectivo']."</td>";
                            echo "<td>$ ".$row_detalle['abono_tarjeta']."</td>";
                            /* if($row_detalle['abono_tarjeta'] > 0){
                                echo "<td>BANAMEX</td>";
                            }else{
                                echo "<td></td>";
                            } */
                            echo "<td>$ ".$row_detalle['abono_cheque']."</td>";
                            echo "<td>$ ".$row_detalle['abono_otro']."</td>";

                            $sum_efectivo = $sum_efectivo + $row_detalle['abono_efectivo'];
                            $sum_tarjetas = $sum_tarjetas + $row_detalle['abono_tarjeta'];
                            $sum_cheques = $sum_cheques + $row_detalle['abono_cheque'];
                            $sum_otros = $sum_otros + $row_detalle['abono_otro'];
                                /*
                                $mp = $row_detalle['medio_pago'];
                                switch($mp){
                                    case 'EFECTIVO':
                                         // EFECTIVO
                                        echo "<td></td>"; // TERMINAL
                                        echo "<td></td>"; // BANCO
                                        echo "<td></td>"; // CHEQUE
                                        echo "<td></td>"; // OTRO
                                        $sum_efectivo = $sum_efectivo + $row_detalle['abono'];
                                    break;
                                    case 'TARJETA(CRED-DEB)':
                                        echo "<td></td>"; // EFECTIVO
                                        echo "<td>$ ".$row_detalle['abono']."</td>"; // TERMINAL
                                        echo "<td>BANAMEX</td>"; // BANCO
                                        echo "<td></td>"; // CHEQUE
                                        echo "<td></td>"; // OTRO
                                        $sum_tarjetas = $sum_tarjetas + $row_detalle['abono'];
                                    break;
                                    case 'CHEQUE':
                                        echo "<td></td>"; // EFECTIVO
                                        echo "<td></td>"; // TERMINAL
                                        echo "<td></td>"; // BANCO
                                        echo "<td>$ ".$row_detalle['abono']."</td>"; // CHEQUE
                                        echo "<td></td>"; // OTRO
                                        $sum_cheques = $sum_cheques + $row_detalle['abono'];
                                    break;
                                    case 'OTRAS':
                                        echo "<td></td>"; // EFECTIVO
                                        echo "<td></td>"; // TERMINAL
                                        echo "<td></td>"; // BANCO
                                        echo "<td></td>"; // CHEQUE
                                        echo "<td>$ ".$row_detalle['abono']."</td>"; // OTRO
                                        $sum_otros = $sum_otros + $row_detalle['abono'];
                                    break;
                                }
                                */
                                ?>
                                
                                <td>$ <?php echo $row_detalle['subtotal'] ?></td>
                                <td><?php echo $row_detalle['descuento'] ?>%</td>
                                <?php 
                                    $sum_subtotales = $sum_subtotales + $row_detalle['subtotal'];
                                    $monto_descuento_cita = $row_detalle['subtotal']*($row_detalle['descuento']/100);
                                    $total_montos_desc_cita = $total_montos_desc_cita + $monto_descuento_cita;
                                ?>
                                <td>$ <?php echo $monto_descuento_cita; ?></td>
                                <td>$ <?php echo $row_detalle['abono'] ?></td>
                                <!--td><?php //echo $row_detalle['medio_pago'] ?></td-->
                            </tr>
                        <?php 
                                $contador_citas ++;
                                $val_abonos = $val_abonos + $row_detalle['abono'];
                            }   // Cierre while de detalle
                        ?>
                        <tr>
                            <td style="text-align: center;" colspan="5"><b>TOTALES <?php //echo $val_abonos ?></b></td>
                            <td style="text-align: center;"><b>$ <?php echo $sum_efectivo; ?></b></td>
                            <td style="text-align: center;"><b>$ <?php echo $sum_tarjetas; ?></b></td>
                            <td style="text-align: center;"><b>$ <?php echo $sum_cheques; ?></b></td>
                            <td style="text-align: center;"><b>$ <?php echo $sum_otros; ?></b></td>
                            <td style="text-align: center;"><b>$ <?php echo $sum_subtotales; ?></b></td>
                            <td style="text-align: center;"><b><?php echo number_format((($total_montos_desc_cita/$sum_subtotales)*100),2) ?>%</b></td>
                            <td style="text-align: center;"><b>$ <?php echo $total_montos_desc_cita; ?></b></td>
                            <td style="text-align: center;"><b>$ <?php echo $val_abonos;?></b></td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <p style="font-size: 14px; text-align: center;"><b>Reporte de Egresos detallados</b></p>
                <table style="width: 80%; margin-left: auto; margin-right: auto;" class="tabla">
                        <thead>
                            <tr>
                                <th>NO.</th>
                                <th>HORA</th>
                                <th>TIPO</th>
                                <th>RECIBE</th>
                                <th>COMENTARIOS</th>
                                <th>MONTO</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $contador_egresos = 1;
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
                                <td><?php echo $contador_egresos; ?></td>
                                <td><?php echo $row_det_egre['horario'] ?></td>
                                <td><?php echo $row_det_egre['descrip_cita'] ?></td>
                                <td><?php echo strtoupper($row_det_egre['Medico']); ?></td>
                                <td></td>
                                <td>$ <?php echo $row_det_egre['abono'] ?></td>
                            </tr>
                        <?php 
                                $contador_egresos ++;
                                $val_egresos = $val_egresos + $row_det_egre['abono'];
                            }   // Cierre while de detalle
                        ?>
                        
                        <?php 
                    //$val_egresos = 0;
                    if($vales_corte != ''){
                    $sql_vales = "SELECT * FROM vales_salida WHERE id_vale IN ($vales_corte)";
                    $res_sql_vales = $mysqli->query($sql_vales);
                    $val_vales = $res_sql_vales->num_rows;
                    
                    if($val_vales > 0){
                        while($row_vales = mysqli_fetch_assoc($res_sql_vales)){
                            ?>
                            <tr>
                                <td><?php echo $contador_egresos; ?></td>
                                <td>N/A</td>
                                <td>VALE SAL</td>
                                <td><?php echo $row_vales['beneficiario']; ?></td>
                                <td><?php echo $row_vales['concepto']; ?></td>
                                <td>$ <?php echo $row_vales['cantidad']; ?></td>
                                
                            </tr>
                    <?php    
                                $contador_egresos ++;
                                $val_egresos = $val_egresos + $row_vales['cantidad'];
                        }
                            }
                        }
                        ?>
                        <?php 
                    $sql_med_oral = "SELECT rec_med_orales.*, cita.horario, caja.descuento, 
                                        rec_med_orales.monto monto2 
                                        FROM rec_med_orales 
                                        INNER JOIN cita ON cita.id_cita = rec_med_orales.id_cita 
                                        INNER JOIN caja ON rec_med_orales.id_cita = caja.id_cita 
                                        INNER JOIN med_orales ON rec_med_orales.id_med_oral = med_orales.id_med_oral
                                        WHERE rec_med_orales.id_cita in ($citas_corte) and cancelado = 0 AND med_orales.egreso = 1";
                    $res_det_orales = $mysqli->query($sql_med_oral);
                    $val_med_orales = $res_det_orales->num_rows;
                    $val_total_orales = 0;
                    if($val_med_orales > 0){
                        
                        while($row_med_orales = mysqli_fetch_assoc($res_det_orales)){
                            ?>
                            <tr>
                                <td><?php echo $contador_egresos; ?></td>
                                <td><?php echo $row_med_orales['horario']; ?></td>
                                <td>Med. Oral/Nutri</td>
                                <td>MMARTINEZ</td>
                                <td><?php echo $row_med_orales['med_oral']," || Cant", $row_med_orales['cantidad_med']  ?></td>
                                <td>$ <?php echo $row_med_orales['monto2'] * $row_med_orales['cantidad_med']; ?></td>
                                
                            </tr>
                    <?php    
                                $contador_egresos ++;
                                $val_total_orales = $val_total_orales + ($row_med_orales['monto2'] * $row_med_orales['cantidad_med']);
                }
                    }
                ?>
                        <tr>
                            <td style="text-align: center;" colspan="5"><b>TOTAL EGRESOS POR TERMINAL</b></td>
                            <td style="text-align: center;"><b>$ 0</b></td>
                        </tr>
                        <tr>
                            <td style="text-align: center;" colspan="5"><b>TOTAL EGRESOS EFECTIVO</b></td>
                            <td style="text-align: center;"><b>$ <?php echo $val_egresos + $val_total_orales; ?></b></td>
                        </tr>
                        <tr>
                            <td style="text-align: center;" colspan="5"><b>TOTAL EGRESOS</b></td>
                            <td style="text-align: center;"><b>$ <?php echo $val_egresos + $val_total_orales; ?></b></td>
                        </tr>
                        </tbody>
                </table>
                <br>
                <div class="row" style="width: 95%;margin-left: auto; margin-right: auto;">
                    <div class="col-5">
                        <p style="font-size: 12px;">Pagos recibidos en la terminal Banamex: $ <?php echo $sum_tarjetas ?><br>
                        Total de ingresos es de: $ <?php echo $val_abonos; ?><br>
                        El total en efectivo es de: $ <?php echo $sum_efectivo - ($val_egresos + $val_total_orales); ?></p>
                    </div>
                    <div class="col-3 text-center" >
                        <br>
                        <hr style="color: #000000; background-color: #000000; height: 3px;" />
                        <p style="font-size: 12px; margin-top: -8px;"><b>Entrega: <?php echo $cajero_corte; ?></b></p>
                    </div>
                    <div style="width: 20px;"></div>
                    <div class="col-3 text-center">
                        <br>
                        <hr style="color: #000000; background-color: #000000; height: 3px;" />
                        <p style="font-size: 12px; margin-top: -8px;"><b>Recibe</b></p>
                            </div>
                </div>
            </div>
        </div>
 </div>
</div>
</body>
</html>
<?php
/*
$html_corte = ob_get_clean();

// //echo $html_etiquetas;

 require_once '../lib/dompdf/autoload.inc.php';

 $dompdf = new Dompdf();

$options = $dompdf->getOptions();
//$options->set(array('isRemoteEnabled'=>true));
$dompdf->setOptions($options); 

$dompdf->loadHtml($html_corte);

$dompdf->setPaper("A4", "portrait");

 $dompdf->render();

 $dompdf->stream("Corte".$fecha_corte."-".$cajero_corte.".pdf",array("Attachment" => false)); 

*/


?>