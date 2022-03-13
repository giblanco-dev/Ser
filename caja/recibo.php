<?php 
require_once '../app/logic/conn.php';
$id_cobro = $_GET['r'];
//echo $id_cobro;

$sql_pago = "SELECT caja.*,
            CONCAT(paciente.nombres,' ',paciente.a_paterno,' ',paciente.a_materno) Nom_paciente,
            cita.fecha, cita.id_cita, cita.tipo
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
    <link rel="stylesheet" href="../static/css/materialize.css">
    <link rel="stylesheet" href="../static/icons/iconfont/material-icons.css">
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
            <div class="col s8">
                <p>Comprobante de Pago<p>
                <p style="font-size: 8px;">Clínica de Medicina Alternativa SER <br>
                    Elena 9, Colonia Nativitas <br>
                    Del. Benito Juárez, Distrito Federal <br>
                    (55) 5579-9896, 6365-8396</p>
            </div>
            <div class="col s4">
            <img src="../static/img/logo.png" style="max-height: 100px; float:right;">
            </div>
        </div>
        <div class="row">
            <div class="col s6">
            <p style="text-transform: capitalize;"><b>Paciente: <?php echo $recibo['Nom_paciente']; ?></b></p>
            </div>
            <div class="s6">
            <ul class="collection">
                <li class="collection-item"><div>Folio Cita<a href="#!" class="secondary-content">CSA<?php echo $recibo['id_cita']; ?></a></div></li>
                <li class="collection-item"><div>Folio Pago<a href="#!" class="secondary-content"><?php echo $recibo['id_cobro']; ?></a></div></li>
                <li class="collection-item"><div>Fecha Cita<a href="#!" class="secondary-content"><?php echo $recibo['fecha']; ?></a></div></li>
                <li class="collection-item"><div>Fecha Pago<a href="#!" class="secondary-content"><?php echo $recibo['fecha_cobro']; ?></a></div></li>
                <li class="collection-item"><div>Total Pagado<a href="#!" class="secondary-content">$<?php echo $recibo['total_cobro']; ?></a></div></li>
            </ul>
            </div>
        </div>
        <div class="row">
            <div class="col s6">
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
            </div>
            <div class="col s6">
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
                <div class="col s12">
                <div class="divider"></div>
               
                <blockquote style="font-size: 8px;">
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