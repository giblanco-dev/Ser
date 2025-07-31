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

// Información de CORTE DEL DIA

$hoy = date("Y-m-d");
$sql_val_corte = "SELECT * FROM cortes_caja WHERE cajero_corte = '$id_user' AND fecha_corte = '$hoy'";
                        $res_val_corte = $mysqli->query($sql_val_corte);
                        $val_corte = $res_val_corte->num_rows;

$cita = $_GET['c'];

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Caja</title>
    <link rel="shortcut icon" href="../static/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../static/css/materialize.css">
    <link rel="stylesheet" href="../static/icons/iconfont/material-icons.css">
    <link rel="stylesheet" href="../../static/css/main.css">
    <script type="text/javascript" src="../static/js/jquery-3.3.1.min.js"></script>
    <script src="../static/js/materialize.js"></script>
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
            <div class="col s1"></div>
            <div class="col s4">

            <?php 
            $sql_pago = "SELECT caja.*,
            CONCAT(paciente.nombres,' ',paciente.a_paterno,' ',paciente.a_materno) Nom_paciente,
            cita.fecha, cita.id_cita, cita.tipo
            FROM caja
            INNER JOIN cita ON caja.id_cita = cita.id_cita
            INNER JOIN paciente ON cita.id_paciente = paciente.id_paciente
            WHERE caja.id_cita = '$cita' AND caja.status_pago = 'SI' AND caja.saldo = 0";

            $res_pago = $mysqli->query($sql_pago);
            $val = $res_pago->num_rows;
            $recibo = mysqli_fetch_assoc($res_pago);
            ?>

                <table> 
                    <thead>
                        <tr>
                            <th>Tratamiento</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($recibo['tipo'] > 0){
                            $tipo = $recibo['tipo'];
                            $sql_tipo = "SELECT descrip_cita FROM tipos_cita WHERE id_tipo_cita = '$tipo'";
                            $res_tipo = $mysqli->query($sql_tipo);
                            $row_tipo = mysqli_fetch_assoc($res_tipo);
                            $descrip_tipo = $row_tipo['descrip_cita'];

                            echo'<tr>
                                    <td>'.$descrip_tipo.'</td>
                                    <td>'.$recibo['subtotal'].'</td>
                                   
                                </tr>';
                        }else{
                            ?>
                        <tr>
                            <td>Consulta</td>
                            <td><?php if($recibo['consulta']>0){echo "$ ",$recibo['consulta'];}?></td>
                            
                        </tr>
                        <tr>
                            <td>Terapias</td>
                            <td><?php if($recibo['total_terapias']>0){echo "$ ",$recibo['total_terapias'];}?></td>
                            
                        </tr>
                        <tr>
                            <td>Sueros</td>
                            <td><?php if($recibo['total_sueros']>0){echo "$ ",$recibo['total_sueros'];}?></td>
                            
                        </tr>
                        <tr>
                            <td>Medicamento Homeopático</td>
                            <td><?php if($recibo['total_homeopaticos']>0){echo "$ ",$recibo['total_homeopaticos'];}?></td>
                            
                        </tr>
                        <tr>
                            <td>Medicamentos Orales</td>
                            <td><?php if($recibo['total_orales']>0){echo "$ ",$recibo['total_orales'];}?></td>
                        </tr>
                           <?php }
                        ?>
                        
                    </tbody>
                </table>

                <table>
                  <thead>
                        <tr>
                            <th colspan="2">Resumen</th>
                        </tr>
                    </thead>
                      <tbody>
                      <tr>
                            <td></td>
                            <td></td>
                            <td><b>Subtotal</b></td>
                            <td>$ <?php echo $recibo['subtotal']; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td><b>Descuento</b></td>
                            <td><?php echo $recibo['descuento']; ?> %</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td><b>Total</b></td>
                            <td>$ <?php echo $recibo['total_cobro']; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td><b>Pagado</b></td>
                            <td>$ <?php echo $recibo['abono']; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td><b>Forma de Pago</b></td>
                            <td><?php echo $recibo['medio_pago']; ?></td>
                        </tr>
                      </tbody>
                  </table>          


        
            </div>
            <div class="col s6">
                <?php 
                if($val_corte == 0){
                ?>
                <div class="row">
                    <div class="col s12">
                    <h5>Generar Devolución de la Cita CMA<?php echo $cita; ?></h5>
                    </div>
                </div>
                <form action="logic_caja/save_devolucion.php" method="POST">
                    <input type="hidden" name="fecha_devo" value="<?php echo $hoy; ?>">
                    <input type="hidden" name="cajero" value="<?php echo $usuario; ?>">
                    <input type="hidden" name="id_cajero" value="<?php echo $id_user; ?>">
                    <input type="hidden" name="id_cobro" value="<?php echo $recibo['id_cobro']; ?>">
                    <div class="row">
                    <div class="input-field col s6">
                    <input id="mont" type="number" class="validate" min="1" max="<?php echo $recibo['abono']; ?>" name="cantidad">
                    <label for="mont">Cantidad de la Devolución</label>
                    </div>
                    <div class="input-field col s6">
                        <select name="autoriza">
                        <option value="" disabled selected>Eliga Autorizador</option>
                        <option value="Dra. Mónica">Dra. Mónica Martinez</option>
                        <option value="Dr. Enrique">Dr. Enrique Martinez</option>
                        <option value="Admin">Administrador</option>
                        </select>
                        <label>Autoriza</label>
                    </div>
                    </div>
                    <div class="row">
                    <div class="input-field col s12">
                    <textarea id="textarea1" class="materialize-textarea" name="concepto"></textarea>
                    <label for="textarea1">Motivo de la Devolución</label>
                    </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <button class="btn waves-effect waves-light" type="submit" name="action">Devolver
                                <i class="material-icons right">save</i>
                            </button>
                        </div>
                    </div>
                </form>
                <?php 
                }else{
                    echo'
                   <div class="row">
                   <div class="col s12">
                   <h5>Generar Devolución de la Cita CMA'.$cita.'</h5>
                   <blockquote style="color: red;">
                        El usuario de la sesión actual ya ejecutó su corte de caja del día, ya no puede generar devoluciones.
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