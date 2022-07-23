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
                CONCAT(user.nombre,' ',user.apellido) medico_cita,
                cita.fecha, 
                caja.fecha_cobro,
                caja.subtotal, caja.consulta, caja.descuento, caja.total_cobro, caja.abono, caja.medio_pago,
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
            font-size: 10px !important;
            padding: -10 !important;
            margin: -10 !important;
            
        }
        td{
            padding: 0;
        }
        th{
            padding: 0;
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
                    <div class="col s10">
                        <h6>Cobros</h6>
                        <?php
                        if($val_cobros > 0){
                            $total_cobrado = 0;
                            $total_tarjeta = 0;
                            $total_efectivo = 0;
                            $total_cheque = 0;
                            $total_varios = 0;
                            $total_devolucion = 0;
                            ?>
                        <table>
                        <thead>
                            <tr>
                                <th>Cita</th>
                                <th>Tipo Cita</th>
                                <th>Paciente</th>
                                <th>Médico</th>
                                <th>Fecha Cita</th>
                                <th>Fecha Cobro</th>
                                <th>Pagado</th>
                                <th>Devolución</th>
                                <th>Medio de Pago</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php   while($row_cobro = mysqli_fetch_assoc($res_sql_cobros)){ 
                                $total_cobrado = $total_cobrado + $row_cobro['abono'];
                                $total_devolucion = $total_devolucion + $row_cobro['monto_devolucion']; 

                                switch($row_cobro['medio_pago']){
                                    case 'EFECTIVO':
                                        $total_efectivo = $total_efectivo + $row_cobro['abono'] - $row_cobro['monto_devolucion'];
                                        break;
                                    case 'TARJETA(CRED-DEB)':
                                        $total_tarjeta = $total_tarjeta + $row_cobro['abono'] - $row_cobro['monto_devolucion'];
                                        break;
                                    case 'CHEQUE':
                                        $total_cheque = $total_cheque + $row_cobro['abono'] - $row_cobro['monto_devolucion'];
                                        break;
                                    case 'OTRAS':
                                        $total_varios = $total_varios + $row_cobro['abono'] - $row_cobro['monto_devolucion'];
                                        break;
                                }
                                
                                ?>
                                
                                <tr>
                                    <td><?php echo $row_cobro['id_cita']; ?></td>
                                    <td><?php echo $row_cobro['descrip_cita'];   ?></td>
                                    <td><?php echo $row_cobro['Nom_Paciente']; ?></td>
                                    <td><?php echo $row_cobro['medico_cita']; ?></td>
                                    <td><?php echo $row_cobro['fecha']; ?></td>
                                    <td><?php echo $row_cobro['fecha_cobro']; ?></td>
                                    <td><?php echo $row_cobro['abono']; ?></td>
                                    <td><?php echo $row_cobro['monto_devolucion']; ?></td>
                                    <td><?php echo $row_cobro['medio_pago']; ?></td>
                                </tr>
                            <?php
                            }
            ?>
                        </tbody>
                        </table>


                        <?php   }else{
                            echo '<blockquote>No cobros registrados del día</blockquote>';
                        }
                        ?>

                    </div>
                    <div class="col s2 left-align">
                        <p>Total Efectivo: $<?php echo $total_efectivo; ?><br>
                        Total Tarjeta: $<?php echo $total_tarjeta; ?><br>
                        Total Cheque: $<?php echo $total_cheque; ?><br>
                        Total Varios: $<?php echo $total_varios; ?><br>
                        Devoluciones: $<?php echo $total_devolucion; ?><br>
                        Total Cobrado: <b>$<?php echo $total_cobrado; ?></b><br>
                        Cobrado (-) Devoluciones: <b>$<?php echo $total_cobrado - $total_devolucion; ?></b></p>


                    </div>
                </div>
               
                </div>

                <div class="col s12">
                <div class="row">
                    <div class="col s10">
                        <h6>Vales de Salida del día</h6>
                        <?php
                        $total_vales = 0;
                        if($val_vales > 0){
                            
                            ?>
                        <table>
                        <thead>
                            <tr>
                                <th>Concepto</th>
                                <th>Cantidad</th>
                                <th>Recibe</th>
                                <th>Autoriza</th>
                                <th>Registra</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php   while($vales_reg = mysqli_fetch_assoc($res_vales)){ 
                                $total_vales = $total_vales + $vales_reg['cantidad'];
                                ?>
                                <tr>
                                    <td><?php echo $vales_reg['concepto']; ?></td>
                                    <td><?php echo $vales_reg['cantidad'];   ?></td>
                                    <td><?php echo $vales_reg['beneficiario']; ?></td>
                                    <td><?php echo $vales_reg['autorizador']; ?></td>
                                    <td><?php echo $vales_reg['user']; ?></td>
                                </tr>
                            <?php
                            }
            ?>
        </tbody>
    </table>

                        <?php
                        }else{
                            echo '<blockquote>No hay vales de salida registrados del día</blockquote>';
                        }
                        ?>
                        
                    </div>
                    <div class="col s2 left-align">
                        <p>Total Vales: <b>$<?php echo $total_vales; ?></b></p>
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