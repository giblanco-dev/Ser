<?php 
require_once '../app/logic/conn.php';
$id_cobro = $_GET['r'];
//echo $id_cobro;

$sql_pago = "SELECT caja.*,
            CONCAT(paciente.nombres,' ',paciente.a_paterno,' ',paciente.a_materno) Nom_paciente,
            cita.fecha, cita.id_cita, cita.tipo, paciente.id_paciente
            FROM caja
            INNER JOIN cita ON caja.id_cita = cita.id_cita
            INNER JOIN paciente ON cita.id_paciente = paciente.id_paciente
            WHERE caja.id_cobro = '$id_cobro' AND caja.status_pago = 'SI' AND caja.saldo = 0";

$res_pago = $mysqli->query($sql_pago);
$val = $res_pago->num_rows;
//echo "<br>",$val;
if($val == 1){
    $recibo = mysqli_fetch_assoc($res_pago);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../static/bootstrap/css/bootstrap.min.css">
    <script type="text/javascript" src="../static/js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="../static/js/jquery.PrintArea.js"></script>
    <script src="../static/js/materialize.js"></script>
    <title>Recibo Pago <?php echo "CMA",$recibo['id_cita'],"/",$recibo['fecha_cobro']; ?></title>
    <script>
        $(document).ready(function(){
        $("#printButton").click(function(){
            var mode = 'iframe'; //popup
            var close = mode == "popup";
            var options = { mode : mode, popClose : close};
        $("div.recibo").printArea( options );
    });
});
    </script>
</head>
<body style="max-width:12cm; max-height: 18cm;"> 
    
    <!--div style="margin: 2%; background-color:#FFF;">
        <div class="row">
            <div class="col s12 m6 center-align" style="padding: 1%;">
                <a href="javascript:void(0);" id="printButton" class="waves-effect waves-light btn"><i class="material-icons right">print</i>Imprime o guarda recibo</a>
            </div>
            <div class="col s12 m6 center-align" style="padding: 1%;">
            <button onclick="window.close();" class="btn red">Cerrar</button>
            </div>
        </div>
    </div-->
    <!-- ************* INICIA RECIBO ***************************** -->
    <div id="recibo" style="font-size: x-small;">
        <div class="row">
            <div class="col-8">
                <p style="text-align: center;"><b>COMPROBANTE DE PAGO</b><p>
                <p style="font-size: 10px;">Clínica de Medicina Alternativa SER <br>
                    Elena 9, Colonia Nativitas <br>
                    Del. Benito Juárez, Distrito Federal <br>
                    (55) 5579-9896, 6365-8396</p>
            </div>
            <div class="col-4">
            <img src="../static/img/logo.png" style="max-height: 80px; float:right;">
            </div>
        </div>
        <div class="row">
            <div class="col-6">
            <p style="text-transform: capitalize; font-size: 20px;"><b><?php echo $recibo['Nom_paciente']; ?></p>
            <p style="font-size: 12px;">CMA<?php echo $recibo['id_paciente']?></b></p>
            </div>
            <div class="col-6">
            <?php 
                $fecha_cita = date("d-m-Y",strtotime($recibo['fecha'])); //
                $fecha_cobro = date("d-m-Y, g:i a",strtotime($recibo['fecha_cobro']));
                ?>
            <table style="padding: 0;" class="table table-bordered table-sm">
                <tr>
                    <td>Folio Cita</td>
                    <td style="text-align: center;"><?php echo $recibo['id_cita']; ?></td>
                </tr>
                <tr>
                    <td>Folio Comprobante</td>
                    <td style="text-align: center;"><?php echo $recibo['id_cobro']; ?></td>
                </tr>
                <tr>
                    <td>Fecha</td>
                    <td style="text-align: center;"><?php echo $fecha_cita ?></td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td style="text-align: center;">$<?php echo $recibo['total_cobro']; ?></td>
                </tr>
            </table>
            </div>
        </div>
        <div class="row" style="margin-top: -10px;">
            <div class="col-12">
                <table class="table table-bordered table-sm" style="font-size: 12px;">
                    <thead>
                        <tr>
                            <th>Tratamiento</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
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
                                    <td></td>
                                    <td>'.$recibo['subtotal'].'</td>
                                    <td>'.$recibo['subtotal'].'</td>
                                   
                                </tr>';
                        }else{
                            // Se imprimen terapias cobradas
                            $id_cita = $recibo['id_cita'];
                            $sql_terapias = "SELECT terapia, no_terapias, terapias.precio, rec_terapias.monto FROM rec_terapias 
                            INNER JOIN terapias ON rec_terapias.id_terapia = terapias.id_terapia
                            WHERE id_cita = '$id_cita' AND cancelado = 0";
                            $res_terapias = $mysqli->query($sql_terapias);
                            $val_terapias = $res_terapias->num_rows;
                            if($val_terapias > 0){
                                while($terapias = mysqli_fetch_assoc($res_terapias)){
                                    echo '
                                <tr>
                                    <td>'.$terapias['terapia'].'</td>
                                    <td>'.$terapias['no_terapias'].'</td>
                                    <td>$ '.$terapias['precio'].'</td>
                                    <td>$ '.$terapias['monto'].'</td>
                                </tr>
                                ';    
                                }    
                            }
                            // Se imprimen sueros y complementos
                            $sql_rec_sueros = "SELECT sueros.nom_suero, sueros.precio,
                            (Select complementos.nom_complemento from complementos WHERE complementos.id_comple = rec_sueros.comp1) Complemento1,
                            (Select complementos.precio from complementos WHERE complementos.id_comple = rec_sueros.comp1) Precio1,
                            (Select complementos.nom_complemento from complementos WHERE complementos.id_comple = rec_sueros.comp2) Complemento2,
                            (Select complementos.precio from complementos WHERE complementos.id_comple = rec_sueros.comp2) Precio2,
                            (Select complementos.nom_complemento from complementos WHERE complementos.id_comple = rec_sueros.comp3) Complemento3,
                            (Select complementos.precio from complementos WHERE complementos.id_comple = rec_sueros.comp3) Precio3,
                            (Select complementos.nom_complemento from complementos WHERE complementos.id_comple = rec_sueros.comp4) Complemento4,
                            (Select complementos.precio from complementos WHERE complementos.id_comple = rec_sueros.comp4) Precio4,
                            (Select complementos.nom_complemento from complementos WHERE complementos.id_comple = rec_sueros.comp5) Complemento5,
                            (Select complementos.precio from complementos WHERE complementos.id_comple = rec_sueros.comp5) Precio5,
                            (Select complementos.nom_complemento from complementos WHERE complementos.id_comple = rec_sueros.comp6) Complemento6,
                            (Select complementos.precio from complementos WHERE complementos.id_comple = rec_sueros.comp5) Precio6,
                            rec_sueros.cancelado, rec_sueros.id_registro
                            FROM rec_sueros
                            INNER JOIN sueros on rec_sueros.suero = sueros.id_suero 
                            WHERE rec_sueros.id_cita = '$id_cita' AND cancelado = 0";
                            $result_suero_comp = $mysqli->query($sql_rec_sueros);
                            $val_sueros = $result_suero_comp->num_rows;
                            $total_sueros = 0;
                            
                            
                            if($val_sueros > 0){
                                $no_complementos = 0;
                                $monto_complementos = 0;
                                while($row_suero = mysqli_fetch_assoc($result_suero_comp)) {
                                    if($row_suero['Complemento1'] != NULL){
                                        $no_complementos ++;
                                        $monto_complementos = $monto_complementos + $row_suero['Precio1'];
                                    }
                                    if($row_suero['Complemento2'] != NULL){
                                        $no_complementos ++;
                                        $monto_complementos = $monto_complementos + $row_suero['Precio2'];
                                    }
                                    if($row_suero['Complemento3'] != NULL){
                                        $no_complementos ++;
                                        $monto_complementos = $monto_complementos + $row_suero['Precio3'];
                                    }
                                    if($row_suero['Complemento4'] != NULL){
                                        $no_complementos ++;
                                        $monto_complementos = $monto_complementos + $row_suero['Precio4'];
                                    }
                                    if($row_suero['Complemento5'] != NULL){
                                        $no_complementos ++;
                                        $monto_complementos = $monto_complementos + $row_suero['Precio5'];
                                    }
                                    if($row_suero['Complemento6'] != NULL){
                                        $no_complementos ++;
                                        $monto_complementos = $monto_complementos + $row_suero['Precio6'];
                                    }
                                

                                    echo '
                                <tr>
                                    <td>'.$row_suero['nom_suero'].'</td>
                                    <td>1</td>
                                    <td>$ '.$row_suero['precio'].'</td>
                                    <td>$ '.$row_suero['precio'].'</td>
                                </tr>
                                ';  
                                }
                                    echo '
                                    <tr>
                                        <td>Complementos de suero</td>
                                        <td>'.$no_complementos.'</td>
                                        <td>$ '.$monto_complementos.'</td>
                                        <td>$ '.$monto_complementos.'</td>
                                    </tr>
                                    ';  


                            }


                            ?>
                        <?php if($recibo['consulta']>0){
                        echo '
                        <tr>
                            <td>Consulta</td>
                            <td>1</td>
                            <td>$ '.$recibo['consulta'].'</td>
                            <td>$ '.$recibo['consulta'].'</td>
                        </tr>
                        ';  
                        
                        
                        }
                        
                        if($recibo['total_homeopaticos']>0){
                            $sql_detalle_trat_hom = "SELECT id_cita, tipo_fras, tipo_trat_hom.des_tratamiento, tipo_trat_hom.costo, tipo_fras, tipo_dosis, cant_tratamientos,
                            (costo * cant_tratamientos) total_tipotrat_hom
                            FROM `resu_med_home` 
                            INNER JOIN tipo_trat_hom ON resu_med_home.id_tipo_trat = tipo_trat_hom.id_trat
                            WHERE id_cita = '$id_cita' and cancelado = 0";
                            $res_dettrat_hom = $mysqli->query($sql_detalle_trat_hom);
                            while($tra_home = mysqli_fetch_assoc($res_dettrat_hom)){
                                if($tra_home['tipo_fras'] == 'gen'){
                                    $tratamiento_home = 'Medicamento Homeopático <br> <b>Dosis '.$tra_home['tipo_dosis'].'<b>';
                                    $canttida_trat_home = $tra_home['cant_tratamientos'];
                                }else{
                                    $tratamiento_home = $tra_home['des_tratamiento'];
                                    $canttida_trat_home = $tra_home['cant_tratamientos'];
                                }
                                echo '
                            <tr>
                                
                                <td>'.$tratamiento_home.'</td>
                                <td>'.$canttida_trat_home.'</td>
                                <td>$ '.$tra_home['costo'].'</td>
                                <td>$ '.$tra_home['total_tipotrat_hom'].'</td>
                            </tr>
                            ';        
                            }
                            }
                            if($recibo['total_orales']>0){
                            $sql_deta_medoral = "SELECT id_med_oral, med_oral, cantidad_med, monto, (cantidad_med*monto) total_med_oral 
                                                    FROM `rec_med_orales` where id_cita = '$id_cita' and cancelado = 0";    
                                $res_det_medoral = $mysqli->query($sql_deta_medoral);
                                while($row_det_med_oral = mysqli_fetch_assoc($res_det_medoral)){
                                    echo '
                                        <tr>
                                            
                                            <td>'.$row_det_med_oral['med_oral'].'</td>
                                            <td>'.$row_det_med_oral['cantidad_med'].'</td>
                                            <td>$ '.$row_det_med_oral['monto'].'</td>
                                            <td>$ '.$row_det_med_oral['total_med_oral'].'</td>
                                        </tr>
                                        ';        
                                }
                            
                            }
                         }
                        ?>
                        
                    </tbody>

                </table>
            </div>
            <div class="col-6" style="margin-top: -10px;"></div>
            <div class="col-6" style="margin-top: -10px;">
                  <table style="width: 100%;" class="table table-bordered table-sm">
                      <tbody>
                      <tr>

                            <td><b>Subtotal</b></td>
                            <td>$ <?php echo $recibo['subtotal']; ?></td>
                        </tr>
                        <tr>
                            <td><b>Descuento</b></td>
                            <td><?php echo $recibo['descuento']; ?> %</td>
                        </tr>
                        <tr>
                            <td><b>Total</b></td>
                            <td>$ <?php echo $recibo['total_cobro']; ?></td>
                        </tr>
                        <tr>
                            <td><b>Pagado</b></td>
                            <td>$ <?php echo $recibo['abono']; ?></td>
                        </tr>
                        <?php 
                        if($recibo['monto_devolucion'] > 0){
                            ?>
                        <tr>
                            <td><b>Devolución</b></td>
                            <td>$ <?php echo $recibo['monto_devolucion']?></td>
                        </tr>
                        <tr>
                            <td><b>Pagado(-)Devolución</b></td>
                            <td><b>$ <?php echo $recibo['abono'] - $recibo['monto_devolucion'];  ?></b></td>
                        </tr>
                            <?php
                        }
                        ?>
                      </tbody>
                  </table>          

            </div>
                <div class="col-12">
                <div class="divider"></div>
               
                <blockquote style="font-size: 10px;">
                El presente comprobante tiene una vigencia de 8 días por lo que se recomienda la liquidación de
                los pendientes dentro del periodo mencionado.
                Para dudas o aclaraciones favor de comunicarse a los números indicados en el encabezado de
                este comprobante.
                </blockquote>
                </div>
            
        </div>
    </div>

    <?php 
    }else{
        echo "<h1>ERROR No hay información para generar recibo. Favor de contactar a Sistemas</h1>";
    }
    ?>
</body>
</html>