<?php
include_once '../../app/logic/conn.php';
$cita = $_GET['c'];
$usuario = $_GET['u'];
$paciente = $_GET['p'];

$sql_tratamientos = "SELECT resu_med_home.id_cita, tipo_fras, tipo_dosis, cant_tratamientos ,tipo_trat_hom.des_tratamiento ,date_format(cita.fecha, '%d/%m/%Y') fecha_format,cita.fecha,tipo_trat_hom.costo, 
cancelado,
user.iniciales,
IF(cita.pagado = 0, 'Sin pago', 'Pagado') Estatus_Pago
FROM resu_med_home
INNER JOIN cita ON resu_med_home.id_cita = cita.id_cita
INNER JOIN user ON cita.medico = user.id
INNER JOIN tipo_trat_hom ON id_tipo_trat = id_trat 
WHERE cita.id_paciente = '$paciente' and cancelado = 0 and tipo_fras  = 'gen';";

$res_sql_trat = $mysqli->query($sql_tratamientos);
$tot_tratamientos = $res_sql_trat->num_rows;



?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../static/css/main.css">
    <link rel="stylesheet" href="../../static/css/materialize.css">
    <link rel="stylesheet" href="../../static/icons/iconfont/material-icons.css">
    <link rel="stylesheet" type="text/css" href="../../static/css/select2.min.css">
    <script type="text/javascript" src="../../static/js/jquery-3.3.1.min.js"></script>
    <script src="../../static/js/select2.min.js"></script>
    <title>Copiar Medicamentos Homeopáticos</title>
    </head>
<body>
    <div class="row">
      <div class="col s12">
        <h4>Todos los tratamientos del Paciente </h4>     
      </div>
    </div>
    <div class="row">
        <div class="col s12">
            <table>
                <thead>
                    <tr>
                        <th>Tipo Frasco</th>
                        <th>Fecha</th>
                        <th>Médico</th>
                        <th>Estatus Cita</th>
                        <th>Frascos</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if($tot_tratamientos > 0){
                        while($trat = mysqli_fetch_assoc($res_sql_trat)){
                            $id_cita_trat = $trat['id_cita'];
                            $tipo_fras = $trat['tipo_fras'];
                            $sql_det_fras = "SELECT frasco, tipo_fras, CONCAT(med1,', ',med2,', ',med3,', ',med4,', ',med5) MedFrascos 
                                                FROM rec_med_home WHERE id_cita = $id_cita_trat AND tipo_fras = '$tipo_fras' AND cancelado = 0";
                            $res_det_fras = $mysqli->query($sql_det_fras);
                            $val_fras = $res_det_fras->num_rows;

                            ?>
                    <form action="save_copy_trathome.php" method="POST">
                    <tr style="padding: 0;">
                        <td><?php echo $trat['tipo_fras']; ?></td>
                        <td><?php echo $trat['fecha_format']; ?></td>
                        <td><?php echo $trat['iniciales']; ?></td>
                        <td><?php echo $trat['Estatus_Pago']; ?></td>
                        <td style="font-size: 11px;"><?php 
                            if($val_fras > 0){
                                while($frasco = mysqli_fetch_assoc($res_det_fras)){
                                    echo $frasco['frasco'],'.- ',$frasco['MedFrascos'],'<br>';
                                }
                            }
                            else{
                                echo  'No hay frascos registrados en este tratamiento';
                            }
                        ?></td>
                        <input type="hidden" name="id_cita_fras" value="<?php echo $id_cita_trat; ?>">
                        <input type="hidden" name="tipo_fras" value="<?php echo $tipo_fras; ?>">
                        <input type="hidden" name="cita_actual" value="<?php echo $cita; ?>">
                        <input type="hidden" name="usuario" value="<?php echo $usuario; ?>">
                        <input type="hidden" name="paciente" value="<?php echo $paciente; ?>">
                        <td><?php 
                        if($val_fras < 11){
                            echo '<input type="submit" class="btn" value="Copiar Tratamiento">';
                        }else{
                            echo 'No es posible copiar este tratamiento';
                        }
                        ?></td>
                    </tr>
                    </form>

                        <?php   }
                    }else{
                        echo '<tr>
                        <td colspan="6">El paciente no tiene tratamientos homeopáticos previos</td>
                    </tr>';
                    }
                    ?>
                    
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>