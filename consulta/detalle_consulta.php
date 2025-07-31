<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: ../index.php');
    exit();
}elseif($_SESSION['nivel'] == 1 OR $_SESSION['nivel'] == 2){
            $id_user = $_SESSION['id'];
            $usuario = $_SESSION['name_usuario'];
            $nivel = $_SESSION['nivel'];
}else{
    header('Location: ../index.php');
    exit();
}
include_once '../app/logic/conn.php';
include_once 'consulta_sections.php';
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
$val_trat_flores = 0;

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

    <blockquote>
                        Historia Clínica
                    </blockquote>
                    <?php
                    
                     $sql_hcg = "SELECT * FROM his_clinica_gen where id_paciente = '$id_paciente'";
                     $result_sql_his = $mysqli -> query($sql_hcg);
                     $hcg = $result_sql_his -> num_rows;

                    if($hcg == 1){
                        echo '<a href="print_h_clinica.php?id_paciente='.$id_paciente.'" target="_blank">Ver historia clinica</a><br>';
                        echo '<a href="captura_hcg.php?id_paciente='.$id_paciente.'&cita='.$id_cita.'" target="_blank">Actualizar historia clinica</a>';
                    }elseif($hcg == 0){
                        echo '<p>Sin Historia Clínica</p>
                                <a href="captura_hcg.php?id_paciente='.$id_paciente.'&cita='.$id_cita.'">Capturar historia clinica</a>';
                    }elseif($hcg > 1){
                        echo '<a href="">Contacte con el Administrador del Sistema</a>';
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
      <?php 
      if($datos_consulta['id_medico'] == $id_user){
          ?>
            <li class="collection-item"><b>Actualizar Nota de Evolución</b>
                <form action="upd_nota.php" method="post">
                <textarea name="nota_evo" id="" cols="30" rows="50" required autocomplete="off"></textarea>
                <input type="hidden" value = '<?php echo $id_cita;?>' name="id_cita">
                <input type="hidden" value = '<?php echo $id_paciente;?>' name="paciente">
                <div class="center-align">
                    <button class="btn waves-effect waves-light" type="submit" name="action">Actualizar
                    <i class="material-icons right">send</i>
                    </button>
                </div>
                </form>
            </li>
      <?php 
      }
      ?>
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
                    <td><b></b></td>
                  </tr>
                ';
        while($ter_reg = mysqli_fetch_assoc($res_tot_ter)){
            echo '<tr>
                    <td>'.$ter_reg['terapia'].'</td>
                    <td>'.$ter_reg['no_terapias'].'</td>';
                    
                    if($ter_reg['cancelado']==0){
                        echo '<td></td>
                    </tr>';
                    }else{
                        echo '<td>Terapia Cancelada</td></tr>';
                    }
                    
                    }
                    echo '
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
        <td><b>Suero</b></td>
        <td colspan="5"><b>Complementos</b></td>
        <td></td>
      </tr>';
      
    while($row = mysqli_fetch_assoc($result)){
       
        echo'
        <tr>
        <td>'.$row['nom_suero'].'</td>
        <td>'.$row['Complemento1'].'</td>
        <td>'.$row['Complemento2'].'</td>
        <td>'.$row['Complemento3'].'</td>
        <td>'.$row['Complemento4'].'</td>
        <td>'.$row['Complemento5'].'</td>';

        if($row['cancelado'] == 0){
            
            echo '<td></td>
        <tr>';
        }else{
            echo '<td>Suero Cancelado</td>
            <tr>';
        }
        
        
    }
    echo '
        </table><br>';
       
}else{
    echo '<h5>No se registraron <b>sueros</b> de la receta de esta cita</h5>';
}

// *********************** Inicia totales de Medicamentos Homeopaticos *********

$sql_resu = "SELECT id_cita, tipo_fras, tipo_dosis, cant_tratamientos ,tipo_trat_hom.des_tratamiento, tipo_trat_hom.costo, cancelado FROM resu_med_home
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
                    <td><b>No. Tratamientos</b></td>
                    <td><b>Dósis</b></td>
                    <td></td>
                  </tr>
                ';

        while($rows3 = mysqli_fetch_assoc($resumen)){
            if($rows3['tipo_fras']== "gen"){$tipo_frasco = "Principal"; $val_trat_gen = 1;}
            if($rows3['tipo_fras']== "ext"){$tipo_frasco = "Extra"; $val_trat_ext = 1;}
            if($rows3['tipo_fras']== "flo"){$tipo_frasco = "Extra"; $val_trat_flores = 1;}
            $sub_total_trat = $rows3['cant_tratamientos'] * $rows3['costo'];
            echo '<tr>
                    <td>'.$rows3['des_tratamiento'].'</td>
                    <td>'.$rows3['cant_tratamientos'].'</td>
                    <td>'.$rows3['tipo_dosis'].'</td>';

                    if($rows3['cancelado'] == 0){
                        echo '<td></td>
                        </tr>';
                    }else{
                        echo '<td>Cancelado</td>
                        </tr>';
                    }
        }
        echo '
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

            if(($val_trat_ext + $val_trat_flores) >= 1){
                $sql_det_ext = "SELECT frasco, tipo_fras, CONCAT(med1,', ',med2,', ',med3,', ',med4,', ',med5) MedFrascos
                FROM rec_med_home
                WHERE id_cita = '$id_cita' AND cancelado = 0 AND tipo_fras IN ('ext','flo')";
                $res_det_ext = $mysqli->query($sql_det_ext);
                ?>
            <h6>Detalle Frascos Extra y Flores de Bach</h6>
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
                         if($row_det_ext['tipo_fras'] == 'ext'){
                            $t_frasco = "-Extra" ;
                         }else{
                            $t_frasco = "-Flor de Bach" ;
                         }
                         echo"
                         <tr>
                         <td>".$row_det_ext['frasco'].$t_frasco."</td>
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
                    <td></td>
                  </tr>
                ';
        while($rows2 = mysqli_fetch_assoc($res_tot)){
            echo '<tr>
                    <td>'.$rows2['med_oral'].'</td>
                    <td>'.$rows2['cantidad_med'].'</td>
                    ';

                  if($rows2['cancelado'] == 0){
                    
                    echo'<td></td>
                        </tr>';
                        
                }else{
                    echo'<td>Cancelado</td>
                        </tr>';
                        
                    }
                  
        }
        echo '
        </table>';
                
    }else{
        echo '<h5>No se registraron <b>medicamentos orales/nutrientes</b> de la receta de esta cita</h5>';
    }

    ?>
    
</div>
</div>
<div class="container">
</div>

<?php echo $footer_consulta;  ?>
</body>
</html>