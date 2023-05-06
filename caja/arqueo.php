<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: ../index.php');
    exit();
}elseif($_SESSION['nivel'] == 3 OR $_SESSION['nivel'] == 7){
            $id_user = $_SESSION['id'];
            $usuario = $_SESSION['name_usuario'];
            $nivel = $_SESSION['nivel'];
}else{
    header('Location: ../index.php');
    exit();
}   
include_once 'caja_sections.php';
include_once '../app/logic/conn.php';

// Información de citas del día

$hoy = date("Y-m-d");
$id_user_caja = $id_user;
$sql_cobros = "SELECT 
                caja.id_cita,
                tipos_cita.descrip_cita,
                CONCAT(paciente.nombres,' ',paciente.a_paterno,' ',paciente.a_materno) Nom_Paciente,
                CONCAT(user.nombre,' ',user.apellido) medico_cita, user.usuario, user.iniciales,
                cita.fecha, 
                caja.fecha_cobro,
                caja.subtotal, caja.consulta, caja.descuento, caja.total_cobro, caja.abono, caja.medio_pago,
                caja.abono_efectivo, caja.abono_tarjeta, caja.abono_cheque, caja.abono_otro,
                caja.monto_devolucion
                FROM caja
                INNER JOIN cita ON caja.id_cita = cita.id_cita
                INNER JOIN paciente ON cita.id_paciente = paciente.id_paciente
                INNER JOIN tipos_cita ON cita.tipo = tipos_cita.id_tipo_cita
                LEFT OUTER JOIN user ON cita.medico = user.id AND user.nivel = 'medico'
                WHERE DATE(fecha_cobro) = '$hoy' AND caja.user_cobro = '$id_user_caja' ORDER BY caja.fecha_cobro";
                $res_sql_cobros = $mysqli->query($sql_cobros);
                $val_cobros = $res_sql_cobros->num_rows;

               $sql_vales = "SELECT * FROM vales_salida WHERE fecha_vale = '$hoy' AND id_user = '$id_user'";
               $res_vales = $mysqli->query($sql_vales);
               $val_vales = $res_vales->num_rows;

$sql_val_corte = "SELECT * FROM cortes_caja WHERE cajero_corte = '$id_user' AND fecha_corte = '$hoy'";
                        $res_val_corte = $mysqli->query($sql_val_corte);
                        $val_corte = $res_val_corte->num_rows;



?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arqueo</title>
    <link rel="shortcut icon" href="../static/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../static/css/materialize.css">
    <link rel="stylesheet" href="../static/icons/iconfont/material-icons.css">
    <link rel="stylesheet" href="../../static/css/main.css">
    <script type="text/javascript" src="../static/js/jquery-3.3.1.min.js"></script>
    <script src="../static/js/materialize.js"></script>
    <style>
        .tabla{
            font-size: 11px !important;
            padding: -10 !important;
            margin: -10 !important;
            border: black 1px solid;
            
        }
        td{
            padding: 0;
            border: black 1px solid;
        }
        th{
            padding: 0;
            border: black 1px solid;
        }
        tr{
            border: black 1px solid;
        }
        
    </style>
</head>
<body>
<?php echo $nav_caja;  
?>
<!-- ***************************** INICIA CONTENIDO ****************************** -->
<div class="row center-align">
    <div class="col s2 grey lighten-3" style="margin-bottom: -20px;"> <!-- ***************************** INICIA BARRA LATERAL ****************************** -->
        <div class="row" style="margin-top: 65px;">
            <div class="col s12">
            <h4>Caja</h4>
            </div>
        </div>
        <div class="row">
            <div class="col s12">
            <iframe src="../static/clock/clock.html" width="100%" frameborder="0"></iframe> 
            </div>
        </div>
        <div class="row" style="margin-top: 2em; min-height: 200px;">
            <div class="col s12">
            
            </div>
        </div>
        
    </div>
    <div class="col s10"> <!-- ***************************** INICIA CUERPO DEL SISTEMA ****************************** -->
        <div class="row center-align">
            <div class="col s12">
                <h4 style="color: #2d83a0; font-weight:bold;">CONSULTORIO DE MEDICINA ALTERNATIVA SER</h4>
                <div class="divider"></div>
            </div>
        </div>
        <div class="row">
        <?php 
                if($val_corte == 0){
                ?>
            <div class="col s12">
                <div class="row">
                    <div class="col s12">
                        <h6>Cobros</h6>
                        <?php
                        if($val_cobros > 0){
                            $consecutivo = 1;
                            $total_cobrado = 0;
                            $total_tarjeta = 0;
                            $total_efectivo = 0;
                            $total_cheque = 0;
                            $total_varios = 0;
                            $total_devolucion = 0;
                            ?>
                        <table class="tabla">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Cita</th>
                                <th>Tipo Cita</th>
                                <th>Paciente</th>
                                <th>Médico</th>
                                <th>Fecha Cita</th>
                                <th>Fecha Cobro</th>
                                <th>Efectivo</th>
                                <th>Tarjeta</th>
                                <th>Cheque</th>
                                <th>Otros</th>
                                <th>Pagado</th>
                                <th>Devolución</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php   while($row_cobro = mysqli_fetch_assoc($res_sql_cobros)){ 
                                $total_cobrado = $total_cobrado + $row_cobro['abono'];
                                $total_devolucion = $total_devolucion + $row_cobro['monto_devolucion']; 

                                
                                        $total_efectivo = $total_efectivo + $row_cobro['abono_efectivo'];
                                        $total_tarjeta = $total_tarjeta + $row_cobro['abono_tarjeta'];                                
                                        $total_cheque = $total_cheque + $row_cobro['abono_cheque'];                                
                                        $total_varios = $total_varios + $row_cobro['abono_otro'];
                                        
                                        
                                                                                                        
                                ?>
                                
                                <tr>
                                    <td><?php echo $consecutivo; ?></td>
                                    <td><?php echo $row_cobro['id_cita']; ?></td>
                                    <td><?php echo $row_cobro['descrip_cita'];   ?></td>
                                    <td><?php echo $row_cobro['Nom_Paciente']; ?></td>
                                    <td><?php echo $row_cobro['iniciales']; ?></td>
                                    <td><?php echo $row_cobro['fecha']; ?></td>
                                    <td><?php echo $row_cobro['fecha_cobro']; ?></td>
                                    <td>$ <?php echo $row_cobro['abono_efectivo']; ?></td>
                                    <td>$ <?php echo $row_cobro['abono_tarjeta']; ?></td>
                                    <td>$ <?php echo $row_cobro['abono_cheque']; ?></td>
                                    <td>$ <?php echo $row_cobro['abono_otro']; ?></td>
                                    <td>$ <?php echo $row_cobro['abono']; ?></td>
                                    <td>$ <?php echo $row_cobro['monto_devolucion']; ?></td>
                                    <td>$ <?php echo $row_cobro['abono'] - $row_cobro['monto_devolucion']; ?></td>
                                </tr>
                            <?php
                                $consecutivo ++;
                            }
            ?>
                        <tr>
                            <th colspan="7" style="text-align:center;">Totales</th>
                            <th>$ <?php  echo $total_efectivo; ?></th>
                            <th>$ <?php  echo $total_tarjeta; ?></th>
                            <th>$ <?php  echo $total_cheque; ?></th>
                            <th>$ <?php  echo $total_varios; ?></th>
                            <th>$ <?php  echo $total_cobrado; ?></th>
                            <th>$ <?php  echo $total_devolucion; ?></th>
                            <th>$ <?php  echo $total_cobrado - $total_devolucion; ?></th>
                        </tr>
                        </tbody>
                        </table>


                        <?php   }else{
                            echo '<blockquote>No hay cobros registrados del día</blockquote>';
                        }
                        ?>

                    </div>
                    <!--div class="col s2 left-align">
                        <p>Total Efectivo: $<?php // echo $total_efectivo; ?><br>
                        Total Tarjeta: $<?php // echo $total_tarjeta; ?><br>
                        Total Cheque: $<?php // echo $total_cheque; ?><br>
                        Total Varios: $<?php // echo $total_varios; ?><br>
                        Devoluciones: $<?php // echo $total_devolucion; ?><br>
                        Total Cobrado: <b>$<?php // echo $total_cobrado; ?></b><br>
                        Cobrado (-) Devoluciones: <b>$<?php echo $total_cobrado - $total_devolucion; ?></b></p>


                    </div-->
                </div>
               
                </div>

                <div class="col s12">
                <div class="row">
                    <div class="col s2"></div>
                    <div class="col s8">
                    <h6>Egresos</h6>
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
                        where DATE(fecha_cobro) = '$hoy' AND caja.user_cobro = '$id_user_caja' AND cita.tipo <> 0 ORDER BY fecha_cobro";
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
                    
                    $sql_vales = "SELECT * FROM vales_salida WHERE fecha_vale = '$hoy' AND id_user = '$id_user_caja'";
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
                        
                        ?>
                        <?php 
                    $sql_med_oral = "SELECT rec_med_orales.*, cita.horario, caja.descuento, 
                                        rec_med_orales.monto monto2 
                                        FROM rec_med_orales 
                                        INNER JOIN cita ON cita.id_cita = rec_med_orales.id_cita 
                                        INNER JOIN caja ON rec_med_orales.id_cita = caja.id_cita 
                                        INNER JOIN med_orales ON rec_med_orales.id_med_oral = med_orales.id_med_oral
                                        WHERE DATE(fecha_cobro) = '$hoy' AND caja.user_cobro = '$id_user_caja' and cancelado = 0 AND med_orales.egreso = 1";
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
                            <td style="text-align: center;" colspan="5"><b>TOTAL EGRESOS</b></td>
                            <td style="text-align: center;"><b>$ <?php echo $val_egresos + $val_total_orales; ?></b></td>
                        </tr>
                        </tbody>
                </table>
                        
                    </div>
                    <div class="col s2 left-align">
                        
                    </div>
                </div>
            </div>
            
                
                <?php 
                }else{
                    echo'
                   <div class="row">
                   <div class="col s12">
                   <blockquote style="color: red;">
                        El usuario de la sesión actual ya ejecutó su corte de caja del día por lo que no puede generar un Arqueo.
                    </blockquote>
                    </div>
                    </div>
                   ';
                }
                ?>
            </div>
            
        </div>
    </div>
            </div>
<!-- ***************************** TERMINA CONTENIDO ****************************** -->
<?php echo $footer_caja;  ?>
<script>
    $(document).ready(function(){
    $('select').formSelect();
  });
</script>
</body>
</html>