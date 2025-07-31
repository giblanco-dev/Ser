<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: ../index.php');
    exit();
}elseif($_SESSION['nivel'] == 1 OR $_SESSION['nivel'] == 7){
            $id_user = $_SESSION['id'];
            $usuario = $_SESSION['name_usuario'];
            $nivel = $_SESSION['nivel'];
}else{
    header('Location: ../index.php');
    exit();
}
include_once '../app/logic/conn.php';
include_once 'recep_sections.php';
$id_paciente = $_GET['p'];
$id_cita = $_GET['c'];

$sql_paciente = "SELECT * FROM paciente WHERE id_paciente = '$id_paciente'";
$res_sql_paciente = $mysqli -> query($sql_paciente);
$paciente_val = $res_sql_paciente -> num_rows;

if($paciente_val == 1){
    $datos_paciente = $res_sql_paciente -> fetch_assoc();
}else {
    echo "Hay un error";
}

$val_trat_ext = 0;
$val_trat_gen = 0;
$val_flores = 0;

$sql_pago = "SELECT caja.*,
            CONCAT(paciente.nombres,' ',paciente.a_paterno,' ',paciente.a_materno) Nom_paciente,
            cita.fecha, cita.id_cita, cita.tipo
            FROM caja
            INNER JOIN cita ON caja.id_cita = cita.id_cita
            INNER JOIN paciente ON cita.id_paciente = paciente.id_paciente
            WHERE caja.id_cita = '$id_cita' AND caja.status_pago = 'SI' AND caja.saldo = 0";

$res_pago = $mysqli->query($sql_pago);
$val = $res_pago->num_rows;
//echo "<br>",$val;
if($val == 1){
    $recibo = mysqli_fetch_assoc($res_pago);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle Cita CMA<?php echo $id_cita ?></title>
    <link rel="shortcut icon" href="../static/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../static/css/materialize.css">
    <link rel="stylesheet" href="../static/icons/iconfont/material-icons.css">
    <script src="../static/js/materialize.js"></script>
    <script type="text/javascript" src="../static/js/jquery-3.3.1.min.js"></script>
    <style type="text/css"> 
        thead tr th { 
            position: sticky;
            top: 0;
            z-index: 10;
            background-color: #ffffff;
        }
    
        .table-responsive-2 { 
            height: 500px; /* Mover a 400 para demostrar el scroll*/
            overflow-y:scroll;
        }
    </style>
</head>
<body>
<header>
 <div class="navbar-fixed">
 <nav>
    <div class="nav-wrapper">
      <a href="#" class="responsive-img" class="brand-logo"><img src="../static/img/logo.png" style="max-height: 150px; margin-left: 20px;"></a>
      <ul id="nav-mobile" class="right hide-on-med-and-down">
      <li><a onclick="window.close();"><i class="material-icons right">close</i>Cerrar Detalle</a></li>
      </ul>
    </div>
  </nav>
 </div>
 </header>
<div class="container">
<div class="row center-align">
    <div class="col s12">
    <h5 style="color: #2d83a0; font-weight:bold;">Detalle Cita CMA<?php echo $id_cita; ?> del Paciente
        <span style="text-transform: capitalize;"><?php echo $datos_paciente['nombres']." ".$datos_paciente['a_paterno']; ?></span></h5>
                <div class="divider"></div>
    </div>
</div>
</div>
<div class="row">
<div class="col s4 offset-s1">
    <blockquote>Datos Generales</blockquote>
    <p style="text-transform: capitalize;">Nombre: <?php echo $datos_paciente['nombres']." ".$datos_paciente['a_paterno']." ".$datos_paciente['a_materno']; ?></p>
    <p>Fecha de Nacimiento: <?php echo $datos_paciente['fecha_nacimiento']; ?></p>
    <p>Género: <?php echo $datos_paciente['genero']; ?> </p>
    <blockquote>Detalles del Pago</blockquote>
    <?php 
    if($val == 1){
    $fecha_cita = date("d-m-Y",strtotime($recibo['fecha'])); //
    $fecha_cobro = date("d-m-Y, g:i a",strtotime($recibo['fecha_cobro']));
    ?>
    <ul class="collection">
                <li class="collection-item"><div>Folio Pago<a href="#!" class="secondary-content"><?php echo $recibo['id_cobro']; ?></a></div></li>
                <li class="collection-item"><div>Fecha Cita<a href="#!" class="secondary-content"><?php echo $fecha_cita; ?></a></div></li>
                <li class="collection-item"><div>Fecha Pago<a href="#!" class="secondary-content"><?php echo $fecha_cobro; ?></a></div></li>
                <li class="collection-item"><div>Total Pagado<a href="#!" class="secondary-content">$<?php echo $recibo['total_cobro']; ?></a></div></li>
                <li class="collection-item"><div>Medio Pago<a href="#!" class="secondary-content"><?php echo $recibo['medio_pago']; ?></a></div></li>
            </ul>
    <?php 
    }else{
        echo'
        <ul class="collection">
                <li class="collection-item"><div>Folio Pago<a href="#!" class="secondary-content">Cita sin pago</a></div></li>
        </ul>
        ';
    }
    ?>
    <blockquote>Domicilio</blockquote>
    <p style="text-transform: capitalize;">Calle <?php echo $datos_paciente['calle']; ?>
    No. <?php echo $datos_paciente['num_domicilio']; ?>
    Colonia <?php echo $datos_paciente['colonia']; ?>
    CP. <?php echo $datos_paciente['cod_postal']; ?>, <?php echo $datos_paciente['muni_alcaldia']; ?>.
    <?php echo $datos_paciente['estado']; ?>
    </p>
    <blockquote>Contacto</blockquote>
    <p>Telefóno de Casa: <?php echo $datos_paciente['tel_casa']; ?></p>
    <p>Telefóno de Móvil: <?php echo $datos_paciente['tel_movil']; ?></p>
    <p>Telefóno de Oficina: <?php echo $datos_paciente['tel_oficina']; ?> Ext: <?php echo $datos_paciente['ext_tel']; ?></p>
    <p>Telefóno de Recados: <?php echo $datos_paciente['tel_recados']; ?></p>
    <p>Correo electrónico: <?php echo $datos_paciente['email']; ?></p>
    <blockquote>Otros</blockquote>
    <p style="text-transform: capitalize;">Ocupación: <?php echo $datos_paciente['ocupacion']; ?></p>
    <p style="text-transform: capitalize;">Titular: <?php echo $datos_paciente['nombre_titular']; ?></p>
    
</div>
<div class="col s7">
    <blockquote>Detalle Cita</blockquote>
    <?php 
    $sql_consulta = "SELECT consulta.*, CONCAT(user.nombre,' ',user.apellido) Medico
                    FROM consulta 
                    INNER JOIN user ON consulta.id_medico = user.id
                    WHERE id_cita = '$id_cita'";

    $res_consulta = $mysqli->query($sql_consulta);
    $val = $res_consulta->num_rows;

    if($val == 1){
        $datos_consulta = mysqli_fetch_assoc($res_consulta);
        ?>
      <ul class="collection">
      <li class="collection-item"><b>Médico: </b><?php echo $datos_consulta['Medico']; ?></li>
      <li class="collection-item"><b>Nota de Evolución: </b><?php echo $datos_consulta['nota_evolucion']; ?></li>
      <li class="collection-item"><b>Signos Vitales</b> <br>
                                    <b>T/A: </b> <?php echo $datos_consulta['ta'];?> mm Hg
                                  <b>TEMP: </b> <?php echo $datos_consulta['temp']; ?>°C
                                  <b>FRE C: </b><?php echo $datos_consulta['fre_c']; ?>''
                                  <b>FRE R: </b> <?php echo $datos_consulta['fre_r']; ?>
                                  <b>PESO: </b><?php echo $datos_consulta['peso']; ?> KG
                                  <b> TALLA: </b><?php echo $datos_consulta['talla']; ?> M<br>
                                  <b>OXIGENACIÓN: </b><?php echo $datos_consulta['edad']; ?>%
                                  <b>EDAD: </b><?php echo $datos_consulta['edad']; ?> años
                                 </li>
      <li class="collection-item"><b>ALERGIAS: </b><?php echo $datos_consulta['alergias']; ?></li>
    </ul>
    <?php   }
    
    $sum_terapias = 0;
    $sql_total = "SELECT terapia, indicaciones, monto, no_terapias, cancelado FROM rec_terapias WHERE id_cita = '$id_cita'";
    $res_tot_ter = $mysqli->query($sql_total);
    $tot_ter = $res_tot_ter-> num_rows;

    if($tot_ter > 0){
        echo '
                <table>
                <tr>
                <td colspan="3" style="background-color: #00e5ff;"><b>Terapias registradas previamente</h5></b></td>
                </tr>
                <tr>
                    <td><b>Terapia</b></td>
                    <td><b>Cantidad</b></td>
                    <td><b>Precio</b></td>
                    <td><b>Sub-Total</b></td>
                  </tr>
                ';
        while($ter_reg = mysqli_fetch_assoc($res_tot_ter)){
            echo '<tr>
                    <td>'.$ter_reg['terapia'].' <br> <b>Indicaciones:</b> '.$ter_reg['indicaciones'].' </td>
                    <td>'.$ter_reg['no_terapias'].'</td>
                    <td>$ '.$ter_reg['monto'].'</td>';
                    if($ter_reg['cancelado']==0){
                        echo '<td>$ '.$ter_reg['monto']*$ter_reg['no_terapias'].'</td>
                    </tr>';
                        $sum_terapias = $sum_terapias + ($ter_reg['monto'] * $ter_reg['no_terapias']); 
                    }else{
                        echo '<td>Cancelado</td></tr>';
                    }
                    
            //$sum_terapias = $sum_terapias + ($ter_reg['monto']*$ter_reg['no_terapias']); 
        }
        echo '
            <tr style="background-color: lightgrey;">
            <td colspan="2" style="text-align: right;"><b>Total de terapias</b></td>
            <td colspan="2"><b>$'.$sum_terapias.'</b></td>
            </tr>
            </table><br>';
    }else{
        echo '<h5>No se registraron <b>terapias</b> de la receta de esta cita.</h5>';
    }

    // ******************** Inicia totales de Sueros y Complementos *****************

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
(Select complementos.precio from complementos WHERE complementos.id_comple = rec_sueros.comp6) Precio6,
(Select complementos.nom_complemento from complementos WHERE complementos.id_comple = rec_sueros.comp7) Complemento7,
(Select complementos.precio from complementos WHERE complementos.id_comple = rec_sueros.comp7) Precio7,
rec_sueros.cancelado, rec_sueros.id_registro
FROM rec_sueros
INNER JOIN sueros on rec_sueros.suero = sueros.id_suero
WHERE rec_sueros.id_cita = '$id_cita' ";
$result = $mysqli->query($sql_rec_sueros);
$val_sueros = $result->num_rows;
$total_sueros = 0;
if($val_sueros > 0){
    echo '
    <table>
    <tr>
    <td colspan="6" style="background-color: #00e5ff;"><b>Sueros-Complementos Registrados</b></td>
    <tr>
    <tr>
        <td><b>Suero/Precio</b></td>
        <td colspan="7"><b>Complementos</b></td>
        <td><b>Subtotal</b></td>
      </tr>';
      
    while($row = mysqli_fetch_assoc($result)){
       
        echo'
        <tr>
        <td>'.$row['nom_suero'].'<br> $'.$row['precio'].'</td>
        <td>'.$row['Complemento1'].'<br>$'.$row['Precio1'].'</td>
        <td>'.$row['Complemento2'].'<br>$'.$row['Precio2'].'</td>
        <td>'.$row['Complemento3'].'<br>$'.$row['Precio3'].'</td>
        <td>'.$row['Complemento4'].'<br>$'.$row['Precio4'].'</td>
        <td>'.$row['Complemento5'].'<br>$'.$row['Precio5'].'</td>
        <td>'.$row['Complemento6'].'<br>$'.$row['Precio6'].'</td>
        <td>'.$row['Complemento7'].'<br>$'.$row['Precio7'].'</td>';;

        if($row['cancelado'] == 0){
            $sub_total = $row['precio'] + $row['Precio1'] + $row['Precio2'] + $row['Precio3'] + $row['Precio4'] + $row['Precio5'] + $row['Precio6'] + $row['Precio7'];
            echo '<td>$'.$sub_total.'</td>
        <tr>';
            $total_sueros = $total_sueros + $sub_total;
        }else{
            echo '<td>Cancelado</td>
            <tr>';
            
        }
        
        
    }
        echo'
        <tr style="background-color: lightgrey;">
        <td colspan="4" style="text-align: right;"><b>Total de Sueros y Complementos</b></td>
        <td colspan="3"><b>$'.$total_sueros.'</b></td>
        </tr>
        </table><br>';
}else{
    echo '<h5>No se registraron <b>sueros</b> de la receta de esta cita</h5>';
}

// *********************** Inicia totales de Medicamentos Homeopaticos *********

$sql_resu = "SELECT id_cita, tipo_fras, cant_tratamientos ,tipo_trat_hom.des_tratamiento, tipo_trat_hom.costo, cancelado FROM resu_med_home
INNER JOIN tipo_trat_hom ON id_tipo_trat = id_trat WHERE id_cita = '$id_cita'";
$resumen = $mysqli->query($sql_resu);
$val_resu = $resumen->num_rows;
$total_trat = 0;
if($val_resu > 0){
    
            echo '
            <table>
                <tr>
                    <td colspan="3" style="background-color: #00e5ff;"><b>Tratamiento Homeopático</b></td>
                </tr>
                <tr>
                    <td><b>Tipo tratamiento</b></td>
                    <td><b>Precio</b></td>
                    <td><b>No. Tratamientos</b></td>
                    <td><b>Sub-Total</b></td>
                  </tr>
                ';

        while($rows3 = mysqli_fetch_assoc($resumen)){
            if($rows3['tipo_fras']== "gen"){$tipo_frasco = "Principal"; $val_trat_gen = 1;}
            if($rows3['tipo_fras']== "ext"){$tipo_frasco = "Extra"; $val_trat_ext = 1;}
            if($rows3['tipo_fras']== "flo"){$tipo_frasco = "Extra"; $val_flores = 1;}
            
            $sub_total_trat = $rows3['cant_tratamientos'] * $rows3['costo'];
            echo '<tr>
                    <td>'.$rows3['des_tratamiento'].'</td>
                    <td>'.$rows3['costo'].'</td>
                    <td>'.$rows3['cant_tratamientos'].'</td>';

                    if($rows3['cancelado'] == 0){
                        $sub_total_trat = $rows3['cant_tratamientos'] * $rows3['costo'];
                        $total_trat = $total_trat + $sub_total_trat;
                        echo '<td>$ '.$sub_total_trat.'</td>
                        </tr>';
                    }else{
                        echo '<td>Cancelado</td>
                        </tr>';
                    }
        }
        echo '
        <tr style="background-color: lightgrey;">
        <td colspan="2" style="text-align: right;"><b>Total Tratamiento Medicamentos Homeopáticos</b></td>
        <td colspan="2"><b>$'.$total_trat.'</b></td>
        </tr>
        </table><br>';
?>

<h6>Detalle Frascos Tratamiento General</h6>
            <?php if($val_trat_gen == 1){
                $sql_det_gen = "SELECT frasco, tipo_fras, CONCAT(med1,', ',med2,', ',med3,', ',med4,', ',med5) MedFrascos
                                FROM rec_med_home
                                WHERE id_cita = '$id_cita' AND cancelado = 0 AND tipo_fras = 'gen'";
                $res_det_gen = $mysqli->query($sql_det_gen);
             ?>
             <table>
                 <thead>
                     <tr>
                         <th>Frasco</th>
                         <th>Medicamentos Frasco</th>
                     </tr>
                 </thead>
                 <tbody>
                     <?php 
                     while($row_det_gen = mysqli_fetch_assoc($res_det_gen)){
                         echo"
                         <tr>
                         <td>".$row_det_gen['frasco']."</td>
                         <td>".rtrim($row_det_gen['MedFrascos'],", ")."</td>
                        </tr> 
                         ";
                     }
                     ?>
                 </tbody>
             </table>
             <br>
            <?php   }else{
                echo '<h6 style="color: red;">No hay registro de tratamiento</h6>';
            }

            if($val_trat_ext == 1){
                $sql_det_ext = "SELECT frasco, tipo_fras, CONCAT(med1,', ',med2,', ',med3,', ',med4,', ',med5) MedFrascos
                FROM rec_med_home
                WHERE id_cita = '$id_cita' AND cancelado = 0 AND tipo_fras = 'ext'";
                $res_det_ext = $mysqli->query($sql_det_ext);
                ?>
            <h6>Detalle Frascos Extra</h6>
                <table>
                <thead>
                     <tr>
                         <th>Frasco</th>
                         <th>Medicamentos Frasco</th>
                     </tr>
                </thead>
                <tbody>
                     <?php 
                     while($row_det_ext = mysqli_fetch_assoc($res_det_ext)){
                         echo"
                         <tr>
                         <td>".$row_det_ext['frasco']."-Extra</td>
                         <td>".rtrim($row_det_ext['MedFrascos'],", ")."</td>
                        </tr> 
                         ";
                     }
                     ?>
                 </tbody>
                </table>

            <?php   }else{
                echo "<h6>No hay registro de frascos extra</h6>";
            }

            

        if($val_flores == 1){
                $sql_det_floresb = "SELECT frasco, tipo_fras, CONCAT(med1,', ',med2,', ',med3,', ',med4,', ',med5) MedFrascos
                FROM rec_med_home
                WHERE id_cita = '$id_cita' AND cancelado = 0 AND tipo_fras = 'flo'";
                $res_det_floresb = $mysqli->query($sql_det_floresb);
                ?>
            <h6>Detalle Flores de Bach</h6>
                <table>
                <thead>
                     <tr>
                         <th>Frasco</th>
                         <th>Medicamentos Frasco</th>
                     </tr>
                </thead>
                <tbody>
                     <?php 
                     while($row_det_floresb = mysqli_fetch_assoc($res_det_floresb)){
                         echo"
                         <tr>
                         <td>".$row_det_floresb['frasco']."-Extra</td>
                         <td>".rtrim($row_det_floresb['MedFrascos'],", ")."</td>
                        </tr> 
                         ";
                     }
                     ?>
                 </tbody>
                </table>

            <?php   }else{
                echo "<h6>No hay registro de Flores de Bach</h6>";
            }

            ?>



<?php   }else{
    echo '<h5>No se registraron <b>medicamentos homeopáticos</b> de la receta de esta cita</h5>';
}

// Total medicamentos orales

$sum_orales = 0;
    $sql_total = "SELECT med_oral, indicaciones, cantidad_med, monto, cancelado FROM rec_med_orales WHERE id_cita = '$id_cita'";
    $res_tot = $mysqli->query($sql_total);
    $total = $res_tot-> num_rows;

    if($total > 0){
        echo '
                <table>
                <tr>
                <td colspan="3" style="background-color: #00e5ff;"><b>Medicamentos Orales registrados</b></td>
                </tr>
                <tr>
                    <td><b>Medicamento Oral</b></td>
                    <td><b>Cantidad</b></td>
                    <td><b>Precio</b></td>
                    <td><b>Sub-Total</b></td>
                  </tr>
                ';
        while($rows2 = mysqli_fetch_assoc($res_tot)){
            echo '<tr>
                    <td>'.$rows2['med_oral'].'</td>
                    <td>'.$rows2['cantidad_med'].'</td>
                    <td>$ '.$rows2['monto'].'</td>';

                  if($rows2['cancelado'] == 0){
                    $total_med = $rows2['monto'] * $rows2['cantidad_med'];
                    echo'<td>$ '.$total_med.'</td>
                        </tr>';
                        
                }else{
                    echo'<td>Cancelado</td>
                        </tr>';
                        $total_med = 0;
                    }
                  
            $sum_orales = $sum_orales + $total_med; 
        }
        echo '
                <tr style="background-color: lightgrey;">
                <td colspan="2" style="text-align: right;"><b>Total de medicamentos orales</b></td>
                <td colspan="2"><b>$'.$sum_orales.'</b></td>
                </tr>
        </table>';
                
    }else{
        echo '<h5>No se registraron <b>medicamentos orales/nutrientes</b> de la receta de esta cita</h5>';
    }

    ?>
    
</div>
</div>

<div class="container">


</div>

<?php echo $footer_recep;  ?>
</body>
</html>