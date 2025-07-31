<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: ../index.php');
    exit();
}elseif($_SESSION['nivel'] == 5 OR $_SESSION['nivel'] == 7){
            $id_user = $_SESSION['id'];
            $usuario = $_SESSION['name_usuario'];
            $nivel = $_SESSION['nivel'];
}else{
    header('Location: ../index.php');
    exit();
}   
include_once 'farma_sections.php';
include_once '../app/logic/conn.php';


// Información de citas del día

$hoy = date("Y-m-d");
$cita = $_GET['c'];

    $sql_citas = "SELECT DISTINCT cita.id_cita, cita.id_paciente, paciente.id_paciente, cita.medico,
    CONCAT(paciente.nombres,' ',paciente.a_paterno,' ',paciente.a_materno) Nom_paciente,
    CONCAT(user.nombre,' ',user.apellido) medico_cita, cita.fecha, cita.horario, cita.tipo, tipos_cita.descrip_cita, confirma, consulta, caja, pagado
        FROM cita
        INNER JOIN paciente ON cita.id_paciente = paciente.id_paciente
        INNER JOIN tipos_cita on cita.tipo = tipos_cita.id_tipo_cita
        INNER JOIN resu_med_home ON cita.id_cita = resu_med_home.id_cita
        LEFT JOIN user on cita.medico = user.id
        WHERE cita.fecha = '$hoy' AND confirma = 2 AND consulta = 1 AND caja = 1 and pagado = 1 AND cita.tipo = 0
        AND cita.id_cita = '$cita'
        ORDER BY cita.fecha, cita.horario";
    $datos_cita = $mysqli->query($sql_citas);
    $val_datos_cita = $datos_cita->num_rows;
    

    if($val_datos_cita == 1){
        $mensaje_val_cita = "";
        $row_cita = mysqli_fetch_assoc($datos_cita);
        $folio_cita = "CMA".$row_cita['id_cita'];
        $paciente = $row_cita['Nom_paciente'];
        $fecha_cita = date('d/m/Y', strtotime($row_cita['fecha']));
        $horario = $row_cita['horario'];
        $medico = $row_cita['medico_cita'];
    }else{
        $mensaje_val_cita = "Error en la cita con folio CMA".$cita;
        $folio_cita = "";
        $paciente = "";
        $fecha_cita = "";
        $horario = "";
        $medico = "";
    }

$sql_trat_gen = "SELECT resu_med_home.*, tipo_trat_hom.des_tratamiento
FROM resu_med_home
INNER JOIN tipo_trat_hom ON resu_med_home.id_tipo_trat = tipo_trat_hom.id_trat
WHERE id_cita = '$cita' AND cancelado = 0 AND tipo_fras = 'gen'";
$res_trat_gen = $mysqli->query($sql_trat_gen);
$val_trat_gen = $res_trat_gen->num_rows;

if($val_trat_gen == 1){
    $trat_gen = mysqli_fetch_assoc($res_trat_gen);
    $cant_tratamientos = $trat_gen['cant_tratamientos'];
    $tipo_tratamiento = $trat_gen['des_tratamiento'];
    $tipo_dosis = $trat_gen['tipo_dosis'];
    $val_imp_gen = $trat_gen['flag_impr_et'];
    
}else{
    $cant_tratamientos = 0;
    $tipo_tratamiento = "";
    $val_imp_gen = 0;
}


$sql_trat_ext = "SELECT resu_med_home.*, tipo_trat_hom.des_tratamiento
FROM resu_med_home
INNER JOIN tipo_trat_hom ON resu_med_home.id_tipo_trat = tipo_trat_hom.id_trat
WHERE id_cita = '$cita' AND cancelado = 0 AND tipo_fras = 'ext'";
$res_trat_ext = $mysqli->query($sql_trat_ext);
$val_trat_ext = $res_trat_ext->num_rows;

if($val_trat_ext == 1){
    $trat_ext = mysqli_fetch_assoc($res_trat_ext);
    $fras_ext = $trat_ext['cant_tratamientos'];
    $val_imp_ext = $trat_ext['flag_impr_et'];
}else{
    $fras_ext = 0;
    $val_imp_ext = 0;
}

$sql_flores = "SELECT resu_med_home.*, tipo_trat_hom.des_tratamiento
FROM resu_med_home
INNER JOIN tipo_trat_hom ON resu_med_home.id_tipo_trat = tipo_trat_hom.id_trat
WHERE id_cita = '$cita' AND cancelado = 0 AND tipo_fras in ('flo','floc')";
$res_flores = $mysqli->query($sql_flores);
$val_flores = $res_flores->num_rows;

if($val_flores > 0){
    $flores = mysqli_fetch_assoc($res_flores);
    $flores_bach = $val_flores;
    $val_imp_flor = $flores['flag_impr_et'];
}else{
    $flores_bach = 0;
    $val_imp_flor = 0;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle Medicamentos Homeopáticos</title>
    <link rel="shortcut icon" href="../static/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../static/css/materialize.css">
    <link rel="stylesheet" href="../static/icons/iconfont/material-icons.css">
    <link rel="stylesheet" href="../../static/css/main.css">
    <script type="text/javascript" src="../static/js/jquery-3.3.1.min.js"></script>
    <script src="../static/js/materialize.js"></script>
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
<?php echo $nav_caja;  
?>
<!-- ***************************** INICIA CONTENIDO ****************************** -->
<div class="row center-align">
    <div class="col s2 grey lighten-3" style="margin-bottom: -20px;"> <!-- ***************************** INICIA BARRA LATERAL ****************************** -->
        <div class="row" style="margin-top: 65px;">
            <div class="col s12">
            <h4>Farmacia</h4>
            </div>
        </div>
        <div class="row">
            <div class="col s12">
            <iframe src="../static/clock/clock.html" width="100%" frameborder="0"></iframe> 
            </div>
        </div>
        <div class="row" style="margin-top: -2em;">
            <div class="col s12">
            
            </div>
        </div>
        <div class="row">
            
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
            <div class="col s3 left-align">
                <p style="color: red;"><?php echo $mensaje_val_cita; ?></p>
                <h6>Folio Cita: <?php echo $folio_cita; ?></h6>
                <p>Paciente: <?php echo $paciente; ?></p>
                <p>Médico: <?php echo $medico; ?></p>
                <p>Fecha: <?php echo $fecha_cita; ?></p>
                <p>Horario: <?php echo $horario; ?></p>
                <p>Tipo de tratamiento: <b><?php echo $tipo_tratamiento; ?></b></p>
                <p>Cantidad de Tratamientos: <b><?php echo $cant_tratamientos; ?></b></p>
                <p>Tipo de dósis: <b><?php echo $tipo_dosis; ?></b></p>
                <p>Frascos Extra: <?php echo $fras_ext; ?></p>
                <p>Flores de Bach: <?php echo $flores_bach; ?></p>
                <?php 
                if($val_trat_gen + $val_trat_ext > 0){
                    ?>
                <form action="logic/print_pdf_etiquetas.php" method="post" target="_blank">
                    <input type="hidden" name="cita" value="<?php echo $cita ?>">
                    <input type="hidden" name="trat_gen" value="<?php echo $val_trat_gen; ?>">
                    <input type="hidden" name="cant_trat_gen" value="<?php echo $cant_tratamientos; ?>">
                    <input type="hidden" name="trat_ext" value="<?php echo $val_trat_ext ?>">
                    <input type="hidden" name="trat_flores" value="<?php echo $val_flores ?>">
                    <input type="hidden" name="user" value="<?php echo $id_user; ?>">
                    <input type="hidden" name="nom_paciente" value="<?php echo $paciente; ?>">
                    <input type="hidden" name="fecha_cita" value="<?php echo $fecha_cita; ?>">
                    <?php
                    $val_impresion = $val_imp_gen + $val_imp_ext;
                    if($val_impresion == 0){
                        echo'
                        <button class="btn waves-effect waves-light" type="submit" name="action">Impresión de Etiquetas
                                <i class="material-icons right">print</i>
                            </button>
                        ';
                    }else{
                        echo'
                        <p style="color: red;">Las etiquetas de este tratamiento ya fueron impresas</p>
                                
                        ';
                    }
                    ?>
                </form>
                <?php   }
                ?>
                <blockquote style="font-style:italic; font-weight:bold;">
                    Recuerda verificar la información antes de mandar la impresión  con la finalidad de ahorrar material.
                </blockquote>
            </div>
            <div class="col s1"></div>
            <div class="col s7">
            <h6>Detalle Frascos Tratamiento General</h6>
            <?php if($val_trat_gen == 1){
                $sql_det_gen = "SELECT frasco, tipo_fras, CONCAT(med1,', ',med2,', ',med3,', ',med4,', ',med5) MedFrascos
                                FROM rec_med_home
                                WHERE id_cita = '$cita' AND cancelado = 0 AND tipo_fras = 'gen'";
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
                WHERE id_cita = '$cita' AND cancelado = 0 AND tipo_fras = 'ext'";
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

            ?>
            <br>
            <h6>Detalle Flores de Bach</h6>
            <?php if($val_flores > 0){
                $sql_det_flor = "SELECT frasco, tipo_fras, CONCAT(med1,', ',med2,', ',med3,', ',med4,', ',med5) MedFrascos
                                FROM rec_med_home
                                WHERE id_cita = '$cita' AND cancelado = 0 AND tipo_fras in ('flo','floc')";
                $res_det_flor = $mysqli->query($sql_det_flor);
             ?>
             <table>
                 <thead>
                     <tr>
                         <th>Frasco</th>
                         <th>Tipo</th>
                         <th>Medicamentos Frasco</th>
                     </tr>
                 </thead>
                 <tbody>
                     <?php 
                     while($row_det_flor = mysqli_fetch_assoc($res_det_flor)){
                        if($row_det_flor['tipo_fras'] == 'flo'){
                            $tipo_flor = 'Gotas';
                        }else{
                            $tipo_flor = 'Concentrado';
                        }
                         echo"
                         <tr>
                         <td>".$row_det_flor['frasco']."</td>
                         <td>".$tipo_flor."</td>
                         <td>".rtrim($row_det_flor['MedFrascos'],", ")."</td>
                        </tr> 
                         ";
                     }
                     ?>
                 </tbody>
             </table>
             <br>
            <?php   }else{
                echo '<h6 style="color: red;">No hay registro de Flores de Bach</h6>';
            }
            ?>
            </div>
        </div>
    </div>
</div>
<!-- ***************************** TERMINA CONTENIDO ****************************** -->
<?php echo $footer_caja;  ?>
</body>
</html>