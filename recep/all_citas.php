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
include_once 'recep_sections.php';
include_once '../app/logic/conn.php';
$citas_dia = 0;
if(!empty($_POST)){
    $fecha = $_POST['fecha_cita'];
    //echo $fecha;

    $sql_citas = "SELECT cita.id_cita, cita.id_paciente, paciente.id_paciente, 
    CONCAT(paciente.nombres,' ',paciente.a_paterno,' ',paciente.a_materno) Nom_paciente,
    CONCAT(user.nombre,' ',user.apellido) medico_cita, cita.fecha, cita.horario, cita.tipo, tipos_cita.descrip_cita, confirma, consulta
        FROM cita
        INNER JOIN paciente ON cita.id_paciente = paciente.id_paciente
        INNER JOIN tipos_cita on cita.tipo = tipos_cita.id_tipo_cita
        LEFT JOIN user on cita.medico = user.id
        WHERE cita.fecha = '$fecha' ORDER BY cita.fecha, cita.horario";

        $citas_fecha = $mysqli->query($sql_citas);
        $citas_dia = $citas_fecha->num_rows;

        //echo $citas_dia;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon">
    <title>Citas</title>
    <link rel="stylesheet" href="../css/materialize.css">
    <link rel="stylesheet" href="../icons/iconfont/material-icons.css">
    <script type="text/javascript" src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/materialize.js"></script>
</head>
<body>
<?php echo $nav_recep; ?>
<div class="container">
<div class="row center-align">
    <div class="col s9">
        <h4 style="color: #2d83a0; font-weight:bold;">Calendario de Citas</h4>
    </div>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <div class="col s3">
        <label for="inputs_cita">Seleccione la fecha</label>
        <input id="inputs_cita" type="date" name="fecha_cita" class="validate" required>
        <button style="margin-top: 1em;" class="btn waves-effect waves-light" type="submit" name="action" style="margin-top: 20%;">Ver citas
            <i class="material-icons right">assignment_turned_in</i>
        </button>
        </div>
        
        </form>
        
    </div>

    <div class="row">
    <div class="col s12">
    <div style="height: 400px;">
    <?php 
        if($citas_dia > 0){
    ?>
    <table>
        <thead>
        <tr>
            <th>Paciente</th>
            <th>Médico</th>
            <th>Horario</th>
            <th>Consulta</th>
            <th>Estatus</th>
            <th>Detalle</th>
        </tr>
        </thead>
        <tbody>
            <?php
            $status = '';
            while($citas = mysqli_fetch_assoc($citas_fecha) ){
                if($citas['confirma'] == 2){
                    $status = 'Confirmada';
                }elseif($citas['confirma'] == 3){
                    $status = 'Cancelada';
                }
                echo '
                <tr>
                <td style="text-transform: capitalize;">'.$citas['Nom_paciente'].'</td>
                <td>'.$citas['medico_cita'].'</td>
                <td>'.$citas['horario'].'</td>
                <td>'.$citas['descrip_cita'].'</td>
                <td>'.$status.'</td>
                <td>Ver detalle</td>
                </tr>  
                ';
            }
            ?>
        </tbody>
    </table>
    <?php 
        }
    ?>
    </div>

    </div>
    </div>

</div>  <!-- CIERRE DE CONTAINER PRINCIPAL -->

<!-- Modal Nueva Cita -->
<div id="modal1" class="modal modal-fixed-footer" style="height: 100%;">
      <div class="modal-content">
        <h4>Nueva Cita</h4>
        <iframe frameborder="0" allowFullScreen="true" src="cita.php" style="width: 100%; height: 100%;"></iframe>

      </div>
      <div class="modal-footer">
        <a href="#" class="modal-close waves-effect waves-green btn-flat">Cerrar</a>
      </div>
    </div>
<?php echo $footer_recep;  ?>

<script>
    $(document).ready(function(){
    $('.modal').modal();
  });
</script>
</body>
</html>