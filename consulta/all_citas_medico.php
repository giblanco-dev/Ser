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
include_once 'consulta_sections.php';
include_once '../app/logic/conn.php';
$citas_dia = 0;
$fecha = '';
$hoy = date("Y-m-d");
if(!empty($_POST)){
    $fecha = $_POST['fecha_cita'];
    //echo $fecha;

    $sql_citas = "SELECT cita.id_cita, cita.id_paciente, paciente.id_paciente, 
    CONCAT(paciente.nombres,' ',paciente.a_paterno,' ',paciente.a_materno) Nom_paciente,
    CONCAT(user.nombre,' ',user.apellido) medico_cita, cita.fecha, cita.horario, cita.tipo, tipos_cita.descrip_cita, confirma, consulta, caja, pagado
        FROM cita
        INNER JOIN paciente ON cita.id_paciente = paciente.id_paciente
        INNER JOIN tipos_cita on cita.tipo = tipos_cita.id_tipo_cita
        LEFT JOIN user on cita.medico = user.id
        WHERE cita.fecha = '$fecha' 
        AND medico = '$id_user'
        and pagado = 1
        ORDER BY cita.fecha, cita.horario";

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
    <link rel="shortcut icon" href="../static/img/favicon.png" type="image/x-icon">
    <title>Citas</title>
    <link rel="stylesheet" href="../static/css/materialize.css">
    <link rel="stylesheet" href="../static/icons/iconfont/material-icons.css">
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
            height: 400px;
            overflow-y:scroll;
        }
    </style>
</head>
<body>
<?php echo $nav_consulta; ?>
<div class="container" style="margin-bottom: 5%;">
<div class="row center-align">
    <div class="col s9">
        <h4 style="color: #2d83a0; font-weight:bold;">Consultas por Fecha</h4>
        <?php 
        if($fecha != ''){
            echo '<hp style="color: #2d83a0; font-weight:bold;">Citas del '.date("d-m-Y", strtotime($fecha)).'</hp>';
        }
        ?>
        <p></p>
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
    <div class="table-responsive-2">
    <?php 
        if($citas_dia > 0){
    ?>
    <table>
        <thead>
        <tr>
            <th>Paciente</th>
            <th>Médico</th>
            <th>Horario</th>
            <th>Tipo de Cita</th>
            <th>Confirmada</th>
            <th>Consulta</th>
            <th>Caja</th>
            <th>Pagado</th>
            <th>Detalle</th>
        </tr>
        </thead>
        <tbody>
            <?php
            $status = '';
            while($citas = mysqli_fetch_assoc($citas_fecha) ){
                
                switch($citas['confirma']){
                    case 1:
                        $status = 'Programada';
                        break;
                    case 2:
                        $status = 'Confirmada';
                        break;
                    case 3:
                        $status = 'Cancelada';
                        break;
                    default:
                    $status = 'Desconocido';        
                }

                if($citas['consulta'] == 1){
                    $status_consulta = 'Sí';
                }else{
                   $status_consulta = 'No';
                }

                if($citas['caja'] == 1){
                    $status_caja = 'Enviado';
                }else{
                   $status_caja = 'Sin Enviar';
                }

                if($citas['pagado'] == 1){
                    $status_pago = 'Pagado';
                }else{
                   $status_pago = 'No';
                }

                echo '
                <tr>
                <td style="text-transform: capitalize;">'.$citas['Nom_paciente'].'</td>
                <td>'.$citas['medico_cita'].'</td>
                <td>'.$citas['horario'].'</td>
                <td>'.$citas['descrip_cita'].'</td>
                <td>'.$status.'</td>
                <td>'.$status_consulta.'</td>
                <td>'.$status_caja.'</td>
                <td>'.$status_pago.'</td>
                <td><a href="detalle_consulta.php?c='.$citas['id_cita'].'&p='.$citas['id_paciente'].'" target="blank">Ver detalle</a></td>
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
<?php echo $footer_consulta;  ?>

<script>
    $(document).ready(function(){
    $('.modal').modal();
  });
</script>
</body>
</html>